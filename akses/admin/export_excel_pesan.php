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
include('../config/library.php');
$lib = new Library();
$data_pesan = $lib->showPesan();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Export Data Pesan</title>
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

	<?php
	$year = date(" d-m-Y");
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Pesan -$year.xls");
	?>

	<center>
		<h1>Data Pesan <br /> SPPDB(Sistem Pelayanan Penduduk Desa Bahagia)</h1>
	</center>

	<table border="1" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Pengirim</th>
				<th>Email</th>
				<th>Komentar</th>
				<th>Tanggal Mengirim Pesan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			foreach ($data_pesan as $row) {

				$tgl_format1 = $row['tanggal_send'];
				$tgl_format2 = date("l, d F Y", strtotime($tgl_format1));
				echo "<tr>";
				echo "<td><center>" . $no . "</center></td>";
				echo "<td>" . $row['nama_kontak'] . "</td>";
				echo "<td>" . $row['email'] . "</td>";
				echo "<td>" . $row['komentar'] . "</td>";
				echo "<td>" . $tgl_format2 . "</td>";
				echo "</tr>";
				$no++;
			}
			?>
		</tbody>
	</table>
</body>

</html>