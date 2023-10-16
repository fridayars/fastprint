/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : db_fastprint

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 16/10/2023 11:14:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fastprint
-- ----------------------------
DROP TABLE IF EXISTS `fastprint`;
CREATE TABLE `fastprint`  (
  `no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fastprint
-- ----------------------------
INSERT INTO `fastprint` VALUES ('7', '6', 'ALCOHOL GEL POLISH CLEANSER GP-CLN01', 'L QUEENLY', '12500', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('10', '9', 'ALUMUNIUM FOIL ALL IN ONE BULAT 23mm IM', 'L MTH AKSESORIS (IM)', '1000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('12', '11', 'ALUMUNIUM FOIL ALL IN ONE BULAT 30mm IM', 'L MTH AKSESORIS (IM)', '1000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('13', '12', 'ALUMUNIUM FOIL ALL IN ONE SHEET 250mm IM', 'L MTH AKSESORIS (IM)', '12500', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('16', '15', 'ALUMUNIUM FOIL HDPE/PE BULAT 23mm IM', 'L MTH AKSESORIS (IM)', '12500', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('18', '17', 'ALUMUNIUM FOIL HDPE/PE BULAT 30mm IM', 'L MTH AKSESORIS (IM)', '1000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('19', '18', 'ALUMUNIUM FOIL HDPE/PE SHEET 250mm IM', 'L MTH AKSESORIS (IM)', '13000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('20', '19', 'ALUMUNIUM FOIL PET SHEET 250mm IM', 'L MTH AKSESORIS (IM)', '1000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('23', '22', 'ARM PENDEK MODEL U', 'L MTH AKSESORIS (IM)', '13000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('24', '23', 'ARM SUPPORT KECIL', 'L MTH TABUNG (LK)', '13000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('25', '24', 'ARM SUPPORT KOTAK PUTIH', 'L MTH AKSESORIS (IM)', '13000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('27', '26', 'ARM SUPPORT PENDEK POLOS', 'L MTH TABUNG (LK)', '13000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('28', '27', 'ARM SUPPORT S IM', 'L MTH AKSESORIS (IM)', '1000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('29', '28', 'ARM SUPPORT T (IMPORT)', 'L MTH AKSESORIS (IM)', '13000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('30', '29', 'ARM SUPPORT T - MODEL 1 ( LOKAL )', 'L MTH TABUNG (LK)', '10000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('51', '50', 'BLACK LASER TONER FP-T3 (100gr)', 'L MTH AKSESORIS (IM)', '13000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('57', '56', 'BODY PRINTER CANON IP2770', 'SP MTH SPAREPART (LK)', '500', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('59', '58', 'BODY PRINTER T13X', 'SP MTH SPAREPART (LK)', '15000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('60', '59', 'BOTOL 1000ML BLUE KHUSUS UNTUK EPSON R1800/R800 - 4180 IM (T054920)', 'CI MTH TINTA LAIN (IM)', '10000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('61', '60', 'BOTOL 1000ML CYAN KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4120 IM (T054220)', 'CI MTH TINTA LAIN (IM)', '10000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('62', '61', 'BOTOL 1000ML GLOSS OPTIMIZER KHUSUS UNTUK EPSON R1800/R800/R1900/R2000/IX7000/MG6170 - 4100 IM (T054020)', 'CI MTH TINTA LAIN (IM)', '1500', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('63', '62', 'BOTOL 1000ML L.LIGHT BLACK KHUSUS UNTUK EPSON 2400 - 0599 IM', 'CI MTH TINTA LAIN (IM)', '1500', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('64', '63', 'BOTOL 1000ML LIGHT BLACK KHUSUS UNTUK EPSON 2400 - 0597 IM', 'CI MTH TINTA LAIN (IM)', '1500', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('65', '64', 'BOTOL 1000ML MAGENTA KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4140 IM (T054320)', 'CI MTH TINTA LAIN (IM)', '1000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('66', '65', 'BOTOL 1000ML MATTE BLACK KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 3503 IM (T054820)', 'CI MTH TINTA LAIN (IM)', '1500', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('67', '66', 'BOTOL 1000ML ORANGE KHUSUS UNTUK EPSON R1900/R2000 IM - 4190 (T087920)', 'CI MTH TINTA LAIN (IM)', '1500', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('68', '67', 'BOTOL 1000ML RED KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4170 IM (T054720)', 'CI MTH TINTA LAIN (IM)', '1000', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('69', '68', 'BOTOL 1000ML YELLOW KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4160 IM (T054420)', 'CI MTH TINTA LAIN (IM)', '1500', 'tidak bisa dijual');
INSERT INTO `fastprint` VALUES ('71', '70', 'BOTOL KOTAK 100ML LK', 'L MTH AKSESORIS (LK)', '1000', 'bisa dijual');
INSERT INTO `fastprint` VALUES ('73', '72', 'BOTOL 10ML IM', 'S MTH STEMPEL (IM)', '1000', 'tidak bisa dijual');

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int NOT NULL AUTO_INCREMENT COMMENT ' ',
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'CI MTH TINTA LAIN (IM)');
INSERT INTO `kategori` VALUES (2, 'L MTH AKSESORIS (IM)');
INSERT INTO `kategori` VALUES (3, 'L MTH AKSESORIS (LK)');
INSERT INTO `kategori` VALUES (4, 'L MTH TABUNG (LK)');
INSERT INTO `kategori` VALUES (5, 'L QUEENLY');
INSERT INTO `kategori` VALUES (6, 'S MTH STEMPEL (IM)');
INSERT INTO `kategori` VALUES (7, 'SP MTH SPAREPART (LK)');

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` int NULL DEFAULT NULL,
  `kategori_id` int NULL DEFAULT NULL,
  `status_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (6, 'ALCOHOL GEL POLISH CLEANSER GP-CLN01', 12500, 5, 1);
INSERT INTO `produk` VALUES (9, 'ALUMUNIUM FOIL ALL IN ONE BULAT 23mm IM', 1000, 2, 1);
INSERT INTO `produk` VALUES (11, 'ALUMUNIUM FOIL ALL IN ONE BULAT 30mm IM', 1000, 2, 1);
INSERT INTO `produk` VALUES (12, 'ALUMUNIUM FOIL ALL IN ONE SHEET 250mm IM', 12500, 2, 2);
INSERT INTO `produk` VALUES (15, 'ALUMUNIUM FOIL HDPE/PE BULAT 23mm IM', 12500, 2, 1);
INSERT INTO `produk` VALUES (17, 'ALUMUNIUM FOIL HDPE/PE BULAT 30mm IM', 1000, 2, 1);
INSERT INTO `produk` VALUES (18, 'ALUMUNIUM FOIL HDPE/PE SHEET 250mm IM', 13000, 2, 2);
INSERT INTO `produk` VALUES (19, 'ALUMUNIUM FOIL PET SHEET 250mm IM', 1000, 2, 2);
INSERT INTO `produk` VALUES (22, 'ARM PENDEK MODEL U', 13000, 2, 1);
INSERT INTO `produk` VALUES (23, 'ARM SUPPORT KECIL', 13000, 4, 2);
INSERT INTO `produk` VALUES (24, 'ARM SUPPORT KOTAK PUTIH', 13000, 2, 2);
INSERT INTO `produk` VALUES (26, 'ARM SUPPORT PENDEK POLOS', 13000, 4, 1);
INSERT INTO `produk` VALUES (27, 'ARM SUPPORT S IM', 1000, 2, 2);
INSERT INTO `produk` VALUES (28, 'ARM SUPPORT T (IMPORT)', 13000, 2, 1);
INSERT INTO `produk` VALUES (29, 'ARM SUPPORT T - MODEL 1 ( LOKAL )', 10000, 4, 1);
INSERT INTO `produk` VALUES (50, 'BLACK LASER TONER FP-T3 (100gr)', 13000, 2, 2);
INSERT INTO `produk` VALUES (56, 'BODY PRINTER CANON IP2770', 500, 7, 1);
INSERT INTO `produk` VALUES (58, 'BODY PRINTER T13X', 15000, 7, 1);
INSERT INTO `produk` VALUES (59, 'BOTOL 1000ML BLUE KHUSUS UNTUK EPSON R1800/R800 - 4180 IM (T054920)', 10000, 1, 1);
INSERT INTO `produk` VALUES (60, 'BOTOL 1000ML CYAN KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4120 IM (T054220)', 10000, 1, 2);
INSERT INTO `produk` VALUES (61, 'BOTOL 1000ML GLOSS OPTIMIZER KHUSUS UNTUK EPSON R1800/R800/R1900/R2000/IX7000/MG6170 - 4100 IM (T054020)', 1500, 1, 1);
INSERT INTO `produk` VALUES (62, 'BOTOL 1000ML L.LIGHT BLACK KHUSUS UNTUK EPSON 2400 - 0599 IM', 1500, 1, 2);
INSERT INTO `produk` VALUES (63, 'BOTOL 1000ML LIGHT BLACK KHUSUS UNTUK EPSON 2400 - 0597 IM', 1500, 1, 2);
INSERT INTO `produk` VALUES (64, 'BOTOL 1000ML MAGENTA KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4140 IM (T054320)', 1000, 1, 1);
INSERT INTO `produk` VALUES (65, 'BOTOL 1000ML MATTE BLACK KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 3503 IM (T054820)', 1500, 1, 2);
INSERT INTO `produk` VALUES (66, 'BOTOL 1000ML ORANGE KHUSUS UNTUK EPSON R1900/R2000 IM - 4190 (T087920)', 1500, 1, 1);
INSERT INTO `produk` VALUES (67, 'BOTOL 1000ML RED KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4170 IM (T054720)', 1000, 1, 2);
INSERT INTO `produk` VALUES (68, 'BOTOL 1000ML YELLOW KHUSUS UNTUK EPSON R1800/R800/R1900/R2000 - 4160 IM (T054420)', 1500, 1, 2);
INSERT INTO `produk` VALUES (70, 'BOTOL KOTAK 100ML LK', 1000, 3, 1);
INSERT INTO `produk` VALUES (72, 'BOTOL 10ML IM', 1000, 6, 2);
INSERT INTO `produk` VALUES (73, 'Kertas 500gr', 60000, 5, 1);
INSERT INTO `produk` VALUES (74, 'Kertas 500gr', 60000, 5, 1);
INSERT INTO `produk` VALUES (75, 'TEST', 866842, 2, 1);
INSERT INTO `produk` VALUES (76, 'TEST LAGI', 7686472, 2, 1);
INSERT INTO `produk` VALUES (77, 'TESTTEST', 7979, 1, 1);
INSERT INTO `produk` VALUES (78, 'rgfegf', 0, 0, 0);
INSERT INTO `produk` VALUES (79, 'TEST', 0, 0, 0);
INSERT INTO `produk` VALUES (80, 'hkbkh', 0, 0, 0);
INSERT INTO `produk` VALUES (81, 'fefw', 0, 0, 0);
INSERT INTO `produk` VALUES (82, 'fefw', 0, 0, 0);
INSERT INTO `produk` VALUES (83, 'ewf', 0, 0, 0);
INSERT INTO `produk` VALUES (84, 'fwfs', 0, 0, 0);
INSERT INTO `produk` VALUES (85, 'fwfs', 0, 0, 0);
INSERT INTO `produk` VALUES (86, 'fwfs', 0, 0, 0);
INSERT INTO `produk` VALUES (87, 'bismillah', 323424, 2, 1);
INSERT INTO `produk` VALUES (88, 'bismillah', 343243, 3, 2);
INSERT INTO `produk` VALUES (91, '5435', 0, 0, 0);
INSERT INTO `produk` VALUES (92, 'safse', 0, 0, 0);

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `nama_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES (1, 'bisa dijual');
INSERT INTO `status` VALUES (2, 'tidak bisa dijual');

SET FOREIGN_KEY_CHECKS = 1;
