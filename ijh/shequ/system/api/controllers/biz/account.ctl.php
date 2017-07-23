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
    
    /* 服务端登录
     * @param $mobile,
     * @param $passwd
     * @return {shop_id,title,logo,mobile,money,token}
     */
    public function login($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',212);
        }else if($shop = K::M('shop/auth')->login($mobile, $passwd, 'mobile')){
            $shop = $this->filter_fields('shop_id,title,logo,contact,mobile,money', $shop);
            $shop['token'] = $this->auth->token;
            $device_info = K::M('jpush/device')->init_device($shop['shop_id'], $params['register_id'], 'shop');
            $shop['tags']  = array_values($device_info['tags']);
            $this->msgbox->set_data('data', $shop);
        }
    }
    
    //获取商户分类
    public function cate()
    {  
        if($cate = K::M('shop/cate')->tree()){            
            foreach($cate as $k =>$v){
                if($v['childrens']){
                    $cate[$k]['childrens'] = array_values($v['childrens']);
                }
            }
            $this->msgbox->set_data('data', array('cate'=>array_values($cate)));            
        }else{
            $this->msgbox->add('获取失败',300);
        }
    }
    
    /* 注册
     * @param $mobile 
     * @param $sms_code
     * @param $passwd
     * @param $contact
     * @param $title
     * @param $phone
     * @param $addr
     * @param $lng
     * @param $lat
     * @param $cate_id 
     * @param $city_id
     */
    public function signup($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$sms_code = $params['sms_code']){
            $this->msgbox->add('手机验证码有误',213);
        }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
            $this->msgbox->add('短信验证码有误',213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',214);
        }else if(!$contact = $params['contact']){
            $this->msgbox->add('联系人不正确',215);
        }else if(!$title = $params['title']){
            $this->msgbox->add('店铺名称不正确',215);
        }else if(!$phone = $params['phone']){
            $this->msgbox->add('客服电话不正确',215);
        }else if(!$addr = $params['addr']){
            $this->msgbox->add('店铺地址不正确',215);
        }else if(!$lng = $params['lng']){
            $this->msgbox->add('未定位坐标',215);
        }else if(!$lat = $params['lat']){
            $this->msgbox->add('未定位坐标',215);
        }else if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add('店铺分类不正确',215);
        }else if(!$cate = K::M('shop/cate')->detail($cate_id)){
            $this->msgbox->add('店铺分类不正确',215);
        }else if($shop = K::M('shop/shop')->shop($mobile, 'mobile')){
            $this->msgbox->add('该手机号已经注册过',215);
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
        }
    }
    
    /*忘记密码*/
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
            $this->msgbox->add('登录密码不正确',214);
        }else if(!$shop = K::M('shop/shop')->shop($mobile, 'mobile')){
            $this->msgbox->add('该手机号未注册过',215);
        }else if(K::M('shop/shop')->update($shop['shop_id'], array('passwd'=>$new_passwd))){
            $this->msgbox->add('成功');
        }else{
            $this->msgbox->add('失败',300);
        }
    }
    
    
    
    
    
   
    
}