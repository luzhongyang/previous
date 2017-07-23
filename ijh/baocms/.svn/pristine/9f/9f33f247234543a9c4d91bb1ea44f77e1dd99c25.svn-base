ALTER TABLE `bao_shop_ding_dianping`
DROP COLUMN `show_date`,
ADD COLUMN `have_photo`  tinyint(1) NULL DEFAULT 0 AFTER `contents`;

ALTER TABLE `bao_shop_ding_setting`
DROP COLUMN `bao_time`,
DROP COLUMN `start_time`,
DROP COLUMN `end_time`,
DROP COLUMN `is_bao`,
DROP COLUMN `is_ting`,
CHANGE COLUMN `money` `deposit`  int(11) NULL DEFAULT 0 COMMENT '包厢需要缴纳定金' AFTER `mobile`;

***
ALTER TABLE `bao_shop_ding_order`
DROP COLUMN `need_price`,
DROP COLUMN `ding_id`,
DROP COLUMN `use_integral`,
ADD COLUMN `ding_date`  varchar(20) NULL DEFAULT '' AFTER `order_no`,
ADD COLUMN `ding_time`  varchar(20) NULL DEFAULT '' AFTER `ding_date`,
ADD COLUMN `ding_num`  varchar(20) NULL DEFAULT '' AFTER `ding_time`,
ADD COLUMN `ding_type`  tinyint(1) NULL DEFAULT 0 AFTER `ding_num`;
CHANGE COLUMN `status` `order_status`  tinyint(1) NULL DEFAULT 0 AFTER `ding_type`;
CHANGE COLUMN `is_dianping` `comment_status`  tinyint(1) NULL DEFAULT 0 AFTER `order_status`,
CHANGE COLUMN `total_price` `amount`  int(10) NULL DEFAULT NULL AFTER `mobile`,
CHANGE COLUMN `tip` `note`  mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `sex`;
ADD COLUMN `update_time`  int(10) DEFAULT '0' AFTER `note`;


ALTER TABLE `bao_goods`
ADD COLUMN `rush_price`  int(11) NULL AFTER `share`;

ALTER TABLE `bao_goods`
ADD COLUMN `rush_kucun`  smallint(6) NULL AFTER `share`;

ALTER TABLE `bao_goods`
ADD COLUMN `rush_ltime`  int(11) NULL AFTER `share`;

ALTER TABLE `bao_goods`
ADD COLUMN `max_buy`  smallint(6) NULL AFTER `share`;

ALTER TABLE `bao_goods`
ADD COLUMN `ltime`  int(11) NULL AFTER `audit`;


ALTER TABLE `bao_goods`
ADD COLUMN `type`  enum('goods','crowd') NULL AFTER `title`;

