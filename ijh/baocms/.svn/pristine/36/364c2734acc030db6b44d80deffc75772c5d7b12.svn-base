<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ShopyouhuiModel extends CommonModel {

    protected $pk = 'yh_id';
    protected $tableName = 'shop_youhui';

    public function get_amount($shop_id,$amount,$exception){
        $youhui = $this->where(array('shop_id'=>$shop_id,'is_open'=>1))->find();
        $need = $amount;
        if($youhui['type_id'] == 0){
            $result = round($need *$youhui['discount']/10,2) + $exception; 
        }else{
            $t = round($need/$youhui['min_amount']);
            $result = $need - $t*$youhui['amount'] + $exception;
        }
        return $result;
    }
    
    
}
