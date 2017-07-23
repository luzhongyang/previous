ALTER TABLE `jh_order`
ADD COLUMN `express`  varchar(32) NULL DEFAULT '' COMMENT '快递单号' AFTER `coupon`;

DROP TABLE IF EXISTS `jh_links`;
CREATE TABLE `jh_links` (
  `link_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '' COMMENT '标题',
  `link` varchar(150) DEFAULT '' COMMENT '链接地址',
  `logo` varchar(150) DEFAULT '' COMMENT '图片链接',
  `desc` varchar(512) DEFAULT '',
  `city_id` smallint(5) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE  `jh_tuan` CHANGE  `orders`  `orders` INT( 9 ) UNSIGNED NULL DEFAULT  '0' COMMENT  '团购商品订单量';

ALTER TABLE `jh_article_cate`
MODIFY COLUMN `from`  enum('about','help','page','hongbao','pchelp','article') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'article' COMMENT '类型 ' AFTER `level`;

ALTER TABLE `jh_article`
MODIFY COLUMN `from`  enum('article','about','help','hongbao','pchelp','page') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'article' COMMENT '内容类型' AFTER `cat_id`;


