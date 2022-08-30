<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once ('db.php');

function validateData($data)
{
    $resultData = htmlspecialchars(stripslashes(trim($data)));
    return $resultData;
}

if (isset($_POST['action']) && $_POST['action'] == 'registration') {
    $first_name = validateData($_POST['firstName']);
    $last_name = validateData($_POST['lastName']);
    $register_number = validateData($_POST['registerNumber']);
    $date_of_birth= validateData($_POST['dateOfBirth']);
    $email_id = validateData($_POST['emailId']);
    $contact_number = validateData($_POST['contactNumber']);
    $password = validateData($_POST['password']);
    $confirm_password = validateData($_POST['confirmPassword']);
    
    $error_message = '';
    $checkEmailQuery = $conn->prepare("select * from tbl_registration where email_id = ?");
    $checkEmailQuery->bind_param("s", $email_id);
    $checkEmailQuery->execute();
    
    $result = $checkEmailQuery->get_result();
    if ($result->num_rows > 0) {
        
        $error_message = "Email ID already exists !";
        echo $error_message;
    } else {
        $insertQuery = $conn->prepare("insert into tbl_registration(first_name,last_name,register_number,date_of_birth,email_id,contact_number,password) values(?,?,?,?,?,?,?)");
        $password = md5($password);
        $insertQuery->bind_param("sssssss", $first_name, $last_name, $register_number, $date_of_birth, $email_id, $contact_number, $password);
        
        if ($insertQuery->execute()) {
            echo "Thankyou for registering with us. You can login now.";
            exit();
        } else {
            $error_message = "error";
        }
        $insertQuery->close();
        $conn->close();
        
        echo $error_message;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $emailId = validateData($_POST['emailId']);
    $password = validateData($_POST['password']);
    $password = md5($password);
    $error_message = '';
    
    $selectQuery = $conn->prepare("select * from tbl_registration where email_id = ? and password = ?");
    $selectQuery->bind_param("ss", $emailId, $password);
    $selectQuery->execute();
    $result = $selectQuery->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['username'] = $row['first_name'] . " " . $row['last_name'];
            $_SESSION['regno'] = $row['register_number'];
            $_SESSION['email'] = $row['email_id'];
            require_once "dashboard.php";
            exit();
        } // endwhile
    } // endif
else {
        $error_message = "error";
    } // endElse
    $conn->close();
    
    echo $error_message;
}
?>
