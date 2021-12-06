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
$id = $_SESSION["id_pen"];
//session_
//library
include('../config/library.php');
$lib = new Library();
$data_KK = $lib->showKartuKeluarga();

// if (isset($_GET['hapus_kk'])) {
// 	$kd_KK = $_GET['hapus_kk'];
// 	$status_hapus = $lib->delete_kk($kd_KK);
// 	if ($status_hapus) {
// 		echo "<script type='text/javascript'>alert('Berhasil Menghapus Data Kartu Keluarga!');window.location.href = 'index.php';</script>";
// 	} else {
// 		echo "Gagal";
// 	}
// }

if (isset($_GET['hapus_anggota'])) {
	$kk_anggota = $_GET['hapus_anggota'];
	$status_hapus = $lib->delete_anggotaKel($kk_anggota);
	if ($status_hapus) {
		echo "<script type='text/javascript'>alert('Berhasil Menghapus Data Anggota Keluarga!');window .location.href = 'index.php';</script>";
	} else {
		echo "<script type='text/javascript'>alert('Gagal Menghapus Data Anggota Keluarga, Silahkan Hubungi Admin Melalui Kontak Pada Halaman Utama Kami :)');window.location.href = 'index.php';</script>";
	}
}

if (isset($_SESSION['nik'])) {
	$kd_penduduk = $_SESSION['nik'];
	$data_penduduk = $lib->get_by_id_user($kd_penduduk);
} else {
	header('Location: index.php');
}

if (isset($_SESSION['no_kk'])) {
	$kd_kk = $_SESSION['no_kk'];
	$data_kk2 = $lib->get_by_id_userKartuKeluarga($kd_kk);
} else {
	header('Location: index.php');
}

if (isset($_SESSION['no_kk'])) {
	$kd_kk_A = $_SESSION['no_kk'];
	$data_kk3 = $lib->get_by_id_userAnggotaKeluarga($kd_kk_A);
} else {
	header('Location: index.php');
}

if (isset($_GET['hapus_pelayanan'])) {
	$kd_pelayanan = $_GET['hapus_pelayanan'];
	$status_hapus = $lib->delete_pelayanan($kd_pelayanan);
	if ($status_hapus) {
		echo "<script type='text/javascript'>alert('Berhasil Menghapus Data Pelayanan!');window .location.href = 'index.php';</script>";
	} else {
		echo "<script type='text/javascript'>alert('Gagal Menghapus Data Pelayanan, Silahkan Hubungi Admin Melalui Kontak Pada Halaman Utama Kami :)');window.location.href = 'index.php';</script>";
	}
}


