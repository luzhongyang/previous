<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Yezhu extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_yezhu';
    protected $_pk = 'yezhu_id';
    protected $_cols = 'yezhu_id,xiaoqu_id,uid,contact,mobile,house_louhao,house_danyuan,house_huhao,house_mianji,have_chewei,chewei_hao,chepai_hao,orderby,audit,closed,clientip,dateline';
    protected $_orderby = array('yezhu_id'=>'DESC');
    
    protected function _format_row($row)
    {
    	$row['house'] = $row['house_louhao'].$row['house_danyuan'].$row['house_huhao'];
    	return $row;
    }
}