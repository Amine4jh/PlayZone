<?php

require("../../database.php");
require("../elements/header-nav.php"); 

$monthStart = date("Y-m-01");

function calcRate($new, $old) {
    if ($old !== 0 && $new !== 0) {
        $rate = (($new - $old) / $old) * 100;
        if ($rate > 0) {
            $color = "success";
            $icon = "trending-up";
        } else {
            $color = "danger";
            $icon = "trending-down";
        }
    } elseif ($old === 0 && $new !== 0) {
        $rate = 100;
        $color = "success";
        $icon = "trending-up";
    } else {
        $rate = 0;
        $color = "secondary";
        $icon = "minus";
    }

    $calcResults = [
        "new" => $new,
        "old" => $old,
        "rate" => $rate,
        "color" => $color,
        "icon" => $icon
    ];

    return $calcResults;
}

?>
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Home</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
             
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-6 col-xl-6">
                <?php
                        $statement = $connect->query("SELECT * FROM utilisateurs WHERE role = 'client'");
                        $totalUsers = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM utilisateurs WHERE role = 'client' AND created_at < '$monthStart'");
                        $oldUsers = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM utilisateurs WHERE role = 'client' AND created_at >= '$monthStart'");
                        $newUsers = $statement->fetchAll(PDO::FETCH_OBJ);

                        $results = calcRate(count($newUsers), count($oldUsers));
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Clients</h6>
                            <h4 class="mb-3"><?= count($totalUsers) ?> <span class="badge bg-light-<?= $results["color"] ?> border border-<?= $results["color"] ?>"><i
                                        class="ti ti-<?= $results["icon"] ?>"></i> <?= $results["rate"] ?>%</span></h4>
                            <p class="mb-0 text-muted text-sm">You made an extra <span class="text-<?= $results["color"] ?>"><?= count($newUsers) ?></span>
                                this month</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <!-- Calc Reservations -->
                    <?php
                        $statement = $connect->query("SELECT * FROM reservation");
                        $totalReservs = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM reservation WHERE date < '$monthStart'");
                        $oldReservs = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM reservation WHERE date >= '$monthStart'");
                        $newReservs = $statement->fetchAll(PDO::FETCH_OBJ);

                        $results = calcRate(count($newReservs), count($oldReservs));
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Reservations</h6>
                            <h4 class="mb-3"><?= count($totalReservs) ?> <span class="badge bg-light-<?= $results["color"] ?> border border-<?= $results["color"] ?>"><i
                                        class="ti ti-<?= $results["icon"] ?>"></i> <?= $results["rate"] ?>%</span></h4>
                            <p class="mb-0 text-muted text-sm">You made an extra <span class="text-<?= $results["color"] ?>"><?= count($newReservs) ?></span>
                                this month</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12">
                    <h5 class="mb-3">Recent Reservations</h5>
                    <div class="card tbl-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CLIENT NAME</th>
                                            <th>FIELD NAME</th>
                                            <th>DATE</th>
                                            <th>START HOUR</th>
                                            <th>END HOUR</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = "SELECT r.*, u.nom AS user_name, t.nom AS terrain_name 
                                            FROM reservation r 
                                            JOIN utilisateurs u ON r.user_id = u.id
                                            JOIN terrains t ON r.terrain_id = t.id 
                                            ORDER BY r.id DESC 
                                            LIMIT 10";

                                            $statement = $connect->query($sql);
                                            $data = $statement->fetchAll(PDO::FETCH_OBJ);
                                            
                                            foreach ($data as $row) {
                                                if ($row->statut === "en attente") {
                                                    $c = "warning";
                                                } elseif ($row->statut === "confirmée") {
                                                    $c = "success";
                                                } else {
                                                    $c = "danger";
                                                }
                                        ?>
                                            <tr>
                                                <td class="text-muted"><?= $row->id ?></td>
                                                <td><?= htmlspecialchars($row->user_name) ?></td>
                                                <td><?= htmlspecialchars($row->terrain_name) ?></td>
                                                <td><?= $row->date ?></td>
                                                <td><?= $row->heure_debut ?></td>
                                                <td><?= $row->heure_fin ?></td>
                                                <td><span class="d-flex align-items-center gap-2"><i
                                                            class="fas fa-circle text-<?= $c ?> f-10 m-r-5"></i><?= $row->statut ?></span>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

<?php require("../elements/footer.php") ?>
