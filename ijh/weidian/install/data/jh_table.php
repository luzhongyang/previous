--<?php exit("Access Denied");?>
DROP TABLE IF EXISTS `jh_admin`;
CREATE TABLE IF NOT EXISTS `jh_admin` (
  `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `admin_name` varchar(15) DEFAULT '' COMMENT '管理员用户名',
  `passwd` char(32) DEFAULT '' COMMENT '登录密码',
  `role_id` smallint(6) DEFAULT '0' COMMENT '权限ID ',
  `last_login` int(10) DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(15) DEFAULT '0.0.0.0' COMMENT '最后登录IP',
  `closed` tinyint(1) DEFAULT '0' COMMENT '删除标识',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=39 ;

DROP TABLE IF EXISTS `jh_admin_role`;
CREATE TABLE IF NOT EXISTS `jh_admin_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `role_name` varchar(20) DEFAULT '' COMMENT '管理员名称',
  `role` enum('editor','admin','system','fenzhan') DEFAULT NULL COMMENT '级别',
  `priv` mediumtext COMMENT '拥有权限',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员权限' AUTO_INCREMENT=4 ;

DROP TABLE IF EXISTS `jh_adv`;
CREATE TABLE IF NOT EXISTS `jh_adv` (
  `adv_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `theme` varchar(20) DEFAULT 'default' COMMENT '隶属模板',
  `theme_id` smallint(6) DEFAULT '0' COMMENT '模板ID',
  `page` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '' COMMENT '标题',
  `from` enum('text','photo','product','script','lunzhuan') DEFAULT 'photo' COMMENT '广告类型  文字，图片，产品，代码，轮转',
  `limit` smallint(6) DEFAULT '10' COMMENT '限制条数',
  `config` mediumtext COMMENT '尺寸配置 ',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  `tmpl` mediumtext,
  `orderby` smallint(6) unsigned DEFAULT '0' COMMENT '排序',
  `audit` tinyint(1) DEFAULT '0' COMMENT '状态 0：待审 1：发布',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '删除标识 0：未删除 1：已删除',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位分类' AUTO_INCREMENT=9 ;

DROP TABLE IF EXISTS `jh_adv_item`;
CREATE TABLE IF NOT EXISTS `jh_adv_item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `adv_id` smallint(6) unsigned DEFAULT '0' COMMENT '广告类型',
  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',
  `title` varchar(100) DEFAULT '' COMMENT '标题',
  `link` varchar(150) DEFAULT '' COMMENT '链接',
  `thumb` varchar(150) DEFAULT '' COMMENT '图片',
  `script` mediumtext COMMENT '代码',
  `clicks` mediumint(8) unsigned DEFAULT '0' COMMENT '点击数',
  `stime` int(10) NOT NULL DEFAULT '0' COMMENT '有效时间开始',
  `ltime` int(10) NOT NULL DEFAULT '0' COMMENT '有效时间截至',
  `audit` tinyint(1) DEFAULT '0' COMMENT '状态 0：下架 1：上架',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '删除标识',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  `target` enum('_self','_blank','_parent','_top') DEFAULT '_blank' COMMENT '打开方式  ''_self:本窗口'',''_blank:新窗口'',''_parent:父窗口'',''_top:Top窗口''',
  `orderby` smallint(6) unsigned DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位列表' AUTO_INCREMENT=449 ;

DROP TABLE IF EXISTS `jh_app_cate`;
CREATE TABLE IF NOT EXISTS `jh_app_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) NOT NULL DEFAULT '',
  `cate_photo` varchar(255) NOT NULL DEFAULT '',
  `cate_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cate_link` varchar(255) NOT NULL DEFAULT '',
  `rule_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

DROP TABLE IF EXISTS `jh_app_noti`;
CREATE TABLE IF NOT EXISTS `jh_app_noti` (
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `complaint_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `system_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_article`;
CREATE TABLE IF NOT EXISTS `jh_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `city_id` smallint(6) DEFAULT '0' COMMENT '0:所有分站都显示',
  `cat_id` mediumint(8) unsigned DEFAULT '0' COMMENT '分类ID',
  `from` enum('article','about','help','hongbao','page') DEFAULT 'article' COMMENT '内容类型',
  `page` varchar(15) DEFAULT '' COMMENT '页面名',
  `title` varchar(200) DEFAULT '' COMMENT '标题',
  `thumb` varchar(150) DEFAULT '' COMMENT '缩略图',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  `views` mediumint(8) DEFAULT '0' COMMENT '查看数',
  `favorites` mediumint(8) DEFAULT '0' COMMENT '收参数',
  `allow_comment` tinyint(1) DEFAULT '1' COMMENT '是否可以评论',
  `comments` mediumint(8) DEFAULT '0' COMMENT '留言数',
  `photos` smallint(6) DEFAULT '0' COMMENT '图片数',
  `linkurl` varchar(255) DEFAULT '' COMMENT '连接地址',
  `ontime` int(10) DEFAULT '0' COMMENT '发布时间',
  `hidden` tinyint(1) DEFAULT '0' COMMENT '1:列表隐藏,0:不隐藏',
  `orderby` smallint(6) unsigned DEFAULT '50' COMMENT '排序',
  `audit` tinyint(1) DEFAULT '0' COMMENT '审核,1:发布，2:待审',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '删除标识',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`article_id`),
  KEY `cat_id` (`cat_id`,`from`,`audit`,`closed`,`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章列表' AUTO_INCREMENT=26 ;

DROP TABLE IF EXISTS `jh_article_cate`;
CREATE TABLE IF NOT EXISTS `jh_article_cate` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `parent_id` mediumint(8) unsigned DEFAULT '0' COMMENT '父ID',
  `title` varchar(150) DEFAULT '' COMMENT '分类名称',
  `level` tinyint(1) unsigned DEFAULT '1' COMMENT '等级',
  `from` enum('about','help','page','hongbao','article') DEFAULT 'article' COMMENT '类型 ',
  `seo_title` varchar(255) DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(255) DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(255) DEFAULT '' COMMENT 'SEO描述',
  `orderby` smallint(6) unsigned DEFAULT '50' COMMENT '排序',
  `hidden` tinyint(1) DEFAULT '0' COMMENT '是否隐藏  1:隐藏,0:不隐藏',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章分类' AUTO_INCREMENT=11 ;

DROP TABLE IF EXISTS `jh_article_content`;
CREATE TABLE IF NOT EXISTS `jh_article_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) NOT NULL,
  `seo_title` varchar(150) DEFAULT '',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_description` varchar(255) DEFAULT '',
  `content` mediumtext,
  `clientip` varchar(15) DEFAULT '0.0.0.0',
  PRIMARY KEY (`content_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

DROP TABLE IF EXISTS `jh_article_photo`;
CREATE TABLE IF NOT EXISTS `jh_article_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `photo` varchar(150) DEFAULT '',
  `size` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_block`;
CREATE TABLE IF NOT EXISTS `jh_block` (
  `block_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(30) DEFAULT NULL,
  `page_id` smallint(6) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `from` varchar(50) DEFAULT '',
  `type` enum('default','hot','new','only','zhanwei') DEFAULT 'default',
  `config` mediumtext,
  `tmpl` mediumtext,
  `limit` tinyint(3) DEFAULT '10',
  `ttl` mediumint(8) DEFAULT '900',
  `orderby` smallint(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_block_item`;
CREATE TABLE IF NOT EXISTS `jh_block_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `block_id` mediumint(8) unsigned DEFAULT '0',
  `itemId` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `link` varchar(150) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `city_id` smallint(6) DEFAULT '0',
  `data` mediumtext,
  `expire_time` int(10) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `block_id` (`block_id`,`itemId`,`city_id`),
  KEY `orderby` (`orderby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_block_page`;
CREATE TABLE IF NOT EXISTS `jh_block_page` (
  `page_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_data_area`;
CREATE TABLE IF NOT EXISTS `jh_data_area` (
  `area_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '区县ID',
  `city_id` mediumint(8) DEFAULT NULL COMMENT '城市ID',
  `area_name` varchar(50) DEFAULT '' COMMENT '区县名称',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='区县信息' AUTO_INCREMENT=24 ;

DROP TABLE IF EXISTS `jh_data_business`;
CREATE TABLE IF NOT EXISTS `jh_data_business` (
  `business_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '商圈ID',
  `city_id` mediumint(8) DEFAULT '0' COMMENT '城市ID',
  `area_id` mediumint(8) DEFAULT '0' COMMENT '区县ID',
  `business_name` varchar(50) DEFAULT NULL COMMENT '商圈名称',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`business_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商圈信息' AUTO_INCREMENT=30 ;

DROP TABLE IF EXISTS `jh_data_city`;
CREATE TABLE IF NOT EXISTS `jh_data_city` (
  `city_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '城市ID',
  `province_id` smallint(6) DEFAULT '0' COMMENT '省份ID',
  `city_name` varchar(50) DEFAULT '' COMMENT '城市名称',
  `pinyin` varchar(50) DEFAULT '' COMMENT '城市拼音',
  `theme_id` smallint(6) DEFAULT '0' COMMENT '模板ID',
  `logo` varchar(150) DEFAULT '' COMMENT '图标',
  `phone` varchar(30) DEFAULT '' COMMENT '客服电话',
  `city_code` char(4) DEFAULT '' COMMENT '城市区号',
  `mobile` varchar(15) DEFAULT '' COMMENT '手机',
  `mail` varchar(30) DEFAULT '' COMMENT '联系邮箱',
  `kfqq` varchar(30) DEFAULT '' COMMENT '客服QQ',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `audit` tinyint(1) DEFAULT '0' COMMENT '是否开启 0:关闭  1:开启',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='城市信息' AUTO_INCREMENT=29 ;

DROP TABLE IF EXISTS `jh_data_province`;
CREATE TABLE IF NOT EXISTS `jh_data_province` (
  `province_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '省份ID',
  `province_name` varchar(30) DEFAULT '' COMMENT '省份名称',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`province_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='省份信息' AUTO_INCREMENT=10 ;

DROP TABLE IF EXISTS `jh_hongbao`;
CREATE TABLE IF NOT EXISTS `jh_hongbao` (
  `hongbao_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '红包ID ',
  `from` enum('tuan','waimai','paotui','maidan','weixiu','house','other') DEFAULT NULL COMMENT '使用类别',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `min_amount` int(10) NOT NULL COMMENT '满足使用条件',
  `amount` int(10) NOT NULL COMMENT '红包价值',
  `type` tinyint(1) DEFAULT '0' COMMENT '红包类型',
  `uid` int(10) DEFAULT '0' COMMENT '会员UID',
  `hongbao_sn` char(8) NOT NULL DEFAULT '' COMMENT '红包卡密',
  `stime` int(10) DEFAULT '0' COMMENT '红包失效时间',
  `ltime` int(10) DEFAULT '0' COMMENT '红包使用时间',
  `order_id` int(10) DEFAULT '0' COMMENT '使用的订单号,0:表示未使用的红包',
  `used_ip` varchar(15) DEFAULT '' COMMENT '使用时IP',
  `used_time` int(10) DEFAULT '0' COMMENT '使用的时间',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`hongbao_id`),
  KEY `uid` (`uid`,`order_id`),
  KEY `stime` (`stime`,`ltime`),
  KEY `hongbao_sn` (`hongbao_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='红包' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_hongbao_log`;
CREATE TABLE IF NOT EXISTS `jh_hongbao_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID ',
  `hongbao_id` int(10) unsigned NOT NULL COMMENT '红包ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `uid` int(10) unsigned NOT NULL COMMENT '会员UID',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包金额',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='红包明细' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_jpush_device`;
CREATE TABLE IF NOT EXISTS `jh_jpush_device` (
  `device_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `staff_id` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `from` enum('member','staff','shop') DEFAULT NULL,
  `platform` enum('ios','android') DEFAULT 'android',
  `register_id` varchar(64) DEFAULT '',
  `tag_ids` varchar(150) DEFAULT '',
  PRIMARY KEY (`device_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_jpush_log`;
CREATE TABLE IF NOT EXISTS `jh_jpush_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` enum('member','staff','shop') DEFAULT NULL,
  `platform` enum('all','android','ios') DEFAULT NULL,
  `tag` varchar(50) DEFAULT '',
  `alias` varchar(50) DEFAULT '',
  `device_id` int(10) DEFAULT '0',
  `register_id` varchar(64) DEFAULT '',
  `content` varchar(1024) DEFAULT '',
  `status` tinyint(1) DEFAULT '0' COMMENT '0:失败,1:成功',
  `clientip` varchar(15) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_jpush_tag`;
CREATE TABLE IF NOT EXISTS `jh_jpush_tag` (
  `tag_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) DEFAULT '',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

DROP TABLE IF EXISTS `jh_member`;
CREATE TABLE IF NOT EXISTS `jh_member` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户UID',
  `mobile` varchar(15) NOT NULL COMMENT '手机号',
  `passwd` char(32) DEFAULT '' COMMENT '登录密码',
  `paypasswd` char(32) DEFAULT '' COMMENT '支付密码',
  `nickname` varchar(30) DEFAULT '' COMMENT '会员昵称',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '账户余额',
  `coin` int(10) DEFAULT '0' COMMENT '夺宝币',
  `total_money` decimal(10,2) DEFAULT '0.00' COMMENT '总花销',
  `orders` mediumint(8) DEFAULT '0' COMMENT '订单数',
  `jifen` int(10) DEFAULT '0' COMMENT '账户积分',
  `face` varchar(150) DEFAULT '' COMMENT '会员头像',
  `wx_openid` varchar(255) DEFAULT '' COMMENT '微信OPENID，绑定过微信的用户会有该值，空则表示未绑定微信帐号',
  `wx_unionid` varchar(255) DEFAULT NULL COMMENT '微信unionid',
  `loginip` varchar(15) DEFAULT '' COMMENT '最后登录IP',
  `lastlogin` int(10) DEFAULT '0' COMMENT '最后登录时间',
  `pmid` char(9) DEFAULT '' COMMENT '格式为(M|P|D|S)+ID M:会员，D:地推，S:商家，P:配送员',
  `closed` tinyint(1) DEFAULT '0' COMMENT '删除标识',
  `regip` varchar(15) DEFAULT '' COMMENT '注册IP',
  `tuisong` tinyint(1) DEFAULT '1' COMMENT '是否接收推送,0:不推送,1:推送,默认接收推送',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mobile` (`mobile`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员信息' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_addr`;
CREATE TABLE IF NOT EXISTS `jh_member_addr` (
  `addr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '地址ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '会员UID ',
  `contact` varchar(30) DEFAULT '' COMMENT '联系人',
  `mobile` varchar(15) DEFAULT '' COMMENT '联系电话',
  `addr` varchar(255) DEFAULT '' COMMENT '联系地址',
  `house` varchar(150) DEFAULT '' COMMENT '小区门牌号',
  `is_default` tinyint(1) DEFAULT '0' COMMENT '是否为默认地址 1：默认地址',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `lat` int(10) DEFAULT '0' COMMENT '纬度坐标',
  `lng` int(10) unsigned DEFAULT '0' COMMENT '经度坐标',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:公司,2:家,3:学校,4:其他',
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员-收货地址' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_cloud`;
CREATE TABLE IF NOT EXISTS `jh_member_cloud` (
  `uid` int(10) unsigned NOT NULL,
  `nickname` varchar(64) DEFAULT '',
  `face` varchar(128) DEFAULT '',
  `mobile` varchar(11) DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='机器人用户表';

DROP TABLE IF EXISTS `jh_member_collect`;
CREATE TABLE IF NOT EXISTS `jh_member_collect` (
  `collect_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '收藏id,',
  `uid` mediumint(8) DEFAULT '0' COMMENT '用户ID',
  `type` tinyint(1) DEFAULT '0' COMMENT '收藏类型,1:店铺,2:人员3:商品',
  `can_id` int(11) DEFAULT '0' COMMENT '可能是staff_id,shop_id',
  `status` tinyint(1) DEFAULT '0' COMMENT '收藏状态 0：已收藏  1：已取消',
  `dateline` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`collect_id`),
  UNIQUE KEY `collect_id` (`collect_id`) USING BTREE,
  KEY `can_id` (`can_id`,`uid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户收藏' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_coupon`;
CREATE TABLE IF NOT EXISTS `jh_member_coupon` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_feedback`;
CREATE TABLE IF NOT EXISTS `jh_member_feedback` (
  `fid` int(11) NOT NULL AUTO_INCREMENT COMMENT '反馈',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` varchar(255) DEFAULT NULL COMMENT '反馈内容',
  `from` varchar(10) DEFAULT '' COMMENT '来源',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户反馈\r\n' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_help`;
CREATE TABLE IF NOT EXISTS `jh_member_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(128) DEFAULT '' COMMENT '标题',
  `details` text COMMENT '详情',
  `dateline` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`help_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户服务中心' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_invite`;
CREATE TABLE IF NOT EXISTS `jh_member_invite` (
  `invite_uid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '被邀请人UID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '邀请人UID',
  `mobile` char(11) DEFAULT '' COMMENT '被邀请人手机号码',
  `money` decimal(6,2) DEFAULT '0.00' COMMENT '被邀请人注册后，邀请人获得注册奖励',
  `dateline` int(10) DEFAULT '0' COMMENT '邀请成功时间',
  PRIMARY KEY (`invite_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_member_log`;
CREATE TABLE IF NOT EXISTS `jh_member_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '会员UID',
  `type` enum('money','jifen','coin') DEFAULT NULL COMMENT '类型 money:余额, jifen:积分',
  `number` float DEFAULT '0' COMMENT '变动数值',
  `intro` varchar(255) DEFAULT '' COMMENT '变动原因',
  `admin` varchar(80) DEFAULT '' COMMENT '管理人',
  `day` int(8) DEFAULT '0' COMMENT '日期 格式20160224',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT NULL COMMENT '变动时间 UNIXTIME',
  PRIMARY KEY (`log_id`),
  KEY `uid` (`uid`,`type`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员-金额、积分明细' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_member_message`;
CREATE TABLE IF NOT EXISTS `jh_member_message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `uid` int(10) DEFAULT '0' COMMENT '会员UID',
  `title` varchar(80) DEFAULT NULL COMMENT '消息标题',
  `content` varchar(512) DEFAULT '' COMMENT '消息内容',
  `type` tinyint(1) DEFAULT '0' COMMENT '0:所有消息 1:红包消息, 2:订单消息,3:其它消息',
  `order_id` int(10) DEFAULT '0' COMMENT '订单id',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0:新消息,1:已读,2:所有',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `clientip` varchar(15) DEFAULT NULL COMMENT '客户IP',
  PRIMARY KEY (`message_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员消息' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_order`;
CREATE TABLE IF NOT EXISTS `jh_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `staff_id` mediumint(8) DEFAULT '0' COMMENT '服务人员ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '用户UID',
  `from` enum('tuan','waimai','paotui','maidan','weixiu','house','mall','weidian','other') DEFAULT NULL COMMENT '订单类型： tuan:团购,waimai:外卖,paotui:跑腿,weixiu:维修,maidan:买单,house:家政,weidian:微商城',
  `order_status` tinyint(1) DEFAULT '0' COMMENT '订单状态',
  `online_pay` tinyint(1) DEFAULT '0' COMMENT '付款方式   0:货到付款,1:在线支付',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '支付状态 0:未支付，1:已支付',
  `trade_no` int(10) DEFAULT '0' COMMENT '支付流水号',
  `total_price` decimal(10,2) DEFAULT '0.00' COMMENT '订单总金额',
  `hongbao_id` int(11) DEFAULT '0' COMMENT '红包ID',
  `hongbao` decimal(8,2) DEFAULT '0.00' COMMENT '红包金额',
  `order_youhui` decimal(8,2) DEFAULT '0.00' COMMENT '订单优惠',
  `first_youhui` decimal(8,2) DEFAULT '0.00' COMMENT '首单优惠',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '余额抵扣',
  `amount` decimal(10,2) DEFAULT '0.00' COMMENT '需支付金额 =product_price+freight-order_youhui-first_youhui-hongbao-money',
  `o_lng` int(10) DEFAULT '0' COMMENT '接单起点经度坐标',
  `o_lat` int(10) DEFAULT '0' COMMENT '接单起点纬度坐标',
  `contact` varchar(15) DEFAULT '' COMMENT '联系人',
  `mobile` char(11) DEFAULT '' COMMENT '手机号',
  `addr` varchar(150) DEFAULT '' COMMENT '收货地址',
  `house` varchar(150) DEFAULT '' COMMENT '收货地小区门牌号',
  `lng` int(10) DEFAULT '0' COMMENT '收货地纬度坐标',
  `lat` int(10) DEFAULT '0' COMMENT '收货地经度坐标',
  `day` int(8) DEFAULT '0' COMMENT '订单日期格式20160220',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `intro` varchar(255) DEFAULT '' COMMENT '描述',
  `order_from` enum('weixin','ios','android','wap','www') DEFAULT 'weixin' COMMENT '订单来源',
  `wx_openid` varchar(64) DEFAULT '' COMMENT '微信下单时记录wxopenid',
  `pay_code` varchar(10) DEFAULT '' COMMENT '支付类型   wxpay:微信, alipay:支付宝, money:余额',
  `pay_time` int(10) DEFAULT '0' COMMENT '支付时间UNIXTIME 当pay_status=1时有值',
  `pei_time` int(10) DEFAULT '0' COMMENT '配送时间',
  `pei_type` tinyint(1) DEFAULT '0' COMMENT '0:自己送，1:跑腿送,  2:代购(仅仅外卖), 3:用户自提单',
  `pei_amount` decimal(8,2) DEFAULT '0.00' COMMENT '配送结算价格/跑腿费用',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `jd_time` int(10) unsigned DEFAULT '0' COMMENT '接单时间',
  `comment_status` tinyint(1) unsigned DEFAULT '0' COMMENT '订单是否已评价  0：未评价  1：已评价',
  `lasttime` int(10) unsigned DEFAULT '0' COMMENT '订单最后更新时间',
  `cui_time` int(10) DEFAULT '0' COMMENT '用户催单时间',
  `closed` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除标识，0否，1已删除',
  `coupon_id` int(10) DEFAULT '0' COMMENT '店铺优惠券ID',
  `coupon` decimal(8,2) DEFAULT '0.00' COMMENT '店铺优惠券抵扣金额',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单主表' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_order_complaint`;
CREATE TABLE IF NOT EXISTS `jh_order_complaint` (
  `complaint_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '投诉ID',
  `order_id` int(10) DEFAULT NULL COMMENT '订单ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '用户UID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `staff_id` mediumint(8) DEFAULT '0' COMMENT '服务人员ID',
  `title` varchar(80) DEFAULT '' COMMENT '投诉类型',
  `content` varchar(255) DEFAULT '' COMMENT '投诉内容',
  `reply` varchar(255) DEFAULT '' COMMENT '商户回复内容',
  `reply_time` int(10) DEFAULT '0' COMMENT '商户回复时间',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`complaint_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单投诉主表' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_order_cuilog`;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_order_log`;
CREATE TABLE IF NOT EXISTS `jh_order_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `status` tinyint(1) DEFAULT '0' COMMENT '-2:已退款，-1取消，0其他，1下单，2支付，3接单，4配送，5送达，6确认完成',
  `log` varchar(255) DEFAULT '' COMMENT '日志内容',
  `from` enum('shop','admin','staff','member','payment') DEFAULT 'member' COMMENT '创建者',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单日志主表' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_order_photo`;
CREATE TABLE IF NOT EXISTS `jh_order_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `photo` varchar(150) DEFAULT '' COMMENT '图片',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单图片' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_order_voice`;
CREATE TABLE IF NOT EXISTS `jh_order_voice` (
  `voice_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '语音ID',
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `voice` varchar(255) DEFAULT '' COMMENT '语音文件',
  `voice_time` tinyint(3) DEFAULT '0' COMMENT '语音时间(长度:秒)',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`voice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单语音' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_payment`;
CREATE TABLE IF NOT EXISTS `jh_payment` (
  `payment_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `payment` varchar(20) DEFAULT '' COMMENT '接口标识',
  `title` varchar(100) DEFAULT '' COMMENT '接口标题',
  `logo` varchar(150) DEFAULT '' COMMENT '图标',
  `config` mediumtext COMMENT '配置信息',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0:关闭  1:开启',
  `dateline` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='支付接口配置' AUTO_INCREMENT=5 ;

DROP TABLE IF EXISTS `jh_payment_log`;
CREATE TABLE IF NOT EXISTS `jh_payment_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0' COMMENT '会员UID',
  `from` enum('money','order','paotui','coin','cloud','yzbill','cashier') DEFAULT NULL COMMENT '类型',
  `payment` varchar(20) DEFAULT '' COMMENT '支付接口',
  `trade_no` int(10) DEFAULT '0' COMMENT '支付流水号',
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `amount` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `payed` tinyint(1) DEFAULT '0' COMMENT '0:未支付，1:已支付',
  `payedip` varchar(15) DEFAULT '' COMMENT '支付成功时IP',
  `payedtime` int(10) DEFAULT '0' COMMENT '支付成功通知时间',
  `pay_trade_no` varchar(50) DEFAULT '' COMMENT '支付交易号',
  `extra_pay` varchar(200) DEFAULT '' COMMENT '支付返回',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `pay_level` tinyint(1) DEFAULT '0' COMMENT '子订单支付批次，同一订单多次支付时用',
  PRIMARY KEY (`log_id`),
  KEY `trade_no` (`trade_no`),
  KEY `uid` (`uid`),
  KEY `from` (`from`,`payed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付明细' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_session`;
CREATE TABLE IF NOT EXISTS `jh_session` (
  `SSID` char(35) NOT NULL COMMENT 'sessionID ',
  `uid` mediumint(8) DEFAULT '0' COMMENT '会员UID',
  `city_id` mediumint(8) DEFAULT '0' COMMENT '城市ID',
  `ip` char(15) DEFAULT '0.0.0.0' COMMENT 'ip地址',
  `data` varchar(1024) DEFAULT NULL COMMENT 'session数据',
  `lastupdate` int(10) DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`SSID`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='SESSION';

DROP TABLE IF EXISTS `jh_shop`;
CREATE TABLE IF NOT EXISTS `jh_shop` (
  `shop_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商户ID',
  `cate_id` smallint(6) DEFAULT '0' COMMENT '分类ID',
  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',
  `title` varchar(30) DEFAULT '' COMMENT '商户名称',
  `contact` varchar(15) DEFAULT '' COMMENT '联系人',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机号',
  `phone` varchar(15) DEFAULT '' COMMENT '电话号码',
  `passwd` char(32) DEFAULT '' COMMENT '登陆密码',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '账户余额',
  `thumb` varchar(255) DEFAULT '' COMMENT '商家头像',
  `intro` varchar(512) DEFAULT '',
  `info` varchar(512) DEFAULT '',
  `total_money` decimal(10,2) DEFAULT '0.00' COMMENT '总收益',
  `tixian_money` decimal(10,2) DEFAULT '0.00' COMMENT '提现总金额',
  `tixian_percent` tinyint(1) DEFAULT '100' COMMENT '提现比例:1~100',
  `have_waimai` tinyint(1) DEFAULT '0' COMMENT '外卖  0:关闭 1:开通 ',
  `have_tuan` tinyint(1) DEFAULT '0' COMMENT '团购',
  `have_quan` tinyint(1) DEFAULT '0' COMMENT '代金券',
  `have_maidan` tinyint(1) DEFAULT '0' COMMENT '优惠买单',
  `have_paidui` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排号功能',
  `have_dingzuo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订座功能',
  `have_diancan` tinyint(1) NOT NULL DEFAULT '0' COMMENT '点餐功能',
  `max_youhui` decimal(10,2) DEFAULT '0.00' COMMENT '买单最大优惠',
  `lat` int(10) DEFAULT '0' COMMENT '纬度',
  `lng` int(10) DEFAULT '0' COMMENT '经度',
  `logo` varchar(150) DEFAULT '' COMMENT '图标',
  `banner` varchar(150) DEFAULT '',
  `score` int(10) DEFAULT '0' COMMENT '总评分，  星星=score/comments*20%',
  `comments` mediumint(8) DEFAULT '0' COMMENT '总评论数',
  `addr` varchar(150) DEFAULT '' COMMENT '地址',
  `avg_amount` decimal(6,2) unsigned DEFAULT '0.00' COMMENT '人均消费',
  `business_id` smallint(6) DEFAULT '0' COMMENT '商圈ID',
  `area_id` smallint(6) DEFAULT '0' COMMENT '区县ID',
  `verify_name` tinyint(1) DEFAULT '0' COMMENT '认证状态',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `audit` tinyint(1) DEFAULT '0' COMMENT '审核状态 0:待审核，1:审核通过, 2:审核失败',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `have_weidian` tinyint(1) DEFAULT '0' COMMENT '石否开通微店',
  `closed` tinyint(1) DEFAULT '0' COMMENT '删除标识',
  `have_fenxiao` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户基础信息' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_account`;
CREATE TABLE IF NOT EXISTS `jh_shop_account` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '商户ID',
  `account_type` varchar(80) DEFAULT NULL COMMENT '帐户类型，如支付宝、工商银行等',
  `account_name` varchar(30) DEFAULT '' COMMENT '开户人',
  `account_number` varchar(100) DEFAULT '' COMMENT '帐号',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户账户信息';

DROP TABLE IF EXISTS `jh_shop_album`;
CREATE TABLE IF NOT EXISTS `jh_shop_album` (
  `album_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `photo` varchar(150) DEFAULT '',
  `orderby` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_album_photo`;
CREATE TABLE IF NOT EXISTS `jh_shop_album_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `album_id` mediumint(8) DEFAULT '0',
  `photo` varchar(150) DEFAULT '' COMMENT '图片',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型 0 全部 1环境 2商品',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户相册' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_cate`;
CREATE TABLE IF NOT EXISTS `jh_shop_cate` (
  `cate_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `parent_id` smallint(6) DEFAULT '0' COMMENT '父ID',
  `title` varchar(30) DEFAULT '' COMMENT '分类名称',
  `icon` varchar(150) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户分类' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_comment`;
CREATE TABLE IF NOT EXISTS `jh_shop_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评价ID ',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '会员UID',
  `order_id` int(8) DEFAULT '0' COMMENT '订单ID',
  `score` tinyint(1) DEFAULT '0' COMMENT '综合总评分，星星可以除以 评论数',
  `score_fuwu` tinyint(1) DEFAULT '0' COMMENT '服务评分',
  `score_kouwei` tinyint(1) DEFAULT '0' COMMENT '口味评分',
  `content` varchar(1024) DEFAULT '' COMMENT '评价内容',
  `pei_time` smallint(6) DEFAULT '30' COMMENT '要求配送时间',
  `have_photo` tinyint(1) DEFAULT '0',
  `reply` varchar(1024) DEFAULT '' COMMENT '回复内容',
  `reply_ip` varchar(15) DEFAULT '' COMMENT '回复人IP',
  `reply_time` int(10) DEFAULT '0' COMMENT '回复时间',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `u_mobile` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_comment_photo`;
CREATE TABLE IF NOT EXISTS `jh_shop_comment_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `comment_id` int(10) DEFAULT '0' COMMENT '评价ID',
  `photo` varchar(150) DEFAULT '' COMMENT '图片',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_coupon`;
CREATE TABLE IF NOT EXISTS `jh_shop_coupon` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺优惠券' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_log`;
CREATE TABLE IF NOT EXISTS `jh_shop_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `shop_id` int(10) DEFAULT '0' COMMENT '商户ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '余额变动',
  `intro` varchar(255) DEFAULT '' COMMENT '变动缘由',
  `admin` varchar(255) DEFAULT '' COMMENT '管理人',
  `day` int(8) DEFAULT '0' COMMENT '日期格式20151111',
  `clientip` varchar(25) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `shop_id` (`shop_id`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户日志' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_msg`;
CREATE TABLE IF NOT EXISTS `jh_shop_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `shop_id` int(10) DEFAULT '0' COMMENT '商户ID',
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `title` varchar(80) DEFAULT NULL COMMENT '消息标题',
  `content` varchar(512) DEFAULT '' COMMENT '消息内容',
  `type` tinyint(1) DEFAULT '0' COMMENT '0:所有消息 1:订单消息, 2:评价消息,3:投诉消息,4:系统消息',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '是否已读    0:未读,1:已读,2:所有',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `clientip` varchar(15) DEFAULT NULL COMMENT '客户IP',
  PRIMARY KEY (`msg_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户消息' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_print`;
CREATE TABLE IF NOT EXISTS `jh_shop_print` (
  `plat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '云打印平台ID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `title` varchar(50) DEFAULT '' COMMENT '云打印平台名称',
  `from` enum('ylyun') DEFAULT NULL COMMENT '平台：ylyun:易联云',
  `partner` mediumint(8) unsigned DEFAULT '0' COMMENT '用户id',
  `apikey` varchar(50) DEFAULT '0' COMMENT 'API密钥',
  `machine_code` varchar(30) DEFAULT '0' COMMENT '终端号',
  `mkey` varchar(15) DEFAULT '0' COMMENT '终端密钥',
  `num` smallint(6) DEFAULT '0' COMMENT '打印份数',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否启用 1：启用 0：静默',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`plat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_tixian`;
CREATE TABLE IF NOT EXISTS `jh_shop_tixian` (
  `tixian_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '提现ID',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '提现资金',
  `intro` varchar(255) DEFAULT '' COMMENT '提现说明',
  `account_info` varchar(512) DEFAULT '' COMMENT '提现帐号',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0:待处理,1:通过,2:拒绝',
  `reason` varchar(255) DEFAULT '' COMMENT '拒绝原因',
  `updatetime` int(10) DEFAULT '0' COMMENT '更新时间 UNIXTIME',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT NULL COMMENT '变动时间 UNIXTIME',
  `end_money` decimal(10,2) DEFAULT '0.00' COMMENT '实际结算金额',
  PRIMARY KEY (`tixian_id`),
  KEY `shop_id` (`shop_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户提现' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_shop_verify`;
CREATE TABLE IF NOT EXISTS `jh_shop_verify` (
  `shop_id` mediumint(8) unsigned NOT NULL COMMENT '商户ID',
  `id_name` varchar(30) DEFAULT '' COMMENT '店主姓名',
  `id_number` varchar(20) DEFAULT '' COMMENT '店主身份证号',
  `id_photo` varchar(150) DEFAULT '' COMMENT '店主身份证图',
  `shop_photo` varchar(150) DEFAULT '' COMMENT '商铺实景图',
  `verify_dianzhu` tinyint(1) DEFAULT '0' COMMENT '店主验证: 0:待审核，1:审核通过, 2:审核失败',
  `company_name` varchar(80) DEFAULT '' COMMENT '公司名称',
  `yz_number` varchar(30) DEFAULT '' COMMENT '营业执照号',
  `yz_photo` varchar(150) DEFAULT '' COMMENT '营业执照图',
  `verify_yyzz` tinyint(1) DEFAULT '0' COMMENT '营业执照验证: 0:待审核，1:审核通过, 2:审核失败',
  `cy_number` varchar(30) DEFAULT '' COMMENT '餐饮执照号',
  `cy_photo` varchar(150) DEFAULT '' COMMENT '餐饮执照图',
  `verify_cy` tinyint(1) DEFAULT '0' COMMENT '餐饮验证: 0:待审核，1:审核通过, 2:审核失败',
  `refuse` varchar(255) DEFAULT '' COMMENT '拒绝原因',
  `verify` tinyint(1) DEFAULT '0' COMMENT '审核状态   0:待审核，1:审核通过, 2:审核失败',
  `verify_time` int(10) DEFAULT '0' COMMENT '审核时间',
  `updatetime` int(10) DEFAULT '0' COMMENT '申请时间',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户审核';

DROP TABLE IF EXISTS `jh_sms_log`;
CREATE TABLE IF NOT EXISTS `jh_sms_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '验证ID',
  `mobile` varchar(50) DEFAULT '' COMMENT '手机号',
  `content` varchar(255) DEFAULT '' COMMENT '短信内容',
  `sms` varchar(20) DEFAULT '',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否发送成功',
  `clientip` char(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信验证' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff`;
CREATE TABLE IF NOT EXISTS `jh_staff` (
  `staff_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '服务人员ID',
  `city_id` smallint(6) DEFAULT '0' COMMENT '城市ID',
  `from` enum('weixiu','paotui','house') DEFAULT NULL COMMENT '服务业务类型   weixiu:维修, paotui:跑腿,house:家政,跑腿服务人员兼外卖单',
  `name` varchar(30) DEFAULT '' COMMENT '姓名',
  `mobile` char(11) DEFAULT '' COMMENT '手机号',
  `passwd` char(32) DEFAULT '' COMMENT '登录密码',
  `face` varchar(150) DEFAULT '' COMMENT '头像',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  `total_money` decimal(10,2) DEFAULT '0.00' COMMENT '总收益',
  `tixian_percent` tinyint(3) DEFAULT '100' COMMENT '服务人员提现比例 0~100',
  `tixian_money` decimal(10,2) DEFAULT '0.00' COMMENT '提现总金额',
  `orders` mediumint(8) DEFAULT '0' COMMENT '订单数',
  `score` int(10) DEFAULT '0' COMMENT '总评分',
  `comments` mediumint(8) DEFAULT '0' COMMENT '评论数',
  `lat` int(10) DEFAULT '0' COMMENT '纬度坐标',
  `lng` int(10) DEFAULT '0' COMMENT '经度坐标',
  `attr` varchar(255) DEFAULT '' COMMENT '关联属性/分类ID结合逗号分隔',
  `sex` tinyint(1) DEFAULT '0' COMMENT '1:男,2女',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `age` tinyint(2) unsigned DEFAULT '0',
  `intro` text COMMENT '介绍',
  `status` tinyint(1) DEFAULT '0' COMMENT '工作状态 0在线 1离线',
  `updatetime` int(10) DEFAULT '0' COMMENT '为空时,可以修改姓名一次，否则不允许修改姓名',
  `loginip` varchar(15) DEFAULT '' COMMENT '登陆IP',
  `lastlogin` int(10) DEFAULT '0' COMMENT '最近一次登陆时间',
  `verify_name` tinyint(1) DEFAULT '3' COMMENT '身份认证状态  0:待审核，1:通过认证, 2:认证被拒绝,3,未认证',
  `audit` tinyint(1) DEFAULT '0' COMMENT '审核状态   0:待审核，1:审核通过, 2:审核失败',
  `closed` tinyint(1) DEFAULT '0' COMMENT '删除标识',
  PRIMARY KEY (`staff_id`),
  KEY `mobile` (`mobile`,`closed`),
  KEY `city_id` (`city_id`,`audit`,`closed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='服务人员信息' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_account`;
CREATE TABLE IF NOT EXISTS `jh_staff_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL COMMENT '关联ID',
  `type` varchar(50) DEFAULT NULL COMMENT '账户类型',
  `name` varchar(50) DEFAULT NULL COMMENT '开户人',
  `account` varchar(50) DEFAULT NULL COMMENT '开户账号',
  `is_default` tinyint(1) DEFAULT NULL COMMENT '是否默认,1:默认,0:正常',
  `dateline` int(11) DEFAULT NULL COMMENT '开户日期',
  `title` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_id` (`account_id`) USING BTREE,
  KEY `staff_id` (`staff_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='账户' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_comment`;
CREATE TABLE IF NOT EXISTS `jh_staff_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评价ID',
  `order_id` int(10) DEFAULT '0' COMMENT '订单ID',
  `staff_id` mediumint(8) DEFAULT '0' COMMENT '服务人员ID',
  `uid` mediumint(8) DEFAULT '0' COMMENT '用户UID',
  `score` tinyint(1) DEFAULT '0' COMMENT '总评分,几颗星，0-6课',
  `content` varchar(255) DEFAULT '' COMMENT '评价内容',
  `reply` varchar(255) DEFAULT '' COMMENT '服务人员回复内容',
  `reply_ip` varchar(15) DEFAULT '' COMMENT '服务人员回复IP',
  `reply_time` int(10) DEFAULT '0' COMMENT '服务人员回复时间',
  `clientip` varchar(15) DEFAULT '' COMMENT '客户IP ',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `have_photo` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='服务人员评价表' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_comment_photo`;
CREATE TABLE IF NOT EXISTS `jh_staff_comment_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(255) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_fields`;
CREATE TABLE IF NOT EXISTS `jh_staff_fields` (
  `staff_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_name` varchar(30) DEFAULT '' COMMENT '实名',
  `id_number` varchar(30) DEFAULT '' COMMENT '身份证号',
  `id_photo` varchar(150) DEFAULT '' COMMENT '身份证图',
  `verify_photo` varchar(150) DEFAULT '' COMMENT '手持身份证',
  `account_type` varchar(30) DEFAULT '' COMMENT '帐户类型，如支付宝、工商银行等',
  `account_name` varchar(30) DEFAULT '' COMMENT '开户人',
  `account_number` varchar(30) DEFAULT '' COMMENT '帐号',
  `info` mediumtext COMMENT '介绍资料',
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_staff_log`;
CREATE TABLE IF NOT EXISTS `jh_staff_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL COMMENT '服务人员ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '余额变动',
  `intro` varchar(255) DEFAULT '' COMMENT '变动缘由',
  `admin` varchar(255) DEFAULT '' COMMENT '管理人',
  `day` int(8) DEFAULT '0' COMMENT '日期格式20151111',
  `clientip` varchar(25) DEFAULT '' COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_id`),
  KEY `staff_id` (`staff_id`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_msg`;
CREATE TABLE IF NOT EXISTS `jh_staff_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `staff_id` int(10) DEFAULT '0' COMMENT '会员UID',
  `title` varchar(80) DEFAULT NULL COMMENT '消息标题',
  `content` varchar(512) DEFAULT '' COMMENT '消息内容',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0:新消息,1:已读,2:所有',
  `clientip` varchar(15) DEFAULT NULL COMMENT '客户IP',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`msg_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_tixian`;
CREATE TABLE IF NOT EXISTS `jh_staff_tixian` (
  `tixian_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` mediumint(8) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '提现金额',
  `intro` varchar(255) DEFAULT '' COMMENT '体现描述',
  `account_info` varchar(512) DEFAULT '' COMMENT '提现帐号信息',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态,0:待处理,1:通过,2:拒绝',
  `reason` varchar(255) DEFAULT NULL COMMENT '拒绝原因',
  `updatetime` int(10) DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL COMMENT '申请时间',
  `end_money` decimal(10,2) DEFAULT '0.00' COMMENT '实际结算金额',
  PRIMARY KEY (`tixian_id`),
  KEY `staff_id` (`staff_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_staff_verify`;
CREATE TABLE IF NOT EXISTS `jh_staff_verify` (
  `staff_id` mediumint(8) NOT NULL,
  `id_name` varchar(30) DEFAULT '' COMMENT '真实姓名',
  `id_number` varchar(18) DEFAULT '' COMMENT '身份证号',
  `id_photo` varchar(150) DEFAULT '' COMMENT '身份证图',
  `verify` tinyint(1) DEFAULT '0' COMMENT ' 身份认证状态 0:待审核，1:通过认证, 2:认证被拒绝',
  `verify_time` int(10) DEFAULT '0' COMMENT '认证时间',
  `refuse` varchar(150) DEFAULT '' COMMENT '拒绝原因',
  `updatetime` int(10) DEFAULT '0' COMMENT '申请时间，重新申请时间会更新',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_system_config`;
CREATE TABLE IF NOT EXISTS `jh_system_config` (
  `k` varchar(30) NOT NULL COMMENT 'key',
  `v` mediumtext COMMENT 'value',
  `title` varchar(30) DEFAULT '' COMMENT '名称',
  `dateline` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置信息';

DROP TABLE IF EXISTS `jh_system_logs`;
CREATE TABLE IF NOT EXISTS `jh_system_logs` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin` varchar(30) DEFAULT '',
  `action` varchar(50) DEFAULT '',
  `title` varchar(255) DEFAULT '' COMMENT '标题',
  `content` mediumtext COMMENT '内容',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统日志' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_system_module`;
CREATE TABLE IF NOT EXISTS `jh_system_module` (
  `mod_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '模块ID',
  `module` enum('top','menu','module') DEFAULT 'module' COMMENT '类型   top:顶级,menu:菜单,module:控制器模块',
  `level` tinyint(1) DEFAULT '3' COMMENT '等级',
  `ctl` varchar(32) DEFAULT '' COMMENT '控制器',
  `act` varchar(20) DEFAULT '' COMMENT '方法',
  `title` varchar(20) DEFAULT '' COMMENT '菜单名称',
  `visible` tinyint(1) DEFAULT '1' COMMENT '是否在导航显示  0:不显示 1:显示',
  `parent_id` smallint(6) DEFAULT '0' COMMENT '父ID',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`mod_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='导航菜单模块' AUTO_INCREMENT=1903 ;

DROP TABLE IF EXISTS `jh_themes`;
CREATE TABLE IF NOT EXISTS `jh_themes` (
  `theme_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `config` mediumtext,
  `default` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`theme_id`),
  KEY `theme` (`theme`,`default`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位模板' AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `jh_tuisong`;
CREATE TABLE IF NOT EXISTS `jh_tuisong` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `from` enum('member','staff','biz') DEFAULT 'member',
  `register_id` varchar(64) DEFAULT '',
  `device_id` varchar(64) DEFAULT '',
  `tag_ids` varchar(255) DEFAULT NULL,
  `tags` varchar(512) DEFAULT '' COMMENT '多个分组用逗号隔开',
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='推送相关配置';

DROP TABLE IF EXISTS `jh_tuisong_group`;
CREATE TABLE IF NOT EXISTS `jh_tuisong_group` (
  `tui_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '中文名称',
  `name` varchar(255) DEFAULT NULL COMMENT '英文标示',
  `number` int(11) DEFAULT '0' COMMENT '该分组被使用次数',
  `order` tinyint(4) DEFAULT '0',
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`tui_id`),
  KEY `tui_id` (`tui_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

DROP TABLE IF EXISTS `jh_upload_photo`;
CREATE TABLE IF NOT EXISTS `jh_upload_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT '0',
  `from` varchar(30) DEFAULT '',
  `hash` char(32) DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `size` smallint(6) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`),
  KEY `hash` (`hash`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian`;
CREATE TABLE IF NOT EXISTS `jh_weidian` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(80) DEFAULT '' COMMENT '店铺名称',
  `info` text,
  `phone` varchar(15) DEFAULT '' COMMENT '联系电话',
  `logo` varchar(255) DEFAULT '' COMMENT 'logo',
  `is_ziti` tinyint(1) DEFAULT '0' COMMENT '是否支持自提',
  `is_daofu` tinyint(1) DEFAULT '0' COMMENT '是否支持到付',
  `online_pay` tinyint(1) DEFAULT '0' COMMENT '0:不支持在线付款,1:支持在线支付',
  `products` mediumint(8) DEFAULT '0' COMMENT '商品数量',
  `orders` mediumint(8) DEFAULT '0' COMMENT '订单数量',
  `audit` tinyint(1) DEFAULT '0' COMMENT '审核',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_weidian_banner`;
CREATE TABLE IF NOT EXISTS `jh_weidian_banner` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `title` varchar(80) CHARACTER SET utf8 DEFAULT '' COMMENT '标题',
  `photo` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '图片',
  `link` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '链接',
  `clicks` mediumint(8) DEFAULT '0' COMMENT '点击数',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `audit` tinyint(1) DEFAULT '0' COMMENT '0:下架,1:上架',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_collect`;
CREATE TABLE IF NOT EXISTS `jh_weidian_collect` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `dateline` int(10) unsigned DEFAULT '0',
  `shop_id` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`collect_id`),
  KEY `pintuan_product_id` (`product_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品收藏' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_comment`;
CREATE TABLE IF NOT EXISTS `jh_weidian_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `uid` int(10) DEFAULT '0',
  `score` decimal(2,1) DEFAULT '3.0',
  `packing_score` tinyint(1) DEFAULT '3',
  `quality_score` tinyint(1) DEFAULT '3',
  `fuwu_score` tinyint(1) DEFAULT '3',
  `content` text,
  `have_photo` tinyint(1) DEFAULT '0',
  `reply` text,
  `closed` tinyint(1) DEFAULT '0',
  `reply_ip` varchar(15) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_comment_photo`;
CREATE TABLE IF NOT EXISTS `jh_weidian_comment_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_fenxiao`;
CREATE TABLE IF NOT EXISTS `jh_weidian_fenxiao` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `uid` int(10) DEFAULT '0',
  `shop_name` varchar(32) DEFAULT '',
  `title` varchar(32) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核状态',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_huodong`;
CREATE TABLE IF NOT EXISTS `jh_weidian_huodong` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(64) CHARACTER SET utf8 DEFAULT '' COMMENT '标题',
  `stime` int(10) unsigned DEFAULT '0' COMMENT '活动开始时间',
  `ltime` int(10) unsigned DEFAULT '0' COMMENT '活动结束时间',
  `link` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '外链',
  `dateline` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  `display` tinyint(1) unsigned DEFAULT '0' COMMENT '0不显示，1显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_name`;
CREATE TABLE IF NOT EXISTS `jh_weidian_name` (
  `key` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_order`;
CREATE TABLE IF NOT EXISTS `jh_weidian_order` (
  `order_id` int(10) unsigned NOT NULL,
  `product_price` decimal(8,2) DEFAULT '0.00',
  `product_number` int(10) DEFAULT '0',
  `freight` decimal(8,2) DEFAULT '0.00',
  `spend_number` varchar(32) DEFAULT '',
  `spend_status` tinyint(1) DEFAULT '0',
  `type` enum('pintuan','fenxiao','default') DEFAULT 'default',
  `sid` int(10) DEFAULT '0' COMMENT '分销店sid',
  `invite1` int(10) DEFAULT '0' COMMENT '分销店 uid',
  `invite2` int(10) DEFAULT '0',
  `invite3` int(10) DEFAULT '0',
  `shop_amount` decimal(8,2) DEFAULT '0.00' COMMENT '商家该得金额',
  `amount_1` decimal(8,2) DEFAULT '0.00' COMMENT '一级分销所得',
  `amount_2` decimal(8,2) DEFAULT '0.00' COMMENT '二级分销所得',
  `amount_3` decimal(8,2) DEFAULT '0.00' COMMENT '三级分销所得',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_weidian_order_product`;
CREATE TABLE IF NOT EXISTS `jh_weidian_order_product` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `product_id` int(10) DEFAULT '0',
  `product_name` varchar(128) DEFAULT '',
  `product_price` decimal(8,2) DEFAULT '0.00',
  `product_number` int(10) DEFAULT '0',
  `amount` decimal(8,2) DEFAULT '0.00',
  `stock_name` varchar(256) DEFAULT '',
  `stock_real_name` varchar(256) DEFAULT '',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_product`;
CREATE TABLE IF NOT EXISTS `jh_weidian_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `cate_id` int(10) DEFAULT '0',
  `type` enum('pintuan','default') DEFAULT NULL,
  `title` varchar(64) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `price` decimal(8,2) DEFAULT '0.00' COMMENT '产品价',
  `wei_price` decimal(8,2) DEFAULT '0.00' COMMENT '商城价/团购价',
  `price_level_1` decimal(8,2) DEFAULT '0.00' COMMENT '一级分销返佣',
  `price_level_2` decimal(8,2) DEFAULT '0.00' COMMENT '二级分销返佣',
  `price_level_3` decimal(8,2) DEFAULT '0.00' COMMENT '三级分销返佣',
  `intro` text,
  `sales` int(10) unsigned DEFAULT '0' COMMENT '销量',
  `stock` int(10) unsigned DEFAULT '0' COMMENT '库存',
  `is_fan` tinyint(1) DEFAULT '0' COMMENT '是否返佣',
  `is_onsale` tinyint(1) DEFAULT '0' COMMENT '是否上架',
  `ship_fee` decimal(8,2) DEFAULT '0.00' COMMENT '配送费用,默认  0,   (仅自提不出现)',
  `closed` tinyint(1) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `is_fenxiao` tinyint(1) DEFAULT '0' COMMENT '是否是分销商品：0不是，1是',
  `price_type` tinyint(1) DEFAULT '0' COMMENT '价格类型：0金额，1比例',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_product_attr`;
CREATE TABLE IF NOT EXISTS `jh_weidian_product_attr` (
  `attr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `product_id` int(10) DEFAULT NULL COMMENT '团产品id,',
  `attr_name` varchar(255) DEFAULT '0' COMMENT '属性名称',
  `attr_value` varchar(255) DEFAULT '' COMMENT '属性值, 英文逗号间隔',
  `dateline` int(10) DEFAULT '0' COMMENT '单价',
  PRIMARY KEY (`attr_id`),
  KEY `tuan_product_id` (`product_id`),
  KEY `attr_name` (`attr_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_product_attr_group`;
CREATE TABLE IF NOT EXISTS `jh_weidian_product_attr_group` (
  `attr_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `orderby` tinyint(3) DEFAULT '50',
  PRIMARY KEY (`attr_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_product_attr_stock`;
CREATE TABLE IF NOT EXISTS `jh_weidian_product_attr_stock` (
  `attr_stock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0',
  `stock_name` varchar(256) DEFAULT '' COMMENT 'ID组合',
  `price` decimal(8,2) DEFAULT '0.00',
  `wei_price` decimal(8,2) DEFAULT '0.00',
  `photo` varchar(128) DEFAULT '0',
  `stock` int(10) DEFAULT '0',
  `stock_sku` varchar(32) DEFAULT '' COMMENT '商品编码',
  `sales` int(10) DEFAULT '0',
  `stock_real_name` varchar(128) DEFAULT '' COMMENT '真实规格名称',
  PRIMARY KEY (`attr_stock_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_product_attr_value`;
CREATE TABLE IF NOT EXISTS `jh_weidian_product_attr_value` (
  `attr_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_group_id` int(10) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `orderby` tinyint(3) DEFAULT '50',
  PRIMARY KEY (`attr_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_product_cate`;
CREATE TABLE IF NOT EXISTS `jh_weidian_product_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `parent_id` int(10) DEFAULT '0' COMMENT '父级分类',
  `shop_id` mediumint(8) DEFAULT '0' COMMENT '商户ID',
  `title` varchar(30) DEFAULT '' COMMENT '商品名称',
  `icon` varchar(150) DEFAULT '' COMMENT '图片',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`cate_id`),
  KEY `orderby` (`orderby`),
  KEY `shop_id` (`shop_id`,`parent_id`),
  KEY `parent_id` (`parent_id`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weidian_value`;
CREATE TABLE IF NOT EXISTS `jh_weidian_value` (
  `key` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin`;
CREATE TABLE IF NOT EXISTS `jh_weixin` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0',
  `wx_appid` varchar(30) DEFAULT '',
  `wx_appsecret` varchar(64) DEFAULT '',
  `access_token` varchar(150) DEFAULT '',
  `refresh_token` varchar(150) DEFAULT '',
  `token_expire_in` int(10) DEFAULT '0' COMMENT 'token过期时间',
  `nick_name` varchar(50) DEFAULT '' COMMENT '微信昵称',
  `verify_type` tinyint(1) DEFAULT '0' COMMENT '0:未认证,1:已认证',
  `wx_type` tinyint(1) DEFAULT '0' COMMENT '0:订阅号,1:服务号',
  `wx_name` varchar(30) DEFAULT '' COMMENT '微信号',
  `wx_ghid` varchar(30) DEFAULT '' COMMENT '微信原始ID',
  `head_img` varchar(200) DEFAULT '',
  `qrcode_url` varchar(200) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`shop_id`),
  KEY `wx_openid` (`wx_appid`),
  KEY `wx_uname` (`wx_ghid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jh_weixin_auto`;
CREATE TABLE IF NOT EXISTS `jh_weixin_auto` (
  `auto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1：文本 ，2：单图文',
  `reply_id` int(10) DEFAULT '0',
  `content` text,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_coupon`;
CREATE TABLE IF NOT EXISTS `jh_weixin_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(30) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `stime` int(10) DEFAULT '0',
  `ltime` int(10) DEFAULT '0',
  `use_tips` varchar(1024) DEFAULT '',
  `end_tips` varchar(1024) DEFAULT '',
  `end_photo` varchar(150) DEFAULT '',
  `num` mediumint(8) DEFAULT '0' COMMENT '数量',
  `max_count` mediumint(8) DEFAULT '0',
  `down_count` mediumint(8) DEFAULT '0',
  `use_count` mediumint(8) DEFAULT '0',
  `views` int(10) DEFAULT '0',
  `follower_condtion` tinyint(1) DEFAULT '0' COMMENT '关注限制，0:不限,1:必须关注',
  `member_condtion` tinyint(1) DEFAULT NULL,
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_couponsn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_couponsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_goldegg`;
CREATE TABLE IF NOT EXISTS `jh_weixin_goldegg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predict_num` int(11) NOT NULL COMMENT '参与人数',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT '填写活动开始图片网址',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `use_tips` varchar(200) NOT NULL COMMENT '简介',
  `stime` int(11) NOT NULL COMMENT '活动开始时间',
  `ltime` int(11) NOT NULL COMMENT '活动结束时间',
  `info` varchar(200) NOT NULL COMMENT '活动说明',
  `aginfo` varchar(200) NOT NULL COMMENT '重复抽奖回复',
  `end_tips` varchar(60) NOT NULL COMMENT '活动结束公告主题',
  `end_photo` varchar(100) NOT NULL,
  `fist` varchar(50) NOT NULL COMMENT '一等奖奖品设置',
  `fistnums` int(4) NOT NULL COMMENT '一等奖奖品数量',
  `fistlucknums` int(1) NOT NULL COMMENT '一等奖中奖号码',
  `second` varchar(50) NOT NULL COMMENT '二等奖奖品设置',
  `secondnums` int(4) NOT NULL,
  `secondlucknums` int(1) NOT NULL,
  `third` varchar(50) NOT NULL,
  `thirdnums` int(4) NOT NULL,
  `thirdlucknums` int(1) NOT NULL,
  `joinnum` int(10) DEFAULT NULL,
  `max_num` int(2) NOT NULL COMMENT '个人限制抽奖次数',
  `parssword` int(15) NOT NULL COMMENT '兑奖密码',
  `four` varchar(50) NOT NULL,
  `fournums` int(11) NOT NULL,
  `fourlucknums` int(11) NOT NULL,
  `five` varchar(50) NOT NULL,
  `fivenums` int(11) NOT NULL,
  `fivelucknums` int(11) NOT NULL,
  `six` varchar(50) NOT NULL COMMENT '六等奖',
  `sixnums` int(11) NOT NULL,
  `sixlucknums` int(11) NOT NULL,
  `daynums` mediumint(4) NOT NULL DEFAULT '0',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `follower_condtion` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_goldeggsn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_goldeggsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `egg_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `isegg` tinyint(1) DEFAULT NULL,
  `prize` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_help`;
CREATE TABLE IF NOT EXISTS `jh_weixin_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `ltime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `predict_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预计参与人数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '每人最多允许抽奖次数',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`help_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_helplist`;
CREATE TABLE IF NOT EXISTS `jh_weixin_helplist` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `help_id` mediumint(8) DEFAULT NULL,
  `shop_id` int(10) DEFAULT '0',
  `zhuliid` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_helpprize`;
CREATE TABLE IF NOT EXISTS `jh_weixin_helpprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `help_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_helpsn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_helpsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `help_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `zhuanfa` mediumint(8) DEFAULT '0',
  `zhuli` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_keyword`;
CREATE TABLE IF NOT EXISTS `jh_weixin_keyword` (
  `kw_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `wx_sid` varchar(50) DEFAULT '',
  `keyword` varchar(30) DEFAULT NULL,
  `plugin` varchar(50) DEFAULT NULL,
  `len` tinyint(3) DEFAULT '0',
  `type` varchar(30) DEFAULT 'text',
  `reply_id` mediumint(8) DEFAULT '0',
  `content` varchar(255) DEFAULT '',
  `hits` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`kw_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_log`;
CREATE TABLE IF NOT EXISTS `jh_weixin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weixin` varchar(50) DEFAULT '',
  `data` mediumtext,
  `post` mediumtext,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_lottery`;
CREATE TABLE IF NOT EXISTS `jh_weixin_lottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predict_num` int(11) NOT NULL COMMENT '参与人数',
  `views` int(11) NOT NULL,
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT '填写活动开始图片网址',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `txt` varchar(60) NOT NULL COMMENT '用户输入兑奖时候的显示信息',
  `use_tips` varchar(200) NOT NULL COMMENT '简介',
  `stime` int(11) NOT NULL COMMENT '活动开始时间',
  `ltime` int(11) NOT NULL COMMENT '活动结束时间',
  `info` varchar(200) NOT NULL COMMENT '活动说明',
  `aginfo` varchar(200) NOT NULL COMMENT '重复抽奖回复',
  `end_tips` varchar(60) NOT NULL COMMENT '活动结束公告主题',
  `end_photo` varchar(100) NOT NULL,
  `fist` varchar(50) NOT NULL COMMENT '一等奖奖品设置',
  `fistnums` int(4) NOT NULL COMMENT '一等奖奖品数量',
  `fistlucknums` int(1) NOT NULL COMMENT '一等奖中奖号码',
  `second` varchar(50) NOT NULL COMMENT '二等奖奖品设置',
  `secondnums` int(4) NOT NULL,
  `secondlucknums` int(1) NOT NULL,
  `third` varchar(50) NOT NULL,
  `thirdnums` int(4) NOT NULL,
  `thirdlucknums` int(1) NOT NULL,
  `allpeople` varchar(30) NOT NULL DEFAULT '' COMMENT '预计活动人数',
  `joinnum` int(10) DEFAULT NULL,
  `max_num` int(2) NOT NULL COMMENT '个人限制抽奖次数',
  `parssword` int(15) NOT NULL COMMENT '兑奖密码',
  `four` varchar(50) NOT NULL,
  `fournums` int(11) NOT NULL,
  `fourlucknums` int(11) NOT NULL,
  `five` varchar(50) NOT NULL,
  `fivenums` int(11) NOT NULL,
  `fivelucknums` int(11) NOT NULL,
  `six` varchar(50) NOT NULL COMMENT '六等奖',
  `sixnums` int(11) NOT NULL,
  `sixlucknums` int(11) NOT NULL,
  `daynums` mediumint(4) NOT NULL DEFAULT '0',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `follower_condtion` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_lotterysn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_lotterysn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lottery_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `islottery` tinyint(1) DEFAULT NULL,
  `prize` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_menu`;
CREATE TABLE IF NOT EXISTS `jh_weixin_menu` (
  `menu_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT '',
  `parent_id` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `wx_sid` varchar(50) DEFAULT '',
  `type` enum('reply','text','link') DEFAULT 'text',
  `reply_id` mediumint(8) DEFAULT '0',
  `content` varchar(255) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `orderby` smallint(6) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_packet`;
CREATE TABLE IF NOT EXISTS `jh_weixin_packet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `title` char(40) NOT NULL,
  `keyword` char(30) NOT NULL,
  `msg_pic` char(120) NOT NULL,
  `desc` varchar(200) NOT NULL,
  `info` text NOT NULL,
  `start_time` char(11) NOT NULL,
  `end_time` char(11) NOT NULL,
  `ext_total` mediumint(8) unsigned NOT NULL,
  `get_number` smallint(5) unsigned NOT NULL,
  `value_count` mediumint(8) unsigned NOT NULL,
  `is_open` enum('0','1') NOT NULL,
  `item_num` mediumint(9) NOT NULL,
  `item_sum` mediumint(9) NOT NULL,
  `item_max` mediumint(9) NOT NULL,
  `item_unit` varchar(30) NOT NULL,
  `packet_type` enum('1','2') NOT NULL,
  `deci` smallint(6) NOT NULL,
  `people` mediumint(9) NOT NULL,
  `password` char(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_packetling`;
CREATE TABLE IF NOT EXISTS `jh_weixin_packetling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `open_id` char(50) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `price` char(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `type_name` char(45) NOT NULL,
  `time` char(11) NOT NULL,
  `sn_id` text NOT NULL,
  `mobile` char(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_packetling_copy`;
CREATE TABLE IF NOT EXISTS `jh_weixin_packetling_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `open_id` char(50) NOT NULL,
  `packet_id` int(11) NOT NULL,
  `price` char(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `type_name` char(45) NOT NULL,
  `time` char(11) NOT NULL,
  `sn_id` text NOT NULL,
  `mobile` char(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_packetsn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_packetsn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `add_time` char(11) NOT NULL,
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `packet_id` int(11) NOT NULL,
  `prize_id` int(11) NOT NULL,
  `prize_name` char(40) NOT NULL,
  `worth` decimal(10,2) NOT NULL,
  `is_reward` enum('0','1','2') NOT NULL,
  `type` enum('1','2') NOT NULL,
  `code` char(40) NOT NULL,
  `open_id` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_prize`;
CREATE TABLE IF NOT EXISTS `jh_weixin_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `scratch_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT 'shop_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_relay`;
CREATE TABLE IF NOT EXISTS `jh_weixin_relay` (
  `relay_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '分享图片',
  `stime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `ltime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `relay_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分享用户参加次数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '每人最多允许次数',
  `max_gold` mediumint(8) DEFAULT NULL,
  `min_gold` mediumint(8) DEFAULT '30',
  `time` mediumint(8) DEFAULT '30',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `max_price` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`relay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_relaylist`;
CREATE TABLE IF NOT EXISTS `jh_weixin_relaylist` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `relay_id` mediumint(8) DEFAULT NULL,
  `shop_id` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '1',
  `jieliid` varchar(50) DEFAULT NULL,
  `gold` mediumint(8) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_relayprize`;
CREATE TABLE IF NOT EXISTS `jh_weixin_relayprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `relay_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_relaysn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_relaysn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `relay_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `cishu` mediumint(8) DEFAULT '0',
  `gold` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_reply`;
CREATE TABLE IF NOT EXISTS `jh_weixin_reply` (
  `reply_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `jumpurl` varchar(255) DEFAULT '',
  `content` mediumtext,
  `views` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_scratch`;
CREATE TABLE IF NOT EXISTS `jh_weixin_scratch` (
  `scratch_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `ltime` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `predict_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预计参与人数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '每人最多允许抽奖次数',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`scratch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_scratchsn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_scratchsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scratch_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `prize_id` int(10) DEFAULT NULL,
  `prize_title` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_shake`;
CREATE TABLE IF NOT EXISTS `jh_weixin_shake` (
  `shake_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` int(10) DEFAULT '0' COMMENT '开始时间',
  `ltime` int(10) DEFAULT NULL COMMENT '结束时间',
  `use_tips` varchar(1024) NOT NULL DEFAULT '' COMMENT '使用说明',
  `end_tips` varchar(1204) NOT NULL COMMENT '过期说明',
  `predict_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预计参与人数',
  `max_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '每人最多允许抽奖次数',
  `follower_condtion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '粉丝状态',
  `member_condtion` tinyint(1) NOT NULL DEFAULT '0',
  `collect_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取人数',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览人数',
  `end_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '过期提示图片',
  `lastupdate` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`shake_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_shakeprize`;
CREATE TABLE IF NOT EXISTS `jh_weixin_shakeprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shake_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_shakesn`;
CREATE TABLE IF NOT EXISTS `jh_weixin_shakesn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shake_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `prize_id` int(10) DEFAULT NULL,
  `prize_title` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixin_welcome`;
CREATE TABLE IF NOT EXISTS `jh_weixin_welcome` (
  `welcome_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1：文本 ，2：单图文',
  `reply_id` int(10) DEFAULT '0',
  `content` text,
  PRIMARY KEY (`welcome_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `jh_weixiu_attr`;
CREATE TABLE IF NOT EXISTS `jh_weixiu_attr` (
  `staff_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '服务人员ID',
  `cate_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '服务项目分类ID',
  `cate_title` varchar(30) DEFAULT '',
  PRIMARY KEY (`staff_id`,`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='维修服务人员属性';

DROP TABLE IF EXISTS `jh_weixiu_cate`;
CREATE TABLE IF NOT EXISTS `jh_weixiu_cate` (
  `cate_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `parent_id` smallint(6) DEFAULT '0' COMMENT '父ID',
  `title` varchar(30) DEFAULT '' COMMENT '维修项目名称',
  `icon` varchar(150) DEFAULT '' COMMENT '图标',
  `photo` varchar(150) DEFAULT '' COMMENT '图片',
  `price` decimal(8,2) DEFAULT '0.00' COMMENT '订金',
  `orders` mediumint(8) DEFAULT '0' COMMENT '订单数',
  `info` mediumtext COMMENT '介绍',
  `orderby` smallint(6) DEFAULT '50' COMMENT '排序',
  `dateline` int(10) DEFAULT '0' COMMENT '创建时间',
  `unit` tinyint(3) DEFAULT '0' COMMENT '计量单位  (个，件，次)',
  `start` int(10) DEFAULT '0' COMMENT '起步价',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='维修服务项目分类信息' AUTO_INCREMENT=1 ;
