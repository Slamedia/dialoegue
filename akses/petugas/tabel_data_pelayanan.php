<?php
date_default_timezone_set("Asia/Jakarta");
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
//Library koneksi
include('../config/library.php');
$lib = new Library();
$data_pelayanan = $lib->showPelayanan();
if (isset($_SESSION['nip'])) {
	$kd_petugas = $_SESSION['nip'];
	$data_petugas2 = $lib->get_by_id_userPetugas($kd_petugas);
} else {
	header('Location: home.php');
}

if (isset($_GET['hapus_pelayanan'])) {
	$kd_pelayanan = $_GET['hapus_pelayanan'];
	$status_hapus = $lib->delete_pelayanan($kd_pelayanan);
	if ($status_hapus) {
		echo "<script type='text/javascript'>alert('Berhasil Menghapus Data Pelayanan!');window .location.href = 'tabel_data_pelayanan.php';</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPPDB - Informasi Pelayanan</title>
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
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-edit"></i>
								<p>
									Forms
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="form_kartu_keluarga.php" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
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
									<a href="tabel_data_kartu_keluarga.php" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Kartu Keluarga</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="tabel_data_pelayanan.php" class="nav-link bg-cyan">
										<i class="fas fa-circle nav-icon"></i>
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
							<h1>Informasi Pelayanan</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Beranda</a></li>
								<li class="breadcrumb-item active">Tabel Data</li>
								<li class="breadcrumb-item active">Informasi Pelayanan</li>
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
									<h3 class="card-title">Tabel Data Pelayanan</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div style="overflow-x:auto;" class="table-responsive">
										<table id="dtHorizontalVerticalExample" class="table table-bordered table-striped" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>No</th>
													<th>ID Pelayanan</th>
													<th>NIK</th>
													<th>Nama Penduduk</th>
													<th>Tanggal Pengajuan</th>
													<th>Keterangan Pelayanan</th>
													<th>Foto Surat RT/RW</th>
													<th>Foto Kartu Keluarga</th>
													<th>Foto Akte Kelahiran</th>
													<th>Foto Surat Nikah</th>
													<th>Foto Keterangan Pindah</th>
													<th>Foto Surat Kehilangan</th>
													<th>NIP Petugas</th>
													<th>Nama Petugas</th>
													<th>Status Proses Pengajuan</th>
													<th>Tanggal Proses</th>
													<th>Keterangan</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												$proses = '';
												$tampil = '';
												foreach ($data_pelayanan as $row) {
													//gambar status proses pengajuan
													if ($row['status_proses_pengajuan'] == 'Dikirim') {
														$proses = "<center><a href='#kirim' class='btn btn-warning'><i class='fa fa-paper-plane'></i> Kirim</a></center>";
													} else if ($row['status_proses_pengajuan'] == 'diproses') {
														$proses = "<center><a href='#batal' class='btn btn-info'><i class='fa fa-clock'></i> Sedang Kami Proses</a></center>";
													} else if ($row['status_proses_pengajuan'] == 'batal') {
														$proses = "<center><a href='#batal' class='btn btn-danger'><i class='fa fa-ban'></i> Batal</a></center>";
													} else {
														$proses = "<center><a href='#success' class='btn btn-success'><i class='fa fa-check'></i> Selesai</a></center>";
													}
													//gambar nikah
													if ($row['gambar_surat_nikah'] == 'Empty') {
														$tampil1 = "<font color='red'>Empty</font>";
													} else if ($row['gambar_surat_nikah'] == '') {
														$tampil2 = "<font color='red'>Empty</font>";
													} else {
														$tampil1 = "<a target='_blank' href='../../berkas/surat_nikah/" . $row["gambar_surat_nikah"] . "'>" . $row["gambar_surat_nikah"] . "</a>";
													}
													//gambar_akte
													if ($row['gambar_akte'] == 'Empty') {
														$tampil = "<font color='red'>Empty</font>";
													} else if ($row['gambar_akte'] == '') {
														$tampil2 = "<font color='red'>Empty</font>";
													} else {
														$tampil = "<a target='_blank' href='../../berkas/surat_akte/" . $row["gambar_akte"] . "'>" . $row["gambar_akte"] . "</a>";
													}
													//surat keterangan pindah
													if ($row['surat_keterangan_pindah'] == 'Empty') {
														$tampil2 = "<font color='red'>Empty</font>";
													} else if ($row['surat_keterangan_pindah'] == '') {
														$tampil2 = "<font color='red'>Empty</font>";
													} else {
														$tampil2 = "<a target='_blank' href='../../berkas/keterangan_pindah/" . $row["surat_keterangan_pindah"] . "'>" . $row["surat_keterangan_pindah"] . "</a>";
													}
													//surat kehilangan
													if ($row['gambar_surat_kehilangan'] == 'Empty') {
														$tampil3 = "<font color='red'>Empty</font>";
													} else if ($row['gambar_surat_kehilangan'] == '') {
														$tampil3 = "<font color='red'>Empty</font>";
													} else {
														$tampil3 = "<a target='_blank' href='../../berkas/surat_kehilangan/" . $row["gambar_surat_kehilangan"] . "'>" . $row["gambar_surat_kehilangan"] . "</a>";
													}


													//echo "<td>"."<img src='../../berkas/rtrw/".$row["gambar_rt_rw"]."'style='width:200px; height:100px;'>"."</a></td>";
													//echo "<td>".$row['gambar_surat_nikah']."</td>";
													//echo "<td>".$row['gambar_rt_rw']."</td>";
													//echo "<td>".$row['gambar_kk']."</td>";
													//echo "<td>".$row['gambar_akte']."</td>";
													//echo "<td>"."<a target='_blank' href='../../berkas/keterangan_pindah/".$row["surat_keterangan_pindah"]."'>".$row["surat_keterangan_pindah"]."</a></td>";
													//echo "<td>".$row['gambar_surat_kehilangan']."</td>";
													echo "<tr>";
													echo "<td>" . $no . "</td>";
													echo "<td>" . $row['id_pelayanan'] . "</td>";
													echo "<td>" . $row['nik_penduduk'] . "</td>";
													echo "<td>" . $row['nama_penduduk'] . "</td>";
													echo "<td>" . $row['tanggal_ajukan'] . "</td>";
													echo "<td>" . $row['keterangan_pelayanan'] . "</td>";
													echo "<td>" . "<a target='_blank' href='../../berkas/rtrw/" . $row["gambar_rt_rw"] . "'>" . $row["gambar_rt_rw"] . "</td>";
													echo "<td>" . "<a target='_blank' href='../../berkas/kk/" . $row["gambar_kk"] . "'>" . $row["gambar_kk"] . "</td>";
													//echo "<td>"."<a target='_blank' href='../../berkas/surat_akte/".$row["gambar_akte"]."'>".$row["gambar_akte"]."</a></td>";
													//echo "<td>"."<a target='_blank' href='../../berkas/surat_nikah/".$row["gambar_surat_nikah"]."'>".$row["gambar_surat_nikah"]."</a></td>";
													echo "<td>" . $tampil . "</td>";
													echo "<td>" . $tampil1 . "</td>";
													echo "<td>" . $tampil2 . "</td>";
													echo "<td>" . $tampil3 . "</td>";
													//echo "<td>"."<a target='_blank' href='../../berkas/keterangan_pindah/".$row["surat_keterangan_pindah"]."'>".$row["surat_keterangan_pindah"]."</a></td>";
													//echo "<td>"."<a target='_blank' href='../../berkas/surat_kehilangan/".$row["gambar_surat_kehilangan"]."'>".$row["gambar_surat_kehilangan"]."</a></td>";
													echo "<td>" . $row['nip_petugas'] . "</td>";
													echo "<td>" . $row['nama_petugas'] . "</td>";
													echo "<td>" . $proses . "</td>";
													echo "<td>" . $row['tanggal_proses'] . "</td>";
													echo "<td>" . $row['keterangan'] . "</td>";
													echo "<td><a href='form_edit_pelayanan.php?id_pelayanan=" . $row['id_pelayanan'] . "' class='btn btn-info'><i class='fa fa-edit'></i> Proses</a>
													<a href='tabel_data_pelayanan.php?hapus_pelayanan=" . $row['id_pelayanan'] . "' class='btn btn-danger'><i class='fa fa-trash'></i> Hapus</a></td>";
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