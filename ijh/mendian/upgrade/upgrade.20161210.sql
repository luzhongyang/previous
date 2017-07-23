ALTER TABLE `jh_cashier_coupon`
CHANGE COLUMN `max_num` `stock`  mediumint(8) UNSIGNED NULL DEFAULT 0 COMMENT '库存' AFTER `ltime`;