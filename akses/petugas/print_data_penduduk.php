<?php
date_default_timezone_set("Asia/Jakarta");
//Login Session
session_start();

if (!isset($_SESSION["email"])) {
	echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
	exit;
}

$aks=$_SESSION["akses"];

if ($aks!="petugas") {
    echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Petugas!');window.location.href = '../../login.php';</script>";
    exit;
}

$id_user=$_SESSION["nip"];
$username=$_SESSION["nama_lengkap_petugas"];
$email=$_SESSION["email"];
//Login Session
include('../config/library.php');
$lib = new Library();
$data_penduduk = $lib->showPenduduk();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Data Pesan</title>
	<!--icon-->
	<link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;

	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
	<center>
		<h1>Data Pesan  <br/> SPPDB(Sistem Pelayanan Penduduk Desa Bahagia)</h1>
		<?php 	
		
		$hari = date ("D");
		switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	} echo $hari_ini.",".date('d F Y'); ?>
	</center>

	<table border="1" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No</th>
										<th>NIK</th>
										<th>Nomor Kartu Keluarga</th>
										<th>Nama Depan</th>
										<th>Nama Belakang</th>
										<th>Agama</th>
										<th>Tempat Tanggal Lahir</th>
										<th>Jenis Kelamin</th>
										<th>No Telepon</th>
										<th>Email</th>
										<th>Password</th>
										<th>Tanggal Registrasi Akun</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no = 1;
										foreach($data_penduduk as $row)
										{
											$tgl_format1 = $row['tanggal_lahir'];
											$tgl_format2 = date("d F Y", strtotime($tgl_format1));
											if($row['jenis_kelamin'] == 'p'){
												$jk = "Pria";
											}else if($row['jenis_kelamin'] == 'w'){
												$jk = "Wanita";
											}else{
												$jk = "<font color='red'>Kosong</font>";
											}
											if($row['no_kk'] == 'Empty'){
												$no_kk = "<font color='red'>Empty</font>";
											}else{
												$no_kk = "<a href='#'>".$row['no_kk']."</a>";
											}
											echo "<tr>";
											echo "<td>".$no."</td>";
											echo "<td>".$row['nik']."</td>";
											echo "<td>".$no_kk."</td>";
											echo "<td>".$row['first_name']."</td>";
											echo "<td>".$row['last_name']."</td>";
											echo "<td>".$row['agama']."</td>";
											echo "<td>".$row['tempat_lahir'].", ".$tgl_format2."</td>";
											echo "<td>".$jk."</td>";
											echo "<td>".$row['notlp']."</td>";
											echo "<td>".$row['email']."</td>";
											echo "<td>".$row['password']."</td>";
											echo "<td>".$row['tanggal_daftar']."</td>";
											echo "</tr>";
											$no++;
										}
									?>
								</tbody>
							</table>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>