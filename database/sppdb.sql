-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2020 at 08:29 PM
-- Server version: 10.3.27-MariaDB-log-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kelxyz_sppdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(16) NOT NULL,
  `nama_admin` varchar(30) NOT NULL,
  `jenis_kelamin` enum('p','w') NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `akses` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `jenis_kelamin`, `email`, `password`, `alamat`, `no_tlp`, `akses`) VALUES
('14122020084251', 'Sakura', 'w', 'sakura@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Bekasi Utara', '0829283194814', 'admin'),
('Admin01', 'Firmansyah', 'p', 'firmansyah.xrpl1.15@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'jakarta', '081384233919', 'admin'),
('admin02', 'udin', 'p', 'udin@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'alamat', 'no_tlp', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `akses_login`
--

CREATE TABLE `akses_login` (
  `id_akses_login` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `jam_masuk_login` varchar(20) NOT NULL,
  `jam_keluar_login` varchar(20) NOT NULL,
  `akses` varchar(10) NOT NULL,
  `tanggal_akses_login` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_login`
--

INSERT INTO `akses_login` (`id_akses_login`, `email`, `jam_masuk_login`, `jam_keluar_login`, `akses`, `tanggal_akses_login`) VALUES
(67, 'firmansyah.xrpl1.15@gmail.com', '09 : 53 : 31pm', 'Empty', 'admin', '2020-12-16'),
(68, 'firmansyah.xrpl1.15@gmail.com', '02 : 28 : 45am', 'Empty', 'admin', '2020-12-18'),
(69, 'firmansyah.xrpl1.15@gmail.com', '07 : 47 : 06pm', 'Empty', 'admin', '2020-12-26');

-- --------------------------------------------------------

--
-- Table structure for table `kartukeluarga`
--

CREATE TABLE `kartukeluarga` (
  `id` int(11) NOT NULL,
  `no_kk` varchar(20) NOT NULL,
  `nama_kepalaKeluarga` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(5) NOT NULL,
  `rw` varchar(5) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `kelurahan` varchar(30) NOT NULL,
  `kecamatan` varchar(30) NOT NULL,
  `kabupaten` varchar(30) NOT NULL,
  `propinsi` varchar(25) NOT NULL,
  `tglsahKK` date NOT NULL,
  `tgl_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kartukeluarga`
--

INSERT INTO `kartukeluarga` (`id`, `no_kk`, `nama_kepalaKeluarga`, `alamat`, `rt`, `rw`, `zip`, `kelurahan`, `kecamatan`, `kabupaten`, `propinsi`, `tglsahKK`, `tgl_update`) VALUES
(2, '3029283183192', 'Agus Santoso', 'Ujung Harapan Babelan Bekasi Utara', '12', '16', '21333', 'Bahagia', 'Babelan', 'Kabupaten Bekasi', 'Babelan', '2000-12-02', '2020-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama_kontak` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal_send` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `nama_kontak`, `email`, `komentar`, `tanggal_send`) VALUES
(3, 'Kholisah Lustinasari', 'lisalustinasari@gmail.com', 'Sistem Bagus Dan Membantu', '2020-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id_pelayanan` varchar(20) NOT NULL,
  `nik_penduduk` varchar(20) NOT NULL,
  `nama_penduduk` varchar(40) NOT NULL,
  `tanggal_ajukan` date NOT NULL,
  `keterangan_pelayanan` text NOT NULL,
  `gambar_rt_rw` varchar(200) NOT NULL,
  `gambar_kk` varchar(200) NOT NULL,
  `gambar_akte` varchar(200) NOT NULL,
  `gambar_surat_nikah` varchar(200) NOT NULL,
  `surat_keterangan_pindah` text NOT NULL,
  `gambar_surat_kehilangan` varchar(200) NOT NULL,
  `nip_petugas` varchar(20) NOT NULL,
  `nama_petugas` varchar(40) NOT NULL,
  `status_proses_pengajuan` varchar(20) NOT NULL,
  `tanggal_proses` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelayanan`
--

INSERT INTO `pelayanan` (`id_pelayanan`, `nik_penduduk`, `nama_penduduk`, `tanggal_ajukan`, `keterangan_pelayanan`, `gambar_rt_rw`, `gambar_kk`, `gambar_akte`, `gambar_surat_nikah`, `surat_keterangan_pindah`, `gambar_surat_kehilangan`, `nip_petugas`, `nama_petugas`, `status_proses_pengajuan`, `tanggal_proses`, `keterangan`) VALUES
('14122020155226', '', '', '2020-12-14', 'Pilih Pelayanan', '14122020155236download (1).jpg', '14122020155236download.jpg', 'Empty', 'Empty', '14122020155236', '14122020155236', '88173918177184', 'Kamu', 'diproses', '2020-12-14', 'Harap tunggu'),
('14122020173406', '9102998491839', 'Bang Adit', '2020-12-14', 'Membuat Kartu Keluarga Baru', 'Rt14122020173437Diagram Kontek SPPDB.vpd.jpg', '14122020173437WhatsApp Image 2020-12-13 at 01.01.00.jpeg', '14122020173437', '14122020173437WhatsApp Image 2020-12-13 at 00.58.58.jpeg', 'Empty', '14122020173437', '', '', 'Dikirim', '2020-12-14', ''),
('14122020201257', '3210029188172', 'Putra', '2020-12-14', 'Membuat KTP Baru', '14122020201331download (1).jpg', '14122020201331WhatsApp Image 2020-12-13 at 00.58.58.jpeg', 'Empty', 'Empty', '14122020201331', '14122020201331', '', '', 'Dikirim', '2020-12-14', '');

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `id` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_kk` varchar(20) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `agama` varchar(10) NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `jenis_kelamin` enum('p','w') NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(200) NOT NULL,
  `notlp` varchar(14) NOT NULL,
  `akses` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penduduk`
--

INSERT INTO `penduduk` (`id`, `nik`, `no_kk`, `first_name`, `last_name`, `agama`, `tempat_lahir`, `tanggal_lahir`, `tanggal_daftar`, `jenis_kelamin`, `email`, `password`, `notlp`, `akses`) VALUES
(1, '3901920491002', '3213131314', 'Bang', 'Muhammad', 'Islam', 'Jakarta', '2010-03-12', '2020-12-12', 'p', 'jakka@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '081218464995', 'penduduk');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `nip` varchar(20) NOT NULL,
  `nama_lengkap_petugas` varchar(30) NOT NULL,
  `jenis_kelamin` enum('p','w') NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `no_tlp` varchar(20) NOT NULL,
  `akses` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`nip`, `nama_lengkap_petugas`, `jenis_kelamin`, `email`, `password`, `alamat`, `no_tlp`, `akses`) VALUES
('88173918177184', 'Kamu', 'p', 'lol@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Bekasi', '098718491941', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `akses_login`
--
ALTER TABLE `akses_login`
  ADD PRIMARY KEY (`id_akses_login`);

--
-- Indexes for table `kartukeluarga`
--
ALTER TABLE `kartukeluarga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`id_pelayanan`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_login`
--
ALTER TABLE `akses_login`
  MODIFY `id_akses_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `kartukeluarga`
--
ALTER TABLE `kartukeluarga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
