<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Money extends Ctl_Biz
{


    public function log($params)
    {
        $this->check_login();
        $items = $filter = array();
        $page = max((int)$params['page'], 1);
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('shop/log')->items($filter, null, $page, $limit, $count)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('log_id,shop_id,money,intro,dateline', $v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), "money"=>$this->shop['money'], "total_money"=>$this->shop['total_money'], 'total_count'=>$count));
    }

    public function txlog($params)
    {
        $this->check_login();
        $items = $filter = array();
        $page = max((int)$params['page'], 1);
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('shop/tixian')->items($filter, array('tixian_id'=>'desc'), $page, $limit, $count)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('tixian_id,shop_id,money,intro,account_info,status,reason,updatetime,dateline', $v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items),"money"=>$this->shop['money'], "total_money"=>$this->shop['total_money'], 'total_count'=>$count));
    }

    public function tixian($params)
    {
        $this->check_login();
        if(!$money = (float)$params['money']){
            $this->msgbox->add(L('提现金额不正确'), 211);
        }else if($money > $this->shop['money']){
            $this->msgbox->add(L('提现金额不正确'), 212);
        }else if(empty($params['passwd']) || md5($params['passwd']) != $this->shop['passwd']){
            $this->msgbox->add(L('提现密码不正确'), 213);
        }else if(K::M('shop/tixian')->count(array('shop_id'=>$this->shop_id, 'dateline'=>'>:'.$this->system->sdaytime))){
            $this->msgbox->add(L('一天只能提现一次'), 214);
        }else if($tixian_id = K::M('shop/shop')->tixian($this->shop_id, $money, $this->shop)){
            $this->msgbox->set_data('data', array('money'=>($this->shop['money']-$money), 'tixian_id'=>$tixian_id));
        }
    }
}
