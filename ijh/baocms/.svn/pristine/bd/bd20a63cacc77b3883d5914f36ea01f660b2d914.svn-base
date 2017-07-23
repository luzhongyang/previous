ALTER TABLE `bao_shop_news`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0;

ALTER TABLE `bao_article`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0;

ALTER TABLE `bao_city`
ADD COLUMN `theme`  varchar(32) NULL DEFAULT 'default';

ALTER TABLE `bao_market`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 ;

ALTER TABLE `bao_housework`
ADD COLUMN `city_id`  smallint(5) NULL DEFAULT 0 ;

ALTER TABLE `bao_weixin_relay`
ADD COLUMN `owner_maxgold`  mediumint(9) NULL ;

CREATE TABLE `bao_weixin_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(30) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `stime` date DEFAULT NULL,
  `ltime` date DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_couponsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(10) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_goldegg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predict_num` int(11) NOT NULL COMMENT '参与人数',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT '填写活动开始图片网址',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `use_tips` varchar(200) NOT NULL COMMENT '简介',
  `stime` date DEFAULT NULL COMMENT '活动开始时间',
  `ltime` date DEFAULT NULL COMMENT '活动结束时间',
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
  PRIMARY KEY (`id`),
  KEY `token` (`shop_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

CREATE TABLE `bao_weixin_goldeggsn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `egg_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` int(11) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `isegg` tinyint(1) DEFAULT NULL,
  `prize` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_helplist` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `help_id` mediumint(8) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `zhuliid` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_helpprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `help_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'wx_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_helpsn` (
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
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_lottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predict_num` int(11) NOT NULL COMMENT '参与人数',
  `views` int(11) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `keyword` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT '填写活动开始图片网址',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `txt` varchar(60) NOT NULL COMMENT '用户输入兑奖时候的显示信息',
  `use_tips` varchar(200) NOT NULL COMMENT '简介',
  `stime` date DEFAULT NULL COMMENT '活动开始时间',
  `ltime` date DEFAULT NULL COMMENT '活动结束时间',
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
  PRIMARY KEY (`id`),
  KEY `token` (`shop_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_lotterysn` (
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
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_packet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_packetling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_packetling_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_packetsn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `add_time` char(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `packet_id` int(11) NOT NULL,
  `prize_id` int(11) NOT NULL,
  `prize_name` char(40) NOT NULL,
  `worth` decimal(10,2) NOT NULL,
  `is_reward` enum('0','1','2') NOT NULL,
  `type` enum('1','2') NOT NULL,
  `code` char(40) NOT NULL,
  `open_id` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `scratch_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'shop_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_qrcode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0',
  `soure_id` smallint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_relay` (
  `relay_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '分享图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
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
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`relay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_relaylist` (
  `list_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `openid` varchar(150) DEFAULT NULL,
  `relay_id` mediumint(8) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `jieliid` varchar(50) DEFAULT NULL,
  `gold` mediumint(8) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_relayprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `relay_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'shop_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_relaysn` (
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
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_scratch` (
  `scratch_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_scratchsn` (
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
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_shake` (
  `shake_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) DEFAULT '0',
  `keyword` varchar(50) NOT NULL DEFAULT '' COMMENT '关键词',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面简介',
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '封面图片',
  `stime` date DEFAULT NULL COMMENT '开始时间',
  `ltime` date DEFAULT NULL COMMENT '结束时间',
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_shakeprize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shake_id` int(10) unsigned NOT NULL COMMENT '来源ID',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `name` varchar(255) NOT NULL COMMENT '奖项',
  `num` int(10) unsigned NOT NULL COMMENT '名额数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `photo` varchar(225) NOT NULL COMMENT '奖品图片',
  `shop_id` int(10) NOT NULL COMMENT 'wx_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
CREATE TABLE `bao_weixin_shakesn` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shake_id` int(10) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` varchar(30) DEFAULT '0',
  `openid` varchar(150) DEFAULT '',
  `nickname` varchar(50) DEFAULT NULL,
  `sn` varchar(15) DEFAULT '',
  `is_use` tinyint(1) DEFAULT '0',
  `use_time` int(10) DEFAULT '0',
  `prize_id` int(10) DEFAULT NULL,
  `prize_title` varchar(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

ALTER TABLE `bao_post`
ADD COLUMN `city_id`  smallint(5) DEFAULT '0' AFTER `community_id`;
ALTER TABLE `bao_weixin_shakesn`
ADD COLUMN `img`  varchar(200) NULL ;
ALTER TABLE `bao_weixin_scratchsn`
ADD COLUMN `img`  varchar(200) NULL ;
ALTER TABLE `bao_weixin_goldeggsn`
ADD COLUMN `img`  varchar(200) NULL ;
