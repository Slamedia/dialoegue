<!DOCTYPE html>
<html>
<?php
date_default_timezone_set("Asia/Jakarta");
include('../../akses/config/library.php');
$lib = new Library();
if (isset($_GET['kode_nik'])) {
	$kd_nik = $_GET['kode_nik'];
	$data_surat = $lib->get_by_id_userSuratPermohonan($kd_nik);
} else {
	header('Location: ../../akses/user/tabel_data_pelayanan.php');
}
?>

<head>
	<title>Web Pelayanan Kelurahan Desa Bahagia</title>
	<!--icon-->
	<link rel="icon" type="icon/png" href="../../library/dist/img/logo.png">
	<!--bootstrap-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.position {
			margin-right: 12%;
			margin-top: -1px;
			font-size: 23px;
		}

		.borderbawah {
			border: 2px double black;
		}

		.fontsurat {
			font-size: 16px;
		}

		table {
			border-style: double;
			border-width: 3px;
			border-color: white;
		}

		table tr .text {
			text-align: center;
			font-size: 13px;
		}

		table tr td {
			font-size: 13px;
		}
	</style>
</head>

<body>
	<center>
		<table style="margin-top:3%;" width="625">
			<tr>
				<td>
					<img style="float:left" src="../../library/dist/img/logo.png" width="82" height="90">
					<center>
						<div class="position">
							<b>PEMERINTAHAN KABUPATEN BEKASI</b><br>
							<b>KECAMATAN BABELAN</b><br>
							<b>DESA BAHAGIA</b><br>
						</div>
					</center>
				</td>
			</tr>
			<tr>
				<td>
					<center>
						<font style="font-size:10px;"><i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jl. KH. Noer Ali Jl. KH. Mahmud Maksum No.01. Kode Pos : 17610 Kel. Bahagia, Kec. Babelan, Bekasi, Jawa Barat </i></font>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr class="borderbawah">
				</td>
			</tr>
			<?php
			$tgl2_tmp = $data_surat['tanggal_proses'];
			$tahun2_real = date("Y", strtotime($tgl2_tmp));
			?>
			<tr height="40">
				<td>
					<center><u style="margin-bottom:-2px;" class="fontsurat"><b>SURAT KETERANGAN PEMBUATAN KTP</b></u></center>
					<p style="margin-top:-8px;">
						<center>Nomor: <?= $data_surat['id_pelayanan']; ?>/SK/KADES/<?= $tahun2_real; ?></center>
					</p>
				</td>
			</tr>
		</table>
		<table width="625">
			<tr class="text2">
				<td>&nbsp; &nbsp; &nbsp; &nbsp; Yang bertanda tangan dibawah ini adalah Kepala Desa Bahagia Kecamatan Babelan Kabupaten Bekasi, dengan ini menerangkan bahwa :
				</td>
			</tr>
		</table>
		<br>
		<table width="520">
			<tr>
				<td width="140">
					Nama
				</td>
				<td width="6">
					:
				</td>
				<td>
					<?= $data_surat['nama_lengkap']; ?>
				</td>
			</tr>
			<tr>
				<td width="140">
					NIK
				</td>
				<td width="6">
					:
				</td>
				<td>
					<?= $data_surat['nik']; ?>
				</td>
			</tr>
			<tr>
				<td width="140">
					Tempat/Tanggal Lahir
				</td>
				<td width="6">
					:
				</td>
				<?php
				$tgl_tmp = $data_surat['tanggal_lahir'];
				$bulan = date("m", strtotime($tgl_tmp));
				if ($bulan == '01') {
					$bulanInd = 'Januari';
				} else if ($bulan == '02') {
					$bulanInd = 'Februari';
				} else if ($bulan == '03') {
					$bulanInd = 'Maret';
				} else if ($bulan == '04') {
					$bulanInd = 'April';
				} else if ($bulan == '05') {
					$bulanInd = 'Mei';
				} else if ($bulan == '06') {
					$bulanInd = 'Juni';
				} else if ($bulan == '07') {
					$bulanInd = 'Juli';
				} else if ($bulan == '08') {
					$bulanInd = 'Agustus';
				} else if ($bulan == '09') {
					$bulanInd = 'September';
				} else if ($bulan == '10') {
					$bulanInd = 'Oktober';
				} else if ($bulan == '11') {
					$bulanInd = 'November';
				} else if ($bulan == '12') {
					$bulanInd = 'Desember';
				}
				$tgl_real = date("d", strtotime($tgl_tmp));
				$tahun_real = date("Y", strtotime($tgl_tmp));
				?>
				<td>
					<?= $data_surat['tempat_lahir'] . ", " . $tgl_real . " " . $bulanInd . " " . $tahun_real ?>
				</td>
			</tr>
			<tr>
				<td width="140">
					Jenis Kelamin
				</td>
				<td width="6">
					:
				</td>
				<?php if ($data_surat['jenis_kelamin'] == 'p') {
					$jk = 'Pria';
				} else {
					$jk = 'Wanita';
				} ?>
				<td>
					<?= $jk; ?>
				</td>
			</tr>
			<tr>
				<td width="140">
					Gol. Darah
				</td>
				<td width="6">
					:
				</td>
				<td>
					<?= $data_surat['GolDarah']; ?>
				</td>
			</tr>
			<tr>
				<td width="140">
					Alamat
				</td>
				<td width="6">
					:
				</td>
				<td>
					Kelurahan Desa Bahagia
				</td>
			</tr>
			<tr>
				<td width="140">
					Agama
				</td>
				<td width="6">
					:
				</td>
				<td>
					<?= $data_surat['agama']; ?>
				</td>
			</tr>
			<?php
			$pekerjaan = '';
			if ($data_surat['pekerjaan'] == '1') {
				$pekerjaan = 'Belum Tidak Bekerja';
			} else if ($data_surat['pekerjaan'] == '2') {
				$pekerjaan = 'Mengurus Rumah Tangga';
			} else if ($data_surat['pekerjaan'] == '3') {
				$pekerjaan = 'Pelajar/Mahasiswa';
			} else if ($data_surat['pekerjaan'] == '4') {
				$pekerjaan = 'Pensiunan';
			} else if ($data_surat['pekerjaan'] == '5') {
				$pekerjaan = 'Pegawai Negri Sipil(PNS)';
			} else if ($data_surat['pekerjaan'] == '6') {
				$pekerjaan = 'TNI';
			} else if ($data_surat['pekerjaan'] == '7') {
				$pekerjaan = 'POLRI';
			} else if ($data_surat['pekerjaan'] == '8') {
				$pekerjaan = 'Perdagangan';
			} else if ($data_surat['pekerjaan'] == '9') {
				$pekerjaan = 'Petani/Pekebun';
			} else if ($data_surat['pekerjaan'] == '10') {
				$pekerjaan = 'Peternak';
			} else if ($data_surat['pekerjaan'] == '11') {
				$pekerjaan = 'Nelayan/Perikanan';
			} else if ($data_surat['pekerjaan'] == '12') {
				$pekerjaan = 'Industri';
			} else if ($data_surat['pekerjaan'] == '13') {
				$pekerjaan = 'Konstruksi';
			} else if ($data_surat['pekerjaan'] == '14') {
				$pekerjaan = 'Transportasi';
			} else if ($data_surat['pekerjaan'] == '15') {
				$pekerjaan = 'Karyawan Swasta';
			} else if ($data_surat['pekerjaan'] == '16') {
				$pekerjaan = 'Karyawan BUMN';
			} else if ($data_surat['pekerjaan'] == '17') {
				$pekerjaan = 'Karyawan BUMND';
			} else if ($data_surat['pekerjaan'] == '18') {
				$pekerjaan = 'Karyawan Honorer';
			} else if ($data_surat['pekerjaan'] == '19') {
				$pekerjaan = 'Buruh Harian Lapas';
			} else if ($data_surat['pekerjaan'] == '20') {
				$pekerjaan = 'Buruh Tani/Perkebunan';
			} else if ($data_surat['pekerjaan'] == '21') {
				$pekerjaan = 'Buruh Nelayan/Perikanan';
			} else if ($data_surat['pekerjaan'] == '22') {
				$pekerjaan = 'Buruh Peternakan';
			} else if ($data_surat['pekerjaan'] == '23') {
				$pekerjaan = 'Pembantu Rumah Tangga';
			} else if ($data_surat['pekerjaan'] == '24') {
				$pekerjaan = 'Tukang Cukur';
			} else if ($data_surat['pekerjaan'] == '25') {
				$pekerjaan = 'Tukang Listrik';
			} else if ($data_surat['pekerjaan'] == '26') {
				$pekerjaan = 'Tukang Batu';
			} else if ($data_surat['pekerjaan'] == '27') {
				$pekerjaan = 'Tukang Kayu';
			} else if ($data_surat['pekerjaan'] == '28') {
				$pekerjaan = 'Tukang Sol Sepatu';
			} else if ($data_surat['pekerjaan'] == '29') {
				$pekerjaan = 'Tukang Las/Pandai Besi';
			} else if ($data_surat['pekerjaan'] == '30') {
				$pekerjaan = 'Tukang Jahit';
			} else if ($data_surat['pekerjaan'] == '31') {
				$pekerjaan = 'Tukang Gigi';
			} else if ($data_surat['pekerjaan'] == '32') {
				$pekerjaan = 'Penata Rias';
			} else if ($data_surat['pekerjaan'] == '33') {
				$pekerjaan = 'Penata Busana';
			} else if ($data_surat['pekerjaan'] == '34') {
				$pekerjaan = 'Penata Rambut';
			} else if ($data_surat['pekerjaan'] == '35') {
				$pekerjaan = 'Mekanik';
			} else if ($data_surat['pekerjaan'] == '36') {
				$pekerjaan = 'Seniman';
			} else if ($data_surat['pekerjaan'] == '37') {
				$pekerjaan = 'Tabib';
			} else if ($data_surat['pekerjaan'] == '38') {
				$pekerjaan = 'Paraji';
			} else if ($data_surat['pekerjaan'] == '39') {
				$pekerjaan = 'Perancang Busana';
			} else if ($data_surat['pekerjaan'] == '40') {
				$pekerjaan = 'Peternak';
			} else if ($data_surat['pekerjaan'] == '41') {
				$pekerjaan = 'Penterjemah';
			} else if ($data_surat['pekerjaan'] == '42') {
				$pekerjaan = 'Pendeta';
			} else if ($data_surat['pekerjaan'] == '43') {
				$pekerjaan = 'Pastor';
			} else if ($data_surat['pekerjaan'] == '44') {
				$pekerjaan = 'Wartawan';
			} else if ($data_surat['pekerjaan'] == '45') {
				$pekerjaan = 'Ustadz / Mubaligh';
			} else if ($data_surat['pekerjaan'] == '46') {
				$pekerjaan = 'Juru Masak';
			} else if ($data_surat['pekerjaan'] == '47') {
				$pekerjaan = 'Promotor Acara';
			} else if ($data_surat['pekerjaan'] == '48') {
				$pekerjaan = 'Anggota DPR RI';
			} else if ($data_surat['pekerjaan'] == '49') {
				$pekerjaan = 'Anggota DPD';
			} else if ($data_surat['pekerjaan'] == '50') {
				$pekerjaan = 'Anggota BPK';
			} else if ($data_surat['pekerjaan'] == '51') {
				$pekerjaan = 'Presiden';
			} else if ($data_surat['pekerjaan'] == '52') {
				$pekerjaan = 'Wakil Presiden';
			} else if ($data_surat['pekerjaan'] == '53') {
				$pekerjaan = 'Anggota Mahkamah Konstitusi';
			} else if ($data_surat['pekerjaan'] == '54') {
				$pekerjaan = 'Anggota Kabinet/Kementrian';
			} else if ($data_surat['pekerjaan'] == '55') {
				$pekerjaan = 'Duta Besar';
			} else if ($data_surat['pekerjaan'] == '56') {
				$pekerjaan = 'Gubernur';
			} else if ($data_surat['pekerjaan'] == '57') {
				$pekerjaan = 'Wakil Gubernur';
			} else if ($data_surat['pekerjaan'] == '58') {
				$pekerjaan = 'Bupati';
			} else if ($data_surat['pekerjaan'] == '59') {
				$pekerjaan = 'Wakil Bupati';
			} else if ($data_surat['pekerjaan'] == '60') {
				$pekerjaan = 'Walikota';
			} else if ($data_surat['pekerjaan'] == '61') {
				$pekerjaan = 'Wakil Walikota';
			} else if ($data_surat['pekerjaan'] == '62') {
				$pekerjaan = 'Anggota DPRD Prop.';
			} else if ($data_surat['pekerjaan'] == '63') {
				$pekerjaan = 'Anggota DPRD Kab./Kota';
			} else if ($data_surat['pekerjaan'] == '64') {
				$pekerjaan = 'Dosen';
			} else if ($data_surat['pekerjaan'] == '65') {
				$pekerjaan = 'Guru';
			} else if ($data_surat['pekerjaan'] == '66') {
				$pekerjaan = 'Pilot';
			} else if ($data_surat['pekerjaan'] == '67') {
				$pekerjaan = 'Pengacara';
			} else if ($data_surat['pekerjaan'] == '68') {
				$pekerjaan = 'Notaris';
			} else if ($data_surat['pekerjaan'] == '69') {
				$pekerjaan = 'Arsitek';
			} else if ($data_surat['pekerjaan'] == '70') {
				$pekerjaan = 'Akuntan';
			} else if ($data_surat['pekerjaan'] == '71') {
				$pekerjaan = 'Konsultan';
			} else if ($data_surat['pekerjaan'] == '72') {
				$pekerjaan = 'Dokter';
			} else if ($data_surat['pekerjaan'] == '73') {
				$pekerjaan = 'Bidan';
			} else if ($data_surat['pekerjaan'] == '74') {
				$pekerjaan = 'Perawat';
			} else if ($data_surat['pekerjaan'] == '75') {
				$pekerjaan = 'Apotaker';
			} else if ($data_surat['pekerjaan'] == '76') {
				$pekerjaan = 'Psikater / Psikolog';
			} else if ($data_surat['pekerjaan'] == '77') {
				$pekerjaan = 'Penyiar Televisi';
			} else if ($data_surat['pekerjaan'] == '78') {
				$pekerjaan = 'Penyiar Radio';
			} else if ($data_surat['pekerjaan'] == '79') {
				$pekerjaan = 'Pelaut';
			} else if ($data_surat['pekerjaan'] == '80') {
				$pekerjaan = 'Peneliti';
			} else if ($data_surat['pekerjaan'] == '81') {
				$pekerjaan = 'Sopir';
			} else if ($data_surat['pekerjaan'] == '82') {
				$pekerjaan = 'Pialang';
			} else if ($data_surat['pekerjaan'] == '83') {
				$pekerjaan = 'Paranormal';
			} else if ($data_surat['pekerjaan'] == '84') {
				$pekerjaan = 'Pedagang';
			} else if ($data_surat['pekerjaan'] == '85') {
				$pekerjaan = 'Perangkat Desa';
			} else if ($data_surat['pekerjaan'] == '86') {
				$pekerjaan = 'Kepala Desa';
			} else if ($data_surat['pekerjaan'] == '87') {
				$pekerjaan = 'Birawati';
			} else if ($data_surat['pekerjaan'] == '88') {
				$pekerjaan = 'Wiraswasta';
			} else if ($data_surat['pekerjaan'] == '89') {
				$pekerjaan = 'Lainnya';
			}
			?>
			<tr>
				<td width="140">
					Pekerjaan
				</td>
				<td width="6">
					:
				</td>
				<td>
					<?= $pekerjaan; ?>
				</td>
			</tr>
			<tr>
				<td width="140">
					Kewarganegaraan
				</td>
				<td width="6">
					:
				</td>
				<td>
					<?= $data_surat['kewarganegaraan']; ?>
				</td>
			</tr>
		</table>
		<br>
		<table width="625">
			<tr>
				<td>
					<font size="2">&nbsp; &nbsp; &nbsp; &nbsp; Dengan ini dimohon kepada Bapak, untuk dapat mengeluarkan seperti tersebut
						pada perihal surat diatas, bahwa yang bersangkutan benar-benar Penduduk Desa Bahagia Kecamatan Babelan, dan belum mempunyai Identitas Kartu Tanda Penduduk (KTP).
					</font>
				</td>
			</tr>
		</table>
		<table width="625">
			<tr>
				<td>
					<font size="2">&nbsp; &nbsp; &nbsp; &nbsp; Demikian Surat Keterangan ini dibuat dengan sebenarnya, untuk dipergunakan seperlunya.
					</font>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table width="625">
			<?php
			$tgl2_tmp = $data_surat['tanggal_proses'];
			$bulan2 = date("m", strtotime($tgl2_tmp));
			if ($bulan2 == '01') {
				$bulanInd2 = 'Januari';
			} else if ($bulan2 == '02') {
				$bulanInd2 = 'Februari';
			} else if ($bulan2 == '03') {
				$bulanInd2 = 'Maret';
			} else if ($bulan2 == '04') {
				$bulanInd2 = 'April';
			} else if ($bulan2 == '05') {
				$bulanInd2 = 'Mei';
			} else if ($bulan2 == '06') {
				$bulanInd2 = 'Juni';
			} else if ($bulan2 == '07') {
				$bulanInd2 = 'Juli';
			} else if ($bulan2 == '08') {
				$bulanInd2 = 'Agustus';
			} else if ($bulan2 == '09') {
				$bulanInd2 = 'September';
			} else if ($bulan2 == '10') {
				$bulanInd2 = 'Oktober';
			} else if ($bulan2 == '11') {
				$bulanInd2 = 'November';
			} else if ($bulan2 == '12') {
				$bulanInd2 = 'Desember';
			}
			$tgl2_real = date("d", strtotime($tgl2_tmp));
			$tahun2_real = date("Y", strtotime($tgl2_tmp));
			?>
			<tr>
				<td style="font-size:13px;" width="420"><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Pemohon<br><br><br><br><br><br><br><span style="margin-left:56px;"><?= $data_surat['nama_lengkap']; ?></span></td>
				<td class="text" align="center">Desa Bahagia, <?= $tgl2_real . " " . $bulanInd2 . " " . $tahun2_real ?>
					<br>Kepala Desa Bahagia<br><img style="margin-left:4px;" src="../../library/img/stempel.png" height="100" width="100" alt="gambar stempel" /><br><span style="margin-left: 5px;">H. Eka Supria Atmaja, S.H.</span>
				</td>
			</tr>
		</table>
	</center>
	<script type="text/javascript">
		window.print();
	</script>
</body>

</html>