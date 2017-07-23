<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Tongji extends Ctl_Ucenter_Shop
{

    /**
     * 我的统计
     */
    public function index(){ 
        $date_items = array();
        $date_start = strtotime(date('Y-m',$this->FENXIAO['dateline']));
        //$data_end = __TIME;
        $data_end = strtotime('+1 month',strtotime(date('Y-m',__TIME)));
        $date_items = array(0=>array('date_cn'=>date('Y年m月',$date_start),'date_math'=>date('Y-m',$date_start))); // 当前月;  
        
        while( ($date_start = strtotime('+1 month', $date_start)) < $data_end){  
              $date_items[] = array('date_cn'=>date('Y年m月',$date_start),'date_math'=>date('Y-m',$date_start));// 取得递增月;   
        }  
        $this->pagedata['num'] = count($date_items);
        $this->pagedata['date_items'] = $date_items;
        //print_r($date_items);die;
        $this->tmpl = 'fenxiao/ucenter/shop/tongji/index.html';
    }

    public function loaditems(){
        $month = $this->GP('month');
        $s_time = strtotime($month);
        $e_time = strtotime('+1 month', $s_time);
        //print_r($month);die;
        $filter = array('order_status'=>8,'dateline'=>$s_time."~".$e_time); //订单完成才可参与统计
        $filter['weidian'][':OR'] = array('invite1'=>$this->uid,'invite2'=>$this->uid,'invite3'=>$this->uid);
        $filter['weidian']['type'] = "fenxiao";
        //$filter['weidian']['sid'] = FX_SID;
        if(!$items = K::M('weidian/order')->items_by_status($filter,array('order_id'=>'desc'),1, 10000, $count)){
            $items = array();
        }
        //print_r($items);die;
        $sids = array();
        foreach($items as $k=>$v){
            $sids[$v['sid']] = $v['sid'];
        }
        //print_r($items);
        $s_items = $sids;
        foreach($s_items as $k=>$v){
            $s_items[$k] = array();
        }
        foreach($s_items as $k=>$v){
            foreach($items as $k1=>$v1){
                if($k == $v1['sid']){
                    $s_items[$k][] = $v1;
                }
            }
        }
        foreach($s_items as $k=>$v){
            $s_items[$k] = array('sid'=>$k,'num'=>count($v));
        }
        $this->pagedata['fx_shops'] = K::M('fenxiao/fenxiao')->items_by_ids($sids);
        $this->pagedata['items'] = $s_items;
        $this->pagedata['count'] = count($items);
        $this->tmpl = 'fenxiao/ucenter/shop/tongji/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    
    
    public function profit(){ 
        $date_items = array();
        $date_start = strtotime(date('Y-m',$this->FENXIAO['dateline']));
        //$data_end = __TIME;
        $data_end = strtotime('+1 month',strtotime(date('Y-m',__TIME)));
        $date_items = array(0=>array('date_cn'=>date('Y年m月',$date_start),'date_math'=>date('Y-m',$date_start))); // 当前月;  
        
        while( ($date_start = strtotime('+1 month', $date_start)) < $data_end){  
              $date_items[] = array('date_cn'=>date('Y年m月',$date_start),'date_math'=>date('Y-m',$date_start));// 取得递增月;   
        }  
        //print_r($date_items); die;
        $this->pagedata['num'] = count($date_items);
        $this->pagedata['date_items'] = $date_items;
        $this->tmpl = 'fenxiao/ucenter/shop/tongji/profit.html';
    }

    public function loaddata(){
        $month = $this->GP('month');
        $s_time = strtotime($month);
        $e_time = strtotime('+1 month', $s_time);
        $filter = array('order_status'=>8,'dateline'=>$s_time."~".$e_time); //订单完成才可参与统计
        $filter['weidian'][':OR'] = array('invite1'=>$this->uid,'invite2'=>$this->uid,'invite3'=>$this->uid);
        $filter['weidian']['type'] = "fenxiao";
        //$filter['weidian']['sid'] = FX_SID;
        if(!$items = K::M('weidian/order')->items_by_status($filter,array('order_id'=>'desc'),1, 10000, $count)){
            $items = array();
        }
        $s_items = array(1=>array(),2=>array());
        foreach($items as $k=>$v){
            if($v['invite1'] == $this->uid){
                $s_items[1][] = $v['amount_1'];
            }elseif($v['invite2'] == $this->uid){
                $s_items[2][] = $v['amount_2'];
            }elseif($v['invite3'] == $this->uid){
                $s_items[2][] = $v['amount_3'];
            }
        }
        $amount = $amount_self = $amount_member = 0;
        foreach($s_items as $k=>$val){
            if($k==1){
                foreach($val as $k1=>$v1){
                   $amount += $v1;
                   $amount_self += $v1;
                } 
            }else{
                foreach($val as $k1=>$v1){
                   $amount += $v1;
                   $amount_member += $v1;
                } 
            }
        }
        $this->pagedata['amount'] = $amount;
        $this->pagedata['amount_self'] = $amount_self;
        $this->pagedata['amount_member'] = $amount_member;
        $this->tmpl = 'fenxiao/ucenter/shop/tongji/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    

}
