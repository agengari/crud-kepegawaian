-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2023 at 04:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_crud_kepegawaian`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `gaji` bigint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `deskripsi`, `gaji`) VALUES
(1, 'Direktur', 'Membuat visi misi bersama untuk perusahaan', 12000000),
(2, 'Manager', 'Menerjemahkan visi misi kedalam rencana aksi', 8000000),
(3, 'Kepala Operasional', 'Mengawasi jalannya operasional', 5500000),
(4, 'Pelaksana', 'Melaksanakan tugas sesuai arahan kepala', 3500000);

-- --------------------------------------------------------

--
-- Table structure for table `kontrak`
--

CREATE TABLE `kontrak` (
  `id_kontrak` int(11) NOT NULL,
  `nama_kontrak` varchar(50) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontrak`
--

INSERT INTO `kontrak` (`id_kontrak`, `nama_kontrak`, `tgl_mulai`, `durasi`) VALUES
(1, 'Kontrak 3 bulan', '2023-04-01', 90),
(2, 'Kontrak 40 hari', '2023-05-01', 40),
(3, 'Kontrak 50 hari', '2023-05-02', 49),
(5, 'WebDev Evaluasi - Ageng', '2023-05-05', 90);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telpon` varchar(14) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_kontrak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `alamat`, `no_telpon`, `id_jabatan`, `id_kontrak`) VALUES
(1, 'Pegawai 1', 'Kalasan, Sleman, Yogyakarta', '081228842381', 1, 1),
(2, 'Pegawai 2', 'Ngemplak, Sleman, Yogyakarta', '081384754332', 2, 1),
(3, 'Pegawai baru 3', 'Ngaglik, Sleman, Yogyakarta', '08995112733', 3, 1),
(6, 'Pegawai baru 4', 'Mlati, Sleman, Jateng', '08995842734', 2, 2),
(7, 'Pegawai baru 5', 'Bramen, Klaten, Jawa Tengah', '08976117323', 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `kontrak`
--
ALTER TABLE `kontrak`
  ADD PRIMARY KEY (`id_kontrak`),
  ADD UNIQUE KEY `nama_kontrak` (`nama_kontrak`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `fk_jabatan` (`id_jabatan`),
  ADD KEY `fk_kontrak` (`id_kontrak`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kontrak`
--
ALTER TABLE `kontrak`
  MODIFY `id_kontrak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`),
  ADD CONSTRAINT `fk_kontrak` FOREIGN KEY (`id_kontrak`) REFERENCES `kontrak` (`id_kontrak`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
