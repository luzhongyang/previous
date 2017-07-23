<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Bind extends Ctl_Card
{
    public function index()
    {
        $this->pagedata['shop'] = K::M('shop/shop')->detail(SHOP_ID);
        $this->pagedata['card'] = $this->card;
        $this->tmpl = 'shop/card/bind/index.html';
    }

    public function bind()
    {
        $this->tmpl = 'shop/card/bind/bind.html';
    }

    public function binding() //绑定操作
    {
        $session =K::M('system/session')->start();
        if(!$mobile = $this->GP('mobile')){
            $this->msgbox->add('手机号没有填写', 211);
        }
        else if(!K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add('手机号有误', 212);
        }
        else if(!$code = $this->GP('code')){
            $this->msgbox->add('手机验证码错误', 213);
        }
        else if($code != $session->get('code_' . $mobile)){
            $this->msgbox->add('手机验证码错误或已过期', 214);
        }else{
            ///$my_card = K::M('card/card')->find(array('shop_id' => SHOP_ID, 'uid' => $this->uid));
            if(!$card = K::M('card/card')->find(array('shop_id' => SHOP_ID, 'mobile' => $mobile))){
                $this->msgbox->add('激活失败，会员卡不存在，请联系商户', 215);
            }else if(!empty($card['wx_openid'])){
                $this->msgbox->add('该卡已经被激活过了！', 216);
            }else if(!K::M('card/card')->update($card['card_id'],array('uid'=>$this->uid,'wx_openid'=>$this->wx_openid))){
                $this->msgbox->add('激活失败，未知错误', 217);
            }else{
                $this->msgbox->add('激活成功!');
            }
        }
    }

    /*  发送短信 */

    public function sendsms()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
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

}
