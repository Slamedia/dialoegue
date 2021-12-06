<?php
//koneksi
date_default_timezone_set("Asia/Jakarta");
$con = new PDO("mysql:host=localhost;dbname=sppdb", "root", "");
session_start();
$akses_log = $_SESSION["id_akses_login"];

//awal
$query_tampil_petugas = $con->prepare("select * from petugas where id_akses_login='$akses_log'");
$query_tampil_petugas->execute();
$data_tampil_petugas = $query_tampil_petugas->fetch();

$query_tampil_akses_login = $con->prepare("select * from akses_login where id_akses_login='$akses_log'");
$query_tampil_akses_login->execute();
$data_tampil_akses_login = $query_tampil_akses_login->fetch();
//btas

$jam_klr = date("h : i : sa");
$sttus = 'OFFLINE';
if ($data_tampil_akses_login && $data_tampil_petugas) {
    $id_log_aks_get = $data_tampil_akses_login['id_akses_login'];
    $id_log_pgs = $data_tampil_petugas['id_akses_login'];

    //update petugas tabel
    $queryUpdate_pgs = $con->prepare('UPDATE petugas set status=? where id_akses_login=?');

    $queryUpdate_pgs->bindParam(1, $sttus);
    $queryUpdate_pgs->bindParam(2, $id_log_pgs);

    $queryUpdate_pgs->execute();

    //update akses login
    $queryUpdate = $con->prepare('UPDATE akses_login set jam_keluar_login=? where id_akses_login=?');

    $queryUpdate->bindParam(1, $jam_klr);
    $queryUpdate->bindParam(2, $id_log_aks_get);

    $queryUpdate->execute();

    if ($queryUpdate && $queryUpdate_pgs) {
        //petugas

        $_SESSION['nip'] = '';
        $_SESSION['nama_lengkap_petugas'] = '';
        $_SESSION['email'] = '';
        $_SESSION['password'] = '';
        $_SESSION['id_akses_login'] = '';
        $_SESSION['akses'] = '';

        unset($_SESSION['nip']);
        unset($_SESSION['nama_lengkap_petugas']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['id_akses_login']);
        unset($_SESSION['akses']);

        session_unset();
        session_destroy();
        echo "<script type='text/javascript'>alert('Anda Telah Logout, Sampai Jumpa!');window.location.href = '../../login.php';</script>";
    } else {
        echo "Gagal mengubah data akses login!";
    }
} else {
    echo "Gagal mengambil data table database!";
}
