/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-05-30 16:53:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ma_quiz
-- ----------------------------
DROP TABLE IF EXISTS `ma_quiz`;
CREATE TABLE `ma_quiz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_finish` tinyint(4) DEFAULT NULL,
  `final_diff` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_quiz
-- ----------------------------
INSERT INTO `ma_quiz` VALUES ('1', '2', null, '0', '1', '2019-02-16 19:01:17', null, '1');
INSERT INTO `ma_quiz` VALUES ('2', '3', null, '1', '1', '2019-02-23 14:52:51', '2019-02-23 23:25:49', '1');
INSERT INTO `ma_quiz` VALUES ('3', '3', null, '1', '1', '2019-02-23 23:35:42', '2019-02-24 15:27:50', '1');
INSERT INTO `ma_quiz` VALUES ('4', '1', null, '1', '1', '2019-03-16 16:17:43', '2019-03-16 16:20:10', '1');
INSERT INTO `ma_quiz` VALUES ('5', '1', null, '1', '1', '2019-03-16 16:32:23', '2019-03-16 16:32:29', '1');
INSERT INTO `ma_quiz` VALUES ('6', '1', null, '1', '1', '2019-03-16 16:57:40', '2019-05-30 14:26:22', '1');
INSERT INTO `ma_quiz` VALUES ('7', '1', null, '0', '2', '2019-05-30 14:26:59', null, '0');
INSERT INTO `ma_quiz` VALUES ('8', '1', null, '1', '2', '2019-05-30 14:45:23', '2019-05-30 15:29:02', '1');
INSERT INTO `ma_quiz` VALUES ('9', '1', null, '1', '4', '2019-05-30 16:38:52', '2019-05-30 16:44:13', '1');
INSERT INTO `ma_quiz` VALUES ('10', '1', null, '1', '2', '2019-05-30 16:44:23', '2019-05-30 16:45:48', '1');
INSERT INTO `ma_quiz` VALUES ('11', '1', null, '1', '2', '2019-05-30 16:48:01', '2019-05-30 16:48:37', '1');