$data_akunPetugas = $lib->countAkunPetugas();
$data_akunPenduduk = $lib->countAkunPenduduk();
$data_akunAdmin = $lib->countAkunAdmin();
$data_kk = $lib->countKK();
$data_pelayanan = $lib->countPelayanan();
$data_riwayat_login = $lib->countRiwayatLogin();
$data_pesan = $lib->countPesan();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPPDB - Beranda Penduduk</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--icon-->
	<link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../library/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="../../library/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="../../library/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../library/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../library/dist/css/adminlte.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="../../library/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
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

		/* Center the loader */

		#loader1 {
			width: 50px;
			height: 50px;
			border: solid 5px white;
			border-top-color: #005380;
			border-radius: 100%;

			position: fixed;
			left: 0;
			top: 0;
			right: 0;
			bottom: 0;
			margin: auto;

			animation: putar 2s infinite;
		}

		#loader2 {
			width: 15px;
			height: 15px;
			border: solid 5px white;
			/* border-top-color: #005380; */
			background-color: #005380;
			border-radius: 100%;

			position: fixed;
			left: 0;
			top: 0;
			right: 0;
			bottom: 0;
			margin: auto;

			animation: putar 2s infinite;
		}

		#loader3 {
			width: 30px;
			height: 30px;
			border: solid 5px white;
			border-top-color: #005380;
			border-radius: 100%;

			position: fixed;
			left: 0;
			top: 0;
			right: 0;
			bottom: 0;
			margin: auto;

			animation: putar2 2s infinite;
		}

		#loader4 {
			width: 70px;
			height: 70px;
			border: solid 5px white;
			border-top-color: #005380;
			border-radius: 100%;

			position: fixed;
			left: 0;
			top: 0;
			right: 0;
			bottom: 0;
			margin: auto;


			animation: putar2 4s infinite;
		}

		@keyframes putar {
			from {
				transform: rotate(0deg);
			}

			to {
				transform: rotate(360deg);
			}
		}

		@keyframes putar2 {
			from {
				transform: rotate(180deg);
			}

			to {
				transform: rotate(0deg);
			}
		}

		@-webkit-keyframes putar {

			0% {
				-webkit-transform: rotate(0deg);
			}

			100% {
				-webkit-transform: rotate(360deg);
			}

		}

		@-webkit-keyframes putar2 {

			0% {
				-webkit-transform: rotate(180deg);
			}

			100% {
				-webkit-transform: rotate(0deg);
			}

		}



		/* Add animation to "page content" */

		.fade-in {
			animation: fadeIn ease 2s;
			-webkit-animation: fadeIn ease 2s;
			-moz-animation: fadeIn ease 2s;
			-o-animation: fadeIn ease 2s;
			-ms-animation: fadeIn ease 2s;
		}

		@keyframes fadeIn {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		@-moz-keyframes fadeIn {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		@-webkit-keyframes fadeIn {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		@-o-keyframes fadeIn {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		@-ms-keyframes fadeIn {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		#textTitle {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			text-align: center;
			margin-top: 18%;
			font-size: 28px;
			color: #005380;
		}

		#myDiv {

			display: none;

		}
	</style>
</head>

<body onload="myFunctionLoad()" style="margin:0;" class="hold-transition sidebar-mini">
	<div id="loader1"></div>
	<div id="loader2"></div>
	<div id="loader3"></div>
	<div id="loader4"></div>
	<div id="textTitle" class="fade-in">SPPDB</div>
	<div style="display:none;" id="myDiv" class="fade-in">
		<div class="wrapper">

			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
					<li class="nav-item d-none d-sm-inline-block">
						<a href="index.php" class="nav-link bg-dark">Beranda</a>
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
							<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
							<li class="nav-item">
								<a href="#" class="nav-link bg-cyan">
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
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0 text-dark">Halo, Selamat datang <?php echo $data_penduduk['first_name']; ?></h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item active">Beranda</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<!-- Small boxes (Stat box) -->
						<div class="row">
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?php echo $data_akunPenduduk; ?></h3>
										<p>Penduduk</p>
									</div>
									<div class="icon">
										<i class="fa fa-users"></i>
									</div>
									<div class="modal fade" id="modal-default-penduduk">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-info">
													<h4 class="modal-title" style="color: #fff;"><i class="fa fa-info-circle"></i> Penduduk</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p style="color:black;">Penduduk yang sudah terdaftar didalam sistem sppdb sebanyak <b>
															<font color="red"><?php echo $data_akunPenduduk; ?></font>
														</b> orang penduduk.</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-default-penduduk">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?php echo $data_kk; ?><sup style="font-size: 20px"></sup></h3>

										<p>Kartu Keluarga</p>
									</div>
									<div class="icon">
										<i class="fa fa-folder-open"></i>
									</div>
									<div class="modal fade" id="modal-default-kk">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-info">
													<h4 class="modal-title" style="color: #fff;"><i class="fa fa-info-circle"></i> Kartu Keluarga</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p style="color:black;">Kartu keluarga yang sudah disimpan didalam sistem sppdb sebanyak <b>
															<font color="red"><?php echo $data_kk; ?></font>
														</b> kartu keluarga.</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
									<a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-default-kk">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-secondary">
									<div class="inner">
										<h3><?php $total = 0;
											$total = $data_akunPetugas + $data_akunAdmin + $data_akunPenduduk;
											echo $total; ?></h3>

										<p>Akun Pengguna</p>
									</div>
									<div class="icon">
										<i class="ion ion-person-add"></i>
									</div>
									<div class="modal fade" id="modal-default-pengguna">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-info">
													<h4 class="modal-title" style="color: #fff;"><i class="fa fa-info-circle"></i> Pengguna</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p style="color:black;">Pengguna yang sudah disimpan didalam sistem sppdb sebanyak <b>
															<font color="red"><?php echo $total; ?></font>
														</b> pengguna. <b>
															<font color="green"><?php echo $data_akunAdmin; ?></font>
														</b> untuk admin, <b>
															<font color="green"><?php echo $data_akunPetugas; ?></font>
														</b> untuk petugas, <b>
															<font color="green"><?php echo $data_akunPenduduk; ?></font>
														</b> untuk penduduk.</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-default-pengguna">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-danger">
									<div class="inner">
										<h3><?php echo $data_pelayanan; ?><sup style="font-size: 20px"></sup></h3>
										<p>Pelayanan</p>
									</div>
									<div class="icon">
										<i class="fa fa-globe"></i>
									</div>
									<div class="modal fade" id="modal-default-pelayanan">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-info">
													<h4 class="modal-title" style="color: #fff;"><i class="fa fa-info-circle"></i> Pelayanan</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<p style="color:black;">Pelayanan yang sudah disimpan didalam sistem sppdb sebanyak <b>
															<font color="red"><?php echo $data_pelayanan; ?></font>
														</b> pelayanan.</p>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
									<a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-default-pelayanan">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
						</div>
						<!-- /.row (main row) -->
						<div class="row">
							<div class="col-12">
								<?php if ($data_penduduk['no_kk'] == 'Empty') {
									$no_kk = "<font color='red'>Empty</font>";
									$msg = "<div class='alert alert-danger' role='alert'>
									<i class='fa fa-info-circle'></i> Untuk melakukan pelayanan diharapkan untuk mengisi nomor Kartu Keluarga! <b><a href='form_edit_penduduk.php?id_pen=" . $data_penduduk['id_pen'] . "'>Klik Disini</a></b>
				</div>";
								} else if ($data_penduduk['Goldarah'] == '') {
									$no_kk = "<a href='#'>" . $data_penduduk['no_kk'] . "</a>";
									$msg = '<div class="alert alert-warning" role="alert">
										<i class="fa fa-info-circle"></i> Silahkan melakukan pengubahan data kartu keluarga, <b>Lakukan Sebelum melakukan pelayanan!</b>
									</div>';
								} else if ($data_penduduk['no_kk'] != 'Empty') {
									$no_kk = "<a href='#'>" . $data_penduduk['no_kk'] . "</a>";
									$msg = '<div class="alert alert-success" role="alert">
										<i class="fa fa-info-circle"></i> Data Kartu Keluarga Lengkap, anda sudah bisa mengajukan <b>Pelayanan!, pastikan data anggota keluarga sudah benar</b>
				</div>';
								}
								echo $msg;
								?>
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Data Diri</h3>
									</div>
									<!-- /.card-header -->
									<div class="card-body">
										<div style="overflow-x:auto;" class="table-responsive">
											<table id="dtHorizontalVerticalExample" class="table table-bordered table-striped" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>No</th>
														<th>NIK</th>
														<th>Nomor Kartu Keluarga</th>
														<th>Nama Depan</th>
														<th>Nama Belakang</th>
														<th>Agama</th>
														<th>Pekerjaan</th>
														<th>Kewarganegaraan</th>
														<th>Status Hubungan Keluarga</th>
														<th>Status Perkawinan</th>
														<th>Tempat Tanggal Lahir</th>
														<th>Jenis Kelamin</th>
														<th>Gol Darah</th>
														<th>No Telepon</th>
														<th>Email</th>
														<th>Password</th>
														<th>Tanggal Registrasi Akun</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$no = 1;
													$tgl_format1 = $data_penduduk['tanggal_lahir'];
													$tgl_format2 = date("d F Y", strtotime($tgl_format1));
													if ($data_penduduk['jenis_kelamin'] == 'p') {
														$jk = "Pria";
													} else if ($data_penduduk['jenis_kelamin'] == 'w') {
														$jk = "Wanita";
													} else {
														$jk = "<font color='red'>Kosong</font>";
													}
													echo "<tr>";
													echo "<td>" . $no . "</td>";
													echo "<td>" . $data_penduduk['nik'] . "</td>";
													echo "<td>" . $no_kk . "</td>";
													echo "<td>" . $data_penduduk['first_name'] . "</td>";
													echo "<td>" . $data_penduduk['last_name'] . "</td>";
													echo "<td>" . $data_penduduk['agama'] . "</td>";
													echo "<td>" . $data_penduduk['pekerjaan'] . "</td>";
													echo "<td>" . $data_penduduk['kewarganegaraan'] . "</td>";
													echo "<td>" . $data_penduduk['status_hub_kel'] . "</td>";
													echo "<td>" . $data_penduduk['status_perkawinan'] . "</td>";
													echo "<td>" . $data_penduduk['tempat_lahir'] . ", " . $tgl_format2 . "</td>";
													echo "<td>" . $jk . "</td>";
													echo "<td>" . $data_penduduk['Goldarah'] . "</td>";
													echo "<td>" . $data_penduduk['notlp'] . "</td>";
													echo "<td>" . $data_penduduk['email'] . "</td>";
													echo "<td>" . $data_penduduk['password'] . "</td>";
													echo "<td>" . $data_penduduk['tanggal_daftar'] . "</td>";
													echo "<td><a href='form_edit_penduduk.php?id_pen=" . $_SESSION['id_pen'] . "' class='btn btn-info'>Update</a></td>";
													echo "</tr>";
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
						<div class="row">
							<div class="col-12">
								<?php if ($data_kk2['no_kk'] == 'Empty') {
									$no_kk2 = "<font color='red'>Empty</font>";
									$msg2 = "<div class='alert alert-danger' role='alert'>
									<i class='fa fa-info-circle'></i> Untuk melakukan pelayanan diharapkan untuk mengisi nomor Kartu Keluarga! <b><a href='form_edit_penduduk.php?id_pen=" . $data_penduduk['id_pen'] . "'>Klik Disini</a></b>
				</div>";
								} else if ($data_kk2['nama_kepalaKeluarga'] == '') {
									$no_kk2 = "<a href='#'>" . $data_kk2['no_kk'] . "</a>";
									$msg2 = '<div class="alert alert-warning" role="alert">
										<i class="fa fa-info-circle"></i> Silahkan melakukan pengubahan data kartu keluarga, <b>Lakukan Sebelum melakukan pelayanan!</b>
									</div>';
								} else if ($data_kk2['no_kk'] != 'Empty') {
									$no_kk2 = "<a href='#'>" . $data_kk2['no_kk'] . "</a>";
									$msg2 = '<div class="alert alert-success" role="alert">
									<i class="fa fa-info-circle"></i> Data Kartu Keluarga Lengkap, anda sudah bisa mengajukan <b>Pelayanan!, pastikan data anggota keluarga sudah benar</b>
				</div>';
								}
								echo $msg2;
								?>
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Kartu Keluarga
											<?php
											if ($data_kk2 > 0) {
												echo $data = '';
											} else {
												echo $data = '<a class="btn btn-success" href="form_kartu_keluarga.php"><i class="fa fa-plus"></i> Tambah Data Kartu Keluarga</a>';
											}
											?></h3>

									</div>
									<!-- /.card-header -->
									<div class="card-body">
										<div style="overflow-x:auto;" class="table-responsive">
											<table id="dtHorizontalVerticalExample" class="table table-bordered table-striped" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>No</th>
														<th>Nomor Kartu Keluarga</th>
														<th>Nama Kepala Keluarga</th>
														<th>Alamat</th>
														<th>RT</th>
														<th>RW</th>
														<th>Kode Pos</th>
														<th>Kelurahan</th>
														<th>Kecamatan</th>
														<th>Kabupaten</th>
														<th>Provinsi</th>
														<th>Tanggal Sah Kartu Keluarga</th>
														<th>Tanggal Perubahan Data</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$no = 1;

													echo "<tr>";
													echo "<td>" . $no . "</td>";
													echo "<td>" . $no_kk2 . "</td>";
													echo "<td>" . $data_kk2['nama_kepalaKeluarga'] . "</td>";
													echo "<td>" . $data_kk2['alamat'] . "</td>";
													echo "<td>" . $data_kk2['rt'] . "</td>";
													echo "<td>" . $data_kk2['rw'] . "</td>";
													echo "<td>" . $data_kk2['zip'] . "</td>";
													echo "<td>" . $data_kk2['kelurahan'] . "</td>";
													echo "<td>" . $data_kk2['kecamatan'] . "</td>";
													echo "<td>" . $data_kk2['kabupaten'] . "</td>";
													echo "<td>" . $data_kk2['propinsi'] . "</td>";
													echo "<td>" . $data_kk2['tglsahKK'] . "</td>";
													echo "<td>" . $data_kk2['tgl_update'] . "</td>";
													echo "<td><a href='form_edit_kartu_keluarga.php?id_kk=" . $data_kk2['id_kk'] . "' class='btn btn-info'>Update</a></td>";
													echo "</tr>";
													$no++;
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
						<!-- row -->
						<div class="row">
							<div class="col-12">
								<?php echo $msg; ?>
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Anggota Keluarga</h3>
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
														<a href='index.php?hapus_anggota=" . $row2['id_anggota'] . "' class='btn btn-danger'>Hapus</a></td>";
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
	</div>
	<!-- animation-load -->
	<script type="text/javascript">
		// Loading Page

		var myVar;



		function myFunctionLoad() {

			myVar = setTimeout(showPage, 4000);

		}



		function showPage() {

			document.getElementById("loader1").style.display = "none";
			document.getElementById("loader2").style.display = "none";
			document.getElementById("loader3").style.display = "none";
			document.getElementById("loader4").style.display = "none";
			document.getElementById("textTitle").style.display = "none";


			document.getElementById("myDiv").style.display = "block";

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
				"scrollY": 400,
			});
			$('.dataTables_length').addClass('bs-select');
		});
	</script>
	<!-- jQuery -->
	<script src="../../library/plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="../../library/plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- DataTables -->
	<script src="../../library/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../library/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../../library/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../library/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="../../library/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="../../library/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="../../library/dist/js/adminlte.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="../../library/dist/js/pages/dashboard.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../library/dist/js/demo.js"></script>
</body>

</html>