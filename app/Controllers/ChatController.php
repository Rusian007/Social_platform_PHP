<?php

class ChatController{
    public $location = "/Social_platform_PHP/app/Views/";
    function index(){
        header("Location: ".$this->location."chat/chat.html.php");
    }

    function SendMsg(){
        
    }
}