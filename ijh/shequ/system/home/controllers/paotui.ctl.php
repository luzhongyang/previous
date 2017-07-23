<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}


class Ctl_Paotui extends Ctl {
    
    // 跑腿-首页
    public function index(){
        $cate = K::M('paotui/cate')->select();
        $this->pagedata['cate'] = $cate;
        $this->tmpl = 'paotui/index.html';
    }
 
    public function getstaffpoi(){
        $items = $filter = array();
        $SouthWlng = $this->GP('SouthWlng');  //左下经度
        $SouthWlat = $this->GP('SouthWlat'); //左下纬度
        $NorthElng = $this->GP('NorthElng'); //右上经度
        $NorthElat = $this->GP('NorthElat');  //右上纬度
        if(!$SouthWlng || !$SouthWlat || !$NorthElng || !$NorthElat){
            $this->msgbox->add('经度纬度不完整',211);
        }else{
            $filter['lat'] = $SouthWlat.'~'.$NorthElat;   //左下纬度和右上纬度
            $filter['lng'] = $SouthWlng.'~'.$NorthElng;   //左下经度和右上经度
            $filter['from'] = 'paotui';
            $filter['closed'] = 0;
            $filter['status'] = 1;
            $items = K::M('staff/staff')->items($filter,null,1,500);
            foreach ($items as $k=>$val){
                $items[$k] = $this->filter_fields('staff_id,lat,lng', $val);
            }
            $count = count($items);
            if(empty($items)){
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items' => $items,'count'=>$count));
            $this->msgbox->response();
        }
    }
    
    
    public function song(){
        
        if($this->checksubmit()){
            $data = $data2 = $file = array();
            $data = $_POST['data'];
            $data2 = $_POST['data2'];
            $file = $_FILES;
            $this->check_login();
            if(!$data['intro']){
                $this->msgbox->add('没有填写要求和描述',211);
            }else if(!$data['addr']){
                $this->msgbox->add('没有收货地址',213);
            }else if(!$data['house']){
                $this->msgbox->add('没有收货门牌号',214);
            }else if(!$data['contact']){
                $this->msgbox->add('没有收货联系人',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('没有收货联系人手机号',216);
            }else if(!$data2['o_time']){
                $this->msgbox->add('没有选择取货时间',217);
            }else if(!$data2['time']){
                $this->msgbox->add('没有选择收货时间',217);
            }else if(!$paotui_amount = $data2['paotui_amount']){
                $this->msgbox->add('没有跑腿费用',218);
            }else if(!$data2['o_addr']){
                $this->msgbox->add('没有取货地址',219);
            }else if(!$data2['o_house']){
                $this->msgbox->add('没有取货门牌号',220);
            }else if(!$data2['o_contact']){
                $this->msgbox->add('没有取货联系人',221);
            }else if(!$data2['o_mobile']){
                $this->msgbox->add('没有取货联系人手机号',222);
            }else{
                $data['uid'] = $this->uid;
                $data['from'] = 'paotui';
                $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
                $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');                  
                if($this->GP('xiaofei')){
                    $paotui_amount = $paotui_amount + $this->GP('xiaofei');
                }
                
                $data['amount'] = $data['total_price'] = $paotui_amount+$data2['danbao_amount'];
        
                if($add = K::M('order/order')->create($data)){
                    
                    $data2['order_id'] = $add;
                    $data2['type'] = 'song';

                    if($attach = $file['photo1']){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }

                    if($add2 = K::M('paotui/order')->create($data2)){
                       // 写入订单日志
                        K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                        // 更新用户订单量
                        K::M('member/member')->update_count($this->uid, 'orders', 1);
                        
                       $this->msgbox->add('下单成功!'); 
                       $this->msgbox->set_data('order_id', $add);
                    }else{
                        print_r($this->system->db->SQLLOG());die;
                        $this->msgbox->add('下单失败2!',231);
                    }
                    
                }else{
                    $this->msgbox->add('下单失败!',230);
                }
                
            }

        }else{
            $this->get_addr();
            $this->get_config('song');
            $this->tmpl = 'paotui/song.html';   
        }
    }
    
    public function buy(){
        
        if($this->checksubmit()){
            $data = $data2 = $file = array();
            $data = $_POST['data'];
            $data2 = $_POST['data2'];
            $file = $_FILES;
            $this->check_login();
            if(!$data['intro']){
                $this->msgbox->add('没有填写要求和描述',211);
            }else if(!$data['addr']){
                $this->msgbox->add('没有收货地址',213);
            }else if(!$data['house']){
                $this->msgbox->add('没有收货门牌号',214);
            }else if(!$data['contact']){
                $this->msgbox->add('没有收货联系人',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('没有收货联系人手机号',216);
            }else if(!$data2['time']){
                $this->msgbox->add('没有选择收货时间',217);
            }else if(!$paotui_amount = $data2['paotui_amount']){
                $this->msgbox->add('没有跑腿费用',218);
            }else{
                if(!$data['o_lat']){
                    $data['o_lat'] = $data['lat'];
                }
                if(!$data['o_lng']){
                    $data['o_lng'] = $data['lng'];
                }                
                $data['uid'] = $this->uid;
                $data['from'] = 'paotui';
                $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
                $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');  
                if($this->GP('xiaofei')){
                    $paotui_amount = $paotui_amount + $this->GP('xiaofei');
                }
                
                $data['amount'] = $data['total_price'] = $paotui_amount+$data2['danbao_amount'];
                
                if($add = K::M('order/order')->create($data)){
                    $data2['order_id'] = $add;
                    $data2['type'] = 'buy';
                    
                    
                    if($attach = $file['photo1']){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }

                    if($add2 = K::M('paotui/order')->create($data2)){
                       // 写入订单日志
                       K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                       // 更新用户订单量
                       K::M('member/member')->update_count($this->uid, 'orders', 1);
                       
                       $this->msgbox->add('下单成功!'); 
                       $this->msgbox->set_data('order_id', $add);
                    }else{
                        $this->msgbox->add('下单失败2!',231);
                    }
   
                }else{
                    $this->msgbox->add('下单失败!',230);
                }

            }

        }else{
            $this->get_addr();
            $this->get_config('buy');
            $this->tmpl = 'paotui/buy.html';
        }
        
    }
    
    public function paidui(){
        
        if($this->checksubmit()){
            $data = $data2 = $file = array();
            $data = $_POST['data'];
            $data2 = $_POST['data2'];
            $file = $_FILES;
            $this->check_login();


            if(!$data['intro']){
                $this->msgbox->add('没有填写要求和描述',211);
            }else if(!$data['addr']){
                $this->msgbox->add('没有收货地址',213);
            }else if(!$data['house']){
                $this->msgbox->add('没有收货门牌号',214);
            }else if(!$data['contact']){
                $this->msgbox->add('没有收货联系人',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('没有收货联系人手机号',216);
            }else if(!$data2['time']){
                $this->msgbox->add('没有选择收货时间',217);
            }else if(!$paotui_amount = $data2['paotui_amount']){
                $this->msgbox->add('没有跑腿费用',218);
            }else{
                $data['o_lat'] = $data['lat'];
                $data['o_lng'] = $data['lng'];
                $data['uid'] = $this->uid;
                $data['from'] = 'paotui';
                $data['amount'] = $paotui_amount;
                $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
                $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');                  
                if($add = K::M('order/order')->create($data)){
                    $data2['order_id'] = $add;
                    $data2['type'] = 'paidui';

                    if($attach = $file['photo1']){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }
                    if($add2 = K::M('paotui/order')->create($data2)){
                       // 写入订单日志
                       K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                       // 更新用户订单量
                       K::M('member/member')->update_count($this->uid, 'orders', 1);
                        
                       $this->msgbox->add('下单成功!'); 
                       $this->msgbox->set_data('order_id', $add);
                    }else{
                        $this->msgbox->add('下单失败2!',231);
                    }
   
                }else{
                    $this->msgbox->add('下单失败!',230);
                }
                
            }
            
        }else{
            $this->get_addr();
            $this->get_config('paidui');
            $this->tmpl = 'paotui/paidui.html'; 
        }
        
    }
    
    public function chongwu(){
        
        if($this->checksubmit()){
            $data = $data2 = $file = array();
            $data = $_POST['data'];
            $data2 = $_POST['data2'];
            $file = $_FILES;
            $this->check_login();

            if(!$data['intro']){
                $this->msgbox->add('没有填写要求和描述',211);
            }else if(!$data['addr']){
                $this->msgbox->add('没有收货地址',213);
            }else if(!$data['house']){
                $this->msgbox->add('没有收货门牌号',214);
            }else if(!$data['contact']){
                $this->msgbox->add('没有收货联系人',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('没有收货联系人手机号',216);
            }else if(!$data2['time']){
                $this->msgbox->add('没有选择收货时间',217);
            }else if(!$paotui_amount = $data2['paotui_amount']){
                $this->msgbox->add('没有跑腿费用',218);
            }else{
                $data['o_lat'] = $data['lat'];
                $data['o_lng'] = $data['lng'];                
                $data['uid'] = $this->uid;
                $data['from'] = 'paotui';
                $data['amount'] = $paotui_amount;
                $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
                $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');                  
                if($add = K::M('order/order')->create($data)){
                    $data2['order_id'] = $add;
                    $data2['type'] = 'chongwu';

                    if($attach = $file['photo1']){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }

                    if($add2 = K::M('paotui/order')->create($data2)){
                         // 写入订单日志
                       K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                       // 更新用户订单量
                       K::M('member/member')->update_count($this->uid, 'orders', 1);
                       
                       $this->msgbox->add('下单成功!'); 
                       $this->msgbox->set_data('order_id', $add);
                    }else{
                        $this->msgbox->add('下单失败2!',231);
                    }
   
                }else{
                    $this->msgbox->add('下单失败!',230);
                }
                
            }
            
        }else{
            $this->get_addr();
            $this->get_config('chongwu');
            $this->tmpl = 'paotui/chongwu.html'; 
        }
    }
    
    public function seat(){
        
        if($this->checksubmit()){
            $data = $data2 = $file = array();
            $data = $_POST['data'];
            $data2 = $_POST['data2'];
            $file = $_FILES;
            $this->check_login();

            if(!$data['intro']){
                $this->msgbox->add('没有填写要求和描述',211);
            }else if(!$data['addr']){
                $this->msgbox->add('没有收货地址',213);
            }else if(!$data['house']){
                $this->msgbox->add('没有收货门牌号',214);
            }else if(!$data['contact']){
                $this->msgbox->add('没有收货联系人',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('没有收货联系人手机号',216);
            }else if(!$data2['time']){
                $this->msgbox->add('没有选择收货时间',217);
            }else if(!$paotui_amount = $data2['paotui_amount']){
                $this->msgbox->add('没有跑腿费用',218);
            }else{
                $data['o_lat'] = $data['lat'];
                $data['o_lng'] = $data['lng'];                
                $data['uid'] = $this->uid;
                $data['from'] = 'paotui';
                $data['amount'] = $paotui_amount;
               $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
               $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');                
                if($add = K::M('order/order')->create($data)){
                    $data2['order_id'] = $add;
                    $data2['type'] = 'seat';

                    if($attach = $file['photo1']){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }

                    if($add2 = K::M('paotui/order')->create($data2)){
                         // 写入订单日志
                       K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                       // 更新用户订单量
                       K::M('member/member')->update_count($this->uid, 'orders', 1);
                       
                       $this->msgbox->add('下单成功!'); 
                       $this->msgbox->set_data('order_id', $add);
                    }else{
                        $this->msgbox->add('下单失败2!',231);
                    }
   
                }else{
                    $this->msgbox->add('下单失败!',230);
                }
                
            }
            
        }else{
            
            $this->get_addr();
            $this->get_config('seat');
            $this->tmpl = 'paotui/seat.html';
            
        }
    }
    
    
    public function other(){
        
        if($this->checksubmit()){
            $data = $data2 = $file = array();
            $data = $_POST['data'];
            $data2 = $_POST['data2'];
            $file = $_FILES;
            $this->check_login();

            if(!$data['intro']){
                $this->msgbox->add('没有填写要求和描述',211);
            }else if(!$data['addr']){
                $this->msgbox->add('没有收货地址',213);
            }else if(!$data['house']){
                $this->msgbox->add('没有收货门牌号',214);
            }else if(!$data['contact']){
                $this->msgbox->add('没有收货联系人',215);
            }else if(!$data['mobile']){
                $this->msgbox->add('没有收货联系人手机号',216);
            }else if(!$data2['time']){
                $this->msgbox->add('没有选择收货时间',217);
            }else if(!$paotui_amount = $data2['paotui_amount']){
                $this->msgbox->add('没有跑腿费用',218);
            }else{
                $data['o_lat'] = $data['lat'];
                $data['o_lng'] = $data['lng'];                
                $data['uid'] = $this->uid;
                $data['from'] = 'paotui';
                $data['amount'] = $paotui_amount;
                $data['order_from'] = (defined('IN_WEIXIN') ? 'weixin' : 'wap');
                $data['wx_openid'] = (defined('WX_OPENID') ? WX_OPENID : '');                
                if($add = K::M('order/order')->create($data)){
                    $data2['order_id'] = $add;
                    $data2['type'] = 'other';

                    if($attach = $file['photo1']){
                        if($a = K::M('magic/upload')->upload($attach)){
                            $photo_data = array(
                                'order_id' => $add,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('order/photo') -> create($photo_data);
                        }
                    }

                    if($add2 = K::M('paotui/order')->create($data2)){
                         // 写入订单日志
                       K::M('order/log')->create(array('order_id'=>$add,'from'=>'member','log'=>'订单已提交','status'=>1));
                       // 更新用户订单量
                       K::M('member/member')->update_count($this->uid, 'orders', 1);
                       
                       $this->msgbox->add('下单成功!');
                       $this->msgbox->set_data('order_id', $add); 
                    }else{
                        $this->msgbox->add('下单失败2!',231);
                    }
   
                }else{
                    $this->msgbox->add('下单失败!',230);
                }
                
            }
            
        }else{
            
            $this->get_addr();
            $this->get_config('other');
            $this->tmpl = 'paotui/other.html';
            
        }
    }
    
    private function get_config($type){
        $config = K::M('paotui/cate')->find(array('type'=>$type));
        $config['config'] = unserialize($config['config']);
        $this->pagedata['config'] = $config;
    }

    private function get_addr(){
        
     if($this->GP('addr_id') && $this->GP('addr') && $this->GP('house') && $this->GP('contact') && $this->GP('mobile') && $this->GP('lat') && $this->GP('lng')){
            $address = array(
                'addr'=>$this->GP('addr'),
                'house'=>$this->GP('house'),
                'contact'=>$this->GP('contact'),
                'mobile'=>$this->GP('mobile'),
                'addr_id'=>$this->GP('addr_id'),
                'lat'=>$this->GP('lat'),
                'lng'=>$this->GP('lng')
            );
            $this->pagedata['address'] = $address;
        }
        
        if($this->GP('o_addr') && $this->GP('o_lat') && $this->GP('o_lng')){
            $o_address = array(
                'addr'=>$this->GP('o_addr'),
                'lat'=>$this->GP('o_lat'),
                'lng'=>$this->GP('o_lng')
            );
            $this->pagedata['o_address'] = $o_address;
        }

    }


    public function staff_detail($staff_id){  //服务人员详情
      
        if(!$staff_id){
            $this->msgbox->add('错误的服务人员',211);
        }else if(!$detail = K::M('staff/staff')->detail($staff_id)){
            $this->msgbox->add('错误的服务人员',211);
        }else if($detail['from'] != 'paotui'){
            $this->msgbox->add('该服务人员不是跑腿服务人员',212);
        }else{
            //评价
            $comments = K::M('staff/comment')->select(array('staff_id'=>$detail['staff_id']));
            $commentsa = $commentsb = $commentsc = array();

            $i = $a = $b = $c = 0;
             foreach($comments as $kk => $vv){
                $u = K::M('member/member')->detail($vv['uid']);
                echo $u['nickname'];
                $comments[$kk]['staff_name'] = $u['nickname'];
             }

            foreach($comments as $kk => $vv){
                if($vv['score'] > 3){
                    $commentsa[] = $vv;
                    $a = $a + 1;
                }else if($vv['score'] == 3){
                    $commentsb[] = $vv;
                    $b = $b + 1;
                }else if($vv['score'] < 3){
                    $commentsc[] = $vv;
                    $c = $c + 1;
                }
                $i=$i+1;
            }

            $count = array(
                'i'=>$i,
                'a'=>$a,
                'b'=>$b,
                'c'=>$c
            );

            $this->pagedata['comments'] = $comments;
            $this->pagedata['commentsa'] = $commentsa;
            $this->pagedata['commentsb'] = $commentsb;
            $this->pagedata['commentsc'] = $commentsc;
            $this->pagedata['count'] = $count;

            $this->pagedata['detail']= $detail;
            $this->tmpl = 'paotui/staff_detail.html';
        }
    }

}