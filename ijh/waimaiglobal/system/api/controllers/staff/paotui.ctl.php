<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Paotui extends Ctl
{

    public function index($params)
    {

        $this->check_login();
        $filter = array();
        if(in_array($params['status'], array(0,1,2,3))){
            switch ($params['status']){
            case 3:
                $filter['staff_id'] = $this->staff_id;
                $filter['order_status'] = array(-1,8);
              break;
            case 2:
                $filter['staff_id'] = $this->staff_id;
                $filter['order_status'] = array(1,2,3,4,5);
              break;
            case 1:
                $filter['order_status'] = 0;
                $filter['pay_status'] = 1;
                $filter['staff_id'] = 0;
                break;
            }
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('paotui/paotui')->items($filter, array('paotui_id'=>'DESC'), $page, $limit, $count)){
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items),'page'=>$page));
  
    }
     
    public function detail($params){
        $this->check_login();
        if(!$paotui_id =$params['paotui_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui =K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else{
            /*if($logs = K::M('paotui/log')->select(array('paotui_id'=>$paotui['paotui_id']))){
                $paotui['logs'] = array_values($logs);
            }else{
                $paotui['logs'] = array();
            }*/
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',$paotui);
        }
    }
    
    // 配送员接跑腿订单
    public function set($params){
        $this->check_login();
        $data = array(); 
        if(!$paotui_id =$params['paotui_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui =K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if(!$status = $params['status']){
            $this->msgbox->add(L('没有设置状态'),213);
        }else if(!in_array($status,array(1,2,3,4))){
            $this->msgbox->add(L('状态错误'),214);
        }else if($status >1 && $paotui['staff_id'] != $this->staff_id){
            $this->msgbox->add(L('非法操作'),215);
        }else{

            if($status == 1){
                $data['staff_id'] = $this->staff_id;
            }
            $data['order_status'] = $status;
            if(K::M('paotui/paotui')->update($paotui_id,$data)){
                $this->msgbox->add('success');
            }  
        }
    }
    
    public function setprice($params){
        $this->check_login();
        if(!$paotui_id =$params['paotui_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui =K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($paotui['staff_id'] != $this->staff_id){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!$jiesuan_amount = $params['jiesuan_amount']){
            $this->msgbox->add(L('没有设置结算价格'),214);
        }else if(!$jiesuan_amount = (int)$jiesuan_amount){
            $this->msgbox->add(L('非法的结算价格'),215);
        }else {

            if($myuser = K::M('member/member')->detail($paotui['uid'])) {
                $wx_openid = $myuser['wx_openid'];
                if($wx_openid) {
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                }   
            }

            if($paotui['danbao_amount'] < $jiesuan_amount){
                // 补价
                if(K::M('paotui/paotui')->update($paotui['paotui_id'],array('jiesuan_amount'=>$jiesuan_amount, 'order_status'=>5, 'pay_status'=>0))) {
                    K::M('paotui/log')->create(array('paotui_id'=>$paotui['paotui_id'], 'log'=>L('跑腿订单需要补价'), 'from'=>'staff', 'type'=>5));
                    $spread = $jiesuan_amount - $paotui['danbao_amount'];
                    if($wx_openid) {
                        $a = array('title'=>L('跑腿订单需要补价'), 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => L('需要付差额')), 'remark' =>sprintf(L('您的订单于 %s 需要支付差额￥%s'), date('Y-m-d H:i:s',__TIME), $spread) );
                        $url = K::M('helper/link')->mklink('paotui:detail', array('args'=>$paotui['paotui_id']), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);      
                    }
                    // 创建子支付记录用于补价支付
                    $new_log = array('uid'=>$paotui['uid'], 'from'=>'paotui', 'order_id'=>$paotui['paotui_id'], 'amount'=>$spread, 'payed'=>2);
                    K::M('payment/log')->create($new_log);
                    // 配送员获得第一次支付的金额
                    K::M('staff/staff')->update_money($paotui['staff_id'], $paotui['danbao_amount'], sprintf(L('订单配送完成结算(ID:%s)'), $paotui['paotui_id']));
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data',array('order_status'=>5));
                }
            }else if($paotui['danbao_amount'] > $jiesuan_amount) {
                // 退差价
                if(K::M('paotui/paotui')->update($paotui['paotui_id'],array('jiesuan_amount'=>$jiesuan_amount,'order_status'=>8))) {
                    K::M('paotui/log')->create(array('paotui_id'=>$paotui['paotui_id'], 'log'=>L('订单已完成'), 'from'=>'staff', 'type'=>6));
                    $spread = $paotui['danbao_amount'] - $jiesuan_amount;
                    if($wx_openid) {
                        $a = array('title'=>L('跑腿订单退回多余担保金'), 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => L('跑腿订单已完成')), 'remark' =>sprintf(L('您的订单于 %s 已退回多余担保金￥%s'), date('Y-m-d H:i:s',__TIME), $spread));
                        $url = K::M('helper/link')->mklink('paotui:detail', array('args'=>$paotui['paotui_id']), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                    K::M('member/member')->update_count($paotui['uid'], 'money', $spread);
                    K::M('member/log')->log($paotui['uid'], 'money', $spread, L('跑腿订单退回多余担保金'));
                    // 配送员获得支付的金额
                    K::M('staff/staff')->update_money($paotui['staff_id'], $jiesuan_amount, sprintf(L('订单配送完成结算(ID:%s)'), $paotui['paotui_id']));
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data',array('order_status'=>8));
                }
            }else {
                if($paotui['danbao_amount'] == $jiesuan_amount) {
                    if(K::M('paotui/paotui')->update($paotui['paotui_id'],array('jiesuan_amount'=>$jiesuan_amount,'order_status'=>8))) {
                        K::M('paotui/log')->create(array('paotui_id'=>$paotui['paotui_id'], 'log'=>L('订单已完成'), 'from'=>'staff', 'type'=>6));
                        if($wx_openid) {
                            $a = array('title'=>L('跑腿订单已完成'), 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => L('跑腿订单已完成')), 'remark' => sprintf(L('您的订单于 %s 已完成'), date('Y-m-d H:i:s',__TIME)) );
                            $url = K::M('helper/link')->mklink('paotui:detail', array('args'=>$paotui['paotui_id']), array(), 'www');
                            K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                        }
                        // 配送员获得支付的金额
                        K::M('staff/staff')->update_money($paotui['staff_id'], $jiesuan_amount, sprintf(L('订单配送完成结算(ID:%s)'), $paotui['paotui_id']));
                        $this->msgbox->add('success');  
                        $this->msgbox->set_data('data',array('order_status'=>8));
                    }
                } 
            }
        }
    }
}
