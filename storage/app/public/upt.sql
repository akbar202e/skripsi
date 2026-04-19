-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2026 at 07:42 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'i:2;', 1772942697),
('laravel-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897:timer', 'i:1772942697;', 1772942697),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1776584583),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1776584583;', 1776584583),
('laravel-cache-b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'i:1;', 1776571030),
('laravel-cache-b1d5781111d84f7b3fe45a0852e59758cd7a87e5:timer', 'i:1776571030;', 1776571030),
('laravel-cache-c1dfd96eea8cc2b62785275bca38ac261256e278', 'i:1;', 1776577444),
('laravel-cache-c1dfd96eea8cc2b62785275bca38ac261256e278:timer', 'i:1776577444;', 1776577444),
('laravel-cache-fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'i:1;', 1770730590),
('laravel-cache-fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f:timer', 'i:1770730589;', 1770730589),
('laravel-cache-livewire-rate-limiter:6f3eb026b03be06f8689db6ffe84135685bba5bd', 'i:1;', 1776570918),
('laravel-cache-livewire-rate-limiter:6f3eb026b03be06f8689db6ffe84135685bba5bd:timer', 'i:1776570918;', 1776570918),
('laravel-cache-livewire-rate-limiter:7f98824f949c9d7384bf2a0786f8f8fbef0532f5', 'i:1;', 1776583879),
('laravel-cache-livewire-rate-limiter:7f98824f949c9d7384bf2a0786f8f8fbef0532f5:timer', 'i:1776583879;', 1776583879),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1776657181);

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
-- Table structure for table `dokumens`
--

CREATE TABLE `dokumens` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` enum('peraturan','informasi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumens`
--

INSERT INTO `dokumens` (`id`, `judul`, `deskripsi`, `kategori`, `image_path`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'SOP Permohonan Uji Laboratorium', 'panduan tertulis langkah-langkah rinci dan sistematis pengajuan permohonan pengujian di laboratorium UPT LAB Bahan Konstruksi ', 'informasi', 'dokumen/01KGYFJZZ406AARCMH3J4QG4KX.jpg', 1, '2026-02-08 04:18:30', '2026-02-08 04:18:30'),
(5, 'Tarif Retribusi', 'Daftar Tarif Pengujian Bahan Konstruksi di UPT LAB', 'informasi', 'dokumen/01KPJATCC3BV6PPME9BGV0ENDQ.jpg', 1, '2026-04-19 00:38:27', '2026-04-19 00:38:27'),
(6, 'Maklumat Pelayanan', NULL, 'peraturan', 'dokumen/01KPJAVW4S438PT60QYWRAB5AP.jpg', 1, '2026-04-19 00:39:15', '2026-04-19 00:39:15'),
(7, 'Formulir Pengujian', 'Contoh Formulir Permohonan Pengujian Bahan Konstruksi', 'informasi', 'dokumen/01KPJB1225ATP6XGM2BR036X50.jpg', 1, '2026-04-19 00:42:05', '2026-04-19 00:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exports`
--

INSERT INTO `exports` (`id`, `completed_at`, `file_disk`, `file_name`, `exporter`, `processed_rows`, `total_rows`, `successful_rows`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2025-12-09 18:24:24', 'local', 'pembayaran-1.xlsx', 'App\\Filament\\Exports\\PembayaranExporter', 4, 4, 4, 6, '2025-12-09 18:22:45', '2025-12-09 18:24:24'),
(2, '2025-12-09 18:24:24', 'local', 'permohonan-2.xlsx', 'App\\Filament\\Exports\\PermohonanExporter', 4, 4, 4, 6, '2025-12-09 18:23:16', '2025-12-09 18:24:24'),
(3, '2025-12-09 18:28:04', 'local', 'pembayaran-3.xlsx', 'App\\Filament\\Exports\\PembayaranExporter', 4, 4, 4, 8, '2025-12-09 18:28:02', '2025-12-09 18:28:04'),
(4, '2025-12-09 18:29:13', 'local', 'permohonan-4.xlsx', 'App\\Filament\\Exports\\PermohonanExporter', 0, 0, 0, 4, '2025-12-09 18:29:12', '2025-12-09 18:29:13'),
(5, '2025-12-09 18:29:56', 'local', 'permohonan-5.xlsx', 'App\\Filament\\Exports\\PermohonanExporter', 1, 1, 1, 4, '2025-12-09 18:29:54', '2025-12-09 18:29:56'),
(6, '2025-12-09 18:30:44', 'local', 'pembayaran-6.xlsx', 'App\\Filament\\Exports\\PembayaranExporter', 4, 4, 4, 6, '2025-12-09 18:30:43', '2025-12-09 18:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_import_rows`
--

CREATE TABLE `failed_import_rows` (
  `id` bigint UNSIGNED NOT NULL,
  `data` json NOT NULL,
  `import_id` bigint UNSIGNED NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengujians`
--

CREATE TABLE `jenis_pengujians` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pengujian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` decimal(10,2) NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pengujians`
--

INSERT INTO `jenis_pengujians` (`id`, `nama_pengujian`, `biaya`, `deskripsi`, `created_at`, `updated_at`) VALUES
(186, 'Analisis Saringan Agregat Kasar / Halus', 60000.00, 'Pengujian analisis saringan agregat kasar atau halus', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(187, 'DMF Agregat Base A', 1500000.00, 'Desain campuran untuk agregat Base A', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(188, 'DMF Agregat Base B', 1500000.00, 'Desain campuran untuk agregat Base B', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(189, 'DMF Lapis Pondasi Tanpa Penutup Aspal', 1500000.00, 'Desain campuran lapis pondasi tanpa penutup aspal', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(190, 'DMF Agregat S', 1500000.00, 'Desain campuran agregat S', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(191, 'DMF BETON', 1500000.00, 'Desain campuran beton', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(192, 'DMF HRS BASE', 1500000.00, 'Desain campuran HRS Base', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(193, 'DMF HRS WC', 1500000.00, 'Desain campuran HRS WC', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(194, 'DMF AC WC', 1500000.00, 'Desain campuran Asphalt Concrete Wearing Course', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(195, 'DMF AC BC', 1500000.00, 'Desain campuran Asphalt Concrete Binder Course', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(196, 'DMF AC BASE', 1500000.00, 'Desain campuran Asphalt Concrete Base', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(197, 'DMF Latasir', 1500000.00, 'Desain campuran Latasir', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(198, 'DMF CTB', 1500000.00, 'Desain campuran CTB', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(199, 'DMF CTSB', 1500000.00, 'Desain campuran CTSB', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(200, 'DMF CTRB', 1500000.00, 'Desain campuran CTRB', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(201, 'DMF CTRSB', 1500000.00, 'Desain campuran CTRSB', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(202, 'DMF SOIL CEMENT', 1500000.00, 'Desain campuran soil cement', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(203, 'Kuat Tekan Paving Block', 36000.00, 'Pengujian kuat tekan paving block', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(204, 'Pengujian Kuat Tekan UCS', 48000.00, 'Pengujian kuat tekan UCS', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(205, 'Pengujian Kuat Tekan CTB', 48000.00, 'Pengujian kuat tekan CTB', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(206, 'Pengujian Kuat Tekan CTRB', 48000.00, 'Pengujian kuat tekan CTRB', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(207, 'DMF Sifat Fisis Aspal', 1500000.00, 'Desain campuran dan sifat fisis aspal', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(208, 'DMF Tanah Timbunan', 1250000.00, 'Desain campuran tanah timbunan', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(209, 'Marshall', 60000.00, 'Pengujian Marshall', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(210, 'Pengujian Abrasi', 90000.00, 'Pengujian keausan agregat (Abrasi)', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(211, 'Pengujian Berat Jenis Agregat / Tanah', 60000.00, 'Pengujian berat jenis agregat atau tanah', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(212, 'Pengujian Berat Jenis Agregat Kasar / Halus', 60000.00, 'Pengujian berat jenis agregat kasar atau halus', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(213, 'Pengujian Berat Jenis Campuran / Density Aspal', 78000.00, 'Pengujian berat jenis campuran atau density aspal', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(214, 'Pengujian Bor Mesin', 250000.00, 'Pengujian bor mesin', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(215, 'Pengujian CBR Lapangan', 96000.00, 'Pengujian CBR lapangan', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(216, 'Pengujian Core Drill Aspal', 118320.00, 'Pengujian core drill aspal', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(217, 'Pengujian Core Drill Beton', 118320.00, 'Pengujian core drill beton', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(218, 'Pengujian Cutting Blok Core Aspal', 341400.00, 'Pengujian cutting block core aspal', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(219, 'Pengujian DCP', 78000.00, 'Pengujian Dynamic Cone Penetrometer', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(220, 'Pengujian Ekstraksi', 300000.00, 'Pengujian ekstraksi', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(221, 'Pengujian Hammer Test', 72000.00, 'Pengujian hammer test', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(222, 'Pengujian Kadar Air', 36000.00, 'Pengujian kadar air sampel', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(223, 'Pengujian Kepadatan Mutlak', 108000.00, 'Pengujian kepadatan mutlak', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(224, 'Pengujian Kuat Tarik Baja', 120000.00, 'Pengujian kuat tarik baja', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(225, 'Pengujian Kuat Tekan / Lentur Beton', 36000.00, 'Pengujian kuat tekan atau lentur beton', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(226, 'Pengujian Lendutan Benkelman Beam', 120000.00, 'Pengujian lendutan Benkelman Beam', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(227, 'Pengujian LWD', 120000.00, 'Pengujian Lightweight Deflectometer', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(228, 'Pengujian PDA Test', 3000000.00, 'Pengujian PDA (Pile Driving Analyzer)', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(229, 'Pengujian Sandcone', 84000.00, 'Pengujian sandcone', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(230, 'Pengujian Sondir', 360000.00, 'Pengujian sondir', '2025-12-09 16:52:34', '2025-12-09 16:52:34'),
(231, 'Uji Material', 1250000.00, 'Uji material konstruksi', '2025-12-09 16:52:34', '2025-12-09 16:52:34');

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

--
-- Dumping data for table `job_batches`
--

INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('a08e49f1-b93a-42ce-8fca-146bb592b137', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6986:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PembayaranExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:22:45\";s:10:\"created_at\";s:19:\"2025-12-10 01:22:45\";s:2:\"id\";i:1;s:9:\"file_name\";s:17:\"pembayaran-1.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:22:45\";s:10:\"created_at\";s:19:\"2025-12-10 01:22:45\";s:2:\"id\";i:1;s:9:\"file_name\";s:17:\"pembayaran-1.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"pembayaran-1.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:3144:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PembayaranExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:22:45\";s:10:\"created_at\";s:19:\"2025-12-10 01:22:45\";s:2:\"id\";i:1;s:9:\"file_name\";s:17:\"pembayaran-1.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:22:45\";s:10:\"created_at\";s:19:\"2025-12-10 01:22:45\";s:2:\"id\";i:1;s:9:\"file_name\";s:17:\"pembayaran-1.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"pembayaran-1.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000009b30000000000000000\";}\";s:4:\"hash\";s:44:\"PfGg/hpcrMrzODH72DKJvYopqxfxyZrwy54SVw48Cgg=\";}}}}', NULL, 1765329863, 1765329864),
('a08e49f1-d229-4302-be0e-4b38fd451bf5', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:7298:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PermohonanExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:23:16\";s:10:\"created_at\";s:19:\"2025-12-10 01:23:16\";s:2:\"id\";i:2;s:9:\"file_name\";s:17:\"permohonan-2.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:23:16\";s:10:\"created_at\";s:19:\"2025-12-10 01:23:16\";s:2:\"id\";i:2;s:9:\"file_name\";s:17:\"permohonan-2.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"permohonan-2.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:3300:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PermohonanExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:23:16\";s:10:\"created_at\";s:19:\"2025-12-10 01:23:16\";s:2:\"id\";i:2;s:9:\"file_name\";s:17:\"permohonan-2.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:23:16\";s:10:\"created_at\";s:19:\"2025-12-10 01:23:16\";s:2:\"id\";i:2;s:9:\"file_name\";s:17:\"permohonan-2.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"permohonan-2.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"000000000000099e0000000000000000\";}\";s:4:\"hash\";s:44:\"JWv+9UrP2hhrlzDgHLO6Y1t6pHKZ7qcCLGkqxYCznq0=\";}}}}', NULL, 1765329863, 1765329864),
('a08e4b42-0542-405c-a91c-e4681c1a4f8a', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6986:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PembayaranExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:8;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:28:02\";s:10:\"created_at\";s:19:\"2025-12-10 01:28:02\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"pembayaran-3.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:8;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:28:02\";s:10:\"created_at\";s:19:\"2025-12-10 01:28:02\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"pembayaran-3.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"pembayaran-3.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:3144:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PembayaranExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:8;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:28:02\";s:10:\"created_at\";s:19:\"2025-12-10 01:28:02\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"pembayaran-3.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:8;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:28:02\";s:10:\"created_at\";s:19:\"2025-12-10 01:28:02\";s:2:\"id\";i:3;s:9:\"file_name\";s:17:\"pembayaran-3.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"pembayaran-3.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000009740000000000000000\";}\";s:4:\"hash\";s:44:\"aIU5x3wHL7ovYE3PB7kzCAFmO/oWsGwzB10qS8xokGY=\";}}}}', NULL, 1765330084, 1765330084),
('a08e4bac-4395-499d-860c-4dbb0b2bb179', '', 1, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:7298:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PermohonanExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:0;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:12\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:12\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"permohonan-4.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:0;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:12\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:12\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"permohonan-4.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"permohonan-4.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:3300:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PermohonanExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:0;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:12\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:12\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"permohonan-4.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:0;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:12\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:12\";s:2:\"id\";i:4;s:9:\"file_name\";s:17:\"permohonan-4.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"permohonan-4.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000a030000000000000000\";}\";s:4:\"hash\";s:44:\"pnP58yMno0O4btlNfK+ps8Q/EaJwHZqaweOtoKOgTV8=\";}}}}', NULL, 1765330153, 1765330153),
('a08e4bed-0bc3-4455-8862-81fba3166970', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:7298:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PermohonanExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:54\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:54\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"permohonan-5.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:54\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:54\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"permohonan-5.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"permohonan-5.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:3300:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PermohonanExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:54\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:54\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"permohonan-5.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:4;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PermohonanExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:29:54\";s:10:\"created_at\";s:19:\"2025-12-10 01:29:54\";s:2:\"id\";i:5;s:9:\"file_name\";s:17:\"permohonan-5.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"permohonan-5.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:14:{s:5:\"judul\";s:16:\"Judul Permohonan\";s:6:\"status\";s:6:\"Status\";s:12:\"pemohon.name\";s:7:\"Pemohon\";s:11:\"worker.name\";s:7:\"Petugas\";s:11:\"total_biaya\";s:11:\"Total Biaya\";s:7:\"is_paid\";s:18:\"Pembayaran Selesai\";s:15:\"is_sample_ready\";s:15:\"Sampel Diterima\";s:11:\"verified_at\";s:16:\"Waktu Verifikasi\";s:18:\"sample_received_at\";s:21:\"Waktu Sampel Diterima\";s:18:\"testing_started_at\";s:23:\"Waktu Pengujian Dimulai\";s:16:\"testing_ended_at\";s:23:\"Waktu Pengujian Selesai\";s:12:\"completed_at\";s:18:\"Waktu Penyelesaian\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000a0c0000000000000000\";}\";s:4:\"hash\";s:44:\"JCn4ujE6JQrF0xl6xfUxW/GQsqs7pj18OAf/j0xFTCc=\";}}}}', NULL, 1765330196, 1765330196);
INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('a08e4c37-176e-4536-b96f-a38b9fe4b165', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6986:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PembayaranExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:30:43\";s:10:\"created_at\";s:19:\"2025-12-10 01:30:43\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"pembayaran-6.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:30:43\";s:10:\"created_at\";s:19:\"2025-12-10 01:30:43\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"pembayaran-6.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"pembayaran-6.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:7:\"chained\";a:1:{i:0;s:3144:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\PembayaranExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:30:43\";s:10:\"created_at\";s:19:\"2025-12-10 01:30:43\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"pembayaran-6.xlsx\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:6;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\PembayaranExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2025-12-10 01:30:43\";s:10:\"created_at\";s:19:\"2025-12-10 01:30:43\";s:2:\"id\";i:6;s:9:\"file_name\";s:17:\"pembayaran-6.xlsx\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:17:\"pembayaran-6.xlsx\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:13:{s:16:\"permohonan.judul\";s:16:\"Judul Permohonan\";s:9:\"user.name\";s:13:\"Nama Pembayar\";s:6:\"amount\";s:7:\"Nominal\";s:14:\"payment_method\";s:17:\"Metode Pembayaran\";s:19:\"payment_method_name\";s:11:\"Nama Metode\";s:17:\"merchant_order_id\";s:17:\"Merchant Order ID\";s:16:\"duitku_reference\";s:16:\"Referensi Duitku\";s:6:\"status\";s:6:\"Status\";s:11:\"result_code\";s:11:\"Result Code\";s:7:\"paid_at\";s:16:\"Waktu Pembayaran\";s:5:\"notes\";s:7:\"Catatan\";s:10:\"created_at\";s:11:\"Dibuat Pada\";s:10:\"updated_at\";s:15:\"Diperbarui Pada\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000008e40000000000000000\";}\";s:4:\"hash\";s:44:\"v90Wz4FI4TgSiHhZ20XZST8W4PmQW1d8eUo1KvR2Z5E=\";}}}}', NULL, 1765330244, 1765330244);

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
(4, '2025_10_19_133834_create_permohonans_table', 1),
(5, '2025_10_19_141337_create_permission_tables', 1),
(6, '2025_11_09_000001_create_jenis_pengujians_table', 1),
(7, '2025_11_09_000002_create_permohonan_pengujian_table', 1),
(8, '2025_11_09_000003_add_files_and_status_to_permohonans_table', 1),
(9, '2025_11_16_055643_create_dokumens_table', 1),
(10, '2025_11_17_131552_update_permohonan_status_enum', 1),
(11, '2025_11_17_150000_add_jumlah_sampel_to_permohonan_pengujian_table', 1),
(12, '2025_11_20_000000_add_instansi_and_no_hp_to_users_table', 1),
(13, '2025_12_06_000000_update_permohonan_payment_status', 2),
(14, '2025_12_06_000001_create_pembayarans_table', 2),
(15, '2025_12_06_000002_create_payment_methods_table', 2),
(16, '2025_12_10_000001_add_status_timestamps_to_permohonans_table', 3),
(17, '2025_12_10_012138_create_imports_table', 4),
(18, '2025_12_10_012139_create_exports_table', 4),
(19, '2025_12_10_012140_create_failed_import_rows_table', 4),
(20, '2025_12_10_012203_create_notifications_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0ba294ef-431f-4d5d-99a7-2f3882366147', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 8, '{\"actions\":[{\"name\":\"download_csv\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Download .csv\",\"shouldClose\":false,\"shouldMarkAsRead\":true,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":true,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/filament\\/exports\\/3\\/download?format=csv\",\"view\":\"filament-actions::link-action\"},{\"name\":\"download_xlsx\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Download .xlsx\",\"shouldClose\":false,\"shouldMarkAsRead\":true,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":true,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/filament\\/exports\\/3\\/download?format=xlsx\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Rekap Pembayaran berhasil diunduh.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Export completed\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2025-12-09 18:28:24', '2025-12-09 18:28:04', '2025-12-09 18:28:24'),
('4a7ec02a-5ce3-4765-811f-118702a2486c', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 6, '{\"actions\":[{\"name\":\"download_csv\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Download .csv\",\"shouldClose\":false,\"shouldMarkAsRead\":true,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":true,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/filament\\/exports\\/6\\/download?format=csv\",\"view\":\"filament-actions::link-action\"},{\"name\":\"download_xlsx\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Download .xlsx\",\"shouldClose\":false,\"shouldMarkAsRead\":true,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":true,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/filament\\/exports\\/6\\/download?format=xlsx\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Rekap Pembayaran berhasil diunduh.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Export completed\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2025-12-09 18:30:56', '2025-12-09 18:30:45', '2025-12-09 18:30:56'),
('7c8ce83a-1f6d-4ae8-b070-9cacc6d480aa', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 4, '{\"actions\":[{\"name\":\"download_csv\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Download .csv\",\"shouldClose\":false,\"shouldMarkAsRead\":true,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":true,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/filament\\/exports\\/5\\/download?format=csv\",\"view\":\"filament-actions::link-action\"},{\"name\":\"download_xlsx\",\"color\":null,\"event\":null,\"eventData\":[],\"dispatchDirection\":false,\"dispatchToComponent\":null,\"extraAttributes\":[],\"icon\":null,\"iconPosition\":\"before\",\"iconSize\":null,\"isOutlined\":false,\"isDisabled\":false,\"label\":\"Download .xlsx\",\"shouldClose\":false,\"shouldMarkAsRead\":true,\"shouldMarkAsUnread\":false,\"shouldOpenUrlInNewTab\":true,\"size\":\"sm\",\"tooltip\":null,\"url\":\"\\/filament\\/exports\\/5\\/download?format=xlsx\",\"view\":\"filament-actions::link-action\"}],\"body\":\"Rekap Permohonan berhasil diunduh.\",\"color\":null,\"duration\":\"persistent\",\"icon\":\"heroicon-o-check-circle\",\"iconColor\":\"success\",\"status\":\"success\",\"title\":\"Export completed\",\"view\":\"filament-notifications::notification\",\"viewData\":[],\"format\":\"filament\"}', '2025-12-09 18:30:01', '2025-12-09 18:29:56', '2025-12-09 18:30:01');

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
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_image` text COLLATE utf8mb4_unicode_ci,
  `total_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `payment_method`, `payment_name`, `payment_image`, `total_fee`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BC', 'BCA VA', 'https://images.duitku.com/hotlink-ok/BCA.SVG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(2, 'M2', 'MANDIRI VA H2H', 'https://images.duitku.com/hotlink-ok/MV.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(3, 'VA', 'MAYBANK VA', 'https://images.duitku.com/hotlink-ok/VA.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(4, 'I1', 'BNI VA', 'https://images.duitku.com/hotlink-ok/I1.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(5, 'B1', 'CIMB NIAGA VA', 'https://images.duitku.com/hotlink-ok/B1.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(6, 'BT', 'PERMATA VA', 'https://images.duitku.com/hotlink-ok/PERMATA.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(7, 'DM', 'Danamon Virtual Account', NULL, 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:49:02', NULL),
(8, 'BV', 'BSI VA', 'https://images.duitku.com/hotlink-ok/BSI.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(9, 'VC', 'CREDIT CARD', 'https://images.duitku.com/hotlink-ok/VC.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(10, 'OV', 'OVO', 'https://images.duitku.com/hotlink-ok/OV.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(11, 'SA', 'SHOPEEPAY APP', 'https://images.duitku.com/hotlink-ok/SHOPEEPAY.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(12, 'DA', 'DANA', 'https://images.duitku.com/hotlink-ok/DA.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(13, 'LF', 'LinkAja Apps (Fixed Fee)', NULL, 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:49:02', NULL),
(14, 'LA', 'LINKAJA APP PCT', 'https://images.duitku.com/hotlink-ok/LINKAJA.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(15, 'SP', 'SHOPEEPAY QRIS', 'https://images.duitku.com/hotlink-ok/SHOPEEPAY.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(16, 'NQ', 'NOBU QRIS', 'https://images.duitku.com/hotlink-ok/NQ.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(17, 'GQ', 'GUDANG VOUCHER QRIS', 'https://images.duitku.com/hotlink-ok/GQ.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(18, 'SQ', 'Nusapay (QRIS)', NULL, 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:49:02', NULL),
(19, 'DN', 'INDODANA PAYLATER', 'https://images.duitku.com/hotlink-ok/DN.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(20, 'AT', 'ATOME Paylater', NULL, 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:49:02', NULL),
(21, 'JP', 'JENIUS PAY', 'https://images.duitku.com/hotlink-ok/JP.PNG', 0.00, 1, '2025-12-06 08:49:02', '2025-12-06 08:57:29', NULL),
(22, 'FT', 'RETAIL', 'https://images.duitku.com/hotlink-ok/RETAIL.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(23, 'A1', 'ATM BERSAMA VA', 'https://images.duitku.com/hotlink-ok/A1.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(24, 'AG', 'ARTHA GRAHA VA', 'https://images.duitku.com/hotlink-ok/AG.JPG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(25, 'LQ', 'LINKAJA QRIS', 'https://images.duitku.com/hotlink-ok/LINKAJA.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(26, 'IR', 'INDOMARET', 'https://images.duitku.com/hotlink-ok/IR.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(27, 'SL', 'SHOPEEPAY LINK', 'https://images.duitku.com/hotlink-ok/SHOPEEPAY.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(28, 'BR', 'BRI VA', 'https://images.duitku.com/hotlink-ok/BR.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(29, 'NC', 'BNC VA', 'https://images.duitku.com/hotlink-ok/NC.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL),
(30, 'OL', 'OVO LINK', 'https://images.duitku.com/hotlink-ok/OV.PNG', 0.00, 1, '2025-12-06 08:57:29', '2025-12-06 08:57:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duitku_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `va_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_url` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','success','failed','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `result_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `permohonan_id`, `user_id`, `amount`, `payment_method`, `payment_method_name`, `merchant_order_id`, `duitku_reference`, `va_number`, `payment_url`, `status`, `result_code`, `paid_at`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 24, 8, 438000.00, 'VC', 'CREDIT CARD', 'ORDER-24-H0dMqfRd', 'DS26604257GPPL5XGNDDP176', NULL, 'https://sandbox.duitku.com/topup/v2/TopUpCreditCardPayment.aspx?reference=DS26604257GPPL5XGNDDP176', 'success', '00', '2025-12-09 17:26:32', NULL, '2025-12-09 17:15:09', '2025-12-09 17:26:32', NULL),
(20, 23, 8, 6600000.00, 'VC', 'CREDIT CARD', 'ORDER-23-jiARj0HM', 'DS26604255QUEINBGQ8YFFR6', NULL, 'https://sandbox.duitku.com/topup/v2/TopUpCreditCardPayment.aspx?reference=DS26604255QUEINBGQ8YFFR6', 'success', '00', '2025-11-04 17:21:48', NULL, '2025-10-31 17:15:22', '2025-10-31 17:21:48', NULL),
(21, 25, 8, 7860000.00, 'VC', 'CREDIT CARD', 'ORDER-25-J9WCrWzL', 'DS2660425CIA3DJRPENI2P4J', NULL, 'https://sandbox.duitku.com/topup/v2/TopUpCreditCardPayment.aspx?reference=DS2660425CIA3DJRPENI2P4J', 'success', '00', '2025-12-09 17:53:45', NULL, '2025-12-09 17:52:33', '2025-12-09 17:53:45', NULL),
(22, 26, 8, 780000.00, NULL, NULL, 'ORDER-26-YKngE3eL', NULL, NULL, NULL, 'failed', NULL, NULL, NULL, '2025-12-09 17:59:37', '2025-12-09 17:59:37', NULL),
(23, 28, 8, 1183200.00, 'VC', 'CREDIT CARD', 'ORDER-28-8dBerFqv', 'DS2660426SABU8MWVKYLA4RF', NULL, 'https://sandbox.duitku.com/topup/v2/TopUpCreditCardPayment.aspx?reference=DS2660426SABU8MWVKYLA4RF', 'success', '00', '2026-02-08 04:44:30', NULL, '2026-02-08 04:42:17', '2026-02-08 04:44:30', NULL),
(24, 30, 8, 360000.00, 'VC', 'CREDIT CARD', 'ORDER-30-CDHxHqYM', 'DS2660426ZH0FOC3AZBJY27M', NULL, 'https://sandbox.duitku.com/topup/v2/TopUpCreditCardPayment.aspx?reference=DS2660426ZH0FOC3AZBJY27M', 'pending', NULL, NULL, NULL, '2026-02-10 06:36:27', '2026-02-10 06:36:32', NULL),
(25, 32, 10, 4500000.00, 'VC', 'CREDIT CARD', 'ORDER-32-UKWmkeHq', 'DS2660426YPW2F0FTEP6D5TD', NULL, 'https://sandbox.duitku.com/topup/v2/TopUpCreditCardPayment.aspx?reference=DS2660426YPW2F0FTEP6D5TD', 'success', '00', '2026-04-18 22:47:39', NULL, '2026-04-18 22:44:03', '2026-04-18 22:47:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permohonans`
--

CREATE TABLE `permohonans` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `worker_id` bigint UNSIGNED DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `sample_received_at` datetime DEFAULT NULL,
  `testing_started_at` datetime DEFAULT NULL,
  `testing_ended_at` datetime DEFAULT NULL,
  `report_started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `surat_permohonan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `laporan_hasil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('menunggu_verifikasi','perlu_perbaikan','menunggu_pembayaran_sampel','sedang_diuji','menyusun_laporan','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_verifikasi',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `is_sample_ready` tinyint(1) NOT NULL DEFAULT '0',
  `total_biaya` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonans`
--

INSERT INTO `permohonans` (`id`, `judul`, `isi`, `user_id`, `worker_id`, `keterangan`, `created_at`, `updated_at`, `verified_at`, `sample_received_at`, `testing_started_at`, `testing_ended_at`, `report_started_at`, `completed_at`, `deleted_at`, `surat_permohonan`, `laporan_hasil`, `status`, `is_paid`, `is_sample_ready`, `total_biaya`) VALUES
(23, 'Permohonan Uji Tekan Beton Fc 20 Mpa', 'Pekerjaan pembangunan jembatan kota Muara Teweh Km. 05', 8, 6, NULL, '2025-10-01 16:56:42', '2026-04-18 22:43:07', '2025-10-01 00:14:47', NULL, '2025-12-10 00:31:30', NULL, '2026-04-19 05:38:00', '2026-04-19 05:43:07', NULL, NULL, 'permohonan/01KPJ476Q98HWTDYFD7F0WMR1C.pdf', 'selesai', 1, 1, 6600000.00),
(24, 'Permohonan Uji Kuat Tarik Baja', 'Pekerjaan pembangunan gedung Koni', 8, 6, NULL, '2025-10-31 17:00:30', '2025-12-09 17:37:51', '2025-12-10 00:14:54', NULL, '2025-12-08 00:31:47', NULL, '2025-12-10 00:37:19', '2025-12-10 00:37:51', NULL, NULL, 'permohonan/01KC2V2T8RERS67K0XC7XHKHKF.pdf', 'selesai', 1, 1, 438000.00),
(25, 'Permohonan DMF Beton Fc 15 Mpa', 'Pekerjaan pembangunan jalan Gg. Permata Hijau', 8, 6, NULL, '2025-12-09 17:51:39', '2026-02-08 04:41:08', '2025-12-10 00:52:15', NULL, '2025-12-10 01:03:03', NULL, '2026-02-08 11:31:22', '2026-02-08 11:41:08', NULL, NULL, 'permohonan/01KGYGWEJY5WZ1YK8QH2VNP5EQ.pdf', 'selesai', 1, 1, 7860000.00),
(26, 'Permohonan Uji Density', 'Pekerjaan pembangunan dan pemeliharaan gedung bupati', 8, 6, NULL, '2025-12-09 17:59:01', '2025-12-09 17:59:32', '2025-12-10 00:59:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu_pembayaran_sampel', 0, 1, 780000.00),
(27, 'Permohonan Uji Kadar Air', 'Pekerjaan Pemeliharaan Jalan dalam Kota Palangka Raya', 4, NULL, NULL, '2025-12-09 18:29:42', '2025-12-09 18:29:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu_verifikasi', 0, 0, 120000.00),
(28, 'Permohonan Uji Core Beton', 'Pekerjaan Pemeliharaan gedung Stadion Km. 05', 8, 6, NULL, '2026-02-08 03:39:28', '2026-02-08 04:45:54', '2026-02-08 11:32:31', NULL, '2026-02-08 11:45:31', NULL, '2026-02-08 11:45:54', NULL, NULL, 'permohonan/01KGYDBHD21W95Y9VT0VGZ83HD.pdf', NULL, 'menyusun_laporan', 1, 1, 1183200.00),
(30, 'Permohonan Uji Titik Lembek Aspal', 'Pekerjaan pembangunan jalan tembusan gang buntu- gang sukamasak', 8, 6, NULL, '2026-02-10 06:35:45', '2026-02-10 06:36:22', '2026-02-10 13:36:15', NULL, NULL, NULL, NULL, NULL, NULL, 'permohonan/01KH3W7RA9K4PJSGZR44J5D55V.pdf', NULL, 'menunggu_pembayaran_sampel', 0, 1, 360000.00),
(31, 'Permohonan Uji tekan beton', 'Peningkatan Jalan Bangkung IV Gg Keluarga, Kota Palangka Raya', 9, NULL, NULL, '2026-03-07 21:04:57', '2026-03-07 21:04:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'permohonan/01KK5SX9C7PVEJSXMBHSRQSSY4.pdf', NULL, 'menunggu_verifikasi', 0, 0, 108000.00),
(32, 'PERMOHONAN DMF BETON FC 20 MPA', 'bangunan jembatan', 10, 6, NULL, '2026-04-18 20:56:21', '2026-04-18 22:47:39', '2026-04-19 05:41:55', NULL, NULL, NULL, NULL, NULL, NULL, 'permohonan/01KPHY3PR0Z7MQJVC1D0SV0NC6.pdf', NULL, 'menunggu_pembayaran_sampel', 1, 1, 4500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_pengujian`
--

CREATE TABLE `permohonan_pengujian` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `jenis_pengujian_id` bigint UNSIGNED NOT NULL,
  `jumlah_sampel` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_pengujian`
--

INSERT INTO `permohonan_pengujian` (`id`, `permohonan_id`, `jenis_pengujian_id`, `jumlah_sampel`, `created_at`, `updated_at`) VALUES
(40, 23, 213, 2, '2025-12-09 16:56:42', '2025-12-09 16:56:42'),
(41, 23, 192, 1, '2025-12-09 16:56:42', '2025-12-09 16:56:42'),
(42, 23, 201, 2, '2025-12-09 16:56:42', '2025-12-09 16:56:42'),
(43, 23, 225, 4, '2025-12-09 16:56:42', '2025-12-09 16:56:42'),
(44, 23, 230, 5, '2025-12-09 16:56:42', '2025-12-09 16:56:42'),
(45, 24, 230, 1, '2025-12-09 17:00:30', '2025-12-09 17:00:30'),
(46, 24, 213, 1, '2025-12-09 17:00:30', '2025-12-09 17:00:30'),
(47, 25, 230, 1, '2025-12-09 17:51:39', '2025-12-09 17:51:39'),
(48, 25, 201, 5, '2025-12-09 17:51:39', '2025-12-09 17:51:39'),
(49, 26, 213, 10, '2025-12-09 17:59:01', '2025-12-09 17:59:01'),
(50, 27, 227, 1, '2025-12-09 18:29:42', '2025-12-09 18:29:42'),
(51, 28, 217, 10, '2026-02-08 03:39:28', '2026-02-08 03:39:28'),
(53, 30, 225, 10, '2026-02-10 06:35:45', '2026-02-10 06:35:45'),
(54, 31, 203, 3, '2026-03-07 21:04:57', '2026-03-07 21:04:57'),
(55, 32, 191, 3, '2026-04-18 20:56:21', '2026-04-18 20:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-11-20 06:46:57', '2025-11-20 06:46:57'),
(2, 'Petugas', 'web', '2025-11-20 06:47:11', '2025-11-20 06:47:11'),
(3, 'Pemohon', 'web', '2025-11-20 06:47:17', '2025-11-20 06:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
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
('LljA5RsKDcNbnfCW80514egejKmxpQP7ZuLG6WQy', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'ZXlKcGRpSTZJa295UTNoUmJtMXNNRGhTZVhkV2MyWjVkRk5JTDBFOVBTSXNJblpoYkhWbElqb2lSMUZKTDNWaWVrVTVWV05GY1ZoQ2FtUnZOVGhZZUhoblRqWldVM2RRU2psM1UzVkJNbUprYmtSaVJtSm5hMHgyV0RGSmRqbFRPV2RpY21Kc2EwbHJSbFI0UzJacWVHRkJMM1V6VEhoNGFFbEdjakZSUWtSTmRFdHFVMGQ1VUc5NFNYaFJUVXhuWVU5SVJURlZVVkkwYjAwd2FYbHZSRkowYmxaNGRtOWhaMUZMV0VkWFZrMW9ZVGx5TXlzeFlsRk9kbHB0YVdSd2FrWk9WbXRzWjFCdk5YSnlXWEZCTm1sRGRIcG9UM2RMY0hOSmQwcHBOMjExYVRaSGJUQnJXRzl4VGxBNFdrUm1SMWRqVUVwMlpHbzRWVGhuUkRad01TOVhVMkpCTmpFd2NYWTNUMlJvZW0xeWNVeDNVR1l2YUVoSUt6VklSVUpZUms0NU9WaHhjWEV3UWsxS1FtaFRSa05zVVRoc1NtZG5PWGRvVUhwYWR6aE5WVE5xU1V4S1EyMTRORVpZU0hSNFFURmpVbXAwZGxwdE1sZDFiMXB6UlVwd1ZHOWpjVmQxWnk5eVZDdGlZak1yVVdGdmExWkxWVkVyYlhOeVNUTlhSa3AxZHk5cWEyaHNiazVIU1ZOaGIydzRNR3hMWlVsVVJITmtUVFJET1RSMmJWbEJWREZSVEdOdVpVZFNNWFpDUXpKTmMxRm9hMkZoV0dGaVJHRlNWV0pKVkhsUFoyZGxNVWhXV2t0c2R6WnlVMGRTY0dsTUwyOVBjRWtyYWpSaFkzZEVRV0ZZVDI1aVJVNWlZMFFyVWsxMGFXTTNkUzh2U0hWUVNXVkdlSEJHV0VRNFp6SXlOMFZ3YnpWbEwyVnJZVGx1WlhSQmRXeEtVVzR5UkVrekwySnBPWGNyV0VkSldua2lMQ0p0WVdNaU9pSmpNV1EzTUdGaU1EUmtaR0poTURGak5qUmhaR1EzWVRWaE1EazVNbUptTVRreU56azJaREpoTm1Gak1EbGxZVFl3Tnpnd1l6RTBaREZrTWpKalpHSmxJaXdpZEdGbklqb2lJbjA9', 1776584540),
('we00LlOtywxbIaBfkt8fBERP04fMbpE9eP6MOfsV', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJa1p3ZUVoTVNXMTJXbXcyTnpKemNtbFZjVFJWZFdjOVBTSXNJblpoYkhWbElqb2lOVU5LY1djeVkwOTJja3N6UzJGdVpWbElWMGx2Y1RjNE5HTmxhek51UTJ4NVRtVlFWemQzY1dSVFF6Rllia2w1TTFWb1YyZGtOR1ZsWVhRdlMzZE5jbnB0VEU0MVMxUXZPVEJhWmpSUlpXNXJkQzlZUVhGT04zTTNTbXRsV1ROaFZqUlhiMk5KUWpobU1GZHlabTVUTlRObGVVNDVRa05DVEVkYU5uZzJMMDFYVWpKakszSmlibkpUUjFWRlozUXhheXR0UTJSR2FVNHplazVGU1hrd1lVSndTV05oZGtOdGNHRldUVGhuVjNjd1VERTNkR05UVDBJdlFrNDVlR3R6YjJWWU4zYzNlV3RYWlRreGR6SktaV3N4VmtWTmRHSTJhekUyTkhaT1RXTk5XamcyTlcxa1YxSklibmR3Y210VGFucG5VSEYzVWxVelRsTlZVMW8zUkM4NFNUVlhXRmhsU1cxa2VrOHJVVUp1TVZRNVpEbHZabkZGYWtSR2J6aDNhV1JHYmtoVU1qVk5aRnBEUml0aWNEVlpkakZwYlZSTWFYQlRlamhqUldZM1NUTTRaSFZUVlRNelFVSktUMkZtVjFkdlUwZHFTVVpMS3pNemFqSXdPRTVCUWxWNFoxTnlkV2N3T1doTFZsSTFNVTVpUzBsQmFqaFdSbUpGUnpOTWNHTkpRazkzY0VnckwzQlZMMnhOUmpsNU5HTjFjbWxQUVZwdlNtTmhNRlEzVWtWWk1XTkNVbkZSVVhjd1ExSnZhVzFqYzBFNU1sbDVRUzlTU0UxeFNWWkNiVVJ3U0V4VlIzTk9TR0puVEVWVmEyZDNRMVJrVkcxbmRGWk9kVEV6T0V4bGNrSjVhVlJNWkRCd1FuSmFXWFJzUkZvMllXTnVjM2N2VkRKWlMwTWlMQ0p0WVdNaU9pSTVNelkxTlRZek5EZGxaVFJpWldNek16ZzVaREEwWWpjNE1UQTRaakZsWmpWaFpUTmpNakk0TmpCa09EVTFOelkxTlRRek1tRmlPVGMxTmpsaU0yWTNJaXdpZEdGbklqb2lJbjA9', 1776584545);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `instansi`, `no_hp`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'UPT2', '0812345678', NULL, '$2y$12$IGybYv/FlYh5u1FOrF0ZUu6HLAXKCpwe./KCJ/LGb/C1SBMCKVHGS', NULL, '2025-11-20 06:42:22', '2025-11-20 06:42:22', NULL),
(3, 'Semut U', 'semut@gmail.com', 'PT. SEMUT HITAM', '08534833', NULL, '$2y$12$hgmpZOh3rlDeYHnvQbfGcussWL4Zm6tM/0Y4BYr.hPBnYHQfpPmGS', NULL, '2025-11-20 08:30:11', '2025-11-20 08:30:11', NULL),
(4, 'Berkah U', 'berkah@gmail.com', NULL, NULL, NULL, '$2y$12$OOTB5f/OKUdyLAMwvoiRpu1oHKr8BpiBB/7hAGTztwSK95KTqOJjG', NULL, '2025-11-20 08:34:16', '2025-11-20 08:34:16', NULL),
(5, 'Sapta P', 'sapta@gmail.com', NULL, NULL, NULL, '$2y$12$hoP8ClcYpjCbiboTwXcAouiM3F6ebNk00vsv0HUqLsL6l5w.dNb0.', NULL, '2025-11-20 08:34:59', '2025-11-20 08:34:59', NULL),
(6, 'Rusmin P', 'rusmin@gmail.com', NULL, NULL, NULL, '$2y$12$v8wsC1InqLaYdkgOLKijE.N0OQMWquK.pcqb/XwOEuaMZ1RePBIB6', NULL, '2025-11-20 08:35:07', '2025-11-20 08:35:07', NULL),
(7, 'Admin', 'admin@example.com', 'UPT2', '0812345678', NULL, '$2y$12$tAygpxjqvo8r5P0Sxe0kweLrDrOUXGCO5/0UWCyBpOWli9Yu4x30u', NULL, '2025-12-06 08:49:40', '2025-12-06 08:49:40', NULL),
(8, 'Surya U', 'surya@gmail.com', NULL, NULL, NULL, '$2y$12$wfzyhqOmLz38LFdZ5w5xX.TnyT4GAPYtJZcadU/OoLjcsMdZS7/aC', NULL, '2025-12-06 09:16:48', '2025-12-06 09:16:48', NULL),
(9, 'CV. MAHA ARTHA ABADI', 'maha@gmail.com', 'CV. MAHA ARTHA ABADI', '08534833', NULL, '$2y$12$z2LPX4.fkJDM1B7UVnw5K.4WOSJByUIRDn1nN0HBplqTpzGn0P29q', NULL, '2026-03-07 21:01:49', '2026-03-07 21:02:03', NULL),
(10, 'Mutfi', 'mutfi@gmail.com', 'mutfi karya', '08534833', NULL, '$2y$12$NUCvrbURtyxJv.z//EJ3pO0JkZaQUNQt.686WW2Yj3GzjLw1SseNu', NULL, '2026-04-18 20:54:18', '2026-04-18 20:54:18', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `dokumens`
--
ALTER TABLE `dokumens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumens_created_by_foreign` (`created_by`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exports_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_import_rows_import_id_foreign` (`import_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imports_user_id_foreign` (`user_id`);

--
-- Indexes for table `jenis_pengujians`
--
ALTER TABLE `jenis_pengujians`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_payment_method_unique` (`payment_method`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembayarans_merchant_order_id_unique` (`merchant_order_id`),
  ADD KEY `pembayarans_permohonan_id_index` (`permohonan_id`),
  ADD KEY `pembayarans_user_id_index` (`user_id`),
  ADD KEY `pembayarans_status_index` (`status`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `permohonans`
--
ALTER TABLE `permohonans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonans_user_id_foreign` (`user_id`),
  ADD KEY `permohonans_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `permohonan_pengujian`
--
ALTER TABLE `permohonan_pengujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_pengujian_permohonan_id_foreign` (`permohonan_id`),
  ADD KEY `permohonan_pengujian_jenis_pengujian_id_foreign` (`jenis_pengujian_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumens`
--
ALTER TABLE `dokumens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_pengujians`
--
ALTER TABLE `jenis_pengujians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permohonans`
--
ALTER TABLE `permohonans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `permohonan_pengujian`
--
ALTER TABLE `permohonan_pengujian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumens`
--
ALTER TABLE `dokumens`
  ADD CONSTRAINT `dokumens_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exports`
--
ALTER TABLE `exports`
  ADD CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permohonans`
--
ALTER TABLE `permohonans`
  ADD CONSTRAINT `permohonans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonans_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `permohonan_pengujian`
--
ALTER TABLE `permohonan_pengujian`
  ADD CONSTRAINT `permohonan_pengujian_jenis_pengujian_id_foreign` FOREIGN KEY (`jenis_pengujian_id`) REFERENCES `jenis_pengujians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_pengujian_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
