<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Member_Message extends Mdl_Table
{   
  
    protected $_table = 'member_message';
    protected $_pk = 'message_id';
    protected $_cols = 'message_id,uid,title,content,type,order_id,is_read,dateline,clientip';
    
    public function get_message_type(){
        return array(
            '0' => '全部消息',
            '1' => '红包消息',
            '2' => '订单消息',
            '3' => '其他消息',
        );
    }
    
    public function create($data=null)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::__TIME;
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
    }
    
}