<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Profit extends Ctl_Ucenter_Shop
{

    /**
     * 我的统计
     */
    public function index(){
        $filter = array();
        $filter['weidian'][':OR'] = array('invite1'=>$this->uid,'invite2'=>$this->uid,'invite3'=>$this->uid);
        $filter['weidian']['type'] = "fenxiao";
        $filter['order_status'] = 8;
        //$filter['weidian']['sid'] = FX_SID;
        $items = K::M('weidian/order')->items_by_status($filter,array('order_id'=>'desc'),1,10000);
        //print_r($items);die;
        $wc_total = 0;
        foreach($items as $k=>$v){
            if($v['invite1'] == $this->uid){
                $wc_total += $v['amount_1'];
            }elseif($v['invite2'] == $this->uid){
                $wc_total += $v['amount_2'];
            }elseif($v['invite3'] == $this->uid){
                $wc_total += $v['amount_3'];
            }
        }
        $this->pagedata['wc_total'] = $wc_total;
        
        $map = array();
        $map['weidian'][':OR'] = array('invite1'=>$this->uid,'invite2'=>$this->uid,'invite3'=>$this->uid);
        $map['weidian']['type'] = "fenxiao";
        $map['order_status'] = array(0,1,2,3,4);
        //$map['weidian']['sid'] = FX_SID;
        $items2 = K::M('weidian/order')->items_by_status($map,array('order_id'=>'desc'),1,10000);
        //print_r($this->system->db->SQLLOG());die;
        //print_r($items2);die;
        $dwc_total = 0;
        foreach($items2 as $k=>$v){
            if($v['invite1'] == $this->uid){
                $dwc_total += $v['amount_1'];
            }elseif($v['invite2'] == $this->uid){
                $dwc_total += $v['amount_2'];
            }elseif($v['invite3'] == $this->uid){
                $dwc_total += $v['amount_3'];
            }
        }
        //print_r($dwc_total);die;
        $this->pagedata['dwc_total'] = $dwc_total;
        
        $tixian = K::M('fenxiao/tixian')->items(array('sid'=>FX_SID,'status'=>1));
        $tixian_money = 0;
        foreach($tixian as $k=>$v){
            $tixian_money += $v['money'];
        }
        $this->pagedata['tixian_money'] = $tixian_money;
        $this->tmpl = 'fenxiao/ucenter/shop/profit/index.html';
    }
    
    
    public function order(){
        $date_items = array();
        $date_start = strtotime(date('Y-m',$this->FENXIAO['dateline']));
        //$data_end = __TIME;
        $data_end = strtotime('+1 month',strtotime(date('Y-m',__TIME)));
        $date_items = array(0=>array('date_cn'=>date('Y年m月',$date_start),'date_math'=>date('Y-m',$date_start),'date_year'=>date('Y年',$date_start),'date_month'=>date('m月',$date_start))); // 当前月;  
        
        while( ($date_start = strtotime('+1 month', $date_start)) < $data_end){  
              $date_items[] = array('date_cn'=>date('Y年m月',$date_start),'date_math'=>date('Y-m',$date_start),'date_year'=>date('Y年',$date_start),'date_month'=>date('m月',$date_start));// 取得递增月;   
        }  
        
        //print_r(count($date_items));die;
        $this->pagedata['num'] = count($date_items);
        $this->pagedata['date_items'] = $date_items;
        $this->tmpl = 'fenxiao/ucenter/shop/profit/order.html';
    }


    public function loaditems($page=1){
        $month = $this->GP('month');
        $s_time = strtotime($month);
        $e_time = strtotime('+1 month', $s_time);
        //print_r($month);die;
        $filter = array('order_status'=>8,'dateline'=>$s_time."~".$e_time); //订单完成才可参与统计
        $filter['weidian'][':OR'] = array('invite1'=>$this->uid,'invite2'=>$this->uid,'invite3'=>$this->uid);
        $filter['weidian']['type'] = "fenxiao";
        //$filter['weidian']['sid'] = FX_SID;
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('weidian/order')->items_by_status($filter,array('order_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        //print_r($items);die;
        $order_ids = $sids = array();
        foreach($items as $k=>$v){
            if($v['invite1'] == $this->uid){
                $items[$k]['profit'] = $v['amount_1'];
                $items[$k]['level'] = 0;
            }elseif($v['invite2'] == $this->uid){
                $items[$k]['profit'] = $v['amount_2'];
                $items[$k]['level'] = 1;
            }elseif($v['invite3'] == $this->uid){
                $items[$k]['profit'] = $v['amount_3'];
                $items[$k]['level'] = 2;
            }
            $sids[$v['sid']] = $v['sid']; 
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        $this->pagedata['fenxiao_shops'] = K::M('fenxiao/fenxiao')->items_by_ids($sids);
        $order_products = K::M('weidian/orderproduct')->items(array('order_id'=>$order_ids));
        $product_ids =  array();
        foreach($items as $k=>$v){
            foreach($order_products as $k1=>$v1){
                if($v['order_id'] == $v1['order_id']){
                    $product_ids[$v1['product_id']] = $v1['product_id'];
                    $items[$k]['products'][] = $v1;
                }
            }
        }
        if($product_ids){
            $this->pagedata['products'] = K::M('weidian/product')->items_by_ids($product_ids);
        }
        //print_r($items);die;
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        //print_r($items);die;
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'fenxiao/ucenter/shop/profit/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    

}
