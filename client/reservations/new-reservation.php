<?php 

require("../../database.php");
require("../elements/auth-check.php");

if (isset($_SESSION["fail"])) {
    $toastMessage = $_SESSION["fail"];
    $toastColor = "danger";
    unset($_SESSION["fail"]);
} elseif (isset($_SESSION["success"])) {
    $toastMessage = $_SESSION["success"];
    $toastColor = "success";
    unset($_SESSION["success"]);
}

$field_id = $_GET["field_id"] ?? null;
$sport_id = $_GET["sport_id"] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = $_POST["field"];
    $date = $_POST["date"];
    $hour = $_POST["hour"];
    header("Location: add-reserv.php?field=$field&date=$date&hour=$hour");
}

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
                                <h5 class="m-b-10">New Reservation</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Reservations</a></li>
                                <li class="breadcrumb-item" aria-current="page">New Reservation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <div class="col-md-12" id="newReservation">
                <div class="card">
                    <div class="card-header">
                        <h4>Make new reservation</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="sport" id="floatingSelect" aria-label="Floating label select example">
                                            <option value="">...</option>
                                            <?php 
                                                $statement = $connect->query("SELECT * FROM sports ORDER BY nom");
                                                $sports = $statement->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($sports as $sport) {
                                            ?>
                                                <option value='<?= $sport->id ?>' <?= ($sport_id == $sport->id) ? 'selected' : '' ?>><?= htmlspecialchars($sport->nom) ?></option>
                                            <?php 
                                                }
                                            ?>
                                        </select>
                                        <label for="floatingSelect">Sport</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="field" id="floatingSelect" aria-label="Floating label select example">
                                            <option value="">...</option>
                                            <!-- Generate with JavaScript -->
                                        </select>
                                        <label for="floatingSelect">Fields</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-0">
                                        <input type="date" name="date" class="form-control" id="floatingInput" value="<?= date("Y-m-d") ?>" min="<?= date("Y-m-d") ?>" max="2100-12-31">
                                        <label for="floatingInput">Date</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-0">
                                        <select name="hour" class="form-control" id="floatingTextarea">
                                            <!-- Generate with JavaScript -->
                                        </select>
                                        <label for="floatingTextarea">Time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <button name="addHour" class="btn btn-primary p-3 mt-2 col-md-12"><strong>Submit</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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

    // Get sport field depends on selected sport
    const sportId = "<?= $sport_id ?>";
    const fieldId = "<?= $field_id ?>";

    const fieldSelect = document.querySelector('select[name="field"]');
    const sportSelect = document.querySelector('select[name="sport"]');

    // Fetch and populate fields for a sport
    function loadFieldsForSport(sportId, preselectFieldId = null) {
        fetch("get-fields.php?sport_id=" + sportId)
            .then(response => response.json())
            .then(data => {
                fieldSelect.innerHTML = '<option value="">...</option>';

                data.forEach(field => {
                    const option = document.createElement("option");
                    option.value = field.id;
                    option.textContent = field.nom;
                    // Preselect the correct field if matched
                    if (field.id == preselectFieldId) {
                        option.selected = true;
                    }

                    fieldSelect.appendChild(option);
                });
            });
    }
    // When change sport
    sportSelect.addEventListener("change", function () {
        const selectedSportId = this.value;
        if (selectedSportId) {
            loadFieldsForSport(selectedSportId);
        } else {
            fieldSelect.innerHTML = '<option value="">...</option>';
        }
    });
    // If URL has sport & field
    if (sportId) {
        loadFieldsForSport(sportId, fieldId);
    }


    // Get hours depends on selected date
    const timeSelect = document.querySelector("select[name='hour']");
    const datePicker = document.querySelector("input[name='date']");

    async function updateTimeOptions() {
        const selectedDate = datePicker.value;
        const now = new Date();
        const booked = await fetchBookedTimes(selectedDate);

        timeSelect.innerHTML = "<option value=''>...</option>";

        for (let hour = 7; hour < 23; hour++) {
            const start = hour.toString().padStart(2, "0") + ":00";
            const end = (hour + 1).toString().padStart(2, "0") + ":00";
            const range = `${start}-${end}`;

            const option = document.createElement("option");
            option.value = range;
            option.textContent = `${start} - ${end}`;

            const rangeDateTime = new Date(selectedDate);
            rangeDateTime.setHours(hour, 0, 0, 0);

            // Disable if in the past (for today) or already booked
            if (
                (new Date(selectedDate).toDateString() === now.toDateString() && rangeDateTime <= now) ||
                booked.includes(range)
            ) {
                option.disabled = true;
            }

            timeSelect.appendChild(option);
        }
    }

    async function fetchBookedTimes(date) {
        try {
            const res = await fetch(`get-booked.php?date=${date}&id=${fieldSelect.value}`);
            const data = await res.json(); // ["10:00-11:00", "14:00-15:00"]
            return data;
        } catch (error) {
            console.error("Error fetching booked times:", error);
            return [];
        }
    }

    datePicker.addEventListener("change", updateTimeOptions);
    fieldSelect.addEventListener("change", updateTimeOptions);
    updateTimeOptions()

</script>


        </div>
    </div>

<?php
require("../elements/footer.php");
