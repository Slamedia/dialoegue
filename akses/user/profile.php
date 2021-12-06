<!DOCTYPE html>
<html>
<?php
date_default_timezone_set("Asia/Jakarta");
session_start();

if (!isset($_SESSION["email"])) {
  echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
  exit;
}

$aks = $_SESSION["akses"];

if ($aks != "penduduk") {
  echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Penduduk!');window.location.href = '../../login.php';</script>";
  exit;
}

$id_user = $_SESSION["nik"];
$username = $_SESSION["first_name"];
$email = $_SESSION["email"];
//session_
//library
include('../config/library.php');
$lib = new Library();
$data_KK = $lib->showKartuKeluarga();

if (isset($_SESSION['nik'])) {
  $kd_penduduk = $_SESSION['nik'];
  $data_penduduk = $lib->get_by_id_user($kd_penduduk);
} else {
  header('Location: index.php');
}

if (isset($_SESSION['nik'])) {
  $kd_penduduk2 = $_SESSION['nik'];
  $data_pelayanan2 = $lib->get_by_id_userPelayanan2($kd_penduduk2);
} else {
  header('Location: index.php');
}
$data_akunPenduduk = $lib->countAkunPenduduk();
if (isset($_POST['tombol_ubah_password'])) {
  $error = '';
  $id = $_SESSION['id_pen'];
  $o = md5($_POST['old']);
  $n = md5($_POST['new']);
  $co = md5($_POST['confirm']);

  if ($o == $data_penduduk['password']) {
    if ($o != $n && $o != $co) {
      if ($n == $co) {
        $error = '<div class="form-group row">
    <div class="col-sm-12">
    <div class="alert alert-success" role="alert">
    <b>Berhasil Mengubah Password!</b>
  </div>
    </div>
  </div>';
        $status_update = $lib->updatePassword($id, $co);
        if ($status_update) {
          echo "<script type='text/javascript'>alert('Berhasil Mengubah Password!');</script>";
        }
      } else {
        $error = '<div class="form-group row">
    <div class="col-sm-12">
    <div class="alert alert-danger" role="alert">
    <b>Wrong New Passwords and Confirm Passwords are not the same!</b>
  </div>
    </div>
  </div>';
      }
    } else {
      $error = '<div class="form-group row">
    <div class="col-sm-12">
    <div class="alert alert-warning" role="alert">
    <b>You still use old password, not change!</b>
  </div>
    </div>
  </div>';
    }
  } else {
    $error = '<div class="form-group row">
    <div class="col-sm-12">
    <div class="alert alert-danger" role="alert">
    <b>Wrong Old Passwords Do Not Match</b>
  </div>
    </div>
  </div>';
  }
}
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SPPDB - User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--icon-->
  <link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../library/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
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
          <a href="contacts.php" class="nav-link">Kontak</a>
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
            <a href="#" class="d-block"><?php echo $data_penduduk['first_name']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Beranda
                </p>
              </a>
            </li>
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
                  Tabels
                  <i class="fas fa-angle-left right"></i>
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
              <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="../../library/dist/img/avatar5.png" alt="User profile picture">
                  </div>

                  <h3 class="profile-username text-center"><?php $dot = '';
                                                            if ($data_penduduk['status'] == 'OFFLINE') {
                                                              $dot = '<span class="dot bg-danger"></span>';
                                                            } else {
                                                              $dot = '<span class="dot bg-success"></span>';
                                                            }
                                                            echo $dot . " ";
                                                            echo $data_penduduk['first_name'] . " " . $data_penduduk['last_name']; ?></h3>

                  <p style="text-transform:capitalize;" class="text-muted text-center"><?php echo $data_penduduk['akses']; ?></p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>NIK</b> <a class="float-right"><?php echo $data_penduduk['nik']; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Nomor Kartu Keluarga</b> <a class="float-right"><?php echo $data_penduduk['no_kk']; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Jenis Kelamin</b> <a class="float-right"><?php if ($data_penduduk['jenis_kelamin'] == 'p') {
                                                                    echo $jk = 'Pria';
                                                                  } else {
                                                                    echo $jk = 'Wanita';
                                                                  } ?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Kewarganegaraan</b> <a class="float-right"><?php echo $data_penduduk['kewarganegaraan']; ?></a>
                    </li>
                    <?php
                    $tgl_tmp = $data_penduduk['tanggal_lahir'];
                    $bulan = date("m", strtotime($tgl_tmp));
                    if ($bulan == '01') {
                      $bulanInd = 'Januari';
                    } else if ($bulan == '02') {
                      $bulanInd = 'Februari';
                    } else if ($bulan == '03') {
                      $bulanInd = 'Maret';
                    } else if ($bulan == '04') {
                      $bulanInd = 'April';
                    } else if ($bulan == '05') {
                      $bulanInd = 'Mei';
                    } else if ($bulan == '06') {
                      $bulanInd = 'Juni';
                    } else if ($bulan == '07') {
                      $bulanInd = 'Juli';
                    } else if ($bulan == '08') {
                      $bulanInd = 'Agustus';
                    } else if ($bulan == '09') {
                      $bulanInd = 'September';
                    } else if ($bulan == '10') {
                      $bulanInd = 'Oktober';
                    } else if ($bulan == '11') {
                      $bulanInd = 'November';
                    } else if ($bulan == '12') {
                      $bulanInd = 'Desember';
                    }
                    $tgl_real = date("d", strtotime($tgl_tmp));
                    $tahun_real = date("Y", strtotime($tgl_tmp));
                    ?>
                    <li class="list-group-item">
                      <b>Tanggal Lahir</b> <a class="float-right"> <?= $tgl_real . " " . $bulanInd . " " . $tahun_real ?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Agama</b> <a class="float-right"><?php echo $data_penduduk['agama']; ?> </a>
                    </li>
                    <?php
                    $pekerjaan = '';
                    if ($data_penduduk['pekerjaan'] == '1') {
                      $pekerjaan = 'Belum Tidak Bekerja';
                    } else if ($data_penduduk['pekerjaan'] == '2') {
                      $pekerjaan = 'Mengurus Rumah Tangga';
                    } else if ($data_penduduk['pekerjaan'] == '3') {
                      $pekerjaan = 'Pelajar/Mahasiswa';
                    } else if ($data_penduduk['pekerjaan'] == '4') {
                      $pekerjaan = 'Pensiunan';
                    } else if ($data_penduduk['pekerjaan'] == '5') {
                      $pekerjaan = 'Pegawai Negri Sipil(PNS)';
                    } else if ($data_penduduk['pekerjaan'] == '6') {
                      $pekerjaan = 'TNI';
                    } else if ($data_penduduk['pekerjaan'] == '7') {
                      $pekerjaan = 'POLRI';
                    } else if ($data_penduduk['pekerjaan'] == '8') {
                      $pekerjaan = 'Perdagangan';
                    } else if ($data_penduduk['pekerjaan'] == '9') {
                      $pekerjaan = 'Petani/Pekebun';
                    } else if ($data_penduduk['pekerjaan'] == '10') {
                      $pekerjaan = 'Peternak';
                    } else if ($data_penduduk['pekerjaan'] == '11') {
                      $pekerjaan = 'Nelayan/Perikanan';
                    } else if ($data_penduduk['pekerjaan'] == '12') {
                      $pekerjaan = 'Industri';
                    } else if ($data_penduduk['pekerjaan'] == '13') {
                      $pekerjaan = 'Konstruksi';
                    } else if ($data_penduduk['pekerjaan'] == '14') {
                      $pekerjaan = 'Transportasi';
                    } else if ($data_penduduk['pekerjaan'] == '15') {
                      $pekerjaan = 'Karyawan Swasta';
                    } else if ($data_penduduk['pekerjaan'] == '16') {
                      $pekerjaan = 'Karyawan BUMN';
                    } else if ($data_penduduk['pekerjaan'] == '17') {
                      $pekerjaan = 'Karyawan BUMND';
                    } else if ($data_penduduk['pekerjaan'] == '18') {
                      $pekerjaan = 'Karyawan Honorer';
                    } else if ($data_penduduk['pekerjaan'] == '19') {
                      $pekerjaan = 'Buruh Harian Lapas';
                    } else if ($data_penduduk['pekerjaan'] == '20') {
                      $pekerjaan = 'Buruh Tani/Perkebunan';
                    } else if ($data_penduduk['pekerjaan'] == '21') {
                      $pekerjaan = 'Buruh Nelayan/Perikanan';
                    } else if ($data_penduduk['pekerjaan'] == '22') {
                      $pekerjaan = 'Buruh Peternakan';
                    } else if ($data_penduduk['pekerjaan'] == '23') {
                      $pekerjaan = 'Pembantu Rumah Tangga';
                    } else if ($data_penduduk['pekerjaan'] == '24') {
                      $pekerjaan = 'Tukang Cukur';
                    } else if ($data_penduduk['pekerjaan'] == '25') {
                      $pekerjaan = 'Tukang Listrik';
                    } else if ($data_penduduk['pekerjaan'] == '26') {
                      $pekerjaan = 'Tukang Batu';
                    } else if ($data_penduduk['pekerjaan'] == '27') {
                      $pekerjaan = 'Tukang Kayu';
                    } else if ($data_penduduk['pekerjaan'] == '28') {
                      $pekerjaan = 'Tukang Sol Sepatu';
                    } else if ($data_penduduk['pekerjaan'] == '29') {
                      $pekerjaan = 'Tukang Las/Pandai Besi';
                    } else if ($data_penduduk['pekerjaan'] == '30') {
                      $pekerjaan = 'Tukang Jahit';
                    } else if ($data_penduduk['pekerjaan'] == '31') {
                      $pekerjaan = 'Tukang Gigi';
                    } else if ($data_penduduk['pekerjaan'] == '32') {
                      $pekerjaan = 'Penata Rias';
                    } else if ($data_penduduk['pekerjaan'] == '33') {
                      $pekerjaan = 'Penata Busana';
                    } else if ($data_penduduk['pekerjaan'] == '34') {
                      $pekerjaan = 'Penata Rambut';
                    } else if ($data_penduduk['pekerjaan'] == '35') {
                      $pekerjaan = 'Mekanik';
                    } else if ($data_penduduk['pekerjaan'] == '36') {
                      $pekerjaan = 'Seniman';
                    } else if ($data_penduduk['pekerjaan'] == '37') {
                      $pekerjaan = 'Tabib';
                    } else if ($data_penduduk['pekerjaan'] == '38') {
                      $pekerjaan = 'Paraji';
                    } else if ($data_penduduk['pekerjaan'] == '39') {
                      $pekerjaan = 'Perancang Busana';
                    } else if ($data_penduduk['pekerjaan'] == '40') {
                      $pekerjaan = 'Peternak';
                    } else if ($data_penduduk['pekerjaan'] == '41') {
                      $pekerjaan = 'Penterjemah';
                    } else if ($data_penduduk['pekerjaan'] == '42') {
                      $pekerjaan = 'Pendeta';
                    } else if ($data_penduduk['pekerjaan'] == '43') {
                      $pekerjaan = 'Pastor';
                    } else if ($data_penduduk['pekerjaan'] == '44') {
                      $pekerjaan = 'Wartawan';
                    } else if ($data_penduduk['pekerjaan'] == '45') {
                      $pekerjaan = 'Ustadz / Mubaligh';
                    } else if ($data_penduduk['pekerjaan'] == '46') {
                      $pekerjaan = 'Juru Masak';
                    } else if ($data_penduduk['pekerjaan'] == '47') {
                      $pekerjaan = 'Promotor Acara';
                    } else if ($data_penduduk['pekerjaan'] == '48') {
                      $pekerjaan = 'Anggota DPR RI';
                    } else if ($data_penduduk['pekerjaan'] == '49') {
                      $pekerjaan = 'Anggota DPD';
                    } else if ($data_penduduk['pekerjaan'] == '50') {
                      $pekerjaan = 'Anggota BPK';
                    } else if ($data_penduduk['pekerjaan'] == '51') {
                      $pekerjaan = 'Presiden';
                    } else if ($data_penduduk['pekerjaan'] == '52') {
                      $pekerjaan = 'Wakil Presiden';
                    } else if ($data_penduduk['pekerjaan'] == '53') {
                      $pekerjaan = 'Anggota Mahkamah Konstitusi';
                    } else if ($data_penduduk['pekerjaan'] == '54') {
                      $pekerjaan = 'Anggota Kabinet/Kementrian';
                    } else if ($data_penduduk['pekerjaan'] == '55') {
                      $pekerjaan = 'Duta Besar';
                    } else if ($data_penduduk['pekerjaan'] == '56') {
                      $pekerjaan = 'Gubernur';
                    } else if ($data_penduduk['pekerjaan'] == '57') {
                      $pekerjaan = 'Wakil Gubernur';
                    } else if ($data_penduduk['pekerjaan'] == '58') {
                      $pekerjaan = 'Bupati';
                    } else if ($data_penduduk['pekerjaan'] == '59') {
                      $pekerjaan = 'Wakil Bupati';
                    } else if ($data_penduduk['pekerjaan'] == '60') {
                      $pekerjaan = 'Walikota';
                    } else if ($data_penduduk['pekerjaan'] == '61') {
                      $pekerjaan = 'Wakil Walikota';
                    } else if ($data_penduduk['pekerjaan'] == '62') {
                      $pekerjaan = 'Anggota DPRD Prop.';
                    } else if ($data_penduduk['pekerjaan'] == '63') {
                      $pekerjaan = 'Anggota DPRD Kab./Kota';
                    } else if ($data_penduduk['pekerjaan'] == '64') {
                      $pekerjaan = 'Dosen';
                    } else if ($data_penduduk['pekerjaan'] == '65') {
                      $pekerjaan = 'Guru';
                    } else if ($data_penduduk['pekerjaan'] == '66') {
                      $pekerjaan = 'Pilot';
                    } else if ($data_penduduk['pekerjaan'] == '67') {
                      $pekerjaan = 'Pengacara';
                    } else if ($data_penduduk['pekerjaan'] == '68') {
                      $pekerjaan = 'Notaris';
                    } else if ($data_penduduk['pekerjaan'] == '69') {
                      $pekerjaan = 'Arsitek';
                    } else if ($data_penduduk['pekerjaan'] == '70') {
                      $pekerjaan = 'Akuntan';
                    } else if ($data_penduduk['pekerjaan'] == '71') {
                      $pekerjaan = 'Konsultan';
                    } else if ($data_penduduk['pekerjaan'] == '72') {
                      $pekerjaan = 'Dokter';
                    } else if ($data_penduduk['pekerjaan'] == '73') {
                      $pekerjaan = 'Bidan';
                    } else if ($data_penduduk['pekerjaan'] == '74') {
                      $pekerjaan = 'Perawat';
                    } else if ($data_penduduk['pekerjaan'] == '75') {
                      $pekerjaan = 'Apotaker';
                    } else if ($data_penduduk['pekerjaan'] == '76') {
                      $pekerjaan = 'Psikater / Psikolog';
                    } else if ($data_penduduk['pekerjaan'] == '77') {
                      $pekerjaan = 'Penyiar Televisi';
                    } else if ($data_penduduk['pekerjaan'] == '78') {
                      $pekerjaan = 'Penyiar Radio';
                    } else if ($data_penduduk['pekerjaan'] == '79') {
                      $pekerjaan = 'Pelaut';
                    } else if ($data_penduduk['pekerjaan'] == '80') {
                      $pekerjaan = 'Peneliti';
                    } else if ($data_penduduk['pekerjaan'] == '81') {
                      $pekerjaan = 'Sopir';
                    } else if ($data_penduduk['pekerjaan'] == '82') {
                      $pekerjaan = 'Pialang';
                    } else if ($data_penduduk['pekerjaan'] == '83') {
                      $pekerjaan = 'Paranormal';
                    } else if ($data_penduduk['pekerjaan'] == '84') {
                      $pekerjaan = 'Pedagang';
                    } else if ($data_penduduk['pekerjaan'] == '85') {
                      $pekerjaan = 'Perangkat Desa';
                    } else if ($data_penduduk['pekerjaan'] == '86') {
                      $pekerjaan = 'Kepala Desa';
                    } else if ($data_penduduk['pekerjaan'] == '87') {
                      $pekerjaan = 'Birawati';
                    } else if ($data_penduduk['pekerjaan'] == '88') {
                      $pekerjaan = 'Wiraswasta';
                    } else if ($data_penduduk['pekerjaan'] == '89') {
                      $pekerjaan = 'Lainnya';
                    }
                    ?>
                    <li class="list-group-item">
                      <b>Pekerjaan</b> <a class="float-right"><?php echo $pekerjaan; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Status Kawin</b> <a class="float-right"><?php echo $data_penduduk['status_perkawinan']; ?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Nomor Handphone</b> <a class="float-right"><?php echo $data_penduduk['notlp']; ?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Email</b> <a class="float-right"><?php echo $data_penduduk['email']; ?> </a>
                    </li>
                  </ul>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab"><i class="fa fa-globe"></i> Pelayanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab"><i class="fa fa-cog"></i> Change Passwords</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <?php
                      foreach ($data_pelayanan2 as $row) {
                      ?>
                        <!-- Post -->
                        <div class="post">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="../../library/dist/img/avatar5.png" alt="user image">
                            <span class="username">
                              <a href="#"><?php if ($row['nama_petugas'] == '') {
                                            echo 'Menunggu Petugas';
                                          } else {
                                            echo $row['nama_petugas'];
                                          } ?></a>
                              <a href="#" class="float-right btn-tool"><i class="fas fa-thumbtack"></i></a>
                            </span>
                            <span class="description">Shared publicly - <?php $tgl_format1 = $row['tanggal_proses'];
                                                                        $tgl_format2 = date("d F Y", strtotime($tgl_format1));
                                                                        echo $tgl_format2;
                                                                        ?></span>
                          </div>
                          <!-- /.user-block -->
                          <p><?php
                              if ($row['keterangan'] == '') {
                                echo 'Sedang Menunggu Balasan Petugas';
                              } else {
                                echo $row['keterangan'];
                              } ?>
                          </p>
                        </div>
                        <!-- /.post -->
                      <?php } ?>
                    </div>
                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" method="POST">
                        <?php echo $error; ?>
                        <div class="form-group row">
                          <label for="inputName" readonly class="col-sm-2 col-form-label">Old Passwords</label>
                          <div class="col-sm-10">
                            <input type="password" name="old" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Harus di isi setidaknya 1 nomor dan 1 huruf besar dan 1 huruf kecil di form ini, dan sedikitnya 8 karakter atau lebih karakter" required="5" class="form-control" id="inputName" placeholder="Old Password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">New Passwords</label>
                          <div class="col-sm-10">
                            <input type="password" name="new" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Harus di isi setidaknya 1 nomor dan 1 huruf besar dan 1 huruf kecil di form ini, dan sedikitnya 8 karakter atau lebih karakter" required="5" class="form-control" id="inputName" placeholder="New Password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label"></label>
                          <div class="col-sm-10">
                            <input type="password" name="confirm" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Harus di isi setidaknya 1 nomor dan 1 huruf besar dan 1 huruf kecil di form ini, dan sedikitnya 8 karakter atau lebih karakter" required="5" class="form-control" id="inputName" placeholder="Confirm New Passwords">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" name="tombol_ubah_password" class="btn btn-success">Ubah Password</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2020 <a href="http://firmansyah.kel4.xyz">Firmansyah</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>SPPDB Version</b> 1.0.0
      </div>
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