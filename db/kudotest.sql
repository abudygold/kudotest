-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2018 at 09:04 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kudotest`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE IF NOT EXISTS `akses` (
  `menu_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `controller` varchar(100) CHARACTER SET latin1 NOT NULL,
  `action` varchar(100) CHARACTER SET latin1 NOT NULL,
  `plugin` varchar(100) CHARACTER SET latin1 NOT NULL,
  `icon` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `orders` tinyint(3) unsigned DEFAULT NULL,
  `groups_controller` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`menu_id`, `name`, `controller`, `action`, `plugin`, `icon`, `parent_id`, `orders`, `groups_controller`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Dashboard', 'welcome', 'index', '#', 'dashboard', 0, 1, 'welcome', '0000-00-00 00:00:00', '', '2017-10-22 01:56:13', 'admin@admin.com'),
(15, 'Menus & Roles', '#', 'menus', '', 'link', 0, 2, 'menus', '0000-00-00 00:00:00', '', '2017-10-22 02:05:36', 'admin@admin.com'),
(18, 'Menus', 'menus', 'index', '', 'angle-double-right', 15, 1, 'menus', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(19, 'Roles', 'roles', 'index', '', 'angle-double-right', 15, 2, 'menus', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(35, 'Configurations', 'configurations', 'index', '#', 'gear', 0, 6, 'configurations', '2017-10-22 02:00:44', 'admin@admin.com', '2017-10-22 02:26:55', 'admin@admin.com'),
(36, 'Users', 'users', 'index', '#', 'users', 0, 3, 'users', '2017-10-22 02:05:28', 'admin@admin.com', '0000-00-00 00:00:00', ''),
(37, 'Groups', 'groups', 'index', '#', 'users', 0, 4, 'groups', '2017-10-22 02:05:53', 'admin@admin.com', '2017-10-22 02:07:30', 'admin@admin.com'),
(38, 'Profile', 'profile', 'view', '{id}', 'user', 0, 5, 'profile', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE IF NOT EXISTS `grup` (
  `id` mediumint(8) unsigned NOT NULL,
  `nama` varchar(20) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `akses_menu` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`id`, `nama`, `deskripsi`, `akses_menu`) VALUES
(1, 'admin', 'Administrator', 'a:8:{s:4:"Auth";a:11:{i:0;s:5:"login";i:1;s:6:"logout";i:2;s:11:"create_user";i:3;s:14:"get_user_by_id";i:4;s:9:"edit_user";i:5;s:8:"activate";i:6;s:10:"deactivate";i:7;s:12:"create_group";i:8;s:15:"get_group_by_id";i:9;s:10:"edit_group";i:10;s:12:"delete_group";}s:14:"Configurations";a:2:{i:0;s:5:"index";i:1;s:3:"add";}s:6:"Groups";a:2:{i:0;s:5:"index";i:1;s:12:"getDataGroup";}s:5:"Menus";a:6:{i:0;s:5:"index";i:1;s:8:"editData";i:2;s:7:"addData";i:3;s:10:"updateData";i:4;s:10:"deleteData";i:5;s:10:"bulkDelete";}s:7:"Profile";a:1:{i:0;s:4:"view";}s:5:"Roles";a:2:{i:0;s:5:"index";i:1;s:3:"add";}s:5:"Users";a:2:{i:0;s:5:"index";i:1;s:11:"getDataUser";}s:7:"Welcome";a:1:{i:0;s:5:"index";}}'),
(4, 'member', 'Member', 'a:3:{s:4:"Auth";a:3:{i:0;s:5:"login";i:1;s:6:"logout";i:2;s:9:"edit_user";}s:7:"Profile";a:1:{i:0;s:4:"view";}s:7:"Welcome";a:1:{i:0;s:5:"index";}}');

-- --------------------------------------------------------

--
-- Table structure for table `grup_pengguna`
--

CREATE TABLE IF NOT EXISTS `grup_pengguna` (
  `id` int(11) unsigned NOT NULL,
  `pengguna_id` int(11) unsigned NOT NULL,
  `grup_id` mediumint(8) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grup_pengguna`
--

INSERT INTO `grup_pengguna` (`id`, `pengguna_id`, `grup_id`) VALUES
(1, 1, 1),
(19, 2, 4),
(21, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE IF NOT EXISTS `konfigurasi` (
  `id` int(11) unsigned NOT NULL,
  `judul` varchar(200) CHARACTER SET latin1 NOT NULL,
  `deskripsi` text CHARACTER SET latin1
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id`, `judul`, `deskripsi`) VALUES
(1, 'app_name', 'Kudo Test'),
(2, 'app_short_name', 'KT'),
(3, 'admin_copyright', 'Copyright © {year} . All rights reserved.'),
(4, 'frontend_copyright', 'Copyright © {year} . All rights reserved.'),
(6, 'contact_person', 'Kudo Test'),
(7, 'contact_email', 'kudo@test.com'),
(8, 'contact_number', '+1234567890'),
(9, 'fax_number', '+1234567890'),
(10, 'contact_address', 'Indonesia'),
(11, 'meta_description', 'This is smart cms'),
(12, 'meta_keywords', 'smart, cms'),
(13, 'facebook_url', 'Facebook URL'),
(14, 'twitter_url', 'Twitter URL'),
(15, 'youtube_url', 'Youtube URL'),
(16, 'google_url', 'Google+ URL'),
(19, 'website_logo', ''),
(20, 'favicon_logo', ''),
(21, 'app_name', 'Kudo Test'),
(22, 'app_short_name', 'KT'),
(23, 'admin_copyright', 'Copyright © {year} . All rights reserved.'),
(24, 'frontend_copyright', 'Copyright © {year} . All rights reserved.'),
(25, 'contact_person', 'Kudo Test'),
(26, 'contact_email', 'kudo@test.com'),
(27, 'contact_number', '+1234567890'),
(28, 'fax_number', '+1234567890'),
(29, 'contact_address', 'Indonesia'),
(30, 'meta_description', 'This is smart cms'),
(31, 'meta_keywords', 'smart, cms'),
(32, 'facebook_url', 'Facebook URL'),
(33, 'twitter_url', 'Twitter URL'),
(34, 'youtube_url', 'Youtube URL'),
(35, 'google_url', 'Google+ URL');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int(11) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `aktivasi_kode` varchar(40) DEFAULT NULL,
  `lupa_sandi_kode` varchar(40) DEFAULT NULL,
  `lupa_sandi_waktu` int(11) unsigned DEFAULT NULL,
  `remember_kode` varchar(40) DEFAULT NULL,
  `dibuat_tgl` int(11) unsigned NOT NULL,
  `terakhir_login` int(11) unsigned DEFAULT NULL,
  `aktif` tinyint(1) unsigned DEFAULT NULL,
  `nama_pertama` varchar(50) DEFAULT NULL,
  `nama_terakhir` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `telpon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `aktivasi_kode`, `lupa_sandi_kode`, `lupa_sandi_waktu`, `remember_kode`, `dibuat_tgl`, `terakhir_login`, `aktif`, `nama_pertama`, `nama_terakhir`, `alamat`, `telpon`) VALUES
(1, '127.0.0.1', 'administrator website', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, 1497369357, NULL, 1268889823, 1514790040, 1, 'administrator', 'website', 'PT. Luminktech', '087870521400'),
(2, '::1', 'user satu', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'user@test.com', NULL, NULL, NULL, NULL, 1497673332, 1514791490, 1, 'user', 'satu', 'Jakarta', '000000'),
(3, '::1', 'user dua', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'test@user.com', NULL, NULL, NULL, NULL, 1507945563, 1514780071, 1, 'user', 'dua', 'jakarta', '000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grup_pengguna`
--
ALTER TABLE `grup_pengguna`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uc_users_groups` (`pengguna_id`,`grup_id`), ADD KEY `fk_users_groups_users1_idx` (`pengguna_id`), ADD KEY `fk_users_groups_groups1_idx` (`grup_id`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses`
--
ALTER TABLE `akses`
  MODIFY `menu_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `grup_pengguna`
--
ALTER TABLE `grup_pengguna`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
