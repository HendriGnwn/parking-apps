-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2016 at 09:40 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secure_parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('operator', '2', 1476440832),
('owner', '5', 1476440843),
('superadmin', '1', 1475747475);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1475747442, 1475747442),
('/admin/route/*', 2, NULL, NULL, NULL, 1475747322, 1475747322),
('/gate/*', 2, NULL, NULL, NULL, 1475812448, 1475812448),
('/gate/bulk-delete', 2, NULL, NULL, NULL, 1475812456, 1475812456),
('/gate/create', 2, NULL, NULL, NULL, 1475812456, 1475812456),
('/gate/delete', 2, NULL, NULL, NULL, 1475812456, 1475812456),
('/gate/index', 2, NULL, NULL, NULL, 1475812456, 1475812456),
('/gate/update', 2, NULL, NULL, NULL, 1475812456, 1475812456),
('/gate/view', 2, NULL, NULL, NULL, 1475812456, 1475812456),
('/payment/*', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/payment/bulk-delete', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/payment/create', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/payment/delete', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/payment/index', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/payment/update', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/payment/view', 2, NULL, NULL, NULL, 1475812813, 1475812813),
('/report/*', 2, NULL, NULL, NULL, 1476428280, 1476428280),
('/report/index', 2, NULL, NULL, NULL, 1476428280, 1476428280),
('/report/transaction', 2, NULL, NULL, NULL, 1476428280, 1476428280),
('/report/voucher', 2, NULL, NULL, NULL, 1476436472, 1476436472),
('/shift/*', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/shift/bulk-delete', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/shift/create', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/shift/delete', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/shift/index', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/shift/update', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/shift/view', 2, NULL, NULL, NULL, 1475812808, 1475812808),
('/site/index', 2, NULL, NULL, NULL, 1475748415, 1475748415),
('/transaction/*', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/ajax-calculate-by-code-and-police-number', 2, NULL, NULL, NULL, 1476436483, 1476436483),
('/transaction/bulk-delete', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/create', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/create-out', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/delete', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/index', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/print-in', 2, NULL, NULL, NULL, 1477120161, 1477120161),
('/transaction/print-out', 2, NULL, NULL, NULL, 1477120161, 1477120161),
('/transaction/update', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transaction/view', 2, NULL, NULL, NULL, 1476068480, 1476068480),
('/transport-price/*', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport-price/ajax-get-data', 2, NULL, NULL, NULL, 1476436483, 1476436483),
('/transport-price/bulk-delete', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport-price/create', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport-price/delete', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport-price/index', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport-price/update', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport-price/view', 2, NULL, NULL, NULL, 1475822373, 1475822373),
('/transport/*', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/transport/bulk-delete', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/transport/create', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/transport/delete', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/transport/index', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/transport/update', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/transport/view', 2, NULL, NULL, NULL, 1475822172, 1475822172),
('/user/admin/*', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/assignments', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/block', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/confirm', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/create', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/delete', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/index', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/info', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/update', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/admin/update-profile', 2, NULL, NULL, NULL, 1476335622, 1476335622),
('/user/settings/*', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/account', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/confirm', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/delete', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/disconnect', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/information', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/networks', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/user/settings/profile', 2, NULL, NULL, NULL, 1476440983, 1476440983),
('/voucher/*', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('/voucher/ajax-get-data-with-relate-transport-price', 2, NULL, NULL, NULL, 1476436473, 1476436473),
('/voucher/bulk-delete', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('/voucher/create', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('/voucher/delete', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('/voucher/index', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('/voucher/update', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('/voucher/view', 2, NULL, NULL, NULL, 1475826326, 1475826326),
('operator', 1, NULL, NULL, NULL, 1476345342, 1476345342),
('owner', 1, NULL, NULL, NULL, 1476428247, 1476428247),
('superadmin', 1, NULL, NULL, NULL, 1475747391, 1476345225);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('superadmin', '/*'),
('owner', '/report/*'),
('operator', '/site/index'),
('owner', '/site/index'),
('operator', '/transaction/ajax-calculate-by-code-and-police-number'),
('operator', '/transaction/create'),
('operator', '/transaction/create-out'),
('operator', '/transaction/index'),
('operator', '/transaction/print-in'),
('operator', '/transaction/print-out'),
('operator', '/transaction/view'),
('operator', '/transport-price/ajax-get-data'),
('owner', '/transport-price/ajax-get-data'),
('owner', '/user/admin/block'),
('owner', '/user/admin/create'),
('owner', '/user/admin/index'),
('owner', '/user/admin/info'),
('owner', '/user/admin/update'),
('operator', '/user/settings/account'),
('owner', '/user/settings/account'),
('operator', '/user/settings/information'),
('owner', '/user/settings/information'),
('operator', '/user/settings/profile'),
('owner', '/user/settings/profile'),
('operator', '/voucher/ajax-get-data-with-relate-transport-price'),
('owner', '/voucher/ajax-get-data-with-relate-transport-price'),
('operator', '/voucher/create'),
('owner', '/voucher/create'),
('operator', '/voucher/index'),
('owner', '/voucher/index'),
('operator', '/voucher/update'),
('owner', '/voucher/update'),
('operator', '/voucher/view'),
('owner', '/voucher/view'),
('superadmin', 'operator'),
('superadmin', 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gate`
--

CREATE TABLE IF NOT EXISTS `gate` (
  `id` int(11) NOT NULL,
  `name` char(100) NOT NULL,
  `gate_type` int(11) NOT NULL COMMENT '1=Gate In;2=Gate Out',
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gate`
--

INSERT INTO `gate` (`id`, `name`, `gate_type`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'MASUK-1', 1, 1, '2016-10-07 05:40:45', '2016-10-07 05:44:09', 1, 1),
(2, 'KELUAR-1', 2, 1, '2016-10-10 16:25:30', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
(1, 'Dashboard', NULL, '/site/index', 0, NULL),
(2, 'Data', NULL, '/gate/index', 30, 0x72657475726e205b2776697369626c65273d3e5c5969693a3a246170702d3e757365722d3e63616e2827737570657261646d696e27295d3b),
(3, 'Palang Pintu', 2, '/gate/index', 10, NULL),
(4, 'Pembayaran', 2, '/payment/index', 20, NULL),
(5, 'Transportasi', 2, '/transport/index', 30, NULL),
(6, 'Harga Transportasi', 2, '/transport-price/index', 40, NULL),
(7, 'Voucher', NULL, '/voucher/index', 10, NULL),
(8, 'Transaksi', NULL, '/transaction/index', 5, 0x72657475726e205b2776697369626c65273d3e5c5969693a3a246170702d3e757365722d3e63616e28276f70657261746f7227295d3b),
(9, 'Daftar', 8, '/transaction/index', 0, NULL),
(10, 'Transaksi Masuk', 8, '/transaction/create', 5, NULL),
(11, 'Transaksi Keluar', 8, '/transaction/create-out', 8, NULL),
(12, 'User', NULL, '/user/admin/index', 100, NULL),
(14, 'Shift', 2, '/shift/index', 11, NULL),
(16, 'Laporan', NULL, '/report/transaction', 6, 0x72657475726e205b2776697369626c65273d3e5c5969693a3a246170702d3e757365722d3e63616e28276f776e657227295d3b),
(17, 'Semua Transaksi', 16, '/report/transaction', 5, NULL),
(18, 'Voucher', 16, '/report/voucher', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1475722915),
('m140209_132017_init', 1475723204),
('m140403_174025_create_account_table', 1475723206),
('m140504_113157_update_tables', 1475723210),
('m140504_130429_create_token_table', 1475723212),
('m140506_102106_rbac_init', 1475724326),
('m140602_111327_create_menu_table', 1475722931),
('m140830_171933_fix_ip_field', 1475723212),
('m140830_172703_change_account_table_name', 1475723212),
('m141222_110026_update_ip_field', 1475723214),
('m141222_135246_alter_username_length', 1475723214),
('m150614_103145_update_social_account_table', 1475723216),
('m150623_212711_fix_username_notnull', 1475723217),
('m151218_234654_add_timezone_to_profile', 1475723217),
('m160312_050000_create_user', 1475722932);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `class` char(100) DEFAULT NULL,
  `description` varchar(600) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `name`, `class`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'CASH', NULL, 'Jenis pembayaran langsung tunai', 1, '2016-10-07 06:24:28', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(1, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Pacific/Apia'),
(2, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', NULL, NULL),
(5, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Pacific/Apia');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `name` char(100) NOT NULL,
  `value` text NOT NULL,
  `label` varchar(100) NOT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `value`, `label`, `note`) VALUES
('admin_email', 'hendri.gnw@gmail.com', 'Hendri Gunawan', NULL),
('app_name', 'RS. Asy-Syifaa', 'Application Name', NULL),
('company_address', 'Jl Raya Leuwiliang Kab. Bogor', 'Company Address', NULL),
('company_email', 'hendri.gnw@gmail.com', 'Company Email', NULL),
('company_name', 'Artcorp Technology', 'Company Name', NULL),
('company_phone', '021 9000081', 'Company Phone', NULL),
('copyright', '&copy; Hendri Gunawan', 'Copyright', NULL),
('developer_email', 'hendri.gnw@gmail.com', 'Hendri Gunawan', NULL),
('send_mail', '1', 'Send Mail', NULL),
('struct_entry_footer', 'Jangan tinggalkan tiket dan barang berharga lainnya di kendaraan Anda. Segala kerusakan dan kehilangan Bukan Tanggung Jawab Pengelola Parkir.', 'Struk masuk', NULL),
('struct_exit_footer', 'Terima Kasih atas kunjungan Anda', 'Struk keluar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `id` int(11) NOT NULL,
  `name` char(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

CREATE TABLE IF NOT EXISTS `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL,
  `code` char(100) NOT NULL,
  `police_number` char(100) NOT NULL,
  `gate_in_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `gate_out_id` int(11) DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1=Entry;2=Exit;',
  `payment_status` int(11) NOT NULL COMMENT '1=Draft;5=Waiting;10=Paid;',
  `transport_price_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `final_amount` decimal(14,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL,
  `name` char(100) NOT NULL,
  `description` varchar(600) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive;',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Reguler', 'Transport biasa', 1, '2016-10-05 17:09:00', NULL, 1, NULL),
(2, 'Member', 'Transport yang memiliki voucher', 1, '2016-10-05 17:09:00', NULL, 1, NULL),
(3, 'Karyawan', 'Transport khusus untuk karyawan, dan gratis', 1, '2016-10-05 17:09:00', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transport_price`
--

CREATE TABLE IF NOT EXISTS `transport_price` (
  `id` int(11) NOT NULL,
  `transport_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `code` char(100) NOT NULL,
  `name` char(100) NOT NULL,
  `amount_1` decimal(14,2) DEFAULT NULL,
  `amount_2` decimal(14,2) DEFAULT NULL,
  `amount_3` decimal(14,2) DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL COMMENT 'Max Amount',
  `limit` int(11) DEFAULT NULL COMMENT 'within days',
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive;',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transport_price`
--

INSERT INTO `transport_price` (`id`, `transport_id`, `vehicle_id`, `code`, `name`, `amount_1`, `amount_2`, `amount_3`, `amount`, `limit`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, '11', 'Motor', '2000.00', '3000.00', '4000.00', '5000.00', NULL, 1, '2016-10-07 09:33:05', NULL, 1, 1),
(2, 1, 2, '12', 'Mobil', '4000.00', '5000.00', '6000.00', '7000.00', NULL, 1, '2016-10-07 09:34:03', NULL, 1, 1),
(3, 1, 3, '13', 'Mobil Besar', '5000.00', '6000.00', '7000.00', '8000.00', NULL, 1, '2016-10-07 09:34:57', NULL, 1, 1),
(4, 2, 1, '21', 'Motor', NULL, NULL, NULL, '10000.00', 30, 1, '2016-10-07 09:36:13', NULL, 1, 1),
(5, 2, 2, '22', 'Mobil', NULL, NULL, NULL, '20000.00', 30, 1, '2016-10-07 09:37:01', '2016-10-07 09:41:08', 1, 1),
(6, 2, 3, '23', 'Mobil Besar', NULL, NULL, NULL, '30000.00', 30, 1, '2016-10-07 09:37:23', NULL, 1, 1),
(7, 3, 1, '31', 'Motor', NULL, NULL, NULL, '0.00', 0, 1, '2016-10-07 09:38:03', NULL, 1, 1),
(8, 3, 2, '32', 'Mobil', NULL, NULL, NULL, '0.00', 0, 1, '2016-10-07 09:38:03', NULL, 1, 1),
(9, 3, 3, '33', 'Mobil Besar', NULL, NULL, NULL, '0.00', 0, 1, '2016-10-07 09:38:03', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `gate_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `online` int(11) DEFAULT NULL,
  `online_date` datetime DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `gate_id`, `shift_id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `online`, `online_date`, `created_at`, `updated_at`, `flags`) VALUES
(1, 0, 0, 'admin', 'hendri.gnw@gmail.com', '$2y$10$Y98GQUuS7BMGcyiznKUPOeIH.OiXQPkKrW5bmc4VJUw67nADR5c.q', 'oyFsVxIqIksQr2WQWSWIt42GcSOUUIAS', 1475747026, NULL, NULL, '::1', 0, '2016-10-22 14:27:45', 1475746427, 1477121769, 0),
(2, 1, 0, 'operator', 'hendrigunawan195@gmail.com', '$2y$10$EMxtCm4bFkBYh5.OBOJrju0aiijvd/dsZqVvr1uoaxYVjteghOBBu', '4jdPs4T7jmgKhsq2N1XxheG2mQ7LooBV', 1476344540, NULL, NULL, '::1', 0, '2016-10-22 14:36:14', 1476344540, 1477121961, 0),
(5, 0, 0, 'owner', 'hendri.gunawan@computesta.com', '$2y$10$eyLJGvFpfoTM8m1QPwv0nOfMMlZHLRcVwPvN3bitIz1A0mmv8ysR2', 'pcI7UqejJ0UaCgE7otSKi9WYywi4tk5B', 1476348422, NULL, NULL, '::1', 0, '2016-10-22 14:39:27', 1476348422, 1477121972, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(11) NOT NULL,
  `name` char(100) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive;',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Motor', 1, '2016-10-05 17:09:00', NULL, 1, NULL),
(2, 'Mobil', 1, '2016-10-05 17:09:00', NULL, 1, NULL),
(3, 'Mobil Besar', 1, '2016-10-05 17:09:00', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE IF NOT EXISTS `voucher` (
  `id` int(11) NOT NULL,
  `code` char(100) NOT NULL COMMENT 'can be filled with code or police number',
  `transport_price_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `voucher_type` int(11) NOT NULL COMMENT '1=Code;2=Police Number',
  `voucher_type_amount` int(11) NOT NULL COMMENT '1=Fix;2=Percent;',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `limit` int(11) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;2=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `gate`
--
ALTER TABLE `gate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_unique` (`provider`,`client_id`),
  ADD UNIQUE KEY `account_unique_code` (`code`),
  ADD KEY `fk_user_account` (`user_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_price_id` (`transport_price_id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_price`
--
ALTER TABLE `transport_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `name` (`name`),
  ADD KEY `transport_id` (`transport_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_email` (`email`),
  ADD UNIQUE KEY `user_unique_username` (`username`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_price_id` (`transport_price_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gate`
--
ALTER TABLE `gate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transport_price`
--
ALTER TABLE `transport_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_price`
--
ALTER TABLE `transport_price`
  ADD CONSTRAINT `transport_price_ibfk_4` FOREIGN KEY (`transport_id`) REFERENCES `transport` (`id`) ON DELETE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
