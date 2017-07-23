--<?php exit("Access Denied");?>
DROP TABLE IF EXISTS `jh_weidian_pintuan_group`;
CREATE TABLE IF NOT EXISTS `jh_weidian_pintuan_group` (
  `group_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '组团ID,主键,递增',
  `city_id` smallint(6) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `group_title` varchar(255) NOT NULL COMMENT '拼团标题',
  `user_num` int(10) DEFAULT '3' COMMENT '成团人数,来源产品表成团人数',
  `master_id` int(10) DEFAULT NULL COMMENT '团长用户id',
  `start_time` int(10) DEFAULT '0' COMMENT '开团时间',
  `end_time` int(10) DEFAULT '0' COMMENT '结束时间',
  `order_count` int(10) DEFAULT '0' COMMENT '订单数量',
  `order_success_count` int(10) DEFAULT '0' COMMENT '成功订单数量',
  `order_yongjin_count` int(10) unsigned DEFAULT '0' COMMENT '支付佣金人数',
  `product_id` int(10) DEFAULT '0' COMMENT '团产品id',
  `status` tinyint(1) DEFAULT '0' COMMENT '组团状态  0: 组团中  1:组团成功  2: 组团失败 3:团完成(商家点结束))',
  `is_update_price` tinyint(1) DEFAULT '0' COMMENT '阶梯团成功,更新订单的价格 0:未更新,1已更新',
  `confirm_time` int(10) DEFAULT '0' COMMENT '商户确认时间, status由1变为3的时间',
  `confirm_reason` varchar(255) DEFAULT '' COMMENT '商户确认原因,失败要填',
  `money_pre` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '预付款,产品表的预付款记录',
  `tuan_type` tinyint(1) DEFAULT '0' COMMENT '团类型  0:普通团  1:阶梯团(值为1则 user_num 0 和 tuan_price 读取最高阶梯价格)',
  `closed` tinyint(1) DEFAULT '0' COMMENT '1:删除,0:正常',
  `clientip` varchar(15) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `master_id` (`master_id`),
  KEY `city_id` (`city_id`,`shop_id`),
  KEY `pintuan_product_id` (`product_id`),
  KEY `status` (`status`),
  KEY `master_id_2` (`master_id`),
  KEY `user_num` (`user_num`),
  KEY `end_time` (`end_time`),
  KEY `closed` (`closed`),
  KEY `is_update_price` (`is_update_price`),
  KEY `tuan_type` (`tuan_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='组团(组团开启后生成, 和团订单 tuan_order 是一对多关系)' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_pintuan_group_level`;
CREATE TABLE IF NOT EXISTS `jh_weidian_pintuan_group_level` (
  `level_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `group_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL COMMENT '团产品id,',
  `level` smallint(3) DEFAULT '1' COMMENT '团级别',
  `user_num` int(10) DEFAULT '1' COMMENT '成团人数   3表示 达到3人的价格,  10表示达到10人的价格, 如果是7人,则调用3人的价格',
  `price` decimal(8,2) DEFAULT '0.00' COMMENT '单价',
  PRIMARY KEY (`level_id`),
  KEY `tuan_product_id` (`product_id`),
  KEY `level` (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_pintuan_order`;
CREATE TABLE IF NOT EXISTS `jh_weidian_pintuan_order` (
  `order_id` int(10) unsigned NOT NULL,
  `product_name` varchar(150) DEFAULT '' COMMENT '商品名称',
  `product_number` mediumint(8) DEFAULT '0' COMMENT '商品数量',
  `product_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品总价',
  `tuan_time` smallint(3) DEFAULT NULL COMMENT '成团有效期,  默认3, 单位天, 2位数,最大99, ',
  `money_master` decimal(8,2) DEFAULT NULL COMMENT '团长佣金',
  `money_master_paid` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '支付佣金',
  `money_master_time` int(10) NOT NULL DEFAULT '0' COMMENT '佣金支付时间',
  `spend_number` varchar(16) DEFAULT '' COMMENT '自提单核销密码',
  `spend_status` tinyint(1) DEFAULT '0' COMMENT '自提单核销状态',
  `freight` decimal(6,2) DEFAULT '0.00' COMMENT '运费',
  `group_id` int(10) DEFAULT '0' COMMENT '组团ID',
  `uid` int(10) DEFAULT '0' COMMENT '用于关联 jh_pintuan_group 表',
  `is_money_pre` tinyint(1) DEFAULT '0' COMMENT '0:全款,1:预付款',
  `money_need_pay` decimal(8,2) DEFAULT '0.00' COMMENT '预付款,应该付的钱',
  `money_paid` decimal(8,2) DEFAULT '0.00' COMMENT '预付款,已经付了多少钱, 预付款=总付款,表示订单完成',
  PRIMARY KEY (`order_id`),
  KEY `pintuan_group_id` (`group_id`),
  KEY `product_name` (`product_name`),
  KEY `spend_status` (`spend_status`),
  KEY `product_number` (`product_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='拼团订单表';

DROP TABLE IF EXISTS `jh_weidian_pintuan_order_product`;
CREATE TABLE IF NOT EXISTS `jh_weidian_pintuan_order_product` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `product_id` int(10) DEFAULT '0' COMMENT '商品ID',
  `product_name` varchar(150) DEFAULT '' COMMENT '商品名称',
  `product_price` decimal(8,2) DEFAULT NULL COMMENT '商品价格(单价)',
  `package_price` decimal(6,2) DEFAULT '0.00' COMMENT '打包费=运费 , 0:免打包费',
  `product_number` smallint(6) DEFAULT '0' COMMENT '商品数量',
  `amount` decimal(8,2) DEFAULT '0.00' COMMENT '订单结算价格 = order表amount的值',
  PRIMARY KEY (`pid`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_pintuan_product`;
CREATE TABLE IF NOT EXISTS `jh_weidian_pintuan_product` (
  `product_id` int(10) unsigned NOT NULL COMMENT '商品ID',
  `item_limit` smallint(5) DEFAULT '0' COMMENT '0: 默认, 不允许单独购买,  其他数字: 限购份数上限',
  `tuan_type` tinyint(1) DEFAULT '0' COMMENT '团类型  0:普通团  1:阶梯团(值为1则 user_num 0 和 tuan_price 读取最高阶梯价格)',
  `user_num` int(10) DEFAULT '3' COMMENT '几人团,  默认3,    3:默认3人,   0:无上限 ',
  `tuan_time` smallint(3) DEFAULT '3' COMMENT '成团有效期,  默认3, 单位天, 2位数,最大99, ',
  `tuan_limit` tinyint(1) DEFAULT '1' COMMENT '团是否限购 默认1  0:否(无上限)   1: 是(上限后需新开一团)  ',
  `master_need_buy` tinyint(1) DEFAULT '0' COMMENT '团长是否购买才能开团  0:无需购买(默认),  1: 需要购买',
  `money_master` decimal(8,2) DEFAULT '0.00' COMMENT '团长佣金,按份?   (总预付款, money_master )',
  `money_pre` decimal(8,2) DEFAULT '0.00' COMMENT '预付定金,必须大于佣金，只有阶梯团，必须设置订金（不可以为0），其它团不需要定金',
  `address_type` tinyint(1) DEFAULT '0' COMMENT '配送类型,0:二者都可(默认),  1:仅配送, 2: 仅自提',
  PRIMARY KEY (`product_id`),
  KEY `money_pre` (`money_pre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品信息';

DROP TABLE IF EXISTS `jh_weidian_pintuan_product_level`;
CREATE TABLE IF NOT EXISTS `jh_weidian_pintuan_product_level` (
  `level_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `product_id` int(10) DEFAULT NULL COMMENT '团产品id,',
  `level` smallint(3) DEFAULT '1' COMMENT '团级别',
  `user_num` int(10) DEFAULT '1' COMMENT '成团人数   3表示 达到3人的价格,  10表示达到10人的价格, 如果是7人,则调用3人的价格',
  `price` decimal(8,2) DEFAULT '0.00' COMMENT '单价',
  PRIMARY KEY (`level_id`),
  KEY `tuan_product_id` (`product_id`),
  KEY `level` (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
