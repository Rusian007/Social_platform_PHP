<?php
require_once "app/Controllers/RegistrationController.php";
require_once "app/Controllers/HomeController.php";
require_once "app/Controllers/ProfileController.php";
require_once "app/Controllers/SearchController.php";
require_once "app/Controllers/ChatController.php";

$request_uri = $_SERVER['REQUEST_URI'];


// splits a string into an array of substrings
$segments = explode('/', $request_uri);

// second segment is the controller name
// ucfirst  takes a string as an argument and returns the same string with the first character capitalized



$controller_name = ucfirst($segments[2]) . 'Controller';
//echo $controller_name;

// third segment is the action name
$action_name = isset($segments[3]) ? $segments[3] : null;

// forth segment (if present) is the parameter
$param = isset($segments[4]) ? $segments[4] : null;

switch ($action_name) {
	case(null):
	//set default route
		echo "OK";
		break;

  default:
		
  	// Instantiate the controller and call the action method
	$controller = new $controller_name();
	$controller->$action_name($param);
    break;
}


