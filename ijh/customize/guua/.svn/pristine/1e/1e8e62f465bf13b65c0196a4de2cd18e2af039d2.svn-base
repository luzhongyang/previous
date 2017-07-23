<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Order_Goods extends Mdl_Table
{   
  
    protected $_table = 'order_goods';
    protected $_pk = 'id';
    protected $_cols = 'id,order_id,order_product_id,goods_id,num,total_price,dateline';
    protected $_pre_cache_key = 'order-goods-list';
    
    
     public function create($data)
    {

        if(!$order_id = $data['order_id']){
            return false;
        }else if(!$order_product_id = $data['order_product_id']){
            return false;
        }else if(!$goods_id = $data['goods_id']){
            return false;
        }else if(!$num = $data['num']){
            return false;
        }else if(!$total_price = $data['total_price']){
            return false;
        }


        $a = array('order_id'=>$order_id, 'order_product_id'=>$order_product_id,'goods_id'=>$goods_id,'num'=>$num,'total_price'=>$total_price);    

    	if(!$o = $this->insert($a, true)){
    		return false;
    	}

        return $o;
    }
    
    
    
     public function insert($data)
    {

        $data['dateline'] = $data['dateline'] ? $data['dateline'] :  __CFG::TIME;
        if($uid = $this->db->insert($this->_table, $data, true)){
            $this->db->Execute("INSERT INTO ".$this->table('member_fields')."(uid) VALUES('$uid')");
        }
        return $uid;
    }
    
}