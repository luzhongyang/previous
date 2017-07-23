<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Login extends Ctl
{
    public function index($params)
    {
        $this->entry($params);
    }

    public function entry($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',213);
        }else if($staff = $this->auth->login($mobile, $passwd)){
            if(!$shop = K::M('cashier/cashier')->detail($staff['shop_id'])){
                $this->msgbox->add('店铺已经关闭', 214);
            }else if(false && empty($shop['audit'])){
                $this->msgbox->add('店铺审核中不可登录', 215);
            }else if(empty($staff['is_owner']) && empty($staff['audit'])){
                $this->msgbox->add('账号审核中不可登录', 215);
            }else{
                $staff = $this->filter_fields('staff_id,shop_id,name,mobile,face,is_owner,audit', $staff);
                $staff['token'] = $this->auth->token;
                $device_info = K::M('jpush/device')->init_device($staff['staff_id'], $params['register_id'], 'cashier', array('shop_'.$staff['shop_id']));
                $staff['tags']  = array_values($device_info['tags']);
                $staff['shop'] = array('title'=>$shop['title'], 'logo'=>$shop['logo'], 'phone'=>$shop['phone'], 'verify_name'=>$shop['verify_name']);
                $this->msgbox->set_data('data', $staff);
            }

        }
    }

    public function signup($params)
    {
            
        if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$sms_code = $params['sms_code']){
            $this->msgbox->add('手机验证码有误',213);
        }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
            $this->msgbox->add('短信验证码有误',213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',214);
        }/*else if(!$title = $params['title']){
            $this->msgbox->add('店铺名称不正确',215);
        }else if(!$contact = $params['contact']){
            $this->msgbox->add('联系人不能为空',215);
        }else if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add('店铺分类不正确',215);
        }else if(!$cate = K::M('shop/cate')->detail($cate_id)){
            $this->msgbox->add('店铺分类不正确',215);
        }*/else if($shop = K::M('shop/shop')->shop($mobile, 'mobile')){
            $this->msgbox->add('该手机号已经注册过',215);
        }else{
            $cate_id = $params['cate_id'] ? (int)$params['cate_id'] : 1;
            $title = $params['title'] ? $params['title'] : '我的店铺';
            $contact = $params['contact'] ? $params['contact'] : '--';
            $data = array('cate_id'=>$cate_id, 'mobile'=>$mobile, 'title'=>$title,'cate_id'=>$cate_id, 'contact'=>$contact,'phone'=>$mobile);
            $data['passwd'] = $passwd;
            if(!$city_id = (int)$params['city_id']){
                $city_id = CITY_ID;
            }
            $data['city_id'] = $city_id;
            if($shop_id = K::M('shop/shop')->create($data)){
                K::M('cashier/cashier')->create(array('shop_id'=>$shop_id, 'dateline'=>__TIME), true);
                $name = substr_replace($mobile, '***', 4, 4);
                $staff_data = array('shop_id'=>$shop_id, 'name'=>$name, 'mobile'=>$mobile, 'passwd'=>$passwd, 'is_owner'=>1, 'dataline'=>_TIME);
                if($staff_id = K::M('cashier/staff')->create($staff_data)){
                    if($staff = $this->auth->login($mobile, $passwd)){
                        $staff = $this->filter_fields('staff_id,shop_id,name,mobile,face,is_owner,audit', $staff);
                        $staff['token'] = $this->auth->token;
                        $device_info = K::M('jpush/device')->init_device($staff['staff_id'], $params['register_id'], 'cashier', array('shop_'.$staff['shop_id']));
                        $staff['tags']  = array_values($device_info['tags']);
                        $shop = K::M('cashier/cashier')->detail($shop_id);
                        $staff['shop'] = array('title'=>$shop['title'], 'logo'=>$shop['logo'], 'phone'=>$shop['phone'], 'verify_name'=>$shop['verify_name']);
                        $this->msgbox->set_data('data', $staff);
                    }else{
                        $this->msgbox->add('系统错误', 511);
                    }
                }
            }            
        }
        
    }

    public function forgot($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add('短信验证码有误',213);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add('新密码不正确',214);
        }else if(!$staff = K::M('cashier/staff')->mobile($mobile)){
            $this->msgbox->add('该手机号未注册过',215);
        }else if(K::M('cashier/staff')->update($staff['staff_id'], array('passwd'=>md5($new_passwd)))){
            $this->msgbox->set_data('data', array('staff_id'=>$staff['staff_id']));
        }else {
            $this->msgbox->add('找回密码失败',216);
        }  
    }

    public function loginout($params)
    {

    }
}
