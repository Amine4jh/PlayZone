<?php

$host = "localhost";
$dbname = "sport_reservation";
$user = "root";
$pwd = "";

try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
} catch (PDOException $e) {
    die("Cannot connect to $dbname because: " . $e->getMessage());
}
