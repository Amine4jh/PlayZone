<?php

require("../../database.php");
session_start();

$id = $_GET["id"];

$statement = $connect->query("DELETE FROM date_heures_fermees WHERE id=$id");

header("Location:closing-hours.php");
$_SESSION["deleted-ch"] = "Closing hour deleted successfully!";
