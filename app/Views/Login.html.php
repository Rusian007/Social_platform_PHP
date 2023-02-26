<?php

?>
<!DOCTYPE html>
<html>
	<title> NSC :: Login </title>
	 <link rel="stylesheet" href="../../public/css/login.css"> <!--linking the stylesheet to the css file-->

	 <style>
      @import url('https://fonts.googleapis.com/css2?family=Outfit&display=swap');
    </style>
<body>

	
    <div class="container"> 

    <h1 class="title">NSC Community Media</h1>

    <div class="Login-Container">
        
<div class="empty"></div>
  <div class="Login">
    <h1 class="login_header">Login</h1>

    <hr></hr>

    <form action="/Social_platform_PHP/login/LoginSubmit" method="post" >
        <p>Username</p>

        <input type="username" name="username" placeholder="Enter your username" required>

        <p>Password</p>

        <input type="password" name="password" placeholder="Enter your password"  required>

        <input type="submit" name="submit" value="Login" id="loginSubmit">

        <a href="#" >Forgotten  password?</a>

    </form>

  </div>

<div class="empty"></div>
    </div>

    </div>




</body>
</html>