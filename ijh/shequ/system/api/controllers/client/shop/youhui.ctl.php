<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Shop_Youhui extends Ctl
{
    /* 优惠规则
     * @param $shop_id
     */
    public function rule($params)
    {

        if(!$shop_id = $params['shop_id']){
            $this->msgbox->add('参数不正确',205);
        }else if(!$detail=K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('非法操作',205);
        }else{
            if($maidan = K::M('maidan/maidan')->find(array('shop_id'=>$shop_id))){
                if($maidan['type']== 0){
                    $maidan['youhuis'] = unserialize($maidan['config']);
                    
                    $maidan['title'] = '';
                    foreach($maidan['youhuis'] as $k => $v){
                        $maidan['title'] .= '每满'.$v['m'].'减'.$v['d'].'元,';
                    }                  
                }else{
                    $maidan['title'] = ($maidan['discount']/10)."折优惠";
                }
                if($maidan['max_youhui']){
                    $maidan['title'] = $maidan['title'].",最大优惠{$maidan['max_youhui']}元";
                }                
                if(CLIENT_OS == 'ANDROID') {
                    unset($maidan['config']);
                    $maidan['order_count'] = $maidan['orders'];
                    unset($maidan['orders']);
                }
                if(!$maidan['youhuis']){
                    $maidan['youhuis'] = array();
                }
                unset($maidan['config']);
                $this->msgbox->set_data('data', $maidan);
            }else{
                $this->msgbox->set_data('data', array('shop_id'=>0));
            }
            
        }
    }
    
    public function order($params)
    {
        $this->create($params);
    }    

    /* 买单金额
     * @param shop_id
     * @param amount,总金额
     * @param unyouhui,不参与优惠金额
     */
    public function create($params)
    {
        $this->check_login();
        if(($params['amount']<0) || ($params['unyouhui']<0) || (!$shop_id=$params['shop_id'])){
            $this->msgbox->add('参数不正确',205);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在或已被删除', 212);
        }else if($shop['audit']!= 1){
            $this->msgbox->add('商户审核中不可下单',212);
        }else if(!$shop['have_maidan']){
            $this->msgbox->add('商户没有开通优惠买单功能',212);
        }else{
            $_amount = $params['amount'] - $params['unyouhui'];
            $youhui_amount = K::M('maidan/maidan')->get_maidan_youhui($shop_id, $_amount);
            $data = array(
                'city_id'            => $shop['city_id'],
                'shop_id'            => $shop_id,
                'uid'                => $this->uid,
                'contact'            => $this->MEMBER['nickname'],
                'mobile'             => $this->MEMBER['mobile'],
                'from'               => 'maidan',
                'total_price'        => $params['amount'],
                'amount'             => $params['amount'] - $youhui_amount,
                'order_youhui'       => $youhui_amount,
                'order_from'         => strtolower(CLIENT_OS)
            );
            $money = $params['amount']-$params['youhui'];
            if($order_id = K::M('order/order')->create($data)){
                K::M('maidan/order')->create(array('maidan_amount'=>$params['amount'], 'order_id'=>$order_id, 'unyouhui'=>$params['unyouhui']));
                K::M('maidan/maidan')->update_count($shop_id,'orders',1);
                $this->msgbox->set_data('data', array('order_id'=>$order_id, 'money'=>$money));
            }else{
                $this->msgbox->add('创建订单失败',20);
            }
        }
    }

}
