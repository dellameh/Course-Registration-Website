<?php 
require_once 'includes/signup_view.inc.php';
require_once 'includes/config.session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup</title>
    <link rel="stylesheet" href="l&s.css">
</head>
<body>
    <div id="pic"><img src="daneshgah.jpg" alt="عکس دانشگاه"></div>
    <div class="container">
        <div class="form-container">
            <form id="signupForm" action="includes/signup.inc.php" method="post" class="login-form">
                <h2>ثبت نام دانشجو</h2>
                <input type="text" name="username" id="signupUsername" placeholder="شماره دانشجویی">
                <input type="password" name="password" id="signupPassword" placeholder="رمز عبور">
                <input type="password" name="repassword" id="confirmPassword" placeholder="تایید رمز عبور">
                <input type="text" name="email" id="email" placeholder="ایمیل">
                <button>Sign Up</button>
                <p>از قبل حساب کاربری دارید؟ <a href="login.php">ورود</a></p>
            </form>
        </div>
    </div>
    <div class="errors"><?php
    check_signup_errors();
    ?> </div>
    

    <script src="script.js"></script>
</body>
</html>
