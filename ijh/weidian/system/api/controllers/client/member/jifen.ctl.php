<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_Jifen extends Ctl
{
    /* 积分日志
     * $page,必填
     * @param type,[jifen|money]
     */
    public function log($params)
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
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count, 'jifen'=>$this->MEMBER['jifen']));
    }
    //积分规则
    public function rule()
    {
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',$this->mklink('page',array('jifenguize')));
    }
}
