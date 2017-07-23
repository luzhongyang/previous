/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.10_3306
Source Server Version : 50169
Source Host           : 192.168.1.10:3306
Source Database       : weidian_weizx_cn

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2016-12-15 10:17:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_weidian_product
-- ----------------------------
DROP TABLE IF EXISTS `jh_weidian_product`;
CREATE TABLE `jh_weidian_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `cate_id` int(10) DEFAULT '0',
  `type` enum('pintuan','default') DEFAULT NULL,
  `title` varchar(64) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `price` decimal(8,2) DEFAULT '0.00' COMMENT '产品价',
  `wei_price` decimal(8,2) DEFAULT '0.00' COMMENT '商城价/团购价',
  `price_level_1` decimal(8,2) DEFAULT '0.00' COMMENT '一级分销返佣',
  `price_level_2` decimal(8,2) DEFAULT '0.00' COMMENT '二级分销返佣',
  `price_level_3` decimal(8,2) DEFAULT '0.00' COMMENT '三级分销返佣',
  `intro` text,
  `sales` int(10) unsigned DEFAULT '0' COMMENT '销量',
  `stock` int(10) unsigned DEFAULT '0' COMMENT '库存',
  `is_fan` tinyint(1) DEFAULT '0' COMMENT '是否返佣',
  `is_onsale` tinyint(1) DEFAULT '0' COMMENT '是否上架',
  `ship_fee` decimal(8,2) DEFAULT '0.00' COMMENT '配送费用,默认  0,   (仅自提不出现)',
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `is_fenxiao` tinyint(1) DEFAULT '0' COMMENT '是否是分销商品：0不是，1是',
  `price_type` tinyint(1) DEFAULT '0' COMMENT '价格类型：0金额，1比例',
  `delivery_type` tinyint(1) DEFAULT '0' COMMENT '0： 统一邮费   1：运费模板',
  `delivery_price` decimal(10,2) DEFAULT '0.00' COMMENT '统一邮费',
  `delivery_tpl_id` smallint(6) DEFAULT '0' COMMENT '运费模板ID',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
