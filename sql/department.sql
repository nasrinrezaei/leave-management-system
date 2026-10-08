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

 Date: 21/08/2023 20:39:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `department_id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `no_space_name_d` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`department_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES (7, 'آموزش', 'آموزش');
INSERT INTO `department` VALUES (17, 'فناوری اطلاعات', 'فناوریاطلاعات');
INSERT INTO `department` VALUES (24, 'امور مالی', 'امورمالی');
INSERT INTO `department` VALUES (25, 'تولید', 'تولید');
INSERT INTO `department` VALUES (27, 'انبارداری', 'انبارداری');

SET FOREIGN_KEY_CHECKS = 1;
