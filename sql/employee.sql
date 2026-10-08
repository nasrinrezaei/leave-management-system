/*
 Navicat MySQL Data Transfer

 Source Server         : project_finaly
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : mydb

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 21/08/2023 20:40:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `employee_id` int UNSIGNED NOT NULL,
  `department_id` tinyint UNSIGNED NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `no_space_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `no_space_family` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `no_space_name_family` varchar(250) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `Ssn` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `birth_date` date NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `gender` enum('woman','man') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'woman',
  `marital_staus` enum('married','single') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'single',
  `role` enum('user','admin') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'user',
  `address` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `mobile` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `position` enum('employee','manager1','manager2') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'employee',
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`employee_id`) USING BTREE,
  INDEX `department_id`(`department_id` ASC) USING BTREE,
  CONSTRAINT `department_id` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES (77, 24, 'مینا', 'مینا', 'مهدوی', 'مهدوی', 'مینامهدوی', '0012399999', '0781-03-04', '0781-03-04', 'woman', 'single', 'user', '       ', '', '77', '$2y$10$ww/Op.aWhhTIWXnbfAJN2O4BU6VsCRculJ.3U9yiZOq9YyhxoWr.G', '', 'employee', '');
INSERT INTO `employee` VALUES (78, 7, 'فرهاد', 'فرهاد', 'حسینی', 'حسینی', 'فرهادحسینی', '0011525267', '1992-07-24', '2023-08-17', 'man', 'single', 'admin', '           ', '', '78', '$2y$10$I6XA4JBVNQFS1aqLTriwBe044oAhDjWllOViB2cdBph75kJjD/Pbm', '', 'employee', '');
INSERT INTO `employee` VALUES (88, 25, 'شادی', 'شادی', 'حاتمی', 'حاتمی', 'شادیحاتمی', '0031412345', '1997-08-17', '2023-08-17', 'woman', 'single', 'user', '  ', '', '88', '$2y$10$urfHSgFXrgUMLu37zKDbDecEgeAXKvyp1Kp533hPMbwu59I6yh3cC', '', 'employee', '');
INSERT INTO `employee` VALUES (98, 27, 'زهرا', 'زهرا', 'احمدی', 'احمدی', 'زهرااحمدی', '0015454540', '1993-08-17', '2023-08-17', 'woman', 'single', 'user', '  ', '09128205887', '98', '$2y$10$6uypyp6yosCMLmXi4CaB8eOt0HTBy.xoKBHEuoarWMwjBEJ79BdBK', '', 'employee', '');
INSERT INTO `employee` VALUES (100, 17, 'ستاره', 'ستاره', 'مرادی', 'مرادی', 'ستارهمرادی', '0520666888', '2001-08-12', '2023-08-12', 'woman', 'single', 'admin', '       ', '', '88881234567', '$2y$10$UWlo9/PUZwI799Tj1w3kveRDa0IGwhUGqtkSWBtt3/g2UOmAYXyO2', '', 'employee', '100.png');
INSERT INTO `employee` VALUES (112, 24, 'مهتا', 'مهتا', 'مبینی', 'مبینی', 'مهتامبینی', '0021717874', '1997-08-17', '2023-08-17', 'woman', 'single', 'admin', '   ', '', '112', '$2y$10$rs/ENZ12capno9f.S9sBcur0tFQ7jd2T0p278/0AJ58Ur0/mg.cGq', '', 'employee', '');
INSERT INTO `employee` VALUES (200, 17, 'محمد', 'محمدپارسا', 'پارسا', 'پارسا', 'محمدپارسا', ' 052099386', '2023-08-01', '2023-08-01', 'woman', 'single', 'user', '', '09338205887', '14444478', 'd75e3b09b2a3c26de09b9a8f1e3b7e5ab7b51b00', '', 'employee', '');
INSERT INTO `employee` VALUES (256, 24, 'یاسمین', 'یاسمین', 'طاهری', 'طاهری', 'یاسمینطاهری', '0021251230', '2023-08-17', '2023-08-17', 'woman', 'single', 'admin', ' ', '', '256', '$2y$10$gT.SOY.ZUxDE0CNNw8NNuOJorkisl5pNeMrcQ9oFlRV.CpnegJ6o2', '', 'employee', '');
INSERT INTO `employee` VALUES (300, 17, 'محمد', 'محمد', 'کوهبری', 'کوهبری', 'محمدکوهبری', ' 052099380', '2023-08-04', '2023-08-04', 'woman', 'single', 'user', '', '', '144444777', '$2y$10$GHK4v6XMX3bBjyNxr3EoLe5Ud70aMDD3REFHEHsR9FpsZY9X/hCxy', '', 'employee', '');
INSERT INTO `employee` VALUES (321, 7, 'زهرا', 'زهرا', 'احمدی', 'احمدی', 'زهرااحمدی', '0520999888', '2023-07-26', '2023-07-25', 'woman', 'single', 'admin', '   ', '', '321', '$2y$10$D4yXqTZN9B.QtfZprgDm7OwPA84zxGwjaB1gOtEjQ8cg0scxG.TJW', '', 'employee', '');
INSERT INTO `employee` VALUES (444, 25, 'نسرین', 'نسرین', 'رضایی', 'رضایی', 'نسرینرضایی', '0012345687', '2001-08-10', '2023-08-10', 'woman', 'single', 'admin', '       ', '09128205881', 'salam', '$2y$10$iLneUQ2w7.IHY/oOj9AoN.7BfIOOviBY5BOGYHwX9kBM.PlEfYFka', '', 'employee', '');
INSERT INTO `employee` VALUES (500, 17, 'نسترن', 'نسترن', 'پارسا', 'پارسا', 'نسترنپارسا', ' 052099377', '2023-08-09', '2023-08-09', 'woman', 'single', 'admin', '', '09338205777', '12345698', '$2y$10$.ZEb2DBrug9IEiHytA1mp.MrU3IOZLI83mEtWpTzoRrtbMCKvedn.', '', 'manager1', '');
INSERT INTO `employee` VALUES (502, 17, 'نسیم', 'نسیم', 'مرادی', 'مرادی', 'نسیممرادی', ' 0031234444', '1996-08-20', '0635-08-22', 'woman', 'single', 'admin', '', '', '502', '$2y$10$VHOp4nPseNwgXnWsFOJwy.r8k3wS7w2qtkdvGIg5DTtLkFeysaCZa', '', 'manager1', '');
INSERT INTO `employee` VALUES (1234, 24, 'محمد', 'محمد', 'کوهبری', 'کوهبری', 'محمدکوهبری', '0012125410', '1966-07-31', '2023-07-27', 'man', 'single', 'admin', ' ', '09338205887', '1234', '$2y$10$Qy.pftdrxjD9.Me9ke1pfu95SG1Y0oI4vTVaTutwTMWwEqxjeH91K', '', 'manager1', '');
INSERT INTO `employee` VALUES (111122, 17, 'زهرا ', 'زهرا', 'کوهبری', 'کوهبری', 'زهراکوهبری', '0011234569', '2023-08-14', '2023-08-22', 'woman', 'single', 'admin', '    ', '', '123456777', '$2y$10$zQ.xKbzb6kcNtISe7TuAkOpmdvwOe1JXgoGLFzuWV1geM9oIMDCRe', '', 'manager2', '111122.png');
INSERT INTO `employee` VALUES (123125, 7, 'زهرا', 'زهرا', 'پارسا', 'پارسا', 'زهراپارسا', '0011222333', '2023-08-02', '2023-08-17', 'woman', 'single', 'admin', ' ', '', '123125', '$2y$10$iNoqh/tLV0LtBzvV2ZFFWuj3UkIA1fBKtIhEPGt7cl1Ghc2eBSZda', '', 'employee', '');
INSERT INTO `employee` VALUES (124124, 17, 'ژاله', 'ژاله', 'محمدی', 'محمدی', 'ژالهمحمدی', ' 0021231230', '2023-08-16', '2023-08-16', 'woman', 'single', 'user', '', '', '124124', '$2y$10$/DkYSP.MXZAEHgfJdHwaMOuy9ACd0QdT8XFBox09np3wOQjGhdeDe', '', 'employee', '');
INSERT INTO `employee` VALUES (125125, 7, 'پریسا', 'پریسا', 'طهرانی', 'طهرانی', 'پریساطهرانی', '0012258258', '2023-08-16', '2023-08-16', 'woman', 'single', 'admin', '   ', '', '125125', '$2y$10$/SNmTQNfbQvnlxisStdvDeLvUK15mS/lUo6CwtuM.lYVM3rqWJE9q', '', 'employee', '');

SET FOREIGN_KEY_CHECKS = 1;
