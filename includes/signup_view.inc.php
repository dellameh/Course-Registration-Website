<?php 
// view shows the information in websites


function check_signup_errors(){
    if(isset($_SESSION['errors_signup'])){
        $errors = $_SESSION['errors_signup'];
        echo "<br>";
        foreach($errors as $e){
            echo "".$e."<br>";
        }
        unset($_SESSION['errors_signup']);
        //get signup string from url and check it
    }else if(isset($_GET['signup']) && $_GET['signup']==="success"){
        echo '<br>';
        echo '<p class= form-success>sign up success!</p>';
    }
}