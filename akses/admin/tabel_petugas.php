<?php
date_default_timezone_set("Asia/Jakarta");
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
//Library koneksi
include('../config/library.php');
$lib = new Library();
$data_petugas = $lib->showPetugas();

if (isset($_GET['id_akses_login'])) {
	$kd_petugas = $_GET['id_akses_login'];
	$status_hapus = $lib->deletePetugas($kd_petugas);
	if ($status_hapus) {
		header('Location:tabel_petugas.php');
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPPDB - Informasi Petugas</title>
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
						<a href="#" class="d-block"><?php echo $username; ?></a>
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
							<a href="#" class="nav-link">
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
									<a href="form_admin.php" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Admin</p>
									</a>
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
									<a href="tabel_petugas.php" class="nav-link bg-cyan">
										<i class="fas fa-circle nav-icon"></i>
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
							<h1>Informasi Petugas</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Beranda</a></li>
								<li class="breadcrumb-item active">Tabel Data</li>
								<li class="breadcrumb-item active">Informasi Petugas</li>
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
									<h3 class="card-title">Tabel Data Petugas <a target="_blank" href='print_data_petugas.php' class='btn btn-default'><i class='fa fa-print'></i> Print</a> <a href='javascript:exportData()' class='btn btn-success'><i class='fas fa-file-excel'></i> Export Excel</a></h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div style="overflow-x:auto;" class="table-responsive">
										<table id="dtHorizontalVerticalExample" class="table table-bordered table-striped" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>No</th>
													<th>NIP</th>
													<th>Nama Lengkap Petugas</th>
													<th>Jenis Kelamin</th>
													<th>Email</th>
													<th>Password</th>
													<th>Alamat</th>
													<th>Nomor Handphone</th>
													<th>Hak Akses</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												foreach ($data_petugas as $row) {
													if ($row['jenis_kelamin'] == 'p') {
														$jk = "Pria";
													} else if ($row['jenis_kelamin'] == 'w') {
														$jk = "Wanita";
													} else {
														$jk = "<font color='red'>Kosong</font>";
													}
													echo "<tr>";
													echo "<td>" . $no . "</td>";
													echo "<td>" . $row['nip'] . "</td>";
													echo "<td>" . $row['nama_lengkap_petugas'] . "</td>";
													echo "<td>" . $jk . "</td>";
													echo "<td>" . $row['email'] . "</td>";
													echo "<td>" . $row['password'] . "</td>";
													echo "<td>" . $row['alamat'] . "</td>";
													echo "<td>" . $row['no_tlp'] . "</td>";
													echo "<td>" . $row['akses'] . "</td>";
													echo "<td><a href='form_edit_petugas.php?id_akses_login=" . $row['id_akses_login'] . "' class='btn btn-info'>Update</a>
											<a href='tabel_petugas.php?id_akses_login=" . $row['id_akses_login'] . "' class='btn btn-danger'>Hapus</button></td>";
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
		function exportData() {
			if (confirm("Apakah anda ingin export Data Petugas?")) {
				window.location.href = 'export_excel_petugas.php';
			} else {
				alert('Batal export Data Petugas!');
				window.location.href = 'tabel_petugas.php?export=batal';
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