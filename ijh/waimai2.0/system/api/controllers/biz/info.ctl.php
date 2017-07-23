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
        $shop = $this->filter_fields('shop_id,city_id,city_name,cate_id,cate_name,mobile,phone,title,money,total_money,logo,lat,lng,addr,views,orders,comments,praise_num,score,score_kouwei,score_fuwu,first_amount,min_amount,freight,pei_amount,pei_time,pei_type,pei_distance,yy_status,yy_stime,yy_ltime,is_new,yy_xiuxi,order_youhui_list,youhui_title,youhui,online_pay,is_daofu,info,pmid,audit,pid,tixian_percent,verify_name', $this->shop);
        $shop['order_youhui_list'] = $this->shop['order_youhui'];
        if(!$account = K::M('shop/account')->detail($this->shop_id)){
            $account = array('account_type'=>'', 'account_number'=>'', 'account_name'=>'');
        }
        $shop['account'] = $account;
        $shop['order_jie_count'] = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'pei_type'=>array(0,1,3), 'order_status'=>0, ':OR'=>array('pay_status'=>1, 'online_pay'=>0),'closed'=>0));
        $shop['order_pei_count'] = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'pei_type'=>array(0,1), 'order_status'=>array(1,2,3),'closed'=>0));
        $shop['order_end_count'] = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'pei_type'=>array(0,1), 'order_status'=>array(4,5,6,7,8),'closed'=>0));

        $shop['msg_new_count'] = (int)K::M('shop/msg')->count(array('shop_id'=>$this->shop_id, 'is_read'=>0));

        $shop_verify = K::M('shop/verify')->detail($this->shop_id);
        if(!$shop_verify){
            $verify = array('verify'=>0);
        }else{
            $verify = $shop_verify;
        }
        if(!$verify['cy_number']){
            $verify['verify_cy'] = -1;
        }
        if(!$verify['yz_number']){
            $verify['verify_yyzz'] = -1;
        }
        if(!$verify['id_number']){
            $verify['verify_dianzhu'] = -1;
        }
        $shop['verify'] = $verify['verify'];

        $this->msgbox->set_data('data', $shop);
        $this->msgbox->add('success');
    }
}