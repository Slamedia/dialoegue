<?php
$error = '';
date_default_timezone_set("Asia/Jakarta");
class Library
{
	public function __construct()
	{
		$host = "localhost";
		$dbname = "sppdb";
		$user = "root";
		$password = "";
		$this->db = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
	}
	//Add Kontak
	public function add_Kontak($nama_pengirim, $email, $komentar)
	{
		$tgl_send = date("Y-m-d");
		if (!isset($error)) {
			$data = $this->db->prepare('INSERT INTO kontak (nama_kontak, email, komentar, tanggal_send) VALUES (?, ?, ?, ?)');
			$data->bindParam(1, $nama_pengirim);
			$data->bindParam(2, $email);
			$data->bindParam(3, $komentar);
			$data->bindParam(4, $tgl_send);
			$data->execute();
			return $data->rowCount();
		} else {
			echo "<script>alert('Gagal Mengirim Pesan!')</script>" . $error;
			exit();
		}
	}
	public function registrasiPetugas($kd, $nama, $jk, $email, $pass, $alamat, $notlp)
	{
		if (!isset($error)) {
			//cek nik
			$cekNik = $this->db->prepare("SELECT * FROM petugas WHERE nip = '$kd'");
			$cekNik->bindParam('nip', $kd);
			$cekNik->execute();
			//cek email
			$cekEmail = $this->db->prepare("SELECT * FROM penduduk, admin, petugas WHERE email = '$email'");
			$cekEmail->bindParam('email', $email);
			$cekEmail->execute();
			if ($cekNik->rowCount() > 0) {
				echo "<script>alert('NIP Sudah Terdaftar!')</script>";
			} else if ($cekEmail->rowCount() > 0) {
				echo "<script>alert('Email Sudah Terdaftar!')</script>";
			} else {
				$akses = 'petugas';
				$id_log_aks = date("dmYhi");
				$status = 'OFFLINE';
				$data2 = $this->db->prepare('INSERT INTO akses_login(id_akses_login) VALUES (?)');
				$data2->bindParam(1, $id_log_aks);
				$data2->execute();
				if ($data2) {
					$data = $this->db->prepare('INSERT INTO petugas(nip, nama_lengkap_petugas, jenis_kelamin, email, password, alamat, no_tlp, id_akses_login, akses, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)');
					$data->bindParam(1, $kd);
					$data->bindParam(2, $nama);
					$data->bindParam(3, $jk);
					$data->bindParam(4, $email);
					$data->bindParam(5, $pass);
					$data->bindParam(6, $alamat);
					$data->bindParam(7, $notlp);
					$data->bindParam(8, $id_log_aks);
					$data->bindParam(9, $akses);
					$data->bindParam(10, $status);
					$data->execute();
					return $data->rowCount();
				}
			}
		} else {
			echo "<script>alert('Gagal menginput petugas, silahkan ulangi kembali!')</script>" . $error;
			exit();
		}
	}
	public function registrasiAdmin($kd, $nama, $jk, $email, $pass, $alamat, $notlp)
	{
		$akses = 'admin';
		if (!isset($error)) {
			//cek nik
			$cekNik = $this->db->prepare("SELECT * FROM admin WHERE id_admin = '$kd'");
			$cekNik->bindParam('id_admin', $kd);
			$cekNik->execute();
			//cek email
			$cekEmail = $this->db->prepare("SELECT * FROM penduduk, admin, petugas WHERE email = '$email'");
			$cekEmail->bindParam('email', $email);
			$cekEmail->execute();
			if ($cekNik->rowCount() > 0) {
				echo "<script>alert('NIP Sudah Terdaftar!')</script>";
			} else if ($cekEmail->rowCount() > 0) {
				echo "<script>alert('Email Sudah Terdaftar!')</script>";
			} else {
				$id_log_aks = date("dmYhi");
				$stts = 'OFFLINE';
				$data2 = $this->db->prepare('INSERT INTO akses_login(id_akses_login) VALUES (?)');
				$data2->bindParam(1, $id_log_aks);
				$data2->execute();
				if ($data2) {
					$data = $this->db->prepare('INSERT INTO admin(id_admin, nama_admin, jenis_kelamin, email, password, alamat, no_tlp, id_akses_login, akses, status) VALUES (?, ?, ?, ?, ? ,? ,? ,? ,?, ?)');
					$data->bindParam(1, $kd);
					$data->bindParam(2, $nama);
					$data->bindParam(3, $jk);
					$data->bindParam(4, $email);
					$data->bindParam(5, $pass);
					$data->bindParam(6, $alamat);
					$data->bindParam(7, $notlp);
					$data->bindParam(8, $id_log_aks);
					$data->bindParam(9, $akses);
					$data->bindParam(10, $stts);
					$data->execute();
					return $data->rowCount();
				}
			}
		} else {
			echo "<script>alert('Gagal menginput admin, silahkan ulangi kembali!')</script>" . $error;
			exit();
		}
	}
	//Add Penduduk
	public function registrasiP($kd, $kk, $fn, $ln, $agama, $pek, $kew, $kel, $perk, $tml, $tgl, $jk, $gol, $email, $pass, $tlp)
	{
		$akses = "penduduk";
		$tgl_daftar = date("Y-m-d");
		if (!isset($error)) {
			//cek nik
			$cekNik = $this->db->prepare("SELECT * FROM penduduk WHERE nik = '$kd'");
			$cekNik->bindParam('nik', $kd);
			$cekNik->execute();
			//cek email
			$cekEmail = $this->db->prepare("SELECT * FROM penduduk, admin, petugas WHERE email = '$email'");
			$cekEmail->bindParam('email', $email);
			$cekEmail->execute();
			if ($cekNik->rowCount() > 0) {
				echo "<script>alert('Nik Sudah Terdaftar!')</script>";
			} else if ($cekEmail->rowCount() > 0) {
				echo "<script>alert('Email Sudah Terdaftar!')</script>";
			} else {
				//aksesLogin
				//akses login
				$id_log_aks = date("dmYhi");
				$id_pen = date("dmYhis");
				$data1 = $this->db->prepare('INSERT INTO akses_login(id_akses_login) VALUES (?)');
				$data1->bindParam(1, $id_log_aks);
				$data1->execute();
				//kartukeluarga
				$data2 = $this->db->prepare('INSERT INTO kartukeluarga(no_kk) VALUES (?)');
				$data2->bindParam(1, $kk);
				$data2->execute();
				$status = 'OFFLINE';
				if ($data1 && $data2) {
					$data = $this->db->prepare('INSERT INTO penduduk (nik, id_pen, no_kk, first_name, last_name, agama, pekerjaan,	kewarganegaraan, status_hub_kel, status_perkawinan, tempat_lahir, tanggal_lahir, tanggal_daftar, jenis_kelamin, GolDarah, email, password, notlp, id_akses_login, akses, status) VALUES (?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? , ?, ?, ? ,? ,? ,? ,? , ?, ?, ?)');
					$data->bindParam(1, $kd);
					$data->bindParam(2, $id_pen);
					$data->bindParam(3, $kk);
					$data->bindParam(4, $fn);
					$data->bindParam(5, $ln);
					$data->bindParam(6, $agama);
					$data->bindParam(7, $pek);
					$data->bindParam(8, $kew);
					$data->bindParam(9, $kel);
					$data->bindParam(10, $perk);
					$data->bindParam(11, $tml);
					$data->bindParam(12, $tgl);
					$data->bindParam(13, $tgl_daftar);
					$data->bindParam(14, $jk);
					$data->bindParam(15, $gol);
					$data->bindParam(16, $email);
					$data->bindParam(17, $pass);
					$data->bindParam(18, $tlp);
					$data->bindParam(19, $id_log_aks);
					$data->bindParam(20, $akses);
					$data->bindParam(21, $status);
					$data->execute();
					return $data->rowCount();
				} else {
					echo "Gagal Menambahkan Kartu Keluarga";
				}
			}
		} else {
			echo "<script>alert('Gagal menginput penduduk, silahkan ulangi kembali!')</script>" . $error;
			exit();
		}
	}
	//Registrasi Anggota Keluarga
	public function registrasiAnggotaKeluarga($kd, $kk, $allN, $agama, $pek, $kew, $kel, $tml, $tgl, $jk, $gol, $perk)
	{
		$tgl_lhrStr = date("Y-m-d", strtotime($tgl));
		$id = date('dmYhi');
		if (!isset($error)) {
			//Anggota Keluarga
			$data = $this->db->prepare('INSERT INTO anggota_keluarga (id_anggota, no_kk, nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, GolDarah, agama, pekerjaan,	kewarganegaraan, status_hub_kel, status_perkawinan) VALUES (?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? , ?)');
			$data->bindParam(1, $id);
			$data->bindParam(2, $kk);
			$data->bindParam(3, $kd);
			$data->bindParam(4, $allN);
			$data->bindParam(5, $tml);
			$data->bindParam(6, $tgl_lhrStr);
			$data->bindParam(7, $jk);
			$data->bindParam(8, $gol);
			$data->bindParam(9, $agama);
			$data->bindParam(10, $pek);
			$data->bindParam(11, $kew);
			$data->bindParam(12, $kel);
			$data->bindParam(13, $perk);


			$data->execute();
			return $data->rowCount();
		} else {
			echo "<script>alert('Gagal menginput penduduk, silahkan ulangi kembali!')</script>" . $error;
			exit();
		}
	}
	//Add KK
	public function add_KK($kd_KK, $nama_kk, $almt, $rt, $rw, $kode_ps, $kel, $kec, $kab, $prov, $tglSah)
	{
		$tgl_update_KK = date("Y-m-d");
		$idkk = date("dmYhis");
		$data = $this->db->prepare('INSERT INTO kartukeluarga (no_kk, id_kk, nama_kepalaKeluarga, alamat, rt, rw, zip, kelurahan, kecamatan, kabupaten, propinsi, tglsahKK, tgl_update) VALUES (?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,?)');

		$data->bindParam(1, $kd_KK);
		$data->bindParam(2, $idkk);
		$data->bindParam(3, $nama_kk);
		$data->bindParam(4, $almt);
		$data->bindParam(5, $rt);
		$data->bindParam(6, $rw);
		$data->bindParam(7, $kode_ps);
		$data->bindParam(8, $kel);
		$data->bindParam(9, $kec);
		$data->bindParam(10, $kab);
		$data->bindParam(11, $prov);
		$data->bindParam(12, $tglSah);
		$data->bindParam(13, $tgl_update_KK);

		$data->execute();
		return $data->rowCount();
	}
	//ktp baru
	public function registrasiPelayananKTPKehilangan(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$kk,
		$ukuran_file2,
		$tipe_file2,
		$tmp2,
		$kehilangan,
		$tipe_file4,
		$ukuran_file4,
		$tmp4,
		$sts,
		$nip
	) {
		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_sek = date('dmYHis') . $sek;

		// Set path folder tempat menyimpan fotonya
		$path = "../../berkas/rtrw/" . $foto_sek;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kk = date('dmYHis') . $kk;

		// Set path folder tempat menyimpan fotonya
		$path2 = "../../berkas/kk/" . $foto_kk;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kehilangan = date('dmYHis') . $kehilangan;

		// Set path folder tempat menyimpan fotonya
		$path4 = "../../berkas/surat_kehilangan/" . $foto_kehilangan;

		// Proses upload
		if ($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file2 == "image/jpeg" || $tipe_file2 == "image/png" || $tipe_file4 == "image/jpeg" || $tipe_file4 == "image/png") { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
			if ($ukuran_file <= 2097152 || $ukuran_file2 <= 2097152 || $ukuran_file4 <= 2097152) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
				if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp2, $path2) && move_uploaded_file($tmp4, $path4)) { // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$sql = $this->db->prepare("INSERT INTO pelayanan(id_pelayanan, nik_penduduk, nama_penduduk, 
				tanggal_ajukan, keterangan_pelayanan, gambar_rt_rw, gambar_kk, gambar_akte, gambar_surat_nikah, surat_keterangan_pindah, gambar_surat_kehilangan, 
				nip_petugas, nama_petugas, status_proses_pengajuan, tanggal_proses, keterangan) VALUES(:id, :nik, :nama, :tglaju, :ket, :gambar1, :gambar2, :gambar3, 
				:gambar4, :gambar5, :gambar6, :nip, :nama_p, :status, :tgl_pr, :keterangan)");
					$tgl_format = date("Y-m-d");
					$foto2 = 'Empty';
					$foto3 = 'Empty';
					$foto4 = 'Empty';
					$foto5 = 'Empty';
					$foto6 = 'Empty';
					$nama_pet = '';
					$keterangan_p = '';
					$sql->bindParam(':id', $kd);
					$sql->bindParam(':nik', $kd_p);
					$sql->bindParam(':nama', $nama);
					$sql->bindParam(':tglaju', $tgl);
					$sql->bindParam(':ket', $ket);
					$sql->bindParam(':gambar1', $foto_sek);
					$sql->bindParam(':gambar2', $foto_kk); //kosong
					$sql->bindParam(':gambar3', $foto3); //kosng
					$sql->bindParam(':gambar4', $foto4); //kosong
					$sql->bindParam(':gambar5', $foto5);
					$sql->bindParam(':gambar6', $foto_kehilangan);
					$sql->bindParam(':nip', $nip); //kosong
					$sql->bindParam(':nama_p', $nama_pet); //kosong
					$sql->bindParam(':status', $sts);
					$sql->bindParam(':tgl_pr', $tgl_format);
					$sql->bindParam(':keterangan', $keterangan_p); //kosong

