-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Sep 2019 pada 06.54
-- Versi server: 10.1.34-MariaDB
-- Versi PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myiios_nurma`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee`
--

CREATE TABLE `tbl_project_dee` (
  `id` int(11) NOT NULL,
  `salesman` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `dp_date` datetime NOT NULL,
  `deadline_date` datetime NOT NULL,
  `days_deadline` int(5) NOT NULL,
  `project_type` int(2) NOT NULL,
  `last_progress` int(3) NOT NULL,
  `days_progress_id` int(11) NOT NULL,
  `site_cp` varchar(200) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `email_cp` varchar(100) NOT NULL,
  `project_addr` text NOT NULL,
  `execution` int(11) NOT NULL,
  `exec_note` text NOT NULL,
  `description` text NOT NULL,
  `published` int(2) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_closed` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reminder_penagihan` date NOT NULL,
  `status_recomendation_point` text NOT NULL,
  `status_point` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee`
--

INSERT INTO `tbl_project_dee` (`id`, `salesman`, `customer_id`, `dp_date`, `deadline_date`, `days_deadline`, `project_type`, `last_progress`, `days_progress_id`, `site_cp`, `no_hp`, `email_cp`, `project_addr`, `execution`, `exec_note`, `description`, `published`, `date_created`, `date_closed`, `date_modified`, `reminder_penagihan`, `status_recomendation_point`, `status_point`) VALUES
(1, 24, 12184, '2019-08-09 00:00:00', '2019-08-16 00:00:00', 8, 0, 0, 0, '11530', '087886554052', 'nfnfnfn', 'sasasas', 0, '', 'sasasasas', 0, '2019-08-09 15:50:20', '0000-00-00 00:00:00', '2019-08-09 08:50:20', '0000-00-00', '', ''),
(2, 24, 12184, '2019-08-09 00:00:00', '2019-08-16 00:00:00', 8, 0, 0, 0, '11530', '087886554052', 'nfnfnfn', 'sasasas', 0, '', 'sasasasas', 0, '2019-08-09 15:51:43', '0000-00-00 00:00:00', '2019-08-09 08:51:43', '0000-00-00', '', ''),
(3, 24, 12184, '2019-08-09 00:00:00', '2019-08-20 00:00:00', 12, 0, 8, 0, '11530', '087886554052', 'nfnfnfn', 'sasasas', 1, 'bvgbgbg', 'sasasasas', 0, '2019-08-09 15:52:01', '0000-00-00 00:00:00', '2019-08-12 06:42:29', '2019-08-19', 'YES', 'YES');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_autohighlight`
--

CREATE TABLE `tbl_project_dee_autohighlight` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `highlight` text NOT NULL,
  `status` text NOT NULL,
  `user` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `days_deadline` int(11) NOT NULL,
  `calculate` varchar(5) NOT NULL,
  `progress_auto` int(5) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_autohighlight`
--

INSERT INTO `tbl_project_dee_autohighlight` (`id`, `title`, `highlight`, `status`, `user`, `receiver`, `days_deadline`, `calculate`, `progress_auto`, `date_created`, `date_modified`) VALUES
(1, 'test', 'test 123456', 'Show', 24, 1, 2, '+', 2, '2019-08-12 11:31:13', '2019-08-12 04:31:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_contributor`
--

CREATE TABLE `tbl_project_dee_contributor` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `log_project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contributor` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_contributor`
--

INSERT INTO `tbl_project_dee_contributor` (`id`, `project_id`, `log_project_id`, `user_id`, `contributor`, `date_created`, `date_modified`) VALUES
(1, 3, 0, 24, 24, '2019-08-09 15:52:01', '2019-08-09 08:52:03'),
(2, 3, 0, 24, 140, '2019-08-09 15:52:01', '2019-08-09 08:52:03'),
(4, 3, 0, 24, 164, '2019-08-09 15:52:03', '2019-08-09 08:52:03'),
(5, 3, 0, 24, 203, '2019-08-12 09:34:43', '2019-08-12 02:34:43'),
(6, 3, 0, 24, 9, '2019-08-12 10:37:55', '2019-08-12 03:37:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_days_progress`
--

CREATE TABLE `tbl_project_dee_days_progress` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `progress_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `dates` datetime NOT NULL,
  `deadline_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_days_progress`
--

INSERT INTO `tbl_project_dee_days_progress` (`id`, `project_id`, `progress_id`, `user`, `days`, `dates`, `deadline_id`, `date_created`, `date_modified`) VALUES
(1, 1, 2, 24, 1, '2019-08-09 00:00:00', 1, '2019-08-09 15:50:20', '2019-08-09 08:50:20'),
(2, 1, 3, 24, 1, '2019-08-10 00:00:00', 1, '2019-08-09 15:50:20', '2019-08-09 08:50:20'),
(3, 1, 4, 24, 2, '2019-08-12 00:00:00', 1, '2019-08-09 15:50:21', '2019-08-09 08:50:21'),
(4, 1, 5, 24, 1, '2019-08-13 00:00:00', 1, '2019-08-09 15:50:21', '2019-08-09 08:50:21'),
(5, 1, 6, 24, 1, '2019-08-14 00:00:00', 1, '2019-08-09 15:50:21', '2019-08-09 08:50:21'),
(6, 1, 7, 24, 2, '2019-08-16 00:00:00', 1, '2019-08-09 15:50:21', '2019-08-09 08:50:21'),
(7, 2, 2, 24, 1, '2019-08-09 00:00:00', 2, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(8, 2, 3, 24, 1, '2019-08-10 00:00:00', 2, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(9, 2, 4, 24, 2, '2019-08-12 00:00:00', 2, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(10, 2, 5, 24, 1, '2019-08-13 00:00:00', 2, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(11, 2, 6, 24, 1, '2019-08-14 00:00:00', 2, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(12, 2, 7, 24, 2, '2019-08-16 00:00:00', 2, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(13, 3, 2, 24, 1, '2019-08-09 00:00:00', 3, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(14, 3, 3, 24, 1, '2019-08-10 00:00:00', 3, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(15, 3, 4, 24, 2, '2019-08-12 00:00:00', 3, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(16, 3, 5, 24, 1, '2019-08-13 00:00:00', 3, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(17, 3, 6, 24, 1, '2019-08-14 00:00:00', 3, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(18, 3, 7, 24, 2, '2019-08-16 00:00:00', 3, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(19, 3, 2, 24, 1, '2019-08-09 00:00:00', 4, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(20, 3, 3, 24, 1, '2019-08-10 00:00:00', 4, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(21, 3, 4, 24, 3, '2019-08-13 00:00:00', 4, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(22, 3, 5, 24, 2, '2019-08-15 00:00:00', 4, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(23, 3, 6, 24, 2, '2019-08-17 00:00:00', 4, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(24, 3, 7, 24, 3, '2019-08-20 00:00:00', 4, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(25, 3, 2, 24, 1, '2019-08-09 00:00:00', 5, '2019-08-12 10:03:21', '2019-08-12 03:03:21'),
(26, 3, 3, 24, 1, '2019-08-10 00:00:00', 5, '2019-08-12 10:03:21', '2019-08-12 03:03:21'),
(27, 3, 4, 24, 3, '2019-08-13 00:00:00', 5, '2019-08-12 10:03:21', '2019-08-12 03:03:21'),
(28, 3, 5, 24, 2, '2019-08-15 00:00:00', 5, '2019-08-12 10:03:21', '2019-08-12 03:03:21'),
(29, 3, 6, 24, 2, '2019-08-17 00:00:00', 5, '2019-08-12 10:03:21', '2019-08-12 03:03:21'),
(30, 3, 7, 24, 3, '2019-08-20 00:00:00', 5, '2019-08-12 10:03:21', '2019-08-12 03:03:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_deadline`
--

CREATE TABLE `tbl_project_dee_deadline` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `days_deadline` int(5) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_deadline`
--

INSERT INTO `tbl_project_dee_deadline` (`id`, `project_id`, `user`, `deadline`, `days_deadline`, `date_created`, `date_modified`) VALUES
(1, 1, 24, '2019-08-16 00:00:00', 8, '2019-08-09 15:50:20', '2019-08-09 08:50:20'),
(2, 2, 24, '2019-08-16 00:00:00', 8, '2019-08-09 15:51:44', '2019-08-09 08:51:44'),
(3, 3, 24, '2019-08-16 00:00:00', 8, '2019-08-09 15:52:01', '2019-08-09 08:52:01'),
(4, 3, 24, '2019-08-20 00:00:00', 12, '2019-08-12 10:02:00', '2019-08-12 03:02:00'),
(5, 3, 24, '2019-08-20 00:00:00', 12, '2019-08-12 10:03:21', '2019-08-12 03:03:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_executor`
--

CREATE TABLE `tbl_project_dee_executor` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `recomend_id` int(11) NOT NULL,
  `executor` int(11) NOT NULL,
  `point` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_executor`
--

INSERT INTO `tbl_project_dee_executor` (`id`, `project_id`, `recomend_id`, `executor`, `point`, `date_created`, `date_modified`) VALUES
(1, 3, 383, 211, '5', '2019-08-12 11:52:08', '2019-08-12 04:52:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_highlight`
--

CREATE TABLE `tbl_project_dee_highlight` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `highlight` text NOT NULL,
  `status` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `notes_user` int(11) NOT NULL,
  `date_finish` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deadline` date NOT NULL,
  `receiver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_highlight`
--

INSERT INTO `tbl_project_dee_highlight` (`id`, `project_id`, `highlight`, `status`, `user`, `notes`, `notes_user`, `date_finish`, `date_created`, `date_modified`, `deadline`, `receiver`) VALUES
(1, 3, 'test', 1, '24', 'yjyjyj', 24, '2019-08-12 14:18:45', '2019-08-12 11:27:52', '2019-08-12 07:18:45', '2019-08-16', 211);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_log`
--

CREATE TABLE `tbl_project_dee_log` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `type_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_log`
--

INSERT INTO `tbl_project_dee_log` (`id`, `project_id`, `user`, `type`, `type_id`, `date_created`, `date_modified`) VALUES
(1, 1, 24, 'New', 1, '2019-08-09 15:50:20', '2019-08-09 08:50:20'),
(2, 2, 24, 'New', 2, '2019-08-09 15:51:43', '2019-08-09 08:51:43'),
(3, 3, 24, 'New', 3, '2019-08-09 15:52:01', '2019-08-09 08:52:01'),
(4, 3, 24, 'Progress', 1, '2019-08-09 15:52:02', '2019-08-09 08:52:02'),
(5, 3, 24, 'Contributor', 4, '2019-08-09 15:52:03', '2019-08-09 08:52:03'),
(6, 3, 24, 'Link', 6350, '2019-08-09 15:52:04', '2019-08-09 08:52:04'),
(7, 3, 24, 'Pesan', 0, '2019-08-12 09:10:08', '2019-08-12 02:10:08'),
(8, 3, 24, 'Upload', 3, '2019-08-12 09:32:30', '2019-08-12 02:32:30'),
(9, 3, 24, 'Contributor', 5, '2019-08-12 09:34:43', '2019-08-12 02:34:43'),
(10, 3, 24, 'Execution', 3, '2019-08-12 09:44:18', '2019-08-12 02:44:18'),
(11, 3, 24, 'Deadline', 0, '2019-08-12 10:03:22', '2019-08-12 03:03:22'),
(12, 3, 24, 'Reminder', 1, '2019-08-12 10:32:45', '2019-08-12 03:32:45'),
(13, 3, 24, 'Reminder', 2, '2019-08-12 10:35:16', '2019-08-12 03:35:16'),
(14, 3, 24, 'Tagih', 3, '2019-08-12 10:37:54', '2019-08-12 03:37:54'),
(15, 3, 24, 'Contributor', 6, '2019-08-12 10:37:55', '2019-08-12 03:37:55'),
(16, 3, 24, 'pesan', 3, '2019-08-12 10:44:45', '2019-08-12 03:44:45'),
(17, 3, 24, 'Link', 6355, '2019-08-12 11:17:58', '2019-08-12 04:17:58'),
(18, 3, 24, 'Progress', 2, '2019-08-12 11:51:45', '2019-08-12 04:51:45'),
(19, 3, 140, 'Point', 383, '2019-08-12 11:52:09', '2019-08-12 04:52:09'),
(20, 3, 24, 'Point', 3631, '2019-08-12 13:42:29', '2019-08-12 06:42:29'),
(21, 3, 24, 'Point', 3632, '2019-08-12 13:43:51', '2019-08-12 06:43:51'),
(22, 3, 24, 'Request', 1, '2019-08-12 14:19:39', '2019-08-12 07:19:39'),
(23, 3, 24, 'Pesan', 1, '2019-08-12 14:22:27', '2019-08-12 07:22:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_log_progress`
--

CREATE TABLE `tbl_project_dee_log_progress` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `progress_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `deadline_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `note` text NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_log_progress`
--

INSERT INTO `tbl_project_dee_log_progress` (`id`, `project_id`, `progress_id`, `user`, `deadline_id`, `date_created`, `note`, `date_modified`) VALUES
(1, 3, 1, 24, 0, '2019-08-09 15:52:02', '', '2019-08-09 08:52:02'),
(2, 3, 8, 24, 0, '2019-08-12 11:51:45', 'asdf', '2019-08-12 04:51:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_pesan`
--

CREATE TABLE `tbl_project_dee_pesan` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `req_spk_id` int(11) NOT NULL,
  `status_request` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_pesan`
--

INSERT INTO `tbl_project_dee_pesan` (`id`, `project_id`, `log_id`, `sender`, `pesan`, `date_created`, `date_modified`, `req_spk_id`, `status_request`) VALUES
(1, 1, 1, 24, 'Membuat data project baru', '2019-08-09 15:50:20', '2019-08-09 08:50:20', 0, 0),
(2, 2, 2, 24, 'Membuat data project baru', '2019-08-09 15:51:43', '2019-08-09 08:51:43', 0, 0),
(3, 3, 3, 24, 'Membuat data project baru', '2019-08-09 15:52:01', '2019-08-09 08:52:01', 0, 0),
(4, 3, 4, 24, 'Progress : #01 : DP / 0% <br>', '2019-08-09 15:52:02', '2019-08-09 08:52:02', 0, 0),
(5, 3, 5, 24, 'Alex Lee Add Petrus Bimo as Contributor', '2019-08-09 15:52:03', '2019-08-09 08:52:03', 0, 0),
(6, 3, 6, 24, 'Membuat Project dari deal <a target=\"_blank\" href=\"https://localhost/MYIIOS_DEVEL/index.php/crm/details/10570\"> CRM ID 10570</a>', '2019-08-09 15:52:04', '2019-08-09 08:52:04', 0, 0),
(7, 3, 7, 24, 'sdfg', '2019-08-12 09:10:09', '2019-08-12 02:10:09', 0, 0),
(8, 3, 8, 24, '2394d919c63162344c84c0ebfc9b4a9b-rp-jpg.jpg', '2019-08-12 09:32:30', '2019-08-12 02:32:30', 0, 0),
(9, 3, 9, 24, 'Alex Lee Add Aditiya as Contributor', '2019-08-12 09:34:43', '2019-08-12 02:34:43', 0, 0),
(10, 3, 10, 24, 'Mengupdate execution Worked-On <br> Note : bvgbgbg', '2019-08-12 09:44:18', '2019-08-12 02:44:18', 0, 0),
(11, 3, 11, 24, 'Mengubah Deadline BAST dari 16/08/2019 menjadi 20/08/2019 <br> Alasan mengubah : asdfghjkllzxcvbnm', '2019-08-12 10:03:22', '2019-08-12 03:03:22', 0, 0),
(12, 3, 12, 24, 'Menambahkan reminder untuk tanggal 13/08/2019<br> Ket : ddvdvdv', '2019-08-12 10:32:45', '2019-08-12 03:32:45', 0, 0),
(13, 3, 13, 24, 'Menambahkan reminder untuk tanggal 14/08/2019<br> Ket : test', '2019-08-12 10:35:16', '2019-08-12 03:35:16', 0, 0),
(14, 3, 14, 24, 'Miminta Tim FA Neneng untuk segera melakukan penagihan', '2019-08-12 10:37:54', '2019-08-12 03:37:54', 0, 0),
(15, 3, 15, 24, 'Alex Lee Add Neneng as Contributor', '2019-08-12 10:37:55', '2019-08-12 03:37:55', 0, 0),
(16, 3, 16, 24, 'Membuat PR ID 5057', '2019-08-12 10:44:45', '2019-08-12 03:44:45', 0, 0),
(17, 3, 17, 24, 'Melanjutkan ke stage Delivery barang dengan <a target=\"_blank\" href=\"https://localhost/MYIIOS_DEVEL/index.php/C_delivery/details/6938\"> Delivery ID 6938</a>', '2019-08-12 11:17:58', '2019-08-12 04:17:58', 0, 0),
(18, 3, 18, 24, 'Progress : #02 : Finished (BAST) / 99% <br>Progress Note : asdf', '2019-08-12 11:51:45', '2019-08-12 04:51:45', 0, 0),
(19, 3, 19, 140, 'Rusli Add recomendation Point for Andriawan<br>Notes: test', '2019-08-12 11:52:09', '2019-08-12 04:52:09', 0, 0),
(20, 3, 20, 24, 'Alex Lee Add  Point for Andriawan', '2019-08-12 13:42:29', '2019-08-12 06:42:29', 0, 0),
(21, 3, 21, 24, 'Alex Lee Add  Point for Andriawan', '2019-08-12 13:43:51', '2019-08-12 06:43:51', 0, 0),
(22, 3, 22, 24, '<p style=\'color:#E2410F;\'>Request SPK: meminta segera dibuatkan SPK project DEE sesuai dengan lampiran <br>\r\n                note :  gngngngn<br></p>', '2019-08-12 14:19:39', '2019-08-12 07:22:27', 1, 2),
(23, 3, 23, 24, '<p style=\"color:#08A810;\">Need Revision <br>Note : sdsdsdsd</p><br>', '2019-08-12 14:22:27', '2019-08-12 07:22:27', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_progress`
--

CREATE TABLE `tbl_project_dee_progress` (
  `id` int(11) NOT NULL,
  `progress_name` varchar(100) NOT NULL,
  `persen` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_progress`
--

INSERT INTO `tbl_project_dee_progress` (`id`, `progress_name`, `persen`, `date_created`, `date_modified`, `published`) VALUES
(1, 'DP', 0, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(2, 'Survey', 1, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(3, 'KickOff', 5, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(4, 'Material', 8, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(5, 'Production', 70, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(6, 'Delivery', 75, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(7, 'Installation', 95, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(8, 'Finished (BAST)', 99, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(9, 'Paid', 100, '0000-00-00 00:00:00', '2017-12-05 05:52:44', 0),
(10, 'New Project DHC', 0, '0000-00-00 00:00:00', '2018-10-30 03:50:12', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_reminder`
--

CREATE TABLE `tbl_project_dee_reminder` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `date_reminder` datetime NOT NULL,
  `note` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_reminder`
--

INSERT INTO `tbl_project_dee_reminder` (`id`, `project_id`, `user`, `date_reminder`, `note`, `date_created`, `date_modified`) VALUES
(1, 3, 24, '2019-08-13 00:00:00', '', '2019-08-12 00:00:00', '2019-08-12 03:32:45'),
(2, 3, 24, '2019-08-14 00:00:00', '', '2019-08-12 00:00:00', '2019-08-12 03:35:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_req_spk`
--

CREATE TABLE `tbl_project_dee_req_spk` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `request` text NOT NULL,
  `user` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `divisi` text NOT NULL,
  `result_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_req_spk`
--

INSERT INTO `tbl_project_dee_req_spk` (`id`, `project_id`, `request`, `user`, `to`, `divisi`, `result_id`, `date_created`, `date_modified`) VALUES
(1, 3, 'gngngngn', 24, 24, '', 1, '2019-08-12 14:19:38', '2019-08-12 07:22:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_project_dee_result_request`
--

CREATE TABLE `tbl_project_dee_result_request` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `note` text NOT NULL,
  `user` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_project_dee_result_request`
--

INSERT INTO `tbl_project_dee_result_request` (`id`, `project_id`, `request_id`, `result`, `note`, `user`, `date_created`, `date_modified`) VALUES
(1, 3, 1, 2, 'sdsdsdsd', 24, '2019-08-12 14:22:27', '2019-08-12 07:22:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_upload_project_dee`
--

CREATE TABLE `tbl_upload_project_dee` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `uploader` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `type` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `highlight_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_upload_project_dee`
--

INSERT INTO `tbl_upload_project_dee` (`id`, `project_id`, `uploader`, `file_name`, `type`, `date_created`, `date_modified`, `highlight_id`) VALUES
(1, 3, 24, 'https://shopee.co.id/flash_sale?promotionId=2000022704', 2, '2019-08-09 15:52:02', '2019-08-09 08:57:33', 0),
(2, 3, 24, 'Standar QC ELECTRIC MOTOR FUJITOR VER.1F.pdf', 1, '2019-08-09 15:52:04', '2019-08-09 08:52:04', 0),
(3, 3, 24, '2394d919c63162344c84c0ebfc9b4a9b-rp-jpg.jpg', 0, '2019-08-12 09:32:29', '2019-08-12 02:32:29', 0),
(4, 3, 24, '0747e09a8b544b85961272cb6dcd9d53-elektrikal-jpg.jpg', 7, '2019-08-12 14:19:27', '2019-08-12 07:19:27', 1),
(5, 3, 24, 'ad6cce002913a10a1b8409bacd31be2c-auto-wishlist-jpg.jpg', 0, '2019-08-12 14:20:36', '2019-08-12 07:20:36', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_project_dee`
--
ALTER TABLE `tbl_project_dee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salesman` (`salesman`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `last_progress` (`last_progress`),
  ADD KEY `days_progress_id` (`days_progress_id`),
  ADD KEY `published` (`published`);

--
-- Indeks untuk tabel `tbl_project_dee_autohighlight`
--
ALTER TABLE `tbl_project_dee_autohighlight`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_dee_contributor`
--
ALTER TABLE `tbl_project_dee_contributor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contributor` (`contributor`);

--
-- Indeks untuk tabel `tbl_project_dee_days_progress`
--
ALTER TABLE `tbl_project_dee_days_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `progress_id` (`progress_id`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `tbl_project_dee_deadline`
--
ALTER TABLE `tbl_project_dee_deadline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `tbl_project_dee_executor`
--
ALTER TABLE `tbl_project_dee_executor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_dee_highlight`
--
ALTER TABLE `tbl_project_dee_highlight`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_dee_log`
--
ALTER TABLE `tbl_project_dee_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `tbl_project_dee_log_progress`
--
ALTER TABLE `tbl_project_dee_log_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `progress_id` (`progress_id`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `tbl_project_dee_pesan`
--
ALTER TABLE `tbl_project_dee_pesan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `log_id` (`log_id`),
  ADD KEY `sender` (`sender`);

--
-- Indeks untuk tabel `tbl_project_dee_progress`
--
ALTER TABLE `tbl_project_dee_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_dee_reminder`
--
ALTER TABLE `tbl_project_dee_reminder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `tbl_project_dee_req_spk`
--
ALTER TABLE `tbl_project_dee_req_spk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_project_dee_result_request`
--
ALTER TABLE `tbl_project_dee_result_request`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_upload_project_dee`
--
ALTER TABLE `tbl_upload_project_dee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `uploader` (`uploader`),
  ADD KEY `type` (`type`),
  ADD KEY `highlight_id` (`highlight_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee`
--
ALTER TABLE `tbl_project_dee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_autohighlight`
--
ALTER TABLE `tbl_project_dee_autohighlight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_contributor`
--
ALTER TABLE `tbl_project_dee_contributor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_days_progress`
--
ALTER TABLE `tbl_project_dee_days_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_deadline`
--
ALTER TABLE `tbl_project_dee_deadline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_executor`
--
ALTER TABLE `tbl_project_dee_executor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_highlight`
--
ALTER TABLE `tbl_project_dee_highlight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_log`
--
ALTER TABLE `tbl_project_dee_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_log_progress`
--
ALTER TABLE `tbl_project_dee_log_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_pesan`
--
ALTER TABLE `tbl_project_dee_pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_progress`
--
ALTER TABLE `tbl_project_dee_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_reminder`
--
ALTER TABLE `tbl_project_dee_reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_req_spk`
--
ALTER TABLE `tbl_project_dee_req_spk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_project_dee_result_request`
--
ALTER TABLE `tbl_project_dee_result_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_upload_project_dee`
--
ALTER TABLE `tbl_upload_project_dee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
