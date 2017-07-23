--<?php exit("Access Denied");?>
DROP TABLE IF EXISTS `jh_ditui`;
CREATE TABLE `jh_ditui` (
  `ditui_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `mobile` varchar(11) DEFAULT '0',
  `passwd` char(32) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `pmid` char(9) DEFAULT '',
  `reg_count` mediumint(8) DEFAULT '0',
  `order_count` mediumint(8) DEFAULT '0',
  `name` varchar(30) DEFAULT '',
  `id_number` varchar(18) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `account_type` varchar(30) DEFAULT '',
  `account_name` varchar(30) DEFAULT '',
  `account_number` varchar(30) DEFAULT '',
  `audit` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `total_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`ditui_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_ditui_log`;
CREATE TABLE `jh_ditui_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ditui_id` mediumint(8) DEFAULT '0',
  `money` decimal(8,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(30) DEFAULT '',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_ditui_member`;
CREATE TABLE `jh_ditui_member` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ditui_id` mediumint(8) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `signup_amount` decimal(6,2) DEFAULT '0.00',
  `first_amount` decimal(6,2) DEFAULT '0.00',
  `first_order_id` int(10) DEFAULT '0',
  `first_order_amount` decimal(8,2) DEFAULT '0.00',
  `first_order_time` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_ditui_shop`;
CREATE TABLE `jh_ditui_shop` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ditui_id` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `signup_amount` decimal(6,2) DEFAULT '0.00',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;