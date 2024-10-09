<?php 
// view shows the information in websites


function check_login_errors(){
    if(isset($_SESSION['errors_login'])){
        $errors = $_SESSION['errors_login'];
        echo "<br>";
        foreach($errors as $e){
            echo "".$e."<br>";
        }
        unset($_SESSION['errors_login']);
        //get signup string from url and check it
    }else if(isset($_GET['login']) && $_GET['login']==="success"){
        echo '<br>';
        echo '<p class= form-success>login success!</p>';
    }
}