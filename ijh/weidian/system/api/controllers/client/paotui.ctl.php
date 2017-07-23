<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Paotui extends Ctl
{
   
    //地图
    public function map($params)
    {
        
        $items = $filter = array();

        if(!$params['SouthWlng'] || !$params['SouthWlat'] || !$params['NorthElng'] || !$params['NorthElat']){
            $this->msgbox->add('经度纬度不完整',211);
        }else{
            $filter['lat'] = $params['SouthWlat'].'~'.$params['NorthElat'];   //左下纬度和右上纬度
            $filter['lng'] = $params['SouthWlng'].'~'.$params['NorthElng'];   //左下经度和右上经度
            $filter['from'] = 'paotui';
            $filter['status'] = 1;
            if($items = K::M('staff/staff')->items($filter,null,1,50,$count)){
                $ii = 0;
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields('staff_id,lat,lng', $v);
                    $ii++;
                }

                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('items' => array_values($items),'counts'=>$ii));
            }else{
        
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('items' => array()));
            }
        }

    }


    // 帮我送下单
    public function song($params){
        $data = $data2 = $file = array();
        $this->check_login();
        if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写要求和描述',211);
        }else if(!$data['addr'] = $params['addr']){
            $this->msgbox->add('没有收货地址',213);
        }else if(!$data['house'] = $params['house']){
            $this->msgbox->add('没有收货门牌号',214);
        }else if(!$data['contact'] = $params['contact']){
            $this->msgbox->add('没有收货联系人',215);
        }else if(!$data['mobile'] = $params['mobile']){
            $this->msgbox->add('没有收货联系人手机号',216);
        }else if(!$data2['o_time'] = $params['o_time']){
            $this->msgbox->add('没有选择取货时间',217);
        }else if(!$data2['time'] = $params['time']){
            $this->msgbox->add('没有选择收货时间',217);
        }else if(!$data2['paotui_amount'] = $params['paotui_amount']){
            $this->msgbox->add('没有跑腿费用',218);
        }else if(!$data2['o_addr'] = $params['o_addr']){
            $this->msgbox->add('没有取货地址',219);
        }else if(!$data2['o_house'] = $params['o_house']){
            $this->msgbox->add('没有取货门牌号',220);
        }else if(!$data2['o_contact'] = $params['o_contact']){
            $this->msgbox->add('没有取货联系人',221);
        }else if(!$data2['o_mobile'] = $params['o_mobile']){
            $this->msgbox->add('没有取货联系人手机号',222);
        }else if(!$data['lat'] = $params['lat']){
            $this->msgbox->add('没有收货纬度',223);
        }else if(!$data['lng'] = $params['lng']){
            $this->msgbox->add('没有收货经度',224);
        }else if(!$data['o_lat'] = $params['o_lat']){
            $this->msgbox->add('没有取货纬度',225);
        }else if(!$data['o_lng'] = $params['o_lng']){
            $this->msgbox->add('没有取货经度',226);
        }else{
            $data['city_id'] = CITY_ID;
            
            $data['uid'] = $this->uid;
            $data['from'] = 'paotui';
            $data['order_from'] = strtolower(CLIENT_OS);

            if($params['xiaofei']){
                $data2['paotui_amount'] = $data2['paotui_amount'] + $params['xiaofei'];
            }
            
            $data['amount'] = $params['paotui_amount'];
            
            if($add = K::M('order/order')->create($data)){

                $data2['order_id'] = $add;
                $data2['type'] = 'song';
                $data2['danbao_amount'] = 0;

                if($attach = $_FILES['photo']){
                    if($a = K::M('magic/upload')->upload($attach)){
                        $photo_data = array(
                            'order_id' => $add,
                            'photo' => $a['photo']
                        );
                        $create_photo = K::M('order/photo') -> create($photo_data);
                    }
                }

                if($upvoice = $_FILES['voice']){
                    if($b = K::M('magic/upload')->file($upvoice)){
                        $voice_data = array(
                            'order_id' => $add,
                            'voice' => $b['photo'],
                            'voice_time' => $params['voice_time']
                        );
                        $create_photo = K::M('order/voice') -> create($voice_data);
                    }
                }

                if($add2 = K::M('paotui/order')->create($data2)){
                   K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                   $this->msgbox->add('success');
                   $this->msgbox->set_data('data', array('order_id' => $add));
                }else{
                    $this->msgbox->add('下单失败2!',231);
                }
            }else{
                $this->msgbox->add('下单失败!',230);
            }

        }

    }

    //帮我买下单
    public function buy($params)
    {
        $this->check_login();
        $data = $data2 = $file = array();
        if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写要求和描述',211);
        }else if(!$data['addr'] = $params['addr']){
            $this->msgbox->add('没有收货地址',213);
        }else if(!$data['house'] = $params['house']){
            $this->msgbox->add('没有收货门牌号',214);
        }else if(!$data['contact'] = $params['contact']){
            $this->msgbox->add('没有收货联系人',215);
        }else if(!$data['mobile'] = $params['mobile']){
            $this->msgbox->add('没有收货联系人手机号',216);
        }else if(!$data['lat'] = $params['lat']){
            $this->msgbox->add('没有收货纬度',217);
        }else if(!$data['lng'] = $params['lng']){
            $this->msgbox->add('没有收货经度',218);
        }else if(!$data2['time'] = $params['time']){
            $this->msgbox->add('没有选择收货时间',219);
        }else if(!$data2['paotui_amount'] = $params['paotui_amount']){
            $this->msgbox->add('没有跑腿费用',220);
        }else{
            $data['city_id'] = CITY_ID;
            $data['uid'] = $this->uid;
            $data['from'] = 'paotui';
            $data['order_from'] = strtolower(CLIENT_OS);
            if($params['o_addr']){
                $data2['o_addr'] = $params['o_addr'];
            }
            if($params['o_lat']){
                $data['o_lat'] = $params['o_lat'];
            }else{
                $data['o_lat'] = $params['lat'];
            }         
            if($params['o_lng']){
                $data['o_lng'] = $params['o_lng'];
            }else{
                $data['o_lng'] = $params['lng'];
            }
            if($params['xiaofei']){
                $data2['paotui_amount'] = $data2['paotui_amount'] + $params['xiaofei'];
            }
            $data2['danbao_amount'] = (float)$params['danbao_amount'];
            $data['amount'] = $params['paotui_amount'] + $data2['danbao_amount'];
            if($add = K::M('order/order')->create($data)){
                $data2['order_id'] = $add;
                $data2['type'] = 'buy';
                if($attach = $_FILES['photo']){
                    if($a = K::M('magic/upload')->upload($attach)){
                        $photo_data = array(
                            'order_id' => $add,
                            'photo' => $a['photo']
                        );
                        $create_photo = K::M('order/photo') -> create($photo_data);
                    }
                }
                if($upvoice = $_FILES['voice']){
                    if($b = K::M('magic/upload')->file($upvoice)){
                        $voice_data = array(
                            'order_id' => $add,
                            'voice' => $b['photo'],
                            'voice_time' => $params['voice_time']
                        );
                        $create_photo = K::M('order/voice') -> create($voice_data);
                    }
                }

                if($add2 = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                K::M('member/member')->update_count($this->uid, 'orders', 1);
                   $this->msgbox->add('success');
                   $this->msgbox->set_data('data', array('order_id' => $add));
                }else{
                    $this->msgbox->add('下单失败2!',231);
                }

            }else{
                $this->msgbox->add('下单失败!',230);
            }

        }
        
  
    }
    //占座
    public function seat($params)
    {
        $this->check_login();
        
        $data = $data2 = $file = array();
       
        if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写要求和描述',211);
        }else if(!$data['addr'] = $params['addr']){
            $this->msgbox->add('没有收货地址',213);
        }else if(!$data['house'] = $params['house']){
            $this->msgbox->add('没有收货门牌号',214);
        }else if(!$data['contact'] = $params['contact']){
            $this->msgbox->add('没有收货联系人',215);
        }else if(!$data['mobile'] = $params['mobile']){
            $this->msgbox->add('没有收货联系人手机号',216);
        }else if(!$data2['time'] = $params['time']){
            $this->msgbox->add('没有选择收货时间',217);
        }else if(!$data['lat'] = $params['lat']){
            $this->msgbox->add('没有收货纬度',218);
        }else if(!$data['lng'] = $params['lng']){
            $this->msgbox->add('没有收货经度',219);
        }else if(!$data2['paotui_amount'] = $params['paotui_amount']){
            $this->msgbox->add('没有跑腿费用',218);
        }else{

            $data['city_id'] = CITY_ID;
            $data['uid'] = $this->uid;
            $data['from'] = 'paotui';
            $data['amount'] = $params['paotui_amount'];
            $data['order_from'] = strtolower(CLIENT_OS);
            $data['o_lng'] = $data['lng'];
            $data['o_lat'] = $data['lat'];
            if($add = K::M('order/order')->create($data)){
                $data2['order_id'] = $add;
                $data2['type'] = 'seat';
                $data2['danbao_amount'] = 0;

                if($attach = $_FILES['photo']){
                    if($a = K::M('magic/upload')->upload($attach)){
                        $photo_data = array(
                            'order_id' => $add,
                            'photo' => $a['photo']
                        );
                        $create_photo = K::M('order/photo') -> create($photo_data);
                    }
                }
                
                if($upvoice = $_FILES['voice']){
                    if($b = K::M('magic/upload')->file($upvoice)){
                        $voice_data = array(
                            'order_id' => $add,
                            'voice' => $b['photo'],
                            'voice_time' => $params['voice_time']
                        );
                        $create_photo = K::M('order/voice') -> create($voice_data);
                    }
                }

                if($add2 = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                   $this->msgbox->add('success');
                   $this->msgbox->set_data('data', array('order_id' => $add));
                }else{
                   $this->msgbox->add('下单失败2!',231);
                }

            }else{
                $this->msgbox->add('下单失败!',230);
            }

        }
        
    }
    //排队
    public function paidui($params)
    {

        $data = $data2 = $file = array();
        $this->check_login();
        
        if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写要求和描述',211);
        }else if(!$data['addr'] = $params['addr']){
            $this->msgbox->add('没有收货地址',213);
        }else if(!$data['house'] = $params['house']){
            $this->msgbox->add('没有收货门牌号',214);
        }else if(!$data['contact'] = $params['contact']){
            $this->msgbox->add('没有收货联系人',215);
        }else if(!$data['mobile'] = $params['mobile']){
            $this->msgbox->add('没有收货联系人手机号',216);
        }else if(!$data2['time'] = $params['time']){
            $this->msgbox->add('没有选择收货时间',217);
        }else if(!$data['lat'] = $params['lat']){
            $this->msgbox->add('没有收货纬度',218);
        }else if(!$data['lng'] = $params['lng']){
            $this->msgbox->add('没有收货经度',219);
        }else if(!$data2['paotui_amount'] = $params['paotui_amount']){
            $this->msgbox->add('没有跑腿费用',218);
        }else{

            $data['city_id'] = CITY_ID;
            $data['uid'] = $this->uid;
            $data['from'] = 'paotui';
            $data['amount'] = $params['paotui_amount'];
            $data['order_from'] = strtolower(CLIENT_OS);
            $data['o_lng'] = $data['lng'];
            $data['o_lat'] = $data['lat'];            
            if($add = K::M('order/order')->create($data)){
                $data2['order_id'] = $add;
                $data2['type'] = 'paidui';
                $data2['danbao_amount'] = 0;

                if($attach = $_FILES['photo']){
                    if($a = K::M('magic/upload')->upload($attach)){
                        $photo_data = array(
                            'order_id' => $add,
                            'photo' => $a['photo']
                        );
                        $create_photo = K::M('order/photo') -> create($photo_data);
                    }
                }
                
                if($upvoice = $_FILES['voice']){
                        if($b = K::M('magic/upload')->file($upvoice)){
                            $voice_data = array(
                                'order_id' => $add,
                                'voice' => $b['photo'],
                                'voice_time' => $params['voice_time']
                            );
                            $create_photo = K::M('order/voice') -> create($voice_data);
                        }
                    }

                if($add2 = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id' => $add));
                }else{
                    $this->msgbox->add('下单失败2!',231);
                }

            }else{
                $this->msgbox->add('下单失败!',230);
            }

        }
        
    }
    //宠物
    public function chongwu($params)
    {
        $this->check_login();
        
        $data = $data2 = $file = array();

        if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写要求和描述',211);
        }else if(!$data['addr'] = $params['addr']){
            $this->msgbox->add('没有收货地址',213);
        }else if(!$data['house'] = $params['house']){
            $this->msgbox->add('没有收货门牌号',214);
        }else if(!$data['contact'] = $params['contact']){
            $this->msgbox->add('没有收货联系人',215);
        }else if(!$data['mobile'] = $params['mobile']){
            $this->msgbox->add('没有收货联系人手机号',216);
        }else if(!$data2['time'] = $params['time']){
            $this->msgbox->add('没有选择收货时间',217);
        }else if(!$data['lat'] = $params['lat']){
            $this->msgbox->add('没有收货纬度',218);
        }else if(!$data['lng'] = $params['lng']){
            $this->msgbox->add('没有收货经度',219);
        }else if(!$data2['paotui_amount'] = $params['paotui_amount']){
            $this->msgbox->add('没有跑腿费用',218);
        }else{
            
            $data['city_id'] = CITY_ID;
            $data['uid'] = $this->uid;
            $data['from'] = 'paotui';
            $data['amount'] = $params['paotui_amount'];
            $data['o_lng'] = $data['lng'];
            $data['o_lat'] = $data['lat'];
            if($add = K::M('order/order')->create($data)){
                $data2['order_id'] = $add;
                $data2['type'] = 'chongwu';
                $data2['danbao_amount'] = 0;
                $data['order_from'] = strtolower(CLIENT_OS);
                if($attach = $_FILES['photo']){
                    if($a = K::M('magic/upload')->upload($attach)){
                        $photo_data = array(
                            'order_id' => $add,
                            'photo' => $a['photo']
                        );
                        $create_photo = K::M('order/photo') -> create($photo_data);
                    }
                }
                
                if($upvoice = $_FILES['voice']){
                        if($b = K::M('magic/upload')->file($upvoice)){
                            $voice_data = array(
                                'order_id' => $add,
                                'voice' => $b['photo'],
                                'voice_time' => $params['voice_time']
                            );
                            $create_photo = K::M('order/voice') -> create($voice_data);
                        }
                    }

                if($add2 = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                   $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id' => $add));
                }else{
                    $this->msgbox->add('下单失败2!',231);
                }

            }else{
                $this->msgbox->add('下单失败!',230);
            }

        }
        
    }
    
    
    
    //其它
    public function other($params)
    {
        $this->check_login();
        
        $data = $data2 = $file = array();

        if(!$data['intro'] = $params['intro']){
            $this->msgbox->add('没有填写要求和描述',211);
        }else if(!$data['addr'] = $params['addr']){
            $this->msgbox->add('没有收货地址',213);
        }else if(!$data['house'] = $params['house']){
            $this->msgbox->add('没有收货门牌号',214);
        }else if(!$data['contact'] = $params['contact']){
            $this->msgbox->add('没有收货联系人',215);
        }else if(!$data['mobile'] = $params['mobile']){
            $this->msgbox->add('没有收货联系人手机号',216);
        }else if(!$data2['time'] = $params['time']){
            $this->msgbox->add('没有选择收货时间',217);
        }else if(!$data['lat'] = $params['lat']){
            $this->msgbox->add('没有收货纬度',218);
        }else if(!$data['lng'] = $params['lng']){
            $this->msgbox->add('没有收货经度',219);
        }else if(!$data2['paotui_amount'] = $params['paotui_amount']){
            $this->msgbox->add('没有跑腿费用',218);
        }else{

            $data['city_id'] = CITY_ID;
            $data['uid'] = $this->uid;
            $data['from'] = 'paotui';
            $data['amount'] = $params['paotui_amount'];
            $data['order_from'] = strtolower(CLIENT_OS);
            $data['o_lng'] = $data['lng'];
            $data['o_lat'] = $data['lat'];            
            if($add = K::M('order/order')->create($data)){
                $data2['order_id'] = $add;
                $data2['type'] = 'other';
                $data2['danbao_amount'] = 0;

                if($attach = $_FILES['photo']){
                    if($a = K::M('magic/upload')->upload($attach)){
                        $photo_data = array(
                            'order_id' => $add,
                            'photo' => $a['photo'],
                            
                        );
                        $create_photo = K::M('order/photo') -> create($photo_data);
                    }
                }
                
                if($upvoice = $_FILES['voice']){
                        if($b = K::M('magic/upload')->file($upvoice)){
                            $voice_data = array(
                                'order_id' => $add,
                                'voice' => $b['photo'],
                                'voice_time' => $params['voice_time']
                            );
                            $create_photo = K::M('order/voice') -> create($voice_data);
                        }
                    }

                if($add2 = K::M('paotui/order')->create($data2)){
                    K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                   $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id' => $add));
                }else{
                    $this->msgbox->add('下单失败2!',231);
                }

            }else{
                $this->msgbox->add('下单失败!',230);
            }

        }
        
    }
    
   
    //帮我买公式
    public function gongshi($params){
        $gongshi = K::M('paotui/cate')->find(array('type'=>$params['type']));
       
        if($gongshi){
            $gongshi['config'] = unserialize($gongshi['config']);
        }else{
            $gongshi = array('type'=>0);
        }
        
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',$gongshi);
    }


    public function preinfo($params)
    {
        
    }
   
}
