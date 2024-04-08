-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2024 at 11:34 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_data_guru`
--

INSERT INTO `tbl_data_guru` (`id`, `nip`, `nama_lengkap`, `status_pegawai`, `date_created`, `user_created`, `jenis_kelamin`, `foto_profile`) VALUES
(1, '1111', 'Admin', 'Admin', '0000-00-00 00:00:00', 1, 'Wanita', ''),
(2, '123', 'Ivana Yunitae', 'Guru', '0000-00-00 00:00:00', 1, 'Wanita', ''),
(7, 'ITP-112', 'Nurma Evitasari', 'Guru', '2024-01-28 18:22:35', 1, 'Wanita', 'f315f00c-8d65-4bca-90b8-fcb9af5fb0a3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_siswa`
--

CREATE TABLE `tbl_data_siswa` (
  `id` int(11) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `nama_lengkap` text NOT NULL,
  `grade` int(11) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `foto_profile` text NOT NULL,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_data_siswa`
--

INSERT INTO `tbl_data_siswa` (`id`, `nip`, `nama_lengkap`, `grade`, `kelas`, `jenis_kelamin`, `foto_profile`, `date_created`, `user_created`) VALUES
(2, '1234', 'Jili Anabul', 10, '10-1', 'Pria', 'jili.jpg', '2024-01-28 19:47:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materi`
--

CREATE TABLE `tbl_materi` (
  `id` int(11) NOT NULL,
  `kelas` int(11) NOT NULL,
  `nama_modul` text NOT NULL,
  `date_created` datetime NOT NULL,
  `status` text NOT NULL,
  `user_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `notification` text NOT NULL,
  `status` int(11) NOT NULL,
  `url` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `id_user`, `notification`, `status`, `url`, `date_created`) VALUES
(1, 1, 'test notification', 0, 'home', '2024-01-28 10:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `role`, `date_created`, `user_created`) VALUES
(1, 'Admin', '2024-01-28 00:00:00', 1),
(2, 'Guru', '2024-01-28 00:00:00', 1),
(3, 'Siswa', '2024-01-28 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `nama_lengkap` text NOT NULL,
  `role_id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `master_password` text NOT NULL,
  `session_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama_lengkap`, `role_id`, `username`, `password`, `date_created`, `user_created`, `status`, `id_user`, `master_password`, `session_id`) VALUES
(1, 'Admin', '1', 'Admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '0000-00-00 00:00:00', 0, 'Active', 1, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', ''),
(2, 'Ivana Yunitae', '2', 'Ivana', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '0000-00-00 00:00:00', 0, 'Active', 2, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', ''),
(3, 'Nurma Evitasari', '2', 'Nurma', '1d9f01c32b0a4ef664480099cf47eef4d37cd270', '2024-01-28 15:01:50', 1, 'Active', 7, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', ''),
(4, 'Jili Anabul', '3', 'Jili', 'c857f2b4b2810455ee83d1e801d1b74e827654af', '2024-01-28 19:47:56', 1, 'Active', 2, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_data_guru`
--
ALTER TABLE `tbl_data_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_data_siswa`
--
ALTER TABLE `tbl_data_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_materi`
--
ALTER TABLE `tbl_materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_data_guru`
--
ALTER TABLE `tbl_data_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_data_siswa`
--
ALTER TABLE `tbl_data_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_materi`
--
ALTER TABLE `tbl_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
