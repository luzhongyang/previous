ALTER TABLE `bao_goods_list`
ADD COLUMN `order_status`  tinyint(1) NULL DEFAULT 0 AFTER `dateline`,
ADD COLUMN `pay_status`  tinyint(1) NULL DEFAULT 0 AFTER `order_status`;


ALTER TABLE `bao_payment_logs`
MODIFY COLUMN `type`  enum('tuan','gold','money','ele','ding','fzmoney','breaks','hotel','farm','crowd','goods') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'tuan' AFTER `user_id`;

