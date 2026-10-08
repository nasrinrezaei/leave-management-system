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

 Date: 21/08/2023 20:41:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `project_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_id` tinyint UNSIGNED NOT NULL,
  `project_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `project_name_no_space` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` enum('registered','doing','done','canceled') CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'registered',
  `create_date` date NOT NULL,
  `deadline` date NOT NULL,
  PRIMARY KEY (`project_id`) USING BTREE,
  INDEX `department_id`(`department_id` ASC) USING BTREE,
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES (1, 7, 'پروژه 7 ', 'پروژه7', 'canceled', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (2, 7, 'پروژه 4', 'پروژه4', 'done', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (3, 24, 'پروژه 15', 'پروژه15', 'doing', '2023-07-30', '2023-08-16');
INSERT INTO `project` VALUES (4, 7, 'پروژه 5', 'پروژه5', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (5, 25, 'منابع ', 'منابع', 'doing', '2023-07-23', '2023-08-01');
INSERT INTO `project` VALUES (6, 7, 'منابع ', 'منابع', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (7, 7, 'تاسیس', 'تاسیس', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (8, 17, 'پروژه 3', 'پروژه3', 'doing', '2023-07-30', '2023-09-07');
INSERT INTO `project` VALUES (9, 7, 'منابع انسانی', 'منابعانساني', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (10, 24, 'پروژه 21', 'پروژه21', 'doing', '2023-07-18', '2023-09-20');
INSERT INTO `project` VALUES (12, 7, 'خدمات', 'خدمات', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (13, 17, 'پروژه 1', 'پروژه1', 'canceled', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (14, 7, 'خدمات', 'خدمات', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (15, 7, 'فروش', 'فروش', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (16, 7, 'تاسیس', 'تاسیس', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (17, 7, 'س ر', 'سر', 'doing', '2023-07-30', '2023-07-30');
INSERT INTO `project` VALUES (18, 24, 'پروژه 20', 'پروژه 20', 'registered', '2023-08-08', '2023-08-28');
INSERT INTO `project` VALUES (19, 17, 'پروژه 2', 'پروژه2', 'done', '2023-08-12', '2023-08-07');
INSERT INTO `project` VALUES (20, 7, 'ی ک', 'یک', 'registered', '2023-08-12', '2023-08-12');
INSERT INTO `project` VALUES (21, 7, 'کای', 'کای', 'registered', '2023-08-12', '2023-08-12');
INSERT INTO `project` VALUES (22, 7, 'تاسیس', 'تاسیس', 'registered', '2023-08-12', '2023-08-12');
INSERT INTO `project` VALUES (23, 7, 'کوهی', 'کوهی', 'registered', '2023-08-12', '2023-08-12');
INSERT INTO `project` VALUES (24, 17, 'پروژه 9', 'پروژه9', 'registered', '2023-08-20', '2023-08-20');

SET FOREIGN_KEY_CHECKS = 1;
