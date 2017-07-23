<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Money extends Ctl_Staff
{
    /** 
     * 最近30天收入明细
     * @param $this->staff_id
     * @param $page,分页
     * @param $type,1:全部,2:收入,3:支出
     */
    //该接口已废除了，
    public function items($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',200);
        }else{
            $filter = array('staff_id'=>$this->staff_id);
            if(isset($params['type'])){
                $type = $params['type'];
                if($type == 2){
                    $filter['money'] = ">:0";
                }else if($type == 3){
                    $filter['money'] = "<:0";
                }
            }
            $page  =  $params['page'] < 1 ? 1 : $params['page'];
            $items = K::M('staff/log')->items($filter, null, $page, 10);
            $this->msgbox->set_data('data', array_values($items));
        }
    }

    //资金日志
    public function log($params)
    {
        $filter = array('staff_id'=>$this->staff_id);
        $page  =  max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('staff/log')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $data = array('items'=>array_values($items),'total_count'=>$count, 'money'=>$this->staff['money'],'tixian_money'=>$this->staff['tixian_money']);
        $this->msgbox->set_data('data', $data);
    }

    /**
     * 资金管理
     * @param $this->staff_id
     * @return money,tixian
     */
    public function capital($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确', 200);
        }else{
            $detail = array(
                'money'  => $this->staff['money'],
                'tixian' => $this->staff['tixian_money'],
                 'total_wait_money' => (float)K::M('staff/tixian')->total_wait_money($this->staff_id)
            );
            $this->msgbox->set_data('data', $detail);
        }
    }

    public function txlog($params)
    {
        $filter = array('staff_id'=>$this->staff_id);
        $page  =  max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('staff/tixian')->items($filter, array('tixian_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }
        $data = array('items'=>array_values($items),'total_count'=>$count, 'money'=>$this->staff['money'],'tixian_money'=>$this->staff['tixian_money']);
        $this->msgbox->set_data('data', $data);
    }

    /**
     * 申请提现
     * @param $this->staff_id
     * 说明:没有POST数据时返回用户银行列表,否则处理提现请求
     */
    public function tixian($params)
    {        
        $account  = K::M('staff/account')->detail_by_staff_id($this->staff_id);
        $account['accountMoney']  = $this->staff['money'];
        $this->msgbox->set_data('data', $account);
    }
    /**
     * 确认提现
     * @param $account_id
     * @param $account_title
     * @param $money
     * @param $pswd
     */
    public function sure_tixian($params)
    {
        if(!($money = (float)$params['money']) < 1){
            $this->msgbox->add('提现金额不正确,最少1元', 211);
        }else if($money > $this->staff['money']){
            $this->msgbox->add(L('提现金额不正确'), 212);
        }else if(empty($params['pswd']) || md5($params['pswd']) != $this->staff['passwd']){
            $this->msgbox->add(L('提现密码不正确'), 213);
        }else if(!$account = K::M('staff/account')->detail_by_staff_id($this->staff_id)){
            $this->msgbox->add(L('没有设置体现帐号'), 214);
        }else if(K::M('staff/tixian')->count(array('staff_id'=>$this->staff_id, 'dateline'=>'>:'.$this->system->sdaytime))){
            $this->msgbox->add(L('一天只能提现一次'), 215);
        }else if($tixian_id = K::M('staff/staff')->tixian($this->staff_id, $money, $account)){
            $this->msgbox->set_data('data', array('money'=>($this->staff['money']-$money), 'tixian_id'=>$tixian_id));
        }
    }
}