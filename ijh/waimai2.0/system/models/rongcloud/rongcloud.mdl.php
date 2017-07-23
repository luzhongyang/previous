<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Rongcloud_Rongcloud extends Mdl_Table
{   
  
    protected $_table = 'rongcloud';
    protected $_pk = 'uuid';
    protected $_cols = 'uuid,token';

    public function client()
    {
    	static $client = null;
    	if($client === null){
    		$cfg = K::$system->config->get('rongcloud');    		
    		Import::L('rongcloud/ServerAPI.php');
    		$client = new ServerAPI($cfg['appkey'], $cfg['appsecret']);
    	}
    	return $client;
    }

    //初始化token
    public function init_token($uuid, $name='', $face='default/face.png')
    {
    	if(!$a = $this->detail($uuid)){
    		$cfg = K::$system->config->get('attach');
    		$face = $cfg['attachurl'].'/'.$face;
    		if($res = $this->client()->getToken($uuid, $name, $face)){
    			if($ret = json_decode($res, true)){
    				if($ret['code'] == 200){
    					$token = $ret['token'];
    				}
    			}
    		}
            K::M('system/logs')->log('rongcloud.token', $res);		
    		if($token){
    			$a = array('uuid'=>$uuid, 'token'=>$token);
    			$this->create($a);
    		}else{
    			return false;
    		}
    	}
    	$cfg = K::$system->config->get('rongcloud');
    	$a['appkey'] = $cfg['appkey'];
    	return $a;
    }
}