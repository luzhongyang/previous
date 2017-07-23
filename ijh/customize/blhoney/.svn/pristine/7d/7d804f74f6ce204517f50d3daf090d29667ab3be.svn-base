<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member_Collect extends Ctl
{


    public function items($params)
    {
        $this->check_login();
        $filter = $items = array();
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        if($collect_list = K::M('shop/collect')->items($filter, null, $page, 10)){
            
            $shop_ids = array();
            foreach($collect_list as $k=>$val){
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
          
            $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
             foreach($shop_list as $k=>$val){
                if($val['youhui']){
                    $youhui = unserialize($val['youhui']);
                    $str = '在线支付';
                    foreach ($youhui as $kk => $v) {
                        $str .= sprintf('满%s减%s', (int) $v['order_amount'], (int) $v['youhui_amount']) . ',';
                    }
                    $shop_list[$k]['youhui'] = substr($str, 0, -1);
                }   
             }
            $items = array();
            foreach($shop_list as $k=>$val){
                $items[] = $this->filter_fields('shop_id,city_id,city_name,d,youhui,orders,cate_title,title,cate_id,phone,logo,lat,lng,addr,score,comments,praise_num,min_amount,first_amount,pei_amount,pei_type,yy_status,yy_stime,yy_ltime,is_new,online_pay,info,orders,youhui', $val);
            }
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }


    public function add($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add('商家不存在',202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在',203);
        }else if(empty($detail['audit'])) {
            $this->msgbox->add('商户审核中',204);
        }else if($result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add('您已经收藏过该商家了',205);
        }else {
            $data = array('uid'=>$this->uid,'shop_id'=>$shop_id);
            if(K::M('shop/collect')->create($data)){
                $this->msgbox->add('collect success');
            }
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add('商家不存在',202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在',203);
        }else if($detail['audit'] !=1||$detail['closed'] !=0) {
            $this->msgbox->add('商家不存在或已被删除',204);
        }else if(!$result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add('您还没有收藏该商家',205);
        }else {
            if(K::M('shop/collect')->delete('shop_id='.$shop_id.' and uid='.$this->uid)){  //
                $this->msgbox->add('cancel success');
            }
        }
    }

    public function status($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add('商家不存在',202);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在',203);
        }else if($detail['audit'] !=1||$detail['closed'] !=0) {
            $this->msgbox->add('商家不存在或已被删除',204);
        }else if(!$result = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
            $this->msgbox->add('您还没有收藏该商家',205);
        }else {
            $this->msgbox->add('success');
        }
    }

}
