<?php

// requires the database connection file
require_once 'db config.php';

class HomeController{
    
    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        
        header('Location: '.'/Social_platform_PHP/registration/index');

    }


	public function index(){
            session_start();
        
         if(isset($_SESSION['logged_in']))
         {
		  header('Location: '.'/Social_platform_PHP/app/Views/home/Home.html.php');
		  exit;
         } else{
             echo "Log in first";
         }
	}
    
    public function createPost(){
         $joined = date('Y-m-d');
        $post_body = $_POST['textArea'];
        $uid = $_POST['uid'];
        $title = $_POST['title'];

        // create a new Database connection
        $handle = new db();
        $conn = $handle->connect();
        
        // create a new post
        
        $sql = "INSERT INTO `posts` ( `post_text`, `post_picture`, `date_posted`, `date_updated`, `user_id`, `upvote_count`, `downvote_count`, `post_title`) VALUES ( '$post_body', '', '$joined', '$joined', '$uid', '0', '0', '$title');
";
        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            header('Location: '.'/Social_platform_PHP/app/Views/home/Home.html.php?notice=successfully created post');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
    // Close the connection
    $conn->close();

    }

    public function UpdatePost(){
        if (isset($_GET['PostID']) && isset($_GET['vote'])) {
            $postid = $_GET['PostID'];
            $VoteType = $_GET['vote'];
            $uid = $_GET['Userid'];
            $reacted = date('Y-m-d');

            // create a new Database connection
             $handle = new db();
             $conn = $handle->connect();
           
             if($VoteType == "UP"){
                     //Increment Upvotes
                 $sql1 = "UPDATE `posts` SET `upvote_count`=`upvote_count` + 1 WHERE `post_id`= ".$postid.";";
                // Execute the SQL query
                if ($conn->query($sql1) === TRUE) {
                   //echo "Upvote Updated";
               } else {
                  // echo "error";
               }

               $sql2 = "SELECT * FROM `reactions` WHERE `user_id` = ".$uid." AND `post_id` = ".$postid.";";
               // Execute the query
                $result = $conn->query($sql2);

                // Check if the result is empty
                 if ($result->num_rows > 0) {
                     // The result is not empty we update 
                     $UpdateSql = "UPDATE `reactions` SET `reaction_type`= 1 WHERE `user_id`=".$uid." AND `post_id` = ".$postid.";";

                     if ($conn->query($UpdateSql) === TRUE) {
                        echo "Upvote Updated";
                    } 
                 } else {

                    $InsertSql = "INSERT INTO `reactions`( `reaction_type`, `date_reacted`, `user_id`, `post_id`) VALUES (1,'".$reacted."',".$uid.",".$postid.");";
                    if ($conn->query($InsertSql) === TRUE) {
                        echo "Upvote Inserted";
                    } 
                
                 }
             }

             if($VoteType == "DOWN"){
                    //Increment Upvotes
                    $sql2 = "UPDATE `posts` SET `downvote_count`=`downvote_count` + 1 WHERE `post_id`=".$postid.";";
                    // Execute the SQL query
                    if ($conn->query($sql2) === TRUE) {
                        $sql2 = "SELECT * FROM `reactions` WHERE `user_id` = ".$uid." AND `post_id` = ".$postid.";";
                        // Execute the query
                         $result = $conn->query($sql2);

                        // Check if the result is empty
                         if ($result->num_rows > 0) {
                         // The result is not empty we update 
                        $UpdateSql = "UPDATE `reactions` SET `reaction_type`= 0 WHERE `user_id`=".$uid." AND `post_id` = ".$postid.";";
                                
                             if ($conn->query($UpdateSql) === TRUE) {
                                echo "Downvote Updated";
                             } 
               
                          } else {

                             $InsertSql = "INSERT INTO `reactions`( `reaction_type`, `date_reacted`, `user_id`, `post_id`) VALUES (0,'".$reacted."',".$uid.",".$postid.");";
                             if ($conn->query($InsertSql) === TRUE) {
                                echo "Downvote Inserted";
                            } 
                             }
                   } else {
                      
                   }

                   
             }
            
           
          }  
          
          
    }

    public function DownUpdatePost(){
        if (isset($_GET['PostID']) && isset($_GET['remove'])) {
            $postid = $_GET['PostID'];
            $VoteType = $_GET['remove'];
            $uid = $_GET['Userid'];
           
            $reacted = date('Y-m-d');

             // create a new Database connection
             $handle = new db();
             $conn = $handle->connect();
           
             if($VoteType == "UP"){
                 // we remove the upvote
                 $sql2 = "UPDATE `posts` SET `upvote_count`=`upvote_count` - 1 WHERE `post_id`=".$postid.";";
                 // Execute the SQL query
                 if ($conn->query($sql2) === TRUE) {
                           // The result is not empty we update 
                           $UpdateSql = "UPDATE `reactions` SET `reaction_type`= null WHERE `user_id`=".$uid." AND `post_id` = ".$postid.";";
                                 
                           if ($conn->query($UpdateSql) === TRUE) {
                              echo "Upvote removed";
                           } 
                 }
             }
             if($VoteType == "DOWN"){
                // we remove the downvote
                $sql2 = "UPDATE `posts` SET `downvote_count`=`downvote_count` - 1 WHERE `post_id`=".$postid.";";
                // Execute the SQL query
                if ($conn->query($sql2) === TRUE) {
                          // The result is not empty we update 
                          $UpdateSql = "UPDATE `reactions` SET `reaction_type`= null WHERE `user_id`=".$uid." AND `post_id` = ".$postid.";";
                                
                          if ($conn->query($UpdateSql) === TRUE) {
                             echo "Downvote removed";
                          } 
                }
             }

        }

    }


}