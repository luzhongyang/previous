ALTER TABLE  `jh_payment_log` CHANGE  `from`  `from` ENUM(  'money',  'order',  'paotui',  'coin',  'cloud',  'yzbill',  'cashier' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT  '类型';


CREATE TABLE IF NOT EXISTS `jh_cashier_order` (
  `po_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '订单号',
  `shop_id` int(10) DEFAULT '0' COMMENT '商铺id',
  `trade_no` varchar(50) DEFAULT '',
  `order_type` tinyint(1) DEFAULT '1' COMMENT '订单类型, 1:微信, 2:支付宝',
  `wx_url` varchar(255) DEFAULT NULL COMMENT '微信支付网址',
  `ali_url` varchar(255) DEFAULT NULL COMMENT '支付宝支付网址',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '支付金额',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '支付状态, 0:未支付,1:已支付 -1已退款',
  `pay_desc` varchar(255) DEFAULT NULL COMMENT '收款理由',
  `pay_shop` varchar(30) DEFAULT NULL COMMENT '收款方',
  `clientip` varchar(15) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`po_id`),
  KEY `pay_status` (`pay_status`,`dateline`),
  KEY `shop_id` (`shop_id`),
  KEY `trade_no` (`trade_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='扫码支付订单表' AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `jh_cashier_order_wxpay` (
  `detail_id` int(10) NOT NULL AUTO_INCREMENT,
  `po_id` int(10) DEFAULT '0' COMMENT '收银id',
  `appid` varchar(30) DEFAULT '',
  `attach` text COMMENT 'json格式数据',
  `bank_type` varchar(10) DEFAULT '',
  `cash_fee` int(10) DEFAULT '0',
  `fee_type` varchar(10) DEFAULT '',
  `is_subscribe` varchar(10) DEFAULT '',
  `mch_id` varchar(30) DEFAULT '',
  `nonce_str` varchar(50) DEFAULT '' COMMENT '微信:nonce_str',
  `openid` varchar(50) DEFAULT NULL,
  `out_trade_no` varchar(50) DEFAULT NULL,
  `result_code` varchar(30) DEFAULT '',
  `return_code` varchar(30) DEFAULT '',
  `return_msg` varchar(30) DEFAULT '',
  `sign` varchar(50) DEFAULT '',
  `time_end` varchar(20) DEFAULT NULL,
  `total_fee` int(10) DEFAULT '0',
  `trade_state` varchar(20) DEFAULT NULL,
  `trade_type` varchar(20) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL COMMENT '第三方交易id',
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '0:未支付,1:支付成功',
  `is_back` tinyint(1) DEFAULT '0' COMMENT '0:无退款,1:已退款',
  `back_time` varchar(20) DEFAULT NULL COMMENT '退款时间',
  `back_info` text COMMENT '退款信息详情',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单详情-支付信息' AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `jh_cashier_order_alipay` (
  `detail_id` int(10) NOT NULL AUTO_INCREMENT,
  `po_id` int(10) DEFAULT '0' COMMENT '收银id',
  `code` varchar(10) DEFAULT NULL COMMENT '支付宝:返回code',
  `msg` varchar(30) DEFAULT NULL COMMENT '支付宝:msg',
  `buyer_logon_id` varchar(50) DEFAULT NULL,
  `buyer_pay_amount` varchar(50) DEFAULT NULL,
  `buyer_user_id` varchar(50) DEFAULT NULL,
  `fund_bill_list` text COMMENT 'json格式化数据',
  `gmt_payment` varchar(30) DEFAULT NULL COMMENT '支付时间',
  `invoice_amount` varchar(20) DEFAULT NULL,
  `open_id` varchar(50) DEFAULT NULL,
  `out_trade_no` varchar(50) DEFAULT '0',
  `point_amount` float(10,2) DEFAULT '0.00',
  `receipt_amount` float(10,2) DEFAULT '0.00',
  `total_amount` float(10,2) DEFAULT '0.00' COMMENT '总金额',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '第三方交易id,类似危险transaction_id ',
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '0:未支付,1:支付成功',
  `is_back` tinyint(1) DEFAULT '0' COMMENT '0:无退款,1:已退款',
  `back_time` varchar(20) DEFAULT NULL COMMENT '退款时间',
  `back_info` text COMMENT '退款信息详情',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单详情-支付信息' AUTO_INCREMENT=0 ;
