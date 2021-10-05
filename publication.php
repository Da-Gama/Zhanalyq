<?php
session_start();
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
        margin-bottom: 13px;
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
    .row{
        justify-content: center;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<body class="bg-light">

<?php
include_once "header.php";
?>

<div class="container mb-5 px-5">
    <p class="text-center my-5 h2">New publication</p>
    <?php
    session_start();
    if (!$_SESSION['user']){
        ?>
        <div class="text-center">
            <h6 class="text-muted">To publish you need to <a href="auth/authentication.php">Sign in</a></h6>
        </div>
        <?php
        return;
    }
    ?>
    <form>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Type here...">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" placeholder="url...">
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category">
                <?php
                    require_once "models/CategoryModel.php";
                    $categories = CategoryModel::getCategories();
                    for ($i = 0; $i < sizeof($categories); ++$i){
                        $category = new CategoryModel($categories[$i]['categoryID'], $categories[$i]['categoryName']);
                        ?>
                        <option value="<?php echo $category->getId()?>"><?php echo $category->getName()?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" rows="8" placeholder="Enter your content here..."></textarea>
        </div>
        <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-publish">Publish</button>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#btn-publish').click(function () {
            title = $('#title').val();
            content = $('#content').val();
            category = $('#category').val();
            image = $('#image').val();
            if (!title || !content || !category || !image){
                alert('Field all fields');
                return;
            }

            //jQuery method to publish new publication
            $.post('publicationRequest.php', {publish: 'ok', title: title, content: content, category: category, user: <?php echo $userID?>, image: image})
                .done(function (msg) {
                    if (msg['code'] === 200){
                        alert('Successfully published');
                        window.location.href = 'content.php?id=' + msg['id'];
                    }else{
                        alert('Error');
                    }
                });
        });
    });
</script>

<?php
include_once "footer.php";
?>

</body>
</html>

