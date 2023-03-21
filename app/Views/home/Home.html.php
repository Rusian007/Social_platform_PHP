 <?php 
      
       session_start();
      ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home : Timeline</title>
    <link rel="stylesheet" type="text/css" href="Home.css" />
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

   <?php 
      
       if(!isset($_SESSION['logged_in']))
         {
		  header('Location: '.'/Social_platform_PHP/registration/index');
		  exit;
         } else{
          require_once '../../../db config.php';

          // create a new Database connection
          $handle = new db();
          $conn = $handle->connect();

          $result = $conn->query('SELECT * FROM `posts`');

          // Fetch data
          $posts = [];
          while ($row = $result->fetch_assoc()) {
              $posts[] = $row;
          }

         }
      ?>
    <!--Modal starts here-->
    <div class="p-modal" id="p-modal">
      <div class="modal-content" id="modal-content" data-backdrop="static">
        <div class="modal-header">
          <h2 class="title">Create a post</h2>
          <a href="#" class="close-btn" id="close-btn">X</a>
        </div>

        <form method="post" action="/Social_platform_PHP/home/createPost" class="modal-body">
          <div class="post-content">
            <textarea
              id="textArea"
              name="textArea"
              type="textarea"
              placeholder="What's on your mind?"
              rows="5"
            ></textarea>

            <div class="media-display">
              <input type="file" id="file" accept="image/*" />
              <input type="hidden" name="uid" value="<?php echo $_SESSION['uid']; ?>" />

              <label for="file">
                <img src="upload.png" alt="error" />
                <h3>Upload picture</h3>
              </label>
            </div>

            <div class="modalBtns">
              <button class="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!--   Ends here -->

    <div class="navbar">
      <nav>
        <h3>NSC</h3>

        <div class="buttons">
          <button onclick="OnProfileClick()"  class="profile-btn btn"><i class="fi-cnsuxl-user-tie-circle"></i></button>

          <button class="create-btn btn" id="create-post-btn-2"><i class="fi-cwsuxl-plus-solid"></i></button>

          <button onclick="OnSearchClick()" class="create-btn btn"><i class="fi-xnsuxl-search"></i></button>
            <button onclick="logout()" class="create-btn btn-red"><i class="fi-xnsuxl-sign-out-solid"></i></button>
        </div>
      </nav>
    </div>

    <div class="container">
      <div id="left" class="left padding">
        <div class="cancel-icon">
          <i
            onclick="Drawer()"
            style="color: #ff4141; margin-left: 5px"
            class="fi-cnsuxl-times-solid"
          ></i>
        </div>

        <div class="img">
          <img
            src="https://www.w3schools.com/howto/img_avatar2.png"
            alt="Avatar"
            class="avatar"
          />
        </div>

        <div class="user-name">
          <h3>
              <?php 
              echo $_SESSION['username'];
              ?>
          </h3>
        </div>

        <div class="votes">
          <h5>Upvotes <span class="yellow"> 12</span></h5>
          <i style="color: #ffca1b" class="fi-xwluxm-star-half-wide"></i>
        </div>

        <div class="btn-flex-container">
          <div class="btn-list">
            <button onclick="OnProfileClick()" class="profile-btn btn">Profile</button>

            <button class="create-btn btn" id="create-post-btn">Create</button>

            <button onclick="OnSearchClick()" class="create-btn btn">Search</button>
          </div>

          <div class="logout-btn">
            <button onclick="logout()" class="btn btn-red">Logout</button>
          </div>
        </div>
      </div>

      <i
        onclick="Drawer()"
        style="color: #ffca1b; margin-left: 5px"
        id="open-icon"
        class="fi-cwsrxx-arrow-solid"
      ></i>

      <div class="right">
        <!-- Replicable -->

        <div class="post-container">
          <?php 
           foreach ($posts as $post) {

            $result = $conn->query('SELECT `username` FROM `users` WHERE user_id = '.$post['user_id']);
            $row = $result->fetch_assoc(); //get the username

        echo'  <div class="post">
            <div class="image-section">
              <div class="img-user">
                <img
                  src="https://www.w3schools.com/howto/img_avatar2.png"
                  alt="Avatar"
                  class="avatar post-avatar"
                />
                <h3>'. $row['username']  .' </h3>
              </div>

              <i class="fi-xwsrxx-ellipsis"></i>
            </div>

            <hr class="post-hr" />

            <div class="post-content">
              <h3></h3>
              <p>'. $post['post_text'] .'</p>
            </div>

            <div class="post-btn">
              <button class="vote-btn-up" style="margin-right: 4px">
                <i style="color: #ffca1b" class="fi-xwsuxx-arrow-solid"></i>
                '. $post['upvote_count'] . '
              </button>

              <button class="vote-btn-down">
                <i style="color: #ff4141" class="fi-xwsdxx-arrow-solid"></i>
                '. $post['downvote_count'] . '
              </button>
            </div>
          </div>';
          
           }
        ?>
       
        </div>
      </div>
    </div>
  </body>

  <script defer src="https://friconix.com/cdn/friconix.js"></script>

  <script type="text/javascript">
    var IsOpen = true;
    document.getElementById("open-icon").style.display = "none";

    function Drawer() {
      if (IsOpen) {
        // hide
        document.getElementById("left").style.width = "0px";

        document.getElementById("left").classList.remove("padding");
        document.getElementById("left").classList.add("padding-remove");

        document.getElementById("open-icon").style.display = "block";
        IsOpen = false;
      } else {
        // Show the div
        document.getElementById("left").style.width = "200px";

        document.getElementById("left").classList.remove("padding-remove");
        document.getElementById("left").classList.add("padding");

        document.getElementById("open-icon").style.display = "none";
        IsOpen = true;
      }
    }

    const backdrop = document.getElementById("p-modal");
    const forgotBtn = document.getElementById("forgot-btn");
    const closeBtn = document.getElementById("close-btn");
    const createPostBtn = document.getElementById("create-post-btn");
    const createPostBtn2 = document.getElementById("create-post-btn-2");

    backdrop.style.display = "none";

    createPostBtn.addEventListener("click", () => {
      backdrop.style.display = null;
    });

    createPostBtn2.addEventListener("click", () => {
      backdrop.style.display = null;
    });

    backdrop.addEventListener("click", (e) => {
      if (e.target.id === "p-modal") {
        backdrop.style.display = "none";
      }
    });

    closeBtn.addEventListener("click", () => {
      backdrop.style.display = "none";
    });

    //upload picture for post//
    const display = document.querySelector(".media-display");
    const input = document.querySelector("#file");
    let img = document.querySelector("img");

    input.addEventListener("change", () => {
      let reader = new FileReader();
      reader.readAsDataURL(input.files[0]);
      reader.addEventListener("load", () => {
        display.innerHTML = `<img src=${reader.result} alt=''/>`;
      });
    });

    closeBtn.addEventListener("click", () => {
      backdrop.style.display = "none";
      display.innerHTML = `<input type="file" id="file" accept="image/*" />
              <label for="file">
                <img src="upload.png" alt="error" />
                <h3>Upload picture</h3>
              </label>`;
    });
  </script>

<script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
<script type="text/javascript">

  function OnProfileClick(){
    window.location.href='../profile/profile.html'
  }

  function OnSearchClick(){
    window.location.href='../search/search.html'
  }
    
    function logout(){
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
</script>


</html>
