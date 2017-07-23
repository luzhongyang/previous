<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Data_Business extends Mdl_Table
{   
  
    protected $_table = 'data_business';
    protected $_pk = 'business_id';
    protected $_cols = 'business_id,city_id,area_id,business_name,orderby,dateline';
    protected $_pre_cache_key = 'data-business-list';
    public function options($area_id)
    {
        $options = array();
        if($items = $this->fetch_all()){
            foreach($items as $k=>$v){
                if($area_id == $v['area_id']){
                    $options[$k] = $v['business_name'];
                }
            }
        }
        return $options;
    }
}