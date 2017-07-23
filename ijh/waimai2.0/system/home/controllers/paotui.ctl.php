<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}


class Ctl_Paotui extends Ctl
{
    
    // 跑腿-首页
    public function index()
    {
        $this->check_login();
        $this->pagedata['adv_item'] = K::M('adv/item')->items(array('adv_id'=>4),array('orderby'=>'asc'),$page,$limit,$count);
        //判断是否有已完成未评价订单
        if($wait = K::M('order/order')->items(array('from'=>'paotui','uid'=>$this->uid,'order_status'=>'8','comment_status'=>'0'),null,null,null,$wait_count)){
            $this->pagedata['wait_count'] = $wait_count;
        }
        $this->tmpl = 'paotui/index.html';
    }
    
    public function showmap($type=null)
    {
        $this->pagedata['type'] = $type;
        $this->tmpl = 'paotui/showmap.html';
    }
    
    // 跑腿-帮我买下单
    public function buy()
    {
        $this->check_login();
        $config = K::M('system/config')->get('paotui');
        if($params = $_POST){
            if(!$pei_time = $params['pei_time']){
                $this->msgbox->add(L('收货时间不能为空'),212);
            }else if(!$addr = $params['addr']){
                $this->msgbox->add(L('收货地不能为空'),219);
            }else if(!$house = $params['house']){
                $this->msgbox->add(L('收件门牌号不能为空'),220);
            }else if(!$contact = $params['contact']){
                $this->msgbox->add(L('收件人不能为空'),221);
            }else if(!$mobile = $params['mobile']){
                $this->msgbox->add(L('收件人手机号不能为空'),222);
            }else if(!($lng = $params['lng']) || !is_numeric($lng)){
                $this->msgbox->add(L('收件地址经度不能为空'),223);
            }else if(!($lat = $params['lat']) || !is_numeric($lat)){
                $this->msgbox->add(L('收件地址纬度不能为空'),224);
            }else{
                $photo = array();
                $voice = '';
                if($photo1 = $_POST['face_img_1']){
                    $photo[] = $photo1;
                }
                if($photo2 = $_POST['face_img_2']){
                    $photo[] = $photo2;
                }
                if($photo3 = $_POST['face_img_3']){
                    $photo[] = $photo3;
                }
                if($photo4 = $_POST['face_img_4']){
                    $photo[] = $photo4;
                }
                
                $photo_str = '';
                if(count($photo) > 0){
                    foreach($photo as $k => $v){
                        $photo_str = $photo_str.$v.',';
                    }
                }
                if($upvoice = $_FILES['voice']){
                    if($b = K::M('magic/upload')->file($upvoice)){
                        $voice = $b['photo'];
                    }
                }
                $paotui_amount = $config['buy_price'];
                $total_price = $config['buy_price'] + $params['reward_amount'];
                $data = array(
                    'city_id'        => CITY_ID,
                    'uid'            => $this->uid,
                    'addr'           => $addr,
                    'house'          => $house,
                    'contact'        => $contact,
                    'mobile'         => $mobile,
                    'lng'            => $lng,
                    'lat'            => $lat,
                    'o_lng'            => $lng,
                    'o_lat'            => $lat,
                    'pei_time'       => strtotime($pei_time),
                    'intro'          => $params['intro'],
                    'paotui_amount'  => $paotui_amount,
                    'total_price'    => $total_price,
                    'from'           => 'paotui',
                    'order_from'    => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    'staff_id'       => 0,
                    'order_status'   => 0
                );
                if($params['hongbao_id']){ //红包抵扣
                    if(!$hongbao = K::M('hongbao/hongbao')->detail($params['hongbao_id'])){
                        $this->msgbox->add('红包不存在！',225)->response();
                    }else if($hongbao['uid'] != $this->uid){
                        $this->msgbox->add('非法操作！',226)->response();
                    }else if(!in_array($hongbao['type'],array(1,4))){
                        $this->msgbox->add('红包不适合跑腿使用！',227)->response();
                    }else if($hongbao['min_amount'] > $total_price){
                        $this->msgbox->add('该红包不符合使用条件！',228)->response();
                    }else{
                        $data['hongbao_id'] = $hongbao['hongbao_id'];
                        $data['hongbao'] = $hongbao['amount'];
                        $data['amount'] = $total_price - $hongbao['amount'];
                    }
                }else{
                    $data['amount'] = $total_price;
                }
            
                $data2 = array(
                    'type'           => 'buy',
                    'paotui_amount'  => $paotui_amount,
                    'reward_amount'  => $params['reward_amount'],
                    'photo'          => $photo_str,
                    'voice'          => $voice,
                    'voice_time'     => $params['voice_time']
                );
            
                if($photo_str){
                    $data2['photo'] = $photo_str;
                }
                if($voice){
                    $data2['voice'] = $voice;
                    $data2['voice_time'] = $voice_time;
                }
            
                if($order_id = K::M('order/order')->create($data)){
                    $data2['order_id'] = $order_id;
                    if($paotui_id = K::M('paotui/order')->create($data2)){
                        K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                        $this->msgbox->add('下单成功');
                        $this->msgbox->set_data('forward', $this->mklink('ucenter/order:payment', array($order_id)));
                    }else{
                        $this->msgbox->add('下单失败2!',331);
                    }
                }else{
                    $this->msgbox->add('下单失败!',330);
                }
            
            }

        }else{
            /* 送达时间选择列表 */
            $res = K::M('order/order')->get_time();
            
            $set_time['start'] = $res['start'];
            $set_time['start_quarter'] = $res['start_quarter'];
            $stime = $res['start'] . ":" . $res['start_quarter'] * 15;
            
            $rr = explode(':', "24:00");
            $set_time['end'] = $rr[0];
            $set_time['end_quarter'] = $rr[1] / 15;
            $ltime = $res['start'] . ":" . $res['start_quarter'] * 15;

            $tomorrow_set_time = $set_time;
            $yy_stime = explode(':', "09:00");
            $tomorrow_set_time['start'] = $yy_stime[0];
            $this->pagedata['tomorrow_set_time'] = $tomorrow_set_time;
            $ziti_yuji = date('H:i', __TIME + 1800);
            
            $displayValues = array('今天', '明天', '后天');
            $values = array(date('Ymd'), date("Ymd", strtotime("+1 day")), date("Ymd", strtotime("+2 day")));

//
            //default  pick-time    20161202 9:15
            $pei_time = date("Ymd H:i", __TIME+ 1800 );
            $this->pagedata['pei_time'] = $pei_time;
            $this->pagedata['values'] = $values;
            $this->pagedata['displayValues'] = $displayValues;
            $this->pagedata['ziti_yuji'] = $ziti_yuji;
            $this->pagedata['set_time'] = $set_time;
            
            $this->pagedata['config'] = $config;
            $this->tmpl = 'paotui/buy.html';
        }
    }
    
