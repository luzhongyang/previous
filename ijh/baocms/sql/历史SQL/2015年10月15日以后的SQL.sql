ALTER TABLE `bao_users_cash`
ADD COLUMN `bank_name`  varchar(128) NULL AFTER `account`,
ADD COLUMN `bank_num`  varchar(32) NULL AFTER `bank_name`,
ADD COLUMN `bank_branch`  varchar(128) NULL AFTER `bank_num`,
ADD COLUMN `bank_realname`  varchar(64) NULL AFTER `bank_branch`;

ALTER TABLE `bao_users_ex`
MODIFY COLUMN `bank_name`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `views`,
MODIFY COLUMN `bank_num`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `bank_name`,
MODIFY COLUMN `bank_branch`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `bank_num`,
MODIFY COLUMN `bank_realname`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `bank_branch`;


ALTER TABLE `bao_goods`
ADD COLUMN `use_integral`  int(11) NULL DEFAULT 0 COMMENT '可使用积分数';

ALTER TABLE `bao_order`
ADD COLUMN `use_integral`  int(11) NULL DEFAULT 0 COMMENT '订单使用积分数' ,
ADD COLUMN `can_use_integral`  int(11) NULL DEFAULT 0 COMMENT '可使用的积分数' ;


ALTER TABLE `bao_goods_cate`
ADD COLUMN `rate`  int NULL DEFAULT 60 COMMENT '结算费率';

ALTER TABLE `bao_tuan_cate`
ADD COLUMN `rate`  int NULL DEFAULT 60 COMMENT '结算费率';



ALTER TABLE `bao_shop_ding_order`
ADD COLUMN `shop_id`  int NULL DEFAULT 0 AFTER `order_id`;

ALTER TABLE `bao_delivery_order`
ADD COLUMN `city_id`  int(10) NOT NULL AFTER `shop_id`,
ADD COLUMN `lat`  varchar(15) NULL AFTER `city_id`,
ADD COLUMN `lng`  varchar(15) NULL AFTER `lat`,
MODIFY COLUMN `type`  tinyint(1) UNSIGNED NOT NULL COMMENT '0是商城，1是外卖，2是快件' AFTER `order_id`,
MODIFY COLUMN `update_time`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '接单时间' AFTER `create_time`,
ADD COLUMN `end_time`  int(10) NULL DEFAULT 0 COMMENT '完成时间 ' AFTER `update_time`;


ALTER TABLE `bao_shop_details`
ADD COLUMN `delivery_time`  tinyint(3) NULL DEFAULT 30 COMMENT '接单倒计时（单位：分钟）';


ALTER TABLE `bao_ele`
ADD COLUMN `rate`  int NULL DEFAULT 60 COMMENT '费率 每个商品的结算价格';


DROP TABLE IF EXISTS `bao_housework_setting`;
CREATE TABLE `bao_housework_setting` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `price` int(11) DEFAULT '0',
  `unit` varchar(32) DEFAULT NULL,
  `gongju` varchar(64) DEFAULT NULL,
  `biz_time` varchar(64) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `contents` text,
  `yuyue_num` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_express`;
CREATE TABLE `bao_express` (
  `express_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `city_id` int(10) DEFAULT '0',
  `area_id` int(10) DEFAULT '0',
  `business_id` int(10) DEFAULT '0',
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
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`express_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_quanming`;
CREATE TABLE `bao_quanming` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `bao_users`
ADD COLUMN `invite1`  int NULL AFTER `post_num`,
ADD COLUMN `invite2`  int NULL AFTER `invite1`,
ADD COLUMN `invite3`  int NULL AFTER `invite2`,
ADD COLUMN `invite4`  int NULL AFTER `invite3`,
ADD COLUMN `invite5`  int NULL AFTER `invite4`,
CHANGE COLUMN `invite_id` `invite6`  int(11) NULL DEFAULT 0 AFTER `invite5`;

