<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: account.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Message_Message extends Mdl_Table
{   
    protected $_table = 'message';
    protected $_pk = 'msg_id';
    protected $_cols = 'msg_id,title,content,shop_id,uid,dateline,client_ip';
    
    public function create($data)
    {
            if(!$data = $this->_check($data)){
                    return false;
            }
            $data['dateline'] = __CFG::TIME;
            $data['clientip'] = __IP;
            return $this->db->insert($this->_table, $data, true);
    }
    
}
