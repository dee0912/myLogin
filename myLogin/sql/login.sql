/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : login
Target Host     : localhost:3306
Target Database : login
Date: 2014-10-01 01:29:24
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `uname` varchar(14) NOT NULL default '',
  `upwd` varchar(32) NOT NULL default '',
  `uemail` varchar(50) NOT NULL default '',
  `active` tinyint(4) default '0',
  `count` tinyint(4) default '0',
  `activekey` varchar(32) NOT NULL default '' COMMENT '注册时生成的key，用于激活验证',
  `regdate` datetime default NULL COMMENT '注册时间',
  `lockurl` tinyint(4) default '0' COMMENT '超过激活时间m没有激活，就把该值置为1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uemail` (`uemail`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'dee', '11', '472323088@qq.com', '0', '0', '', null, '0');
INSERT INTO `user` VALUES ('2', '小dee', '', 'dihuang.lucky@gmail.com', '0', '0', '', null, '0');
