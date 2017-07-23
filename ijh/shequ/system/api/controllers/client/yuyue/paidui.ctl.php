<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Yuyue_Paidui extends Ctl
{


    public function create($params)
    {   
        //未登录也可以预定
        if(!$data = $this->check_fields($params, 'shop_id,paidui_number,contact,mobile')){
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop_id = (int)$data['shop_id']){
            $this->msgbox->add('未指定要排队的商户', 212);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 213);
        }else if(/*empty($shop['verify_name']) || */empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可排队', 214);
        }else if(empty($shop['have_paidui'])){
            $this->msgbox->add('商户未开通排队功能', 211);
        }else{
            $data['uid'] = (int)$this->uid;
            $data['city_id'] = $shop['city_id'];
            if($paidui_id = K::M('yuyue/paidui')->create($data)){
                $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
            }
        }
    }

    public function items($params)
    {
        $this->check_login();
        $filter = array('uid'=>$this->uid, 'closed'=>0);
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('yuyue/paidui')->items($filter, array('paidui_id'=>'DESC'), $page, $limit, $count)){
            $shop_ids = $zhuohao_ids = $shop_list = $zhuohao_list = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
                // 计算还需等待多少桌  
                $w_filter['dateline'] = '>:' . strtotime(date("Y-m-d"));
                $w_filter['paidui_id'] = '<:' . $v['paidui_id'];
                $w_filter['order_status'] = 0;
                $w_filter['shop_id'] = $v['shop_id'];
                $w_filter['closed'] = 0;
                $items[$k]['zhuo_wait_nums'] = K::M('yuyue/paidui')->count($w_filter);
                if($v['wait_time'] > __TIME) {
                    $items[$k]['wait_time'] = round(($v['wait_time']-__TIME)/60,0);
                }else {
                    $items[$k]['wait_time'] = '--';
                }
            }
            if($shop_ids){
                $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
                foreach($zhuohao_list as $k1=>$v1) {
                    $zhuohao_cate_ids[] = $v1['cate_id'];
                }
            }
            if($zhuohao_cate_ids) {
                $zhuohao_cate_list = K::M('yuyue/zhuohaocate')->items_by_ids($zhuohao_cate_ids);
            }
            foreach($items as $k=>$v){
                if($row = $shop_list[$v['shop_id']]){
                    $v['shop_detail'] = array('shop_id'=>$row['shop_id'], 'title'=>$row['title'], 'addr'=>$row['addr'].$row['house'], 'lat'=>$row['lat'], 'lng'=>$row['lng'],'phone'=>$row['phone']);
                }else{
                    $v['shop_detail'] = array('shop_id'=>0, 'title'=>'--', 'addr'=>'', 'lat'=>'0', 'lng'=>'0', 'phone'=>'');
                }
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_cate_title'=>$zhuohao_cate_list[$row['cate_id']]['title'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_cate_title'=>'--', 'title'=>'--');
                }
                $items[$k] = $v;
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 211);
        }else{
            if($detail['shop_id'] && ($row = K::M('shop/shop')->detail($detail['shop_id']))){
                $detail['shop_detail'] = array('shop_id'=>$row['shop_id'], 'title'=>$row['title'], 'addr'=>$row['addr'].$row['house'], 'lat'=>$row['lat'], 'lng'=>$row['lng'],'phone'=>$row['phone']);
            }else{
                $v['shop_detail'] = array('shop_id'=>0, 'title'=>'--', 'addr'=>'', 'lat'=>'0', 'lng'=>'0', 'phone'=>'');
            }
            if($detail['zhuohao_id'] && ($row = K::M('yuyue/zhuohao')->detail($detail['zhuohao_id']))){
                $zhuohao_cate = K::M('yuyue/zhuohaocate')->detail($row['cate_id']);
                $detail['zhuohao_detail'] = array('zhuohao_cate_title'=>$zhuohao_cate['title'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_cate_title'=>'--', 'title'=>'--');
            }
            $w_filter['dateline'] = '>:' . strtotime(date("Y-m-d"));
            $w_filter['paidui_id'] = '<:' . $paidui_id;
            $w_filter['order_status'] = 0;
            $w_filter['shop_id'] = $detail['shop_id'];
            $w_filter['closed'] = 0;
            $detail['zhuo_wait_nums'] = K::M('yuyue/paidui')->count($w_filter);
            if($detail['wait_time'] > __TIME) {
                $detail['wait_time'] = round(($detail['wait_time']-__TIME)/60,0);
            }else {
                $detail['wait_time'] = '--';
            }
            $this->msgbox->set_data('data', $detail);
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if($detail['order_status'] != 0){
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('order_status'=>-1, 'reason'=>$params['reason']))){
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }

    public function cancelreason($params)
    {
        $this->msgbox->set_data('data', array('items'=>K::M('yuyue/paidui')->cancel_reason_list()));
    }

    public function delete($params)
    {
        $this->check_login();
        if(!$paidui_id = (int)$params['paidui_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if(K::M('yuyue/paidui')->delete($paidui_id)){
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }

    public function checkpaidui($params)
    {
        $this->check_login();
        if(!$shop_id = $params['shop_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 213);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可排队', 214);
        }else if(empty($shop['have_paidui'])){
            $this->msgbox->add('商户未开通排队功能', 211);
        }else if($row = K::M('yuyue/paidui')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id,'order_status'=>"0"))){
            $this->msgbox->set_data('data', array('paidui_id'=>$row['paidui_id']));
        }else{
            $this->msgbox->set_data('data', array('paidui_id'=>'0'));
        }
    }

}
