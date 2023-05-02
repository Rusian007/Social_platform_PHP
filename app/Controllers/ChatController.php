<?php
require_once 'db config.php';

class ChatController
{
    public $location = "/Social_platform_PHP/app/Views/";

    function index()
    {

        header("Location: " . $this->location . "chat/chat.html.php");
        exit;
    }

    function GPTcontroller()
    {
        $userdata = $_POST['data'];
        if (!isset($userdata) && $userdata == "")
            exit;
        // start db connection
        $handle = new db();
        $conn = $handle->connect();
        $sql = "SELECT `client_id`,`secret` FROM `oauth` WHERE `client_id`='gpt'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        # $clientID = $row["client_id"];
        $secret = $row["secret"];
        $conn->close();

        $url = 'https://chatgpt-api.shn.hk/v1/'; // Set the URL
        $auth_code = $secret; // Set the authorization code

        $data = array(
            'model' => 'gpt-3.5-turbo',
            'messages' => array(
                array(
                    'role' => 'user',
                    'content' => $userdata
                )
            )
        );  // Set the data to be sent in the request body

        // Create a stream context with the required options
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n" .
                    "Authorization: $auth_code\r\n",
                'content' => json_encode($data)
            )
        ));

        // Send the request and get the response
        $response = file_get_contents($url, false, $context);
        $response = json_decode($response, true);

        // Handle the response as needed
        $SendBack = array(
            "message" => $response['choices'][0]['message']['content']
        );
        echo json_encode($SendBack);
    }

    function YOUcontroller()
    {
        $userdata =  $_POST['data'];
        if (!isset($userdata) && $userdata == "")
            exit;
       
        // start db connection
        $handle = new db();
        $conn = $handle->connect();
        $sql = "SELECT `client_id`,`secret` FROM `oauth` WHERE `client_id`='YouAI'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        # $clientID = $row["client_id"];
        $secret = $row["secret"];
        $conn->close();

        $auth_code = $secret; // Set the authorization code
        $url = 'https://api.betterapi.net/youdotcom/chat?message=' . $userdata . '&key=' . $auth_code; // Set the URL

        // Create a stream context with the required options
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "Authorization: $auth_code\r\n"
            )
        ));

        // Send the request and get the response
        $response = file_get_contents($url, false, $context);
        $response = json_decode($response, true);

        echo json_encode($response);
        exit;
    }
}