    //跑腿-帮我送下单
    public function send()
    {
        $this->check_login();
        $config = $this->system->config->get('paotui');
        if($params = $_POST){
            if(!$pei_time = $params['pei_time']){
                $this->msgbox->add(L('收货时间不能为空'),212);
            }else if(!$addr = $params['addr']){
                $this->msgbox->add(L('收货地不能为空'),219);
            }else if(!$house = $params['house']){
                $this->msgbox->add(L('收件门牌号不能为空'),220);
            }else if(!$contact = $params['contact']){
                $this->msgbox->add(L('收件人不能为空'),221);
            }else if(!$mobile = $params['mobile']){
                $this->msgbox->add(L('收件人手机号不能为空'),222);
            }else if(!($lng = $params['lng']) || !is_numeric($lng)){
                $this->msgbox->add(L('收件地址经度不能为空'),223);
            }else if(!($lat = $params['lat']) || !is_numeric($lat)){
                $this->msgbox->add(L('收件地址纬度不能为空'),224);
            }else if(!$o_addr = $params['o_addr']){
                $this->msgbox->add(L('发货地不能为空'),219);
            }else if(!$o_house = $params['o_house']){
                $this->msgbox->add(L('发件门牌号不能为空'),220);
            }else if(!$o_contact = $params['o_contact']){
                $this->msgbox->add(L('发件人不能为空'),221);
            }else if(!$o_mobile = $params['o_mobile']){
                $this->msgbox->add(L('发件人手机号不能为空'),222);
            }else if(!($o_lng = $params['o_lng']) || !is_numeric($o_lng)){
                $this->msgbox->add(L('发件地址经度不能为空'),223);
            }else if(!($o_lat = $params['o_lat']) || !is_numeric($o_lat)){
                $this->msgbox->add(L('发件地址纬度不能为空'),224);
            }else{
    
                $photo = array();
                $voice = '';
                
                if($photo1 = $_POST['face_img_1']){
                    $photo[] = $photo1;
                }
                if($photo2 = $_POST['face_img_2']){
                    $photo[] = $photo2;
                }
                if($photo3 = $_POST['face_img_3']){
                    $photo[] = $photo3;
                }
                if($photo4 = $_POST['face_img_4']){
                    $photo[] = $photo4;
                }
    
                $photo_str = '';
                if(count($photo) > 0){
                    foreach($photo as $k => $v){
                        $photo_str = $photo_str.$v.',';
                    }
                }
    
                if($upvoice = $_FILES['voice']){
                    if($b = K::M('magic/upload')->file($upvoice)){
                        $voice = $b['photo'];
                    }
                }
                
                $paotui_amount = $config['send_price'];
                $distence = K::M('helper/round')->getdistances($lng,$lat,$o_lng,$o_lat);
                $over_dt = ceil($distence/1000) - $config['send_km'];
                if($over_dt > 0){
                    $paotui_amount += $over_dt * $config['send_pk'];
                }
                
                $total_price = $paotui_amount + $params['reward_amount'];
                $data = array(
                    'city_id'        => CITY_ID,
                    'uid'            => $this->uid,
                    'addr'           => $addr,
                    'house'          => $house,
                    'contact'        => $contact,
                    'mobile'         => $mobile,
                    'lng'            => $lng,
                    'lat'            => $lat,
                    'o_lng'          => $o_lng,
                    'o_lat'          => $o_lat,
                    'pei_time'       => strtotime($pei_time),
                    'intro'          => $params['intro'],
                    'paotui_amount'  => $paotui_amount,
                    'total_price'    => $total_price,
                    'from'           => 'paotui',
                    'order_from'    => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    'staff_id'       => 0,
                    'order_status'   => 0
                );
    
                if($params['hongbao_id']){ //红包抵扣
                    if(!$hongbao = K::M('hongbao/hongbao')->detail($params['hongbao_id'])){
                        $this->msgbox->add('红包不存在！',225)->response();
                    }else if($hongbao['uid'] != $this->uid){
                        $this->msgbox->add('非法操作！',226)->response();
                    }else if(!in_array($hongbao['type'],array(1,4))){
                        $this->msgbox->add('红包不适合跑腿使用！',227)->response();
                    }else if($hongbao['min_amount'] > $total_price){
                        $this->msgbox->add('该红包不符合使用条件！',228)->response();
                    }else{
                        $data['hongbao_id'] = $hongbao['hongbao_id'];
                        $data['hongbao'] = $hongbao['amount'];
                        $data['amount'] = $total_price - $hongbao['amount'];
                    }
                }else{
                    $data['amount'] = $total_price;
                }
    
                $data2 = array(
                    'type'           => 'song',
                    'paotui_amount'  => $paotui_amount,
                    'reward_amount'  => $params['reward_amount'],
                    'o_addr'           => $o_addr,
                    'o_house'          => $o_house,
                    'o_contact'        => $o_contact,
                    'o_mobile'         => $o_mobile,
                    'o_lng'            => $o_lng,
                    'o_lat'            => $o_lat,
                    'photo'          => $photo_str,
                    'voice'          => $voice,
                    'voice_time'     => $params['voice_time']
                );
    
                if($photo_str){
                    $data2['photo'] = $photo_str;
                }
                if($voice){
                    $data2['voice'] = $voice;
                    $data2['voice_time'] = $voice_time;
                }
    
                if($order_id = K::M('order/order')->create($data)){
                    K::M('hongbao/hongbao')->update($hongbao['hongbao_id'], array('order_id'=>$order_id,'used_time'=>__TIME,'used_ip'=>__IP));
                    $data2['order_id'] = $order_id;
                    if($paotui_id = K::M('paotui/order')->create($data2)){
                        K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                        $this->msgbox->add('下单成功');
                        $this->msgbox->set_data('forward', $this->mklink('ucenter/order:payment', array($order_id)));
                    }else{
                        $this->msgbox->add('下单失败2!',331);
                    }
                }else{
                    $this->msgbox->add('下单失败!',330);
                }
            }
        }else{
            /* 送达时间选择列表 */
            $res = K::M('order/order')->get_time();
            
            $set_time['start'] = $res['start'];
            $set_time['start_quarter'] = $res['start_quarter'];
            $stime = $res['start'] . ":" . $res['start_quarter'] * 15;
            
            $rr = explode(':', "24:00");
            $set_time['end'] = $rr[0];
            $set_time['end_quarter'] = $rr[1] / 15;
            $ltime = $res['start'] . ":" . $res['start_quarter'] * 15;

            $tomorrow_set_time = $set_time;
            $yy_stime = explode(':', "09:00");
            $tomorrow_set_time['start'] = $yy_stime[0];
            $this->pagedata['tomorrow_set_time'] = $tomorrow_set_time;
            $ziti_yuji = date('H:i', __TIME + 1800);
            
            $displayValues = array('今天', '明天', '后天');
            $values = array(date('Ymd'), date("Ymd", strtotime("+1 day")), date("Ymd", strtotime("+2 day")));

            //default  pick-time    20161202 9:15
            $pei_time = date("Ymd H:i", __TIME+ 1800 );
            $this->pagedata['pei_time'] = $pei_time;
            $this->pagedata['values'] = $values;
            $this->pagedata['displayValues'] = $displayValues;
            $this->pagedata['ziti_yuji'] = $ziti_yuji;
            $this->pagedata['set_time'] = $set_time;
            
            $this->pagedata['config'] = $config;
            $this->tmpl = 'paotui/send.html';
        }
    }
    
