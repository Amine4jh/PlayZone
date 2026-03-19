<?php

require("../../database.php");
require("../elements/auth-check.php");

$field = $_GET["field"];
$date = $_GET["date"];
$hour = $_GET["hour"];

if (!$field || !$date || !$hour) {
    $_SESSION["fail"] = "All fields are required!";
} else {
    $startEnd = explode("-",$hour);
    $status = "en attente";
    $statement = $connect->prepare("INSERT INTO reservation (user_id, terrain_id, date, heure_debut, heure_fin, statut) VALUES (:usid,:terid,:dt,:hd,:hf,:st)");
    $statement->bindParam("usid", $user["id"]);
    $statement->bindParam("terid", $field);
    $statement->bindParam("dt", $date);
    $statement->bindParam("hd", $startEnd[0]);
    $statement->bindParam("hf", $startEnd[1]);
    $statement->bindParam("st", $status);
    $statement->execute();
    $_SESSION["success"] = "Reservation added successfully!";
}
header("Location: new-reservation.php");
