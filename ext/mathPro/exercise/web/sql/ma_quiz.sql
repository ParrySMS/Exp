/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-02-23 23:21:03
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_quiz
-- ----------------------------
INSERT INTO `ma_quiz` VALUES ('1', '2', null, '0', '1', '2019-02-16 19:01:17', null, '1');
INSERT INTO `ma_quiz` VALUES ('2', '3', null, '0', '1', '2019-02-23 14:52:51', '2019-02-23 18:14:25', '1');
