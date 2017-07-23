--<?php exit("Access Denied");?>
DROP TABLE IF EXISTS `jh_admin`;
CREATE TABLE `jh_admin` (
  `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(15) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `role_id` smallint(6) DEFAULT '0',
  `last_login` int(10) DEFAULT '0',
  `last_ip` varchar(15) DEFAULT '0.0.0.0',
  `closed` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_admin_role`;
CREATE TABLE `jh_admin_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) DEFAULT '',
  `role` enum('editor','admin','system','fenzhan') DEFAULT NULL,
  `priv` mediumtext,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_adv`;
CREATE TABLE `jh_adv` (
  `adv_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(20) DEFAULT 'default',
  `theme_id` smallint(6) DEFAULT '0',
  `page` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `from` enum('text','photo','product','script','lunzhuan') DEFAULT 'photo',
  `limit` smallint(6) DEFAULT '10',
  `config` mediumtext,
  `desc` varchar(255) DEFAULT '',
  `tmpl` mediumtext,
  `orderby` smallint(6) unsigned DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_adv_item`;
CREATE TABLE `jh_adv_item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `adv_id` smallint(6) unsigned DEFAULT '0',
  `city_id` smallint(6) DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `link` varchar(150) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `script` mediumtext,
  `clicks` mediumint(8) unsigned DEFAULT '0',
  `stime` int(10) NOT NULL DEFAULT '0',
  `ltime` int(10) NOT NULL DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  `desc` varchar(255) DEFAULT '',
  `target` enum('_self','_blank','_parent','_top') DEFAULT '_blank',
  `orderby` smallint(6) unsigned DEFAULT '50',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_article`;
CREATE TABLE `jh_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `cat_id` mediumint(8) unsigned DEFAULT '0',
  `from` enum('article','about','help','page') DEFAULT 'article',
  `page` varchar(15) DEFAULT '',
  `title` varchar(200) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `desc` varchar(255) DEFAULT '',
  `views` mediumint(8) DEFAULT '0',
  `favorites` mediumint(8) DEFAULT '0',
  `allow_comment` tinyint(1) DEFAULT '1',
  `comments` mediumint(8) DEFAULT '0',
  `photos` smallint(6) DEFAULT '0',
  `linkurl` varchar(255) DEFAULT '',
  `ontime` int(10) DEFAULT '0',
  `hidden` tinyint(1) DEFAULT '0',
  `orderby` smallint(6) unsigned DEFAULT '50',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `cat_id` (`cat_id`,`from`,`audit`,`closed`,`hidden`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_article_cate`;
CREATE TABLE `jh_article_cate` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned DEFAULT '0',
  `title` varchar(150) DEFAULT '',
  `level` tinyint(1) unsigned DEFAULT '1',
  `from` enum('about','help','page','article') DEFAULT 'article',
  `seo_title` varchar(255) DEFAULT '',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_description` varchar(255) DEFAULT '',
  `orderby` smallint(6) unsigned DEFAULT '50',
  `hidden` tinyint(1) DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_article_content`;
CREATE TABLE `jh_article_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) NOT NULL,
  `seo_title` varchar(150) DEFAULT '',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_description` varchar(255) DEFAULT '',
  `content` mediumtext,
  `clientip` varchar(15) DEFAULT '0.0.0.0',
  PRIMARY KEY (`content_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_article_photo`;
CREATE TABLE `jh_article_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `photo` varchar(150) DEFAULT '',
  `size` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_block`;
CREATE TABLE `jh_block` (
  `block_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(30) DEFAULT NULL,
  `page_id` smallint(6) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `from` varchar(50) DEFAULT '',
  `type` enum('default','hot','new','only','zhanwei') DEFAULT 'default',
  `config` mediumtext,
  `tmpl` mediumtext,
  `limit` tinyint(3) DEFAULT '10',
  `ttl` mediumint(8) DEFAULT '900',
  `orderby` smallint(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_block_item`;
CREATE TABLE `jh_block_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `block_id` mediumint(8) unsigned DEFAULT '0',
  `itemId` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `link` varchar(150) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `city_id` smallint(6) DEFAULT '0',
  `data` mediumtext,
  `expire_time` int(10) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `block_id` (`block_id`,`itemId`,`city_id`),
  KEY `orderby` (`orderby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_block_page`;
CREATE TABLE `jh_block_page` (
  `page_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_data_city`;
CREATE TABLE `jh_data_city` (
  `city_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` smallint(6) DEFAULT '0',
  `city_name` varchar(50) DEFAULT '',
  `pinyin` varchar(50) DEFAULT '',
  `theme_id` smallint(6) DEFAULT '0',
  `logo` varchar(150) DEFAULT '',
  `phone` varchar(30) DEFAULT '',
  `city_code` char(4) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `mail` varchar(30) DEFAULT '',
  `kfqq` varchar(30) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `audit` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_data_province`;
CREATE TABLE `jh_data_province` (
  `province_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `province_name` varchar(30) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`province_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_hongbao`;
CREATE TABLE `jh_hongbao` (
  `hongbao_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `min_amount` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `type` tinyint(1) DEFAULT '0',
  `uid` int(10) DEFAULT '0',
  `hongbao_sn` char(8) NOT NULL DEFAULT '',
  `stime` int(10) DEFAULT '0',
  `ltime` int(10) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  `used_ip` varchar(15) DEFAULT '',
  `used_time` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(11) DEFAULT '0',
  PRIMARY KEY (`hongbao_id`),
  KEY `uid` (`uid`,`order_id`),
  KEY `stime` (`stime`,`ltime`),
  KEY `hongbao_sn` (`hongbao_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_hongbao_log`;
CREATE TABLE `jh_hongbao_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hongbao_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_mall_cate`;
CREATE TABLE `jh_mall_cate` (
  `cate_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT '',
  `icon` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  PRIMARY KEY (`cate_id`),
  KEY `orderby` (`orderby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_mall_order`;
CREATE TABLE `jh_mall_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `product_id` mediumint(8) DEFAULT '0',
  `product_name` varchar(80) DEFAULT '',
  `product_jifen` mediumint(8) DEFAULT '0',
  `product_number` smallint(6) DEFAULT '0',
  `contact` varchar(30) DEFAULT '',
  `mobile` char(11) DEFAULT '',
  `addr` varchar(150) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_mall_product`;
CREATE TABLE `jh_mall_product` (
  `product_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(6) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `jifen` mediumint(8) DEFAULT '0',
  `info` mediumtext,
  `views` mediumint(8) DEFAULT '0',
  `sales` mediumint(8) DEFAULT '0',
  `sku` int(10) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `cate_id` (`cate_id`,`orderby`,`closed`),
  KEY `jifen` (`jifen`,`views`,`sales`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_member`;
CREATE TABLE `jh_member` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(15) NOT NULL,
  `passwd` char(32) DEFAULT '',
  `paypasswd` char(32) DEFAULT '',
  `nickname` varchar(30) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `total_money` decimal(10,2) DEFAULT '0.00',
  `orders` mediumint(8) DEFAULT '0',
  `jifen` int(10) DEFAULT '0',
  `face` varchar(150) DEFAULT '',
  `wx_openid` varchar(50) DEFAULT '',
  `loginip` varchar(15) DEFAULT '',
  `lastlogin` int(10) DEFAULT '0',
  `pmid` char(9) DEFAULT '',
  `closed` tinyint(1) DEFAULT '0',
  `regip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mobile` (`mobile`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_member_addr`;
CREATE TABLE `jh_member_addr` (
  `addr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `contact` varchar(30) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `addr` varchar(255) DEFAULT '',
  `house` varchar(150) DEFAULT '',
  `is_default` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_member_help`;
CREATE TABLE `jh_member_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT '',
  `details` text,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`help_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_member_invite`;
CREATE TABLE `jh_member_invite` (
  `invite_uid` mediumint(8) NOT NULL DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `mobile` char(11) DEFAULT '',
  `money` decimal(6,2) DEFAULT '0.00',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`invite_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_member_log`;
CREATE TABLE `jh_member_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `type` enum('money','jifen') DEFAULT NULL,
  `number` float DEFAULT '0',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(80) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `uid` (`uid`,`type`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_member_message`;
CREATE TABLE `jh_member_message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT NULL,
  `content` varchar(512) DEFAULT '',
  `type` tinyint(1) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  `is_read` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_order`;
CREATE TABLE `jh_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `product_number` mediumint(8) DEFAULT '0',
  `product_price` decimal(10,2) DEFAULT '0.00',
  `package_price` decimal(8,2) DEFAULT '0.00',
  `freight` decimal(6,2) DEFAULT '0.00',
  `money` decimal(10,2) DEFAULT '0.00',
  `amount` decimal(10,2) DEFAULT '0.00',
  `order_youhui` decimal(8,2) DEFAULT '0.00',
  `first_youhui` decimal(8,2) DEFAULT '0.00',
  `hongbao` decimal(8,2) DEFAULT '0.00',
  `hongbao_id` int(10) DEFAULT '0',
  `contact` varchar(30) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `addr` varchar(255) DEFAULT '',
  `house` varchar(150) DEFAULT '',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `pei_time` char(11) DEFAULT '0',
  `note` varchar(150) DEFAULT '',
  `order_status` tinyint(1) DEFAULT '0',
  `pay_status` tinyint(1) DEFAULT '0',
  `online_pay` tinyint(1) DEFAULT '0',
  `pay_code` varchar(10) DEFAULT '',
  `pay_ip` varchar(15) DEFAULT '',
  `pay_time` int(10) DEFAULT '0',
  `staff_id` mediumint(8) DEFAULT '0',
  `pei_type` tinyint(1) DEFAULT '0',
  `pei_amount` decimal(6,2) DEFAULT '0.00',
  `comment_status` tinyint(1) DEFAULT '0',
  `cui_time` int(10) DEFAULT '0',
  `order_from` enum('weixin','ios','android','wap','www') DEFAULT 'weixin',
  `day` int(8) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `shop_id` (`shop_id`,`uid`,`staff_id`),
  KEY `order_status` (`order_status`,`pay_status`,`closed`,`pei_type`),
  KEY `lat` (`lat`,`lng`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_order_complaint`;
CREATE TABLE `jh_order_complaint` (
  `complaint_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT NULL,
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `staff_id` mediumint(8) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `content` varchar(255) DEFAULT '',
  `clientip` varchar(15) DEFAULT '',
  `reply` varchar(255) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`complaint_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_order_log`;
CREATE TABLE `jh_order_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `from` enum('shop','admin','staff','member') DEFAULT NULL,
  `log` varchar(255) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_order_product`;
CREATE TABLE `jh_order_product` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `product_id` int(10) DEFAULT '0',
  `product_name` varchar(150) DEFAULT '',
  `product_price` decimal(8,2) DEFAULT NULL,
  `package_price` decimal(6,2) DEFAULT '0.00',
  `product_number` smallint(6) DEFAULT '0',
  `amount` decimal(8,2) DEFAULT '0.00',
  PRIMARY KEY (`pid`),
  KEY `order_id` (`order_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_payment`;
CREATE TABLE `jh_payment` (
  `payment_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `payment` varchar(20) DEFAULT '',
  `title` varchar(100) DEFAULT '',
  `logo` varchar(150) DEFAULT '',
  `config` mediumtext,
  `status` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_payment_log`;
CREATE TABLE `jh_payment_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `from` enum('money','order') DEFAULT NULL,
  `payment` varchar(20) DEFAULT '',
  `trade_no` int(10) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  `amount` decimal(10,2) DEFAULT '0.00',
  `payed` tinyint(1) DEFAULT '0',
  `payedip` varchar(15) DEFAULT '',
  `payedtime` int(10) DEFAULT '0',
  `pay_trade_no` varchar(50) DEFAULT '',
  `extra_pay` varchar(200) DEFAULT '',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `trade_no` (`trade_no`),
  KEY `uid` (`uid`),
  KEY `from` (`from`,`payed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_product`;
CREATE TABLE `jh_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `cate_id` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `price` decimal(8,2) DEFAULT '0.00',
  `package_price` decimal(6,2) DEFAULT '0.00',
  `sales` mediumint(8) DEFAULT '0',
  `sale_type` tinyint(1) DEFAULT '0',
  `sale_sku` mediumint(8) DEFAULT '0',
  `sale_count` mediumint(8) DEFAULT '0',
  `intro` varchar(1024) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `shop_id` (`shop_id`,`cate_id`,`closed`),
  KEY `orderby` (`orderby`,`closed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_product_cate`;
CREATE TABLE `jh_product_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `title` varchar(30) DEFAULT '',
  `icon` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`cate_id`),
  KEY `shop_id` (`shop_id`),
  KEY `orderby` (`orderby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_session`;
CREATE TABLE `jh_session` (
  `SSID` char(35) NOT NULL,
  `uid` mediumint(8) DEFAULT '0',
  `city_id` mediumint(8) DEFAULT '0',
  `ip` char(15) DEFAULT '0.0.0.0',
  `data` varchar(1024) DEFAULT NULL,
  `lastupdate` int(10) DEFAULT '0',
  PRIMARY KEY (`SSID`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop`;
CREATE TABLE `jh_shop` (
  `shop_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `cate_id` smallint(6) DEFAULT '0',
  `mobile` char(11) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `phone` varchar(20) DEFAULT '',
  `title` varchar(80) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `total_money` decimal(10,2) DEFAULT '0.00',
  `banner` varchar(150) DEFAULT '',
  `logo` varchar(150) DEFAULT '',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `addr` varchar(150) DEFAULT '',
  `views` mediumint(8) DEFAULT '0',
  `orders` mediumint(8) DEFAULT '0',
  `comments` mediumint(8) DEFAULT '0',
  `praise_num` mediumint(8) DEFAULT '0',
  `score` int(10) DEFAULT '0',
  `score_fuwu` int(10) DEFAULT '0',
  `score_kouwei` int(10) DEFAULT '0',
  `first_amount` decimal(6,2) DEFAULT '0.00',
  `min_amount` decimal(6,2) DEFAULT '0.00',
  `freight` decimal(6,2) DEFAULT '0.00',
  `pei_distance` decimal(6,0) DEFAULT '0',
  `pei_time` smallint(6) DEFAULT '0',
  `pei_type` tinyint(1) DEFAULT '0',
  `pei_amount` decimal(6,2) DEFAULT '0.00',
  `yy_status` tinyint(1) DEFAULT '0',
  `yy_stime` char(5) DEFAULT '9:00',
  `yy_ltime` char(5) DEFAULT '20:00',
  `yy_xiuxi` varchar(512) DEFAULT '',
  `is_new` tinyint(1) DEFAULT '0',
  `online_pay` tinyint(1) DEFAULT '0',
  `youhui` varchar(1024) DEFAULT NULL,
  `info` varchar(1024) DEFAULT '',
  `pmid` char(9) DEFAULT '',
  `verify_name` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `tixian_percent` tinyint(2) unsigned DEFAULT '100',
  `orderby` tinyint(4) unsigned DEFAULT '50',
  PRIMARY KEY (`shop_id`),
  KEY `city_id` (`city_id`,`cate_id`),
  KEY `lat` (`lat`,`lng`),
  KEY `views` (`views`,`orders`,`comments`,`score`,`audit`,`closed`),
  KEY `pei_time` (`pei_time`,`pei_type`,`yy_stime`,`yy_ltime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_account`;
CREATE TABLE `jh_shop_account` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0',
  `account_type` varchar(80) DEFAULT NULL,
  `account_name` varchar(30) DEFAULT '',
  `account_number` varchar(100) DEFAULT '',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_cate`;
CREATE TABLE `jh_shop_cate` (
  `cate_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT '0',
  `title` varchar(30) DEFAULT '',
  `icon` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_collect`;
CREATE TABLE `jh_shop_collect` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0',
  `uid` mediumint(8) NOT NULL DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`uid`,`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_comment`;
CREATE TABLE `jh_shop_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `order_id` int(8) DEFAULT '0',
  `score` tinyint(1) DEFAULT '0',
  `score_fuwu` tinyint(1) DEFAULT '0',
  `score_kouwei` tinyint(1) DEFAULT '0',
  `pei_time` smallint(6) DEFAULT '30',
  `content` varchar(1024) DEFAULT '',
  `have_photo` tinyint(1) DEFAULT '0',
  `reply` varchar(1024) DEFAULT '',
  `reply_ip` varchar(15) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `shop_id` (`shop_id`,`uid`),
  KEY `order_id` (`order_id`,`score`,`reply_time`,`closed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_comment_photo`;
CREATE TABLE `jh_shop_comment_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(150) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_log`;
CREATE TABLE `jh_shop_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(255) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(25) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `shop_id` (`shop_id`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_msg`;
CREATE TABLE `jh_shop_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT NULL,
  `content` varchar(512) DEFAULT '',
  `is_read` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_tixian`;
CREATE TABLE `jh_shop_tixian` (
  `tixian_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `account_info` varchar(512) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `reason` varchar(255) DEFAULT '',
  `updatetime` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  `end_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`tixian_id`),
  KEY `shop_id` (`shop_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_verify`;
CREATE TABLE `jh_shop_verify` (
  `shop_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_name` varchar(30) DEFAULT '',
  `id_number` varchar(20) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `shop_photo` varchar(150) DEFAULT '',
  `verify_dianzhu` tinyint(1) DEFAULT '0',
  `yz_number` varchar(30) DEFAULT '',
  `yz_photo` varchar(150) DEFAULT '',
  `verify_yyzz` tinyint(1) DEFAULT '0',
  `cy_number` varchar(30) DEFAULT '',
  `cy_photo` varchar(150) DEFAULT '',
  `verify_cy` tinyint(1) DEFAULT '0',
  `refuse` varchar(255) DEFAULT '',
  `verify` tinyint(1) DEFAULT '0',
  `verify_time` int(10) DEFAULT '0',
  `updatetime` int(10) DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_shop_youhui`;
CREATE TABLE `jh_shop_youhui` (
  `youhui_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `order_amount` decimal(10,2) DEFAULT '0.00',
  `youhui_amount` decimal(8,2) DEFAULT '0.00',
  `use_count` smallint(6) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '0',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`youhui_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_sms_log`;
CREATE TABLE `jh_sms_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(50) DEFAULT '',
  `content` varchar(255) DEFAULT '',
  `sms` varchar(20) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `clientip` char(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_staff`;
CREATE TABLE `jh_staff` (
  `staff_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `mobile` char(11) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `face` varchar(150) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `total_money` decimal(10,2) DEFAULT '0.00',
  `orders` mediumint(8) DEFAULT '0',
  `loginip` varchar(15) DEFAULT '',
  `lastlogin` int(10) DEFAULT '0',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `name` varchar(30) DEFAULT '',
  `id_number` varchar(20) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `account_type` varchar(30) DEFAULT '',
  `account_name` varchar(30) DEFAULT '',
  `account_number` varchar(30) DEFAULT '',
  `verify_name` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `tixian_percent` tinyint(2) unsigned DEFAULT '100',
  PRIMARY KEY (`staff_id`),
  KEY `mobile` (`mobile`,`closed`),
  KEY `city_id` (`city_id`,`audit`,`closed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_staff_log`;
CREATE TABLE `jh_staff_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(255) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(25) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `staff_id` (`staff_id`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_staff_msg`;
CREATE TABLE `jh_staff_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT NULL,
  `content` varchar(512) DEFAULT '',
  `is_read` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_staff_tixian`;
CREATE TABLE `jh_staff_tixian` (
  `tixian_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` mediumint(8) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `account_info` varchar(512) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `reason` varchar(255) DEFAULT '',
  `updatetime` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  `end_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`tixian_id`),
  KEY `staff_id` (`staff_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_staff_verify`;
CREATE TABLE `jh_staff_verify` (
  `staff_id` mediumint(8) NOT NULL,
  `id_name` varchar(30) DEFAULT '',
  `id_number` varchar(18) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `verify` tinyint(1) DEFAULT '0',
  `verify_time` int(10) DEFAULT '0',
  `refuse` varchar(150) DEFAULT '',
  `updatetime` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_system_config`;
CREATE TABLE `jh_system_config` (
  `k` varchar(30) NOT NULL,
  `v` mediumtext,
  `title` varchar(30) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_system_logs`;
CREATE TABLE `jh_system_logs` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(30) DEFAULT '',
  `action` varchar(50) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `content` mediumtext,
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_system_module`;
CREATE TABLE `jh_system_module` (
  `mod_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module` enum('top','menu','module') DEFAULT 'module',
  `level` tinyint(1) DEFAULT '3',
  `ctl` varchar(20) DEFAULT '',
  `act` varchar(20) DEFAULT '',
  `title` varchar(20) DEFAULT '',
  `visible` tinyint(1) DEFAULT '1',
  `parent_id` smallint(6) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`mod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_themes`;
CREATE TABLE `jh_themes` (
  `theme_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `config` mediumtext,
  `default` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`theme_id`),
  KEY `theme` (`theme`,`default`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_upload_photo`;
CREATE TABLE `jh_upload_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT '0',
  `from` varchar(30) DEFAULT '',
  `hash` char(32) DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `size` smallint(6) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`),
  KEY `hash` (`hash`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
