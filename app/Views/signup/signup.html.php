<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <script src="https://kit.fontawesome.com/630a961bfb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit.fontawesome.com/630a961bfb.css" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit&family=Roboto:wght@100;400;500;700;900&display=swap');
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;600&family=Poppins:wght@100;300;500;700;900&display=swap" rel="stylesheet">

    <title>NSC || Home</title>
</head>

<body>

    <?php
    if (isset($_SESSION['logged_in'])) {
        header('Location: ' . '/Social_platform_PHP/home/index');
        exit;
    }
    require_once '../../../db config.php';
    // start db connection
    $handle = new db();
    $conn = $handle->connect();


    if (isset($_GET['error'])) {
        $paramValue = $_GET['error'];
        echo '<div class="notification">
            <h3>' . $paramValue . '</h3>
            <div class="vertical-line"></div>
          </div>';
    }
    ?>


    <div class="header">
        <div class="logo">
            <span> <img style="width: 40px; padding: 10px;" src="http://localhost/Social_platform_PHP/public/images/logo.svg"> </span>
            <span>Welcome to NSC</span>
        </div>

        <div class="login-container">
            <p id="login-container-text">Already connected to us?</p>
            <a id="login-mode-btn">Click Here To Login</a>
            <a id="signup-mode-btn">Click Here To Signup</a>
        </div>
    </div>
    <div class="main">
        <div class="left-part">
            <section class="container">
                <h2>WHY JOIN US ??</h2>
                <p>Communicate with your peers and alumni to expand your network or get suggestions regarding your
                    concerns here in North South Community (NSC) platform.</p>
            </section>
        </div>

        <form class="right-part container" action="/Social_platform_PHP/registration/SignUpSubmit" method="post" id="signup-form">
            <div>
                <h2 class="signupHeader">Sign Up</h2>
            </div>

            <div class="input-container username">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Enter your username" autocomplete="off" required>
            </div>
            <div class="input-container email">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="off" required>
            </div>

            <!-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" -->
            <div class="input-container password">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Must be at least 8 characters" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
            <div class="input-container confirm-password">
                <label for="confirm-password">Confirm Password</label>
                <input id="confirm-password" name="confirm-password" type="password" placeholder="Confirm your password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
            <div class="buttons">
                <button class="signup-btn" type="submit">Sign Up</button>
                <button onclick="OAuthSignUp()" class="google-btn" href="#">
                    <i class="fa fa-google fa-fw"></i> Signup with Google
                    </a>
                </button>
            </div>
        </form>

        <?php
        require_once '../../Controllers/oauth/vendor/autoload.php';
        $sql = "SELECT `client_id`,`secret` FROM `oauth` WHERE `id`=1";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();


        $clientID = $row["client_id"];
        $secret = $row["secret"];

        $gclient = new Google_Client();
        $gclient->setClientId($clientID);
        $gclient->setClientSecret($secret);
        $gclient->setRedirectUri('http://localhost/Social_platform_PHP/home/oAuth/');
        $gclient->addScope('email');
        $gclient->addScope('profile');

        $authUrl = $gclient->createAuthUrl();
        $conn->close();

        ?>

        <a id="Oauth" style="display: none;" href="<?= $gclient->createAuthUrl() ?>"></a>


        <form action="/Social_platform_PHP/registration/LoginSubmit" method="post" class="right-part container" id="login-form">
            <div>
                <h2 class="signupHeader">Login</h2>
            </div>

            <div class="input-container email">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="off" required>
            </div>
            <div class="input-container password">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Must be at least 8 characters" required>
            </div>

            <div class="buttons">
                <button class="signup-btn logn-btn" type="submit">Login</button>
                <button onclick="OAuthSignUp()" class="google-btn" href="#">
                    <i class="fa fa-google fa-fw"></i> Login with Google
                    </a>
                </button>
            </div>

             <a href="#" class="forgot" id="forgot-btn">Forgot Password?</a> 
        </form>



    </div>
    </div>

    <div class="p-modal" id="p-modal">
        <div class="modal-content" id="modal-content" data-backdrop="static">
            <div class="modal-header">
                <h2>Forgot Your Password?</h1>
                    <a href="#" class="close-btn" id="close-btn">X</a>
            </div>

            <form action="#" class="resetPass input-container" id="resetPass">
                <h3>Please enter your email and we will send you instructions on how to reset your password.</h3>
                <label for="email"></label>
                <input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="off" required>
                <div class="buttons">
                    <button class="resetBtn" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="signup.js"></script>



    <script type="text/javascript">
        function OAuthSignUp() {
            document.getElementById("Oauth").click();
        }
        //TODO: remove this in production 
        function OnLoginClick() {
            window.location.href = '../home/Home.html'
        }
    </script>
</body>

</html>