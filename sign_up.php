<?php
$connect = new PDO("mysql:host=localhost;dbname=sppdb", "root", "");
$message = '';
if (isset($_POST["email"])) {
  $kk = $_POST['no_kk'];
  $id_pen = date("dmYhi");
  $tgl_daftar = date("Y-m-d");
  $akses = "penduduk";
  $kd = $_POST['nik'];
  $eml = $_POST['email'];
  $tglan = $_POST['tanggal_lahir'];
  $tgl_lhrStr = date("Y-m-d", strtotime($tglan));
  $id_kk = date("dmYhis");
  sleep(1);
  //akses login
  $id_log_aks = date("dmYhi");
  $data = $connect->prepare('INSERT INTO akses_login(id_akses_login) VALUES (?)');
  $data->bindParam(1, $id_log_aks);
  $data->execute();
  //kartukeluarga
  $data2 = $connect->prepare('INSERT INTO kartukeluarga(no_kk, id_kk) VALUES (?, ?)');
  $data2->bindParam(1, $kk);
  $data2->bindParam(2, $id_kk);
  $data2->execute();
  if ($data && $data2) {
    //registrasi penduduk
    $query = "
 INSERT INTO penduduk 
 (nik, id_pen, no_kk, first_name, last_name, agama, tempat_lahir, tanggal_lahir, tanggal_daftar, jenis_kelamin, email, password, notlp, id_akses_login, akses) VALUES 
 (:nik, :id_pen, :nokk, :first_name, :last_name, :agama, :tempat_lahir, :tanggal_lahir, :tanggal_daftar, :jk, :email, :password, :notlp, :id_akses,:akses)
 ";
    $password_hash = md5($_POST["password"]);
    $user_data = array(
      ':nik'  => $kd,
      ':id_pen'  => $id_pen,
      ':nokk'  => $kk,
      ':first_name'  => $_POST["first_name"],
      ':last_name'  => $_POST["last_name"],
      ':agama'  => $_POST["agama"],
      ':tempat_lahir'  => $_POST["tempat_lahir"],
      ':tanggal_lahir'  => $tgl_lhrStr,
      ':tanggal_daftar'  => $tgl_daftar,
      ':jk'   => $_POST["gender"],
      ':email'   => $eml,
      ':password'   => $password_hash,
      ':notlp'   => $_POST["notlp"],
      'id_akses' => $id_log_aks,
      ':akses'  => $akses
    );
    $statement = $connect->prepare($query);
    $cekNik = $connect->prepare("SELECT * FROM penduduk WHERE nik = '$kd'");
    $cekNik->bindParam('nik', $kd);
    $cekNik->execute();

    //email cek
    $cekEmail = $connect->prepare("SELECT * FROM penduduk,petugas,admin WHERE email = '$eml'");
    $cekEmail->bindParam('email', $eml);
    $cekEmail->execute();
    if ($cekNik->rowCount() > 0) {
      $message = '
  <div class="alert alert-danger">
  NIK sudah terdaftar!
  </div>
  ';
    } else if ($cekEmail->rowCount() > 0) {
      $message = '
  <div class="alert alert-danger">
  Email sudah terdaftar!
  </div>
  ';
    } else {
      if ($statement->execute($user_data)) {
        $gol = 'Empty';
        $pek = 'Empty';
        $kew = 'Empty';
        $kel = 'Empty';
        $allN = $_POST['first_name'] . " " . $_POST['last_name'];
        $id = date('dmYhi');
        //Anggota Keluarga
        $data_ang = $connect->prepare('INSERT INTO anggota_keluarga (id_anggota, no_kk, nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, GolDarah, agama, pekerjaan,	kewarganegaraan, status_hub_kel) VALUES (?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? , ?)');
        $data_ang->bindParam(1, $id);
        $data_ang->bindParam(2, $kk);
        $data_ang->bindParam(3, $kd);
        $data_ang->bindParam(4, $allN);
        $data_ang->bindParam(5, $_POST["tempat_lahir"]);
        $data_ang->bindParam(6, $tgl_lhrStr);
        $data_ang->bindParam(7, $_POST["gender"]);
        $data_ang->bindParam(8, $gol);
        $data_ang->bindParam(9, $_POST["agama"]);
        $data_ang->bindParam(10, $pek);
        $data_ang->bindParam(11, $kew);
        $data_ang->bindParam(12, $kel);
        $data_ang->execute();
        if ($data_ang) {
          $message = '
          <div class="alert alert-success">
          Berhasil Mendaftar Akun SPPDB! Silahkan login <a href="login.php">Login Disini!</a>
          </div>
          ';
        } else {
          $message = '
  <div class="alert alert-danger">
  Gagal Mendaftar
  </div>
  ';
        }
      } else {
        $message = '
  <div class="alert alert-danger">
  Gagal Mendaftar
  </div>
  ';
      }
    }
  } else {
    echo 'Gagal Memberikan Logika ID Login dan kartu Keluarga';
  }
}
?>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SPPDB - Registrasi Akun</title>
  <!--icon-->
  <link rel="icon" type="icon/png" href="library/dist/img/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
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

    .box {
      width: 40%;
      margin: 0 auto;
    }

    .jarak-header {
      margin-top: 82px;
    }

    .active_tab1 {
      background-color: #fff;
      color: #333;
      font-weight: 600;
    }

    .inactive_tab1 {
      background-color: #f5f5f5;
      color: #333;
      cursor: not-allowed;
    }

    .has-error {
      border-color: #cc0000;
      background-color: #ffff99;
    }

    @media screen and (max-width: 768px) {
      .box {
        width: 100%;
      }
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
  <div class="container box jarak-header">
    <h2 align="center" style="color:teal;">Registrasi Akun SPPDB</h2><br />
    <?php echo $message; ?>
    <form method="post" id="register_form">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_login_details">Akun</a>
        </li>
        <li class="nav-item">
          <a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Biodata</a>
        </li>
        <li class="nav-item">
          <a class="nav-link inactive_tab1" id="list_contact_details" style="border:1px solid #ccc">Kontak</a>
        </li>
      </ul>
      <div class="tab-content" style="margin-top:16px;">
        <div class="tab-pane active" id="login_details">
          <div class="panel panel-default">
            <div class="panel-heading" style="background-color:teal; color:white;">Registrasi Akun</div>
            <div class="panel-body">
              <div class="form-group">
                <label>Masukan Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Masukan Email" />
                <span id="error_email" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Masukan Password</label>
                <div class="input-group" id="show_hide_password">
                  <input class="form-control" type="password" name="password" id="password" placeholder="Masukan Password">
                  <div class="input-group-addon">
                    <a style="color:#333;" href=""><i class="glyphicon glyphicon-eye-close" aria-hidden="true"></i></a>
                  </div>
                  </input>
                </div>
                <span id="error_password" class="text-danger"></span>
              </div>
              <br />
              <div align="center">
                <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Next</button>
              </div>
              <br />
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="personal_details">
          <div class="panel panel-default">
            <div class="panel-heading" style="background-color:teal; color:white;">Registrasi Biodata</div>
            <div class="panel-body">
              <div class="form-group">
                <label>NIK:*</label>
                <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukan NIK" />
                <span id="error_nik" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Nomor Kartu Keluarga:*</label>
                <input type="text" name="no_kk" id="no_kk" class="form-control" placeholder="Masukan Nomor Kartu Keluarga" />
                <span id="error_no_kk" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Masukan Nama Depan:*</label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Masukan Nama Depan" />
                <span id="error_first_name" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Enter Nama Belakang:*</label>
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Masukan Nama Belakang" />
                <span id="error_last_name" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Agama:*</label>
                <select class="form-control" name="agama">
                  <option selected>Pilih Agama</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen(Protestan)">Kristen(Protestan)</option>
                  <option value="Katolik">Katolik</option>
                  <option value="Budha">Budha</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Konghucu">Konghucu</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tempat Lahir:*</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Masukan Tempat Lahir" />
                <span id="error_tempat_lahir" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="input-group-text"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
                  <input type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="dd/mm/yyyy" class="form-control" />
                </div>
                <span id="error_tanggal_lahir" class="text-danger"></span>

                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Jenis Kelamin:*</label>
                <label class="radio-inline">
                  <input type="radio" name="gender" value="p" checked> Pria
                </label>
                <label class="radio-inline">
                  <input type="radio" name="gender" value="w"> Wanita
                </label>
              </div>
              <br />
              <div align="center">
                <button type="button" name="previous_btn_personal_details" id="previous_btn_personal_details" class="btn btn-default btn-lg">Previous</button>
                <button type="button" name="btn_personal_details" id="btn_personal_details" class="btn btn-info btn-lg">Next</button>
              </div>
              <br />
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="contact_details">
          <div class="panel panel-default">
            <div class="panel-heading" style="background-color:teal; color:white;">Registrasi Kontak:</div>
            <div class="panel-body">
              <div class="form-group">
                <label>Masukan No Handphone:*</label>
                <input type="text" name="notlp" id="mobile_no" class="form-control" placeholder="Masukan Nomor 
		 " />
                <span id="error_mobile_no" class="text-danger"></span>
              </div>
              <br />
              <div align="center">
                <button type="button" name="previous_btn_contact_details" id="previous_btn_contact_details" class="btn btn-default btn-lg">Previous</button>
                <button type="button" name="btn_contact_details" id="btn_contact_details" class="btn btn-success btn-lg">Register</button>
              </div>
              <br />
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="container-fluid text-center">
    <p>Sudah Punya Akun ?
      <button type="button" onclick="window.location.href='login.php'" class="btn btn-Primary">Login disini <i class="glyphicon glyphicon-log-in"></i></button>
    </p>
  </div>
  <footer style="padding:20px;" class="box text-center">
    <div class="panel panel-default panel-footer">
      <strong>Copyright &copy; 2020 <a target="_blank" title="visit" href="http://firmansyah.kel4.xyz">Firmansyah</a>.</strong> All rights reserved. <br>Sistem Pelayanan Penduduk Desa Bahagia
    </div>
  </footer>
</body>

</html>

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
  $(document).ready(function() {

    $('#btn_login_details').click(function() {

      var error_email = '';
      var error_password = '';
      var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      var password_validation = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;

      if ($.trim($('#email').val()).length == 0) {
        error_email = 'Email is required';
        $('#error_email').text(error_email);
        $('#email').addClass('has-error');
      } else {
        if (!filter.test($('#email').val())) {
          error_email = 'Invalid Email';
          $('#error_email').text(error_email);
          $('#email').addClass('has-error');
        } else {
          error_email = '';
          $('#error_email').text(error_email);
          $('#email').removeClass('has-error');
        }
      }

      if ($.trim($('#password').val()).length == 0) {
        error_password = 'Password is required';
        $('#error_password').text(error_password);
        $('#password').addClass('has-error');
      } else {
        if (!password_validation.test($('#password').val())) {
          error_password = 'Harus di isi setidaknya 1 nomor dan 1 huruf besar dan 1 huruf kecil dan sedikitnya 8 karakter atau lebih karakter';
          $('#error_password').text(error_password);
          $('#password').addClass('has-error');
        } else {
          error_password = '';
          $('#error_password').text(error_password);
          $('#password').removeClass('has-error');
        }
      }

      if (error_email != '' || error_password != '') {
        return false;
      } else {
        $('#list_login_details').removeClass('active active_tab1');
        $('#list_login_details').removeAttr('href data-toggle');
        $('#login_details').removeClass('active');
        $('#list_login_details').addClass('inactive_tab1');
        $('#list_personal_details').removeClass('inactive_tab1');
        $('#list_personal_details').addClass('active_tab1 active');
        $('#list_personal_details').attr('href', '#personal_details');
        $('#list_personal_details').attr('data-toggle', 'tab');
        $('#personal_details').addClass('active in');
      }
    });

    $('#previous_btn_personal_details').click(function() {
      $('#list_personal_details').removeClass('active active_tab1');
      $('#list_personal_details').removeAttr('href data-toggle');
      $('#personal_details').removeClass('active in');
      $('#list_personal_details').addClass('inactive_tab1');
      $('#list_login_details').removeClass('inactive_tab1');
      $('#list_login_details').addClass('active_tab1 active');
      $('#list_login_details').attr('href', '#login_details');
      $('#list_login_details').attr('data-toggle', 'tab');
      $('#login_details').addClass('active in');
    });

    $('#btn_personal_details').click(function() {
      var error_nik = '';
      var error_no_kk = '';
      var error_first_name = '';
      var error_last_name = '';
      var error_tempat_lahir = '';
      var error_tanggal_lahir = '';
      //NIK
      if ($.trim($('#nik').val()).length == 0) {
        error_nik = 'NIK is required';
        $('#error_nik').text(error_nik);
        $('#nik').addClass('has-error');
      } else {
        error_nik = '';
        $('#error_nik').text(error_nik);
        $('#nik').removeClass('has-error');
      }
      //NO KK
      if ($.trim($('#no_kk').val()).length == 0) {
        error_nik = 'Nomor Kartu Keluarga is required';
        $('#error_no_kk').text(error_no_kk);
        $('#no_kk').addClass('has-error');
      } else {
        error_no_kk = '';
        $('#error_no_kk').text(error_no_kk);
        $('#no_kk').removeClass('has-error');
      }
      //firstName
      if ($.trim($('#first_name').val()).length == 0) {
        error_first_name = 'First Name is required';
        $('#error_first_name').text(error_first_name);
        $('#first_name').addClass('has-error');
      } else {
        error_first_name = '';
        $('#error_first_name').text(error_first_name);
        $('#first_name').removeClass('has-error');
      }

      if ($.trim($('#last_name').val()).length == 0) {
        error_last_name = 'Last Name is required';
        $('#error_last_name').text(error_last_name);
        $('#last_name').addClass('has-error');
      } else {
        error_last_name = '';
        $('#error_last_name').text(error_last_name);
        $('#last_name').removeClass('has-error');
      }
      //tempat_lahir
      if ($.trim($('#tempat_lahir').val()).length == 0) {
        error_tempat_lahir = 'Tempat Lahir is required';
        $('#error_tempat_lahir').text(error_tempat_lahir);
        $('#tempat_lahir').addClass('has-error');
      } else {
        error_tempat_lahir = '';
        $('#error_tempat_lahir').text(error_tempat_lahir);
        $('#tempat_lahir').removeClass('has-error');
      }
      //Tanggal Lahir
      if ($.trim($('#tanggal_lahir').val()).length == 0) {
        error_tanggal_lahir = 'Tanggal Lahir is required';
        $('#error_tanggal_lahir').text(error_tanggal_lahir);
        $('#tanggal_lahir').addClass('has-error');
      } else {
        error_tanggal_lahir = '';
        $('#error_tanggal_lahir').text(error_tanggal_lahir);
        $('#tanggal_lahir').removeClass('has-error');
      }

      if (error_nik != '' || error_no_kk != '' || error_first_name != '' || error_last_name != '' || error_tempat_lahir != '' || error_tanggal_lahir != '') {
        return false;
      } else {
        $('#list_personal_details').removeClass('active active_tab1');
        $('#list_personal_details').removeAttr('href data-toggle');
        $('#personal_details').removeClass('active');
        $('#list_personal_details').addClass('inactive_tab1');
        $('#list_contact_details').removeClass('inactive_tab1');
        $('#list_contact_details').addClass('active_tab1 active');
        $('#list_contact_details').attr('href', '#contact_details');
        $('#list_contact_details').attr('data-toggle', 'tab');
        $('#contact_details').addClass('active in');
      }
    });

    $('#previous_btn_contact_details').click(function() {
      $('#list_contact_details').removeClass('active active_tab1');
      $('#list_contact_details').removeAttr('href data-toggle');
      $('#contact_details').removeClass('active in');
      $('#list_contact_details').addClass('inactive_tab1');
      $('#list_personal_details').removeClass('inactive_tab1');
      $('#list_personal_details').addClass('active_tab1 active');
      $('#list_personal_details').attr('href', '#personal_details');
      $('#list_personal_details').attr('data-toggle', 'tab');
      $('#personal_details').addClass('active in');
    });

    $('#btn_contact_details').click(function() {
      var error_mobile_no = '';
      var mobile_validation = /^[0-9]+$/;

      if ($.trim($('#mobile_no').val()).length == 0) {
        error_mobile_no = 'Mobile Number is required';
        $('#error_mobile_no').text(error_mobile_no);
        $('#mobile_no').addClass('has-error');
      } else {
        if (!mobile_validation.test($('#mobile_no').val())) {
          error_mobile_no = 'Invalid Mobile Number';
          $('#error_mobile_no').text(error_mobile_no);
          $('#mobile_no').addClass('has-error');
        } else {
          error_mobile_no = '';
          $('#error_mobile_no').text(error_mobile_no);
          $('#mobile_no').removeClass('has-error');
        }
      }
      if (error_mobile_no != '') {
        return false;
      } else {
        $('#btn_contact_details').attr("disabled", "disabled");
        $(document).css('cursor', 'prgress');
        $("#register_form").submit();
      }

    });

  });
</script>