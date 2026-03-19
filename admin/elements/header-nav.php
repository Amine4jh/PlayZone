<?php

session_start();
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    header("Location: ../../index.php");
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
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="../dashboard/index.php" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="../../assets/images/PlayZone.png" width="100px" class="img-fluid logo-lg" alt="logo">
      </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item">
            <a href="../dashboard/index.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>
          <li class="pc-item pc-caption">
              <label>Management</label>
              <i class="ti ti-dashboard"></i>
          </li>
          <li class="pc-item">
              <a href="../sports/sports.php" class="pc-link">
                  <span class="pc-micon"><i class="ti ti-ball-football"></i></span>
                  <span class="pc-mtext">Sports</span>
              </a>
          </li>
          <li class="pc-item">
              <a href="../fields/fields.php" class="pc-link">
                  <span class="pc-micon"><i class="ti ti-soccer-field"></i></span>
                  <span class="pc-mtext">Sport Fields</span>
              </a>
          </li>
          <li class="pc-item">
              <a href="../closing-hours/closing-hours.php" class="pc-link">
                  <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                  <span class="pc-mtext">Closing hours</span>
              </a>
          </li>
          <li class="pc-item pc-caption">
              <label>Users</label>
              <i class="ti ti-news"></i>
          </li>
          <li class="pc-item">
              <a href="../users/admins.php" class="pc-link">
                  <span class="pc-micon"><i class="ti ti-lock-access"></i></span>
                  <span class="pc-mtext">Admins</span>
              </a>
          </li>
          <li class="pc-item">
              <a href="../users/clients.php" class="pc-link">
                  <span class="pc-micon"><i class="ti ti-users"></i></span>
                  <span class="pc-mtext">Clients</span>
              </a>
          </li>
          <li class="pc-item pc-caption">
              <label>Other</label>
              <i class="ti ti-brand-chrome"></i>
          </li>
          <li class="pc-item">
              <a href="../reservations/reservations.php" class="pc-link">
                  <span class="pc-micon"><i class="ti ti-files"></i></span>
                  <span class="pc-mtext">Reservations</span>
              </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
<!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ti ti-search"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3">
          <div class="form-group mb-0 d-flex align-items-center">
            <i data-feather="search"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
          </div>
        </form>
      </div>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
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
          <div class="list-group list-group-flush w-100">
          </div>
        </div>
        <p style="text-align:center;">No message yet!</p>
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
            <a href="../profile/edit-profile.php" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Edit Profile</span>
            </a>
            <a href="../profile/view-profile.php" class="dropdown-item">
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
