<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Msg extends Ctl
{
    

    public function index($params)
    {
        $this->check_login();
        $limit = 10;
        $items = $filter = array();
        $page = max((int)$params['page'], 1);
        $filter['staff_id'] = $this->staff_id;
        if(in_array($params['is_read'], array(0, 1))){
            $filter['is_read'] = $params['is_read']; 
        }else {
            $filter['is_read'] = array(0,1,2); 
        }  
        if(!$items = K::M('staff/msg')->items($filter, array('is_read'=>'ASC','msg_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function read($params)
    {
        $this->check_login();
        if($msg_ids = K::M('verify/check')->ids($params['msg_ids'])){
            $mids = array();
            if($items = K::M('staff/msg')->items_by_ids($msg_ids)){
                foreach($items as $v){
                    if($v['staff_id'] == $this->staff_id && !$v['is_read']){
                        $mids[$v['msg_id']] = $v['msg_id'];
                    }
                }
                if($mids){
                    if(K::M('staff/msg')->batch($mids, array('is_read'=>1))){
                        $this->err->add(L('批量阅读内容成功'));
                    }
                }
            }            
        }
    }
}