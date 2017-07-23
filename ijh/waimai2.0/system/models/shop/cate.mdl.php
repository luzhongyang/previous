<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Cate extends Mdl_Table
{   
  
    protected $_table = 'shop_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,parent_id,title,icon,ico,orderby,dateline,shop_num';
    protected $_pre_cache_key = 'shop-cate-list';
    protected $_orderby = array('parent_id'=>'ASC', 'orderby'=>'ASC');



    public function get_cate_count($lng,$lat)
    {
        $cate_tree = K::M('shop/cate')->tree();
        $cate_source = K::M('shop/cate')->select();
        $where_filter = '';
        if($lng && $lat) {
            $where_filter = "AND ($lng) AND ($lat)";
        }
        $sql = "SELECT a.cate_id, a.title, count(a.cate_id) as how FROM  ".$this->table('shop_cate')." a  left join  ".$this->table('shop')."  b on  a.cate_id = b.cate_id   where   b.closed = 0  &&  b.audit=1 && b.verify_name = 1 {$where_filter}  group by a.cate_id";
        $arr = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $arr[$row['cate_id']] = $row;
            }
        }
        $new_cate = array();
        foreach($cate_tree as $k => $v) {
            $new_cate[$v['cate_id']]['cate_id'] = $arr[$v['cate_id']]['cate_id'];
            $new_cate[$v['cate_id']]['parent_id'] = $cate_source[$v['cate_id']]['parent_id'];
            $new_cate[$v['cate_id']]['title'] = $arr[$v['cate_id']]['title'];
            $new_cate[$v['cate_id']]['icon'] = $cate_source[$v['cate_id']]['icon'];
            $new_cate[$v['cate_id']]['ico'] = $cate_source[$v['cate_id']]['ico'];
            $new_cate[$v['cate_id']]['shop_num'] = $arr[$v['cate_id']]['how'];
            $new_cate[$v['cate_id']]['orderby'] = $cate_source[$v['cate_id']]['orderby'];
            $new_cate[$v['cate_id']]['dateline'] = $cate_source[$v['cate_id']]['dateline'];

            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['cate_id'] = $arr[$v['cate_id']]['cate_id'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['parent_id'] = $cate_source[$v['cate_id']]['parent_id'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['shop_num'] = $arr[$v['cate_id']]['how'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['title'] = '全部'.$arr[$v['cate_id']]['title'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['icon'] = $cate_source[$v['cate_id']]['icon'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['ico'] = $cate_source[$v['cate_id']]['ico'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['orderby'] = $cate_source[$v['cate_id']]['orderby'];
            $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['dateline'] = $cate_source[$v['cate_id']]['dateline'];
            if(is_array($v['children']) && count($v['children']) > 0) {
                $extea_add = 0;
                foreach($v['children'] as $kk => $vv) {
                    if($arr[$vv['cate_id']]['how']< 1) {
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['cate_id'] = $vv['cate_id'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['parent_id'] = $vv['parent_id'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['shop_num'] = 0;
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['title'] = $cate_source[$vv['cate_id']]['title'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['icon'] = $cate_source[$vv['cate_id']]['icon'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['ico'] = $cate_source[$vv['cate_id']]['ico'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['orderby'] = $cate_source[$vv['cate_id']]['orderby'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['dateline'] = $cate_source[$vv['cate_id']]['dateline'];
                    }else {
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['cate_id'] = $vv['cate_id'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['parent_id'] = $vv['parent_id'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['shop_num'] = $arr[$vv['cate_id']]['how'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['title'] = $arr[$vv['cate_id']]['title'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['icon'] = $cate_source[$vv['cate_id']]['icon'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['ico'] = $cate_source[$vv['cate_id']]['ico'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['orderby'] = $cate_source[$vv['cate_id']]['orderby'];
                        $new_cate[$v['cate_id']]['childrens'][$vv['cate_id']]['dateline'] = $cate_source[$vv['cate_id']]['dateline'];
                        $extea_add += $arr[$vv['cate_id']]['how'];
                    }
                }
                $new_cate[$v['cate_id']]['shop_num'] = $new_cate[$v['cate_id']]['childrens'][$v['cate_id']]['shop_num'] = $arr[$v['cate_id']]['how'] + $extea_add;
            }
        }

        foreach ($new_cate as $k => $v) {
            $new_cate[$k]['childrens'] = array_values($new_cate[$k]['childrens']);
        }
        return $new_cate;
    }

    // 更新商家数据到商家分类下
    public function setupdata()
    {
        $sql = "SELECT a.cate_id,count(a.cate_id) as shop_num FROM  ".$this->table('shop_cate')." a  left join  ".$this->table('shop')."  b on  a.cate_id = b.cate_id   where   b.closed = 0  &&  b.audit=1 && b.verify_name = 1  group by a.cate_id";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['cate_id']] = $row;
            }
        }
        foreach ($items as $k => $v) {
            $data[$k]['shop_num'] = $v['shop_num'];
        }
        if(is_array($data)) {
            foreach($data as $k=>$v) {
                if($ret = $this->db->update($this->_table, $v, $this->field($this->_pk, $k))){
                    $this->flush();
                }
            } 
        }
        return true;
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

    public function tree()
    {
        $tree = array();
        if($items = K::M('shop/cate')->items()) {
            foreach($items as $k=>$v){
                if(!$v['parent_id']){
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
    
}