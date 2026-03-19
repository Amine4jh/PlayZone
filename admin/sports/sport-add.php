<?php

require("../../database.php");
session_start();

$errorMsg = "";

function getData() {
    global $connect;
    $sports = [];
    $statement = $connect->query("SELECT id, nom FROM sports");
    $data = $statement->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
$data = getData();

$sportName = $_GET["nom"];
$valid = true;

if (!$sportName) {
    $errorMsg = "Cannot add sport, please write a sport name!";
    $valid = false;
}
foreach ($data as $sport) {
    if ($sportName === $sport->nom) {
        $errorMsg = htmlspecialchars($sportName) . " is already exist";
        $valid = false;
    }
}

if ($valid) {
    $statement = $connect->prepare("INSERT INTO sports (nom) VALUES (:nom)");
    $statement->bindParam("nom", $sportName);
    $statement->execute();
    header("Location:sports.php");
    $_SESSION["add-success"] = htmlspecialchars($sportName) . " added successfully!";
} else {
    header("Location:sports.php");
    $_SESSION["add-error"] = $errorMsg;
}
