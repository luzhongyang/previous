<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Fenxiao_Account extends Mdl_Table
{

    protected $_table = 'fenxiao_account';
    protected $_pk = 'id';
    protected $_cols = 'id,real_name,uid,card_no,account_type,account_number';
    
    //账户列表
    public function bank_items()
    {
    	$items = array(
            array('title_value'=>'huishang', 'title'=>'徽商银行'),
            array('title_value'=>'nongye', 'title'=>'农业银行'),
            array('title_value'=>'jianshe', 'title'=>'建设银行'),
            array('title_value'=>'jiaotong', 'title'=>'交通银行'),
            array('title_value'=>'gongshang', 'title'=>'工商银行'),
            array('title_value'=>'zhaoshang', 'title'=>'招商银行'),
            array('title_value'=>'pufa', 'title'=>'浦发银行'),
            array('title_value'=>'jiujiang', 'title'=>'九江银行'),
            array('title_value'=>'xingye', 'title'=>'兴业银行'),
    	);
    	return $items;
    }

}
