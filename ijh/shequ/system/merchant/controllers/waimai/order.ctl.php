<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('waimai');
class Ctl_Waimai_Order extends Ctl_Waimai
{

    public function index($page=1)
    {
        $this->waimai($page);
    }

    public function so($page)
    {
        $filter = $pager = $items = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        if($keyword = $this->GP('keyword')){
            $keyword = htmlspecialchars($keyword);
            if(K::M('verify/check')->mobile($keyword)){
                $filter['mobile'] =$keyword;
            }else{
                $filter[':OR'] = array( 'addr'=>"LIKE:%".$keyword."%", 'contact'=>"LIKE:%".$keyword."%");
                if(is_numeric($keyword)){
                    $filter[':OR']['mobile'] = "LIKE:%".$keyword."%";
                    $filter[':OR']['order_id'] = "LIKE:%".$keyword."%";
                }
            }
            $attr = array('keyword'=>$keyword);
            $pager['keyword'] = $keyword;
            $order_ids = array();
            if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink('merchant/waimai/order/so', array('{page}'), $attr));
                foreach($items as $k=>$v){
                    $items[$k]['js_price'] = $v['money'] + $v['amount'];
                    $order_ids[$v['order_id']] = $v['order_id'];
                }
            }
            if (!empty($order_ids)) {
                if($waimai_order_list = K::M('waimai/order')->items_by_ids($order_ids)){
                    foreach($waimai_order_list as $k=>$v){
                        $items[$k] = array_merge($v, $items[$k]);
                    }
                }
                if($product_list = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids))){
                    foreach($product_list as $k=>$v){
                        $items[$v['order_id']]['products'][$k] = $v;
                    }
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:waimai/order/so.html';
    }
    
    // 外卖订单
    public function waimai($page)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter['from'] = 'waimai';
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        $filter['pei_type'] = array(0,1,3,4); //0:商家送,1:三方送,2:三方代,4:堂食
        $filter['closed'] = 0;
        if($keyword = $this->GP('keyword')){
            $keyword = htmlspecialchars($keyword);
            if(K::M('verify/check')->mobile($keyword)){
                $filter['mobile'] =$keyword;
            }else{
                $filter[':OR'] = array( 'addr'=>"LIKE:%".$keyword."%", 'contact'=>"LIKE:%".$keyword."%");
                if(is_numeric($keyword)){
                    $filter[':OR']['mobile'] = "LIKE:%".$keyword."%";
                    $filter[':OR']['order_id'] = "LIKE:%".$keyword."%";
                }
            }
            $attr = array('keyword'=>$keyword);
            $pager['keyword'] = $keyword;
        }
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink('merchant/waimai/order/index', array('{page}'), $attr));
        }
        $order_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        if($waimai_order_list = K::M('waimai/order')->items_by_ids($order_ids)){
            foreach($waimai_order_list as $k=>$v){
                $items[$k] = array_merge($v, $items[$k]);
            }
        }
        if($product_list = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids))){
            foreach($product_list as $k=>$v){
                $items[$v['order_id']]['products'][$k] = $v;
            }
        }
       // print_r($items);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:waimai/order/index.html';
    }

    public function porder($order_id)
    {
       $order_id = (int)$order_id;
        if(!$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else{
           $order['products'] = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id'])); 
           $order['js_price'] = $order['amount'] + $order['money'];
           $this->pagedata['detail'] = $order; 
           $this->pagedata['payments'] = K::M('order/order')->get_payments();
           $this->tmpl = 'merchant:waimai/order/porder.html';
        }
    }

    public function check_print()
    {
        //判断打印机
        if(!$printer = K::M('shop/print')->find(array('shop_id'=>$this->shop_id,'status'=>1))) {
            $this->msgbox->add('打印机未添加或未启用',210);
        }else {
            $this->msgbox->add('success');
        }
    }

    public function yun_print()
    {
        K::M('order/order')->yunprint($this->GP('order_id'), $this->GP('nums'));
    }
    
    
    public function pei($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(1, 2);
        $filter['from'] = 'waimai';
        $filter['staff_id'] = 0;
        $filter['closed'] = 0;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink('merchant/waimai/order/pei', array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
            if($items[$k]['pei_type'] == 3 || $items[$k]['pei_type'] == 4) {
                unset($items[$k]);
            }
        }
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        //
        foreach($order_product as $k=>$val){
            
        }
        
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        //$this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:waimai/order/pei.html';
    }
    
    public function cancel($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if(K::M('order/order')->cancel($order_id,$order,'shop')){
                $this->msgbox->add('取消订单成功');
            }else{
                $this->msgbox->add('取消订单失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }/*else if($order['order_status'] !=0&&$order['order_status']!=1){
                    unset($ids[$k]);
                }*/
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->cancel($val,null,'shop');
                }
                $this->msgbox->add('批量取消成功');
            }
        }
    }

    
    public function complete($page=1, $day=null) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(4,5,6,7,8);
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        if(!empty($day)) {
            $filter['day'] = $day;
        }
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/waimai/order/complete', array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        $order_ids = array();
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    $items[$k]['products'][] = $v;
                }
            }
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        $logs = K::M('waimai/log')->items(array('order_id'=>$order_ids,'type'=>5));
        $logs2 = K::M('waimai/log')->items(array('order_id'=>$order_ids,'type'=>6));
        foreach($logs as $lk => $lv){
            foreach($logs2 as $l2k=>$l2v){
                if($lv['order_id'] == $l2v['order_id']){
                    $logs[$lk]['dateline2'] = $l2v['dateline'];
                }
            }
        }
        foreach($items as $k=>$val){
            $items[$k]['sd_time'] = 0;
            foreach ($logs as $kk=>$v){
                if($v['order_id'] == $val['order_id']){
                    if($v['dateline']){
                        $items[$k]['sd_time'] = $v['dateline']; //送达时间
                    }else{
                        $items[$k]['sd_time'] = $v['dateline2'];
                    }
                 }
            } 
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:waimai/order/complete.html';
    }
    
    public function cancellist($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = -1;
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/waimai/order/cancellist', array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:waimai/order/cancellist.html';
    }
    

    public function delivered($page=1) 
    {
    	$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 3;
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/waimai/order/delivered', array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:waimai/order/delivered.html';
    }


    // 接单
    public function accept($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=0){
                $this->msgbox->add('该订单不可接单',213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add('该订单未支付',214);
            }else if(K::M('order/order')->update($order_id, array('order_status'=>1,'jd_time'=>__TIME, 'lasttime'=>__TIME))){
                //自动打印订单判断 todo...
                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已接单','status'=>1);
                K::M('order/log')->create($log);
                //通知用户,APP推送 weixin模板消息
                K::M('order/order')->send_member('商家已经接单', sprintf("订单(%s)商家已经接单", $order_id), $order);
                $this->msgbox->add('接单成功');
                $this->msgbox->set_data('forward', $this->mklink('merchant/waimai/order/pei'));
            }else{
                $this->msgbox->add('接单失败',215);

            }
        }else if($ids = $this->GP('order_id')){
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && $order['pei_type'] != 2){
                            if($order['online_pay']==1 && $order['pay_status'] ==0){
                                if(K::M('order/order')->update($order_id, array('order_status'=>1,'jd_time'=>__TIME, 'lasttime'=>__TIME))){
                                    //自动打印订单判断 todo...
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已接单','status'=>1);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('商家已经接单', sprintf("订单(%s)商家已经接单", $order_id), $order);
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量接单'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }  
        }    
    }

    public function setpei($order_id, $type=0)
    {
        $pei_type = $type ? 1 : 0;
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作',212);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('已有骑手接单不可操作',212);
        }else if(!in_array($order['pei_type'], array(0, 1))){
            $this->msgbox->add('该订单不可配送',214);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add('该订单不可配送',213);
        }else if(K::M('order/order')->update($order_id, array('pei_type'=>$pei_type, 'lasttime'=>__TIME))){
            $this->msgbox->add('修改配送方式成功');
        }      
    }

    public function peisong($order_id=null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add('该订单不可配送',213);
        }else if(!in_array($order['pei_type'], array(0, 1))){
            $this->msgbox->add('该订单不可配送',214);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('该订单已由骑手配送',215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>3, 'pei_type'=>0, 'lasttime'=>__TIME))){
            $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'开始由商家配送','status'=>3);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            K::M('order/order')->send_member('订单开始配送', sprintf('订单(%s)商家已经开始配送', $order_id), $order);
            $this->msgbox->add('订单由商家开始配送');
            $this->msgbox->set_data('forward', $this->mklink('merchant/waimai/order/delivered'));
        }else if($ids = $this->GP('order_id')){ //批量配送
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && in_array($order['pei_type'], array(0, 1))){
                            if($order['staff_id'] == 0){
                                if(K::M('order/order')->update($order_id, array('order_status'=>3, 'pei_type'=>0,'lasttime'=>__TIME))){
                                    //自动打印订单判断 todo...
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'开始由商家配送','status'=>3);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('订单开始配送', sprintf('订单(%s)商家已经开始配送', $order_id), $order);
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);                
                $this->msgbox->set_data('forward', $this->mklink('merchant/waimai/order/delivered'));
                $this->msgbox->add('批量配送订单'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }             
        }
    }
    
    //订单配送完成
    public function finish($order_id=null)
    { 
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作',212);
        }else if(!in_array($order['order_status'], array(1, 2, 3))){            
            $this->msgbox->add('该订单不可配送',213);
        }else if(!in_array($order['pei_type'], array(0, 1))){
            $this->msgbox->add('该订单不可配送',214);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('该订单已由骑手配送',215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'pei_type'=>0, 'lasttime'=>__TIME))){
            $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'订单由商家配送达','status'=>3);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            K::M('order/order')->send_member('订单已送达', sprintf('订单(%s)商家已经送达', $order_id), $order);
            $this->msgbox->add('订单已配送');
        }else if($ids = $this->GP('order_id')){ //批量配送
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && in_array($order['pei_type'], array(0, 1))){
                            if($order['staff_id'] == 0){
                                if(K::M('order/order')->update($order_id, array('order_status'=>4, 'pei_type'=>0,'lasttime'=>__TIME))){
                                    //自动打印订单判断 todo...
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'订单由商家配送达','status'=>3);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('订单已送达', sprintf('订单(%s)商家已经送达', $order_id), $order);
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);                
                $this->msgbox->add('批量配送订单完成'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }             
        }
    }

    // 自提订单
    public function ziti($page)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(1,8);
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        $filter['pei_type'] = 3;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }        
        $order_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $items[$k]['spend_number'] = $v2['spend_number'];  
                            $items[$k]['spend_status'] = $v2['spend_status'];
                            $order_product[$kk]['freight'] = $v2['freight']; 
                        }
                    }
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['payments'] = K::M('waimai/order')->get_payments();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:waimai/order/ziti.html';
    }

    // 堂食订单
    public function eatin($page)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(1,8);
        $filter['from'] = 'waimai';
        $filter['closed'] = 0;
        $filter['pei_type'] = 4;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }        
        $order_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $items[$k]['spend_number'] = $v2['spend_number'];  
                            $items[$k]['spend_status'] = $v2['spend_status'];
                        }
                    }
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['payments'] = K::M('waimai/order')->get_payments();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:waimai/order/eatin.html';
    }

    // 自提订单核销弹框
    public function dialog($order_id)
    {
        if($order_id = (int)$order_id) {
            if($detail = K::M('order/order')->detail($order_id)) {
                $this->pagedata['detail'] = $detail;
            }
        }
        $this->tmpl = 'merchant:waimai/order/dialog.html';   
    }

    // 自提订单核销
    public function setspend()
    {
        if($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'order_id')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(!$order = K::M('waimai/order')->detail($data['order_id'])){
                $this->msgbox->add(L('无效的订单'), 218);
            }/*else if(!$order = K::M('waimai/order')->detail_by_number($waimai_order['spend_number'])){
                $this->msgbox->add(L('无效的自提码'), 218);
            }*/else if($order['shop_id'] != $this->shop_id){
                 $this->msgbox->add(L('不可操作其他店铺订单'), 219);
            }else if($order['order_status'] < 0){
                $this->msgbox->add(L('订单已取消'), 220);
            }else if($order['spend_status']){
                $this->msgbox->add(L('自提码已使用'), 221);
            }else if($order['order_status'] == 8){
                $this->msgbox->add(L('自提码已使用'), 221);
            }else if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                if(K::M('waimai/order')->update($order['order_id'], array('spend_status'=>1))){
                    $waimai = K::M('waimai/waimai')->detail($order['shop_id']);
                    $title = sprintf("您在[%s]的自提订单完成", $waimai['title'], $order['order_id']);
                    $content = sprintf("您在[%s]的订单(单号：%s)自提码(%s)已使用", $waimai['title'], $order['order_id'], $order['spend_number']);
                    K::M('member/member')->send($order['uid'], $title, $content,  'order', $order['order_id']);
                    $this->msgbox->add(L('核销码成功'));
                }else{
                   $this->msgbox->add(L('核销码失败'), 222); 
                }
            }else{
                K::M('system/logs')->log('waimai.order.setspend', array($this->system->db->SQLLOG(), $order));
                $this->msgbox->add(L('核销码失败'), 223);
            }
            /*if($data['order_id'] != (int)$data['order_id']){
                $this->msgbox->add('订单不存在', 212);
            }else if(!$waimai_order = K::M('waimai/order')->detail($order['order_id'])) {
                $this->msgbox->add('订单不存在', 213);
            }else if($order['closed'] != 0) {
                $this->msgbox->add('订单不存在或已被删除',214);
            }else if($order['shop_id'] != $this->shop_id) {
                $this->msgbox->add('非法操作',215);
            }else if(!($order['order_status']==1)) {
                $this->msgbox->add('订单状态不可核销',216);
            }else if($waimai_order['spend_status'] == 1 && $order['order_status'] == 8) {
                $this->msgbox->add('订单已核销，请勿重复操作',217);
            }else if($waimai_order['spend_number'] != $data['spend_number']) {
                $this->msgbox->add('核销密码不正确',218);
            }else if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                if(K::M('waimai/order')->update($order['order_id'], array('spend_status'=>1))){
                    $waimai = K::M('waimai/waimai')->detail($order['shop_id']);
                    $title = sprintf("您在[%s]的自体订单完成", $waimai['title'], $order['order_id']);
                    $content = sprintf("您在[%s]的订单(单号：%s)自提码(%s)已使用", $waimai['title'], $order['order_id'], $order['spend_number']);
                    K::M('member/member')->send($order['uid'], $title, $content,  'order', $order['order_id']);
                    $this->msgbox->add('核销成功');                 
                }
            }*/
        }
    }

    // 堂食订单核销
    public function setspendEatin()
    {
        if($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'order_id')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(!$order = K::M('waimai/order')->detail($data['order_id'])){
                $this->msgbox->add(L('无效的订单'), 218);
            }/*else if(!$order = K::M('waimai/order')->detail_by_number($waimai_order['spend_number'])){
                $this->msgbox->add(L('无效的消费码'), 218);
            }*/else if($order['shop_id'] != $this->shop_id){
                 $this->msgbox->add(L('不可操作其他店铺订单'), 219);
            }else if($order['order_status'] < 0){
                $this->msgbox->add(L('订单已取消'), 220);
            }else if($order['spend_status']){
                $this->msgbox->add(L('消费码已使用'), 221);
            }else if($order['order_status'] == 8){
                $this->msgbox->add(L('消费码已使用'), 221);
            }else if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                if(K::M('waimai/order')->update($order['order_id'], array('spend_status'=>1))){
                    $waimai = K::M('waimai/waimai')->detail($order['shop_id']);
                    $title = sprintf("您在[%s]的堂食订单完成", $waimai['title'], $order['order_id']);
                    $content = sprintf("您在[%s]的订单(单号：%s)消费码(%s)已使用", $waimai['title'], $order['order_id'], $order['spend_number']);
                    K::M('member/member')->send($order['uid'], $title, $content,  'order', $order['order_id']);
                    $this->msgbox->add(L('消费码核销成功'));
                }else{
                   $this->msgbox->add(L('消费码核销失败'), 222); 
                }
            }else{
                K::M('system/logs')->log('waimai.order.setspend', array($this->system->db->SQLLOG(), $order));
                $this->msgbox->add(L('消费码核销失败'), 223);
            }
        }
    }

    public function detail($order_id)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('waimai/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else{
            if($staff_id = (int)$order['staff_id']){
                $this->pagedata['staff'] = K::M('staff/staff')->detail($staff_id);
            }
            $this->pagedata['product_list'] = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id));
            $this->pagedata['log_list'] = K::M('order/log')->items(array('order_id'=>$order_id));
            $this->pagedata['member'] = K::M('member/member')->detail($order['uid']);            
            $this->pagedata['detail'] = $order;
            $this->tmpl = 'merchant:waimai/order/detail.html';
        }
    }

    public function ajax_detail()
    {
        $order_id = (int)$this->GP('order_id');
        if(!$order = K::M('waimai/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else{
            if(!$staff = K::M('staff/staff')->detail($order['staff_id'])) {
                $order['staff']['name'] = '--';$order['staff']['mobile'] = '--';
            }else {
                $order['staff'] = $staff;
            }
            if($order['note'] == NULL) {
                $order['note'] = '--';
            }
            $order['dateline_format'] = date('Y-m-d H:i', $order['dateline']);
            $order['peitime_format'] = date('Y-m-d H:i', $order['pei_time']);
            $order['product_list'] = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id));
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',array('order'=>$order));
        }
    }
}