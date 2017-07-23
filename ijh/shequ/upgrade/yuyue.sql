-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- Host: 192.168.1.10:3306
-- Generation Time: Nov 02, 2016 at 08:09 AM
-- Server version: 5.1.69
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shequ_weizx_cn`
--

-- --------------------------------------------------------

--
-- Table structure for table `jh_yuyue_dingzuo`
--

CREATE TABLE IF NOT EXISTS `jh_yuyue_dingzuo` (
  `dingzuo_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订座订单ID',
  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '用户UID',
  `order_status` tinyint(1) DEFAULT '0' COMMENT '订单状态  -1:已取消,0:未处理,1:已接单(完成)',
  `contact` varchar(15) DEFAULT '' COMMENT '联系人',
  `mobile` char(11) DEFAULT '' COMMENT '手机号',
  `zhuohao_id` int(10) DEFAULT NULL COMMENT '桌号',
  `yuyue_time` int(10) DEFAULT NULL COMMENT '时间戳,到店时间',
  `yuyue_number` smallint(6) DEFAULT '0' COMMENT '就餐人数',
  `is_baoxiang` tinyint(1) DEFAULT '0' COMMENT '0:随意,1:订包厢',
  `order_from` enum('weixin','ios','android','wap','www') DEFAULT 'weixin' COMMENT '订单来源',
  `wx_openid` varchar(64) DEFAULT '' COMMENT '微信下单时记录wxopenid',
  `jd_time` int(10) unsigned DEFAULT '0' COMMENT '接单时间',
  `lasttime` int(10) unsigned DEFAULT '0' COMMENT '订单最后更新时间',
  `cui_time` int(10) DEFAULT '0' COMMENT '用户催单时间',
  `reason` varchar(255) DEFAULT NULL COMMENT '退订原因',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除标识，0否，1已删除',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `notice` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`dingzuo_id`),
  KEY `order_status` (`order_status`),
  KEY `_INDEX` (`city_id`,`shop_id`,`uid`,`closed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单主表' AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `jh_yuyue_paidui`
--

CREATE TABLE IF NOT EXISTS `jh_yuyue_paidui` (
  `paidui_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '预定订单ID',
  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '用户UID',
  `zhuohao_id` int(10) DEFAULT '0' COMMENT '桌号',
  `order_status` tinyint(1) DEFAULT '0' COMMENT '订单状态  -1:已取消,0:未处理,1:已接单(完成),2确认就餐',
  `contact` varchar(15) DEFAULT '' COMMENT '联系人',
  `mobile` char(11) DEFAULT '' COMMENT '手机号',
  `paidui_number` smallint(6) DEFAULT '0' COMMENT '就餐人数',
  `wait_time` int(10) DEFAULT NULL COMMENT '时间戳, 预计等待,商家接单填写, 时间差等于0,显示: 您可以去就餐',
  `order_from` enum('weixin','ios','android','wap','www') DEFAULT 'weixin' COMMENT '订单来源',
  `wx_openid` varchar(64) DEFAULT '' COMMENT '微信下单时记录wxopenid',
  `reason` varchar(255) DEFAULT NULL COMMENT '退订原因',
  `jd_time` int(10) unsigned DEFAULT '0' COMMENT '接单时间',
  `cui_time` int(10) DEFAULT '0' COMMENT '用户催单时间',
  `lasttime` int(10) unsigned DEFAULT '0' COMMENT '订单最后更新时间',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除标识，0否，1已删除',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`paidui_id`),
  KEY `order_status` (`order_status`),
  KEY `_INDEX` (`city_id`,`shop_id`,`uid`,`closed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单主表' AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `jh_yuyue_zhuohao`
--

CREATE TABLE IF NOT EXISTS `jh_yuyue_zhuohao` (
  `zhuohao_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `cate_id` int(10) DEFAULT '0' COMMENT '桌子类型（大厅，包厢等）',
  `title` varchar(30) DEFAULT '' COMMENT '卓名称:VIP888,等.',
  `number` smallint(6) DEFAULT '0' COMMENT '可做人数',
  PRIMARY KEY (`zhuohao_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='桌号二维码界面, 商家可贴在桌子上' AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Table structure for table `jh_yuyue_zhuohao_cate`
--

CREATE TABLE IF NOT EXISTS `jh_yuyue_zhuohao_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `title` varchar(30) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  PRIMARY KEY (`cate_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

ALTER TABLE `jh_shop.bak` ADD `have_paidui` TINYINT( 1 ) NULL DEFAULT '0' COMMENT '排队' AFTER `have_maidan` ,
ADD `have_dingzuo` TINYINT( 1 ) NULL DEFAULT '0' COMMENT '定做' AFTER `have_paidui` ,
ADD `have_diancan` TINYINT( 1 ) NULL DEFAULT '0' COMMENT '点餐' AFTER `have_dingzuo` ;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
