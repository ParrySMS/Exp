/*
Navicat MySQL Data Transfer

Source Server         : lizhiNew
Source Server Version : 50628
Source Host           : 55c5f3742f54d.gz.cdb.myqcloud.com:13125
Source Database       : yihui

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2018-10-30 00:29:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ms_company
-- ----------------------------
DROP TABLE IF EXISTS `ms_company`;
CREATE TABLE `ms_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `iop_timestamp` int(11) NOT NULL,
  `ipo_date` datetime(6) DEFAULT NULL,
  `exchange` varchar(255) NOT NULL,
  `issued_shares` int(11) unsigned zerofill NOT NULL,
  `validity` int(11) NOT NULL DEFAULT '1' COMMENT '有效性 默认 0无效 1有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ms_company
-- ----------------------------
INSERT INTO `ms_company` VALUES ('1', '003742', '星际中华集团', '0', '2018-10-22 09:00:00.000000', '星际交易所', '00000050000', '1');
INSERT INTO `ms_company` VALUES ('2', '418721', '宇宙空间', '0', '2015-06-16 00:00:00.000000', '星际交易所', '00001000000', '1');
INSERT INTO `ms_company` VALUES ('3', '245820', '蓝色地球', '0', '2014-06-14 00:00:00.000000', '地球交易所', '00000230000', '1');
INSERT INTO `ms_company` VALUES ('4', '004587', '火星人', '0', '2017-02-17 00:00:00.000000', '火星交易所', '00000030000', '1');
