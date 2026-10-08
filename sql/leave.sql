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

 Date: 21/08/2023 20:40:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for leave
-- ----------------------------
DROP TABLE IF EXISTS `leave`;
CREATE TABLE `leave`  (
  `leave_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int UNSIGNED NOT NULL,
  `leave_type` enum('without_salary','illness','entitlent') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'illness',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `status` enum('disapproval','approval','manager2_approval','not-define') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `total_hours` int NOT NULL,
  PRIMARY KEY (`leave_id`) USING BTREE,
  INDEX `department_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `leave_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 124 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of leave
-- ----------------------------
INSERT INTO `leave` VALUES (77, 100, 'without_salary', '2023-08-11 05:31:50', '2023-08-22 05:31:50', '', 'not-define', 264);
INSERT INTO `leave` VALUES (78, 444, 'without_salary', '2023-08-11 05:31:58', '2023-08-22 05:31:58', '', 'disapproval', 264);
INSERT INTO `leave` VALUES (79, 444, 'without_salary', '2023-08-11 05:32:07', '2023-08-22 05:32:07', '', 'manager2_approval', 264);
INSERT INTO `leave` VALUES (80, 444, 'without_salary', '2023-08-11 05:32:15', '2023-08-22 05:32:15', '', 'manager2_approval', 264);
INSERT INTO `leave` VALUES (81, 444, 'without_salary', '2023-08-11 05:32:21', '2023-08-22 05:32:21', '', 'not-define', 264);
INSERT INTO `leave` VALUES (82, 444, 'without_salary', '2023-08-11 05:32:47', '2023-08-22 05:32:47', '', 'approval', 264);
INSERT INTO `leave` VALUES (83, 444, 'without_salary', '2023-08-11 05:32:53', '2023-08-22 05:32:53', '', 'approval', 264);
INSERT INTO `leave` VALUES (84, 444, 'without_salary', '2023-08-11 05:33:02', '2023-08-22 05:33:02', '', 'disapproval', 264);
INSERT INTO `leave` VALUES (92, 124124, 'entitlent', '2023-08-16 05:54:36', '2023-08-20 05:54:36', '', '', 96);
INSERT INTO `leave` VALUES (93, 124124, 'entitlent', '2023-08-16 05:58:13', '2023-08-20 05:58:13', '', 'manager2_approval', 96);
INSERT INTO `leave` VALUES (94, 124124, 'illness', '2023-08-16 05:59:04', '2023-08-21 05:59:04', '', 'disapproval', 120);
INSERT INTO `leave` VALUES (95, 124124, 'illness', '2023-08-16 05:59:12', '2023-08-20 05:59:12', '', 'not-define', 96);
INSERT INTO `leave` VALUES (96, 124124, 'illness', '2023-08-16 05:59:12', '2023-08-20 05:59:12', '', 'not-define', 96);
INSERT INTO `leave` VALUES (97, 124124, 'illness', '2023-08-16 05:59:12', '2023-08-20 05:59:12', '', 'not-define', 96);
INSERT INTO `leave` VALUES (98, 124124, 'illness', '2023-08-16 05:59:12', '2023-08-20 05:59:12', '', 'not-define', 96);
INSERT INTO `leave` VALUES (99, 124124, 'illness', '2023-08-21 06:26:33', '2023-08-22 06:26:33', '', 'not-define', 24);
INSERT INTO `leave` VALUES (104, 111122, 'entitlent', '2023-10-24 11:28:01', '2023-10-27 11:28:02', '', 'manager2_approval', 72);
INSERT INTO `leave` VALUES (105, 111122, 'entitlent', '2023-08-15 07:10:25', '2023-08-21 07:10:26', '', 'manager2_approval', 144);
INSERT INTO `leave` VALUES (106, 111122, 'without_salary', '2023-08-20 07:10:50', '2023-08-22 07:10:50', '', 'manager2_approval', 48);
INSERT INTO `leave` VALUES (107, 111122, 'without_salary', '2023-08-17 07:23:43', '2023-08-21 07:23:43', '', 'manager2_approval', 96);
INSERT INTO `leave` VALUES (108, 111122, 'illness', '2023-08-17 07:24:06', '2023-08-17 07:24:06', '', 'manager2_approval', 0);
INSERT INTO `leave` VALUES (109, 111122, 'without_salary', '2023-08-22 07:24:07', '2023-08-23 07:24:07', '', 'manager2_approval', 24);
INSERT INTO `leave` VALUES (110, 111122, 'illness', '2023-08-17 07:27:11', '2023-08-17 07:27:12', '', 'manager2_approval', 0);
INSERT INTO `leave` VALUES (111, 111122, 'illness', '2023-08-17 07:27:13', '2023-08-17 07:27:13', '', 'manager2_approval', 0);
INSERT INTO `leave` VALUES (112, 111122, 'without_salary', '2023-08-21 07:29:23', '2023-08-22 07:29:23', '', 'manager2_approval', 24);
INSERT INTO `leave` VALUES (113, 111122, 'illness', '2023-08-17 07:29:50', '2023-08-17 07:29:50', '', 'manager2_approval', 0);
INSERT INTO `leave` VALUES (116, 111122, 'without_salary', '2023-08-21 07:40:53', '2023-08-22 07:40:53', '', 'manager2_approval', 24);
INSERT INTO `leave` VALUES (117, 111122, 'without_salary', '1402-05-29 07:40:53', '1402-05-30 07:40:53', '', 'manager2_approval', 0);
INSERT INTO `leave` VALUES (118, 111122, 'without_salary', '2023-08-17 07:42:07', '2023-08-20 07:42:07', '', 'manager2_approval', 72);
INSERT INTO `leave` VALUES (119, 111122, 'without_salary', '2023-08-22 07:43:05', '2023-08-29 07:43:05', '', 'manager2_approval', 168);
INSERT INTO `leave` VALUES (120, 111122, 'entitlent', '2023-08-17 07:45:34', '2023-08-18 07:45:34', '', 'manager2_approval', 24);
INSERT INTO `leave` VALUES (121, 111122, 'without_salary', '2023-08-17 07:46:35', '2023-08-18 07:46:35', '', 'manager2_approval', 24);
INSERT INTO `leave` VALUES (122, 111122, 'entitlent', '2023-09-27 00:50:45', '2023-07-28 00:50:45', '', 'manager2_approval', -1440);
INSERT INTO `leave` VALUES (123, 77, 'illness', '2023-08-22 03:14:32', '2023-08-25 03:14:32', 'سلام درخواست مرخصی دارم.', 'not-define', 72);

SET FOREIGN_KEY_CHECKS = 1;
