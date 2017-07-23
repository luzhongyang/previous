<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: cate.mdl.php 2108 2013-12-11 11:21:31Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_App_Noti extends Mdl_Table
{   
  
    protected $_table = 'app_noti';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,order_msg,comment_msg,complaint_msg,system_msg';
    protected $_orderby = array('shop_id'=>'DESC');
    
    
    public function create($data)
    {
        if(!$data = $this->_check_schema($data)){
            return false;
        }
        return $this->db->insert($this->_table, $data);
    }
}