<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Magic extends Ctl
{

    /*  发送短信 */
    public function sendsms()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            if($mobile = $this->checksubmit('mobile')){
                if(!$mobile = K::M('verify/check')->mobile('mobile')){
                    $this->msgbox->add('手机号不正确', 211);
                }else{
                    $code = rand(100000, 999999);
                    $session = K::M('system/session')->start();
                    $session->set('code_' . $mobile, $code, 900); /* 15分钟缓存 */
                    $smsdata = array('code' => $code);
                    if($img_code = $this->GP('img_code')){ /* 有发送图形验证码 */
                        if(!K::M('magic/verify')->check($img_code)){
                            $this->msgbox->add('图形验证码错误', 213);
                        }else if(K::M('sms/sms')->send($mobile, 'login', $smsdata)){
                            if(__DEBUG){
                                $this->msgbox->add('短信发送成功' . $code);
                            }else{
                                $this->msgbox->add('短信发送成功');
                            }
                        }
                    }else if(($log_count = K::M('sms/log')->count(array('mobile' => $mobile, 'dateline' => '>:' . (__TIME - 600)))) > 2){ 
                        //大于5次需要验证码
                        //$this->msgbox->add('需要验证发送');
                        $this->msgbox->set_data('data', array('sms_code' => 1));
                    }else if(K::M('sms/sms')->send($mobile, 'login', $smsdata)){
                        if(__DEBUG){
                           $this->msgbox->add('短信发送成功' . $code);
                        }else{
                           $this->msgbox->add('短信发送成功');
                        }
                    }
                }
            }
            $mobile = $this->GP('mobile');
            if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add('电话号码有误', 212);
            }
            else{
                $code = rand(100000, 999999);
                $session = K::M('system/session')->start();
                $session->set('code_' . $mobile, $code, 900); //15分钟缓存
                $smsdata = array('code' => $code);
                if(K::M('sms/sms')->send($mobile, 'login', $smsdata) || $code){
                    if(__DEBUG){
                        $this->msgbox->add('短信发送成功' . $code);
                    }
                    else{
                        $this->msgbox->add('短信发送成功');
                    }
                }
            }
        }
        else{
            $this->error(404);
        }
    }

    public function clearcookie()
    {
        $a = $this->cookie->get('UxLocation');
        $this->cookie->delete("UxLocation");
        $this->cookie->clear();
        $this->cookie->set('UxLocation', '{}');
        echo "<!doctype html><html><body>";
        echo "<pre>";
        print_r($a);
        print_r($_COOKIE);
        print_r($this->cookie->_COOKIE);
        //print_r($_SERVER);
        echo 'clear cookie success';
        echo "</pre>";
        echo "<script>localStorage={},localStorage.clear();</script></body></html>";
        exit();
    }

}
