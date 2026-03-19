<?php

require("../../database.php");

if (isset($_GET['sport_id'])) {
    $sportId = $_GET['sport_id'];

    $stmt = $connect->query("SELECT id, nom FROM terrains WHERE sport_id = $sportId");
    $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($fields);
}

if (isset($_GET['field_id'])) {
    $fieldId = $_GET['field_id'];

    $stmt = $connect->query("SELECT s.id AS sport_id FROM terrains t JOIN sports s ON t.sport_id = s.id WHERE t.id = $fieldId");
    $sport = $stmt->fetch();
    $sport_id = $sport["sport_id"];

    header("Location: new-reservation.php?field_id=$fieldId&sport_id=$sport_id");
}
