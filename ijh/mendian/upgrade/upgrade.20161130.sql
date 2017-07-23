ALTER TABLE  `jh_card_log` ADD INDEX (  `order_id` );
ALTER TABLE  `jh_card_log` ADD INDEX (  `card_id` );

ALTER TABLE `jh_card_order` ADD COLUMN `type` ENUM('maidan','chongzhi') DEFAULT 'chongzhi' NULL AFTER `card_id`; 
ALTER TABLE `jh_card` ADD INDEX (`wx_openid`, `shop_id`); 

ALTER TABLE `jh_cashier_log`   
  CHANGE `type` `type` ENUM('order','refund','chongzhi','maidan','qrcode') CHARSET utf8 COLLATE utf8_general_ci DEFAULT 'order'   NULL;

ALTER TABLE  `jh_cashier_order` CHANGE  `type`  `type` ENUM(  'refund',  'chongzhi',  'cashier',  'maidan' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  'cashier' COMMENT  'ceshier:收银,chongzhi:充值,refund:退款'

ALTER TABLE `jh_order` CHANGE `note` `intro` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci NULL  COMMENT '订单备注';

ALTER TABLE  `jh_card_sign` CHANGE  `uid`  `uid` MEDIUMINT( 8 ) UNSIGNED NULL DEFAULT  '0';


ALTER TABLE  `jh_cashier_order` ADD  `coupon_log_id` INT( 10 ) NOT NULL DEFAULT  '0' AFTER  `zhaoling_amount` ,
ADD  `coupon_amount` DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0' AFTER  `coupon_log_id`