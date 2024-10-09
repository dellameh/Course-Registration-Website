<?php

// get data / submit data / update data / delete data (queries)

function getUsername(object $pdo, string $username){
    $query = "SELECT username FROM user WHERE username = :username;";
    //prohibit query injection
    $stmt = $pdo->prepare($query);
    $stmt ->bindParam(":username", $username);
    $stmt -> execute();
    // get associative array
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getEmail(object $pdo, string $email){
    $query = "SELECT email FROM user WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt ->bindParam(":email", $email);
    $stmt -> execute();
    // get associative array
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo,string $username, string $pass, string $email){
    $query = "INSERT INTO user (username,pass,email,admin_no) VALUES (:username, :pass, :email,0);";
    $stmt = $pdo->prepare($query);

    //prevents hackers to find password with brute forcing
    $options = [
        'cost'=>12
    ];
    $hashedPwd = password_hash($pass,PASSWORD_BCRYPT,$options);

    $stmt ->bindParam(":email", $email);
    $stmt ->bindParam(":pass", $hashedPwd);
    $stmt ->bindParam(":username", $username);
    $stmt -> execute();

}