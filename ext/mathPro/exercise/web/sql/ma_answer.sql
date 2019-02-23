/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-02-23 23:20:38
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_answer
-- ----------------------------
INSERT INTO `ma_answer` VALUES ('1', 'A', '1', '1');
INSERT INTO `ma_answer` VALUES ('2', 'B', '2', '1');
INSERT INTO `ma_answer` VALUES ('3', 'C', '3', '1');
INSERT INTO `ma_answer` VALUES ('4', 'A', '4', '1');
INSERT INTO `ma_answer` VALUES ('5', 'B', '5', '1');
INSERT INTO `ma_answer` VALUES ('6', 'C', '6', '1');
INSERT INTO `ma_answer` VALUES ('7', 'B', '7', '1');
INSERT INTO `ma_answer` VALUES ('8', 'D', '8', '1');
INSERT INTO `ma_answer` VALUES ('9', 'D', '9', '1');
INSERT INTO `ma_answer` VALUES ('10', 'D', '10', '1');
INSERT INTO `ma_answer` VALUES ('11', 'B', '11', '1');
INSERT INTO `ma_answer` VALUES ('12', 'A', '12', '1');
INSERT INTO `ma_answer` VALUES ('13', 'C', '13', '1');
INSERT INTO `ma_answer` VALUES ('14', 'A', '14', '1');
INSERT INTO `ma_answer` VALUES ('15', 'C', '15', '1');
INSERT INTO `ma_answer` VALUES ('16', 'D', '16', '1');
INSERT INTO `ma_answer` VALUES ('17', 'C', '17', '1');
INSERT INTO `ma_answer` VALUES ('18', 'D', '18', '1');
INSERT INTO `ma_answer` VALUES ('19', 'D', '19', '1');
INSERT INTO `ma_answer` VALUES ('20', 'A', '20', '1');
INSERT INTO `ma_answer` VALUES ('21', 'D', '21', '1');
INSERT INTO `ma_answer` VALUES ('22', 'D', '22', '1');
INSERT INTO `ma_answer` VALUES ('23', 'A', '23', '1');
INSERT INTO `ma_answer` VALUES ('24', 'B', '24', '1');
INSERT INTO `ma_answer` VALUES ('25', 'A', '25', '1');
INSERT INTO `ma_answer` VALUES ('26', 'C', '26', '1');
INSERT INTO `ma_answer` VALUES ('27', 'B', '27', '1');
INSERT INTO `ma_answer` VALUES ('28', 'C', '28', '1');
INSERT INTO `ma_answer` VALUES ('29', 'C', '29', '1');
INSERT INTO `ma_answer` VALUES ('30', 'C', '30', '1');
INSERT INTO `ma_answer` VALUES ('31', 'B', '31', '1');
INSERT INTO `ma_answer` VALUES ('32', 'D', '32', '1');
INSERT INTO `ma_answer` VALUES ('33', 'D', '33', '1');
INSERT INTO `ma_answer` VALUES ('34', 'D', '34', '1');
INSERT INTO `ma_answer` VALUES ('35', 'A', '35', '1');
INSERT INTO `ma_answer` VALUES ('36', 'B', '36', '1');
INSERT INTO `ma_answer` VALUES ('37', 'D', '37', '1');
INSERT INTO `ma_answer` VALUES ('38', 'A', '38', '1');
INSERT INTO `ma_answer` VALUES ('39', 'D', '39', '1');
INSERT INTO `ma_answer` VALUES ('40', 'C', '40', '1');
INSERT INTO `ma_answer` VALUES ('41', 'D', '41', '1');
INSERT INTO `ma_answer` VALUES ('42', 'C', '42', '1');
INSERT INTO `ma_answer` VALUES ('43', 'D', '43', '1');
INSERT INTO `ma_answer` VALUES ('44', 'A', '44', '1');
INSERT INTO `ma_answer` VALUES ('45', 'A', '45', '1');
INSERT INTO `ma_answer` VALUES ('46', 'B', '46', '1');
INSERT INTO `ma_answer` VALUES ('47', 'B', '47', '1');
INSERT INTO `ma_answer` VALUES ('48', 'B', '48', '1');
INSERT INTO `ma_answer` VALUES ('49', 'D', '49', '1');
INSERT INTO `ma_answer` VALUES ('50', 'B', '50', '1');
INSERT INTO `ma_answer` VALUES ('51', 'D', '51', '1');
INSERT INTO `ma_answer` VALUES ('52', 'C', '52', '1');
INSERT INTO `ma_answer` VALUES ('53', 'C', '53', '1');
INSERT INTO `ma_answer` VALUES ('54', 'D', '54', '1');
INSERT INTO `ma_answer` VALUES ('55', 'D', '55', '1');
INSERT INTO `ma_answer` VALUES ('56', 'C', '56', '1');
