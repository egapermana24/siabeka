-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 04:14 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siabeka`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `id_user`, `tgl_login`) VALUES
(25, 9, '2024-04-15 13:11:46'),
(26, 10, '2024-04-15 13:33:51'),
(27, 11, '2024-04-15 13:44:48'),
(28, 10, '2024-04-15 13:46:44'),
(29, 9, '2024-04-15 23:35:51'),
(30, 9, '2024-04-15 23:39:42'),
(31, 10, '2024-04-15 23:40:53'),
(32, 11, '2024-04-16 00:56:18'),
(33, 12, '2024-04-16 01:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `norma_waktu_komponen`
--

CREATE TABLE `norma_waktu_komponen` (
  `id_nwk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `id_uraian_kegiatan` int(11) NOT NULL,
  `norma_waktu` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `standar_beban_kerja` float DEFAULT NULL,
  `frekuensi_kegiatan` float DEFAULT NULL,
  `jumlah_beban_kerja` float DEFAULT NULL,
  `qty_tugas_penunjang` int(11) DEFAULT NULL,
  `faktor_tugas_penunjang` float DEFAULT NULL,
  `tgl_insert` timestamp NULL DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `norma_waktu_komponen`
--

INSERT INTO `norma_waktu_komponen` (`id_nwk`, `id_user`, `id_unit_kerja`, `id_uraian_kegiatan`, `norma_waktu`, `satuan`, `standar_beban_kerja`, `frekuensi_kegiatan`, `jumlah_beban_kerja`, `qty_tugas_penunjang`, `faktor_tugas_penunjang`, `tgl_insert`, `tgl_update`) VALUES
(75, 10, 3, 13, 10, 'LEMBAR', 8580, 1500, 0.174825, NULL, NULL, NULL, NULL),
(76, 10, 3, 14, 5, 'LEMBAR', 17160, 1000, 0.0582751, NULL, NULL, NULL, NULL),
(77, 10, 3, 15, 5, 'LEMBAR', 17160, 500, 0.0291375, NULL, NULL, NULL, NULL),
(78, 10, 3, 16, 10, 'LEMBAR', 8580, 1500, 0.174825, NULL, NULL, NULL, NULL),
(79, 10, 3, 17, 20, 'BERKAS', 4290, 2500, 0.582751, NULL, NULL, NULL, NULL),
(80, 10, 3, 35, 10, 'DLL', 8580, 365, 0.0425408, NULL, NULL, NULL, NULL),
(81, 10, 3, 38, 10, 'DLL', 8580, 365, 0.0425408, NULL, NULL, NULL, NULL),
(82, 10, 3, 23, 180, 'DLL', 476.667, NULL, NULL, 12, 0.0251748, NULL, NULL),
(83, 10, 3, 24, 180, 'DLL', 476.667, NULL, NULL, 4, 0.00839161, NULL, NULL),
(84, 10, 2, 8, 10, 'Berkas', 8400, 1000, 0.119048, NULL, NULL, NULL, NULL),
(85, 10, 2, 9, 15, 'Bendel', 5600, 1300, 0.232143, NULL, NULL, NULL, NULL),
(86, 10, 2, 10, 25, 'Lembar', 3360, 750, 0.223214, NULL, NULL, NULL, NULL),
(87, 10, 2, 11, 20, 'Bendel', 4200, 500, 0.119048, NULL, NULL, NULL, NULL),
(88, 10, 2, 12, 30, 'Berkas', 2800, 4000, 1.42857, NULL, NULL, NULL, NULL),
(89, 10, 2, 34, 35, 'Kali', 2400, 100, 0.0416667, NULL, NULL, NULL, NULL),
(90, 10, 2, 37, 5, 'Kali', 16800, 50, 0.00297619, NULL, NULL, NULL, NULL),
(91, 10, 2, 23, 120, 'Kali', 700, NULL, NULL, 12, 0.0171429, NULL, NULL),
(92, 10, 2, 24, 60, 'Kali', 1400, NULL, NULL, 4, 0.00285714, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(500) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `level` varchar(20) NOT NULL,
  `foto` text DEFAULT NULL,
  `tgl_insert` timestamp NULL DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `tanggal_lahir`, `username`, `password`, `level`, `foto`, `tgl_insert`, `tgl_update`) VALUES
