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

        // create a new Database connection
        $handle = new db();
        $conn = $handle->connect();
        
        // create a new post
        
        $sql = "INSERT INTO `posts` ( `post_text`, `post_picture`, `date_posted`, `date_updated`, `user_id`, `upvote_count`, `downvote_count`) VALUES ( '$post_body', '', '$joined', '$joined', '$uid', '0', '0');
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


}