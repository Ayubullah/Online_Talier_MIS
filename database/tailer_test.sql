-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 02:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tailer_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `cloth_assignment`
--

CREATE TABLE `cloth_assignment` (
  `ca_id` bigint(20) UNSIGNED NOT NULL,
  `F_cm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `F_vm_id` bigint(20) UNSIGNED DEFAULT NULL,
  `F_emp_id` bigint(20) UNSIGNED NOT NULL,
  `work_type` enum('cutting','salaye') NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `rate_at_assign` decimal(10,2) NOT NULL,
  `status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `assigned_at` datetime NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `cloth_assignment`
--

INSERT INTO `cloth_assignment` (`ca_id`, `F_cm_id`, `F_vm_id`, `F_emp_id`, `work_type`, `qty`, `rate_at_assign`, `status`, `assigned_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(14, 1, NULL, 10, 'cutting', 1, 20.00, 'pending', '2025-09-12 15:48:57', NULL, '2025-09-12 11:18:57', '2025-09-12 11:18:57'),
(15, 1, NULL, 11, 'salaye', 1, 30.00, 'pending', '2025-09-12 15:48:57', NULL, '2025-09-12 11:18:57', '2025-09-12 11:18:57'),
(16, 2, NULL, 10, 'cutting', 1, 20.00, 'pending', '2025-09-12 15:49:08', NULL, '2025-09-12 11:19:08', '2025-09-12 11:19:08'),
(17, 2, NULL, 11, 'salaye', 1, 30.00, 'complete', '2025-09-12 15:49:08', '2025-09-24 02:39:57', '2025-09-12 11:19:08', '2025-09-23 22:09:57'),
(18, 3, NULL, 10, 'cutting', 1, 20.00, 'pending', '2025-09-13 07:58:38', NULL, '2025-09-13 03:28:38', '2025-09-23 23:17:21'),
(19, 3, NULL, 11, 'salaye', 1, 30.00, 'pending', '2025-09-13 07:58:38', NULL, '2025-09-13 03:28:38', '2025-09-13 03:28:38'),
(20, NULL, 1, 12, 'cutting', 1, 10.00, 'complete', '2025-09-23 03:27:26', '2025-09-24 02:42:55', '2025-09-22 22:57:26', '2025-09-23 22:12:55'),
(21, NULL, 1, 13, 'salaye', 1, 30.00, 'pending', '2025-09-23 03:27:26', NULL, '2025-09-22 22:57:26', '2025-09-22 22:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `cloth_m`
--

CREATE TABLE `cloth_m` (
  `cm_id` bigint(20) UNSIGNED NOT NULL,
  `F_cus_id` bigint(20) UNSIGNED NOT NULL,
  `size` enum('S','L') NOT NULL,
  `cloth_rate` decimal(10,2) NOT NULL,
  `order_status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `Height` varchar(10) DEFAULT NULL,
  `chati` varchar(255) DEFAULT NULL,
  `Sleeve` int(11) DEFAULT NULL,
  `Shoulder` int(11) DEFAULT NULL,
  `Collar` varchar(15) DEFAULT NULL,
  `Armpit` varchar(15) DEFAULT NULL,
  `Skirt` varchar(15) DEFAULT NULL,
  `Trousers` varchar(15) DEFAULT NULL,
  `Kaff` varchar(40) DEFAULT NULL,
  `size_kaf` varchar(10) DEFAULT NULL,
  `Pacha` varchar(15) DEFAULT NULL,
  `sleeve_type` varchar(40) DEFAULT NULL,
  `size_sleve` varchar(10) DEFAULT NULL,
  `Kalar` varchar(15) DEFAULT NULL,
  `Shalwar` varchar(15) DEFAULT NULL,
  `Yakhan` varchar(15) DEFAULT NULL,
  `Daman` varchar(15) DEFAULT NULL,
  `Jeb` varchar(60) DEFAULT NULL,
  `O_date` date DEFAULT NULL,
  `R_date` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cloth_m`
--

INSERT INTO `cloth_m` (`cm_id`, `F_cus_id`, `size`, `cloth_rate`, `order_status`, `created_at`, `Height`, `chati`, `Sleeve`, `Shoulder`, `Collar`, `Armpit`, `Skirt`, `Trousers`, `Kaff`, `size_kaf`, `Pacha`, `sleeve_type`, `size_sleve`, `Kalar`, `Shalwar`, `Yakhan`, `Daman`, `Jeb`, `O_date`, `R_date`, `updated_at`) VALUES
(1, 1, 'L', 100.00, 'pending', '2025-09-01 09:46:32', '2', '22', 2, 2, '2', '2', '2', '2', 'null', '2', '2', 'null', '2', 'هندی', 'ساده', NULL, 'گول', 'روي', '2025-08-31', '2025-09-04', '2025-09-12 02:02:56'),
(2, 3, 'L', 100.00, 'complete', '2025-09-02 16:04:13', '2', '22', 2, 2, '2', '2', '2', '2', '2', '2', '2', '22', '2', 'کالر', 'ساده', NULL, 'گول', 'روي', '2025-08-31', '2025-09-04', '2025-09-23 22:09:57'),
(3, 6, 'L', 100.00, 'pending', '2025-09-04 13:04:08', '2', '22', 2, 2, '2', '2', '2', '2', '2', '2', '2', '22', '2', 'نیمه بین', 'ساده', NULL, 'گول', 'روي', '2025-08-31', '2025-09-04', '2025-09-23 23:17:21'),
(4, 8, 'L', 100.00, 'pending', '2025-09-07 16:15:35', '2', '22', 2, 2, '2', '2', '2', '2', '2', '2', '2', '22', '2', 'نیمه بین', 'ساده', NULL, 'گول', 'روي', '2025-09-07', '2025-09-11', '2025-09-07 11:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_id` bigint(20) UNSIGNED NOT NULL,
  `cus_name` varchar(50) NOT NULL,
  `F_pho_id` bigint(20) UNSIGNED DEFAULT NULL,
  `F_inv_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_id`, `cus_name`, `F_pho_id`, `F_inv_id`, `created_at`, `updated_at`) VALUES
(1, 'halimjan', 1, NULL, '2025-09-01 05:16:32', '2025-09-12 02:02:11'),
(2, 'K123', 2, 2, '2025-09-02 08:53:18', '2025-09-02 08:53:18'),
(3, 'asad', 8, NULL, '2025-09-02 11:34:13', '2025-09-12 02:31:19'),
(4, 'malikjan', 6, 4, '2025-09-02 11:35:56', '2025-09-02 11:35:56'),
(6, 'asad', 6, 6, '2025-09-04 08:34:08', '2025-09-04 08:34:08'),
(7, 'amen', 7, 7, '2025-09-07 09:57:35', '2025-09-07 09:57:35'),
(8, 'Shamsullah', 10, 8, '2025-09-07 11:45:35', '2025-09-07 11:45:35'),
(9, 'hamza', 11, 9, '2025-09-07 12:07:08', '2025-09-07 12:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','bank_transfer','mobile_money','card') NOT NULL,
  `payment_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `F_user_id` bigint(11) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `role` enum('cutter','salaye') NOT NULL,
  `type` enum('cloth','vest') DEFAULT NULL,
  `cutter_s_rate` decimal(10,2) DEFAULT NULL,
  `cutter_l_rate` decimal(10,2) DEFAULT NULL,
  `salaye_s_rate` decimal(10,2) DEFAULT NULL,
  `salaye_l_rate` decimal(10,2) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`F_user_id`, `emp_id`, `emp_name`, `role`, `type`, `cutter_s_rate`, `cutter_l_rate`, `salaye_s_rate`, `salaye_l_rate`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 10, 'shahi', 'cutter', 'cloth', 10.00, 20.00, NULL, NULL, NULL, '2025-09-12 12:37:47', '2025-09-12 12:37:47'),
(9, 11, 'Bilal Ahmed', 'salaye', 'cloth', NULL, NULL, 10.00, 30.00, NULL, '2025-09-12 10:50:09', '2025-09-12 10:50:09'),
(10, 12, 'samer', 'cutter', 'vest', 10.00, 20.00, NULL, NULL, NULL, '2025-09-22 22:45:06', '2025-09-22 22:45:06'),
(11, 13, 'malik', 'salaye', 'vest', NULL, NULL, 30.00, 40.00, NULL, '2025-09-22 22:45:49', '2025-09-22 22:45:49'),
(12, 14, 'l', 'cutter', 'cloth', 10.00, 10.00, NULL, NULL, NULL, '2025-09-29 06:57:55', '2025-09-29 06:57:55');

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
-- Table structure for table `invoice_tb`
--

CREATE TABLE `invoice_tb` (
  `inc_id` bigint(20) UNSIGNED NOT NULL,
  `inc_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amt` decimal(10,2) NOT NULL,
  `status` enum('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_tb`
--

INSERT INTO `invoice_tb` (`inc_id`, `inc_date`, `total_amt`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-09-01 00:00:00', 100.00, 'paid', '2025-09-01 05:16:32', '2025-09-01 05:16:32'),
(2, '2025-09-02 00:00:00', 100.00, 'unpaid', '2025-09-02 08:53:18', '2025-09-02 08:53:18'),
(3, '2025-09-02 00:00:00', 100.00, 'paid', '2025-09-02 11:34:13', '2025-09-02 11:34:13'),
(4, '2025-09-02 00:00:00', 100.00, 'unpaid', '2025-09-02 11:35:56', '2025-09-02 11:35:56'),
(5, '2025-09-04 00:00:00', 350.00, 'unpaid', '2025-09-04 02:51:06', '2025-09-04 02:51:06'),
(6, '2025-09-04 00:00:00', 100.00, 'unpaid', '2025-09-04 08:34:08', '2025-09-04 08:34:08'),
(7, '2025-09-07 00:00:00', 500.00, 'unpaid', '2025-09-07 09:57:35', '2025-09-07 09:57:35'),
(8, '2025-09-07 00:00:00', 100.00, 'paid', '2025-09-07 11:45:35', '2025-09-07 11:45:35'),
(9, '2025-09-07 00:00:00', 500.00, 'unpaid', '2025-09-07 12:07:08', '2025-09-07 12:07:08'),
(10, '2025-09-12 00:00:00', 100.00, 'paid', '2025-09-12 03:49:43', '2025-09-12 03:49:43');

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
(4, '2025_01_28_000001_create_employee_table', 1),
(5, '2025_01_28_000002_create_phone_table', 1),
(6, '2025_01_28_000003_create_invoice_tb_table', 1),
(7, '2025_01_28_000004_create_customer_table', 1),
(8, '2025_01_28_000005_create_cloth_m_table', 1),
(9, '2025_01_28_000006_create_vest_m_table', 1),
(10, '2025_01_28_000007_create_cloth_assignment_table', 1),
(11, '2025_01_28_000008_create_payment_table', 1),
(12, '2025_08_28_092001_add_is_admin_to_users_table', 1),
(13, '2025_08_31_064828_add_size_fields_to_cloth_m_table', 1),
(14, '2025_08_31_070103_remove_unique_constraint_from_phone_table', 1),
(15, '2025_08_31_073937_add_vest_type_to_vest_m_table', 1),
(16, '2025_09_01_063553_add_specialized_rates_to_employee_table', 1),
(17, '2025_09_01_064134_add_salaye_rates_to_employee_table', 1),
(18, '2025_09_01_064958_drop_base_rate_from_employee_table', 1),
(19, '2025_09_01_065444_drop_salary_rate_from_employee_table', 1),
(20, '2025_09_01_071339_add_type_to_employee_table', 1),
(21, '2025_09_01_094403_update_role_column_in_employee_table', 2),
(22, '2025_09_03_183252_fix_existing_payments_assign_employees', 3),
(23, '2025_01_28_000009_create_customer_payments_table', 4),
(24, '2025_09_12_121251_add_role_to_users_table', 5),
(28, '2025_09_12_124243_add_role_to_user_table', 6);

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` bigint(20) UNSIGNED NOT NULL,
  `F_inc_id` bigint(20) UNSIGNED DEFAULT NULL,
  `F_phone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `F_emp_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('cash','card','bank') NOT NULL DEFAULT 'cash',
  `note` varchar(255) DEFAULT NULL,
  `paid_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `F_inc_id`, `F_phone_id`, `F_emp_id`, `amount`, `method`, `note`, `paid_at`, `created_at`, `updated_at`) VALUES
(11, 7, NULL, NULL, 50.00, 'cash', NULL, '2025-09-07 00:00:00', '2025-09-07 09:57:35', '2025-09-07 09:57:35'),
(12, 8, NULL, NULL, 200.00, 'cash', NULL, '2025-09-07 00:00:00', '2025-09-07 11:45:35', '2025-09-07 11:45:35'),
(13, 9, NULL, NULL, 200.00, 'cash', NULL, '2025-09-07 00:00:00', '2025-09-07 12:07:08', '2025-09-07 12:07:08'),
(14, 10, NULL, NULL, 200.00, 'cash', NULL, '2025-09-12 00:00:00', '2025-09-12 03:49:43', '2025-09-12 03:49:43'),
(15, NULL, NULL, 11, 30.00, 'cash', 'aksdjla', '2025-09-12 16:15:00', '2025-09-12 11:45:43', '2025-09-12 11:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `phone`
--

CREATE TABLE `phone` (
  `pho_id` bigint(20) UNSIGNED NOT NULL,
  `pho_no` varchar(14) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone`
--

INSERT INTO `phone` (`pho_id`, `pho_no`, `created_at`, `updated_at`) VALUES
(1, '0777777700', '2025-09-01 05:16:32', '2025-09-01 05:16:32'),
(2, '0777777772', '2025-09-02 08:53:18', '2025-09-02 08:53:18'),
(3, '0777777700', '2025-09-02 11:34:13', '2025-09-02 11:34:13'),
(4, '0777777772', '2025-09-02 11:35:56', '2025-09-02 11:35:56'),
(5, '0777777772', '2025-09-04 02:51:06', '2025-09-04 02:51:06'),
(6, '0777777772', '2025-09-04 08:34:08', '2025-09-04 08:34:08'),
(7, '0777777772', '2025-09-07 09:57:35', '2025-09-07 09:57:35'),
(8, '077777000', '2025-09-07 10:00:07', '2025-09-07 10:00:07'),
(9, '0777777770', '2025-09-07 10:23:28', '2025-09-07 10:23:28'),
(10, '0777777772', '2025-09-07 11:45:35', '2025-09-07 11:45:35'),
(11, '0777777772', '2025-09-07 12:07:08', '2025-09-07 12:07:08'),
(12, '0777777772', '2025-09-12 03:49:43', '2025-09-12 03:49:43');

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
('0ylTsdPRMYsXWQzuLswumaZrYj1V2h4soy4AlLq1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNEhudUxwOFpFM1F4clVpY3NZbE9zWVVnSDJLbFJEekxRb1g5cW9IZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1759142733),
('G3VbHVnoQT6S4nTc3ewqwvNMErVUCGDA6h56aUhP', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibHh2a2VVeGhHMDBMdkdiVGJPTmpmTzlWZWVoVE9Bb2laS2RkYVJOOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdGF0dXMiO31zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjY6ImxvY2FsZSI7czoyOiJmYSI7fQ==', 1759146921);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','admin','agent') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Ayub', 'admin@tailoring.com', '2025-09-01 05:09:30', '$2y$12$VBGVaAIBg/clwOAZHUBvwuy5OUPGTbBzg03djN1Boh8XdMjgFkCCK', NULL, '2025-09-01 05:09:31', '2025-09-04 03:58:50', 'user'),
(2, 'John Cutter', 'john@tailoring.com', '2025-09-01 05:09:31', '$2y$12$yoBAhcz.B3BpxHHLESJotOgTpRGCKhUgX43Z/ZNHnxeZJ2JN8JrW2', NULL, '2025-09-01 05:09:31', '2025-09-01 05:09:31', 'user'),
(3, 'Admin User', 'admin@example.com', NULL, '$2y$12$hc/JUJr6jVXagK6OBdzTIehX5HaQGPAADW3l9dhkKyG4HFT.cafkq', 'IpneKAgQ3ZPoPgece2oiLb8PE20qSpppeS6ujsbwjjSH0x2HwxmqpeAK2jkj', '2025-09-12 07:43:49', '2025-09-12 08:16:18', 'admin'),
(4, 'Regular User', 'user@example.com', NULL, '$2y$12$nqC20/DmlZbJJ0Nhc2Al3uY7QVgT8Mtwm8osXT3W9SQUwSGegGmb6', NULL, '2025-09-12 07:43:49', '2025-09-12 08:16:19', 'user'),
(7, 'Agent User', 'agent@example.com', NULL, '$2y$12$mmEDuxkb4CYKT687Ph/.3eZNvc2Dn/yOJTInLVozujBYhOmrMNiNq', NULL, '2025-09-12 08:16:18', '2025-09-12 08:16:18', 'user'),
(9, 'Bilal Ahmed', 'b@example.com', NULL, '$2y$12$bE3BU/wr35p0i8H6nSoE5O00sal9PeGfkQKWqhDPYVQc7VCbsG5dy', NULL, '2025-09-12 10:50:09', '2025-09-12 10:50:09', 'user'),
(10, 'samer', 'samer@example.com', NULL, '$2y$12$yHaQV1CLszonpS3bw9OVX.I1/39AyALJwIX/Gs4Z2TzBB.7dZYR/m', NULL, '2025-09-22 22:45:06', '2025-09-22 22:45:06', 'user'),
(11, 'malik', 'malik@example.com', NULL, '$2y$12$oLYogeQ8a1OkDtvej93b/OZAa8kg8NurjQft8hmpMO/ox6WsH1BxW', NULL, '2025-09-22 22:45:49', '2025-09-22 22:45:49', 'user'),
(12, 'l', 'l@example.com', NULL, '$2y$12$HY7k/fYUwlZuDKEM5bhJgecaZr7JUZyuHiK4lYLSXUciPBM5vylLO', NULL, '2025-09-29 06:57:55', '2025-09-29 06:57:55', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vest_m`
--

CREATE TABLE `vest_m` (
  `V_M_ID` bigint(20) UNSIGNED NOT NULL,
  `F_cus_id` bigint(20) UNSIGNED NOT NULL,
  `size` enum('S','L') NOT NULL,
  `Vest_Type` varchar(50) DEFAULT NULL,
  `vest_rate` decimal(10,2) NOT NULL,
  `Height` varchar(50) DEFAULT NULL,
  `Shoulder` varchar(50) DEFAULT NULL,
  `Armpit` varchar(50) DEFAULT NULL,
  `Waist` varchar(20) DEFAULT NULL,
  `Shana` varchar(50) DEFAULT NULL,
  `Kalar` varchar(50) DEFAULT NULL,
  `Daman` varchar(50) DEFAULT NULL,
  `NawaWaskat` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `O_date` date DEFAULT NULL,
  `R_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vest_m`
--

INSERT INTO `vest_m` (`V_M_ID`, `F_cus_id`, `size`, `Vest_Type`, `vest_rate`, `Height`, `Shoulder`, `Armpit`, `Waist`, `Shana`, `Kalar`, `Daman`, `NawaWaskat`, `Status`, `O_date`, `R_date`, `created_at`, `updated_at`) VALUES
(1, 2, 'L', 'واسكت', 100.00, '2', '2', '2', '2', 'سیده', 'هفت', 'چهار کنج', 'چرمه دار', 'complete', '2025-08-31', '2025-08-31', '2025-09-02 17:53:18', NULL),
(2, 4, 'L', 'كورتي', 100.00, '2', '2', '2', '2', 'نیمه دون', 'هفت', 'چهار کنج', 'چرمه دار', 'pending', '2025-08-31', '2025-08-31', '2025-09-02 20:35:56', NULL),
(4, 7, 'L', 'واسكت', 500.00, '2', '2', '2', '2', 'سیده', 'هفت', 'چهار کنج', 'چرمه دار', 'pending', '2025-09-07', '2025-09-07', '2025-09-07 18:57:35', NULL),
(5, 9, 'L', 'واسكت', 500.00, '2', '2', '2', '2', 'سیده', 'هفت', 'چهار کنج', 'چرمه دار', 'pending', '2025-09-07', '2025-09-07', '2025-09-07 21:07:08', NULL);

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
-- Indexes for table `cloth_assignment`
--
ALTER TABLE `cloth_assignment`
  ADD PRIMARY KEY (`ca_id`),
  ADD KEY `cloth_assignment_f_cm_id_foreign` (`F_cm_id`),
  ADD KEY `cloth_assignment_f_vm_id_foreign` (`F_vm_id`),
  ADD KEY `cloth_assignment_f_emp_id_foreign` (`F_emp_id`);

--
-- Indexes for table `cloth_m`
--
ALTER TABLE `cloth_m`
  ADD PRIMARY KEY (`cm_id`),
  ADD KEY `cloth_m_f_cus_id_foreign` (`F_cus_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_id`),
  ADD KEY `customer_f_pho_id_foreign` (`F_pho_id`),
  ADD KEY `customer_f_inv_id_foreign` (`F_inv_id`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_payments_customer_id_payment_date_index` (`customer_id`,`payment_date`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `employee_user_id_foreign` (`user_id`),
  ADD KEY `F_user_id` (`F_user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoice_tb`
--
ALTER TABLE `invoice_tb`
  ADD PRIMARY KEY (`inc_id`);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `payment_f_inc_id_foreign` (`F_inc_id`),
  ADD KEY `payment_f_emp_id_foreign` (`F_emp_id`),
  ADD KEY `F_phone_id` (`F_phone_id`);

--
-- Indexes for table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`pho_id`);

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
-- Indexes for table `vest_m`
--
ALTER TABLE `vest_m`
  ADD PRIMARY KEY (`V_M_ID`),
  ADD KEY `vest_m_f_cus_id_foreign` (`F_cus_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cloth_assignment`
--
ALTER TABLE `cloth_assignment`
  MODIFY `ca_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cloth_m`
--
ALTER TABLE `cloth_m`
  MODIFY `cm_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_tb`
--
ALTER TABLE `invoice_tb`
  MODIFY `inc_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `phone`
--
ALTER TABLE `phone`
  MODIFY `pho_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vest_m`
--
ALTER TABLE `vest_m`
  MODIFY `V_M_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cloth_assignment`
--
ALTER TABLE `cloth_assignment`
  ADD CONSTRAINT `cloth_assignment_f_cm_id_foreign` FOREIGN KEY (`F_cm_id`) REFERENCES `cloth_m` (`cm_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cloth_assignment_f_emp_id_foreign` FOREIGN KEY (`F_emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cloth_assignment_f_vm_id_foreign` FOREIGN KEY (`F_vm_id`) REFERENCES `vest_m` (`V_M_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cloth_m`
--
ALTER TABLE `cloth_m`
  ADD CONSTRAINT `cloth_m_f_cus_id_foreign` FOREIGN KEY (`F_cus_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_f_inv_id_foreign` FOREIGN KEY (`F_inv_id`) REFERENCES `invoice_tb` (`inc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_f_pho_id_foreign` FOREIGN KEY (`F_pho_id`) REFERENCES `phone` (`pho_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD CONSTRAINT `customer_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`F_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_f_emp_id_foreign` FOREIGN KEY (`F_emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_f_inc_id_foreign` FOREIGN KEY (`F_inc_id`) REFERENCES `invoice_tb` (`inc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`F_phone_id`) REFERENCES `phone` (`pho_id`);

--
-- Constraints for table `vest_m`
--
ALTER TABLE `vest_m`
  ADD CONSTRAINT `vest_m_f_cus_id_foreign` FOREIGN KEY (`F_cus_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
