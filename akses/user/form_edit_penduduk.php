<?php
//Login Session
session_start();

if (!isset($_SESSION["email"])) {
	echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
	exit;
}

$aks = $_SESSION["akses"];

if ($aks != "penduduk") {
	echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Admin!');window.location.href = '../../login.php';</script>";
	exit;
}

$id_user = $_SESSION["nik"];
$username = $_SESSION["first_name"];
$email = $_SESSION["email"];
//Login Session
//library
include('../config/library.php');
$lib = new Library();

if (isset($_GET['id_pen'])) {
	$kd_penduduk = $_GET['id_pen'];
	$data_penduduk = $lib->get_by_id($kd_penduduk);
} else {
	header('Location: tabel_data_penduduk.php');
}
if (isset($_POST['tombol_ubah'])) {
	$id = $_POST['id_pen'];
	$kd = $_POST['nik'];
	$kk = $_POST['nomor_kkeluarga'];
	$fn = $_POST['first_name'];
	$ln = $_POST['last_name'];
	$agama = $_POST['agama'];
	$pek = $_POST['pekerjaan'];
	$kew = $_POST['kewarganegaraan'];
	$kel = $_POST['statusKel'];
	$perk = $_POST['statusP'];
	$tml = $_POST['tempat_lahir'];
	$tgl = $_POST['tanggal_lahir'];
	$jk = $_POST['jenis_kelamin'];
	$gol = $_POST['gold'];
	$email = $_POST['email'];
	$tlp = $_POST['notlp'];

	$status_update = $lib->updatePenduduk($id, $kd, $kk, $fn, $ln, $agama, $pek, $kew, $kel, $perk, $tml, $tgl, $jk, $gol, $email, $tlp);
	if ($status_update) {
		echo "<script type='text/javascript'>alert('Berhasil Mengubah Data Penduduk!');window.location.href = 'index.php';</script>";
	} else {
		echo "<script type='text/javascript'>alert('Gagal Mengubah Data Penduduk, Silahkan Hubungi Admin Melalui Kontak Pada Halaman Utama Kami :)');window.location.href = 'index.php';</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPPDB - Form Kartu Keluarga</title>
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
			max-width: 120px;
			max-height: 70px;
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
							<a href="#" class="nav-link bg-cyan">
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
									</ul>
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
							<h1>Formulir Penduduk</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
								<li class="breadcrumb-item active">Formulir</li>
								<li class="breadcrumb-item active">Formulir Penduduk</li>
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
							<h3 class="card-title">Silahkan isi Form Penduduk</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="alert alert-warning" role="alert">
										<i class="fa fa-info-circle"></i> Silahkan hubungi <b>Admin</b>, jika ingin melakukan perubahan <b>NIK!</b>
									</div>
								</div>
								<div class="col-md-6">
									<form action="" method="post">
										<div class="form-group">
											<label>NIK:</label>
											<div class="input-group">
												<input type="hidden" class="form-control" name="id_pen" value="<?= $data_penduduk['id_pen']; ?>" placeholder="Masukan Nomor Kartu Keluarga">
												<input type="text" class="form-control" readonly name="nik" value="<?= $data_penduduk['nik']; ?>" placeholder="Masukan Nomor Kartu Keluarga">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fas fa-id-badge"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Nomor Kartu Keluarga:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="nomor_kkeluarga" readonly value="<?= $data_penduduk['no_kk']; ?>" placeholder="Masukan Nomor Kartu Keluarga">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fas fa-id-badge"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Nama Depan:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="first_name" value="<?= $data_penduduk['first_name']; ?>" placeholder="Masukan Nama Depan">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-user"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group inline">
											<label>Nama Belakang:</label>
											<div class="input-group">
												<input type="text" class="form-control" name="last_name" value="<?= $data_penduduk['last_name']; ?>" placeholder="Masukan Nama Belakang">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-user"></i></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Agama:*</label>
											<select class="form-control" name="agama">
												<option>Pilih Agama</option>
												<option value="Islam" <?php if ($data_penduduk['agama'] == 'Islam') {
																			echo 'selected';
																		} ?>>Islam</option>
												<option value="Kristen(Protestan)" <?php if ($data_penduduk['agama'] == 'Kristen(Protestan)') {
																						echo 'selected';
																					} ?>>Kristen(Protestan)</option>
												<option value="Katolik" <?php if ($data_penduduk['agama'] == 'Katolik') {
																			echo 'selected';
																		} ?>>Katolik</option>
												<option value="Budha" <?php if ($data_penduduk['agama'] == 'Budha') {
																			echo 'selected';
																		} ?>>Budha</option>
												<option value="Hindu" <?php if ($data_penduduk['agama'] == 'Hindu') {
																			echo 'selected';
																		} ?>>Hindu</option>
												<option value="Konghucu" <?php if ($data_penduduk['agama'] == 'Konghucu') {
																				echo 'selected';
																			} ?>>Konghucu</option>
											</select>
										</div>
										<div class="form-group">
											<div style="overflow-x:auto; height:200px; overflow:scroll;" class="table-responsive">
												<table style="font-size:13px" id="dtHorizontalVerticalExample" class="table table-bordered" cellspacing="0" width="100%">

													<thead>
														<tr>
															<th class="text-center" colspan="5" scope="col">DAFTAR PEKERJAAN</th>
														</tr>
													</thead>
													<tbody>
														<!--Row1-->
														<tr>
															<td><b>1.</b> Belum Tidak Bekerja</td>
															<td><b>20.</b> Buruh Tani/Perkebunan</td>
															<td><b>39.</b> Perancang Busana</td>
															<td><b>58.</b> Bupati</td>
															<td><b>77.</b> Penyiar Televisi</td>
														</tr>
														<!--Row2-->
														<tr>
															<td><b>2.</b> Mengurus Rumah Tangga</td>
															<td><b>21.</b> Buruh Nelayan/Perikanan</td>
															<td><b>40.</b> Penterjemah</td>
															<td><b>59.</b> Wakil Bupati</td>
															<td><b>78.</b> Penyiar Radio</td>
														</tr>
														<!--Row3-->
														<tr>
															<td><b>3.</b> Pelajar/Mahasiswa</td>
															<td><b>22.</b> Buruh Peternakan</td>
															<td><b>41.</b> Imam Masjid</td>
															<td><b>60.</b> Walikota</td>
															<td><b>79.</b> Pelaut</td>
														</tr>
														<!--Row4-->
														<tr>
															<td><b>4.</b> Pensiunan</td>
															<td><b>23.</b> Pembantu Rumah Tangga</td>
															<td><b>42.</b> Pendeta</td>
															<td><b>61.</b> Wakil Walikota</td>
															<td><b>80.</b> Peneliti</td>
														</tr>
														<!--Row5-->
														<tr>
															<td><b>5.</b> Pegawai Negri Sipil (PNS)</td>
															<td><b>24.</b> Tukang Cukur</td>
															<td><b>43.</b> Pastor</td>
															<td><b>62.</b> Anggota DPRD Prop.</td>
															<td><b>81.</b> Sopir</td>
														</tr>
														<!--Row6-->
														<tr>
															<td><b>6.</b> Tentara Nasional Indonesia (TNI)</td>
															<td><b>25.</b> Tukang Listrik</td>
															<td><b>44.</b> Wartawan</td>
															<td><b>63.</b> Anggota DPRD Kab./Kota</td>
															<td><b>82.</b> Pialang</td>
														</tr>
														<!--Row7-->
														<tr>
															<td><b>7.</b> Kepolisian RI (POLRI)</td>
															<td><b>26.</b> Tukang Batu</td>
															<td><b>45.</b> Ustadz/Mubaligh</td>
															<td><b>64.</b> Dosen</td>
															<td><b>83.</b> Paranormal</td>
														</tr>
														<!--Row8-->
														<tr>
															<td><b>8.</b> Perdagangan</td>
															<td><b>27.</b> Tukang Kayu</td>
															<td><b>46.</b> Juru Masak</td>
															<td><b>65.</b> Guru</td>
															<td><b>84.</b> Pedagang</td>
														</tr>
														<!--Row9-->
														<tr>
															<td><b>9.</b> Petani/Pekebun</td>
															<td><b>28.</b> Tukang Sol Sepatu</td>
															<td><b>47.</b> Promotor Acara</td>
															<td><b>66.</b> Pilot</td>
															<td><b>85.</b> Perangkat Desa</td>
														</tr>
														<!--Row10-->
														<tr>
															<td><b>10.</b> Peternak</td>
															<td><b>29.</b> Tukang Las / Pandai Besi</td>
															<td><b>48.</b> Anggota DPR RI</td>
															<td><b>67.</b> Pengacara</td>
															<td><b>86.</b> Kepala Desa</td>
														</tr>
														<!--Row11-->
														<tr>
															<td><b>11.</b> Nelayan/Perikanan</td>
															<td><b>30.</b> Tukang Jahit</td>
															<td><b>49.</b> Anggota DPD</td>
															<td><b>68.</b> Notaris</td>
															<td><b>87.</b> Birawati</td>
														</tr>
														<!--Row12-->
														<tr>
															<td><b>12.</b> Industri</td>
															<td><b>31.</b> Tukang Gigi</td>
															<td><b>50.</b> Anggota BPK</td>
															<td><b>69.</b> Arsitek</td>
															<td><b>88.</b> Wiraswasta</td>
														</tr>
														<!--Row13-->
														<tr>
															<td><b>13.</b> Konstruksi</td>
															<td><b>32.</b> Penata Rias</td>
															<td><b>51.</b> Presiden</td>
															<td><b>70.</b> Akuntan</td>
															<td><b>89.</b> Lainnya Sebutkan</td>
														</tr>
														<!--Row14-->
														<tr>
															<td><b>14.</b> Transportasi</td>
															<td><b>33.</b> Penata Busana</td>
															<td><b>52.</b> Wakil Presiden</td>
															<td><b>71.</b> Konsultan</td>
														</tr>
														<!--Row15-->
														<tr>
															<td><b>15.</b> Karyawan Swasta</td>
															<td><b>34.</b> Penata Rambut</td>
															<td><b>53.</b> Anggota Mahkamah Konstitusi</td>
															<td><b>72.</b> Dokter</td>

														</tr>
														<!--Row16-->
														<tr>
															<td><b>16.</b> Karyawan BUMN</td>
															<td><b>35.</b> Mekanik</td>
															<td><b>54.</b> Anggota Kabinet/Kementrian</td>
															<td><b>73.</b> Bidan</td>
														</tr>
														<!--Row17-->
														<tr>
															<td><b>17.</b> Karyawan BUMND</td>
															<td><b>36.</b> Seniman</td>
															<td><b>55.</b> Duta Besar</td>
															<td><b>74.</b> Perawat</td>
														</tr>
														<!--Row18-->
														<tr>
															<td><b>18.</b> Karyawan Honorer</td>
															<td><b>37.</b> Tabib</td>
															<td><b>56.</b> Gubernur </td>
															<td><b>75.</b> Apotaker</td>
														</tr>
														<!--Row19-->
														<tr>
															<td><b>19.</b> Buruh Harian Lapas</td>
															<td><b>38.</b> Paraji</td>
															<td><b>57.</b> Wakil Gubernur</td>
															<td><b>76.</b> Psikater/Psikolog</td>
														</tr>
													</tbody>
												</table>
											</div>
											<p class="text-center">Geser untuk melihat lebih banyak pekerjaan</p>
										</div>
										<!-- /.form-group -->
										<div class="form-group">
											<label>Pilih Nomer Pekerjaan Berdasarkan Tabel Pekerjaan:* / (Lainnya)</label>
											<div class="input-group">
												<input type="number" class="form-control" name="pekerjaan" max="100" value="<?php echo $data_penduduk['pekerjaan']; ?>" placeholder="Masukan Nomer Pekerjaan">
												<div class="input-group-append">
													<div class="input-group-text"><i class="fa fa-briefcase"></i></div>
												</div>
											</div>
										</div>
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<div class="form-group">
										<label>Status Hubungan Keluarga:*</label>
										<select class="form-control" name="statusKel">
											<option>Pilih Hubungan Keluarga</option>
											<option value="KEPALA KELUARGA" <?php if ($data_penduduk['status_hub_kel'] == 'KEPALA KELUARGA') {
																				echo 'selected';
																			} ?>>Kepala Keluarga</option>
											<option value="SUAMI" <?php if ($data_penduduk['status_hub_kel'] == 'SUAMI') {
																		echo 'selected';
																	} ?>>Suami</option>
											<option value="ISTRI" <?php if ($data_penduduk['status_hub_kel'] == 'ISTRI') {
																		echo 'selected';
																	} ?>>Istri</option>
											<option value="ANAK" <?php if ($data_penduduk['status_hub_kel'] == 'ANAK') {
																		echo 'selected';
																	} ?>>Anak</option>
											<option value="MENANTU" <?php if ($data_penduduk['status_hub_kel'] == 'MENANTU') {
																		echo 'selected';
																	} ?>>Menantu</option>
											<option value="CUCU" <?php if ($data_penduduk['status_hub_kel'] == 'CUCU') {
																		echo 'selected';
																	} ?>>Cucu</option>
											<option value="ORANG TUA" <?php if ($data_penduduk['status_hub_kel'] == 'ORANG TUA') {
																			echo 'selected';
																		} ?>>Orang tua</option>
											<option value="MERTUA" <?php if ($data_penduduk['status_hub_kel'] == 'MERTUA') {
																		echo 'selected';
																	} ?>>Mertua</option>
											<option value="FAMILI LAIN" <?php if ($data_penduduk['status_hub_kel'] == 'FAMILI LAIN') {
																			echo 'selected';
																		} ?>>Famili Lain</option>
											<option value="PEMBANTU" <?php if ($data_penduduk['status_hub_kel'] == 'PEMBANTU') {
																			echo 'selected';
																		} ?>>Pembantu</option>
											<option value="LAINNYA" <?php if ($data_penduduk['status_hub_kel'] == 'LAINNYA') {
																		echo 'selected';
																	} ?>>Lainnya</option>
										</select>
									</div>
									<div class="form-group">
										<label>Status Perkawinan:*</label>
										<select class="form-control" name="statusP">
											<option>Pilih Status Perkawinan</option>
											<option value="Belum Kawin" <?php if ($data_penduduk['status_perkawinan'] == 'Belum Kawin') {
																			echo 'selected';
																		} ?>>Belum Kawin</option>
											<option value="Kawin" <?php if ($data_penduduk['status_perkawinan'] == 'Kawin') {
																		echo 'selected';
																	} ?>>Kawin</option>
											<option value="Cerai Hidup" <?php if ($data_penduduk['status_perkawinan'] == 'Cerai Hidup') {
																			echo 'selected';
																		} ?>>Cerai Hidup</option>
											<option value="Cerai Mati" <?php if ($data_penduduk['status_perkawinan'] == 'Cerai Mati') {
																			echo 'selected';
																		} ?>>Cerai Mati</option>
										</select>
									</div>
									<div class="form-group">
										<label>Kewarganegaraan:*</label>
										<label class="radio-inline">
											<input type="radio" name="kewarganegaraan" value="WNI" <?php if ($data_penduduk['kewarganegaraan'] == 'WNI') {
																										echo 'checked';
																									} ?>> WNI
										</label>
										<label class="radio-inline">
											<input type="radio" name="kewarganegaraan" value="WNA" <?php if ($data_penduduk['kewarganegaraan'] == 'WNA') {
																										echo 'checked';
																									} ?>> WNA
										</label>
									</div>
									<div class="form-group">
										<label>Tempat Lahir:</label>
										<div class="input-group">
											<input type="text" class="form-control" value="<?= $data_penduduk['tempat_lahir']; ?>" name="tempat_lahir" placeholder="Masukan Tempat Lahir">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-map-signs"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Tanggal Lahir:</label>
										<div class="input-group">
											<input type="date" class="form-control" value="<?= $data_penduduk['tanggal_lahir']; ?>" name="tanggal_lahir" placeholder="dd/mm/yyyy">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Jenis Kelamin:*</label>
										<label class="radio-inline">
											<input type="radio" name="jenis_kelamin" value="p" <?php if ($data_penduduk['jenis_kelamin'] == 'p') {
																									echo 'checked';
																								} ?>> Pria
										</label>
										<label class="radio-inline">
											<input type="radio" name="jenis_kelamin" value="w" <?php if ($data_penduduk['jenis_kelamin'] == 'w') {
																									echo 'checked';
																								} ?>> Wanita
										</label>
									</div>
									<div class="form-group">
										<label>Gol. Darah:*</label>
										<select class="form-control" name="gold">
											<option>Pilih Golongan Darah</option>
											<option value="O+" <?php if ($data_penduduk['Goldarah'] == 'O+') {
																	echo 'selected';
																} ?>>O+</option>
											<option value="O-" <?php if ($data_penduduk['Goldarah'] == 'O-') {
																	echo 'selected';
																} ?>>O-</option>
											<option value="A+" <?php if ($data_penduduk['Goldarah'] == 'A+') {
																	echo 'selected';
																} ?>>A+</option>
											<option value="A-" <?php if ($data_penduduk['Goldarah'] == 'A-') {
																	echo 'selected';
																} ?>>A-</option>
											<option value="B+" <?php if ($data_penduduk['Goldarah'] == 'B+') {
																	echo 'selected';
																} ?>>B+</option>
											<option value="B-" <?php if ($data_penduduk['Goldarah'] == 'B-') {
																	echo 'selected';
																} ?>>B-</option>
										</select>
									</div>
									<div class="form-group">
										<label>Email:</label>
										<div class="input-group">
											<input type="text" class="form-control" value="<?= $data_penduduk['email']; ?>" name="email" placeholder="Masukan Email">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fas fa-at"></i></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Masukan Password</label>
										<div class="input-group" id="show_hide_password">
											<input class="form-control" type="password" name="password" readonly value="<?php echo $data_penduduk['password']; ?>" id=" password" placeholder="Masukan Password">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fas fa-eye-slash"></i></div>
											</div>
											</input>
										</div>
									</div>
									<div class="form-group">
										<label>Nomor Handphone:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="notlp" value="<?= $data_penduduk['notlp']; ?>" placeholder="Masukan Nomor Handphone">
											<div class="input-group-append">
												<div class="input-group-text"><i class="fa fa-phone-alt"></i></div>
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