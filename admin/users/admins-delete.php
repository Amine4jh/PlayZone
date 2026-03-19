<?php

require("../../database.php");
session_start();

$id = $_GET['id'];
$user = $_SESSION["user"];
$ifSameUser = false;

if ($id == $user[0]) {
    $ifSameUser = true;
}

$statement = $connect->query("DELETE FROM utilisateurs WHERE id=$id");
$statement->execute();
if ($ifSameUser) {
    header("Location: ../../logout.php");
} else {
    header("Location:admins.php");
    $_SESSION["delAdmin"] = "Admin deleted successfully";
}
