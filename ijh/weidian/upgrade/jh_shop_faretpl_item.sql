/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.10_3306
Source Server Version : 50169
Source Host           : 192.168.1.10:3306
Source Database       : weidian_weizx_cn

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2016-12-03 15:31:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_shop_faretpl_item
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_faretpl_item`;
CREATE TABLE `jh_shop_faretpl_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tpl_id` mediumint(8) DEFAULT NULL COMMENT '运费模板ID',
  `shop_id` mediumint(8) DEFAULT NULL COMMENT '商户ID',
  `pei_area` varchar(255) DEFAULT NULL COMMENT '指定的配送区域',
  `first` smallint(6) DEFAULT '0' COMMENT '首件（个）',
  `first_price` decimal(10,2) DEFAULT '0.00' COMMENT '首件运费（元）	',
  `renew` smallint(6) DEFAULT '0' COMMENT '续件（个）',
  `renew_price` decimal(10,2) DEFAULT '0.00' COMMENT '续件运费（元）	',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除标识，0否，1已删除',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='运费模板配送区域配置列表';

-- ----------------------------
-- Records of jh_shop_faretpl_item
-- ----------------------------
