<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_ordermanage extends Ctl_Biz
{

    public function index($page=1) //0:全部，1：待接订单，2：待配送订单，3：待完成订单，4：已完成订单
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $type = (int)$this->GP('type');
        $this->pagedata['type'] = $type;
        switch ($type){
            case 1:
                $filter['order_status'] = 0;
                $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
                break;
            case 2 :
                $filter['order_status'] = 1;
                //$filter[':SQL'] = '(`pei_type`=0 OR (`pei_type`=1 AND `staff_id`>0))';
                break;
            case 3 :
                $filter['order_status'] = array(3,4);
                break;
            case 4 :
                $filter['order_status'] = array(-1,8);
                break;
            default :
                $filter['order_status'] = '>=:0';
                $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
                break;
                
        }
        $map['order_status'] = 0;
        $map['shop_id'] = $this->shop_id;
        $map[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))'; 

        $last_order = K::M('order/order')->find($map,array('order_id'=>'desc'));
        $last_order_id = $_COOKIE['last_order_id'];
        if($last_order['order_id']!=$last_order_id){
            $this->pagedata['play_mp3'] = 1;
            setcookie("last_order_id",$last_order['order_id'],time()+86400*30,'/');
        }
        
        if($order_id = (int) $this->GP('order_id')){
            $filter['order_id'] = $order_id;
            $this->pagedata['order_id'] = $order_id;
        }
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page,$limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}'),array('type'=>$type)));
        }
        //PRINT_R($items);DIE;
        //print_r($this->system->db->SQLLOG());die;
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['order_price'] = $val['product_price'] + $val['package_price'] + $val['freight'];
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        //print_r($items);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['payments'] = K::M('order/order')->get_payments();
        $this->tmpl = 'biz/ordermanage/index.html';
    }
    


    public function pei($page=1)
    {
       $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 1;
        $filter[':SQL'] = '(`pei_type`=0 OR (`pei_type`=1 AND `staff_id`>0))';
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->tmpl = 'biz/order/pei.html';
    }
    
    public function cancel($order_id=null){
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'),212);
            }else if($order['order_status'] !=0&&$order['order_status']!=1){
                $this->msgbox->add(L('该订单不可取消'),213);
            }else if(K::M('order/order')->cancel($order_id,$order,'shop')){
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),215);
            }
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=0&&$order['order_status']!=1){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->cancel($val,null,'shop');
                }
                $this->msgbox->add(L('SUCCESS'));
            }
        }
    }

    
    public function complete($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(-1,8);
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'biz/order/complete.html';
    }

    public function delivered($page=1) 
    {
    	$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(3,4);
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'biz/order/delivered.html';
    }
    
    public function tongji($page=1) 
    {
    	$this->tmpl = 'biz/order/tongji.html';
    }

    public function detail($order_id) 
    {
    	if($order_id != (int)$order_id) {
        	$this->msgbox->add(L('订单不存在'),210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
        	$this->msgbox->add(L('订单不存在'),211);
        }else if($order['shop_id'] != $this->shop_id){
        	$this->msgbox->add(L('非法操作'),212);
        }else {
            $order = $this->filter_fields('order_id,order_status,pay_status,product_price,amount,pei_time,note,contact,mobile,order_youhui,first_youhui,hongbao',$order);
        	if($order_product = K::M('order/product')->items(array('order_id'=>$order['order_id']))) {
        		foreach($order_product as $k=>$v) {
        			$goods[] = $this->filter_fields('product_name,product_number',$v);
        		}
                
        	}
        }
        $this->pagedata['order'] = $order;
        $this->pagedata['goods'] = $order_product;
    	$this->tmpl = 'biz/order/detail.html';
    }
    

    // 接单
    public function accept($order_id=null,$pei_type=nul) {
        if($order_id = (int)$order_id){
            $pei_type = (int)$pei_type;
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'),212);
            }else if($order['order_status'] !=0){
                $this->msgbox->add(L('该订单不可接单'),213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add(L('该订单未支付'),214);
            }else if(K::M('order/order')->update($order_id,array('order_status'=>1,'pei_type'=>$pei_type))){
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=>L('商家已接单'),'dateline'=>__TIME,'type'=>3));
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),215);
            }
        }else if($ids = $this->GP('order_id')){
            $pei_type = (int)$this->GP('pei_type');
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=0){
                    unset($ids[$k]);
                }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->update($val,array('order_status'=>1,'pei_type'=>$pei_type));
                     K::M('order/log')->create(array('order_id'=>$val,'from'=>'shop','log'=>L('商家已接单'),'dateline'=>__TIME,'type'=>3));
                }
                $this->msgbox->add(L('SUCCESS'));
            }
            
        }    
    }

    // 配送
    public function peisong($order_id=null) {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'),212);
            }else if($order['order_status'] !=1){
                $this->msgbox->add(L('该订单不可配送'),213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add('该订单不可配送',214);
            }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                $this->msgbox->add(L('第三方配送必须配送员接单'),215);
            }else if(K::M('order/order')->update($order_id,array('order_status'=>3))){
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=> L('开始配送'),'dateline'=>__TIME,'type'=>4));
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),216);
            } 
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=1){
                    unset($ids[$k]);
                }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                    unset($ids[$k]);
                }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->update($val,array('order_status'=>3));
                     K::M('order/log')->create(array('order_id'=>$val,'from'=>'shop','log'=> L('开始配送'),'dateline'=>__TIME,'type'=>4));
                }
                $this->msgbox->add(L('SUCCESS'));
            }
        }
    }
    
    
    public function finish($order_id=null) { //订单完成
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'),212);
            }else if($order['order_status'] !=3&&$order['order_status'] !=4){
                $this->msgbox->add(L('该订单不可完成'),213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add(L('该订单不可完成'),214);
            }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                $this->msgbox->add(L('该订单不可完成'),215);
            }else if(K::M('order/order')->confirm($order_id,$order,'shop')){
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),216);
            } 
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=3&&$order['order_status'] !=4){
                    unset($ids[$k]);
                }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                    unset($ids[$k]);
                }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->confirm($val,null,'shop');
                }
                $this->msgbox->add(L('SUCCESS'));
            }
        }
    }
    
}
