<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Wuye_Account extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_wuye_account';
    protected $_pk = 'account_id';
    protected $_cols = 'account_id,wuye_id,title,name,account,is_default,dateline';
    
    public function bank_list()
    {
    	$items = array(
            '徽商银行',
            '农业银行',
            '建设银行',
            '交通银行',
            '工商银行',
            '招商银行',
            '浦发银行',
            '九江银行',
            '兴业银行'
    	);
    	return $items;
    }
}