<?php
require("../elements/header-nav.php");
// require("../elements/header.php");
require("../../database.php");

if (isset($_SESSION["delAdmin"])) {
    $toastMessage = $_SESSION["delAdmin"];
    $toastColor = "warning";
    unset($_SESSION["delAdmin"]);
} elseif (isset($_SESSION["modifyAdmin"])) {
    $toastMessage = $_SESSION["modifyAdmin"];
    $toastColor = "info";
    unset($_SESSION["modifyAdmin"]);
}

// require("../elements/nav.php");
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
                                <h5 class="m-b-10">Admins</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                                <li class="breadcrumb-item" aria-current="page">Admins</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                        $statement = $connect->query("SELECT * FROM utilisateurs WHERE role='admin'");
                        $data = $statement->fetchAll(PDO::FETCH_OBJ);
                        foreach ($data as $user) { ?>
                            <tr>
                                <th scope="row"><?= $user->id ?></th>
                                <td><?= htmlspecialchars($user->nom) ?></td>
                                <td><?= $user->email ?></td>
                                <td>
                                    <button id="delAdmin" data-id=<?= $user->id ?> class="btn btn-danger me-3" <?= count($data) === 1 ? "disabled" : "" ?>>Delete</button>
                                    <button id="setClient" data-id=<?= $user->id ?> class="btn btn-primary ms-3" <?= count($data) === 1 ? "disabled" : "" ?>>Set as Client</button>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
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




    <script>
        const delBtns = document.querySelectorAll("#delAdmin")
        delBtns.forEach(element => {
            element.addEventListener("click", () => {
                let id = element.getAttribute("data-id")
                if (confirm(`Are you sure you want to delete this admin?`)) {
                    window.location = `admins-delete.php?id=${id}`
                }
            })
        });

        const modifyBtns = document.querySelectorAll("#setClient")
        modifyBtns.forEach(element => {
            element.addEventListener("click", () => {
                let id = element.getAttribute("data-id")
                if (confirm(`Are you sure you want to set this admin as a client?`)) {
                    window.location = `admins-modify.php?id=${id}`
                }
            })
        });


   </script> 

<?php if (!empty($toastMessage)): ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
  });
</script>
<?php endif; ?>


<?php require("../elements/footer.php"); ?>
