<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Comment extends Mdl_Table
{   
  
    protected $_table = 'weidian_comment';
    protected $_pk = 'comment_id';
    protected $_cols = 'comment_id,shop_id,uid,order_id,score,packing_score,fuwu_score,quality_score,content,have_photo,reply,reply_ip,reply_time,closed,clientip,dateline';
}