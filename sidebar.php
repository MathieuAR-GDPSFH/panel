<?php
$staff_subcategory = "";

foreach ($staff_permissions as $perm) {
  switch ($perm) {
    case "see_allgdps": {
      $active = "";
      if (isset($active_allgdps)) {
        $active = "active";
      }
      $staff_subcategory = $staff_subcategory."
      <li class='nav-item'>
        <a href='all-gdps.php' class='nav-link ".$active."'>
          <i class='nav-icon fas fa-user-shield'></i>
          <p>All GDPS</p>
        </a>
      </li>
      ";
      break;
    }
    case "see_allusers": {
      $active = "";
      if (isset($active_allusers)) {
        $active = "active";
      }
      $staff_subcategory = $staff_subcategory."
      <li class='nav-item'>
        <a href='all-users.php' class='nav-link ".$active."'>
          <i class='nav-icon fas fa-list'></i>
          <p>All users</p>
        </a>
      </li>
      ";
      break;
    }
  }
}

$staff_category = "
<li class='nav-item menu-closed'>
  <a href='#' class='nav-link'>
    <i class='nav-icon fas fa-hammer'></i>
    <p>
      Staff
      <i class='right fas fa-angle-left'></i>
    </p>
  </a>
  <ul class='nav nav-treeview'>
  ".$staff_subcategory."
  </ul>
</li>
";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GDPSFH</title>
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3257705067704579" crossorigin="anonymous"></script>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="https://cdn3.emoji.gg/emojis/9954-blurple-shield.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">GDPSFH Manager</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $avatar ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $username ?></a>
          <!--<a href="#" class="d-block"><?php #echo $user_name; ?></a> -->
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link <?php if (isset($active_yourservers)) {echo $active_yourservers;} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="create-gdps.php" class="nav-link <?php if (isset($active_creategdps)) {echo $active_creategdps;} ?>">
              <i class="nav-icon fas fa-plus"></i>
              <p>Create a GDPS</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="my-gdps.php" class="nav-link <?php if (isset($active_mygdps)) {echo $active_mygdps;} ?>">
              <i class="nav-icon fas fa-list"></i>
              <p>My GDPS</p>
            </a>
          </li>
          <?php if ($staff_subcategory !== "") { echo $staff_category; } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $page_name; ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>