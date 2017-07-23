<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
class Mdl_Member_WxLogin extends Model
{
    
    protected $_type_id = 3;//微信登录3
    

    public function wxlogin_jsqr($qr_id='wxlogin_jsqr')
    {
        $wxqrjs = '';
        $cfg = K::$system->config->get('connect');
        $site = K::$system->config->get('site');
        if($cfg['weixin_is_open']) {
            $callback = K::M('helper/link')->mklink('passport:wxcallback',null,null,'www');
            $session_state = md5(uniqid(rand(), TRUE));
            K::$system->session->start();
            K::$system->session->set('WEIXIN_LOGIN', $session_state);

            $wxqrjs = '<script type="text/javascript">var obj = new WxLogin({id:"'.$qr_id.'",appid: "'
                    . trim($cfg['weixin_app_id']) .'",scope: "snsapi_login",redirect_uri: "'
                    . urlencode($callback) .'",state: "'.$session_state.'",style: "",href: "'.$site['siteurl'].'/themes/default/static/css/wxlogin.css"});</script>';
            return $wxqrjs;
        }       
        return false;
    }

    public function wxlogin_url()
    {
        $cfg = K::$system->config->get('connect');
        if(defined('IN_MOBILE')){
            $site = K::$system->config->get('site');
            $callback = K::M('helper/link')->mklink('mobile/passport:wxcallback',null,null,'www');
        }else{
            $site = K::$system->config->get('site');
            $callback = K::M('helper/link')->mklink('passport:wxcallback',null,null,'www');
        }
        if (empty($cfg['weixin_is_open'])) {
            $this->msgbox->add(L('很抱歉网站管理员还未开启微信登录功能'), 201);
        }
        else {
            $session_state = md5(uniqid(rand(), TRUE));
            K::$system->session->start();
            K::$system->session->set('WEIXIN_LOGIN', $session_state);
            $login_url = "https://open.weixin.qq.com/connect/qrconnect?appid="
                    . trim($cfg['weixin_app_id']) . "&redirect_uri=" . urlencode($callback)
                    . "&response_type=code&scope=snsapi_login"
					. "&state=" . $session_state;
            return $login_url;
        }		
        return false;
    }

    public function wxcallback($code, $state)
    {
        $cfg = K::$system->config->get('connect');
        if(defined('IN_MOBILE')){
            $site = K::$system->config->get('site');
            $callback = K::M('helper/link')->mklink('mobile/passport:weixincallback', array(), array(), 'www');
        }else{
            $site = K::$system->config->get('site');
            $callback = K::M('helper/link')->mklink('passport:weixincallback', array(), array(), 'www');
        }
        if (empty($cfg['weixin_is_open'])) {
            $this->msgbox->add(L('很抱歉网站管理员还未开启微信登录功能'), 201);
            return false;
        } else {
            K::$system->session->start();
            $session_state = K::$system->session->get('WEIXIN_LOGIN');
            if ($session_state != $state) {
                $this->msgbox->add(L('很抱歉请重新登录'), 201);
                return false;
            }
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$cfg['weixin_app_id']."&secret=".$cfg['weixin_app_key']."&code={$code}&grant_type=authorization_code";
            $response = K::M('net/http')->http($token_url, array(), 'GET');
            if (strpos($response, "access_token") !== false) {
                $params = json_decode($response, true);
            }
            if (empty($params['access_token'])) {
                 $this->msgbox->add(L('授权过期请重试'), 201);
                 return false;
            }
            $params['weixin_app_id'] = $cfg['weixin_app_id'];
            return $this->login($params);
        }
    }

    public function login($info)
    {
        $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$info['access_token']."&openid=".$info['openid'];
        $str = K::M('net/http')->http($info_url, array(), 'GET');
        $wx_info = json_decode($str,true);
        if(empty($wx_info)){
            $this->msgbox->add(L('授权过期请重试'), 201);
            return false;
        }
        if($m = K::M('member/weixin')->detail_by_unionid($wx_info['unionid'])){
            K::M('member/auth')->manager($m['uid']);
            return true;            
        }
        if($uid = K::$system->uid){
            if($m = K::M('member/weixin')->detail($uid)){
                K::M('member/weixin')->update($uid, array('openid'=>$wx_info['openid'], 'unionid'=>$wx_info['unionid'], 'dateline'=>__TIME, 'status'=>1), true);
            }else{
                K::M('member/weixin')->create(array('uid'=>$uid, 'openid'=>$wx_info['openid'], 'unionid'=>$wx_info['unionid'], 'status'=>1), true);
            }
            return true;
        }else{

            $uinqid = 'wx'.rand(10000000,99999999);
            if(!$uname = K::M('member/account')->check_uname($wx_info['nickname'])){
                if(!$uname = K::M('member/account')->check_uname('WX'.$wx_info['nickname'])){
                    $uname = $uinqid;
                }
                $this->msgbox->clean();
            }
            $realname = trim($wx_info['nickname']);
            $a = array(
                'uname'       => $uname,
                'mail'        => $uinqid.'@qq.com',
                'passwd'      => substr(md5($uinqid),rand(5, 20),7),
                'realname'    => $realname
            );
            if($uid = K::M('member/account')->create($a)){
                K::M('member/weixin')->create(array('uid'=>$uid, 'openid'=>$wx_info['openid'], 'unionid'=>$wx_info['unionid'], 'status'=>1), true);
                K::M('member/member')->update($uid, array('realname'=>$wx_info['nickname']), true);
                if($face = file_get_contents($wx_info['headimgurl'])){
                    K::M('member/face')->update_face($uid, '', $face);
                }
                K::M('member/auth')->manager($uid);
                return true;
            }
        }
        return false;

    }
}