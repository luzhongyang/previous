ALTER TABLE `bao_coupon`
DROP COLUMN `area_id`,
ADD COLUMN `full_money`  int(11) NULL DEFAULT 0 COMMENT '满多少使用' AFTER `title`,
ADD COLUMN `money`  int(11) NULL DEFAULT 0 COMMENT '抵扣多少' AFTER `full_money`,
ADD COLUMN `limit`  int(11) NULL DEFAULT 0 AFTER `money`,
ADD COLUMN `lng`  varchar(15) NULL AFTER `closed`,
ADD COLUMN `lat`  varchar(15) NULL AFTER `lng`;




DROP TABLE IF EXISTS `bao_settlement`;

DROP TABLE IF EXISTS `bao_settlement_shop`;



DROP TABLE IF EXISTS `bao_city`;
CREATE TABLE `bao_city` (
  `city_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `pinyin` varchar(32) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `first_letter` char(1) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;




ALTER TABLE `bao_shop_details`
MODIFY COLUMN `wei_pic`  varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `near`;

DROP TABLE IF EXISTS `bao_weixin_qrcode`;
CREATE TABLE `bao_weixin_qrcode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0',
  `soure_id` smallint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_qrcode_census`;
CREATE TABLE `bao_qrcode_census` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
  `year` smallint(5) DEFAULT '0',
  `month` tinyint(2) DEFAULT '0',
  `day` tinyint(2) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_users_cash`;
CREATE TABLE `bao_users_cash` (
  `cash_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `account` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`cash_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


ALTER TABLE `bao_area`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 AFTER `area_id`;


ALTER TABLE `bao_tuan`
ADD COLUMN `branch_id`  int(11) NULL DEFAULT 0 AFTER `shop_id`,
ADD COLUMN `thumb`  text NULL DEFAULT NULL COMMENT '缩略图' AFTER `photo`,
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 AFTER `area_id`,
ADD COLUMN `tao_num`  tinyint(2) NULL DEFAULT 0 COMMENT '套餐人数' AFTER `sold_num`,
ADD COLUMN `wei_pic`  varchar(256) NULL DEFAULT NULL COMMENT '抢购二维码' AFTER `tao_num`,
ADD COLUMN `is_multi`  tinyint(1) NULL DEFAULT 0 COMMENT '多店可用' AFTER `is_chose`;


DROP TABLE IF EXISTS `bao_shop_branch`;
CREATE TABLE `bao_shop_branch` (
  `branch_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `score` tinyint(3) DEFAULT '0',
  `password`  varchar(32) NULL DEFAULT '',
  `shop_id` int(11) DEFAULT '0',
  `city_id` smallint(5) DEFAULT '0',
  `area_id` smallint(5) DEFAULT '0',
  `business_id` smallint(5) DEFAULT '0',
  `addr` varchar(128) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `telephone` varchar(11) NOT NULL DEFAULT '',
  `business_time` varchar(64) DEFAULT NULL,
  `d1` tinyint(3) DEFAULT '0',
  `d2` tinyint(3) DEFAULT '0',
  `d3` tinyint(3) DEFAULT '0',
  `score_num` int(10) unsigned NOT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


ALTER TABLE `bao_shop`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 AFTER `area_id`;

ALTER TABLE `bao_shop`
ADD COLUMN `ding_num`  int(11) NULL DEFAULT 0 AFTER `orderby`;

ALTER TABLE `bao_shop`
ADD COLUMN `is_ding`  tinyint(1) NULL DEFAULT 0 AFTER `audit`;

ALTER TABLE `bao_goods`
ADD COLUMN `branch_id`  varchar(64) NULL DEFAULT NULL AFTER `shop_id`;

ALTER TABLE `bao_goods`
ADD COLUMN `city_id`  varchar(64) NULL DEFAULT NULL AFTER `shop_id`;

ALTER TABLE `bao_payment_logs`
MODIFY COLUMN `type`  enum('tuan','gold','money','ele','ding','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `user_id`;

ALTER TABLE `bao_shop_money`
MODIFY COLUMN `type`  enum('tuan','ele','ding','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `create_ip`;


ALTER TABLE `bao_shop`
ADD COLUMN `fans_num`  int(11) NULL DEFAULT 0 AFTER `score_num`;

ALTER TABLE `bao_work`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 AFTER `area_id`;

ALTER TABLE `bao_life`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 AFTER `area_id`;


ALTER TABLE `bao_shop_favorites`
ADD COLUMN `closed`  tinyint(1) NULL DEFAULT 0 AFTER `shop_id`;

DROP TABLE IF EXISTS `bao_around`;
CREATE TABLE `bao_around` (
  `around_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1代表常去，2代表我家，3代表公司',
  `name` varchar(128) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`around_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `bao_goods`
ADD COLUMN `wei_pic`  varchar(256) NULL DEFAULT NULL COMMENT '购物二维码' AFTER `photo`;


ALTER TABLE `bao_shop`
ADD COLUMN `is_seat`  tinyint(1) NULL DEFAULT 0 AFTER `city_id`;

ALTER TABLE `bao_shop`
ADD COLUMN `type_id`  char(20) NULL DEFAULT 0 AFTER `city_id`;


ALTER TABLE `bao_shop_dianping`
ADD COLUMN `evaluate`  tinyint(1) NULL DEFAULT 0 COMMENT '1表示好评，2表示中评，3表示差评' AFTER `shop_id`,
ADD COLUMN `branch_id`  int(11) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_coupon`
MODIFY COLUMN `area_id`  smallint(6) NULL DEFAULT 0 AFTER `cate_id`,
ADD COLUMN `city_id`  smallint(6) NULL DEFAULT 0 AFTER `cate_id`,
ADD COLUMN `business_id`  smallint(6) NULL DEFAULT 0 AFTER `area_id`;




DROP TABLE IF EXISTS `bao_tuan_meal`;
CREATE TABLE `bao_tuan_meal` (
  `tuan_id` int(11) unsigned DEFAULT '0' COMMENT '主套餐',
  `id` int(11) unsigned DEFAULT '0' COMMENT '分套餐id',
  `name` varchar(64) DEFAULT NULL COMMENT '套餐名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






/*
Navicat MySQL Data Transfer

Source Server         : baocms
Source Server Version : 50169
Source Host           : 203.195.209.91:3306
Source Database       : baocms

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2015-07-29 14:46:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bao_weidian_details
-- ----------------------------
DROP TABLE IF EXISTS `bao_weidian_details`;
CREATE TABLE `bao_weidian_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weidian_name` varchar(64) NOT NULL,
  `addr` varchar(128) NOT NULL,
  `business_time` varchar(32) NOT NULL,
  `details` text NOT NULL,
  `pic` varchar(64) NOT NULL,
  `logo` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `bao_shop`
DROP COLUMN `is_seat`,
DROP COLUMN `wei_date`,
DROP COLUMN `yuyue_date`,
DROP COLUMN `ranking`,
DROP COLUMN `yuyue_total`,
DROP COLUMN `is_mall`,
MODIFY COLUMN `business_id`  smallint(5) NULL DEFAULT NULL AFTER `type_id`,
CHANGE COLUMN `card_date` `is_card`  tinyint(1) NULL DEFAULT 0 AFTER `addr`,
CHANGE COLUMN `bao_date` `is_bao`  tinyint(1) NULL DEFAULT 0 AFTER `is_card`,
MODIFY COLUMN `score`  tinyint(3) NULL DEFAULT 0 COMMENT '评价' AFTER `is_bao`,
MODIFY COLUMN `orderby`  int(11) NULL DEFAULT 100 COMMENT '越小排序越高' AFTER `d3`,
MODIFY COLUMN `lng`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `orderby`,
MODIFY COLUMN `is_pei`  tinyint(1) NULL DEFAULT 0 COMMENT '是否商家自主配送' AFTER `audit`;


ALTER TABLE `bao_shop`
DROP COLUMN `is_card`,
DROP COLUMN `is_bao`,
MODIFY COLUMN `score`  tinyint(3) NULL DEFAULT 0 COMMENT '评价' AFTER `addr`;


/*
Navicat MySQL Data Transfer

Source Server         : baocms
Source Server Version : 50169
Source Host           : 203.195.209.91:3306
Source Database       : baocms

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2015-07-31 18:43:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bao_weidian_details
-- ----------------------------
DROP TABLE IF EXISTS `bao_weidian_details`;
CREATE TABLE `bao_weidian_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weidian_name` varchar(64) NOT NULL,
  `addr` varchar(128) NOT NULL,
  `business_time` varchar(32) NOT NULL,
  `details` text NOT NULL,
  `pic` varchar(64) NOT NULL,
  `logo` varchar(64) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `lng` varchar(15) NOT NULL,
  `lat` varchar(15) NOT NULL,
  `cate_id` int(10) unsigned NOT NULL,
  `audit` tinyint(1) unsigned NOT NULL,
  `reg_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `area_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bao_weidian_details
-- ----------------------------


ALTER TABLE `bao_community`
ADD COLUMN `city_id`  smallint(5) NULL AFTER `user_id`,
ADD INDEX (`city_id`, `area_id`) ;


ALTER TABLE `bao_ele`
ADD COLUMN `audit`  tinyint(1) UNSIGNED NULL DEFAULT 0 AFTER `distribution`;

ALTER TABLE `bao_ele`
DROP COLUMN `city_id`,
ADD COLUMN `city_id`  smallint(5) NULL AFTER `shop_name`;

ALTER TABLE `bao_users_cash`
MODIFY COLUMN `status`  tinyint(1) NULL DEFAULT 0 COMMENT '0未审核1通过2拒绝' AFTER `addtime`;


ALTER TABLE `bao_tuan_code`
ADD COLUMN `branch_id`  int(11) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_shop`
ADD COLUMN `is_ding`  tinyint(1) NULL DEFAULT 0 COMMENT '针对餐饮行业的订座' AFTER `is_pei`;


DROP TABLE IF EXISTS `bao_shop_ding_setting`;
CREATE TABLE `bao_shop_ding_setting` (
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `mobile` varchar(11) DEFAULT NULL COMMENT '有单了，通知手机号',
  `money` int(11) DEFAULT '0' COMMENT '包厢需要缴纳定金',
  `bao_time` tinyint(3) DEFAULT '0' COMMENT '包厢预定间隔小时',
  `start_time` tinyint(3) DEFAULT '0' COMMENT '开始接客时间',
  `end_time` tinyint(3) DEFAULT '0' COMMENT '打烊时间',
  `is_bao` tinyint(1) DEFAULT '0' COMMENT '1代表包厢有位子',
  `is_ting` tinyint(1) DEFAULT '0' COMMENT '1代表大厅有位置',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_shop_ding_room`;
CREATE TABLE `bao_shop_ding_room` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `intro` varchar(64) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  PRIMARY KEY (`room_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_shop_ding_cate`;
CREATE TABLE `bao_shop_ding_cate` (
  `cate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
  `cate_name` varchar(64) DEFAULT '',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_shop_ding_menu`;
CREATE TABLE `bao_shop_ding_menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(64) DEFAULT '',
  `shop_id` int(11) DEFAULT '0',
  `cate_id` int(11) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  `price` int(11) DEFAULT '0',
  `ding_price` int(11) DEFAULT '0',
  `is_tuijian` tinyint(1) DEFAULT '0' COMMENT '是否推荐',
  `is_new` tinyint(1) DEFAULT '0' COMMENT '是否新品',
  `is_sale` tinyint(1) DEFAULT '0' COMMENT '是否优惠',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `bao_tuan_order`
ADD COLUMN `branch_id`  int(11) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_activity`
ADD COLUMN `tuan_id`  int(11) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_life`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 AFTER `cate_id`;


ALTER TABLE `bao_shop_favorites`
ADD COLUMN `last_news_id`  int 0 AFTER `shop_id`;

ALTER TABLE `bao_shop_favorites`
ADD COLUMN `read_id`  int(11) NULL DEFAULT 0 AFTER `last_news_id`;

ALTER TABLE `bao_user_addr`
ADD COLUMN `city_id`  int(11) NULL DEFAULT 0 AFTER `user_id`;

ALTER TABLE `bao_tuan_order`
ADD COLUMN `is_dianping`  tinyint(1) NULL DEFAULT 0 AFTER `is_mobile`;

ALTER TABLE `bao_coupon`
ADD COLUMN `num`  int NULL DEFAULT 9999999 AFTER `audit`,
ADD COLUMN `limit_num`  tinyint(3) NULL DEFAULT 0 COMMENT '0代表不限制' AFTER `num`;

ALTER TABLE `bao_ad`
ADD COLUMN `city_id`  smallint(5) UNSIGNED NULL DEFAULT 0 AFTER `site_id`;

DROP TABLE IF EXISTS `bao_shop_yuyue`;
CREATE TABLE `bao_shop_yuyue` (
  `yuyue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT '0',
  `shop_id` int(11) unsigned DEFAULT '0',
  `name` varchar(32) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `yuyue_date` date DEFAULT NULL,
  `yuyue_time` varchar(32) DEFAULT NULL,
  `number` smallint(5) unsigned DEFAULT '0',
  `code` varchar(32) DEFAULT NULL,
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  `used` tinyint(1) DEFAULT '0',
  `used_time` int(11) DEFAULT '0',
  `used_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`yuyue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `bao_delivery`;
CREATE TABLE `bao_delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `bao_delivery_order`;
CREATE TABLE `bao_delivery_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL COMMENT '0是商城，1是外卖',
  `type_order_id` int(10) unsigned NOT NULL COMMENT '关联的分类中的订单编号',
  `delivery_id` int(10) unsigned NOT NULL COMMENT '配送员ID',
  `shop_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `shop_name` varchar(64) NOT NULL DEFAULT '',
  `shop_addr` varchar(64) NOT NULL DEFAULT '',
  `shop_mobile` varchar(11) NOT NULL DEFAULT '',
  `user_name` varchar(64) NOT NULL DEFAULT '',
  `user_addr` varchar(64) NOT NULL DEFAULT '',
  `user_mobile` varchar(11) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL COMMENT '0是货到付款，1是已付款，2是配送中，8是已完成。',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;





ALTER TABLE `bao_activity`
MODIFY COLUMN `area_id`  smallint(5) UNSIGNED NULL DEFAULT 0 AFTER `tuan_id`,
ADD COLUMN `city_id`  smallint(5) UNSIGNED NULL DEFAULT 0 AFTER `tuan_id`,
ADD COLUMN `business_id`  smallint(5) UNSIGNED NULL DEFAULT 0 AFTER `area_id`;









DROP TABLE IF EXISTS `bao_ele_dianping`;
CREATE TABLE `bao_ele_dianping` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `speed` tinyint(3) unsigned DEFAULT '0',
  `contents` varchar(1024) DEFAULT NULL,
  `reply` varchar(1024) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `closed` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_ele_dianping_pics`;
CREATE TABLE `bao_ele_dianping_pics` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT '0',
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `dianping_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `bao_tuan_order`
ADD COLUMN `update_time`  int(11) NULL DEFAULT 0 AFTER `create_ip`,
ADD COLUMN `update_ip`  varchar(15) NULL AFTER `update_time`;

-- ----------------------------
-- Table structure for `bao_zhuan`
-- ----------------------------
DROP TABLE IF EXISTS `bao_zhuan`;
CREATE TABLE `bao_zhuan` (
  `zhuan_id` int(10) NOT NULL AUTO_INCREMENT,
  `map_id` tinyint(4) DEFAULT NULL,
  `goods_id` int(10) NOT NULL,
  `floor_id` tinyint(4) NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `deadline` int(10) NOT NULL COMMENT '到期时间',
  PRIMARY KEY (`zhuan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;



-- ----------------------------
-- Table structure for `bao_zhuan_config`
-- ----------------------------
DROP TABLE IF EXISTS `bao_zhuan_config`;
CREATE TABLE `bao_zhuan_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `color_title` varchar(10) DEFAULT NULL,
  `color_bg` varchar(10) DEFAULT NULL,
  `color_mtitle` varchar(10) DEFAULT NULL,
  `color_mbg` varchar(10) DEFAULT NULL,
  `pc_banner` varchar(255) DEFAULT NULL,
  `mobile_banner` varchar(255) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0:删除,1正常',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `bao_zhuan_floor`
-- ----------------------------
DROP TABLE IF EXISTS `bao_zhuan_floor`;
CREATE TABLE `bao_zhuan_floor` (
  `floor_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(11) DEFAULT NULL COMMENT '11',
  `sort` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0:删除,1:正常',
  PRIMARY KEY (`floor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `bao_zhuan_map`
-- ----------------------------
DROP TABLE IF EXISTS `bao_zhuan_map`;
CREATE TABLE `bao_zhuan_map` (
  `map_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '专题ID',
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0:不启用，1:启用',
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `bao_shop_ding_dianping`
-- ----------------------------
DROP TABLE IF EXISTS `bao_shop_ding_dianping`;
CREATE TABLE `bao_shop_ding_dianping` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `contents` varchar(1024) DEFAULT NULL,
  `reply` varchar(1024) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `closed` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `bao_shop_ding_dianping_pic`
-- ----------------------------
DROP TABLE IF EXISTS `bao_shop_ding_dianping_pic`;
CREATE TABLE `bao_shop_ding_dianping_pic` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `dianping_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `bao_shop_ding_order`
-- ----------------------------
DROP TABLE IF EXISTS `bao_shop_ding_order`;
CREATE TABLE `bao_shop_ding_order` (
  `order_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `order_no` int(10) DEFAULT NULL,
  `is_dianping` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1代表已经付款购买   0未付款 -1 取消 2已消费',
  `name` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `total_price` int(10) DEFAULT NULL,
  `need_price` int(10) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `ding_id` mediumint(8) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT '1' COMMENT '1男 2女',
  `tip` mediumtext,
  `use_integral` int(11) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL,
  `create_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `bao_shop_ding_yuyue`
-- ----------------------------
DROP TABLE IF EXISTS `bao_shop_ding_yuyue`;
CREATE TABLE `bao_shop_ding_yuyue` (
  `ding_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `room_id` mediumint(8) NOT NULL,
  `shop_id` mediumint(8) DEFAULT NULL,
  `last_date` date NOT NULL,
  `last_t` tinyint(3) NOT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `user_id` mediumint(8) DEFAULT NULL,
  `number` int(3) DEFAULT NULL,
  `order_no` int(10) DEFAULT NULL,
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '1代表已经付款购买   0未付款',
  `create_time` int(10) DEFAULT NULL,
  `create_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ding_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

ALTER TABLE `bao_order_goods`
ADD COLUMN `update_time`  int(11) NULL DEFAULT 0 AFTER `create_ip`,
ADD COLUMN `update_ip`  varchar(15) NULL AFTER `update_time`;

ALTER TABLE `bao_order`
ADD COLUMN `update_time`  int(11) NULL DEFAULT 0 AFTER `create_ip`,
ADD COLUMN `update_ip`  varchar(15) NULL AFTER `update_time`;

ALTER TABLE `bao_users_cash`
ADD COLUMN `reason`  text NULL AFTER `status`;

ALTER TABLE `bao_order_goods`
ADD COLUMN `js_price`  int(11) NULL DEFAULT 0 AFTER `total_price`;


ALTER TABLE `bao_tuan`
ADD COLUMN `mobile_fan`  int(11) NULL DEFAULT 0 AFTER `use_integral`;

ALTER TABLE `bao_goods`
ADD COLUMN `mobile_fan`  int(11) NULL DEFAULT 0 AFTER `settlement_price`;

ALTER TABLE `bao_tuan_order`
ADD COLUMN `mobile_fan`  int(11) NULL DEFAULT 0 AFTER `use_integral`;

ALTER TABLE `bao_order_goods`
ADD COLUMN `mobile_fan`  int(11) NULL DEFAULT 0 AFTER `price`;

ALTER TABLE `bao_order`
ADD COLUMN `mobile_fan`  int(11) NULL DEFAULT 0 AFTER `total_price`;

ALTER TABLE `bao_cloud_goods`
ADD COLUMN `adress`  varchar(1024) NULL DEFAULT 0 AFTER `create_ip`;