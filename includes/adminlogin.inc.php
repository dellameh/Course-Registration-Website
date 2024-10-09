<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        require_once 'dbh.inc.php';
        require_once 'adminlogin_model.inc.php';
        require_once 'login_cntrl.inc.php';

        //ERROR HANDLERS
        //checking if user entered all required inputs
        $errors = [];


        if (($username != NULL) AND ($password!=NULL)){
            $result = getUser($pdo,$username);

            if (isUsernameWrong($result)) {
                $errors['Wrong-login'] = 'incorrect login info';
            }

            else if (isPasswordAdminWrong($password, $result['pass'])) {
                $errors['Wrong-login'] = 'incorrect pass';
            }
        }else{
            $errors['Empty_input'] = 'Fill in all fields';
        }


        require_once 'config.session.inc.php';



        if($errors){
            $_SESSION['errors_login'] = $errors;
            header("Location: ../adminlogin.php");
            die();
        }

        //create new session id 
        $newSessionID = session_create_id();
        $sessionID = $newSessionID . "_" . $result['id'];
        session_id($sessionID);

        $_SESSION["user_id"] = $result['id'];
        $_SESSION["user_username"] = htmlspecialchars($result['username']);
        $_SESSION['last'] = time();
        header("Location: ../admin.php?login=success");
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("connection failed:" . $e->getMessage());
    }
}else {
    header("Location: ../adminlogin.php ");
    die();
}