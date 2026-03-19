<?php

require("../../database.php");
session_start();
$modifyError = "";

$id = $_GET["id"];
$nom = $_GET["nom"];
$address = $_GET["address"];
$sport = $_GET["sport"];
$valid = true;

if (!$nom || !$address || !$sport) {
    $modifyError = "Please fill in all fields!";
    $valid = false;
}

$statement = $connect->prepare("SELECT id FROM terrains WHERE nom = :nom AND id != :id");
$statement->bindParam("nom", $nom);
$statement->bindParam("id", $id);
$statement->execute();
$data = $statement->fetch();
if ($data) {
    $modifyError = "Sport field is already exist!";
    $valid = false;
}

$statement = $connect->prepare("SELECT id FROM terrains WHERE addresse = :address AND id != :id");
$statement->bindParam("address", $address);
$statement->bindParam("id", $id);
$statement->execute();
$data = $statement->fetch();
if ($data) {
    $modifyError = "Sport field is already exist!";
    $valid = false;
}

if ($valid) {
    $statement = $connect->prepare("UPDATE terrains SET addresse= :address,sport_id= :sport,nom= :nom WHERE id=:id");
    $statement->bindParam("address", $address);
    $statement->bindParam("sport", $sport);
    $statement->bindParam("nom", $nom);
    $statement->bindParam("id", $id);
    $statement->execute();
    header("Location:fields.php");
    $_SESSION["modifyFieldSuccess"] = "Field modified successfully!";
} else {
    header("Location:fields.php");
    $_SESSION["modifyFieldError"] = $modifyError;
}
