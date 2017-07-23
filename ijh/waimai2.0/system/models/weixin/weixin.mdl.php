<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Weixin_Weixin extends Mdl_Table
{   
  
    protected $_table = 'weixin';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,wx_appid,wx_appsecret,access_token,refresh_token,token_expire_in,nick_name,verify_type,wx_type,wx_name,wx_ghid,head_img,qrcode_url,dateline';

    public function update($shop_id, $data)
    {

    }

    public function detail_by_appid($appid)
    {

    }

    public function detail_by_ghid($ghid)
    {
        
    }
}