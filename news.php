<?php
session_start();

//Checking SESSION for logged user

if ($_SESSION['user']['id']){
    $userID = $_SESSION['user']['id'];
}else{
    $userID = null;
}
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>News</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link href="fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet">
<style>
    ul.navbar-nav li{
        padding-left: 16px;
        padding-right: 16px;
    }
    .navbar {
        padding: 15px 140px 15px 150px;
    }
    .card-block .card{
        margin-right: 13px;
        transition: box-shadow .3s;
        cursor: pointer;
    }
    .card-block .card:hover{
        box-shadow: 0 0 11px rgba(33,33,33,.2);
    }
    .image-container{
        position: relative;
        text-align: center;
    }
    .top-right {
        position: absolute;
        top: 13px;
        right: 13px;
    }
    .bottom-left {
        position: absolute;
        bottom: 13px;
        left: 13px;
    }
    .row{
        justify-content: center;
    }
</style>

<!-- Download Bootstrap and jQuery libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<body class="bg-light">


<?php
//To include header of our web page
include_once "header.php";
?>

<div class="container">
    <?php

    //Import our classes
    require_once "models/PublicationModel.php";
    require_once "models/UserModel.php";
    require_once "models/CategoryModel.php";

    $title = 'The latest news 🆕';
    ?>
    <?php

    //Count of elements on per page
    $count = 3;
    if (isset($_GET['page'])) {
        $start = ($_GET['page'] - 1) * $count;
    } else {
        $start = 0;
    }

    //To calculate total page, it is necessary to divide count of publications by count of elements on per page
    //ceil means round. For example 5.1 -> ceil -> 6
    $totalPage = ceil(PublicationModel::getPublicationsCount() / $count);
    $publications = PublicationModel::getLatestPublications($start, $count);

    //Filter news by author
    if (isset($_GET['author'])) {
        //getAuthorPublications - static method of class "PublicationModel"
        $publications = PublicationModel::getAuthorPublications($start, $count, $_GET['author']);

        //It is necessary to update totalPage in per filter because of different count of elements in per filter
        $totalPage = ceil(PublicationModel::getAuthorPublicationsCount($_GET['author']) / $count);
        if ($_GET['author'] == $userID) {
            $title = 'My publications';
        } else {
            $user = UserModel::getUser($_GET['author']);
            $title = $user['firstName'] . " " . $user['lastName'];
        }
    }

    //Filter by category
    if (isset($_GET['category'])) {
        //getPublicationsByCategory - static method of class "PublicationModel"
        $publications = PublicationModel::getPublicationsByCategory($start, $count, $_GET['category']);

        $totalPage = ceil(PublicationModel::getPublicationsCountByCategory($_GET['category']) / $count);

        $category = CategoryModel::getCategory($_GET['category']);

        //To refresh our title
        $title = $category['categoryName'];
    }

    //Filter by type
    if (isset($_GET['type'])) {
        $totalPage = ceil(PublicationModel::getPublicationsCount() / $count);
        if ($_GET['type'] == 'hot') {
            $publications = PublicationModel::getHotPublications($start, $count);
            $title = "Hot news 🔥";
        } elseif ($_GET['type'] == 'discussed') {
            $publications = PublicationModel::getDiscussedPublications($start, $count);
            $title = "Most discussed news 🗣";
        } else {
            $publications = PublicationModel::getLatestPublications($start, $count);
            $title = "The latest news 🆕";
        }
    }

    ?>
    <p class="text-center mt-5 h2"><?php echo $title?></p>
    <div class="text-center mb-3">
    <?php
    //To generate links of pages
    for ($i = 1; $i <= $totalPage; ++$i){

        //If already have filter parameter, it is necessary to save it
        if (isset($_GET['author'])){
            $author = $_GET['author'];
            echo "<a href='?author=$author&page=$i' class='mr-4'>$i</a>";
        }
        if (isset($_GET['type'])){
            $type = $_GET['type'];
            echo "<a href='?type=$type&page=$i' class='mr-4'>$i</a>";
        }
        if (isset($_GET['category'])){
            $category = $_GET['category'];
            echo "<a href='?category=$category&page=$i' class='mr-4'>$i</a>";
        }
        if (empty($_GET['author']) && empty($_GET['type']) && empty($_GET['category'])){
            echo "<a href='?type=latest&page=$i' class='mr-4'>$i</a>";
        }
    }
    ?>
    </div>
    <div class="row mb-5">

        <?php

        //Array of publications
        for ($i = 0; $i < sizeof($publications); ++$i){
            $publication = $publications[$i];
            $publication['content'] = substr($publication['content'], 0, 50) . '...';
            ?>
            <div class="card-block mb-3" onclick="showContent(<?php echo $publication['publicationID']?>)">
                <div class="card" style="width: 18rem;">
                    <div class="image-container">
                        <img src="<?php echo $publication['image']?>" class="card-img-top" alt="">
                        <div class="top-right px-2 rounded bg-dark" style="opacity: 0.5">
                            <small class="text-white mr-2"><i class="fas fa-heart"></i> <?php echo $publication['liked']?></small>
                            <small class="text-white"><i class="fas fa-comment"></i> <?php echo $publication['commented']?></small>
                        </div>
                        <div class="bottom-left px-2 rounded bg-dark" style="opacity: 0.5">
                            <small class="text-white"><?php echo $publication['categoryName']?></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $publication['title']?></h5>
                        <p class="card-text"><?php echo $publication['content']?></p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <small class="text-muted"><?php echo $publication['firstName'] . " " . $publication['lastName']?></small>
                            <small class="ml-auto text-muted"><?php echo $publication['date_']?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
            if (sizeof($publications) === 0){
                echo "<p class='text-muted display-4 my-5'>No data :(</p>";
            }
            ?>
    </div>
    <script>
        function showContent(a){
            //Function to open one publication on the new page
            window.location.href = 'content.php?id=' + a;
        }
    </script>
</div>

<?php
//Just including footer

include_once "footer.php";
?>

</body>
</html>

