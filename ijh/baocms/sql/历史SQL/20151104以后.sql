DROP TABLE IF EXISTS `bao_post_pics`;
CREATE TABLE `bao_post_pics` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) DEFAULT '0',
  `pic` varchar(128) DEFAULT '',
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

ALTER TABLE `bao_convenient_phone`
ADD COLUMN `community_id`  int(10) NULL DEFAULT 0 AFTER `phone_id`;


DROP TABLE IF EXISTS `bao_community_ad`;
CREATE TABLE `bao_community_ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT '',
  `link_url` varchar(128) DEFAULT '',
  `photo` varchar(128) DEFAULT '',
  `orderby` tinyint(1) DEFAULT '100',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_community_owner`;
CREATE TABLE `bao_community_owner` (
  `owner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `name` varchar(32) DEFAULT '' COMMENT '称呼',
  `number` int(10) DEFAULT '0' COMMENT '户号',
  `location` varchar(64) DEFAULT '' COMMENT '具体地址',
  `audit` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bao_community_order`;
CREATE TABLE `bao_community_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `order_date` char(7) DEFAULT '2015-10',
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_community_order_products`;
CREATE TABLE `bao_community_order_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0' COMMENT '1水费  2电费 3燃气费 4停车费 5物业费',
  `order_id` int(10) DEFAULT '0',
  `money` int(10) DEFAULT '0',
  `bg_date` char(10) DEFAULT NULL,
  `end_date` char(10) DEFAULT NULL,
  `is_pay` tinyint(1) DEFAULT '0' COMMENT '0未缴 1已缴',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



ALTER TABLE `bao_post`
ADD COLUMN `community_id`  int(10) NULL DEFAULT 0 AFTER `post_id`,
ADD COLUMN `closed`  tinyint(1) NULL DEFAULT 0 AFTER `last_time`;


DROP TABLE IF EXISTS `bao_community_order_logs`;
CREATE TABLE `bao_community_order_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `money` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_cloud_goods`;
CREATE TABLE `bao_cloud_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0' COMMENT '0表示后台发布',
  `city_id` int(10) DEFAULT '0',
  `area_id` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0' COMMENT '1表示1元夺宝，2代表5元夺宝，3代表10元夺宝',
  `title` varchar(64) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `details` text,
  `join` int(10) DEFAULT '0' COMMENT '已参与',
  `price` int(10) DEFAULT '0' COMMENT '总价格',
  `max` int(10) DEFAULT '0' COMMENT '该件商品最大允许的参与数',
  `settlement_price` int(10) DEFAULT '0',
  `photo` varchar(128) DEFAULT '',
  `thumb` text,
  `status` tinyint(4) DEFAULT '0' COMMENT '0表示正在云购中，1表示已结束',
  `win_user_id` int(10) DEFAULT '0' COMMENT '中奖UID',
  `win_number` int(10) DEFAULT '0' COMMENT '中奖编号',
  `closed` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `lottery_time` int(10) DEFAULT '0' COMMENT '开奖时间',
  `create_time` int(10) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100001 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `bao_cloud_logs`;
CREATE TABLE `bao_cloud_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `num` int(10) DEFAULT '0',
  `create_time` int(10) DEFAULT '0',
  `microtime` varchar(3) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bao_ad_site`;
CREATE TABLE `bao_ad_site` (
  `site_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(32) DEFAULT NULL,
  `site_name` varchar(64) DEFAULT NULL,
  `site_type` tinyint(1) DEFAULT NULL,
  `site_place` smallint(5) DEFAULT '0',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bao_ad_site
-- ----------------------------
INSERT INTO `bao_ad_site` VALUES ('1', 'default', 'PC首页轮播图片广告位', '2', '1');
INSERT INTO `bao_ad_site` VALUES ('2', 'default', 'PC首页优惠券顶部图片广告位', '2', '1');
INSERT INTO `bao_ad_site` VALUES ('3', 'default', 'PC活动首页轮播图片广告位', '2', '3');
INSERT INTO `bao_ad_site` VALUES ('4', 'default', 'PC上门服务图片广告位', '2', '4');
INSERT INTO `bao_ad_site` VALUES ('5', 'default', 'PC同城优购主页图片广告位', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('6', 'default', 'PC同城优购优惠专区左侧图片广告位', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('7', 'default', 'PC同城优购优惠专区右侧图片广告位', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('8', 'default', 'PC同城优购主页1楼图片广告', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('9', 'default', 'PC同城优购主页2楼图片广告', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('10', 'default', 'PC同城优购主页3楼图片广告', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('11', 'default', 'PC同城优购主页4楼图片广告', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('12', 'default', 'PC同城优购主页5楼图片广告', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('13', 'default', 'PC同城优购主页6楼图片广告', '2', '5');
INSERT INTO `bao_ad_site` VALUES ('14', 'default', 'PC外卖首页轮播图片广告位', '2', '6');
INSERT INTO `bao_ad_site` VALUES ('15', 'default', 'PC订座首页右侧轮播图片广告', '2', '7');
INSERT INTO `bao_ad_site` VALUES ('16', 'default', 'PC订座列表右侧轮播图片广告', '2', '7');
INSERT INTO `bao_ad_site` VALUES ('17', 'default', 'PC订座新单右侧轮播图片广告', '2', '7');
INSERT INTO `bao_ad_site` VALUES ('18', 'default', 'PC订座热门右侧轮播图片广告', '2', '7');
INSERT INTO `bao_ad_site` VALUES ('19', 'default', 'PC同城信息主页头部轮播图片广告位', '2', '8');
INSERT INTO `bao_ad_site` VALUES ('20', 'default', 'PC同城信息主页右侧轮播图片广告位', '2', '8');
INSERT INTO `bao_ad_site` VALUES ('21', 'default', 'PC同城信息主页底部轮播图片广告位', '2', '8');
INSERT INTO `bao_ad_site` VALUES ('22', 'default', 'PC同城信息首页右侧轮播图片广告位', '2', '8');
INSERT INTO `bao_ad_site` VALUES ('23', 'default', 'PC优惠券首页轮播图片广告位', '2', '9');
INSERT INTO `bao_ad_site` VALUES ('24', 'default', 'PC积分商城首页轮播图片广告位', '2', '11');
INSERT INTO `bao_ad_site` VALUES ('25', 'default', 'PC专题1首页图片广告位', '2', '13');
INSERT INTO `bao_ad_site` VALUES ('26', 'default', 'PC专题2首页图片广告位', '2', '13');
INSERT INTO `bao_ad_site` VALUES ('27', 'default', 'PC专题3首页图片广告位', '2', '13');
INSERT INTO `bao_ad_site` VALUES ('28', 'default', 'PC专题4首页图片广告位', '2', '13');
INSERT INTO `bao_ad_site` VALUES ('29', 'default', 'PC专题5首页图片广告位', '2', '13');
INSERT INTO `bao_ad_site` VALUES ('30', 'default', '手机同城优购首页轮播广告位', '2', '18');
INSERT INTO `bao_ad_site` VALUES ('31', 'default', '手机家政首页图片广告位', '2', '19');
INSERT INTO `bao_ad_site` VALUES ('32', 'default', '手机优惠券首页轮播图片广告位', '2', '23');
INSERT INTO `bao_ad_site` VALUES ('33', 'default', '手机社区详情页轮播图片广告位', '2', '24');
INSERT INTO `bao_ad_site` VALUES ('34', 'default', '手机卖场首页轮播图片广告位', '2', '25');
INSERT INTO `bao_ad_site` VALUES ('35', 'default', '手机微店列表页轮播图片广告位', '2', '29');
INSERT INTO `bao_ad_site` VALUES ('36', 'default', '手机附近工作图片广告位', '2', '32');
INSERT INTO `bao_ad_site` VALUES ('37', 'default', '手机APP首页轮播图片广告位', '2', '33');
INSERT INTO `bao_ad_site` VALUES ('38', 'default', 'PC首页活动图片广告位', '2', '1');
INSERT INTO `bao_ad_site` VALUES ('39', 'default', '手机首页轮播图片广告位', '2', '14');
INSERT INTO `bao_ad_site` VALUES ('40', 'default', '手机社区通告页面图片轮播广告位', '2', '24');
INSERT INTO `bao_ad_site` VALUES ('41', 'default', 'PC贴吧首页和详情页轮播图片广告位', '2', '34');
INSERT INTO `bao_ad_site` VALUES ('42', 'default', 'PC新闻首页轮播广告位', '2', '35');
INSERT INTO `bao_ad_site` VALUES ('43', 'default', 'PC一元云购首页轮播广告位', '2', '36');


DROP TABLE IF EXISTS `bao_menu`;
CREATE TABLE `bao_menu` (
  `menu_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(32) DEFAULT NULL,
  `menu_action` varchar(64) DEFAULT NULL,
  `parent_id` smallint(5) DEFAULT '0',
  `orderby` tinyint(3) unsigned DEFAULT '100' COMMENT '1排序第一',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0代表不直接显示',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=565 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bao_menu
-- ----------------------------
INSERT INTO `bao_menu` VALUES ('1', '系统', null, '0', '1', '1');
INSERT INTO `bao_menu` VALUES ('2', '设置', null, '0', '2', '1');
INSERT INTO `bao_menu` VALUES ('3', '商家', null, '0', '3', '1');
INSERT INTO `bao_menu` VALUES ('4', '会员', null, '0', '4', '1');
INSERT INTO `bao_menu` VALUES ('5', '商城', null, '0', '5', '1');
INSERT INTO `bao_menu` VALUES ('203', '支付方式', 'payment/index', '202', '1', '1');
INSERT INTO `bao_menu` VALUES ('7', '功能', null, '0', '6', '1');
INSERT INTO `bao_menu` VALUES ('8', '运营', null, '0', '10', '1');
INSERT INTO `bao_menu` VALUES ('9', '管理员管理', null, '1', '2', '1');
INSERT INTO `bao_menu` VALUES ('11', '后台菜单管理', null, '1', '1', '1');
INSERT INTO `bao_menu` VALUES ('12', '菜单列表', 'menu/index', '11', '2', '1');
INSERT INTO `bao_menu` VALUES ('13', '新增菜单', 'menu/create', '11', '3', '0');
INSERT INTO `bao_menu` VALUES ('14', '编辑菜单', 'menu/edit', '11', '1', '0');
INSERT INTO `bao_menu` VALUES ('15', '删除菜单', 'menu/delete', '11', '3', '0');
INSERT INTO `bao_menu` VALUES ('16', '更新菜单', 'menu/update', '11', '4', '0');
INSERT INTO `bao_menu` VALUES ('17', '批量菜单', 'menu/action', '11', '1', '0');
INSERT INTO `bao_menu` VALUES ('18', '角色管理', 'role/index', '9', '2', '1');
INSERT INTO `bao_menu` VALUES ('25', '新增角色', 'role/create', '9', '7', '0');
INSERT INTO `bao_menu` VALUES ('26', '编辑角色', 'role/edit', '9', '1', '0');
INSERT INTO `bao_menu` VALUES ('27', '删除角色', 'role/delete', '9', '2', '0');
INSERT INTO `bao_menu` VALUES ('28', '角色授权', 'role/auth', '9', '8', '0');
INSERT INTO `bao_menu` VALUES ('29', '管理员管理', 'admin/index', '9', '1', '1');
INSERT INTO `bao_menu` VALUES ('30', '新增管理员', 'admin/create', '9', '2', '0');
INSERT INTO `bao_menu` VALUES ('31', '编辑管理员', 'admin/edit', '9', '2', '0');
INSERT INTO `bao_menu` VALUES ('32', '删除管理员', 'admin/delete', '9', '4', '0');
INSERT INTO `bao_menu` VALUES ('33', '会员管理', null, '4', '1', '1');
INSERT INTO `bao_menu` VALUES ('34', '会员管理', 'user/index', '33', '3', '1');
INSERT INTO `bao_menu` VALUES ('35', '新增会员', 'user/create', '33', '2', '0');
INSERT INTO `bao_menu` VALUES ('36', '编辑会员', 'user/edit', '33', '6', '0');
INSERT INTO `bao_menu` VALUES ('37', '删除会员', 'user/delete', '33', '4', '0');
INSERT INTO `bao_menu` VALUES ('60', '预约订座', null, '3', '4', '1');
INSERT INTO `bao_menu` VALUES ('39', '缓存管理', null, '8', '6', '1');
INSERT INTO `bao_menu` VALUES ('40', '清空缓存', 'clean/cache', '39', '100', '1');
INSERT INTO `bao_menu` VALUES ('41', '审核会员', 'user/audit', '33', '3', '0');
INSERT INTO `bao_menu` VALUES ('42', '商家分类', null, '3', '1', '1');
INSERT INTO `bao_menu` VALUES ('43', '商家管理', null, '3', '2', '1');
INSERT INTO `bao_menu` VALUES ('44', '分类列表', 'shopcate/index', '42', '1', '1');
INSERT INTO `bao_menu` VALUES ('45', '新增分类', 'shopcate/create', '42', '2', '0');
INSERT INTO `bao_menu` VALUES ('46', '编辑分类', 'shopcate/edit', '42', '3', '0');
INSERT INTO `bao_menu` VALUES ('47', '删除分类', 'shopcate/delete', '42', '4', '0');
INSERT INTO `bao_menu` VALUES ('48', '更新排序', 'shopcate/update', '42', '5', '0');
INSERT INTO `bao_menu` VALUES ('49', '基本设置', null, '2', '1', '1');
INSERT INTO `bao_menu` VALUES ('50', '区域设置', null, '2', '3', '1');
INSERT INTO `bao_menu` VALUES ('51', '区域管理', 'area/index', '50', '11', '1');
INSERT INTO `bao_menu` VALUES ('52', '新增区域', 'area/create', '50', '12', '0');
INSERT INTO `bao_menu` VALUES ('53', '编辑区域', 'area/edit', '50', '13', '0');
INSERT INTO `bao_menu` VALUES ('54', '删除区域', 'area/delete', '50', '14', '0');
INSERT INTO `bao_menu` VALUES ('55', '商圈管理', 'business/index', '50', '15', '0');
INSERT INTO `bao_menu` VALUES ('56', '新增商圈', 'business/create', '50', '19', '0');
INSERT INTO `bao_menu` VALUES ('57', '编辑商圈', 'business/edit', '50', '18', '0');
INSERT INTO `bao_menu` VALUES ('58', '删除商圈', 'business/delete', '50', '17', '0');
INSERT INTO `bao_menu` VALUES ('277', '审核商家', 'shop/audit', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('61', '文章内容', null, '7', '2', '1');
INSERT INTO `bao_menu` VALUES ('62', '抢购', null, '5', '3', '1');
INSERT INTO `bao_menu` VALUES ('65', '友情链接', null, '8', '4', '1');
INSERT INTO `bao_menu` VALUES ('66', '广告管理', null, '8', '1', '1');
INSERT INTO `bao_menu` VALUES ('202', '支付设置', null, '2', '2', '1');
INSERT INTO `bao_menu` VALUES ('215', '微信', null, '0', '9', '1');
INSERT INTO `bao_menu` VALUES ('70', '友情链接', 'links/index', '65', '100', '1');
INSERT INTO `bao_menu` VALUES ('71', '添加友情', 'links/create', '65', '100', '0');
INSERT INTO `bao_menu` VALUES ('72', '修改友情', 'links/edit', '65', '100', '0');
INSERT INTO `bao_menu` VALUES ('73', '删除友情', 'links/delete', '65', '100', '0');
INSERT INTO `bao_menu` VALUES ('278', '积分兑换', 'integralexchange/index', '234', '2', '1');
INSERT INTO `bao_menu` VALUES ('279', '设为已完成兑换', 'integralexchange/audit', '234', '2', '0');
INSERT INTO `bao_menu` VALUES ('280', '设为热门分类', 'shopcate/hots', '42', '6', '0');
INSERT INTO `bao_menu` VALUES ('80', '站点设置', 'setting/site', '49', '1', '1');
INSERT INTO `bao_menu` VALUES ('81', '附件设置', 'setting/attachs', '49', '2', '1');
INSERT INTO `bao_menu` VALUES ('270', '选择分类', 'activitycate/select', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('85', '商家列表', 'shop/index', '43', '2', '1');
INSERT INTO `bao_menu` VALUES ('86', '新增商家', 'shop/create', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('87', '修改商家', 'shop/edit', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('88', '删除商家', 'shop/delete', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('90', '异步选择会员', 'user/select', '33', '2', '0');
INSERT INTO `bao_menu` VALUES ('91', '异步查询商圈', 'business/child', '50', '20', '0');
INSERT INTO `bao_menu` VALUES ('95', '预定合作', 'shop/yuyue', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('96', '商家新闻', 'shopnews/index', '228', '2', '1');
INSERT INTO `bao_menu` VALUES ('97', '发布新闻', 'shopnews/create', '228', '1', '1');
INSERT INTO `bao_menu` VALUES ('98', '修改新闻', 'shopnews/edit', '228', '3', '0');
INSERT INTO `bao_menu` VALUES ('99', '删除新闻', 'shopnews/delete', '228', '4', '0');
INSERT INTO `bao_menu` VALUES ('100', '审核新闻', 'shopnews/audit', '228', '5', '0');
INSERT INTO `bao_menu` VALUES ('101', '商家异步查询', 'shop/select', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('102', '商家图片', 'shoppic/index', '43', '41', '1');
INSERT INTO `bao_menu` VALUES ('103', '删除图片', 'shoppic/delete', '43', '42', '0');
INSERT INTO `bao_menu` VALUES ('104', '异步查询', 'articlecate/child', '61', '3', '0');
INSERT INTO `bao_menu` VALUES ('105', '更新排序', 'articlecate/update', '61', '4', '0');
INSERT INTO `bao_menu` VALUES ('106', '删除分类', 'articlecate/delete', '61', '5', '0');
INSERT INTO `bao_menu` VALUES ('107', '编辑分类', 'articlecate/edit', '61', '6', '0');
INSERT INTO `bao_menu` VALUES ('108', '新增分类', 'articlecate/create', '61', '7', '0');
INSERT INTO `bao_menu` VALUES ('109', '分类列表', 'articlecate/index', '61', '1', '1');
INSERT INTO `bao_menu` VALUES ('110', '文章管理', 'article/index', '61', '2', '1');
INSERT INTO `bao_menu` VALUES ('111', '新增文章', 'article/create', '61', '8', '0');
INSERT INTO `bao_menu` VALUES ('112', '编辑文章', 'article/edit', '61', '9', '0');
INSERT INTO `bao_menu` VALUES ('113', '删除文章', 'article/delete', '61', '10', '0');
INSERT INTO `bao_menu` VALUES ('114', '消费分享', null, '7', '2', '1');
INSERT INTO `bao_menu` VALUES ('115', '敏感词过滤', 'sensitive/index', '49', '3', '1');
INSERT INTO `bao_menu` VALUES ('116', '新增敏感词', 'sensitive/create', '49', '4', '0');
INSERT INTO `bao_menu` VALUES ('117', '编辑敏感词', 'sensitive/edit', '49', '5', '0');
INSERT INTO `bao_menu` VALUES ('118', '删除敏感词', 'sensitive/delete', '49', '6', '0');
INSERT INTO `bao_menu` VALUES ('119', '消费分享', 'post/index', '114', '1', '1');
INSERT INTO `bao_menu` VALUES ('120', '新增分享', 'post/create', '114', '2', '0');
INSERT INTO `bao_menu` VALUES ('121', '编辑分享', 'post/edit', '114', '3', '0');
INSERT INTO `bao_menu` VALUES ('122', '删除分享', 'post/delete', '114', '4', '0');
INSERT INTO `bao_menu` VALUES ('123', '审核分享', 'post/audit', '114', '5', '0');
INSERT INTO `bao_menu` VALUES ('509', '会员提现', null, '4', '100', '1');
INSERT INTO `bao_menu` VALUES ('125', '抢购列表', 'tuan/index', '62', '1', '1');
INSERT INTO `bao_menu` VALUES ('126', '新增抢购', 'tuan/create', '62', '14', '0');
INSERT INTO `bao_menu` VALUES ('127', '编辑抢购', 'tuan/edit', '62', '11', '0');
INSERT INTO `bao_menu` VALUES ('128', '删除抢购', 'tuan/delete', '62', '12', '0');
INSERT INTO `bao_menu` VALUES ('129', '审核抢购', 'tuan/audit', '62', '13', '0');
INSERT INTO `bao_menu` VALUES ('130', '订单管理', 'tuanorder/index', '62', '20', '1');
INSERT INTO `bao_menu` VALUES ('206', '支付日志', 'paymentlogs/index', '202', '4', '1');
INSERT INTO `bao_menu` VALUES ('134', '优惠券', null, '5', '5', '1');
INSERT INTO `bao_menu` VALUES ('135', '优惠券管理', 'coupon/index', '134', '1', '1');
INSERT INTO `bao_menu` VALUES ('136', '新增优惠券', 'coupon/create', '134', '2', '0');
INSERT INTO `bao_menu` VALUES ('137', '编辑优惠券', 'coupon/edit', '134', '3', '0');
INSERT INTO `bao_menu` VALUES ('138', '删除优惠券', 'coupon/delete', '134', '4', '0');
INSERT INTO `bao_menu` VALUES ('139', '审核优惠券', 'coupon/audit', '134', '5', '0');
INSERT INTO `bao_menu` VALUES ('140', '优惠券下载', 'coupondownload/index', '134', '6', '1');
INSERT INTO `bao_menu` VALUES ('142', '回复帖子', 'postreply/index', '114', '11', '1');
INSERT INTO `bao_menu` VALUES ('143', '新增回复', 'postreply/create', '114', '12', '0');
INSERT INTO `bao_menu` VALUES ('144', '编辑回复', 'postreply/edit', '114', '13', '0');
INSERT INTO `bao_menu` VALUES ('145', '删除回复', 'postreply/delete', '114', '14', '0');
INSERT INTO `bao_menu` VALUES ('146', '审核回复', 'postreply/audit', '114', '15', '0');
INSERT INTO `bao_menu` VALUES ('156', '短信设置', 'setting/sms', '49', '11', '1');
INSERT INTO `bao_menu` VALUES ('157', '邮件设置', 'setting/mail', '49', '12', '1');
INSERT INTO `bao_menu` VALUES ('158', '模版管理', null, '2', '4', '1');
INSERT INTO `bao_menu` VALUES ('159', '短信模版', 'sms/index', '158', '11', '1');
INSERT INTO `bao_menu` VALUES ('160', '新增短信模版', 'sms/create', '158', '12', '0');
INSERT INTO `bao_menu` VALUES ('161', '编辑短信模版', 'sms/edit', '158', '13', '0');
INSERT INTO `bao_menu` VALUES ('162', '关闭短信模版', 'sms/delete', '158', '14', '0');
INSERT INTO `bao_menu` VALUES ('163', '邮件模版', 'email/index', '158', '21', '1');
INSERT INTO `bao_menu` VALUES ('164', '新增邮件模版', 'email/create', '158', '22', '0');
INSERT INTO `bao_menu` VALUES ('165', '编辑邮件模版', 'email/edit', '158', '23', '0');
INSERT INTO `bao_menu` VALUES ('166', '关闭邮件模版', 'email/delete', '158', '24', '0');
INSERT INTO `bao_menu` VALUES ('167', 'SEO模版', 'seo/index', '158', '31', '1');
INSERT INTO `bao_menu` VALUES ('168', '新增SEO模版', 'seo/create', '158', '100', '0');
INSERT INTO `bao_menu` VALUES ('169', '编辑SEO模版', 'seo/edit', '158', '100', '0');
INSERT INTO `bao_menu` VALUES ('170', '删除SEO模版', 'seo/delete', '158', '100', '0');
INSERT INTO `bao_menu` VALUES ('171', '网站风格', 'template/index', '158', '40', '1');
INSERT INTO `bao_menu` VALUES ('172', '安装风格', 'template/install', '158', '42', '0');
INSERT INTO `bao_menu` VALUES ('173', '卸载风格', 'template/uninstall', '158', '41', '0');
INSERT INTO `bao_menu` VALUES ('174', '配置风格', 'template/setting', '158', '43', '0');
INSERT INTO `bao_menu` VALUES ('175', '批量开启短信', 'sms/audit', '158', '15', '0');
INSERT INTO `bao_menu` VALUES ('176', '开启邮件模版', 'email/audit', '158', '25', '0');
INSERT INTO `bao_menu` VALUES ('177', '商家点评', 'shopdianping/index', '230', '22', '1');
INSERT INTO `bao_menu` VALUES ('178', '发布点评', 'shopdianping/create', '230', '21', '1');
INSERT INTO `bao_menu` VALUES ('179', '编辑点评', 'shopdianping/edit', '230', '23', '0');
INSERT INTO `bao_menu` VALUES ('180', '删除点评', 'shopdianping/delete', '230', '24', '0');
INSERT INTO `bao_menu` VALUES ('181', '商家预约', 'shopyuyue/index', '60', '31', '1');
INSERT INTO `bao_menu` VALUES ('182', '新增预约', 'shopyuyue/create', '60', '32', '0');
INSERT INTO `bao_menu` VALUES ('183', '编辑预约', 'shopyuyue/edit', '60', '33', '0');
INSERT INTO `bao_menu` VALUES ('184', '删除预约', 'shopyuyue/delete', '60', '34', '0');
INSERT INTO `bao_menu` VALUES ('185', '系统文章', 'systemcontent/index', '61', '21', '1');
INSERT INTO `bao_menu` VALUES ('186', '新增系统文章', 'systemcontent/create', '61', '22', '0');
INSERT INTO `bao_menu` VALUES ('187', '编辑系统文章', 'systemcontent/edit', '61', '23', '0');
INSERT INTO `bao_menu` VALUES ('188', '删除系统文章', 'systemcontent/delete', '61', '24', '0');
INSERT INTO `bao_menu` VALUES ('189', '广告位设置', 'adsite/index', '66', '1', '1');
INSERT INTO `bao_menu` VALUES ('494', '人才招聘', null, '487', '10', '1');
INSERT INTO `bao_menu` VALUES ('495', '人才招聘', 'work/index', '494', '1', '1');
INSERT INTO `bao_menu` VALUES ('193', '广告管理', 'ad/index', '66', '11', '0');
INSERT INTO `bao_menu` VALUES ('194', '新增广告', 'ad/create', '66', '12', '0');
INSERT INTO `bao_menu` VALUES ('195', '编辑广告', 'ad/edit', '66', '13', '0');
INSERT INTO `bao_menu` VALUES ('196', '删除广告', 'ad/delete', '66', '14', '0');
INSERT INTO `bao_menu` VALUES ('197', '设为默认模版', 'template/df', '158', '44', '0');
INSERT INTO `bao_menu` VALUES ('198', '新增挂件', 'template/add', '158', '45', '0');
INSERT INTO `bao_menu` VALUES ('199', '编辑挂件', 'template/edit', '158', '46', '0');
INSERT INTO `bao_menu` VALUES ('200', '删除挂件', 'template/delete', '158', '47', '0');
INSERT INTO `bao_menu` VALUES ('201', '更新模版', 'template/update', '158', '48', '0');
INSERT INTO `bao_menu` VALUES ('204', '安装支付', 'payment/install', '202', '2', '0');
INSERT INTO `bao_menu` VALUES ('205', '卸载支付', 'payment/uninstall', '202', '3', '0');
INSERT INTO `bao_menu` VALUES ('259', '积分设置', 'setting/integral', '49', '13', '1');
INSERT INTO `bao_menu` VALUES ('441', '资金记录', 'shopmoney/index', '440', '1', '1');
INSERT INTO `bao_menu` VALUES ('209', '抢购券管理', 'tuancode/index', '62', '33', '1');
INSERT INTO `bao_menu` VALUES ('210', '删除抢购券', 'tuancode/delete', '62', '34', '0');
INSERT INTO `bao_menu` VALUES ('211', '积分日志', 'userintegrallogs/index', '291', '40', '1');
INSERT INTO `bao_menu` VALUES ('212', '增加积分', 'user/integral', '33', '8', '0');
INSERT INTO `bao_menu` VALUES ('213', '金块日志', 'usergoldlogs/index', '291', '42', '1');
INSERT INTO `bao_menu` VALUES ('214', '增加金块', 'user/gold', '33', '9', '0');
INSERT INTO `bao_menu` VALUES ('216', '微信O2O', null, '215', '1', '1');
INSERT INTO `bao_menu` VALUES ('217', '商家微信', null, '215', '2', '1');
INSERT INTO `bao_menu` VALUES ('218', '微信配置', 'setting/weixin', '216', '1', '1');
INSERT INTO `bao_menu` VALUES ('219', '微信关键字', 'weixinkeyword/index', '216', '2', '1');
INSERT INTO `bao_menu` VALUES ('220', '新增关键字', 'weixinkeyword/create', '216', '3', '0');
INSERT INTO `bao_menu` VALUES ('221', '编辑关键字', 'weixinkeyword/edit', '216', '4', '0');
INSERT INTO `bao_menu` VALUES ('222', '删除关键字', 'weixinkeyword/delete', '216', '5', '0');
INSERT INTO `bao_menu` VALUES ('223', '商家商品', 'goods/index', '231', '51', '1');
INSERT INTO `bao_menu` VALUES ('224', '新增商品', 'goods/create', '231', '52', '0');
INSERT INTO `bao_menu` VALUES ('225', '编辑商品', 'goods/edit', '231', '53', '0');
INSERT INTO `bao_menu` VALUES ('226', '删除商品', 'goods/delete', '231', '54', '0');
INSERT INTO `bao_menu` VALUES ('227', '审核商品', 'goods/audit', '231', '55', '0');
INSERT INTO `bao_menu` VALUES ('228', '商家新闻', null, '3', '6', '1');
INSERT INTO `bao_menu` VALUES ('230', '商家点评', null, '3', '5', '1');
INSERT INTO `bao_menu` VALUES ('231', '商家产品', null, '5', '1', '1');
INSERT INTO `bao_menu` VALUES ('486', '榜单分类', 'billcate/index', '483', '1', '1');
INSERT INTO `bao_menu` VALUES ('234', '积分商城', null, '335', '6', '1');
INSERT INTO `bao_menu` VALUES ('235', '商品列表', 'integralgoods/index', '234', '1', '1');
INSERT INTO `bao_menu` VALUES ('236', '新增商品', 'integralgoods/create', '234', '1', '0');
INSERT INTO `bao_menu` VALUES ('237', '修改商品', 'integralgoods/edit', '234', '1', '0');
INSERT INTO `bao_menu` VALUES ('238', '删除商品', 'integralgoods/delete', '234', '1', '0');
INSERT INTO `bao_menu` VALUES ('239', '审核商品', 'integralgoods/audit', '234', '1', '0');
INSERT INTO `bao_menu` VALUES ('240', '会员等级', 'userrank/index', '33', '21', '1');
INSERT INTO `bao_menu` VALUES ('241', '新增等级', 'userrank/create', '33', '22', '0');
INSERT INTO `bao_menu` VALUES ('242', '编辑等级', 'userrank/edit', '33', '23', '0');
INSERT INTO `bao_menu` VALUES ('243', '删除等级', 'userrank/delete', '33', '24', '0');
INSERT INTO `bao_menu` VALUES ('244', '活动管理', null, '7', '5', '1');
INSERT INTO `bao_menu` VALUES ('245', '活动列表', 'activity/index', '244', '2', '1');
INSERT INTO `bao_menu` VALUES ('246', '活动添加', 'activity/create', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('247', '活动审核', 'activity/audit', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('248', '活动编辑', 'activity/edit', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('249', '活动删除', 'activity/delete', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('262', '新增地址', 'useraddr/create', '260', '2', '0');
INSERT INTO `bao_menu` VALUES ('260', '收货地址', null, '4', '4', '1');
INSERT INTO `bao_menu` VALUES ('261', '收货地址', 'useraddr/index', '260', '1', '1');
INSERT INTO `bao_menu` VALUES ('255', '分类列表', 'activitycate/index', '244', '1', '1');
INSERT INTO `bao_menu` VALUES ('256', '添加分类', 'activitycate/create', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('257', '编辑分类', 'activitycate/edit', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('258', '删除分类', 'activitycate/delete', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('263', '编辑地址', 'useraddr/edit', '260', '3', '0');
INSERT INTO `bao_menu` VALUES ('264', '删除地址', 'useraddr/delete', '260', '4', '0');
INSERT INTO `bao_menu` VALUES ('265', '商品类别', 'goodscate/index', '231', '1', '1');
INSERT INTO `bao_menu` VALUES ('266', '新增分类', 'goodscate/create', '231', '2', '0');
INSERT INTO `bao_menu` VALUES ('267', '编辑分类', 'goodscate/edit', '231', '3', '0');
INSERT INTO `bao_menu` VALUES ('268', '更新分类', 'goodscate/update', '231', '4', '0');
INSERT INTO `bao_menu` VALUES ('269', '删除分类', 'goodscate/delete', '231', '5', '0');
INSERT INTO `bao_menu` VALUES ('271', '添加子分类', 'activitycate/child', '244', '100', '0');
INSERT INTO `bao_menu` VALUES ('274', '微信消息列表', 'weixinmsg/index', '216', '11', '1');
INSERT INTO `bao_menu` VALUES ('275', '第三方登录', 'setting/connect', '33', '10', '1');
INSERT INTO `bao_menu` VALUES ('281', '热门商圈', 'business/hots', '50', '16', '0');
INSERT INTO `bao_menu` VALUES ('282', '统计报表', null, '8', '5', '1');
INSERT INTO `bao_menu` VALUES ('283', '团购数分析', 'tongji/index', '282', '11', '1');
INSERT INTO `bao_menu` VALUES ('533', '单发消息', 'jpush/single', '530', '100', '1');
INSERT INTO `bao_menu` VALUES ('532', '群发消息', 'jpush/mass', '530', '100', '1');
INSERT INTO `bao_menu` VALUES ('296', '抢购券退款', 'tuancode/refund', '62', '34', '1');
INSERT INTO `bao_menu` VALUES ('289', '团购金额', 'tongji/money', '282', '12', '1');
INSERT INTO `bao_menu` VALUES ('290', '威望设置', 'setting/prestige', '49', '14', '1');
INSERT INTO `bao_menu` VALUES ('291', '会员日志', null, '4', '5', '1');
INSERT INTO `bao_menu` VALUES ('292', '余额日志', 'usermoneylogs/index', '291', '43', '1');
INSERT INTO `bao_menu` VALUES ('297', '抢购券退款操作', 'tuancode/refunding', '62', '35', '0');
INSERT INTO `bao_menu` VALUES ('298', '抢购券过期', 'tuancode/overdue', '62', '35', '1');
INSERT INTO `bao_menu` VALUES ('299', '抢购券过期退款操作', 'tuancode/overdueing', '62', '35', '0');
INSERT INTO `bao_menu` VALUES ('303', '手机功能', null, '487', '7', '1');
INSERT INTO `bao_menu` VALUES ('305', '新增发现', 'found/create', '303', '2', '0');
INSERT INTO `bao_menu` VALUES ('306', '编辑发现', 'found/edit', '303', '3', '0');
INSERT INTO `bao_menu` VALUES ('307', '删除发现', 'found/delete', '303', '4', '0');
INSERT INTO `bao_menu` VALUES ('308', '审核发现', 'found/audit', '303', '5', '0');
INSERT INTO `bao_menu` VALUES ('309', '消息管理', 'msg/index', '303', '6', '1');
INSERT INTO `bao_menu` VALUES ('310', '新增消息', 'msg/create', '303', '7', '0');
INSERT INTO `bao_menu` VALUES ('311', '编辑消息', 'msg/edit', '303', '8', '0');
INSERT INTO `bao_menu` VALUES ('312', '删除消息', 'msg/delete', '303', '9', '0');
INSERT INTO `bao_menu` VALUES ('313', '报名管理', 'activitysign/index', '244', '3', '1');
INSERT INTO `bao_menu` VALUES ('314', '商城订单', null, '5', '7', '1');
INSERT INTO `bao_menu` VALUES ('315', '订单汇总', 'order/index', '314', '1', '1');
INSERT INTO `bao_menu` VALUES ('316', '等待捡货', 'order/wait', '314', '2', '1');
INSERT INTO `bao_menu` VALUES ('317', '捡货单管理', 'order/picks', '314', '4', '1');
INSERT INTO `bao_menu` VALUES ('318', '发货管理', 'order/delivery', '314', '5', '1');
INSERT INTO `bao_menu` VALUES ('319', '加入捡货单', 'order/pick', '314', '100', '0');
INSERT INTO `bao_menu` VALUES ('320', '清空拣货单', 'order/clean', '314', '100', '0');
INSERT INTO `bao_menu` VALUES ('321', '创建捡货单', 'order/create', '314', '100', '0');
INSERT INTO `bao_menu` VALUES ('322', '捡货单详情', 'order/pickdetail', '314', '100', '0');
INSERT INTO `bao_menu` VALUES ('324', '打印配送单', 'order/send', '314', '100', '0');
INSERT INTO `bao_menu` VALUES ('325', '订单发货', 'order/distribution', '314', '100', '0');
INSERT INTO `bao_menu` VALUES ('326', '增加余额', 'user/money', '33', '100', '0');
INSERT INTO `bao_menu` VALUES ('327', '新增商家资金', 'shopmoney/create', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('328', '商家审核列表', 'shop/apply', '43', '3', '1');
INSERT INTO `bao_menu` VALUES ('329', '分类列表', 'sharecate/index', '114', '1', '1');
INSERT INTO `bao_menu` VALUES ('330', '添加分类', 'sharecate/create', '114', '100', '0');
INSERT INTO `bao_menu` VALUES ('331', '选择分类', 'sharecate/select', '114', '100', '0');
INSERT INTO `bao_menu` VALUES ('332', '添加子分类', 'sharecate/child', '114', '100', '0');
INSERT INTO `bao_menu` VALUES ('333', '编辑分类', 'sharecate/edit', '114', '100', '0');
INSERT INTO `bao_menu` VALUES ('334', '删除分类', 'sharecate/delete', '114', '100', '0');
INSERT INTO `bao_menu` VALUES ('335', '频道', null, '0', '8', '1');
INSERT INTO `bao_menu` VALUES ('336', '自定义菜单', 'setting/weixinmenu', '216', '6', '1');
INSERT INTO `bao_menu` VALUES ('337', '删除微信消息', 'weixinmsg/delete', '216', '12', '0');
INSERT INTO `bao_menu` VALUES ('338', '分类信息', null, '335', '1', '1');
INSERT INTO `bao_menu` VALUES ('339', '分类管理', 'lifecate/index', '338', '1', '1');
INSERT INTO `bao_menu` VALUES ('340', '新增分类', 'lifecate/create', '338', '2', '0');
INSERT INTO `bao_menu` VALUES ('341', '编辑分类', 'lifecate/edit', '338', '3', '0');
INSERT INTO `bao_menu` VALUES ('342', '删除分类', 'lifecate/delete', '338', '4', '0');
INSERT INTO `bao_menu` VALUES ('343', '属性设置', 'lifecate/setting', '338', '5', '0');
INSERT INTO `bao_menu` VALUES ('541', '全民经纪人', 'tongji/quanming', '282', '20', '1');
INSERT INTO `bao_menu` VALUES ('345', '抢购分类', 'tuancate/index', '62', '1', '1');
INSERT INTO `bao_menu` VALUES ('346', '添加分类', 'tuancate/create', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('347', '添加子分类', 'tuancate/child', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('348', '删除分类', 'tuancate/delete', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('349', '编辑分类', 'tuancate/edit', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('350', '选择分类', 'tuancate/select', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('351', '删除属性', 'lifecate/delattr', '338', '6', '0');
INSERT INTO `bao_menu` VALUES ('352', '信息列表', 'life/index', '338', '11', '1');
INSERT INTO `bao_menu` VALUES ('353', '新增信息', 'life/create', '338', '12', '0');
INSERT INTO `bao_menu` VALUES ('354', '编辑信息', 'life/edit', '338', '13', '0');
INSERT INTO `bao_menu` VALUES ('355', '删除信息', 'life/delete', '338', '14', '0');
INSERT INTO `bao_menu` VALUES ('356', '审核信息', 'life/audit', '338', '15', '0');
INSERT INTO `bao_menu` VALUES ('357', '分类异步查询', 'lifecate/ajax', '338', '7', '0');
INSERT INTO `bao_menu` VALUES ('537', '审核菜单', 'eleorder/audit', '416', '100', '0');
INSERT INTO `bao_menu` VALUES ('359', '抢购点评', 'tuandianping/index', '62', '20', '1');
INSERT INTO `bao_menu` VALUES ('360', '发布点评', 'tuandianping/create', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('361', '删除点评', 'tuandianping/delete', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('362', '编辑点评', 'tuandianping/edit', '62', '100', '0');
INSERT INTO `bao_menu` VALUES ('547', '添加分类', 'weidiancate/create', '231', '100', '0');
INSERT INTO `bao_menu` VALUES ('548', '编辑分类', 'weidiancate/edit', '231', '100', '0');
INSERT INTO `bao_menu` VALUES ('549', '删除分类', 'weidiancate/delete', '231', '100', '0');
INSERT INTO `bao_menu` VALUES ('517', '新增站点', 'city/create', '50', '2', '0');
INSERT INTO `bao_menu` VALUES ('519', '删除站点', 'city/delete', '50', '4', '0');
INSERT INTO `bao_menu` VALUES ('518', '编辑站点', 'city/edit', '50', '3', '0');
INSERT INTO `bao_menu` VALUES ('550', '更新分类', 'weidiancate/update', '231', '100', '0');
INSERT INTO `bao_menu` VALUES ('499', '家政配置', 'setting/housework', '498', '1', '1');
INSERT INTO `bao_menu` VALUES ('534', '历史记录', 'jpush/history', '530', '100', '1');
INSERT INTO `bao_menu` VALUES ('527', '微信模板消息', 'weixintmpl/index', '216', '13', '1');
INSERT INTO `bao_menu` VALUES ('394', '抽奖营销', null, '487', '3', '1');
INSERT INTO `bao_menu` VALUES ('387', '关键字列表', 'shopweixinkeyword/index', '217', '100', '1');
INSERT INTO `bao_menu` VALUES ('388', '新增关键字', 'shopweixinkeyword/create', '217', '100', '0');
INSERT INTO `bao_menu` VALUES ('389', '编辑关键字', 'shopweixinkeyword/edit', '217', '100', '0');
INSERT INTO `bao_menu` VALUES ('390', '删除关键字', 'shopweixinkeyword/delete', '217', '100', '0');
INSERT INTO `bao_menu` VALUES ('392', '货到付款捡货', 'order/wait2', '314', '3', '1');
INSERT INTO `bao_menu` VALUES ('395', '抽奖管理', 'award/index', '394', '1', '1');
INSERT INTO `bao_menu` VALUES ('396', '新增抽奖', 'award/create', '394', '2', '0');
INSERT INTO `bao_menu` VALUES ('397', '编辑抽奖', 'award/edit', '394', '3', '0');
INSERT INTO `bao_menu` VALUES ('398', '删除抽奖', 'award/delete', '394', '4', '0');
INSERT INTO `bao_menu` VALUES ('399', '启用抽奖', 'award/online', '394', '5', '0');
INSERT INTO `bao_menu` VALUES ('400', '奖品设置', 'awardgoods/index', '394', '6', '0');
INSERT INTO `bao_menu` VALUES ('401', '新增奖品', 'awardgoods/create', '394', '7', '0');
INSERT INTO `bao_menu` VALUES ('402', '编辑奖品', 'awardgoods/edit', '394', '8', '0');
INSERT INTO `bao_menu` VALUES ('403', '删除奖品', 'awardgoods/delete', '394', '9', '0');
INSERT INTO `bao_menu` VALUES ('404', '中奖名单', 'awardwinning/index', '394', '10', '0');
INSERT INTO `bao_menu` VALUES ('405', '新增中奖', 'awardwinning/create', '394', '11', '0');
INSERT INTO `bao_menu` VALUES ('406', '编辑中奖', 'awardwinning/edit', '394', '12', '0');
INSERT INTO `bao_menu` VALUES ('407', '删除中奖', 'awardwinning/delete', '394', '13', '0');
INSERT INTO `bao_menu` VALUES ('408', '关键字管理', null, '8', '3', '1');
INSERT INTO `bao_menu` VALUES ('410', '关键字列表', 'keyword/index', '408', '1', '1');
INSERT INTO `bao_menu` VALUES ('411', '添加关键字', 'keyword/create', '408', '100', '0');
INSERT INTO `bao_menu` VALUES ('412', '编辑关键字', 'keyword/edit', '408', '100', '0');
INSERT INTO `bao_menu` VALUES ('413', '删除关键字', 'keyword/delete', '408', '100', '0');
INSERT INTO `bao_menu` VALUES ('414', '手机配置', 'setting/mobile', '303', '10', '1');
INSERT INTO `bao_menu` VALUES ('418', '设置热门分类', 'life/hots', '338', '4', '0');
INSERT INTO `bao_menu` VALUES ('416', '外卖', null, '5', '3', '1');
INSERT INTO `bao_menu` VALUES ('516', '城市站点', 'city/index', '50', '1', '1');
INSERT INTO `bao_menu` VALUES ('419', '举报信息', 'lifereport/index', '338', '20', '1');
INSERT INTO `bao_menu` VALUES ('498', '家政服务', null, '487', '11', '1');
INSERT INTO `bao_menu` VALUES ('421', '商家列表', 'ele/index', '416', '2', '1');
INSERT INTO `bao_menu` VALUES ('422', '新增商家', 'ele/create', '416', '2', '0');
INSERT INTO `bao_menu` VALUES ('423', '编辑商家', 'ele/edit', '416', '3', '0');
INSERT INTO `bao_menu` VALUES ('424', '删除商家', 'ele/delete', '416', '4', '0');
INSERT INTO `bao_menu` VALUES ('425', '打样管理', 'ele/opened', '416', '4', '0');
INSERT INTO `bao_menu` VALUES ('538', '家政项目配置', 'housework/setting', '498', '2', '1');
INSERT INTO `bao_menu` VALUES ('487', '手机', null, '0', '9', '1');
INSERT INTO `bao_menu` VALUES ('430', '菜单管理', 'eleproduct/index', '416', '12', '1');
INSERT INTO `bao_menu` VALUES ('431', '新增菜单', 'eleproduct/create', '416', '12', '0');
INSERT INTO `bao_menu` VALUES ('432', '编辑菜单', 'eleproduct/edit', '416', '12', '0');
INSERT INTO `bao_menu` VALUES ('433', '删除菜单', 'eleproduct/delete', '416', '12', '0');
INSERT INTO `bao_menu` VALUES ('434', '进入商家中心', 'shop/login', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('435', '卡密管理', 'rechargecard/index', '202', '5', '1');
INSERT INTO `bao_menu` VALUES ('436', '添加充值卡', 'rechargecard/create', '202', '100', '0');
INSERT INTO `bao_menu` VALUES ('437', '删除充值卡', 'rechargecard/delete', '202', '100', '0');
INSERT INTO `bao_menu` VALUES ('438', '餐饮订单管理', 'eleorder/index', '416', '22', '1');
INSERT INTO `bao_menu` VALUES ('439', '删除订单', 'eleorder/delete', '416', '100', '0');
INSERT INTO `bao_menu` VALUES ('440', '销售流水', null, '3', '3', '1');
INSERT INTO `bao_menu` VALUES ('545', '年订单汇总', 'shopmoney/tjyear', '440', '4', '1');
INSERT INTO `bao_menu` VALUES ('544', '日订单汇总', 'shopmoney/tjday', '440', '3', '1');
INSERT INTO `bao_menu` VALUES ('543', '月订单汇总', 'shopmoney/tjmonth', '440', '2', '1');
INSERT INTO `bao_menu` VALUES ('445', '商场管理', null, '7', '8', '1');
INSERT INTO `bao_menu` VALUES ('446', '商场列表', 'market/index', '445', '1', '1');
INSERT INTO `bao_menu` VALUES ('447', '添加商场', 'market/create', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('448', '编辑商场', 'market/edit', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('449', '删除商场', 'market/delete', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('450', '商家入驻', 'market/enter', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('451', '入驻列表', 'market/enterlist', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('452', '撤销入驻', 'market/cancle', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('453', '商场活动', 'marketactivity/index', '445', '2', '1');
INSERT INTO `bao_menu` VALUES ('454', '添加活动', 'marketactivity/create', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('455', '编辑活动', 'marketactivity/edit', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('456', '删除活动', 'marketactivity/delete', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('458', '小区管理', 'community/index', '50', '21', '1');
INSERT INTO `bao_menu` VALUES ('459', '新增小区', 'community/add', '50', '22', '0');
INSERT INTO `bao_menu` VALUES ('460', '编辑小区', 'community/edit', '50', '23', '0');
INSERT INTO `bao_menu` VALUES ('461', '删除小区', 'community/delete', '50', '24', '0');
INSERT INTO `bao_menu` VALUES ('463', '便民电话', null, '487', '9', '1');
INSERT INTO `bao_menu` VALUES ('464', '便民电话列表', 'convenientphone/index', '463', '1', '1');
INSERT INTO `bao_menu` VALUES ('465', '添加便民电话', 'convenientphone/create', '463', '100', '0');
INSERT INTO `bao_menu` VALUES ('466', '删除便民电话', 'convenientphone/delete', '463', '100', '0');
INSERT INTO `bao_menu` VALUES ('467', '编辑便民电话', 'convenientphone/edit', '463', '100', '0');
INSERT INTO `bao_menu` VALUES ('468', '推广配置', 'tui/index', '282', '1', '1');
INSERT INTO `bao_menu` VALUES ('469', '新增推广', 'tui/create', '282', '2', '0');
INSERT INTO `bao_menu` VALUES ('470', '编辑推广', 'tui/edit', '282', '3', '0');
INSERT INTO `bao_menu` VALUES ('471', '删除推广', 'tui/delete', '282', '4', '0');
INSERT INTO `bao_menu` VALUES ('472', '来源分析', 'tongji/laiyuan', '282', '13', '1');
INSERT INTO `bao_menu` VALUES ('473', '推广效果分析', 'tongji/tuiguan', '282', '14', '1');
INSERT INTO `bao_menu` VALUES ('477', '手机约会', null, '487', '6', '1');
INSERT INTO `bao_menu` VALUES ('475', '关键词分析', 'tongji/keyword', '282', '16', '1');
INSERT INTO `bao_menu` VALUES ('476', '来源金额', 'tongji/lmoney', '282', '13', '1');
INSERT INTO `bao_menu` VALUES ('478', '手机约会', 'hdmobile/index', '477', '1', '1');
INSERT INTO `bao_menu` VALUES ('482', '报名管理', 'hdmobilesign/index', '477', '2', '0');
INSERT INTO `bao_menu` VALUES ('483', '上榜榜单', null, '7', '10', '1');
INSERT INTO `bao_menu` VALUES ('484', '榜单列表', 'billboard/index', '483', '2', '1');
INSERT INTO `bao_menu` VALUES ('485', '榜单管理', 'billshop/index', '483', '100', '1');
INSERT INTO `bao_menu` VALUES ('539', '设置项目配置', 'housework/setting2', '498', '3', '0');
INSERT INTO `bao_menu` VALUES ('540', '全民经纪人', 'setting/quanming', '33', '1', '1');
INSERT INTO `bao_menu` VALUES ('496', '审核招聘', 'work/audit', '494', '2', '0');
INSERT INTO `bao_menu` VALUES ('497', '删除招聘', 'work/delete', '494', '3', '0');
INSERT INTO `bao_menu` VALUES ('500', '家政列表', 'housework/index', '498', '10', '1');
INSERT INTO `bao_menu` VALUES ('501', '删除家政', 'housework/delete', '498', '14', '0');
INSERT INTO `bao_menu` VALUES ('502', '修改家政', 'housework/edit', '498', '15', '0');
INSERT INTO `bao_menu` VALUES ('528', 'APP', null, '0', '11', '1');
INSERT INTO `bao_menu` VALUES ('530', 'APP推送管理', null, '528', '100', '1');
INSERT INTO `bao_menu` VALUES ('531', '推送配置', 'setting/jpush', '530', '100', '1');
INSERT INTO `bao_menu` VALUES ('510', '提现管理', 'usercash/index', '509', '100', '1');
INSERT INTO `bao_menu` VALUES ('520', '微店审核列表', 'weidian/index', '43', '100', '1');
INSERT INTO `bao_menu` VALUES ('521', '开通订座', 'shop/ding', '43', '100', '0');
INSERT INTO `bao_menu` VALUES ('515', '微店分类', 'weidiancate/index', '231', '55', '1');
INSERT INTO `bao_menu` VALUES ('522', '专题管理', 'zhuanti/special', '62', '41', '1');
INSERT INTO `bao_menu` VALUES ('523', '配送员管理', null, '335', '100', '1');
INSERT INTO `bao_menu` VALUES ('524', '配送员列表', 'delivery/index', '523', '100', '1');
INSERT INTO `bao_menu` VALUES ('525', '添加配送员', 'delivery/create', '523', '100', '0');
INSERT INTO `bao_menu` VALUES ('526', '配送记录', 'delivery/lists', '523', '100', '0');
INSERT INTO `bao_menu` VALUES ('535', 'APP管理', null, '528', '100', '1');
INSERT INTO `bao_menu` VALUES ('536', 'APP版本管理', 'setting/updateapp', '535', '100', '1');
INSERT INTO `bao_menu` VALUES ('542', '全民推广明细', 'quanming/index', '33', '2', '1');
INSERT INTO `bao_menu` VALUES ('546', '检查系统', 'check/index', '9', '100', '1');
INSERT INTO `bao_menu` VALUES ('551', '推广金奖励', 'user/fzmoney', '33', '25', '1');
INSERT INTO `bao_menu` VALUES ('552', '批准推广金奖励', 'user/fzmoneyyes', '33', '26', '0');
INSERT INTO `bao_menu` VALUES ('553', '商场楼层', 'market/floor', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('554', '添加楼层', 'market/flooradd', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('555', '编辑楼层', 'market/flooredit', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('556', '删除楼层', 'market/floordel', '445', '100', '0');
INSERT INTO `bao_menu` VALUES ('558', '物业资金', null, '335', '100', '1');
INSERT INTO `bao_menu` VALUES ('559', '资金记录', 'logs/index', '558', '1', '1');
INSERT INTO `bao_menu` VALUES ('560', '一元云购', null, '335', '100', '1');
INSERT INTO `bao_menu` VALUES ('561', '商品列表', 'cloudgoods/index', '560', '1', '1');
INSERT INTO `bao_menu` VALUES ('562', '添加商品', 'cloudgoods/create', '560', '100', '0');
INSERT INTO `bao_menu` VALUES ('563', '编辑商品', 'cloudgoods/edit', '560', '100', '0');
INSERT INTO `bao_menu` VALUES ('564', '删除商品', 'cloudgoods/delete', '560', '100', '0');

