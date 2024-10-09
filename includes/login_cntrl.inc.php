<?php


function isUsernameWrong(bool|array $result){
    if (!$result) {
        return true;
    }else{
        return false;
    }
}

function isPasswordWrong(string $password, string $hashedPwd ){
    if (!password_verify($password,$hashedPwd)) {
        return true;
    }else{
        return false;
    }
}

function isPasswordAdminWrong(string $password, string $Pwd ){
    if ($password != $Pwd) {
        return true;
    }else{
        return false;
    }
}