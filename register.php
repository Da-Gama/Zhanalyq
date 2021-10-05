<?php
header('Content-Type: application/json');
require_once "../Database/db.php";

if (isset($_POST['checkEmail'])){
    //email validation
    $email = $_POST['email'];
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if ($row == null) {

        $return = array(
            'message' => "success"
        );
    } else {
        $return = array(
            'message' => "Account is reserved!"
        );
    }
    $stmt->close();
    echo (json_encode($return));
}
if (isset($_POST['register'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthday'];
    if (empty($email) || empty($password) || empty($firstName) || empty($lastName) || empty($birthDate)){
        echo (json_encode(array('message'=>'Please, fill all fields')));
        return;
    }

    $dec = "";
    //Prepared Statement
    $stmt = $db->prepare("INSERT INTO users(email, password, firstName, lastName, birthday) VALUES(?, ?, ?, ?, ?);");
    $stmt->bind_param("sssss", $email, $password, $firstName, $lastName, $birthDate);

    if ($stmt->execute()){
        session_start();
        //session
        $_SESSION['user'] = array(
            'id' => mysqli_insert_id($db),
            'email' => $email,
            'password' => $password,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'birthday' => $birthDate
        );
        $return = array('message'=>"success");
    }else{
        $return = array('message'=>'Registration error');
    }
    $stmt->close();
    echo json_encode($return);
}
