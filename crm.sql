-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 13, 2024 at 10:01 AM
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
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `email_address` varchar(100) NOT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lead_id` int(11) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `client_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_reports`
--

CREATE TABLE `daily_reports` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` int(11) NOT NULL,
  `day` enum('monday','tuesday','wednesday','thursday','friday') NOT NULL,
  `report` text DEFAULT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_submitted` tinyint(1) NOT NULL DEFAULT 0,
  `report_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_reports`
--

INSERT INTO `daily_reports` (`id`, `created_at`, `updated_at`, `employee_id`, `day`, `report`, `report_date`, `is_submitted`, `report_id`) VALUES
(55, '2024-11-28 23:20:13', '2024-11-28 20:20:13', 4, 'thursday', 'smms', '2024-11-27 21:00:00', 1, 11),
(56, '2024-11-28 23:26:16', '2024-11-28 20:26:16', 5, 'thursday', 'today was a busy day, met CRM client.', '2024-11-27 21:00:00', 1, 12),
(57, '2024-12-02 13:55:42', '2024-12-02 10:55:42', 5, 'monday', 'Monday was a busy day.\n\n<strong>Met the first lead.</strong>', '2024-12-01 21:00:00', 1, 13),
(58, '2024-12-04 06:16:06', '2024-12-04 03:16:06', 6, 'monday', 'Onboarded interns about the company.', '2024-12-01 21:00:00', 1, 14),
(62, '2024-12-09 07:56:16', '2024-12-09 04:56:16', 13, 'monday', 'Muchiri\'s Monday report.', '2024-12-08 21:00:00', 1, 18),
(70, '2024-12-10 14:08:36', '2024-12-10 11:08:36', 19, 'tuesday', 'abc', '2024-12-09 21:00:00', 1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `description`, `created_at`, `updated_at`, `employee_id`) VALUES
(6, 'Finance', 'Accounting', '2024-12-09 09:17:27', '2024-12-09 06:17:27', 19);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `full_name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `email`, `phone_number`, `created_at`, `updated_at`, `department_id`, `full_name`) VALUES
(19, 'Muchiri.kinyua6564@gmail.com', 798765432, '2024-12-09 06:10:14', '2024-12-09 06:10:14', 6, 'Muchiri Kinyua'),
(20, 'superadmin@gmail.com', 712346789, '2024-12-10 11:11:41', '2024-12-10 11:11:41', 6, 'super admin');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `records` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `interactions_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `source` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `employee_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lead_date` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `interaction_type` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_employee`
--

