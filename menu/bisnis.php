<?php
include('../akses/config/library.php');
$lib = new Library();
if (isset($_POST['tombol_kirim'])) {
  $nama_pengirim = $_POST['nama_pengirimx'];
  $email = $_POST['emailx'];
  $komentar = $_POST['komentarx'];

  $addKontak = $lib->add_Kontak($nama_pengirim, $email, $komentar);
  if ($addKontak) {
    echo "<script type='text/javascript'>alert('Berhasil Mengirim Pesan, Harap tunggu balasan 1x24 Jam!');window.location.href='index.php';</script>";
  } else {
    echo "<script type='text/javascript'>alert('Gagal Mengirim Pesan, Silahkan Ulangi Lagi!');window.location.href='index.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dialoegue | Home</title>
  <!--icon-->
  <link rel="icon" type="icon/png" href="library/dist/img/logo.png">
  <!--bootstrap-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .navbar {
      margin-bottom: 0;
      background-color: #f75139;
      z-index: 9999;
      border: 0;
      font-size: 12px !important;
      line-height: 1.42857143 !important;
      letter-spacing: 4px;
      border-radius: 0;
    }

    .navbar-header {
      padding-bottom: 25px;
    }

    .navbar-brand img {
      width: 150px;
      height: 50px;
    }

    .collapse.navbar-collapse ul {
      position: relative;
      top: 20px;
    }

    .collapse.navbar-collapse {
      padding-bottom: 20px;
    }

    .navbar-toggle {
      position: relative;
      top: 10px;
    }

    .glyphicon.glyphicon-th-list {
      font-size: 20px;
    }

    .jumbotron.text-left {
      font-family: fantasy;
    }

    .col-sm-8 {
      position: relative;
      left: 30px;
    }

    .col-sm-8 button {
      width: 120px;
      height: 60px;
      margin-right: 30px;
      position: relative;
      bottom: 30px;
      background-color: #f75139; 
      color: #fff;
    }

    .col-sm-4 {
      position: relative;
      right: 30px;
    }

    .col-sm-4 img {
      width: 350px;
      height: 350px;
    }

    #myPage {
      background-color: #f75139;
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
      color: #fff !important;
    }

    .jumbotron {
      background-color: #d4dee8;
      color: black;
      padding: 100px 50px;
    }

    .jumbotron>.btn {
      margin-left: 3px;
      font-size: 16px;
      padding: 10px 20px;
      background-color: #3399ff;
      color: #f1f1f1;
      border-radius: 0;
      transition: .2s;
    }

    .container-fluid {
      padding: 60px 50px;
    }

    .jumbotron>.btn:hover,
    .btn:focus {
      background-color: #0059b3;
      color: #fff;
      transition-duration: 1s;
    }

    .bg-grey {
      background-color: #f6f6f6;
    }

    .logo {
      color: #f4511e;
      font-size: 200px;
    }

    .logo-small {
      color: teal;
      font-size: 50px;
    }

    @keyframes slide {
      0% {
        opacity: 0;
        transform: translateY(70%);
      }

      100% {
        opacity: 1;
        transform: translateY(0%);
      }
    }

    @-webkit-keyframes slide {
      0% {
        opacity: 0;
        -webkit-transform: translateY(70%);
      }

      100% {
        opacity: 1;
        -webkit-transform: translateY(0%);
      }
    }

    @media screen and (max-width: 768px) {
      .col-sm-4 {
        text-align: center;
        margin: 25px 0;
      }

      .col-sm-3 {
        text-align: center;
        margin: 25px 0;
      }

      .btn-lg {
        width: 100%;
        margin-bottom: 35px;
      }

      .plex {
        height: 260px;
        width: 225px;
      }
    }

    @media screen and (max-width: 480px) {
      .logo {
        font-size: 150px;
      }

      .plex {
        height: 260px;
        width: 225px;
      }
    }
  </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="glyphicon glyphicon-th-list
"></span>
        </button>
        <a class="navbar-brand" href="../index.php"><img src="../library/img/logo.png"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../index.php">HOME</a></li>
          <li><a href="../produk.php">PRODUK</a></li>
          <li><a href="#home">BISNIS</a></li>
          <li><a href="faq.php">FAQ</a></li>
          <li><a href="../pesan.php"><span class="glyphicon glyphicon-log-in"></span> PESAN</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div id="home" class="jumbotron text-left">
    <div class="row">
      <div class="col-sm-8">
        <p><h2>Ayo!</h2><h2>jadi 500 yang pertama</h2>
          <h2>mencoba produk</h2><h2>yang kamu suka</h2><h2>secara gampang,</h2><h2>yuk review dulu di website!!</h2>
        </p><br>
        <br><button class="btn btn-default btn-lg">Produk</button>
        <button class="btn btn-default btn-lg">Pesan</button>
      </div>
      <div class="col-sm-4">
        <img class="slideanim plex" src="../library/img/icon-10.svg" height="370" width="295" alt="Logo Pemkab">
      </div>
    </div>
  </div>
  </div>
  <div class="jumbotron text-left" style="background-color: #f75139; color: #fff;">
    <div class="row">
      <div class="col-sm-4">
        <img class="slideanim plex" src="../library/img/icon-2.svg" height="370" width="295" alt="Logo Pemkab">
      </div>
      <div class="col-sm-8">
        <p><h2>Pesanan Mudah</h2><h2>produknya Pas</h2>
          <h2>mencoba produk</h2><h2>yang kamu suka</h2><h2>secara gampang,</h2><h2>yuk review dulu di website!!</h2>
        </p><br>
        <br><button class="btn btn-default btn-lg" style="width: 160px;">Coba Sekarang</button>
      </div>
      <div class="col-sm-8">
        <p><h2>Pesanan Mudah</h2><h2>produknya Pas</h2>
          <h2>mencoba produk</h2><h2>yang kamu suka</h2><h2>secara gampang,</h2><h2>yuk review dulu di website!!</h2>
        </p><br>
        <br><button class="btn btn-default btn-lg" style="width: 160px;">Coba Sekarang</button>
      </div>
      <div class="col-sm-4">
        <img class="slideanim plex" src="../library/img/icon-2.svg" height="370" width="295" alt="Logo Pemkab">
      </div>
    </div>
  </div>
  </div>

  <div id="home" class="jumbotron text-left">
    <div class="row">
      <div class="col-sm-8">
        <p><h2>Ayo!</h2><h2>jadi 500 yang pertama</h2>
          <h2>mencoba produk</h2><h2>yang kamu suka</h2><h2>secara gampang,</h2><h2>yuk review dulu di website!!</h2>
        </p><br>
        <br><button class="btn btn-default btn-lg">Lihat</button>
      </div>
      <div class="col-sm-4">
        <img class="slideanim plex" src="../library/img/icon-10.svg" height="370" width="295" alt="Logo Pemkab">
      </div>
    </div>
  </div>
  </div>
  <!-- Kontak -->
  <div id="kontak" class="container-fluid bg-grey" style="background-color: #d4dee8;">
    <h2 class="text-center">Kontak</h2>
    <div class="row">
      <div class="col-sm-5">
        <p> Hubungi kami dan kami akan menghubungi Anda dalam waktu 24 jam.</p>
        <p><span class="glyphicon glyphicon-map-marker"></span> Ma'sum, Jl. kiyai H. Noer Ali Jl. KH. Mahmud Maksum No.01, Bahagia, Kec. Babelan, Bekasi, Jawa Barat 17610</p>
        <p><span class="glyphicon glyphicon-phone"></span> +6281384233919</p>
        <p><span class="glyphicon glyphicon-envelope"></span> firmansyah.xrpl1.15@gmail.com</p>
      </div>
      <div class="col-sm-7 slideanim">
        <div class="row">
          <form method="POST" action="">
            <div class="col-sm-6 form-group">
              <input class="form-control" id="name" name="nama_pengirimx" placeholder="Masukan Nama" type="text" required>
            </div>
            <div class="col-sm-6 form-group">
              <input class="form-control" id="email" name="emailx" placeholder="Masukan Email" type="email" required>
            </div>
        </div>
        <textarea class="form-control" id="comments" name="komentarx" placeholder="Masukan Komentar" rows="5"></textarea><br>
        <div class="row">
          <div class="col-sm-12 form-group">
            <button class="btn btn-primary pull-right" name="tombol_kirim" type="submit">Send</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- foter -->
  <footer style="padding:30px; background-color: #252638;" class="container-fluid text-center">
    <a href="#myPage" title="To Top">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
    <p style="color: #FFF;"><strong>Copyright © 2021 <a href="http://dialoegue.id/" title="visit" target="_blank">SLMN</a></strong>. All Right Reserved.<br>DIALOGUE</p>
  </footer>

  <script>
    $(document).ready(function() {
      // Add smooth scrolling to all links in navbar + footer link
      $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 900, function() {

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if
      });

      $(window).scroll(function() {
        $(".slideanim").each(function() {
          var pos = $(this).offset().top;

          var winTop = $(window).scrollTop();
          if (pos < winTop + 600) {
            $(this).addClass("slide");
          }
        });
      });
    })
  </script>
</body>

</html>