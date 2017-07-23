<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Tuan_order extends Ctl
{
    // 团购提交订单
    public function sub($shop_id) 
    {
        $this->check_login();
        $detail = array();
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('商家不能为空',221)->response();
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
             $this->msgbox->add('商家不能为空',222)->response();
        }else {
            if($data = $this->checksubmit('data')) {
                //var_dump($data);die;
                if(!$tuan = K::M('tuan/tuan')->detail($data['tuan_id'])) {
                    $this->msgbox->add('团购商品不存在',223);
                }else if($tuan['shop_id'] != $shop_id) {
                    $this->msgbox->add('商品不是同一家商家的',224);
                }else {
                    $this->pagedata['detail'] = $tuan;
                }
            }
        }
        $this->tmpl = 'tuan/order.html';
    }

    // 团购创建订单
    public function create()
    {
        // 判断商家 判断团购商品的库存
        $this->check_login();
        $ticket_merge = null;
        $data_order = $data_tuan = $data_ticket= array();
        if(IS_AJAX){
            if(!$shop_id = (int)$this->GP('shop_id')) {
                $this->msgbox->add('商家不能为空',221);
            }else if(!$shop_detail = K::M('shop/shop')->detail($shop_id)){
                $this->msgbox->add('商家不存在',222);
            }else if($shop_detail['audit'] !=1){
                $this->msgbox->add('商家未审核',223);
            }else if(!$tuan_id = (int)$this->GP('tuan_id')) {
                $this->msgbox->add('商品不能为空',224);
            }else if(!$tuan_detail = K::M('tuan/tuan')->detail($tuan_id)) {
                $this->msgbox->add('商品不存在',225);
            // }else if($tuan_detail['audit'] !=1 || $tuan_detail['closed'] !=0) {
            //     $this->msgbox->add('商品未审核或已删除',226);
            }else if(!$numbers = (int)$this->GP('numbers')) {
                $this->msgbox->add('商品数量不正确',227);
            }else if(!$prices = $this->GP('prices')) {
                $this->msgbox->add('商品总价不正确',228);
            }else if($tuan_detail['max_buy'] < $numbers){
                $this->msgbox->add('不能超过最大购买数',230);
            }else if($tuan_detail['min_buy'] > $numbers){
                $this->msgbox->add('不能低于最小购买数',231);
            }else if($tuan_detail['stock_type'] ==1 && ($tuan_detail['stock_num'] < $numbers)){
                $this->msgbox->add('商品库存不足',229);
            }else if(__TIME < $tuan_detail['stime'] || __TIME > $tuan_detail['ltime']) {
                $this->msgbox->add('当前不在团购有效期时间内',232);
            }else {
                $lng = $this->request['UxLocation']['lng'];
                $lat = $this->request['UxLocation']['lat'];
                
                $data_order = array(
                    'city_id'            => $shop_detail['city_id'],
                    'shop_id'            => $shop_id,
                    'staff_id'           => 0,
                    'uid'                => $this->uid,
                    'from'               => 'tuan',
                    'order_status'       => 0,
                    'pay_status'         => 0,
                    'total_price'        => $numbers * $prices,
                    'amount'             => $numbers * $prices,
                    'mobile'             => $this->MEMBER['mobile'],
                    'contact'            => $this->MEMBER['nickname'],
                    'addr'               => '',
                    'house'              => '',
                    'lng'                => $lng,
                    'lat'                => $lat,
                    'order_from'         => (defined('IN_WEIXIN') ? 'weixin' : 'wap')
                );
                $data_tuan = array(
                    'tuan_id'            => $tuan_id,
                    'tuan_title'         => $tuan_detail['title'],
                    'tuan_price'         => $numbers * $prices,
                    'tuan_number'        => $numbers,
                    'use_time'           => 0,
                    'ltime'              => $tuan_detail['ltime'],
                    'type'               => $tuan_detail['type'],
                );
                $data_ticket = array(
                    'uid'                => $this->uid,
                    'shop_id'            => $shop_id,
                    'tuan_id'            => $tuan_id,
                    'count'              => $numbers,
                    'ltime'              => $tuan_detail['ltime'],
                    'use_time'           => 0,
                    'status'             => 0,
                    'type'               => $tuan_detail['type'],
                    'dateline'           => __TIME
                );
                if($order_id = K::M('order/order')->create($data_order)) {
                    // 创建tuan_order订单
                    $data_tuan['order_id'] = $order_id;
                    K::M('tuan/order')->create($data_tuan); 
                    // 更新商品销量
                    K::M('tuan/tuan')->update_count($tuan_id, 'sales', $numbers);
                    K::M('tuan/tuan')->update_count($tuan_id,'sale_count', $numbers);
                    K::M('tuan/tuan')->update_count($tuan_id,'stock_num', -$numbers);
                    // if($tuan_detail['stock_type'] ==1){  //启用库存机制时 更新已购数
                    //     K::M('tuan/tuan')->update_count($tuan_id,'sale_count', $numbers);
                    //     K::M('tuan/tuan')->update_count($tuan_id,'stock_num', -$numbers);
                    // }
                    // 写入订单日志
                    K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                    // 给商户发送订单消息
                    K::M('shop/msg')->create(array('shop_id'=>$shop_id,'title'=>'订单已提交','content'=>'订单已提交','is_read'=>0,'type'=>1,'order_id'=>$order_id));
                    // 更新用户订单量
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    //echo '<pre>';print_r($this->system->db->SQLLOG());die;
                    $this->msgbox->add('订单提交成功');
                    $this->msgbox->set_data('order_id',$order_id);   
                    $this->msgbox->set_data('pay_status',$data_order['pay_status']);            
                }
            }
        }
    }
}