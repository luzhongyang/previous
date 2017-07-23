<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Maidan_Maidan extends Mdl_Table
{   
  
    protected $_table = 'maidan';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,type,config,discount,orders,max_youhui';
    // public function create($data, $checked=false)
    // {
    //     if(!$checked && !$data = $this->_check_schema($data)){
    //         return false;
    //     }
    //     return $this->db->insert($this->_table, $data);
    // }
    
    // public function update_maidan($shop_id, $status, $type, $maidan_youhui=array())
    // {
    //     if(!$shop_id = (int)$shop_id){
    //         return false;
    //     }
    //     $this->db->Execute("DELETE FROM ".$this->table($this->_table)." WHERE shop_id=".$shop_id);
    //     $sql =  array();
    //     foreach((array)$maidan_youhui as $k=>$v){
    //         $k = (float)$k;
    //         $v = (float)$v;
    //         if($k && $v){
    //             $sql[] = "('{$shop_id}','{$status}','{$type}', '{$k}', '{$v}')";
    //         }
    //     }
    //     if($sql){
    //         $sql = "INSERT INTO ".$this->table($this->_table)."(`shop_id`,`status`,`type`,`each_amount`,`each_youhui`) VALUES".implode(',', $sql);
    //         $this->db->Execute($sql);    
    //     }
    //     return true;
    // }
    //返回买单优惠金额
    //$amount 为总价减去不优惠后的金额
    public function get_maidan_youhui($shop_id, $amount)
    {
        $youhui_amount = 0;
        if($maidan = $this->detail($shop_id)){
            if($maidan['type'] == 1){ //规则为折扣
                $sale = $maidan['discount']/100;
                $discount = (int)$maidan['discount'];
                $dec_money = ($amount * $discount / 100);
                $youhui_amount = $amount - $dec_money;
            }else{
                $config = unserialize($maidan['config']);                
                foreach($config as $v){
                    if($amount >= $v['m']){
                        if(($a = intval($amount/$v['m']) * $v['d']) > $youhui_amount){
                            $youhui_amount = $a;
                        }
                    }
                }                
            }
            if($maidan['max_youhui'] > 0 && ($maidan['max_youhui'] < $youhui_amount)){
                $youhui_amount = $maidan['max_youhui'];
            }
        }
        return $youhui_amount;    
    }
    
}