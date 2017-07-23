<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Jifen_Product extends Ctl_Cashier
{


    public function items($params)
    {
        $filter = array('shop_id'=>$this->shop_id);
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if(!$items = K::M('jifen/product')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    public function create($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'title,jifen,stock,orderby')){
            $this->msgbox->add('参数错误', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'cashier')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if($product_id = K::M('jifen/product')->create($data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function edit($params)
    {
        $this->check_owner();
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$data = $this->check_fields($params, 'title,jifen,stock,orderby')){
            $this->msgbox->add('参数错误', 212);
        }else if(!$product = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('修改的商品不存在或已经删除', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('修改的商品不存在', 214);
        }else{
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'cashier')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if(K::M('jifen/product')->update($product_id, $data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }            
        }
    }

    public function detail($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$product = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('商品不存在或已经删除', 212);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('商品不存在或已经删除', 213);
        }else{
            $this->msgbox->set_data('data', array('product_detail'=>$product));
        }
    }

    public function delete($params)
    {
        $this->check_owner();
        if(!$ids = K::M('verify/check')->ids(trim($params['product_id'],','))){
            $this->msgbox->add('商品不存在', 211);
        }else if(!$items = K::M('jifen/product')->items_by_ids($ids)){
            $this->msgbox->add('商品不存在', 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['product_id']] = $v['product_id'];
                }
            }
            if($del_ids){
                K::M('jifen/product')->delete($del_ids);
            }
            $this->msgbox->add('success');
        }
    }

}
