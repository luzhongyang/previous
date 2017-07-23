ALTER TABLE  `jh_order` ADD  `payee` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:平台收款,1:商户收款' AFTER  `from`;
ALTER TABLE  `jh_payment_log` ADD  `payee` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0:平台帐户收款,1:商户帐户收款' AFTER  `pay_level`;
ALTER TABLE `jh_payment_log` ADD COLUMN `payee_info` VARCHAR(255) DEFAULT '' NULL COMMENT '收款账户信息' AFTER `payee`;
CREATE TABLE `jh_cooperation` (
`cooperation_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '合作自增ID' ,
`name`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '姓名' ,
`city_name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '城市名称' ,
`mobile`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号' ,
`qq`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '腾讯QQ' ,
`audit`  tinyint(1) NULL DEFAULT 0 COMMENT '审核  0:不通过  1:通过' ,
`dateline`  int(10) NULL DEFAULT 0 COMMENT '添加时间' ,
PRIMARY KEY (`cooperation_id`),
UNIQUE INDEX `mobile` USING BTREE (`mobile`) 
)
;
