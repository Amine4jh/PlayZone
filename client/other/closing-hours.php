<?php

require("../../database.php");
require("../elements/auth-check.php");

$sql = "SELECT dhf.*, t.nom AS terrain_name
        FROM date_heures_fermees dhf
        JOIN terrains t ON dhf.terrain_id = t.id";
$statement = $connect->query($sql);
$data = $statement->fetchAll(PDO::FETCH_OBJ);

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
                                <h5 class="m-b-10">Closing Hours</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Other</a></li>
                                <li class="breadcrumb-item" aria-current="page">Closing Hours</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <?php if ($data): ?>
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Field</th>
                        <th scope="col">Date</th>
                        <th scope="col">Start time</th>
                        <th scope="col">End time</th>
                        <th scope="col">Reason</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        foreach ($data as $res) { ?>
                            <tr>
                                <th scope="row"><?= $res->id ?></th>
                                <td><?= htmlspecialchars($res->terrain_name) ?></td>
                                <td><?= $res->date ?></td>
                                <td><?= $res->debut_fermeture ?></td>
                                <td><?= $res->fin_fermeture ?></td>
                                <td><?= htmlspecialchars($res->motif) ?></td>
                            </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php else: ?>
                <h5 class="text-center mt-5 opacity-75">No closing hour exist</h5>
            <?php endif; ?>
            <!-- [ Main Content ] End -->


        </div>
    </div>






<?php
require("../elements/footer.php");
