<?php
header('Content-Type: application/json');
require_once "models/CommentModel.php";

//Page of requests related to comment

if (isset($_POST['comment'])){
    $userID = $_POST['userID'];
    $publicationID = $_POST['publicationID'];
    $content = $_POST['content'];
    if (CommentModel::createComment($userID, $publicationID, $content)){
        echo json_encode(array('code'=>200));
        return;
    }else{
        echo json_encode(array('code'=>501));
        return;
    }
}

if (isset($_POST['updateComment'])){
    $commentID = $_POST['commentID'];
    $content = $_POST['content'];

    if (CommentModel::updateComment($commentID, $content)){
        echo json_encode(array('code'=>200));
        return;
    }else{
        echo json_encode(array('code'=>501));
        return;
    }
}

if (isset($_POST['removeComment'])){
    $commentID = $_POST['commentID'];
    $publicationID = $_POST['publicationID'];
    if (CommentModel::removeComment($commentID, $publicationID)){
        echo json_encode(array('code'=>200));
        return;
    }else{
        echo json_encode(array('code'=>501));
        return;
    }
}

if (isset($_POST['getComment'])){
    $commentID = $_POST['commentID'];
    $comment = CommentModel::getComment($commentID);
    if ($comment){
        echo json_encode(array('code'=>200, 'content'=>$comment['commentContent']));
        return;
    }else{
        echo json_encode(array('code'=>501));
        return;
    }
}
