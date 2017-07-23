<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Jifen_Order extends Mdl_Table
{

    protected $_table = 'jifen_order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,shop_id,uid,product_id,product_title,product_number,product_jifen,total_jifen,order_status,clientip,dateline,card_id';

    protected function _format_row($row)
    {
    	if($row['order_status'] > 0){
    		$row['order_status_label'] = '已领取';
    	}else if($row['order_status'] < 0){
    		$row['order_status_label'] = '已取消';
    	}else{
    		$row['order_status_label'] = '待领取';
    	}
    	return $row;
    }

    public function cancel($order_id, $order=null)
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if($order['order_status'] != 0){
            return false;
        }else if($this->update($order_id, array('order_status'=>-1), true)){
            K::M('card/card')->update_jifen($order['card_id'], $order['total_jifen'], '取消兑换订单退回积分', $order_id);
            K::M('jifen/product')->update($order['product_id'], array('sales'=>"`sales`-{$order['product_number']}",'stock'=>"`stock`+{$order['product_number']}"), true);
            return true;
        }
    }

    public function confirm($order_id, $order=null)
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if($order['order_status'] != 0){
            return false;
        }else{
            return $this->update($order_id, array('order_status'=>1));
        }
    }
}
