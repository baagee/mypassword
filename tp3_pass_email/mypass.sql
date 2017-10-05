/*
Navicat MySQL Data Transfer

Source Server         : 139.129.45.234我的服务器
Source Server Version : 50163
Source Host           : 139.129.45.234:3306
Source Database       : mypass

Target Server Type    : MYSQL
Target Server Version : 50163
File Encoding         : 65001

Date: 2017-10-05 13:30:46
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
  `create_time` int(11) NOT NULL,
  `uuid` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
