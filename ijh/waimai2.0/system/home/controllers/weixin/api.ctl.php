<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

Import::C('weixin');
class Ctl_Weixin_Api extends Ctl_Weixin
{

    public function index()
    {
        
    }


    //获取token前ticket票据
    public function openapi()
    {
        $xmldata = file_get_contents('php://input');
        $wx_config = K::M('system/config')->get('wechat');
        Import::L('weixin/crypt/wxBizMsgCrypt.php');
        // 第三方收到公众号平台发送的消息
        $Crypt = new wxBizMsgCrypt($wx_config['open_mp_token'], $wx_config['open_mp_aeskey'], $wx_config['open_mp_appid']);
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $msg_sign = $_GET['msg_signature'];
        $errCode = $Crypt->decryptMsg($msg_sign, $timeStamp, $nonce, $xmldata, $msg);
        K::M('system/logs')->log('wxopen.api.ticket', array($xmldata, $_POST, $_REQUEST, $msg));
        if ($errCode == 0) {
            $xmlobj = simplexml_load_string($msg);
            foreach($xmlobj as $k=>$v){
                $data[$k] = strval($v);
            }
            $this->cache->set('wxopen.api.ticket', $data);
            exit('SUCCESS');
        } else {
            exit('FAIL');
        }        
        
    }

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
                        K::M('weixin/weixin')
                    }
                }
            }            
        }
    }

}