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

 Date: 21/08/2023 20:41:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for token_leave
-- ----------------------------
DROP TABLE IF EXISTS `token_leave`;
CREATE TABLE `token_leave`  (
  `token_hours_for_illness` int NULL DEFAULT NULL,
  `token_hours_for_without_salary` int NULL DEFAULT NULL,
  `employee_id` int UNSIGNED NOT NULL,
  `token_hours_for_entitlent` int NULL DEFAULT NULL,
  PRIMARY KEY (`employee_id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `Token_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of token_leave
-- ----------------------------
INSERT INTO `token_leave` VALUES (0, 0, 77, 0);
INSERT INTO `token_leave` VALUES (0, 0, 78, 0);
INSERT INTO `token_leave` VALUES (0, 0, 88, 0);
INSERT INTO `token_leave` VALUES (0, 0, 98, 0);
INSERT INTO `token_leave` VALUES (0, 0, 112, 0);
INSERT INTO `token_leave` VALUES (0, 0, 256, 0);
INSERT INTO `token_leave` VALUES (0, 0, 321, 0);
INSERT INTO `token_leave` VALUES (0, 0, 502, 0);
INSERT INTO `token_leave` VALUES (12, 12, 111122, 12);
INSERT INTO `token_leave` VALUES (0, 0, 123125, 0);
INSERT INTO `token_leave` VALUES (0, 0, 124124, 0);

SET FOREIGN_KEY_CHECKS = 1;
