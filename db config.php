<?php

Class db{

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
