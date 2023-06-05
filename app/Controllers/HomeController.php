<?php

// requires the database connection file
require_once 'db config.php';
require_once 'oauth/vendor/autoload.php';
require_once 'app/url.php';

class HomeController
{
    public $location = "/start/app/Views/";

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        $BaseClass = new Url();
        header('Location: ' . $BaseClass->base . '/registration/index');
    }


    public function index()
    {
        session_start();

        if (isset($_SESSION['logged_in'])) {
            $BaseClass = new Url();
            header('Location: ' . $BaseClass->base .  '/app/Views/home/Home.html.php');
            exit;
        } else {
            echo "Log in first";
        }
    }

    public function createPost()
    {
         session_start();
        $joined = date('Y-m-d');
        $post_body = $_POST['textArea'];
        $uid =  $_SESSION['uid'];
        $title = $_POST['title'];
        
        // create a new Database connection
        $handle = new db();
        $conn = $handle->connect();

       



        // Check if the file was uploaded and no error found
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            
                // Get the temporary file path and the original file name
                $tmpFilePath = $_FILES['picture']['tmp_name'];
                $fileName = basename($_FILES['picture']['name']);

                // current directory path
                $parentDirectoryPath = dirname(__FILE__);



                // Set the destination file path
                $uploadDir = $parentDirectoryPath. "/../upload/post_pics";
                $destinationFilePath = $uploadDir . '/' . $fileName;

                // Move the uploaded file to the destination
                if (move_uploaded_file($tmpFilePath, $destinationFilePath)) {
                    // The file was successfully moved to the destination - Save the link to the picture in the database


                        
                    // set a server file path (http:// )
                    $serverFilePath =  $handle->baseUrl . $handle->PostUploadDir . '/' . $fileName;

                    $stmt = $conn->prepare("INSERT INTO posts (post_text, post_picture, date_posted, date_updated, user_id, upvote_count, downvote_count, post_title) VALUES (?, ?, ?, ?, ?, 0, 0, ?)");
                    $stmt->bind_param("ssssis", $post_body, $serverFilePath, $joined, $joined, $uid, $title);

                    //$stmt = $conn->prepare('UPDATE `users` SET `profile_picture`= (?) WHERE `user_id` = ?');
                   // $stmt->bind_param('si', $serverFilePath, $uid);
                   // $stmt->execute();
                    if ($stmt->execute()) {
                        $BaseClass = new Url();
                        header('Location: ' . $BaseClass->base . '/app/Views/home/Home.html.php?notice=successfully created post');
                    } else {
                        echo "Error:  <br>" . $conn->error;
                    }

                }

            } else{
                 // create a new post

                $stmt = $conn->prepare("INSERT INTO posts (post_text, date_posted, date_updated, user_id, upvote_count, downvote_count, post_title) VALUES (?, ?, ?, ?, 0, 0, ?)");
                $stmt->bind_param("sssis", $post_body, $joined, $joined, $uid, $title);

                if ($stmt->execute()) {
                    $BaseClass = new Url();
                        header('Location: '  . $BaseClass->base . '/app/Views/home/Home.html.php?notice=successfully created post');
                    } else {
                        echo "Error:  <br>" . $conn->error;
                    }
            }

        



        // Close the connection
        $conn->close();
        exit;
    }

    public function UpdatePost()
    {
        if (isset($_GET['PostID']) && isset($_GET['vote'])) {
            $postid = $_GET['PostID'];
            $VoteType = $_GET['vote'];
            $uid = $_GET['Userid'];
            $reacted = date('Y-m-d');

            // create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

            if ($VoteType == "UP") {
                //Increment Upvotes
                $sql1 = "UPDATE `posts` SET `upvote_count`=`upvote_count` + 1 WHERE `post_id`= " . $postid . ";";
                // Execute the SQL query
                if ($conn->query($sql1) === TRUE) {
                    //echo "Upvote Updated";
                } else {
                    // echo "error";
                }

                $sql2 = "SELECT * FROM `reactions` WHERE `user_id` = " . $uid . " AND `post_id` = " . $postid . ";";
                // Execute the query
                $result = $conn->query($sql2);

                // Check if the result is empty
                if ($result->num_rows > 0) {
                    // The result is not empty we update 
                    $UpdateSql = "UPDATE `reactions` SET `reaction_type`= 1 WHERE `user_id`=" . $uid . " AND `post_id` = " . $postid . ";";

                    if ($conn->query($UpdateSql) === TRUE) {
                        echo "Upvote Updated";
                    }
                } else {

                    $InsertSql = "INSERT INTO `reactions`( `reaction_type`, `date_reacted`, `user_id`, `post_id`) VALUES (1,'" . $reacted . "'," . $uid . "," . $postid . ");";
                    if ($conn->query($InsertSql) === TRUE) {
                        echo "Upvote Inserted";
                    }
                }
            }

            if ($VoteType == "DOWN") {
                //Increment Upvotes
                $sql2 = "UPDATE `posts` SET `downvote_count`=`downvote_count` + 1 WHERE `post_id`=" . $postid . ";";
                // Execute the SQL query
                if ($conn->query($sql2) === TRUE) {
                    $sql2 = "SELECT * FROM `reactions` WHERE `user_id` = " . $uid . " AND `post_id` = " . $postid . ";";
                    // Execute the query
                    $result = $conn->query($sql2);

                    // Check if the result is empty
                    if ($result->num_rows > 0) {
                        // The result is not empty we update 
                        $UpdateSql = "UPDATE `reactions` SET `reaction_type`= 0 WHERE `user_id`=" . $uid . " AND `post_id` = " . $postid . ";";

                        if ($conn->query($UpdateSql) === TRUE) {
                            echo "Downvote Updated";
                        }
                    } else {

                        $InsertSql = "INSERT INTO `reactions`( `reaction_type`, `date_reacted`, `user_id`, `post_id`) VALUES (0,'" . $reacted . "'," . $uid . "," . $postid . ");";
                        if ($conn->query($InsertSql) === TRUE) {
                            echo "Downvote Inserted";
                        }
                    }
                } else {
                }
            }
        }
    }

    public function DownUpdatePost()
    {
        if (isset($_GET['PostID']) && isset($_GET['remove'])) {
            $postid = $_GET['PostID'];
            $VoteType = $_GET['remove'];
            $uid = $_GET['Userid'];

            $reacted = date('Y-m-d');

            // create a new Database connection
            $handle = new db();
            $conn = $handle->connect();

            if ($VoteType == "UP") {
                // we remove the upvote
                $sql2 = "UPDATE `posts` SET `upvote_count`=`upvote_count` - 1 WHERE `post_id`=" . $postid . ";";
                // Execute the SQL query
                if ($conn->query($sql2) === TRUE) {
                    // The result is not empty we update 
                    $UpdateSql = "UPDATE `reactions` SET `reaction_type`= null WHERE `user_id`=" . $uid . " AND `post_id` = " . $postid . ";";

                    if ($conn->query($UpdateSql) === TRUE) {
                        echo "Upvote removed";
                    }
                }
            }
            if ($VoteType == "DOWN") {
                // we remove the downvote
                $sql2 = "UPDATE `posts` SET `downvote_count`=`downvote_count` - 1 WHERE `post_id`=" . $postid . ";";
                // Execute the SQL query
                if ($conn->query($sql2) === TRUE) {
                    // The result is not empty we update 
                    $UpdateSql = "UPDATE `reactions` SET `reaction_type`= null WHERE `user_id`=" . $uid . " AND `post_id` = " . $postid . ";";

                    if ($conn->query($UpdateSql) === TRUE) {
                        echo "Downvote removed";
                    }
                }
            }
        }
    }
    public function oAuth()
    {
        // start db connection
        $handle = new db();
        $conn = $handle->connect();

        $sql = "SELECT `client_id`,`secret` FROM `oauth` WHERE `id`=1";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $clientID = $row["client_id"];
        $secret = $row["secret"];
        $BaseClass = new Url();
        $gclient = new Google_Client();
        $gclient->setClientId($clientID);
        $gclient->setClientSecret($secret);
        $gclient->setRedirectUri($handle ->baseUrl .''. $BaseClass->base .'/home/oAuth/');
        $gclient->addScope('email');
        $gclient->addScope('profile');

        $authUrl = $gclient->createAuthUrl();

        if (isset($_GET['code'])) {
            // Get Token
            $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

            // Check if fetching token did not return any errors
            if (!isset($token['error'])) {
                // Setting Access token
                $gclient->setAccessToken($token['access_token']);


                // Get Account Profile using Google Service
                $gservice = new Google_Service_Oauth2($gclient);

                // Get User Data
                $udata = $gservice->userinfo->get();

                $email = $udata['email'];
                $username =  $udata['name'];
                $picture = $udata->picture;

                // Query to find out if user already exists
                $sql = " SELECT * FROM `users` WHERE `email` = '$email'";
                $result = $conn->query($sql); // execute the query

                // Check if there are any rows returned
                if (mysqli_num_rows($result) > 0) {
                    // User already exists then just log him in
                    $row = $result->fetch_assoc();
                    session_start();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['uid'] = $row['user_id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['picture'] = $picture;

                    header('Location: '. $BaseClass->base .'/app/Views/home/Home.html.php');

                    // close database connection
                    $conn->close();
                    exit;
                } else {
                    // User does not exists - create new user - log him in
                    $joined = date('Y-m-d');
                    $sql = "INSERT INTO `users` ( `username`, `email`, `profile_picture`, `date_joined`, `last_login`) VALUES ( '$username', '$email', '$picture', '$joined', '$joined');";
                    // execute and check the query result
                    if (mysqli_query($conn, $sql)) {
                        $sql = "SELECT `user_id` FROM `users` WHERE `username` = '$username'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();

                        session_start();
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['uid'] = $row['user_id'];
                        $_SESSION['email'] = $email;
                        $_SESSION['picture'] = $picture;
                        $conn->close();
                        header('Location: '. $BaseClass->base .'/app/Views/home/Home.html.php');
                        exit;
                    } else {
                        header('Location: ' . $this->location . 'signup/signup.html.php?error=Try again later');
                        return;
                    }
                }

                exit;
            }
        }
    }
}
