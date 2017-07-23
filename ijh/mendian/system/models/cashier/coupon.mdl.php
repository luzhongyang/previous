<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Coupon extends Mdl_Table
{   
  
    protected $_table = 'cashier_coupon';
    protected $_pk = 'coupon_id';
    protected $_cols = 'coupon_id,shop_id,title,amount,min_price,stime,ltime,stock,send_count,used_count,receive_count,one_limit,intro,dateline';
    protected $_orderby = array('coupon_id'=>'DESC');

    protected function _check($data, $coupon_id=null)
    {
    	if(isset($data['stime']) && isset($data['ltime'])){
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            if ($data['ltime'] <= __TIME) {
                $this->msgbox->add('结束时间不能小于等于当前时间', 511);
                return false;
            }elseif ($data['stime'] >= $data['ltime']) {
                $this->msgbox->add('开始时间不能大于等于结束时间', 511);
                return false;
            }
    	}
        if(isset($data['stock']) && isset($data['one_limit'])){
    		if ($data['stock'] < $data['one_limit']) {
	        	$this->msgbox->add('库存不能小于每人限领数量', 512);
	            return false;
	        }elseif ($data['stock'] <= 0) {
	        	$this->msgbox->add('库存必须大于0', 513);
	            return false;
	        }
    	}
        if(isset($data['amount']) && isset($data['min_price'])){
    		if ($data['amount'] < 0 || $data['min_price'] < 0) {
	        	$this->msgbox->add('卡券面值或最低消费额不能小于0', 514);
	            return false;
	        }
    	}
        return parent::_check($data, $coupon_id);
    }

    protected function _format_row($row){
        if ($row['shop_id']) {
            if ($shop = K::M('shop/shop')->detail($row['shop_id'])) {
                $row['shop_logo'] = $shop['logo'];
            }
        }
        return $row;
    }
}