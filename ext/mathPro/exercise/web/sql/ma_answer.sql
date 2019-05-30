/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-05-30 16:53:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ma_answer
-- ----------------------------
DROP TABLE IF EXISTS `ma_answer`;
CREATE TABLE `ma_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(50) DEFAULT NULL,
  `qid` int(11) NOT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_answer
-- ----------------------------
INSERT INTO `ma_answer` VALUES ('1', 'C', '1', '1');
INSERT INTO `ma_answer` VALUES ('2', 'A', '2', '1');
INSERT INTO `ma_answer` VALUES ('3', 'D', '3', '1');
INSERT INTO `ma_answer` VALUES ('4', 'C', '4', '1');
INSERT INTO `ma_answer` VALUES ('5', 'B', '5', '1');
INSERT INTO `ma_answer` VALUES ('6', 'D', '6', '1');
INSERT INTO `ma_answer` VALUES ('7', 'B', '7', '1');
INSERT INTO `ma_answer` VALUES ('8', 'A', '8', '1');
INSERT INTO `ma_answer` VALUES ('9', 'C', '9', '1');
INSERT INTO `ma_answer` VALUES ('10', 'B', '10', '1');
INSERT INTO `ma_answer` VALUES ('11', 'A', '11', '1');
INSERT INTO `ma_answer` VALUES ('12', 'C', '12', '1');
