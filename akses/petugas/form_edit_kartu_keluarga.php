<?php
//Login Session
session_start();

if (!isset($_SESSION["email"])) {
	echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
	exit;
}

$aks = $_SESSION["akses"];

if ($aks != "petugas") {
	echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Petugas!');window.location.href = '../../login.php';</script>";
	exit;
}

$id_user = $_SESSION["nip"];
$username = $_SESSION["nama_lengkap_petugas"];
$email = $_SESSION["email"];
//Login Session
//library
include('../config/library.php');
$lib = new Library();

if (isset($_GET['nomor_kartu'])) {
	$kd_kartuKeluarga = $_GET['nomor_kartu'];
	$data_kartuKeluarga = $lib->get_by_id_KK($kd_kartuKeluarga);
} else {
	header('Location:tabel_data_kartu_keluarga.php');
}
if (isset($_SESSION['nip'])) {
	$kd_petugas = $_SESSION['nip'];
	$data_petugas2 = $lib->get_by_id_userPetugas($kd_petugas);
} else {
	header('Location: home.php');
}
if (isset($_POST['tombol_update'])) {
	$kd_KK = $_POST['no_kkx'];
	$id = $_POST['no_kkReal'];
	$nama_kk = $_POST['nama_kepalaKeluargax'];
	$almt = $_POST['alamatx'];
	$rt = $_POST['rtx'];
	$rw = $_POST['rwx'];
	$kode_ps = $_POST['zipx'];
	$kel = $_POST['kelurahanx'];
	$kec = $_POST['kecamatanx'];
	$kab = $_POST['kabupatenx'];
	$prov = $_POST['propinsix'];
	$tglSah = $_POST['tglsahKKx'];


	$status_update = $lib->updateKartuKeluargaPetugas($id, $kd_KK, $nama_kk, $almt, $rt, $rw, $kode_ps, $kel, $kec, $kab, $prov, $tglSah);
	if ($status_update) {
		echo "<script type='text/javascript'>alert('Berhasil Mengubah Data Kartu Keluarga!');window.location.href = 'tabel_data_kartu_keluarga.php';</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPPDB - Form Edit Kartu Keluarga</title>
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
					<a class="nav-link" href="../config/logout_petugas.php" role="button">
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
			if ($jk = $data_petugas2["jenis_kelamin"] == 'p') {
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
						<a href="profile.php" class="d-block"><?php echo $data_petugas2['nama_lengkap_petugas']; ?></a>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
						<li class="nav-item">
							<a href="home.php" class="nav-link">
								<i class="nav-icon fas fa-home"></i>
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
									<a href="form_kartu_keluarga.php" class="nav-link bg-cyan">
										<i class="fas fa-circle nav-icon"></i>
										<p>Kartu Keluarga</p>
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
								<li class="nav-item">
									<a href="ktp_baru.php" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>KTP Baru</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="kk_baru.php" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>KK Baru</p>
									</a>
								</li>
							</ul>
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
									<a href="tabel_data_kartu_keluarga.php" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Kartu Keluarga</p>
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
							<h1>Formulir Kartu Keluarga</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="home.php">Beranda</a></li>
								<li class="breadcrumb-item active">Formulir</li>
								<li class="breadcrumb-item active">Formulir Kartu Keluarga</li>
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
							<h3 class="card-title">Silahkan isi Form Kartu Keluarga</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<form action="" method="post">
										<div class="form-group">
											<label>Nomor Kartu keluarga:</label>
											<input type="hidden" name="no_kkReal" value="<?php echo $data_kartuKeluarga['no_kk']; ?>" />
											<div class="input-group">
												<input type="text" class="form-control" name="no_kkx" value="<?php echo $data_kartuKeluarga['no_kk']; ?>" placeholder="Masukan Nomor Kartu Keluarga">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-id-badge"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Nama Kepala Keluarga:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="nama_kepalaKeluargax" value="<?php echo $data_kartuKeluarga['nama_kepalaKeluarga']; ?>" placeholder="Masukan Nama Kepala Keluarga">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-user-alt"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Alamat:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="alamatx" value="<?php echo $data_kartuKeluarga['alamat']; ?>" placeholder="Masukan Alamat Kartu Keluarga">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-map-marked"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group inline">
											<label>RT:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="rtx" value="<?php echo $data_kartuKeluarga['rt']; ?>" placeholder="Masukan RT">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-thumbtack"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>RW:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="rwx" value="<?php echo $data_kartuKeluarga['rw']; ?>" placeholder="Masukan RW">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-thumbtack"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Kode Pos:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="zipx" value="<?php echo $data_kartuKeluarga['zip']; ?>" placeholder="Masukan Kode Pos">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-certificate"></i></div>
												</div>
											</div>
										</div>
										<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label>Kelurahan:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="kelurahanx" readonly value="Bahagia" placeholder="Masukan Kelurahan">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-map"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Kecamatan:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="kecamatanx" value="<?php echo $data_kartuKeluarga['kecamatan']; ?>" placeholder="Masukan Kecamatan">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-map"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Kabupaten/Kota:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="kabupatenx" value="<?php echo $data_kartuKeluarga['kabupaten']; ?>" placeholder="Masukan Kabupaten/Kota">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-map-signs"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Provinsi:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="propinsix" value="<?php echo $data_kartuKeluarga['kecamatan']; ?>" placeholder="Masukan Provinsi">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-map"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Tanggal Disahkan Kartu Keluarga:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="tglsahKKx" value="<?php echo $data_kartuKeluarga['tglsahKK']; ?>" placeholder="Masukan Tanggal Sah Kartu Keluarga">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group text-right">
										<input type="submit" name="tombol_update" class="btn btn-info" value="Update">
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