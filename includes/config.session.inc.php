<?php

//session security
ini_set("session.use_only_cookies",1);
ini_set("session.use_strict_mode",1);

session_set_cookie_params([
    'lifetime'=> 1800,
    'domain'=> 'localhost',
    // all subpaths in localhost are covered
    'path'=> '/',
    //https
    'secure'=> true,
    //user cannot change anything about the cookie
    'httponly'=> true,
]);

session_start();

if (isset($_SESSION["user_id"])) {
    if(!isset($_SESSION['last'])){
        regenerate_session_id_loggedin();
    }else{
        if(time()- $_SESSION['last'] >= (30*60)){
            regenerate_session_id_loggedin();
        }
    }
}else{
    if(!isset($_SESSION['last'])){
        regenerate_session_id();
    }else{
        if(time()- $_SESSION['last'] >= (30*60)){
            regenerate_session_id();
        }
    }
}


function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION['last'] = time();
}

function regenerate_session_id_loggedin(){

    $newID = $_SESSION["user_id"];
    $newSessionID = session_create_id();
    $sessionID = $newSessionID . "_" . $newID;
    session_id($sessionID);
    $_SESSION['last'] = time();
}