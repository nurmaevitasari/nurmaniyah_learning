-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2024 at 04:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waskito_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_guru`
--

CREATE TABLE `tbl_data_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `nama_lengkap` text NOT NULL,
  `status_pegawai` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `foto_profile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_data_guru`
--

INSERT INTO `tbl_data_guru` (`id`, `nip`, `nama_lengkap`, `status_pegawai`, `date_created`, `user_created`, `jenis_kelamin`, `foto_profile`) VALUES
(1, '1910101010', 'Ivana', 'Admin', '0000-00-00 00:00:00', 1, 'Wanita', 'logo_nurmaniyah.png'),
(7, 'ITP-112', 'Nurma Evitasari', 'Guru', '2024-01-28 18:22:35', 1, 'Wanita', 'f315f00c-8d65-4bca-90b8-fcb9af5fb0a3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_data_guru`
--
ALTER TABLE `tbl_data_guru`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_data_guru`
--
ALTER TABLE `tbl_data_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
