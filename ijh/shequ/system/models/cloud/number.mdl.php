<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Number extends Mdl_Table
{   
  
    protected $_table = 'cloud_number';
    protected $_pk = 'id';
    protected $_cols = 'id,attr_id,uid,number,order_id';
   /**
    * 
    * @param type $max
    * @param type $attr_id
    */
    public function createStart($max, $attr_id)
    {
        $codes =  range(100000001, 100000000+$max);
        shuffle($codes);
        $value = "";
        foreach($codes as $k=>$v){
            $i = floor($k/500);
            $value[$i][] = "(".$attr_id.",".$v.")";
        }
        foreach($value as $item){
            $values = implode(',', $item);
            $sql = "INSERT INTO ".$this->table('cloud_number')."(`attr_id`,`number`) VALUES". $values;
            $this->db->Execute($sql);    
        }
        return true;
    }
    
    /**
     * 
     * @param type $uid
     * @param type $order_id 订单id 
     * @param type $attr_id  云购id
     * @param type $limit    购买份数
     * @return boolean
     */
    public function setcode($uid,$order_id,$attr_id,$limit)
    {
        $sql = "UPDATE ".$this->table($this->_table)." SET `uid`=".$uid.",`order_id`=".$order_id." WHERE `uid`=0 AND `attr_id`=".$attr_id." ORDER BY id ASC LIMIT ".$limit; 
        $this->db->Execute($sql);
        return true;
    } 
    
}