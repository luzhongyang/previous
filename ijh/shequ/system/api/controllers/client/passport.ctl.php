<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Passport extends Ctl
{

    /* 注册
     * $mobile,必填
     * $sms_code,必填
     * $passwd,必填
     * $register_id
     */
    public function signup($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$sms_code = $params['sms_code']){
            $this->msgbox->add('短信验证码有误',213);
        }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
            $this->msgbox->add('短信验证码有误',213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',214);
        }else if($member = K::M('member/member')->member($mobile, 'mobile')){
            $this->msgbox->add('该手机号已经注册',215);
        }else{
            $data = array('mobile'=>$mobile, 'passwd'=>$passwd);
            $data['paypasswd'] = $passwd;
            $data['nickname'] = substr($mobile,0,3).'****'.substr($mobile,-4);;
            if($pmid = preg_match('/^(M|P|D|S)\d+/i', $params['pmid'])){
                $data['pmid'] = $pmid;
            }
            if($uid = K::M('member/account')->create($data)){
                if($this->system->auth->manager($uid)){
                    $member = $this->filter_fields('uid,nickname,face,mobile', $this->auth->member);
                    $device_info = K::M('jpush/device')->init_device($member['uid'], $params['register_id'], 'member');
                    $member['tags']  = array_values($device_info['tags']);
                    $member['token'] = $this->auth->token;
                    $this->msgbox->set_data('data', $member);
                    $this->msgbox->add('SUCCESS');
                }
            }
        }
    }
    /* 登录
     * $mobile,必填
     * $sms_code,选填
     * $passwd,必填
     * $register_id
     */
    public function login($params)
    {
        //K::M('system/logs')->log('agent',$_SERVER['HTTP_USER_AGENT']);
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误', 212);
        }else if($passwd = $params['passwd']){
            if(!$member = K::M('member/member')->member($mobile, 'mobile')){
                $this->msgbox->add('该手机号未注册', 213);
            }else if(md5($passwd) != $member['passwd']){
                $this->msgbox->add('登录密码错误',214);
            }else if($this->auth->manager($member['uid'])){
                $member = $this->filter_fields('uid,nickname,face,mobile',$member);
                $member['token'] = $this->auth->token;
                $device_info = K::M('jpush/device')->init_device($member['uid'], $params['register_id'], 'member');
                $member['tags']  = array_values($device_info['tags']);
                $this->msgbox->set_data('data', $member);
                $this->msgbox->add('success');
            }
        }else if($sms_code = $params['sms_code']){            
            if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
                $this->msgbox->add('短信验证码有误',213);
            }else {
                if($member = K::M('member/member')->member($mobile, 'mobile')){
                    $member = $this->filter_fields('uid,nickname,face,mobile',$member);
                    $this->auth->manager($member['uid']);
                    $member['token'] = $this->auth->token;
                    $device_info = K::M('jpush/device')->init_device($member['uid'], $params['register_id'], 'member');
                    $member['tags']  = array_values($device_info['tags']);
                    $this->msgbox->set_data('data', $member);
                }else{
                    $this->msgbox->add('该手机号未注册', 213);
                }
            }
        }else{
            $this->msgbox->add('参数传递有误', 216);
        }
    }
    //忘记密码
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
        }else if(!$member = K::M('member/member')->member($mobile, 'mobile')){
            $this->msgbox->add('该手机号未注册过',215);
        }else if(K::M('member/member')->update($member['uid'], array('passwd'=>md5($new_passwd), 'paypasswd'=>md5($new_passwd)))) {
            $this->msgbox->set_data('data', array('uid'=>$member['uid']));
        }
    }
    /*微信登录
     * $wx_openid,必填
     * $register_id
     */
    public function wxlogin($params)
    {
        if(!($wx_unionid = $params['wx_unionid']) && !($wx_openid = $params['wx_openid'])){
            $this->msgbox->add('缺少微信unionid', 211);
        }else{
            if($wx_unionid){
                $member = K::M('member/member')->member($wx_unionid, 'wx_unionid');
            }else if($wx_openid){
                $member = K::M('member/member')->member($wx_openid, 'wx_openid');
            }
            if($member){
                if($this->auth->manager($member['uid'])){
                    $data = $this->filter_fields('uid,nickname,face,mobile', $member);
                    $data['token'] = $this->auth->token;
                    $data['wxtype'] = 'wxlogin';
                    $data['wx_openid'] = $wx_openid;
                    $data['wx_unionid'] = $wx_unionid;
                    $device_info = K::M('jpush/device')->init_device($data['uid'], $params['register_id'], 'member');
                    $data['tags']  = array_values($device_info['tags']);
                    $this->msgbox->set_data('data', $data);
                }
            }else{
               $data = array('wxtype'=>'wxbind', 'uid'=>0, 'nickname'=>'', 'face'=>'', 'mobile'=>'', 'token'=>'', 'wx_openid'=>$wx_openid, 'wx_unionid'=>$wx_unionid);
                $this->msgbox->set_data('data', $data); 
            }
        }
    }

    /* 微信绑定
     * $wx_unionid,必填
     * $mobile,必填
     * $sms_code,必填
     * $wx_nickname,选填
     */
    public function wxbind($params)
    {
        $session = K::M('system/session')->start();
        if(!$wx_unionid = $params['wx_unionid']){
            $this->msgbox->add('微信unionid错误',211);
        }else if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$sms_code = $params['sms_code']){
            $this->msgbox->add('短信验证码有误',213);
        }else if(K::M('system/session')->start()->get('code_'.$mobile) != $sms_code){
            $this->msgbox->add('短信验证码有误',214);
        }else if($member = K::M('member/member')->member($mobile, 'mobile')){
            K::M('member/member')->update($member['uid'], array('wx_unionid'=>$wx_unionid)); //只关联wx_unionid 不要更新openid,openid只存公众号的
            if($this->auth->manager($member['uid'])){
                $data = $this->filter_fields('uid,nickname,face,mobile', $member);
                $data['token'] = $this->auth->token;
                $device_info = K::M('jpush/device')->init_device($data['uid'], $params['register_id'], 'member');
                $data['tags']  = array_values($device_info['tags']);
                $this->msgbox->set_data('data', $data);
            }
        }else{
            $data = array('mobile'=>$mobile, 'wx_unionid'=>$wx_unionid);
            if(!$nickname = $params['wx_nickname']){
                $nickname = substr($mobile,0,3).'****'.substr($mobile,-4);;
            }
            $data['nickname'] = $nickname;
            $data['paypasswd'] = md5(uniqid());
            $data['passwd'] = md5(uniqid());
            if($uid = K::M('member/account')->create($data)){
                if($wx_headimgurl = $params['wx_headimgurl']){
                    if($face = file_get_contents($wx_headimgurl)){
                        K::M('member/face')->update_face($uid, '', $face);
                    }
                }
                if($this->auth->manager($uid)){
                    $data = $this->filter_fields('uid,nickname,face,mobile', $this->auth->member);
                    $this->msgbox->add('success');
                    $data['token'] = $this->auth->token;
                    $device_info = K::M('jpush/device')->init_device($data['uid'], $params['register_id'], 'member');
                    $data['tags']  = array_values($device_info['tags']);
                    $this->msgbox->set_data('data', $data);
                }
            }
        }
    }
    
    
    public function loginout()
    {
        $this->auth->loginout();
    }
    
}
