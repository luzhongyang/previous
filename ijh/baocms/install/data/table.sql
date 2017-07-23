CREATE TABLE IF NOT EXISTS `bao_activity` (
  `activity_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(10) DEFAULT '0',
  `shop_id` int(10) DEFAULT NULL,
  `tuan_id` int(11) DEFAULT '0',
  `city_id` smallint(5) unsigned DEFAULT '0',
  `area_id` smallint(5) unsigned DEFAULT '0',
  `business_id` smallint(5) unsigned DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `intro` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `thumb` text,
  `details` text,
  `price` decimal(32,0) DEFAULT NULL,
  `bg_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `time` varchar(64) DEFAULT NULL,
  `sign_end` date DEFAULT NULL,
  `addr` varchar(1024) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT NULL,
  `audit` tinyint(2) DEFAULT '0',
  `closed` tinyint(2) DEFAULT '0',
  `sign_num` int(10) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  `template` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_activity_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` tinyint(3) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_activity_sign` (
  `sign_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `num` int(5) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`sign_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` smallint(6) DEFAULT '0',
  `city_id` smallint(5) unsigned DEFAULT '0',
  `title` varchar(64) DEFAULT NULL,
  `link_url` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `code` varchar(1024) DEFAULT NULL,
  `bg_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_admin` (
  `admin_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `role_id` smallint(5) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ad_site` (
  `site_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(32) DEFAULT NULL,
  `site_name` varchar(64) DEFAULT NULL,
  `site_type` tinyint(1) DEFAULT NULL,
  `site_place` smallint(5) DEFAULT '0',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_app_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `app_type` int(1) unsigned DEFAULT '0' COMMENT '0:ios,1:android',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_area` (
  `area_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(5) DEFAULT '0',
  `area_name` varchar(32) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_around` (
  `around_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1代表常去，2代表我家，3代表公司',
  `name` varchar(128) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`around_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(5) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `cate_id` smallint(5) DEFAULT '0',
  `source` varchar(32) DEFAULT NULL,
  `keywords` varchar(256) DEFAULT NULL,
  `desc` varchar(256) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `details` text,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_article_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_award` (
  `award_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `type` enum('shark','scratch','lottery') DEFAULT NULL COMMENT '摇一摇 刮刮卡  抽奖大转盘',
  `explain` varchar(1024) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `is_online` tinyint(1) DEFAULT '0' COMMENT '1就是在线状态了',
  PRIMARY KEY (`award_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_award_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `award_id` int(11) DEFAULT NULL,
  `award_name` varchar(32) DEFAULT NULL,
  `goods_name` varchar(64) DEFAULT NULL,
  `prob` int(11) DEFAULT '0' COMMENT '数值越大概率越低',
  `num` int(11) DEFAULT '0',
  `surplus` int(11) DEFAULT '0',
  PRIMARY KEY (`goods_id`),
  KEY `award_id` (`award_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_award_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `award_id` int(11) DEFAULT NULL,
  `is_used` tinyint(4) DEFAULT '0' COMMENT '1代表抽过奖了',
  `ip` varchar(15) DEFAULT NULL,
  `num` int(11) DEFAULT '0' COMMENT '点击的数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`,`award_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_award_winning` (
  `winning_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `award_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `randstr` varchar(6) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`winning_id`),
  KEY `award_id` (`award_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_billboard` (
  `list_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `intro` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `cate_id` int(10) DEFAULT NULL,
  `looknum` int(11) DEFAULT '0',
  `orderby` int(10) DEFAULT '100',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `is_hot` tinyint(1) DEFAULT '0',
  `is_new` tinyint(1) DEFAULT NULL,
  `is_chose` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_bill_cate` (
  `cate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(128) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  `photo` varchar(128) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_bill_shop` (
  `bill_id` int(10) NOT NULL AUTO_INCREMENT,
  `list_id` int(10) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `reason` varchar(128) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `votenum` int(11) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_bill_vote` (
  `vote_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `bill_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_breaks_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `amount` decimal(8,2) DEFAULT '0.00',
  `exception` decimal(8,2) DEFAULT '0.00',
  `need_pay` decimal(8,2) DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '0未支付，1已支付',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_business` (
  `business_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `business_name` varchar(32) DEFAULT NULL,
  `area_id` smallint(5) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `is_hot` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`business_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_city` (
  `city_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `pinyin` varchar(32) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `theme` varchar(32) DEFAULT 'default',
  `orderby` tinyint(3) DEFAULT '100',
  `first_letter` char(1) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_cloud_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0' COMMENT '0表示后台发布',
  `city_id` int(10) DEFAULT '0',
  `area_id` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1表示1元夺宝，2代表5元夺宝，3代表10元夺宝',
  `title` varchar(64) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `details` text,
  `join` int(10) DEFAULT '0' COMMENT '已参与',
  `price` int(10) DEFAULT '0' COMMENT '总价格',
  `max` int(10) DEFAULT '0' COMMENT '该件商品最大允许的参与数',
  `settlement_price` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  `thumb` text,
  `status` tinyint(4) DEFAULT '0' COMMENT '0表示正在云购中，1表示已结束',
  `win_user_id` int(10) DEFAULT '0' COMMENT '中奖UID',
  `win_number` int(10) DEFAULT '0' COMMENT '中奖编号',
  `closed` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `lottery_time` int(10) DEFAULT '0' COMMENT '开奖时间',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  `adress` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_cloud_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `num` int(10) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `microtime` varchar(3) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_community` (
  `community_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '物业管理员',
  `city_id` smallint(5) DEFAULT NULL,
  `area_id` smallint(5) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `addr` varchar(128) DEFAULT NULL,
  `property` varchar(128) DEFAULT NULL COMMENT '物业',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(4) DEFAULT '100',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`community_id`),
  KEY `city_id` (`city_id`,`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='小区表';

CREATE TABLE IF NOT EXISTS `bao_community_ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `title` varchar(64) DEFAULT '',
  `link_url` varchar(128) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `orderby` tinyint(1) DEFAULT '100',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_community_news` (
  `news_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `intro` varchar(1024) DEFAULT NULL,
  `details` text,
  `views` int(11) DEFAULT '0',
  `audit` tinyint(1) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_community_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `order_date` char(7) DEFAULT '2015-10',
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_community_order_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `money` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_community_order_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0' COMMENT '1水费  2电费 3燃气费 4停车费 5物业费',
  `order_id` int(10) DEFAULT '0',
  `money` int(10) DEFAULT '0',
  `bg_date` char(10) DEFAULT NULL,
  `end_date` char(10) DEFAULT NULL,
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '0未缴 1已缴',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_community_owner` (
  `owner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `name` varchar(32) DEFAULT '' COMMENT '称呼',
  `number` int(10) DEFAULT '0' COMMENT '户号',
  `location` varchar(64) DEFAULT '' COMMENT '具体地址',
  `audit` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`owner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_connect` (
  `connect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('weibo','test','weixin','qq') DEFAULT 'qq' COMMENT 'test 作为调试的时候使用！以免不懂得用户误会小弟啊',
  `open_id` varchar(32) DEFAULT NULL,
  `token` varchar(512) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`connect_id`),
  UNIQUE KEY `type` (`type`,`open_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_convenient_phone` (
  `phone_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `orderby` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`phone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_convenient_phone_maps` (
  `phone_id` int(11) DEFAULT NULL,
  `community_id` smallint(6) DEFAULT NULL,
  UNIQUE KEY `phone_id` (`phone_id`,`community_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `cate_id` smallint(6) DEFAULT NULL,
  `city_id` smallint(6) DEFAULT '0',
  `area_id` smallint(6) DEFAULT '0',
  `business_id` smallint(6) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `downloads` int(11) DEFAULT '0',
  `intro` varchar(1024) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0',
  `num` int(11) DEFAULT '9999999',
  `limit_num` tinyint(3) DEFAULT '0' COMMENT '0代表不限制',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`coupon_id`),
  KEY `cate_id` (`cate_id`,`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_coupon_download` (
  `download_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `mobile` char(11) DEFAULT NULL,
  `code` char(8) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT '0',
  `branch_id` int(11) DEFAULT '0',
  `used_time` int(11) DEFAULT NULL,
  `used_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`download_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL,
  `uid` int(10) NOT NULL,
  `idcardpic` varchar(150) DEFAULT NULL,
  `idcardpic2` varchar(150) DEFAULT NULL,
  `idcardpic3` varchar(150) DEFAULT NULL,
  `audit` int(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_delivery_cashlog` (
  `cashlog_id` int(50) NOT NULL,
  `delivery_id` int(50) NOT NULL,
  `money` int(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `account` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`cashlog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_delivery_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL COMMENT '0是商城，1是外卖，2是快件',
  `type_order_id` int(10) unsigned NOT NULL COMMENT '关联的分类中的订单编号',
  `delivery_id` int(10) unsigned NOT NULL COMMENT '配送员ID',
  `shop_id` int(10) unsigned NOT NULL,
  `city_id` int(10) NOT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `shop_name` varchar(64) NOT NULL DEFAULT '',
  `shop_addr` varchar(64) NOT NULL DEFAULT '',
  `shop_mobile` varchar(64) DEFAULT '',
  `user_name` varchar(64) NOT NULL DEFAULT '',
  `user_addr` varchar(64) NOT NULL DEFAULT '',
  `user_mobile` varchar(11) DEFAULT '',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单时间',
  `end_time` int(10) DEFAULT '0' COMMENT '完成时间 ',
  `status` tinyint(1) unsigned NOT NULL COMMENT '0是货到付款，1是已付款，2是配送中，8是已完成。',
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ele` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(64) DEFAULT NULL COMMENT '冗余方便查询',
  `city_id` smallint(5) unsigned DEFAULT NULL,
  `area_id` smallint(5) DEFAULT '0',
  `business_id` smallint(5) DEFAULT '0',
  `cate` varchar(64) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0' COMMENT '1 代表营业中',
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '1代表支持在线付款',
  `is_fan` tinyint(1) DEFAULT '0' COMMENT '1 代表返现',
  `fan_money` int(10) DEFAULT NULL,
  `is_new` tinyint(1) DEFAULT NULL,
  `full_money` int(10) DEFAULT '0' COMMENT '满多少MONEY 立刻减几元',
  `new_money` int(10) DEFAULT '0' COMMENT '减多少钱  比如说 满20减5元 那么  每增加10块钱 将额外减一元',
  `logistics` int(10) DEFAULT '0' COMMENT '0代表不收取配送费 填写其他的将代表收取',
  `since_money` int(10) DEFAULT NULL COMMENT '起送价',
  `sold_num` int(10) DEFAULT NULL,
  `month_num` int(10) DEFAULT NULL,
  `intro` varchar(1024) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100' COMMENT '数字越小排序越高',
  `distribution` tinyint(3) DEFAULT '30' COMMENT '分钟  配送时间',
  `audit` tinyint(3) unsigned DEFAULT '0' COMMENT '0审核中1成功入驻2未通过',
  `rate` int(11) DEFAULT '60' COMMENT '费率 每个商品的结算价格',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ele_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `cate_name` varchar(32) DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `closed` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`cate_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ele_dianping` (
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

CREATE TABLE IF NOT EXISTS `bao_ele_dianping_pics` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `dianping_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ele_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `addr_id` int(11) DEFAULT '0',
  `total_price` int(11) DEFAULT '0',
  `logistics` int(11) DEFAULT '0',
  `need_pay` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `new_money` int(11) DEFAULT '0',
  `fan_money` int(11) DEFAULT '0',
  `settlement_price` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0' COMMENT '1等待处理  2代表已经确认 3代表客户已经收货 8代表配送完成',
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '0是货到付款，1是在线支付',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  `audit_time` int(11) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `month` int(11) DEFAULT '201501',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ele_order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `total_price` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_ele_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(32) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `settlement_price` int(11) unsigned DEFAULT NULL,
  `is_new` tinyint(1) DEFAULT '0',
  `is_hot` tinyint(1) DEFAULT '0',
  `is_tuijian` tinyint(1) DEFAULT '0',
  `sold_num` int(11) DEFAULT '0',
  `month_num` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_email` (
  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_key` varchar(32) DEFAULT NULL,
  `email_explain` varchar(1024) DEFAULT NULL,
  `email_tmpl` text,
  `is_open` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `email_key` (`email_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_express` (
  `express_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `cid` int(10) DEFAULT '0',
  `city_id` int(10) DEFAULT '0',
  `title` varchar(64) DEFAULT NULL,
  `from_name` varchar(32) DEFAULT NULL,
  `from_addr` varchar(255) DEFAULT NULL,
  `from_mobile` varchar(11) DEFAULT NULL,
  `to_name` varchar(32) DEFAULT NULL,
  `to_addr` varchar(255) DEFAULT NULL,
  `to_mobile` varchar(11) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0未处理，1已接单，2已完成，-1已拒收',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`express_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_feedback` (
  `feed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `community_id` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `content` text,
  `reply` text,
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `reply_time` int(11) DEFAULT NULL,
  `reply_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`feed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_found` (
  `found_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `link_url` varchar(128) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`found_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_function` (
  `func_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(128) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `is_index` tinyint(1) DEFAULT '0' COMMENT '是否首页显示',
  `orderby` tinyint(3) DEFAULT '100',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`func_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `shopcate_id` int(11) DEFAULT NULL,
  `area_id` smallint(5) DEFAULT NULL,
  `business_id` smallint(5) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `city_id` varchar(64) DEFAULT NULL,
  `branch_id` varchar(64) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `wei_pic` varchar(256) DEFAULT NULL COMMENT '购物二维码',
  `price` int(11) DEFAULT NULL,
  `mall_price` int(11) DEFAULT NULL,
  `settlement_price` int(11) DEFAULT '0',
  `mobile_fan` int(11) DEFAULT '0',
  `use_integral` int(11) DEFAULT '0' COMMENT '可使用积分数',
  `sold_num` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `instructions` text,
  `details` text,
  `end_date` date DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `is_mall` tinyint(3) DEFAULT '0',
  `commission` int(11) DEFAULT '0',
  `share` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `orderby` tinyint(4) DEFAULT '100',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_goods_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `rate` int(11) DEFAULT '60' COMMENT '结算费率',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_goods_dianping` (
  `dianping_id` int(11) NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '0',
  `score` int(11) DEFAULT NULL,
  `contents` varchar(1024) DEFAULT NULL,
  `reply` varchar(1024) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `closed` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`dianping_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_goods_dianping_pics` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT '0',
  `dianping_id` int(11) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `dianping_id` (`dianping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_goods_shopcate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_housework` (
  `housework_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `svc_id` tinyint(3) DEFAULT '0',
  `svctime` varchar(20) DEFAULT NULL,
  `addr` varchar(128) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `buy_num` tinyint(3) DEFAULT '0',
  `contents` varchar(1024) DEFAULT NULL,
  `is_real` tinyint(1) DEFAULT '0' COMMENT '1代表客服已经确认过是有效的',
  `num` tinyint(3) DEFAULT '0' COMMENT '未填数字就代表使用全局的',
  `gold` tinyint(3) DEFAULT '0' COMMENT '未填数字代表应用全局的设置',
  `city_id` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`housework_id`),
  KEY `svc_id` (`svc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_housework_look` (
  `look_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `housework_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`look_id`),
  UNIQUE KEY `housework_id` (`housework_id`,`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_housework_setting` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `price` int(11) DEFAULT '0',
  `unit` varchar(32) DEFAULT NULL,
  `gongju` varchar(64) DEFAULT NULL,
  `biz_time` varchar(64) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `contents` text,
  `yuyue_num` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_huodong` (
  `huodong_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `city_id` int(10) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `intro` varchar(128) DEFAULT NULL,
  `traffic` tinyint(1) DEFAULT '0' COMMENT '交通方式',
  `limit_num` int(10) DEFAULT '0' COMMENT '限制人数，0不限制',
  `time` datetime DEFAULT '0000-00-00 00:00:00',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `addr` varchar(1024) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT '3' COMMENT '1男 2女 3不限',
  `photo` varchar(128) DEFAULT NULL,
  `sign_num` int(11) DEFAULT '0',
  `ping_num` int(10) DEFAULT '0' COMMENT '评论人数',
  `views` int(10) DEFAULT '0' COMMENT '浏览人数',
  `lat` varchar(15) DEFAULT '' COMMENT '纬度',
  `lng` varchar(15) DEFAULT '0' COMMENT '经度',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`huodong_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_huodong_dianping` (
  `dianping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `huodong_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `contents` text,
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`dianping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_huodong_looks` (
  `look_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `huodong_id` int(10) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`look_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_huodong_sign` (
  `sign_id` int(10) NOT NULL AUTO_INCREMENT,
  `huodong_id` int(11) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `num` int(5) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`sign_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_integral_exchange` (
  `exchange_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `addr_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0' COMMENT '1代表后台已经确认了那么发货是前台发货还是什么流程',
  PRIMARY KEY (`exchange_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_integral_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `face_pic` varchar(64) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `is_vip` tinyint(1) DEFAULT '0' COMMENT '1代表只能是本店的VIP 才能兑换该物品',
  `integral` int(11) DEFAULT '0',
  `price` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `limit_num` int(11) DEFAULT '0',
  `exchange_num` int(11) DEFAULT '0',
  `details` text,
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(255) DEFAULT NULL,
  `audit` tinyint(4) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0' COMMENT '1代表已经下架',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_keyword` (
  `key_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) DEFAULT NULL,
  `type` tinyint(2) DEFAULT '0' COMMENT '搜索关键字，0不限，1表示团购，2表示商家',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life` (
  `life_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `cate_id` smallint(5) DEFAULT '0',
  `city_id` smallint(5) DEFAULT '0',
  `area_id` smallint(5) DEFAULT '0',
  `business_id` smallint(5) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `is_shop` tinyint(1) DEFAULT '0',
  `text1` varchar(64) DEFAULT NULL,
  `text2` varchar(64) DEFAULT NULL,
  `text3` varchar(64) DEFAULT NULL,
  `num1` int(11) DEFAULT NULL,
  `num2` int(11) DEFAULT NULL,
  `select1` int(11) DEFAULT NULL,
  `select2` int(11) DEFAULT NULL,
  `select3` int(11) DEFAULT NULL,
  `select4` int(11) DEFAULT NULL,
  `select5` int(11) DEFAULT NULL,
  `urgent_date` date DEFAULT '0000-00-00',
  `top_date` date DEFAULT '0000-00-00',
  `photo` varchar(64) DEFAULT NULL,
  `contact` varchar(32) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `qq` varchar(15) DEFAULT NULL,
  `addr` varchar(128) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  `last_time` int(11) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`life_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life_cate` (
  `cate_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` tinyint(3) DEFAULT '0',
  `cate_name` varchar(32) DEFAULT NULL,
  `num` int(11) DEFAULT '0' COMMENT '信息数冗余',
  `text1` varchar(32) DEFAULT NULL COMMENT '文本字段一',
  `text2` varchar(32) DEFAULT NULL COMMENT '文本字段2',
  `text3` varchar(32) DEFAULT NULL,
  `num1` varchar(32) DEFAULT NULL,
  `num2` varchar(32) DEFAULT NULL COMMENT '5个text字段，如果text 字段没有设置那么就不启用',
  `unit1` varchar(32) DEFAULT NULL,
  `unit2` varchar(32) DEFAULT NULL,
  `select1` varchar(32) DEFAULT NULL,
  `select2` varchar(32) DEFAULT NULL,
  `select3` varchar(32) DEFAULT NULL,
  `select4` varchar(32) DEFAULT NULL COMMENT '多选1',
  `select5` varchar(32) DEFAULT NULL COMMENT '多选2',
  `orderby` tinyint(3) DEFAULT '100',
  `is_hot` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life_cate_attr` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(5) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `attr_name` varchar(32) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`attr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life_details` (
  `life_id` int(11) NOT NULL DEFAULT '0',
  `details` text,
  PRIMARY KEY (`life_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life_love` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `life_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `life_id` (`life_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life_photos` (
  `pic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `life_id` int(11) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_life_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `life_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_links` (
  `link_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(32) DEFAULT NULL,
  `link_url` varchar(128) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_lock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `t` char(8) DEFAULT '0' COMMENT 'UID 操作分钟级别锁',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`,`t`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market` (
  `market_id` int(11) NOT NULL AUTO_INCREMENT,
  `market_name` varchar(64) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT NULL,
  `area_id` smallint(5) DEFAULT '0',
  `business_id` smallint(5) DEFAULT '0',
  `logo` varchar(64) DEFAULT '0',
  `photo` varchar(64) DEFAULT '0',
  `type1` tinyint(1) DEFAULT '0',
  `type2` tinyint(1) DEFAULT NULL,
  `type3` tinyint(1) DEFAULT NULL,
  `type4` tinyint(1) DEFAULT NULL,
  `type5` tinyint(1) DEFAULT NULL,
  `type6` tinyint(1) DEFAULT NULL,
  `tel` varchar(64) DEFAULT NULL,
  `contact` varchar(32) DEFAULT NULL,
  `addr` varchar(64) DEFAULT NULL,
  `summary` text,
  `orderby` int(11) DEFAULT '100',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `view` int(11) DEFAULT '0',
  `tags` varchar(64) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `views` int(10) DEFAULT NULL,
  `fans_num` int(11) DEFAULT '0',
  `city_isd` smallint(5) DEFAULT '0',
  PRIMARY KEY (`market_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `market_id` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `details` text,
  `views` int(11) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market_details` (
  `market_id` int(11) NOT NULL DEFAULT '0',
  `details` text,
  `business_time` varchar(32) DEFAULT '9:00-18:00',
  `near` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`market_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market_enter` (
  `enter_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `market_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `cate_id` int(10) DEFAULT '0',
  `floor` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`enter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market_favorites` (
  `favorites_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `market_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`favorites_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market_floor` (
  `floor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `market_id` int(10) DEFAULT '0',
  `floor_name` varchar(32) DEFAULT '',
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`floor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_market_pic` (
  `pic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `market_id` int(11) DEFAULT NULL,
  `pic` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_menu` (
  `menu_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(32) DEFAULT NULL,
  `menu_action` varchar(64) DEFAULT NULL,
  `parent_id` smallint(5) DEFAULT '0',
  `orderby` tinyint(3) unsigned DEFAULT '100' COMMENT '1排序第一',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0代表不直接显示',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `type` enum('gift','coupon','movie','message') DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `intro` varchar(256) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL COMMENT '可以为空 如果为空',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `details` text,
  PRIMARY KEY (`msg_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_msg_read` (
  `read_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`read_id`),
  UNIQUE KEY `msg_id` (`msg_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `addr_id` int(11) DEFAULT '0',
  `shop_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT '0',
  `mobile_fan` int(11) DEFAULT '0',
  `use_integral` int(11) DEFAULT '0' COMMENT '订单使用积分数',
  `can_use_integral` int(11) DEFAULT '0' COMMENT '用户可以使用的积分',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '0.0.0.0',
  `update_time` int(11) DEFAULT '0',
  `update_ip` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '1代表已经付款  2代表正在配送  3客户已经确认',
  `is_daofu` tinyint(1) DEFAULT '0',
  `is_shop` tinyint(1) DEFAULT '0' COMMENT '1 代表商家发货',
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `mobile_fan` int(11) DEFAULT '0',
  `total_price` int(11) DEFAULT NULL,
  `js_price` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '1代表已经发货 2代表申请退款  3代表已经退款',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  `update_time` int(11) DEFAULT '0',
  `update_ip` varchar(15) DEFAULT NULL,
  `is_daofu` tinyint(1) DEFAULT '0',
  `tui_uid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_order_pick` (
  `pick_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `order_ids` text,
  PRIMARY KEY (`pick_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_payment` (
  `payment_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `logo` varchar(32) DEFAULT NULL,
  `code` varchar(32) DEFAULT NULL,
  `mobile_logo` varchar(32) DEFAULT NULL,
  `contents` varchar(1024) DEFAULT NULL,
  `setting` text,
  `is_mobile_only` tinyint(1) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_payment_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `type` enum('tuan','gold','money','ele','ding','fzmoney','breaks','goods') DEFAULT 'tuan',
  `order_id` int(11) DEFAULT '0',
  `order_ids` text COMMENT '如果该支付方式支持多个订单（合并付款）',
  `code` varchar(32) DEFAULT NULL,
  `need_pay` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `pay_time` int(11) DEFAULT NULL,
  `pay_ip` varchar(15) DEFAULT NULL,
  `is_paid` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_pc_function` (
  `function_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) DEFAULT '',
  `url` varchar(64) DEFAULT '',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `is_nav` tinyint(1) DEFAULT '0' COMMENT '是否导航显示，1显示，0快捷导航',
  `is_system` tinyint(1) DEFAULT '0' COMMENT '是否系统功能',
  `orderby` tinyint(3) DEFAULT '50',
  PRIMARY KEY (`function_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `cate_id` smallint(6) DEFAULT '0',
  `details` text,
  `views` int(11) DEFAULT '0',
  `reply_num` int(11) DEFAULT '0',
  `zan_num` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `last_id` int(11) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100' COMMENT '1就是第一名',
  `is_fine` tinyint(1) DEFAULT '0' COMMENT '1代表精华',
  `city_id` int(11) DEFAULT '0',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_post_pics` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) DEFAULT '0',
  `pic` varchar(128) DEFAULT '',
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_post_reply` (
  `reply_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contents` text,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`reply_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_post_zan` (
  `zan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`zan_id`),
  UNIQUE KEY `post_id` (`post_id`,`create_ip`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_push_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sendtype` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '0单发消息,1群发消息',
  `sendtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uid` int(10) unsigned DEFAULT '0',
  `contents` varchar(1024) NOT NULL,
  `type` enum('android','ios','all') NOT NULL DEFAULT 'android' COMMENT '发送平台',
  `url` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_qrcode_census` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `year` smallint(5) DEFAULT '0',
  `month` tinyint(2) DEFAULT '0',
  `day` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`user_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_quanming` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '获得佣金的用户ID',
  `buy_uid` int(11) DEFAULT '0' COMMENT '购买的用户ID',
  `rank` tinyint(4) DEFAULT '0' COMMENT '第几级会员产生的收益',
  `price` int(11) DEFAULT '0' COMMENT '对方消费多少',
  `commission` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `year` char(4) DEFAULT NULL,
  `month` char(2) DEFAULT NULL,
  `day` char(2) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `uid` (`uid`,`rank`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_recharge_card` (
  `card_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT '0',
  `card_key` char(32) DEFAULT '0',
  `value` int(10) DEFAULT '0',
  `end_date` date DEFAULT '0000-00-00',
  `is_used` tinyint(3) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `used_time` int(11) DEFAULT '0',
  PRIMARY KEY (`card_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_role_maps` (
  `role_id` smallint(5) DEFAULT NULL,
  `menu_id` smallint(5) DEFAULT NULL,
  UNIQUE KEY `role_id` (`role_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_sensitive_words` (
  `words_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `words` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`words_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_seo` (
  `seo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seo_key` varchar(32) DEFAULT NULL,
  `seo_explain` varchar(1024) DEFAULT NULL,
  `seo_title` varchar(1024) DEFAULT NULL,
  `seo_keywords` varchar(1024) DEFAULT NULL,
  `seo_desc` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`seo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_service` (
  `service_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT '',
  `intro` text,
  `orderby` tinyint(3) DEFAULT '100',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_session` (
  `session_id` char(32) NOT NULL,
  `session_expire` int(11) NOT NULL,
  `session_data` blob,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `bao_setting` (
  `k` varchar(255) DEFAULT NULL,
  `v` text,
  UNIQUE KEY `k` (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_share_cate` (
  `cate_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` smallint(5) DEFAULT NULL,
  `area_id` smallint(5) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT '0',
  `type_id` char(20) DEFAULT '0',
  `business_id` smallint(5) DEFAULT NULL,
  `shop_name` varchar(64) DEFAULT NULL,
  `logo` varchar(64) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `tel` varchar(64) DEFAULT NULL,
  `extension` varchar(8) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT '0',
  `contact` varchar(32) DEFAULT NULL,
  `addr` varchar(64) DEFAULT NULL,
  `score` tinyint(3) DEFAULT '0' COMMENT '评价',
  `score_num` int(11) DEFAULT '0',
  `fans_num` int(11) DEFAULT '0',
  `d1` tinyint(3) DEFAULT '0',
  `d2` tinyint(3) DEFAULT '0',
  `d3` tinyint(3) DEFAULT '0' COMMENT '点评项目',
  `orderby` int(11) DEFAULT '100' COMMENT '越小排序越高',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `ding_num` int(10) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `view` int(11) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0' COMMENT '1代表已经审核',
  `is_pei` tinyint(1) DEFAULT '0' COMMENT '是否商家自主配送',
  `is_ding` tinyint(1) DEFAULT '0' COMMENT '针对餐饮行业的订座',
  `is_breaks` tinyint(1) DEFAULT '0' COMMENT '优惠买单',
  `is_ele` tinyint(1) DEFAULT '0' COMMENT '外卖商家',
  `is_tuan` tinyint(1) DEFAULT '0' COMMENT '有团购',
  `is_mart` tinyint(1) DEFAULT '0' COMMENT '是否微店',
  `is_coupon` tinyint(1) DEFAULT '0' COMMENT '是否有优惠券',
  `tags` varchar(64) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `tui_uid` int(11) DEFAULT '0' COMMENT '代理商',
  PRIMARY KEY (`shop_id`),
  KEY `cate_id` (`cate_id`,`area_id`,`business_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_banner` (
  `banner_id` int(10) NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `is_mobile` tinyint(1) DEFAULT '1',
  `photo` varchar(128) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_branch` (
  `branch_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `score` tinyint(3) DEFAULT '0',
  `password` varchar(32) DEFAULT '',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `is_hot` tinyint(1) DEFAULT '0',
  `d1` varchar(32) DEFAULT '价格',
  `d2` varchar(32) DEFAULT '环境',
  `d3` varchar(32) DEFAULT '服务',
  `title` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_details` (
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `details` text,
  `theme_id` int(11) DEFAULT '0',
  `theme_expir_time` int(11) DEFAULT NULL,
  `discounts` varchar(32) DEFAULT NULL,
  `business_time` varchar(32) DEFAULT '9:00-18:00',
  `price` int(10) DEFAULT NULL,
  `near` varchar(64) DEFAULT NULL,
  `wei_pic` varchar(256) DEFAULT NULL,
  `delivery_time` tinyint(3) DEFAULT '30' COMMENT '接单倒计时（单位：分钟）',
  `is_dingyue` tinyint(1) DEFAULT '0' COMMENT '是否是订阅号',
  `app_id` varchar(32) DEFAULT NULL,
  `app_key` varchar(256) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  `weixin_msg` text,
  `menus` text,
  `seo_title` varchar(32) DEFAULT NULL,
  `seo_keywords` varchar(32) DEFAULT NULL,
  `seo_description` varchar(32) DEFAULT NULL,
  `icp` varchar(32) DEFAULT NULL,
  `sitelogo` varchar(64) DEFAULT NULL,
  `bank` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_dianping` (
  `dianping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '0',
  `evaluate` tinyint(1) DEFAULT '0' COMMENT '1表示好评，2表示中评，3表示差评',
  `score` tinyint(3) DEFAULT NULL,
  `d1` tinyint(3) DEFAULT '0',
  `d2` tinyint(3) DEFAULT '0',
  `d3` tinyint(3) DEFAULT '0',
  `cost` int(11) DEFAULT NULL,
  `contents` varchar(1024) DEFAULT NULL,
  `reply` varchar(1024) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`dianping_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_dianping_pics` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
  `dianping_id` int(11) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `dianping_id` (`dianping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_ding_cate` (
  `cate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
  `cate_name` varchar(64) DEFAULT '',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_ding_dianping` (
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

CREATE TABLE IF NOT EXISTS `bao_shop_ding_dianping_pic` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `dianping_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_ding_menu` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_ding_order` (
  `order_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
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
  `use_integral` varchar(50) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL,
  `create_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_ding_room` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `intro` varchar(64) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `last_date` date DEFAULT NULL,
  `last_t` tinyint(3) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0' COMMENT '1 代表该包厢已经不能被预定了',
  PRIMARY KEY (`room_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_ding_setting` (
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

CREATE TABLE IF NOT EXISTS `bao_shop_ding_yuyue` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_expand` (
  `expand_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `expand` tinyint(3) DEFAULT NULL,
  `intro` varchar(256) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`expand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_favorites` (
  `favorites_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `last_news_id` int(11) DEFAULT '0',
  `read_id` int(11) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`favorites_id`),
  UNIQUE KEY `user_id` (`user_id`,`shop_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_life_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `cate_id` smallint(5) unsigned NOT NULL,
  `area_id` smallint(5) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `business_id` smallint(5) unsigned NOT NULL,
  `shop_name` varchar(64) NOT NULL,
  `logo` varchar(64) NOT NULL,
  `photo` varchar(64) NOT NULL,
  `tel` varchar(64) DEFAULT NULL,
  `extension` varchar(8) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `contact` varchar(32) DEFAULT NULL,
  `addr` varchar(64) DEFAULT NULL,
  `create_ip` varchar(15) NOT NULL,
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `type` enum('yuyue','card','wei','bao') DEFAULT NULL,
  `date` date DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_money` (
  `money_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `type` enum('tuan','ele','ding','breaks','goods') DEFAULT 'tuan',
  `order_id` int(11) DEFAULT '0',
  `intro` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`money_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_news` (
  `news_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT '0',
  `cate_id` smallint(5) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `details` text,
  `create_time` int(11) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `orderby` tinyint(1) DEFAULT '50',
  `audit` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `shop_id` (`shop_id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_pic` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `audit` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_weixin_access` (
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `access_token` varchar(256) DEFAULT NULL,
  `expir_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_weixin_keyword` (
  `keyword_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT '0',
  `keyword` varchar(32) DEFAULT NULL,
  `type` enum('news','text') DEFAULT 'text' COMMENT '0普通消息 1图片消息',
  `title` varchar(128) DEFAULT NULL,
  `contents` text,
  `url` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`),
  UNIQUE KEY `shop_id` (`shop_id`,`keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_youhui` (
  `yh_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(1) DEFAULT '0' COMMENT '0：折扣，1：满减',
  `shop_id` int(10) DEFAULT '0',
  `discount` decimal(5,1) DEFAULT '0.0' COMMENT '折扣',
  `min_amount` decimal(8,2) DEFAULT '0.00' COMMENT '满多少',
  `amount` decimal(8,2) DEFAULT '0.00' COMMENT '减多少',
  `is_open` tinyint(1) DEFAULT '0' COMMENT '0关闭，1开启',
  `use_count` int(10) DEFAULT '0' COMMENT '使用次数',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`yh_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_shop_yuyue` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_sms` (
  `sms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sms_key` varchar(32) DEFAULT NULL,
  `sms_explain` varchar(1024) DEFAULT NULL,
  `sms_tmpl` varchar(2048) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`sms_id`),
  UNIQUE KEY `sms_key` (`sms_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_system_content` (
  `content_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) DEFAULT NULL,
  `contents` text,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(255) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_template` (
  `template_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `theme` varchar(32) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`template_id`),
  UNIQUE KEY `theme` (`theme`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_template_setting` (
  `theme` varchar(32) DEFAULT NULL,
  `setting` text,
  UNIQUE KEY `theme` (`theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tongji` (
  `tongji_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(12) DEFAULT NULL,
  `keyword` varchar(32) DEFAULT NULL COMMENT '超过的部分忽略',
  `type` tinyint(1) DEFAULT '0' COMMENT '1 团购  2购物  暂时只统计这两块',
  `money` int(11) DEFAULT NULL,
  `year` smallint(4) DEFAULT NULL,
  `month` char(2) DEFAULT NULL,
  `day` char(2) DEFAULT NULL,
  `date` date DEFAULT '2015-03-24',
  `is_mobile` tinyint(1) DEFAULT '0',
  `is_weixin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`tongji_id`),
  KEY `from` (`from`),
  KEY `keyword` (`keyword`),
  KEY `type` (`type`),
  KEY `year` (`year`,`month`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan` (
  `tuan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '0',
  `cate_id` smallint(6) DEFAULT NULL,
  `area_id` smallint(6) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT '0',
  `business_id` smallint(6) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `intro` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `thumb` text COMMENT '缩略图',
  `price` int(11) DEFAULT NULL,
  `tuan_price` int(11) DEFAULT NULL,
  `settlement_price` int(11) DEFAULT '0' COMMENT '结算金额',
  `use_integral` int(11) DEFAULT '0' COMMENT '代表允许使用的积分数，100积分是1RMB',
  `mobile_fan` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `sold_num` int(11) DEFAULT '0',
  `tao_num` tinyint(2) DEFAULT '0' COMMENT '套餐人数',
  `wei_pic` varchar(256) DEFAULT NULL COMMENT '抢购二维码',
  `bg_date` date DEFAULT '0000-00-00',
  `end_date` date DEFAULT NULL,
  `fail_date` date DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  `is_hot` tinyint(2) DEFAULT '0',
  `is_new` tinyint(2) DEFAULT '0',
  `is_chose` tinyint(2) DEFAULT '0',
  `is_multi` tinyint(1) DEFAULT '0' COMMENT '多店可用',
  `freebook` tinyint(2) DEFAULT '0',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `is_return_cash` tinyint(2) DEFAULT '0',
  `is_seckill` tinyint(1) DEFAULT '0',
  `kill_bg` date DEFAULT NULL,
  `kill_end` date DEFAULT NULL,
  `kill_num` int(11) DEFAULT '0',
  `kill_price` int(11) DEFAULT '0',
  PRIMARY KEY (`tuan_id`),
  KEY `cate_id` (`cate_id`,`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_cate` (
  `cate_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT NULL,
  `is_hot` tinyint(2) DEFAULT NULL,
  `rate` int(11) DEFAULT '60' COMMENT '结算费率',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_code` (
  `code_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(8) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `shop_id` int(11) DEFAULT '0',
  `branch_id` int(11) DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `tuan_id` int(11) DEFAULT '0',
  `price` int(11) DEFAULT NULL,
  `settlement_price` int(11) DEFAULT NULL,
  `real_money` int(11) DEFAULT '0' COMMENT '真实花费的MONEY',
  `real_integral` int(11) DEFAULT '0' COMMENT '真实积分',
  `fail_date` date DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `used_time` int(11) DEFAULT '0',
  `used_ip` varchar(15) DEFAULT '0.0.0.0',
  `is_used` tinyint(1) DEFAULT '0' COMMENT '1代表已经使用',
  `status` tinyint(1) DEFAULT '0' COMMENT '0代表正常，1代表申请退款中，2代表已经退款',
  PRIMARY KEY (`code_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_details` (
  `tuan_id` int(10) NOT NULL,
  `details` text,
  `instructions` text,
  PRIMARY KEY (`tuan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_dianping` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `tuan_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `contents` varchar(1024) DEFAULT NULL,
  `reply` varchar(1024) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `closed` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_dianping_pics` (
  `pic_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_meal` (
  `tuan_id` int(11) unsigned DEFAULT '0' COMMENT '主套餐',
  `id` int(11) unsigned DEFAULT '0' COMMENT '分套餐id',
  `name` varchar(64) DEFAULT NULL COMMENT '套餐名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `tuan_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `shop_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '0',
  `total_price` int(11) DEFAULT NULL,
  `use_integral` int(11) DEFAULT '0',
  `mobile_fan` int(11) DEFAULT '0',
  `need_pay` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `update_time` int(11) DEFAULT '0',
  `update_ip` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '1代表已经付款购买  -1表示到店付',
  `is_mobile` tinyint(1) DEFAULT '0' COMMENT '为了统计用',
  `is_dianping` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tuan_view` (
  `view_id` int(10) NOT NULL AUTO_INCREMENT,
  `tuan_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`view_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_tui` (
  `tui_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tui_name` varchar(64) DEFAULT NULL,
  `tui_link` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`tui_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(64) DEFAULT NULL COMMENT '邮件或者手机',
  `password` char(32) DEFAULT NULL,
  `face` varchar(128) DEFAULT NULL,
  `ext0` varchar(15) DEFAULT NULL COMMENT '为了兼容DISCUZ 设立的用户名存储的字段',
  `nickname` varchar(32) DEFAULT NULL,
  `integral` int(11) DEFAULT '0',
  `prestige` int(11) DEFAULT '0' COMMENT '声望，影响等级的',
  `money` int(11) DEFAULT '0' COMMENT '账户余额',
  `rank_id` tinyint(4) DEFAULT '1' COMMENT '等级ID',
  `gold` int(11) DEFAULT '0',
  `reg_time` int(11) DEFAULT '0',
  `reg_ip` varchar(15) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0' COMMENT '-1代表需要激活   0 代表正常  1 代表删除',
  `uc_id` int(11) DEFAULT '0',
  `email` varchar(64) DEFAULT NULL COMMENT '认证的邮件',
  `mobile` varchar(11) DEFAULT NULL COMMENT '认证的手机号码',
  `ping_num` int(11) DEFAULT '0',
  `post_num` int(11) DEFAULT '0',
  `invite1` int(11) DEFAULT NULL,
  `invite2` int(11) DEFAULT NULL,
  `invite3` int(11) DEFAULT NULL,
  `invite4` int(11) DEFAULT NULL,
  `invite5` int(11) DEFAULT NULL,
  `invite6` int(11) DEFAULT '0',
  `token` char(32) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_users_cash` (
  `cash_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0未审核1通过2拒绝',
  `reason` text,
  `account` varchar(64) DEFAULT NULL,
  `bank_name` varchar(128) DEFAULT NULL,
  `bank_num` varchar(32) DEFAULT NULL,
  `bank_branch` varchar(128) DEFAULT NULL,
  `bank_realname` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`cash_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_users_ex` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `last_uid` int(11) DEFAULT '0',
  `views` int(11) DEFAULT NULL,
  `bank_name` varchar(128) DEFAULT NULL,
  `bank_num` varchar(32) DEFAULT NULL,
  `bank_branch` varchar(128) DEFAULT NULL,
  `bank_realname` varchar(64) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT '0' COMMENT '0未知，1男，2女',
  `job` varchar(32) DEFAULT '' COMMENT '职业',
  `star_id` tinyint(2) DEFAULT '0' COMMENT '星座',
  `born_year` smallint(4) DEFAULT '0' COMMENT '出生年',
  `born_month` tinyint(2) DEFAULT '0' COMMENT '出生月',
  `born_day` tinyint(2) DEFAULT '0' COMMENT '出生日',
  `frozen_money` int(11) DEFAULT '0' COMMENT '冻结的金额',
  `frozen_date` int(11) DEFAULT '0',
  `is_tui_money` tinyint(1) DEFAULT '0' COMMENT '1代表已经发放了推广的佣金',
  `is_no_frozen` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_users_goods` (
  `record_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `goods_id` int(10) DEFAULT NULL,
  `record_time` int(11) DEFAULT NULL,
  `record_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_users_look` (
  `look_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`look_id`),
  UNIQUE KEY `user_id` (`user_id`,`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_users_visitors` (
  `visitors_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`visitors_id`),
  UNIQUE KEY `uid` (`uid`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_addr` (
  `addr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `business_id` int(11) DEFAULT '0',
  `name` varchar(32) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `addr` varchar(1024) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_num` varchar(32) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`card_id`),
  UNIQUE KEY `card_num` (`card_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_gold_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `gold` int(11) DEFAULT '0',
  `intro` varchar(64) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_integral_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `integral` int(11) DEFAULT NULL,
  `intro` varchar(256) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0' COMMENT '接收用户id',
  `from_id` int(10) DEFAULT '0' COMMENT '发送人id',
  `content` text COMMENT '消息内容',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0未读，1已读',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_money_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `money` int(11) DEFAULT '0',
  `intro` varchar(64) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_rank` (
  `rank_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(32) DEFAULT NULL,
  `icon` varchar(64) DEFAULT NULL,
  `icon1` varchar(64) DEFAULT NULL,
  `prestige` int(11) DEFAULT '0' COMMENT '需要的积分数',
  `rebate` int(10) DEFAULT '0',
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_sign` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `day` int(11) DEFAULT '0',
  `is_first` tinyint(4) DEFAULT '1',
  `last_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_user_weixin` (
  `wx_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `openid` varchar(200) DEFAULT NULL,
  `nickname` varchar(200) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `unionid` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`wx_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_vote` (
  `vote_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `is_select` tinyint(2) DEFAULT '0',
  `is_pic` tinyint(2) DEFAULT '0',
  `banner` varchar(64) DEFAULT NULL,
  `num` int(10) DEFAULT '0',
  `shop_id` int(11) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_work` tinyint(2) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_vote_option` (
  `option_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vote_id` int(11) DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `number` int(11) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_vote_result` (
  `result_id` int(10) NOT NULL AUTO_INCREMENT,
  `vote_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `vote_option` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`result_id`),
  KEY `vote_id` (`vote_id`,`create_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weidian_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT '',
  `orderby` tinyint(2) DEFAULT '50',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weidian_details` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(30) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `stime` date DEFAULT NULL,
  `ltime` date DEFAULT NULL,
  `use_tips` varchar(1024) DEFAULT '',
  `end_tips` varchar(1024) DEFAULT '',
  `end_photo` varchar(150) DEFAULT '',
  `num` mediumint(8) DEFAULT '0' COMMENT '数量',
  `max_count` mediumint(8) DEFAULT '0',
  `down_count` mediumint(8) DEFAULT '0',
  `use_count` mediumint(8) DEFAULT '0',
  `views` int(10) DEFAULT '0',
  `follower_condtion` tinyint(1) DEFAULT '0' COMMENT '关注限制，0:不限,1:必须关注',
  `member_condtion` tinyint(1) DEFAULT NULL,
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_couponsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_goldegg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predict_num` int(11) NOT NULL COMMENT '参与人数',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT '填写活动开始图片网址',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `use_tips` varchar(200) NOT NULL COMMENT '简介',
  `stime` date DEFAULT NULL COMMENT '活动开始时间',
  `ltime` date DEFAULT NULL COMMENT '活动结束时间',
  `info` varchar(200) NOT NULL COMMENT '活动说明',
  `aginfo` varchar(200) NOT NULL COMMENT '重复抽奖回复',
  `end_tips` varchar(60) NOT NULL COMMENT '活动结束公告主题',
  `end_photo` varchar(100) NOT NULL,
  `fist` varchar(50) NOT NULL COMMENT '一等奖奖品设置',
  `fistnums` int(4) NOT NULL COMMENT '一等奖奖品数量',
  `fistlucknums` int(1) NOT NULL COMMENT '一等奖中奖号码',
  `second` varchar(50) NOT NULL COMMENT '二等奖奖品设置',
  `secondnums` int(4) NOT NULL,
  `secondlucknums` int(1) NOT NULL,
  `third` varchar(50) NOT NULL,
  `thirdnums` int(4) NOT NULL,
  `thirdlucknums` int(1) NOT NULL,
  `joinnum` int(10) DEFAULT NULL,
  `max_num` int(2) NOT NULL COMMENT '个人限制抽奖次数',
  `parssword` int(15) NOT NULL COMMENT '兑奖密码',
  `four` varchar(50) NOT NULL,
  `fournums` int(11) NOT NULL,
  `fourlucknums` int(11) NOT NULL,
  `five` varchar(50) NOT NULL,
  `fivenums` int(11) NOT NULL,
  `fivelucknums` int(11) NOT NULL,
  `six` varchar(50) NOT NULL COMMENT '六等奖',
  `sixnums` int(11) NOT NULL,
  `sixlucknums` int(11) NOT NULL,
  `daynums` mediumint(4) NOT NULL DEFAULT '0',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `follower_condtion` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`shop_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_goldeggsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `egg_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(11) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `isegg` tinyint(1) DEFAULT NULL,
  `prize` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `predict_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预计参与人数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '每人最多允许抽奖次数',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`help_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_helplist` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `help_id` mediumint(8) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `zhuliid` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_helpprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `help_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'wx_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_helpsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `help_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `zhuanfa` mediumint(8) DEFAULT '0',
  `zhuli` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_keyword` (
  `keyword_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) DEFAULT NULL,
  `type` enum('news','text') DEFAULT 'text' COMMENT '0普通消息 1图片消息',
  `title` varchar(128) DEFAULT NULL,
  `contents` text,
  `url` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_lottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predict_num` int(11) NOT NULL COMMENT '参与人数',
  `views` int(11) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `keyword` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT '填写活动开始图片网址',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `txt` varchar(60) NOT NULL COMMENT '用户输入兑奖时候的显示信息',
  `use_tips` varchar(200) NOT NULL COMMENT '简介',
  `stime` date DEFAULT NULL COMMENT '活动开始时间',
  `ltime` date DEFAULT NULL COMMENT '活动结束时间',
  `info` varchar(200) NOT NULL COMMENT '活动说明',
  `aginfo` varchar(200) NOT NULL COMMENT '重复抽奖回复',
  `end_tips` varchar(60) NOT NULL COMMENT '活动结束公告主题',
  `end_photo` varchar(100) NOT NULL,
  `fist` varchar(50) NOT NULL COMMENT '一等奖奖品设置',
  `fistnums` int(4) NOT NULL COMMENT '一等奖奖品数量',
  `fistlucknums` int(1) NOT NULL COMMENT '一等奖中奖号码',
  `second` varchar(50) NOT NULL COMMENT '二等奖奖品设置',
  `secondnums` int(4) NOT NULL,
  `secondlucknums` int(1) NOT NULL,
  `third` varchar(50) NOT NULL,
  `thirdnums` int(4) NOT NULL,
  `thirdlucknums` int(1) NOT NULL,
  `allpeople` varchar(30) NOT NULL DEFAULT '' COMMENT '预计活动人数',
  `joinnum` int(10) DEFAULT NULL,
  `max_num` int(2) NOT NULL COMMENT '个人限制抽奖次数',
  `parssword` int(15) NOT NULL COMMENT '兑奖密码',
  `four` varchar(50) NOT NULL,
  `fournums` int(11) NOT NULL,
  `fourlucknums` int(11) NOT NULL,
  `five` varchar(50) NOT NULL,
  `fivenums` int(11) NOT NULL,
  `fivelucknums` int(11) NOT NULL,
  `six` varchar(50) NOT NULL COMMENT '六等奖',
  `sixnums` int(11) NOT NULL,
  `sixlucknums` int(11) NOT NULL,
  `daynums` mediumint(4) NOT NULL DEFAULT '0',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `follower_condtion` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`shop_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_lotterysn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lottery_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `islottery` tinyint(1) DEFAULT NULL,
  `prize` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FromUserName` varchar(64) DEFAULT NULL,
  `ToUserName` varchar(64) DEFAULT NULL,
  `Content` varchar(1024) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_packet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `title` char(40) NOT NULL,
  `keyword` char(30) NOT NULL,
  `msg_pic` char(120) NOT NULL,
  `desc` varchar(200) NOT NULL,
  `info` text NOT NULL,
  `start_time` char(11) NOT NULL,
  `end_time` char(11) NOT NULL,
  `ext_total` mediumint(8) unsigned NOT NULL,
  `get_number` smallint(5) unsigned NOT NULL,
  `value_count` mediumint(8) unsigned NOT NULL,
  `is_open` enum('0','1') NOT NULL,
  `item_num` mediumint(9) NOT NULL,
  `item_sum` mediumint(9) NOT NULL,
  `item_max` mediumint(9) NOT NULL,
  `item_unit` varchar(30) NOT NULL,
  `packet_type` enum('1','2') NOT NULL,
  `deci` smallint(6) NOT NULL,
  `people` mediumint(9) NOT NULL,
  `password` char(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_packetling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `open_id` char(50) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `price` char(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `type_name` char(45) NOT NULL,
  `time` char(11) NOT NULL,
  `sn_id` text NOT NULL,
  `mobile` char(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_packetling_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `open_id` char(50) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `price` char(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `type_name` char(45) NOT NULL,
  `time` char(11) NOT NULL,
  `sn_id` text NOT NULL,
  `mobile` char(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_packetsn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `add_time` char(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `packet_id` int(11) NOT NULL,
  `prize_id` int(11) NOT NULL,
  `prize_name` char(40) NOT NULL,
  `worth` decimal(10,2) NOT NULL,
  `is_reward` enum('0','1','2') NOT NULL,
  `type` enum('1','2') NOT NULL,
  `code` char(40) NOT NULL,
  `open_id` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `scratch_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'shop_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_qrcode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0',
  `soure_id` smallint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_relay` (
  `relay_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '分享图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `relay_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分享用户参加次数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '每人最多允许次数',
  `max_gold` mediumint(8) DEFAULT NULL,
  `min_gold` mediumint(8) DEFAULT '30',
  `time` mediumint(8) DEFAULT '30',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`relay_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_relaylist` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `relay_id` mediumint(8) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `jieliid` varchar(50) DEFAULT NULL,
  `gold` mediumint(8) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_relayprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `relay_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'shop_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_relaysn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `relay_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `cishu` mediumint(8) DEFAULT '0',
  `gold` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_scratch` (
  `scratch_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `predict_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预计参与人数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '每人最多允许抽奖次数',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`scratch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_scratchsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scratch_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `prize_id` int(10) DEFAULT NULL,
  `prize_title` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_shake` (
  `shake_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `predict_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预计参与人数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '每人最多允许抽奖次数',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`shake_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_shakeprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shake_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'wx_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_shakesn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shake_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` varchar(30) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `prize_id` int(10) DEFAULT NULL,
  `prize_title` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_weixin_tmpl` (
  `tmpl_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '模板标题',
  `serial` varchar(255) DEFAULT NULL COMMENT '模板系统编号',
  `template_id` varchar(255) DEFAULT NULL COMMENT '模板应用ID',
  `info` varchar(255) DEFAULT NULL COMMENT '模板介绍',
  `sort` tinyint(4) unsigned DEFAULT NULL COMMENT '排序',
  `status` tinyint(4) DEFAULT NULL COMMENT '模板介绍',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`tmpl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_work` (
  `work_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `area_id` smallint(5) DEFAULT '0',
  `city_id` smallint(5) DEFAULT '0',
  `business_id` smallint(5) DEFAULT '0',
  `money1` int(11) DEFAULT '0' COMMENT '起步MONEY',
  `money2` int(11) DEFAULT '0' COMMENT '封顶MONEY',
  `num` tinyint(4) DEFAULT '0' COMMENT '0代表若干',
  `intro` varchar(1024) DEFAULT NULL,
  `work_time` varchar(32) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `expir_date` date DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `audit` tinyint(1) DEFAULT '0' COMMENT '1 代表显示',
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`work_id`),
  KEY `shop_id` (`shop_id`),
  KEY `lng` (`lng`,`lat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_zhuan` (
  `zhuan_id` int(10) NOT NULL AUTO_INCREMENT,
  `map_id` tinyint(4) DEFAULT NULL,
  `goods_id` int(10) NOT NULL,
  `floor_id` tinyint(4) NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `deadline` int(10) NOT NULL COMMENT '到期时间',
  PRIMARY KEY (`zhuan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_zhuan_config` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_zhuan_floor` (
  `floor_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(11) DEFAULT NULL COMMENT '11',
  `sort` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0:删除,1:正常',
  PRIMARY KEY (`floor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `bao_zhuan_map` (
  `map_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '专题ID',
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0:不启用，1:启用',
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
