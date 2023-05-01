<?php

  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Chat</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="chat.css" />
  </head>
  <body>

  <?php
       if (!isset($_SESSION['logged_in'])) {
        header('Location: ' . '/Social_platform_PHP/registration/index');
        exit;
      } 
  ?>
    '<div class="background">
      <div class="pie astronaut"> </div>
        
    </div>
  

  
</div>
    <div class="chat-container">
      
      <div class="chat-header">
      
      </div>
      <div class="chat-body">
        <div id="container" class="message-container">

          <div class="message">
            <div class="sender">Hello, how can I help you today?</div>
          </div>

          <div class="message">
            <div class="receiver">Tell me about cactus flowers.</div>
          </div>
          
          
        </div>
      </div>
      
        <div class="chat-footer">
          <input id="myInput" type="text" placeholder="Type your message here" />
          <button onclick="SendMsg(event)" type="submit">Send</button>
        </div>
      </div>
    </div>

  <script type="text/javascript">
    let container = document.getElementById("container");

    

    function SendMsg(event){
      const input = document.querySelector('#myInput');
      let inputValue = input.value;

      let receiverNode = document.createElement('div');


      receiverNode.className = 'receiver';
      receiverNode.textContent = inputValue;
      input.value ="";

      // send ajax req with inputValue

      let messageNode = document.createElement('div');
      messageNode.className = 'message';
      messageNode.appendChild(receiverNode);
      container.appendChild(messageNode);
   
    }
  </script>

  </body>
</html>
