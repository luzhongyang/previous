<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Account extends Ctl
{
    
    public function login($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add(L('登录密码不正确'),212);
        }else if($shop = K::M('shop/auth')->login($mobile, $passwd, 'mobile')){
            $shop = $this->filter_fields('shop_id,title,logo,mobile,money', $shop);
            $shop['token'] = $this->auth->token;
            if($a = K::M('rongcloud/rongcloud')->init_token('B'.$shop['shop_id'], $shop['title'], $shop['logo'])){
                $shop['rongcloud'] = $a;
            }else{
                $shop['rongcloud'] = array('uuid'=>'B'.$shop['shop_id'], 'token'=>'','appkey'=>'');
            }
            $this->msgbox->set_data('data', $shop);
        }
    }

    public function signup($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if(!$sms_code = $params['sms_code']){
            $this->msgbox->add(L('短信验证码不能为空'),213);
        }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add(L('登录密码不能为空'),214);
        }else if(!$contact = $params['contact']){
            $this->msgbox->add(L('联系人不能为空'),215);
        }else if(!$title = $params['title']){
            $this->msgbox->add(L('店铺名称不能为空'),215);
        }else if(!$phone = $params['phone']){
            $this->msgbox->add(L('客服电话不能为空'),215);
        }else if(!$addr = $params['addr']){
            $this->msgbox->add(L('店铺地址不能为空'),215);
        }else if(!$lng = $params['lng']){
            $this->msgbox->add(L('未定位坐标'),215);
        }else if(!$lat = $params['lat']){
            $this->msgbox->add(L('未定位坐标'),215);
        }else if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add(L('店铺分类不存在'),215);
        }else if(!$cate = K::M('shop/cate')->detail($cate_id)){
            $this->msgbox->add(L('店铺分类不存在'),215);
        }else if($shop = K::M('shop/shop')->shop($mobile, 'mobile')){
            $this->msgbox->add(L('该手机号已经注册过'),215);
        }else{
            $data = array('cate_id'=>$cate_id, 'contact'=>$contact, 'mobile'=>$mobile, 'title'=>$title, 'phone'=>$phone, 'addr'=>$addr, 'lng'=>$lng, 'lat'=>$lat);
            $data['passwd'] = $passwd;
            if(!$city_id = (int)$params['city_id']){
                $city_id = CITY_ID;
            }
            $data['city_id'] = $city_id;
            if($shop_id = K::M('shop/shop')->create($data)){
                $this->msgbox->set_data('data', array('shop_id'=>$shop_id));
                $this->msgbox->add('success');
            }
            K::M('system/logs')->log('sql.biz.account.signup', $this->system->db->SQLLOG());
        }
    }

    public function forgot($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add(L('登录密码不正确'),214);
        }else if(!$shop = K::M('shop/shop')->shop($mobile, 'mobile')){
            $this->msgbox->add(L('该手机号未注册过'),215);
        }else if(K::M('shop/shop')->update($shop['shop_id'], array('passwd'=>$new_passwd))){
            $this->msgbox->set_data('data', array('shop_id'=>$shop['shop_id']));
        }
    }
}