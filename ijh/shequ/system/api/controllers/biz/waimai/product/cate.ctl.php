<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Product_Cate extends Ctl_Biz
{    
    
    
    public function all($params){
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id'=>$this->shop_id);
        $tree = array();

        if($tree = K::M('waimai/productcate')->tree($this->shop_id)){
            foreach($tree as $k=>$v){
                $v = $this->filter_fields('cate_id,title,parent_id,orderby,childrens,children', $v);
                foreach($v['childrens'] as $kk=>$vv){
                    $v['childrens'][$kk] = $this->filter_fields('cate_id,parent_id,title,orderby', $vv);
                    //$v['childrens'] = array_values($v['childrens']);
                }
                if(!$v['childrens']){
                    $v['childrens'] = array();
                }else{
					$v['childrens'] = array_values($v['childrens']);
				}
                $tree[$k] = $v;
            } 
        }
        $this->msgbox->set_data('data', array('items'=>array_values($tree)));
    }

    public function items($params)
    {
        $items = array();
        $father = '';
        $parent_id = (int)$params['parent_id'];
        if($tree = K::M('waimai/productcate')->tree($this->shop_id)){
            if($parent = $tree[$parent_id]){
                $items = (array)$parent['childrens'];
                $father = $parent['title'];
            }else{                
                foreach($tree as $k=>$v){
                    if(!$v['children_num'] = count($v['childrens'])){
                        $v['childrens'] = array();
                    }
                    $v['childrens'] = $v['children'] = array_values($v['childrens']);
                    $items[$k] = $v;
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items),'count'=>count($items), 'father'=>$father));
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'title,orderby,parent_id')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if(!$data['parent_id']){
                $data['parent_id'] = 0;
            }
            if($cate_id = K::M('waimai/productcate')->create($data)){
                $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
            }
        }
    }

    public function update($params)
    {
        if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add('分类不存在', 211);
        }else if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(!$cate = K::M('waimai/productcate')->detail($cate_id)){
            $this->msgbox->add('非法的数据提交', 213);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 214);
        }else if(K::M('waimai/productcate')->update($cate_id, $data)){
            $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
        }
    }

    //危险接口，会同步删除该分类下的所有子分类及分类下商品
    public function delete($params)
    {
        if(!$ids = K::M('verify/check')->ids($params['cate_id'])){
            $this->msgbox->add(L('未指删除的分类'), 211);
        }else if(!$items = K::M('waimai/productcate')->items_by_ids($ids)){
            $this->msgbox->add(L('未指删除的分类'), 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['cate_id']] = $v['cate_id'];
                } 
            }
            if($del_ids){
                if($parent_list = K::M('waimai/productcate')->items(array('parent_id'=>$del_ids, 'shop_id'=>$this->shop_id))){
                    foreach($parent_list as $k=>$v){
                        $del_ids[$v['cate_id']] = $v['cate_id'];
                    }
                }
                if(K::M('waimai/productcate')->delete($del_ids)){
                    $del_pids = array();
                    if($product_list = K::M('waimai/product')->items(array('cate_id'=>$del_ids, 'shop_id'=>$this->shop_id))){
                        foreach($product_list as $k=>$v){
                            $del_pids[$v['product_id']] = $v['product_id'];
                        }
                    }
                    K::M('waimai/product')->delete($del_pids);
                }
            }
            $this->msgbox->add('success');
        }
        
    }
    
}