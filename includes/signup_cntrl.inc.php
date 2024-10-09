<?php

// get user info and interact with model file functions

function isInputEmpty(string $username, string $password, string $repassword, string $email)
{
    if (empty($username) || empty($password) || empty($repassword) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function isEmailInvalid(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function isUsernameTaken(object $pdo, string $username)
{
    if (getUsername($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email)
{
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function wrongRePassword($password , $repassword){
    if ($password != $repassword) {
        return true;
    } else {
        return false;
    }
}

function createUser(object $pdo,string $username, string $password, string $email ){
    set_user($pdo, $username, $password, $email);
}