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


    public function sendsms($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add(L('电话号码有误'),211);
        }else if(!$a = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('电话号码有误'),211);
        }else{
            $code = rand(100000,999999);
            $session =K::M('system/session')->start();
            $session->set('code_'.$params['mobile'], $code,900); //15分钟缓存
            $smsdata =  array('code'=>$code);
            //本地暂时模拟返回短信验证码
            if(K::M('sms/sms')->send($params['mobile'], 'login', $smsdata ,false,1)){
                if(__DEBUG){
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data',array('code'=>$code));
                }else{
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data','******');
                }
                $this->msgbox->set_data('data',array('code'=>$code));
            }
        }
    }

}
