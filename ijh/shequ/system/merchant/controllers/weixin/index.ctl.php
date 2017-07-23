<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weixin/weixin');
class Ctl_Weixin_Index extends Ctl_Weixin
{
    
    public function index()
    {
        $this->tmpl = 'merchant:weixin/index.html';
    }
    
    
    public function bind()
    {
        $this->tmpl = 'merchant:weixin/bind.html';
    }

    public function wxloginpage()
    {
        $component = K::M('weixin/wechat')->component_client();
        $redirect_url = $this->mklink('merchant/weixin/api/wxcallback', array($this->shop_id), null, 'www');
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
            if($ret = $component->authorizer_info_by_code($code)){//echo __FILE__.'---'.__LINE__;exit;
                $auth_info = $ret['authorization_info'];
                if($auth_info['authorizer_appid']){
                    $data = array('wx_appid'=>$auth_info['authorizer_appid'], 'access_token'=>$auth_info['authorizer_access_token'], 'refresh_token'=>$auth_info['authorizer_refresh_token']);
                    $data['token_expire_in'] = __TIME + $auth_info['expires_in'];
                    if($wxret = $component->authorizer_info($auth_info['authorizer_appid'])){//echo __FILE__.'---'.__LINE__;exit;
                        if($wx_info = $wxret['authorizer_info']){
                            $data['wx_name'] = $wx_info['alias'];
                            $data['wx_uname'] = $wx_info['user_name'];
                            $data['nick_name'] = $wx_info['nick_name'];
                            $data['qrcode_url'] = $wx_info['qrcode_url'];
                            $data['head_img'] = $wx_info['head_img'];
                        }
                        if(!K::M('weixin/weixin')->update_weixin($this->shop_id, $data)){
                            $this->msgbox->add('授权失败或用户拒绝授权', 211);
                        }else{
                            $this->msgbox->add('微信公众号授权成功');
                            $this->msgbox->set_data('forward', $this->mklink('merchant/weixin/index'));
                            $this->msgbox->response();
                        }
                    }
                }
            }            
        }
    }
    
    public function welcome()
    {
        $welcome = K::M('weixin/welcome')->find(array('shop_id'=>$this->shop_id));
        if($data = $this->checksubmit('data')){
            $data = $this->check_fields($data, 'type,reply_id,content');
            if($welcome){
                if(K::M('weixin/welcome')->update($welcome['welcome_id'],$data)){
                    $this->msgbox->add('设置微信关注欢迎信息成功');
                }
            }else{
                $data['shop_id'] = $this->shop_id;
                if($welcome_id = K::M('weixin/welcome')->create($data)){
                    $this->msgbox->add('添加微信关注欢迎信息成功');
                }
            }
        }else{
            if($reply_id = (int)$welcome['reply_id']){
                if($reply = K::M('weixin/reply')->detail($reply_id)){
                    if($reply['shop_id'] == $this->shop_id){
                        $this->pagedata['reply'] = $reply;
                    }
                }
            }
            $this->pagedata['welcome'] = $welcome;
            $this->tmpl = 'merchant:weixin/welcome.html';
        }        
    }
    
    
    
    public function auto()
    {
        $auto = K::M('weixin/auto')->find(array('shop_id'=>$this->shop_id));
        if($data = $this->checksubmit('data')){
            $data = $this->check_fields($data, 'type,reply_id,content');
            if($auto){
                if(K::M('weixin/auto')->update($auto['auto_id'],$data)){
                    $this->msgbox->add('设置微信自动回复信息成功');
                }
            }else{
                $data['shop_id'] = $this->shop_id;
                if($auto_id = K::M('weixin/auto')->create($data)){
                    $this->msgbox->add('添加微信自动回复信息成功');
                }
            }
        }else{
            if($reply_id = (int)$auto['reply_id']){
                if($reply = K::M('weixin/reply')->detail($reply_id)){
                    if($reply['shop_id'] == $this->shop_id){
                        $this->pagedata['reply'] = $reply;
                    }
                }
            }
            $this->pagedata['auto'] = $auto;
            $this->tmpl = 'merchant:weixin/auto.html';
        }        
    }
    
    
}