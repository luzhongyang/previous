<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Paotui extends Ctl
{

    public function adv(){
        if(!$adv = K::M('adv/item')->items(array('adv_id'=>4),array('orderby'=>'asc'))){
            $adv = array();
        }else{
            $adv = array_values($adv);
        }
        $this->msgbox->set_data('data', array('items' => $adv));
    }
    
    
    public function map($params)
    {
        $limit = 500;
        if(!$params['alat'] || !$params['alng'] || !$params['blat'] || !$params['blng']){
            $this->msgbox->add(L('经纬度不正确'), 211);
        }
        else{

            $a = array($params['blat'], $params['alat']);
            sort($a);
            $filter['lat'] = $a[0] . '~' . $a[1];
            $b = array($params['alng'], $params['blng']);
            sort($b);
            $filter['lng'] = $b[0] . '~' . $b[1];

            if($items = K::M('staff/staff')->items($filter, null, 1, $limit, $count)){
                foreach($items as $k => $v){
                    $items[$k] = $this->filter_fields('staff_id,lat,lng,face,mobile,name,money,orders,total_money', $v);
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('items' => array_values($items),'total_count'=>$count));
                //,'sql'=>$this->system->db->SQLLOG()
            }
            else{
                $this->msgbox->add('error');
                $this->msgbox->set_data('data', array('items' => array(),'total_count'=>0));
            }
        }
    }

    public function info_link()
    {
        $cfg = $this->system->config->get('attach');

        //各种链接返回
        $link = $this->mklink('paotui/info', null, null, 'www');
        $this->msgbox->set_data('data', array('link' => $link));
    }

    //帮我买下单
    public function buy($params)
    {
        $this->check_login();
        $cfg = $this->system->config->get('paotui');
        if(!$time = $params['time']){
            $this->msgbox->add(L('收货时间不能为空'), 212);
        }
        else if(!$addr = $params['addr']){
            $this->msgbox->add(L('收货地不能为空'), 219);
        }
        else if(!$house = $params['house']){
            $this->msgbox->add(L('收件门牌号不能为空'), 220);
        }
        else if(!$contact = $params['contact']){
            $this->msgbox->add(L('收件人不能为空'), 221);
        }
        else if(!$mobile = $params['mobile']){
            $this->msgbox->add(L('收件人手机号不能为空'), 222);
        }
        else if(!$lng = $params['lng']){
            $this->msgbox->add(L('收件地址经度不能为空'), 223);
        }
        else if(!$lat = $params['lat']){
            $this->msgbox->add(L('收件地址纬度不能为空'), 224);
        }
        else{

            $photo = array();
            $voice = '';

            if($photo1 = $_FILES['photo1']){
                if($a1 = K::M('magic/upload')->upload($photo1)){
                    $photo[] = $a1['photo'];
                }
            }

            if($photo2 = $_FILES['photo2']){
                if($a2 = K::M('magic/upload')->upload($photo2)){
                    $photo[] = $a2['photo'];
                }
            }

            if($photo3 = $_FILES['photo3']){
                if($a3 = K::M('magic/upload')->upload($photo3)){
                    $photo[] = $a3['photo'];
                }
            }

            if($photo4 = $_FILES['photo4']){
                if($a4 = K::M('magic/upload')->upload($photo4)){
                    $photo[] = $a4['photo'];
                }
            }

            $photo_str = '';
            if(count($photo) > 0){
                foreach($photo as $k => $v){
                    $photo_str = $photo_str . $v . ',';
                }
            }

            if($upvoice = $_FILES['voice']){
                if($b = K::M('magic/upload')->file($upvoice)){
                    $voice = $b['photo'];
                }
            }
            $total_price = $cfg['buy_price'] + $params['reward_amount'];
            $data = array(
                'city_id'      => CITY_ID,
                'uid'          => $this->uid,
                'addr'         => $addr,
                'house'        => $house,
                'contact'      => $contact,
                'mobile'       => $mobile,
                'lng'          => $lng,
                'lat'          => $lat,
                'o_lng'         => $lng,
                'o_lat'         => $lat,
                'pei_time'     => $time,
                'intro'        => $params['intro'],
                'pei_amount'   => $cfg['buy_price'], //获取的配置中的跑腿帮我买的基础费用
                'total_price'  => $total_price,
                'from'         => 'paotui',
                'staff_id'     => 0,
                'order_status' => 0
            );

            if($params['hongbao_id']){ //红包抵扣
                if(!$hongbao = K::M('hongbao/hongbao')->detail($params['hongbao_id'])){
                    $this->msgbox->add('红包不存在！', 225);
                }
                else if($hongbao['uid'] != $this->uid){
                    $this->msgbox->add('非法操作！', 226);
                }
                // else if($hongbao['from'] != 'paotui'){
                //     $this->msgbox->add('红包不适合跑腿使用！', 227);
                // }
                else if($hongbao['min_amount'] > $total_price){
                    $this->msgbox->add('该红包不符合使用条件！', 228);
                }
                else{
                    $data['hongbao_id'] = $hongbao['hongbao_id'];
                    $data['hongbao'] = $hongbao['amount'];
                    $data['amount'] = $total_price - $hongbao['amount'];
                }
            }
            else{
                $data['amount'] = $total_price;
            }

            $data2 = array(
                'type'          => 'buy',
                'paotui_amount' => $cfg['buy_price'], // 起步价
                'reward_amount' => $params['reward_amount'],
                'photo'         => $photo_str,
                'voice'         => $voice,
                'voice_time'    => $params['voice_time']
            );

            if($photo_str){
                $data2['photo'] = $photo_str;
            }
            if($$voice){
                $data2['voice'] = $voice;
                $data2['voice_time'] = $voice_time;
            }

            if($order_id = K::M('order/order')->create($data)){

                //如果有小费，则插入记录表
                if($params['reward_amount']){
                    $reward = array(
                        'order_id'     => $order_id,
                        'order_status' => 0,
                        'type'         => 0,
                        'amount'       => $params['reward_amount']
                    );
                    $add_reward = K::M('paotui/reward')->create($reward);
                }

                $data2['order_id'] = $order_id;
                if($paotui_id = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'status' => 1));
                    // 下单成功更新红包使用状态
                    if($hongbao){
                        K::M('hongbao/hongbao')->update($params['hongbao_id'], array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                    }
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id' => $order_id, 'dateline' => time()));
                }
                else{
                    $this->msgbox->add('下单失败2!', 331);
                }
            }
            else{
                $this->msgbox->add('下单失败!', 330);
            }
        }
    }

    public function song($params)
    {
        $this->check_login();
        $cfg = $this->system->config->get('paotui');
        if(!$time = $params['time']){
            $this->msgbox->add(L('收货时间不能为空'), 212);
        }
        else if(!$addr = $params['addr']){
            $this->msgbox->add(L('收货地不能为空'), 219);
        }
        else if(!$house = $params['house']){
            $this->msgbox->add(L('收件门牌号不能为空'), 220);
        }
        else if(!$contact = $params['contact']){
            $this->msgbox->add(L('收件人不能为空'), 221);
        }
        else if(!$mobile = $params['mobile']){
            $this->msgbox->add(L('收件人手机号不能为空'), 222);
        }
        else if(!$lng = $params['lng']){
            $this->msgbox->add(L('收件地址经度不能为空'), 223);
        }
        else if(!$lat = $params['lat']){
            $this->msgbox->add(L('收件地址纬度不能为空'), 224);
        }
        else if(!$o_addr = $params['o_addr']){
            $this->msgbox->add(L('发货地不能为空'), 219);
        }
        else if(!$o_house = $params['o_house']){
            $this->msgbox->add(L('发件门牌号不能为空'), 220);
        }
        else if(!$o_contact = $params['o_contact']){
            $this->msgbox->add(L('发件人不能为空'), 221);
        }
        else if(!$o_mobile = $params['o_mobile']){
            $this->msgbox->add(L('发件人手机号不能为空'), 222);
        }
        else if(!$o_lng = $params['o_lng']){
            $this->msgbox->add(L('发件地址经度不能为空'), 223);
        }
        else if(!$o_lat = $params['o_lat']){
            $this->msgbox->add(L('发件地址纬度不能为空'), 224);
        }
        else{

            $photo = array();
            $voice = '';

            if($photo1 = $_FILES['photo1']){
                if($a1 = K::M('magic/upload')->upload($photo1)){
                    $photo[] = $a1['photo'];
                }
            }

            if($photo2 = $_FILES['photo2']){
                if($a2 = K::M('magic/upload')->upload($photo2)){
                    $photo[] = $a2['photo'];
                }
            }

            if($photo3 = $_FILES['photo3']){
                if($a3 = K::M('magic/upload')->upload($photo3)){
                    $photo[] = $a3['photo'];
                }
            }

            if($photo4 = $_FILES['photo4']){
                if($a4 = K::M('magic/upload')->upload($photo4)){
                    $photo[] = $a4['photo'];
                }
            }

            $photo_str = '';
            if(count($photo) > 0){
                foreach($photo as $k => $v){
                    $photo_str = $photo_str . $v . ',';
                }
            }

            if($upvoice = $_FILES['voice']){
                if($b = K::M('magic/upload')->file($upvoice)){
                    $voice = $b['photo'];
                }
            }
            $paotui_amount = $this->get_juli_price($lng, $lat, $o_lng, $o_lat);

            $total_price = $paotui_amount + $params['reward_amount'];
            $data = array(
                'city_id'      => CITY_ID,
                'uid'          => $this->uid,
                'addr'         => $addr,
                'house'        => $house,
                'contact'      => $contact,
                'mobile'       => $mobile,
                'lng'          => $lng,
                'lat'          => $lat,
                'o_lng'        => $o_lng,
                'o_lat'        => $o_lat,
                'pei_time'     => $time,
                'intro'        => $params['intro'],
                'pei_amount'   => $paotui_amount,
                'total_price'  => $total_price,
                'from'         => 'paotui',
                'staff_id'     => 0,
                'order_status' => 0
            );

            if($params['hongbao_id']){ //红包抵扣
                if(!$hongbao = K::M('hongbao/hongbao')->detail($params['hongbao_id'])){
                    $this->msgbox->add('红包不存在！', 225);
                }
                else if($hongbao['uid'] != $this->uid){
                    $this->msgbox->add('非法操作！', 226);
                }
                // else if($hongbao['from'] != 'paotui'){
                //     $this->msgbox->add('该红包不符合使用条件！', 227);
                // }
                else if($hongbao['min_amount'] > ($total_price)){
                    $this->msgbox->add('该红包不符合使用条件！', 228);
                }
                else{
                    $data['hongbao_id'] = $hongbao['hongbao_id'];
                    $data['hongbao'] = $hongbao['amount'];
                    $data['amount'] = $total_price - $hongbao['amount'];
                }
            }
            else{
                $data['amount'] = $total_price;
            }

            $data2 = array(
                'type'          => 'song',
                'paotui_amount' => $paotui_amount,
                'reward_amount' => $params['reward_amount'],
                'o_addr'        => $o_addr,
                'o_house'       => $o_house,
                'o_contact'     => $o_contact,
                'o_mobile'      => $o_mobile,
                'o_lng'         => $o_lng,
                'o_lat'         => $o_lat,
                'photo'         => $photo_str,
                'voice'         => $voice,
                'voice_time'    => $params['voice_time']
            );

            if($photo_str){
                $data2['photo'] = $photo_str;
            }
            if($$voice){
                $data2['voice'] = $voice;
                $data2['voice_time'] = $voice_time;
            }

            if($order_id = K::M('order/order')->create($data)){

                //如果有小费，则插入记录表
                if($params['reward_amount']){
                    $reward = array(
                        'order_id'     => $order_id,
                        'order_status' => 0,
                        'type'         => 0,
                        'amount'       => $params['reward_amount']
                    );
                    $add_reward = K::M('paotui/reward')->create($reward);
                }

                $data2['order_id'] = $order_id;
                if($paotui_id = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'status' => 1));
                    // 下单成功更新红包使用状态
                    if($hongbao){
                        K::M('hongbao/hongbao')->update($params['hongbao_id'], array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                    }
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id' => $order_id, 'dateline' => time()));
                }
                else{
                    $this->msgbox->add('下单失败2!', 331);
                }
            }
            else{
                $this->msgbox->add('下单失败!', 330);
            }
        }
    }

    //帮我买下单
    public function other($params)
    {
        $this->check_login();
        $cfg = $this->system->config->get('paotui');
        $other_cate = K::M('paotui/paotui_othercate')->items();
        if(!$time = $params['time']){
            $this->msgbox->add(L('收货时间不能为空'), 212);
        }
        else if(!$addr = $params['addr']){
            $this->msgbox->add(L('收货地不能为空'), 219);
        }
        else if(!$house = $params['house']){
            $this->msgbox->add(L('收件门牌号不能为空'), 220);
        }
        else if(!$contact = $params['contact']){
            $this->msgbox->add(L('收件人不能为空'), 221);
        }
        else if(!$mobile = $params['mobile']){
            $this->msgbox->add(L('收件人手机号不能为空'), 222);
        }
        else if(!$lng = $params['lng']){
            $this->msgbox->add(L('收件地址经度不能为空'), 223);
        }
        else if(!$lat = $params['lat']){
            $this->msgbox->add(L('收件地址纬度不能为空'), 224);
        }
        else{
            $type = $params['type'];

            $photo = array();
            $voice = '';

            if($photo1 = $_FILES['photo1']){
                if($a1 = K::M('magic/upload')->upload($photo1)){
                    $photo[] = $a1['photo'];
                }
            }

            if($photo2 = $_FILES['photo2']){
                if($a2 = K::M('magic/upload')->upload($photo2)){
                    $photo[] = $a2['photo'];
                }
            }

            if($photo3 = $_FILES['photo3']){
                if($a3 = K::M('magic/upload')->upload($photo3)){
                    $photo[] = $a3['photo'];
                }
            }

            if($photo4 = $_FILES['photo4']){
                if($a4 = K::M('magic/upload')->upload($photo4)){
                    $photo[] = $a4['photo'];
                }
            }

            $photo_str = '';
            if(count($photo) > 0){
                foreach($photo as $k => $v){
                    $photo_str = $photo_str . $v . ',';
                }
            }

            if($upvoice = $_FILES['voice']){
                if($b = K::M('magic/upload')->file($upvoice)){
                    $voice = $b['photo'];
                }
            }

            foreach($other_cate as $ok => $ov){
                if($type == $ov['type']){
                    $paotui_amount = $ov['price']; //根据配置计算出价格
                }
            }

            if(!$paotui_amount){
                $this->msgbox->add(L('错误!'), 225);
            }
            $total_price = $paotui_amount + $params['reward_amount'];
            $data = array(
                'city_id'       => CITY_ID,
                'uid'           => $this->uid,
                'addr'          => $addr,
                'house'         => $house,
                'contact'       => $contact,
                'mobile'        => $mobile,
                'lng'           => $lng,
                'lat'           => $lat,
                'o_lng'         => $lng,
                'o_lat'         => $lat,
                'pei_time'      => $time,
                'intro'         => $params['intro'],
                'paotui_amount' => $paotui_amount,
                'total_price'   => $total_price,
                'from'          => 'paotui',
                'staff_id'      => 0,
                'order_status'  => 0
            );

            if($params['hongbao_id']){ //红包抵扣
                if(!$hongbao = K::M('hongbao/hongbao')->detail($params['hongbao_id'])){
                    $this->msgbox->add('红包不存在！', 225);
                }
                else if($hongbao['uid'] != $this->uid){
                    $this->msgbox->add('非法操作！', 226);
                }
                // else if($hongbao['from'] != 'paotui'){
                //     $this->msgbox->add('该红包不符合使用条件！', 227);
                // }
                else if($hongbao['min_amount'] > ($total_price)){
                    $this->msgbox->add('该红包不符合使用条件！', 228);
                }
                else{
                    $data['hongbao_id'] = $hongbao['hongbao_id'];
                    $data['hongbao'] = $hongbao['amount'];
                    $data['amount'] = $total_price - $hongbao['amount'];
                }
            }
            else{
                $data['amount'] = $total_price;
            }

            $data2 = array(
                'type'          => $type,
                'paotui_amount' => $params['paotui_amount'],
                'reward_amount' => $params['reward_amount'],
                'photo'         => $photo_str
            );

            if($photo_str){
                $data2['photo'] = $photo_str;
            }
            if($params['voice_time'] && $voice){
                $data2['voice'] = $voice;
                $data2['voice_time'] = $params['voice_time'];
            }

            if($order_id = K::M('order/order')->create($data)){

                //如果有小费，则插入记录表
                if($params['reward_amount']){
                    $reward = array(
                        'order_id'     => $order_id,
                        'order_status' => 0,
                        'type'         => 0,
                        'amount'       => $params['reward_amount']
                    );
                    $add_reward = K::M('paotui/reward')->create($reward);
                }

                $data2['order_id'] = $order_id;
                if($paotui_id = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'status' => 1));
                    // 下单成功更新红包使用状态
                    if($hongbao){
                        K::M('hongbao/hongbao')->update($params['hongbao_id'], array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                    }
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id' => $order_id, 'dateline' => time()));
                }
                else{
                    $this->msgbox->add('下单失败2!', 331);
                }
            }
            else{
                $this->msgbox->add('下单失败!', 330);
            }
        }
    }

    function reward($params)
    {
        if(!$reward = $params['reward']){
            $this->msgbox->add('金额错误!', 210);
        }
        else if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单ID错误!', 212);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!', 213);
        }
        else{
            $update = K::M('paotui/order')->update_count($order['order_id'], 'reward_amount', $reward);
            $data = array(
                'order_id'     => $order['order_id'],
                'order_status' => $order['order_status'],
                'amount'       => $reward
            );
            if($order['order_status'] == 8){
                $data['type'] = 1;
            }
            else{
                $data['type'] = 0;
            }
            $add = K::M('paotui/reward')->create($data);
            $this->msgbox->add('成功!');
        }
    }

    //公式配置
    public function cfg($params)
    {
        $cfg = $this->system->config->get('paotui');
        //完成订单返回
        $other_cate = K::M('paotui/paotui_othercate')->items();
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('cfg' => $cfg, 'other_cate' => array_values($other_cate)));
    }

    public function paotui_tips()
    {
        $this->check_login();
        $new_com_order = K::M('order/order')->count(array('uid' => $this->uid, 'dateline' => '>:' . $params['time'], 'order_status' => 8, 'from' => 'paotui', 'comment_status' => 0));
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('new_com_order' => $new_com_order));
    }

    public function get_juli_price($alng, $alat, $blng, $blat)
    {
        $cfg = K::M('system/config')->get('paotui');
//        $bl = $cfg['send_pk'];
//        $juli = K::M('helper/round')->getdistances($alng, $alat, $blng, $blat);
//        $km = number_format($juli / 1000, 1);
//        if(strstr($km, ".") || !$km || empty($km)){
//            $km = (int) $km + 1;
//        }
//        if($km <= $cfg['send_km']){
//            $price = $cfg['send_price'];
//        }
//        else{
//            $price = $bl * ($km - $cfg['send_km']) + $cfg['send_price'];
//        }

        $paotui_amount = $cfg['send_price'];
        $distence = K::M('helper/round')->getdistances($alng,$alat,$blng,$blat);
        $over_dt = ceil($distence/1000) - $cfg['send_km'];
        if($over_dt > 0){
            $paotui_amount += $over_dt * $cfg['send_pk'];
        }
        return $paotui_amount;
    }

    public function get_juli_price2($params)
    {  //测试用
        $cfg = K::M('system/config')->get('paotui');
        $bl = $cfg['send_pk'];
        $juli = K::M('helper/round')->getdistances($params['alng'], $params['alat'], $params['blng'], $params['blat']);

        $km = number_format($juli / 1000, 1);
        if(strstr($km, ".") || !$km || empty($km)){
            $km = (int) $km + 1;
        }
        if($km <= $cfg['send_km']){
            $price = $cfg['send_price'];
        }
        else{
            $price = $bl * ($km - $cfg['send_km']) + $cfg['send_price'];
        }

        return $price;
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$order_id = $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法订单'), 213);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 214);
        }
        else{
            // $order = $this->filter_fields('clientip,city_id,closed,coupon,coupon_id,cui_time,first_youhui,from,jd_time,order_status_label,order_status_warning,pay_ip,pay_time,pei_amount,pei_time,pei_type,reason,shop_id,uid,ziti_time', $order);
            $detail = K::M('paotui/order')->detail($order['order_id']);

            $order['type'] = $detail['type'];
            $order['o_addr'] = $detail['o_addr'];
            $order['o_house'] = $detail['o_house'];
            $order['o_contact'] = $detail['o_contact'];
            $order['o_mobile'] = $detail['o_mobile'];
            $order['o_lng'] = $detail['o_lng'];
            $order['o_lat'] = $detail['o_lat'];

            $order['photo'] = array();
            if($detail['photo']) {
                $order['photo'] = explode(',',trim($detail['photo'], ','));
            }
            
            $order['voice'] = $detail['voice'];
            $order['voice_time'] = $detail['voice_time'];
            $order['paotui_amount'] = $detail['paotui_amount'];
            $order['reward_amount'] = $detail['reward_amount'];
            $order['hongbaos'] = $order['hongbao'];
            $order['pei_time'] = $order['pei_time'];
            unset($order['hongbao']);

            if($order['staff_id'] > 0){
                $staff = K::M('staff/staff')->detail($order['staff_id']);
                $order['staff'] = $this->filter_fields('face,name,staff_id,mobile', $staff);
            }
            else{
                $order['staff'] = array('staff_id' => 0);
            }

            if($order['comment_status'] > 0){
                $order['comment'] = K::M('staff/comment')->find(array('order_id' => $order['order_id']));
                if($commentphoto = K::M('staff/commentphoto')->items(array('comment_id' => $order['comment']['comment_id']))){
                    $order['commentphoto'] = array_values($commentphoto);
                }
                else{
                    $order['commentphoto'] = array();
                }
            }
            else{
                $order['comment'] = array('comment_id' => 0);
                $order['commentphoto'] = array();
            }
            $reward = K::M('paotui/reward')->find(array('order_id' => $order_id, 'order_status' => 8, 'type' => 1));
            if($reward){
                $order['reward_status'] = 1;
            }
            else{
                $order['reward_status'] = 0;
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', $order);
        }
    }

    // 取消跑腿订单
    public function cancel($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'), 214);
        }
        else if($order['order_status'] != 0){
            $this->msgbox->add(L('当前订单是不可取消的状态'), 215);
        }
        else{
            if($params['reason']){
                $order['reason'] = $params['reason'];
            }
            if(K::M('order/order')->cancel($order_id, $order, 'member')){
                $this->msgbox->add('success');
            }
        }
    }

    // 跑腿用户确认
    public function set_ok($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['staff_id'] == 0){
            $this->msgbox->add(L('跑腿人员不存在'), 213);
        }
        else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作'), 214);
        }
        else if(!K::M('order/order')->update($order['order_id'], array('order_status' => 8))){
            $this->msgbox->add(L('设置出错'), 215);
        }
        else if(K::M('order/order')->confirm($order_id,$order,'member')){
            $this->msgbox->add('success');
        }
    }

    //删除订单
    public function delete($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作'), 214);
        }
        else if($del = K::M('order/order')->delete($order_id)){
            $this->msgbox->add(L('success'));
        }
        else{
            $this->msgbox->add(L('删除失败!'), 300);
        }
    }

    public function staff_comment($params)  //跑腿订单，评价服务人员
    {
        $this->check_login();
        $datas = array();
        $file = $_FILES;
        $datas['uid'] = $this->uid;

        if(!$datas['order_id'] = $params['order_id']){
            $this->msgbox->add('错误的订单!', 211);
        }
        else if(!$order = K::M('order/order')->detail($datas['order_id'])){
            $this->msgbox->add('错误的订单!', 212);
        }
        else if($order['from'] != 'paotui'){
            $this->msgbox->add('非法操作!', 213);
        }
        else if($order['staff_id'] == 0){
            $this->msgbox->add('错误的服务人员!', 214);
        }
        else if($order['order_status'] != 8){
            $this->msgbox->add('订单当前不可评价!', 215);
        }
        else if(!$datas['score'] = $params['score']){
            $this->msgbox->add('请正确选择总评分!', 216);
        }
        else if(!$datas['content'] = $params['content']){
            $this->msgbox->add('没有填写评价内容!', 217);
        }
        else if(!$datas['mark'] = $params['mark']){
            $this->msgbox->add('没有选择标签!', 218);
        }
        else{

            $datas['staff_id'] = $order['staff_id'];
            if($file){
                $datas['have_photo'] = 1;
            }

            if($create = K::M('staff/comment')->create($datas)){
                if($file){
                    //插入评价
                    foreach($file as $k => $v){
                        if($a = K::M('magic/upload')->upload($v, 'photo')){
                            $photo_data = array(
                                'comment_id' => $create,
                                'photo'      => $a['photo']
                            );
                            $create_photo = K::M('staff/commentphoto')->create($photo_data);
                        }
                    }
                }
                K::M('order/order')->update($order['order_id'], array('comment_status' => 1));
                $this->msgbox->add('评价成功');
            }
            else{
                K::M('system/logs')->log('name', $this->system->db->SQLLOG());
                $this->msgbox->add('评价失败!', 400);
            }
        }
    }

}
