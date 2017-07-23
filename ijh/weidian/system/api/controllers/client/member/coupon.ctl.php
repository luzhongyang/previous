<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_Coupon extends Ctl
{
    public function index($params){
        $this->check_login();
        
        $filter = $pager = array();
        $page = max((int)$params['page'], 1);
        $orderby = array('ticket_id'=>'desc');
        $limit = 10;
        $filter['use_time'] = 0;
        $filter['status'] = 0;
        $filter['uid'] = $this->uid;
        $filter['type'] = $type;
        $items = K::M('tuan/ticket')->items($filter, $orderby, $page, $limit, $count);
        
        foreach($items as $k => $v){
            $detail = K::M('tuan/tuan')->detail($v['tuan_id']);
            $shop = K::M('shop/shop')->detail($v['shop_id']);
            if($detail){
                $items[$k]['detail_title'] = $shop['title'];
                $items[$k]['detail_photo'] = $detail['photo'];
                $items[$k]['detail_price'] = $detail['price'];
            }
            if($v['ltime'] <= time()){
                $items[$k]['end'] = 1;
            }else{
                $items[$k]['end'] = 0;
            }
        }
        
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
        
    }

}
