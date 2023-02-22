<?php

// requires the database connection file
require_once 'db config.php';

class LoginController{

	public function LoginSubmit(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			// create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

			// Get form data
            $name =$_POST['username'];
            $password = $_POST['password'];

           

            $sql= "SELECT `username`, `password` FROM `user` WHERE `username` = '$name';";

            $result = $conn->query($sql); // execute the query

            // Check if there are any rows returned
			if (mysqli_num_rows($result) > 0) {
    		
    		$row = $result->fetch_assoc(); //get row in an array -_-!
   			 if($row['password'] == $password)
   			 	echo "Logged in successfully !";
   			 else echo "Password do not match :(";
   			 // close database connection
			$conn->close();
   			 exit;

    		} else {
    			echo "User does not exist :(";
    			$conn->close();
   			 exit;
    		}

		} else {
			echo "Invalid Request!";
		}
	}

	


	public function index(){
		echo "controller hit";
		header('Location: '.'/Social_platform_PHP/app/Views/Login.html.php');
		exit;
	}


}