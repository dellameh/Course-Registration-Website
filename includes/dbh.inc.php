<?php

$host = 'localhost';
$dbname = 'project';
$dbusername = 'root';
$dbpass = '';



try {
    $pdo = new PDO("mysql:host=$host; port=3307 ; dbname=$dbname; charset=utf8", $dbusername, "");
    //enable exception-based error handling.
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("connection failed:" . $e->getMessage());
}