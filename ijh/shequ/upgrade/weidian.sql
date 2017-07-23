ALTER TABLE `jh_order`
ADD COLUMN `coupon_id`  int(10) NULL DEFAULT 0 COMMENT 'µÍ∆Ã”≈ª›»ØID' AFTER `closed`,
ADD COLUMN `coupon`  decimal(8,2) NULL DEFAULT 0.00 COMMENT 'µÍ∆Ã”≈ª›»Øµ÷ø€Ω∂Ó' AFTER `coupon_id`;