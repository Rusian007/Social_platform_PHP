<?php

// requires the database connection file
require_once 'db config.php';




// Class to handle form submission
class RegistrationController {

    public $location = "/Social_platform_PHP/app/Views/";


    public function SignUpSubmit() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	// create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

            // Get form data
            $name =$_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Check if the user already exists
           	$sql = " SELECT * FROM `users` WHERE `username` = '$name'";
			$result = $conn->query($sql); // execute the query

			// Check if there are any rows returned
			if (mysqli_num_rows($result) > 0) {
    		
    		//$row = $result->fetch_assoc();
   			 echo "User already exists";
   			 // close database connection
			$conn->close();
   			 exit;
    		}
 

            

            // Sanitize the form data to prevent SQL injection
			$name = mysqli_real_escape_string($conn, $name);
			$email = mysqli_real_escape_string($conn, $email);
			$password = mysqli_real_escape_string($conn, $password);
            $hash = password_hash($password, PASSWORD_DEFAULT); // use bcrypt algorithm by default
            $password = $hash;
            $joined = date('Y-m-d');

			// generate an SQL to save in database
            $sql = "INSERT INTO `users`(`username`, `password`, `email`, `date_joined`) VALUES ('$name', '$password', '$email', $joined)";

            // execute and check the query result
            if (mysqli_query($conn, $sql)) {
   				 echo "New record created successfully";
			} else {
   				 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			// close database connection
			$conn->close();

            // Redirect to another page
            header('Location: '.$this->location.'home/Home.html.php');
            exit;
        }

        else{
        	echo "Not allowed";
        	exit;
        }
    }
    public function index() {

        header('Location: '.$this->location.'signup/signup.html.php');
        exit;
    }
}


// Instantiate the class and call the method to handle the form submit
//$formHandler = new SignUp_Controller();
//$formHandler->SignUpSubmit();



