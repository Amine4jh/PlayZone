<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Register | PlayZone</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="assets/images/PlayZone_icon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="assets/fonts/feather.css">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="assets/fonts/fontawesome.css">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="assets/fonts/material.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="assets/css/style-preset.css">
    <link rel="stylesheet" href="assets/css/custom-style.css">

</head>
<!-- [Head] end -->

<!-- PHP Start -->
<?php 

require("database.php");

$name = "";
$email = "";

$nameError = "";
$emailError = "";
$pwdError = "";
$cnfPwdError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["name"];
  $email = $_POST["email"];
  $pwd = $_POST["password"];
  $cnfPwd = $_POST["confirm-pwd"];
  $todayDate = date("Y-m-d");
  $av = 'avatar-1.jpg';

  $valid = true;

  if (!$name) {
    $nameError = "This field is required";
    $valid = false;
  } else if (strlen($name) < 3) {
    $nameError = "Name must be at least 3 characters";
    $valid = false;
  }
  if (!$email) {
    $emailError = "This field is required";
    $valid = false;
  } else if (!preg_match("/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/", $email)) {
    $emailError = "This is not a valid email";
    $valid = false;
  }
  if (!$pwd) {
    $pwdError = "This field is required";
    $valid = false;
  } else if (strlen($pwd) < 8) {
    $pwdError = "Password must be at least 8 characters";
    $valid = false;
  }
  if (!$cnfPwd) {
    $cnfPwdError = "This field is required";
    $valid = false;    
  } else if ($cnfPwd !== $pwd) {
    $cnfPwdError = "Passwords not matching";
    $valid = false;
  }

  $stmt = $connect->query("SELECT * FROM utilisateurs");
  $res = $stmt->fetchAll(PDO::FETCH_OBJ);
  foreach ($res as $row) {
    if ($email === $row->email) {
      $emailError = "Email already used from another user";
      $valid = false;
    }
  }

  if ($valid) {
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    $statement = $connect->prepare("INSERT INTO utilisateurs (nom, email, password_hash, role, created_at, avatar) VALUES (:nom,:email,:pwd,'client',:dt,:av)");
    $statement->bindParam("nom", $name);
    $statement->bindParam("email", $email);
    $statement->bindParam("pwd", $hash);
    $statement->bindParam("dt", $todayDate);
    $statement->bindParam("av", $av);
    $statement->execute();
    @session_start();
    $_SESSION['message'] = '<div class="alert alert-success" role="alert">Your account has created successfuly! Please login.</div>';
    header("Location:index.php");
  }
}

?>
<!-- PHP End -->

<!-- [Body] Start -->
<body>
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="auth-header">
          <a href="#"><img src="assets/images/PlayZone.png" width="100px" alt="img"></a>
        </div>
        <form class="card my-5" method="post">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><b>Sign up</b></h3>
              <a href="index.php" class="link-primary">Already have an account?</a>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo $name; ?>">
              <small id="input-error"><?php echo $nameError; ?></small>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Email Address</label>
              <input type="text" name="email" class="form-control" placeholder="Email Address" value="<?php echo $email; ?>">
              <small id="input-error"><?php echo $emailError; ?></small>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Password">
              <small id="input-error"><?php echo $pwdError; ?></small>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Confirm password</label>
              <input type="password" name="confirm-pwd" class="form-control" placeholder="Confirm password">
              <small id="input-error"><?php echo $cnfPwdError; ?></small>
            </div>
            <p class="mt-4 text-sm text-muted">By Signing up, you agree to our <a href="#" class="text-primary"> Terms of Service </a> and <a href="#" class="text-primary"> Privacy Policy</a></p>
            <div class="d-grid mt-3">
              <button class="btn btn-primary">Create Account</button>
            </div>
          </div>
        </form>
        <div class="auth-footer row">
          <!-- <div class=""> -->
            <div class="col my-1">
              <p class="m-0">Copyright &copy; <a href="#">amine4jh</a></p>
            </div>
            <!-- <div class="col-auto my-1">
              <ul class="list-inline footer-link mb-0">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#">Contact us</a></li>
              </ul>
            </div> -->
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>

  
  
  
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
    
</body>
<!-- [Body] end -->

</html>