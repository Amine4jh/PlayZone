<?php
require("../../database.php");
require("../elements/header-nav.php");

$fieldError = "";
$dateError = "";
$startError = "";
$endError = "";
$motifError = "";

if (isset($_SESSION["deleted-ch"])) {
    $toastMessage = $_SESSION["deleted-ch"];
    $toastColor = "info";
    unset($_SESSION["deleted-ch"]);
}

function getData() {
    global $connect;
    $sql = "SELECT dhf.*, t.nom AS terrain_name FROM date_heures_fermees dhf JOIN terrains t ON dhf.terrain_id = t.id";
    $statement = $connect->query($sql);
    $data = $statement->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
$data = getData();

// Add closing hours to db
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addHour"])) {
        $field = $_POST["field"];
        $date = $_POST["date"];
        $start = $_POST["start"];
        $end = $_POST["end"];
        $motif = $_POST["motif"];
        $isValid = true;

        if (!$field || !$date || !$motif) {
            $toastMessage = "All fields are required!";
            $toastColor = "danger";
            $isValid = false;
        }

        if ($isValid) {
            $statement = $connect->prepare("INSERT INTO date_heures_fermees (terrain_id,date,debut_fermeture,fin_fermeture,motif) VALUES (:tid,:dt,:st,:en,:mtf)");
            $statement->bindParam("tid", $field);
            $statement->bindParam("dt", $date);
            $statement->bindParam("st", $start);
            $statement->bindParam("en", $end);
            $statement->bindParam("mtf", $motif);
            $statement->execute();
            $data = getData();
            $toastMessage = "Closing hour added successfully!";
            $toastColor = "success";
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
                                <h5 class="m-b-10">Closing hours</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Management</a></li>
                                <li class="breadcrumb-item" aria-current="page">Closing hours</li>
                            </ul>
                            <button class="btn btn-shadow btn-success col-md-2 offset-md-5" id="addBtn"><strong><?= $data ? "Show" : "Hide" ?> Form</strong></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            
            <!-- Add closing hours form -->
            <div class="col-md-12 <?php if(!$data) echo 'active'; ?>" id="closingHoursForm">
                <div class="card">
                    <div class="card-header">
                        <h4>Add closing hours form</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row g-4 mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select class="form-select" name="field" id="floatingSelect" aria-label="Floating label select example">
                                            <option value="">...</option>
                                            <?php 
                                                $statement = $connect->query("SELECT * FROM terrains ORDER BY nom");
                                                $res = $statement->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($res as $row) {
                                                    echo "<option value='$row->id'>" . htmlspecialchars($row->nom) . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Sport fields</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-0">
                                        <input type="date" name="date" class="form-control" id="floatingInput dateInput" placeholder="Email address" value="<?= date("Y-m-d") ?>" min="<?= date("Y-m-d") ?>" max="2100-12-31">
                                        <label for="floatingInput">Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-0">
                                        <select name="start" class="form-control" id="floatingTextarea">
                                            <!-- Generate with JavaScript -->
                                        </select>
                                        <label for="floatingTextarea">Start time</label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-0">
                                        <select class="form-control" name="end" id="floatingTextarea">
                                            <!-- Generate with JavaScript -->
                                        </select>
                                        <label for="floatingTextarea">End time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-0">
                                        <textarea class="form-control" name="motif" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Reason</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <button name="addHour" class="btn btn-primary p-2 col-md-12"><strong>Add Closing Hours</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Table -->
            <?php 
                if ($data) { ?>
                    <table class="table table-striped table-hover" id="tableContainer">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Terrain</th>
                                <th scope="col">Date</th>
                                <th scope="col">Start</th>
                                <th scope="col">End</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php
                                foreach ($data as $row) { ?>
                                    <tr>
                                        <th scope="row"><?= $row->id ?></th>
                                        <td><?= htmlspecialchars($row->terrain_name) ?></td>
                                        <td><?= $row->date ?></td>
                                        <td><?= $row->debut_fermeture ?></td>
                                        <td><?= $row->fin_fermeture ?></td>
                                        <td><?= htmlspecialchars($row->motif) ?></td>
                                        <td>
                                            <button id="delete" data-id=<?= $row->id ?> class="btn btn-danger me-3">Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
            <?php
                } else {
                    echo '<h5 id="noDataMsg">No closing hours exist!</h5>';
                }
            ?>
            



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
    <!-- [ Main Content ] End -->



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
        const form = document.querySelector("#closingHoursForm")
        const table = document.querySelector("#tableContainer")
        const addBtn = document.querySelector("#addBtn")

        // Form show and hide
        addBtn.addEventListener("click", () => {
            if (!form.classList.contains("active")) {
                addBtn.textContent = "Hide Form";
                form.classList.add("active")
                requestAnimationFrame(() => {
                    form.classList.add("slide-down");
                    form.classList.remove("slide-up");
                    table.style.marginTop = "20px";
                });
            } else {
                addBtn.textContent = "Show Form";
                form.classList.remove("slide-down");
                form.classList.add("slide-up");
                setTimeout(() => {
                    if (form.classList.contains("active")) {
                        form.classList.remove("active")
                    }
                }, 0);
            }
        })

        // Delete Closing hour
        const deleteBtns = document.querySelectorAll("#delete")
        deleteBtns.forEach(element => {
            element.addEventListener("click", () => {
                let id = element.getAttribute("data-id")
                if (confirm(`Are you sure you want to delete this closing hour?`)) {
                    window.location = `closing-hour-delete.php?id=${id}`
                }
            })
        });


        // Start and End Time Select
        document.addEventListener("DOMContentLoaded", () => {
            const dateInput = document.querySelector('input[name="date"]');
            const startSelect = document.querySelector('select[name="start"]');
            const endSelect = document.querySelector('select[name="end"]');

            function generateTimeOptions(selectedDate) {
                const now = new Date();
                const selected = new Date(selectedDate);
                const currentHour = now.getHours();
                const isToday = now.toDateString() === selected.toDateString();

                startSelect.innerHTML = '';
                for (let h = 7; h <= 22; h++) {
                    if (isToday && h <= currentHour) continue;
                    const time = `${String(h).padStart(2, '0')}:00`;
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    startSelect.appendChild(option);
                }

                if (startSelect.options.length > 0) {
                    startSelect.selectedIndex = 0;
                    updateEndTimes(startSelect.value);
                }
            }

            function updateEndTimes(startTime) {
                const [hour, minute] = startTime.split(':').map(Number);
                endSelect.innerHTML = '';

                for (let h = hour + 1; h <= 23; h++) {
                    const time = `${String(h).padStart(2, '0')}:00`;
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    endSelect.appendChild(option);
                }

                if (endSelect.options.length > 0) {
                    endSelect.selectedIndex = 0;
                }
            }

            generateTimeOptions(dateInput.value);

            dateInput.addEventListener('change', () => {
                generateTimeOptions(dateInput.value);
            });

            startSelect.addEventListener('change', () => {
                updateEndTimes(startSelect.value);
            });
        });

    </script>

<?php require("../elements/footer.php");
