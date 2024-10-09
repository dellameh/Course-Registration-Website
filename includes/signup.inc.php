<?php

//limit users to enter unallowed paths in url

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $email = $_POST['email'];
    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_cntrl.inc.php';

        //ERROR HANDLERS
        //checking if user entered all required inputs
        $errors = [];

        if (isInputEmpty($username, $password, $repassword, $email) == true) {
            $errors['Empty_input'] = 'Fill in all fields';
        }
        if (isEmailInvalid($email) && !empty($email)) {
            $errors['invalid_email'] = 'Invalid Email used';
        }
        if (isUsernameTaken($pdo, $username)) {
            $errors['username_taken'] = 'Username already taken';
        }
        if(isEmailRegistered($pdo,$email) && !empty($email)){
            $errors['Email_used'] = 'Email already registered';
        }
        if (wrongRePassword($password , $repassword)){
            $errors['password_match'] = 'Your passwords do not match';
        }

        require_once 'config.session.inc.php';

        if($errors){
            $_SESSION['errors_signup'] = $errors;
            header("Location: ../signup.php");
            die();
        }

        createUser($pdo,$username, $password, $email);
        header("Location: ../signup.php?signup=success");
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("connection failed:" . $e->getMessage());
    }
} else {
    header("Location: ../signup.php ");
    die();
}