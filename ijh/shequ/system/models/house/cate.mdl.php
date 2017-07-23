<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_House_Cate extends Mdl_Table
{   
  
    protected $_table = 'house_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,parent_id,title,icon,photo,price,orders,orderby,info,dateline,start';
    protected $_pre_cache_key = 'house-cate-list';
    public function children_ids($cate_id, $glue=null)
    {
        if(!$cate_id = (int)$cate_id){
            return false;
        }
        $cate_ids = array($cate_id=>$cate_id);
        if($items = $this->fetch_all()){
            foreach((array)$items as $k=>$v){
                if(in_array($v['parent_id'], $cate_ids)){
                    $cate_ids[$v['cate_id']] = $v['cate_id'];
                }
            }
        }
        if($glue !== null){
            $cate_ids = implode($glue, $cate_ids);
        }
        return $cate_ids;
    }
    protected function _format_row($row)
    {
        $row['start'] = $row['price'];
        return $row;
    }
}