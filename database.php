<?php

$env = parse_ini_file('.env');
$host = $env["DB_HOST"];
$dbname = $env["DB_NAME"];
$user = $env["DB_USER"];
$pwd = $env["DB_PASS"];
// $port = $env["DB_PORT"] ?: 5432;

try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
} catch (PDOException $e) {
    die("Cannot connect to $dbname because: " . $e->getMessage());
}
