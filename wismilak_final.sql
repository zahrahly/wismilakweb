-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2026 at 08:34 PM
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
-- Database: `wismilak_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `user_id`, `department`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Management', '081234000000', 'avatars/WMYwWounCgUKVWLiZJVCIwLKvrqMCH3alFOIc9U8.png', '2026-04-22 07:59:43', '2026-05-22 21:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@survivegarage.com|127.0.0.1', 'i:2;', 1780490298),
('laravel-cache-admin@survivegarage.com|127.0.0.1:timer', 'i:1780490298;', 1780490298);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_session_id` bigint(20) UNSIGNED NOT NULL,
  `sender` enum('user','admin','bot') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `chat_session_id`, `sender`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'bot', 'Selamat datang, Customer Test. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.', '2026-05-17 19:58:51', '2026-05-17 19:58:51'),
(2, 1, 'user', 'event', '2026-05-17 19:59:38', '2026-05-17 19:59:38'),
(3, 1, 'bot', '📅 Untuk melihat event terbaru:\n1. Buka menu **Event** di navbar\n2. Pilih Calendar View atau Event List\n3. Klik event untuk detail & registrasi\n\nSetiap event memiliki kuota terbatas, jadi daftar sekarang!', '2026-05-17 19:59:38', '2026-05-17 19:59:38'),
(4, 2, 'bot', 'Selamat datang, Admin Wismilak. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.', '2026-05-19 10:13:43', '2026-05-19 10:13:43'),
(5, 3, 'bot', 'Selamat datang, Customer Test. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.', '2026-05-22 21:31:14', '2026-05-22 21:31:14'),
(6, 3, 'user', 'halo kak mau tanya kalau aku mau tukerin poin aku gimana ya?', '2026-05-22 22:03:45', '2026-05-22 22:03:45'),
(7, 3, 'bot', 'Halo! 👋 Selamat datang di Wismilak. Ada yang bisa saya bantu?\n\nAnda bisa bertanya tentang:\n• Event & Registrasi\n• Tiket & Pembayaran\n• Voucher & Diskon\n• Produk & Outlet\n• Reward & Poin\n\nAtau ketik \"admin\" untuk bicara langsung dengan tim kami.', '2026-05-22 22:03:45', '2026-05-22 22:03:45'),
(8, 3, 'user', 'tentang poin kak', '2026-05-22 22:04:06', '2026-05-22 22:04:06'),
(9, 3, 'bot', 'Cara mendapatkan poin:\r\n• Registrasi event gratis: +5 poin\r\n• Pembayaran event: +10 poin per tiket\r\n• Memberikan feedback: +15 poin per tiket\r\n\r\nTukar poin dengan voucher di Dashboard!', '2026-05-22 22:04:06', '2026-05-22 22:04:06'),
(10, 3, 'admin', 'okkay kak', '2026-06-11 18:47:54', '2026-06-11 18:47:54'),
(11, 4, 'bot', 'Selamat datang, charles. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.\n\n*(Catatan: Layanan admin aktif pada jam kerja pukul 08:00 - 15:00. Di luar jam kerja tersebut, pertanyaan akan dijawab otomatis oleh chatbot).*', '2026-06-15 18:16:45', '2026-06-15 18:16:45'),
(12, 5, 'bot', 'Selamat datang, jenny. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.\n\n(Catatan: Layanan admin aktif pada jam kerja pukul 08:00 - 15:00. Di luar jam kerja tersebut, pertanyaan akan dijawab otomatis oleh chatbot).', '2026-06-15 18:18:12', '2026-06-15 18:18:12'),
(13, 6, 'bot', 'Selamat datang, Budi Santoso. Terima kasih telah menghubungi Wismilak.\n\nSaya asisten virtual yang siap membantu Anda mengenai:\n\n- Event dan Registrasi\n- Tiket dan Pembayaran\n- Voucher dan Diskon\n- Produk dan Outlet\n- Reward dan Poin\n\nSilakan ketik topik yang ingin ditanyakan, atau ketik \"admin\" untuk terhubung langsung dengan tim layanan kami.\n\n(Catatan: Layanan admin aktif pada jam kerja pukul 08:00 - 15:00. Di luar jam kerja tersebut, pertanyaan akan dijawab otomatis oleh chatbot).', '2026-06-23 16:07:53', '2026-06-23 16:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `mode` varchar(255) NOT NULL DEFAULT 'bot',
  `assigned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `needs_admin` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_sessions`
--

INSERT INTO `chat_sessions` (`id`, `name`, `email`, `status`, `mode`, `assigned_at`, `created_at`, `updated_at`, `needs_admin`, `user_id`) VALUES
(1, 'Customer Test', 'customer@wismilak.com', 'open', 'bot', NULL, '2026-05-17 19:58:51', '2026-05-17 19:58:51', 0, 13),
(2, 'Admin Wismilak', 'admin@wismilak.com', 'closed', 'bot', NULL, '2026-05-19 10:13:42', '2026-06-23 16:03:50', 0, 1),
(3, 'Customer Test', 'customer@example.com', 'closed', 'bot', NULL, '2026-05-22 21:31:14', '2026-06-23 16:03:41', 0, 10),
(4, 'charles', 'charles@example.com', 'open', 'bot', NULL, '2026-06-15 18:16:45', '2026-06-15 18:16:45', 0, 14),
(5, 'jenny', 'jenny@gmail.com', 'open', 'bot', NULL, '2026-06-15 18:18:12', '2026-06-15 18:18:12', 0, 15),
(6, 'Budi Santoso', 'budi@example.com', 'open', 'bot', NULL, '2026-06-23 16:07:53', '2026-06-23 16:07:53', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `chat_topics`
--

CREATE TABLE `chat_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `response` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `is_escalation` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_topics`
--

INSERT INTO `chat_topics` (`id`, `keyword`, `response`, `category`, `is_escalation`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'halo', 'Halo! 👋 Selamat datang di Wismilak. Ada yang bisa saya bantu?\n\nAnda bisa bertanya tentang:\n• Event & Registrasi\n• Tiket & Pembayaran\n• Voucher & Diskon\n• Produk & Outlet\n• Reward & Poin\n\nAtau ketik \"admin\" untuk bicara langsung dengan tim kami.', 'greeting', 0, 0, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32'),
(2, 'hello', 'Hello! 👋 Welcome to Wismilak. How can I help you?', 'greeting', 0, 1, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32'),
(3, 'hi', 'Hi! 👋 Ada yang bisa saya bantu hari ini?', 'greeting', 0, 2, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32'),
(4, 'event', 'Untuk melihat event terbaru:\r\n1. Buka menu Event di navbar\r\n2. Pilih Calendar View atau Event List\r\n3. Klik event untuk detail & registrasi\r\n\r\nSetiap event memiliki kuota terbatas, jadi daftar sekarang!', 'event', 0, 3, 1, '2026-04-27 12:52:32', '2026-05-19 06:50:00'),
(5, 'daftar', 'Cara mendaftar event:\r\n1. Buka halaman event yang diminati\r\n2. Klik \"Register Now\"\r\n3. Isi data peserta\r\n4. Gunakan voucher jika ada\r\n5. Lanjutkan ke pembayaran', 'event', 0, 4, 1, '2026-04-27 12:52:32', '2026-05-19 06:49:34'),
(6, 'tiket', 'Informasi tiket:\r\n• Tiket otomatis dibuat setelah pembayaran sukses\r\n• Download tiket PDF dari halaman Riwayat Transaksi\r\n• Tiket memiliki QR code untuk check-in di event', 'ticket', 0, 5, 1, '2026-04-27 12:52:32', '2026-05-19 06:48:42'),
(7, 'bayar', 'Informasi pembayaran:\r\n• Pembayaran melalui Midtrans (transfer bank, e-wallet, dll)\r\n• Batas waktu pembayaran: 30 menit\r\n• Status otomatis terupdate setelah pembayaran', 'payment', 0, 6, 1, '2026-04-27 12:52:32', '2026-05-19 06:50:26'),
(8, 'voucher', 'Tentang voucher:\r\n• Tukar poin Anda dengan voucher di Dashboard\r\n• Gunakan kode voucher saat registrasi event\r\n• Cek masa berlaku voucher sebelum digunakan', 'voucher', 0, 7, 1, '2026-04-27 12:52:32', '2026-05-19 06:48:28'),
(9, 'poin', 'Cara mendapatkan poin:\r\n• Registrasi event gratis: +5 poin\r\n• Pembayaran event: +10 poin per tiket\r\n• Memberikan feedback: +15 poin per tiket\r\n\r\nTukar poin dengan voucher di Dashboard!', 'reward', 0, 8, 1, '2026-04-27 12:52:32', '2026-05-19 06:48:54'),
(10, 'produk', 'Lihat koleksi premium kami di menu Collection.\r\nSetiap produk memiliki detail spesifikasi lengkap.', 'product', 0, 9, 1, '2026-04-27 12:52:32', '2026-05-19 06:49:24'),
(11, 'outlet', 'Temukan outlet terdekat di menu Find Us.\r\nSetiap outlet memiliki alamat, jam operasional, dan peta lokasi.', 'outlet', 0, 10, 1, '2026-04-27 12:52:32', '2026-05-19 06:50:15'),
(12, 'feedback', 'Tentang feedback:\r\n• Berikan feedback setelah semua tiket di check-in\r\n• Dapatkan +15 poin per tiket\r\n• Rating 1-5 bintang + komentar', 'feedback', 0, 11, 1, '2026-04-27 12:52:32', '2026-05-19 06:49:09'),
(13, 'checkin', 'Informasi check-in:\r\n• Tunjukkan tiket PDF/QR code saat datang ke event\r\n• Staff akan scan QR code Anda\r\n• Check-in wajib untuk mendapatkan poin feedback', 'checkin', 0, 12, 1, '2026-04-27 12:52:32', '2026-04-28 08:35:27'),
(14, 'admin', '🔄 Saya akan menghubungkan Anda dengan admin. Mohon tunggu sebentar...', 'escalation', 1, 13, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32'),
(15, 'bantuan', '🔄 Saya akan menghubungkan Anda dengan admin. Mohon tunggu sebentar...', 'escalation', 1, 14, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32'),
(16, 'help', '🔄 I will connect you with our admin. Please wait...', 'escalation', 1, 15, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32'),
(17, 'komplain', '🔄 Kami akan menghubungkan Anda dengan admin untuk menangani keluhan Anda.', 'escalation', 1, 16, 1, '2026-04-27 12:52:32', '2026-04-27 12:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `customer_profiles`
--

CREATE TABLE `customer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_profiles`
--

INSERT INTO `customer_profiles` (`id`, `user_id`, `phone`, `date_of_birth`, `city`, `gender`, `preferences`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 5, '081223075434', '1976-04-22', 'Jakarta', 'male', NULL, NULL, '2026-04-22 07:59:45', '2026-04-22 07:59:45'),
(2, 6, '081255537878', '1984-04-22', 'Bandung', 'female', NULL, NULL, '2026-04-22 07:59:46', '2026-04-22 07:59:46'),
(3, 7, '081216120175', '1984-04-22', 'Surabaya', 'male', NULL, NULL, '2026-04-22 07:59:46', '2026-04-22 07:59:46'),
(4, 8, '081266165856', '1979-04-22', 'Medan', 'female', NULL, NULL, '2026-04-22 07:59:47', '2026-04-22 07:59:47'),
(5, 9, '081249296926', '1991-04-22', 'Yogyakarta', 'male', NULL, NULL, '2026-04-22 07:59:47', '2026-04-22 07:59:47'),
(6, 10, '081232780628', '1982-04-22', 'Jakarta', 'male', NULL, NULL, '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(7, 11, '081234567890', '1990-11-11', 'Jakarta', 'male', NULL, NULL, '2026-05-17 16:58:11', '2026-05-17 16:58:11'),
(8, 12, '081234567890', '2000-10-10', 'Jakarta', 'female', NULL, NULL, '2026-05-17 17:49:09', '2026-05-17 17:49:09'),
(9, 13, '08123456789', '1990-01-01', 'Jakarta', 'female', NULL, NULL, '2026-05-17 18:53:24', '2026-05-17 18:53:24'),
(10, 14, '081234567890', '2004-10-27', 'Surabaya', 'male', NULL, NULL, '2026-05-30 14:23:33', '2026-05-30 14:23:33'),
(11, 15, '08123456789', '2000-10-10', 'Surabaya', 'female', NULL, NULL, '2026-06-03 11:45:17', '2026-06-03 11:45:17'),
(12, 16, '08123456789', '2000-10-10', 'Jakarta', 'male', NULL, NULL, '2026-06-03 11:53:25', '2026-06-03 11:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `quota` int(11) DEFAULT 0,
  `remaining_quota` int(11) DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'upcoming',
  `price_type` enum('free','paid') NOT NULL DEFAULT 'free',
  `price` int(11) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `published_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(255) DEFAULT NULL,
  `is_all_outlets` tinyint(1) NOT NULL DEFAULT 0,
  `created_by_role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `date`, `location`, `quota`, `remaining_quota`, `created_by`, `created_at`, `updated_at`, `description`, `image`, `status`, `price_type`, `price`, `is_verified`, `verification_status`, `rejection_reason`, `approved_by`, `published_by`, `approved_at`, `published_at`, `start_time`, `end_time`, `contact_person_name`, `contact_person_phone`, `is_all_outlets`, `created_by_role`) VALUES
(1, 'Wismilak Premium Cigar Evening', '2026-05-22', 'Grand Ballroom Hotel Indonesia, Jakarta', 100, 94, 1, '2026-04-22 08:06:36', '2026-06-15 17:58:30', 'An exclusive evening of premium cigars, whiskey pairing, and jazz music.', 'events/ritWXtWJY665Vcg5MavsNDPx0tCIWdefGza25P0U.jpg', 'completed', 'paid', 250000, 0, 'approved', NULL, NULL, 1, NULL, '2026-05-30 18:30:37', '19:00:00', '21:00:00', 'Admin', '082133968080', 0, NULL),
(2, 'Tobacco Masterclass Surabaya', '2026-05-07', 'Surabaya Convention Center', 50, 48, 3, '2026-04-22 08:06:36', '2026-06-11 19:52:41', 'Pelajari seni menikmati cerutu premium bersama master tobacconist.', 'events/d9DTiQRWUmnfDpXXi1TvRPzvarrTi39kAopQQQ88.jpg', 'approved', 'paid', 150000, 0, 'approved', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(3, 'Free Wismilak Tasting Session', '2026-04-29', 'Wismilak Lounge, Bandung', 30, 28, 1, '2026-04-22 08:06:36', '2026-06-15 17:58:30', 'Sesi tasting gratis untuk memperkenalkan lini premium terbaru.', NULL, 'completed', 'free', 0, 0, 'approved', NULL, NULL, 1, NULL, '2026-05-19 06:45:54', NULL, NULL, NULL, NULL, 0, NULL),
(4, 'Bali Sunset Cigar Experience', '2026-06-06', 'Seminyak Beach Club, Bali', 40, 37, 4, '2026-04-22 08:06:36', '2026-06-15 17:58:30', 'Nikmati cerutu premium sambil menyaksikan sunset di Seminyak.', 'events/4qxLAHGnZM8Iwff3oSRx0G5Q3zBQkRAcEnJNz9tW.jpg', 'completed', 'paid', 350000, 0, 'approved', NULL, NULL, 1, NULL, '2026-05-30 18:32:19', '16:00:00', '23:59:00', 'Admin', '08123456789', 0, NULL),
(5, 'Partner Event Nusantara 2026', '2026-06-20', 'Jakarta Convention Center', 80, 80, 3, '2026-04-22 08:06:36', '2026-05-19 09:21:55', 'Partner Event Nusantara 2026 merupakan sebuah cigar event eksklusif yang menghadirkan pengalaman premium bagi para pecinta cerutu, komunitas, pelaku industri lifestyle, serta partner brand dalam suasana yang elegan dan berkelas. Event ini menjadi wadah untuk menikmati cigar experience melalui berbagai aktivitas seperti cigar tasting, cigar pairing session, networking lounge, live entertainment, hingga showcase produk premium dan lifestyle.', 'events/TOs2Awr50fQPbBKT2LubTCRPA4iXin6u17SIq5A3.jpg', 'rejected', 'paid', 200000, 0, 'rejected', 'belum sesuai', 1, NULL, '2026-05-10 17:03:38', NULL, '16:00:00', '22:00:00', 'Tony', '08123456789', 0, NULL),
(6, 'Sunset Wine & Cigar', '2026-06-14', 'One Deck Gastropub', 100, 98, 3, '2026-05-10 17:42:57', '2026-06-15 17:58:30', 'Sunset wine & cigar with cigar winetasting and grant burge', 'events/psI2IhV5vnrRVhVs3TxZypdWEwlyVzFWUTM30CSW.jpg', 'completed', 'paid', 99998, 0, 'approved', NULL, 1, 1, '2026-05-19 06:45:46', '2026-05-30 16:03:49', '16:00:00', '21:00:00', 'Admin', '0812345678', 0, 'partner'),
(7, 'Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience', '2026-06-27', 'Jakarta', 50, 47, 1, '2026-05-22 21:39:48', '2026-06-24 14:47:04', 'Whisky & Cigar Night merupakan acara eksklusif yang menghadirkan pengalaman menikmati whisky premium Tamnavulin bersama Wismilak Cigar dalam suasana malam yang elegan dan santai. Event ini dirancang untuk memberikan pengalaman refined pours, slow moments, dan indulgence after dark bagi para pengunjung. Tersedia juga complimentary cigar experience secara terbatas untuk peserta.', 'events/Gjt5UHsM2mfME5HjYtRpQ7P73evtk09ZIkZVbJSq.jpg', 'published', 'paid', 150000, 0, 'approved', NULL, 1, 1, '2026-05-22 21:40:39', '2026-05-30 15:48:11', '16:00:00', '22:00:00', 'Admin', '08123456789', 0, '{\"id\":1,\"name\":\"admin\",\"created_at\":\"2026-04-22T07:59:42.000000Z\",\"updated_at\":\"2026-04-22T07:59:42.000000Z\"}'),
(8, 'Harmony of Tasty', '2026-06-29', 'Surabaya', 40, 40, 1, '2026-06-23 15:39:13', '2026-06-23 15:39:13', 'Harmony of Tasty merupakan event tasting eksklusif yang menghadirkan pengalaman menikmati dinner, wine tasting, dan cigar dalam suasana premium. Customer dapat menikmati rangkaian tasting session, networking, serta pengalaman cigar lounge yang elegan bersama Wismilak Cigars.', 'events/s5FZg1czdo0YFSyShzzQUVnMdATroXtwldtaWTfm.jpg', 'approved', 'paid', 150000, 0, 'approved', NULL, NULL, NULL, NULL, NULL, '16:00:00', '22:00:00', 'Admin Hensman', '0811320079', 0, '{\"id\":1,\"name\":\"admin\",\"created_at\":\"2026-04-22T07:59:42.000000Z\",\"updated_at\":\"2026-04-22T07:59:42.000000Z\"}'),
(9, 'Cigar of The Week', '2026-06-30', 'Cavaro Golf Course', 25, 22, 1, '2026-06-23 15:42:19', '2026-06-23 16:50:06', 'Cigar of The Week merupakan event weekly cigar experience yang memperkenalkan rekomendasi cigar pilihan dari Wismilak Premium Cigars. Customer dapat menikmati suasana lounge premium, mengenal karakter produk Seleccion Corona, serta berdiskusi seputar cigar bersama komunitas.', 'events/DnnimtQSDy1ANNYqVVaSqNViahk5kvnMthzg4ndT.png', 'published', 'free', NULL, 0, 'approved', NULL, NULL, 1, NULL, '2026-06-23 15:53:37', '20:00:00', '12:00:00', 'Admin', '082130297815', 0, '{\"id\":1,\"name\":\"admin\",\"created_at\":\"2026-04-22T07:59:42.000000Z\",\"updated_at\":\"2026-04-22T07:59:42.000000Z\"}'),
(10, 'Pandawa 007', '2026-07-23', 'Jakarta', 5, 4, 3, '2026-06-23 15:47:46', '2026-06-23 17:11:10', 'Pandawa 007 merupakan event fun poker competition yang dikolaborasikan bersama Wismilak Cigars. Event ini menghadirkan suasana permainan santai, cigar experience, serta coffee selection untuk memberikan pengalaman premium dan eksklusif kepada peserta.', 'events/arUA1YuKKSKqN46kmszbYzFkhDUrU8zId4knNlgS.png', 'published', 'paid', 200000, 0, 'approved', NULL, 1, 1, '2026-06-23 15:53:20', '2026-06-23 15:53:41', '17:00:00', '23:30:00', 'Charles', '08123456789', 0, 'partner'),
(11, 'Fun Night Cigar', '2026-07-05', 'Orchid Business Center Blok D No.3, Bali', 20, 20, 3, '2026-06-23 15:57:18', '2026-06-23 16:03:00', 'Fun Night Cigar merupakan event santai bertema cigar night yang menghadirkan live show rolling cigar experience dan lomba cigar competition. Peserta dapat belajar proses pembuatan cerutu secara langsung, mengikuti kompetisi, serta menikmati suasana komunitas cigar bersama Wismilak Cigars.', 'events/msq7ZoxyHfxOU3jeOowko1vw2Yz8xpoPRqRNw34u.png', 'rejected', 'paid', 120000, 0, 'rejected', 'Data event yang diajukan belum lengkap, sehingga belum dapat diverifikasi oleh admin', 1, NULL, '2026-06-23 16:03:00', NULL, '15:00:00', '22:00:00', 'Sandy', '08123456789', 0, 'partner'),
(12, 'New Clasico Series', '2026-07-10', 'Area Bar & Resto', 50, 50, 3, '2026-06-23 16:00:09', '2026-06-23 16:00:09', 'New Clasico Series merupakan event pengenalan produk Wismilak Clasico Series yang menghadirkan pengalaman belajar seni rolling cigar dari expert. Event ini ditujukan untuk customer yang ingin mengenal proses pembuatan cerutu, menikmati suasana santai, dan mencoba pengalaman cigar secara langsung.', 'events/NZRe7LD5IhdxjKdntrFa4b4ynj4dzUj6ziQ0ahrB.jpg', 'draft', 'paid', 300000, 0, 'pending', NULL, NULL, NULL, NULL, NULL, '16:00:00', '12:00:00', 'Tony', '0812345678', 0, 'partner');

-- --------------------------------------------------------

--
-- Table structure for table `event_checkins`
--

CREATE TABLE `event_checkins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `points_awarded` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_checkins`
--

INSERT INTO `event_checkins` (`id`, `ticket_id`, `user_id`, `event_id`, `checked_in_at`, `points_awarded`, `created_at`, `updated_at`) VALUES
(1, 6, 10, 2, '2026-04-22 17:11:15', 10, '2026-04-22 17:11:15', '2026-04-22 17:11:15'),
(2, 7, 10, 2, '2026-04-27 14:56:14', 10, '2026-04-27 14:56:14', '2026-04-27 14:56:14'),
(3, 20, 10, 9, '2026-06-23 16:59:16', 10, '2026-06-23 16:59:16', '2026-06-23 16:59:16'),
(4, 21, 5, 10, '2026-06-23 17:29:02', 10, '2026-06-23 17:29:02', '2026-06-23 17:29:02'),
(5, 18, 5, 9, '2026-06-24 15:02:23', 10, '2026-06-24 15:02:23', '2026-06-24 15:02:23'),
(6, 22, 5, 7, '2026-06-24 15:03:00', 10, '2026-06-24 15:03:00', '2026-06-24 15:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_feedbacks`
--

CREATE TABLE `event_feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `points_awarded` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_feedbacks`
--

INSERT INTO `event_feedbacks` (`id`, `event_id`, `user_id`, `rating`, `comment`, `image`, `points_awarded`, `created_at`, `updated_at`) VALUES
(1, 2, 10, 5, 'bagus banget pelayanan semuanyaa, rekomen deh kalian semua harus dateng kesini', 'feedback_images/y3UovrXURy2N5oJD463d52obNY7nFnFWCixensfw.jpg', 30, '2026-04-27 14:57:19', '2026-05-30 14:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `event_outlets`
--

CREATE TABLE `event_outlets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `location_detail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_outlets`
--

INSERT INTO `event_outlets` (`id`, `event_id`, `outlet_id`, `location_detail`) VALUES
(1, 5, 1, 'VIP Lounge'),
(2, 4, 5, '-'),
(3, 7, 1, 'Lantai 2'),
(4, 8, 3, 'Jl. Tunjungan No.20, Surabaya'),
(5, 9, 5, '1917 Heritage Dago Golf Course, Lower Ground Floor'),
(6, 10, 1, 'VIP Lounge'),
(7, 11, 5, 'Cigar Thing’s Orchid Business Center'),
(8, 12, 1, '69 Bar & Resto');

-- --------------------------------------------------------

--
-- Table structure for table `event_packages`
--

CREATE TABLE `event_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_packages`
--

INSERT INTO `event_packages` (`id`, `event_id`, `title`, `description`) VALUES
(1, 1, '1 Wismillak Cigar, Selection beverage (Americano/Capp, caffelate), Free Fresh roll  Cigarete', NULL),
(8, 6, 'Grant Burge Classic Collection', NULL),
(9, 5, '- Premium Cigar Experience', NULL),
(10, 5, '- Cigar Pairing Session', NULL),
(11, 5, '- Networking Lounge', NULL),
(12, 4, 'Special Offer : Buy any selection of macallan by bottle and get 4 pcs Fresh Cigar Roll and Sweet & Spice Platter', NULL),
(13, 7, 'Special Offer : Buy any selection of macallan by bottle and get 4 pcs Fresh Cigar Roll and Sweet & Spice Platter', NULL),
(14, 8, 'Dinner, wine tasting, cigar experience, dan akses networking session.', NULL),
(15, 9, 'Cigar introduction, product knowledge session, lounge experience, dan networking bersama komunitas cigar.', NULL),
(16, 10, 'Fun poker competition, Clasico series cigars, coffee selection, dan limited attendee experience.', NULL),
(17, 11, '1 cigar Wismilak, Coke Zero free flow, live rolling cigar experience, dan akses lomba cigar competition.', NULL),
(18, 12, 'Cigar rolling demo, product introduction, cigar experience, dan sharing session bersama expert.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `ticket_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `snap_token` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voucher_redemption_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `ktp_number` varchar(255) DEFAULT NULL,
  `ktp_file` varchar(255) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `reward_redemption_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`id`, `event_id`, `user_id`, `quantity`, `ticket_price`, `total_amount`, `status`, `snap_token`, `payment_status`, `created_at`, `updated_at`, `voucher_redemption_id`, `expired_at`, `full_name`, `phone`, `ktp_number`, `ktp_file`, `payment_proof`, `reward_redemption_id`) VALUES
(1, 1, 5, 1, 250000.00, 250000.00, 'pending', NULL, 'paid', '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, '2026-05-22 08:06:37', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 7, 1, 250000.00, 250000.00, 'pending', NULL, 'paid', '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, '2026-05-22 08:06:37', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 10, 1, 250000.00, 250000.00, 'pending', NULL, 'paid', '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, '2026-05-22 08:06:37', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 3, 6, 1, 0.00, 0.00, 'pending', NULL, 'paid', '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, '2026-04-29 08:06:37', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 3, 8, 1, 0.00, 0.00, 'pending', NULL, 'paid', '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, '2026-04-29 08:06:37', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 10, 2, 150000.00, 270000.00, 'pending', 'c262947a-9c83-4e1d-810a-5fa652b644f5', 'paid', '2026-04-22 08:50:26', '2026-04-22 08:51:40', 2, '2026-04-22 09:20:26', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 4, 10, 1, 350000.00, 350000.00, 'pending', '2708a963-0c8f-4a90-874d-1a1b7a2a21ed', 'paid', '2026-04-28 08:09:09', '2026-04-28 08:09:49', NULL, '2026-04-28 08:39:09', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 4, 5, 2, 350000.00, 630000.00, 'pending', 'ca3140eb-12ad-45e8-9b21-d545cf3ad1c2', 'paid', '2026-05-15 16:36:01', '2026-05-15 16:37:14', 1, '2026-05-15 17:06:01', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 11, 2, 250000.00, 500000.00, 'pending', '0b643541-6312-4cac-a071-bf4d9098e1ba', 'paid', '2026-05-17 17:02:49', '2026-05-17 17:03:19', NULL, '2026-05-17 17:32:49', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 10, 1, 250000.00, 250000.00, 'pending', '23f8d1b9-a711-4a93-ac2d-4312b7244f6b', 'paid', '2026-05-17 17:10:22', '2026-05-17 17:10:47', NULL, '2026-05-17 17:40:22', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 6, 10, 2, 99998.00, 199996.00, 'pending', 'fa49aaa5-2f36-45d8-8907-cbae7f3e95fe', 'paid', '2026-05-22 21:34:08', '2026-05-22 21:34:48', NULL, '2026-05-22 22:04:08', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 7, 14, 1, 150000.00, 150000.00, 'pending', 'df4bab5d-c926-45cb-bddb-03d0efab9fb9', 'paid', '2026-05-30 18:50:58', '2026-05-30 18:51:51', NULL, '2026-05-30 19:20:58', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 7, 10, 1, 150000.00, 135000.00, 'pending', 'ec1afef5-13cd-4f30-877b-458cd04b1431', 'paid', '2026-06-11 18:44:39', '2026-06-11 18:45:27', 3, '2026-06-11 19:14:39', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 9, 5, 2, 0.00, 0.00, 'pending', NULL, 'paid', '2026-06-23 16:10:29', '2026-06-23 16:10:29', 5, '2026-06-23 16:40:29', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 9, 10, 1, 0.00, 0.00, 'pending', NULL, 'paid', '2026-06-23 16:50:05', '2026-06-23 16:50:06', NULL, '2026-06-23 17:20:05', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 10, 5, 1, 200000.00, 200000.00, 'pending', 'a0245005-ac10-40fd-a517-68ee3204fbeb', 'paid', '2026-06-23 17:08:24', '2026-06-23 17:11:10', NULL, '2026-06-23 17:38:24', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 7, 5, 1, 150000.00, 150000.00, 'pending', '9b61a39f-709c-47cd-bb97-bd89e4fd18e2', 'paid', '2026-06-24 14:45:40', '2026-06-24 14:47:04', NULL, '2026-06-24 15:15:40', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_tickets`
--

CREATE TABLE `event_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `ktp_number` varchar(255) NOT NULL,
  `ktp_file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_tickets`
--

INSERT INTO `event_tickets` (`id`, `registration_id`, `full_name`, `email`, `phone`, `date_of_birth`, `ktp_number`, `ktp_file`, `created_at`, `updated_at`) VALUES
(1, 6, 'charles', 'char@gmail.com', '0812345678', '2000-10-10', '1234567888888888', 'ktp/Pry22Of6hgjtB6uAKkPcZOzSJZxUp5G3v1SFmHhL.jpg', '2026-04-22 08:50:28', '2026-04-22 08:50:28'),
(2, 6, 'jenny', 'jenn@gmail.com', '08123456789', '2000-10-10', '1234567888888888', 'ktp/FFyPvRl8nq0UyugoLRo3fa0EUQaMv8F2Aywei4O1.jpg', '2026-04-22 08:50:28', '2026-04-22 08:50:28'),
(3, 7, 'jenny', 'jenny@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/ItljaZiwvYKl7sol4OwEGqNUSJmREWS1BP26auQF.jpg', '2026-04-28 08:09:09', '2026-04-28 08:09:09'),
(4, 8, 'sani', 'sani@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/uGanr8Ls3SYiCx0nxRGsABXCw5HKV1eDQ4LYnYt2.png', '2026-05-15 16:36:03', '2026-05-15 16:36:03'),
(5, 8, 'aliyy', 'aliyy@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/dojjBJR9jNcjhjUqUM23xcugLuOrPtEBFKL5gtH0.png', '2026-05-15 16:36:03', '2026-05-15 16:36:03'),
(6, 9, 'Test User', 'testuser@example.com', '081234567890', '1990-11-11', '1234567890123456', 'ktp/Q8km644zihlJr0TnuGBRycf1OhGDst6Ia2DabZpG.jpg', '2026-05-17 17:02:49', '2026-05-17 17:02:49'),
(7, 9, 'lia', 'lia@gmail.com', '08123456789', '2000-10-10', '1234567888888888', 'ktp/zm7HZujrzPkqK5Zq7z1A1aQo29H1bADWWKkLJW3Z.jpg', '2026-05-17 17:02:49', '2026-05-17 17:02:49'),
(8, 10, 'bebe', 'bebe@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/4p0zPTNCUUZIceOYwjLfczGJCVt09tZkvN2NuV01.jpg', '2026-05-17 17:10:22', '2026-05-17 17:10:22'),
(9, 11, 'louvre', 'lou@gmail.com', '0812345678', '2000-02-02', '1234567891011123', 'ktp/BEgCQUmtTZvPTCQpPOx9Lnd8Q0pAPSl31Fyf5lhi.png', '2026-05-22 21:34:08', '2026-05-22 21:34:08'),
(10, 11, 'bobo', 'boo@gmail.com', '0812345678', '2003-10-05', '1234567891011123', 'ktp/tzd9vXf4fJsIwqyspyiujNSAYPfCdOgsCAHNwTxD.jpg', '2026-05-22 21:34:08', '2026-05-22 21:34:08'),
(11, 12, 'jenny', 'jenny@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/vh2CSMadxb43foxYUFFXc2a4l3ux6f5YBFvo1m5z.jpg', '2026-05-30 18:50:58', '2026-05-30 18:50:58'),
(12, 13, 'nanda', 'nanda@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/tedvw0GPw9in4lmYqd9zwRa0WzJqkcBRAnslfNeA.png', '2026-06-11 18:44:40', '2026-06-11 18:44:40'),
(13, 14, 'jenny', 'jenny@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/yvsELVg2SOOMjt7CRYwHr1QYW3r6cYvflgeRnMr2.jpg', '2026-06-23 16:10:29', '2026-06-23 16:10:29'),
(14, 14, 'tara', 'tara@gmail.com', '0812345678', '2003-02-01', '1234567891011123', 'ktp/zN41GaKsd5p51G7VegcquhpwS3oF2aBJM9nVSg9a.jpg', '2026-06-23 16:10:29', '2026-06-23 16:10:29'),
(15, 15, 'alya', 'lou@gmail.com', '0812345678', '2000-10-10', '1234567891011123', 'ktp/WLlMWozFFlrwBFHCWLzAiZSI8OffBCZJHo6NKkFP.jpg', '2026-06-23 16:50:06', '2026-06-23 16:50:06'),
(16, 16, 'jenny', 'jenny@gmail.com', '0812345678', '2003-01-02', '1234567891011123', 'ktp/v5nYKlkJJfJSiQihGcuWXpEPLa2te3CKuU9gwzmv.jpg', '2026-06-23 17:08:24', '2026-06-23 17:08:24'),
(17, 17, 'nanda', 'nanda@gmail.com', '0812345678', '2003-10-10', '1234567891011123', 'ktp/1DXoCcLIzbk6T12XE848ay7b5BbuxUwlsvA1dgNL.jpg', '2026-06-24 14:45:42', '2026-06-24 14:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `category` enum('event','promo') DEFAULT NULL,
  `status` enum('tampil','sembunyi') NOT NULL DEFAULT 'tampil',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `image`, `caption`, `category`, `status`, `created_at`, `updated_at`) VALUES
(1, 'gallery/ixRCPsA87E14dr5awJWFM1ksg9Etz5tmtbdtUAJE.jpg', 'Event Upcoming', 'event', 'tampil', '2026-04-22 17:17:55', '2026-04-22 17:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `instagram_posts`
--

CREATE TABLE `instagram_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instagram_posts`
--

INSERT INTO `instagram_posts` (`id`, `image_path`, `instagram_url`, `caption`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'instagram/LRzzp0L5zAAzaRPiCT7xiDpuQqnC1NCZNZnI93OG.jpg', 'https://www.instagram.com/p/DWuvBCxCeVA/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 'It’s the weekend. You’ve got a Wismilak in one hand and nothing to do. What’s the playlist? 💨 Drop your top track.', 1, 'active', '2026-04-27 14:46:14', '2026-05-19 10:09:14'),
(2, 'instagram/qAOztmDewcM2WjLDIVZ2AZpRZNeeixtI0lZFUFtk.png', 'https://www.instagram.com/p/DV-d5gCiYq1/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 'Work hard, smoke smooth. This is my version of balance. The Exotic Taste of Indonesia', 2, 'active', '2026-04-28 07:54:02', '2026-05-19 10:08:48'),
(3, 'instagram/qHsKF0RUXsm94BdgdnmJ8H6rhILRdR6HVJCp1dz0.jpg', 'https://www.instagram.com/p/DVvkxxHCVKc/', 'Late nights, deep thoughts, and the slow burn of a Wismilak Clasico\r\n.\r\n\"Crafted by Tradition, Perfect by Passion”\r\n.\r\nLet\'s your journey begin, Ignite greatness with every draw-clasico series, where passion meets perfection', 3, 'active', '2026-05-19 10:08:26', '2026-05-19 10:08:26'),
(4, 'instagram/Azz7ZKYzRYnhZbCPnvWasTzfZzURDCROYNBpXOuE.png', 'https://www.instagram.com/p/DVc8b_bAClD/', 'Not just a cigar. It’s a statement. Nikmati pilihan Mix 10 Wismilak Cigar favorit Anda\r\ndan dapatkan Premium Cigar Ashtray – FREE.', 4, 'active', '2026-05-19 10:11:03', '2026-05-19 10:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"4421f739-1884-4b48-a04a-ee13f92f6bb9\",\"displayName\":\"App\\\\Mail\\\\MediaInquiryAutoReply\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:30:\\\"App\\\\Mail\\\\MediaInquiryAutoReply\\\":3:{s:7:\\\"inquiry\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MediaInquiry\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:27:\\\"maheswari@urbanlifestyle.id\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1779955000,\"delay\":null}', 0, NULL, 1779955000, 1779955000),
(2, 'default', '{\"uuid\":\"28c3ff65-09ae-4c48-baee-384d4e1b2791\",\"displayName\":\"App\\\\Mail\\\\MediaInquiryNotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\MediaInquiryNotifyAdmin\\\":3:{s:7:\\\"inquiry\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MediaInquiry\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"admin@wismilakcigars.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1779955000,\"delay\":null}', 0, NULL, 1779955000, 1779955000),
(3, 'default', '{\"uuid\":\"98812141-dff5-4b22-9b00-90dcd6cdc3a0\",\"displayName\":\"App\\\\Mail\\\\MediaInquiryAutoReply\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:30:\\\"App\\\\Mail\\\\MediaInquiryAutoReply\\\":3:{s:7:\\\"inquiry\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MediaInquiry\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:30:\\\"aditya.pratama@mediadigital.id\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1780152476,\"delay\":null}', 0, NULL, 1780152477, 1780152477),
(4, 'default', '{\"uuid\":\"338e8051-c136-4e3c-8785-91d009b2460b\",\"displayName\":\"App\\\\Mail\\\\MediaInquiryNotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\MediaInquiryNotifyAdmin\\\":3:{s:7:\\\"inquiry\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MediaInquiry\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"admin@wismilakcigars.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1780152477,\"delay\":null}', 0, NULL, 1780152477, 1780152477),
(5, 'default', '{\"uuid\":\"2f474298-f4d6-4950-9597-9675a02ebe4d\",\"displayName\":\"App\\\\Mail\\\\MediaInquiryReplyMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:30:\\\"App\\\\Mail\\\\MediaInquiryReplyMail\\\":4:{s:7:\\\"inquiry\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MediaInquiry\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"replyMessage\\\";s:640:\\\"Halo Bapak Aditya Pratama,\\r\\n\\r\\nTerima kasih telah menghubungi Wismilak Cigars melalui media inquiry. Kami sangat mengapresiasi ketertarikan Bapak terhadap peluang kerja sama media dan publikasi bersama Wismilak Cigars.\\r\\n\\r\\nTerkait informasi mengenai event, press release, maupun kegiatan terbaru, tim kami akan meninjau terlebih dahulu detail inquiry yang telah Bapak sampaikan. Selanjutnya, kami akan menghubungi Bapak kembali melalui email untuk memberikan informasi lebih lanjut mengenai bentuk kerja sama yang memungkinkan.\\r\\n\\r\\nTerima kasih atas perhatian dan ketertarikannya terhadap Wismilak Cigars.\\r\\n\\r\\nSalam hormat,\\r\\nTim Wismilak Cigars\\\";s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:30:\\\"aditya.pratama@mediadigital.id\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1780152654,\"delay\":null}', 0, NULL, 1780152654, 1780152654);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager_profiles`
--

CREATE TABLE `manager_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manager_profiles`
--

INSERT INTO `manager_profiles` (`id`, `user_id`, `department`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 'avatars/svm8zCwTY9F2ynLE6nQTZaovmklt5ZRCzA5PMd7L.png', '2026-05-28 08:10:25', '2026-05-28 08:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `media_inquiries`
--

CREATE TABLE `media_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `inquiry_type` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_inquiries`
--

INSERT INTO `media_inquiries` (`id`, `name`, `email`, `phone`, `organization`, `subject`, `inquiry_type`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Rania Maheswari', 'maheswari@urbanlifestyle.id', '081234567890', 'Urban Lifestyle Magazine', 'Permohonan Kerja Sama Liputan Event Wismilak Cigars', 'Media Partnership', 'Halo Tim Wismilak Cigars,\r\n\r\nSaya Rania dari Urban Lifestyle Magazine ingin mengajukan kerja sama media partnership untuk peliputan kegiatan Wismilak Cigars, khususnya event cigar tasting session dan product launching yang akan diselenggarakan. Kami tertarik untuk membuat artikel publikasi mengenai pengalaman event, informasi produk, serta brand story Wismilak Cigars sebagai salah satu produk cerutu premium di Indonesia.\r\n\r\nKami berharap dapat memperoleh informasi lebih lanjut mengenai jadwal event, ketentuan peliputan, serta kemungkinan kerja sama publikasi melalui media digital kami. Terima kasih atas perhatian dan kesempatan yang diberikan.\r\n\r\nHormat saya,\r\nRania Maheswari\r\nUrban Lifestyle Magazine', 1, '2026-05-28 07:56:35', '2026-05-30 14:57:05'),
(2, 'Aditya Pratama', 'aditya.pratama@mediadigital.id', '081234567890', 'Media Digital Indonesia', 'Permohonan Informasi Kerja Sama Media dengan Wismilak Cigars', 'Collaboration', 'Halo Tim Wismilak Cigars, saya Aditya Pratama dari Media Digital Indonesia ingin mengajukan pertanyaan terkait peluang kerja sama media dan publikasi dengan Wismilak Cigars. Kami tertarik untuk mengetahui informasi lebih lanjut mengenai event, press release, serta kegiatan terbaru yang dapat dipublikasikan kepada audiens kami. Terima kasih.', 1, '2026-05-30 14:47:56', '2026-05-30 14:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `media_inquiry_replies`
--

CREATE TABLE `media_inquiry_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `media_inquiry_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_inquiry_replies`
--

INSERT INTO `media_inquiry_replies` (`id`, `media_inquiry_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 2, 'Halo Bapak Aditya Pratama,\r\n\r\nTerima kasih telah menghubungi Wismilak Cigars melalui media inquiry. Kami sangat mengapresiasi ketertarikan Bapak terhadap peluang kerja sama media dan publikasi bersama Wismilak Cigars.\r\n\r\nTerkait informasi mengenai event, press release, maupun kegiatan terbaru, tim kami akan meninjau terlebih dahulu detail inquiry yang telah Bapak sampaikan. Selanjutnya, kami akan menghubungi Bapak kembali melalui email untuk memberikan informasi lebih lanjut mengenai bentuk kerja sama yang memungkinkan.\r\n\r\nTerima kasih atas perhatian dan ketertarikannya terhadap Wismilak Cigars.\r\n\r\nSalam hormat,\r\nTim Wismilak Cigars', '2026-05-30 14:50:54', '2026-05-30 14:50:54'),
(2, 1, 'Halo Ibu Rania Maheswari,\r\n\r\nTerima kasih telah menghubungi Wismilak Cigars dan menyampaikan ketertarikan Urban Lifestyle Magazine untuk melakukan kerja sama media partnership.\r\n\r\nKami sangat mengapresiasi rencana peliputan terkait kegiatan Wismilak Cigars, khususnya event cigar tasting session, product launching, informasi produk, serta brand story Wismilak Cigars. Terkait permohonan tersebut, tim kami akan melakukan peninjauan terlebih dahulu terhadap jadwal event dan ketentuan peliputan yang tersedia.\r\n\r\nSelanjutnya, kami akan menghubungi Ibu melalui email untuk memberikan informasi lebih lanjut mengenai peluang kerja sama, jadwal kegiatan, serta kebutuhan publikasi yang dapat disesuaikan dengan media Urban Lifestyle Magazine.\r\n\r\nTerima kasih atas perhatian dan ketertarikannya terhadap Wismilak Cigars.\r\n\r\nSalam hormat,\r\nTim Wismilak Cigars', '2026-05-30 14:54:42', '2026-05-30 14:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_25_171252_create_roles_table', 1),
(5, '2026_01_25_171301_create_events_table', 1),
(6, '2026_01_25_184622_add_role_id_to_users_table', 1),
(7, '2026_01_25_225652_add_fields_to_events_table', 1),
(8, '2026_02_02_103909_add_is_verified_to_events_table', 1),
(9, '2026_02_02_104354_create_event_registrations_table', 1),
(10, '2026_02_02_114306_add_verification_status_to_events_table', 1),
(11, '2026_02_04_020611_add_rejection_reason_to_events_table', 1),
(12, '2026_02_04_034052_add_detail_to_event_registrations_table', 1),
(13, '2026_02_04_042611_create_galleries_table', 1),
(14, '2026_02_04_172030_create_products_table', 1),
(15, '2026_02_04_180036_add_specifications_to_products_table', 1),
(16, '2026_02_04_181155_add_images_to_products_table', 1),
(17, '2026_02_04_182358_create_pressrooms_table', 1),
(18, '2026_02_08_161345_create_outlets_table', 1),
(19, '2026_02_08_172228_add_status_to_users_table', 1),
(20, '2026_02_08_180717_create_user_points_table', 1),
(21, '2026_02_08_180739_create_rewards_table', 1),
(22, '2026_02_08_180757_create_reward_redemptions_table', 1),
(23, '2026_02_08_183821_add_image_to_rewards_table', 1),
(24, '2026_02_11_060907_create_chat_sessions_table', 1),
(25, '2026_02_11_061638_create_chat_messages_table', 1),
(26, '2026_02_12_045323_add_needs_admin_to_chat_sessions_table', 1),
(27, '2026_02_12_071701_create_pages_table', 1),
(28, '2026_02_19_054106_create_media_inquiries_table', 1),
(29, '2026_02_19_071608_create_media_inquiry_replies_table', 1),
(30, '2026_02_20_213212_add_customer_fields_to_users_table', 1),
(31, '2026_02_20_215359_refactor_event_registrations_table', 1),
(32, '2026_02_20_215406_create_event_tickets_table', 1),
(33, '2026_02_20_230939_update_payment_status_on_event_registrations', 1),
(34, '2026_02_20_231938_add_remaining_quota_to_events_table', 1),
(35, '2026_02_20_232732_add_expired_at_to_event_registrations', 1),
(36, '2026_02_23_100000_create_customer_profiles_table', 1),
(37, '2026_02_23_100001_create_admin_profiles_table', 1),
(38, '2026_02_23_100002_create_partner_profiles_table', 1),
(39, '2026_02_23_100003_create_manager_profiles_table', 1),
(40, '2026_02_23_100010_add_approval_workflow_to_events_table', 1),
(41, '2026_02_23_100011_create_transactions_table', 1),
(42, '2026_02_23_100012_create_vouchers_table', 1),
(43, '2026_02_23_100013_create_voucher_redemptions_table', 1),
(44, '2026_02_23_100020_add_user_id_and_mode_to_chat_sessions', 1),
(45, '2026_03_03_192912_create_page_sections_table', 1),
(46, '2026_03_03_193330_create_tickets_table', 1),
(47, '2026_03_03_194138_add_columns_to_event_registrations', 1),
(48, '2026_03_03_195229_create_personal_access_tokens_table', 1),
(49, '2026_03_03_212356_update_voucher_redemptions_table', 1),
(50, '2026_03_03_212707_add_voucher_redemption_id_to_event_registrations_table', 1),
(51, '2026_03_30_100000_expand_system_tables', 1),
(52, '2026_03_30_100001_fix_missing_columns', 1),
(53, '2026_03_31_125609_add_participant_fields_to_tickets_table', 1),
(54, '2026_04_01_120337_add_image_to_event_feedbacks_table', 1),
(55, '2026_04_07_031911_add_fields_to_media_inquiries_table', 1),
(56, '2026_04_07_102813_add_inquiry_type_to_media_inquiries_table', 1),
(57, '2026_04_08_185727_add_event_extra_fields', 1),
(58, '2026_04_08_185753_create_event_outlets_table', 1),
(59, '2026_04_08_185810_create_event_packages_table', 1),
(60, '2026_04_08_201935_create_partner_outlets_table', 1),
(61, '2026_04_09_100000_adjust_column_types', 1),
(62, '2026_04_22_100000_add_max_discount_to_vouchers', 1),
(63, '2026_04_27_100000_create_outlet_products_table', 2),
(64, '2026_04_27_100001_create_instagram_posts_table', 2),
(65, '2026_04_27_100002_create_chat_topics_table', 2),
(67, '2026_05_05_000000_note_bigint_to_int_standardization', 3),
(68, '2026_05_23_000001_create_notifications_table', 3),
(69, '2026_05_23_000002_add_avatar_to_admin_and_manager_profiles', 3),
(70, '2026_06_24_140800_add_reward_redemption_id_to_event_registrations_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications_custom`
--

CREATE TABLE `notifications_custom` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'system',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications_custom`
--

INSERT INTO `notifications_custom` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 10, 'Pembayaran Menunggu', 'Pendaftaran event \"Sunset Wine & Cigar\" berhasil diajukan. Silakan selesaikan pembayaran.', 'transaction', 0, '2026-05-22 21:34:09', '2026-05-22 21:34:09'),
(2, 1, 'Pendaftaran Event (Pending)', 'Customer Customer Test mengajukan pendaftaran untuk event \"Sunset Wine & Cigar\" (Pending).', 'event', 0, '2026-05-22 21:34:09', '2026-05-22 21:34:09'),
(3, 10, 'Pembayaran Sukses', 'Pembayaran Anda sebesar Rp199.996 untuk event \"Sunset Wine & Cigar\" telah berhasil diterima. Tiket Anda aktif.', 'transaction', 0, '2026-05-22 21:34:48', '2026-05-22 21:34:48'),
(4, 1, 'Pembayaran Sukses (Admin)', 'Pembayaran tiket event \"Sunset Wine & Cigar\" oleh customer Customer Test telah diverifikasi.', 'transaction', 0, '2026-05-22 21:34:48', '2026-05-22 21:34:48'),
(5, 3, 'Tiket Terjual', 'Tiket event \"Sunset Wine & Cigar\" Anda telah dibeli oleh Customer Test.', 'transaction', 0, '2026-05-22 21:34:48', '2026-05-22 21:34:48'),
(6, 1, 'Event Baru Dibuat', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dibuat.', 'event', 0, '2026-05-22 21:39:48', '2026-05-22 21:39:48'),
(7, 2, 'Persetujuan Event Diperlukan', 'Event baru \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" membutuhkan verifikasi dan persetujuan.', 'event', 0, '2026-05-22 21:39:48', '2026-05-22 21:39:48'),
(8, 1, 'Profil Diperbarui', 'Profil Anda berhasil diperbarui.', 'profile', 0, '2026-05-22 21:42:21', '2026-05-22 21:42:21'),
(9, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-22 21:46:30', '2026-05-22 21:46:30'),
(10, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-22 21:46:30', '2026-05-22 21:46:30'),
(11, 3, 'Event Dipublikasikan', 'Event \"Tobacco Masterclass Surabaya\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-22 22:05:05', '2026-05-22 22:05:05'),
(12, 2, 'Event Dipublikasikan', 'Event \"Tobacco Masterclass Surabaya\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-22 22:05:05', '2026-05-22 22:05:05'),
(13, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-22 22:05:11', '2026-05-22 22:05:11'),
(14, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-22 22:05:11', '2026-05-22 22:05:11'),
(15, 1, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-22 22:05:18', '2026-05-22 22:05:18'),
(16, 2, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-22 22:05:18', '2026-05-22 22:05:18'),
(17, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-28 05:35:52', '2026-05-28 05:35:52'),
(18, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-28 05:35:52', '2026-05-28 05:35:52'),
(19, 1, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-28 05:35:56', '2026-05-28 05:35:56'),
(20, 2, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-28 05:35:56', '2026-05-28 05:35:56'),
(21, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-28 05:36:46', '2026-05-28 05:36:46'),
(22, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-28 05:36:46', '2026-05-28 05:36:46'),
(23, 1, 'Event Diperbarui', 'Event \"Bali Sunset Cigar Experience\" telah diperbarui.', 'event', 0, '2026-05-28 07:24:15', '2026-05-28 07:24:15'),
(24, 2, 'Event Diperbarui', 'Event \"Bali Sunset Cigar Experience\" telah diperbarui oleh Admin.', 'event', 0, '2026-05-28 07:24:15', '2026-05-28 07:24:15'),
(25, 4, 'Event Dipublikasikan', 'Event \"Bali Sunset Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-28 07:24:26', '2026-05-28 07:24:26'),
(26, 2, 'Event Dipublikasikan', 'Event \"Bali Sunset Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-28 07:24:26', '2026-05-28 07:24:26'),
(27, 1, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-28 07:50:06', '2026-05-28 07:50:06'),
(28, 2, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-28 07:50:06', '2026-05-28 07:50:06'),
(29, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-28 07:50:30', '2026-05-28 07:50:30'),
(30, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-28 07:50:30', '2026-05-28 07:50:30'),
(31, 3, 'Profil Diperbarui', 'Profil Anda berhasil diperbarui.', 'profile', 0, '2026-05-28 08:00:36', '2026-05-28 08:00:36'),
(32, 2, 'Profil Diperbarui', 'Profil Anda berhasil diperbarui.', 'profile', 0, '2026-05-28 08:10:25', '2026-05-28 08:10:25'),
(33, 1, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 14:52:31', '2026-05-30 14:52:31'),
(34, 2, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 14:52:31', '2026-05-30 14:52:31'),
(35, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 14:52:35', '2026-05-30 14:52:35'),
(36, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 14:52:35', '2026-05-30 14:52:35'),
(37, 3, 'Event Dipublikasikan', 'Event \"Tobacco Masterclass Surabaya\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 14:52:43', '2026-05-30 14:52:43'),
(38, 2, 'Event Dipublikasikan', 'Event \"Tobacco Masterclass Surabaya\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 14:52:43', '2026-05-30 14:52:43'),
(39, 1, 'Event Diperbarui', 'Event \"Sunset Wine & Cigar\" telah diperbarui.', 'event', 0, '2026-05-30 15:47:07', '2026-05-30 15:47:07'),
(40, 2, 'Event Diperbarui', 'Event \"Sunset Wine & Cigar\" telah diperbarui oleh Admin.', 'event', 0, '2026-05-30 15:47:07', '2026-05-30 15:47:07'),
(41, 1, 'Event Diperbarui', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah diperbarui.', 'event', 0, '2026-05-30 15:48:03', '2026-05-30 15:48:03'),
(42, 2, 'Event Diperbarui', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah diperbarui oleh Admin.', 'event', 0, '2026-05-30 15:48:03', '2026-05-30 15:48:03'),
(43, 1, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 15:48:11', '2026-05-30 15:48:11'),
(44, 2, 'Event Dipublikasikan', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 15:48:11', '2026-05-30 15:48:11'),
(45, 1, 'Event Diperbarui', 'Event \"Sunset Wine & Cigar\" telah diperbarui.', 'event', 0, '2026-05-30 16:03:42', '2026-05-30 16:03:42'),
(46, 2, 'Event Diperbarui', 'Event \"Sunset Wine & Cigar\" telah diperbarui oleh Admin.', 'event', 0, '2026-05-30 16:03:42', '2026-05-30 16:03:42'),
(47, 3, 'Event Dipublikasikan', 'Event \"Sunset Wine & Cigar\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 16:03:49', '2026-05-30 16:03:49'),
(48, 2, 'Event Dipublikasikan', 'Event \"Sunset Wine & Cigar\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 16:03:49', '2026-05-30 16:03:49'),
(49, 1, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 18:30:37', '2026-05-30 18:30:37'),
(50, 2, 'Event Dipublikasikan', 'Event \"Wismilak Premium Cigar Evening\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 18:30:37', '2026-05-30 18:30:37'),
(51, 3, 'Event Dipublikasikan', 'Event \"Tobacco Masterclass Surabaya\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 18:30:42', '2026-05-30 18:30:42'),
(52, 2, 'Event Dipublikasikan', 'Event \"Tobacco Masterclass Surabaya\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 18:30:42', '2026-05-30 18:30:42'),
(53, 1, 'Event Diperbarui', 'Event \"Bali Sunset Cigar Experience\" telah diperbarui.', 'event', 0, '2026-05-30 18:32:09', '2026-05-30 18:32:09'),
(54, 2, 'Event Diperbarui', 'Event \"Bali Sunset Cigar Experience\" telah diperbarui oleh Admin.', 'event', 0, '2026-05-30 18:32:09', '2026-05-30 18:32:09'),
(55, 4, 'Event Dipublikasikan', 'Event \"Bali Sunset Cigar Experience\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-05-30 18:32:19', '2026-05-30 18:32:19'),
(56, 2, 'Event Dipublikasikan', 'Event \"Bali Sunset Cigar Experience\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-05-30 18:32:19', '2026-05-30 18:32:19'),
(57, 14, 'Pembayaran Menunggu', 'Pendaftaran event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" berhasil diajukan. Silakan selesaikan pembayaran.', 'transaction', 0, '2026-05-30 18:51:00', '2026-05-30 18:51:00'),
(58, 1, 'Pendaftaran Event (Pending)', 'Customer charles mengajukan pendaftaran untuk event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" (Pending).', 'event', 0, '2026-05-30 18:51:00', '2026-05-30 18:51:00'),
(59, 14, 'Pembayaran Sukses', 'Pembayaran Anda sebesar Rp150.000 untuk event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah berhasil diterima. Tiket Anda aktif.', 'transaction', 0, '2026-05-30 18:51:51', '2026-05-30 18:51:51'),
(60, 1, 'Pembayaran Sukses (Admin)', 'Pembayaran tiket event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" oleh customer charles telah diverifikasi.', 'transaction', 0, '2026-05-30 18:51:51', '2026-05-30 18:51:51'),
(61, 1, 'Tiket Terjual', 'Tiket event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah dibeli oleh charles.', 'transaction', 0, '2026-05-30 18:51:51', '2026-05-30 18:51:51'),
(62, 14, 'Update Status/Akses Akun', 'Status atau peran akun Anda telah diperbarui oleh Admin. Status aktif: Active', 'verification', 0, '2026-06-03 11:40:33', '2026-06-03 11:40:33'),
(63, 10, 'Penukaran Voucher Sukses', 'Anda telah menukarkan voucher \'Selamat Datang\' seharga 100 poin.', 'voucher', 0, '2026-06-11 18:43:04', '2026-06-11 18:43:04'),
(64, 1, 'Penukaran Voucher Baru', 'Customer Customer Test menukarkan voucher \'Selamat Datang\'.', 'voucher', 0, '2026-06-11 18:43:04', '2026-06-11 18:43:04'),
(65, 10, 'Pembayaran Menunggu', 'Pendaftaran event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" berhasil diajukan. Silakan selesaikan pembayaran.', 'transaction', 0, '2026-06-11 18:44:42', '2026-06-11 18:44:42'),
(66, 1, 'Pendaftaran Event (Pending)', 'Customer Customer Test mengajukan pendaftaran untuk event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" (Pending).', 'event', 0, '2026-06-11 18:44:42', '2026-06-11 18:44:42'),
(67, 10, 'Pembayaran Sukses', 'Pembayaran Anda sebesar Rp135.000 untuk event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah berhasil diterima. Tiket Anda aktif.', 'transaction', 0, '2026-06-11 18:45:28', '2026-06-11 18:45:28'),
(68, 1, 'Pembayaran Sukses (Admin)', 'Pembayaran tiket event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" oleh customer Customer Test telah diverifikasi.', 'transaction', 0, '2026-06-11 18:45:28', '2026-06-11 18:45:28'),
(69, 1, 'Tiket Terjual', 'Tiket event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah dibeli oleh Customer Test.', 'transaction', 0, '2026-06-11 18:45:28', '2026-06-11 18:45:28'),
(70, 10, 'Balasan Chat Admin', 'Admin telah membalas chat Anda: \"okkay kak\"', 'chat', 0, '2026-06-11 18:47:54', '2026-06-11 18:47:54'),
(71, 1, 'Event Diperbarui', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah diperbarui.', 'event', 0, '2026-06-15 17:51:31', '2026-06-15 17:51:31'),
(72, 2, 'Event Diperbarui', 'Event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah diperbarui oleh Admin.', 'event', 0, '2026-06-15 17:51:31', '2026-06-15 17:51:31'),
(73, 10, 'Penukaran Voucher Sukses', 'Anda telah menukarkan voucher \'Selamat Datang\' seharga 100 poin.', 'voucher', 0, '2026-06-15 18:12:55', '2026-06-15 18:12:55'),
(74, 1, 'Penukaran Voucher Baru', 'Customer Customer Test menukarkan voucher \'Selamat Datang\'.', 'voucher', 0, '2026-06-15 18:12:55', '2026-06-15 18:12:55'),
(75, 5, 'Penukaran Voucher Sukses', 'Anda telah menukarkan voucher \'First Event 100K\' seharga 150 poin.', 'voucher', 0, '2026-06-23 14:08:12', '2026-06-23 14:08:12'),
(76, 1, 'Penukaran Voucher Baru', 'Customer Budi Santoso menukarkan voucher \'First Event 100K\'.', 'voucher', 0, '2026-06-23 14:08:12', '2026-06-23 14:08:12'),
(77, 1, 'Event Baru Dibuat', 'Event \"Harmony of Tasty\" telah dibuat.', 'event', 0, '2026-06-23 15:39:13', '2026-06-23 15:39:13'),
(78, 2, 'Persetujuan Event Diperlukan', 'Event baru \"Harmony of Tasty\" membutuhkan verifikasi dan persetujuan.', 'event', 0, '2026-06-23 15:39:13', '2026-06-23 15:39:13'),
(79, 1, 'Event Baru Dibuat', 'Event \"Cigar of The Week\" telah dibuat.', 'event', 0, '2026-06-23 15:42:19', '2026-06-23 15:42:19'),
(80, 2, 'Persetujuan Event Diperlukan', 'Event baru \"Cigar of The Week\" membutuhkan verifikasi dan persetujuan.', 'event', 0, '2026-06-23 15:42:19', '2026-06-23 15:42:19'),
(81, 3, 'Event Disetujui', 'Event \"Pandawa 007\" Anda telah disetujui.', 'verification', 0, '2026-06-23 15:53:20', '2026-06-23 15:53:20'),
(82, 2, 'Event Disetujui', 'Event \"Pandawa 007\" telah disetujui oleh Admin Wismilak.', 'verification', 0, '2026-06-23 15:53:20', '2026-06-23 15:53:20'),
(83, 1, 'Event Dipublikasikan', 'Event \"Cigar of The Week\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-06-23 15:53:37', '2026-06-23 15:53:37'),
(84, 2, 'Event Dipublikasikan', 'Event \"Cigar of The Week\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-06-23 15:53:37', '2026-06-23 15:53:37'),
(85, 3, 'Event Dipublikasikan', 'Event \"Pandawa 007\" Anda telah resmi dipublikasikan!', 'event', 0, '2026-06-23 15:53:41', '2026-06-23 15:53:41'),
(86, 2, 'Event Dipublikasikan', 'Event \"Pandawa 007\" telah dipublikasikan oleh Admin Wismilak.', 'event', 0, '2026-06-23 15:53:41', '2026-06-23 15:53:41'),
(87, 3, 'Event Ditolak', 'Event \"Fun Night Cigar\" Anda ditolak. Alasan: Data event yang diajukan belum lengkap, sehingga belum dapat diverifikasi oleh admin', 'verification', 0, '2026-06-23 16:03:00', '2026-06-23 16:03:00'),
(88, 2, 'Event Ditolak', 'Event \"Fun Night Cigar\" telah ditolak oleh Admin Wismilak.', 'verification', 0, '2026-06-23 16:03:00', '2026-06-23 16:03:00'),
(89, 10, 'Sesi Chat Ditutup', 'Sesi chat Anda telah ditutup oleh admin. Terima kasih telah menghubungi kami.', 'chat', 0, '2026-06-23 16:03:41', '2026-06-23 16:03:41'),
(90, 1, 'Sesi Chat Ditutup', 'Sesi chat Anda telah ditutup oleh admin. Terima kasih telah menghubungi kami.', 'chat', 0, '2026-06-23 16:03:50', '2026-06-23 16:03:50'),
(91, 5, 'Pendaftaran Event Sukses', 'Registrasi gratis untuk event \"Cigar of The Week\" berhasil. Tiket Anda telah diterbitkan.', 'event', 0, '2026-06-23 16:10:29', '2026-06-23 16:10:29'),
(92, 1, 'Pendaftaran Event Baru (Gratis)', 'Customer Budi Santoso mendaftar gratis untuk event \"Cigar of The Week\".', 'event', 0, '2026-06-23 16:10:29', '2026-06-23 16:10:29'),
(93, 1, 'Tiket Terjual (Gratis)', 'Customer Budi Santoso mendaftar gratis untuk event \"Cigar of The Week\".', 'event', 0, '2026-06-23 16:10:29', '2026-06-23 16:10:29'),
(94, 10, 'Pendaftaran Event Sukses', 'Registrasi gratis untuk event \"Cigar of The Week\" berhasil. Tiket Anda telah diterbitkan.', 'event', 0, '2026-06-23 16:50:06', '2026-06-23 16:50:06'),
(95, 1, 'Pendaftaran Event Baru (Gratis)', 'Customer Customer Test mendaftar gratis untuk event \"Cigar of The Week\".', 'event', 0, '2026-06-23 16:50:06', '2026-06-23 16:50:06'),
(96, 1, 'Tiket Terjual (Gratis)', 'Customer Customer Test mendaftar gratis untuk event \"Cigar of The Week\".', 'event', 0, '2026-06-23 16:50:06', '2026-06-23 16:50:06'),
(97, 5, 'Pembayaran Menunggu', 'Pendaftaran event \"Pandawa 007\" berhasil diajukan. Silakan selesaikan pembayaran.', 'transaction', 0, '2026-06-23 17:08:26', '2026-06-23 17:08:26'),
(98, 1, 'Pendaftaran Event (Pending)', 'Customer Budi Santoso mengajukan pendaftaran untuk event \"Pandawa 007\" (Pending).', 'event', 0, '2026-06-23 17:08:26', '2026-06-23 17:08:26'),
(99, 5, 'Pembayaran Sukses', 'Pembayaran Anda sebesar Rp200.000 untuk event \"Pandawa 007\" telah berhasil diterima. Tiket Anda aktif.', 'transaction', 0, '2026-06-23 17:11:10', '2026-06-23 17:11:10'),
(100, 1, 'Pembayaran Sukses (Admin)', 'Pembayaran tiket event \"Pandawa 007\" oleh customer Budi Santoso telah diverifikasi.', 'transaction', 0, '2026-06-23 17:11:10', '2026-06-23 17:11:10'),
(101, 3, 'Tiket Terjual', 'Tiket event \"Pandawa 007\" Anda telah dibeli oleh Budi Santoso.', 'transaction', 0, '2026-06-23 17:11:10', '2026-06-23 17:11:10'),
(102, 5, 'Penukaran Reward Sukses', 'Anda telah menukarkan reward \'Cigar Cutter Premium\' seharga 148 poin. Status: Pending.', 'reward', 0, '2026-06-24 13:57:30', '2026-06-24 13:57:30'),
(103, 1, 'Penukaran Reward Baru', 'Customer Budi Santoso menukarkan reward \'Cigar Cutter Premium\'.', 'reward', 0, '2026-06-24 13:57:30', '2026-06-24 13:57:30'),
(104, 5, 'Pembayaran Menunggu', 'Pendaftaran event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" berhasil diajukan. Silakan selesaikan pembayaran.', 'transaction', 0, '2026-06-24 14:45:47', '2026-06-24 14:45:47'),
(105, 1, 'Pendaftaran Event (Pending)', 'Customer Budi Santoso mengajukan pendaftaran untuk event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" (Pending).', 'event', 0, '2026-06-24 14:45:47', '2026-06-24 14:45:47'),
(106, 5, 'Pembayaran Sukses', 'Pembayaran Anda sebesar Rp150.000 untuk event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" telah berhasil diterima. Tiket Anda aktif.', 'transaction', 0, '2026-06-24 14:47:06', '2026-06-24 14:47:06'),
(107, 1, 'Pembayaran Sukses (Admin)', 'Pembayaran tiket event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" oleh customer Budi Santoso telah diverifikasi.', 'transaction', 0, '2026-06-24 14:47:06', '2026-06-24 14:47:06'),
(108, 1, 'Tiket Terjual', 'Tiket event \"Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\" Anda telah dibeli oleh Budi Santoso.', 'transaction', 0, '2026-06-24 14:47:06', '2026-06-24 14:47:06'),
(109, 5, 'Check-in Berhasil', 'Check-in Anda untuk event \'Cigar of The Week\' berhasil. Selamat, Anda mendapatkan +10 poin loyalty!', 'event', 0, '2026-06-24 15:02:23', '2026-06-24 15:02:23'),
(110, 1, 'Check-in Peserta Baru', 'Peserta \'jenny\' telah berhasil melakukan check-in untuk event \'Cigar of The Week\' Anda.', 'event', 0, '2026-06-24 15:02:23', '2026-06-24 15:02:23'),
(111, 5, 'Check-in Berhasil', 'Check-in Anda untuk event \'Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\' berhasil. Selamat, Anda mendapatkan +10 poin loyalty!', 'event', 0, '2026-06-24 15:03:00', '2026-06-24 15:03:00'),
(112, 1, 'Check-in Peserta Baru', 'Peserta \'nanda\' telah berhasil melakukan check-in untuk event \'Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience\' Anda.', 'event', 0, '2026-06-24 15:03:00', '2026-06-24 15:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE `outlets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `region` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outlets`
--

INSERT INTO `outlets` (`id`, `name`, `address`, `region`, `city`, `latitude`, `longitude`, `phone`, `opening_hours`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sudirman Premium Lounge', 'Jl. Jend. Sudirman No. 1', 'Jakarta', 'Jakarta', -6.2088000, 106.8456000, '0217467108', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(2, 'Senayan Cigar Gallery', 'Plaza Senayan Lt. 2', 'Jakarta', 'Jakarta', -6.2184000, 106.7980000, '0213047295', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(3, 'Tunjungan Cigar Lounge', 'Jl. Tunjungan No. 12', 'Surabaya', 'Surabaya', -7.2575000, 112.7378000, '0216972830', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(4, 'Braga Tobacco House', 'Jl. Braga No. 45', 'Bandung', 'Bandung', -6.9175000, 107.6191000, '0218288411', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(5, 'Seminyak Premium Lounge', 'Jl. Kayu Aya No. 8', 'Bali', 'Bali', -8.6906000, 115.1576000, '0216502080', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(6, 'Simalungun Cigars', 'Jl. Gatot Subroto No. 21', 'Medan', 'Medan', 3.5952000, 98.6722000, '0216958267', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(7, 'Malioboro Cigar House', 'Jl. Malioboro No. 77', 'Yogyakarta', 'Yogyakarta', -7.7956000, 110.3695000, '0214503665', NULL, 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `outlet_products`
--

CREATE TABLE `outlet_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outlet_products`
--

INSERT INTO `outlet_products` (`id`, `outlet_id`, `product_id`, `is_available`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '2026-04-27 13:18:23', '2026-04-28 08:33:19'),
(2, 2, 1, 1, NULL, '2026-04-27 13:18:40', '2026-05-19 10:05:41'),
(3, 1, 2, 0, NULL, '2026-04-28 08:33:19', '2026-04-28 08:33:19'),
(4, 2, 2, 1, NULL, '2026-05-19 10:05:41', '2026-05-19 10:05:41'),
(5, 2, 3, 1, NULL, '2026-05-19 10:05:41', '2026-05-19 10:05:41'),
(6, 3, 1, 1, NULL, '2026-05-19 10:05:49', '2026-05-19 10:07:11'),
(7, 5, 2, 1, NULL, '2026-05-19 10:05:58', '2026-05-19 10:07:17'),
(8, 5, 1, 0, NULL, '2026-05-19 10:05:58', '2026-05-19 10:07:17'),
(9, 7, 2, 1, NULL, '2026-05-19 10:06:06', '2026-05-19 10:06:06'),
(10, 6, 1, 0, NULL, '2026-05-19 10:06:15', '2026-05-19 10:06:15'),
(11, 6, 3, 1, NULL, '2026-05-19 10:06:15', '2026-05-19 10:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_sections`
--

CREATE TABLE `page_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partner_outlets`
--

CREATE TABLE `partner_outlets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partner_outlets`
--

INSERT INTO `partner_outlets` (`id`, `partner_id`, `outlet_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL),
(2, 4, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 4, 4, NULL, NULL),
(5, 3, 5, NULL, NULL),
(6, 4, 6, NULL, NULL),
(7, 4, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partner_profiles`
--

CREATE TABLE `partner_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `business_description` text DEFAULT NULL,
  `business_license` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partner_profiles`
--

INSERT INTO `partner_profiles` (`id`, `user_id`, `company_name`, `company_address`, `contact_person`, `phone`, `business_description`, `business_license`, `logo`, `created_at`, `updated_at`) VALUES
(1, 3, 'PT Nusantara Tobacco', NULL, 'PT Nusantara Tobacco', '081234000047', NULL, NULL, 'avatars/uAvvGsotMguxZm6ZOWDoWEndnyNhjykHpoi3cd2B.png', '2026-04-22 07:59:44', '2026-05-28 08:00:36'),
(2, 4, 'Cigar House Jakarta', NULL, 'Cigar House Jakarta', '081234000095', NULL, NULL, NULL, '2026-04-22 07:59:45', '2026-04-22 07:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `point_histories`
--

CREATE TABLE `point_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `points` int(11) NOT NULL,
  `type` enum('earn','spend') NOT NULL,
  `source` varchar(255) NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_histories`
--

INSERT INTO `point_histories` (`id`, `user_id`, `points`, `type`, `source`, `reference_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 5, 10, 'earn', 'event_registration', 1, 'Tiket event: Wismilak Premium Cigar Evening', '2026-04-22 08:06:37', '2026-04-22 08:06:37'),
(2, 7, 10, 'earn', 'event_registration', 2, 'Tiket event: Wismilak Premium Cigar Evening', '2026-04-22 08:06:37', '2026-04-22 08:06:37'),
(3, 10, 10, 'earn', 'event_registration', 3, 'Tiket event: Wismilak Premium Cigar Evening', '2026-04-22 08:06:37', '2026-04-22 08:06:37'),
(4, 10, 100, 'spend', 'voucher_redemption', 1, 'Tukar voucher: Selamat Datang', '2026-04-22 08:48:29', '2026-04-22 08:48:29'),
(5, 10, 20, 'earn', 'event_payment', 6, 'Reward tiket event: Tobacco Masterclass Surabaya', '2026-04-22 08:51:40', '2026-04-22 08:51:40'),
(6, 10, 10, 'earn', 'checkin', 6, 'Check-in event: Tobacco Masterclass Surabaya', '2026-04-22 17:11:15', '2026-04-22 17:11:15'),
(7, 10, 10, 'earn', 'checkin', 7, 'Check-in event: Tobacco Masterclass Surabaya', '2026-04-27 14:56:14', '2026-04-27 14:56:14'),
(8, 10, 30, 'earn', 'feedback', 2, 'Feedback event: Tobacco Masterclass Surabaya (2 tiket)', '2026-04-27 14:57:19', '2026-04-27 14:57:19'),
(9, 10, 10, 'earn', 'event_payment', 7, 'Reward tiket event: Bali Sunset Cigar Experience', '2026-04-28 08:09:51', '2026-04-28 08:09:51'),
(10, 5, 20, 'earn', 'event_payment', 8, 'Reward tiket event: Bali Sunset Cigar Experience', '2026-05-15 16:37:15', '2026-05-15 16:37:15'),
(11, 11, 20, 'earn', 'event_payment', 9, 'Reward tiket event: Wismilak Premium Cigar Evening', '2026-05-17 17:03:20', '2026-05-17 17:03:20'),
(12, 10, 10, 'earn', 'event_payment', 10, 'Reward tiket event: Wismilak Premium Cigar Evening', '2026-05-17 17:10:47', '2026-05-17 17:10:47'),
(13, 10, 20, 'earn', 'event_payment', 11, 'Reward tiket event: Sunset Wine & Cigar', '2026-05-22 21:34:48', '2026-05-22 21:34:48'),
(14, 14, 10, 'earn', 'event_payment', 12, 'Reward tiket event: Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience', '2026-05-30 18:51:51', '2026-05-30 18:51:51'),
(15, 10, 100, 'spend', 'voucher_redemption', 1, 'Tukar voucher: Selamat Datang', '2026-06-11 18:43:03', '2026-06-11 18:43:03'),
(16, 10, 10, 'earn', 'event_payment', 13, 'Reward tiket event: Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience', '2026-06-11 18:45:28', '2026-06-11 18:45:28'),
(17, 10, 100, 'spend', 'voucher_redemption', 1, 'Tukar voucher: Selamat Datang', '2026-06-15 18:12:55', '2026-06-15 18:12:55'),
(18, 5, 150, 'spend', 'voucher_redemption', 5, 'Tukar voucher: First Event 100K', '2026-06-23 14:08:12', '2026-06-23 14:08:12'),
(19, 5, 10, 'earn', 'event_registration', 14, 'Event: Cigar of The Week', '2026-06-23 16:10:29', '2026-06-23 16:10:29'),
(20, 10, 5, 'earn', 'event_registration', 15, 'Event: Cigar of The Week', '2026-06-23 16:50:06', '2026-06-23 16:50:06'),
(21, 10, 10, 'earn', 'checkin', 20, 'Check-in event: Cigar of The Week', '2026-06-23 16:59:16', '2026-06-23 16:59:16'),
(22, 5, 10, 'earn', 'event_payment', 16, 'Reward tiket event: Pandawa 007', '2026-06-23 17:11:10', '2026-06-23 17:11:10'),
(23, 5, 10, 'earn', 'checkin', 21, 'Check-in event: Pandawa 007', '2026-06-23 17:29:02', '2026-06-23 17:29:02'),
(24, 5, 148, 'spend', 'reward_redemption', 1, 'Tukar merchandise: Cigar Cutter Premium', '2026-06-24 13:57:30', '2026-06-24 13:57:30'),
(25, 5, 10, 'earn', 'event_payment', 17, 'Reward tiket event: Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience', '2026-06-24 14:47:06', '2026-06-24 14:47:06'),
(26, 5, 10, 'earn', 'checkin', 18, 'Check-in event: Cigar of The Week', '2026-06-24 15:02:23', '2026-06-24 15:02:23'),
(27, 5, 10, 'earn', 'checkin', 22, 'Check-in event: Whisky & Cigar Night: A Tamnavulin Whisky x Wismilak Cigar Experience', '2026-06-24 15:03:00', '2026-06-24 15:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `pressrooms`
--

CREATE TABLE `pressrooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `published_at` date DEFAULT NULL,
  `status` enum('draft','publish') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pressrooms`
--

INSERT INTO `pressrooms` (`id`, `title`, `slug`, `image`, `excerpt`, `content`, `published_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 'HOW TO SELECT, SMOKE AND ENJOY HAND ROLLED CIGARS', 'how-to-select-smoke-and-enjoy-hand-rolled-cigars', 'pressroom/l7eFJvg0Z38MT3yks0i3YE0xRk5q40JHhYuM38v4.jpg', 'If you’re ready to join the ranks of cigar smokers, here is how to get started', 'If you’re ready to join the ranks of cigar smokers, here is how to get started. The first step is If you’re ready to join the ranks of cigar smokers, here is how to get started. The first step is If you’re ready to join the ranks of cigar smokers, here is how to get started. The first step is If you’re ready to join the ranks of cigar smokers, here is how to get started. The first step is ... Continue reading', '2026-10-03', 'publish', '2026-04-22 17:23:41', '2026-04-22 17:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_main` varchar(255) NOT NULL,
  `image_detail` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `genome` varchar(255) DEFAULT NULL,
  `assembly` varchar(255) DEFAULT NULL,
  `varietal` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `wrapper` varchar(255) DEFAULT NULL,
  `filler` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image_main`, `image_detail`, `short_description`, `description`, `weight`, `genome`, `assembly`, `varietal`, `size`, `wrapper`, `filler`, `profile`, `origin`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PREMIUM CIGAR ROBUSTO GLASSTUBE', 'products/fmLn1cnExJhKexp1u5LkI1EVZD464VCpmiaKPWlG.jpg', 'products/CGQeAFGt4iphtavLsfCIj1Cdg57zYL2W8tLncT22.jpg', 'Premium Cigar Robusto Glasstube a Cigar with combination from the world famous Connecticut', 'a Cigar with combination from the world famous Connecticut wrapper, bound with exotic Java binder and a unique blend of selected long fillers from Indonesia th at will gives you a light toasted bread taste and medium roasted hazelnuts.', '0.20 KG', 'Robusto', '100% Handmade', '100% Premium Tobacco', '49 x 127 mm', 'Connecticut Shade', 'Indonesia', 'Mild strength, slightly herb', NULL, 'aktif', '2026-04-22 17:15:10', '2026-04-22 17:15:10'),
(2, 'CLASICO RESERVA', 'products/Hu1JS0zvpGL6hPNoR02wnvQDK2Pav9sYkX3MaaED.png', 'products/09xvjVWQbFPxKToDguCqDIq4WJ8D6X8b3ikpifcN.jpg', 'From the selected Indonesian premium tobacco leaves', 'From the selected Indonesian premium tobacco leaves, Wismilak Clasico Reserva offers you an unforgettable journey of taste, which only Blend master of Wismilak can create. The cigar delivers a light roasted coffee and roasted hazelnuts, with sweet and creamy note at every stage of your smoking journey.', '0.2 Kg', 'Robusto', '100% Handmade', '100% Premium Tobacco', '50 x 127 mm', 'Ecuadorian Corojo', 'Indonesia', 'Medium to Full', NULL, 'aktif', '2026-04-28 08:32:12', '2026-05-19 10:05:07'),
(3, 'PREMIUM SELECCION PETIT CORONA', 'products/m2coQiHT5gklbSu9VbKdg1TjqaGqUxtCILgmiEE4.png', 'products/zswPAbLBa4EawofCJr1qQh585JFxzn7vpkUpWVNq.jpg', 'Premium Seleccion Petit Corona', 'Premium Seleccion Petit Corona, a Cigar with combination from the rich Corojowrapper, bound with exotic Java binder and a unique blend of selected long fillers from Indonesia that will creating a light smoke with a cool feeling on the tongue. \r\nDark roasted coffee & chocolate with aromatic spicy herb', '0.2 Kg', 'Corona – Petit', '100% Handmade', '100% Premium Tobacco', '34 x 127 mm', 'Ecuadorian Corojo', 'Indonesia', 'Mild to medium strength, light-dry, easy draw', NULL, 'aktif', '2026-05-19 10:04:51', '2026-05-19 10:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `points_required` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `title`, `image`, `description`, `points_required`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cigar Cutter Premium', 'rewards/sXs6luUXiC7mfNLlOxSZCurSir6pKShyF5q4NyuB.jpg', 'Gunting cerutu premium stainless steel grade.', 148, 9, 'active', '2026-04-22 07:59:48', '2026-06-24 13:57:29'),
(2, 'Tobacco Humidor Box', 'rewards/1viJjTmR5L6lZCLnHZCWYX3do4MqEQXejnbIg6dk.jpg', 'Kotak penyimpanan cerutu kapasitas 20 pcs.', 1200, 5, 'active', '2026-04-22 07:59:48', '2026-05-22 21:48:06'),
(3, 'Exclusive Wismilak Mug', 'rewards/OEHohEaQWbLBjn23MiEUF4MmCvhbZdzm4TjVZ3wY.jpg', 'Mug keramik edisi terbatas Wismilak Premium.', 300, 30, 'active', '2026-04-22 07:59:48', '2026-05-22 21:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `reward_redemptions`
--

CREATE TABLE `reward_redemptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reward_id` bigint(20) UNSIGNED NOT NULL,
  `points_used` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_redemptions`
--

INSERT INTO `reward_redemptions` (`id`, `user_id`, `reward_id`, `points_used`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 148, 'completed', '2026-06-24 13:57:30', '2026-06-24 15:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-04-22 07:59:42', '2026-04-22 07:59:42'),
(2, 'manager', '2026-04-22 07:59:42', '2026-04-22 07:59:42'),
(3, 'partner', '2026-04-22 07:59:42', '2026-04-22 07:59:42'),
(4, 'customer', '2026-04-22 07:59:42', '2026-04-22 07:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1wbLYffCcJSYaJsbZXrxWO5sxA7ti1bFvPkSJxW6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoieDd3aUNWbm8zbTNNckVQeDh0a0JhOG5zb2drM3JsUE1vQ0JlMThuciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ldmVudC1wYXJ0aWNpcGFudHMvNy9wYXJ0aWNpcGFudC8yMiI7czo1OiJyb3V0ZSI7czozNjoiYWRtaW4uZXZlbnQucGFydGljaXBhbnRzLnBhcnRpY2lwYW50Ijt9czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2N1c3RvbWVyL21lc3NhZ2VzLzYvZmV0Y2giO31zOjEyOiJhZ2VfdmVyaWZpZWQiO2I6MTtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1782320259);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `event_registration_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `qr_code` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `ktp_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `event_registration_id`, `user_id`, `event_id`, `status`, `qr_code`, `created_at`, `updated_at`, `full_name`, `email`, `phone`, `date_of_birth`, `ktp_number`) VALUES
(1, 'TCK-90J6RCULPY', 1, 5, 1, 'active', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, NULL, NULL, NULL, NULL),
(2, 'TCK-KOAKU3DRU8', 2, 7, 1, 'active', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, NULL, NULL, NULL, NULL),
(3, 'TCK-BC2FK0ZCJS', 3, 10, 1, 'active', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, NULL, NULL, NULL, NULL),
(4, 'TCK-YFYM62MSLJ', 4, 6, 3, 'active', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, NULL, NULL, NULL, NULL),
(5, 'TCK-ZRLA0NEPMO', 5, 8, 3, 'active', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37', NULL, NULL, NULL, NULL, NULL),
(6, 'TCK-F0A2E2A151', 6, 10, 2, 'checked_in', NULL, '2026-04-22 08:51:40', '2026-04-22 17:11:15', 'charles', 'char@gmail.com', '0812345678', '2000-10-10', '1234567888888888'),
(7, 'TCK-2241F7101A', 6, 10, 2, 'checked_in', NULL, '2026-04-22 08:51:40', '2026-04-27 14:56:14', 'jenny', 'jenn@gmail.com', '08123456789', '2000-10-10', '1234567888888888'),
(8, 'TCK-EECC0E0415', 7, 10, 4, 'active', NULL, '2026-04-28 08:09:50', '2026-04-28 08:09:50', 'jenny', 'jenny@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(9, 'TCK-6133D29A4E', 8, 5, 4, 'active', NULL, '2026-05-15 16:37:14', '2026-05-15 16:37:14', 'sani', 'sani@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(10, 'TCK-6834B67154', 8, 5, 4, 'active', NULL, '2026-05-15 16:37:14', '2026-05-15 16:37:14', 'aliyy', 'aliyy@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(11, 'TCK-8025DFAC2C', 9, 11, 1, 'active', NULL, '2026-05-17 17:03:19', '2026-05-17 17:03:19', 'Test User', 'testuser@example.com', '081234567890', '1990-11-11', '1234567890123456'),
(12, 'TCK-B717EE0110', 9, 11, 1, 'active', NULL, '2026-05-17 17:03:19', '2026-05-17 17:03:19', 'lia', 'lia@gmail.com', '08123456789', '2000-10-10', '1234567888888888'),
(13, 'TCK-6682E95770', 10, 10, 1, 'active', NULL, '2026-05-17 17:10:47', '2026-05-17 17:10:47', 'bebe', 'bebe@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(14, 'TCK-0662DF208E', 11, 10, 6, 'active', NULL, '2026-05-22 21:34:48', '2026-05-22 21:34:48', 'louvre', 'lou@gmail.com', '0812345678', '2000-02-02', '1234567891011123'),
(15, 'TCK-6C904825E6', 11, 10, 6, 'active', NULL, '2026-05-22 21:34:48', '2026-05-22 21:34:48', 'bobo', 'boo@gmail.com', '0812345678', '2003-10-05', '1234567891011123'),
(16, 'TCK-E253D2BF25', 12, 14, 7, 'active', NULL, '2026-05-30 18:51:51', '2026-05-30 18:51:51', 'jenny', 'jenny@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(17, 'TCK-C0606B5C66', 13, 10, 7, 'active', NULL, '2026-06-11 18:45:27', '2026-06-11 18:45:27', 'nanda', 'nanda@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(18, 'TCK-8F0EB14DA2', 14, 5, 9, 'checked_in', NULL, '2026-06-23 16:10:29', '2026-06-24 15:02:23', 'jenny', 'jenny@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(19, 'TCK-4B8465B481', 14, 5, 9, 'active', NULL, '2026-06-23 16:10:29', '2026-06-23 16:10:29', 'tara', 'tara@gmail.com', '0812345678', '2003-02-01', '1234567891011123'),
(20, 'TCK-586D584934', 15, 10, 9, 'checked_in', NULL, '2026-06-23 16:50:06', '2026-06-23 16:59:16', 'alya', 'lou@gmail.com', '0812345678', '2000-10-10', '1234567891011123'),
(21, 'TCK-1C7695E011', 16, 5, 10, 'checked_in', NULL, '2026-06-23 17:11:10', '2026-06-23 17:29:02', 'jenny', 'jenny@gmail.com', '0812345678', '2003-01-02', '1234567891011123'),
(22, 'TCK-8447EC5072', 17, 5, 7, 'checked_in', NULL, '2026-06-24 14:47:04', '2026-06-24 15:03:00', 'nanda', 'nanda@gmail.com', '0812345678', '2003-10-10', '1234567891011123');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'dummy_gateway',
  `transaction_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `gateway_response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `registration_id`, `user_id`, `amount`, `payment_method`, `transaction_code`, `status`, `paid_at`, `gateway_response`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 250000.00, 'midtrans', 'TRX-LUPILKEO', 'paid', '2026-04-21 08:06:37', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37'),
(2, 2, 7, 250000.00, 'midtrans', 'TRX-JARVZQXK', 'paid', '2026-04-20 08:06:37', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37'),
(3, 3, 10, 250000.00, 'midtrans', 'TRX-HQDSGSQ5', 'paid', '2026-04-19 08:06:37', NULL, '2026-04-22 08:06:37', '2026-04-22 08:06:37'),
(4, 6, 10, 270000.00, 'credit_card', '3febd45b-8f20-494d-bb0a-12dd3dd037a1', 'paid', '2026-04-22 08:51:30', '{\"status_code\":\"200\",\"transaction_id\":\"3febd45b-8f20-494d-bb0a-12dd3dd037a1\",\"gross_amount\":\"270000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-6-1776847828\",\"payment_type\":\"credit_card\",\"signature_key\":\"5ae3300cff39d531aa0eb88969664885fd44dffa9c92b8ff94bacbf779c1d4922278e15bf331f96ccff6437f43ac208f31e7bf2ca1fcb861338e93d9c88d3428\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-04-22 15:51:30\",\"settlement_time\":\"2026-04-22 15:51:35\",\"expiry_time\":\"2026-04-30 15:51:30\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1776847895680\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-04-22 08:51:40', '2026-04-22 08:51:40'),
(5, 7, 10, 350000.00, 'credit_card', '62d2aff0-9ad4-461a-93bb-666d9ddd99f0', 'paid', '2026-04-28 08:09:40', '{\"status_code\":\"200\",\"transaction_id\":\"62d2aff0-9ad4-461a-93bb-666d9ddd99f0\",\"gross_amount\":\"350000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-7-1777363749\",\"payment_type\":\"credit_card\",\"signature_key\":\"4b0bf88226d546a3ed41df25b87e9ff86b3696a33a30fe1f8a0be151b6fc879eece17273c8b35fe7911e3aa33a6309ac70c579a065c42037bacb21cf031745b8\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-04-28 15:09:40\",\"settlement_time\":\"2026-04-28 15:09:45\",\"expiry_time\":\"2026-05-06 15:09:40\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1777363785188\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-04-28 08:09:50', '2026-04-28 08:09:50'),
(6, 8, 5, 630000.00, 'credit_card', 'd0451e4a-8d32-4f76-a9fe-44c69f1ebe13', 'paid', '2026-05-15 16:37:03', '{\"status_code\":\"200\",\"transaction_id\":\"d0451e4a-8d32-4f76-a9fe-44c69f1ebe13\",\"gross_amount\":\"630000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-8-1778862963\",\"payment_type\":\"credit_card\",\"signature_key\":\"4a31bc9714875d3eac85ee22e2e4211a8296b4db8938c63ab7e23972295a44bb2b81fd53c275363d3bb677caca0b45b42b2be4c52ca9a220b98bf408248b26b7\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-05-15 23:37:03\",\"settlement_time\":\"2026-05-15 23:37:11\",\"expiry_time\":\"2026-05-23 23:37:03\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1778863030888\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-05-15 16:37:14', '2026-05-15 16:37:14'),
(7, 9, 11, 500000.00, 'credit_card', '558bcbfc-bd11-4821-8199-07ed544ef517', 'paid', '2026-05-17 17:03:14', '{\"status_code\":\"200\",\"transaction_id\":\"558bcbfc-bd11-4821-8199-07ed544ef517\",\"gross_amount\":\"500000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-9-1779037369\",\"payment_type\":\"credit_card\",\"signature_key\":\"06b16e8787f3e20bad862d9ac8842377f9e83615c030ed161bee38be2f2427ac38100e2fc85450166c505c1885ff89bfd78c2888100d7c9614d68433dcb814ff\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-05-18 00:03:14\",\"settlement_time\":\"2026-05-18 00:03:20\",\"expiry_time\":\"2026-05-26 00:03:14\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1779037399954\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-05-17 17:03:19', '2026-05-17 17:03:19'),
(8, 10, 10, 250000.00, 'credit_card', 'd1854506-441c-4894-a84c-290b81063373', 'paid', '2026-05-17 17:10:43', '{\"status_code\":\"200\",\"transaction_id\":\"d1854506-441c-4894-a84c-290b81063373\",\"gross_amount\":\"250000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-10-1779037822\",\"payment_type\":\"credit_card\",\"signature_key\":\"4e8852dea9f12e9511c7a11bf12b3827cd3a130a1b1327ec4105ae8d32c089329af0fc8c3af730dcfa6d98068156274a5a563190d03c2b80a2d454e7dd6db576\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-05-18 00:10:43\",\"settlement_time\":\"2026-05-18 00:10:47\",\"expiry_time\":\"2026-05-26 00:10:43\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1779037847808\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-05-17 17:10:47', '2026-05-17 17:10:47'),
(9, 11, 10, 199996.00, 'credit_card', 'be96243e-b425-436f-b154-9c0a8820a323', 'paid', '2026-05-22 21:34:40', '{\"status_code\":\"200\",\"transaction_id\":\"be96243e-b425-436f-b154-9c0a8820a323\",\"gross_amount\":\"199996.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-11-1779485648\",\"payment_type\":\"credit_card\",\"signature_key\":\"bebe1bdde7c4a541213d252ba717fffd394078df6a8f6c9da76fe2826f523fdf02fe9dc60b9b1298f36f584822f760c05101147700fe3bb0003fa6f2803a2432\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-05-23 04:34:40\",\"settlement_time\":\"2026-05-23 04:34:45\",\"expiry_time\":\"2026-05-31 04:34:40\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1779485685748\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-05-22 21:34:48', '2026-05-22 21:34:48'),
(10, 12, 14, 150000.00, 'credit_card', 'b26b125f-2bef-49d6-9cbd-3c9697709622', 'paid', '2026-05-30 18:51:50', '{\"status_code\":\"200\",\"transaction_id\":\"b26b125f-2bef-49d6-9cbd-3c9697709622\",\"gross_amount\":\"150000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-12-1780167058\",\"payment_type\":\"credit_card\",\"signature_key\":\"d1cd18eb2bb848ab06128174ca243955ba7340e14bcb61656a138baf6bdc020382bf7d322c082e15395937f4dad2626c2de2b47c6a9eab31ce643d65cce75eba\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-05-31 01:51:50\",\"settlement_time\":\"2026-05-31 01:51:56\",\"expiry_time\":\"2026-06-08 01:51:50\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1780167116170\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-05-30 18:51:51', '2026-05-30 18:51:51'),
(11, 13, 10, 135000.00, 'credit_card', 'c1710544-a1f2-4f62-9a9f-64f17e008321', 'paid', '2026-06-11 18:45:18', '{\"status_code\":\"200\",\"transaction_id\":\"c1710544-a1f2-4f62-9a9f-64f17e008321\",\"gross_amount\":\"135000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-13-1781203480\",\"payment_type\":\"credit_card\",\"signature_key\":\"aaeb71c215862a757b50da97d778bcc7a17efee88d33fbe03f8c3f72458cd949614a5f86e9866ff4e4f40a685faf5df1debb7d3f5d35074739e9c08cfe0288de\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-06-12 01:45:18\",\"settlement_time\":\"2026-06-12 01:45:23\",\"expiry_time\":\"2026-06-20 01:45:18\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1781203523705\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-06-11 18:45:27', '2026-06-11 18:45:27'),
(12, 15, 10, 0.00, 'free', 'TRX-6A3AB93E1AA38-20260623', 'paid', '2026-06-23 16:50:06', NULL, '2026-06-23 16:50:06', '2026-06-23 16:50:06'),
(13, 16, 5, 200000.00, 'credit_card', '33bca96b-1955-4e53-822b-f34a81a03273', 'paid', '2026-06-23 17:11:01', '{\"status_code\":\"200\",\"transaction_id\":\"33bca96b-1955-4e53-822b-f34a81a03273\",\"gross_amount\":\"200000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-16-1782234504\",\"payment_type\":\"credit_card\",\"signature_key\":\"9559b8dc14e8a8971584b4ba359cf875d1aec490698318c17601ee92bc5487ce9e8a08ba6cbb9fb8624509df4091bbfee783eeae7f65482e645b214ae3f77e93\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-06-24 00:11:01\",\"settlement_time\":\"2026-06-24 00:11:07\",\"expiry_time\":\"2026-07-02 00:11:01\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1782234667266\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-06-23 17:11:10', '2026-06-23 17:11:10'),
(14, 17, 5, 150000.00, 'credit_card', 'f8dd72cf-e63a-4fc3-a1ed-4da806b5bb33', 'paid', '2026-06-24 14:46:46', '{\"status_code\":\"200\",\"transaction_id\":\"f8dd72cf-e63a-4fc3-a1ed-4da806b5bb33\",\"gross_amount\":\"150000.00\",\"currency\":\"IDR\",\"order_id\":\"EVT-17-1782312342\",\"payment_type\":\"credit_card\",\"signature_key\":\"a1c7a6cd918a5abc058e7f10eadbea88a551ab140aada7653d9835f7183ffd6bb15e153d5d7271f7312957b8722109e7de8776552b4a22527ee981f8a8682fc0\",\"transaction_status\":\"capture\",\"fraud_status\":\"accept\",\"status_message\":\"Success, Credit Card capture transaction is successful\",\"merchant_id\":\"M857353825\",\"transaction_time\":\"2026-06-24 21:46:46\",\"settlement_time\":\"2026-06-24 21:46:57\",\"expiry_time\":\"2026-07-02 21:46:46\",\"channel_response_code\":\"00\",\"channel_response_message\":\"Approved\",\"bank\":\"mega\",\"approval_code\":\"1782312416917\",\"masked_card\":\"48111111-1114\",\"card_type\":\"credit\",\"channel\":\"dragon\",\"three_ds_version\":\"2\",\"on_us\":false,\"challenge_completion\":true,\"eci\":\"05\"}', '2026-06-24 14:47:04', '2026-06-24 14:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 2,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `date_of_birth`, `city`, `gender`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `status`) VALUES
(1, 'Admin Wismilak', 'admin@wismilak.com', '08123456789', NULL, NULL, NULL, NULL, '$2y$12$wZHLRu8gRS3HW9calNZMzuh2OW1TuYiZWzVrfyFUOyPGOoOGAUsxK', NULL, '2026-04-22 07:59:43', '2026-04-28 08:37:44', 1, 'active'),
(2, 'Manager Wismilak', 'manager@wismilak.com', '08123456789', NULL, NULL, NULL, NULL, '$2y$12$F0kjWFZJsDX44L.j9aiZ2O/xWeKSHQF2ygHrMRgZ5hM7mQwpGgxb6', NULL, '2026-04-22 07:59:44', '2026-04-28 08:02:27', 2, 'active'),
(3, 'PT Nusantara Tobacco', 'partner@nusantara.com', '08123456789', NULL, NULL, NULL, NULL, '$2y$12$2tOmmELuvxluzBy4MFtOlO6WlFWx.s9JCfEieernS5cGhbLA0ktQ.', NULL, '2026-04-22 07:59:44', '2026-05-10 18:02:55', 3, 'active'),
(4, 'Cigar House Jakarta', 'partner@cigarhouse.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$.SCqynm/ZqcYDJfcb8N.1O2/5vdeGyR4HBokMktUaoxksnbNkQp.e', NULL, '2026-04-22 07:59:45', '2026-04-22 07:59:45', 3, 'active'),
(5, 'Budi Santoso', 'budi@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$aq1KDxe44cQSLMCixkJwz.Jyv.EsYclNpLFIlDPbwf/FgRN43R8sq', NULL, '2026-04-22 07:59:45', '2026-04-22 07:59:45', 4, 'active'),
(6, 'Dewi Rahayu', 'dewi@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$qVAPRQSONnbRUgF5sYmfc.6oXUFhzrXofLzIcmhJbCHNPpFgMHCou', NULL, '2026-04-22 07:59:46', '2026-04-22 07:59:46', 4, 'active'),
(7, 'Ahmad Rizki', 'ahmad@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$n0jBoOSBAmCAS3gOV2MVcOpW14fMSNsc6ksxi8wYGs05p4QCzw3.W', NULL, '2026-04-22 07:59:46', '2026-04-22 07:59:46', 4, 'active'),
(8, 'Siti Nurhaliza', 'siti@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$bVJK6lgOrU6nNVUii1US9eYzJfl3yMWd1Iwil8H9F3EvyOc0gHpFe', 'gaLIckGmU1Xbu5040SLgg1YHDAv6wN0GczSFuc6rbK34Be2m1IaulrFNUSFH', '2026-04-22 07:59:47', '2026-05-30 14:21:33', 4, 'active'),
(9, 'Eko Prasetyo', 'eko@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$5BMtgu6t6EucMS15prk7WOnRAgpDgY8ZCUXPXzlkDBIAFb.Dlm7P.', '0XEt8LXsu6jORRxoYJp6qql8viL6DXfxfuwY0BKSAJ7bPh9AeU6lAFaWOoIq', '2026-04-22 07:59:47', '2026-04-28 08:51:26', 4, 'active'),
(10, 'Customer Test', 'customer@example.com', '08123456789', '2000-10-10', 'Surabaya', 'female', NULL, '$2y$12$Egta5wgjG4Z3AX6FdBFyA.wAhjoZY7F4a7hlCuqOYU1mB4yS0We8O', NULL, '2026-04-22 07:59:48', '2026-04-28 08:04:10', 4, 'active'),
(11, 'Test User', 'testuser@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$BTNZV6sQNVVImpzgmpAWdeUcBTnYCgKseEba3/UyUKU4gs5WjvXZ.', NULL, '2026-05-17 16:58:11', '2026-05-17 16:58:11', 4, 'active'),
(12, 'bobo', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$uLGoIoJjC98yr8t5TvA3VuwWFQvw6O18sUX3QYaO8zW5mD.68pCOy', NULL, '2026-05-17 17:49:09', '2026-05-17 17:49:09', 4, 'active'),
(13, 'Customer Test', 'customer@wismilak.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$BRnquVdnd2yf4jl8dGROSOn3/c5OLxt0PhHcL3lkZ6Iy7HDoeFq.2', NULL, '2026-05-17 18:53:24', '2026-05-17 18:53:24', 4, 'active'),
(14, 'charles', 'charles@example.com', '08123456789', '2000-10-10', 'Jakarta', 'male', NULL, '$2y$12$RwshHpVct8EFwcKIK2WoTOUcbN0i.LQe8PKGPUAhsYA98FR56e1Mu', NULL, '2026-05-30 14:23:33', '2026-06-03 11:40:33', 4, 'active'),
(15, 'jenny', 'jenny@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$AFMBtL05xCJ0Oz/XkCOI9uTcUAa0n6YXLncmsc.zPmR/W99R9Pj9i', NULL, '2026-06-03 11:45:17', '2026-06-03 11:45:17', 4, 'active'),
(16, 'Jimny', 'jimny@example.com', '08123456789', '2000-10-10', 'Jakarta', 'male', NULL, '$2y$12$T..JmjIKie.3s19vgEaKKOM8GiwqrhrX.yZgQnJDHVe/afnyajMxC', NULL, '2026-06-03 11:53:25', '2026-06-03 11:53:25', 4, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_points`
--

CREATE TABLE `user_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_points`
--

INSERT INTO `user_points` (`id`, `user_id`, `total_points`, `created_at`, `updated_at`) VALUES
(1, 5, 132, '2026-04-22 07:59:45', '2026-06-24 15:03:00'),
(2, 6, 120, '2026-04-22 07:59:46', '2026-04-22 07:59:46'),
(3, 7, 580, '2026-04-22 07:59:46', '2026-04-22 07:59:46'),
(4, 8, 240, '2026-04-22 07:59:47', '2026-04-22 07:59:47'),
(5, 9, 90, '2026-04-22 07:59:47', '2026-04-22 07:59:47'),
(6, 10, 35, '2026-04-22 07:59:48', '2026-06-23 16:59:16'),
(7, 11, 20, '2026-05-17 16:58:11', '2026-05-17 17:03:20'),
(8, 12, 0, '2026-05-17 17:49:09', '2026-05-17 17:49:09'),
(9, 13, 0, '2026-05-17 18:53:24', '2026-05-17 18:53:24'),
(10, 14, 10, '2026-05-30 14:23:33', '2026-05-30 18:51:51'),
(11, 15, 0, '2026-06-03 11:45:17', '2026-06-03 11:45:17'),
(12, 16, 0, '2026-06-03 11:53:25', '2026-06-03 11:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `max_discount` decimal(12,2) DEFAULT NULL,
  `min_purchase` decimal(12,2) NOT NULL DEFAULT 0.00,
  `max_uses` int(11) NOT NULL DEFAULT 0,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `points_required` int(11) NOT NULL DEFAULT 0,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `title`, `description`, `discount_type`, `discount_value`, `max_discount`, `min_purchase`, `max_uses`, `used_count`, `points_required`, `valid_from`, `valid_until`, `status`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'Selamat Datang', NULL, 'percentage', 10.00, NULL, 0.00, 50, 6, 100, NULL, '2026-07-22', 'active', '2026-04-22 07:59:48', '2026-06-15 18:12:55'),
(2, 'DISC50K', 'Diskon 50K', NULL, 'fixed', 50000.00, NULL, 0.00, 30, 0, 200, NULL, '2026-07-22', 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(3, 'EVENT20', 'Event Discount 20%', NULL, 'percentage', 20.00, NULL, 0.00, 20, 0, 300, NULL, '2026-07-22', 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(4, 'PREMIUM15', 'Premium Member 15%', NULL, 'percentage', 15.00, NULL, 0.00, 10, 0, 500, NULL, '2026-07-22', 'active', '2026-04-22 07:59:48', '2026-04-22 07:59:48'),
(5, 'FIRST100K', 'First Event 100K', NULL, 'fixed', 100000.00, NULL, 0.00, 25, 2, 150, NULL, '2026-07-22', 'active', '2026-04-22 07:59:48', '2026-06-23 16:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_redemptions`
--

CREATE TABLE `voucher_redemptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `points_spent` int(11) NOT NULL DEFAULT 0,
  `voucher_code` varchar(255) NOT NULL,
  `status` enum('unused','used') NOT NULL DEFAULT 'unused',
  `redeemed_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher_redemptions`
--

INSERT INTO `voucher_redemptions` (`id`, `voucher_id`, `user_id`, `points_spent`, `voucher_code`, `status`, `redeemed_at`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 100, 'VCH-2GZ6UYNE', 'used', '2026-04-17 08:06:37', '2026-05-17 08:06:37', '2026-04-22 08:06:37', '2026-05-15 16:37:15'),
(2, 1, 10, 100, 'VCH-T1MAM9XA', 'used', '2026-04-22 08:48:29', '2026-07-21 17:00:00', '2026-04-22 08:48:29', '2026-04-22 08:51:40'),
(3, 1, 10, 100, 'VCH-CMSWOM1Q', 'used', '2026-06-11 18:43:03', '2026-07-21 17:00:00', '2026-06-11 18:43:03', '2026-06-11 18:45:28'),
(4, 1, 10, 100, 'VCH-FRJKK0TP', 'unused', '2026-06-15 18:12:55', '2026-07-21 17:00:00', '2026-06-15 18:12:55', '2026-06-15 18:12:55'),
(5, 5, 5, 150, 'VCH-35BIPXFW', 'used', '2026-06-23 14:08:12', '2026-07-21 17:00:00', '2026-06-23 14:08:12', '2026-06-23 16:10:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_chat_session_id_foreign` (`chat_session_id`);

--
-- Indexes for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_sessions_user_id_foreign` (`user_id`);

--
-- Indexes for table `chat_topics`
--
ALTER TABLE `chat_topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chat_topics_keyword_unique` (`keyword`);

--
-- Indexes for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_created_by_foreign` (`created_by`),
  ADD KEY `events_approved_by_foreign` (`approved_by`),
  ADD KEY `events_published_by_foreign` (`published_by`);

--
-- Indexes for table `event_checkins`
--
ALTER TABLE `event_checkins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_checkins_ticket_id_unique` (`ticket_id`),
  ADD KEY `event_checkins_user_id_foreign` (`user_id`),
  ADD KEY `event_checkins_event_id_foreign` (`event_id`);

--
-- Indexes for table `event_feedbacks`
--
ALTER TABLE `event_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_feedbacks_event_id_user_id_unique` (`event_id`,`user_id`),
  ADD KEY `event_feedbacks_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_outlets`
--
ALTER TABLE `event_outlets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_outlets_event_id_foreign` (`event_id`),
  ADD KEY `event_outlets_outlet_id_foreign` (`outlet_id`);

--
-- Indexes for table `event_packages`
--
ALTER TABLE `event_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_packages_event_id_foreign` (`event_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_registrations_user_id_foreign` (`user_id`),
  ADD KEY `event_registrations_event_id_user_id_index` (`event_id`,`user_id`),
  ADD KEY `event_registrations_voucher_redemption_id_foreign` (`voucher_redemption_id`),
  ADD KEY `event_registrations_reward_redemption_id_foreign` (`reward_redemption_id`);

--
-- Indexes for table `event_tickets`
--
ALTER TABLE `event_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_tickets_registration_id_foreign` (`registration_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instagram_posts`
--
ALTER TABLE `instagram_posts`
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
-- Indexes for table `manager_profiles`
--
ALTER TABLE `manager_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `media_inquiries`
--
ALTER TABLE `media_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_inquiry_replies`
--
ALTER TABLE `media_inquiry_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_inquiry_replies_media_inquiry_id_foreign` (`media_inquiry_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications_custom`
--
ALTER TABLE `notifications_custom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_custom_user_id_is_read_index` (`user_id`,`is_read`),
  ADD KEY `notifications_custom_created_at_index` (`created_at`);

--
-- Indexes for table `outlets`
--
ALTER TABLE `outlets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outlet_products`
--
ALTER TABLE `outlet_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `outlet_products_outlet_id_product_id_unique` (`outlet_id`,`product_id`),
  ADD KEY `outlet_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_sections_page_id_foreign` (`page_id`);

--
-- Indexes for table `partner_outlets`
--
ALTER TABLE `partner_outlets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_outlets_partner_id_foreign` (`partner_id`),
  ADD KEY `partner_outlets_outlet_id_foreign` (`outlet_id`);

--
-- Indexes for table `partner_profiles`
--
ALTER TABLE `partner_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `point_histories`
--
ALTER TABLE `point_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_histories_user_id_type_index` (`user_id`,`type`);

--
-- Indexes for table `pressrooms`
--
ALTER TABLE `pressrooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pressrooms_slug_unique` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reward_redemptions_user_id_foreign` (`user_id`),
  ADD KEY `reward_redemptions_reward_id_foreign` (`reward_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  ADD KEY `tickets_event_registration_id_foreign` (`event_registration_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_event_id_foreign` (`event_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_transaction_code_unique` (`transaction_code`),
  ADD KEY `transactions_registration_id_foreign` (`registration_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_points_user_id_foreign` (`user_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- Indexes for table `voucher_redemptions`
--
ALTER TABLE `voucher_redemptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_redemptions_voucher_code_unique` (`voucher_code`),
  ADD KEY `voucher_redemptions_voucher_id_foreign` (`voucher_id`),
  ADD KEY `voucher_redemptions_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chat_topics`
--
ALTER TABLE `chat_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_checkins`
--
ALTER TABLE `event_checkins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_feedbacks`
--
ALTER TABLE `event_feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_outlets`
--
ALTER TABLE `event_outlets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_packages`
--
ALTER TABLE `event_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event_tickets`
--
ALTER TABLE `event_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instagram_posts`
--
ALTER TABLE `instagram_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `manager_profiles`
--
ALTER TABLE `manager_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media_inquiries`
--
ALTER TABLE `media_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media_inquiry_replies`
--
ALTER TABLE `media_inquiry_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `notifications_custom`
--
ALTER TABLE `notifications_custom`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `outlets`
--
ALTER TABLE `outlets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `outlet_products`
--
ALTER TABLE `outlet_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_sections`
--
ALTER TABLE `page_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partner_outlets`
--
ALTER TABLE `partner_outlets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `partner_profiles`
--
ALTER TABLE `partner_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `point_histories`
--
ALTER TABLE `point_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pressrooms`
--
ALTER TABLE `pressrooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `voucher_redemptions`
--
ALTER TABLE `voucher_redemptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_chat_session_id_foreign` FOREIGN KEY (`chat_session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `chat_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_profiles`
--
ALTER TABLE `customer_profiles`
  ADD CONSTRAINT `customer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `events_published_by_foreign` FOREIGN KEY (`published_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_checkins`
--
ALTER TABLE `event_checkins`
  ADD CONSTRAINT `event_checkins_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_checkins_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_checkins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_feedbacks`
--
ALTER TABLE `event_feedbacks`
  ADD CONSTRAINT `event_feedbacks_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_outlets`
--
ALTER TABLE `event_outlets`
  ADD CONSTRAINT `event_outlets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_outlets_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_packages`
--
ALTER TABLE `event_packages`
  ADD CONSTRAINT `event_packages_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_reward_redemption_id_foreign` FOREIGN KEY (`reward_redemption_id`) REFERENCES `reward_redemptions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `event_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_voucher_redemption_id_foreign` FOREIGN KEY (`voucher_redemption_id`) REFERENCES `voucher_redemptions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_tickets`
--
ALTER TABLE `event_tickets`
  ADD CONSTRAINT `event_tickets_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `event_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `manager_profiles`
--
ALTER TABLE `manager_profiles`
  ADD CONSTRAINT `manager_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_inquiry_replies`
--
ALTER TABLE `media_inquiry_replies`
  ADD CONSTRAINT `media_inquiry_replies_media_inquiry_id_foreign` FOREIGN KEY (`media_inquiry_id`) REFERENCES `media_inquiries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications_custom`
--
ALTER TABLE `notifications_custom`
  ADD CONSTRAINT `notifications_custom_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `outlet_products`
--
ALTER TABLE `outlet_products`
  ADD CONSTRAINT `outlet_products_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `outlet_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD CONSTRAINT `page_sections_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `partner_outlets`
--
ALTER TABLE `partner_outlets`
  ADD CONSTRAINT `partner_outlets_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partner_outlets_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `partner_profiles`
--
ALTER TABLE `partner_profiles`
  ADD CONSTRAINT `partner_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `point_histories`
--
ALTER TABLE `point_histories`
  ADD CONSTRAINT `point_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reward_redemptions`
--
ALTER TABLE `reward_redemptions`
  ADD CONSTRAINT `reward_redemptions_reward_id_foreign` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reward_redemptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_event_registration_id_foreign` FOREIGN KEY (`event_registration_id`) REFERENCES `event_registrations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `event_registrations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_points`
--
ALTER TABLE `user_points`
  ADD CONSTRAINT `user_points_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voucher_redemptions`
--
ALTER TABLE `voucher_redemptions`
  ADD CONSTRAINT `voucher_redemptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `voucher_redemptions_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
