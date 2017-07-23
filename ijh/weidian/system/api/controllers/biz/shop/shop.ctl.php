<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop_Shop extends Ctl_Biz
{
    
    public function info()
    {
        //订单，资金信息
        $shop = $this->shop;
        unset($shop['passwd']);
        $sdaytime = $this->system->sdaytime;
        $shop['today_order'] = K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'lasttime'=>'>:'.$sdaytime, 'order_status'=>'8'));
        $today_amount = K::M('shop/log')->count_money(array('shop_id'=>$this->shop_id, 'dateline'=>'>:'.$sdaytime, 'money'=>'>:0'));
        if($today_amount){
            $shop['today_amount'] = $today_amount;
        }else{
            $shop['today_amount'] = 0;
        }
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
        $shop['verify'] = $verify;
        if(!$msg = K::M('shop/msg')->count(array('shop_id'=>$this->shop_id,'is_read'=>0))){
            $msg = 0;
        }
        $shop['msg'] = $msg;
        if(!$waimai = K::M('waimai/waimai')->detail($this->shop_id)){
            $shop['waimai'] = array('shop_id'=>0, 'yy_status'=>0, 'yy_stime'=>0, 'yy_ltime'=>0, 'yy_xiuxi'=>0, 'audit'=>0);
            $shop['waimai_open'] = 0;
        }else{
            $shop['waimai'] = $this->filter_fields('shop_id,yy_status,yy_stime,yy_ltime,yy_xiuxi,audit',$waimai);
            $shop['waimai_open'] = 1;
        }

        $this->msgbox->set_data('data', $shop);
        $this->msgbox->add('success');
    }
    
    /*团购、代金券记录*/
    public function tuan_log($params)
    {
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter['shop_id'] = $this->shop_id;
        $filter['status'] = 1; //仅显示已经核销的券
        if($items = K::M('tuan/ticket')->items($filter, array('ticket_id'=>'DESC'), $page, $limit, $count)){
            $tuan_ids = array();
            foreach($items as $k => $v){
                $tuan_ids[$v['tuan_id']] = $v['tuan_id'];
                $v['title'] = '';
                $v['price'] = '';
                $items[$k] = $v;
            }
            if($tuan_list = K::M('tuan/tuan')->items_by_ids($tuan_ids)){
                foreach($items as $kk => $vv){
                    $items[$kk]['title'] = $tuan_list[$vv['tuan_id']]['title'];
                    $items[$kk]['price'] = $tuan_list[$vv['tuan_id']]['price'];
                }
            }

        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        $this->msgbox->add('success');
    }
    
    /*买单记录*/
    public function maidan_log($params)
    {
        $filter = $items = array();
        $page = max((int)$params['page'], 1);
        $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'maidan';
        $filter['pay_status'] = 1; //仅显示已经付款成功的买单记录
        if($order_list = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            foreach($order_list as $k=>$v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($maidan_list = K::M('maidan/order')->items_by_ids($order_ids)){                
                foreach($maidan_list as $k=>$v){
                    if($row = $order_list[$v['order_id']]){
                        $row = $this->filter_fields('order_id,dateline,contact,mobile,total_price,amount', $row);
                    }
                    $row['unyouhui'] = $v['unyouhui'];
                    $row['maidan_amount'] = $v['maidan_amount'];
                    $row['reply'] = 0;
                    $row['comment'] = 0;
                    $items[$k] = $row;
                }
                if($comment_list = K::M('shop/comment')->items(array('order_id'=>$order_ids))){
                    foreach($comment_list as $k=>$v){
                        if($row = $items[$v['order_id']]){
                            $row['comment'] = 1;
                            if($v['reply']){
                                $row['reply'] = 1;
                            }
                            $items[$v['order_id']] = $row;
                        }
                    }
                }
                krsort($items);
            }
        }
        $this->msgbox->set_data('data',array('items'=>array_values($items), 'total_count'=>$count));
    }
    
    
    /*买单详情*/
    public function maidan_detail($params){
        if(!$order_id = $params['order_id']){
            $this->msgbox->add('订单号错误',211)->response();
        }else if(!$order = K::M('maidan/order')->detail($order_id)){
            $this->msgbox->add('订单号不存在',212)->response();
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',213)->response();
        }else{
            $order = $this->filter_fields('order_id,dateline,pay_time,contact,mobile,total_price,amount,maidan_amount,unyouhui', $order);
            if($shop_comment = K::M('shop/comment')->find(array('order_id'=>$order_id))){
                if($photo = K::M('shop/commentphoto')->items(array('comment_id'=>$shop_comment['comment_id']))){
                    $shop_comment['photo'] = array_values($photo);
                }
                $order['comment'] = $shop_comment;
                $member = K::M('member/member')->detail($shop_comment['uid']);
                $member = $this->filter_fields('nickname,mobile,face',$member);
                $order['comment']['member'] = $member;
            }
        }
        $this->msgbox->set_data('data', array('order'=>$order));
        $this->msgbox->add('success');
    }
    
    /*修改密码*/
    public function updatepasswd($params){
        $session = K::M('system/session')->start();
        if(!$params['sms_code']){
            $this->msgbox->add('没有短信验证码',213);
        }else if($session->get('code_'.$this->shop['mobile']) != $params['sms_code']){
            $this->msgbox->add('短信验证码有误',213);
        }else if(!$passwd = $params['new_passwd']){
            $this->msgbox->add('新密码没有填写',214);
        }else if($update = K::M('shop/shop')->update($this->shop['shop_id'],array('passwd'=>md5($passwd)))){
            $this->msgbox->add('修改密码成功');
        }else{
            $this->msgbox->add('修改失败',300);
        }
    }
    
    /*修改手机*/
    public function updatemobile($params){
        $session = K::M('system/session')->start();
        if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码没有填写',213);
        }else if(!$new_mobile = $params['new_mobile']){
            $this->msgbox->add('新手机号没有填写',214);
        }else if($session->get('code_'.$new_mobile) != $params['sms_code']){
            $this->msgbox->add('短信验证码有误',213);
        }else if($update = K::M('shop/shop')->update($this->shop['shop_id'],array('mobile'=>$new_mobile))){
            $this->msgbox->add('修改手机号码成功');
        }else{
            $this->msgbox->add('修改失败',300);
        }
    }
    
    
    /*设置用户名*/
    public function updatecontact($params){
        if(!$contact = $params['contact']){
            $this->msgbox->add('用户名没有填写',213);
        }else if(strlen($contact) > 16 || strlen($contact) < 4){
            $this->msgbox->add('用户名长度不正确',214);
        }else if($update = K::M('shop/shop')->update($this->shop['shop_id'],array('contact'=>$contact))){
            $this->msgbox->add('设置成功');
        }else{
            $this->msgbox->add('设置失败',300);
        }
    }
    
    
    
    // 店主身份认证
    public function dianzhu($params)
    {
        $row = K::M('shop/verify')->detail($this->shop_id);
        if($row['verify'] == 1 || $row['verify_dianzhu'] == 1){
            $this->msgbox->add('店主已经验证过了', 211);
        }else if(!$id_name = $params['id_name']){
            $this->msgbox->add('真实姓名不正确', 213);
        }else if(!$id_number = K::M('verify/check')->id_number($params['id_number'])){
            $this->msgbox->add('身份证号码不正确', 213);
        }else if((!($attach_id_photo = $_FILES['id_photo']) || $attach_id_photo['error']) && !$row['shop_id']){
            $this->msgbox->add('身份证图片不正确', 214);
        }else if((!($attach_shop_photo = $_FILES['shop_photo']) || $attach_shop_photo['error']) && !$row['shop_id']){
            $this->msgbox->add('店铺实景图片不正确', 214);
        }else{
            $data = array('id_name'=>$id_name, 'id_number'=>$id_number, 'verify_dianzhu'=>0);
            if($attach_id_photo && ($a = K::M('magic/upload')->upload($attach_id_photo))){
                $data['id_photo'] = $a['photo'];
            }
            if($attach_shop_photo && ($b = K::M('magic/upload')->upload($attach_shop_photo))){
                $data['shop_photo'] = $b['photo'];
            }
            if($row['shop_id']){
                $ret = K::M('shop/verify')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/verify')->create($data);
            }
            $this->msgbox->add('success');
        }
    }
    
 
    // 营业执照认证
    public function yyzy($params)
    {
        $row = K::M('shop/verify')->detail($this->shop_id);
        if($row['verify'] == 1 || $row['verify_yyzz'] == 1){
            $this->msgbox->add('营业执照已经验证过了', 211);
        }else if(!$company_name = $params['company_name']){
            $this->msgbox->add('公司名称不正确', 213);
        }else if(!$yz_number = $params['yz_number']){
            $this->msgbox->add('营业执照不正确', 213);
        }else if((!($attach_yz_photo = $_FILES['yz_photo']) || $attach_yz_photo['error']) && !$row['shop_id']){
            $this->msgbox->add('营业执照图片不正确', 214);
        }else{
            $data = array('yz_number'=>$yz_number,'company_name'=>$company_name, 'verify_yyzz'=>0);
            if($attach_yz_photo && ($a = K::M('magic/upload')->upload($attach_yz_photo))){
                $data['yz_photo'] = $a['photo'];
            }
            if($row['shop_id']){
                K::M('shop/verify')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/verify')->create($data);
            }
            $this->msgbox->add('success');
        }
    }
    
    
    // 餐饮许可证认证
    public function cyzy($params)
    {
        $row = K::M('shop/verify')->detail($this->shop_id);
        if($row['verify'] == 1 || $row['verify_cy'] == 1){
            $this->msgbox->add('餐饮许可证已经验证过了', 211);
        }else if(!$cy_number = $params['cy_number']){
            $this->msgbox->add('餐饮许可证不正确', 213);
        }else if((!($attach_cy_photo = $_FILES['cy_photo']) || $attach_cy_photo['error']) && !$row['shop_id']){
            $this->msgbox->add('餐饮许可证图片不正确', 214);
        }else{
            $data = array('cy_number'=>$cy_number, 'verify_yyzz'=>0);
            if($attach_cy_photo && ($a = K::M('magic/upload')->upload($attach_cy_photo))){
                $data['cy_photo'] = $a['photo'];
            }
            if($row['shop_id']){
                $ret = K::M('shop/verify')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/verify')->create($data);
            }
            $this->msgbox->add('success');
        }
    }

    
    /*店铺基本资料*/
    public function base($params)
    {
        if(!$data = $this->check_fields($params, 'title,contact,mobile,phone,banner,intro,cate_id,,addr,lng,lat')){
            $this->msgbox->add('非法的数据提交');
        }else{
            if(($attach = $_FILES['logo']) && ($attach['error'] == UPLOAD_ERR_OK)){
                if($a = K::M('magic/upload')->upload($attach, 'shop')){
                    $data['logo'] = $a['photo'];
                }
            }
            if(($attach = $_FILES['banner']) && ($attach['error'] == UPLOAD_ERR_OK)){
                if($a = K::M('magic/upload')->upload($attach, 'shop')){
                    $data['banner'] = $a['photo'];
                }
            }
            if(K::M('shop/shop')->update($this->shop_id, $data)){
                $a = array();
                if(isset($data['lat']) && isset($data['lng'])){
                    $a = array('lat'=>$data['lat'], 'lng'=>$data['lng']);
                }
                if(isset($data['addr'])){
                    $a['addr'] = $data['addr'];
                }
                if($a){
                    K::M('waimai/waimai')->update($this->shop_id, $a);
                }
                $this->msgbox->add('success');
            }
        }
    }

    /*店铺基本资料 -公告设置*/
    public function set_info($params)
    {
        if(!$info = $params['info']){
            $info = '';
        }
        if(K::M('shop/shop')->update($this->shop_id, array('info'=>$info))){
            $this->msgbox->add('success');
        }
    }
    
    /*开户行列表获取*/
    public function bank_list(){
        $this->msgbox->set_data('data', array('bank_list'=>K::M('data/data')->bank_list()));
        $this->msgbox->add('success');
    }
    
    public function my_bank()
    {
        if(!$my_bank = K::M('shop/account')->detail($this->shop_id)){
            $my_bank = array('shop_id'=>$this->shop_id);
        }
        $this->msgbox->set_data('data', array('my_bank'=>$my_bank));
        $this->msgbox->add('success');
    }
    
    /*开户行设置*/
    public function account($params)
    {
        $account = K::M('shop/account')->detail($this->shop_id);
        if(!$account_type = $params['account_type']){
            $this->msgbox->add('开户行不正确', 211);
        }else if(!$account_name = $params['account_name']){
            $this->msgbox->add('真实姓名不正确', 212);
        }else if(!$account_number = $params['account_number']){
            $this->msgbox->add('提现帐号不正确', 212);
        }else{
            $data = array('account_name'=>$account_name, 'account_type'=>$account_type, 'account_number'=>$account_number);
            if($account){
                $ret = K::M('shop/account')->update($this->shop_id, $data);
            }else{
                $data['shop_id'] = $this->shop_id;
                $ret = K::M('shop/account')->create($data);
            }
            if($ret){
                $this->msgbox->add('success');
            }
        }
    }
    
    /*外卖营业状态设置*/
    public function waimai_yingye($params)
    {
 
        if(!in_array($params['yy_status'],array(0,1,2))){
            $this->msgbox->add('营业状态不正确', 212);
        }else{
            $data['yy_status'] = $params['yy_status'];
        }

        if(preg_match('/^\d{1,2}\:\d{2}$/i', $params['ltime'])){
            $data['yy_ltime'] = $params['ltime'];
        }
        if(preg_match('/^\d{1,2}\:\d{2}$/i', $params['stime'])){
            $data['yy_stime'] = $params['stime'];
        }
        
        if($data && K::M('waimai/waimai')->update($this->shop_id, $data)){
            $this->msgbox->add('success');
        }
        
    }

    public function open($params)
    {
        if(!$data = $this->check_fields($params, 'have_tuan,have_quan,have_maidan,have_waimai,have_paidui,have_dingzuo,have_diancan')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            if(isset($data['have_tuan'])){
                $data['have_tuan'] = $data['have_tuan'] ? 1 : 0;
            }
            if(isset($data['have_quan'])){
                $data['have_quan'] = $data['have_quan'] ? 1 : 0;
            }
            if(isset($data['have_maidan'])){
                $data['have_maidan'] = $data['have_maidan'] ? 1 : 0;
            }
            if(isset($data['have_waimai'])){
                $data['have_waimai'] = $data['have_waimai'] ? 1 : 0;
            }
            if(isset($data['have_paidui'])){
                $data['have_paidui'] = $data['have_paidui'] ? 1 : 0;
            }
            if(isset($data['have_dingzuo'])){
                $data['have_dingzuo'] = $data['have_dingzuo'] ? 1 : 0;
            }
            if(isset($data['have_diancan'])){
                $data['have_diancan'] = $data['have_diancan'] ? 1 : 0;
            }
            if(K::M('shop/shop')->update($this->shop_id, $data)){
                $this->msgbox->add('设置成功');
            }
        }
    }   
    
    
}