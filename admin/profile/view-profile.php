<?php

session_start();
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    header("Location: ../../index.php");
}
if (isset($_SESSION["edit-profile"])) {
    $toastMessage = $_SESSION["edit-profile"];
    $toastColor = "success";
    unset($_SESSION["edit-profile"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>PlayZone</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="../../assets/images/PlayZone_icon.png" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../../assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../../assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../../assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../../assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../../assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../../assets/css/style-preset.css" >
<link rel="stylesheet" href="../../assets/css/custom-style.css" >

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
<nav class="pc-sidebar pc-trigger pc-sidebar-hide"></nav>
<!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper">
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <a href="../dashboard/index.php" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="../../assets/images/PlayZone.png" width="100px" class="img-fluid logo-lg" alt="logo">
    </a>
  </ul>
</div>
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ti ti-mail"></i>
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
          <h5 class="m-0">Message</h5>
          <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-x text-danger"></i></a>
        </div>
        <div class="dropdown-divider"></div>
        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
          <p style="text-align:center;">No message yet!</p>
        </div>
      </div>
    </li>
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <img src="../../assets/images/user/<?= $user[3] ?>" alt="user-image" class="user-avtar">
        <span><?= $user[1] ?></span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../../assets/images/user/<?= $user[3] ?>" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1"><?= $user[1] ?></h6>
              <span><?= $user[2] ?></span>
            </div>
          </div>
        </div>
        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="drp-t1"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-1"
              type="button"
              role="tab"
              aria-controls="drp-tab-1"
              aria-selected="true"
              ><i class="ti ti-user"></i> Profile</button
            >
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="drp-t2"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-2"
              type="button"
              role="tab"
              aria-controls="drp-tab-2"
              aria-selected="false"
              ><i class="ti ti-settings"></i> Setting</button
            >
          </li>
        </ul>
        <div class="tab-content" id="mysrpTabContent">
          <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
            <a href="edit-profile.php" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Edit Profile</span>
            </a>
            <a href="view-profile.php" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>View Profile</span>
            </a>
            <a href="../../logout.php" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
          </div>
          <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
            <a href="#!" class="dropdown-item">
              <i class="ti ti-help"></i>
              <span>Support</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>Account Settings</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-lock"></i>
              <span>Privacy Center</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-messages"></i>
              <span>Feedback</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-list"></i>
              <span>History</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10" style="font-size: 28px;">Your Profile</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->


            <div id="card-container">
                <div class="position-relative" id="card">
                    <div id="image">
                        <img src="../../assets/images/user/<?= $user[3] ?>" alt="profile">
                    </div>
                    <h1><?= $user[1] ?></h1>
                    <h3><?= $user[2] ?></h3>
                    <div id="social">
                        <a href="https://github.com/Amine4jh" target="_blank"><i class="ti ti-brand-github"></i></a>
                        <a href="https://x.com/amine4jh" target="_blank"><i class="ti ti-brand-twitter"></i></a>
                        <a href="" target="_blank"><i class="ti ti-brand-discord"></i></a>
                        <a href="https://www.linkedin.com/in/amineajaha/" target="_blank"><i class="ti ti-brand-linkedin"></i></a>
                    </div>
                    <a href="edit-profile.php" id="edit" class="position-absolute top-0 start-100 translate-middle rounded-circle">
                        <i class="ti ti-edit"></i>
                    </a>
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

        </div>
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col-sm my-1">
                    <p class="m-0">
                        &copy; <?= date('Y') ?> PlayZone. Built by <a href="https://github.com/Amine4jh" target="_blank">Amine4jh</a>.
                    </p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0" id="footer-social-links">
                        <li class="list-inline-item"><a href="https://github.com/Amine4jh" target="_blank"><i class="ti ti-brand-github"></i></a></li>
                        <li class="list-inline-item"><a href="https://x.com/amine4jh" target="_blank"><i class="ti ti-brand-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.linkedin.com/in/amineajaha/" target="_blank"><i class="ti ti-brand-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <?php if (!empty($toastMessage)): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
    </script>
    <?php endif; ?>

    <!-- [Page Specific JS] start -->
    <script src="../../assets/js/plugins/apexcharts.min.js"></script>
    <script src="../../assets/js/pages/dashboard-default.js"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="../../assets/js/plugins/popper.min.js"></script>
    <script src="../../assets/js/plugins/simplebar.min.js"></script>
    <script src="../../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../../assets/js/fonts/custom-font.js"></script>
    <script src="../../assets/js/pcoded.js"></script>
    <script src="../../assets/js/plugins/feather.min.js"></script>





    <script>
    layout_change('light');
    </script>




    <script>
    change_box_container('false');
    </script>



    <script>
    layout_rtl_change('false');
    </script>


    <script>
    preset_change("preset-1");
    </script>


    <script>
    font_change("Public-Sans");
    </script>



</body>
<!-- [Body] end -->

</html>

    