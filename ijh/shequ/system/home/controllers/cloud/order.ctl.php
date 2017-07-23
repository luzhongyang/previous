<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cloud_Order extends Ctl_Cloud
{
    
    public function code($back_attr_id,$attr_id=null,$uid=null)
    {
        if(!$attr_id = (int) $attr_id){
           $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }elseif(!$uid = (int)$uid){
           $this->msgbox->add('用户不存在',216)->response();
       }elseif(!$user = K::M('member/member')->detail($uid)){
           $this->msgbox->add('用户不存在',217)->response();
       }elseif($user['closed'] !=0){
           $this->msgbox->add('用户不存在',218)->response();
       }else{
           $this->pagedata['back_attr_id'] = $back_attr_id;
           $this->pagedata['buy_num'] = K::M('cloud/order')->member_num_count(array('uid'=>$uid,'attr_id'=>$detail['attr_id'],'order_status'=>1),false);
           //print_r(K::M('cloud/order')->member_num_count(array('uid'=>$uid,'attr_id'=>$detail['attr_id'],'order_status'=>1),false));die;
           $this->pagedata['goods'] = $goods;
           $this->pagedata['user'] = $user;
           $this->pagedata['detail'] = $detail;
           $this->tmpl = 'cloud/order/code.html';
       }
    }
    
    
    public function loaddata($page=1){
        
        $filter = array('closed'=>0);
        if(!$attr_id = $this->GP('attr_id')){
         $this->msgbox->add('云购商品不存在',211)->response();
       }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
           $this->msgbox->add('云购商品不存在',212)->response();
       }elseif($detail['closed'] == 1){
           $this->msgbox->add('云购商品不存在',213)->response();
       }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
           $this->msgbox->add('云购商品不存在',214)->response();
       }elseif($goods['closed'] == 1){
           $this->msgbox->add('云购商品不存在',215)->response();
       }elseif(!$uid = $this->GP('uid')){
           $this->msgbox->add('用户不存在',216)->response();
       }elseif(!$user = K::M('member/member')->detail($uid)){
           $this->msgbox->add('用户不存在',217)->response();
       }elseif($user['closed'] !=0){
           $this->msgbox->add('用户不存在',218)->response();
       }else{
           $filter['attr_id'] = $attr_id;
           $filter['uid'] = $uid;
           //$filter['order_status'] = 1;
       }
        $page = max((int)$page, 1);
        $limit = 60;
        if(!$items = K::M('cloud/number')->items($filter,null, $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('cloud/number')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['detail'] = $detail;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/order/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    public function order()
    {
        $this->check_login();
        if(IS_AJAX){
            if(!$attr_id = $this->GP('attr_id')){
                $this->msgbox->add('云购商品不存在',211)->response();
            }elseif(!$detail = K::M('cloud/attr')->detail($attr_id)){
                $this->msgbox->add('云购商品不存在',212)->response();
            }elseif($detail['closed'] == 1){
                $this->msgbox->add('云购商品不存在',213)->response();
            }elseif($detail['status'] == 1){
                $this->msgbox->add('该期云购已结束',214)->response();
            }elseif(!$goods = K::M('cloud/goods')->detail($detail['goods_id'])){
                $this->msgbox->add('云购商品不存在',215)->response();
            }elseif($goods['closed'] == 1){
                $this->msgbox->add('云购商品不存在',216)->response();
            }elseif(!$num = $this->GP('num')){
                $this->msgbox->add('云购人次不能为空',217)->response();
            }elseif($num>($detail['price']-$detail['join'])){
                $this->msgbox->add('剩余商品人次不足',218)->response();
            }else{
                $data = array(
                    'goods_id' => $detail['goods_id'],
                    'attr_id' => $attr_id,
                    'uid' => $this->uid,
                    'num' => $num,
                );
                if($order_id = K::M('cloud/order')->create_user_order($this->uid,$attr_id,$detail,$num)){
                    $order = K::M('cloud/order')->detail($order_id);
                    //print_r($this->MEMBER);die;
                    $use_coin = 0;
                    if($this->MEMBER['coin']>=$num){
                        $use_coin = $num;
                        $res = K::M('cloud/order')->update_coin($order_id,$order,$num,$this->uid);
                    }else{
                        $use_coin = $this->MEMBER['coin'];
                        $res = K::M('cloud/order')->update_coin($order_id,$order,$this->MEMBER['coin'],$this->uid);
                    }
                    //print_r($use_coin);die;
                    $new_order = K::M('cloud/order')->detail($order_id);
                    $this->msgbox->add('下单成功');
                    $this->msgbox->set_data('order_id',$order_id);
                    $this->msgbox->set_data('status',$new_order['order_status']);
                    $this->msgbox->set_data('use_coin',$use_coin);
                }
            }
        }
    }


    public function pay($order_id){
        $this->check_login();
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('云购订单不存在',211);
        }elseif(!$order = K::M('cloud/order')->detail($order_id)){
            $this->msgbox->add('云购订单不存在',211);
        }elseif($order['order_status'] == 1){
            $this->msgbox->add('该订单已支付过了',211);
        }else{
            if(defined('IN_WEIXIN')){
                $this->pagedata['weixin'] = 1;
            }
            $this->pagedata['order'] = $order;
            $this->tmpl = 'cloud/order/pay.html';
        }
        
    }

    
    public function pay2($order_id){  //使用夺宝币，更新订单 
        $this->check_login();
        if(!$order_id = (int) $order_id){
            $this->msgbox->add('云购订单不存在',211);
        }elseif(!$order = K::M('cloud/order')->detail($order_id)){
            $this->msgbox->add('云购订单不存在',212);
        }elseif($order['order_status'] == 1){
            $this->msgbox->add('该订单已支付过了',213);
        }elseif($order['order_status'] == -1){
            $this->msgbox->add('该订单已经取消',214);
        }elseif(!$attr = K::M('cloud/attr')->detail($order['attr_id'])){
            $this->msgbox->add('该云购商品不存',215);
        }elseif($order['num']>($attr['price']-$attr['join'])){
            $this->msgbox->add('剩余次数不足，请重新下单',216);
        }else{
            $need_pay = $order['num'] - $order['use_coin'];
            if($this->MEMBER['coin']>=$need_pay){
                $res = K::M('cloud/order')->update_coin($order_id,$order,$need_pay,$this->uid);
            }else{
                $res = K::M('cloud/order')->update_coin($order_id,$order,$this->MEMBER['coin'],$this->uid);
            }
            $new_order = K::M('cloud/order')->detail($order_id);
            $this->msgbox->add('操作成功');
            $this->msgbox->set_data('status',$new_order['order_status']);
            $this->msgbox->set_data('use_coin',$new_order['use_coin']);
        }
    }


    


}
