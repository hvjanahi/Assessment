/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : omdb

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-11-18 04:16:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tborders
-- ----------------------------
DROP TABLE IF EXISTS `tborders`;
CREATE TABLE `tborders` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `OrderRef` varchar(30) NOT NULL,
  `CustomerCode` varchar(30) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `OrderType` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tborders
-- ----------------------------
INSERT INTO `tborders` VALUES ('1', '111111', '222222', '2016-11-17 21:14:27', '32767');
INSERT INTO `tborders` VALUES ('2', 'OrderRef content', 'CustomerCode content', '2016-11-17 21:12:44', '1');
INSERT INTO `tborders` VALUES ('3', '111111', '222222', '2016-11-17 21:15:34', '32767');
INSERT INTO `tborders` VALUES ('4', 'OrderRef content', 'CustomerCode content', '2016-11-17 21:12:53', '1');
