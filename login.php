<!DOCTYPE html>
<html>

<head>
	<link rel="icon" type="icon/png" href="library/dist/img/logo.png">
	<!-- Load file CSS Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<title>SPPDB - Halaman Login</title>
	<style>
		.navbar {
			margin-bottom: 0;
			background-color: teal;
			z-index: 9999;
			border: 0;
			font-size: 12px !important;
			line-height: 1.42857143 !important;
			letter-spacing: 4px;
			border-radius: 0;
		}

		.navbar li a,
		.navbar .navbar-brand {
			color: #fff !important;
		}

		.navbar-nav li a:hover,
		.navbar-nav li.active a {
			color: teal !important;
			background-color: #fff !important;
			transition-duration: 1s;
		}

		.navbar-default .navbar-toggle {
			border-color: transparent;
			color: #fff !important;
		}

		.container-fluid {
			width: 40%;
		}

		@media screen and (max-width: 768px) {
			.container-fluid {
				width: 100%;
			}
		}

		.jarak-header {
			margin-top: 80px;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php#myPage">SPPDB</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php#beranda">BERANDA</a></li>
					<li><a href="index.php#tentang">TENTANG</a></li>
					<li><a href="index.php#pelayanan">PELAYANAN</a></li>
					<li><a href="index.php#kontak">KONTAK</a></li>
					<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> LOGIN</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-fluid jarak-header">
		<h2 style="color:teal; text-align:center;">Login Halaman SPPDB</h2><br>
		<?php
		date_default_timezone_set("Asia/Jakarta");
		//Koneksi sederhana dengan PDO
		$con = new PDO("mysql:host=localhost;dbname=sppdb", "root", "");
		//Fungsi untuk mencegah inputan karakter yang tidak sesuai
		function input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			$data = strip_tags($data);
			return $data;
		}
		//Cek apakah ada kiriman form dari method post
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			//penduduk
			$message = '';
			$user = input($_POST['user']);
			$pass = input(md5($_POST["pass"]));
			$query = $con->prepare("select * from penduduk where email=:user and password=:pass");
			$query->BindParam(":user", $user);
			$query->BindParam(":pass", $pass);
			$query->execute();
			//admin
			$query2 = $con->prepare("select * from admin where email=:user and password=:pass");
			$query2->BindParam(":user", $user);
			$query2->BindParam(":pass", $pass);
			$query2->execute();
			//petugas
			$query3 = $con->prepare("select * from petugas where email=:user and password=:pass");
			$query3->BindParam(":user", $user);
			$query3->BindParam(":pass", $pass);
			$query3->execute();

			if ($query->rowCount() > 0) {
				session_start();
				$data = $query->fetch();
				$_SESSION["nik"] = $data["nik"];
				$_SESSION["id_pen"] = $data["id_pen"];
				$_SESSION["no_kk"] = $data["no_kk"];
				$_SESSION["first_name"] = $data["first_name"];
				$_SESSION["last_name"] = $data["last_name"];
				$_SESSION["agama"] = $data["agama"];
				$_SESSION["tempat_lahir"] = $data["tempat_lahir"];
				$_SESSION["tanggal_lahir"] = $data["tanggal_lahir"];
				$_SESSION["tanggal_daftar"] = $data["tanggal_daftar"];
				$_SESSION['jenis_kelamin'] = $data['jenis_kelamin'];
				$_SESSION["notlp"] = $data["notlp"];
				$_SESSION["email"] = $data["email"];
				$_SESSION["password"] = $data["password"];
				$_SESSION["id_akses_login"] = $data["id_akses_login"];
				$_SESSION["akses"] = $data["akses"];

				if ($data['akses'] == "penduduk") {
					$eml = $_POST['user'];
					$jam_msk = date("h : i : sa");
					$jam_klr = 'Sedang Akses';
					$tanggal_akses_login = date("Y-m-d");
					$akses = "penduduk";
					$akses_log = $data['id_akses_login'];

					// tampil_akses_login_validation
					$query_tampil_akses_login = $con->prepare("select * from akses_login where id_akses_login='$akses_log'");
					$query_tampil_akses_login->execute();
					$data_tampil_akses_login = $query_tampil_akses_login->fetch();

					if ($data_tampil_akses_login) {
						$stts = 'ONLINE';
						$id_log_aks_get = $data_tampil_akses_login['id_akses_login'];
						//UPDATE PENDUDUK
						$queryUpdate_pen = $con->prepare('UPDATE penduduk set status=?  where id_akses_login=?');

						$queryUpdate_pen->bindParam(1, $stts);
						$queryUpdate_pen->bindParam(2, $akses_log);

						$queryUpdate_pen->execute();

						$queryUpdate = $con->prepare('UPDATE akses_login set email=?, jam_masuk_login=?, jam_keluar_login=?, akses=?, tanggal_akses_login=?  where id_akses_login=?');

						$queryUpdate->bindParam(1, $eml);
						$queryUpdate->bindParam(2, $jam_msk);
						$queryUpdate->bindParam(3, $jam_klr);
						$queryUpdate->bindParam(4, $akses);
						$queryUpdate->bindParam(5, $tanggal_akses_login);
						$queryUpdate->bindParam(6, $id_log_aks_get);

						$queryUpdate->execute();
						//show
						if ($queryUpdate && $queryUpdate_pen)
							echo "<script type='text/javascript'>window.location.href = 'akses/user/home.php';</script>";
						else {
							header('Location: index.php');
						}
					} else {
						header('Location: index.php');
					}
				}
			} else if ($query2->rowCount() > 0) {
				session_start();
				$data2 = $query2->fetch();
				$_SESSION["id_admin"] = $data2["id_admin"];
				$_SESSION["nama_admin"] = $data2["nama_admin"];
				$_SESSION['jenis_kelamin'] = $data2['jenis_kelamin'];
				$_SESSION['email'] = $data2['email'];
				$_SESSION['password'] = $data2['password'];
				$_SESSION['alamat'] = $data2['alamat'];
				$_SESSION['no_tlp'] = $data2['no_tlp'];
				$_SESSION['id_akses_login'] = $data2['id_akses_login'];
				$_SESSION['akses'] = $data2['akses'];
				if ($data2['akses'] == "admin") {
					//header('location:akses/admin/home.php');
					//inserhidden
					$eml = $_POST['user'];
					$jam_msk = date("h : i : sa");
					$jam_klr = 'Sedang Akses';
					$tanggal_akses_login = date("Y-m-d");
					$akses = "admin";
					sleep(1);
					$akses_log = $data2['id_akses_login'];
					$stts = 'ONLINE';
					// tampil_akses_login_validation
					$query_tampil_akses_login = $con->prepare("select * from akses_login where id_akses_login='$akses_log'");
					$query_tampil_akses_login->execute();
					$data_tampil_akses_login = $query_tampil_akses_login->fetch();

					if ($data_tampil_akses_login) {

						$id_log_aks_get = $data_tampil_akses_login['id_akses_login'];
						//UPDATE ADMIN
						$queryUpdate_adm = $con->prepare('UPDATE admin set status=?  where id_akses_login=?');

						$queryUpdate_adm->bindParam(1, $stts);
						$queryUpdate_adm->bindParam(2, $akses_log);

						$queryUpdate_adm->execute();

						//AKSES_UPDATE_LOG
						$queryUpdate = $con->prepare('UPDATE akses_login set email=?, jam_masuk_login=?, jam_keluar_login=?, akses=?, tanggal_akses_login=?  where id_akses_login=?');

						$queryUpdate->bindParam(1, $eml);
						$queryUpdate->bindParam(2, $jam_msk);
						$queryUpdate->bindParam(3, $jam_klr);
						$queryUpdate->bindParam(4, $akses);
						$queryUpdate->bindParam(5, $tanggal_akses_login);
						$queryUpdate->bindParam(6, $id_log_aks_get);

						$queryUpdate->execute();
						//show
						if ($queryUpdate && $queryUpdate_adm) {
							echo "<script type='text/javascript'>window.location.href = 'akses/admin/home.php';</script>";
						} else {
							header('Location: index.php');
						}
					} else {
						header('Location: index.php');
					}
				}
			} else if ($query3->rowCount() > 0) {
				session_start();
				$data3 = $query3->fetch();
				$_SESSION["nip"] = $data3["nip"];
				$_SESSION["nama_lengkap_petugas"] = $data3["nama_lengkap_petugas"];
				$_SESSION['jenis_kelamin'] = $data3['jenis_kelamin'];
				$_SESSION['email'] = $data3['email'];
				$_SESSION['password'] = $data3['password'];
				$_SESSION['id_akses_login'] = $data3['id_akses_login'];
				$_SESSION['akses'] = $data3['akses'];

				if ($data3['akses'] == "petugas") {
					$eml = $_POST['user'];
					$jam_msk = date("h : i : sa");
					$jam_klr = 'Sedang Akses';
					$tanggal_akses_login = date("Y-m-d");
					$akses = "petugas";
					sleep(1);
					$akses_log = $data3['id_akses_login'];

					// tampil_akses_login_validation
					$query_tampil_akses_login = $con->prepare("select * from akses_login where id_akses_login='$akses_log'");
					$query_tampil_akses_login->execute();
					$data_tampil_akses_login = $query_tampil_akses_login->fetch();

					if ($data_tampil_akses_login) {
						$id_log_aks_get = $data_tampil_akses_login['id_akses_login'];
						$stts = 'ONLINE';
						//UPDATE PETUGAS
						$queryUpdate_pgs = $con->prepare('UPDATE petugas set status=?  where id_akses_login=?');

						$queryUpdate_pgs->bindParam(1, $stts);
						$queryUpdate_pgs->bindParam(2, $akses_log);

						$queryUpdate_pgs->execute();
						//UPDATE AKSES_LOGIN
						$queryUpdate = $con->prepare('UPDATE akses_login set email=?, jam_masuk_login=?, jam_keluar_login=?, akses=?, tanggal_akses_login=?  where id_akses_login=?');

						$queryUpdate->bindParam(1, $eml);
						$queryUpdate->bindParam(2, $jam_msk);
						$queryUpdate->bindParam(3, $jam_klr);
						$queryUpdate->bindParam(4, $akses);
						$queryUpdate->bindParam(5, $tanggal_akses_login);
						$queryUpdate->bindParam(6, $id_log_aks_get);

						$queryUpdate->execute();
						//show
						if ($queryUpdate)
							echo "<script type='text/javascript'>window.location.href = 'akses/petugas/home.php';</script>";
						else {
							header('Location: index.php');
						}
					} else {
						header('Location: index.php');
					}
				}
			} else if ($user = $_POST['user'] === '' && $pass = $_POST['pass'] === '') {
				echo "<div class='alert alert-danger'>
					<strong>Error!</strong> Email dan Password Belum diisi.
				</div>";
			} else if ($pass = $_POST['pass'] === '') {
				echo "<div class='alert alert-danger'>
					<strong>Error!</strong> Password Belum diisi.
				</div>";
			} else if ($user = $_POST['user'] === '') {
				echo "<div class='alert alert-danger'>
					<strong>Error!</strong> Email Belum diisi.
				</div>";
			} else {
				echo "<div class='alert alert-danger'>
					<strong>Error!</strong> Email dan password salah.
				</div>";
			}
		}

		?>

		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<div class="form-group">
				<label>Email:</label>
				<input type="text" class="form-control" name="user" placeholder="Masukan Email">
			</div>
			<div class="form-group">
				<label>Password:</label>
				<div class="input-group" id="show_hide_password">
					<input class="form-control" type="password" name="pass" id="password" placeholder="Masukan Password">
					<div class="input-group-addon">
						<a style="color:#333;" href=""><i class="glyphicon glyphicon-eye-close" aria-hidden="true"></i></a>
					</div>
					</input>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Login">
				<input type="reset" class="btn btn-danger" value="Batal">
			</div>
		</form>
	</div>
	<div class="container-fluid text-center">
		<p>Belum Punya Akun ?
			<button type="button" onclick="window.location.href='sign_up.php'" class="btn btn-success">Daftar disini <i class="glyphicon glyphicon-user"></i></button>
		</p>
	</div>
	<footer style="padding:20px;" class="container-fluid text-center">
		<div class="panel panel-default panel-footer">
			<strong>Copyright &copy; 2020 <a target="_blank" title="visit" href="http://firmansyah.kel4.xyz">Firmansyah</a>.</strong> All rights reserved. <br>Sistem Pelayanan Penduduk Desa Bahagia
		</div>
	</footer>
	<script>
		$(document).ready(function() {
			$("#show_hide_password a").on('click', function(event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("glyphicon glyphicon-eye-close");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("glyphicon glyphicon-eye-close");
					$('#show_hide_password i').addClass("glyphicon glyphicon-eye-open");
				}
			});
		});
	</script>
</body>

</html>