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
        $this->tmpl = 'paotui/index.html';
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
            $this->msgbox->add(L('SUCCESS'));
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
    
    // 跑腿-帮我送下单
    public function songsubmit(){
        $this->check_login();
        $data = $this->GP('data');
        if(!$data = $this->checksubmit('data')){
            $this->msgbox->add(L('非法操作'), 211);
        }else if(!$o_time = $data['q_time']){
            $this->msgbox->add(L('取件时间不能为空'), 211);
        }else if(!$time = $data['s_time']){
            $this->msgbox->add(L('送件时间不能为空'), 212);
        }else if(!$o_addr = $data['q_addr']){
            $this->msgbox->add(L('取件地不能为空'), 213);
        }else if(!$o_house = $data['q_num']){
            $this->msgbox->add(L('取件门牌号不能为空'), 214);
        }else if(!$o_contact = $data['q_name']){
            $this->msgbox->add(L('取件人不能为空'), 215);
        }else if(!$o_mobile = $data['q_phone']){
            $this->msgbox->add(L('取件人手机号不能为空'), 216);
        }else if(!$o_lng = $data['q_lng']){
            $this->msgbox->add(L('取件地址经度不能为空'), 217);
        }else if(!$o_lat = $data['q_lat']){
            $this->msgbox->add(L('取件地址纬度不能为空'), 218);
        }else if(!$addr = $data['s_addr']){
            $this->msgbox->add(L('送件地不能为空'), 219);
        }else if(!$house = $data['s_num']){
            $this->msgbox->add(L('送件门牌号不能为空'), 220);
        }else if(!$contact = $data['s_name']){
            $this->msgbox->add(L('送件人不能为空'), 221);
        }else if(!$mobile = $data['s_phone']){
            $this->msgbox->add(L('送件人手机号不能为空'), 222);
        }else if(!$lng = $data['s_lng']){
            $this->msgbox->add(L('送件地址经度不能为空'), 223);
        }else if(!$lat = $data['s_lat']){
            $this->msgbox->add(L('送件地址纬度不能为空'), 224);
        }else if(!$intro = $data['intro']){
            $this->msgbox->add(L('配送的物件及要求不能为空'), 225);
        }/*else if(!$voice = $data['voice']){
            $this->msgbox->add('没有语音',227);
        }*/else if(!$amount = $data['amount']){
            $this->msgbox->add(L('物件重量不能为空'),228);
        }else{
            if($attach = $_FILES['photo1']){
                if($a = K::M('magic/upload')->upload($attach)){
                    $photo = $a['photo'];
                }    
            }
            $xiaofei = $data['xiaofei'] ? $data['xiaofei'] : 0;
            $paotui_amount = $amount + $xiaofei; //结算金额 = 配送费+小费
            $datas = array(
                'uid'            => $this->uid,
                'addr'           => $addr,
                'house'          => $house,
                'contact'        => $contact,
                'mobile'         => $mobile,
                'lng'            => $lng,
                'lat'            => $lat,
                'time'           => strtotime($time),
                'o_addr'         => $o_addr,
                'o_house'        => $o_house,
                'o_contact'      => $o_contact,
                'o_mobile'       => $o_mobile,
                'o_lng'          => $o_lng,
                'o_lat'          => $o_lat,
                'o_time'         => strtotime($o_time),
                'intro'          => $intro,
                'photo'          => $photo,
                'voice'          => $voice,
                'paotui_amount'  => $paotui_amount,
                'danbao_amount'  => 0,
                'type'           => 'song',
                'staff_id'          => 0,
                'order_status'   => 0,
             );

            if($paotui_id = K::M('paotui/paotui')->create($datas)){
                K::M('paotui/log')->create(array('paotui_id'=>$paotui_id, 'log'=>L('订单已提交'), 'from'=>'member', 'type'=>1));
                $this->msgbox->add(L('SUCCESS'));
                $this->msgbox->set_data('data', array('paotui_id' => $paotui_id));
            }else{
                $this->msgbox->add(L('FAIL'), 229);
            }
        }   
    }

    public function song() 
    {
        $paotuiCfg = $this->system->config->get('paotui');
        $this->pagedata['ptCfg'] = $paotuiCfg;
        $this->tmpl = 'paotui/song.html';
    }
    
    // 跑腿-帮我买下单
    public function buy()
    {
        $config = K::M('system/config')->get('paotui');
        $this->pagedata['start_price'] = $config['start_price'];
        $this->pagedata['start_km'] = $config['start_km'];
        $this->pagedata['start_kg'] = $config['start_kg'];
        $this->pagedata['addkm_price'] = $config['addkm_price'];
        $this->pagedata['addkg_price'] = $config['addkg_price'];
        $this->tmpl = 'paotui/buy.html';
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
                $this->msgbox->add(L('SUCCESS'));
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
            $filter['status'] = 0;
            if($items = K::M('staff/staff')->items($filter,null,1,500,$count)){
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields('staff_id,lat,lng', $v);
                }
                $this->msgbox->add(L('SUCCESS'));
                $this->msgbox->set_data('data', array('items' => $items));
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
            $this->msgbox->add(L('SUCCESS'));
        }
    }
    
    
    //地图规划
    public function map($alng,$alat,$blng,$blat)
    {
        $this->tmpl = 'paotui/map.html'; 
    }
    
    
}