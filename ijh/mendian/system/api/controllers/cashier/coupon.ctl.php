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

class Ctl_Cashier_Coupon extends Ctl_Cashier
{
    protected $_allow_fields = 'coupon_id,shop_id,title,amount,min_price,stime,ltime,stock,send_count,used_count,receive_count,one_limit,intro,dateline,shop_logo';

    public function items($params)
    {
        $items = $share_detail = array();
        $filter['shop_id'] = $this->shop_id;
        $filter['ltime'] = '>:'.__TIME;
        if($params['coupon_status'] == 1){// 失效请求
            $filter['ltime'] = '<=:'.__TIME;
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('cashier/coupon')->items($filter, null, $page, $limit, $count)){
            foreach($items as $k=>$v){
                $v = $this->filter_fields($this->_allow_fields, $v);
                $items[$k] = $v;
                $share_detail['share_title'] = $v['title'];
                $share_detail['share_photo'] = $v['shop_logo'];
                $share_detail['share_url'] = $this->mklink('card/coupon:detail', array($v['coupon_id']), null, $this->shop['url']);
                $share_detail['share_content'] = '快来领取优惠券吧！';
                $items[$k]['share_detail'] = $share_detail;
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    public function create($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'title,amount,min_price,stime,ltime,stock,one_limit,intro')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($coupon_id = K::M('cashier/coupon')->create($data)){
                $this->msgbox->set_data('data', array('coupon_id'=>$coupon_id));
            }
        }
    }

    public function detail($params)
    {
        if(!$coupon_id = (int)$params['coupon_id']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$coupon = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('卡券不存在或已经删除', 212);
        }else if($coupon['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限查看该卡券', 213);
        }else{
            if (!empty($coupon['ltime'])) {
                $coupon['coupon_status'] = $coupon['ltime'] > __TIME ? 0 : 1;// 0:有效 1:失效 
            }
            $share_detail = array();
            $share_detail['share_title'] = $coupon['title'];
            $share_detail['share_photo'] = $coupon['shop_logo'];
            $share_detail['share_url'] = $this->mklink('card/coupon:detail', array($coupon['coupon_id']), null, $this->shop['url']);
            $share_detail['share_content'] = '快来领取优惠券吧！';
            $coupon['share_detail'] = $share_detail;
            $this->msgbox->set_data('data', array('coupon_detail'=>$coupon));
        }
    }

    public function edit($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'coupon_id,title,amount,min_price,stime,ltime,stock,one_limit,intro')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$coupon_id = (int) $params['coupon_id']){
            $this->msgbox->add('参数错误', 212);
        }else if(!$coupon = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('卡券不存在或已经删除', 212);
        }else if($coupon['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法的数据操作', 213);
        }else{
            $data['shop_id'] = $this->shop_id;
            if(K::M('cashier/coupon')->update($coupon['coupon_id'],$data)){
                $this->msgbox->set_data('data', array('coupon_id'=>$coupon_id));
            }
        }
    }

    public function sendcoupon($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'coupon_id,card_id,kw,month,grade_id,filter_id')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$coupon_id = (int) $params['coupon_id']){
            $this->msgbox->add('参数错误', 212);
        }else if(!$coupon = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('卡券不存在', 213);
        }else if($coupon['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法的数据操作', 214);
        }else if((!empty($data['kw']) || !empty($data['month']) || !empty($data['grade_id'])) && !$filter_items = K::M('card/card')->items_by_filter($data, $this->shop_id)){// 只要有筛选条件，按筛选条件发放
            $this->msgbox->add('没有选择会员或卡券不足', 215);
        }else if(!empty($data['card_id']) && !$card = K::M('card/card')->items_by_ids($data['card_id'])){// 定向单独发 或者 定向多选发
            $this->msgbox->add('会员不存在或卡券不足', 216);
        }else if(empty($data['card_id']) && !$all_items = K::M('card/card')->items(array('shop_id'=>$this->shop_id, 'closed'=>0))){// 会员卡为空则全选，获取当前商店所有会员卡
            $this->msgbox->add('该店铺没有会员或卡券不足', 217);
        }else{
            $data['shop_id'] = $this->shop_id;
            $data['coupon_id'] = $coupon['coupon_id'];
            $data['is_used'] = 0;
            // ------卡券冗余信息-------
            $data['title'] = $coupon['title'];
            $data['amount'] = $coupon['amount'];
            $data['min_price'] = $coupon['min_price'];
            $data['stime'] = $coupon['stime'];
            $data['ltime'] = $coupon['ltime'];
            $data['intro'] = $coupon['intro'];

            if (!empty($filter_items)) {// 按筛选条件发放
                //if ($coupon['stock'] >= count($filter_items)) {
                    $send_data = K::M('cashier/coupon/log')->send_coupon($data, $filter_items);
                /*}else{
                    $this->msgbox->add('卡券不足', 221)->response();
                }*/
            }elseif (!empty($all_items)) {// 全选发放
                
                if (!empty($data['filter_id'])) {// 需要去除反选的会员卡
                    if ($valid_ids = K::M('verify/check')->ids(trim($data['filter_id'], ','))) {// 验证反选id合法性
                        $all_items = array();
                        $filter[':SQL'] = "(`card_id` NOT IN(".$valid_ids."))"; // 去除的ID
                        $filter['shop_id'] = $this->shop_id;
                        $filter['closed'] = 0;
                        if (!$all_items = K::M('card/card')->items($filter)) {
                            $this->msgbox->add('未选择会员卡', 218)->response();
                        }
                    }else{
                        $this->msgbox->add('参数不合法', 219)->response();
                    }
                }
                //if ($coupon['stock'] >= count($all_items)) {
                    $send_data = K::M('cashier/coupon/log')->send_coupon($data, $all_items);
                /*}else{
                    $this->msgbox->add('卡券不足', 221)->response();
                }*/
            }else if(!empty($card)){// 定向多选发 或者 定向单独发
                //if ($coupon['stock'] >= count($card)) {
                    if (count($card) > 1) {// 定向多选发
                        $send_data = K::M('cashier/coupon/log')->send_coupon($data, $card);
                    }else{// 定向单独发
                        if ($card[$data['card_id']]['shop_id'] == $this->shop_id) { //越权判断
                            $data['card_id'] = $card[$data['card_id']]['card_id'];
                            if (!empty($card[$data['card_id']]['wx_openid'])) {
                                $data['wx_openid'] = $card[$data['card_id']]['wx_openid'];
                            }
                            $data['number'] = K::M('cashier/coupon/log')->create_number();
                            $send_data = K::M('cashier/coupon/log')->send_coupon($data);
                        }
                    }
                /*}else{
                    $this->msgbox->add('卡券不足', 221)->response();
                }*/
            }
            $this->msgbox->set_data('data', array('send_data'=>$send_data));
        }
    }

    public function closecoupon($params)
    {
        if(!$data = $this->check_fields($params, 'coupon_id')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$coupon_id = (int) $params['coupon_id']){
            $this->msgbox->add('参数错误', 212);
        }else if(!$coupon = K::M('cashier/coupon')->detail($coupon_id)){
            $this->msgbox->add('卡券不存在', 213);
        }else if($coupon['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法的数据操作', 214);
        }else{
            if (K::M('cashier/coupon')->update($coupon['coupon_id'],array('ltime'=>__TIME))){// 更新过期时间为当前时间，即过期。
                $this->msgbox->set_data('data', array('coupon_id'=>$coupon_id));
            }
        }
    }

}