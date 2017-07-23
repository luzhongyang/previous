<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Money extends Ctl
{

    public function log($params)
    {
        $this->check_login();
        $items = $filter = array();
        $page = max((int)$params['page'], 1);
        $filter['staff_id'] = $this->staff_id;
        if($items = K::M('staff/log')->items($filter, null, $page, $limit, $count)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('log_id,staff_id,money,intro,dateline', $v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), "money"=>$this->staff['money'], 'total_count'=>$count));
    }

    public function txlog($params)
    {
        $this->check_login();
        $items = $filter = array();
        $page = max((int)$params['page'], 1);
        $filter['staff_id'] = $this->staff_id;
        if($items = K::M('staff/tixian')->items($filter, null, $page, $limit, $count)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('tixian_id,staff_id,money,intro,account_info,status,reason,updatetime,dateline', $v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), "money"=>$this->staff['money'], 'total_count'=>$count));
    }

    public function tixian($params)
    {
        $this->check_login();
        if(!($money = (float)$params['money']) < 1){
				$this->msgbox->add('提现金额不能少于1元,', 211);
        }else if($money > $this->staff['money']){
            $this->msgbox->add(L('提现金额不正确'), 212);
        }else if(empty($params['passwd']) || md5($params['passwd']) != $this->staff['passwd']){
            $this->msgbox->add(L('提现密码不正确'), 212);
        }else if(K::M('staff/tixian')->count(array('staff_id'=>$this->staff_id, 'dateline'=>'>:'.$this->system->sdaytime))){
            $this->msgbox->add(L('一天只能提现一次'), 212);
        }else if($tixian_id = K::M('staff/staff')->tixian($this->staff_id, $money, $this->staff)){
            $this->msgbox->set_data('data', array('money'=>($this->staff['money']-$money), 'tixian_id'=>$tixian_id));
        }
    }
}
