<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Magic extends Ctl
{
    /* 发送短信,array('mobile'=>'') */
    public function sendsms($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add('电话号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('电话号码有误',212);
        }else{
            $code = rand(100000,999999);
            $session =K::M('system/session')->start();
            $session->set('code_'.$mobile, $code,900); //15分钟缓存
            $smsdata =  array('code'=>$code);
            if($img_code = $params['img_code']){ //有发送图形验证码
                if(!K::M('magic/verify')->check($img_code,$params['mobile'])){
                    $this->msgbox->add('图形验证码错误', 213);
                }else if(true || K::M('sms/sms')->send($mobile, 'login', $smsdata)){
                    if(__DEBUG){
                        $this->msgbox->add('success');
                        $this->msgbox->set_data('data', array('code'=>$code, 'sms_code'=>0));
                    }else{
                        $this->msgbox->add('success');
                        $this->msgbox->set_data('data',  array('code'=>'******', 'sms_code'=>0));
                    }                    
                }
            }else if(true || ($log_count = K::M('sms/log')->count(array('mobile'=>$mobile, 'dateline'=>'>:'.(__TIME-600)))) > 2){ //大于5次需要验证码
                 $this->msgbox->set_data('data',array('code'=>'******', 'sms_code'=>1));
            }else if(true || K::M('sms/sms')->send($mobile, 'login', $smsdata)){
                if(__DEBUG){
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('code'=>$code, 'sms_code'=>0));
                }else{
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data',  array('code'=>'******', 'sms_code'=>0));
                }
            }            
        }
    }
    
    public function verify()
    {
        $mobile = $this->GP('mobile');
        K::M('magic/verify')->output($mobile);

    }

    public function citycode($params)
    {
        if($code = $params['code']){
            if($city = K::M('data/city')->city_by_code($code)){
                $data = $this->filter_fields('city_id,city_name,province_id,province_name,city_code', $city);
            }
        }
        if(empty($data)){
            $this->msgbox->add('城市暂未开通', 211);
        }else{
            $this->msgbox->set_data('data', $data);
        }
    }
}