(9, 'Naufal Rifqi Mubarok', '2003-03-19', 'admin', '$2y$10$Gc9Htnv4hieL7O6OBxmFh.q4F/bzvb/Niw2gFkDRUwh9XkCvFJg8S', 'admin', '15042024152836Foto almet BG merah.jpg', '2024-04-15 12:59:48', '2024-04-15 12:59:48'),
(10, 'NAUFAL RIFQI MUBAROK', NULL, 'P20637121031', '$2y$10$pDZzvv5CxsTRq6Yi67KADetVfa8IJEr/zpVRyiuix4GFCV2aTaz1i', 'user', NULL, NULL, NULL),
(11, 'EGA PERMANA', NULL, 'P20637121032', '$2y$10$iyfqYLVoh3oJWwfg1dtSM.PWKHXdXlnGXOD.Mp1pUBCXhH.mHynZG', 'user', NULL, NULL, NULL),
(12, 'Ahmad Ya Habibi', NULL, 'P20637121033', '$2y$10$u3836SZdQy1VZRUeSYZqkuWliugSuqkrjGljYK.Tr02NNFQjPk9G2', 'user', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit_kerja`
--

CREATE TABLE `unit_kerja` (
  `id_unit_kerja` int(11) NOT NULL,
  `nama_unit_kerja` varchar(100) NOT NULL,
  `tgl_insert` timestamp NULL DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_kerja`
--

INSERT INTO `unit_kerja` (`id_unit_kerja`, `nama_unit_kerja`, `tgl_insert`, `tgl_update`) VALUES
(1, 'Unit Kerja Rekam Medis Bagian Pendaftaran', NULL, NULL),
(2, 'Unit Kerja Rekam Medis Bagian Penyimpanan (Filling)', NULL, NULL),
(3, 'Unit Kerja Rekam Medis Bagian Koding', NULL, NULL),
(4, 'Unit Kerja Rekam Medis Bagian Pelaporan', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `uraian_kegiatan`
--

CREATE TABLE `uraian_kegiatan` (
  `id_uraian_kegiatan` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `jenis_tugas` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `tgl_insert` timestamp NULL DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uraian_kegiatan`
--

INSERT INTO `uraian_kegiatan` (`id_uraian_kegiatan`, `id_unit_kerja`, `jenis_tugas`, `deskripsi`, `tgl_insert`, `tgl_update`) VALUES
(1, 1, 'pokok', 'Menyiapkan Peralatan Kerja', NULL, NULL),
(2, 1, 'pokok', 'Mendaftarkan Pasien Baru', NULL, NULL),
(3, 1, 'pokok', 'Mendaftarkan Pasien Lama', NULL, NULL),
(4, 1, 'pokok', 'Memberikan Informasi Layanan Yang Akan Diterima Pasien', NULL, NULL),
(5, 1, 'pokok', 'Merakit Lembar Rekam Medis Baru', NULL, NULL),
(6, 1, 'pokok', 'Mengentry Sensus Harian Ke Komputer', NULL, NULL),
(7, 1, 'pokok', 'Merapihkan Peralatan Kerja', NULL, NULL),
(8, 2, 'pokok', 'Menerima Dan Mengecek Berkas Rekam Medis', NULL, NULL),
(9, 2, 'pokok', 'Mengecek Lembar Rekam Medis Dan Menata Di Rak Penyimpanan', NULL, NULL),
(10, 2, 'pokok', 'Mencatat Dokumen Rekam Medis Yang Keluar Atau Sedang Dipinjam', NULL, NULL),
(11, 2, 'pokok', 'Mendistribusikan Berkas Rekam Medis Ke Poliklinik', NULL, NULL),
(12, 2, 'pokok', 'Memilah Berkas Rekam Medis Inaktif', NULL, NULL),
(13, 3, 'pokok', 'Mencatat Dan Meneliti Kode Penyakit Dari Diagnosa Yang Ditulis Dokter, Kode Operasi Dari Tindakan Medis Yang Ditulis Dokter Atau Petugas Kesehatan Lainnya', NULL, NULL),
(14, 3, 'pokok', 'Mencatat Dan Meneliti Kode Sebab Kematian Yang Ditulis Oleh Dokter ', NULL, NULL),
(15, 3, 'pokok', 'Mencatat Hasil Pelayanan Kedalam Formulir Indeks Penyakit Sesuai Dengan Ketentuan Mencatat Indeks', NULL, NULL),
(16, 3, 'pokok', 'Menyimpan Indeks Tersebut Sesuai Dengan Ketentuan Menyimpan Indeks', NULL, NULL),
(17, 3, 'pokok', 'Membuat Laporan Penyakit (Morbiditas) Dan Laporan Kematian (Mortalitas) Berdasarkan Indeks Penyakit,Indeks Operasi Dan Indeks Kematian', NULL, NULL),
(18, 4, 'pokok', 'Membuat Laporan Harian Kunjungan Pasien Rawat Inap', NULL, NULL),
(19, 4, 'pokok', 'Melaporkan Data Rutin 10 Besar Penyakit', NULL, NULL),
(20, 4, 'pokok', 'Membuat Laporan Sensus Harian Rawat Inap Dari Tiap Ruangan', NULL, NULL),
(21, 4, 'pokok', 'Membuat Laporan Internal Dan Eksternal', NULL, NULL),
(22, 4, 'pokok', 'Membuat Laporan Indicator Pelayanan Fasyankes', NULL, NULL),
(23, 0, 'penunjang', 'Mengikuti pertemuan bulanan di Dinkes dalam program Jaminan Kesehatan Nasional', NULL, NULL),
(24, 0, 'penunjang', 'Mengikuti pertemuan triwulanan penyusunan profil kesehatan', NULL, NULL),
(34, 2, 'pokok', 'Menyiapkan Peralatan Kerja', NULL, NULL),
(35, 3, 'pokok', 'Menyiapkan Peralatan Kerja', NULL, NULL),
(36, 4, 'pokok', 'Menyiapkan Peralatan Kerja', NULL, NULL),
(37, 2, 'pokok', 'Merapihkan Peralatan Kerja', NULL, NULL),
(38, 3, 'pokok', 'Merapihkan Peralatan Kerja', NULL, NULL),
(39, 4, 'pokok', 'Merapihkan Peralatan Kerja', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `waktu_kerja_tersedia`
--

CREATE TABLE `waktu_kerja_tersedia` (
  `id_wkt` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `dipilih` int(11) DEFAULT NULL,
  `jam_kerja` float NOT NULL,
  `waktu_luang` float NOT NULL,
  `pola_hari_kerja` int(11) NOT NULL,
  `hari_tahun` int(11) NOT NULL,
  `jumlah_hari_minggu` int(11) NOT NULL,
  `libur_resmi` int(11) NOT NULL,
  `libur_cuti` int(11) NOT NULL,
  `jam_kerja_efektif_perminggu` float NOT NULL,
  `jam_kerja_efektif_perhari` float NOT NULL,
  `hari_kerja_efektif` float NOT NULL,
  `waktu_kerja_efektif_jam` float NOT NULL,
  `waktu_kerja_efektif_menit` float NOT NULL,
  `total_faktor_tugas_penunjang` float DEFAULT NULL,
  `standar_tugas_penunjang` float DEFAULT NULL,
  `jumlah_kebutuhan_tenaga_tugas_pokok` float DEFAULT NULL,
  `total_kebutuhan_tenaga` float DEFAULT NULL,
  `tgl_insert` timestamp NULL DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waktu_kerja_tersedia`
--

INSERT INTO `waktu_kerja_tersedia` (`id_wkt`, `id_user`, `id_unit_kerja`, `dipilih`, `jam_kerja`, `waktu_luang`, `pola_hari_kerja`, `hari_tahun`, `jumlah_hari_minggu`, `libur_resmi`, `libur_cuti`, `jam_kerja_efektif_perminggu`, `jam_kerja_efektif_perhari`, `hari_kerja_efektif`, `waktu_kerja_efektif_jam`, `waktu_kerja_efektif_menit`, `total_faktor_tugas_penunjang`, `standar_tugas_penunjang`, `jumlah_kebutuhan_tenaga_tugas_pokok`, `total_kebutuhan_tenaga`, `tgl_insert`, `tgl_update`) VALUES
(27, 10, 3, 0, 40, 0.25, 6, 365, 52, 15, 12, 30, 5, 286, 1430, 85800, 0.0335664, 1.03473, 1.1049, 1.14327, NULL, NULL),
(28, 10, 2, 1, 40, 0.25, 6, 365, 42, 33, 10, 30, 5, 280, 1400, 84000, 0.02, 1.02041, 2.16667, 2.21089, NULL, NULL),
(32, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 12, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 12, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 12, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 12, 4, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `norma_waktu_komponen`
--
ALTER TABLE `norma_waktu_komponen`
  ADD PRIMARY KEY (`id_nwk`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  ADD PRIMARY KEY (`id_unit_kerja`);

--
-- Indexes for table `uraian_kegiatan`
--
ALTER TABLE `uraian_kegiatan`
  ADD PRIMARY KEY (`id_uraian_kegiatan`);

--
-- Indexes for table `waktu_kerja_tersedia`
--
ALTER TABLE `waktu_kerja_tersedia`
  ADD PRIMARY KEY (`id_wkt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `norma_waktu_komponen`
--
ALTER TABLE `norma_waktu_komponen`
  MODIFY `id_nwk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  MODIFY `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uraian_kegiatan`
--
ALTER TABLE `uraian_kegiatan`
  MODIFY `id_uraian_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `waktu_kerja_tersedia`
--
ALTER TABLE `waktu_kerja_tersedia`
  MODIFY `id_wkt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
