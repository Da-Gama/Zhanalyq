<!DOCTYPE html>
<html>
    <head>
        <title>All tags</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                crossorigin="anonymous"></script>
        <link href="fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <style>

            ul.navbar-nav li{
                padding-left: 16px;
                padding-right: 16px;
            }
            .navbar {
                padding: 15px 140px 15px 150px;
            }
            .item1 {
                grid-area: button;
            }
            .item2 {
                grid-area: menu;
                text-align: center;

            }
            .item3 { grid-area: main; }
            .item4 { grid-area: right; }
            .item5 { grid-area: footer; }

            .grid-container {
                display: grid;
                grid-template-areas:
                    'menu main main main right right right'
                    'menu main main main right right right'
                    'menu footer footer footer footer footer footer'
                    'menu footer footer footer footer footer footer'
                    'button footer footer footer footer footer footer';
                grid-gap: 20px;
                padding: 20px;
                margin-top: 20px;
            }
            .grid-container > div{
                padding: 20px;
            }
        </style>

    </head>
    <body>

    <?php
    include_once "header.php";
    ?>

    <div class="container text-center mt-5">
        <?php
        //import class UserModel
        require_once "models/UserModel.php";
        session_start();
        if (empty($_GET['id'])){
            $userID = $_SESSION['user']['id'];
        }else{
            $userID = $_GET['id'];
        }
        $user = UserModel::getUser($userID);
        ?>
        <h2><?php echo $user['firstName'] . " " . $user['lastName']?></h2>
        <hr>
    </div>
    <div class="grid-container container">
        <div class="item2">
            <img src="https://image.flaticon.com/icons/svg/667/667429.svg" width="250px" height="250px" alt="">
        </div>
        <div class="item1">

        </div>
        <div class="item3 card">
            <span class="text-muted">Main info:</span>
            <hr>
            <div>
                <div>
                    <span>Email: <b><?php echo $user['email']?></b></span>
                </div>
                <div>
                    <span>Publications: <b><?php echo $user['publications']?></b></span>
                </div>
                <div>
                    <span>Comments: <b><?php echo $user['comments']?></b></span>
                </div>
            </div>
        </div>
        <div class="item4 card">
            <span class="text-muted">Personal Info:</span>
            <hr>
            <div>
                <span>First name: <b><?php echo $user['firstName']?></b></span>
            </div>
            <div>
                <span>Last name: <b><?php echo $user['lastName']?></b></span>
            </div>
            <div>
                <span>Birthday: <b><?php echo $user['birthday']?></b></span>
            </div>
        </div>
        <div class="item5 card">
            <span class="text-muted">About me:</span>
            <hr>
            <p class="lead"><?php if ($user['description'] == '') echo "<i class='text-muted'>Empty</i>"; else echo $user['description']?></p>
        </div>
    </div>
    </body>
    <?php
    include_once "footer.php";
    ?>
</html>