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

 Date: 21/08/2023 20:40:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for function
-- ----------------------------
DROP TABLE IF EXISTS `function`;
CREATE TABLE `function`  (
  `function_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `imployee_project_id` int UNSIGNED NOT NULL,
  `report` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`function_id`) USING BTREE,
  INDEX `imployee_project_id`(`imployee_project_id` ASC) USING BTREE,
  CONSTRAINT `imployee_project_id` FOREIGN KEY (`imployee_project_id`) REFERENCES `project_employee` (`imployee_project_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of function
-- ----------------------------
INSERT INTO `function` VALUES (8, 9, 'عملکرد1', 'سلام،دریافت کردم.  ', '2023-08-10 01:40:24', '2023-08-10 01:40:24');
INSERT INTO `function` VALUES (11, 9, 'کارهای زیر انجام شد:', '', '2023-08-05 08:45:34', '2023-08-14 05:45:40');
INSERT INTO `function` VALUES (12, 21, 'کارها', 'سلام دریافت شد.', '2023-08-19 00:16:02', '2023-08-20 00:16:17');
INSERT INTO `function` VALUES (13, 22, 'عملکرد 2', NULL, '2023-08-16 00:17:14', '2023-08-19 00:17:22');
INSERT INTO `function` VALUES (14, 23, ' کارهای زیر انجام شده است:\r\n1)\r\n2)\r\n3) ', NULL, '2023-05-24 04:01:15', '2023-05-29 04:01:15');
INSERT INTO `function` VALUES (15, 23, ' کارهای زیر انجام شده است:\r\n1)\r\n2)\r\n3) ', NULL, '2023-08-19 04:04:25', '2023-08-21 04:04:25');

SET FOREIGN_KEY_CHECKS = 1;
