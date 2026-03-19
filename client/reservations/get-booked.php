<?php

require("../../database.php");

// expands a range like "18:00:00" to "23:00:00" into blocks like "18:00-19:00", "19:00-20:00", ...
function expandHourRange($startTime, $endTime) {
    $startHour = (int)substr($startTime, 0, 2);
    $endHour = (int)substr($endTime, 0, 2);

    $ranges = [];
    for ($hour = $startHour; $hour < $endHour; $hour++) {
        $start = sprintf("%02d:00", $hour);
        $end = sprintf("%02d:00", $hour + 1);
        $ranges[] = "$start-$end";
    }

    return $ranges;
}

if (isset($_GET['date']) && isset($_GET['id'])) {
    $date = $_GET['date'];
    $id = $_GET['id'];
    $booked = [];

    if (!empty($id)) {
        $stmt = $connect->query("SELECT heure_debut, heure_fin FROM reservation WHERE date = '$date' AND terrain_id = $id");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach($data as $row) {
            $start = substr($row['heure_debut'], 0, 5);
            $end = substr($row['heure_fin'], 0, 5);
            $booked[] = "$start-$end";
        }
    
        $stmt = $connect->query("SELECT debut_fermeture, fin_fermeture FROM date_heures_fermees WHERE date = '$date' AND terrain_id = $id");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach($data as $row) {
            $booked = array_merge($booked, expandHourRange($row['debut_fermeture'], $row['fin_fermeture']));
        }
    
    }
    echo json_encode($booked);
}
