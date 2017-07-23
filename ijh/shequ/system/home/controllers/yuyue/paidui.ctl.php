<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Yuyue_Paidui extends Ctl
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
        }else if(empty($shop['have_paidui'])){
            $this->msgbox->add('商户未开通排队功能', 211);
        }else{
            $this->pagedata['shop'] = $shop;
            $number = array();
            for ($i=2; $i < 51; $i++) { 
                $number[] = '"' . $i . '人' . '"';
            }
            $this->pagedata['paidui_numbers'] = implode(',', $number);
            $this->tmpl = 'yuyue/paidui/index.html';
        }  
    }
    
    
    public function loaditems()
    {
        
        $this->check_login();
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        
        if (!$items = K::M('yuyue/paidui')->items($filter, array('paidui_id'=>'desc'), $page, $limit, $count)) {
            $items= array();
        }else{
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
                if($row1 = $shop_list[$v['shop_id']]){
                    $v['shop_detail'] = array('shop_id'=>$row1['shop_id'], 'title'=>$row1['title'], 'addr'=>$row1['addr'].$row1['house'], 'lat'=>$row1['lat'], 'lng'=>$row1['lng'],'phone'=>$row1['phone']);
                }else{
                    $v['shop_detail'] = array('shop_id'=>0, 'title'=>'--', 'addr'=>'', 'lat'=>'0', 'lng'=>'0', 'phone'=>'');
                }
                if($row2 = $zhuohao_list[$v['zhuohao_id']]){
                    $v['zhuohao_detail'] = array('zhuohao_cate_title'=>$zhuohao_cate_list[$row2['cate_id']]['title'], 'title'=>$row2['title']);
                }else{
                    $v['zhuohao_detail'] = array('zhuohao_cate_title'=>'--', 'title'=>'--');
                }
                if(empty($v['wait_time'])) {
                    $v['wait_time'] = '--';
                }
                $v['detail_url'] = $this->mklink('yuyue/paidui/detail',array('args'=>$v['paidui_id']));
                $items[$k] = $v;
            }
            $items = array_slice($items, ($page-1)*10, 10, true);
            $count_num = K::M('yuyue/paidui')->count($filter);
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
        $this->tmpl = "yuyue/paidui/loaditems.html";
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
        

    }
    

    // 检查是否正常取号
	public function checkpaidui()
    {
        $this->check_login();
        $shop_id = (int)$this->GP('shop_id');
        if(!$shop_id) {
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

    // 创建排号订单
    public function create()
    {
        //未登录也可以预定
        $data['shop_id'] = (int)$this->GP('shop_id');
        $data['paidui_number'] = (int)$this->GP('paidui_number');
        $data['contact'] = $this->GP('contact');
        $data['mobile'] = $this->GP('mobile');
        if(!$data['paidui_number']) {
            $this->msgbox->add('请选择就餐人数',210)->response();
        }
        if(!$data['contact']) {
            $this->msgbox->add('请填写您的姓名',211)->response();
        }
        if(!$data['mobile']) {
            $this->msgbox->add('请填写您的手机号',212)->response();
        }
        if(!$shop_id = $data['shop_id']){
            $this->msgbox->add('未指定要排队的商户', 213);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 214);
        }else if(/*empty($shop['verify_name']) || */empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可排队', 215);
        }else if(empty($shop['have_paidui'])){
            $this->msgbox->add('商户未开通排队功能', 216);
        }else{
            $data['uid'] = (int)$this->uid;
            $data['city_id'] = $shop['city_id'];
            $data['order_from'] = defined('IN_WEIXIN') ? 'weixin' : 'wap';
            $data['lasttime'] = __TIME;
            if($paidui_id = K::M('yuyue/paidui')->create($data)){
                $this->msgbox->add('取号成功');
                $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
            }
        }
    }

    // 排号订单列表
    public function items()
    {
        $this->check_login();
        $this->tmpl = 'yuyue/paidui/items.html';
    }

    

    // 排号订单详情
    public function detail($id)
    {
        $this->check_login();
        $paidui_id = (int)$id;
        if(!$paidui_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
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
                $zhuohao_cate = K::M('yuyue/zhuohaocate')->detail($row['cate_id']);
                $detail['zhuohao_detail'] = array('zhuohao_cate_title'=>$zhuohao_cate['title'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_cate_title'=>'--', 'title'=>'--');
            }
            if($detail['wait_time'] > __TIME) {
                $detail['wait_time'] = round(($detail['wait_time']-__TIME)/60,0);
            }else {
                $detail['wait_time'] = '--';
            }
            $w_filter['dateline'] = '>:' . strtotime(date("Y-m-d"));
            $w_filter['paidui_id'] = '<:' . $paidui_id;
            $w_filter['order_status'] = 0;
            $w_filter['shop_id'] = $detail['shop_id'];
            $w_filter['closed'] = 0;
            $detail['zhuo_wait_nums'] = K::M('yuyue/paidui')->count($w_filter);
            $detail['cancel_reason_list'] = K::M('yuyue/paidui')->cancel_reason_list();
            $this->pagedata['order'] = $detail;
            $this->tmpl = 'yuyue/paidui/detail.html';
        }
    }

    // 排号订单取消
    public function cancel()
    {
        $this->check_login();
        $paidui_id = (int)$this->GP('paidui_id');
        $reason = $this->GP('reason');
        if(!$paidui_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if($detail['order_status'] != 0){
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('order_status'=>-1, 'reason'=>$reason,'lasttime'=>__TIME))){
            $this->msgbox->add('取消成功');
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id));
        }
    }

    // 排号订单取消
    public function delete()
    {
        $this->check_login();
        $paidui_id = (int)$this->GP('paidui_id');
        if(!$paidui_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/paidui')->detail($paidui_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if($detail['order_status'] != 0 && $detail['order_status'] != 1){
            $this->msgbox->add('该单号已取消或已完成', 213);
        }else if(K::M('yuyue/paidui')->update($paidui_id, array('order_status'=>-1, 'lasttime'=>__TIME))){
            $this->msgbox->add('取消单号成功');
            $this->msgbox->set_data('data', array('paidui_id'=>$paidui_id,'shop_id'=>$detail['shop_id']));
        }
    }

    public function location($shop_id)
    {
        if($shop_id = (int)$shop_id) {
            if($detail = K::M('shop/shop')->detail($shop_id)) {
                $this->pagedata['shop'] = $detail;
            }
        }
        $this->tmpl = 'yuyue/paidui/shoplocation.html';
    }
}