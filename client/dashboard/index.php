<?php 

require("../../database.php");
require("../elements/auth-check.php");
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
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li> -->
                                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-md-6 col-xl-6">
                <?php
                        $statement = $connect->query("SELECT * FROM reservation WHERE user_id = $user[id]");
                        $totalRes = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM reservation WHERE user_id = $user[id] AND date < '$monthStart'");
                        $oldRes = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM reservation WHERE user_id = $user[id] AND date >= '$monthStart'");
                        $newRes = $statement->fetchAll(PDO::FETCH_OBJ);

                        $results = calcRate(count($newRes), count($oldRes));
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">My reservations</h6>
                            <h4 class="mb-3"><?= count($totalRes) ?> <span class="badge bg-light-<?= $results["color"] ?> border border-<?= $results["color"] ?>"><i
                                        class="ti ti-<?= $results["icon"] ?>"></i> <?= $results["rate"] ?>%</span></h4>
                            <p class="mb-0 text-muted text-sm">You made an extra <span class="text-<?= $results["color"] ?>"><?= count($newRes) ?></span>
                                this month</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <?php
                        $statement = $connect->query("SELECT * FROM reservation WHERE user_id = $user[id] AND statut = 'confirmée'");
                        $totalCnfrm = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM reservation WHERE user_id = $user[id] AND statut = 'confirmée' AND date < '$monthStart'");
                        $oldCnfrm = $statement->fetchAll(PDO::FETCH_OBJ);

                        $statement = $connect->query("SELECT * FROM reservation WHERE user_id = $user[id] AND statut = 'confirmée' AND date >= '$monthStart'");
                        $newCnfrm = $statement->fetchAll(PDO::FETCH_OBJ);

                        $results = calcRate(count($newCnfrm), count($oldCnfrm));
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Confirmed reservations</h6>
                            <h4 class="mb-3"><?= count($totalCnfrm) ?> <span class="badge bg-light-<?= $results["color"] ?> border border-<?= $results["color"] ?>"><i
                                        class="ti ti-<?= $results["icon"] ?>"></i> <?= $results["rate"] ?>%</span></h4>
                            <p class="mb-0 text-muted text-sm">You made an extra <span class="text-<?= $results["color"] ?>"><?= count($newCnfrm) ?></span>
                                this month</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12">
                    <h5 class="mb-3">My Recent Reservations</h5>
                    <?php
                        $sql = "SELECT r.*, u.nom AS user_name, t.nom AS terrain_name 
                        FROM reservation r 
                        JOIN utilisateurs u ON r.user_id = u.id
                        JOIN terrains t ON r.terrain_id = t.id 
                        WHERE user_id = $user[id]
                        ORDER BY r.id DESC 
                        LIMIT 5";

                        $statement = $connect->query($sql);
                        $data = $statement->fetchAll(PDO::FETCH_OBJ);
                        if ($data) {
                    ?>
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
                    <?php } else { ?>
                        <div id="no-reserv">
                            <h5>There is 0 reservations, click the button to make one:</h5>
                            <!-- Add link here -->
                            <button class="btn btn-primary"><a href="../reservations/new-reservation.php">Make Reservation</a></button>
                        </div>
                    <?php } ?>
                </div>

                <?php 
                    $sql = "SELECT t.*, s.nom AS sport_name 
                    FROM terrains t 
                    JOIN sports s ON t.sport_id = s.id 
                    ORDER BY t.id DESC 
                    LIMIT 3";
                    $statement = $connect->query($sql);
                    $data = $statement->fetchAll(PDO::FETCH_OBJ);
                    if ($data) {
                        echo "<h5 class='mb-3'>Recent Fields</h5>";
                        foreach ($data as $row) {
                ?>
                    <div class="col-md-4 col-xl-4">
                        <div class="card mb-3">
                            <img class="img-fluid card-img-top" src="../../assets/images/fields/<?= $row->image ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row->nom) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row->addresse) ?></p>
                            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($row->sport_name)?></small></p>
                            <button class="btn btn-success"><a id="resLink" href="../reservations/get-fields.php?field_id=<?= $row->id ?>">Reserve</a></button>    
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

<?php require("../elements/footer.php") ?>
