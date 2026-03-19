<?php

require("../../database.php");
require("../elements/auth-check.php");
require("../elements/header-nav.php");

if (isset($_SESSION["deleted-res"])) {
    $toastMessage = $_SESSION["deleted-res"];
    $toastColor = "danger";
    unset($_SESSION["deleted-res"]);
}

$sort = "";
$filter = "";

$sql = "SELECT r.*, t.nom AS terrain_name, s.nom AS sport_name
FROM reservation r 
JOIN terrains t ON r.terrain_id = t.id 
JOIN sports s ON t.sport_id = s.id
WHERE user_id = $user[id]
ORDER BY r.id";

if (isset($_GET["filter"])) {
    $filter = $_GET["filter"];

    $sql = "SELECT r.*, t.nom AS terrain_name, s.nom AS sport_name
    FROM reservation r 
    JOIN terrains t ON r.terrain_id = t.id 
    JOIN sports s ON t.sport_id = s.id
    WHERE user_id = $user[id] $filter
    $sort";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["default"])) {
        $sort = "ORDER BY r.id";
    } elseif (isset($_POST["byFieldAsc"])) {
        $sort = "ORDER BY terrain_name";
    } elseif (isset($_POST["byFieldDesc"])) {
        $sort = "ORDER BY terrain_name DESC";
    } elseif (isset($_POST["byDateAsc"])) {
        $sort = "ORDER BY date";
    } elseif (isset($_POST["byDateDesc"])) {
        $sort = "ORDER BY date DESC";
    }

    $sql = "SELECT r.*, t.nom AS terrain_name, s.nom AS sport_name
    FROM reservation r 
    JOIN terrains t ON r.terrain_id = t.id 
    JOIN sports s ON t.sport_id = s.id
    WHERE user_id = $user[id] $filter
    $sort";


}

$statement = $connect->query($sql);
$data = $statement->fetchAll(PDO::FETCH_OBJ);

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
                                <h5 class="m-b-10">My Reservations</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Reservations</a></li>
                                <li class="breadcrumb-item" aria-current="page">My Reservations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            
            <!-- Reservations Table -->
            <?php if ($data): ?>
                <!-- Filter DropDown -->
                <div class="btn-group-dropdown mt-1 mb-3">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort by</button>
                    <form class="dropdown-menu dropdown-menu-dark" method="post">
                        <button class="dropdown-item" name="default">Default</button>
                        <button class="dropdown-item" name="byFieldAsc">By Fields (A-Z)</button>
                        <button class="dropdown-item" name="byFieldDesc">By Fields (Z-A)</button>
                        <button class="dropdown-item" name="byDateAsc">By Date (Ascending)</button>
                        <button class="dropdown-item" name="byDateDesc">By Date (Descending)</button>
                    </form>
                </div>
                <div class="btn-group-dropdown mt-1 mb-3">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter by sport</button>
                    <div class="dropdown-menu dropdown-menu-dark" method="post">
                        <a class="dropdown-item" href="filter-sport.php?nom=all">All</a>
                        <?php 
                            $query = "SELECT r.*, t.nom AS terrain_name, s.nom AS sport_name
                                    FROM reservation r 
                                    JOIN terrains t ON r.terrain_id = t.id 
                                    JOIN sports s ON t.sport_id = s.id
                                    WHERE user_id = $user[id]";
                            $stmt = $connect->query($query);
                            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                            $sports = [];
                            foreach ($results as $row) {
                                $sports[] = $row->sport_name;
                                array_unique($sports);
                            }
                            foreach (array_unique($sports) as $sport) {
                        ?>
                            <a class="dropdown-item" href="filter-sport.php?nom=<?= htmlspecialchars($sport) ?>"><?= htmlspecialchars($sport) ?></a>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client</th>
                        <th scope="col">Sport</th>
                        <th scope="col">Field</th>
                        <th scope="col">Date</th>
                        <th scope="col">Start hour</th>
                        <th scope="col">End hour</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        foreach ($data as $res) { ?>
                            <tr>
                                <th scope="row"><?= $res->id ?></th>
                                <td><?= $user["nom"] ?></td>
                                <td><?= htmlspecialchars($res->sport_name) ?></td>
                                <td><?= htmlspecialchars($res->terrain_name) ?></td>
                                <td><?= $res->date ?></td>
                                <td><?= $res->heure_debut ?></td>
                                <td><?= $res->heure_fin ?></td>
                                <td><?= $res->statut ?></td>
                                <td>
                                    <button id="delete" data-id=<?= $res->id ?> class="btn btn-danger ms-3" <?= ($res->statut !== "en attente") ? "disabled" : "" ?>>Delete</button>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php else: ?>
                <h5 class="text-center mt-5 opacity-75">No reservation exist</h5>
            <?php endif; ?>
            <!-- [ Main Content ] End -->


            <!-- BS Toast after Add Sport -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast text-white bg-<?= $toastColor ?? "" ?> fade" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= $toastMessage ?? "" ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <!-- End of Toast -->

        </div>
    </div>


    <?php if (!empty($toastMessage)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    <?php endif; ?>

<script>
    // delete reservation
    const deleteBtns = document.querySelectorAll("#delete")
    deleteBtns.forEach(element => {
        element.addEventListener("click", () => {
            let id = element.getAttribute("data-id")
            if (confirm(`Are you sure you want to delete this reservation?`)) {
                window.location = `delete-reserv.php?id=${id}`
            }
        })
    });
</script>


<?php
require("../elements/footer.php");
