-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2016 at 07:44 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
('/gridview/export/*', 2, NULL, NULL, NULL, 1478924637, 1478924637),
('/gridview/export/download', 2, NULL, NULL, NULL, 1478924636, 1478924636),
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
('/report/transaction-today', 2, NULL, NULL, NULL, 1478924292, 1478924292),
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
('/transaction/print-in', 2, NULL, NULL, NULL, 1476962473, 1476962473),
('/transaction/print-out', 2, NULL, NULL, NULL, 1476962474, 1476962474),
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
('owner', '/gridview/export/*'),
('operator', '/gridview/export/download'),
('owner', '/report/*'),
('operator', '/report/transaction-today'),
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
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

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
(18, 'Voucher', 16, '/report/voucher', 10, NULL),
(19, 'Laporan Hari Ini', 8, '/report/transaction-today', 15, NULL);

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
 ADD PRIMARY KEY (`name`), ADD KEY `rule_name` (`rule_name`), ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
 ADD PRIMARY KEY (`parent`,`child`), ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`), ADD KEY `parent` (`parent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