    //跑腿-其他下单
    public function other()
    {
        $this->check_login();
        $cates = K::M('paotui/paotui_othercate')->items();
        if($params = $_POST){
            if(!$picktype = $params['picktype']){
                $this->msgbox->add(L('跑腿类型不能为空'),210);
            }else if(!$cate = $cates[$picktype]){
                $this->msgbox->add(L('跑腿类型不存在'),211);
            }else if(!$pei_time = $params['pei_time']){
                $this->msgbox->add(L('收货时间不能为空'),212);
            }else if(!$addr = $params['addr']){
                $this->msgbox->add(L('收货地不能为空'),219);
            }else if(!$house = $params['house']){
                $this->msgbox->add(L('收件门牌号不能为空'),220);
            }else if(!$contact = $params['contact']){
                $this->msgbox->add(L('收件人不能为空'),221);
            }else if(!$mobile = $params['mobile']){
                $this->msgbox->add(L('收件人手机号不能为空'),222);
            }else if(!$lng = $params['lng']){
                $this->msgbox->add(L('收件地址经度不能为空'),223);
            }else if(!$lat = $params['lat']){
                $this->msgbox->add(L('收件地址纬度不能为空'),224);
            }else{
                $photo = array();
                $voice = '';
                
                if($photo1 = $_POST['face_img_1']){
                    $photo[] = $photo1;
                }
                if($photo2 = $_POST['face_img_2']){
                    $photo[] = $photo2;
                }
                if($photo3 = $_POST['face_img_3']){
                    $photo[] = $photo3;
                }
                if($photo4 = $_POST['face_img_4']){
                    $photo[] = $photo4;
                }
                
                $photo_str = '';
                if(count($photo) > 0){
                   foreach($photo as $k => $v){
                       $photo_str = $photo_str.$v.',';
                   }
                }
                
                if($upvoice = $_FILES['voice']){
                    if($b = K::M('magic/upload')->file($upvoice)){
                        $voice = $b['photo'];
                    }
                }
                $paotui_amount = $cate['price'];
                $total_price = $paotui_amount + $params['reward_amount'];
                $data = array(
                    'city_id'        => CITY_ID,
                    'uid'            => $this->uid,
                    'addr'           => $addr,
                    'house'          => $house,
                    'contact'        => $contact,
                    'mobile'         => $mobile,
                    'lng'            => $lng,
                    'lat'            => $lat,
                    'o_lng'            => $lng,
                    'o_lat'            => $lat,
                    'pei_time'       => strtotime($pei_time),
                    'intro'          => $params['intro'],
                    'paotui_amount'  => $paotui_amount,
                    'total_price'    => $total_price,
                    'from'           => 'paotui',
                    'order_from'    => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    'staff_id'       => 0,
                    'order_status'   => 0
                );
              
                if($params['hongbao_id']){ //红包抵扣
                    if(!$hongbao = K::M('hongbao/hongbao')->detail($params['hongbao_id'])){
                        $this->msgbox->add('红包不存在！',225)->response();
                    }else if($hongbao['uid'] != $this->uid){
                        $this->msgbox->add('非法操作！',226)->response();
                    }else if(!in_array($hongbao['type'],array(1,4))){
                        $this->msgbox->add('红包不适合跑腿使用！',227)->response();
                    }else if($hongbao['min_amount'] > $total_price){
                        $this->msgbox->add('该红包不符合使用条件！',228)->response();
                    }else{
                        $data['hongbao_id'] = $hongbao['hongbao_id'];
                        $data['hongbao'] = $hongbao['amount'];
                        $data['amount'] = $total_price - $hongbao['amount'];
                    }
                }else{
                    $data['amount'] = $total_price;
                }
                $data2 = array(
                    'type'           => $cate['type'],
                    'paotui_amount'  => $paotui_amount,
                    'reward_amount'  => $params['reward_amount'],
                    'photo'          => $photo_str,
                    'voice'          => $voice,
                    'voice_time'     => $params['voice_time']
                );
                
                if($photo_str){
                    $data2['photo'] = $photo_str;
                }
                if($voice){
                    $data2['voice'] = $voice;
                    $data2['voice_time'] = $voice_time;
                }
    
                if($order_id = K::M('order/order')->create($data)){
                    K::M('hongbao/hongbao')->update($hongbao['hongbao_id'], array('order_id'=>$order_id,'used_time'=>__TIME,'used_ip'=>__IP));
                    $data2['order_id'] = $order_id;
                    if($paotui_id = K::M('paotui/order')->create($data2)){
                        K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单已提交','status'=>1));
                       $this->msgbox->add('下单成功');
                       $this->msgbox->set_data('forward', $this->mklink('ucenter/order:payment', array($order_id)));
                    }else{
                        $this->msgbox->add('下单失败2!',331);
                    }
                }else{
                    $this->msgbox->add('下单失败!',330);
                }
                
            } 
        }else{
            /* 送达时间选择列表 */
            $res = K::M('order/order')->get_time();
            
            $set_time['start'] = $res['start'];
            $set_time['start_quarter'] = $res['start_quarter'];
            $stime = $res['start'] . ":" . $res['start_quarter'] * 15;
            
            $rr = explode(':', "24:00");
            $set_time['end'] = $rr[0];
            $set_time['end_quarter'] = $rr[1] / 15;
            $ltime = $res['start'] . ":" . $res['start_quarter'] * 15;

            $tomorrow_set_time = $set_time;
            $yy_stime = explode(':', "09:00");
            $tomorrow_set_time['start'] = $yy_stime[0];
            $this->pagedata['tomorrow_set_time'] = $tomorrow_set_time;
            $ziti_yuji = date('H:i', __TIME + 1800);

            $displayValues = array('今天', '明天', '后天');
            $values = array(date('Ymd'), date("Ymd", strtotime("+1 day")), date("Ymd", strtotime("+2 day")));

            //default  pick-time    20161202 9:15
            $pei_time = date("Ymd H:i", __TIME+ 1800 );
            $this->pagedata['pei_time'] = $pei_time;

            $this->pagedata['values'] = $values;
            $this->pagedata['displayValues'] = $displayValues;
            $this->pagedata['ziti_yuji'] = $ziti_yuji;
            $this->pagedata['set_time'] = $set_time;
            
            foreach($cates as $k=>$v){
                $prices[$v['cate_id']] = $v['price'];
                $cate['title'] .= "'".$v['title'].":￥".$v['price']."',";
                $cate['id'] .= "'".$v['cate_id']."',";
            } 
            $this->pagedata['cate'] = $cate;
            $this->pagedata['prices'] = json_encode($prices,true);
            $this->tmpl = 'paotui/other.html';
        }
    }
    
    
    // 微信端暂时无上传语音功能
    public function uploadVoice(){
        $mid = $this->GP('mid');
        if($mid){
            if($voice = K::M('weixin/wechat')->wechat_client()->download($mid)){
                if($b = K::M('magic/upload')->file($voice)){
                    $voice = $b['photo'];
                    $this->msgbox->add('上传成功');
                }else{
                    $this->msgbox->add('上传失败',224);
                }
            }else{
                $this->msgbox->add('上传失败',225);
            }
        }else{
            $this->msgbox->add('错误',226);
        }
        
    }
    
