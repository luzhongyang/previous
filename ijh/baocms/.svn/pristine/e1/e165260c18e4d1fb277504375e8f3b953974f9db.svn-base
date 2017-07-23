SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `bao_app_user`
-- app用户分表,每条记录代表一个APP登录用户
-- ----------------------------
CREATE TABLE IF NOT EXISTS `bao_app_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `app_type` int(1) unsigned DEFAULT '0' COMMENT '0:android,1ios',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `bao_app_user`
-- 信鸽推送管理菜单
-- ----------------------------
INSERT INTO `bao_menu` (`menu_id`, `menu_name`, `menu_action`, `parent_id`, `orderby`, `is_show`) VALUES (533, '单发消息', 'xinge/single', 530, 100, 1);
INSERT INTO `bao_menu` (`menu_id`, `menu_name`, `menu_action`, `parent_id`, `orderby`, `is_show`) VALUES (532, '群发消息', 'xinge/mass', 530, 100, 1);
INSERT INTO `bao_menu` (`menu_id`, `menu_name`, `menu_action`, `parent_id`, `orderby`, `is_show`) VALUES (534, '历史记录', 'xinge/history', 530, 100, 1);
INSERT INTO `bao_menu` (`menu_id`, `menu_name`, `menu_action`, `parent_id`, `orderby`, `is_show`) VALUES (528, '信鸽', NULL, 0, 11, 1);
INSERT INTO `bao_menu` (`menu_id`, `menu_name`, `menu_action`, `parent_id`, `orderby`, `is_show`) VALUES (531, '信鸽配置', 'setting/xinge', 530, 100, 1);



