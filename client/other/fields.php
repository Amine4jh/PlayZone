<?php

require("../../database.php");
require("../elements/auth-check.php");



require("../elements/header-nav.php");

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
                                <h5 class="m-b-10">See All Fields</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Other</a></li>
                                <li class="breadcrumb-item" aria-current="page">See All Fields</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <div class="row">





            <?php 
                    $sql = "SELECT t.*, s.nom AS sport_name 
                    FROM terrains t 
                    JOIN sports s ON t.sport_id = s.id 
                    ORDER BY nom";
                    $statement = $connect->query($sql);
                    $data = $statement->fetchAll(PDO::FETCH_OBJ);
                    if ($data) {
                        echo "<h5 class='mb-3'>Recent Fields</h5>";
                        foreach ($data as $row) {
                ?>
                    <div class="col-md-4 col-xl-4">
                        <div class="card mb-3">
                            <img class="img-fluid card-img-top" src="../../assets/images/fields/<?= $row->image ?>" alt="Field image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row->nom) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row->addresse) ?></p>
                            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($row->sport_name) ?></small></p>
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






<?php
require("../elements/footer.php");