    public function order()
    {
        $this->check_login();
        $reason = K::M('order/order')->get_reason();
        $orders_wait = $this->orders_items(0);
        $orders_done = $this->orders_items(1);
        $this->pagedata['reason'] = $reason['paotui'];
        $this->pagedata['orders_wait'] = $orders_wait;
        $this->pagedata['orders_done'] = $orders_done;
        $this->tmpl = 'paotui/orders.html';
    }

    public function orders_items($status)
    {
        $map = array();
        $map['from'] = 'paotui';
        $map['uid'] = $this->uid;
        if($status){
            $map['order_status'] = array(-1,4,8);
        }else{
            $map['order_status'] = array(0,1,2,3);
        }
        $list = K::M('order/order')->items($map);
        foreach($list as $k=>$v){
            $past_time = K::M('helper/format')->time($v['dateline']);
            $list[$k][past_time] = $past_time;
            $paotui_order_ids[$k] = $v['order_id'];
            if(__TIME - $v['dateline'] > 1800 && $v['order_status']==0 && $v['pay_status']==0 && $v['online_pay']==1) {
                K::M('order/order')->cancel($v['order_id'], $v, 'admin','订单超过30分钟未付款自动取消');
            }
            if(__TIME - $v['dateline'] > 3600 && $v['order_status']==0 && $v['pay_status']==1) {
                K::M('order/order')->cancel($v['order_id'], $v, 'admin','订单逾期1小时内无人接单自动取消');
            }
            /* $paotui_order = K::M('paotui/order')->detail($v['order_id']);
            $list[$k]['paotui_order'] = $paotui_order; */
        }
        $paotui_orders = K::M('paotui/order')->items_by_ids($paotui_order_ids);
        foreach($paotui_order_ids as $k=>$v){
            $list[$k]['paotui_order'] = $paotui_orders[$v];
        }
        return $list;
    }
    
