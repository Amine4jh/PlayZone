<?php

require("../../database.php");
require("../elements/header-nav.php");

$sportNameError = "";
$sportRenameError = "";

// session_start();
if (isset($_SESSION["deleted-msg"])) {
    $toastMessage = $_SESSION["deleted-msg"];
    $toastColor = "danger";
    unset($_SESSION["deleted-msg"]);
} elseif (isset($_SESSION["rename-error"])) {
    $toastMessage = $_SESSION["rename-error"];
    $toastColor = "warning";
    unset($_SESSION["rename-error"]);
} elseif (isset($_SESSION["rename-success"])) {
    $toastMessage = $_SESSION["rename-success"];
    $toastColor = "info";
    unset($_SESSION["rename-success"]);
} elseif (isset($_SESSION["add-error"])) {
    $toastMessage = $_SESSION["add-error"];
    $toastColor = "danger";
    unset($_SESSION["add-error"]);
} elseif (isset($_SESSION["add-success"])) {
    $toastMessage = $_SESSION["add-success"];
    $toastColor = "success";
    unset($_SESSION["add-success"]);
}

function getData() {
    global $connect;
    $sports = [];
    $statement = $connect->query("SELECT id, nom FROM sports");
    $data = $statement->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
$data = getData();

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
                                <h5 class="m-b-10">Sports</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Management</a></li>
                                <li class="breadcrumb-item" aria-current="page">Sports</li>
                            </ul>
                            <button class="btn btn-shadow btn-success col-md-2 offset-md-6" id="addBtn" data-bs-toggle="modal" data-bs-target="#exampleModalLive"><strong>Add New Sport</strong></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <!-- Add Sport Cards -->
            <div class="row" id="cardContainer">
                <?php
                if ($data) {
                    foreach($data as $sport) {
                        echo "
                            <div class='col-md-4 mb-3'>
                                <div class='card' id='sportCard'>
                                    <h5 class='card-header'>" . htmlspecialchars($sport->nom) . "</h5>
                                    <div class='card-body'>
                                        <button id='rename' data-id='{$sport->id}' class='btn btn-shadow btn-info me-2'><strong>Rename</strong></button>
                                        <button id='delete' data-id='{$sport->id}' class='btn btn-shadow btn-danger'><strong>Delete</strong></button>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo '<h5 class="text-center mt-5 opacity-75">No sport exist</h5>';
                }
                ?>
            </div>
            <!-- End of Cards -->

            <!-- Add Sport Modal (Form in Modal) -->
            <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">Add new sport</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <input type="text" name="sport-name" class="form-control" placeholder="Enter sport name">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><strong>Close</strong></button>
                                <button name="add" class="btn btn-success"><strong>Add Sport</strong></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->

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

            <!-- Rename Sport Modal (Form in Modal) -->
            <div id="renameModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="renameModalLabel">Rename sport</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formRename" action="" method="post">
                            <div class="modal-body">
                                <input type="text" name="sport-rename" class="form-control" placeholder="Edit sport name" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><strong>Close</strong></button>
                                <button name="rename" class="btn btn-info"><strong>Save changes</strong></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->

        </div>
    </div>


    <!-- [ Main Content ] end -->


<!-- Toast shows up -->
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
    const cardContainer = document.querySelector("#cardContainer")
    const deleteBtns = document.querySelectorAll("#delete")
    deleteBtns.forEach(element => {
        element.addEventListener("click", () => {
            let deletedSportName = element.parentElement.previousElementSibling.textContent
            let id = element.getAttribute("data-id")
            if (confirm(`Are you sure you want to delete ${deletedSportName}?`)) {
                window.location = `sport-delete.php?id=${id}&nom=${deletedSportName}`
            }
        })
    });
    
    const renameBtns = document.querySelectorAll("#rename")
    renameBtns.forEach(element => {
        element.addEventListener("click", () => {
            let firstSportName = element.parentElement.previousElementSibling.textContent
            let id = element.getAttribute("data-id")
            const myModal = new bootstrap.Modal(document.getElementById('renameModal'));
            myModal.show();
            const formRename = myModal._element.children[0].children[0].children[1]
            let input = formRename.children[0].children[0]
            input.value = firstSportName
            formRename.addEventListener("submit", (e) => {
                e.preventDefault()
                window.location = `sport-rename.php?id=${id}&nom=${firstSportName}&newnom=${input.value}`
            })
        })
    });

    const addBtn = document.querySelector("#addBtn")
    addBtn.addEventListener("click", () => {
        const myModal = new bootstrap.Modal(document.getElementById('exampleModalLive'));
        myModal.show();
        const formAdd = myModal._element.children[0].children[0].children[1]
        let input = formAdd.children[0].children[0]
        formAdd.addEventListener("submit", (e) => {
            e.preventDefault()
            window.location = `sport-add.php?nom=${input.value}`
        })
    })

</script>



<?php require("../elements/footer.php");
