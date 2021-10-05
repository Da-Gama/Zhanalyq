<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>News</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<style>
    ul.navbar-nav li{
        padding-left: 16px;
        padding-right: 16px;
    }
    .navbar {
        padding: 15px 140px 15px 150px;
    }
    .card-block{
        margin-right: 13px;
        transition: box-shadow .3s;
        cursor: pointer;
        margin-bottom: 13px;
    }
    .card-block:hover{
        box-shadow: 0 0 11px rgba(33,33,33,.2);
    }
    .image-container{
        position: relative;
        text-align: center;
    }
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .row{
        justify-content: center;
        align-items: flex-start;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<body>

<?php
include_once "header.php";
?>

<div class="container">
    <p class="text-center my-5 h2">Categories</p>
    <div class="row mb-5">
        <?php
        //Import our class Category
        require_once "models/CategoryModel.php";

        //Array of categories
        $categories = CategoryModel::getCategories();
        for ($i = 0; $i < sizeof($categories); ++$i){
            $category = $categories[$i];
            ?>
            <div class="card-block image-container" style='width: 15rem;' onclick="showNews(<?php echo $category['categoryID']?>)">
                <div class="centered bg-dark w-100 h-100" style="opacity: 0.5"></div>
                <img src="<?php echo $category['categoryImage']?>" class="card-img-top" alt="">
                <div class="centered px-2 text-white">
                    <h3 class="align-middle"><?php echo $category['categoryName']?></h3>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <script>
        function showNews(c){
            //show all news filtered by category
            window.location.href = 'news.php?category=' + c;
        }
    </script>
</div>
<?php
include_once "footer.php";
?>
</body>
</html>