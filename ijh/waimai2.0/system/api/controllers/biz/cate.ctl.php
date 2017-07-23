<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Cate extends Ctl_Biz
{    

    public function items($params)
    {
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $filter = array('shop_id'=>$this->shop_id);
        $tree = array();

        if($tree = K::M('waimai/productcate')->tree($this->shop_id)){
            foreach($tree as $k=>$v){
                $v = $this->filter_fields('cate_id,title,parent_id,orderby,childrens', $v);
                foreach($v['childrens'] as $kk=>$vv){
                    $v['childrens'][$kk] = $this->filter_fields('cate_id,parent_id,title,orderby', $vv);
                }
                $tree[$k] = $v;
            } 
        }
        $this->msgbox->set_data('data', array('items'=>array_values($tree)));
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add(L('非法的数据提交'), 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($cate_id = K::M('waimai/productcate')->create($data)){
                $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
            }
        }
    }

    public function update($params)
    {
        if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add(L('分类不存在'), 211);
        }else if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add(L('非法的数据提交'), 212);
        }else if(!$cate = K::M('waimai/productcate')->detail($cate_id)){
            $this->msgbox->add(L('非法的数据提交'), 213);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 214);
        }else if(K::M('waimai/productcate')->update($cate_id, $data)){
            $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
        }
    }

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
                K::M('waimai/productcate')->delete($del_ids);
            }
            $this->msgbox->add('success');
        }
    }
}