CREATE TABLE `lead_employee` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_product`
--

CREATE TABLE `lead_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2),
(6, '2024_11_13_123631_rename_client_id_in_orders', 3),
(7, '2024_11_13_143603_add_client_id_to_orders', 4),
(8, '2024_11_15_120947_add_product_id_to_leads_table', 5),
(9, '2024_11_17_181742_add_employee_id_to_clients_table', 6),
(10, '2024_11_17_182116_add_employee_id_to_clients_table', 6),
(11, '2024_11_20_084433_add_employee_id_to_interactions_table', 7),
(14, '2024_11_22_115628_add_order_ref_number_to_orders_table', 8),
(15, '2024_11_22_171126_create_lead_product_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 4),
(7, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 6),
(10, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_ordered` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) DEFAULT NULL,
  `order_ref_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `quantity_ordered`, `unit_price`, `total_price`, `order_date`, `status`, `client`, `lead_id`, `type`, `created_at`, `updated_at`, `client_id`, `order_ref_number`) VALUES
(32, NULL, NULL, NULL, 100000, '2024-12-04', 'Pending', NULL, 99, NULL, '2024-12-03 15:50:38', '2024-12-03 15:50:38', 28, 'ORD-20241203-3262'),
(33, NULL, NULL, NULL, 100000, '2024-12-05', 'Pending', NULL, 99, NULL, '2024-12-03 15:52:32', '2024-12-03 15:52:32', 28, 'ORD-20241203-9933'),
(34, NULL, NULL, NULL, 250000, '2024-12-07', 'Pending', NULL, 99, NULL, '2024-12-03 15:54:25', '2024-12-03 15:54:25', 28, 'ORD-20241203-5195');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total_price`, `created_at`, `updated_at`) VALUES
(22, 32, 6, 1, 100000.00, 100000.00, '2024-12-03 15:50:38', '2024-12-03 15:50:38'),
(23, 33, 7, 2, 50000.00, 100000.00, '2024-12-03 15:52:32', '2024-12-03 15:52:32'),
(24, 34, 6, 2, 100000.00, 200000.00, '2024-12-03 15:54:25', '2024-12-03 15:54:25'),
(25, 34, 7, 1, 50000.00, 50000.00, '2024-12-03 15:54:25', '2024-12-03 15:54:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guard_name` varchar(255) DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`, `guard_name`) VALUES
(3, 'updaterole-edit', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(4, 'deleterole-delete', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(5, 'createcategory-list', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(6, 'viewcategory-create', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(7, 'updatecategory-edit', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(8, 'deletecategory-delete', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(9, 'createpermission-list', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(10, 'viewpermission-create', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(11, 'updatepermission-edit', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(12, 'deletepermission-delete', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(13, 'casecategory-list', '2024-11-08 23:31:32', '2024-11-08 23:31:32', 'web'),
(14, 'casecategory-create', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(15, 'casecategory-edit', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(16, 'casecategory-delete', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(17, 'casefile-list', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(18, 'casefile-create', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(19, 'casefile-edit', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(20, 'casefile-delete', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(21, 'casefolder-list', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(22, 'casefolder-create', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(23, 'casefolder-edit', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(24, 'casefolder-delete', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(25, 'document-list', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(26, 'document-create', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(27, 'document-edit', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(28, 'document-delete', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(29, 'documentpagecount-list', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(30, 'documentpagecount-create', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(31, 'documentpagecount-edit', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(32, 'documentpagecount-delete', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(33, 'documenttype-list', '2024-11-08 23:31:33', '2024-11-08 23:31:33', 'web'),
(34, 'documenttype-create', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(35, 'documenttype-edit', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(36, 'documenttype-delete', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(37, 'field-list', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(38, 'field-create', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(39, 'field-edit', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(40, 'field-delete', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(41, 'fieldcategory-list', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(42, 'fieldcategory-create', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(43, 'fieldcategory-edit', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(44, 'fieldcategory-delete', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(45, 'fileretention-list', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(46, 'fileretention-create', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(47, 'fileretention-edit', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(48, 'fileretention-delete', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(49, 'fileretentiondate-list', '2024-11-08 23:31:34', '2024-11-08 23:31:34', 'web'),
(50, 'fieldcategorydate-create', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(51, 'fileretentiondate-edit', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(52, 'fileretentiondate-delete', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(53, 'form-list', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(54, 'form-create', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(55, 'form-edit', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(56, 'form-delete', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(57, 'log-list', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(58, 'log-create', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(59, 'log-edit', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(60, 'log-delete', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(61, 'metadatadefinition-list', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(62, 'metadatadefinition-create', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(63, 'metadatadefinition-edit', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(64, 'metadatadefinition-delete', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(65, 'metadatavalue-list', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(66, 'metadatavalue-create', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(67, 'metadatavalue-edit', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(68, 'metadatavalue-delete', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(69, 'permission-list', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(70, 'permission-create', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(71, 'permission-edit', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(72, 'permission-delete', '2024-11-08 23:31:35', '2024-11-08 23:31:35', 'web'),
(73, 'role-list', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(74, 'role-create', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(75, 'role-edit', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(76, 'role-delete', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(77, 'user-list', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(78, 'user-create', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(79, 'user-edit', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(80, 'user-delete', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(81, 'workflow-list', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(82, 'workflow-create', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(83, 'workflow-edit', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(84, 'workflow-delete', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(85, 'workflowrule-list', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(86, 'workflowrule-create', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(87, 'workflowrule-edit', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(88, 'workflowrule-delete', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(89, 'workflowstep-list', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(90, 'workflowstep-create', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(91, 'workflowstep-edit', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(92, 'workflowstep-delete', '2024-11-08 23:31:36', '2024-11-08 23:31:36', 'web'),
(93, 'documentrequirement-list', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(94, 'documentrequirement-create', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(95, 'documentrequirement-edit', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(96, 'documentrequirement-delete', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(97, 'documentsignature-list', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(98, 'documentsignature-create', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(99, 'documentsignature-edit', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(100, 'documentsignature-delete', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(101, 'duplicatedocument-list', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(102, 'duplicatedocument-create', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(103, 'duplicatedocument-edit', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(104, 'duplicatedocument-delete', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(105, 'file-list', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(106, 'file-create', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(107, 'file-edit', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(108, 'file-delete', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(109, 'filestore-list', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(110, 'filestore-create', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(111, 'filestore-edit', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(112, 'filestore-delete', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(113, 'license-list', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(114, 'license-create', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(115, 'license-edit', '2024-11-08 23:31:37', '2024-11-08 23:31:37', 'web'),
(116, 'license-delete', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(117, 'licensesession-list', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(118, 'licensesession-create', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(119, 'licensesession-edit', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(120, 'licensesession-delete', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(121, 'mfacode-list', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(122, 'mfacode-create', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(123, 'mfacode-edit', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(124, 'mfacode-delete', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(125, 'smsconfiguration-list', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(126, 'smsconfiguration-create', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(127, 'smsconfiguration-edit', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(128, 'smsconfiguration-delete', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(129, 'smtpconfiguration-list', '2024-11-08 23:31:38', '2024-11-08 23:31:38', 'web'),
(130, 'smtpconfiguration-create', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(131, 'smtpconfiguration-edit', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(132, 'smtpconfiguration-delete', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(133, 'userkey-list', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(134, 'userkey-create', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(135, 'userkey-edit', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(136, 'userkey-delete', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(137, 'workflowdocument-list', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(138, 'workflowdocument-create', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(139, 'workflowdocument-edit', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(140, 'workflowdocument-delete', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(141, 'workflowinstance-list', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(142, 'workflowinstance-create', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(143, 'workflowinstance-edit', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(144, 'workflowinstance-delete', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(145, 'workflowstepaction-list', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(146, 'workflowstepaction-create', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(147, 'workflowstepaction-edit', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(148, 'workflowstepaction-delete', '2024-11-08 23:31:39', '2024-11-08 23:31:39', 'web'),
(149, 'workflowstepcomment-list', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(150, 'workflowstepcomment-create', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(151, 'workflowstepcomment-edit', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(152, 'workflowstepcomment-delete', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(153, 'workflowsteprequirement-list', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(154, 'workflowsteprequirement-create', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(155, 'workflowsteprequirement-edit', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(156, 'workflowsteprequirement-delete', '2024-11-08 23:31:40', '2024-11-08 23:31:40', 'web'),
(157, 'createrole-list', '2024-12-11 02:35:26', '2024-12-11 02:35:26', 'web'),
(162, 'viewrole-list', '2024-12-11 03:22:59', '2024-12-11 03:22:59', 'web');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `quantity_available` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `monday` text DEFAULT NULL,
  `tuesday` text DEFAULT NULL,
  `wednesday` text DEFAULT NULL,
  `thursday` text DEFAULT NULL,
  `friday` text DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `employee_id`, `report_date`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `summary`, `created_at`, `updated_at`, `department_id`) VALUES
(24, 19, '2024-12-09', 'abc', NULL, NULL, NULL, NULL, NULL, '2024-12-09 06:58:32', '2024-12-09 06:58:38', NULL),
(25, 19, '2024-12-10', NULL, 'abc', NULL, NULL, NULL, NULL, '2024-12-10 11:08:31', '2024-12-10 11:08:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guard_name` varchar(255) DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`, `guard_name`) VALUES
(1, 'super admin', '2024-11-12 02:05:03', '2024-12-11 04:16:22', 'web'),
(3, 'admin', '2024-11-12 02:05:20', '2024-11-12 02:05:20', 'web'),
(6, 'Intern', '2024-12-04 10:55:09', '2024-12-04 10:56:32', 'web'),
(7, 'head of department', '2024-12-10 06:24:18', '2024-12-11 04:16:18', 'web'),
(10, 'financial accountant', '2024-12-11 03:22:33', '2024-12-11 04:16:29', 'web');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 1),
(6, 1),
(6, 3),
(7, 1),
(7, 3),
(8, 1),
(8, 3),
(9, 1),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(16, 1),
(16, 3),
(17, 1),
(17, 3),
(18, 1),
(18, 3),
(19, 1),
(19, 3),
(20, 1),
(20, 3),
(21, 1),
(22, 1),
(22, 3),
(23, 1),
(23, 3),
(24, 1),
(24, 3),
(25, 1),
(25, 3),
(26, 1),
(26, 3),
(27, 1),
(28, 1),
(28, 3),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 3),
(36, 1),
(36, 3),
(37, 1),
(37, 3),
(38, 1),
(38, 3),
(39, 1),
(39, 3),
(40, 1),
(40, 3),
(41, 1),
(41, 3),
(42, 1),
(42, 3),
(43, 1),
(43, 3),
(44, 1),
(44, 3),
(45, 1),
(45, 3),
(46, 1),
(46, 3),
(47, 1),
(47, 3),
(48, 1),
(48, 3),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 3),
(52, 1),
(52, 3),
(53, 1),
(53, 3),
(54, 1),
(54, 3),
(55, 1),
(55, 3),
(56, 1),
(56, 3),
(57, 1),
(57, 3),
(58, 1),
(58, 3),
(59, 1),
(59, 3),
(60, 1),
(60, 3),
(61, 1),
(61, 3),
(62, 1),
(62, 3),
(63, 1),
(63, 3),
(64, 1),
(64, 3),
(65, 1),
(65, 3),
(66, 1),
(66, 3),
(67, 1),
(67, 3),
(68, 1),
(68, 3),
(69, 1),
(69, 3),
(70, 1),
(70, 3),
(71, 1),
(71, 3),
(72, 1),
(72, 3),
(73, 1),
(73, 3),
(74, 1),
(74, 3),
(75, 1),
(75, 3),
(76, 1),
(76, 3),
(77, 1),
(77, 3),
(78, 1),
(78, 3),
(79, 1),
(79, 3),
(80, 1),
(80, 3),
(81, 1),
(81, 3),
(82, 1),
(82, 3),
(83, 1),
(83, 3),
(84, 1),
(84, 3),
(85, 1),
(85, 3),
(86, 1),
(86, 3),
(86, 6),
(87, 1),
(87, 3),
(88, 1),
(88, 3),
(89, 1),
(89, 3),
(90, 1),
(90, 3),
(91, 1),
(91, 3),
(92, 1),
(92, 3),
(93, 1),
(93, 3),
(94, 1),
(94, 3),
(95, 1),
(95, 3),
(95, 6),
(96, 1),
(96, 3),
(97, 1),
(97, 3),
(98, 1),
(98, 3),
(98, 6),
(99, 1),
(99, 3),
(100, 1),
(100, 3),
(101, 1),
(101, 3),
(101, 6),
(102, 1),
(102, 3),
(103, 1),
(103, 3),
(104, 1),
(104, 3),
(105, 1),
(105, 3),
(106, 1),
(106, 3),
(107, 1),
(107, 3),
(108, 1),
(108, 3),
(109, 1),
(109, 3),
(110, 1),
(110, 3),
(110, 6),
(111, 1),
(111, 3),
(112, 1),
(112, 3),
(113, 1),
(113, 3),
(113, 6),
(114, 1),
(114, 3),
(115, 1),
(115, 3),
(116, 1),
(116, 3),
(117, 1),
(117, 3),
(118, 1),
(118, 3),
(119, 1),
(119, 3),
(119, 6),
(120, 1),
(120, 3),
(121, 1),
(121, 3),
(122, 1),
(122, 3),
(123, 1),
(123, 3),
(124, 1),
(124, 3),
(125, 1),
(125, 3),
(126, 1),
(126, 3),
(127, 1),
(127, 3),
(128, 1),
(128, 3),
(129, 1),
(129, 3),
(129, 6),
(130, 1),
(130, 3),
(131, 1),
(131, 3),
(132, 1),
(132, 3),
(133, 1),
(133, 3),
(134, 1),
(134, 3),
(135, 1),
(135, 3),
(136, 1),
(136, 3),
(137, 1),
(137, 3),
(138, 1),
(138, 3),
(139, 1),
(139, 3),
(140, 1),
(140, 3),
(141, 1),
(141, 3),
(142, 1),
(142, 3),
(143, 1),
(143, 3),
(144, 1),
(144, 3),
(145, 1),
(145, 3),
(146, 1),
(146, 3),
(147, 1),
(147, 3),
(148, 1),
(148, 3),
(149, 1),
(149, 3),
(150, 1),
(150, 3),
(151, 1),
(151, 3),
(152, 1),
(152, 3),
(153, 1),
(153, 3),
(154, 1),
(154, 3),
(155, 1),
(155, 3),
(156, 1),
(156, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount_paid` float DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `transaction_reference` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `client_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Emmaculate', 'emmakatheu123@gmail.com', NULL, '$2y$12$X.4/jKMypvHkgNB7/ZgPXOsjaLeQjdFss9p0xCBn.b3kHRZiiZKs.', NULL, '2024-11-07 16:31:16', '2024-12-11 04:21:35'),
(2, 'Victor', 'okiomeriv@gmail.com', NULL, '$2y$12$OoLy7nCIG6CXnlPfzrDmb.15OfYjIlalx46LlVRcU/4wwqxGxBR7O', NULL, '2024-11-25 04:35:35', '2024-11-25 04:35:35'),
(3, 'Muchiri Kinyua', 'Muchiri.kinyua6564@gmail.com', NULL, '$2y$12$T9f35sklicoER.qsqlO0..y9sIewz7UPNrrvyafvEzFmhrgLOI5om', NULL, '2024-11-26 09:59:20', '2024-12-11 04:11:54'),
(4, 'staff', 'staff@gmail.com', NULL, '$2y$12$CobB2u00YL2/bCsRyX07auumun3xxujKj/Wqbpx.yoWqovsMvV34i', NULL, '2024-12-11 03:12:06', '2024-12-11 03:12:06'),
(6, 'Oluoch', 'oluoch@gmail.com', NULL, '$2y$12$PPwsZiNKvHXly6LAlrvzyeOV/3VZj9p6aN42nnKSiO47vdTr2rRgS', NULL, '2024-12-11 04:05:19', '2024-12-11 04:13:30'),
(7, 'superadmin', 'superadmin@gmail.com', NULL, '$2y$12$F5YrA8hibIeAV98ChOwLuetXMQIENAY1PiWS4wgR5sRrd.Y17NRhq', NULL, '2024-12-11 04:08:40', '2024-12-11 04:08:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_companies_company_id` (`phone_number`),
  ADD UNIQUE KEY `unq_customers_lead_id` (`lead_id`),
  ADD KEY `clients_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employees_departments` (`department_id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_interactions_customers` (`client_id`),
  ADD KEY `fk_interactions_leads` (`lead_id`),
  ADD KEY `fk_interactions_employees` (`employee_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_leads_employees` (`employee_id`(768));

--
-- Indexes for table `lead_employee`
--
ALTER TABLE `lead_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_product`
--
ALTER TABLE `lead_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_product_lead_id_foreign` (`lead_id`),
  ADD KEY `lead_product_product_id_foreign` (`product_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_ref_number_unique` (`order_ref_number`),
  ADD KEY `fk_orders_customers` (`client`),
  ADD KEY `fk_orders_products` (`product_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reports_employees` (`employee_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_transactions_order_id` (`order_id`),
  ADD KEY `fk_transactions_clients` (`client_id`);

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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `daily_reports`
--
ALTER TABLE `daily_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `lead_employee`
--
ALTER TABLE `lead_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_product`
--
ALTER TABLE `lead_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interactions_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lead_product`
--
ALTER TABLE `lead_product`
  ADD CONSTRAINT `lead_product_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lead_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_customers` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
