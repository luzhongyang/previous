<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Weixin_Wechat extends Model
{   
  
    public function wechat_client($config=null)
    {
        static $client = null;
        if ($client === null) {
            $wx_config = K::M('system/config')->get('wechat');
            if (!$wx_config['appid'] || !$wx_config['appsecret']) {
                return false;
            } else {
                Import::L('weixin/wechat.class.php');
                $client = new WeChatClient($wx_config['appid'], $wx_config['appsecret']);
                $client->weixin_type = $wx_config['type'];
            }
        }
        return $client;
    }

    public function app_client()
    {
        static $client = null;
        if ($client === null) {
            $wx_config = K::M('system/config')->get('wechat');
            if (!$wx_config['app_appid'] || !$wx_config['app_appsecret']) {
                return false;
            } else {
                Import::L('weixin/wechat.class.php');
                $client = new WeChatClient($wx_config['app_appid'], $wx_config['app_appsecret']);
                $client->weixin_type = $wx_config['type'];
            }
        }
        return $client;        
    }

}