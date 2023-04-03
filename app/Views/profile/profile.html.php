<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./profile.css"> <!--linking the stylesheet to the css file-->
    <title>NSC || Profile</title> <!--creating a title for the page-->

    <style>
        .image-container {
            position: relative;
        }

        .edit-button {
            position: absolute;
            padding: 20px;
            border-radius: 15px;
            border: none;
            outline: none;
            background: #FFCA1B;
            font-weight: bold;
            color: white;
            border: 2px dashed white;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

    <?php
    if (!isset($_SESSION['logged_in'])) {
        header('Location: ' . '/Social_platform_PHP/registration/index');
        exit;
    }
    require_once '../../../db config.php';
    $uid = $_SESSION['uid'];
    $sql = "SELECT * FROM `posts` WHERE `user_id` = " . $uid;


    // create a new Database connection
    $handle = new db();
    $conn = $handle->connect();

    $result = $conn->query($sql);


    $usersql = "SELECT * FROM `users` WHERE `user_id` = " . $uid;
    $res = $conn->query($usersql);
    $CurrentUser = $res->fetch_assoc();
    ?>

</head>

<body>

<?php

if (isset($_GET['notice'])) {
    $paramValue = $_GET['notice'];
    echo '<div class="notification">
              <h3>' . $paramValue . '</h3>
              <div class="vertical-line"></div>
            </div>';
}
?>


<div class="nav-container">


    <nav>

        <div class="logo">
            <h3>
                NSC
            </h3>
        </div>

        <div class="links">

            <button onclick="OnHomeClick()" class="btn">
                <i class="fi-xnsuxl-house-solid"></i>
            </button>

            <button onclick="logout()" class="btn btn-red">
                <i class="fi-xnsuxl-sign-out-solid"></i>
            </button>

        </div>

    </nav>


</div>

<div class="container">

    <div class="user-info">

        <div class="image-container">
            <?php
            if (!is_null($CurrentUser['profile_picture'])) {
                echo '<img
                    src=' . $CurrentUser['profile_picture'] . '
                    alt="Avatar"
                    class="avatar"
                    />';
            } else {
                echo '<img
                    src="https://www.w3schools.com/howto/img_avatar2.png"
                    alt="Avatar"
                    class="avatar"
                    />';
            }


            ?>

            <button onclick="UploadPicture()" class="edit-button" style="display: none;">Upload</button>
            <form id="Update-Form" action="/Social_platform_PHP/profile/updateProfile" method="post"
                  enctype="multipart/form-data">
                <input type="file" id="file-input" name="profile-pic" style="display: none;" accept=".jpg,.jpeg,.png">
                <input type="hidden" name="uid" value="<?php echo $uid; ?>">
        </div>

        <div id="edit-off" class="user-name">
            <?php
            echo '
             <h1>' . $CurrentUser['username'] . '</h1>
             <h3>' . $_SESSION['email'] . '</h3>
             ';
            ?>
        </div>

        <div id="edit-on" class="user-name">
            <input id="username-input" type="text" name="username-update" placeholder="Username" value="<?php echo $CurrentUser['username']; ?>">
            <?php
            echo '
              <h3>' . $_SESSION['email'] . '</h3>
           
             ';
            ?>

            

        </div>
        </form>

    </div>

    <div class="buttons-profile">
        <button onclick="ProfileUpdate()" class="btn">
            Update
        </button>

        <button onclick="ProfileDelete()" class="btn btn-red">
            Delete
        </button>
        <form id="delete-form" method="get" style="display: none;" action="http://localhost/Social_platform_PHP/profile/delete/">
            <input type="hidden" name="uid" value=<?php echo $_SESSION['uid']; ?> >
        </form>
    </div>
</div>


<div class="post-container">

    <!-- Post start -->
    <?php

    while ($row = $result->fetch_assoc()) {


        echo  '<div class="post">
          <div class="image-section">
            
            <div class="img-user">
            ';

        // show picture of user if user has a picture
        if (!is_null($CurrentUser['profile_picture'])) {
            echo '
            <img src=' . $CurrentUser['profile_picture'] . ' alt="Avatar" class="avatar post-avatar"> ';
        } else {
            echo '<img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar post-avatar">';
        }




        echo '
              <h3>' . $_SESSION['username'] . '</h3>
            </div>
              
              <i class="fi-xwsrxx-ellipsis"></i>
              
          </div>
        

          <hr class="post-hr">

          <div class="post-content">
            <h3>' . $row['post_title'] . '</h3>
            <p>' . $row['post_text'] . '</p>
          </div>
          
          <div class="post-btn">
            <button class="vote-btn-up gray" style="margin-right: 4px;">
              <i style="color: #FFCA1B" class="fi-xwsuxx-arrow-solid"></i> 
               ' . $row['upvote_count'] . '
            </button>

            <button class="vote-btn-down gray" >
              <i style="color: #FF4141" class="fi-xwsdxx-arrow-solid"></i>
               ' . $row['downvote_count'] . '
            </button>
          </div>
          
        </div>';
    }
    ?>
    <!-- Post end -->


</div>


<script defer src="https://friconix.com/cdn/friconix.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"
        integrity="sha512-LUKzDoJKOLqnxGWWIBM4lzRBlxcva2ZTztO8bTcWPmDSpkErWx0bSP4pdsjNH8kiHAUPaT06UXcb+vOEZH+HpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">

    function logout() {
        axios.get('http://localhost/Social_platform_PHP/home/logout')
            .then(function (response) {
                // handle success
                location.reload();
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    }

    function OnHomeClick() {
        window.location.href = '/Social_platform_PHP/home/index'
    }

    var editOn = document.getElementById("edit-on");
    editOn.style.display = "none";

    function ProfileUpdate() {
        var editOff = document.getElementById("edit-off");
        var editOn = document.getElementById("edit-on");
        var imageContainer = document.querySelector(".image-container");
        var editButton = document.querySelector(".edit-button");

        if (editOff.style.display === "none") {
            editOff.style.display = "block";
            editButton.style.display = "none";
            editOn.style.display = "none";
            // submit the form
            document.getElementById('Update-Form').submit();


        } else {
            editOff.style.display = "none";
            editOn.style.display = "block";
            editButton.style.display = "block";


        }


    }

    function UploadPicture() {
        var fileInput = document.querySelector("#file-input");

        fileInput.click();

    }

    function ProfileDelete() {

        document.getElementById('delete-form').submit();

    }


</script>


</body>

</html>
