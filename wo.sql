/*
 Navicat Premium Data Transfer

 Source Server         : Mysql Local
 Source Server Type    : MySQL
 Source Server Version : 50727
 Source Host           : 127.0.0.1:3306
 Source Schema         : wo

 Target Server Type    : MySQL
 Target Server Version : 50727
 File Encoding         : 65001

 Date: 14/08/2019 16:47:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acara_data
-- ----------------------------
DROP TABLE IF EXISTS `acara_data`;
CREATE TABLE `acara_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_acara_field` int(11) NULL DEFAULT NULL,
  `value` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for acara_field
-- ----------------------------
DROP TABLE IF EXISTS `acara_field`;
CREATE TABLE `acara_field`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_acara_tipe` int(11) NULL DEFAULT NULL,
  `nama_field` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_label` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `isian` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `wajib` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of acara_field
-- ----------------------------
INSERT INTO `acara_field` VALUES (1, 2, 'nama_ayah', 'Nama Ayah', 'text', 'Di isi Nama Ayah', NULL, NULL, '1');
INSERT INTO `acara_field` VALUES (3, 2, 'nama_kakak', 'Nama Kakak', 'addabletext', 'di isi nama kakak', NULL, NULL, '3');
INSERT INTO `acara_field` VALUES (8, 2, 'nama_ibu', 'Nama Ibu', 'text', 'di isi nama ibu', NULL, NULL, '2');
INSERT INTO `acara_field` VALUES (9, 2, 'adik', 'Nama Adik', 'addabletext', 'Nama Adik', NULL, NULL, '4');
INSERT INTO `acara_field` VALUES (10, 2, 'saudara_ayah', 'Saudara Ayah', 'addabletext', 'saudara ayah', NULL, NULL, '5');

-- ----------------------------
-- Table structure for acara_tipe
-- ----------------------------
DROP TABLE IF EXISTS `acara_tipe`;
CREATE TABLE `acara_tipe`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_acara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `use_panitia` tinyint(4) NULL DEFAULT NULL,
  `id_panitia_tipe` int(10) NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of acara_tipe
-- ----------------------------
INSERT INTO `acara_tipe` VALUES (2, 'Midodareni', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for app_group
-- ----------------------------
DROP TABLE IF EXISTS `app_group`;
CREATE TABLE `app_group`  (
  `group_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `group_desc` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `group_application_id` int(11) NULL DEFAULT NULL COMMENT 'refer to gtfw_application.application_id',
  `insert_user_id` bigint(20) NULL DEFAULT NULL,
  `insert_timestamp` datetime(0) NULL,
  `update_user_id` bigint(20) NULL DEFAULT NULL,
  `update_timestamp` datetime(0) NULL,
  PRIMARY KEY (`group_id`) USING BTREE,
  INDEX `FK_gtfw_group_application`(`group_application_id`) USING BTREE,
  CONSTRAINT `app_group_ibfk_1` FOREIGN KEY (`group_application_id`) REFERENCES `gtfw_application` (`application_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of app_group
-- ----------------------------
INSERT INTO `app_group` VALUES (1, 'Administrator', '', 1, NULL, '0000-00-00 00:00:00', 1, '2018-06-21 02:12:55');
INSERT INTO `app_group` VALUES (35, 'Admin Perusahaan', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00');
INSERT INTO `app_group` VALUES (36, 'Vendor', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00');
INSERT INTO `app_group` VALUES (37, 'Pengantin', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for app_group_menu
-- ----------------------------
DROP TABLE IF EXISTS `app_group_menu`;
CREATE TABLE `app_group_menu`  (
  `groupmenu_menu_id` bigint(20) NOT NULL COMMENT 'refer to gtfw_menu.menu_id',
  `groupmenu_group_id` bigint(20) NOT NULL COMMENT 'refer to gtfw_group.group_id',
  PRIMARY KEY (`groupmenu_menu_id`, `groupmenu_group_id`) USING BTREE,
  INDEX `FK_gtfw_group_menu_group`(`groupmenu_group_id`) USING BTREE,
  CONSTRAINT `app_group_menu_ibfk_1` FOREIGN KEY (`groupmenu_menu_id`) REFERENCES `app_menu` (`menu_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `app_group_menu_ibfk_2` FOREIGN KEY (`groupmenu_group_id`) REFERENCES `app_group` (`group_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of app_group_menu
-- ----------------------------
INSERT INTO `app_group_menu` VALUES (1, 1);

-- ----------------------------
-- Table structure for app_menu
-- ----------------------------
DROP TABLE IF EXISTS `app_menu`;
CREATE TABLE `app_menu`  (
  `menu_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `menu_parent_id` bigint(20) NULL DEFAULT NULL COMMENT 'refer to gtfw_menu.menu_id (parent)',
  `menu_desc` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `menu_is_show` enum('Yes','No') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menu_icon_large` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menu_icon_path` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menu_icon_small` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menu_menu_order` int(11) NULL DEFAULT NULL,
  `menu_application_id` int(11) NOT NULL COMMENT 'refer to gtfw_application.application_id',
  `menu_default_module_id` bigint(20) NULL DEFAULT NULL COMMENT 'refer to gtfw_module.module_id',
  `menu_class_style` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `insert_user_id` bigint(20) NULL DEFAULT NULL,
  `insert_timestamp` datetime(0) NULL,
  `update_user_id` bigint(20) NULL DEFAULT NULL,
  `update_timestamp` datetime(0) NULL,
  PRIMARY KEY (`menu_id`) USING BTREE,
  INDEX `FK_gtfw_menu_application`(`menu_application_id`) USING BTREE,
  INDEX `FK_gtfw_menu_parent`(`menu_parent_id`) USING BTREE,
  INDEX `FK_gtfw_menu_module`(`menu_default_module_id`) USING BTREE,
  CONSTRAINT `app_menu_ibfk_1` FOREIGN KEY (`menu_default_module_id`) REFERENCES `gtfw_module` (`module_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `app_menu_ibfk_2` FOREIGN KEY (`menu_application_id`) REFERENCES `gtfw_application` (`application_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of app_menu
-- ----------------------------
INSERT INTO `app_menu` VALUES (1, 0, '', 'Yes', 'large-preferences.png', '', '', 1, 1, NULL, '', NULL, '0000-00-00 00:00:00', 1, '2012-11-23 16:52:19');

-- ----------------------------
-- Table structure for app_setting
-- ----------------------------
DROP TABLE IF EXISTS `app_setting`;
CREATE TABLE `app_setting`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `setting_value` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `setting_desc` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of app_setting
-- ----------------------------
INSERT INTO `app_setting` VALUES (1, 'template_dokumen', 'pengecekan_saldo.xlsx', NULL);

-- ----------------------------
-- Table structure for app_user
-- ----------------------------
DROP TABLE IF EXISTS `app_user`;
CREATE TABLE `app_user`  (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NULL DEFAULT NULL,
  `user_real_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_user_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_password` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_phone` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_desc` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `user_no_password` tinyint(1) NULL DEFAULT 0,
  `user_active` tinyint(1) NULL DEFAULT 1,
  `user_force_logout` tinyint(1) NULL DEFAULT 0,
  `user_active_lang_code` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'refer to gtfw_lang.lang_code',
  `user_last_logged_in` datetime(0) NULL,
  `user_last_ip` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_is_super` tinyint(1) NOT NULL DEFAULT 0,
  `user_foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `insert_user_id` bigint(20) NULL DEFAULT NULL,
  `insert_timestamp` datetime(0) NULL,
  `update_user_id` bigint(20) NULL DEFAULT NULL,
  `update_timestamp` datetime(0) NULL,
  `user_token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `last_used` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `ip` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  `appid` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `salah_pin` int(11) NULL DEFAULT NULL,
  `user_company` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  INDEX `idx_gtfw_user`(`user_active_lang_code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Storage for user data of the application' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of app_user
-- ----------------------------
INSERT INTO `app_user` VALUES (1, 1, 'Admin', 'admin', 'email_tester@gmail.com', '0192023a7bbd73250516f069df18b500', 'bmbnmb', '123123123', '', 0, 1, 0, 'id', '0000-00-00 00:00:00', NULL, 1, NULL, NULL, '0000-00-00 00:00:00', 1, '2017-10-20 17:48:48', 'RFD7QEU5VGVEHDAX8QRD', '2019-08-13 09:09:25', '::1', 1, 'gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81MzcuM#gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81MzcuM#gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81MzcuM#gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81Mz', 0, NULL);
INSERT INTO `app_user` VALUES (2, 35, 'adminmahkota', 'adminmahkota', 'adminmahkota@gmail.com', 'e60e66226e980ec9e6d4449be39da907', 'semarang', '085111111111', 'Admin Mahkota', 0, 1, 0, '', '0000-00-00 00:00:00', NULL, 1, '', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '2019-08-13 09:15:22', NULL, 1, 'gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81MzcuM#gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81MzcuM#gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81MzcuM#gKFgxMTsgTGludXggeDg2XzY0KSBBcHBsZVdlYktpdC81Mz', NULL, '1');
INSERT INTO `app_user` VALUES (3, 35, 'tiara', 'admintiara', 'admintiara@gmail.com', 'ce41c8d679391e08fe4bc951139eff84', 'Semarang', '081111111111', 'Admin Tiara', 0, 1, 0, '', '0000-00-00 00:00:00', NULL, 0, '', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, '2019-08-13 09:15:33', NULL, NULL, NULL, NULL, '2');

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `notelp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sosmed` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` tinyint(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES (1, 'Mahkota Enterprise', 'Semarang', '0298 654 984', 'mahkota@gmail.com', NULL, 'lores_mahkota2.png', 1);
INSERT INTO `company` VALUES (2, 'Tiara', 'semarang', '085123123123', 'tiara@gmail.com', NULL, 'lores_tiara.png', 1);

-- ----------------------------
-- Table structure for foto
-- ----------------------------
DROP TABLE IF EXISTS `foto`;
CREATE TABLE `foto`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(10) NULL DEFAULT NULL,
  `tipe` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waktu` tinyint(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kategori_vendor
-- ----------------------------
DROP TABLE IF EXISTS `kategori_vendor`;
CREATE TABLE `kategori_vendor`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori_vendor
-- ----------------------------
INSERT INTO `kategori_vendor` VALUES (1, 'Bride MUA');
INSERT INTO `kategori_vendor` VALUES (2, 'Mother of Bride MUA');
INSERT INTO `kategori_vendor` VALUES (3, 'Mother of Groom MUA');
INSERT INTO `kategori_vendor` VALUES (4, 'Siblings of Groom MUA');
INSERT INTO `kategori_vendor` VALUES (5, 'Siblings ofGroom MUA');
INSERT INTO `kategori_vendor` VALUES (6, 'Bridesmaids MUA');
INSERT INTO `kategori_vendor` VALUES (7, 'Bridal Gown');
INSERT INTO `kategori_vendor` VALUES (8, 'Mother of Bride Gown');
INSERT INTO `kategori_vendor` VALUES (9, 'Mother of Groom Gown');
INSERT INTO `kategori_vendor` VALUES (10, 'Siblings of Bride Gown');
INSERT INTO `kategori_vendor` VALUES (11, 'Siblings of Groom Gown');
INSERT INTO `kategori_vendor` VALUES (12, 'Headpiece');
INSERT INTO `kategori_vendor` VALUES (13, 'Heels');
INSERT INTO `kategori_vendor` VALUES (14, 'Bridal Robe');
INSERT INTO `kategori_vendor` VALUES (15, 'Cincin');
INSERT INTO `kategori_vendor` VALUES (16, 'Tailor');
INSERT INTO `kategori_vendor` VALUES (17, 'Mobil Pengantin');
INSERT INTO `kategori_vendor` VALUES (18, 'Photography');
INSERT INTO `kategori_vendor` VALUES (19, 'Photobooth');
INSERT INTO `kategori_vendor` VALUES (20, 'Videography');
INSERT INTO `kategori_vendor` VALUES (21, 'Gereja');
INSERT INTO `kategori_vendor` VALUES (22, 'Vihara');
INSERT INTO `kategori_vendor` VALUES (23, 'Venue');
INSERT INTO `kategori_vendor` VALUES (24, 'Decoration');
INSERT INTO `kategori_vendor` VALUES (25, 'Florist');
INSERT INTO `kategori_vendor` VALUES (26, 'Cake');
INSERT INTO `kategori_vendor` VALUES (27, 'Lighting');
INSERT INTO `kategori_vendor` VALUES (28, 'LED');
INSERT INTO `kategori_vendor` VALUES (29, 'Special Effect');
INSERT INTO `kategori_vendor` VALUES (30, 'Soundsystem');
INSERT INTO `kategori_vendor` VALUES (31, 'Player');
INSERT INTO `kategori_vendor` VALUES (32, 'MC');
INSERT INTO `kategori_vendor` VALUES (33, 'Singer');
INSERT INTO `kategori_vendor` VALUES (34, 'Guest Star');
INSERT INTO `kategori_vendor` VALUES (35, 'Dancer');
INSERT INTO `kategori_vendor` VALUES (36, 'Souvenir');
INSERT INTO `kategori_vendor` VALUES (37, 'Undangan');
INSERT INTO `kategori_vendor` VALUES (38, 'Catering');
INSERT INTO `kategori_vendor` VALUES (39, 'Kids Corner');
INSERT INTO `kategori_vendor` VALUES (40, 'Grand Piano');
INSERT INTO `kategori_vendor` VALUES (41, 'AC');
INSERT INTO `kategori_vendor` VALUES (42, 'genset');
INSERT INTO `kategori_vendor` VALUES (43, 'Tenda Drop Zone');
INSERT INTO `kategori_vendor` VALUES (44, 'Flooring');
INSERT INTO `kategori_vendor` VALUES (45, 'Foreijder');
INSERT INTO `kategori_vendor` VALUES (46, 'Golf Car');
INSERT INTO `kategori_vendor` VALUES (47, 'Valet');
INSERT INTO `kategori_vendor` VALUES (48, 'Wdding Stylist');
INSERT INTO `kategori_vendor` VALUES (49, 'Wedding Organizer');

-- ----------------------------
-- Table structure for keluarga
-- ----------------------------
DROP TABLE IF EXISTS `keluarga`;
CREATE TABLE `keluarga`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_pengantin` int(11) NULL DEFAULT NULL,
  `ayah` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nohp_ayah` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ibu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nohp_ibu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kakak` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nohp_kakak` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `adik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nohp_adik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `others` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lagu
-- ----------------------------
DROP TABLE IF EXISTS `lagu`;
CREATE TABLE `lagu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `judul_lagu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `artis` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_akitivitas
-- ----------------------------
DROP TABLE IF EXISTS `log_akitivitas`;
CREATE TABLE `log_akitivitas`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(10) NULL DEFAULT NULL,
  `id_user` int(10) NULL DEFAULT NULL,
  `deskripsi` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for panitia_data
-- ----------------------------
DROP TABLE IF EXISTS `panitia_data`;
CREATE TABLE `panitia_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_panitia_field` int(11) NULL DEFAULT NULL,
  `value` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for panitia_field
-- ----------------------------
DROP TABLE IF EXISTS `panitia_field`;
CREATE TABLE `panitia_field`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_panitia_tipe` int(11) NULL DEFAULT NULL,
  `nama_field` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_label` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `isian` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `wajib` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of panitia_field
-- ----------------------------
INSERT INTO `panitia_field` VALUES (1, 1, 'nama_ayah', 'Ayah', 'text', 'Ayah', NULL, NULL, 1);
INSERT INTO `panitia_field` VALUES (2, 2, 'petugas_bunga_papan', 'Petugas bunga papan', 'addabletext', 'Nama||Telp/Hp', NULL, NULL, 1);
INSERT INTO `panitia_field` VALUES (3, 2, 'souvenir', 'Souvenir', 'addabletext', 'Nama||Telp/Hp', NULL, NULL, 2);
INSERT INTO `panitia_field` VALUES (4, 2, 'petugas_registrasi', 'Petugas registrasi', 'addabletext', 'Nama||Telp/Hp', NULL, NULL, 3);
INSERT INTO `panitia_field` VALUES (5, 2, 'koordinator_petugas_registrasi', 'Koordinator petugas registrasi', 'addabletext', 'Nama||Telp/Hp', NULL, NULL, 4);
INSERT INTO `panitia_field` VALUES (6, 2, 'serah_terima_kado', 'Serah terima kado / angpao', 'addabletext', 'Nama||Telp/Hp', NULL, NULL, 5);

-- ----------------------------
-- Table structure for panitia_tipe
-- ----------------------------
DROP TABLE IF EXISTS `panitia_tipe`;
CREATE TABLE `panitia_tipe`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_acara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_upacara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_panitia` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of panitia_tipe
-- ----------------------------
INSERT INTO `panitia_tipe` VALUES (2, NULL, NULL, 'DAFTAR PANITIA KELUARGA');

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_vendor_pengantin` int(11) NULL DEFAULT NULL,
  `biaya` int(255) NULL DEFAULT NULL,
  `tanggal_pembayaran` date NULL DEFAULT NULL,
  `status` tinyint(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengantin
-- ----------------------------
DROP TABLE IF EXISTS `pengantin`;
CREATE TABLE `pengantin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_panggilan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_sekarang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_nikah` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `agama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pendidikan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hobi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sosmed` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tambahan_data
-- ----------------------------
DROP TABLE IF EXISTS `tambahan_data`;
CREATE TABLE `tambahan_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_acara_field` int(11) NULL DEFAULT NULL,
  `value` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tambahan_field
-- ----------------------------
DROP TABLE IF EXISTS `tambahan_field`;
CREATE TABLE `tambahan_field`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tambahan_tipe` int(11) NULL DEFAULT NULL,
  `nama_field` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_label` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `isian` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `wajib` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tambahan_field
-- ----------------------------
INSERT INTO `tambahan_field` VALUES (1, 2, 'nama_ayah', 'Nama Ayah', 'text', 'Di isi Nama Ayah', NULL, NULL, 1);
INSERT INTO `tambahan_field` VALUES (3, 2, 'nama_kakak', 'Nama Kakak', 'addabletext', 'di isi nama kakak', NULL, NULL, 3);
INSERT INTO `tambahan_field` VALUES (8, 2, 'nama_ibu', 'Nama Ibu', 'text', 'di isi nama ibu', NULL, NULL, 2);
INSERT INTO `tambahan_field` VALUES (9, 2, 'adik', 'Nama Adik', 'addabletext', 'Nama Adik', NULL, NULL, 4);
INSERT INTO `tambahan_field` VALUES (10, 2, 'saudara_ayah', 'Saudara Ayah', 'addabletext', 'saudara ayah', NULL, NULL, 5);

-- ----------------------------
-- Table structure for tambahan_tipe
-- ----------------------------
DROP TABLE IF EXISTS `tambahan_tipe`;
CREATE TABLE `tambahan_tipe`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_tambahan_paket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` int(255) NULL DEFAULT NULL,
  `is_lampiran` tinyint(1) NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tambahan_tipe
-- ----------------------------
INSERT INTO `tambahan_tipe` VALUES (2, 'Daftar Tea Pai Mempelai Pria', NULL, NULL, NULL);
INSERT INTO `tambahan_tipe` VALUES (3, 'Daftar Tea Pai Mempelai Wanita', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for upacara_data
-- ----------------------------
DROP TABLE IF EXISTS `upacara_data`;
CREATE TABLE `upacara_data`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_upacara_field` int(11) NULL DEFAULT NULL,
  `value` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for upacara_field
-- ----------------------------
DROP TABLE IF EXISTS `upacara_field`;
CREATE TABLE `upacara_field`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_upacara_tipe` int(11) NULL DEFAULT NULL,
  `nama_field` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_label` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `isian` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `wajib` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 113 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of upacara_field
-- ----------------------------
INSERT INTO `upacara_field` VALUES (1, 1, 'siraman', 'Siraman', 'text', '0', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (2, 3, 'rias_pria_di', 'Rias Pengantin Pria Lokasi', 'text', '10', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (3, 3, 'rias_pria_oleh', 'Rias Pengantin Pria oleh', 'text', '30', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (4, 3, 'rias_mama_pria_di', 'Rias Mama Pengantin Pria Lokasi', 'text', '50', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (5, 3, 'rias_mama_pria_oleh', 'Rias Mama Penganti Pria oleh', 'text', '50', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (6, 3, 'rias_saudara_pria_jumlah', 'Rias Saudara Pria Jumlah', 'angka', '10', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (7, 3, 'rias_saudara_pria_di', 'Rias Saudara Pria Lokasi', 'text', '50', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (8, 3, 'rias_saudara_pria_oleh', 'Rias Saudara Pria Oleh', 'text', '50', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (9, 4, 'warna_gaun_mama', 'Warna Gaun Mama', 'text', '50', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (10, 4, 'warna_gaun_saudara', 'Warna Gaun Kakak / Adik', 'text', '50', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (15, 4, 'warna_jas_pengantin', 'Warna Jas Pengantin', 'text', '50', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (16, 4, 'warna_jas_papa', 'Warna Jas Papa', 'text', '50', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (17, 4, 'warna_jas_saudara_groomsman', 'Warna Jas Kakak / Adik / Groomsman', 'text', '50', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (18, 4, 'warna_dasi_pengantin', 'Warna Dasi Pengantin', 'text', '50', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (19, 4, 'warna_dasi_papa', 'Warna Dasi Papa', 'text', '50', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (20, 4, 'warna_dasi_saudara_groomsman', 'Warna Dasi Kakak / Adik / Groomsman', 'text', '50', NULL, NULL, 8);
INSERT INTO `upacara_field` VALUES (21, 4, 'warna_kemeja_pengantin', 'Warna Kemeja Pengantin', 'text', '50', NULL, NULL, 9);
INSERT INTO `upacara_field` VALUES (22, 4, 'warna_kemeja_papa', 'Warna Kemeja Papa', 'text', '50', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (23, 4, 'warna_kemeja_saudara_groomsman', 'Warna Kemeja Kakak / Adik / Groomsman', 'text', '50', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (24, 5, 'tempat_pasang_jas', 'Tempat Pasang Jas', 'text', '50', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (25, 5, 'is_kain_merah?', 'Apakah pakai Kain Merah?', 'checkbox', 'Ada', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (26, 5, 'is_kertas_merah', 'Apakah pakai kertas merah?', 'checkbox', 'Ada', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (27, 5, 'kain_merah_dari', 'Kain merah dari?', 'text', '50', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (28, 5, 'kertas_merah_dari', 'Kertas Merah dari?', 'text', '50', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (29, 5, 'dekorasi_kamar', 'Dekorasi Kamar', 'text', '50', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (30, 5, 'handbouquest_broos', 'Handbouquet / Bross pengantin ', 'text', '50', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (31, 5, 'mobil_start', 'Mobil Pengantin Mulai Pukul', 'text', '0', NULL, NULL, 8);
INSERT INTO `upacara_field` VALUES (32, 5, 'mobil_finish', 'Mobil Pengantin Selesai', 'text', '0', NULL, NULL, 9);
INSERT INTO `upacara_field` VALUES (33, 5, 'mobil_type', 'Mobil Pengantin Type', 'text', '0', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (34, 5, 'mobil_nopol', 'Mobil Pengantin Nomor Polisi', 'text', '0', NULL, NULL, 12);
INSERT INTO `upacara_field` VALUES (35, 5, 'mobil_dari', 'Mobil Pengantin dari', 'text', '0', NULL, NULL, 13);
INSERT INTO `upacara_field` VALUES (36, 5, 'mobil_nama_driver', 'Mobil Pengantin Nama Driver', 'text', '0', NULL, NULL, 14);
INSERT INTO `upacara_field` VALUES (37, 5, 'mobil_driver_nohp', 'Mobil Penganti No Hp Driver', 'text', '0', NULL, NULL, 15);
INSERT INTO `upacara_field` VALUES (38, 5, 'mobil_aksesoris', 'Mobil Pengantin Pakai Aksesoris?', 'checkbox', 'pakai plat nama||JUST MARRIES||tidak pakai', NULL, NULL, 16);
INSERT INTO `upacara_field` VALUES (39, 5, 'pengapit_pria', 'Pengapit Pria / Groomsman', 'addabletext', 'Nama||NoHp', NULL, NULL, 17);
INSERT INTO `upacara_field` VALUES (40, 5, 'is_pelangkahan', 'Pelangkahan ada?', 'checkbox', 'Ya', NULL, NULL, 18);
INSERT INTO `upacara_field` VALUES (41, 5, 'pelangkahan', 'Pelangkahan', 'text', '', NULL, NULL, 19);
INSERT INTO `upacara_field` VALUES (42, 5, 'wakil_temon_pria', 'Wakil keluarga untuk Temo', 'addabletext', 'Bp./Ibu||HP', NULL, NULL, 20);
INSERT INTO `upacara_field` VALUES (43, 5, 'forejider_jenis', 'Forejider jenis', 'combobox', 'Mobil||Motor', NULL, NULL, 21);
INSERT INTO `upacara_field` VALUES (44, 5, 'forejider_cp', 'Forejider CP', 'text', '', NULL, NULL, 22);
INSERT INTO `upacara_field` VALUES (45, 5, 'forejider_nohp', 'Forejider No Hp', 'text', '', NULL, NULL, 23);
INSERT INTO `upacara_field` VALUES (46, 5, 'breakfast_dari', 'Breakfast Box dari', 'text', '', NULL, NULL, 24);
INSERT INTO `upacara_field` VALUES (47, 5, 'breakfast_jumlah', 'Breakfast Box Jumlah', 'angka', '', NULL, NULL, 25);
INSERT INTO `upacara_field` VALUES (48, 5, 'mobil_lain_ortu', 'Mobil Lain Ortu Groom', 'text', '', NULL, NULL, 26);
INSERT INTO `upacara_field` VALUES (49, 5, 'mobil_lain_groomsman', 'Mobil Lain Groomsman', 'text', '', NULL, NULL, 27);
INSERT INTO `upacara_field` VALUES (50, 5, 'mobil_lain_sibling', 'Mobil Lain Sibling', 'text', '', NULL, NULL, 28);
INSERT INTO `upacara_field` VALUES (51, 5, 'mobil_lain_wakil_keluarga', 'Mobil Lain Wakil Keluarga', 'text', '', NULL, NULL, 29);
INSERT INTO `upacara_field` VALUES (52, 6, 'is_sembahyang_leluhur', 'Sembahyang Leluhur Ada?', 'checkbox', 'Ya', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (53, 6, 'sembahyang_di', 'Sembahyang Leluhur Di', 'text', '', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (54, 6, 'is_makan_ronde_misoa', 'Makan ronde / misoa ada?', 'checkbox', 'Ya', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (55, 6, 'makan_ronde_misoa_di', 'Makan ronde / misoa Di', 'text', '', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (56, 6, 'is_tea_pai_pria', 'Tea Pai Keluarga Mempelai Pria ada', 'checkbox', 'Ada', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (57, 6, 'tea_pai_pria_di', 'Tea Pai Keluarga Mempelai Pria Di', 'text', '', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (58, 6, 'tea_pai_pria_koordinator', 'Tea Pai Keluarga Mempelai Pria Koordinator', 'text', '', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (59, 6, 'tea_pai_pria_koordinator_nohp', 'Tea Pai Keluarga Mempelai Pria Koordinator No Hp', 'text', '', NULL, NULL, 8);
INSERT INTO `upacara_field` VALUES (60, 6, 'is_foto_kamar_pria', 'Foto Kamar Pengantin Ada?', 'checkbox', 'Ada', NULL, NULL, 9);
INSERT INTO `upacara_field` VALUES (61, 6, 'foto_kamar_pria_di', 'Foto Kamar Penganti Di', 'text', '', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (62, 6, 'is_foto_stasi', 'Foto Stasi Ada', 'checkbox', 'Ada', NULL, NULL, 11);
INSERT INTO `upacara_field` VALUES (63, 6, 'foto_statis', 'Foto Stasi', 'combobox', 'Outdoor||Studio', NULL, NULL, 12);
INSERT INTO `upacara_field` VALUES (64, 6, 'foto_stasi_di', 'Foto Stasi di', 'text', '', NULL, NULL, 13);
INSERT INTO `upacara_field` VALUES (65, 6, 'koreksi_rias', 'Koreksi Rias', 'text', '', NULL, NULL, 14);
INSERT INTO `upacara_field` VALUES (66, 8, 'rias_pengantin_wanita_di', 'Rias Pengantin Wanita di', 'text', '', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (67, 8, 'rias_pengantin_wanita_oleh', 'Rias Pengantin Wanita oleh', 'text', '', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (68, 8, 'rias_mama_pengantin_wanita_di', 'Rias Mama Pengantin Wanita', 'text', '', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (69, 8, 'rias_mama_pengantin_wanita_oleh', 'Rias Mama Pengantin Wanita oleh', 'text', '', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (70, 8, 'rias_pengapit_wanita_jumlah', 'Rias Pengapit Putri Jumlah', 'angka', '', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (71, 8, 'rias_pengapit_wanita_di', 'Rias Pengapit Wanita di', 'text', '', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (72, 8, 'rias_pengantin_wanita_oleh', 'Rias Pengantin Wanita oleh', 'text', '', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (73, 8, 'rias_saudara_jumlah', 'Rias Kakak / Adik Jumlah', 'angka', '', NULL, NULL, 8);
INSERT INTO `upacara_field` VALUES (74, 8, 'rias_saudara_di', 'Rias Kakak / Adik di', 'text', '', NULL, NULL, 9);
INSERT INTO `upacara_field` VALUES (75, 8, 'rias_saudara_oleh', 'Rias Kakak / Adik oleh', 'text', '', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (76, 9, 'warna_gaun_bride', 'Warna Gaun Pengantin Wanita', 'text', '', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (77, 9, 'warna_gaun_mama_bride', 'Warna Gaun Mama Wanita', 'text', '', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (78, 9, 'warna_gaun_saudara_bridesmaid', 'Warna Gaun Kakak / Adik / Bridesmaid', 'text', '', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (79, 9, 'warna_jas_papa_bride', 'Warna Jas Papa', 'text', '', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (80, 9, 'warna_jas_saudara_bride', 'Warna Jas Kakak / Adik', 'text', '', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (81, 9, 'warna_jas_groomsman_bride', 'Warna Jas Groomsmen', 'text', '', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (82, 9, 'warna_dasi_papa_bride', 'Warna Dasi Papa', 'text', '', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (83, 9, 'warna_dasi_saudara', 'Warna Dasi Kakak / Adik', 'text', '', NULL, NULL, 8);
INSERT INTO `upacara_field` VALUES (84, 9, 'warna_dasi_groomsman', 'Warna Dasi Groomsman', 'text', '', NULL, NULL, 9);
INSERT INTO `upacara_field` VALUES (85, 9, 'warna_kemeja_papa_bride', 'Warna Kemeja Papa', 'text', '', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (86, 9, 'warna_kemeja_saudara', 'Warna Kemeja Kakak / Adik', 'text', '', NULL, NULL, 11);
INSERT INTO `upacara_field` VALUES (87, 9, 'warna_kemeja_groomsmen', 'Warna Kemeja Groomsmen', 'text', '', NULL, NULL, 12);
INSERT INTO `upacara_field` VALUES (88, 10, 'tempat_tutup_waring', 'Tempat', 'text', '', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (89, 10, 'is_kain_merah_tutup_waring', 'Apakah pakai kain merah?', 'checkbox', 'Ada', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (90, 10, 'kain_merah_tutup_waring_dari', 'Kain Merah dari', 'text', '', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (91, 10, 'is_kertas_merah_tutup_waring', 'Apakah pakai kertas merah?', 'checkbox', 'Pakai', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (92, 10, 'kertas_merah_dari', 'Kertas Merah dari', 'text', '', NULL, NULL, 5);
INSERT INTO `upacara_field` VALUES (93, 10, 'dekorasi_kamar_bride', 'Dekorasi Kamar', 'text', '', NULL, NULL, 6);
INSERT INTO `upacara_field` VALUES (94, 10, 'handbouquest_broos_bride', 'Handbouquet / Bross pengantin ', 'text', '', NULL, NULL, 7);
INSERT INTO `upacara_field` VALUES (95, 10, 'is_handbouquet_bridesmaid', 'Handbouquet Bridesmaid Ada', 'checkbox', 'Ada', NULL, NULL, 8);
INSERT INTO `upacara_field` VALUES (96, 10, 'Handbouquet_bridesmaid_dari', 'Handbouquet Bridesmaid Dari', 'text', '', NULL, NULL, 9);
INSERT INTO `upacara_field` VALUES (97, 10, 'bridesmaid', 'Pengapit Purti / Bridesmaid', 'addabletext', 'Nama||No Hp', NULL, NULL, 10);
INSERT INTO `upacara_field` VALUES (98, 10, 'is_pelangkahan', 'Pelangkahan', 'checkbox', 'Ada', NULL, NULL, 11);
INSERT INTO `upacara_field` VALUES (99, 10, 'is_payung_beras_kuning', 'Payung dan Beras Kuning ada', 'checkbox', 'Ada', NULL, NULL, 12);
INSERT INTO `upacara_field` VALUES (100, 10, 'payung_beras_pembawa', 'Payung dan Beras Kuning Pembawa Payung', 'text', '', NULL, NULL, 13);
INSERT INTO `upacara_field` VALUES (101, 10, 'payung_beras_nohp', 'Payung dan Beras Kuning Pembawa No Hp', 'text', '', NULL, NULL, 14);
INSERT INTO `upacara_field` VALUES (102, 10, 'is_ronde_misoa', 'Makan Ronde / Misoa', 'checkbox', 'Ada', NULL, NULL, 15);
INSERT INTO `upacara_field` VALUES (103, 10, 'ronde_misoa_disiapkan', 'Makan Ronde / Misoa Di siapkan oleh', 'text', '', NULL, NULL, 16);
INSERT INTO `upacara_field` VALUES (104, 10, 'breakfast_dari', 'Breakfast Box Dari', 'text', '', NULL, NULL, 17);
INSERT INTO `upacara_field` VALUES (105, 10, 'breakfast_jumlah', 'Breakfast Box Jumlah', 'angka', '', NULL, NULL, 18);
INSERT INTO `upacara_field` VALUES (106, 10, 'mobil_ortu_bride', 'Mobil Ortu Bride', 'text', '', NULL, NULL, 19);
INSERT INTO `upacara_field` VALUES (107, 10, 'mobil_sibling_bride', 'Mobil Sibling', 'text', '', NULL, NULL, 20);
INSERT INTO `upacara_field` VALUES (108, 11, 'tea_pai_bride_ada', 'Tea Pai Keluarga Perempuan Ada', 'checkbox', 'Ada', NULL, NULL, 1);
INSERT INTO `upacara_field` VALUES (109, 11, 'tea_pie_bride_di', 'Tea Pai Keluarga Perempuan Di', 'text', '', NULL, NULL, 2);
INSERT INTO `upacara_field` VALUES (110, 11, 'tea_pie_koordinator', 'Tea Pai Keluarga Perempuan Koordinator', 'text', '', NULL, NULL, 3);
INSERT INTO `upacara_field` VALUES (111, 11, 'tea_pie_koordinator_nohp', 'Tea Pai Keluarga Perempuan Koordinator No Hp', 'text', '', NULL, NULL, 4);
INSERT INTO `upacara_field` VALUES (112, 11, 'koreksi_rias', 'Koreksi Rias', 'text', '', NULL, NULL, 5);

-- ----------------------------
-- Table structure for upacara_tipe
-- ----------------------------
DROP TABLE IF EXISTS `upacara_tipe`;
CREATE TABLE `upacara_tipe`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_acara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_upacara` int(10) NULL DEFAULT 0,
  `nama_upacara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `form` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of upacara_tipe
-- ----------------------------
INSERT INTO `upacara_tipe` VALUES (2, NULL, 0, 'Data Upacara Pernikahan Pengantin Pria (Groom)', NULL, 'FORM 3A');
INSERT INTO `upacara_tipe` VALUES (3, NULL, 2, 'Acara Rias / Make Up', '1', NULL);
INSERT INTO `upacara_tipe` VALUES (4, NULL, 2, 'Dress Code / Nuansa / Tema Kostum', '2', NULL);
INSERT INTO `upacara_tipe` VALUES (5, NULL, 2, 'Acara Pasang Jas', '3', NULL);
INSERT INTO `upacara_tipe` VALUES (6, NULL, 2, 'Acara Setelah Pemberkatan', '4', NULL);
INSERT INTO `upacara_tipe` VALUES (7, NULL, 0, 'Data Upacara Pernikahan Pengantin Wanita ( Bride )', NULL, 'FORM 3B');
INSERT INTO `upacara_tipe` VALUES (8, NULL, 7, 'Acara Risa / Make Up', '1', NULL);
INSERT INTO `upacara_tipe` VALUES (9, NULL, 7, 'Dress Code / Nuansa / Tema Kostum', '2', NULL);
INSERT INTO `upacara_tipe` VALUES (10, NULL, 7, 'Acara Tutup Waring', '3', NULL);
INSERT INTO `upacara_tipe` VALUES (11, NULL, 7, 'Acara Setelah Pemberkatan', '4', NULL);

-- ----------------------------
-- Table structure for vendor
-- ----------------------------
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NULL DEFAULT NULL,
  `id_company` int(11) NULL DEFAULT NULL,
  `vendor` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nohp_cp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vendor
-- ----------------------------
INSERT INTO `vendor` VALUES (1, 3, 1, 'Bridal 1 2 3', '08579456587', '0465977889', 'Bridal 123');

-- ----------------------------
-- Table structure for vendor_pengantin
-- ----------------------------
DROP TABLE IF EXISTS `vendor_pengantin`;
CREATE TABLE `vendor_pengantin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NULL DEFAULT NULL,
  `id_vendor` int(11) NULL DEFAULT NULL,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `nama_vendor` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `cp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nohp_cp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `biaya` int(255) NULL DEFAULT NULL,
  `dibayaroleh` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` tinyint(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wedding
-- ----------------------------
DROP TABLE IF EXISTS `wedding`;
CREATE TABLE `wedding`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_company` int(255) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengantin_pria` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengantin_wanita` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `waktu` time(0) NULL DEFAULT NULL,
  `tempat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tema` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hashtag` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `penyelenggara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `undangan` int(255) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wedding_acara
-- ----------------------------
DROP TABLE IF EXISTS `wedding_acara`;
CREATE TABLE `wedding_acara`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(10) NULL DEFAULT NULL,
  `id_acara_tipe` int(10) NULL DEFAULT NULL,
  `urutan` int(10) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wedding_panitia
-- ----------------------------
DROP TABLE IF EXISTS `wedding_panitia`;
CREATE TABLE `wedding_panitia`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(10) NULL DEFAULT NULL,
  `id_panitia_tipe` int(10) NULL DEFAULT NULL,
  `urutan` int(10) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wedding_upacara
-- ----------------------------
DROP TABLE IF EXISTS `wedding_upacara`;
CREATE TABLE `wedding_upacara`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(10) NULL DEFAULT NULL,
  `id_upacara_tipe` int(10) NULL DEFAULT NULL,
  `urutan` int(10) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jadwal_meeting
-- ----------------------------
DROP TABLE IF EXISTS `jadwal_meeting`;
CREATE TABLE `jadwal_meeting`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tanggal` date NULL DEFAULT NULL,
  `waktu` time(0) NULL DEFAULT NULL,
  `tempat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keperluan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_wedding` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kepada` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for undangan
-- ----------------------------
DROP TABLE IF EXISTS `undangan`;
CREATE TABLE `undangan`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wedding` int(11) NULL DEFAULT NULL,
  `id_pengantin` int(11) NULL DEFAULT NULL,
  `nama` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tipe_undangan` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `barcode` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
