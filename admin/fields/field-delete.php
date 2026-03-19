<?php

require("../../database.php");
session_start();

$id = $_GET["id"];

$statement = $connect->query("DELETE FROM terrains WHERE id=$id");

header("Location:fields.php");
$_SESSION["deleted-field"] = "Field deleted successfully!";
