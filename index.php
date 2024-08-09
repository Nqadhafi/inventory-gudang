<?php
session_start();
include ('config.php');

// Logout
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laksmita  | Dashboard</title>

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
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="?logout=true" role="button">
          <h5>Logout</h5>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="./" class="brand-link">
      <img src="dist/img/Logo-utama.png" alt="Laksmita Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Laksmita</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Selamat Datang, <b><?php echo htmlspecialchars($_SESSION['username']); ?> </b>!</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Transaksi<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($_SESSION['role'] == 'admin'): ?>
                <li class="nav-item">
                  <a href="./index.php?pages=barang" class="nav-link">
                    <p>Tambah Barang</p>
                  </a>
                </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?pages=input" class="nav-link">
                  <p>Input Barang Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?pages=output" class="nav-link">
                  <p>Input Barang Keluar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?pages=supplier" class="nav-link">
                  <p>Input Supplier</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php
    if ($_SESSION['role'] == 'admin') {
      if (isset($_GET['pages'])) {
        switch ($_GET['pages']) {
          case 'barang':
            include './form/form_barang.php';
            break;
          case 'input':
            include './form/form_masuk.php';
            break;
          case 'output':
            include './form/form_keluar.php';
            break;
          case 'supplier':
            include './form/form_supplier.php';
            break;
        }
      } elseif (isset($_GET['tambah'])) {
        switch ($_GET['tambah']) {
          case 'barang':
            include './form/tambah_barang.php';
            break;
          case 'input':
            include './form/tambah_masuk.php';
            break;
          case 'output':
            include './form/tambah_keluar.php';
            break;
          case 'supplier':
            include './form/tambah_supplier.php';
            break;
        }
      } elseif (isset($_GET['edit'])) {
        include './form/edit_barang.php';
      } elseif (isset($_GET['supplier'])) {
        include './form/edit_supplier.php';
      }
    } elseif ($_SESSION['role'] == 'karyawan') {
      if (isset($_GET['pages']) && !in_array($_GET['pages'], ['barang', 'edit'])) {
        switch ($_GET['pages']) {
          case 'input':
            include './form/form_masuk.php';
            break;
          case 'output':
            include './form/form_keluar.php';
            break;
          case 'supplier':
            include './form/form_supplier.php';
            break;
        }
      } elseif (isset($_GET['tambah']) && !in_array($_GET['tambah'], ['barang'])) {
        switch ($_GET['tambah']) {
          case 'input':
            include './form/tambah_masuk.php';
            break;
          case 'output':
            include './form/tambah_keluar.php';
            break;
          case 'supplier':
            include './form/tambah_supplier.php';
            break;
        }
      } 
      elseif (isset($_GET['supplier'])) {
        include './form/edit_supplier.php';
      }
      else {
        echo '<h1 class="text-center">Selamat datang di aplikasi inventory gudang Laksmita</h1>';
      }
    } else {
      echo '<h1 class="text-center">Selamat datang di aplikasi inventory gudang Laksmita</h1>';
    }
    ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="./">Laksmita</a>.</strong>
    All rights reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

</body>
</html>
