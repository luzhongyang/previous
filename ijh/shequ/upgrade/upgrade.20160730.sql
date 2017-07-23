ALTER TABLE `jh_waimai` CHANGE `phone` `phone` VARCHAR(15) CHARSET utf8 COLLATE utf8_general_ci DEFAULT ''  NULL;

ALTER TABLE `jh_tuan` CHANGE `notice` `notice` MEDIUMTEXT NULL  COMMENT '购买须知，后台表单textarea填写信息'  AFTER `orderby`,
  CHANGE `is_onsale` `is_onsale` TINYINT(1) DEFAULT 0  NULL  COMMENT '是否上架  0：下架 1：上架'  AFTER `stock_num`,
  CHANGE `audit` `audit` TINYINT(1) DEFAULT 0  NULL  COMMENT '商品是否审核 0:未审核，1:已审核'  AFTER `is_onsale`,
  CHANGE `dateline` `dateline` INT(10) DEFAULT 0  NULL  COMMENT '创建时间'  AFTER `clientip`;


CREATE TABLE IF NOT EXISTS `jh_app_noti` (
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `complaint_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `system_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `jh_waimai` CHANGE `youhui` `youhui` VARCHAR(1024) CHARSET utf8 COLLATE utf8_general_ci DEFAULT ''  NULL  COMMENT '优惠信息冗余';

ALTER TABLE `jh_waimai` CHANGE `tmpl_type` `tmpl_type` ENUM('market','waimai') CHARSET utf8 COLLATE utf8_general_ci DEFAULT 'waimai'   NULL  COMMENT '显示模板类型： market:商超,waimai:外卖';

CREATE TABLE IF NOT EXISTS `jh_order_cuilog` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) unsigned DEFAULT '0' COMMENT '商户ID',
  `staff_id` mediumint(8) DEFAULT '0',
  `order_id` int(10) unsigned DEFAULT '0' COMMENT '订单ID',
  `cui_time` int(10) unsigned DEFAULT '0' COMMENT '催单时间',
  `reply` varchar(255) DEFAULT '' COMMENT '回复内容',
  `reply_time` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `jh_member_collect` CHANGE `collect_id` `collect_id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '收藏id,', CHANGE `uid` `uid` MEDIUMINT(8) DEFAULT 0 NULL COMMENT '用户ID', CHANGE `type` `type` TINYINT(1) DEFAULT 0 NULL COMMENT '收藏类型,1:店铺,2:人员3:商品', CHANGE `can_id` `can_id` INT(11) DEFAULT 0 NULL COMMENT '可能是staff_id,shop_id', DROP INDEX `can_id`, ADD INDEX `can_id` (`can_id`, `uid`, `type`); 

ALTER TABLE `jh_staff` CHANGE `attr` `attr` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci DEFAULT '' NULL COMMENT '关联属性/分类ID结合逗号分隔' AFTER `lng`, CHANGE `sex` `sex` TINYINT(1) DEFAULT 0 NULL COMMENT '1:男,2女' AFTER `attr`, CHANGE `age` `age` TINYINT(2) UNSIGNED DEFAULT 0 NULL, CHANGE `intro` `intro` TEXT CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '介绍' AFTER `age`, CHANGE `status` `status` TINYINT(1) DEFAULT 0 NULL COMMENT '工作状态 0在线 1离线' AFTER `intro`, CHANGE `updatetime` `updatetime` INT(10) DEFAULT 0 NULL COMMENT '为空时,可以修改姓名一次，否则不允许修改姓名' AFTER `status`, CHANGE `loginip` `loginip` VARCHAR(15) CHARSET utf8 COLLATE utf8_general_ci DEFAULT '' NULL COMMENT '登陆IP' AFTER `updatetime`, CHANGE `lastlogin` `lastlogin` INT(10) DEFAULT 0 NULL COMMENT '最近一次登陆时间' AFTER `loginip`, CHANGE `verify_name` `verify_name` TINYINT(1) DEFAULT 3 NULL COMMENT '身份认证状态  0:待审核，1:通过认证, 2:认证被拒绝,3,未认证' AFTER `lastlogin`, CHANGE `audit` `audit` TINYINT(1) DEFAULT 0 NULL COMMENT '审核状态   0:待审核，1:审核通过, 2:审核失败' AFTER `verify_name`, CHANGE `closed` `closed` TINYINT(1) DEFAULT 0 NULL COMMENT '删除标识' AFTER `audit`; 

ALTER TABLE `jh_shop_print` ADD COLUMN `num` SMALLINT(6) DEFAULT 0  NULL  COMMENT '打印份数' AFTER `mkey`;

ALTER TABLE `jh_shop_cate` ADD COLUMN `photo` VARCHAR(150) DEFAULT ''  NULL AFTER `icon`;
ALTER TABLE `jh_waimai_cate` ADD COLUMN `photo` VARCHAR(150) DEFAULT ''  NULL AFTER `icon`;
ALTER TABLE `jh_payment_log`  CHANGE `from` `from` ENUM('money','order','paotui','yzbill') CHARSET utf8 COLLATE utf8_general_ci NULL  COMMENT '类型';
<<<<<<< HEAD
ALTER TABLE `jh_payment_log` CHANGE `from` `from` ENUM('money','order','paotui','coin','cloud') CHARSET utf8 COLLATE utf8_general_ci NULL  COMMENT '类型';

ALTER TABLE `jh_tuan`  
  CHANGE `notice` `notice` MEDIUMTEXT NULL  COMMENT '购买须知，后台表单textarea填写信息'  AFTER `info`,
  CHANGE `detail` `detail` MEDIUMTEXT NULL  COMMENT '图文详情'  AFTER `notice`,
  CHANGE `orderby` `orderby` SMALLINT(6) DEFAULT 0  NULL  COMMENT '排序'  AFTER `is_onsale`,
  CHANGE `audit` `audit` TINYINT(1) DEFAULT 0  NULL  COMMENT '商品是否审核 0:未审核，1:已审核'  AFTER `orderby`,
  CHANGE `closed` `closed` TINYINT(1) DEFAULT 0  NULL  COMMENT '删除标识'  AFTER `audit`;

ALTER TABLE `jh_member_feedback`   ADD COLUMN `clientip` VARCHAR(15) DEFAULT ''  NULL AFTER `content`;


ALTER TABLE  `jh_order_cuilog` ADD  `dateline` INT( 10 ) NOT NULL DEFAULT  '0' AFTER  `reply_time`

ALTER TABLE `jh_order` CHANGE `from` `from` ENUM('tuan','waimai','paotui','maidan','weixiu','house','mall','other') CHARSET utf8 COLLATE utf8_general_ci NULL COMMENT '订单类型： tuan:团购,waimai:外卖,paotui:跑腿,weixiu:维修,maidan:买单,house:家政'; 

ALTER TABLE `jh_member` ADD COLUMN `coin` INT(10) DEFAULT 0 NULL COMMENT '夺宝币' AFTER `money`; 

ALTER TABLE .`jh_member_log` CHANGE `type` `type` ENUM('money','jifen','coin') CHARSET utf8 COLLATE utf8_general_ci NULL  COMMENT '类型 money:余额, jifen:积分';

ALTER TABLE `jh_payment_log` CHANGE `from` `from` ENUM('money','order','paotui','coin') CHARSET utf8 COLLATE utf8_general_ci NULL  COMMENT '类型';
