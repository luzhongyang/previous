<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Coupon extends Ctl
{
    
    public function detail($coupon_id=1)
    {
        
        if(!$coupon_id = (int)$coupon_id){
            $this->error(404);
        }else if(!$coupon = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('优惠券不存在！', 211);
        } else if($coupon['shop_id'] != $this->shop_id){
            $this->msgbox->add('参数错误！',212);
        }else{

           if($logs = K::M('cashier/coupon/log')->items(array('coupon_id'=>$coupon_id), array('log_id'=>'DESC'),1, 5, $count)){
                $wx_openids = array();
                foreach($logs as $v){
                    $wx_openids[$v['wx_openid']] = $v['wx_openid'];
                }
                $wx_openids = "'".implode("','", $wx_openids)."'";
                $filter[':SQL'] = "wx_openid IN ({$wx_openids})";
                if($wx_user_list = K::M('weixin/user')->items($filter, null, 1, 5)){
                    foreach($logs as $k=>$v){
                        foreach($wx_user_list as $vv){
                            if($v['wx_openid'] == $vv['wx_openid']){
                                $v['weixin_user'] = $vv;
                                $logs[$k] = $v;
                            }
                        }
                    }
                }
            }
          
           
            $this->pagedata['intro'] = $coupon;
            $links = $this->mklink('card/coupon:linqu',array($coupon_id),array(),$this->request['url'],true);
            $this->pagedata['url'] = $links;
            $this->pagedata['logo']=$this->shop['logo'];
          
            $this->pagedata['name']=$this->shop['title'];
            $this->pagedata['logs'] = $logs;
            $this->tmpl = 'shop/card/coupon/detail.html';
        }
        $this->msgbox->set_data('forward',$this->mklink('card',array(),null,$this->request['url']));
    }
    //自己可用代金券
    public function ablelist(){
        if(!$this->wx_openid){
            $this->msgbox->add('未登录!',222);
        }else {

            $item = K::M('cashier/coupon/log')->items_by_openid($this->wx_openid,false);
            $this->pagedata['datalist'] = $item;
            $this->tmpl = "shop/card/coupon/ablelist.html";
        }
        return false;
        


    }
    //自己过期代金券
    public function  unablelist(){
        if(!$this->wx_openid){
            $this->msgbox('未登录！',221);
        } else {
            $item = K::M('cashier/coupon/log')->items_by_openid($this->wx_openid,true);
            $this->pagedata['datalist'] = $item;
           $this->tmpl = "shop/card/coupon/unablelist.html";
        }
        return false;
       

    }


    public function linqu($coupon_id){
        
        if(!(int)$coupon_id||!$this->wx_openid){
            $this->msgbox->add('参数不完整！',214);
        } else if(!$coupon = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('该优惠券不存在！',215);
        }else if($coupon['shop_id'] != $this->shop_id){
            $this->msgbox->add('该优惠券不存在！',215);
        } else if($coupon['ltime']<time()){
            $this->msgbox->add('该优惠卷已经过期！',218);
        } else if($coupon['stock']<= '0'){
            $this->msgbox->add('该优惠券已经领取完了！',216);
        }  else {
            $logdata = array(
                'shop_id'=>SHOP_ID,
                'coupon_id'=>$coupon_id,
                'wx_openid'=>$this->wx_openid,
                'is_used'=>0,
                'title'=>$coupon['title'],
                'amount'=>$coupon['amount'],
                'min_price'=>$coupon['min_price'],
                'stime'=>$coupon['stime'],
                'ltime'=>$coupon['ltime'],
                'intro'=>$coupon['intro'],
                'number'=>K::M('cashier/coupon/log')->create_number(),
            );
            $filter['coupon_id'] = $coupon_id;
            if($card = K::M('card/card')->detail_by_wx_openid($this->wx_openid)){
                $filter['card_id'] = $card['card_id'];
                $logdata['card_id'] = $card['card_id'];
            }else{
                $filter['wx_openid'] = $this->wx_openid;
            }
            $up_coupon_data = array('send_count'=>'`send_count`+1', 'stock'=>'`stock`-1');
            if($count = K::M('cashier/coupon/log')->count($filter)){

                if($coupon['one_limit'] && ($coupon['one_limit'] <= $count)){
                    $this->msgbox->add('该优惠券每人限领'.$coupon['one_limit']."张！",217);
                    $this->msgbox->show($this->mklink('card/coupon:linqu',array('$coupon_id')));
                }
            }else {
                $up_coupon_data['receive_count'] = '`receive_count`+1';
            }
            if(K::M('cashier/coupon/log')->create($logdata)){
                K::M('cashier/coupon')->update($coupon_id, $up_coupon_data, true);
                $link = $this->mklink('card/coupon:successcoupon',array($coupon_id),array(),$this->request['url'],true);
                header("Location:$link");
                exit;
            } else {
                $this->msgbox->add('领取失败！请稍后再试！',213);
            }
            $this->msgbox->set_data('forward',$this->mklink('card/coupon:detail',array($coupon_id),null,$this->request['url']));
        }
    }
    public function successcoupon($coupon_id){

        if(!$coupon_id||!$this->wx_openid){
            $this->error(404);
        }else if(!$data = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('该卡券不存在！',219);
        }elseif($data['closed'] == '1'){
            $this->msgbox->add('该优惠券已失效！',225);
        }/*else if(!$user = K::M('card/card')->detail_by_wx_openid($this->wx_openid)){
            $this->msgbox->add('您还没有绑定会员卡无法领取该卡券！',220);
        }*/else{
            $user = K::M('card/card')->detail_by_wx_openid($this->wx_openid);
            $this->pagedata['user'] = $user;
            $count=K::M('cashier/coupon/log')->count_by_openid($this->wx_openid);

            $data['money'] = $count['count'];
            $this->pagedata['items'] = $data;
            $this->tmpl = 'shop/card/coupon/successcoupon.html';
        }
        $this->msgbox->set_data('forward',$this->mklink('card/coupon:linqu',array('$coupon_id'),null,$this->request['url']));

        
    }
    
    public function cdetail($log_id){
        if(!$log_id||!$this->wx_openid){
            $this->msgbox->add('参数错误！',221);
        } else if(!$data_log = K::M('cashier/coupon/log')->detail($log_id)){
            $this->msgbox->add('您没有领取该卡券',222);
        } else {
            $data_log['now_time'] = $this->system->sdaytime;
            $data_log['qrcode']= $this->mklink('qrcode:index',array(),array('data'=>$data_log['number']),'www',true);
            $this->pagedata['logs'] = $data_log;
            $this->tmpl = 'shop/card/coupon/cdetail.html';
            
        }
        $this->msgbox->set_data('forward',$this->mklink('card/coupon:ablelist',$this->request['url']));

        
    }
  



}
