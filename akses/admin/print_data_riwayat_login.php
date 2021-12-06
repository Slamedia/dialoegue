<?php 
//Login Session
session_start();

if (!isset($_SESSION["email"])) {
	echo "<script type='text/javascript'>alert('Anda Harus Login Terlebih Dahulu!');window.location.href = '../../login.php';</script>";
	exit;
}

$aks=$_SESSION["akses"];

if ($aks!="admin") {
    echo "<script type='text/javascript'>alert('Anda Tidak Memiliki Akses Admin!');window.location.href = '../../login.php';</script>";
    exit;
}

$id_user=$_SESSION["id_admin"];
$username=$_SESSION["nama_admin"];
$email=$_SESSION["email"];
//Login Session
//library
include('../config/library.php');
$lib = new Library();
$data_riwayatLoginSite = $lib->riwayatLogin();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Data Riwayat Login</title>
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
		<h1>Data Riwayat Login  <br/> SPPDB(Sistem Pelayanan Penduduk Desa Bahagia)</h1>
	</center>

	<table border="1" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Email</th>
										<th>Jam Masuk Website</th>
										<th>Jam Keluar Website</th>
										<th>akses</th>
										<th>Tanggal Akses</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no = 1;
										$no = 1;
										foreach($data_riwayatLoginSite as $row)
										{
											
											$tgl_format1 = $row['tanggal_akses_login'];
											$tgl_format2 = date("l, d F Y", strtotime($tgl_format1));
											echo "<tr>";
											echo "<td><center>".$no."</center></td>";
											echo "<td>".$row['email']."</td>";
											echo "<td>".$row['jam_masuk_login']."</td>";
											echo "<td>".$row['jam_keluar_login']."</td>";
											echo "<td>".$row['akses']."</td>";
											echo "<td>".$tgl_format2."</td>";
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