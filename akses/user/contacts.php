<?php
date_default_timezone_set("Asia/Jakarta");
//Login Session
session_start();

if (!isset($_SESSION["email"])) {
  echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
  exit;
}

$aks = $_SESSION["akses"];

if ($aks != "penduduk") {
  echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Admin');window.location.href = '../../login.php';</script>";
  exit;
}

$id_user = $_SESSION["nik"];
$username = $_SESSION["first_name"];
$email = $_SESSION["email"];
$about = 'Admin SPPDB/User Control/Registasi/Change';
//Library koneksi
include('../config/library.php');
$lib = new Library();
if (isset($_SESSION['nik'])) {
  $kd_penduduk = $_SESSION['nik'];
  $data_penduduk = $lib->get_by_id_user($kd_penduduk);
} else {
  header('Location: index.php');
}

$data_admin = $lib->showAdmin();
$data_petugas = $lib->showPetugas();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SPPDB - Kontak</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--icon-->
  <link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../library/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../library/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .dot {
      height: 12px;
      width: 12px;
      border-radius: 50%;
      display: inline-block;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Beranda</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link bg-dark">Kontak</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-sliders-h"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../config/logout_penduduk.php" role="button">
            Logout <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="../../library/dist/img/logoNav.png" alt="SPPDB Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span style="margin-left:2px" class="brand-text font-weight-light">SPPDB</span>
      </a>

      <?php
      if ($jk = $_SESSION["jenis_kelamin"] == 'p') {
        $ava = '<img src="../../library/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">';
      } else {
        $ava = '<img src="../../library/dist/img/avatar2.png" class="img-circle elevation-2" alt="User Image">';
      }
      ?>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php echo $ava; ?>
          </div>
          <div class="info">
            <a href="profile.php" class="d-block"><?php echo $data_penduduk['first_name']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Beranda
                </p>
              </a>
            </li>
            <!--FORM-->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Forms
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="form_anggota_keluarga.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Anggota Keluarga</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Pelayanan <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Kartu Keluarga <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="kk_baru.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Membuat KK Baru</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="kk_baru_kehilangan.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>KK (Kehilangan)</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="kk_baru_anggota_baru.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>KK (Anggota Baru)</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Kartu Tanda Penduduk <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="ktp_baru.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Membuat KTP Baru</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="ktp_baru_kehilangan.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>KTP (Kehilangan)</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="ktp_baru_pindah.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>KTP (Pindah)</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Tables <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="tabel_anggota_keluarga.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Anggota Keluarga</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="tabel_data_pelayanan.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelayanan</p>
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
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Contacts</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Kontak</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="card card-solid">
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              <?php foreach ($data_admin as $row) {
                if ($row["jenis_kelamin"] == 'p') {
                  $ava2 = '<img src="../../library/dist/img/avatar5.png" class="img-circle img-fluid" alt="User Image">';
                } else {
                  $ava2 = '<img src="../../library/dist/img/avatar2.png" class="img-circle img-fluid" alt="User Image">';
                }
              ?>

                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div style="text-transform: capitalize;" class="card-header text-muted border-bottom-0">
                      <?php echo $row['akses']; ?>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b><?php echo $row['nama_admin']; ?> </b></h2>
                          <p class="text-muted text-sm"><b>About: </b><?php echo $about; ?></p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><?php echo $row['alamat']; ?></li>
                            <li class="small mt-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><?php echo $row['no_tlp']; ?></li>
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <?php echo $ava2; ?>

                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="text-right text-muted">
                        <?php
                        $dot = '';
                        if ($row['status'] == 'OFFLINE') {
                          $dot = '<a><span class="dot bg-danger"></span> Offline , </a>';
                        } else {
                          $dot = '<a><span class="dot bg-success"></span> Online , </a>';
                        }
                        echo $dot;
                        ?>
                        <a>
                          <?php
                          $day = "";
                          if (date("N") == 1) {
                            $day = "Senin";
                          } else if (date("N") == 2) {
                            $day = "Selasa";
                          } else if (date("N") == 3) {
                            $day = "Rabu";
                          } else if (date("N") == 4) {
                            $day = "Kamis";
                          } else if (date("N") == 5) {
                            $day = "Jum'at";
                          } else if (date("N") == 6) {
                            $day = "Sabtu";
                          } else if (date("N") == 7) {
                            $day = "Minggu";
                          }
                          echo $day . ", " . date("h : i : s : A"); ?></a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }
              ?>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">6</a></li>
                <li class="page-item"><a class="page-link" href="#">7</a></li>
                <li class="page-item"><a class="page-link" href="#">8</a></li>
              </ul>
            </nav>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

        <div class="card card-solid">
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              <?php foreach ($data_petugas as $row) {
                if ($row["jenis_kelamin"] == 'p') {
                  $ava2 = '<img src="../../library/dist/img/avatar5.png" class="img-circle img-fluid" alt="User Image">';
                } else {
                  $ava2 = '<img src="../../library/dist/img/avatar2.png" class="img-circle img-fluid" alt="User Image">';
                }
              ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div style="text-transform: capitalize;" class="card-header text-muted border-bottom-0">
                      <?php echo $row['akses']; ?>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b><?php echo $row['nama_lengkap_petugas']; ?> </b></h2>
                          <p class="text-muted text-sm"><b>About: </b><?php echo $about; ?></p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><?php echo $row['alamat']; ?></li>
                            <li class="small mt-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><?php echo $row['no_tlp']; ?></li>
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <?= $ava2; ?>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="text-right text-muted">
                        <?php
                        $dot = '';
                        if ($row['status'] == 'OFFLINE') {
                          $dot = '<a><span class="dot bg-danger"></span> Offline , </a>';
                        } else {
                          $dot = '<a><span class="dot bg-success"></span> Online , </a>';
                        }
                        echo $dot;
                        ?>
                        <a>
                          <?php
                          $day = "";
                          if (date("N") == 1) {
                            $day = "Senin";
                          } else if (date("N") == 2) {
                            $day = "Selasa";
                          } else if (date("N") == 3) {
                            $day = "Rabu";
                          } else if (date("N") == 4) {
                            $day = "Kamis";
                          } else if (date("N") == 5) {
                            $day = "Jum'at";
                          } else if (date("N") == 6) {
                            $day = "Sabtu";
                          } else if (date("N") == 7) {
                            $day = "Minggu";
                          }
                          echo $day . ", " . date("h : i : s : A"); ?></a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }
              ?>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">6</a></li>
                <li class="page-item"><a class="page-link" href="#">7</a></li>
                <li class="page-item"><a class="page-link" href="#">8</a></li>
              </ul>
            </nav>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>SPPDB Version</b> 1.0.0
      </div>
      <strong>Copyright &copy; 2020 <a href="http://firmansyah.kel4.xyz">Firmansyah</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../library/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../library/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../library/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../library/dist/js/demo.js"></script>
</body>

</html>