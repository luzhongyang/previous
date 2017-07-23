<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Cate extends Mdl_Table
{   
  
    protected $_table = 'cloud_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,title,orderby,parent_id,dateline';
    protected $_orderby = array('orderby'=>'ASC');
    protected $_pre_cache_key = 'cloud-cate-list';
    
    
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