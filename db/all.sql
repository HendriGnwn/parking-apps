-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('operator',	'2',	1476440832),
('owner',	'5',	1476440843),
('superadmin',	'1',	1475747475);

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*',	2,	NULL,	NULL,	NULL,	1475747442,	1475747442),
('/admin/route/*',	2,	NULL,	NULL,	NULL,	1475747322,	1475747322),
('/gate/*',	2,	NULL,	NULL,	NULL,	1475812448,	1475812448),
('/gate/bulk-delete',	2,	NULL,	NULL,	NULL,	1475812456,	1475812456),
('/gate/create',	2,	NULL,	NULL,	NULL,	1475812456,	1475812456),
('/gate/delete',	2,	NULL,	NULL,	NULL,	1475812456,	1475812456),
('/gate/index',	2,	NULL,	NULL,	NULL,	1475812456,	1475812456),
('/gate/update',	2,	NULL,	NULL,	NULL,	1475812456,	1475812456),
('/gate/view',	2,	NULL,	NULL,	NULL,	1475812456,	1475812456),
('/gridview/export/*',	2,	NULL,	NULL,	NULL,	1478924637,	1478924637),
('/gridview/export/download',	2,	NULL,	NULL,	NULL,	1478924636,	1478924636),
('/payment/*',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/payment/bulk-delete',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/payment/create',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/payment/delete',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/payment/index',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/payment/update',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/payment/view',	2,	NULL,	NULL,	NULL,	1475812813,	1475812813),
('/report/*',	2,	NULL,	NULL,	NULL,	1476428280,	1476428280),
('/report/index',	2,	NULL,	NULL,	NULL,	1476428280,	1476428280),
('/report/transaction',	2,	NULL,	NULL,	NULL,	1476428280,	1476428280),
('/report/transaction-daily',	2,	NULL,	NULL,	NULL,	1508036471,	1508036471),
('/report/transaction-monthly',	2,	NULL,	NULL,	NULL,	1508036471,	1508036471),
('/report/transaction-per-gate',	2,	NULL,	NULL,	NULL,	1508036471,	1508036471),
('/report/transaction-recapitulation',	2,	NULL,	NULL,	NULL,	1481815912,	1481815912),
('/report/transaction-recapitulation-monthly',	2,	NULL,	NULL,	NULL,	1508036471,	1508036471),
('/report/transaction-today',	2,	NULL,	NULL,	NULL,	1478924292,	1478924292),
('/report/voucher',	2,	NULL,	NULL,	NULL,	1476436472,	1476436472),
('/shift/*',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/shift/bulk-delete',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/shift/create',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/shift/delete',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/shift/index',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/shift/update',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/shift/view',	2,	NULL,	NULL,	NULL,	1475812808,	1475812808),
('/site/index',	2,	NULL,	NULL,	NULL,	1475748415,	1475748415),
('/transaction/*',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/ajax-calculate-by-code-and-police-number',	2,	NULL,	NULL,	NULL,	1476436483,	1476436483),
('/transaction/bulk-delete',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/create',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/create-out',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/delete',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/index',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/print-in',	2,	NULL,	NULL,	NULL,	1476962473,	1476962473),
('/transaction/print-out',	2,	NULL,	NULL,	NULL,	1476962474,	1476962474),
('/transaction/update',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transaction/view',	2,	NULL,	NULL,	NULL,	1476068480,	1476068480),
('/transport-price/*',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport-price/ajax-get-data',	2,	NULL,	NULL,	NULL,	1476436483,	1476436483),
('/transport-price/bulk-delete',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport-price/create',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport-price/delete',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport-price/index',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport-price/update',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport-price/view',	2,	NULL,	NULL,	NULL,	1475822373,	1475822373),
('/transport/*',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/transport/bulk-delete',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/transport/create',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/transport/delete',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/transport/index',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/transport/update',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/transport/view',	2,	NULL,	NULL,	NULL,	1475822172,	1475822172),
('/user/admin/*',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/assignments',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/block',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/confirm',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/create',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/delete',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/index',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/info',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/update',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/admin/update-profile',	2,	NULL,	NULL,	NULL,	1476335622,	1476335622),
('/user/settings/*',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/account',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/confirm',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/delete',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/disconnect',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/information',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/networks',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/user/settings/profile',	2,	NULL,	NULL,	NULL,	1476440983,	1476440983),
('/voucher/*',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('/voucher/ajax-get-data-with-relate-transport-price',	2,	NULL,	NULL,	NULL,	1476436473,	1476436473),
('/voucher/bulk-delete',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('/voucher/create',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('/voucher/delete',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('/voucher/index',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('/voucher/update',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('/voucher/view',	2,	NULL,	NULL,	NULL,	1475826326,	1475826326),
('operator',	1,	NULL,	NULL,	NULL,	1476345342,	1476345342),
('owner',	1,	NULL,	NULL,	NULL,	1476428247,	1476428247),
('superadmin',	1,	NULL,	NULL,	NULL,	1475747391,	1476345225);

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('superadmin',	'/*'),
('owner',	'/gridview/export/*'),
('operator',	'/gridview/export/download'),
('owner',	'/report/*'),
('operator',	'/report/transaction-today'),
('operator',	'/site/index'),
('owner',	'/site/index'),
('operator',	'/transaction/ajax-calculate-by-code-and-police-number'),
('operator',	'/transaction/create'),
('operator',	'/transaction/create-out'),
('operator',	'/transaction/index'),
('operator',	'/transaction/print-in'),
('operator',	'/transaction/print-out'),
('operator',	'/transaction/view'),
('operator',	'/transport-price/ajax-get-data'),
('owner',	'/user/admin/block'),
('owner',	'/user/admin/create'),
('owner',	'/user/admin/index'),
('owner',	'/user/admin/info'),
('owner',	'/user/admin/update'),
('operator',	'/user/settings/account'),
('owner',	'/user/settings/account'),
('operator',	'/user/settings/information'),
('owner',	'/user/settings/information'),
('operator',	'/user/settings/profile'),
('owner',	'/user/settings/profile'),
('operator',	'/voucher/ajax-get-data-with-relate-transport-price'),
('owner',	'/voucher/ajax-get-data-with-relate-transport-price'),
('operator',	'/voucher/create'),
('owner',	'/voucher/create'),
('operator',	'/voucher/index'),
('owner',	'/voucher/index'),
('operator',	'/voucher/update'),
('owner',	'/voucher/update'),
('operator',	'/voucher/view'),
('owner',	'/voucher/view'),
('superadmin',	'operator'),
('superadmin',	'owner');

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `gate`;
CREATE TABLE `gate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `gate_type` int(11) NOT NULL COMMENT '1=Gate In;2=Gate Out',
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `idx_name_3232_00` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `gate` (`id`, `name`, `gate_type`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1,	'MASUK-1',	1,	1,	'2016-10-07 05:40:45',	'2016-10-07 05:44:09',	1,	1),
(2,	'KELUAR-1',	2,	1,	'2016-10-10 16:25:30',	NULL,	1,	1);

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
(1,	'Dashboard',	NULL,	'/site/index',	0,	NULL),
(2,	'Data',	NULL,	'/gate/index',	30,	'return [\'visible\'=>\\Yii::$app->user->can(\'superadmin\')];'),
(3,	'Palang Pintu',	2,	'/gate/index',	10,	NULL),
(4,	'Pembayaran',	2,	'/payment/index',	20,	NULL),
(5,	'Transportasi',	2,	'/transport/index',	30,	NULL),
(6,	'Harga Transportasi',	2,	'/transport-price/index',	40,	NULL),
(7,	'Voucher',	NULL,	'/voucher/index',	10,	NULL),
(8,	'Transaksi',	NULL,	'/transaction/index',	5,	'return [\'visible\'=>\\Yii::$app->user->can(\'operator\')];'),
(9,	'Daftar',	8,	'/transaction/index',	0,	NULL),
(10,	'Transaksi Masuk',	8,	'/transaction/create',	5,	NULL),
(11,	'Transaksi Keluar',	8,	'/transaction/create-out',	8,	NULL),
(12,	'User',	NULL,	'/user/admin/index',	100,	NULL),
(14,	'Shift',	2,	'/shift/index',	11,	NULL),
(16,	'Laporan',	NULL,	'/report/transaction',	6,	'return [\'visible\'=>\\Yii::$app->user->can(\'owner\')];'),
(17,	'Semua Transaksi',	16,	'/report/transaction',	5,	NULL),
(18,	'Voucher',	16,	'/report/voucher',	10,	NULL),
(19,	'Laporan Hari Ini',	8,	'/report/transaction-today',	15,	NULL),
(20,	'Rekapitulasi Transaksi',	16,	'/report/transaction-recapitulation',	8,	NULL),
(21,	'Transaksi Harian',	16,	'/report/transaction-daily',	15,	NULL),
(22,	'Transaksi Bulanan',	16,	'/report/transaction-monthly',	20,	NULL),
(23,	'Transaksi per Pintu',	16,	'/report/transaction-per-gate',	25,	NULL),
(24,	'Transaksi Rekapitulasi Bulanan',	16,	'/report/transaction-recapitulation-monthly',	30,	NULL);

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base',	1475722915),
('m140209_132017_init',	1475723204),
('m140403_174025_create_account_table',	1475723206),
('m140504_113157_update_tables',	1475723210),
('m140504_130429_create_token_table',	1475723212),
('m140506_102106_rbac_init',	1475724326),
('m140602_111327_create_menu_table',	1475722931),
('m140830_171933_fix_ip_field',	1475723212),
('m140830_172703_change_account_table_name',	1475723212),
('m141222_110026_update_ip_field',	1475723214),
('m141222_135246_alter_username_length',	1475723214),
('m150614_103145_update_social_account_table',	1475723216),
('m150623_212711_fix_username_notnull',	1475723217),
('m151218_234654_add_timezone_to_profile',	1475723217),
('m160312_050000_create_user',	1475722932);

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `class` char(100) DEFAULT NULL,
  `description` varchar(600) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment` (`id`, `name`, `class`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1,	'CASH',	NULL,	'Jenis pembayaran langsung tunai',	1,	'2016-10-07 06:24:28',	NULL,	1,	1);

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(1,	'',	'',	'',	'd41d8cd98f00b204e9800998ecf8427e',	'',	'',	'',	'Pacific/Apia'),
(2,	'',	'',	'',	'd41d8cd98f00b204e9800998ecf8427e',	'',	'',	NULL,	NULL),
(5,	'',	'',	'',	'd41d8cd98f00b204e9800998ecf8427e',	'',	'',	'',	'Pacific/Apia');

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `name` char(100) NOT NULL,
  `value` text NOT NULL,
  `label` varchar(100) NOT NULL,
  `note` text,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `setting` (`name`, `value`, `label`, `note`) VALUES
('admin_email',	'hendri.gnw@gmail.com',	'Hendri Gunawan',	NULL),
('app_name',	'Jungleland Indonesia',	'Application Name',	NULL),
('company_address',	'Sentul Bogor',	'Company Address',	NULL),
('company_email',	'hendri.gnw@gmail.com',	'Company Email',	NULL),
('company_name',	'PT Jungleland Indonesia',	'Company Name',	NULL),
('company_phone',	'021 9000081',	'Company Phone',	NULL),
('copyright',	'&copy; Art Techno Corporation',	'Copyright',	NULL),
('developer_email',	'hendri.gnw@gmail.com',	'Hendri Gunawan',	NULL),
('send_mail',	'1',	'Send Mail',	NULL),
('struct_entry_footer',	'Jangan tinggalkan tiket dan barang berharga lainnya di kendaraan Anda. Segala kerusakan dan kehilangan Bukan Tanggung Jawab Pengelola Parkir.',	'Struk masuk',	NULL),
('struct_exit_footer',	'Terima Kasih atas kunjungan Anda',	'Struk keluar',	NULL);

DROP TABLE IF EXISTS `shift`;
CREATE TABLE `shift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `social_account`;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(100) NOT NULL,
  `police_number` char(100) NOT NULL,
  `gate_in_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `camera_in` varchar(100) DEFAULT NULL,
  `camera_out` varchar(100) DEFAULT NULL,
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
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_price_id` (`transport_price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `transaction` (`id`, `code`, `police_number`, `gate_in_id`, `time_in`, `camera_in`, `camera_out`, `gate_out_id`, `time_out`, `picture`, `status`, `payment_status`, `transport_price_id`, `vehicle_id`, `payment_id`, `voucher_id`, `final_amount`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1,	'11161010001',	'B6941PFJ',	1,	'2016-10-10 10:39:45',	NULL,	NULL,	2,	'2016-10-10 18:07:03',	NULL,	2,	10,	4,	1,	1,	2,	0.00,	NULL,	'2016-10-10 18:07:27',	NULL,	1),
(2,	'11161010002',	'',	1,	'2016-10-10 13:57:32',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	2,	2,	NULL,	NULL,	NULL,	'2016-10-10 13:57:44',	NULL,	1,	1),
(3,	'11161010003',	'',	1,	'2016-10-10 13:57:55',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	1,	1,	NULL,	NULL,	NULL,	'2016-10-10 13:58:01',	NULL,	1,	1),
(4,	'12161011001',	'B6941PFJ',	1,	'2016-10-11 19:35:40',	NULL,	NULL,	2,	'2016-10-11 19:42:20',	NULL,	2,	10,	2,	2,	1,	NULL,	4000.00,	'2016-10-11 19:36:09',	'2016-10-11 19:42:40',	1,	1),
(5,	'11161013001',	'B6941PFJ',	1,	'2016-10-13 15:54:11',	NULL,	NULL,	2,	'2016-10-13 19:05:23',	NULL,	2,	10,	4,	1,	1,	2,	0.00,	'2016-10-13 15:54:18',	'2016-10-13 19:05:33',	1,	1),
(6,	'12161013001',	'',	1,	'2016-10-13 15:54:27',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	2,	2,	NULL,	NULL,	NULL,	'2016-10-13 15:54:35',	NULL,	1,	1),
(7,	'11161013002',	'B6941PFJ',	1,	'2016-10-13 19:20:06',	NULL,	NULL,	2,	'2016-10-13 19:20:35',	NULL,	2,	10,	4,	3,	1,	2,	0.00,	'2016-10-13 19:20:14',	'2016-10-13 19:20:42',	1,	1),
(8,	'11161013003',	'B6310JEU',	1,	'2016-10-13 22:12:06',	NULL,	NULL,	2,	'2016-10-13 22:12:44',	NULL,	2,	10,	1,	2,	1,	NULL,	2000.00,	'2016-10-13 22:12:13',	'2016-10-13 22:13:22',	1,	1),
(9,	'11161013004',	'B6941PFJ',	1,	'2016-10-13 22:21:53',	NULL,	NULL,	2,	'2016-10-13 22:29:11',	NULL,	2,	10,	4,	1,	1,	2,	0.00,	'2016-10-13 22:23:14',	'2016-10-13 22:29:37',	1,	1),
(10,	'11161014001',	'B6941PFJ',	1,	'2016-10-14 17:02:40',	NULL,	NULL,	2,	'2016-10-14 17:03:04',	NULL,	2,	10,	4,	1,	1,	2,	0.00,	'2016-10-14 17:02:45',	'2016-10-14 17:03:20',	1,	1),
(11,	'11161020001',	'B1234SOC',	1,	'2016-10-20 09:53:22',	NULL,	NULL,	2,	'2016-10-20 09:53:45',	NULL,	2,	10,	7,	1,	1,	3,	0.00,	'2016-10-20 09:53:28',	'2016-10-20 09:53:59',	1,	1),
(12,	'11161020002',	'B7891JGH',	1,	'2016-10-20 12:45:32',	NULL,	NULL,	2,	'2016-10-20 12:45:51',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-10-20 12:45:37',	'2016-10-20 12:46:03',	1,	1),
(13,	'11161024001',	'B1234SOC',	1,	'2016-10-24 19:59:00',	NULL,	NULL,	2,	'2016-10-25 07:21:00',	NULL,	2,	10,	1,	1,	1,	NULL,	5000.00,	'2016-10-24 09:47:15',	'2016-10-24 09:47:53',	1,	1),
(14,	'11161025001',	'B1234SOC',	1,	'2016-10-25 09:46:55',	NULL,	NULL,	2,	'2016-10-25 23:47:48',	NULL,	2,	10,	7,	1,	1,	3,	0.00,	'2016-10-25 09:47:01',	'2016-10-25 09:48:04',	1,	1),
(15,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(16,	'11161112002',	'',	1,	'2016-11-12 11:28:15',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	1,	1,	NULL,	NULL,	NULL,	'2016-11-12 11:28:17',	NULL,	2,	2),
(17,	'11161112003',	'',	1,	'2016-11-12 11:28:20',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	1,	1,	NULL,	NULL,	NULL,	'2016-11-12 11:28:23',	NULL,	2,	2),
(18,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	2,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(19,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(20,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(22,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(23,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(24,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(25,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(29,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(30,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(31,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(32,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(33,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(34,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(35,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(36,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(44,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(45,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(46,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(47,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(48,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(49,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	1,	1),
(50,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(51,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(52,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(53,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(54,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(55,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(56,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(57,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(58,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(59,	'11161112001',	'B1234SOB',	1,	'2016-11-12 11:20:49',	NULL,	NULL,	2,	'2016-11-12 11:22:53',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-12 11:20:55',	'2016-11-12 11:23:15',	2,	2),
(60,	'11161114001',	'',	1,	'2016-11-14 13:35:07',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	1,	1,	NULL,	NULL,	NULL,	'2016-11-14 13:35:11',	NULL,	2,	2),
(61,	'11161114002',	'B7891JGH',	1,	'2016-11-14 13:35:25',	NULL,	NULL,	2,	'2016-11-14 13:35:49',	NULL,	2,	10,	1,	1,	1,	NULL,	2000.00,	'2016-11-14 13:35:43',	'2016-11-14 13:36:01',	2,	2),
(62,	'11170624001',	'B6941PFJ',	1,	'2017-06-24 01:13:16',	NULL,	NULL,	NULL,	'2017-06-24 01:13:16',	NULL,	1,	10,	1,	1,	1,	NULL,	5000.00,	'2017-06-24 01:14:22',	NULL,	1,	1),
(63,	'12170624001',	'B6941PFJ',	1,	'2017-06-24 01:16:11',	NULL,	NULL,	NULL,	'2017-06-24 01:16:11',	NULL,	1,	10,	2,	2,	1,	NULL,	7000.00,	'2017-06-24 01:16:20',	NULL,	1,	1),
(64,	'13170624001',	'B6941PFJ',	1,	'2017-06-24 01:17:56',	NULL,	NULL,	NULL,	'2017-06-24 01:17:56',	NULL,	3,	10,	3,	3,	1,	NULL,	8000.00,	'2017-06-24 01:18:04',	NULL,	1,	1),
(65,	'11170624002',	'B8291PDJ',	1,	'2017-06-24 01:21:03',	NULL,	NULL,	NULL,	'2017-06-24 01:21:03',	NULL,	3,	10,	1,	1,	1,	NULL,	5000.00,	'2017-06-24 01:21:12',	NULL,	1,	1),
(66,	'12170624002',	'B5812ITH',	1,	'2017-06-24 09:20:37',	NULL,	NULL,	NULL,	'2017-06-24 09:20:37',	NULL,	3,	10,	2,	2,	1,	NULL,	7000.00,	'2017-06-24 09:20:58',	NULL,	1,	1),
(67,	'11171012001',	'B6941PFJ',	1,	'2017-10-12 22:27:44',	NULL,	NULL,	NULL,	'2017-10-12 22:27:44',	NULL,	3,	10,	1,	1,	1,	NULL,	5000.00,	'2017-10-12 22:43:53',	NULL,	1,	1),
(70,	'11171012002',	'',	1,	'2017-10-12 10:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	1,	1,	NULL,	NULL,	NULL,	'2017-10-12 23:28:36',	NULL,	NULL,	NULL),
(71,	'11171012003',	'',	1,	'2017-10-12 10:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	5,	1,	1,	NULL,	NULL,	NULL,	'2017-10-12 23:29:59',	NULL,	NULL,	NULL),
(72,	'11171016001',	'B1234PTH',	1,	'2017-10-16 10:10:29',	NULL,	NULL,	2,	'2017-10-16 23:13:40',	NULL,	2,	10,	1,	1,	1,	NULL,	5000.00,	'2017-10-16 23:12:43',	'2017-10-16 23:13:56',	1,	1),
(73,	'11171016002',	'V1234DG',	1,	'2017-10-16 13:10:29',	NULL,	NULL,	2,	'2017-10-16 23:18:00',	NULL,	2,	10,	1,	1,	1,	NULL,	5000.00,	'2017-10-16 23:12:56',	'2017-10-16 23:18:30',	1,	1),
(74,	'12171016001',	'J9109SK',	1,	'2017-10-16 18:00:29',	NULL,	NULL,	2,	'2017-10-16 23:18:35',	NULL,	2,	10,	2,	2,	1,	NULL,	7000.00,	'2017-10-16 23:13:15',	'2017-10-16 23:18:49',	1,	1),
(75,	'12171016002',	'B9180KD',	1,	'2017-10-16 05:10:19',	NULL,	NULL,	2,	'2017-10-16 23:19:40',	NULL,	2,	10,	2,	2,	1,	NULL,	7000.00,	'2017-10-16 23:19:29',	'2017-10-16 23:19:49',	1,	1),
(76,	'12171016003',	'B6271UEI',	1,	'2017-10-16 06:30:57',	NULL,	NULL,	2,	'2017-10-16 23:52:24',	NULL,	2,	10,	2,	2,	1,	NULL,	7000.00,	'2017-10-16 23:52:14',	'2017-10-16 23:52:37',	1,	1),
(77,	'11171016003',	'B8120ISl',	1,	'2017-10-16 07:50:56',	NULL,	NULL,	2,	'2017-10-16 23:53:15',	NULL,	2,	10,	1,	1,	1,	NULL,	5000.00,	'2017-10-16 23:53:07',	'2017-10-16 23:53:22',	1,	1);

DROP TABLE IF EXISTS `transport`;
CREATE TABLE `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `description` varchar(600) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive;',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `transport` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1,	'Regular',	'Transport biasa',	1,	'2016-10-05 17:09:00',	NULL,	1,	NULL),
(2,	'Member',	'Transport yang memiliki voucher',	1,	'2016-10-05 17:09:00',	NULL,	1,	NULL),
(3,	'Employee',	'Transport khusus untuk karyawan, dan gratis',	1,	'2016-10-05 17:09:00',	NULL,	1,	NULL);

DROP TABLE IF EXISTS `transport_price`;
CREATE TABLE `transport_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `transport_id` (`transport_id`),
  CONSTRAINT `transport_price_ibfk_4` FOREIGN KEY (`transport_id`) REFERENCES `transport` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `transport_price` (`id`, `transport_id`, `vehicle_id`, `code`, `name`, `amount_1`, `amount_2`, `amount_3`, `amount`, `limit`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1,	1,	1,	'11',	'Motor',	2000.00,	3000.00,	4000.00,	5000.00,	NULL,	1,	'2016-10-07 09:33:05',	NULL,	1,	1),
(2,	1,	2,	'12',	'Mobil',	4000.00,	5000.00,	6000.00,	7000.00,	NULL,	1,	'2016-10-07 09:34:03',	NULL,	1,	1),
(3,	1,	3,	'13',	'Mobil Besar',	5000.00,	6000.00,	7000.00,	8000.00,	NULL,	1,	'2016-10-07 09:34:57',	NULL,	1,	1),
(4,	2,	1,	'21',	'Motor',	NULL,	NULL,	NULL,	10000.00,	30,	1,	'2016-10-07 09:36:13',	NULL,	1,	1),
(5,	2,	2,	'22',	'Mobil',	NULL,	NULL,	NULL,	20000.00,	30,	1,	'2016-10-07 09:37:01',	'2016-10-07 09:41:08',	1,	1),
(6,	2,	3,	'23',	'Mobil Besar',	NULL,	NULL,	NULL,	30000.00,	30,	1,	'2016-10-07 09:37:23',	NULL,	1,	1),
(7,	3,	1,	'31',	'Motor',	NULL,	NULL,	NULL,	0.00,	0,	1,	'2016-10-07 09:38:03',	NULL,	1,	1),
(8,	3,	2,	'32',	'Mobil',	NULL,	NULL,	NULL,	0.00,	0,	1,	'2016-10-07 09:38:03',	NULL,	1,	1),
(9,	3,	3,	'33',	'Mobil Besar',	NULL,	NULL,	NULL,	0.00,	0,	1,	'2016-10-07 09:38:03',	NULL,	1,	1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_email` (`email`),
  UNIQUE KEY `user_unique_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `gate_id`, `shift_id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `online`, `online_date`, `created_at`, `updated_at`, `flags`) VALUES
(1,	0,	0,	'admin',	'hendri.gnw@gmail.com',	'$2y$10$Y98GQUuS7BMGcyiznKUPOeIH.OiXQPkKrW5bmc4VJUw67nADR5c.q',	'oyFsVxIqIksQr2WQWSWIt42GcSOUUIAS',	1475747026,	NULL,	NULL,	'::1',	1,	'2017-10-10 13:26:31',	1475746427,	1507616792,	0),
(2,	1,	0,	'operator',	'hendrigunawan195@gmail.com',	'$2y$10$EMxtCm4bFkBYh5.OBOJrju0aiijvd/dsZqVvr1uoaxYVjteghOBBu',	'4jdPs4T7jmgKhsq2N1XxheG2mQ7LooBV',	1476344540,	NULL,	NULL,	'::1',	1,	'2016-12-31 09:46:26',	1476344540,	1483152386,	0),
(5,	0,	0,	'owner',	'hendri.gunawan@computesta.com',	'$2y$10$eyLJGvFpfoTM8m1QPwv0nOfMMlZHLRcVwPvN3bitIz1A0mmv8ysR2',	'pcI7UqejJ0UaCgE7otSKi9WYywi4tk5B',	1476348422,	NULL,	NULL,	'::1',	0,	'2016-10-14 17:37:49',	1476348422,	1476441491,	0);

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active;0=Inactive;',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vehicle` (`id`, `name`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1,	'Motor',	1,	'2016-10-05 17:09:00',	NULL,	1,	NULL),
(2,	'Mobil',	1,	'2016-10-05 17:09:00',	NULL,	1,	NULL),
(3,	'Mobil Besar',	1,	'2016-10-05 17:09:00',	NULL,	1,	NULL);

DROP TABLE IF EXISTS `voucher`;
CREATE TABLE `voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_price_id` (`transport_price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `voucher` (`id`, `code`, `transport_price_id`, `vehicle_id`, `voucher_type`, `voucher_type_amount`, `start_date`, `end_date`, `limit`, `amount`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2,	'B6941PFJ',	4,	1,	2,	1,	'2016-10-10',	'2016-11-15',	5,	10000.00,	1,	'2016-10-10 04:51:10',	NULL,	1,	1),
(3,	'B1234SOC',	7,	1,	2,	1,	'2016-10-20',	'2016-10-20',	0,	0.00,	1,	'2016-10-20 09:53:17',	NULL,	1,	1);

-- 2017-10-17 01:30:44
