<?php
 require_once '../../url.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>search | post</title>
    <link rel="stylesheet" href="./searchpost.css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <?php
      // TODO: use the post id to get the post
      //view the post using the template from home.html.php
      $BaseClass = new Url();
        if (!isset($_SESSION['logged_in'])) {
            header('Location: ' . $BaseClass->base . '/registration/index');
             exit;
        }

        require_once '../../../db config.php';
      

 
        $sql = "SELECT * FROM `posts` WHERE `post_id` = " . $_SESSION['post_id'];


        // create a new Database connection
        $handle = new db();
        $conn = $handle->connect();

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $usersql = "SELECT * FROM `users` WHERE `user_id` = " . $row['user_id'];
        $res = $conn->query($usersql);
        $postUser = $res->fetch_assoc();
      ?>



<div class="post-container">

    <!-- Post start -->
    <?php

        


        echo  '<div class="post">
          <div class="image-section">
            
            <div class="img-user">
            ';

        // show picture of user if user has a picture
        if (!is_null($postUser['profile_picture'])) {
            echo '
            <img src=' . $postUser['profile_picture'] . ' alt="Avatar" class="avatar post-avatar"> ';
        } else {
            echo '<img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar post-avatar">';
        }




        echo '
              <h3>' . $postUser['username'] . '</h3>
            </div>
              
              <i class="fi-xwsrxx-ellipsis"></i>
              
          </div>
        

          <hr class="post-hr">

          <div class="post-content">
            <h3>' . $row['post_title'] . '</h3>
            <p>' . $row['post_text'] . '</p>
          </div>
          
          <div class="post-btn">
            <button class="vote-btn-up gray" style="margin-right: 4px;">
              <i style="color: #FFCA1B" class="fi-xwsuxx-arrow-solid"></i> 
               ' . $row['upvote_count'] . '
            </button>

            <button class="vote-btn-down gray" >
              <i style="color: #FF4141" class="fi-xwsdxx-arrow-solid"></i>
               ' . $row['downvote_count'] . '
            </button>
          </div>
          
        </div>';
    
    ?>
    <!-- Post end -->


</div>
  </body>
</html>