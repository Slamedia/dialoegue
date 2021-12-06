<?php
//Login Session
session_start();

if (!isset($_SESSION["email"])) {
    echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
    exit;
}

$aks = $_SESSION["akses"];

if ($aks != "admin") {
    echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Admin!');window.location.href = '../../login.php';</script>";
    exit;
}

$id_user = $_SESSION["id_admin"];
$username = $_SESSION["nama_admin"];
$email = $_SESSION["email"];

//Login Session
//library
include('../config/library.php');
$lib = new Library();

if (isset($_GET['id_akses_login'])) {
    $kd_admin = $_GET['id_akses_login'];
    $data_admin = $lib->get_by_id_admin($kd_admin);
} else {
    header('Location: tabel_admin.php');
}

if (isset($_POST['tombol_ubah'])) {
    $kd = $_POST['id_adminx'];
    // $kd = $data_admin['id_akses_login'];
    $nama = $_POST['nama_adminx'];
    $jk = $_POST['jenis_kelamin'];
    $email = $_POST['emailx'];
    // $pass = md5($_POST['passwordx']);
    $alamat = $_POST['alamatx'];
    $notlp = $_POST['no_tlpx'];

    $add_status = $lib->updateAdmin($kd, $nama, $jk, $email, $alamat, $notlp);
    if ($add_status) {
        echo "<script type='text/javascript'>alert('Berhasil Mengubah Data Admin!');window.location.href = 'tabel_admin.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Gagal Mengubah Data Admin!');window.location.href = 'form_edit_admin.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SPPDB - Form Ubah Admin</title>
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
                    <a href="home.php" class="nav-link">Beranda</a>
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
                    <a class="nav-link" href="../config/logout.php" role="button">
                        Logout <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="home.php" class="brand-link">
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
                        <a href="profile.php" class="d-block"><?php echo $username; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="home.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Beranda
                                </p>
                            </a>
                        </li>
                        <!--FORM-->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link bg-cyan">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Forms
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="form_penduduk.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penduduk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="form_petugas.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Petugas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="form_admin.php" class="nav-link bg-cyan">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Tabels <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="tabel_data_penduduk.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penduduk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="tabel_data_riwayat_login.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Riwayat Login</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="tabel_data_pesan.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pesan Website</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="tabel_petugas.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Petugas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="tabel_admin.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Admin</p>
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
                            <h1>Formulir Ubah Admin</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home.php">Beranda</a></li>
                                <li class="breadcrumb-item active">Formulir</li>
                                <li class="breadcrumb-item active">Formulir Admin</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-teal">
                        <div class="card-header">
                            <h3 class="card-title">Silahkan isi Form Admin</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    date_default_timezone_set("Asia/Jakarta");
                                    $id_admin_date = date('dmYHis');
                                    ?>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>ID Admin:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" readonly value="<?= $data_admin['id_admin']; ?>" name="id_adminx" placeholder="Masukan ID Admin">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Admin:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="nama_adminx" value="<?= $data_admin['nama_admin']; ?>" placeholder="Masukan Nama Admin">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fas fa-id-badge"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin:*</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="jenis_kelamin" value="p" <?php if ($data_admin['jenis_kelamin'] == 'p') {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Pria
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="jenis_kelamin" value="w" <?php if ($data_admin['jenis_kelamin'] == 'w') {
                                                                                                        echo 'checked';
                                                                                                    } ?>> Wanita
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="emailx" value="<?= $data_admin['email']; ?>" placeholder="Masukan Email">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fas fa-at"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Masukan Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control" type="password" name="passwordx" readonly value="<?= $data_admin['password']; ?>" id="password" placeholder="Masukan Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fas fa-eye-slash"></i></div>
                                                </div>
                                                </input>
                                            </div>
                                        </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alamat:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="alamatx" value="<?= $data_admin['alamat']; ?>" placeholder="Masukan Alamat">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-phone-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Handphone:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="no_tlpx" value="<?= $data_admin['no_tlp']; ?>" placeholder="Masukan Nomor Handphone">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-phone-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Akses:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" readonly name="aksesx" value="<?= $data_admin['akses']; ?>" value="Admin" placeholder="Masukan Akses">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" name="tombol_ubah" class="btn btn-success" value="Ubah">
                                        <input type="reset" class="btn btn-danger" value="Batal">
                                    </div>
                                    </form>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            Form Kartu Keluarga
                        </div>
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-fluid -->
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
    <!-- Page script -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password i").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fas fa-eye-slash");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fas fa-eye-slash");
                    $('#show_hide_password i').addClass("fas fa-eye");
                }
            });
        });
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
    </script>
</body>

</html>