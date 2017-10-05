/*
Navicat MySQL Data Transfer

Source Server         : php_dev
Source Server Version : 50557
Source Host           : 192.168.199.101:3306
Source Database       : mypass

Target Server Type    : MYSQL
Target Server Version : 50557
File Encoding         : 65001

Date: 2017-10-05 13:32:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pass
-- ----------------------------
DROP TABLE IF EXISTS `pass`;
CREATE TABLE `pass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `remark` text NOT NULL,
  `create_at` int(10) NOT NULL,
  `uuid` varchar(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `update_at` int(10) NOT NULL,
  PRIMARY KEY (`id`,`uuid`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(55) NOT NULL,
  `key` text NOT NULL,
  `create_at` int(10) NOT NULL,
  `update_at` int(10) NOT NULL,
  `phone` varchar(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
