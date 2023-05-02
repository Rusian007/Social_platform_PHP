<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search.css">
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;600&family=Poppins:wght@100;300;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>NSC || Search</title>

    <style>
        .btn {
            margin-top: 5px;
            margin: 10px !important;
            padding: 0;
            border: none;
            font: inherit;
            color: inherit;
            background-color: transparent;
            cursor: pointer;
            height: 50px;
            width: 50px;
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
                0 3px 1px -2px rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
        }

        .button-back {
            color: white;
            background-color: #ff4141;
            border-radius: 25px;
        }
    </style>
      <script defer src="https://friconix.com/cdn/friconix.js"> </script>
</head>

<body>
    <button class="btn button-back" onclick="goBack()"><i class="fi-xnslxl-chevron-solid"></i></button>
    <div class="main">

    <div class="live-filter">

        <div class="search">

            <div class="header">
                <h2>Looking for a particular post?</h2>


                <div class="search-bar">
                    <input type="text" id="query" name="q" placeholder="input post title...">

                </div>

            </div>

            <div class="user-info">
                <ul id="results" class="user-list">

                </ul>
            </div>


        </div>
    </div>
    </div>
    <script type="text/javascript">
        function goBack() {
            window.location.href = '/Social_platform_PHP/home/index';
        }
    </script>
    <script src="search.js"></script>
</body>

</html>