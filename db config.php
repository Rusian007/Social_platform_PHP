<?php

Class db{
    public $baseUrl = 'http://localhost';
    public $uploadDir = '/Social_platform_PHP/app/upload/profile_pics';
    public $PostUploadDir = '/Social_platform_PHP/app/upload/post_pics';


    public function connect(){
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "nsc";

        $conn = mysqli_connect($servername,$dbUsername,$dbPassword,$dbName);

        if(!$conn){
            die("Connection failed: ".mysqli_connect_error());
            exit;
        }
        return $conn;
    }
}

