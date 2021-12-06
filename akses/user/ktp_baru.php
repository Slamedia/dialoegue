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
$last = $_SESSION["last_name"];
//session
//library
include('../config/library.php');
$lib = new Library();
if (isset($_SESSION['nik'])) {
	$kd_penduduk = $_SESSION['nik'];
	$data_penduduk = $lib->get_by_id_user($kd_penduduk);
} else {
	header('Location: index.php');
}

$data_petugas = $lib->showPetugas();
if (isset($_POST['tombol_tambah'])) {
	$kd = $_POST['id_pelayananx'];
	$kd_p = $_POST['nik_pendudukx'];
	$nama = $_POST['nama_pendudukx'];
	$tgl = $_POST['tanggal_ajukanx'];
	$ket = $_POST['keterangan_pelayanan'];
	$nip = $_POST['nip'];

	//batas rt rw
	$sek = 	$_FILES['gambar_rt_rwx']['name'];
	$ukuran_file = $_FILES['gambar_rt_rwx']['size'];
	$tipe_file = $_FILES['gambar_rt_rwx']['type'];
	$tmp = $_FILES['gambar_rt_rwx']['tmp_name'];

	//batas kartu keluarga
	$kk = $_FILES['gambar_kkx']['name'];
	$ukuran_file2 = $_FILES['gambar_kkx']['size'];
	$tipe_file2 = $_FILES['gambar_kkx']['type'];
	$tmp2 = $_FILES['gambar_kkx']['tmp_name'];

	$sts = $_POST['status_pengajuan_prosesx'];

	$add_status = $lib->registrasiPelayananKTP(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$kk,
		$ukuran_file2,
		$tipe_file2,
		$tmp2,
		$sts,
		$nip
	);
	if ($add_status) {
		echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan KTP!');window.location.href = 'ktp_baru.php';</script>";
	} else {
		echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan KTP, Silahkan Hubungi Admin Melalui Kontak Kami :)');window.location.href = 'ktp_baru.php';</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPPDB - Pelayanan KTP Baru</title>
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
							<a href="#" class="nav-link bg-cyan">
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
									<a href="#" class="nav-link bg-cyan">
										<i class="nav-icon fas fa-list"></i>
										<p>
											Kartu Tanda Penduduk <i class="right fas fa-angle-left"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a href="ktp_baru.php" class="nav-link bg-cyan">
												<i class="fas fa-circle nav-icon"></i>
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
							<h1>Formulir Pelayanan KTP Baru</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
								<li class="breadcrumb-item active">Formulir</li>
								<li class="breadcrumb-item active">Formulir Pelayanan KTP Baru</li>
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
							<h3 class="card-title">Silahkan isi Form Pelayanan</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<form id="form1" action="" method="post" enctype="multipart/form-data">
										<?php
										date_default_timezone_set("Asia/Jakarta");
										$id_pelayanan_date = date('dmYHis');
										$tgl_format = date('Y-m-d');
										?>
										<div class="form-group">
											<label>Kode Pelayanan:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="id_pelayananx" readonly value="<?php echo $id_pelayanan_date; ?>" placeholder="Masukan NIK">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fas fa-id-card"></i></div>
												</div>
											</div>
										</div>
										<!--auto-->
										<div class="form-group">
											<label>NIK Penduduk:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="nik_pendudukx" readonly value="<?php echo $id_user; ?>" placeholder="Masukan Nomor NIK">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fas fa-id-badge"></i></div>
												</div>
											</div>
										</div>
										<!--auto-->
										<div class="form-group">
											<label>Nama Pemohon:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="nama_pendudukx" readonly value="<?php echo $username . " " . $last ?>" placeholder="Masukan Nama Pemohon">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-user"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group inline">
											<label>Tanggal Pengajuan:</label>
											<div class="input-group">
												<input type="text" class="form-control" readonly value="<?php echo $tgl_format; ?>" name="tanggal_ajukanx" placeholder="Masukan Tanggal Pengajuan">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Di Ajukan Kepada:</label>
											<select class="form-control" name="nip">
												<option selected>Pilih NIP Petugas</option>
												<?php
												foreach ($data_petugas as $row) {
												?>
													<option value="<?php echo $row["nip"]; ?>"><?php echo $row["nip"] . " - " . $row["nama_lengkap_petugas"] . " - " . $row['status']; ?></option>;
												<?php	}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Pelayanan:</label>
											<div class="input-group">
												<input type="text" class="form-control" readonly value="Membuat KTP Baru" name="keterangan_pelayanan" placeholder="Masukan Pelayanan">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-bars"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="exampleInputFile">Surat Rt/Rw(max-size-file:2 Mb): <font color="red">*(wajib)</font></label>
											<input type="file" name="gambar_rt_rwx" class="form-control-file" id="exampleFormControlFile1">
										</div>
										<!-- /.form-group -->
								</div>
								<!-- /.col -->
								<div class="col-md-6" id="tampil">
									<div class="form-group">
										<label for="exampleInputFile">Foto Kartu Keluarga Asli(max-size-file:2 Mb): <font color="red">*(wajib)</font></label>
										<input type="file" name="gambar_kkx" class="form-control-file" id="exampleFormControlFile1">
									</div>
									<div class="form-group">
										<label>Status Pengajuan:</label>
										<div class="input-group">
											<input type="text" class="form-control" readonly value="Dikirim" name="status_pengajuan_prosesx" placeholder="Masukan Status Pengajuan">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-envelope"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group text-right">
										<input type="submit" name="tombol_tambah" class="btn btn-success" value="Tambah">
										<input type="reset" class="btn btn-danger" value="Batal">
									</div>
									<div class="form-group">
										<i class="fa fa-exclamation-triangle"></i> <label> Keterangan Pengajuan Pelayanan:</label>
										<p>
											<font color="red">*Untuk KTP Kehilangan Tersedia Di Menu Khusus KTP Kehilangan.</font><br>
											<font color="red">*Untuk KTP Baru pindah Tersedia Di Menu Khusus KTP Pindah.</font>
										</p>
									</div>
									<div class="form-group">
										<i class="fa fa-info-circle"></i> <label> Info Pelayanan:</label>
										<p>
											<font color="blue">*Petugas akan mengecek dan membuat surat permohonan untuk kecamatan apabila surat-surat terpenuhi jika dokumen kurang lengkap maka petugas akan memberikan keterangan dan menunda layanan sampai melengkapi kekurangan dokumen.</font>
										</p>
									</div>
									</form>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							Form KTP Baru
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