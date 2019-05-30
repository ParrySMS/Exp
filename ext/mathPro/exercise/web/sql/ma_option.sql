/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-05-30 16:53:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ma_option
-- ----------------------------
DROP TABLE IF EXISTS `ma_option`;
CREATE TABLE `ma_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `qid` int(11) NOT NULL,
  `visible` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_option
-- ----------------------------
INSERT INTO `ma_option` VALUES ('1', 'A', '/quesimg/q1-A.png', '1', '1');
INSERT INTO `ma_option` VALUES ('2', 'B', '/quesimg/q1-B.png', '1', '1');
INSERT INTO `ma_option` VALUES ('3', 'C', '/quesimg/q1-C.png', '1', '1');
INSERT INTO `ma_option` VALUES ('4', 'D', '/quesimg/q1-D.png', '1', '1');
INSERT INTO `ma_option` VALUES ('5', 'A', '/quesimg/q2-A.png', '2', '1');
INSERT INTO `ma_option` VALUES ('6', 'B', '/quesimg/q2-B.png', '2', '1');
INSERT INTO `ma_option` VALUES ('7', 'C', '/quesimg/q2-C.png', '2', '1');
INSERT INTO `ma_option` VALUES ('8', 'D', '/quesimg/q2-D.png', '2', '1');
INSERT INTO `ma_option` VALUES ('9', 'A', '/quesimg/q3-A.png', '3', '1');
INSERT INTO `ma_option` VALUES ('10', 'B', '/quesimg/q3-B.png', '3', '1');
INSERT INTO `ma_option` VALUES ('11', 'C', '/quesimg/q3-C.png', '3', '1');
INSERT INTO `ma_option` VALUES ('12', 'D', '/quesimg/q3-D.png', '3', '1');
INSERT INTO `ma_option` VALUES ('13', 'A', '/quesimg/q4-A.png', '4', '1');
INSERT INTO `ma_option` VALUES ('14', 'B', '/quesimg/q4-B.png', '4', '1');
INSERT INTO `ma_option` VALUES ('15', 'C', '/quesimg/q4-C.png', '4', '1');
INSERT INTO `ma_option` VALUES ('16', 'D', '/quesimg/q4-D.png', '4', '1');
INSERT INTO `ma_option` VALUES ('17', 'A', '/quesimg/q5-A.png', '5', '1');
INSERT INTO `ma_option` VALUES ('18', 'B', '/quesimg/q5-B.png', '5', '1');
INSERT INTO `ma_option` VALUES ('19', 'C', '/quesimg/q5-C.png', '5', '1');
INSERT INTO `ma_option` VALUES ('20', 'D', '/quesimg/q5-D.png', '5', '1');
INSERT INTO `ma_option` VALUES ('21', 'A', '/quesimg/q6-A.png', '6', '1');
INSERT INTO `ma_option` VALUES ('22', 'B', '/quesimg/q6-B.png', '6', '1');
INSERT INTO `ma_option` VALUES ('23', 'C', '/quesimg/q6-C.png', '6', '1');
INSERT INTO `ma_option` VALUES ('24', 'D', '/quesimg/q6-D.png', '6', '1');
INSERT INTO `ma_option` VALUES ('25', 'A', '/quesimg/q7-A.png', '7', '1');
INSERT INTO `ma_option` VALUES ('26', 'B', '/quesimg/q7-B.png', '7', '1');
INSERT INTO `ma_option` VALUES ('27', 'C', '/quesimg/q7-C.png', '7', '1');
INSERT INTO `ma_option` VALUES ('28', 'D', '/quesimg/q7-D.png', '7', '1');
INSERT INTO `ma_option` VALUES ('29', 'A', '/quesimg/q8-A.png', '8', '1');
INSERT INTO `ma_option` VALUES ('30', 'B', '/quesimg/q8-B.png', '8', '1');
INSERT INTO `ma_option` VALUES ('31', 'C', '/quesimg/q8-C.png', '8', '1');
INSERT INTO `ma_option` VALUES ('32', 'D', '/quesimg/q8-D.png', '8', '1');
INSERT INTO `ma_option` VALUES ('33', 'A', '/quesimg/q9-A.png', '9', '1');
INSERT INTO `ma_option` VALUES ('34', 'B', '/quesimg/q9-B.png', '9', '1');
INSERT INTO `ma_option` VALUES ('35', 'C', '/quesimg/q9-C.png', '9', '1');
INSERT INTO `ma_option` VALUES ('36', 'D', '/quesimg/q9-D.png', '9', '1');
INSERT INTO `ma_option` VALUES ('37', 'A', '/quesimg/q10-A.png', '10', '1');
INSERT INTO `ma_option` VALUES ('38', 'B', '/quesimg/q10-B.png', '10', '1');
INSERT INTO `ma_option` VALUES ('39', 'C', '/quesimg/q10-C.png', '10', '1');
INSERT INTO `ma_option` VALUES ('40', 'D', '/quesimg/q10-D.png', '10', '1');
INSERT INTO `ma_option` VALUES ('41', 'A', '/quesimg/q11-A.png', '11', '1');
INSERT INTO `ma_option` VALUES ('42', 'B', '/quesimg/q11-B.png', '11', '1');
INSERT INTO `ma_option` VALUES ('43', 'C', '/quesimg/q11-C.png', '11', '1');
INSERT INTO `ma_option` VALUES ('44', 'D', '/quesimg/q11-D.png', '11', '1');
INSERT INTO `ma_option` VALUES ('45', 'A', '/quesimg/q12-A.png', '12', '1');
INSERT INTO `ma_option` VALUES ('46', 'B', '/quesimg/q12-B.png', '12', '1');
INSERT INTO `ma_option` VALUES ('47', 'C', '/quesimg/q12-C.png', '12', '1');
INSERT INTO `ma_option` VALUES ('48', 'D', '/quesimg/q12-D.png', '12', '1');
