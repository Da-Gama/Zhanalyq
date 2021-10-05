<?php

header('Content-Type: application/json');
require_once "../Database/db.php";

function haveAccount($acc){
    if($acc != null && $acc['email'] != null){
        return true;
    } else{
        throw new Exception("Login or Password incorrect!");
    }
}

if(isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)){
        //JSON response to client
        echo (json_encode(array('message'=>'Please, fill all fields')));
        return;
    }

    //Prepared Statement
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    //Try Catch
    try{
        haveAccount($row);
        session_start();

        //Session
        $_SESSION['user'] = array(
            'id' => $row['userID'],
            'email' => $email,
            'password' => $password,
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'birthday' => $row['birthday'],
            'description' => $row['description']
        );
        $return = array(
            'message' => "success"
        );
    }
    catch(Exception $not){
        $return = array(
            'message' => "Login or Password incorrect!"
        );
    }
    $stmt->close();
}
else{
    $return = array(
        'message' => "Login attempt denied."
    );
}
echo (json_encode($return));