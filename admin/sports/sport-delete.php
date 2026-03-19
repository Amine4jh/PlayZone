<?php
require("../../database.php");

@session_start();
$sport_id = $_GET["id"];
$sport_name = $_GET["nom"];

$statement = $connect->query("DELETE FROM sports WHERE id=$sport_id");

header("Location:sports.php");
$_SESSION["deleted-msg"] = htmlspecialchars($sport_name) . " deleted successfully!";
