<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Waimai_Cate extends Mdl_Table
{   
    protected $_table = 'waimai_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,parent_id,title,icon,photo,orderby,dateline';
    protected $_orderby = array('orderby'=>'ASC');
    protected $_pre_cache_key = 'waimai-cate-list';
    public function tree()
    {
        $tree = array();
        if($items = $this->fetch_all()){
            foreach($items as $k=>$v){
                if(!$v['parent_id']){
                    $v['childrens'] = array();
                    $v['children'] = $v['childrens'];
                    $tree[$k] = $v;
                }                
            }
            foreach($items as $k=>$v){
                if($tree[$v['parent_id']]){
                    $tree[$v['parent_id']]['childrens'][$k] = $v;
                }
            }
        }
        return $tree;        
    }
    
    public function update($pk, $data, $checked=false)
    {
        $this->_checkpk();
        if(!$checked && !($data = $this->_check($data,  $pk))){
            return false;
        }
        if($ret = $this->db->update($this->_table, $data, $this->field($this->_pk, $pk))){
            $this->flush();
        }
        return $ret;
    }
    
    public function children_ids($cate_id, $glue=',')
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
        return implode($glue, $cate_ids);
    }
}