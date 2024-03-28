-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2024 at 01:48 PM
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
  `faktor_tugas_penunjang` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `norma_waktu_komponen`
--

INSERT INTO `norma_waktu_komponen` (`id_nwk`, `id_user`, `id_unit_kerja`, `id_uraian_kegiatan`, `norma_waktu`, `satuan`, `standar_beban_kerja`, `frekuensi_kegiatan`, `jumlah_beban_kerja`, `qty_tugas_penunjang`, `faktor_tugas_penunjang`) VALUES
(1, 1, 1, 1, 123, 'Kali', 607.805, 234, 0.384992, 3, 0.262199),
(2, 1, 1, 2, 43, 'Lembar', 1738.6, 56, 0.0322098, 3, 0.262199),
(3, 1, 1, 3, 65, 'sdff', 1150.15, 686, 0.596444, 3, 0.262199),
(4, 1, 1, 4, 124, 'dsfdsfdf', 602.903, 56, 0.0928839, 3, 0.262199),
(5, 1, 1, 5, 523, 'sdfsdf', 142.945, 567, 3.96656, 3, 0.262199),
(6, 1, 1, 6, 765, 'sdfsdf', 97.7255, 856, 8.75923, 3, 0.262199),
(7, 1, 1, 7, 128, 'alhamdulillah', 584.062, 45, 0.0770466, 3, 0.262199),
(8, 1, 1, 23, 343, 'sdggfdfg', 217.959, NULL, NULL, 3, 0.013764),
(9, 1, 1, 24, 6534, 'ssdfsdf', 11.4417, NULL, NULL, 6, 0.524398);

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
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `tanggal_lahir`, `username`, `password`, `level`) VALUES
(1, 'Naufal Rifqi', '2005-06-22', 'mahasiswa', '$2y$10$/hKRl6gG/POth0wXywd5SeQAOCM2LyQUo1ZNm5iVfwaWEGzzN7l02', 'user'),
(4, 'Rifqi Naufal', '2024-03-26', 'mahasiswa1', '$2y$10$/hKRl6gG/POth0wXywd5SeQAOCM2LyQUo1ZNm5iVfwaWEGzzN7l02', 'user'),
(6, 'Rifqi Mubarok', '2024-03-01', 'mahasiswa2', '$2y$10$/hKRl6gG/POth0wXywd5SeQAOCM2LyQUo1ZNm5iVfwaWEGzzN7l02', '');

-- --------------------------------------------------------

--
-- Table structure for table `unit_kerja`
--

