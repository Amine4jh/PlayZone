<?php

require("../elements/header-nav.php");
require("../../database.php");

$nameError = "";
$addressError = "";
$sportError = "";
$imgError = "";

$name = "";
$addresse = "";
$sport = "";

$photoDir = __DIR__ . '/../../assets/images/fields/';
$allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

if (isset($_SESSION["deleted-field"])) {
    $toastMessage = $_SESSION["deleted-field"];
    $toastColor = "danger";
    unset($_SESSION["deleted-field"]);
} elseif (isset($_SESSION["modifyFieldError"])) {
    $toastMessage = $_SESSION["modifyFieldError"];
    $toastColor = "warning";
    unset($_SESSION["modifyFieldError"]);
} elseif (isset($_SESSION["modifyFieldSuccess"])) {
    $toastMessage = $_SESSION["modifyFieldSuccess"];
    $toastColor = "info";
    unset($_SESSION["modifyFieldSuccess"]);
}

function getData() {
    global $connect;
    $statement = $connect->query("SELECT * FROM terrains");
    $data = $statement->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
$data = getData();

// Add sport field
if (isset($_POST["add"])) {
    $name = $_POST["nom"];
    $addresse = $_POST["addresse"];
    $sport = $_POST["sport"];
    $image = $_FILES["image"];
    $valid = true;

    if (!$name) {
        $nameError = "This field is required";
        $valid = false;
    }
    if (!$addresse) {
        $addressError = "This field is required";
        $valid = false;
    }
    if (!$sport) {
        $sportError = "This field is required";
        $valid = false;
    }
    foreach ($data as $field) {
        if ($name === $field->nom) {
            $nameError = htmlspecialchars($name) . " is already exist";
            $valid = false;
        }
        if ($addresse === $field->addresse) {
            $addressError = "Sport field address is already exist";
            $valid = false;
        }
    }

    $filename = basename($image['name']);
    $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if ($image['error'] !== UPLOAD_ERR_OK) {
        $imgError = "Upload error (code {$image['error']}).";
        $valid = false;
    } elseif (!in_array($fileExt, $allowedImageExtensions)) {
        $imgError = "Invalid file extension.";
        $valid = false;
    }

    if ($valid) {
        if (move_uploaded_file($image['tmp_name'], $photoDir . $filename)) {
            $statement = $connect->prepare("INSERT INTO terrains (addresse, sport_id, nom, image) VALUES (:addresse,:sport,:nom,:img)");
            $statement->bindParam("addresse", $addresse);
            $statement->bindParam("sport", $sport);
            $statement->bindParam("nom", $name);
            $statement->bindParam("img", $filename);
            $statement->execute();
            $data = getData();
            $toastMessage = htmlspecialchars($name) . " added successfully";
            $toastColor = "success";
        } else {
            $imgError = "Can't save uploaded image";
        }
    }
}


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
                                <h5 class="m-b-10">Sport Fields</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Management</a></li>
                                <li class="breadcrumb-item" aria-current="page">Sport Fields</li>
                            </ul>
                            <button class="btn btn-shadow btn-success col-md-2 offset-md-5" id="addBtn" data-bs-toggle="modal" data-bs-target="#exampleModalLive"><strong>Add New Field</strong></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <!-- Add Fields Cards -->
            <div id="cardContainer">
                <?php
                if ($data) {
                    foreach($data as $field) {
                        $statement = $connect->query("SELECT nom FROM sports WHERE id=$field->sport_id");
                        $res = $statement->fetchAll(PDO::FETCH_OBJ);
                        ?>
                        <div class='card overflow-hidden mt-2' id="fieldCard">
                            <div class='row g-0'>
                                <div class='col-md-4'>
                                    <img src='../../assets/images/fields/<?= $field->image ?>' class='img-fluid rounded-md-start'>
                                </div>
                                <div class='col-md-8'>
                                    <div class='card-body'>
                                        <h5 class='card-title'><?= htmlspecialchars($field->nom) ?></h5>
                                        <p class='card-text'>Address: <?= htmlspecialchars($field->addresse) ?></p>
                                        <p class='card-text'><small class='text-muted'><?= htmlspecialchars($res[0]->nom) ?></small></p>
                                    </div>
                                    <div class='card-footer d-flex justify-content-end'>
                                        <button id='rename' data-id='<?= $field->id ?>' class='btn btn-shadow btn-info me-2'><strong>Modify</strong></button>
                                        <button id='delete' data-id='<?= $field->id ?>' class='btn btn-shadow btn-danger'><strong>Delete</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h5 class="text-center mt-5 opacity-75">No field exist</h5>';
                }
                ?>
            </div>
            <!-- End of Cards -->

            <!-- Add Sport Modal (Form in Modal) -->
            <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">Add new field</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="text" name="nom" class="form-control" placeholder="Field name..." value="<?= $name ?>">
                                <small id="input-error"><?= $nameError ?></small>
                                <input type="text" name="addresse" class="form-control mt-3" placeholder="Field address..." value="<?= $addresse ?>">
                                <small id="input-error"><?= $addressError ?></small>
                                <select name="sport" class="form-control mt-3">
                                    <option value="">Choose sport...</option>
                                    <?php 
                                        $statement = $connect->query("SELECT * FROM sports ORDER BY nom");
                                        $results = $statement->fetchAll(PDO::FETCH_OBJ);
                                        foreach($results as $sport) {
                                            echo "<option value='$sport->id'>" . htmlspecialchars($sport->nom) . "</option>";
                                        }
                                        ?>
                                </select>
                                <small id="input-error"><?= $sportError ?></small>
                                <label for="image" id="formLabel">Field image:</label>
                                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
                                <small id="input-error"><?= $imgError ?></small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><strong>Close</strong></button>
                                <button name="add" class="btn btn-success"><strong>Add Field</strong></button>
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

            <!-- Add Sport Modal (Form in Modal) -->
            <div id="renameModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="renameModalLabel">Add new field</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" id="renameForm">
                            <div class="modal-body">
                                <input type="text" name="nom" id="nom" class="form-control" placeholder="Field name...">
                                <input type="text" name="addresse" id="addresse" class="form-control mt-3" placeholder="Field address...">
                                <select name="sport" class="form-control mt-3" id="sport">
                                    <option value="">Choose sport...</option>
                                    <?php 
                                        $statement = $connect->query("SELECT * FROM sports");
                                        $results = $statement->fetchAll(PDO::FETCH_OBJ);
                                        foreach($results as $sport) {
                                            echo "<option value='$sport->id'>" . htmlspecialchars($sport->nom) . "</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><strong>Close</strong></button>
                                <button name="rename" class="btn btn-info"><strong>Save Changes</strong></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->

        </div>
    </div>

<?php if($nameError || $addressError || $sportError || $imgError): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = new bootstrap.Modal(document.getElementById('exampleModalLive'));
            modal.show();
        });
    </script>
<?php endif; ?>

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
    const deleteBtns = document.querySelectorAll("#delete")
    deleteBtns.forEach(element => {
        element.addEventListener("click", () => {
            let id = element.getAttribute("data-id")
            if (confirm(`Are you sure you want to delete that field?`)) {
                window.location = `field-delete.php?id=${id}`
            }
        })
    });

    const renameBtns = document.querySelectorAll("#rename")
    renameBtns.forEach(element => {
        element.addEventListener("click", () => {
            let id = element.getAttribute("data-id")
            const myModal = new bootstrap.Modal(document.getElementById('renameModal'));
            myModal.show();
            let inputNom = document.querySelector("#nom")
            let inputAddress = document.querySelector("#addresse")
            let inputSport = document.querySelector("#sport")
            let form = document.querySelector("#renameForm")
            form.addEventListener("submit", (e) => {
                e.preventDefault()
                window.location = `field-rename.php?id=${id}&nom=${inputNom.value}&address=${inputAddress.value}&sport=${inputSport.value}`
            })
        })
    });
</script>
<?php require("../elements/footer.php");
