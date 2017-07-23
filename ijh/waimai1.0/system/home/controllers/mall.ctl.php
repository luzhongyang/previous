<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Mall extends Ctl
{

    public function index($cate_id,$new)
    {

        $filter = $orderby = array();

        if($cate_id == 0){
            unset($filter);
        }else{
            $filter['cate_id'] = $cate_id;
        }
        $product = K::M('mall/product') -> items($filter,$orderby,1,10);
        $this->pagedata['product'] = $product;
        $cates = K::M('mall/cate')->items();
        $this->pagedata['cates']= $cates;
        $this->tmpl = 'mall/index.html';
    }

    
    public function items(){
        $cate_id = (int)$this->GP('cate_id');
        if($cate_id){
            $filter['cate_id'] = $cate_id;
            $this->pagedata['cate_id'] = $cate_id;
        }
        $product = K::M('mall/product') -> items($filter,$orderby,1,10);
        $this->pagedata['product'] = $product;
        $cates = K::M('mall/cate')->items();
        $this->pagedata['cates']= $cates;
        $this->tmpl = 'mall/items.html';
    }

    public function detail($product_id)
    {
        $product_id = (int)$product_id;
        if(!$product_id){
            $this->error(404);
        }else if(!$detail = K::M('mall/product')->detail($product_id)){
            $this->error(404);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'mall/detail.html';
        }
    }
    
    
    public function exchange(){
        $product_id = $this->GP('product_id');
        $exchange = K::M('mall/product')->detail($product_id);
        $addr_id = $this->GP('addr_id');
 
        if($addr_id){
            $my_addr = K::M('member/addr')->detail($addr_id);
            if($my_addr['uid'] == $this->uid){
                $this->pagedata['my_addr'] = $my_addr;
            }
        }

        $addr_count = K::M('member/addr') -> count(array('uid'=>$this->uid));
        $this->pagedata['addr_count'] = $addr_count;
        $this->pagedata['exchange'] = $exchange;
        $this->tmpl = 'mall/exchange.html';
    }
    
    
    public function handle(){
        
        if(!$product_id = (int)$this->GP('product_id')){
            $this->msgbox->add(L('商品不存在'),211);
        }else if(!$product_number = $this->GP('product_number')){
            $this->msgbox->add(L('请选择兑换的数量'),212);
        }else if(!$addr_id = $this->GP('addr_id')){
            $this->msgbox->add(L('收货地址不存在'),213);
        }else if(!$product = K::M('mall/product')->detail($product_id)){
            $this->msgbox->add(L('商品不存在'),214);
        }else if(!$addr = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add(L('收货地址不存在'),215);
        }else if($addr['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),216);
        }else if(!$this->uid){
            $this->msgbox->add(L('NOLOGIN'),101);
        }else if($this->MEMBER['jifen'] < ($product['jifen']*$product_number)){
            $this->msgbox->add(L('您的积分不足'),217);
        }else if($product['sku']< $product_number){
            $this->msgbox->add(L('商品库存不足'),218);
        }else{
            $data = array(
                'uid'=>$this->uid,
                'product_id' => $product_id,
                'product_name' => $product['title'],
                'product_jifen' => $product['jifen']*$product_number,
                'product_number' => $product_number,
                'contact' => $addr['contact'],
                'mobile' => $addr['mobile'],
                'addr' => $addr['addr'].$addr['house'],
                
            );
            $data2['sku'] = $product['sku'] - $product_number;
            $data2['sales'] = $product['sales'] + $product_number;
            if($create = K::M('mall/order')->create($data)){
                //扣除用户的积分余额
                if(K::M('member/member')->update_jifen($this->uid,-($product['jifen']*$product_number),'兑换商品消耗积分')){
                    K::M('mall/product')->update($product['product_id'], $data2);
                    $this->msgbox->add(L('SUCCESS'));
                }
            }else{
                $this->msgbox->add(L('FAIL'));
            }
        }
        
    }

}