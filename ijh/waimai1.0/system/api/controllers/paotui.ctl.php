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

    
    public function map2($params)
    {   
        if(!$params['alat'] || !$params['alng'] || !$params['blat'] || !$params['blng']){
            $this->msgbox->add(L('经纬度不正确'),211);
        }else{
            //$filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            //$filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            $filter['lat'] = $params['alat'].'~'.$params['blat'];   //左下纬度和右上纬度
            $filter['lng'] = $params['alng'].'~'.$params['blng'];   //左下经度和右上经度
            if($items = K::M('staff/staff')->items($filter,null,1,500,$count)){
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields('staff_id,lat,lng,face,mobile,name,money,orders,total_money', $v);
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('items'=>array_values($items)));
            }else{
                $this->msgbox->add('error');
            }
        }
    }
    
    public function map($params)
    {   
        
        if(!$params['lat'] || !$params['lng']){
            $this->msgbox->add(L('经纬度不正确'),211);
        }else{
            $squares = K::M('helper/round')->returnSquarePoint($params['lng'],$params['lat']);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            if($items = K::M('staff/staff')->items($filter,null,1,500,$count)){
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields('staff_id,lat,lng,face,mobile,name,money,orders,total_money', $v);
                }
            }else{
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items)));
        }
    }
    

    
    //帮我送下单
    public function song($params){
        $this->check_login();
        if(!$o_time = $params['o_time']){
            $this->msgbox->add(L('取件时间不能为空'),211);
        }else if(!$time = $params['time']){
            $this->msgbox->add(L('送件时间不能为空'),212);
        }else if(!$o_addr = $params['o_addr']){
            $this->msgbox->add(L('取件地不能为空'),213);
        }else if(!$o_house = $params['o_house']){
            $this->msgbox->add(L('取件门牌号不能为空'),214);
        }else if(!$o_contact = $params['o_contact']){
            $this->msgbox->add(L('取件人不能为空'),215);
        }else if(!$o_mobile = $params['o_mobile']){
            $this->msgbox->add(L('取件人手机号不能为空'),216);
        }else if(!$o_lng = $params['o_lng']){
            $this->msgbox->add(L('取件地址经度不能为空'),217);
        }else if(!$o_lat = $params['o_lat']){
            $this->msgbox->add(L('取件地址纬度不能为空'),218);
        }else if(!$addr = $params['addr']){
            $this->msgbox->add(L('送件地不能为空'),219);
        }else if(!$house = $params['house']){
            $this->msgbox->add(L('送件门牌号不能为空'),220);
        }else if(!$contact = $params['contact']){
            $this->msgbox->add(L('送件人不能为空'),221);
        }else if(!$mobile = $params['mobile']){
            $this->msgbox->add(L('送件人手机号不能为空'),222);
        }else if(!$lng = $params['lng']){
            $this->msgbox->add(L('送件地址经度不能为空'),223);
        }else if(!$lat = $params['lat']){
            $this->msgbox->add(L('送件地址纬度不能为空'),224);
        }else if(!$intro = $params['intro']){
            $this->msgbox->add(L('配送的物件及要求不能为空'),225);
        }else if(!$paotui_amount = $params['paotui_amount']){
            $this->msgbox->add(L('跑腿费用不能为空'),228);
        }else{

            $photo = $voice = '';
            if($upphoto = $_FILES['photo']){
                if($a = K::M('magic/upload')->upload($upphoto)){
                    $photo = $a['photo'];
                }    
            }
            if($upvoice = $_FILES['voice']){
                if($b = K::M('magic/upload')->file($upvoice)){
                    $voice = $b['photo'];
                }
            }
            $data = array(
                'uid'            => $this->uid,
                'addr'           => $addr,
                'house'          => $house,
                'contact'        => $contact,
                'mobile'         => $mobile,
                'lng'            => $lng,
                'lat'            => $lat,
                'time'           => $time,
                'o_addr'         => $o_addr,
                'o_house'        => $o_house,
                'o_contact'      => $o_contact,
                'o_mobile'       => $o_mobile,
                'o_lng'          => $o_lng,
                'o_lat'          => $o_lat,
                'o_time'         => $o_time,
                'intro'          => $intro,
                'photo'          => $photo,
                'voice'          => $voice,
                'voice_time'          => $params['voice_time'],
                'danbao_amount'  => $params['danbao_amount'],
                'paotui_amount' => $paotui_amount,
                'type'           => 'song',
                'staff_id'          => 0,
                'order_status'   => 0,
            );

            if($paotui_id = K::M('paotui/paotui')->create($data)){
                K::M('paotui/log')->create(array('paotui_id'=>$paotui_id, 'log'=>L('订单已提交'), 'from'=>'member', 'type'=>1));
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('paotui_id'=>$paotui_id));
            }
        }   
    }
    

    
    //帮我买下单
    public function buy($params){
        $this->check_login();
  
        
        if(!$time = $params['time']){
            $this->msgbox->add(L('送件时间不能为空'),212);
        }else if(!$addr = $params['addr']){
            $this->msgbox->add(L('送件地不能为空'),219);
        }else if(!$house = $params['house']){
            $this->msgbox->add(L('送件门牌号不能为空'),220);
        }else if(!$contact = $params['contact']){
            $this->msgbox->add(L('送件人不能为空'),221);
        }else if(!$mobile = $params['mobile']){
            $this->msgbox->add(L('送件人手机号不能为空'),222);
        }else if(!$lng = $params['lng']){
            $this->msgbox->add(L('送件地址经度不能为空'),223);
        }else if(!$lat = $params['lat']){
            $this->msgbox->add(L('送件地址纬度不能为空'),224);
        }else if(!$intro = $params['intro']){
            $this->msgbox->add(L('购买的物件及要求不能为空'),225);
        }else if(!$paotui_amount = $params['paotui_amount']){
            $this->msgbox->add(L('跑腿费用不能为空'),228);
        }else{
            $photo = $voice = '';
            if($upphoto = $_FILES['photo']){
                if($a = K::M('magic/upload')->upload($upphoto)){
                    $photo = $a['photo'];
                }    
            }
            if($upvoice = $_FILES['voice']){
                if($b = K::M('magic/upload')->file($upvoice)){
                    $voice = $b['photo'];
                }
            }
            $data = array(
                'uid'            => $this->uid,
                'addr'           => $addr,
                'house'          => $house,
                'contact'        => $contact,
                'mobile'         => $mobile,
                'lng'            => $lng,
                'lat'            => $lat,
                'time'           => $time,
                'o_addr'         => $params['o_addr'],
                'o_house'        => $params['o_house'],
                'o_contact'      => $params['o_contact'],
                'o_mobile'       => $params['o_mobile'],
                'o_lng'          => $params['o_lng'],
                'o_lat'          => $params['o_lat'],
                'o_time'         => $params['o_time'],
                'danbao_amount'  => $params['danbao_amount'],
                'intro'          => $intro,
                'photo'          => $photo,
                'voice'          => $voice,
                'voice_time'     => $params['voice_time'],
                'paotui_amount'  => $paotui_amount,
                'type'           => 'buy',
                'staff_id'       => 0,
                'order_status'   => 0,
            );

            if($paotui_id = K::M('paotui/paotui')->create($data)){
                K::M('paotui/log')->create(array('paotui_id'=>$paotui_id, 'log'=>L('订单已提交'), 'from'=>'member', 'type'=>1));
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('paotui_id'=>$paotui_id));
            }
        }   
    }
    
    public function detail($params){
        $this->check_login();
        if(!$paotui_id =$params['paotui_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui =K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($paotui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else{
            if($logs = K::M('paotui/log')->select(array('paotui_id'=>$paotui['paotui_id']))){
                $paotui['logs'] = array_values($logs);
            }else{
                $paotui['logs'] = array();
            }
            
  
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',$paotui);
        }  
    }
    
    
    public function items($params)
    {
        
        $this->check_login();
        $filter = array();
        if(in_array($params['status'], array(0,1,2))){
            switch ($params['status']){
            case 2:
                $filter['order_status'] = array(-1,8);
              break;
            case 1:
                $filter['order_status'] = array(0,1,2,3,4,5);
                break;
            }
        }
        if(in_array($params['pay_status'], array(0,1))){
            $filter['pay_status'] = $params['pay_status'];
        }
        $filter['uid'] = $this->uid;

        $page = max((int)$params['page'], 1);
        $items = K::M('paotui/paotui')->items($filter, array('paotui_id'=>'desc'), $page, 10, $count);
        if(!$items){
            $items = array();
        }    
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
       
    }
    

    // 取消跑腿订单
    public function cancel($params)
    {
        $this->check_login();
        if(!$paotui_id = (int)$params['paotui_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paitui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($paitui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($paitui['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'),214);
        }else if($paitui['order_status'] != 0){
            $this->msgbox->add(L('当前订单是不可取消的状态'),215);
        }else if(K::M('paotui/paotui')->cancel($paotui_id, $paitui, 'member')){
            $this->msgbox->add('success');
        }
    }
    
    
    // 跑腿用户确认
    public function set_ok($params)
    {
        $this->check_login();
        if(!$paotui_id = (int)$params['paotui_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$paotui = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($paotui['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($paotui['type'] != 'song'){
            $this->msgbox->add(L('非法操作'),212);
        }else if($paotui['staff_id'] == 0){
            $this->msgbox->add(L('跑腿人员不存在'),213);
        }else if($paotui['order_status'] != 4){
            $this->msgbox->add(L('当前订单无法设置'),214);
        }else if(!K::M('paotui/paotui')->update($paotui['paotui_id'],array('order_status'=>8))){
            $this->msgbox->add(L('设置出错'),215);
        }else{
            $up = K::M('staff/staff')->update_count($paotui['staff_id'],'money',$paotui['paotui_amount']);
            $this->msgbox->add('success');
        }
        
    
        
    }
    
    
    //根据距离和重量计算出配送费用公式配置
    public function price_formula_config(){
        $cfg = $this->system->config->get('paotui');
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('cfg'=>$cfg,'Cfg'=>$cfg));
    }
    
    public function price_formula(){
        
    }
  
    // 根据距离和重量计算出配送费用
    public function price($params)
    {                                                                                                                                              
        $kmp = $kmg = 0;
        if(!$km = $params['km']) {
            $this->msgbox->add(L('距离不存在'),201);
        }
        if(!$kg = $params['kg']) {
            $this->msgbox->add(L('重量不存在'),202);
        }
        $Cfg = $this->system->config->get('paotui');
        $start_price = (int)$Cfg['start_price'];
        $start_km = (int)$Cfg['start_km'];
        $start_kg = (int)$Cfg['start_kg'];
        $addkm_price = (int)$Cfg['addkm_price'];
        $addkg_price = (int)$Cfg['addkg_price'];

        if(($km-$start_km)>0){
           $kmp = ($km - $start_km)*$addkm_price;
        }
        if(($kg-$start_kg)>0){
           $kmg = ($kg - $start_kg)*$addkg_price;
        }
        $price = $start_price + $kmp + $kmg;
        if($price) {
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('price'=>$price));
        }
    }

}
