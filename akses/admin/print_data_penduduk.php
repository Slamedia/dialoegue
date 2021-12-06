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
$data_penduduk = $lib->showPenduduk();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Print Data Penduduk</title>
	<!--icon-->
	<link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
</head>

<body>
	<style type="text/css">
		body {
			font-family: sans-serif;
		}

		table {
			margin: 20px auto;
			border-collapse: collapse;
		}

		table th,
		table td {
			border: 1px solid #3c3c3c;
			padding: 3px 8px;

		}

		a {
			background: blue;
			color: #fff;
			padding: 8px 10px;
			text-decoration: none;
			border-radius: 2px;
		}
	</style>
	<center>
		<h1>Data User Penduduk <br /> SPPDB(Sistem Pelayanan Penduduk Desa Bahagia)</h1>
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
			foreach ($data_penduduk as $row) {
				$tgl_format1 = $row['tanggal_lahir'];
				$tgl_format2 = date("d F Y", strtotime($tgl_format1));
				if ($row['jenis_kelamin'] == 'p') {
					$jk = "Pria";
				} else if ($row['jenis_kelamin'] == 'w') {
					$jk = "Wanita";
				} else {
					$jk = "<font color='red'>Kosong</font>";
				}

				echo "<tr>";
				echo "<td>" . $no . "</td>";
				echo "<td>" . $row['nik'] . "</td>";
				echo "<td>" . $row['no_kk'] . "</td>";
				echo "<td>" . $row['first_name'] . "</td>";
				echo "<td>" . $row['last_name'] . "</td>";
				echo "<td>" . $row['agama'] . "</td>";
				echo "<td>" . $row['tempat_lahir'] . ", " . $tgl_format2 . "</td>";
				echo "<td>" . $jk . "</td>";
				echo "<td>" . $row['notlp'] . "</td>";
				echo "<td>" . $row['email'] . "</td>";
				echo "<td>" . $row['password'] . "</td>";
				echo "<td>" . $row['tanggal_daftar'] . "</td>";
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