					$sql->execute(); // Eksekusi query insert

					if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
						// Jika Sukses, Lakukan :
						echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan KTP Baru!');window.location.href = 'ktp_baru.php';</script>"; //redirect halaman
					} else {
						// Jika Gagal, Lakukan :
						echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan KTP Baru!');window.location.href = 'ktp_baru.php';</script>";
					}
				} else {
					// Jika gambar gagal diupload, Lakukan :
					echo "<script type='text/javascript'>alert('Gagal mengupload anda diharuskan mengisi yang diwajibkan!');window.location.href = 'ktp_baru.php';</script>";
				}
			} else {
				// Jika ukuran file lebih dari 1MB, lakukan :
				echo "<script type='text/javascript'>alert('Size tidak boleh lebih dari 2 Mb!');window.location.href = 'ktp_baru.php';</script>";
			}
		} else {
			// Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
			echo "<script type='text/javascript'>alert('Gambar yang diupload harus ber ekstensi JPG/JPEG/PNG');window.location.href = 'ktp_baru.php';</script>";
		}
	}
	//ktp baru
	public function registrasiPelayananKTP(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$kk,
		$ukuran_file2,
		$tipe_file2,
		$tmp2,
		$sts,
		$nip
	) {
		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_sek = date('dmYHis') . $sek;

		// Set path folder tempat menyimpan fotonya
		$path = "../../berkas/rtrw/" . $foto_sek;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kk = date('dmYHis') . $kk;

		// Set path folder tempat menyimpan fotonya
		$path2 = "../../berkas/kk/" . $foto_kk;

		// Proses upload
		if ($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file2 == "image/jpeg" || $tipe_file2 == "image/png") { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
			if ($ukuran_file <= 2097152 || $ukuran_file2 <= 2097152) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
				if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp2, $path2)) { // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$sql = $this->db->prepare("INSERT INTO pelayanan(id_pelayanan, nik_penduduk, nama_penduduk, 
			tanggal_ajukan, keterangan_pelayanan, gambar_rt_rw, gambar_kk, gambar_akte, gambar_surat_nikah, surat_keterangan_pindah, gambar_surat_kehilangan, 
			nip_petugas, nama_petugas, status_proses_pengajuan, tanggal_proses, keterangan) VALUES(:id, :nik, :nama, :tglaju, :ket, :gambar1, :gambar2, :gambar3, 
			:gambar4, :gambar5, :gambar6, :nip, :nama_p, :status, :tgl_pr, :keterangan)");
					$tgl_format = date("Y-m-d");
					$foto2 = 'Empty';
					$foto3 = 'Empty';
					$foto4 = 'Empty';
					$foto5 = 'Empty';
					$foto6 = 'Empty';
					$nama_pet = '';
					$keterangan_p = '';
					$sql->bindParam(':id', $kd);
					$sql->bindParam(':nik', $kd_p);
					$sql->bindParam(':nama', $nama);
					$sql->bindParam(':tglaju', $tgl);
					$sql->bindParam(':ket', $ket);
					$sql->bindParam(':gambar1', $foto_sek);
					$sql->bindParam(':gambar2', $foto_kk); //kosong
					$sql->bindParam(':gambar3', $foto3); //kosng
					$sql->bindParam(':gambar4', $foto4); //kosong
					$sql->bindParam(':gambar5', $foto6);
					$sql->bindParam(':gambar6', $foto5);
					$sql->bindParam(':nip', $nip); //kosong
					$sql->bindParam(':nama_p', $nama_pet); //kosong
					$sql->bindParam(':status', $sts);
					$sql->bindParam(':tgl_pr', $tgl_format);
					$sql->bindParam(':keterangan', $keterangan_p); //kosong

					$sql->execute(); // Eksekusi query insert

					if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
						// Jika Sukses, Lakukan :
						echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan KTP Baru!');window.location.href = 'ktp_baru.php';</script>"; //redirect halaman
					} else {
						// Jika Gagal, Lakukan :
						echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan KTP Baru!');window.location.href = 'ktp_baru.php';</script>";
					}
				} else {
					// Jika gambar gagal diupload, Lakukan :
					echo "<script type='text/javascript'>alert('Gagal mengupload anda diharuskan mengisi yang diwajibkan!');window.location.href = 'ktp_baru.php';</script>";
				}
			} else {
				// Jika ukuran file lebih dari 1MB, lakukan :
				echo "<script type='text/javascript'>alert('Size tidak boleh lebih dari 2 Mb!');window.location.href = 'ktp_baru.php';</script>";
			}
		} else {
			// Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
			echo "<script type='text/javascript'>alert('Gambar yang diupload harus ber ekstensi JPG/JPEG/PNG');window.location.href = 'ktp_baru.php';</script>";
		}
	}
	//ktp baru
	public function registrasiPelayananKTP_pindah(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$kk,
		$ukuran_file2,
		$tipe_file2,
		$tmp2,
		$pindah,
		$ukuran_file3,
		$tipe_file3,
		$tmp3,
		$sts,
		$nip
	) {
		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_sek = date('dmYHis') . $sek;

		// Set path folder tempat menyimpan fotonya
		$path = "../../berkas/rtrw/" . $foto_sek;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kk = date('dmYHis') . $kk;

		// Set path folder tempat menyimpan fotonya
		$path2 = "../../berkas/kk/" . $foto_kk;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_pindah = date('dmYHis') . $pindah;

		// Set path folder tempat menyimpan fotonya
		$path3 = "../../berkas/keterangan_pindah/" . $foto_pindah;

		// Proses upload
		if ($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file2 == "image/jpeg" || $tipe_file2 == "image/png" ||  $tipe_file3 == "image/jpeg" || $tipe_file3 == "image/png") { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
			if ($ukuran_file <= 2097152 || $ukuran_file2 <= 2097152 || $ukuran_file3 <= 2097152) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
				if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp2, $path2) && move_uploaded_file($tmp3, $path3)) { // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$sql = $this->db->prepare("INSERT INTO pelayanan(id_pelayanan, nik_penduduk, nama_penduduk, 
			tanggal_ajukan, keterangan_pelayanan, gambar_rt_rw, gambar_kk, gambar_akte, gambar_surat_nikah, surat_keterangan_pindah, gambar_surat_kehilangan, 
			nip_petugas, nama_petugas, status_proses_pengajuan, tanggal_proses, keterangan) VALUES(:id, :nik, :nama, :tglaju, :ket, :gambar1, :gambar2, :gambar3, 
			:gambar4, :gambar5, :gambar6, :nip, :nama_p, :status, :tgl_pr, :keterangan)");
					$tgl_format = date("Y-m-d");
					$foto2 = 'Empty';
					$foto3 = 'Empty';
					$foto4 = 'Empty';
					$foto5 = 'Empty';
					$foto6 = 'Empty';
					$nama_pet = '';
					$keterangan_p = '';
					$sql->bindParam(':id', $kd);
					$sql->bindParam(':nik', $kd_p);
					$sql->bindParam(':nama', $nama);
					$sql->bindParam(':tglaju', $tgl);
					$sql->bindParam(':ket', $ket);
					$sql->bindParam(':gambar1', $foto_sek);
					$sql->bindParam(':gambar2', $foto_kk); //kosong
					$sql->bindParam(':gambar3', $foto3); //kosng
					$sql->bindParam(':gambar4', $foto4); //kosong
					$sql->bindParam(':gambar5', $foto_pindah);
					$sql->bindParam(':gambar6', $foto5);
					$sql->bindParam(':nip', $nip); //kosong
					$sql->bindParam(':nama_p', $nama_pet); //kosong
					$sql->bindParam(':status', $sts);
					$sql->bindParam(':tgl_pr', $tgl_format);
					$sql->bindParam(':keterangan', $keterangan_p); //kosong

					$sql->execute(); // Eksekusi query insert

					if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
						// Jika Sukses, Lakukan :
						echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan KTP Baru!');window.location.href = 'ktp_baru.php';</script>"; //redirect halaman
					} else {
						// Jika Gagal, Lakukan :
						echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan KTP Baru!');window.location.href = 'ktp_baru.php';</script>";
					}
				} else {
					// Jika gambar gagal diupload, Lakukan :
					echo "<script type='text/javascript'>alert('Gagal mengupload anda diharuskan mengisi yang diwajibkan!');window.location.href = 'ktp_baru.php';</script>";
				}
			} else {
				// Jika ukuran file lebih dari 1MB, lakukan :
				echo "<script type='text/javascript'>alert('Size tidak boleh lebih dari 2 Mb!');window.location.href = 'ktp_baru.php';</script>";
			}
		} else {
			// Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
			echo "<script type='text/javascript'>alert('Gambar yang diupload harus ber ekstensi JPG/JPEG/PNG');window.location.href = 'ktp_baru.php';</script>";
		}
	}
	//kk baru
	public function registrasiKKBaruKehilangan(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$kk,
		$ukuran_file2,
		$tipe_file2,
		$tmp2,
		$nikah,
		$ukuran_file3,
		$tipe_file3,
		$tmp3,
		$kehilangan,
		$tipe_file4,
		$ukuran_file4,
		$tmp4,
		$sts,
		$nip
	) {
		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_sek = "Rt" . date('dmYHis') . $sek;

		// Set path folder tempat menyimpan fotonya
		$path = "../../berkas/rtrw/" . $foto_sek;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kk = date('dmYHis') . $kk;

		// Set path folder tempat menyimpan fotonya
		$path2 = "../../berkas/kk/" . $foto_kk;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_nikah = date('dmYHis') . $nikah;

		// Set path folder tempat menyimpan fotonya
		$path3 = "../../berkas/surat_nikah/" . $foto_nikah;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kehilangan = date('dmYHis') . $kehilangan;

		// Set path folder tempat menyimpan fotonya
		$path4 = "../../berkas/surat_kehilangan/" . $foto_kehilangan;

		// Proses upload
		if (
			$tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "image/jpg"
			|| $tipe_file2 == "image/jpeg" || $tipe_file2 == "image/png" || $tipe_file2 == "image/jpg"
			|| $tipe_file3 == "image/jpeg" || $tipe_file3 == "image/png" || $tipe_file3 == "image/jpg"
			|| $tipe_file4 == "image/jpeg" || $tipe_file4 == "image/png" || $tipe_file4 == "image/jpg"
		) { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
			if ($ukuran_file <= 2097152 || $ukuran_file2 <= 2097152 || $ukuran_file3 <= 2097152 || $ukuran_file4 <= 2097152) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 2MB
				if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp2, $path2) && move_uploaded_file($tmp3, $path3) && move_uploaded_file($tmp4, $path4)) { // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$sql = $this->db->prepare("INSERT INTO pelayanan(id_pelayanan, nik_penduduk, nama_penduduk, 
			tanggal_ajukan, keterangan_pelayanan, gambar_rt_rw, gambar_kk, gambar_akte, gambar_surat_nikah, surat_keterangan_pindah, gambar_surat_kehilangan, 
			nip_petugas, nama_petugas, status_proses_pengajuan, tanggal_proses, keterangan) VALUES(:id, :nik, :nama, :tglaju, :ket, :gambar1, :gambar2, :gambar3, 
			:gambar4, :gambar5, :gambar6, :nip, :nama_p, :status, :tgl_pr, :keterangan)");
					$tgl_format = date("Y-m-d");
					$foto2 = 'Empty';
					$foto3 = 'Empty';
					$foto4 = 'Empty';
					$foto5 = 'Empty';
					$foto6 = 'Empty';
					$nama_pet = '';
					$keterangan_p = '';
					$sql->bindParam(':id', $kd);
					$sql->bindParam(':nik', $kd_p);
					$sql->bindParam(':nama', $nama);
					$sql->bindParam(':tglaju', $tgl);
					$sql->bindParam(':ket', $ket);
					$sql->bindParam(':gambar1', $foto_sek);
					$sql->bindParam(':gambar2', $foto_kk);
					$sql->bindParam(':gambar3', $foto3);
					$sql->bindParam(':gambar4', $foto_nikah);
					$sql->bindParam(':gambar5', $foto5); //kosong
					$sql->bindParam(':gambar6', $foto_kehilangan); //kosong
					$sql->bindParam(':nip', $nip); //kosong
					$sql->bindParam(':nama_p', $nama_pet);
					$sql->bindParam(':status', $sts);
					$sql->bindParam(':tgl_pr', $tgl_format);
					$sql->bindParam(':keterangan', $keterangan_p); //kosong

					$sql->execute(); // Eksekusi query insert

					if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
						// Jika Sukses, Lakukan :
						echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan Kartu Keluarga!');window.location.href = 'kk_baru.php';</script>"; //redirect halaman
					} else {
						// Jika Gagal, Lakukan :
						echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan Kartu Keluarga!');window.location.href = 'kk_baru.php';</script>";
					}
				} else {
					// Jika gambar gagal diupload, Lakukan :
					echo "<script type='text/javascript'>alert('Gagal mengupload anda mengisi yang diwajibkan!');window.location.href = 'kk_baru.php';</script>";
				}
			} else {
				// Jika ukuran file lebih dari 1MB, lakukan :
				echo "<script type='text/javascript'>alert('Size tidak boleh lebih dari 2 Mb!');window.location.href = 'kk_baru.php';</script>";
			}
		} else {
			// Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
			echo "<script type='text/javascript'>alert('Gambar yang diupload harus ber ekstensi JPG/JPEG/PNG');window.location.href = 'kk_baru.php';</script>";
		}
	}
	public function registrasiKKBaruAnggota_Baru(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$kk,
		$ukuran_file2,
		$tipe_file2,
		$tmp2,
		$nikah,
		$ukuran_file3,
		$tipe_file3,
		$tmp3,
		$sakte,
		$ukuran_file5,
		$tipe_file5,
		$tmp5,
		$sts,
		$nip
	) {
		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_sek = "Rt" . date('dmYHis') . $sek;

		// Set path folder tempat menyimpan fotonya
		$path = "../../berkas/rtrw/" . $foto_sek;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_kk = date('dmYHis') . $kk;

		// Set path folder tempat menyimpan fotonya
		$path2 = "../../berkas/kk/" . $foto_kk;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_nikah = date('dmYHis') . $nikah;

		// Set path folder tempat menyimpan fotonya
		$path3 = "../../berkas/surat_nikah/" . $foto_nikah;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_akte = date('dmYHis') . $sakte;

		// Set path folder tempat menyimpan fotonya
		$path5 = "../../berkas/surat_akte/" . $foto_akte;

		// Proses upload
		if (
			$tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "image/jpg"
			|| $tipe_file2 == "image/jpeg" || $tipe_file2 == "image/png" || $tipe_file2 == "image/jpg"
			|| $tipe_file3 == "image/jpeg" || $tipe_file3 == "image/png" || $tipe_file3 == "image/jpg"
			|| $tipe_file5 == "image/jpeg" || $tipe_file5 == "image/png" || $tipe_file5 == "image/jpg"
		) { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
			if ($ukuran_file <= 2097152 || $ukuran_file2 <= 2097152 || $ukuran_file3 <= 2097152 || $ukuran_file5 <= 2097152) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 2MB
				if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp2, $path2) && move_uploaded_file($tmp3, $path3) && move_uploaded_file($tmp5, $path5)) { // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$sql = $this->db->prepare("INSERT INTO pelayanan(id_pelayanan, nik_penduduk, nama_penduduk, 
			tanggal_ajukan, keterangan_pelayanan, gambar_rt_rw, gambar_kk, gambar_akte, gambar_surat_nikah, surat_keterangan_pindah, gambar_surat_kehilangan, 
			nip_petugas, nama_petugas, status_proses_pengajuan, tanggal_proses, keterangan) VALUES(:id, :nik, :nama, :tglaju, :ket, :gambar1, :gambar2, :gambar3, 
			:gambar4, :gambar5, :gambar6, :nip, :nama_p, :status, :tgl_pr, :keterangan)");
					$tgl_format = date("Y-m-d");
					$foto2 = 'Empty';
					$foto3 = 'Empty';
					$foto4 = 'Empty';
					$foto5 = 'Empty';
					$foto6 = 'Empty';
					$nama_pet = '';
					$keterangan_p = '';
					$sql->bindParam(':id', $kd);
					$sql->bindParam(':nik', $kd_p);
					$sql->bindParam(':nama', $nama);
					$sql->bindParam(':tglaju', $tgl);
					$sql->bindParam(':ket', $ket);
					$sql->bindParam(':gambar1', $foto_sek);
					$sql->bindParam(':gambar2', $foto_kk);
					$sql->bindParam(':gambar3', $foto_akte);
					$sql->bindParam(':gambar4', $foto_nikah);
					$sql->bindParam(':gambar5', $foto5); //kosong
					$sql->bindParam(':gambar6', $foto6); //kosong
					$sql->bindParam(':nip', $nip); //kosong
					$sql->bindParam(':nama_p', $nama_pet);
					$sql->bindParam(':status', $sts);
					$sql->bindParam(':tgl_pr', $tgl_format);
					$sql->bindParam(':keterangan', $keterangan_p); //kosong

					$sql->execute(); // Eksekusi query insert

					if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
						// Jika Sukses, Lakukan :
						echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan Kartu Keluarga!');window.location.href = 'kk_baru.php';</script>"; //redirect halaman
					} else {
						// Jika Gagal, Lakukan :
						echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan Kartu Keluarga!');window.location.href = 'kk_baru.php';</script>";
					}
				} else {
					// Jika gambar gagal diupload, Lakukan :
					echo "<script type='text/javascript'>alert('Gagal mengupload anda mengisi yang diwajibkan!');window.location.href = 'kk_baru.php';</script>";
				}
			} else {
				// Jika ukuran file lebih dari 1MB, lakukan :
				echo "<script type='text/javascript'>alert('Size tidak boleh lebih dari 2 Mb!');window.location.href = 'kk_baru.php';</script>";
			}
		} else {
			// Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
			echo "<script type='text/javascript'>alert('Gambar yang diupload harus ber ekstensi JPG/JPEG/PNG');window.location.href = 'kk_baru.php';</script>";
		}
	}
	public function registrasiKKBaru(
		$kd,
		$kd_p,
		$nama,
		$tgl,
		$ket,
		$sek,
		$ukuran_file,
		$tipe_file,
		$tmp,
		$nikah,
		$ukuran_file3,
		$tipe_file3,
		$tmp3,
		$sts,
		$nip
	) {
		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_sek = "Rt" . date('dmYHis') . $sek;

		// Set path folder tempat menyimpan fotonya
		$path = "../../berkas/rtrw/" . $foto_sek;

		// Rename nama fotonya dengan menambahkan tanggal dan jam upload
		$foto_nikah = date('dmYHis') . $nikah;

		// Set path folder tempat menyimpan fotonya
		$path3 = "../../berkas/surat_nikah/" . $foto_nikah;

		// Proses upload
		if (
			$tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "image/jpg"
			|| $tipe_file3 == "image/jpeg" || $tipe_file3 == "image/png" || $tipe_file3 == "image/jpg"
		) { // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
			if ($ukuran_file <= 2097152 || $ukuran_file3 <= 2097152) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 2MB
				if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp3, $path3)) { // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$sql = $this->db->prepare("INSERT INTO pelayanan(id_pelayanan, nik_penduduk, nama_penduduk, 
			tanggal_ajukan, keterangan_pelayanan, gambar_rt_rw, gambar_kk, gambar_akte, gambar_surat_nikah, surat_keterangan_pindah, gambar_surat_kehilangan, 
			nip_petugas, nama_petugas, status_proses_pengajuan, tanggal_proses, keterangan) VALUES(:id, :nik, :nama, :tglaju, :ket, :gambar1, :gambar2, :gambar3, 
			:gambar4, :gambar5, :gambar6, :nip, :nama_p, :status, :tgl_pr, :keterangan)");
					$tgl_format = date("Y-m-d");
					$foto2 = 'Empty';
					$foto3 = 'Empty';
					$foto4 = 'Empty';
					$foto5 = 'Empty';
					$foto6 = 'Empty';
					$nama_pet = '';
					$keterangan_p = '';
					$sql->bindParam(':id', $kd);
					$sql->bindParam(':nik', $kd_p);
					$sql->bindParam(':nama', $nama);
					$sql->bindParam(':tglaju', $tgl);
					$sql->bindParam(':ket', $ket);
					$sql->bindParam(':gambar1', $foto_sek);
					$sql->bindParam(':gambar2', $foto2);
					$sql->bindParam(':gambar3', $foto3);
					$sql->bindParam(':gambar4', $foto_nikah);
					$sql->bindParam(':gambar5', $foto5); //kosong
					$sql->bindParam(':gambar6', $foto6); //kosong
					$sql->bindParam(':nip', $nip); //kosong
					$sql->bindParam(':nama_p', $nama_pet);
					$sql->bindParam(':status', $sts);
					$sql->bindParam(':tgl_pr', $tgl_format);
					$sql->bindParam(':keterangan', $keterangan_p); //kosong

					$sql->execute(); // Eksekusi query insert

					if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
						// Jika Sukses, Lakukan :
						echo "<script type='text/javascript'>alert('Berhasil melakukan pelayanan Kartu Keluarga!');window.location.href = 'kk_baru.php';</script>"; //redirect halaman
					} else {
						// Jika Gagal, Lakukan :
						echo "<script type='text/javascript'>alert('Gagal melakukan pelayanan Kartu Keluarga!');window.location.href = 'kk_baru.php';</script>";
					}
				} else {
					// Jika gambar gagal diupload, Lakukan :
					echo "<script type='text/javascript'>alert('Gagal mengupload anda mengisi yang diwajibkan!');window.location.href = 'kk_baru.php';</script>";
				}
			} else {
				// Jika ukuran file lebih dari 1MB, lakukan :
				echo "<script type='text/javascript'>alert('Size tidak boleh lebih dari 2 Mb!');window.location.href = 'kk_baru.php';</script>";
			}
		} else {
			// Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
			echo "<script type='text/javascript'>alert('Gambar yang diupload harus ber ekstensi JPG/JPEG/PNG');window.location.href = 'kk_baru.php';</script>";
		}
	}
	public function riwayatLogin()
	{
		$query = $this->db->prepare("SELECT * FROM akses_login");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}
	public function showAdmin()
	{
		$query = $this->db->prepare("SELECT * FROM admin");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}
	public function showPelayanan()
	{
		$query = $this->db->prepare("SELECT * FROM pelayanan");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}

	public function showPetugas()
	{
		$query = $this->db->prepare("SELECT * FROM petugas");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}

	public function showPenduduk()
	{
		$query = $this->db->prepare("SELECT * FROM penduduk");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}
	public function showPesan()
	{
		$query = $this->db->prepare("SELECT * FROM kontak");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}
	public function showPesanLimitAdmin()
	{
		$query = $this->db->prepare("SELECT * FROM kontak ORDER BY tanggal_send DESC LIMIT 10;");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}

	public function countAkunPetugas()
	{
		$query = $this->db->prepare("select count(*) from petugas");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	public function countAkunPenduduk()
	{
		$query = $this->db->prepare("select count(*) from penduduk");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	public function countAkunAdmin()
	{
		$query = $this->db->prepare("select count(*) from admin");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	//spesial count DISTINC
	public function countKK()
	{
		$query = $this->db->prepare("select count(DISTINCT no_kk) from kartukeluarga");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	public function countPelayanan()
	{
		$query = $this->db->prepare("select count(*) from pelayanan");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	public function countPesan()
	{
		$query = $this->db->prepare("select count(*) from kontak");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	public function countRiwayatLogin()
	{
		$query = $this->db->prepare("select count(*) from akses_login");
		$query->execute();
		$data = $query->fetchColumn();
		return $data;
	}
	public function showKartuKeluarga()
	{
		$query = $this->db->prepare("SELECT * FROM kartukeluarga");
		$query->execute();
		$data = $query->fetchAll();
		return $data;
	}
	//Get Penduduk
	public function get_by_id($kd_penduduk)
	{
		$query = $this->db->prepare("SELECT * FROM penduduk where id_pen=?");
		$query->bindParam(1, $kd_penduduk);
		$query->execute();
		return $query->fetch();
	}
	//Get Anggota Keluarga
	public function get_by_id_anggota($kd_ang)
	{
		$query = $this->db->prepare("SELECT * FROM anggota_keluarga where id_anggota=?");
		$query->bindParam(1, $kd_ang);
		$query->execute();
		return $query->fetch();
	}

	//Get ID USER Pendduk
	public function get_by_id_user($kd_penduduk)
	{
		$query = $this->db->prepare("SELECT * FROM penduduk where nik=?");
		$query->bindParam(1, $kd_penduduk);
		$query->execute();
		return $query->fetch();
	}
	//Get ID USER PETUGAS
	public function get_by_id_userPetugas($kd_petugas)
	{
		$query = $this->db->prepare("SELECT * FROM petugas where nip=?");
		$query->bindParam(1, $kd_petugas);
		$query->execute();
		return $query->fetch();
	}
	public function get_by_id_pelayananPetugas($kd_pet)
	{
		$query = $this->db->prepare("SELECT * FROM pelayanan where nip_petugas=?");
		$query->bindParam(1, $kd_pet);
		$query->execute();
		return $query->fetchAll();
	}
	public function get_by_id_Admins($kd_mins)
	{
		$query = $this->db->prepare("SELECT * FROM admin where id_admin=?");
		$query->bindParam(1, $kd_mins);
		$query->execute();
		return $query->fetch();
	}
	public function get_by_id_pelayananPet($kd_pelayanan)
	{
		$query = $this->db->prepare("SELECT * FROM pelayanan where id_pelayanan=?");
		$query->bindParam(1, $kd_pelayanan);
		$query->execute();
		return $query->fetch();
	}
	public function get_by_id_userKartuKeluarga($kd_kk)
	{
		$query = $this->db->prepare("SELECT * FROM kartukeluarga where no_kk=?");
		$query->bindParam(1, $kd_kk);
		$query->execute();
		return $query->fetch();
	}

	public function get_by_id_userAnggotaKeluarga($kd_kk_A)
	{
		$query = $this->db->prepare("SELECT * FROM anggota_keluarga where no_kk=?");
		$query->bindParam(1, $kd_kk_A);
		$query->execute();
		return $query->fetchAll();
	}
	public function get_by_id_userSuratPermohonan($kd_nik)
	{
		$query = $this->db->prepare("SELECT * FROM anggota_keluarga, pelayanan where anggota_keluarga.nik=?");
		$query->bindParam(1, $kd_nik);
		$query->execute();
		return $query->fetch();
	}
	public function get_by_id_userPelayanan($kd_penduduk2)
	{
		$query = $this->db->prepare("SELECT * FROM pelayanan where nik_penduduk=?");
		$query->bindParam(1, $kd_penduduk2);
		$query->execute();
		return $query->fetchAll();
	}
	public function get_by_id_userPelayanan2($kd_penduduk2)
	{
		$query = $this->db->prepare("SELECT * FROM pelayanan where nik_penduduk=? ORDER BY tanggal_ajukan DESC LIMIT 7;");
		$query->bindParam(1, $kd_penduduk2);
		$query->execute();
		return $query->fetchAll();
	}
	//Get kartu keluarga
	public function get_by_id_KK($kd_kartuKeluarga)
	{
		$query = $this->db->prepare("SELECT * FROM kartukeluarga where no_kk=?");
		$query->bindParam(1, $kd_kartuKeluarga);
		$query->execute();
		return $query->fetch();
	}

	public function get_by_id_KKUser($kd_kartuKeluarga)
	{
		$query = $this->db->prepare("SELECT * FROM kartukeluarga where id_kk=?");
		$query->bindParam(1, $kd_kartuKeluarga);
		$query->execute();
		return $query->fetch();
	}
	//Get admin
	public function get_by_id_admin($kd_admin)
	{
		$query = $this->db->prepare("SELECT * FROM admin where id_akses_login=?");
		$query->bindParam(1, $kd_admin);
		$query->execute();
		return $query->fetch();
	}

	//Get admin
	public function get_by_id_petugas($kd_petugas)
	{
		$query = $this->db->prepare("SELECT * FROM petugas where id_akses_login=?");
		$query->bindParam(1, $kd_petugas);
		$query->execute();
		return $query->fetch();
	}


	//update query
	public function updatePenduduk($id, $kd, $kk, $fn, $ln, $agama, $pek, $kew, $kel, $perk, $tml, $tgl, $jk, $gol, $email, $tlp)
	{
		$queryUpdateAnggota = $this->db->prepare('UPDATE anggota_keluarga set GolDarah=?, pekerjaan=?, kewarganegaraan=?, status_hub_kel=?, status_perkawinan=? where nik=?');
		$queryUpdateAnggota->bindParam(1, $gol);
		$queryUpdateAnggota->bindParam(2, $pek);
		$queryUpdateAnggota->bindParam(3, $kew);
		$queryUpdateAnggota->bindParam(4, $kel);
		$queryUpdateAnggota->bindParam(5, $perk);
		$queryUpdateAnggota->bindParam(6, $kd);
		$queryUpdateAnggota->execute();
		$tgl_lhrStr = date("Y-m-d", strtotime($tgl));
		$queryUpdate = $this->db->prepare('UPDATE penduduk set nik=?, no_kk=?, first_name=?, last_name=?, agama=?, pekerjaan=?, kewarganegaraan=?, status_hub_kel=?, status_perkawinan=?, tempat_lahir=?, tanggal_lahir=?, jenis_kelamin=?, Goldarah=?, email=?, notlp=?  where id_pen=?');
		$queryUpdate->bindParam(1, $kd);
		$queryUpdate->bindParam(2, $kk);
		$queryUpdate->bindParam(3, $fn);
		$queryUpdate->bindParam(4, $ln);
		$queryUpdate->bindParam(5, $agama);
		$queryUpdate->bindParam(6, $pek);
		$queryUpdate->bindParam(7, $kew);
		$queryUpdate->bindParam(8, $kel);
		$queryUpdate->bindParam(9, $perk);
		$queryUpdate->bindParam(10, $tml);
		$queryUpdate->bindParam(11, $tgl_lhrStr);
		$queryUpdate->bindParam(12, $jk);
		$queryUpdate->bindParam(13, $gol);
		$queryUpdate->bindParam(14, $email);
		$queryUpdate->bindParam(15, $tlp);
		$queryUpdate->bindParam(16, $id);
		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}
	public function updateAnggotaKel($id_a, $kd, $kk, $allN, $agama, $pek, $kew, $kel, $tml, $tgl, $jk, $gol, $perk)
	{
		$tgl_lhrStr = date("Y-m-d", strtotime($tgl));
		$queryUpdate = $this->db->prepare('UPDATE anggota_keluarga set  no_kk=?, nik=?, nama_lengkap=?, tempat_lahir=?, tanggal_lahir=?, jenis_kelamin=?, Goldarah=?, agama=?, pekerjaan=?, kewarganegaraan=?, status_hub_kel=?, status_perkawinan=? where id_anggota=?');
		$queryUpdate->bindParam(1, $kk);
		$queryUpdate->bindParam(2, $kd);
		$queryUpdate->bindParam(3, $allN);
		$queryUpdate->bindParam(4, $tml);
		$queryUpdate->bindParam(5, $tgl_lhrStr);
		$queryUpdate->bindParam(6, $jk);
		$queryUpdate->bindParam(7, $gol);
		$queryUpdate->bindParam(8, $agama);
		$queryUpdate->bindParam(9, $pek);
		$queryUpdate->bindParam(10, $kew);
		$queryUpdate->bindParam(11, $kel);
		$queryUpdate->bindParam(12, $perk);
		$queryUpdate->bindParam(13, $id_a);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}
	public function updatePendudukUser($id, $kd, $kk, $fn, $ln, $agama, $tml, $tgl, $jk, $email, $tlp)
	{
		$queryUpdate = $this->db->prepare('UPDATE penduduk set nik=?, no_kk=?, first_name=?, last_name=?, agama=?, tempat_lahir=?, tanggal_lahir=?, jenis_kelamin=?, email=?, notlp=?  where id=?');

		$queryUpdate->bindParam(1, $kd);
		$queryUpdate->bindParam(2, $kk);
		$queryUpdate->bindParam(3, $fn);
		$queryUpdate->bindParam(4, $ln);
		$queryUpdate->bindParam(5, $agama);
		$queryUpdate->bindParam(6, $tml);
		$queryUpdate->bindParam(7, $tgl);
		$queryUpdate->bindParam(8, $jk);
		$queryUpdate->bindParam(9, $email);
		$queryUpdate->bindParam(10, $tlp);
		$queryUpdate->bindParam(11, $id);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}
	//update Admin
	public function updateAdmin($kd, $nama, $jk, $email, $alamat, $notlp)
	{
		$queryUpdate = $this->db->prepare('UPDATE admin set nama_admin=?, jenis_kelamin=?, email=?, alamat=?, no_tlp=?  where id_admin=?');

		$queryUpdate->bindParam(1, $nama);
		$queryUpdate->bindParam(2, $jk);
		$queryUpdate->bindParam(3, $email);
		$queryUpdate->bindParam(4, $alamat);
		$queryUpdate->bindParam(5, $notlp);
		$queryUpdate->bindParam(6, $kd);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}

	public function updatePassword($id, $co)
	{
		$queryUpdate = $this->db->prepare('UPDATE penduduk set password=?  where id_pen=?');

		$queryUpdate->bindParam(1, $co);
		$queryUpdate->bindParam(2, $id);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}

	public function updatePasswordPet($id, $co)
	{
		$queryUpdate = $this->db->prepare('UPDATE petugas set password=?  where nip=?');

		$queryUpdate->bindParam(1, $co);
		$queryUpdate->bindParam(2, $id);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}

	public function updatePetugas($kd, $nama, $jk, $email, $alamat, $notlp)
	{
		$queryUpdate = $this->db->prepare('UPDATE petugas set nama_lengkap_petugas=?, jenis_kelamin=?, email=?, alamat=?, no_tlp=?  where nip=?');

		$queryUpdate->bindParam(1, $nama);
		$queryUpdate->bindParam(2, $jk);
		$queryUpdate->bindParam(3, $email);
		$queryUpdate->bindParam(4, $alamat);
		$queryUpdate->bindParam(5, $notlp);
		$queryUpdate->bindParam(6, $kd);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}
	public function updateKartuKeluarga($kd_KK, $nama_kk, $almt, $rt, $rw, $kode_ps, $kel, $kec, $kab, $prov, $tglSah)
	{
		$tgl_update_KK = date("Y-m-d");
		$queryUpdate = $this->db->prepare('UPDATE kartukeluarga set no_kk=?, id_kk=?, nama_kepalaKeluarga=?, alamat=?, rt=?, rw=?, zip=?, kelurahan=?, kecamatan=?, kabupaten=?, propinsi=?, tglsahKK=?, tgl_update=?  where no_kk=?');
		$idkk = date("dmYhis");
		$queryUpdate->bindParam(1, $kd_KK);
		$queryUpdate->bindParam(2, $idkk);
		$queryUpdate->bindParam(3, $nama_kk);
		$queryUpdate->bindParam(4, $almt);
		$queryUpdate->bindParam(5, $rt);
		$queryUpdate->bindParam(6, $rw);
		$queryUpdate->bindParam(7, $kode_ps);
		$queryUpdate->bindParam(8, $kel);
		$queryUpdate->bindParam(9, $kec);
		$queryUpdate->bindParam(10, $kab);
		$queryUpdate->bindParam(11, $prov);
		$queryUpdate->bindParam(12, $tglSah);
		$queryUpdate->bindParam(13, $tgl_update_KK);
		$queryUpdate->bindParam(14, $kd_KK);
		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}
	public function updateKartuKeluargaPetugas($id, $kd_KK, $nama_kk, $almt, $rt, $rw, $kode_ps, $kel, $kec, $kab, $prov, $tglSah)
	{
		$kdNew = 'Empty';
		$queryUpdatePenduduk = $this->db->prepare('UPDATE penduduk set no_kk=?  where no_kk=?');

		$queryUpdatePenduduk->bindParam(1, $kdNew);
		$queryUpdatePenduduk->bindParam(2, $id);

		$queryUpdatePenduduk->execute();

		$queryUpdateAng = $this->db->prepare('DELETE FROM anggota_keluarga  where no_kk=?');

		$queryUpdateAng->bindParam(1, $id);

		$queryUpdateAng->execute();

		if ($queryUpdatePenduduk && $queryUpdateAng) {
			//delete
			$query_kartu_keluarga = $this->db->prepare("DELETE FROM kartukeluarga where no_kk=?");

			$query_kartu_keluarga->bindParam(1, $id);

			$query_kartu_keluarga->execute();
			if ($query_kartu_keluarga) {
				$tgl_update_KK = date("Y-m-d");
				$idkk = date("dmYhis");
				$data = $this->db->prepare('INSERT INTO kartukeluarga (no_kk, id_kk, nama_kepalaKeluarga, alamat, rt, rw, zip, kelurahan, kecamatan, kabupaten, propinsi, tglsahKK, tgl_update) VALUES (?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,?)');

				$data->bindParam(1, $kd_KK);
				$data->bindParam(2, $idkk);
				$data->bindParam(3, $nama_kk);
				$data->bindParam(4, $almt);
				$data->bindParam(5, $rt);
				$data->bindParam(6, $rw);
				$data->bindParam(7, $kode_ps);
				$data->bindParam(8, $kel);
				$data->bindParam(9, $kec);
				$data->bindParam(10, $kab);
				$data->bindParam(11, $prov);
				$data->bindParam(12, $tglSah);
				$data->bindParam(13, $tgl_update_KK);

				$data->execute();
				return $data->rowCount();
			}
		} else {
			echo 'Gagal Update Kartu Keluarga';
		}
	}

	public function updatePelayanan($id, $nip, $nama, $sts, $tgl, $ket)
	{
		$queryUpdate = $this->db->prepare('UPDATE pelayanan set nip_petugas=?, nama_petugas=?, status_proses_pengajuan=?, tanggal_proses=?, keterangan=?  where id_pelayanan=?');

		$queryUpdate->bindParam(1, $nip);
		$queryUpdate->bindParam(2, $nama);
		$queryUpdate->bindParam(3, $sts);
		$queryUpdate->bindParam(4, $tgl);
		$queryUpdate->bindParam(5, $ket);
		$queryUpdate->bindParam(6, $id);

		$queryUpdate->execute();
		return $queryUpdate->rowCount();
	}

	public function delete($kd_penduduk)
	{
		$query = $this->db->prepare("DELETE FROM penduduk where id_akses_login=?");

		$query->bindParam(1, $kd_penduduk);

		$query->execute();
		//batas akses login penduduk
		if ($query) {
			//delete akses login row
			$query_akses_login = $this->db->prepare("DELETE FROM akses_login where id_akses_login=?");

			$query_akses_login->bindParam(1, $kd_penduduk);

			$query_akses_login->execute();
			return $query_akses_login->rowCount();
		} else {
			echo "Gagal delete akses login";
		}
	}

	//delete petugas
	public function deletePetugas($kd_petugas)
	{
		$query = $this->db->prepare("DELETE FROM petugas where id_akses_login=?");

		$query->bindParam(1, $kd_petugas);

		$query->execute();

		//batas delete akses login petugas

		if ($query) {
			//delete akses login row
			$query_akses_login = $this->db->prepare("DELETE FROM akses_login where id_akses_login=?");

			$query_akses_login->bindParam(1, $kd_petugas);

			$query_akses_login->execute();
			return $query_akses_login->rowCount();
		} else {
			echo "Gagal delete akses login";
		}
	}
	public function delete_anggotaKel($kk_anggota)
	{
		$query = $this->db->prepare("DELETE FROM anggota_keluarga where id_anggota=?");

		$query->bindParam(1, $kk_anggota);

		$query->execute();
		return $query->rowCount();
	}
	public function deleteAdmin($kd_admin)
	{
		$query = $this->db->prepare("DELETE FROM admin where id_akses_login=?");

		$query->bindParam(1, $kd_admin);

		$query->execute();

		//batas delete akses login

		if ($query) {
			//delete admin
			$query_akses_login = $this->db->prepare("DELETE FROM akses_login where id_akses_login=?");

			$query_akses_login->bindParam(1, $kd_admin);

			$query_akses_login->execute();
			return $query_akses_login->rowCount();
		} else {
			echo "Gagal delete akses login";
		}
	}

	public function delete_kk($kd_KK)
	{
		// UPDATE anggota_keluarga, penduduk SET anggota_keluarga.no_kk = 'Empty', penduduk.no_kk = 'Empty' WHERE anggota_keluarga.no_kk='21412412421' AND penduduk.no_kk='21412412421' ;
		$kdNew = 'Empty';
		$queryUpdatePenduduk = $this->db->prepare('UPDATE penduduk set no_kk=?  where no_kk=?');

		$queryUpdatePenduduk->bindParam(1, $kdNew);
		$queryUpdatePenduduk->bindParam(2, $kd_KK);

		$queryUpdatePenduduk->execute();

		$queryUpdateAng = $this->db->prepare('UPDATE anggota_keluarga set no_kk=?  where no_kk=?');

		$queryUpdateAng->bindParam(1, $kdNew);
		$queryUpdateAng->bindParam(2, $kd_KK);

		$queryUpdateAng->execute();

		if ($queryUpdatePenduduk && $queryUpdateAng) {
			//delete
			$query_kartu_keluarga = $this->db->prepare("DELETE FROM kartukeluarga where no_kk=?");

			$query_kartu_keluarga->bindParam(1, $kd_KK);

			$query_kartu_keluarga->execute();
			return $query_kartu_keluarga->rowCount();
		} else {
			echo "Gagal delete akses login";
		}
	}
	public function delete_pelayanan($kd_pelayanan)
	{
		$query = $this->db->prepare("DELETE FROM pelayanan where id_pelayanan=?");

		$query->bindParam(1, $kd_pelayanan);

		$query->execute();
		return $query->rowCount();
	}
	public function deletePesan($kd_pesan)
	{
		$query = $this->db->prepare("DELETE FROM kontak where id_kontak=?");

		$query->bindParam(1, $kd_pesan);

		$query->execute();
		return $query->rowCount();
	}
}
