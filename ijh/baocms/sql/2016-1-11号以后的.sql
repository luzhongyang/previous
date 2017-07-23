ALTER TABLE `bao_payment_logs`
MODIFY COLUMN `type`  enum('tuan','gold','money','ele','ding','fzmoney','breaks','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `user_id`;

ALTER TABLE `bao_shop_money`
MODIFY COLUMN `type`  enum('tuan','ele','ding','breaks','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `create_ip`;


ALTER TABLE `bao_shop`
ADD COLUMN `is_breaks`  tinyint(1) NULL DEFAULT 0 COMMENT '优惠买单' AFTER `is_ding`,
ADD COLUMN `is_ele`  tinyint(1) NULL DEFAULT 0 COMMENT '外卖商家' AFTER `is_breaks`,
ADD COLUMN `is_tuan`  tinyint(1) NULL DEFAULT 0 COMMENT '有团购' AFTER `is_ele`,
ADD COLUMN `is_mart`  tinyint(1) NULL DEFAULT 0 COMMENT '是否微店' AFTER `is_tuan`,
ADD COLUMN `is_coupon`  tinyint(1) NULL DEFAULT 0 COMMENT '是否有优惠券' AFTER `is_mart`;


DROP TABLE IF EXISTS `bao_shop_youhui`;
CREATE TABLE `bao_shop_youhui` (
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_function`;
CREATE TABLE `bao_function` (
  `func_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(128) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `is_index` tinyint(1) DEFAULT '0' COMMENT '是否首页显示',
  `orderby` tinyint(3) DEFAULT '100',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`func_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_breaks_order`;
CREATE TABLE `bao_breaks_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `amount` decimal(8,2) DEFAULT '0.00',
  `exception` decimal(8,2) DEFAULT '0.00',
  `need_pay`  decimal(8,2) DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '0未支付，1已支付',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_service`;
CREATE TABLE `bao_service` (
  `service_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT '',
  `intro` text,
  `orderby` tinyint(3) DEFAULT '100',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_pc_function`;
CREATE TABLE `bao_pc_function` (
  `function_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) DEFAULT '',
  `url` varchar(64) DEFAULT '',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `is_nav` tinyint(1) DEFAULT '0' COMMENT '是否导航显示，1显示，0快捷导航',
  `is_system` tinyint(1) DEFAULT '0' COMMENT '是否系统功能',
  `orderby` tinyint(3) DEFAULT '50',
  PRIMARY KEY (`function_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO bao_function VALUES
(1, '2016/01/12/5694b97d6c3c6.png', '抢购', 'tuan/index', 1, 1, 1452587413, '127.0.0.1'),
(2, '2016/01/12/5694b9c6ccb84.png', '外卖', 'ele/index', 1, 2, 1452587479, '127.0.0.1'),
(3, '2016/01/12/5694b9efaec5e.png', '购物', 'mall/index', 1, 3, 1452587506, '127.0.0.1'),
(4, '2016/01/12/5694ba09d4bc6.png', '家政', 'housekeeping/main', 1, 12, 1452736885, '127.0.0.1'),
(5, '2016/01/12/5694ba7bc348a.png', '订座', 'ding/index', 1, 5, 1452587647, '127.0.0.1'),
(6, '2016/01/12/5694ba962c0a7.png', '约会', 'hdmobile/index', 1, 6, 1452587673, '127.0.0.1'),
(7, '2016/01/12/5694bab6bff50.png', '优惠券', 'coupon/index', 1, 7, 1452587710, '127.0.0.1'),
(8, '2016/01/12/5694badcbe88d.png', '逛街', 'market/index', 1, 8, 1452587744, '127.0.0.1'),
(9, '2016/01/12/5694bb1f72ce3.png', '1元云购', 'cloud/index', 1, 9, 1452587809, '127.0.0.1'),
(10, '2016/01/12/5694bb3609686.png', '微店', 'mart/index', 0, 10, 1452587832, '127.0.0.1'),
(11, '2016/01/12/5694bba89f33a.png', '生活信息', 'life/index', 1, 11, 1452587960, '127.0.0.1'),
(12, '2016/01/12/5694bbd03ed4b.png', '商家服务', 'shop/index', 1, 4, 1452736900, '127.0.0.1'),
(13, '2016/01/12/5694bbfb258d1.png', '积分商城', 'jifen/index', 1, 13, 1452588071, '127.0.0.1'),
(14, '2016/01/12/5694bc3c63bdd.png', '全民推广', 'extend/index', 1, 14, 1452588103, '127.0.0.1'),
(15, '2016/01/12/5694bc76a4469.png', '活动', 'huodong/index', 1, 15, 1452588160, '127.0.0.1'),
(16, '2016/01/12/5694bc957363b.png', '榜单', 'billboard/index', 1, 16, 1452588189, '127.0.0.1'),
(17, '2016/01/12/5694bcb75a3a6.png', '附近工作', 'nearwork/index', 1, 17, 1452588217, '127.0.0.1'),
(18, '2016/01/14/569778c2d2532.png', '贴吧', 'post/index', 1, 5, 1452767429, '127.0.0.1');

INSERT INTO bao_pc_function VALUES
(1, '首页', 'pchome/index/index', 1, 1, 1, 1),
(2, '商家', 'pchome/shop/index', 1, 1, 1, 2),
(3, '抢购', 'pchome/tuan/index', 1, 1, 1, 3),
(4, '活动', 'pchome/huodong/index', 1, 1, 1, 4),
(5, '上门服务', 'pchome/lifeservice/index', 1, 1, 1, 5),
(6, '本地商城', 'pchome/mall/index', 1, 1, 1, 6),
(7, '外卖', 'pchome/ele/index', 1, 1, 1, 7),
(8, '订座', 'pchome/ding/index', 1, 1, 1, 8),
(9, '同城信息', 'pchome/life/main', 1, 0, 1, 9),
(10, '优惠券', 'pchome/coupon/index', 1, 1, 1, 10),
(11, '积分商城', 'pchome/jifen/index', 1, 0, 1, 11),
(12, '贴吧', 'pchome/post/index', 1, 1, 1, 12),
(13, '商家榜单', 'pchome/billboard/index', 1, 0, 1, 13),
(14, '商家新闻', 'pchome/news/index', 1, 0, 1, 14),
(15, '一元云购', 'pchome/cloud/index', 1, 0, 1, 15),
(16, '文章资讯', 'pchome/sarticle/index', 1, 0, 1, 16);