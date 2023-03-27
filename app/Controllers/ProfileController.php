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
}