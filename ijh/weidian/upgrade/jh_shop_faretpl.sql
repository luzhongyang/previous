/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.10_3306
Source Server Version : 50169
Source Host           : 192.168.1.10:3306
Source Database       : weidian_weizx_cn

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2016-12-03 15:31:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_shop_faretpl
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_faretpl`;
CREATE TABLE `jh_shop_faretpl` (
  `tpl_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `title` varchar(100) DEFAULT NULL COMMENT '运费模板名称',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `lasttime` int(10) unsigned DEFAULT '0' COMMENT '模板最后更新时间',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除标识，0否，1已删除',
  PRIMARY KEY (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='运费模板';
