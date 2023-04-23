<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GDPSFH</title>
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3257705067704579" crossorigin="anonymous"></script>

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../dist/css/custom-table.css">
  <script src="https://kit.fontawesome.com/d7316527b7.js" crossorigin="anonymous"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="https://cdn3.emoji.gg/emojis/9954-blurple-shield.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">GDPSFH Manager</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://upload.wikimedia.org/wikipedia/en/thumb/3/35/Geometry_Dash_Logo.PNG/250px-Geometry_Dash_Logo.PNG" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $gdps_name; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" onclick="window.location='/gdps/index.php'+window.location.search;" class="nav-link <?php if (isset($active_gdpsdashboard)) {echo $active_gdpsdashboard;} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" onclick="window.location='/gdps/management.php'+window.location.search;" class="nav-link <?php if (isset($active_management)) {echo $active_management;} ?>">
              <i class="nav-icon fas fa-lock"></i>
              <p>GDPS Management</p>
            </a>
          </li>
          <!-- onclick="window.location='/gdps/levels.php'+window.location.search;" -->
          <li class="nav-item">
            <a href="#" class="nav-link <?php if (isset($active_levels)) {echo $active_levels;} ?>" onclick="notImpYet()">
              <i class="nav-icon fas fa-list"></i>
              <p>Levels</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="notImpYet()">
              <i class="nav-icon fas fa-cubes"></i>
              <p>Map packs</p>
            </a>
          </li>
          <li class="nav-item" onclick="notImpYet()">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-trophy"></i>
              <p>Gauntlets</p>
            </a>
          </li>
          <li class="nav-item" onclick="notImpYet()">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-check"></i>
              <p>Quests</p>
            </a>
          </li>
          <li class="nav-item" onclick="notImpYet()">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" onclick="window.location='/gdps/levelReupload.php'+window.location.search;" class="nav-link <?php if (isset($active_levelReupload)) {echo $active_levelReupload;} ?>">
              <i class="nav-icon fas fa-upload"></i>
              <p>Level Reupload</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" onclick="window.location='/gdps/mainLevels.php'+window.location.search;" class="nav-link <?php if (isset($active_mainLevels)) {echo $active_mainLevels;} ?>">
              <i class="nav-icon fas fa-play"></i>
              <p>Main Levels</p>
            </a>
          </li>
          <li class="nav-item menu-<?php if (isset($active_gdpsmoderators) || isset($active_rateNotifications)) {echo "open";} else {echo "closed";} ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hammer"></i>
              <p>
                Moderation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" onclick="window.location='/gdps/moderators.php'+window.location.search;" class="nav-link <?php if (isset($active_gdpsmoderators)) {echo $active_gdpsmoderators;} ?>">
                  <i class="nav-icon fas fa-user-shield"></i>
                  <p>Moderators / Roles</p>
                </a>
              </li>
              <li class="nav-item" onclick="notImpYet()">
                <a href="#" class="nav-link <?php if (isset($active_createserver)) {echo $active_createserver;} ?>">
                  <i class="nav-icon fas fa-user-check"></i>
                  <p>Mod actions</p>
                </a>
              </li>
              <li class="nav-item" onclick="notImpYet()">
                <a href="#" class="nav-link <?php if (isset($active_createserver)) {echo $active_createserver;} ?>">
                  <i class="nav-icon fas fa-clock"></i>
                  <p>Levels sent</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" onclick="window.location='/gdps/rateNotifications.php'+window.location.search;" class="nav-link <?php if (isset($active_rateNotifications)) {echo $active_rateNotifications;} ?>">
                  <i class="nav-icon fas fa-bell"></i>
                  <p>Rate Notifications</p>
                </a>
              </li>
            </ul>
          </li>
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