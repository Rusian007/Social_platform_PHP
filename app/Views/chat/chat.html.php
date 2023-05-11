<?php
 require_once '../../url.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Chat</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link id="pagestyle" rel="stylesheet" type="text/css" href="oldchat.css" />
  <style>
    .btn:focus {
      outline: 0;
    }

    .btn {
      margin-top: 5px;
      margin: 2px;
      padding: 0;
      border: none;
      font: inherit;
      color: inherit;
      background-color: transparent;
      cursor: pointer;
      height: 50px;
      width: 50px;
      box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
        0 3px 1px -2px rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
    }

    .button-css1 {
      color: white;
      background-color: #edba0f;
      border-radius: 25px;
    }

    .button-css2 {
      color: white;
      background-color: #116278;
      border-radius: 25px;
    }

    .button-back {
      color: white;
      margin-left: 15px;
      background-color: #ff4141;
      border-radius: 25px;
    }
  </style>
</head>

<body>

  <?php

  if (!isset($_SESSION['logged_in'])) {
    $BaseClass = new Url();
    header('Location: ' . $BaseClass->base .'/registration/index');
    exit;
  }
  ?>
  '<div class="background">
    <div class="pie astronaut"> </div>

  </div>

  <button class="btn button-back" onclick="goBack()"><i class="fi-xnslxl-chevron-solid"></i></button>
  <button class="btn button-css1" onclick="swapStyleSheet('oldchat.css')"><i class="fi-xnsuxl-comment-square-dot-solid"></i></button>
  <button class="btn button-css2" onclick="swapStyleSheet('newchat.css')"><i class="fi-xnsuxl-party-hat-solid"></i></button>



  </div>
  <div class="chat-container">

    <div class="chat-header">

    </div>
    <div class="chat-body">
      <div id="container" class="message-container">

        <div class="message">
          <div class="sender">Hello, how can I help you today?</div>
        </div>




      </div>
    </div>

    <form onsubmit="SendMsg(event)" class="chat-footer">
      <input id="myInput" type="text" placeholder="Type your message here" />
      <button id="submit-btn" type="submit">Send</button>
    </form>
  </div>
  </div>

  <script defer src="https://friconix.com/cdn/friconix.js"> </script>

  <script type="text/javascript">
    let container = document.getElementById("container");
    let RequestRouter = "YOU";
    var xhr = new XMLHttpRequest();
    var url = "";

    function SendMsg(event) {
      event.preventDefault();
      const input = document.querySelector('#myInput');
      var button = document.getElementById("submit-btn");

      let inputValue = input.value;
      let receiverNode = document.createElement('div');

      input.disabled = true;
      button.disabled = true;

      receiverNode.className = 'receiver';
      receiverNode.textContent = inputValue;
      input.value = "";

      // send ajax req with inputValue
      if (RequestRouter === "GPT") {
        //changeUrl
        url = "http://localhost/Social_platform_PHP/chat/GPTcontroller/";

      } else if (RequestRouter === "YOU") {
        url = "http://localhost/Social_platform_PHP/chat/YOUcontroller/";
      } else {
        alert("Request Not send, Error !")
        return;
      }
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (this.readyState == 4) {

          var responseJSON = JSON.parse(this.responseText);


          input.disabled = false;
          button.disabled = false;

          if (responseJSON.message !== null) {
            let SenderNode = document.createElement('div');
            SenderNode.className = 'sender';
            SenderNode.textContent = responseJSON.message;

            let replyMessageNode = document.createElement('div');
            replyMessageNode.className = 'message';
            replyMessageNode.appendChild(SenderNode);

            container.appendChild(replyMessageNode);
          } else {
            alert("Server Overload !")
          }

        } else if( this.status >300){
          alert(this.statusText);
          input.disabled = false;
          button.disabled = false;

        }
      };

      var data = "data=" + inputValue;
      xhr.send(data);

      let messageNode = document.createElement('div');
      messageNode.className = 'message';
      messageNode.appendChild(receiverNode);
      container.appendChild(messageNode);

    }

    function swapStyleSheet(sheet) {
      document.getElementById('pagestyle').setAttribute('href', sheet);

      if (sheet === 'oldchat.css') {
        RequestRouter = "YOU"
      } else if (sheet === 'newchat.css') {
        RequestRouter = "GPT"
      }

    }
  </script>

  <script type="text/javascript">
    function goBack() {
      window.location.href = '/Social_platform_PHP/home/index';
    }
  </script>



</body>

</html>