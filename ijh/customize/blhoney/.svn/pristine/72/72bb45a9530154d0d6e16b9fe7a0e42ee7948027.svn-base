<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Info extends Ctl_Biz
{
    
    public function index()
    {
        //订单，资金信息
        $shop = $this->filter_fields('shop_id,city_id,city_name,cate_id,cate_name,mobile,phone,title,money,total_money,logo,lat,lng,addr,views,orders,comments,praise_num,score,score_price,score_fuwu,first_amount,min_amount,freight,pei_amount,pei_time,pei_type,pei_distance,yy_status,yy_stime,yy_ltime,is_new,yy_xiuxi,order_youhui_list,youhui_title,youhui,online_pay,info,pmid,audit,pid,tixian_percent,verify_name', $this->shop);
        $shop['order_youhui_list'] = $this->shop['order_youhui'];
        $shop['score_price'] = round($shop['score_price']/$shop['comments']);
        $shop['score_fuwu'] = round($shop['score_fuwu']/$shop['comments']);
        if($shop['score_price']>5) {
            $shop['score_price'] = 5;
        }
        if($shop['score_fuwu']>5) {
            $shop['score_fuwu'] = 5;
        }
        if(!$account = K::M('shop/account')->detail($this->shop_id)){
            $account = array('account_type'=>'', 'account_number'=>'', 'account_name'=>'');
        }
        $shop['account'] = $account;
        // 待接单数
        $shop['order_jie_count'] = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'order_status'=>0,'pay_status'=>1,'spend_status'=>0,'closed'=>0));
        // 待核销数
        $shop['order_pei_count'] = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'order_status'=>1,'pay_status'=>1,'spend_status'=>0,'closed'=>0));
        // 已完成数
        $shop['order_end_count'] = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'order_status'=>8,'pay_status'=>1,'spend_status'=>1,'closed'=>0));

        $shop['msg_new_count'] = (int)K::M('shop/msg')->count(array('shop_id'=>$this->shop_id, 'is_read'=>0));
        $this->msgbox->set_data('data', $shop);
        $this->msgbox->add('success');
    }
}