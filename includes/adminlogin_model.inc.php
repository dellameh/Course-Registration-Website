<?php

function getUser(object $pdo, string $username){
    $query = "SELECT * FROM user WHERE username = :username AND admin_no=1;";
    //prohibit query injection
    $stmt = $pdo->prepare($query);
    $stmt ->bindParam(":username", $username);
    $stmt -> execute();
    // get associative array
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    return $result;
}
