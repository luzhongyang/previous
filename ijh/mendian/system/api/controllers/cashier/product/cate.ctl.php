<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Product_Cate extends Ctl_Cashier
{    
    

    public function items($params)
    {
        if(!$items = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id), null, 1, 100)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($cate_id = K::M('cashier/product/cate')->create($data)){
                $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
            }
        }
    }

    public function edit($params)
    {
        if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add('分类不存在', 211);
        }else if(!$data = $this->check_fields($params, 'title,orderby')){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(!$cate = K::M('cashier/product/cate')->detail($cate_id)){
            $this->msgbox->add('非法的数据提交', 213);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 214);
        }else if(K::M('cashier/product/cate')->update($cate_id, $data)){
            $this->msgbox->set_data('data', array('cate_id'=>$cate_id));
        }
    }

    public function delete($params)
    {
        if(!$cate_id = (int)$params['cate_id']){
            $this->msgbox->add(L('未指删除的分类'), 211);
        }else if(!$cate = K::M('cashier/product/cate')->detail($cate_id)){
            $this->msgbox->add(L('删除的分类不存在'), 212);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('删除的分类不存在'), 213);
        }else if(K::M('cashier/product')->count(array('cate_id'=>$cate_id,'closed'=>0))){
            $this->msgbox->add('分类下有商品不能删除', 214);
        }else if(K::M('cashier/product/cate')->delete($cate_id)){
            $this->msgbox->set_data(array('cate_id'=>$cate_id));
        }        
    }
    
}