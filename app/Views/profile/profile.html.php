
<?php 
      
      session_start();
     ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="profile.css"> <!--linking the stylesheet to the css file-->
  <title>OWN Page</title> <!--creating a title for the page-->

  <style>
    .image-container {
        position: relative;
    }
    .edit-button {
        position: absolute;
        padding: 20px;
        border-radius: 15px;
        border: none;
        outline: none;
        background: #FFCA1B;
        font-weight: bold;
        color: white;
        border: 2px dashed white;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>

  <?php 
      require_once '../../../db config.php';
     $sql = "SELECT * FROM `posts` WHERE `user_id` = ".$_SESSION['uid'];

     

          // create a new Database connection
          $handle = new db();
          $conn = $handle->connect();

          $result = $conn->query($sql);
     ?>

</head>

<body>
  <div class="nav-container">

    <nav>

        <div class="logo">
          <h3>
            NSC
          </h3>
        </div>

        <div class="links">
          
            <button onclick="OnHomeClick()" class="btn">
              <i class="fi-xnsuxl-house-solid"></i>
            </button>

            <button class="btn btn-red">
              <i class="fi-xnsuxl-sign-out-solid"></i>
            </button>

        </div>
  
    </nav>


  </div>

  <div class="container">

    <div class="user-info">
    <div class="image-container">
    <img src="https://i.pinimg.com/originals/28/0d/b1/280db177e9d448726401dd1d6532a970.png" class="avatar">
    <button class="edit-button" style="display: none;">Upload</button>
    </div>

           <div id="edit-off" class="user-name">
            <?php
            echo '
             <h1>'.$_SESSION['username'].'</h1>
             <h3>'.$_SESSION['email'].'</h3>
             ';
             ?>
           </div>

           <div id="edit-on" class="user-name">
           <?php
            echo '
             <h1>'.$_SESSION['username'].'</h1>
           
             ';
             ?>
        
            <input id="email-input" type="text" name="email" placeholder="Email">
         
           </div>

    </div>

    <div class="buttons-profile">
       <button onclick="ProfileUpdate()" class="btn">
              Update
        </button>

        <button class="btn btn-red">
              Delete
        </button>
    </div>
  </div>


  <div class="post-container">
    
    <!-- Post start -->
    <?php

        while ($row = $result->fetch_assoc()) {
 
  
          echo 
        '<div class="post">
          <div class="image-section">
            
            <div class="img-user">
              <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar post-avatar">
              <h3>'.$_SESSION['username'].'</h3>
            </div>
              
              <i class="fi-xwsrxx-ellipsis"></i>
              
          </div>
        

          <hr class="post-hr">

          <div class="post-content">
            <h3>'.$row['post_title'].'</h3>
            <p>'.$row['post_text'].'</p>
          </div>
          
          <div class="post-btn">
            <button class="vote-btn-up gray" style="margin-right: 4px;">
              <i style="color: #FFCA1B" class="fi-xwsuxx-arrow-solid"></i> 
               '.$row['upvote_count'].'
            </button>

            <button class="vote-btn-down gray" >
              <i style="color: #FF4141" class="fi-xwsdxx-arrow-solid"></i>
               '.$row['downvote_count'].'
            </button>
          </div>
          
        </div>';
        }
        ?>
        <!-- Post end -->




  </div>
  

  <script defer src="https://friconix.com/cdn/friconix.js"> </script>

  <script type="text/javascript">

  function OnHomeClick(){
    window.location.href='/Social_platform_PHP/home/index'
  }

  var editOn = document.getElementById("edit-on");
  editOn.style.display = "none";

  function ProfileUpdate(){
        var editOff = document.getElementById("edit-off");
        var editOn = document.getElementById("edit-on");
        var imageContainer = document.querySelector(".image-container");
         var editButton = document.querySelector(".edit-button");

        if (editOff.style.display === "none") {
            editOff.style.display = "block";
            editOn.style.display = "none";
        } else {
            editOff.style.display = "none";
            editOn.style.display = "block";
        }

        if (editButton.style.display === "none") {
            editButton.style.display = "block";
        } else {
            editButton.style.display = "none";
        }
  }

  
</script>



</body>

</html>
