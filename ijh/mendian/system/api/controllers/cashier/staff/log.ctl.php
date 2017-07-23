<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Staff_Log extends Ctl_Cashier 
{
    
    
    public function items($params)
    {
        $page = max((int)$params['page'], 1);
        $limit = 10;
        
        if(($staff_id = (int)$params['staff_id']) && $this->staff['is_owner']){
            $staff = K::M('cashier/staff')->detail($staff_id);
        }else{
            $staff = $this->staff;
        }
        if($staff['shop_id'] != $this->shop_id){
            $this->msgbox->add('收银员不存在', 211);
        }else{
            $filter = array('staff_id'=>$staff['staff_id']);
            if(!$items = K::M('cashier/staff/log')->items($filter, null, $page, $limit, $count)){
                $items = array();
            }
            $staff = $this->check_fields($staff, 'staff_id,name,mobile');
            $this->msgbox->set_data(array('items'=>array_values($items), 'staff_detail'=>$staff, 'total_count'=>$count));
        }
    }

    public function detail($params)
    {
        if(!$log_id = (int)$params['log_id']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$log = K::M('cashier/staff/log')->detail($log_id)){
            $this->msgbox->add('记录不存在或已经删除', 212);
        }else if($log['shop_id'] != $this->shop_id){
            $this->msgbox->add('记录不存在或已经删除', 213);
        }else{
            if($this->staff_id != $log['staff_id']){
                if(!$this->staff['is_owner']){
                    $this->msgbox->add('您没有权限查看', 214)->response();
                }
                $staff = K::M('cashier/staff')->detail($log['staff_id']);
            }else{
                $staff = $this->staff;
            }
            $staff = $this->check_fields($staff, 'staff_id,name,mobile');
            $this->msgbox->set_data(array('log_detail'=>$log, 'staff_detail'=>$staff));
        }
    }

}