/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-05-30 16:53:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ma_question
-- ----------------------------
DROP TABLE IF EXISTS `ma_question`;
CREATE TABLE `ma_question` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(500) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `diff` int(11) DEFAULT NULL COMMENT '题目难度',
  `refer_id` int(11) DEFAULT NULL,
  `unit` int(11) unsigned DEFAULT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_question
-- ----------------------------
INSERT INTO `ma_question` VALUES ('1', '/quesimg/q1.png', '1', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('2', '/quesimg/q2.png', '1', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('3', '/quesimg/q3.png', '1', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('4', '/quesimg/q4.png', '1', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('5', '/quesimg/q5.png', '1', '2', '2', '1', '1');
INSERT INTO `ma_question` VALUES ('6', '/quesimg/q6.png', '1', '2', '2', '1', '1');
INSERT INTO `ma_question` VALUES ('7', '/quesimg/q7.png', '1', '2', '2', '1', '1');
INSERT INTO `ma_question` VALUES ('8', '/quesimg/q8.png', '1', '2', '2', '1', '1');
INSERT INTO `ma_question` VALUES ('9', '/quesimg/q9.png', '1', '3', '3', '1', '1');
INSERT INTO `ma_question` VALUES ('10', '/quesimg/q10.png', '1', '3', '3', '1', '1');
INSERT INTO `ma_question` VALUES ('11', '/quesimg/q11.png', '1', '3', '3', '1', '1');
INSERT INTO `ma_question` VALUES ('12', '/quesimg/q12.png', '1', '3', '3', '1', '1');
