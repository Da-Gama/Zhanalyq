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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<body class="bg-light">

<?php
include_once "header.php";
require_once "models/PublicationModel.php";
if (empty($_GET['id'])){
    echo "<p class='text-center display-4 text-muted mt-5'>Content not found</p>";
    return;
}

//Check if it is my publication, if is not, cannot be updated
if (!PublicationModel::isMyPublication($userID, $_GET['id'])){
    echo "<p class='text-center display-4 text-muted mt-5'>Access denied</p>";
    return;
}

$publication = PublicationModel::getPublication($_GET['id']);
?>

<div class="container mb-5 px-5">
    <p class="text-center my-5 h2">Update publication</p>
    <form>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Type here..." value="<?php echo $publication['title']?>">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" value="<?php echo $publication['image']?>" placeholder="url...">
        </div>
        <input type="hidden" value="<?php echo $_GET['id']?>" id="publicationID">
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" rows="8" placeholder="Enter your content here..."><?php echo $publication['content']?></textarea>
        </div>
        <div class="form-group text-center">
            <button type="button" class="btn btn-primary btn-lg btn-block mb-4" id="btn-update">Update</button>
            <small class="text-muted">or</small><br>
            <button type="button" class="btn btn-outline-danger mt-4 float-middle" id="btn-delete">Delete</button>
        </div>
    </form>
    <script>
        $('#btn-update').click(function(){
            title = $('#title').val();
            content = $('#content').val();
            image = $('#image').val();
            publicationID = $('#publicationID').val();
            if (!title || !content || !image){
                alert('Please, fill all fields');
                return;
            }

            //jQuery method for updating publication
            $.post('publicationRequest.php', {updatePublication: 200, title: title, content: content, image: image, publicationID: publicationID})
            .done(function(msg){
                if (msg['code'] === 200){
                    alert(msg['msg']);
                    window.location.href = 'content.php?id=' + publicationID;
                }else{
                    alert('Error');
                }
            })
        });
        $('#btn-delete').click(function(){
            publicationID = $('#publicationID').val();
           var x = confirm("Delete the publication?");
           if (x === true){

               //jQuery method for deleting publication
               $.post('publicationRequest.php', {deletePublication: 200, publicationID: publicationID})
                   .done(function(msg){
                       if (msg['code'] === 200){
                           alert(msg['msg']);
                           window.location.href = 'main.php';
                       }else{
                           alert('Error');
                       }
                   })
           }
        });
    </script>

</div>

<?php
include_once "footer.php";
?>

</body>
</html>