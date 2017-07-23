<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Weixin extends Ctl_Biz
{
    

    public function wxloginpage()
    {
        $component = K::M('weixin/wechat')->component_client();
        $redirect_url = $this->mklink('weixin/api/wxcallback', null, null, 'www');
        if($url = $component->component_login_page($redirect_url)){
            header("Location:{$url}");
            exit;
        }
        $this->msgbox->add('获取微信第三方授权票据失败', 211);
    }

    public function wxcallback()
    {
        if(!$code = $this->GP('auth_code')){
            $this->msgbox->add('授权失败或用户拒绝授权', 211);
        }else{
            $component = K::M('weixin/wechat')->component_client();
            if($ret = $component->authorizer_info_by_code($code)){
                $auth_info = $ret['authorizer_info'];
                if($auth_info['authorizer_appid']){
                    $data = array('wx_appid'=>$auth_info['authorizer_appid'], 'access_token'=>$auth_info['authorizer_access_token'], 'refresh_token'=>$auth_info['authorizer_refresh_token']);
                    if($ret = $component->authorizer_info($auth_info['authorizer_appid'])){
                        if($wx_info = $ret['authorizer_info']){
                            $data['wx_name'] = $wx_info['alias'];
                            $data['wx_uname'] = $wx_info['user_name'];
                            $data['nick_name'] = $wx_info['nick_name'];
                            $data['qrcode_url'] = $wx_info['qrcode_url'];
                            $data['head_img'] = $wx_info['head_img'];
                        }
                        K::M('weixin/weixin')->update($this->shop_id, $data);
                    }
                }
            }            
        }
    }
}
