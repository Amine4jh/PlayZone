<?php

require("../../database.php");
session_start();

$id = $_GET['id'];

$statement = $connect->query("DELETE FROM utilisateurs WHERE id=$id");
$statement->execute();

header("Location:clients.php");
$_SESSION["delClient"] = "Client deleted successfully";
