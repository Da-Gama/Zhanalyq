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
    .row{
        justify-content: center;
    }
    .image-container{
        position: relative;
        text-align: center;
    }
    .background-image{
        position: relative;
        background-repeat: no-repeat;
        background-size: cover;
        height: 400px;
        background-position: center;
    }
    .bottom-left {
        position: absolute;
        bottom: 30px;
        margin: 0 100px 0 100px;
    }
    .no-decor {
        background: transparent;
        box-shadow: 0 0 0 transparent;
        border: 0 solid transparent;
        text-shadow: 0 0 0 transparent;
    }
    .like-container{
        padding: 100px;
    }
    .fa {
        font-size: 50px;
        cursor: pointer;
        user-select: none;
        color: #dc3444;
    }
    .fa:hover {
        color: #dc3444;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<body class="bg-light">
<?php
include_once "header.php";
?>

<?php
require_once "models/CommentModel.php";
require_once "models/PublicationModel.php";
if (empty($_GET['id'])){
    echo "<p class='text-center mt-5 display-4 text-muted'>NOT FOUND 404 :(</p>";
    return;
}
$publication = PublicationModel::getPublication($_GET['id']);

?>
<div class="background-image" style='background: url("<?php echo $publication['image']?>")'>
    <div style="background: black; opacity: 0.5" class="w-100 h-100">
    </div>
    <div class="bottom-left text-white">
        <a href="news.php?category=<?php echo $publication['categoryID']?>" ><?php echo $publication['categoryName']?></a>
        <h1><?php echo $publication['title']?></h1>
        <span><a href="news.php?author=<?php echo $publication['userID']?>" class="text-white"><?php echo $publication['firstName'] . ' ' . $publication['lastName']?></a><br><small class="text-white" style="opacity: 0.5"><?php echo $publication['date_']?></small></span>
        <br><br>
        <span class="text-white mr-3" style="opacity: 0.5"><i class="fas fa-heart"></i> <?php echo $publication['liked']?></span>
        <span class="text-white mr-3" style="opacity: 0.5"><i class="fas fa-comment"></i> <?php echo $publication['commented']?></span>
        <?php
        if (PublicationModel::isMyPublication($userID, $_GET['id'])){
            $publicationID = $_GET['id'];
            echo "<a href='updatePubl.php?id=$publicationID' class=\"text-white\">Update</a>";
        }
        ?>
    </div>
</div>
<div class="container pt-4 mb-5 px-5" style="background: white">
    <p><?php echo $publication['content']?></p>
    <hr>
    <?php
    if (!PublicationModel::isMyPublication($userID, $_GET['id']) && $userID != null){
        ?>
        <div class="like-container text-center">
            <p class="display-4">LIKE POST</p>
            <?php
            if (PublicationModel::isLiked($publication['publicationID'], $userID)){
                $style = 'style="color: red"';
                $style2 = 'style="display: block"';
            }else{
                $style = 'style="color: gray"';
                $style2 = 'style="display: none"';
            }
            ?>
            <i id="btn-like" class="text-center fa fas fa-heart fa-2x" <?php echo $style?>></i>
            <br><small class="text-muted" id="liked-message" <?php echo $style2?>>You have already liked</small>
            <script>
                $('#btn-like').click(function(){
                    $.post('publicationRequest.php', {like: 200, publicationID: <?php echo $_GET['id']?>, userID: <?php echo $userID?>}).done(function (msg) {
                        if (msg['code'] === 200){
                            if (msg['msg'] === 'Successfully liked'){
                                $('#btn-like').css('color', 'red');
                            }
                            else{
                                $('#btn-like').css('color', 'gray');
                                $('#liked-message').css('display', 'none');
                            }
                        }else{
                            alert('Error');
                        }
                    })
                });
            </script>
        </div>
        <?php
    }
    ?>
</div>
<div class="container mb-5">
    <h3>Comments</h3><br>
    <?php
    if (!PublicationModel::isMyPublication($userID, $_GET['id']) && $userID != null){
        ?>
        <form class="mb-5">
            <div class="form-group">
                <label for="commentContent">Content</label><textarea class="form-control" id="commentContent" rows="8" placeholder="Enter your comment here..."></textarea>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" id="btn-comment">Publish</button>
            </div>
            <script>
                //jQuery function click to implement clicking on button
                $('#btn-comment').click(function(){
                    content = $('#commentContent').val();
                    if (content === ''){
                        alert('Comment body cannot be empty');
                        return;
                    }

                    //jQuery function for post method
                    $.post('commentRequest.php', {comment: 200, publicationID: <?php echo $_GET['id']?>, userID: <?php echo $userID?>, content: content})
                        .done(function(msg){
                            if (msg['code'] === 200){
                                alert('successfully published');
                                location.reload();
                            }else{
                                alert('Error');
                            }
                        });
                });
            </script>
        </form>
        <?php
    }elseif ($userID == null){
        //if user is not logged
        echo "<a href='auth/authentication.php'>Sign in</a> to comment";
    }
    ?>
    <?php

    //Array of comments
    $comments = $publication['comments'];
    for ($i = 0; $i < sizeof($comments); ++$i){
        $comment = $comments[$i];
        ?>
        <div class="comment">
            <div>
                <span><?php echo $comment['firstName'] . ' ' . $comment['lastName']?></span>
                <?php
                    if (CommentModel::isMyComment($userID, $comment['commentID'])){
                        ?>
                        <button type="button" class="no-decor float-right" onclick="showModal(<?php echo $comment['commentID']?>)">
                            <i class="fas fa-edit" style="color: #057bfe"></i>
                        </button>
                        <button type="button" class="no-decor float-right">
                            <i class="fas fa-trash" style="color: #dc3444" onclick="removeComment(<?php echo $comment['commentID']?>)"></i>
                        </button>
                        <?php
                    }
                ?>
            </div>
            <small class="text-muted"><?php echo $comment['date_']?></small>
            <p><?php echo $comment['commentContent']?></p>
        </div>
        <hr>
        <?php
    }
    ?>
    <div class="modal fade" id="commentUpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" value="" id="comment-id">
                <div class="modal-body">
                    <textarea id="comment-content-area" class="form-control" rows="8"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update-comment">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        //Updating comment
        $('#btn-update-comment').click(function(){
            content = $('#comment-content-area').val();
            commentID = $('#comment-id').val();
            if (content === ''){
                alert('Fill the content');
                return;
            }

            //jQuery post method for updating comment
            $.post('commentRequest.php', {updateComment: 200, content: content, commentID: commentID}).done(function(msg){
                if (msg['code'] === 200){
                    alert('Successfully updated');
                    location.reload();
                }else{
                    alert('Error');
                }
            });
        });

        //Function to show modal
        function showModal(id){

            //Post method -> first param = server, second param = request body

            //msg = message received from server commentRequest.php
            $.post('commentRequest.php', {getComment: 200, commentID: id}).done(function(msg){
                if (msg['code'] === 200){
                    $('#comment-content-area').val(msg['content']);
                    $('#comment-id').val(id);
                    $('#commentUpdateModal').modal('show');
                }else{
                    alert('Error');
                }
            });


        }


        function removeComment(c){
            //confirm is just alert window with confirm button
            var b = confirm('Delete the comment?');
            if (b === true){

                //jQuery Post method for deleting comment
                $.post('commentRequest.php', {removeComment: 200, commentID: c, publicationID: <?php echo $_GET['id']?>}).done(function(msg){
                    if (msg['code'] === 200){
                        alert('Comment successfully deleted');
                        location.reload();
                    }else{
                        alert('Error');
                    }
                });
            }
        }
    </script>
</div>
<?php
include_once "footer.php";
?>
</body>
</html>

