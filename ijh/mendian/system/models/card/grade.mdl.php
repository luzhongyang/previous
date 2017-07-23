<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Grade extends Mdl_Table
{   
  
    protected $_table = 'card_grade';
    protected $_pk = 'grade_id';
    protected $_cols = 'grade_id,shop_id,title,need_money,need_jifen,discount,icon,orderby';

    public function items_by_shop_id($shop_id)
    {
        if(!$shop_id = (int)$shop_id){
            return false;
        }
        if($items = $this->items(array('shop_id'=>$shop_id), array('need_money'=>'ASC'))){
            $index = 0;
            foreach($items as $k=>$v){
                $index ++;
                $v['icon'] = 'default/card/VIP-v'.$index.'.png';
                $v['level'] =$index;
                $items[$k] = $v;
            }
        }
        return $items;
    }

    protected function _check($row, $grade_id=null)
    {
        if(empty($grade_id) || isset($row['discount'])){
            $row['discount'] = (float)$row['discount'];
            if($row['discount'] < 1 && $row['discount'] > 10){
                $row['discount'] = 10;
            }
        }
        return parent::_check($row, $grade_id);
    }
}