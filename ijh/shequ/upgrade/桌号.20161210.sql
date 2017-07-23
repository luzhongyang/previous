ALTER TABLE `jh_order`
ADD COLUMN `zhuohao_id`  int(10) NULL DEFAULT 0 COMMENT '桌号ID' AFTER `express`;

ALTER TABLE `jh_waimai`
MODIFY COLUMN `pei_type`  tinyint(1) NULL DEFAULT 0 COMMENT '配送类型  0:自己送,1:第三方送，2:第三方代购及配送  3:用户自提单 4:堂食' AFTER `pei_distance`;

ALTER TABLE `jh_order`
MODIFY COLUMN `pei_type`  tinyint(1) NULL DEFAULT 0 COMMENT '0:自己送，1:跑腿送,  2:代购(仅仅外卖), 3:用户自提单 4:堂食' AFTER `pei_time`;


