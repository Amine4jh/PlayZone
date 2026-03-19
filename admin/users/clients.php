<?php
require("../../database.php");
// require("../elements/header.php");
require("../elements/header-nav.php");

if (isset($_SESSION["delClient"])) {
    $toastMessage = $_SESSION["delClient"];
    $toastColor = "warning";
    unset($_SESSION["delClient"]);
} elseif (isset($_SESSION["modifyClient"])) {
    $toastMessage = $_SESSION["modifyClient"];
    $toastColor = "info";
    unset($_SESSION["modifyClient"]);
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
                                <h5 class="m-b-10">Clients</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                                <li class="breadcrumb-item" aria-current="page">Clients</li>
                            </ul>
                            <!-- <button class="btn btn-shadow btn-success col-md-2 offset-md-5" id="addBtn" data-bs-toggle="modal" data-bs-target="#exampleModalLive"><strong>Add New Field</strong></button> -->
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
                        $statement = $connect->query("SELECT * FROM utilisateurs WHERE role='client'");
                        $data = $statement->fetchAll(PDO::FETCH_OBJ);
                        foreach ($data as $user) { ?>
                            <tr>
                                <th scope="row"><?= $user->id ?></th>
                                <td><?= htmlspecialchars($user->nom) ?></td>
                                <td><?= $user->email ?></td>
                                <td>
                                    <button id="delete" data-id=<?= $user->id ?> class="btn btn-danger me-3">Delete</button>
                                    <button id="setAdmin" data-id=<?= $user->id ?> class="btn btn-primary ms-3">Set as Admin</button>
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
        const delBtns = document.querySelectorAll("#delete")
        delBtns.forEach(element => {
            element.addEventListener("click", () => {
                let id = element.getAttribute("data-id")
                if (confirm(`Are you sure you want to delete this client?`)) {
                    window.location = `clients-delete.php?id=${id}`
                }
            })
        });

        const modifyBtns = document.querySelectorAll("#setAdmin")
        modifyBtns.forEach(element => {
            element.addEventListener("click", () => {
                let id = element.getAttribute("data-id")
                if (confirm(`Are you sure you want to set this client as an admin?`)) {
                    window.location = `clients-modify.php?id=${id}`
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


<?php require("../elements/footer.php");
