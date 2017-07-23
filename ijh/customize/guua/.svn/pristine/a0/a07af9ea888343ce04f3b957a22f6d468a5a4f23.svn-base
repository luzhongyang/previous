<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Mall_Cate extends Mdl_Table
{   
  
    protected $_table = 'mall_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,title,icon,orderby';
    protected $_pre_cache_key = 'mall-cate-list';

    // 获取商品分类名称
    public function get_cate() {
        $sql = "SELECT cate_id,title FROM ".$this->table($this->_table);
        if($detail = $this->db->GetAll($sql)){
            return $detail;
        }
        
    }

    
    public function options()
    {
        $options = array();
        if($items = $this->fetch_all()){
            foreach($items as $k=>$v){
                $options[$k] = $v['title'];
            }
        }
        return $options;
    }

}