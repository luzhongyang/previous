<?php

class Mdl_Data_Region extends Mdl_Table
{   
    protected $_table = 'data_region';
    protected $_pk = 'region_id';
    protected $_cols = 'region_id,region_name,parent_id,path_ids,level,map_x,map_y,orderby,closed';
    protected $_orderby = array('orderby'=>'ASC', 'region_id'=>'ASC');
    protected $_pre_cache_key = 'data-region-list';

    public function options()
    {
        $options = $items = array();
        $options = K::M('data/region')->fetch_all();
       
        foreach($options as $k=>$v) {
        	if($v['level'] == 1) {
        		$items[$k] = $v;
        	}
        	if($v['level'] == 2 ) {
        		$items[$v['parent_id']]['children'][$k] = $v;
        	}
        }

        foreach($options as $k=>$v) {
        	if($v['level'] == 3) {
        		foreach($items as $kk=>$vv) {
        			foreach($vv['children'] as $kkk=>$vvv) {
        				if($vvv['region_id'] == $v['parent_id']) {
        					$items[$kk]['children'][$vvv['region_id']]['children'][$k] = $v;
        				}
        			}
        		}
        	}
        }
        return $items;
    }
}