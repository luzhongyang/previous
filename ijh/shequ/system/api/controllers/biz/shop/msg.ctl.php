<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop_Msg extends Ctl_Biz
{

    public function items($params)
    {
        //0:所有消息 1:订单消息, 2:评价消息,3:投诉消息,4:系统消息
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id'=>$this->shop_id);
        if(in_array($params['type'], array(1, 2, 3, 4))){
            if((int)$params['type'] === 1){
                $filter['type'] = array(0,1,5,6);
            }else{
                $filter['type'] = $params['type']; 
            }
        }

        if(in_array($params['is_read'], array(0, 1))){
            $filter['is_read'] = $params['is_read']; 
        }else {
            $filter['is_read'] = array(0,1,2); 
        }        
        if(!$items = K::M('shop/msg')->items($filter, array('is_read'=>'ASC','msg_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }

        $odrmsg_count = K::M('shop/msg')->count(array('shop_id'=>$this->shop_id,'type'=>array(0,1,5,6), 'is_read'=>0));
        $pijmsg_count =  K::M('shop/msg')->count(array('shop_id'=>$this->shop_id,'type'=>2, 'is_read'=>0));
        $tsumsg_count =  K::M('shop/msg')->count(array('shop_id'=>$this->shop_id,'type'=>3, 'is_read'=>0));
        $sysmsg_count =  K::M('shop/msg')->count(array('shop_id'=>$this->shop_id,'type'=>4, 'is_read'=>0));
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count, 'odrmsg_count'=>$odrmsg_count,'pijmsg_count'=>$pijmsg_count,'tsumsg_count'=>$tsumsg_count,'sysmsg_count'=>$sysmsg_count));
    }

    public function read($params)
    {

        if(!$ids = K::M('verify/check')->ids($params['msg_id'])){
            $this->msgbox->add('未指定消息ID', 211);
        }else if(!$items = K::M('shop/msg')->items_by_ids($ids)){
            $this->msgbox->add('未指定要操作的消息', 212);
        }else{
            $mids = array();
            foreach($items as $k=>$v){
                if(($v['shop_id'] == $this->shop_id) && !$v['is_read']){
                    $mids[$v['msg_id']] = $v['msg_id'];
                } 
            }
            if($mids){
                K::M('shop/msg')->update($mids, array('is_read'=>1));
            }
            $this->msgbox->add('success');
        }
    }    
}