--微商城类订单,添加到order: weidian--
ALTER TABLE  `jh_order` CHANGE  `from`  `from` ENUM(  'tuan',  'waimai',  'paotui',  'maidan',  'weixiu',  'house',  'mall',  'weidian',  'other' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单类型： tuan:团购,waimai:外卖,paotui:跑腿,weixiu:维修,maidan:买单,house:家政,weidian:微商城'

--主订单表增加coupon_id和coupon字段
ALTER TABLE `jh_order`
ADD COLUMN `coupon_id` int(10) NULL DEFAULT 0 COMMENT '店铺优惠券ID' AFTER `closed`,
ADD COLUMN `coupon` decimal(8,2) NULL DEFAULT 0.00 COMMENT '店铺优惠券抵扣金额' AFTER `coupon_id`;




--新增商家优惠券表

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_shop_coupon
-- ----------------------------
DROP TABLE IF EXISTS `jh_shop_coupon`;
CREATE TABLE `jh_shop_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠券ID',
  `shop_id` mediumint(8) DEFAULT '0',
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单最小金额, 满足金额才能使用',
  `coupon_amount` decimal(8,2) DEFAULT '0.00' COMMENT '券面值',
  `stime` int(10) DEFAULT '0' COMMENT '有效期开始时间',
  `ltime` int(10) DEFAULT '0' COMMENT '有效期过期时间',
  `use_count` smallint(6) DEFAULT '0' COMMENT '使用了次数',
  `sku` int(10) DEFAULT '0' COMMENT '库存数，剩余数量',
  `orderby` smallint(6) DEFAULT '0' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '删除标识  0：未删除 1：已删除  当券过期或全部被使用过时可删除',
  `picked` int(10) unsigned DEFAULT '0' COMMENT '被领取的数量',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='店铺优惠券';



--新增用户优惠券表

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_member_coupon
-- ----------------------------
DROP TABLE IF EXISTS `jh_member_coupon`;
CREATE TABLE `jh_member_coupon` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) NOT NULL DEFAULT '0',
  `uid` mediumint(8) NOT NULL DEFAULT '0',
  `use_time` int(10) DEFAULT '0' COMMENT '使用时间',
  `order_id` int(10) DEFAULT '0' COMMENT '使用时的订单ID',
  `status` tinyint(1) DEFAULT '0' COMMENT '使用状态 0：未使用 1：已使用',
  `dateline` int(10) DEFAULT '0' COMMENT '优惠券领取时间',
  `ltime` int(10) DEFAULT '0' COMMENT '过期时间冗余，优惠券一旦有用户领取，商家不应该再可以修改优惠券的过期时间。',
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单最小金额, 满足金额才能使用',
  `coupon_amount` decimal(8,2) DEFAULT '0.00' COMMENT '券面值',
  `shop_id` int(10) DEFAULT '0',
  PRIMARY KEY (`cid`,`coupon_id`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=utf8;


--商户表新增微店开通字段
ALTER TABLE `jh_shop`
ADD COLUMN `have_weidian`  tinyint(1) NULL DEFAULT 0 COMMENT '石否开通微店' AFTER `dateline`;


--新增微分销开通字段
ALTER TABLE `jh_shop`
ADD COLUMN `have_fenxiao`  tinyint(1) NULL DEFAULT 0 COMMENT '是否开通分销，0关闭，123为开通的分销级别' AFTER `have_weidian`;




--新增微店活动表

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jh_weidian_huodong
-- ----------------------------
DROP TABLE IF EXISTS `jh_weidian_huodong`;
CREATE TABLE `jh_weidian_huodong` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(64) DEFAULT '' COMMENT '标题',
  `stime` int(10) unsigned DEFAULT '0' COMMENT '活动开始时间',
  `ltime` int(10) unsigned DEFAULT '0' COMMENT '活动结束时间',
  `link` varchar(255) DEFAULT '' COMMENT '外链',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `jh_weidian_product`
MODIFY COLUMN `sales`  int(10) UNSIGNED NULL DEFAULT 0 COMMENT '销量' AFTER `intro`,
MODIFY COLUMN `stock`  int(10) UNSIGNED NULL DEFAULT 0 COMMENT '库存' AFTER `sales`;

