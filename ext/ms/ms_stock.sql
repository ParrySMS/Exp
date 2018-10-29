/*
Navicat MySQL Data Transfer

Source Server         : lizhiNew
Source Server Version : 50628
Source Host           : 55c5f3742f54d.gz.cdb.myqcloud.com:13125
Source Database       : yihui

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2018-10-30 00:30:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ms_stock
-- ----------------------------
DROP TABLE IF EXISTS `ms_stock`;
CREATE TABLE `ms_stock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `now_100times` int(11) DEFAULT NULL,
  `open_100times` int(11) DEFAULT NULL,
  `high_100times` int(11) DEFAULT NULL,
  `low_100times` int(11) DEFAULT NULL,
  `close_100times` int(11) DEFAULT NULL,
  `vol` int(11) unsigned NOT NULL,
  `benefit_100times` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `timestamp` int(11) NOT NULL,
  `validity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`c_id`),
  CONSTRAINT `cid` FOREIGN KEY (`c_id`) REFERENCES `ms_company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ms_stock
-- ----------------------------
INSERT INTO `ms_stock` VALUES ('1', '1', 'Star1', '001546', '138', '125', '146', '132', '138', '600000', '13', '2018-10-28 00:00:00', '1540710000', '1');
INSERT INTO `ms_stock` VALUES ('2', '2', 'Star2', '001547', '568', '614', '620', '568', '614', '23100', '23', '2018-10-29 00:00:00', '1540816286', '1');
INSERT INTO `ms_stock` VALUES ('3', '3', 'Uni3', '048737', '568', '614', '620', '568', '614', '13100', '23', '2018-10-29 00:00:00', '1540816286', '1');
INSERT INTO `ms_stock` VALUES ('6', '4', 'Uni4', '057624', '1034', '998', '1106', '926', '1034', '46575', '23', '2018-10-29 00:00:00', '1540816286', '1');
