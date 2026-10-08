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

 Date: 21/08/2023 20:41:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`  (
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int UNSIGNED NOT NULL,
  `date` date NULL DEFAULT NULL,
  `time` time NULL DEFAULT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`log_id`) USING BTREE,
  INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  CONSTRAINT `log_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 117 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES (2, 111122, '2023-08-16', '03:43:31', 'ورود به سایت');
INSERT INTO `log` VALUES (3, 111122, '2023-08-16', '03:58:18', 'خروج از سایت');
INSERT INTO `log` VALUES (4, 111122, '2023-08-16', '03:58:20', 'ورود به سایت');
INSERT INTO `log` VALUES (5, 111122, '2023-08-16', '04:08:55', 'خروج از سایت');
INSERT INTO `log` VALUES (6, 125125, '2023-08-16', '04:10:07', 'ورود به سایت');
INSERT INTO `log` VALUES (7, 125125, '2023-08-16', '04:22:11', 'خروج از سایت');
INSERT INTO `log` VALUES (8, 111122, '2023-08-16', '04:22:18', 'ورود به سایت');
INSERT INTO `log` VALUES (9, 111122, '2023-08-16', '04:23:59', 'خروج از سایت');
INSERT INTO `log` VALUES (10, 124124, '2023-08-16', '04:24:28', 'ورود به سایت');
INSERT INTO `log` VALUES (11, 124124, '2023-08-16', '05:05:09', 'خروج از سایت');
INSERT INTO `log` VALUES (12, 111122, '2023-08-16', '05:05:11', 'ورود به سایت');
INSERT INTO `log` VALUES (13, 111122, '2023-08-16', '05:32:12', 'ورود به سایت');
INSERT INTO `log` VALUES (14, 111122, '2023-08-16', '05:38:33', 'ورود به سایت');
INSERT INTO `log` VALUES (15, 111122, '2023-08-16', '16:50:54', 'خروج از سایت');
INSERT INTO `log` VALUES (16, 111122, '2023-08-16', '16:50:57', 'ورود به سایت');
INSERT INTO `log` VALUES (17, 111122, '2023-08-16', '18:20:14', 'خروج از سایت');
INSERT INTO `log` VALUES (18, 111122, '2023-08-16', '18:20:16', 'ورود به سایت');
INSERT INTO `log` VALUES (19, 111122, '2023-08-16', '18:20:32', 'خروج از سایت');
INSERT INTO `log` VALUES (20, 124124, '2023-08-16', '18:23:12', 'ورود به سایت');
INSERT INTO `log` VALUES (21, 124124, '2023-08-16', '18:46:14', 'خروج از سایت');
INSERT INTO `log` VALUES (22, 111122, '2023-08-16', '18:46:17', 'ورود به سایت');
INSERT INTO `log` VALUES (23, 111122, '2023-08-16', '20:43:37', 'خروج از سایت');
INSERT INTO `log` VALUES (24, 111122, '2023-08-16', '20:44:49', 'ورود به سایت');
INSERT INTO `log` VALUES (25, 111122, '2023-08-17', '06:32:30', 'خروج از سایت');
INSERT INTO `log` VALUES (26, 111122, '2023-08-17', '06:32:32', 'ورود به سایت');
INSERT INTO `log` VALUES (27, 111122, '2023-08-17', '12:36:38', 'خروج از سایت');
INSERT INTO `log` VALUES (28, 111122, '2023-08-17', '12:41:44', 'ورود به سایت');
INSERT INTO `log` VALUES (29, 111122, '2023-08-17', '13:04:44', 'خروج از سایت');
INSERT INTO `log` VALUES (30, 111122, '2023-08-17', '13:04:46', 'ورود به سایت');
INSERT INTO `log` VALUES (31, 111122, '2023-08-17', '13:07:39', 'خروج از سایت');
INSERT INTO `log` VALUES (32, 111122, '2023-08-17', '13:07:41', 'ورود به سایت');
INSERT INTO `log` VALUES (33, 111122, '2023-08-17', '13:15:23', 'خروج از سایت');
INSERT INTO `log` VALUES (34, 111122, '2023-08-17', '13:15:25', 'ورود به سایت');
INSERT INTO `log` VALUES (35, 111122, '2023-08-17', '13:26:12', 'خروج از سایت');
INSERT INTO `log` VALUES (36, 111122, '2023-08-17', '13:26:13', 'ورود به سایت');
INSERT INTO `log` VALUES (37, 111122, '2023-08-17', '13:27:06', 'ورود به سایت');
INSERT INTO `log` VALUES (38, 111122, '2023-08-17', '13:38:20', 'خروج از سایت');
INSERT INTO `log` VALUES (39, 111122, '2023-08-17', '13:38:23', 'ورود به سایت');
INSERT INTO `log` VALUES (40, 111122, '2023-08-17', '13:38:31', 'خروج از سایت');
INSERT INTO `log` VALUES (41, 111122, '2023-08-17', '13:38:42', 'ورود به سایت');
INSERT INTO `log` VALUES (42, 111122, '2023-08-17', '14:10:14', 'ورود به سایت');
INSERT INTO `log` VALUES (43, 111122, '2023-08-17', '19:15:20', 'خروج از سایت');
INSERT INTO `log` VALUES (44, 111122, '2023-08-17', '19:15:22', 'ورود به سایت');
INSERT INTO `log` VALUES (45, 111122, '2023-08-17', '22:26:51', 'خروج از سایت');
INSERT INTO `log` VALUES (46, 111122, '2023-08-17', '22:26:53', 'ورود به سایت');
INSERT INTO `log` VALUES (47, 111122, '2023-08-17', '22:28:34', 'خروج از سایت');
INSERT INTO `log` VALUES (48, 111122, '2023-08-17', '22:28:36', 'ورود به سایت');
INSERT INTO `log` VALUES (49, 111122, '2023-08-17', '22:41:59', 'خروج از سایت');
INSERT INTO `log` VALUES (50, 111122, '2023-08-17', '22:42:01', 'ورود به سایت');
INSERT INTO `log` VALUES (51, 111122, '2023-08-18', '00:22:51', 'ورود به سایت');
INSERT INTO `log` VALUES (52, 111122, '2023-08-18', '00:27:10', 'خروج از سایت');
INSERT INTO `log` VALUES (53, 111122, '2023-08-18', '00:27:12', 'ورود به سایت');
INSERT INTO `log` VALUES (54, 111122, '2023-08-18', '00:29:30', 'خروج از سایت');
INSERT INTO `log` VALUES (55, 111122, '2023-08-18', '00:29:32', 'ورود به سایت');
INSERT INTO `log` VALUES (56, 111122, '2023-08-18', '00:30:59', 'خروج از سایت');
INSERT INTO `log` VALUES (57, 111122, '2023-08-18', '00:31:26', 'ورود به سایت');
INSERT INTO `log` VALUES (58, 111122, '2023-08-18', '00:40:13', 'ورود به سایت');
INSERT INTO `log` VALUES (59, 111122, '2023-08-18', '00:43:22', 'خروج از سایت');
INSERT INTO `log` VALUES (60, 111122, '2023-08-18', '00:43:24', 'ورود به سایت');
INSERT INTO `log` VALUES (61, 111122, '2023-08-18', '00:43:37', 'ورود به سایت');
INSERT INTO `log` VALUES (62, 111122, '2023-08-18', '05:10:51', 'خروج از سایت');
INSERT INTO `log` VALUES (63, 111122, '2023-08-18', '05:10:53', 'ورود به سایت');
INSERT INTO `log` VALUES (64, 111122, '2023-08-18', '05:12:11', 'خروج از سایت');
INSERT INTO `log` VALUES (65, 111122, '2023-08-18', '05:12:15', 'ورود به سایت');
INSERT INTO `log` VALUES (66, 111122, '2023-08-18', '05:15:37', 'ورود به سایت');
INSERT INTO `log` VALUES (67, 111122, '2023-08-18', '12:42:40', 'خروج از سایت');
INSERT INTO `log` VALUES (68, 111122, '2023-08-18', '12:42:43', 'ورود به سایت');
INSERT INTO `log` VALUES (69, 111122, '2023-08-18', '12:46:29', 'خروج از سایت');
INSERT INTO `log` VALUES (70, 111122, '2023-08-18', '12:46:59', 'ورود به سایت');
INSERT INTO `log` VALUES (71, 111122, '2023-08-18', '12:51:14', 'خروج از سایت');
INSERT INTO `log` VALUES (72, 111122, '2023-08-18', '12:51:16', 'ورود به سایت');
INSERT INTO `log` VALUES (73, 111122, '2023-08-18', '13:12:25', 'ورود به سایت');
INSERT INTO `log` VALUES (74, 111122, '2023-08-18', '13:12:35', 'ورود به سایت');
INSERT INTO `log` VALUES (75, 111122, '2023-08-18', '13:51:07', 'خروج از سایت');
INSERT INTO `log` VALUES (76, 111122, '2023-08-18', '13:52:03', 'ورود به سایت');
INSERT INTO `log` VALUES (77, 111122, '2023-08-18', '15:52:23', 'خروج از سایت');
INSERT INTO `log` VALUES (78, 111122, '2023-08-18', '15:52:24', 'ورود به سایت');
INSERT INTO `log` VALUES (79, 111122, '2023-08-18', '16:33:55', 'خروج از سایت');
INSERT INTO `log` VALUES (80, 111122, '2023-08-18', '16:33:57', 'ورود به سایت');
INSERT INTO `log` VALUES (81, 111122, '2023-08-18', '16:34:03', 'خروج از سایت');
INSERT INTO `log` VALUES (82, 111122, '2023-08-18', '16:34:06', 'ورود به سایت');
INSERT INTO `log` VALUES (83, 111122, '2023-08-18', '16:34:12', 'خروج از سایت');
INSERT INTO `log` VALUES (84, 111122, '2023-08-20', '07:56:58', 'ورود به سایت');
INSERT INTO `log` VALUES (85, 111122, '2023-08-20', '07:59:19', 'ورود به سایت');
INSERT INTO `log` VALUES (86, 111122, '2023-08-20', '14:10:24', 'ورود به سایت');
INSERT INTO `log` VALUES (87, 111122, '2023-08-20', '23:22:52', 'خروج از سایت');
INSERT INTO `log` VALUES (88, 77, '2023-08-20', '23:23:08', 'ورود به سایت');
INSERT INTO `log` VALUES (89, 77, '2023-08-20', '23:25:49', 'خروج از سایت');
INSERT INTO `log` VALUES (90, 77, '2023-08-20', '23:26:07', 'ورود به سایت');
INSERT INTO `log` VALUES (91, 77, '2023-08-21', '15:42:46', 'خروج از سایت');
INSERT INTO `log` VALUES (92, 111122, '2023-08-21', '15:42:58', 'ورود به سایت');
INSERT INTO `log` VALUES (93, 111122, '2023-08-21', '16:52:13', 'خروج از سایت');
INSERT INTO `log` VALUES (96, 111122, '2023-08-21', '16:58:54', 'ورود به سایت');
INSERT INTO `log` VALUES (97, 111122, '2023-08-21', '16:58:59', 'خروج از سایت');
INSERT INTO `log` VALUES (98, 111122, '2023-08-21', '16:59:47', 'ورود به سایت');
INSERT INTO `log` VALUES (99, 77, '2023-08-21', '17:27:38', 'ورود به سایت');
INSERT INTO `log` VALUES (100, 77, '2023-08-21', '17:28:11', 'خروج از سایت');
INSERT INTO `log` VALUES (101, 502, '2023-08-21', '17:28:29', 'ورود به سایت');
INSERT INTO `log` VALUES (102, 502, '2023-08-21', '17:28:47', 'خروج از سایت');
INSERT INTO `log` VALUES (103, 502, '2023-08-21', '17:29:19', 'ورود به سایت');
INSERT INTO `log` VALUES (104, 502, '2023-08-21', '17:30:40', 'خروج از سایت');
INSERT INTO `log` VALUES (105, 111122, '2023-08-21', '17:31:12', 'ورود به سایت');
INSERT INTO `log` VALUES (106, 111122, '2023-08-21', '17:33:34', 'ورود به سایت');
INSERT INTO `log` VALUES (107, 111122, '2023-08-21', '17:40:36', 'خروج از سایت');
INSERT INTO `log` VALUES (108, 111122, '2023-08-21', '17:40:38', 'ورود به سایت');
INSERT INTO `log` VALUES (109, 111122, '2023-08-21', '18:24:56', 'خروج از سایت');
INSERT INTO `log` VALUES (110, 111122, '2023-08-21', '18:24:57', 'ورود به سایت');
INSERT INTO `log` VALUES (111, 111122, '2023-08-21', '18:26:08', 'خروج از سایت');
INSERT INTO `log` VALUES (112, 111122, '2023-08-21', '18:26:10', 'ورود به سایت');
INSERT INTO `log` VALUES (113, 111122, '2023-08-21', '18:28:09', 'خروج از سایت');
INSERT INTO `log` VALUES (114, 111122, '2023-08-21', '18:28:11', 'ورود به سایت');
INSERT INTO `log` VALUES (115, 111122, '2023-08-21', '18:59:40', 'خروج از سایت');
INSERT INTO `log` VALUES (116, 111122, '2023-08-21', '18:59:42', 'ورود به سایت');

SET FOREIGN_KEY_CHECKS = 1;
