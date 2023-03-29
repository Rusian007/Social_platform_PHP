<?php

// requires the database connection file
require_once 'db config.php';

class ProfileController
{
    public $location = "/Social_platform_PHP/app/Views/";

    public function index()
    {
        session_start();
        if (isset($_SESSION['uid']))
            header("Location:  " . $this->location . "profile/profile.html.php");
        else
            echo "Are you lost ?";
    }

    // TODO: Create a update Profile function and get the request and update profile picture and email
    // TODO: Also , don't forget to change the action in form in profile.html.php
    public function updateProfile(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // The request method is POST
            $uid = $_POST['uid'];
            // create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

            if(isset($_POST['email-update'])){
                $email = filter_var($_POST["email-update"], FILTER_SANITIZE_EMAIL);
                $stmt = $conn->prepare('UPDATE `users` SET `email`= (?) WHERE `user_id` = ?');
                $stmt->bind_param('si', $email, $uid);
                $stmt->execute();

            }

            // Check if the file was uploaded and no error found
            if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] === UPLOAD_ERR_OK) {
                // Get the temporary file path and the original file name
                $tmpFilePath = $_FILES['profile-pic']['tmp_name'];
                $fileName = basename($_FILES['profile-pic']['name']);

                // current directory path
                $parentDirectoryPath = dirname(__FILE__);



                // Set the destination file path
                $uploadDir = $parentDirectoryPath. "/../upload/profile_pics";
                $destinationFilePath = $uploadDir . '/' . $fileName;

                // Move the uploaded file to the destination
                if (move_uploaded_file($tmpFilePath, $destinationFilePath)) {
                    // The file was successfully moved to the destination - Save the link to the picture in the database



                    // set a server file path (http:// )
                    $serverFilePath =  $handle->baseUrl . $handle->uploadDir . '/' . $fileName;

                    $stmt = $conn->prepare('UPDATE `users` SET `profile_picture`= (?) WHERE `user_id` = ?');
                    $stmt->bind_param('si', $serverFilePath, $uid);
                    $stmt->execute();


                }

            }
            $conn->close();
            header('Location: '.'/Social_platform_PHP/app/Views/profile/profile.html.php?notice=Updates Issued.<br> Changes will be applied from next login.');

        } else {
            echo "Not allowed";
        }



    }

    public function delete(){
        $uid = $_GET["uid"];

        // create a new Database connection
        $handle = new db();
        $conn = $handle->connect();

        $sql = "DELETE FROM users WHERE `users`.`user_id` = ".$uid;



        if ($conn->query($sql) === TRUE) {
            session_start();
            session_unset();
            session_destroy();

            header('Location: '.'/Social_platform_PHP/registration/index');

        } else {
            echo "error: Try again Later";
        }

        $conn->close();
       //
    }
}