    public function order_cancel($order_id){
        $this->check_login();
        $reason = $this->GP('reason');
        $order_id = (int)$order_id?(int)$order_id:$this->GP('order_id');
        if(!$order_id){
            $this->msgbox->add(L('订单号错误'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作，用户不匹配'),213);
        }else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作，类型错误'),214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add(L('订单状态不正确'),214);
        }else{
            if(K::M('order/order')->cancel($order_id, $order, 'member',$reason)){
                $this->msgbox->add(L('取消成功'));
                $this->msgbox->set_data('forward', $this->mklink('paotui/order_detail',array($order_id)));
            }else{
                $this->msgbox->add(L('操作失败'),214);
            }
        }
    }
    
    public function order_confirm($order_id){
        $this->check_login();
        $order_id = (int)$order_id?(int)$order_id:$this->GP('order_id');
        if(!$order_id){
            $this->msgbox->add(L('订单号错误'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作，用户不匹配'),213);
        }else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作，类型错误'),214);
        }else if($order['order_status'] != 3){
            $this->msgbox->add(L('订单状态不正确'),214);
        }else{
            if(K::M('order/order')->confirm($order_id, $order, 'member')){
                $this->msgbox->add(L('确认成功'));
                $this->msgbox->set_data('forward', $this->mklink('paotui/order_detail',array($order_id)));
            }else{
                $this->msgbox->add(L('操作失败'),214);
            }
        }
    }
    
    public function order_comment($order_id){
        $this->check_login();
        $order_id = (int)$order_id?(int)$order_id:$this->GP('order_id');
        if(!$order_id){
            $this->msgbox->add(L('订单号错误'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作，用户不匹配'),213);
        }else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作，类型错误'),214);
        }else if(!in_array($order['order_status'],array(4,8))){
            $this->msgbox->add(L('订单状态不正确'),214);
        }else if($order['comment_status'] == 0){
            //评价订单
            $jifen_ratio = $this->system->config->get('jifen');
            $jifen = (int)($jifen_ratio)*(int)($order['amount']);
            if($this->GP('order_id')){
                //接收数据
                $data = $_POST['data'];
                if(!$data['score']) {   //配送员配送
                    $this->msgbox->add('请为服务打分',218)->response();
                }else if(!$data['content']) {
                    $this->msgbox->add('请写下您对服务的评价',219)->response();
                }
                $data['staff_id'] = $order['staff_id'];
                $data['uid'] = $this->uid;
                $data['order_id'] = $order_id;
                if($_FILES['data']) {
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $data['have_photo'] = 1;
                }
                if($comment_id = K::M('staff/comment')->create($data)){
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'comment')){
                                K::M('staff/commentphoto')->create(array('comment_id'=>$comment_id,'photo'=>$a['photo']));
                            }
                        }
                    }  
                    K::M('member/member')->update_jifen($this->uid,$jifen,'订单'.$order_id.'评价完成，获得积分');
                    K::M('order/order')->update($order,array('comment_status'=>1));
                    K::M('staff/staff')->send($order['staff_id'], '用户评价', '订单'.$order_id.'已获得用户评价', 'comment', $order_id);
                    
                    $this->msgbox->add('评价成功');
                    $this->msgbox->set_data('forward', $this->mklink('paotui/order_comment', array($order_id)));
                }else{
                    $this->msgbox->add('评价失败');
                    $this->msgbox->set_data('forward', $this->mklink('paotui/order_comment', array($order_id)));
                }
            }else{
                //打开评价页面
                $this->pagedata['jifen'] = $jifen;
                $staff = K::M('staff/staff')->detail($order['staff_id']);
                $this->pagedata['staff'] = $staff;
                $titles = K::M('order/order')->get_comment();
                $this->pagedata['titles'] = $titles['paotui'];
                $this->pagedata['order_id'] = $order['order_id'];
                $this->tmpl = 'paotui/comment.html';
            }
        }else{
            //查看评价
            $staff = K::M('staff/staff')->detail($order['staff_id']);
            $this->pagedata['staff'] = $staff;
            $titles = K::M('order/order')->get_comment();
            $this->pagedata['titles'] = $titles['paotui'];
            $comment = K::M('staff/comment')->find(array('order_id'=>$order_id));
            $marks = explode(',',$comment['mark']);
            foreach($titles['paotui'] as $k=>$v){
                if(in_array($v,$marks)){
                    $comment['marks'][$k] = $k;
                }
            }
            $comment['photos'] = K::M("staff/commentphoto")->items(array('comment_id'=>$comment['comment_id']));
            $this->pagedata['comment'] = $comment;
            $this->tmpl = 'paotui/comment_show.html';
        }
    }
    
    public function order_detail($order_id){
        $this->check_login();
        $order_id = (int)$order_id?(int)$order_id:$this->GP('order_id');
        if(!$order_id){
            $this->msgbox->add(L('订单号错误'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作，用户不匹配'),213);
        }else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作，类型错误'),214);
        }else{
            if(__TIME - $order['dateline'] > 1800 && $order['order_status']==0 && $order['pay_status']==0) {
                K::M('order/order')->cancel($order_id, $order, 'admin','订单超过30分钟未付款自动取消');
            }
            if(__TIME - $order['dateline'] > 3600 && $order['order_status']==0 && $order['pay_status']==1) {
                K::M('order/order')->cancel($order_id, $order, 'admin','订单逾期1小时内无人接单自动取消');
            }
            if(define('IN_WEIXIN')) {
                $pagedata['weixin'] = 1;
            }
            $order['past_time'] = K::M('helper/format')->time($order['dateline']);
            $paotui_order = K::M('paotui/order')->detail($order['order_id']);
            $order['paotui_order'] = $paotui_order;
            $this->pagedata['order'] = $order;
            if($paotui_order['type'] != 'buy' && $paotui_order['type'] != 'song'){
                $cates = K::M('paotui/paotui_othercate')->items();
                foreach($cates as $k=>$cate){
                    if($cate['type'] == $paotui_order['type']){
                        $this->pagedata['cate'] = $cate;
                        break;
                    }
                }                
            }
            if($order['staff_id']){
                $staff = K::M('staff/staff')->detail($order['staff_id']);
                $this->pagedata['staff'] = $staff;
            }
            // 追加小费
            $addtip = K::M('paotui/reward')->items(array('order_id'=>$order_id));
            foreach($addtip as $k=>$v) {
                if($v['type'] == 0) {
                    $tip_amount += $v['amount'];
                }
                if($v['type'] == 1) {
                    $ward_amount += $v['amount'];
                }
            }
            $reason = K::M('order/order')->get_reason();
            $this->pagedata['reason'] = $reason['paotui'];
            $this->pagedata['tip_amount'] = $tip_amount;
            $this->pagedata['ward_amount'] = $ward_amount;
            $this->tmpl = 'paotui/order_detail.html';
        }
    }
    
    public function order_repai($order_id){
        $order_id = (int)$order_id?(int)$order_id:$this->GP('order_id');
        if(!$order_id){
            $this->msgbox->add(L('订单号错误'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作，用户不匹配'),213);
        }else if($order['from'] != 'paotui'){
            $this->msgbox->add(L('非法操作，类型错误'),214);
        }else{
            $paotui_order = K::M('paotui/order')->detail($order['order_id']);
            $data = array(
                'addr' => $order['addr'],
                'house' => $order['house'],
                'lat' => $order['lat'],
                'lng' => $order['lng'],
                'contact' => $order['contact'],
                'mobile' => $order['mobile'],
                'intro' => $order['intro'],
                'o_addr' => $paotui_order['o_addr'],
                'o_house' => $paotui_order['o_house'],
                'o_lat' => $paotui_order['o_lat'],
                'o_lng' => $paotui_order['o_lng'],
                'o_contact' => $paotui_order['o_contact'],
                'o_mobile' => $paotui_order['o_mobile'],
            );
            if($paotui_order['type'] == 'buy'){
                $data['link'] = $this->mklink('paotui/buy');
            }elseif($paotui_order['type'] == 'song'){
                $data['link'] = $this->mklink('paotui/send');
            }else{
                $cates = K::M('paotui/paotui_othercate')->items();
                foreach($cates as $k=>$cate){
                    if($cate['type'] == $paotui_order['type']){
                        $data['typepick'] = $cate['title'];
                        $data['style'] = $cate['cate_id'];
                        break;
                    }
                } 
                $data['link'] = $this->mklink('paotui/other');
            }
            echo json_encode($data,true);exit;
            //$this->msgbox->set_data('data', array_values($data));
        }
    }

    // 删除跑腿订单
    public function order_del() {
        $this->check_login();
        $order_id = (int)$this->GP('order_id');
        if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在',210);
        }else if($this->uid != $order['uid']) {
            $this->msgbox->add('非法操作',211);
        }else if($order['from'] != 'paotui') {
            $this->msgbox->add('非法操作',212);
        }else if(($order['order_status'] == -1) || ($order['order_status'] == 8)){
            if(K::M('order/order')->delete($order_id, false)){
                $this->msgbox->add('删除订单成功');
            }else{
                $this->msgbox->add('删除订单失败', 213);
            }
        }else{
            $this->msgbox->add('当前状态不可删除', 214);
        }
    }
    
    public function photo()
    {
        if(!$attach = $_FILES['imgFile']){
            $this->msgbox->add(L('上传文件失败'), 211);
        }else if(UPLOAD_ERR_OK != $attach['error']){
            $this->msgbox->add(L('上传文件失败'), 212);
        }else if($data = K::M('magic/upload')->upload($attach, 'photo')){
            $cfg = $this->system->config->get('attach');
            $this->msgbox->set_data('photo', $data['photo']);
        }
        $this->msgbox->json();
    }
    
    public function set_ok($paotui_id){ //帮我送订单设置已完成
    
        if(!$paotui_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),211);
        }else if($paotui['type'] != 'song'){
            $this->msgbox->add(L('非法操作'),212);
        }else if($paotui['staff_id'] == 0){
            $this->msgbox->add(L('非法操作'),213);
        }else if($paotui['order_status'] != 4){
            $this->msgbox->add(L('订单状态不正确'),214);
        }else if(!K::M('paotui/paotui')->update($paotui['paotui_id'],array('order_status'=>8))){
            $this->msgbox->add(L('FAIL'),215);
        }else{
            //发钱给配送员
            $up = K::M('staff/staff')->update_count($paotui['staff_id'],'money',$paotui['paotui_amount']);
            $this->msgbox->add(L('操作成功'));
        }
    
    }
    
    // 跑腿-订单列表
    public function paotui($status=1,$page=1){
        $this->check_login();
        $filter = array();
        if(in_array($status, array(1,2))){
            switch ($status){
                case 2:
                    $filter['order_status'] = array(8);
                    break;
                case 1:
                    $filter['order_status'] = array(0,1,2,3,4,5);
                    break;
            }
        }
        $filter['uid'] = $this->uid;
    
        $page = max((int)$page, 1);
        $items = K::M('paotui/paotui')->items($filter, array('paotui_id'=>'desc'), $page, 100, $count);
        $this->pagedata['status'] = $status;
        $this->pagedata['items'] = $items;
         
        $this->tmpl = 'paotui/paotui.html';
    }
    
    // 跑腿-订单详情
    public function detail($paotui_id){
        $this->check_login();
        if(!$paotui_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui =K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($paotui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else{
            if($paotui['staff_id'] > 0){
                $staff = K::M('staff/staff')->detail($paotui['staff_id']);
                $paotui['staff'] = $staff;
            }
            $this->pagedata['paotui'] = $paotui;
            $this->tmpl = 'paotui/detail.html';
        }
    }
    
    
    // 跑腿-订单日志
    public function log($paotui_id){
        $this->check_login();
        if(!$paotui_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui =K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($paotui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!$logs =K::M('paotui/log')->select(array('paotui_id'=>$paotui_id))){
            $this->msgbox->add(L('订单日志不存在'),212);
        }else{
            $this->pagedata['paotui'] = $paotui;
            $this->pagedata['logs'] = $logs;
            $this->tmpl = 'paotui/log.html';
        }
    
    }
    
    public function buy_handle()
    {
        $datas = array();
        $this->check_login();
        if(!$data = $this->checksubmit('data')){
            $this->msgbox->add(L('FAIL'), 211);
        }else if(!$intro = $data['intro']){
            $this->msgbox->add(L('购买的物件及要求不能为空'), 225);
        }else if(!$addr_id = $data['addr_id']){
            $this->msgbox->add(L('收货地址不能为空'), 227);
        }else if(!$time = $data['time']){
            $this->msgbox->add(L('收货时间不能为空'), 228);
        }else if(!$paotui_amount = $data['paotui_amount']){
            $this->msgbox->add(L('跑腿费用不能为空'), 229);
        }else{
            $addr = K::M('member/addr')->detail($addr_id);
            $xiaofei = $data['xiaofei'] ? $data['xiaofei'] : 0;
            $paotui_amount = $paotui_amount + $xiaofei;
            //if($data['danbao_amount']){
                //$paotui_amount = $paotui_amount + $data['danbao_amount'];
            //}            
            if($attach = $_FILES['photo1']){
                if($a = K::M('magic/upload')->upload($attach)){
                    $photo = $a['photo'];
                }    
            }
            
            /*if($mid = $data['mid']){
                $voice = K::M('weixin/wechat')->wechat_client()->download($mid);
                //K::M('magic/upload')->upload_by_data($data);
                // file_put_contents('')
                if($b = K::M('magic/upload')->file($voice)){
                    $voice = $b['photo'];
                }
            }*/
            
            $paotui_data = array(
                'uid'=>$this->uid,
                'o_addr'=>$data['o_addr'],
                'o_house'=>$data['o_house'],
                'o_contact'=>$data['o_contact'],
                'o_mobile'=>$data['o_mobile'],
                'o_lng'=>$data['o_lng'],
                'o_lat'=>$data['o_lat'],
                'danbao_amount' => $data['danbao_amount'],
                'time'=>strtotime($time),
                'addr'=>$addr['addr'],
                'house'=>$addr['house'],
                'contact'=>$addr['contact'],
                'mobile'=>$addr['mobile'],
                'lng'=>$addr['lng'],
                'lat'=>$addr['lat'],
                'type'=>'buy',
                'intro'=>$intro,
                'photo'=>$photo,
                'voice'=>$voice,
                'paotui_amount'=>$paotui_amount
            );
         
            if($paotui_id = K::M('paotui/paotui')->create($paotui_data)){
                K::M('paotui/log')->create(array('paotui_id'=>$paotui_id, 'log'=>L('订单已提交'), 'from'=>'member', 'type'=>1));
                $this->msgbox->add(L('操作成功'));
                $this->msgbox->set_data('data', array('paotui_id' => $paotui_id));
            }else{
                $this->msgbox->add(L('FAIL'), 229);
            }
            
        }
        
    }

    // 跑腿-获取附近配送员经纬度坐标
    public function getstaffpoi()
    {
        $items = $filter = array();
        $SouthWlng = $this->GP('SouthWlng');
        $SouthWlat = $this->GP('SouthWlat');
        $NorthElng = $this->GP('NorthElng');
        $NorthElat = $this->GP('NorthElat');

        if(!$SouthWlng || !$SouthWlat || !$NorthElng || !$NorthElat){
            $this->msgbox->add(L('经度纬度不完整'),211);
        }else{
            $filter['lat'] = $SouthWlat.'~'.$NorthElat;   //左下纬度和右上纬度
            $filter['lng'] = $SouthWlng.'~'.$NorthElng;   //左下经度和右上经度
            $filter['status'] = 1;
            if($items = K::M('staff/staff')->items($filter,null,1,500,$count)){
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields('staff_id,lat,lng', $v);
                }
                $this->msgbox->add(L('操作成功'));
                $this->msgbox->set_data('data', array('items' => $items));
                $this->msgbox->set_data('count', $count);
                $this->msgbox->response();
            }else{
                $this->msgbox->add(L('FAIL'),210);
                $this->msgbox->set_data('data', array('items' => array()));
                $this->msgbox->response();
            }
        }
    }
    
    
    
    public function pay($paotui_id)
    {
        if(!$paotui_id = (int)$paotui_id){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }else if($paotui['pay_status'] ==1){
            $this->msgbox->add(L('订单已支付'), 213);
        }      
        $this->pagedata['paotui'] = $paotui;
        $this->tmpl = 'paotui/pay.html';  
    }
    
    
    // 取消跑腿订单
    public function cancel($paotui_id)
    {
        $this->check_login();
        if(!$paotui_id = (int)$paotui_id){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$paitui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }else if($paitui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($paitui['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'), 214);
        }else if($paitui['order_status'] != 0){
            $this->msgbox->add(L('当前订单是不可取消的状态'), 215);
        }else if(K::M('paotui/paotui')->cancel($paotui_id, $paitui, 'member')){
            $this->msgbox->add(L('操作成功'));
        }
    }
    
    
    //地图规划
    public function map($alng,$alat,$blng,$blat)
    {
        $this->tmpl = 'paotui/map.html'; 
    }
    
    //说明
    public function info()
    {
        $this->tmpl = 'paotui/info.html';
    }
}