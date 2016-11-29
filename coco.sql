/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : coco

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-11-29 17:35:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `phone_number` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of client
-- ----------------------------
INSERT INTO `client` VALUES ('1', '李三', '1567777222', '2016-11-24 10:22:34');
INSERT INTO `client` VALUES ('2', '李另外', '15612317222', '2016-11-24 10:22:38');
INSERT INTO `client` VALUES ('3', '李三3', '1567777222', null);
INSERT INTO `client` VALUES ('4', '李三3', '1567777222', null);
INSERT INTO `client` VALUES ('5', '李三3', '1567777222', null);
INSERT INTO `client` VALUES ('6', '李三3', '1567777222', null);
INSERT INTO `client` VALUES ('7', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('8', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('9', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('10', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('11', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('12', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('13', '李三4', '1567777111', null);
INSERT INTO `client` VALUES ('14', '李三5', '1567777111', null);
INSERT INTO `client` VALUES ('15', '李三6', '1567777111', null);
INSERT INTO `client` VALUES ('16', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('17', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('18', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('19', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('20', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('21', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('22', '李三76', '1567777111', null);
INSERT INTO `client` VALUES ('23', '李三76', '1567777111', null);

-- ----------------------------
-- Table structure for wechat_public_number
-- ----------------------------
DROP TABLE IF EXISTS `wechat_public_number`;
CREATE TABLE `wechat_public_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wechat_public_number
-- ----------------------------
INSERT INTO `wechat_public_number` VALUES ('1', '12', '123', '123', '2016-11-29 17:10:09', null);
