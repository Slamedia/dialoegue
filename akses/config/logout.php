    <?php
    //koneksi
    date_default_timezone_set("Asia/Jakarta");
    $con = new PDO("mysql:host=localhost;dbname=sppdb", "root", "");
    session_start();
    $akses_log = $_SESSION["id_akses_login"];

    //awal
    $query_tampil_admin = $con->prepare("select * from admin where id_akses_login='$akses_log'");
    $query_tampil_admin->execute();
    $data_tampil_admin = $query_tampil_admin->fetch();

    $query_tampil_akses_login = $con->prepare("select * from akses_login where id_akses_login='$akses_log'");
    $query_tampil_akses_login->execute();
    $data_tampil_akses_login = $query_tampil_akses_login->fetch();
    //btas

    $jam_klr = date("h : i : sa");
    $sttus = 'OFFLINE';
    if ($data_tampil_akses_login && $data_tampil_admin) {
        $id_log_aks_get = $data_tampil_akses_login['id_akses_login'];
        $id_log_adm = $data_tampil_admin['id_akses_login'];

        //update admin tabel
        $queryUpdate_adm = $con->prepare('UPDATE admin set status=? where id_akses_login=?');

        $queryUpdate_adm->bindParam(1, $sttus);
        $queryUpdate_adm->bindParam(2, $id_log_adm);

        $queryUpdate_adm->execute();

        //update akses login
        $queryUpdate = $con->prepare('UPDATE akses_login set jam_keluar_login=? where id_akses_login=?');

        $queryUpdate->bindParam(1, $jam_klr);
        $queryUpdate->bindParam(2, $id_log_aks_get);

        $queryUpdate->execute();

        if ($queryUpdate && $queryUpdate_adm) {
            //penduduk

            $_SESSION['nik'] = '';
            $_SESSION['no_kk'] = '';
            $_SESSION['first_name'] = '';
            $_SESSION['last_name'] = '';
            $_SESSION['agama'] = '';
            $_SESSION['tempat_lahir'] = '';
            $_SESSION['tanggal_lahir'] = '';
            $_SESSION['tanggal_daftar'] = '';
            $_SESSION['jenis_kelamin'] = '';
            $_SESSION['no_tlp'] = '';
            $_SESSION['email'] = '';
            $_SESSION['password'] = '';
            $_SESSION['id_akses_login'] = '';
            $_SESSION['akses'] = '';

            unset($_SESSION['nik']);
            unset($_SESSION['no_kk']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            unset($_SESSION['agama']);
            unset($_SESSION['tempat_lahir']);
            unset($_SESSION['tanggal_lahir']);
            unset($_SESSION['tanggal_daftar']);
            unset($_SESSION['jenis_kelamin']);
            unset($_SESSION['no_tlp']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['id_akses_login']);
            unset($_SESSION['akses']);

            session_unset();
            session_destroy();
            echo "<script type='text/javascript'>alert('Anda Telah Logout, Sampai Jumpa!');window.location.href = '../../login.php';</script>";

            //admin
            session_start();
            $_SESSION['id_admin'] = '';
            $_SESSION['nama_admin'] = '';
            $_SESSION['email'] = '';
            $_SESSION['password'] = '';
            $_SESSION['id_akses_login'] = '';
            $_SESSION['akses'] = '';


            unset($_SESSION['id_admin']);
            unset($_SESSION['nama_admin']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['id_akses_login']);
            unset($_SESSION['akses']);

            session_unset();
            session_destroy();
            echo "<script type='text/javascript'>alert('Anda Telah Logout, Sampai Jumpa!');window.location.href = '../../login.php';</script>";
            //batas logout admin

            //petugas
            session_start();

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
    ?>