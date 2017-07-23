<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Yuyue_Dingzuo extends Ctl
{


    public function create($params)
    {   
        $this->check_login();
        if(!$data = $this->check_fields($params, 'shop_id,yuyue_time,yuyue_number,is_baoxiang,contact,mobile,notice')){
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop_id = (int)$data['shop_id']){
            $this->msgbox->add('未指定要预定的商户', 212);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('预订的商户不存在或已经删除', 213);
        }else if(/*empty($shop['verify_name']) || */empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可订座', 214);
        }else if(empty($shop['have_dingzuo'])){
            $this->msgbox->add('商户未开通订座功能', 211);
        }else{
            $data['uid'] = (int)$this->uid;
            $data['city_id'] = $shop['city_id'];
            if($dingzuo_id = K::M('yuyue/dingzuo')->create($data)){
                $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
            }
        }
    }

    public function items($params)
    {
        $this->check_login();
        $filter = array('uid'=>$this->uid, 'closed'=>0);
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'DESC'), $page, $limit, $count)){
            $shop_ids = $zhuohao_ids = $shop_list = $zhuohao_list = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($shop_ids){
                $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($zhuohao_ids){
                $zhuohao_list = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
            foreach($items as $k=>$v){
                if($row = $shop_list[$v['shop_id']]){
                    $v['shop_detail'] = array('shop_id'=>$row['shop_id'], 'title'=>$row['title'], 'addr'=>$row['addr'].$row['house'], 'lat'=>$row['lat'], 'lng'=>$row['lng'],'phone'=>$row['phone']);
                }else{
                    $v['shop_detail'] = array('shop_id'=>0, 'title'=>'--', 'addr'=>'', 'lat'=>'0', 'lng'=>'0', 'phone'=>'');
                }
                if($row = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                $items[$k] = $v;
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
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
                $detail['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
            }
            $this->msgbox->set_data('data', $detail);
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if($detail['order_status'] != 0){
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('order_status'=>-1, 'reason'=>$params['reason']))){
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function cancelreason($params)
    {
        $this->msgbox->set_data('data', array('items'=>K::M('yuyue/dingzuo')->cancel_reason_list()));
    }

    public function delete($params)
    {
        $this->check_login();
        if(!$dingzuo_id = (int)$params['dingzuo_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if(K::M('yuyue/dingzuo')->delete($dingzuo_id)){
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function checkdingzuo($params)
    {
        $this->check_login();
        if(!$shop_id = $params['shop_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 213);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可排队', 214);
        }else if(empty($shop['have_dingzuo'])){
            $this->msgbox->add('商户未开通排队功能', 211);
        }else if($row = K::M('yuyue/dingzuo')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id,'order_status'=>"0" /*, 'yuyue_time'=>'>:'.__TIME*/))){
            $this->msgbox->set_data('data', array('dingzuo_id'=>$row['dingzuo_id']));
        }else{
            $this->msgbox->set_data('data', array('dingzuo_id'=>'0'));
        }
    }
}
