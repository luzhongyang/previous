<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Staff_Cate extends Mdl_Table
{   
  
    protected $_table = 'staff_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,title,from,orderby,dateline';
    protected $_pre_cache_key = 'staff_list';

    protected function _format_row($row)
    {
        static $from_list = null;
        if($from_list === null){
            $from_list = K::M('data/data')->staff_from();
        }
        $row['from_title'] = $from_list[$row['from']];
        return $row;
    }

    public function cate($cate_id)
    {
        static $items = null;
        if($items === null){
            $items = $this->fetch_all();
        }
        return $items[$cate_id];
    }
}