<?php

require("../../database.php");
session_start();

$id = $_GET["id"];

$statement = $connect->query("DELETE FROM reservation WHERE id=$id");

header("Location:my-reservation.php");
$_SESSION["deleted-res"] = "Reservation deleted successfully!";
