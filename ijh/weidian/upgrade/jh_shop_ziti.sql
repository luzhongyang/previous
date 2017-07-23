/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.10_3306
Source Server Version : 50169
Source Host           : 192.168.1.10:3306
Source Database       : weidian_weizx_cn

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2016-12-03 16:01:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_shop_ziti
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_ziti`;
CREATE TABLE `jh_shop_ziti` (
  `addr_id` int(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '自提点名称便于买家理解和管理',
  `province_id` mediumint(8) DEFAULT NULL COMMENT '省份ID',
  `city_id` mediumint(8) DEFAULT NULL,
  `area_id` mediumint(8) DEFAULT NULL,
  `address_detail` varchar(150) DEFAULT NULL COMMENT '自提点的具体地址',
  `phone` char(15) DEFAULT NULL COMMENT '联系电话，便于买家联系',
  `fuwu_stime` char(5) DEFAULT NULL COMMENT '接待时间开始',
  `fuwu_ltime` char(5) DEFAULT NULL COMMENT '接待时间结束',
  `photo1` varchar(150) DEFAULT NULL COMMENT '自提点照片1',
  `photo2` varchar(150) DEFAULT '' COMMENT '自提点照片2',
  `photo3` varchar(150) DEFAULT '' COMMENT '自提点照片3',
  `photo4` varchar(150) DEFAULT '' COMMENT '自提点照片4',
  `description` varchar(255) DEFAULT NULL COMMENT '可以描述自提点的活动或相关备注信息（最多200个字）',
  `is_store` tinyint(1) DEFAULT NULL COMMENT '同时作为线下门店接待',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除标识，0否，1已删除',
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上门自提自提地点设置';
