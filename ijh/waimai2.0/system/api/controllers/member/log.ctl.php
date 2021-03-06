<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member_Log extends Ctl
{
    
    // 余额明细
    public function money($params)
    {
        $this->check_login();
        $filter = array();
        $filter['type'] = 'money';
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        $count = 0;
        if($moneys = K::M('member/log')->items($filter, array('log_id'=>'DESC'), $page, 10, $count)){
            $items = array();
            foreach($moneys as $k=>$val){
                $items[] = $this->filter_fields('log_id,uid,type,number,intro,dateline', $val);
            } 
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count, 'money'=>$this->MEMBER['money']));
    }

    // 积分日志
    public function jifen($params) 
    {
        $this->check_login();
        $filter = array();
        $filter['type'] = 'jifen';
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        $count = 0;
        if($jifens = K::M('member/log')->items($filter, array('log_id'=>'DESC'), $page, 10, $count)){
            $items = array();
            foreach($jifens as $k=>$val){
                $items[] = $this->filter_fields('log_id,uid,type,number,intro,dateline', $val);
            } 
        }else {
            $items = array(); 
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count, 'jifen'=>$this->MEMBER['jifen']));
    }
}