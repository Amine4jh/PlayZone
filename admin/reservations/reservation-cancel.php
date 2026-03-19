<?php

session_start();
require("../../database.php");

$id = $_GET["id"];

$statement = $connect->query("UPDATE reservation SET statut='annulée' WHERE id=$id");
$statement->execute();

header("Location:reservations.php");
$_SESSION["confirm"] = "Reservation canceled successfully!";
