/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : login
Target Host     : localhost:3306
Target Database : login
Date: 2014-10-04 00:19:35
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `uname` varchar(14) character set utf8 collate utf8_bin NOT NULL default '',
  `upwd` varchar(32) NOT NULL default '',
  `uemail` varchar(50) NOT NULL default '',
  `active` tinyint(4) default '0',
  `count` tinyint(4) default '0',
  `activekey` varchar(32) NOT NULL default '' COMMENT '注册时生成的key，用于激活验证',
  `regdate` int(11) default NULL COMMENT '注册时间',
  `lockurl` tinyint(4) default '0' COMMENT '超过激活时间m没有激活，就把该值置为1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uemail` (`uemail`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('45', '盗墓\\\\笔记', '9ff506ec13dabadfdfff34fe7f96c3f9', '4723230817@qq.com', '1', '0', '6a778280a9bf980366ad158565840b93', '1412322556', '0');
INSERT INTO `user` VALUES ('53', '盗墓\\\'笔记', '9ff506ec13dabadfdfff34fe7f96c3f9', '4723213087@qq.com', '1', '0', '19c787a60b260763b6630ef0402cbe32', '1412327107', '0');
INSERT INTO `user` VALUES ('54', 'Let\\\'s Git123', '9ff506ec13dabadfdfff34fe7f96c3f9', '47232233087@qq.com', '1', '0', '4b7e4e5378747e86b6e55470411ccee2', '1412327614', '0');
INSERT INTO `user` VALUES ('55', 'Let\\\'s Git', '9ff506ec13dabadfdfff34fe7f96c3f9', '472323087@qq.com', '1', '0', 'f542f98100aab2e01bcf4f253f88c107', '1412346140', '0');
