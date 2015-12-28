/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : asmoria

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2015-12-28 10:36:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `acl_roles`
-- ----------------------------
DROP TABLE IF EXISTS `acl_roles`;
CREATE TABLE `acl_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(54) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acl_roles
-- ----------------------------
INSERT INTO `acl_roles` VALUES ('1', 'ADMIN');
INSERT INTO `acl_roles` VALUES ('2', 'USER');

-- ----------------------------
-- Table structure for `acl_users_role`
-- ----------------------------
DROP TABLE IF EXISTS `acl_users_role`;
CREATE TABLE `acl_users_role` (
  `usr_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acl_users_role
-- ----------------------------
INSERT INTO `acl_users_role` VALUES ('10', '2');

-- ----------------------------
-- Table structure for `profiles`
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of profiles
-- ----------------------------
INSERT INTO `profiles` VALUES ('10', 'test@mail.com', '$2y$11$NTQ2NTQ2Ri4jQCYhKCYlYeB1mejxc7z2Y/zFvWIVgFSxmpfqre2eK');
-- pass qwerty --