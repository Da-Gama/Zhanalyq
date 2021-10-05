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
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<body>

    <?php
    include_once "header.php";
    ?>

    <div class="container py-5">
        <div class="d-flex">
            <h3 class="pl-1 py-1 align-self-center">Latest 🆕</h3>
            <a href="news.php?type=latest" class="ml-auto align-self-center">Show all</a>
        </div>
        <div class="row flex-nowrap overflow-auto p-3">
            <?php

            //import class PublicationModel
            require_once "models/PublicationModel.php";

            //get first 5 publications ordered by date
            $publications = PublicationModel::getLatestPublications(0, 5);
            for ($i = 0; $i < sizeof($publications); ++$i){
                $publication = $publications[$i];
                $publication['content'] = substr($publication['content'], 0, 50) . '...';
                ?>
                <div class="card-block" onclick="showContent(<?php echo $publication['publicationID']?>)">
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
            ?>
        </div>
        <div class="d-flex">
            <h3 class="pl-1 py-1 align-self-center">Hot 🔥</h3>
            <a href="news.php?type=hot" class="ml-auto align-self-center">Show all</a>
        </div>
        <div class="row flex-nowrap overflow-auto p-3">
            <?php
            //get first 5 publications ordered by likes count
            $publications = PublicationModel::getHotPublications(0, 5);
            for ($i = 0; $i < sizeof($publications); ++$i){
                $publication = $publications[$i];
                $publication['content'] = substr($publication['content'], 0, 50) . '...';
                ?>
                <div class="card-block" onclick="showContent(<?php echo $publication['publicationID']?>)">
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
            ?>
        </div>
        <div class="d-flex">
            <h3 class="pl-1 py-1 align-self-center">Most discussed 🗣</h3>
            <a href="news.php?type=discussed" class="ml-auto align-self-center">Show all</a>
        </div>
        <div class="row flex-nowrap overflow-auto p-3">
            <?php

            //get first 5 publications ordered by comments count
            $publications = PublicationModel::getDiscussedPublications(0, 5);
            for ($i = 0; $i < sizeof($publications); ++$i){
                $publication = $publications[$i];
                $publication['content'] = substr($publication['content'], 0, 50) . '...';
                ?>
                <div class="card-block" onclick="showContent(<?php echo $publication['publicationID']?>)">
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
            ?>
        </div>
        <script>
            function showContent(a){
                //open publication on new page
                window.location.href = 'content.php?id=' + a;
            }
        </script>
    </div>
    <?php
    include_once "footer.php";
    ?>
</body>
</html>
