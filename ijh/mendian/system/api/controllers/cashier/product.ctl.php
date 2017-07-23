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

class Ctl_Cashier_Product extends Ctl_Cashier
{

    public function items()
    {
        if($cate_list = K::M('cashier/product/cate')->items(array('shop_id'=>$this->shop_id), null, 1, 100)){
            foreach($cate_list as $k=>$v){
                $v['product_list'] = array();
                $cate_list[$k] = $v;
            }
        }else{
            $cate_list = array();
        }
        $other_product_list = array();
        if($product_list = K::M('cashier/product')->items(array('shop_id'=>$this->shop_id, 'closed'=>0), null, 1, 5000)){ //支持5000个单品
            foreach($product_list as $k=>$v){
                if($cate_list[$v['cate_id']]){
                    $cate_list[$v['cate_id']]['product_list'][] = $v;
                }else{
                    $v['cate_id'] = 0;
                    $other_product_list[] = $v;
                }
            }
            if($other_product_list){//cate_id,shop_id,title,orderby,dateline
                $cate_list['other'] = array('cate_id'=>0, 'shop_id'=>$this->shop_id, 'title'=>'其它', 'orderby'=>'999', 'dateline'=>__TIME, 'product_list'=>$other_product_list);
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($cate_list)));
    }

    public function create($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'cate_id,title,price,stock,code')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$cate_id = (int)$data['cate_id']){
            $this->msgbox->add('未指定商品分类', 212);
        }else if(!$cate = K::M('cashier/product/cate')->detail($cate_id)){
            $this->msgbox->add('商品分类不正确', 213);
        }else if($cate['shop_id'] != $this->shop_id){
            $this->msgbox->add('商品分类不正确', 214);
        }else{
            if($code = $params['code']){
                if(K::M('cashier/product')->count(array('shop_id'=>$this->shop_id,'code'=>$code))){
                    $this->msgbox->add('条码已经存在', 215)->response();
                }
            }
            $data['shop_id'] = $this->shop_id;
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'cashier')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if($product_id = K::M('cashier/product')->create($data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function edit($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'cate_id,title,price,code')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('未指定要修改的商品', 212);
        }else if(!$product = K::M('cashier/product')->detail($product_id)){
            $this->msgbox->add('您要修改的商品不存在', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限修改该商品', 214);
        }else{
            if($code = $params['code']){
                if($code_product = K::M('cashier/product')->find(array('shop_id'=>$this->shop_id,'code'=>$code))){
                    if($product_id != $code_product['product_id']){
                        $this->msgbox->add('条码已经存在', 215)->response();
                    }
                }
            }
            if(isset($data['cate_id'])){
                if(!$cate = K::M('cashier/product/cate')->detail($data['cate_id'])){
                    unset($data['cate_id']);
                }else if($cate['shop_id'] != $this->shop_id){
                    unset($data['cate_id']);
                }
            }
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'cashier')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if(K::M('cashier/product')->update($product_id, $data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function delete($params)
    {
        if(!$ids = K::M('verify/check')->ids($params['product_id'])){
            $this->msgbox->add('商品不存在', 211);
        }else if(!$items = K::M('cashier/product')->items_by_ids($ids)){
            $this->msgbox->add('商品不存在', 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['product_id']] = $v['product_id'];
                } 
            }
            if($del_ids){
                K::M('cashier/product')->delete($del_ids);
            }
            $this->msgbox->add('success');
        } 
    }
    
    public function barcode ($params)
    {
        if($params['code']){
            $code = $params['code'];
//            if(K::M('cashier/product')->find(array('shop_id'=>$this->shop_id, 'code'=>$code))){
//
//            }
           if($ret = K::M('net/http')->callapi('tools/barcode/query', array('code'=>$code))){
               $this->msgbox->set_data('data',$ret);
               $this->msgbox->json();
           }
            $this->msgbox->add('接口错误请稍后再试!',220);
            
        } else {
            $this->msgbox->add('缺少code!',211);
        }
        
    }
}