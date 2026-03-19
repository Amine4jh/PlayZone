<?php

require("../../database.php");

$sport = $_GET["nom"];

if ($sport === "all") {
    $filter = "";
} else {
    $filter = "AND s.nom = '$sport'";
}
header("Location: my-reservation.php?filter=$filter");
