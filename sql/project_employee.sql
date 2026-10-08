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

 Date: 21/08/2023 20:41:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for project_employee
-- ----------------------------
DROP TABLE IF EXISTS `project_employee`;
CREATE TABLE `project_employee`  (
  `imployee_id` int UNSIGNED NOT NULL,
  `project_id` int UNSIGNED NOT NULL,
  `imployee_project_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `report` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`imployee_project_id`) USING BTREE,
  INDEX `project_id`(`project_id` ASC) USING BTREE,
  INDEX `imployee_id`(`imployee_id` ASC) USING BTREE,
  CONSTRAINT `employee_id` FOREIGN KEY (`imployee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of project_employee
-- ----------------------------
INSERT INTO `project_employee` VALUES (200, 1, 5, ' 111 ');
INSERT INTO `project_employee` VALUES (444, 2, 9, ' 123');
INSERT INTO `project_employee` VALUES (444, 13, 10, '11');
INSERT INTO `project_employee` VALUES (444, 17, 11, '1111 ');
INSERT INTO `project_employee` VALUES (444, 19, 13, ' سلام،');
INSERT INTO `project_employee` VALUES (124124, 8, 15, ' با سلام، وظایف زیر انجام شود:\r\n1) وظیفه 1\r\n2)وظیفه 2');
INSERT INTO `project_employee` VALUES (124124, 19, 16, ' ,وظایف');
INSERT INTO `project_employee` VALUES (124124, 19, 17, 'کارهای زیر انجام شود:\r\n1)\r\n2)');
INSERT INTO `project_employee` VALUES (200, 8, 21, ' وظایف زیر را انجام دهید:\r\nوظیفه 1\r\nوظیفه 2');
INSERT INTO `project_employee` VALUES (300, 19, 22, ' کارهای زیر را انجام دهید.\r\n1)\r\n2)\r\n3)\r\n4)');
INSERT INTO `project_employee` VALUES (77, 10, 23, 'وظایف 1');
INSERT INTO `project_employee` VALUES (77, 18, 24, 'وظایف 2');
INSERT INTO `project_employee` VALUES (77, 3, 25, 'وظایف 3');

SET FOREIGN_KEY_CHECKS = 1;
