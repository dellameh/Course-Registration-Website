<?php 
require_once 'includes/login_view.inc.php';
require_once 'includes/config.session.inc.php';
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="l&s.css">
</head>
<body>
    <div id="pic"><img src="daneshgah.jpg" alt="عکس دانشگاه"></div>
    <div id="title"><h1>ورود به سیستم 
        دانشگاه علامه طباطبایی
    </h1></div>
    <div class="container">
        <div class="form-container">
            <form id="adminForm" class="login-form" action="includes/adminlogin.inc.php" method="post" >
                <h2>ورود مدیران</h2>
                <input type="text" name="username" id="adminUsername" placeholder="نام کاربری">
                <input type="password" name= 'password' id="adminPassword" placeholder="رمز عبور">
                <button>Login</button>
            </form>
            
            <div class="login_errors">
                <?php
                    check_login_errors();
                ?> 
            </div>
            <div class="form-toggle">
                <button id="adminBtn"><a href="adminlogin.php">ورود مدیران</a></button>
                <button id="studentBtn"><a href="login.php">ورود دانشجو</a></button>
            </div>
        </div>
    </div>

    <script src="login.js"></script>
</body>
</html>
