<?php
require_once "models/PublicationModel.php";
header('Content-Type: application/json');
if (isset($_POST['publish'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['user'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    $id = PublicationModel::publish($author, $title, $content, $category, $image);
    if ($id != null){
        echo json_encode(array('code'=>200, 'id'=>$id));
        return;
    }
    echo json_encode(array('code'=>501));
    return;
}

if (isset($_POST['like'])){
    $publicationID = $_POST['publicationID'];
    $userID = $_POST['userID'];
    if (PublicationModel::isLiked($publicationID, $userID)){
        if (PublicationModel::unlike($publicationID, $userID))
        {
            echo json_encode(array('code'=>200, 'msg'=>'Successfully unliked'));
            return;
        }else{
            echo json_encode(array('code'=>501));
            return;
        }
    }else{
        if (PublicationModel::like($publicationID, $userID))
        {
            echo json_encode(array('code'=>200, 'msg'=>'Successfully liked'));
            return;
        }else{
            echo json_encode(array('code'=>501));
            return;
        }
    }
}

if (isset($_POST['updatePublication'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image'];
    $publicationID = $_POST['publicationID'];

    if (PublicationModel::update($publicationID, $title, $content, $image)){
        echo json_encode(array('code'=>200, 'msg'=>'Successfully updated'));
        return;
    }else{
        echo json_encode(array('code'=>501));
        return;
    }
}

if (isset($_POST['deletePublication'])){
    $userID = $_POST['userID'];
    $publicationID = $_POST['publicationID'];

    if (PublicationModel::deletePublication($publicationID)){
        echo json_encode(array('code'=>200, 'msg'=>'Successfully deleted'));
        return;
    }else{
        echo json_encode(array('code'=>501));
        return;
    }
}