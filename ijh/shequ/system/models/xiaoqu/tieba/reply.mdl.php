<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Tieba_Reply extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_tieba_reply';
    protected $_pk = 'reply_id';
    protected $_cols = 'reply_id,tieba_id,uid,at_uid,at_reply_id,content,closed,clientip,dateline';
}