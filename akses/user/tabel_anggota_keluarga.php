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
    echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Penduduk!');window.location.href = '../../login.php';</script>";
    exit;
}

$id_user = $_SESSION["nik"];
$username = $_SESSION["first_name"];
$email = $_SESSION["email"];
//session
//library
include('../config/library.php');
$lib = new Library();
if (isset($_SESSION['nik'])) {
    $kd_penduduk2 = $_SESSION['nik'];
    $data_pelayanan = $lib->get_by_id_userPelayanan($kd_penduduk2);
} else {
    header('Location: index.php');
}
if (isset($_SESSION['nik'])) {
    $kd_penduduk = $_SESSION['nik'];
    $data_penduduk = $lib->get_by_id_user($kd_penduduk);
} else {
    header('Location: index.php');
}
if (isset($_SESSION['no_kk'])) {
    $kd_kk_A = $_SESSION['no_kk'];
    $data_kk3 = $lib->get_by_id_userAnggotaKeluarga($kd_kk_A);
} else {
    header('Location: index.php');
}
if (isset($_GET['hapus_anggota'])) {
    $kk_anggota = $_GET['hapus_anggota'];
    $status_hapus = $lib->delete_anggotaKel($kk_anggota);
    if ($status_hapus) {
        echo "<script type='text/javascript'>alert('Berhasil Menghapus Data Anggota Keluarga!');window .location.href = 'tabel_anggota_keluarga.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Gagal Menghapus Data Anggota Keluarga, Silahkan Hubungi Admin Melalui Kontak Kami :)');window .location.href = 'tabel_anggota_keluarga.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SPPDB - Tabel Anggota Keluarga</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--icon-->
    <link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../library/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../library/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../library/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../library/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .dtHorizontalVerticalExampleWrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        #dtHorizontalVerticalExample th,
        td {
            white-space: nowrap;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
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
                            <a href="#" class="nav-link bg-cyan">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Tables <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="tabel_anggota_keluarga.php" class="nav-link bg-cyan">
                                        <i class="fas fa-circle nav-icon"></i>
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
                            <h1>Data Anggota Keluarga</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                                <li class="breadcrumb-item active">Tabel Data</li>
                                <li class="breadcrumb-item active">Anggota Keluarga</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tabel Data Anggota Keluarga</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div style="overflow-x:auto;" class="table-responsive">
                                        <table id="dtHorizontalVerticalExample" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nomor Kartu Keluarga</th>
                                                    <th>NIK</th>
                                                    <th>Nama Anggota Keluarga</th>
                                                    <th>Tempat Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Gol Darah</th>
                                                    <th>Agama</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Kewarganegaraan</th>
                                                    <th>Status Hub. Keluarga</th>
                                                    <th>Status Perkawinan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($data_kk3 as $row2) {
                                                    $jkl = '';
                                                    $tgl_tmp = $row2['tanggal_lahir'];
                                                    $tgl_real = date("d F Y", strtotime($tgl_tmp));
                                                    if ($row2['jenis_kelamin'] == 'p') {
                                                        $jkl = 'Pria';
                                                    } else {
                                                        $jkl = 'Wanita';
                                                    }
                                                    echo "<tr>";
                                                    echo "<td>" . $no . "</td>";
                                                    echo "<td>" . $row2['no_kk'] . "</td>";
                                                    echo "<td>" . $row2['nik'] . "</td>";
                                                    echo "<td>" . $row2['nama_lengkap'] . "</td>";
                                                    echo "<td>" . $row2['tempat_lahir'] . ", " . $tgl_real . "</td>";
                                                    echo "<td>" . $jkl . "</td>";
                                                    echo "<td>" . $row2['GolDarah'] . "</td>";
                                                    echo "<td>" . $row2['agama'] . "</td>";
                                                    echo "<td>" . $row2['pekerjaan'] . "</td>";
                                                    echo "<td>" . $row2['kewarganegaraan'] . "</td>";
                                                    echo "<td>" . $row2['status_hub_kel'] . "</td>";
                                                    echo "<td>" . $row2['status_perkawinan'] . "</td>";
                                                    echo "<td><a href='form_edit_anggota_keluarga.php?id_anggota=" . $row2['id_anggota'] . "' class='btn btn-info'>Update</a>
														<a href='tabel_anggota_keluarga.php?hapus_anggota=" . $row2['id_anggota'] . "' class='btn btn-danger'>Hapus</a></td>";
                                                    echo "</tr>";
                                                    $no++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
    <!-- DataTables -->
    <script src="../../library/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../library/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../library/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../library/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../library/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../library/dist/js/demo.js"></script>
    <!-- page script -->
    <script type="text/javascript">
        function updateData(id_pelayanan) {
            if (confirm("Apakah ingin mengubah data pelayanan ini?")) {
                window.location.href = 'form_edit_pelayanan.php?id_pelayanan=' + id_pelayanan;
            } else {
                alert('Batal Mengubah Data Pelayanan!');
                window.location.href = 'tabel_data_pelayanan.php?ubah_pelayanan=batal';
            }
        }

        function hapusData(id_pelayanan) {
            if (confirm("Apakah anda yakin akan menghapus data ini?")) {
                alert('Berhasil Menghapus Data Pelayanan!');
                window.location.href = 'tabel_data_pelayanan.php?hapus_pelayanan=' + id_pelayanan;
            } else {
                alert('Batal Menghapus Data Pelayanan!');
                window.location.href = 'tabel_data_pelayanan.php?hapus_pelayanan=batal';
            }
        }
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(document).ready(function() {
            $('#dtHorizontalVerticalExample').DataTable({
                "scrollX": true,
                "scrollY": true,
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
</body>

</html>