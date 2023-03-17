<?php

// requires the database connection file
require_once 'db config.php';

class HomeController{


	public function index(){
		echo "controller hit";
		header('Location: '.'/Social_platform_PHP/app/Views/home/Home.html.php');
		exit;
	}


}