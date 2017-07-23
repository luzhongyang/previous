ALTER TABLE `bao_weixin_keyword`   
  CHANGE `type` `type` ENUM('news','text','addon') CHARSET utf8 COLLATE utf8_general_ci DEFAULT 'text'   NULL  COMMENT 'text:普通消息 news图片消息 addon:插件';

  ALTER TABLE `bao_shop_weixin_keyword`   
  CHANGE `type` `type` ENUM('news','text','addon') CHARSET utf8 COLLATE utf8_general_ci DEFAULT 'text'   NULL  COMMENT 'text:普通消息 news:图片消息 addon:插件';

ALTER TABLE `bao_weixin_coupon`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_weixin_scratch`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_weixin_lottery`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_weixin_goldegg`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_weixin_packet`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `title`;

ALTER TABLE `bao_weixin_packet`
MODIFY COLUMN `item_min`  decimal(9,2) NULL DEFAULT 0.00 AFTER `password`,
MODIFY COLUMN `item_max`  decimal(9,2) NOT NULL AFTER `item_sum`;

ALTER TABLE `bao_weixin_shake`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_weixin_help`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;

ALTER TABLE `bao_weixin_relay`
ADD COLUMN `keyword_id`  int(10) NULL DEFAULT 0 AFTER `shop_id`;



