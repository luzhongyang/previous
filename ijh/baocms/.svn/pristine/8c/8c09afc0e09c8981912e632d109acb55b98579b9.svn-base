ALTER TABLE `bao_market`
ADD COLUMN `type1`  tinyint(1) NULL DEFAULT 0 AFTER `photo`,
ADD COLUMN `type2`  tinyint(1) NULL AFTER `type1`,
ADD COLUMN `type3`  tinyint(1) NULL AFTER `type2`,
ADD COLUMN `type4`  tinyint(1) NULL AFTER `type3`,
ADD COLUMN `type5`  tinyint(1) NULL AFTER `type4`,
ADD COLUMN `type6`  tinyint(1) NULL AFTER `type5`,
CHANGE COLUMN `view` `views`  int(11) NULL DEFAULT 0 AFTER `closed`,
ADD COLUMN `fans_num`  int(10) NULL DEFAULT 0 COMMENT '粉丝' AFTER `views`;


ALTER TABLE `bao_users_ex`
ADD COLUMN `sex`  tinyint(1) NULL DEFAULT 0 COMMENT '0未知，1男，2女',
ADD COLUMN `job`  varchar(32) NULL DEFAULT '' COMMENT '职业',
ADD COLUMN `star_id`  tinyint(2) NULL DEFAULT 0 COMMENT '星座',
ADD COLUMN `born_year`  smallint(4) NULL DEFAULT 0 COMMENT '出生年',
ADD COLUMN `born_month`  tinyint(2) NULL DEFAULT 0 COMMENT '出生月',
ADD COLUMN `born_day`  tinyint(2) NULL DEFAULT 0 COMMENT '出生日';



ALTER TABLE `bao_users_ex`
ADD COLUMN `frozen_money`  int NULL DEFAULT 0 COMMENT '冻结的金额',
ADD COLUMN `frozen_date`  int NULL DEFAULT 0 ,
ADD COLUMN `is_tui_money`  tinyint(1) NULL DEFAULT 0 COMMENT '1代表已经发放了推广的佣金';

ALTER TABLE `bao_huodong`
ADD COLUMN `city_id`  int(10) NULL DEFAULT 0,
ADD COLUMN `traffic`  tinyint(1) NULL DEFAULT 0 COMMENT '交通方式',
ADD COLUMN `limit_num`  int(10) NULL DEFAULT 0 COMMENT '限制人数，0不限制',
ADD COLUMN `ping_num`  int(10) NULL DEFAULT 0 COMMENT '评论人数' ,
ADD COLUMN `views`  int(10) NULL DEFAULT 0 COMMENT '浏览人数' ,
MODIFY COLUMN `sex`  tinyint(1) NULL DEFAULT 3 COMMENT '1男 2女 3不限' ;

ALTER TABLE `bao_users_ex`
ADD COLUMN `is_no_frozen`  tinyint(1) NULL DEFAULT 0;

ALTER TABLE `bao_payment_logs`
MODIFY COLUMN `type`  enum('tuan','gold','money','ele','ding','fzmoney','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `user_id`;

DROP TABLE IF EXISTS `bao_huodong_looks`;
CREATE TABLE `bao_huodong_looks` (
  `look_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `huodong_id` int(10) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`look_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_huodong_dianping`;
CREATE TABLE `bao_huodong_dianping` (
  `dianping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `huodong_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `contents` text,
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`dianping_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_user_message`;
CREATE TABLE `bao_user_message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0' COMMENT '接收用户id',
  `from_id` int(10) DEFAULT '0' COMMENT '发送人id',
  `content` text COMMENT '消息内容',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0未读，1已读',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `bao_market_enter`
ADD COLUMN `cate_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`,
ADD COLUMN `floor`  tinyint(1) NULL DEFAULT 0 AFTER `cate_id`;

DROP TABLE IF EXISTS `bao_market_floor`;
CREATE TABLE `bao_market_floor` (
  `floor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `market_id` int(10) DEFAULT '0',
  `floor_name` varchar(32) DEFAULT '',
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  PRIMARY KEY (`floor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;