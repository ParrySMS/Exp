/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : math

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-05-30 16:53:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ma_refer
-- ----------------------------
DROP TABLE IF EXISTS `ma_refer`;
CREATE TABLE `ma_refer` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `visible` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ma_refer
-- ----------------------------
INSERT INTO `ma_refer` VALUES ('1', 'Level 1 ', 'Don’t worry! You need to study more on basic operation rule of addition and subtraction. There are some sources that can help you out:\r \rAddition and Subtraction for fractions have common denominator : \rhttps://www.youtube.com/watch?v=5juto2ze8Lg\rAddition and Subtraction for fractions have different denominator : \rhttps://www.youtube.com/watch?v=N-Y0Kvcnw8g\rLest denominator \rhttps://www.youtube.com/watch?v=pZEmFSP3Z0I\r \rFractions with like terms \rhttps://www.k5learning.com/worksheets/math/grade-5-adding-fractions-like-denominators-a.pdf\rhttps://www.k5learning.com/worksheets/math/grade-5-subtracting-fractions-like-denominators-a.pdf\rhttps://www.k5learning.com/worksheets/math/grade-5-adding-unlike-fractions-b.pdf\rhttps://www.k5learning.com/worksheets/math/grade-5-subtracting-fractions-from-mixed-numbers-b.pdf\r', '1');
INSERT INTO `ma_refer` VALUES ('2', 'Level 2', 'Looking good! You have showed an adequate understanding on this topic, you may further work on middle level practice, there are some sources you can practice:\r \rFractions with unlike terms:\rhttps://www.k5learning.com/worksheets/math/grade-5-adding-unlike-fractions-a.pdf\rhttps://www.k5learning.com/worksheets/math/grade-5-subtracting-fractions-unlike-denominators2-12-a.pdf\r \rFractions with mixed number:\rhttps://www.k5learning.com/worksheets/math/grade-5-adding-fractions-mixed-numbers-unlike-a.pdf\rhttps://www.k5learning.com/free-math-worksheets/fifth-grade-5/fractions-addition-subtraction/subtracting-fractions-unlike-denominators\r', '1');
INSERT INTO `ma_refer` VALUES ('3', 'Level 3 ', '\r\nCongratulation! You have shown a great understanding on this topic, and there are some challenging complex questions you can work on:\r\n\r\nhttps://www.k5learning.com/worksheets/math/grade-5-word-problems-adding-subtracting-fractions-a.pdf\r\n\r\nhttps://www.k5learning.com/worksheets/math/grade-5-word-problems-adding-subtracting-fractions-b.pdf\r\n', '1');
INSERT INTO `ma_refer` VALUES ('4', 'Level 4', null, null);
