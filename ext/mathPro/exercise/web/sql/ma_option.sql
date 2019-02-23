/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-02-23 23:20:47
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
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_option
-- ----------------------------
INSERT INTO `ma_option` VALUES ('1', 'A', '1', '1', '1');
INSERT INTO `ma_option` VALUES ('2', 'B', '2', '1', '1');
INSERT INTO `ma_option` VALUES ('3', 'C', '3', '1', '1');
INSERT INTO `ma_option` VALUES ('4', 'D', '4', '1', '1');
INSERT INTO `ma_option` VALUES ('5', 'A', '21', '2', '1');
INSERT INTO `ma_option` VALUES ('6', 'B', '64', '2', '1');
INSERT INTO `ma_option` VALUES ('7', 'C', '7', '2', '1');
INSERT INTO `ma_option` VALUES ('8', 'D', '57', '2', '1');
INSERT INTO `ma_option` VALUES ('9', 'A', '21', '3', '1');
INSERT INTO `ma_option` VALUES ('10', 'B', '65', '3', '1');
INSERT INTO `ma_option` VALUES ('11', 'C', '87', '3', '1');
INSERT INTO `ma_option` VALUES ('12', 'D', '2', '3', '1');
INSERT INTO `ma_option` VALUES ('13', 'A', '6', '4', '1');
INSERT INTO `ma_option` VALUES ('14', 'B', '76', '4', '1');
INSERT INTO `ma_option` VALUES ('15', 'C', '21', '4', '1');
INSERT INTO `ma_option` VALUES ('16', 'D', '44', '4', '1');
INSERT INTO `ma_option` VALUES ('17', 'A', '4', '5', '1');
INSERT INTO `ma_option` VALUES ('18', 'B', '0', '5', '1');
INSERT INTO `ma_option` VALUES ('19', 'C', '2', '5', '1');
INSERT INTO `ma_option` VALUES ('20', 'D', '3', '5', '1');
INSERT INTO `ma_option` VALUES ('21', 'A', '461', '6', '1');
INSERT INTO `ma_option` VALUES ('22', 'B', '451', '6', '1');
INSERT INTO `ma_option` VALUES ('23', 'C', '456', '6', '1');
INSERT INTO `ma_option` VALUES ('24', 'D', '459', '6', '1');
INSERT INTO `ma_option` VALUES ('25', 'A', '4481', '7', '1');
INSERT INTO `ma_option` VALUES ('26', 'B', '4480', '7', '1');
INSERT INTO `ma_option` VALUES ('27', 'C', '4478', '7', '1');
INSERT INTO `ma_option` VALUES ('28', 'D', '4485', '7', '1');
INSERT INTO `ma_option` VALUES ('29', 'A', '-2', '8', '1');
INSERT INTO `ma_option` VALUES ('30', 'B', '-3', '8', '1');
INSERT INTO `ma_option` VALUES ('31', 'C', '7', '8', '1');
INSERT INTO `ma_option` VALUES ('32', 'D', '2', '8', '1');
INSERT INTO `ma_option` VALUES ('33', 'A', '15', '9', '1');
INSERT INTO `ma_option` VALUES ('34', 'B', '13', '9', '1');
INSERT INTO `ma_option` VALUES ('35', 'C', '19', '9', '1');
INSERT INTO `ma_option` VALUES ('36', 'D', '18', '9', '1');
INSERT INTO `ma_option` VALUES ('37', 'A', '5', '10', '1');
INSERT INTO `ma_option` VALUES ('38', 'B', '-5', '10', '1');
INSERT INTO `ma_option` VALUES ('39', 'C', '2', '10', '1');
INSERT INTO `ma_option` VALUES ('40', 'D', '50', '10', '1');
INSERT INTO `ma_option` VALUES ('41', 'A', '9', '11', '1');
INSERT INTO `ma_option` VALUES ('42', 'B', '6', '11', '1');
INSERT INTO `ma_option` VALUES ('43', 'C', '5', '11', '1');
INSERT INTO `ma_option` VALUES ('44', 'D', '8', '11', '1');
INSERT INTO `ma_option` VALUES ('45', 'A', '131', '12', '1');
INSERT INTO `ma_option` VALUES ('46', 'B', '132', '12', '1');
INSERT INTO `ma_option` VALUES ('47', 'C', '130', '12', '1');
INSERT INTO `ma_option` VALUES ('48', 'D', '135', '12', '1');
INSERT INTO `ma_option` VALUES ('49', 'A', '-3', '13', '1');
INSERT INTO `ma_option` VALUES ('50', 'B', '-4', '13', '1');
INSERT INTO `ma_option` VALUES ('51', 'C', '58', '13', '1');
INSERT INTO `ma_option` VALUES ('52', 'D', '-5', '13', '1');
INSERT INTO `ma_option` VALUES ('53', 'A', '42', '14', '1');
INSERT INTO `ma_option` VALUES ('54', 'B', '-2', '14', '1');
INSERT INTO `ma_option` VALUES ('55', 'C', '-1', '14', '1');
INSERT INTO `ma_option` VALUES ('56', 'D', '2', '14', '1');
INSERT INTO `ma_option` VALUES ('57', 'A', '85', '15', '1');
INSERT INTO `ma_option` VALUES ('58', 'B', '86', '15', '1');
INSERT INTO `ma_option` VALUES ('59', 'C', '88', '15', '1');
INSERT INTO `ma_option` VALUES ('60', 'D', '84', '15', '1');
INSERT INTO `ma_option` VALUES ('61', 'A', '3', '16', '1');
INSERT INTO `ma_option` VALUES ('62', 'B', '5', '16', '1');
INSERT INTO `ma_option` VALUES ('63', 'C', '2', '16', '1');
INSERT INTO `ma_option` VALUES ('64', 'D', '45', '16', '1');
INSERT INTO `ma_option` VALUES ('65', 'A', '2971', '17', '1');
INSERT INTO `ma_option` VALUES ('66', 'B', '2977', '17', '1');
INSERT INTO `ma_option` VALUES ('67', 'C', '2975', '17', '1');
INSERT INTO `ma_option` VALUES ('68', 'D', '2974', '17', '1');
INSERT INTO `ma_option` VALUES ('69', 'A', '2959', '18', '1');
INSERT INTO `ma_option` VALUES ('70', 'B', '2967', '18', '1');
INSERT INTO `ma_option` VALUES ('71', 'C', '2960', '18', '1');
INSERT INTO `ma_option` VALUES ('72', 'D', '2964', '18', '1');
INSERT INTO `ma_option` VALUES ('73', 'A', '199', '19', '1');
INSERT INTO `ma_option` VALUES ('74', 'B', '202', '19', '1');
INSERT INTO `ma_option` VALUES ('75', 'C', '198', '19', '1');
INSERT INTO `ma_option` VALUES ('76', 'D', '200', '19', '1');
INSERT INTO `ma_option` VALUES ('77', 'A', '92', '20', '1');
INSERT INTO `ma_option` VALUES ('78', 'B', '94', '20', '1');
INSERT INTO `ma_option` VALUES ('79', 'C', '90', '20', '1');
INSERT INTO `ma_option` VALUES ('80', 'D', '95', '20', '1');
INSERT INTO `ma_option` VALUES ('81', 'A', '1093', '21', '1');
INSERT INTO `ma_option` VALUES ('82', 'B', '1087', '21', '1');
INSERT INTO `ma_option` VALUES ('83', 'C', '1090', '21', '1');
INSERT INTO `ma_option` VALUES ('84', 'D', '1088', '21', '1');
INSERT INTO `ma_option` VALUES ('85', 'A', '58', '22', '1');
INSERT INTO `ma_option` VALUES ('86', 'B', '55', '22', '1');
INSERT INTO `ma_option` VALUES ('87', 'C', '51', '22', '1');
INSERT INTO `ma_option` VALUES ('88', 'D', '54', '22', '1');
INSERT INTO `ma_option` VALUES ('89', 'A', '8', '23', '1');
INSERT INTO `ma_option` VALUES ('90', 'B', '7', '23', '1');
INSERT INTO `ma_option` VALUES ('91', 'C', '10', '23', '1');
INSERT INTO `ma_option` VALUES ('92', 'D', '13', '23', '1');
INSERT INTO `ma_option` VALUES ('93', 'A', '-13', '24', '1');
INSERT INTO `ma_option` VALUES ('94', 'B', '-14', '24', '1');
INSERT INTO `ma_option` VALUES ('95', 'C', '-11', '24', '1');
INSERT INTO `ma_option` VALUES ('96', 'D', '-15', '24', '1');
INSERT INTO `ma_option` VALUES ('97', 'A', '78', '25', '1');
INSERT INTO `ma_option` VALUES ('98', 'B', '76', '25', '1');
INSERT INTO `ma_option` VALUES ('99', 'C', '73', '25', '1');
INSERT INTO `ma_option` VALUES ('100', 'D', '81', '25', '1');
INSERT INTO `ma_option` VALUES ('101', 'A', '45', '26', '1');
INSERT INTO `ma_option` VALUES ('102', 'B', '41', '26', '1');
INSERT INTO `ma_option` VALUES ('103', 'C', '44', '26', '1');
INSERT INTO `ma_option` VALUES ('104', 'D', '48', '26', '1');
INSERT INTO `ma_option` VALUES ('105', 'A', '-68', '27', '1');
INSERT INTO `ma_option` VALUES ('106', 'B', '-67', '27', '1');
INSERT INTO `ma_option` VALUES ('107', 'C', '-64', '27', '1');
INSERT INTO `ma_option` VALUES ('108', 'D', '-70', '27', '1');
INSERT INTO `ma_option` VALUES ('109', 'A', '81', '28', '1');
INSERT INTO `ma_option` VALUES ('110', 'B', '78', '28', '1');
INSERT INTO `ma_option` VALUES ('111', 'C', '76', '28', '1');
INSERT INTO `ma_option` VALUES ('112', 'D', '79', '28', '1');
INSERT INTO `ma_option` VALUES ('113', 'A', '105', '29', '1');
INSERT INTO `ma_option` VALUES ('114', 'B', '104', '29', '1');
INSERT INTO `ma_option` VALUES ('115', 'C', '102', '29', '1');
INSERT INTO `ma_option` VALUES ('116', 'D', '100', '29', '1');
INSERT INTO `ma_option` VALUES ('117', 'A', '-3', '30', '1');
INSERT INTO `ma_option` VALUES ('118', 'B', '-2', '30', '1');
INSERT INTO `ma_option` VALUES ('119', 'C', '42', '30', '1');
INSERT INTO `ma_option` VALUES ('120', 'D', '4', '30', '1');
INSERT INTO `ma_option` VALUES ('121', 'A', '118', '31', '1');
INSERT INTO `ma_option` VALUES ('122', 'B', '115', '31', '1');
INSERT INTO `ma_option` VALUES ('123', 'C', '113', '31', '1');
INSERT INTO `ma_option` VALUES ('124', 'D', '120', '31', '1');
INSERT INTO `ma_option` VALUES ('125', 'A', '91', '32', '1');
INSERT INTO `ma_option` VALUES ('126', 'B', '96', '32', '1');
INSERT INTO `ma_option` VALUES ('127', 'C', '89', '32', '1');
INSERT INTO `ma_option` VALUES ('128', 'D', '94', '32', '1');
INSERT INTO `ma_option` VALUES ('129', 'A', '24', '33', '1');
INSERT INTO `ma_option` VALUES ('130', 'B', '17', '33', '1');
INSERT INTO `ma_option` VALUES ('131', 'C', '26', '33', '1');
INSERT INTO `ma_option` VALUES ('132', 'D', '21', '33', '1');
INSERT INTO `ma_option` VALUES ('133', 'A', '6', '34', '1');
INSERT INTO `ma_option` VALUES ('134', 'B', '3', '34', '1');
INSERT INTO `ma_option` VALUES ('135', 'C', '-4', '34', '1');
INSERT INTO `ma_option` VALUES ('136', 'D', '1', '34', '1');
INSERT INTO `ma_option` VALUES ('137', 'A', '1', '35', '1');
INSERT INTO `ma_option` VALUES ('138', 'B', '5', '35', '1');
INSERT INTO `ma_option` VALUES ('139', 'C', '-4', '35', '1');
INSERT INTO `ma_option` VALUES ('140', 'D', '-3', '35', '1');
INSERT INTO `ma_option` VALUES ('141', 'A', '20', '36', '1');
INSERT INTO `ma_option` VALUES ('142', 'B', '16', '36', '1');
INSERT INTO `ma_option` VALUES ('143', 'C', '19', '36', '1');
INSERT INTO `ma_option` VALUES ('144', 'D', '11', '36', '1');
INSERT INTO `ma_option` VALUES ('145', 'A', '68', '37', '1');
INSERT INTO `ma_option` VALUES ('146', 'B', '64', '37', '1');
INSERT INTO `ma_option` VALUES ('147', 'C', '61', '37', '1');
INSERT INTO `ma_option` VALUES ('148', 'D', '65', '37', '1');
INSERT INTO `ma_option` VALUES ('149', 'A', '18', '38', '1');
INSERT INTO `ma_option` VALUES ('150', 'B', '13', '38', '1');
INSERT INTO `ma_option` VALUES ('151', 'C', '22', '38', '1');
INSERT INTO `ma_option` VALUES ('152', 'D', '20', '38', '1');
INSERT INTO `ma_option` VALUES ('153', 'A', '36', '39', '1');
INSERT INTO `ma_option` VALUES ('154', 'B', '42', '39', '1');
INSERT INTO `ma_option` VALUES ('155', 'C', '38', '39', '1');
INSERT INTO `ma_option` VALUES ('156', 'D', '40', '39', '1');
INSERT INTO `ma_option` VALUES ('157', 'A', '8', '40', '1');
INSERT INTO `ma_option` VALUES ('158', 'B', '9', '40', '1');
INSERT INTO `ma_option` VALUES ('159', 'C', '13', '40', '1');
INSERT INTO `ma_option` VALUES ('160', 'D', '18', '40', '1');
INSERT INTO `ma_option` VALUES ('161', 'A', '-3', '41', '1');
INSERT INTO `ma_option` VALUES ('162', 'B', '5', '41', '1');
INSERT INTO `ma_option` VALUES ('163', 'C', '-5', '41', '1');
INSERT INTO `ma_option` VALUES ('164', 'D', '5', '41', '1');
INSERT INTO `ma_option` VALUES ('165', 'A', '2142', '42', '1');
INSERT INTO `ma_option` VALUES ('166', 'B', '2144', '42', '1');
INSERT INTO `ma_option` VALUES ('167', 'C', '2139', '42', '1');
INSERT INTO `ma_option` VALUES ('168', 'D', '2143', '42', '1');
INSERT INTO `ma_option` VALUES ('169', 'A', '4481', '43', '1');
INSERT INTO `ma_option` VALUES ('170', 'B', '4483', '43', '1');
INSERT INTO `ma_option` VALUES ('171', 'C', '4487', '43', '1');
INSERT INTO `ma_option` VALUES ('172', 'D', '4484', '43', '1');
INSERT INTO `ma_option` VALUES ('173', 'A', '153', '44', '1');
INSERT INTO `ma_option` VALUES ('174', 'B', '151', '44', '1');
INSERT INTO `ma_option` VALUES ('175', 'C', '150', '44', '1');
INSERT INTO `ma_option` VALUES ('176', 'D', '155', '44', '1');
INSERT INTO `ma_option` VALUES ('177', 'A', '111', '45', '1');
INSERT INTO `ma_option` VALUES ('178', 'B', '113', '45', '1');
INSERT INTO `ma_option` VALUES ('179', 'C', '110', '45', '1');
INSERT INTO `ma_option` VALUES ('180', 'D', '109', '45', '1');
INSERT INTO `ma_option` VALUES ('181', 'A', '1538', '46', '1');
INSERT INTO `ma_option` VALUES ('182', 'B', '1536', '46', '1');
INSERT INTO `ma_option` VALUES ('183', 'C', '1540', '46', '1');
INSERT INTO `ma_option` VALUES ('184', 'D', '1537', '46', '1');
INSERT INTO `ma_option` VALUES ('185', 'A', '49', '47', '1');
INSERT INTO `ma_option` VALUES ('186', 'B', '53', '47', '1');
INSERT INTO `ma_option` VALUES ('187', 'C', '58', '47', '1');
INSERT INTO `ma_option` VALUES ('188', 'D', '57', '47', '1');
INSERT INTO `ma_option` VALUES ('189', 'A', '-5', '48', '1');
INSERT INTO `ma_option` VALUES ('190', 'B', '-24', '48', '1');
INSERT INTO `ma_option` VALUES ('191', 'C', '-3', '48', '1');
INSERT INTO `ma_option` VALUES ('192', 'D', '-4', '48', '1');
INSERT INTO `ma_option` VALUES ('193', 'A', '132', '49', '1');
INSERT INTO `ma_option` VALUES ('194', 'B', '130', '49', '1');
INSERT INTO `ma_option` VALUES ('195', 'C', '136', '49', '1');
INSERT INTO `ma_option` VALUES ('196', 'D', '134', '49', '1');
INSERT INTO `ma_option` VALUES ('197', 'A', '3647', '50', '1');
INSERT INTO `ma_option` VALUES ('198', 'B', '3650', '50', '1');
INSERT INTO `ma_option` VALUES ('199', 'C', '3652', '50', '1');
INSERT INTO `ma_option` VALUES ('200', 'D', '3655', '50', '1');
INSERT INTO `ma_option` VALUES ('201', 'A', '6141', '51', '1');
INSERT INTO `ma_option` VALUES ('202', 'B', '6136', '51', '1');
INSERT INTO `ma_option` VALUES ('203', 'C', '6143', '51', '1');
INSERT INTO `ma_option` VALUES ('204', 'D', '6138', '51', '1');
INSERT INTO `ma_option` VALUES ('205', 'A', '-61', '52', '1');
INSERT INTO `ma_option` VALUES ('206', 'B', '-62', '52', '1');
INSERT INTO `ma_option` VALUES ('207', 'C', '-57', '52', '1');
INSERT INTO `ma_option` VALUES ('208', 'D', '-59', '52', '1');
INSERT INTO `ma_option` VALUES ('209', 'A', '1874', '53', '1');
INSERT INTO `ma_option` VALUES ('210', 'B', '1873', '53', '1');
INSERT INTO `ma_option` VALUES ('211', 'C', '1870', '53', '1');
INSERT INTO `ma_option` VALUES ('212', 'D', '1868', '53', '1');
INSERT INTO `ma_option` VALUES ('213', 'A', '1', '54', '1');
INSERT INTO `ma_option` VALUES ('214', 'B', '7', '54', '1');
INSERT INTO `ma_option` VALUES ('215', 'C', '-1', '54', '1');
INSERT INTO `ma_option` VALUES ('216', 'D', '4', '54', '1');
INSERT INTO `ma_option` VALUES ('217', 'A', '18', '55', '1');
INSERT INTO `ma_option` VALUES ('218', 'B', '17', '55', '1');
INSERT INTO `ma_option` VALUES ('219', 'C', '20', '55', '1');
INSERT INTO `ma_option` VALUES ('220', 'D', '21', '55', '1');
INSERT INTO `ma_option` VALUES ('221', 'A', '15', '56', '1');
INSERT INTO `ma_option` VALUES ('222', 'B', '9', '56', '1');
INSERT INTO `ma_option` VALUES ('223', 'C', '11', '56', '1');
INSERT INTO `ma_option` VALUES ('224', 'D', '10', '56', '1');
