<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Money extends Ctl_Cashier
{
    
    /*资金明细*/
    public function log($params)
    {
        $items = $filter = array();
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('shop/log')->items($filter, array('log_id'=>'DESC'), $page, $limit, $count)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('log_id,shop_id,money,intro,dateline', $v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), "money"=>$this->shop['money'], "total_money"=>$this->shop['total_money'], 'total_count'=>$count));
    }
    
    public function log_detail($params)
    {
        if(!$log_id = $params['log_id']){
            $this->msgbox->add('错误的记录', 211);
        }else if(!$log = K::M('shop/log')->detail($log_id)){
            $this->msgbox->add('不存在的记录', 211);
        }else if($log['shop_id'] != $this->shop_id){
            $this->msgbox->add('不存在的记录', 211);
        }else{
            $this->msgbox->set_data('data', array('log'=>$log));
        }
    }
    
    public function info($params)
    {
        $this->check_owner();
        $money = $this->shop['money'];
        $tixian_percent = $shop['tixian_percent'];
        if(!$bank = K::M('shop/account')->detail($this->shop_id)){
            $bank = array('shop_id'=>0);
        }
        $info=array(
            'money'=>$money,
            'tixian_percent'=>$tixian_percent,
            'bank'=>$bank
        );
        $this->msgbox->set_data('data', array('info'=>$info));
    }
    
    //资金提现
    public function tixian($params)
    {
        $this->check_owner();
        if(($money = (float)$params['money']) < 1){
            $this->msgbox->add('提现金额不正确,最少1元', 211);
        }else if($money > $this->shop['money']){
            $this->msgbox->add('提现金额不正确', 212);
        }else if(empty($params['passwd']) || md5($params['passwd']) != $this->shop['passwd']){
            $this->msgbox->add('提现密码不正确', 213);
        }else if(K::M('shop/tixian')->count(array('shop_id'=>$this->shop_id, 'dateline'=>'>:'.$this->system->sdaytime))){
            $this->msgbox->add('一天只能提现一次', 214);
        }else if($tixian_id = K::M('shop/shop')->tixian($this->shop_id, $money, $this->shop)){
            $this->msgbox->set_data('data', array('money'=>($this->shop['money']-$money), 'tixian_id'=>$tixian_id));
        }
    }

    //体现日志
    public function txlog($param)
    {
        $this->check_owner();
        $filter = array('shop_id'=>$this->shop_id);
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('shop/tixian')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data(array('items'=>array_values($items)));
    }

}