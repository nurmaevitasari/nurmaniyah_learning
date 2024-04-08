-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2024 at 04:17 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modul_materi`
--

CREATE TABLE `tbl_modul_materi` (
  `id` int(11) NOT NULL,
  `kelas` int(11) NOT NULL,
  `kode_modul` varchar(500) NOT NULL,
  `user_created` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` varchar(500) NOT NULL,
  `views` int(11) NOT NULL,
  `nama_materi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_modul_materi`
--

INSERT INTO `tbl_modul_materi` (`id`, `kelas`, `kode_modul`, `user_created`, `date_created`, `status`, `views`, `nama_materi`) VALUES
(1, 10, 'MT-10-1', '1', '2024-03-15 22:00:11', 'Non Active', 0, 'test materi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modul_materi_detail`
--

CREATE TABLE `tbl_modul_materi_detail` (
  `id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `materi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_modul_materi_detail`
--

INSERT INTO `tbl_modul_materi_detail` (`id`, `materi_id`, `materi`) VALUES
(1, 1, 'THIS IS MATERI&nbsp;<br />\r\n1. test<br />\r\n2. bbbb<br />\r\n3. cccc<br />\r\n4.dddd<br />\r\n<img alt=\"\" height=\"23\" src=\"https://localhost/Waskito_learning/plugins/ckeditor/plugins/smiley/images/s22.png\" title=\"\" width=\"23\" />');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modul_materi_upload`
--

CREATE TABLE `tbl_modul_materi_upload` (
  `id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_modul_materi_upload`
--

INSERT INTO `tbl_modul_materi_upload` (`id`, `materi_id`, `file_name`, `date_created`, `user_created`, `status`) VALUES
(1, 1, 'Screenshot 2023-06-08 220710.png', '2024-03-15 21:57:13', 1, 'Active'),
(2, 1, 'Screenshot 2023-06-08 220921.png', '2024-03-15 21:57:13', 1, 'Active');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `id_user`, `notification`, `status`, `url`, `date_created`) VALUES
(1, 1, 'test notification', 0, 'home', '2024-01-28 10:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification_admin`
--

CREATE TABLE `tbl_notification_admin` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `notification` text NOT NULL,
  `status` int(11) NOT NULL,
  `url` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification_guru`
--

CREATE TABLE `tbl_notification_guru` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `notification` text NOT NULL,
  `status` int(11) NOT NULL,
  `url` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama_lengkap`, `role_id`, `username`, `password`, `date_created`, `user_created`, `status`, `id_user`, `master_password`, `session_id`) VALUES
(1, 'Ivana', '1', 'Ivana', '7f7925ab47cabb9dcd6e4954baf2a5b67ef4f2d3', '0000-00-00 00:00:00', 1, 'Active', 1, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', ''),
(3, 'Nurma Evitasari', '1', 'Nurma', '1d9f01c32b0a4ef664480099cf47eef4d37cd270', '2024-01-28 15:01:50', 1, 'Active', 7, '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '');

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
-- Indexes for table `tbl_modul_materi`
--
ALTER TABLE `tbl_modul_materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_modul_materi_detail`
--
ALTER TABLE `tbl_modul_materi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_modul_materi_upload`
--
ALTER TABLE `tbl_modul_materi_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification_admin`
--
ALTER TABLE `tbl_notification_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification_guru`
--
ALTER TABLE `tbl_notification_guru`
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
-- AUTO_INCREMENT for table `tbl_modul_materi`
--
ALTER TABLE `tbl_modul_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_modul_materi_detail`
--
ALTER TABLE `tbl_modul_materi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_modul_materi_upload`
--
ALTER TABLE `tbl_modul_materi_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_notification_admin`
--
ALTER TABLE `tbl_notification_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification_guru`
--
ALTER TABLE `tbl_notification_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
