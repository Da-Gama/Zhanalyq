<?php
header('Content-Type: application/json');
require_once "Database/Database.php";

if (isset($_POST['updatePersonal'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthday = $_POST['birthday'];
    $userID = $_POST['userID'];

    $sql = 'update users set firstName = "' . $firstName . '", lastName = "' . $lastName . '", birthday = "' . $birthday . '" where userID = ' . $userID;
    if (Database::executeData($sql)){
        session_start();
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['birthday'] = $birthday;
        echo json_encode(array('code'=>200));
        return;
    }
    echo json_encode(array('code'=>501));
    return;
}

if (isset($_POST['updatePassword'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $retype_password = $_POST['retype_password'];
    $userID = $_POST['userID'];
    $sql = 'select * from users where userID = ' . $userID . ' and password = "' . $current_password . '"';
    if (sizeof(Database::getData($sql)) == 0){
        echo json_encode(array('code' => 300, 'message'=>'Password is incorrect'));
        return;
    }else{
        if ($new_password == '' || $current_password == ''){
            echo json_encode(array('code'=>300, 'message'=>'New password cannot be empty'));
            return;
        }
        if ($new_password == $retype_password){
            $sql = 'update users set password = "' . $new_password . '" where userID = ' . $userID;
            Database::executeData($sql);
            echo json_encode(array('code'=>200));
            return;
        }else{
            echo json_encode(array('code'=>400, 'message'=>'Passwords do not match'));
            return;
        }
    }
}

if (isset($_POST['updateDescription'])){
    session_start();
    $description = $_POST['description'];
    $userID = $_POST['userID'];
    $sql = 'update users set description = "' . $description . '" where userID = ' . $userID;
    if (Database::executeData($sql)){
        $_SESSION['user']['description'] = $description;
        echo json_encode(array('code'=>200));
        return;
    }
    echo json_encode(array('code'=>300));
    return;
}