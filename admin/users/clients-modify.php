<?php

require("../../database.php");
session_start();

$id = $_GET['id'];

$statement = $connect->query("UPDATE utilisateurs SET role='admin' WHERE id=$id");
$statement->execute();

header("Location:clients.php");
$_SESSION["modifyClient"] = "Client modified successfully";
