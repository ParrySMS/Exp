/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-02-23 23:21:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ma_submit
-- ----------------------------
DROP TABLE IF EXISTS `ma_submit`;
CREATE TABLE `ma_submit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `time` datetime DEFAULT NULL,
  `submit_content` varchar(255) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  `result` tinyint(4) NOT NULL COMMENT '答题结果',
  `visible` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_submit
-- ----------------------------
INSERT INTO `ma_submit` VALUES ('1', '2', '2', '2019-02-16 19:13:18', 'A', '1', '0', '1');
INSERT INTO `ma_submit` VALUES ('2', '2', '3', '2019-02-16 19:13:18', 'A', '1', '0', '1');
INSERT INTO `ma_submit` VALUES ('3', '3', '12', '2019-02-23 18:12:50', 'A', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('4', '3', '33', '2019-02-23 18:12:50', 'D', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('5', '3', '41', '2019-02-23 18:12:55', 'B', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('6', '3', '33', '2019-02-23 18:12:55', 'D', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('7', '3', '43', '2019-02-23 18:13:34', 'D', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('8', '3', '31', '2019-02-23 18:13:34', 'B', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('9', '3', '18', '2019-02-23 18:13:53', 'D', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('10', '3', '12', '2019-02-23 18:13:53', 'A', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('11', '3', '22', '2019-02-23 18:14:25', 'D', '2', '0', '1');
INSERT INTO `ma_submit` VALUES ('12', '3', '4', '2019-02-23 18:14:25', 'A', '2', '0', '1');
