<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Yuyue_Dingzuo extends Ctl
{
	// 填写订单
    public function index($id)
    {   
        $this->check_login();
        if(!$shop_id = (int)$id) {
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 213);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可排队', 214);
        }else if(empty($shop['have_dingzuo'])){
            $this->msgbox->add('商户未开通订座功能', 211);
        }else{
            $this->pagedata['shop'] = $shop;
            $number = array();
            for ($i=2; $i < 51; $i++) { 
                $number[] = $i;
            }
            $this->pagedata['yuyue_numbers'] = $number;
            $this->tmpl = 'yuyue/dingzuo/index.html';
        }
    }
    
    public function loaditems($page)
    {
        $this->check_login();
        

        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        
        if (!$items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'desc'), $page, $limit, $count)) {
            $items= array();
        }else{
            
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
                if($row2 = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_id'=>$row2['zhuohao_id'], 'title'=>$row2['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
                }
                if($v['order_status'] == 0) {
                    $v['order_status_label'] = '等待商户确认订单';
                }else if($v['order_status'] == 1) {
                    $v['order_status_label'] = '预约成功';
                }else if($v['order_status'] == -1) {
                    $v['order_status_label'] = '已取消';
                }
                $v['yuyue_time_str'] = date('Y-m-d H:i',$v['yuyue_time']);
                $v['detail_url'] = $this->mklink('yuyue/dingzuo/detail',array('args'=>$v['dingzuo_id']));
                $items[$k] = $v;
            }
            $items = array_slice($items, ($page - 1) * 10, 10, true);
            
            $count_num = K::M('yuyue/dingzuo')->count($filter);
            if($count_num <= $limit){
                $loadst = 0;
            }
            else{
                $loadst = 1;
            }
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = "yuyue/dingzuo/loaditems.html";
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
       
    }

    public function checkdingzuo()
    {
        $this->check_login();
        $shop_id = (int)$this->GP('shop_id');
        if(!$shop_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 213);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可排队', 214);
        }else if(empty($shop['have_dingzuo'])){
            $this->msgbox->add('商户未开通订座功能', 211);
        }else if($row = K::M('yuyue/dingzuo')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id,'order_status'=>"0"))){
            $this->msgbox->set_data('data', array('dingzuo_id'=>$row['dingzuo_id']));
        }else{
            $this->msgbox->set_data('data', array('dingzuo_id'=>'0'));
        }
    }

    public function create($params)
    {   
        $this->check_login();
        $data['shop_id'] = (int)$this->GP('shop_id');
        $data['yuyue_time'] = strtotime($this->GP('yuyue_time'));
        $data['yuyue_number'] = $this->GP('yuyue_number');
        $data['is_baoxiang'] = (int)$this->GP('is_baoxiang');
        $data['contact'] = $this->GP('contact');
        $data['mobile'] = $this->GP('mobile');
        $data['notice'] = $this->GP('notice');
        if(!$data['shop_id']){
            $this->msgbox->add('未指定要预定的商户', 212);
        }else if(!$shop = K::M('shop/shop')->detail($data['shop_id'])){
            $this->msgbox->add('预订的商户不存在或已经删除', 213);
        }else if(/*empty($shop['verify_name']) || */empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可订座', 214);
        }else if(empty($shop['have_dingzuo'])){
            $this->msgbox->add('商户未开通订座功能', 215);
        }else if($data['yuyue_time'] < __TIME){
            $this->msgbox->add('请选择有效的预约时间',216);
        }else if(!$data['yuyue_time']){
            $this->msgbox->add('请选择预约时间',216);
        }else if(!$data['yuyue_number']){
            $this->msgbox->add('请选择预约人数',217);
        }else if(!$data['contact']){
            $this->msgbox->add('请填写您的姓名',218);
        }else if(!$data['mobile']){
            $this->msgbox->add('请填写您的手机号',219);
        }else{
            $data['uid'] = (int)$this->uid;
            $data['city_id'] = $shop['city_id'];
            $data['order_from'] = defined('IN_WEIXIN') ? 'weixin' : 'wap';
            if($dingzuo_id = K::M('yuyue/dingzuo')->create($data)){
                $this->msgbox->add('订座成功');
                $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
            }
        }
    }

    public function items($params)
    {
        $this->check_login();
        $this->tmpl = 'yuyue/dingzuo/items.html';
    }

    

    public function detail($id)
    {
        $this->check_login();
        $dingzuo_id = (int)$id;
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 211);
        }else{
            if($detail['shop_id'] && ($row = K::M('shop/shop')->detail($detail['shop_id']))){
                $detail['shop'] = array('shop_id'=>$row['shop_id'], 'title'=>$row['title'], 'addr'=>$row['addr'].$row['house'], 'lat'=>$row['lat'], 'lng'=>$row['lng'],'phone'=>$row['phone'],'mobile'=>$row['mobile'],'logo'=>$row['logo']);
            }else{
                $v['shop_detail'] = array('shop_id'=>0, 'title'=>'--', 'addr'=>'', 'lat'=>'0', 'lng'=>'0', 'phone'=>'');
            }
            if($detail['zhuohao_id'] && ($row = K::M('yuyue/zhuohao')->detail($detail['zhuohao_id']))){
                $detail['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
            }
            if($detail['order_status'] == 0) {
                $detail['order_status_label'] = '等待商户确认订单';
            }else if($detail['order_status'] == 1) {
                $detail['order_status_label'] = '预约成功';
            }else if($detail['order_status'] == -1) {
                $detail['order_status_label'] = '已取消';
            }
            $detail['cancel_reason_list'] = K::M('yuyue/dingzuo')->cancel_reason_list();
            $this->pagedata['order'] = $detail;
            $this->tmpl = 'yuyue/dingzuo/detail.html';
        }
    }

    public function cancel()
    {
        $this->check_login();
        $dingzuo_id = (int)$this->GP('dingzuo_id');
        $reason = $this->GP('reason');
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if($detail['order_status'] != 0){
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('order_status'=>-1, 'reason'=>$reason,'lasttime'=>__TIME))){
            $this->msgbox->add('取消成功');
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function delete()
    {
        $this->check_login();
        $dingzuo_id = (int)$this->GP('dingzuo_id');
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if(K::M('yuyue/dingzuo')->delete($dingzuo_id)){
            $this->msgbox->add('删除成功');
            K::M('yuyue/dingzuo')->update($dingzuo_id,array('lasttime'=>__TIME));
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id,'shop_id'=>$detail['shop_id']));
        }
    }

    public function location($shop_id)
    {
        if($shop_id = (int)$shop_id) {
            if($detail = K::M('shop/shop')->detail($shop_id)) {
                $this->pagedata['shop'] = $detail;
            }
        }
        $this->tmpl = 'yuyue/dingzuo/shoplocation.html';
    }

    // 催单
    public function cuidan($dingzuo_id)
    {
        $this->check_login();
        if(!$dingzuo_id = (int)$this->GP('dingzuo_id')){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)) {
            $this->msgbox->add("订单不存在",212);
        }else if($dingzuo['uid'] != $this->uid) {
            $this->msgbox->add('你没有权限操作',213);
        }else if((__TIME - $dingzuo['jd_time']) < 1800){
            $this->msgbox->add('请在30分钟后催单',214);
        }else if((__TIME - $dingzuo['cui_time']) < 900){
            $this->msgbox->add('请在15分钟之后催单',215);
        }else {
            if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('cui_time'=>__TIME))) {
                $dingzuo['order_id'] = $dingzuo['dingzuo_id'];
                K::M('order/order')->send_shop('用户正在催单', sprintf("用户(%s)正在催促订座订单(%s)", $dingzuo['contact'] ,$dingzuo_id), $dingzuo);
                $this->msgbox->add('催单成功');
            }else {
                $this->msgbox->add('催单失败',216);
            }
        }
    }
}