CREATE TABLE `unit_kerja` (
  `id_unit_kerja` int(11) NOT NULL,
  `nama_unit_kerja` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_kerja`
--

INSERT INTO `unit_kerja` (`id_unit_kerja`, `nama_unit_kerja`) VALUES
(1, 'Unit Kerja Rekam Medis Bagian Pendaftaran'),
(2, 'Unit Kerja Rekam Medis Bagian Penyimpanan (Filling)'),
(3, 'Unit Kerja Rekam Medis Bagian Koding'),
(4, 'Unit Kerja Rekam Medis Bagian Pelaporan');

-- --------------------------------------------------------

--
-- Table structure for table `uraian_kegiatan`
--

CREATE TABLE `uraian_kegiatan` (
  `id_uraian_kegiatan` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `jenis_tugas` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uraian_kegiatan`
--

INSERT INTO `uraian_kegiatan` (`id_uraian_kegiatan`, `id_unit_kerja`, `jenis_tugas`, `deskripsi`) VALUES
(1, 1, 'pokok', 'Menyiapkan Peralatan Kerja'),
(2, 1, 'pokok', 'Mendaftarkan Pasien Baru'),
(3, 1, 'pokok', 'Mendaftarkan Pasien Lama'),
(4, 1, 'pokok', 'Memberikan Informasi Layanan Yang Akan Diterima Pasien'),
(5, 1, 'pokok', 'Merakit Lembar Rekam Medis Baru'),
(6, 1, 'pokok', 'Mengentry Sensus Harian Ke Komputer'),
(7, 1, 'pokok', 'Merapihkan Peralatan Kerja'),
(8, 2, 'pokok', 'Menerima Dan Mengecek Berkas Rekam Medis'),
(9, 2, 'pokok', 'Mengecek Lembar Rekam Medis Dan Menata Di Rak Penyimpanan'),
(10, 2, 'pokok', 'Mencatat Dokumen Rekam Medis Yang Keluar Atau Sedang Dipinjam'),
(11, 2, 'pokok', 'Mendistribusikan Berkas Rekam Medis Ke Poliklinik'),
(12, 2, 'pokok', 'Memilah Berkas Rekam Medis Inaktif'),
(13, 3, 'pokok', 'Mencatat Dan Meneliti Kode Penyakit Dari Diagnosa Yang Ditulis Dokter, Kode Operasi Dari Tindakan Medis Yang Ditulis Dokter Atau Petugas Kesehatan Lainnya'),
(14, 3, 'pokok', 'Mencatat Dan Meneliti Kode Sebab Kematian Yang Ditulis Oleh Dokter '),
(15, 3, 'pokok', 'Mencatat Hasil Pelayanan Kedalam Formulir Indeks Penyakit Sesuai Dengan Ketentuan Mencatat Indeks'),
(16, 3, 'pokok', 'Menyimpan Indeks Tersebut Sesuai Dengan Ketentuan Menyimpan Indeks'),
(17, 3, 'pokok', 'Membuat Laporan Penyakit (Morbiditas) Dan Laporan Kematian (Mortalitas) Berdasarkan Indeks Penyakit,Indeks Operasi Dan Indeks Kematian'),
(18, 4, 'pokok', 'Membuat Laporan Harian Kunjungan Pasien Rawat Inap'),
(19, 4, 'pokok', 'Melaporkan Data Rutin 10 Besar Penyakit'),
(20, 4, 'pokok', 'Membuat Laporan Sensus Harian Rawat Inap Dari Tiap Ruangan'),
(21, 4, 'pokok', 'Membuat Laporan Internal Dan Eksternal'),
(22, 4, 'pokok', 'Membuat Laporan Indicator Pelayanan Fasyankes'),
(23, 0, 'penunjang', 'Mengikuti pertemuan bulanan di Dinkes dalam program Jaminan Kesehatan Nasional'),
(24, 0, 'penunjang', 'Mengikuti pertemuan triwulanan penyusunan profil kesehatan');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_kerja_tersedia`
--

CREATE TABLE `waktu_kerja_tersedia` (
  `id_wkt` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
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
  `total_kebutuhan_tenaga` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waktu_kerja_tersedia`
--

INSERT INTO `waktu_kerja_tersedia` (`id_wkt`, `id_user`, `id_unit_kerja`, `jam_kerja`, `waktu_luang`, `pola_hari_kerja`, `hari_tahun`, `jumlah_hari_minggu`, `libur_resmi`, `libur_cuti`, `jam_kerja_efektif_perminggu`, `jam_kerja_efektif_perhari`, `hari_kerja_efektif`, `waktu_kerja_efektif_jam`, `waktu_kerja_efektif_menit`, `total_faktor_tugas_penunjang`, `standar_tugas_penunjang`, `jumlah_kebutuhan_tenaga_tugas_pokok`, `total_kebutuhan_tenaga`) VALUES
(1, 1, 1, 40, 0.3, 6, 365, 52, 34, 12, 28, 4.66667, 267, 1246, 74760, 0.538162, 2.16526, 13.9094, 30.1174),
(2, 4, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `norma_waktu_komponen`
--
ALTER TABLE `norma_waktu_komponen`
  MODIFY `id_nwk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  MODIFY `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uraian_kegiatan`
--
ALTER TABLE `uraian_kegiatan`
  MODIFY `id_uraian_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `waktu_kerja_tersedia`
--
ALTER TABLE `waktu_kerja_tersedia`
  MODIFY `id_wkt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
