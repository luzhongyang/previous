<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Cashier extends Mdl_Table
{   
  
    protected $_table = 'cashier';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,orders,is_youhui,discount,youhui,is_moling,moling,package,xf_jifen,sign_jifen,verify_name,dateline';
    protected $_moling_data = array('1'=>'抹分', '2'=>'抹角', '3'=>'四舍五入分', '4'=>'四舍五入角');

    public function moling()
    {
        return $this->_moling_data;
    }

    public function detail($shop_id, $closed=false)
    {
        if(!$shop_id = (int)$shop_id){
            return false;
        }
        $where = "s.shop_id=ext.shop_id AND ext.shop_id=".$shop_id;
        if(empty($closed)){
            $where .= " AND s.closed='0'";
        }
        $sql = "SELECT s.*,ext.* FROM ".$this->table('shop')." s, ".$this->table($this->_table)." ext WHERE ".$where;
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
            
        }        
        return $row;
    }

    public function update_money($shop_id, $money, $intro='')
    {
        return K::M('shop/shop')->update_money($shop_id, $money, $intro);
    }

    public function moling_amount($price, $shop)
    {
        $amount = $price;
        if($shop['is_moling']){
            switch ((int)$shop['moling']) {
                case 1:
                    $amount = bcdiv(floor(bcmul($price, 10)), 10, 1);
                    break;
                case 2:
                    $amount = floor($price);
                    break;
                case 3:
                    $amount = round($price, 1);
                    break;
                case 4:
                    $amount = round($price);
                    break;

            }
        }
        return $price - $amount;
    }

    public function send($shop_id, $title, $content, $extras=array())
    {
        return K::M('jpush/device')->jpush($title, $content, array('tag'=>'shop_id'.$shop_id, 'from'=>'cashier'), $extras);
    }

    protected function _format_row($row)
    {
        $row['discount_data'] = $row['youhui_data'] = $row['package_data'] = array();
        if($row['discount']){
            $row['discount_data'] = explode(',', $row['discount']);
        }
        if($row['youhui']){
            $row['youhui_data'] = explode(',', $row['youhui']);
        }
        $row['moling_title'] = '抹零未开启';
        if($row['is_moling'] && ($str = $this->_moling_data[$row['moling']])){
            $row['moling_label'] = $str;
        }
        $package_data = array();
        foreach(explode(',', $row['package']) as $v){
            list($money, $give, $jifen) = explode(":", $v);
            if(($money = (int)$money) > 0){
                $give = (float)$give;
                $jifen = (int)$jifen;
                $package_data[$money] = array('money'=>$money, 'give'=>$give, 'jifen'=>$jifen);
            }
        }
        $row['package_data'] = $package_data;
        $row['url'] = 'http://shop'.$row['shop_id'].'.'.__CFG::SHOP_DOMAIN;
        return $row;
    }

    //订单统计

    public function sum_money(){
        $sql = "SELECT SUM('')";
    }
    
    public function batch($shop_id,$barh=0){

        if($shop_id&&!is_array($shop_id)){

          return  $this->update($shop_id,array('verify_name'=>$barh));
        }else if($shop_id&&is_array($shop_id)){

           foreach ($shop_id as $v){
               if(!$this->update($v,array('verify_name'=>$barh))){
                   return false;

               }
           }
            return true;
        }
       
        return false;
        
    }
    
}