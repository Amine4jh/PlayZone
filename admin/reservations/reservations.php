<?php
require("../../database.php");
require("../elements/header-nav.php");

if (isset($_SESSION["confirm"])) {
    $toastMessage = $_SESSION["confirm"];
    $toastColor = "success";
    unset($_SESSION["confirm"]);
} elseif (isset($_SESSION["cancel"])) {
    $toastMessage = $_SESSION["cancel"];
    $toastColor = "danger";
    unset($_SESSION["cancel"]);
}

$sql = "SELECT r.*, u.nom AS user_name, t.nom AS terrain_name FROM reservation r JOIN utilisateurs u ON r.user_id = u.id JOIN terrains t ON r.terrain_id = t.id ORDER BY r.id";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["default"])) {
        $filter = "ORDER BY r.id";
    } elseif (isset($_POST["byUserAsc"])) {
        $filter = "ORDER BY user_name";
    } elseif (isset($_POST["byUserDesc"])) {
        $filter = "ORDER BY user_name DESC";
    } elseif (isset($_POST["byFieldAsc"])) {
        $filter = "ORDER BY terrain_name";
    } elseif (isset($_POST["byFieldDesc"])) {
        $filter = "ORDER BY terrain_name DESC";
    } elseif (isset($_POST["byDateAsc"])) {
        $filter = "ORDER BY date";
    } elseif (isset($_POST["byDateDesc"])) {
        $filter = "ORDER BY date DESC";
    }

    $sql = "SELECT r.*, u.nom AS user_name, t.nom AS terrain_name 
    FROM reservation r 
    JOIN utilisateurs u ON r.user_id = u.id 
    JOIN terrains t ON r.terrain_id = t.id
    $filter";

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
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Reservations</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Other</a></li>
                                <li class="breadcrumb-item" aria-current="page">Reservations</li>
                            </ul>
                            <!-- <button class="btn btn-shadow btn-success col-md-2 offset-md-5" id="addBtn" data-bs-toggle="modal" data-bs-target="#exampleModalLive"><strong>Add New Field</strong></button> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <!-- Filter DropDown -->
            <div class="btn-group-dropdown mt-1 mb-3">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter</button>
                <form class="dropdown-menu dropdown-menu-dark" method="post">
                    <button class="dropdown-item" name="default">By Default</button>
                    <button class="dropdown-item" name="byUserAsc">By User (Ascending)</button>
                    <button class="dropdown-item" name="byUserDesc">By User (Descending)</button>
                    <button class="dropdown-item" name="byFieldAsc">By Fields (Ascending)</button>
                    <button class="dropdown-item" name="byFieldDesc">By Fields (Descending)</button>
                    <button class="dropdown-item" name="byDateAsc">By Date (Ascending)</button>
                    <button class="dropdown-item" name="byDateDesc">By Date (Descending)</button>
                </form>
            </div>

            <!-- Reservs Table -->
            <?php if ($data): ?>
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Client</th>
                        <th scope="col">Sport field</th>
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
                                <td><?= htmlspecialchars($res->user_name) ?></td>
                                <td><?= htmlspecialchars($res->terrain_name) ?></td>
                                <td><?= $res->date ?></td>
                                <td><?= $res->heure_debut ?></td>
                                <td><?= $res->heure_fin ?></td>
                                <td><?= $res->statut ?></td>
                                <td>
                                    <button id="confirm" data-id=<?= $res->id ?> class="btn btn-success me-3" <?= ($res->statut !== "en attente") ? "disabled" : "" ?>>Confirm</button>
                                    <button id="cancel" data-id=<?= $res->id ?> class="btn btn-danger ms-3" <?= ($res->statut !== "en attente") ? "disabled" : "" ?>>Cancel</button>
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

        const confirmBtns = document.querySelectorAll("#confirm")
        confirmBtns.forEach(element => {
            element.addEventListener("click", () => {
                let id = element.getAttribute("data-id")
                if (confirm(`Are you sure you want to confirm that reservation?`)) {
                    window.location = `reservation-confirm.php?id=${id}`
                }
            })
        });

        const cancelBtns = document.querySelectorAll("#cancel")
        cancelBtns.forEach(e => {
            e.addEventListener("click", () => {
                let id = e.getAttribute("data-id")
                if (confirm(`Are you sure you want to cancel that reservation?`)) {
                    window.location = `reservation-cancel.php?id=${id}`
                }
            })
        })
    </script>


<?php require("../elements/footer.php");