DROP TABLE IF EXISTS `bao_goods_ask`;
CREATE TABLE `bao_goods_ask` (
  `ask_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT NULL,
  `ask_c` text,
  `answer_c` text,
  `goods_id` mediumint(8) DEFAULT NULL,
  `answer_time` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`ask_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_goods_crowd`;
CREATE TABLE `bao_goods_crowd` (
  `goods_id` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `follow_num` smallint(6) DEFAULT '0',
  `zan_num` smallint(6) DEFAULT '0',
  `img` varchar(225) DEFAULT NULL,
  `all_price` int(11) DEFAULT NULL,
  `details` text,
  `instructions` text,
  `have_price` int(11) DEFAULT '0',
  `ltime` int(11) DEFAULT NULL,
  `have_num` smallint(6) DEFAULT '0',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_goods_follow`;
CREATE TABLE `bao_goods_follow` (
  `zan_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `type` enum('follow','zan') DEFAULT NULL,
  `uid` mediumint(8) DEFAULT NULL,
  `goods_id` mediumint(8) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`zan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_goods_list`;
CREATE TABLE `bao_goods_list` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT NULL,
  `type_id` mediumint(8) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `addr` varchar(500) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `is_zhong` tinyint(1) DEFAULT '0',
  `goods_id` mediumint(8) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_goods_project`;
CREATE TABLE `bao_goods_project` (
  `project_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) DEFAULT NULL,
  `content` text,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_goods_type`;
CREATE TABLE `bao_goods_type` (
  `type_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `max_num` mediumint(8) DEFAULT NULL,
  `have_num` mediumint(8) DEFAULT '0',
  `content` text,
  `img` varchar(200) DEFAULT NULL,
  `yunfei` smallint(3) DEFAULT '0',
  `choujiang` tinyint(1) DEFAULT NULL,
  `fahuo` smallint(3) DEFAULT '30',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;



ALTER TABLE `bao_shop_ding_menu`
ADD COLUMN `sold_num`  int(10) NULL DEFAULT 0 AFTER `ding_price`;

***
ALTER TABLE `bao_ad_site`
INSERT INTO `bao_ad_site` (`theme`, `site_name`, `site_type`, `site_place`) VALUES ('default', '手机订座首页轮播广告位', '2', '21')


ALTER TABLE `bao_payment_logs`
MODIFY COLUMN `type`  enum('tuan','gold','money','ele','ding','fzmoney','breaks','hotel','farm','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `user_id`;


DROP TABLE IF EXISTS `bao_hotel`;
CREATE TABLE `bao_hotel` (
  `hotel_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0' COMMENT '关联shop_id',
  `hotel_name` varchar(32) DEFAULT '',
  `tel` varchar(20) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `addr` varchar(128) DEFAULT '',
  `city_id` int(10) DEFAULT '0',
  `area_id` int(10) DEFAULT '0',
  `business_id` int(10) DEFAULT '0',
  `star` tinyint(1) DEFAULT '0' COMMENT '星级',
  `cate_id` tinyint(1) DEFAULT '0' COMMENT '酒店级别',
  `price` int(10) DEFAULT '0' COMMENT '评价价格',
  `sold_num` int(10) DEFAULT '0',
  `comments` int(10) DEFAULT '0',
  `score` int(10) DEFAULT '0' COMMENT '评分，所有分数的和',
  `type` tinyint(1) DEFAULT '0' COMMENT '酒店品牌',
  `is_wifi` tinyint(1) DEFAULT '0',
  `is_kt` tinyint(1) DEFAULT '0' COMMENT '是否有空调',
  `is_nq` tinyint(1) DEFAULT '0' COMMENT '是否有暖气',
  `is_xyj` tinyint(1) DEFAULT '0' COMMENT '是否有洗衣机',
  `is_tv` tinyint(1) DEFAULT '0',
  `is_ly` tinyint(1) DEFAULT '0' COMMENT '是否有淋浴',
  `is_bx` tinyint(1) DEFAULT '0' COMMENT '是否有冰箱',
  `is_base` tinyint(1) DEFAULT '0' COMMENT '是否有毛巾牙刷',
  `is_rsh` tinyint(1) DEFAULT '0' COMMENT '是否有热水壶',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `details` text,
  `update_time` int(10) DEFAULT '0',
  `update_ip` varchar(15) DEFAULT '',
  `audit` tinyint(1) DEFAULT '0',
  `reason` varchar(256) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`hotel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_hotel_brand`;
CREATE TABLE `bao_hotel_brand` (
  `type` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT '',
  `orderby` tinyint(3) DEFAULT '100',
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_hotel_comment`;
CREATE TABLE `bao_hotel_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `hotel_id` int(10) DEFAULT '0',
  `score` tinyint(1) DEFAULT '0',
  `have_photo` tinyint(1) DEFAULT '0',
  `content` varchar(1024) DEFAULT '',
  `reply` varchar(1024) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `reply_ip` varchar(15) DEFAULT '',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_hotel_comment_pics`;
CREATE TABLE `bao_hotel_comment_pics` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_hotel_order`;
CREATE TABLE `bao_hotel_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT '0',
  `room_id` int(10) DEFAULT '0',
  `amount` int(10) DEFAULT '0',
  `jiesuan_amount` int(10) DEFAULT '0',
  `price` int(10) DEFAULT '0',
  `num` smallint(5) DEFAULT '0',
  `stime` date DEFAULT NULL,
  `ltime` date DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT '',
  `note` text,
  `order_status` tinyint(1) DEFAULT '0',
  `comment_status` tinyint(1) DEFAULT '0',
  `online_pay` tinyint(1) DEFAULT '0',
  `last_time` varchar(15) DEFAULT '',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_hotel_pics`;
CREATE TABLE `bao_hotel_pics` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_hotel_room`;
CREATE TABLE `bao_hotel_room` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_id` int(10) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `type` tinyint(1) DEFAULT '0' COMMENT '床型',
  `area` smallint(5) DEFAULT '0' COMMENT '面积，是整数',
  `is_zc` tinyint(1) DEFAULT '0' COMMENT '是否供应早餐',
  `is_kd` tinyint(1) DEFAULT '0' COMMENT '是否有宽带',
  `is_cancel` tinyint(1) DEFAULT '0' COMMENT '是否可以取消',
  `sku` smallint(5) DEFAULT '0' COMMENT '库存',
  `price` int(10) DEFAULT '0' COMMENT '房价',
  `settlement_price` int(10) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_shop_setting`;
CREATE TABLE `bao_shop_setting` (
  `set_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `apiKey` varchar(64) DEFAULT '',
  `mKey` varchar(32) DEFAULT '',
  `partner` int(10) DEFAULT '0',
  `machine_code` varchar(32) DEFAULT '',
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_shop_ding`;
CREATE TABLE `bao_shop_ding` (
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联shop_id',
  `shop_name` varchar(32) DEFAULT '',
  `tel` varchar(15) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `addr` varchar(128) DEFAULT '',
  `city_id` int(10) DEFAULT '0',
  `area_id` int(10) DEFAULT '0',
  `business_id` int(10) DEFAULT '0',
  `price` int(10) DEFAULT '0' COMMENT '评价价格',
  `deposit` int(10) DEFAULT '0' COMMENT '定金',
  `orders` int(10) DEFAULT '0',
  `comments` int(10) DEFAULT '0',
  `score` float(2,1) DEFAULT '0.0' COMMENT '评分',
  `kw_score` float(2,1) DEFAULT '0.0',
  `hj_score` float(2,1) DEFAULT '0.0',
  `fw_score` float(2,1) DEFAULT '0.0',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `stime` varchar(10) DEFAULT '' COMMENT '开始订座时间',
  `ltime` varchar(10) DEFAULT '' COMMENT '结束订座时间',
  `is_open` tinyint(1) DEFAULT '1',
  `details` text,
  `update_time` int(10) DEFAULT '0',
  `update_ip` varchar(15) DEFAULT '',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_shop_ding_attr`;
CREATE TABLE `bao_shop_ding_attr` (
  `type_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`,`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe`;
CREATE TABLE `bao_tribe` (
  `tribe_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(10) DEFAULT '0',
  `tribe_name` varchar(32) DEFAULT '',
  `intro` varchar(256) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `banner` varchar(128) DEFAULT '',
  `posts` int(10) DEFAULT '0',
  `fans` int(10) DEFAULT '0',
  `is_hot` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`tribe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe_cate`;
CREATE TABLE `bao_tribe_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT '',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_tribe_collect`;
CREATE TABLE `bao_tribe_collect` (
  `tribe_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tribe_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_tribe_comments_photo`;
CREATE TABLE `bao_tribe_comments_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe_post`;
CREATE TABLE `bao_tribe_post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT '',
  `tribe_id` int(10) DEFAULT '0',
  `cate_id` int(10) DEFAULT '0',
  `details` text,
  `user_id` int(10) DEFAULT '0',
  `donate_num` int(10) DEFAULT '0',
  `reply_num` int(10) DEFAULT '0',
  `zan_num` int(10) DEFAULT '0',
  `views` int(10) DEFAULT '0',
  `last_id` int(10) DEFAULT '0',
  `last_time` int(10) DEFAULT '0' COMMENT '最后时间',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe_post_comments`;
CREATE TABLE `bao_tribe_post_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '0代表评论帖子，1代表仅回复评论，2代表回复评价且在评论列表显示',
  `contents` text,
  `user_id` int(10) DEFAULT '0' COMMENT '评论用户',
  `reply_comment_id` int(10) DEFAULT '0',
  `reply_user_id` int(10) DEFAULT '0' COMMENT '回复评论的用户',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe_post_photo`;
CREATE TABLE `bao_tribe_post_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe_post_zan`;
CREATE TABLE `bao_tribe_post_zan` (
  `zan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`zan_id`),
  UNIQUE KEY `post_id` (`post_id`,`create_ip`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_farm`;
CREATE TABLE `bao_farm` (
  `farm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联shop_id',
  `farm_name` varchar(32) DEFAULT '',
  `intro` varchar(128) DEFAULT '',
  `tel` varchar(20) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `addr` varchar(128) DEFAULT '',
  `city_id` int(10) DEFAULT '0',
  `area_id` int(10) DEFAULT '0',
  `business_id` int(10) DEFAULT '0',
  `orders` int(10) DEFAULT '0',
  `comments` int(10) DEFAULT '0',
  `good_comments` int(10) DEFAULT '0',
  `score` int(10) DEFAULT '0' COMMENT '评分',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `business_time` varchar(64) DEFAULT '',
  `details` text,
  `notice` text,
  `environmental` text,
  `update_time` int(10) DEFAULT '0',
  `update_ip` varchar(15) DEFAULT '',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  `have_room` tinyint(1) DEFAULT '0' COMMENT '是否标准间',
  `have_washchange` tinyint(1) DEFAULT '0' COMMENT '是否一客洗换',
  `have_wifi` tinyint(1) DEFAULT '0' COMMENT '是否有WIFI',
  `have_shower` tinyint(1) DEFAULT '0' COMMENT '是否有淋浴',
  `have_tv` tinyint(1) DEFAULT '0' COMMENT '是否有电视',
  `have_ticket` tinyint(1) DEFAULT '0' COMMENT '是否有门票',
  `have_toiletries` tinyint(1) DEFAULT '0' COMMENT '是否有洗漱用品',
  `have_hotwater` tinyint(1) DEFAULT '0' COMMENT '是否有全天热水',
  `price` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`farm_id`,`shop_id`),
  UNIQUE KEY `shop_id` (`shop_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `bao_farm_comment`;
CREATE TABLE `bao_farm_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `farm_id` int(10) DEFAULT '0',
  `score` tinyint(1) DEFAULT '0',
  `have_photo` tinyint(1) DEFAULT '0',
  `content` varchar(1024) DEFAULT '',
  `reply` varchar(1024) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `reply_ip` varchar(15) DEFAULT '',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_farm_comment_pics`;
CREATE TABLE `bao_farm_comment_pics` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_farm_group_attr`;
CREATE TABLE `bao_farm_group_attr` (
  `attr_id` int(10) unsigned NOT NULL DEFAULT '0',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`attr_id`,`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_farm_order`;
CREATE TABLE `bao_farm_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `farm_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL COMMENT '农家乐-套餐ID-package',
  `amount` int(10) unsigned DEFAULT '0' COMMENT '订单支付金额',
  `jiesuan_amount` int(10) unsigned DEFAULT '0' COMMENT '结算给商家的结算金额',
  `name` varchar(32) DEFAULT '' COMMENT '联系人',
  `mobile` varchar(11) DEFAULT '' COMMENT '联系人手机号',
  `note` text COMMENT '补充说明',
  `gotime` int(10) unsigned DEFAULT '0' COMMENT '到店时间',
  `order_status` tinyint(1) DEFAULT '0' COMMENT '订单状态',
  `comment_status` tinyint(1) unsigned DEFAULT '0' COMMENT '评价状态',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `create_ip` varchar(15) DEFAULT '' COMMENT '创建IP',
  `closed` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `bao_farm_package`;
CREATE TABLE `bao_farm_package` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `farm_id` int(10) unsigned DEFAULT '0',
  `title` varchar(128) DEFAULT '',
  `price` int(10) unsigned DEFAULT '0',
  `jiesuan_price` int(10) unsigned DEFAULT '0',
  `intro` varchar(128) DEFAULT '',
  `intro2` varchar(128) DEFAULT '',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_farm_pics`;
CREATE TABLE `bao_farm_pics` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `farm_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_tribe_donate`;
CREATE TABLE `bao_tribe_donate` (
  `donate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `money` decimal(10,1) DEFAULT '0.0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`donate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

ALTER TABLE `bao_tuan`
MODIFY COLUMN `bg_date`  datetime NULL DEFAULT '0000-00-00' AFTER `wei_pic`,
MODIFY COLUMN `end_date`  datetime NULL DEFAULT '0000-00-00' AFTER `bg_date`;

ALTER TABLE `bao_shop_dianping`
ADD COLUMN `audit`  tinyint(1) NULL DEFAULT 0 AFTER `show_date`;

ALTER TABLE `bao_connect`
ADD COLUMN `wx_unionid`  varchar(100) NULL AFTER `open_id`;

ALTER TABLE `bao_connect`
ADD INDEX `wx_unionid` (`wx_unionid`) ;


DROP TABLE IF EXISTS `bao_goods_format`;
CREATE TABLE `bao_goods_format` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `mall_price` int(10) DEFAULT NULL,
  `store` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_farm_play_attr`;
CREATE TABLE `bao_farm_play_attr` (
  `attr_id` int(10) unsigned NOT NULL DEFAULT '0',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`attr_id`,`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_format`;
CREATE TABLE `bao_format` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_shop_ding_order_menu`;
CREATE TABLE `bao_shop_ding_order_menu` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `menu_id` int(10) DEFAULT '0',
  `price` int(10) DEFAULT '0',
  `menu_name` varchar(32) DEFAULT '',
  `num` int(10) DEFAULT '0',
  `amount` int(10) DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_shop_ding_pics`;
CREATE TABLE `bao_shop_ding_pics` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;


ALTER TABLE `bao_hotel`
ADD COLUMN `in_time`  varchar(10) NULL DEFAULT '' AFTER `lng`,
ADD COLUMN `out_time`  varchar(10) NULL DEFAULT '' AFTER `in_time`;


ALTER TABLE `bao_pc_function`
ADD COLUMN `is_new`  tinyint(1) NULL DEFAULT 0 AFTER `is_system`;