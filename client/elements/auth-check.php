<?php
session_start();
if (isset($_SESSION["client"])) {
    $user = $_SESSION["client"];
} else {
    header("Location: ../../index.php");
    exit;
}
