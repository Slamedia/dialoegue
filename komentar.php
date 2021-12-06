<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- font awesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
    <div class="pembatas">
    
    <!-- header section -->

    <header>

        <a href="index.php" class="logo"><i class="fas fa-reply"></i>Back</a>

        <nav class="navbar">
            <a href="produk.php#terbaru">Terbaru</a>
            <a href="produk.php#promo">Promo</a>
            <a href="produk.php#layanan">Layanan</a>
            <a href="produk.php#menu">Produk</a>
            <a href="produk.php#testimoni">Testimoni</a>
            <a href="produk.php#kontak">Kontak</a>
        </nav>

        <div class="icons">
            <i class="fas fa-bars" id="menu-bars"></i>
            <i class="fas fa-search" id="search-icon"></i>
            <a href="#komen" class="fas fa-comments"></a>
            <a href="pesan.php" class="fas fa-shopping-cart"></a>
        </div>

    </header>

    <form action="" id="search-form">
        <input type="search" placeholder="Cari Disini..." name="" id="search-box">
        <label for="search-box" class="fas fa-search"></label>
        <i class="fas fa-times" id="close"></i>
    </form>

    <!-- order section   -->

    <section class="order" id="komen" style="padding-top: 80px;">

        <h3 class="sub-heading"> pesan sekarang </h3>
        <h1 class="heading"> mudah dan cepat </h1>

        <form action="">

            <div class="inputBox">
                <div class="input">
                    <span>Nama anda</span>
                    <input type="text" placeholder="masukan nama anda">
                </div>
                <div class="input">
                    <span>Nomor telpon</span>
                    <input type="number" placeholder="masukan nomer anda">
                </div>
            </div>
            <div class="inputBox">
                <div class="input">
                    <span>Pesanan anda</span>
                    <input type="text" placeholder="masukan produk">
                </div>
                <div class="input">
                    <span>Produk tambahan</span>
                    <input type="test" placeholder="masukan produk">
                </div>
            </div>
            <div class="inputBox">
                <div class="input">
                    <span>Berapa banyak</span>
                    <input type="number" placeholder="berapa banyak">
                </div>
                <div class="input">
                    <span>waktu dan tanggal</span>
                    <input type="datetime-local">
                </div>
            </div>
            <div class="inputBox">
                <div class="input">
                    <span>alamat</span>
                    <textarea name="" placeholder="masukkan alamat anda" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="input">
                    <span>pesan</span>
                    <textarea name="" placeholder="tinggalkan pesan" id="" cols="30" rows="10"></textarea>
                </div>
            </div>

            <input type="submit" value="Pesan Sekarang" class="btn">

        </form>

    </section>

    <!-- order section akhir -->

    <!-- footer section   -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>Lokasi</h3>
                <a href="">Bali</a>
                <a href="">Jawa</a>
                <a href="">Kalimantan</a>
                <a href="">Sulawesi</a>
                <a href="">Sumatra</a>
            </div>

            <div class="box">
                <h3>Akses cepat</h3>
                <a href="#home">home</a>
                <a href="#discc">diskon</a>
                <a href="#about">tentang</a>
                <a href="#menu">produk</a>
                <a href="#review">review</a>
                <a href="#order">pesan</a>
            </div>

            <div class="box">
                <h3>Info kontak</h3>
                <a href="https:/wa.me/+628967187255" target="_blank">+62 896-7187-255</a>
                <a href="">+62 896-7187-244</a>
                <a id="email">ryansahadha@gmail.com</a>
                <a id="email">ferguso2478@gmail.com</a>
                <a href="">Denpasar - Bali - 400104</a>
            </div>

            <div class="box">
                <h3>Ikuti Kami</h3>
                <a href="https://www.facebook.com/rizky.ryansahadha" target="_blank">facebook</a>
                <a href="https://twitter.com/RSahadha" target="_blank">twitter</a>
                <a href="https://www.instagram.com/ikiy_zahadha07/" target="_blank">instagram</a>
                <a href="https://www.linkedin.com/in/ryan-sahadha-187161225/" target="_blank">linkedin</a>
            </div>

        </div>

        <div class="credit"> &copy; copyright 2021 by <span>Rizky Ryan Sahadha</span> </div>

    </section>

    <!-- footer section akhir -->

    <!-- loader part  -->
    <div class="loader-container">
        <img src="images/terbaruloop.gif" alt="">
    </div>

</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>