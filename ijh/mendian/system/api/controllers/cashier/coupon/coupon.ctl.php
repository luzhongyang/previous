<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Coupon_Coupon extends Ctl_Cashier
{
    protected $_allow_fields = 'shop_id,coupon_id,wx_openid,card_id,dateline,title,amount,min_price,stime,ltime,intro';

    public function items($params)
    {
        if(!$data = $this->check_fields($params, 'card_id,page,coupon_status')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$card_id = (int) $params['card_id']){
            $this->msgbox->add('参数错误', 212);
        }else if(!$card = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('会员卡不存在或已经删除', 213);
        }else if($card['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法的数据操作', 214);
        }else{
            $items = array();
            $filter['shop_id'] = $this->shop_id;
            $filter['card_id'] = $card['card_id'];
            $filter['is_used'] = 0;
            $filter['ltime'] = '>:'.__TIME;
            if($params['coupon_status'] == 1){// 失效请求
                $filter['ltime'] = '<=:'.__TIME;
            }
            $page = max((int)$params['page'], 1);
            $limit = 10;
            if($items = K::M('cashier/coupon/log')->items($filter, null, $page, $limit, $count)){
                $title_count = K::M('cashier/coupon/log')->count($filter);
                foreach($items as $k=>$v){
                    $v = $this->filter_fields($this->_allow_fields, $v);
                    $items[$k] = $v;
                }
            }else{
                $items = array();
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'title_count'=>$title_count));
        }
    }

    public function search($params)
    {
        if(!$number = (int)$params['number']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$coupon_log = K::M('cashier/coupon/log')->find(array('shop_id'=>$this->shop_id,'number'=>$number,'is_used'=>0))){
            $this->msgbox->add('该卡券不存在或已经使用', 212);
        }else if(($card_id = (int)$params['card_id']) && $card_id != $coupon_log['card_id']){
            $this->msgbox->add('请勿使用别人的卡券', 213);
        }else{
            $this->msgbox->set_data('data', array('coupon_log'=>$coupon_log));
        }
    }
}