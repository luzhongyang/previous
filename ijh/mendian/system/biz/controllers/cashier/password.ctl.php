<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/13
 * Time: 16:36
 */
class Ctl_Cashier_Password extends Ctl {

    public function step_one()
    {
         $this->tmpl ='biz/cashier/password/step_one.html';

    }

    public function step_two(){
        if($data= $this->checksubmit('data')){
            $session = K::M('system/session');
            $session->start();
            if((empty($data['mobile']))||(empty($data['yzm']))){
                $this->msgbox->add('手机号或验证码不能为空',214);
            }else if($data['yzm']!=$session->get('code_pass_'.$data['mobile'])){
                $this->msgbox->add('验证码错误！');
            }else if(!$shop = K::M('shop/shop')->find(array('mobile'=>$data['mobile']))){
                $this->msgbox->add('商户不存在',215);
            } else {
                $this->pagedata['shop_info'] = $shop;
                $this->tmpl = 'biz/cashier/password/step_two.html';
                
            }

        } else {
            $this->msgbox->add('手机号或验证码不能为空',213);
        }
        $this->msgbox->set_data('forward',$this->mklink('cashier/password:step_one',null,null,$this->request['url']));

    }

    public function step_three(){
        if($data = $this->checksubmit('data')){
            if(empty($data['passwd'])||empty($data['repasswd'])){
                $this->msgbox->add('密码不能为空',219);
            } else if(empty($data['shop_id'])){
                $this->msgbox->add('非法提交数据',218);
            } else if($data['passwd'] != $data['repasswd']){
                $this->msgbox->add('两次密码不一致');
            }else if(!$shop = K::M('shop/shop')->detail($data['shop_id'])){
                $this->msgbox->add('商户不存在',220);
            }else if (strlen($data['passwd'])< 5){
                $this->msgbox->add('密码长度不足5位',221);
            } else if($log_id = K::M('shop/shop')->update($data['shop_id'],array('passwd'=>md5($data['passwd'])))){
               $this->tmpl = 'biz/cashier/password/step_three.html';
               $this->output();
                
            } else {
                $this->msgbox->add('未知错误',222);
            }

        } else {
            $this->msgbox->add('非法提交数据',216);
        }
        $this->msgbox->set_data('forward',$this->mklink('cashier/password:step_one',null,null,$this->request['url']));
    }

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
                $session->set('code_pass_' . $mobile, $code, 900); //15分钟缓存
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