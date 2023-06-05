<?php

// requires the database connection file
require_once 'db config.php';
require_once 'app/url.php';


// Class to handle form submission
class RegistrationController
{


    public $location = "/start/app/Views/";

    public function LoginSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

            // Get form data
            $email = $_POST['email'];
            $password = $_POST['password'];


            $sql = "SELECT `user_id`, `username`, `password` FROM `users` WHERE `email` = '$email';";

            $result = $conn->query($sql); // execute the query

            // Check if there are any rows returned
            if (mysqli_num_rows($result) > 0) {

                $row = $result->fetch_assoc(); //get row in an array -_-!
                if (password_verify($password, $row['password'])) {
                    echo "Logged in successfully !";
                    session_start();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['uid'] = $row['user_id'];
                    $_SESSION['email'] = $email;

                    $BaseClass = new Url();
                    header('Location: ' . $BaseClass->base . '/home/index');
                } else {
                    header('Location: ' . $this->location . 'signup/signup.html.php?error=Password do not match 😔 <br> If you used google sign up then please login with google');

                }
                // close database connection
                $conn->close();
                exit;

            } else {
                header('Location: ' . $this->location . 'signup/signup.html.php?error=User does not exist 😭');
                $conn->close();
                exit;
            }

        } else {
            echo "Invalid Request! 😭";
        }
    }


    public function SignUpSubmit()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

            // Get form data
            $name = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Check if the user already exists
            $sql = " SELECT * FROM `users` WHERE `email` = '$email'";
            $result = $conn->query($sql); // execute the query

            // Check if there are any rows returned
            if (mysqli_num_rows($result) > 0) {

                //$row = $result->fetch_assoc();
                echo header('Location: ' . $this->location . 'signup/signup.html.php?error=User already exists');

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
                $sql = "SELECT `user_id` FROM `users` WHERE `username` = '$name'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $name;
                $_SESSION['uid'] = $row['user_id'];
                $_SESSION['email'] = $email;
            } else {
                header('Location: ' . $this->location . 'signup/signup.html.php?error=Try again later');
                return;
            }

            // close database connection
            $conn->close();

            // Redirect to another page
            header('Location: ' . $this->location . 'home/Home.html.php');
            exit;
        } else {
            echo "Not allowed";
            exit;
        }
    }

    public function index()
    {

        header('Location: ' . $this->location . 'signup/signup.html.php');
        exit;
    }


}


