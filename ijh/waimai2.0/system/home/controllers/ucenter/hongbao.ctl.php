<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Hongbao extends Ctl_Ucenter {


    public function index($page = 1) 
    {
        $filter = $pager = array();
        if($money= $this->GP('money')){
            $filter['min_amount'] = '<=:' .$money;
        }
        $filter['uid'] = $this->uid;
        $filter['order_id'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        if($items = K::M('hongbao/hongbao')->items($filter, array('amount'=>'desc'),null,null,$count)) {
            foreach($items as $k => $v){
                $items[$k]['stime'] = date('Y-m-d',$v['stime']);
                $items[$k]['ltime'] = date('Y-m-d',$v['ltime']);
            }
        }
        $this->pagedata['hb_count'] = $count;
        $this->pagedata['items'] = $items;
        $this->pagedata['types'] = K::M('hongbao/hongbao')->getType();
        $this->tmpl = 'ucenter/hongbao/index.html';
    }
    
    
    public function lists($from=null, $money)
    {
        $filter = $pager = array();
        $filter['uid'] = $this->uid;
        $filter['order_id'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        if($money){
            $filter['min_amount'] = '<=:' .$money;
        }
        else{
            $money = 0;
        }
        if($items = K::M('hongbao/hongbao')->items($filter, array('amount'=>'desc'),null,null,$count)) {
            foreach($items as $k => $v){
                $v['stime'] = date('Y-m-d',$v['stime']);
                $v['ltime'] = date('Y-m-d',$v['ltime']);
                $items[$k] = $v;
            }
        }
        $this->pagedata['money'] = $money;
        $this->pagedata['hb_count'] = $count;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'ucenter/hongbao/lists.html';
    }

    public function hongbao_list()
    {
        
        $filter = $pager = array();
        $page = max((int) $this->GP('page'), 1);
        $pager['limit'] = $limit = 10;
        $filter['uid'] = $this->uid;
        $filter['order_id'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        if (!$items = K::M('hongbao/hongbao')->items($filter, null, $page, $limit, $count)) {
            $items= array();
        }else{
            foreach($items as $k => $v){
                $items[$k]['dateline'] = date('Y-m-d',$v['dateline']);
                $items[$k]['ltime'] = date('Y-m-d',$v['ltime']);
            }
        }
        $this->pagedata['items'] = $items;
        $this->msgbox->set_data('data', array('items' => array_values($items)));
    }

    public function exchange()
    {
        if ($hongbao_sn = $this->GP('hongbao_sn')) {
            $detail = K::M('hongbao/hongbao')->find(array('hongbao_sn' => $hongbao_sn, 'order_id' => 0, 'ltime' => '>:' . time()));
            if (empty($detail)) {                
                $this->msgbox->add(L('红包不存在'), 212);
            } else if ($detail['uid'] != 0) {
                $this->msgbox->add(L('红包已经被使用'), 213);
            } else if (false !== K::M('hongbao/hongbao')->update($detail['hongbao_id'], array('uid' => $this->uid))) {
                $info  = K::M('hongbao/hongbao')->detail($detail['hongbao_id']);
                if($info['uid'] && ($info['uid'] != $detail['uid'])){
                    $title = sprintf('恭喜你获得一个%s元红包', $info['amount']);
                    $content = sprintf('恭喜你获得一个%s元红包,订单满%s可用', $info['amount'], $info['min_amount']);
                    K::M('member/member')->send($data['uid'], $title, $content, 'hongbao');
                }
                $this->msgbox->add('兑换成功');
            } else {
                $this->msgbox->add('兑换失败', 214);
            }
        } else {
            $this->tmpl = 'ucenter/hongbao/exchange.html';
        }
    }
    
    public function info()
    {
        $this->tmpl = 'ucenter/hongbao/info.html';
    }
    
    public function overdue()
    {
        $filter = $pager = array();
        if($money= $this->GP('money')){
            $filter['min_amount'] = '<=:' .$money;
        }
        $filter['uid'] = $this->uid;
        $filter[':OR'] = array('order_id'=>'>:0','ltime'=>'<:'.time());
        if($items = K::M('hongbao/hongbao')->items($filter, array('amount'=>'desc'),null,null,$count)) {
            foreach($items as $k => $v){
                $items[$k]['stime'] = date('Y-m-d',$v['stime']);
                $items[$k]['ltime'] = date('Y-m-d',$v['ltime']);
            }
        }
        $this->pagedata['hb_count'] = $count;
        $this->pagedata['items'] = $items;
        $this->pagedata['types'] = K::M('hongbao/hongbao')->getType();
        $this->tmpl = 'ucenter/hongbao/overdue.html';
    }

}
