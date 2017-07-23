<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Banner extends Mdl_Table
{
    protected $_table = 'xiaoqu_banner';
    protected $_pk = 'banner_id';
    protected $_cols = 'banner_id,xiaoqu_id,title,photo,link,clicks,orderby,audit,dateline';
}