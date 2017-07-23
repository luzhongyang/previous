<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Youhui extends Mdl_Table
{

    protected $_table = 'shop_youhui';
    protected $_pk = 'youhui_id';
    protected $_cols = 'youhui_id,shop_id,order_amount,youhui_amount,use_count,orderby,dateline';
    protected $_orderby = array('shop_id'=>'ASC','order_amount'=>'ASC');

    public function order_youhui($shop_id, $amount)
    {
        $youhui = $this->find(array('shop_id'=>$shop_id,'order_amount'=>'<=:'.$amount),array('youhui_amount'=>'DESC'));
        return $youhui;
    }

    public function update_youhui($shop_id, $order_youhui=array())
    {
        if(!$shop_id = (int)$shop_id){
            return false;
        }
        $this->db->Execute("DELETE FROM ".$this->table($this->_table)." WHERE shop_id=".$shop_id);
        $sql = $youhui = array();
        foreach((array)$order_youhui as $k=>$v){
            $k = (float)$k;
            $v = (float)$v;
            if($k && $v){
                $sql[] = "('{$shop_id}', '{$k}', '{$v}')";
                $youhui[] ="{$k}:{$v}";
            }
        }
        if($sql){
            $sql = "INSERT INTO ".$this->table($this->_table)."(`shop_id`,`order_amount`,`youhui_amount`) VALUES".implode(',', $sql);
            $this->db->Execute($sql);            
        }
        K::M('shop/shop')->update($shop_id, array('youhui'=>implode(',', $youhui)));
        return true;
    }
}
