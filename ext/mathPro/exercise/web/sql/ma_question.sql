/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-02-23 23:20:55
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
  `visible` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_question
-- ----------------------------
INSERT INTO `ma_question` VALUES ('1', '1+2=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('2', '3*4=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('3', '5*5=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('4', '3*4+2=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('5', '100-100=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('6', '24*19=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('7', '70*64=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('8', '2%33=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('9', '18%56=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('10', '54-4=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('11', '46%40=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('12', '48+83=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('13', '65-7=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('14', '97-55=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('15', '22*4=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('16', '73-28=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('17', '85*35=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('18', '78*38=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('19', '5*40=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('20', '62+30=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('21', '64*17=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('22', '77-23=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('23', '68%15=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('24', '32-46=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('25', '78%81=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('26', '44%67=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('27', '3-70=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('28', '19*4=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('29', '95+7=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('30', '85-43=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('31', '29+86=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('32', '8+86=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('33', '21%68=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('34', '57%4=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('35', '1%67=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('36', '16%69=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('37', '9+56=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('38', '70%26=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('39', '65-25=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('40', '77%32=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('41', '88-83=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('42', '31*69=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('43', '59*76=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('44', '81+72=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('45', '49+62=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('46', '64*24=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('47', '53%94=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('48', '29-53=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('49', '38+96=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('50', '73*50=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('51', '66*93=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('52', '28-85=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('53', '34*55=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('54', '33%29=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('55', '94-73=?', '1', '1', '1', '1');
INSERT INTO `ma_question` VALUES ('56', '89%39=?', '1', '1', '1', '1');
