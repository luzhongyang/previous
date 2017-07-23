--<?php exit("Access Denied");?>
DROP TABLE IF EXISTS `jh_fenxiao`;
CREATE TABLE IF NOT EXISTS `jh_fenxiao` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_sid` int(10) unsigned DEFAULT '0' COMMENT '上级sid',
  `shop_id` int(10) DEFAULT '0',
  `uid` int(10) DEFAULT '0',
  `shop_name` varchar(32) DEFAULT '' COMMENT 'shop表商户的名称',
  `title` varchar(32) DEFAULT '' COMMENT '当前小店的名字',
  `photo` varchar(128) DEFAULT '',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核状态 0未审核，1通过，2拒绝',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `money` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '分销店铺店主余额',
  `orders` int(10) unsigned DEFAULT '0' COMMENT '订单总数',
  `orders_amount` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '所有订单金额',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_fenxiao_account`;
CREATE TABLE IF NOT EXISTS `jh_fenxiao_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `real_name` varchar(32) DEFAULT '' COMMENT '真实姓名',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `card_no` varchar(32) NOT NULL COMMENT '身份证号码',
  `account_type` varchar(80) DEFAULT NULL COMMENT '帐户类型，如支付宝、工商银行等',
  `account_number` varchar(100) DEFAULT '' COMMENT '帐号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_fenxiao_collect`;
CREATE TABLE IF NOT EXISTS `jh_fenxiao_collect` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分销店铺ID',
  PRIMARY KEY (`collect_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_fenxiao_log`;
CREATE TABLE IF NOT EXISTS `jh_fenxiao_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(10) unsigned DEFAULT '0',
  `uid` int(10) unsigned DEFAULT '0',
  `money` decimal(8,2) DEFAULT '0.00',
  `intro` varchar(128) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_fenxiao_member`;
CREATE TABLE IF NOT EXISTS `jh_fenxiao_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(10) unsigned DEFAULT '0' COMMENT '分销店铺ID',
  `invite1` int(10) unsigned DEFAULT '0' COMMENT '一级上线（sid店铺店主自身）',
  `invite2` int(10) unsigned DEFAULT '0' COMMENT '二级上线',
  `invite3` int(10) unsigned DEFAULT '0' COMMENT '三级上线',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_fenxiao_tixian`;
CREATE TABLE IF NOT EXISTS `jh_fenxiao_tixian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` mediumint(8) unsigned DEFAULT '0' COMMENT '分销店铺ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '提现金额',
  `intro` varchar(255) DEFAULT '' COMMENT '体现描述',
  `account_info` varchar(512) DEFAULT '' COMMENT '提现帐号信息',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态,0:待处理,1:通过,2:拒绝',
  `reason` varchar(255) DEFAULT NULL COMMENT '拒绝原因',
  `updatetime` int(10) DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
