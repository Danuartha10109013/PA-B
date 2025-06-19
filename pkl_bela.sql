-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2025 at 08:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkl_bela`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verivikasi` int DEFAULT NULL,
  `confirmation` int DEFAULT NULL,
  `verivikasi_oleh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `location`, `photo`, `type`, `verivikasi`, `confirmation`, `verivikasi_oleh`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 18, '-6.2062592, 106.8302336', 'storage/absensi/photo_1734918666.png', 'masuk', NULL, 1, '1', NULL, '2024-12-23 01:51:09', '2024-12-23 01:52:07'),
(2, 13, '-6.22592, 106.8531712', 'storage/absensi/photo_1734918826.png', 'masuk', NULL, 0, '1', '546', '2024-12-23 01:53:46', '2024-12-23 09:03:25'),
(3, 14, '-6.320928, 107.2911439', 'storage/absensi/photo_1734944715.png', 'masuk', NULL, NULL, NULL, NULL, '2024-12-23 09:05:18', '2024-12-23 09:05:18'),
(4, 14, '-6.3209139, 107.291134', NULL, 'pulang', NULL, NULL, NULL, NULL, '2024-12-23 09:05:38', '2024-12-23 09:05:38'),
(5, 14, '-6.3209139, 107.291134', 'storage/absensi/photo_1735011465.png', 'masuk', NULL, NULL, NULL, NULL, '2024-12-24 03:37:48', '2024-12-24 03:37:48'),
(6, 14, '-6.3209139, 107.291134', NULL, 'pulang', NULL, NULL, NULL, NULL, '2024-12-24 03:38:30', '2024-12-24 03:38:30'),
(7, 18, '-6.5663891, 107.8273916', 'storage/absensi/photo_1738557328.png', 'masuk', NULL, 1, '1', 'iya', '2025-02-03 04:35:32', '2025-05-16 07:13:55'),
(8, 11, '-6.5661802, 107.8274167', 'storage/absensi/photo_1748229360.png', 'masuk', NULL, NULL, NULL, NULL, '2025-05-26 03:16:03', '2025-05-26 03:16:03'),
(9, 12, '-6.433808, 107.084427', 'storage/absensi/photo_1748470680.png', 'masuk', NULL, NULL, NULL, NULL, '2025-05-28 22:18:00', '2025-05-28 22:18:00'),
(10, 21, '-6.433808, 107.084427', 'storage/absensi/photo_1748485427.png', 'masuk', NULL, NULL, NULL, NULL, '2025-05-29 02:23:47', '2025-05-29 02:23:47'),
(11, 12, '-6.549289311267482, 107.76679616636467', 'storage/absensi/photo_1749971124.png', 'masuk', NULL, NULL, NULL, NULL, '2025-06-15 07:05:24', '2025-06-15 07:05:24'),
(12, 12, '-6.5494742, 107.7668266', 'storage/absensi/photo_1749973733.png', 'masuk', NULL, NULL, NULL, NULL, '2025-06-15 07:48:53', '2025-06-15 07:48:53'),
(13, 13, '-6.5663112, 107.8275321', 'storage/absensi/photo_1750218462.png', 'masuk', NULL, NULL, NULL, NULL, '2025-06-18 03:47:44', '2025-06-18 03:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_cuti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_cuti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `title`, `jenis_cuti`, `alasan_cuti`, `status`, `keterangan`, `user_id`, `start`, `end`, `bukti`, `score`, `created_at`, `updated_at`) VALUES
(1, 'nikah', 'tahunan', 'Pernikahan', '2', NULL, '14', '2025-01-09', '2025-01-10', NULL, 8, '2024-12-23 09:06:48', '2024-12-23 09:08:28'),
(2, 'sakit', 'lain-lain', 'Sakit', '1', 'lekas sembuh', '14', '2024-12-17', '2024-12-19', 'bukti/QXL3ozrse4RhFU6M2yYPNnIT6ctCYLeP7u2ezIui.jpg', NULL, '2024-12-24 03:40:43', '2025-05-16 07:15:33'),
(3, 'mau nikah', 'tahunan', 'Pernikahan', '1', NULL, '14', '2025-01-23', '2025-01-24', NULL, 8, '2024-12-24 03:43:52', '2024-12-24 03:43:52'),
(4, 'mau ke dufan', 'tahunan', 'Liburan', '1', NULL, '18', '2025-01-24', '2025-01-24', NULL, 5, '2024-12-24 03:46:20', '2024-12-24 03:47:36'),
(5, 'liburan', 'tahunan', 'Relaksasi', '1', NULL, '18', '2025-05-20', '2025-05-21', NULL, 5, '2025-05-16 07:22:16', '2025-05-16 07:22:16'),
(6, 'mudik natal', 'tahunan', 'Keperluan Keluarga', '2', NULL, '11', '2025-05-27', '2025-05-28', NULL, 7, '2025-05-26 03:14:28', '2025-05-26 03:17:12'),
(7, 'nikah', 'tahunan', 'Pernikahan', '2', NULL, '11', '2025-05-29', '2025-05-31', NULL, 8, '2025-05-26 03:27:28', '2025-05-28 14:59:45'),
(8, 'Hayang Kawin', 'tahunan', 'Pernikahan', '1', NULL, '12', '2025-05-28', '2025-05-31', NULL, 8, '2025-05-28 14:59:45', '2025-05-28 14:59:45'),
(9, 'Hayang Kawin', 'tahunan', 'Urusan Pendidikan', '1', NULL, '12', '2025-06-03', '2025-06-07', NULL, 6, '2025-05-28 16:53:46', '2025-05-28 16:53:46'),
(10, 'Hayang Kawin', 'tahunan', 'Relaksasi', '1', NULL, '12', '2025-06-08', '2025-06-10', NULL, 5, '2025-05-28 16:57:24', '2025-05-28 16:57:24'),
(11, 'Hayang Kawin', 'tahunan', 'Urusan Pendidikan', '1', NULL, '20', '2025-05-06', '2025-05-17', NULL, 6, '2025-05-28 17:07:11', '2025-05-28 17:07:11'),
(12, '12', 'tahunan', 'Keperluan Keluarga', '1', NULL, '20', '2025-07-27', '2025-09-06', NULL, 7, '2025-05-28 17:10:51', '2025-05-28 17:10:51'),
(13, '12', 'tahunan', 'Urusan Pendidikan', '1', NULL, '20', '2025-09-07', '2025-10-10', NULL, 6, '2025-05-28 17:10:59', '2025-05-28 17:10:59'),
(14, 'bagas', 'tahunan', 'Pernikahan', '1', NULL, '21', '2025-06-29', '2025-07-12', NULL, 8, '2025-05-29 02:22:58', '2025-05-29 02:22:58'),
(15, 'demam', 'lain-lain', 'Sakit', '1', 'okedeh', '13', '2025-06-17', '2025-06-19', 'bukti/XbHaHgbdBJGz0382vGiA7dBTCu3lhxL2OQqPbIvv.jpg', NULL, '2025-06-17 13:56:49', '2025-06-17 14:00:37'),
(16, 'Mau psikotes s2', 'tahunan', 'Urusan Pendidikan', '1', NULL, '13', '2025-06-29', '2025-06-30', NULL, 6, '2025-06-18 04:02:09', '2025-06-18 04:02:09'),
(17, 'Mau psikotes s2', 'tahunan', 'Urusan Pendidikan', '1', NULL, '13', '2025-06-29', '2025-06-30', NULL, 6, '2025-06-18 04:02:11', '2025-06-18 04:02:11'),
(18, 'flu', 'lain-lain', 'Sakit', '0', NULL, '13', '2025-06-18', '2025-06-20', 'bukti/njalRnl7RS2EE7Ht83JWQR3ZYInY0NtR0kSSpNCW.jpg', NULL, '2025-06-18 08:29:04', '2025-06-18 08:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_14_135005_create_absensi_table', 2),
(5, '2024_10_14_135227_create_absensi_table', 3),
(6, '2024_10_26_012239_create_events_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('02OwcCRTlyNPZR9p9g0B5bZljXQr0Spv1EKzTxSB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1o4cWZmclJ0RjZTSFEyTXhPdXdNWTc3QXBkWGRwQXdjU01xaWU3MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1750235482),
('8S94uuLXhrShhALFwqLhYRrOjQuVDtSkqj01fcQK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTzVqV0hBR2FpWjQyYk54bnpicUFmMk1zeHN1RDVKZ0t2Qk1BUzhFaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9rY3V0aS9kb3dubG9hZC8xOCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7TzoyNToiSWxsdW1pbmF0ZVxTdXBwb3J0XENhcmJvbiI6Mzp7czo0OiJkYXRlIjtzOjI2OiIyMDI1LTA2LTE4IDE1OjI5OjM5LjAzMDIyNSI7czoxMzoidGltZXpvbmVfdHlwZSI7aTozO3M6ODoidGltZXpvbmUiO3M6MTI6IkFzaWEvSmFrYXJ0YSI7fX0=', 1750235379),
('SzJzKvM2MJtMADq0xMD3uzf426RhH1Tv70F5XrPP', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSGlWZFdOMmRpU0g2NGJLd3RSbUVaQnczOUFHYmt1WXlWTkFvSVFicSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZWdhd2FpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTM7czoxNjoibGFzdEFjdGl2aXR5VGltZSI7TzoyNToiSWxsdW1pbmF0ZVxTdXBwb3J0XENhcmJvbiI6Mzp7czo0OiJkYXRlIjtzOjI2OiIyMDI1LTA2LTE4IDE1OjM1OjM1LjM3Mzg3NCI7czoxMzoidGltZXpvbmVfdHlwZSI7aTozO3M6ODoidGltZXpvbmUiO3M6MTI6IkFzaWEvSmFrYXJ0YSI7fX0=', 1750235859);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo_cuti` int NOT NULL DEFAULT '12',
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_wa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `no_pegawai`, `jabatan`, `alamat`, `active`, `profile`, `role`, `birthday`, `email`, `email_verified_at`, `password`, `saldo_cuti`, `tempat_lahir`, `no_wa`, `gender`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'EMP001', 'Admin', '123 Main Streets', '1', 'avatars/man.jpg', '0', '1985-08-25', 'admin@a.com', '2024-10-09 07:20:53', '$2y$12$zz67TcwtjiX00xlozU4huul4SaOcPPgLzlbrwTJPkdobU0J7lHoVu', 12, 'Subang', '088222054482', 'Laki-Laki', 'BNn0mAxGofAPhwtuJ2kQv4O77b1RjAQqCNnXvGZzwnb1P1iP8arvT86T13JW', '2024-10-09 07:20:53', '2025-05-28 22:54:32'),
(10, 'Suherman', 'Suherman', 'EMP002', 'Direktur', 'Perumahan Courtyard Galuh Mas blok M 28', '1', 'avatars/man.jpg', '1', '1971-05-02', 'arjunaw63@gmail.com', NULL, '$2y$12$rCCpdQmrEAjq6.3LSqXvVe8/wVR9X1Wi6UJUI6ffgpvWhlKO47nfC', 12, 'Jakarta', '081188007359', 'Laki-Laki', NULL, '2024-12-22 13:18:46', '2024-12-22 13:33:48'),
(11, 'Nabila', 'Nabila Khoerunnisa', 'EMP003', 'Admin', 'Dsn Sukawargi Rt 07 Rw 03; Ds. Pinayungan; Kec. Telukjambe Timur; Kab. Karawang', '1', 'avatars/woman.jpg', '1', '2000-06-06', 'nabilakhoerunnisa311@gmail.com', NULL, '$2y$12$FE9eXr5nbXdDhlRyUTFFueqDnKkZrp8BJjjBow.ipq0aB.CS6Vnde', 12, 'Pemalang', '082324788078', 'Perempuan', NULL, '2024-12-22 13:19:52', '2025-05-28 14:59:45'),
(12, 'Khoirul', 'Khoirul Anwar', 'EMP004', 'Sales and Application Engineering', 'Kp. Cap Jaya RT/RW 009/003; Kel. Setiajaya; Kec. Cabangbungin; Kab. Bekasi 17720', '1', 'avatars/man.jpg', '1', '1992-04-19', 'khoirulanwar19@yahoo.com', NULL, '$2y$12$S/1f2/aSXZSJTt3BVkIWX.JRGbAjSTnvbrGcztF5qvDPl5o1fsheG', 0, 'Bekasi', '081586611993', 'Laki-Laki', NULL, '2024-12-22 13:20:41', '2025-05-28 16:57:24'),
(13, 'Eva', 'Eva Shofiyanah', 'EMP005', 'Staf Administrasi Keuangan/Accounting', 'Jl. Terate Guro II No.34 B RT.002/RW.010; Kel. Karawang Wetan; Kec. Karawang Timur; Kab. Karawang', '1', 'avatars/woman.jpg', '1', '1995-09-19', 'eshofiyanah@gmail.com', NULL, '$2y$12$3/.tQLphsfTW7Ap7wTxFiu17OVfsIFBZyQW6o7SkPoaZtbqsJeJEy', 10, 'Serang', '081295560220', 'Laki-Laki', NULL, '2024-12-22 13:21:54', '2025-06-18 04:02:11'),
(14, 'Ira', 'Ira Efriyanti', 'EMP006', 'Internal and External Admin', 'Perumnas Bumi Teluk Jambe Blok T No. 105 RT/RW 07/11; Desa Sukaharja; Kec. Teluk Jambe Timur; Kab. Karawang', '1', 'avatars/woman.jpg', '1', '1996-01-10', 'iraefriyanti@gmail.com', NULL, '$2y$12$W3Yq/epliu1znxRlQJQA1eS4hLjfBnMM8AetsNih3FkgKa2ZdQKb.', 25, 'Bekasi', '08990863745', 'Perempuan', NULL, '2024-12-22 13:23:31', '2025-05-16 07:15:33'),
(15, 'Sutrisno', 'Sutrisno', 'EMP007', 'Sales and Application Engineering', 'Blok Capar; Kelurahan Sidawangi; Kabupaten Sumber', '1', 'avatars/man.jpg', '1', '1989-03-21', 'sutrisno@gmail.com', NULL, '$2y$12$1u7yK64oPxbM1BudFQ0p3.Tw18VDCu6jUEO/4ev97xgkYuwmnCDkm', 12, 'Cirebon', '-', 'Laki-Laki', NULL, '2024-12-22 13:24:31', '2024-12-22 13:35:26'),
(16, 'Andrey Ardiansyah', 'Andrey Ardiansyah', 'EMP008', 'Sales Admin', 'Dusun Sukawargi', '1', 'avatars/man.jpg', '1', '1999-10-05', 'andreyben12@gmail.com', NULL, '$2y$12$d7mWfe1Z4mx8GW/GWuakauDq8MDP6Z8HUgbwpYxkhfiFYqVUlDeqC', 12, 'Karawang', '089660681338', 'Laki-Laki', NULL, '2024-12-22 13:25:26', '2025-05-16 07:10:00'),
(17, 'Herwono', 'Herwono', 'EMP009', 'Operator Workshop', 'Jl. Kh A Dahlan Gg.7 No.224 RT.006/RW.002; Kelurahan Tiro; Kecamatan Pekalongan Barat', '1', 'avatars/man.jpg', '1', '1978-02-06', 'herwono1234@yahoo.co.id', NULL, '$2y$12$fO6XHqmxF6ypwdllTiUHiuIQNpZLosrKar1hyaTq17o5c6SMz.Uqa', 12, 'Pekalongan', '085219379952', 'Laki-Laki', NULL, '2024-12-22 13:26:22', '2024-12-22 13:35:50'),
(18, 'Annisa', 'Annisa Ainnur Efendi', 'EMP010', 'Drafter', 'Karaba Indah; Kelurahan Wadas; Kecamatan Telukjambe Timur', '1', 'avatars/woman.jpg', '1', '2002-02-24', 'annisaainnure24@gmail.com', NULL, '$2y$12$YmmAUcUqtMrqScP6LNYLZe9noz3RN5UO36NXGoGFyNFmbwd/pp9BG', 7, 'Bandung', '081310278052', 'Perempuan', NULL, '2024-12-22 13:27:24', '2025-05-16 07:22:16'),
(20, 'ray', 'ray satya', 'EMP011', 'Boss', NULL, '1', 'avatars/man.jpg', '1', '2004-05-28', 'putrabagas298@gmail.com', NULL, '$2y$12$jfaP8fvnAqZsEFLLqwv6MOtU8gdo8EHbV2jqlER7UhcZi6BQqAFau', 9, 'Kupang', '082215662010', 'Laki-Laki', NULL, '2025-05-28 16:58:41', '2025-05-28 17:10:59'),
(21, 'bagas', 'bagas', 'EMP012', 'Juragan', NULL, '1', 'avatars/man.jpg', '1', '2003-01-29', 'bagas@gmail.com', NULL, '$2y$12$n5RS5mc1DN5JCfJlgIuRgekRAkvxsxXoL6skEKgFNy9eBuLLuvqBC', 11, 'Bekasi', '081586611993', 'Laki-Laki', NULL, '2025-05-29 02:21:56', '2025-05-29 02:22:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
