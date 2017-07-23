<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Weidianbanner extends Mdl_Table
{
	protected $_table = 'shop_weidian_banner';
    protected $_pk = 'banner_id';
    protected $_cols = 'banner_id,shop_id,title,link,photo,clicks,stime,ltime,closed,dateline,desc,target,orderby,status';
    protected $_orderby = array('banner_id'=>'DESC');
}