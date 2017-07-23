<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Mall_Product extends Ctl
{
  	// 积分商城首页
    public function index()
    {
        $this->check_login();
        $this->pagedata['adv_item'] = K::M('adv/item')->items(array('adv_id'=>2),array('orderby'=>'asc'),$page,$limit,$count);
        $this->pagedata['cates']= K::M('mall/cate')->items(array('parent_id'=>0),array('cate_id'=>'desc'),1,8);
        $this->pagedata['products']= K::M('mall/product')->items(array('closed'=>0),array('orderby'=>'asc'),1,4);

        if($mallcart = unserialize($this->cookie->get('mallcart'))) {
            foreach($mallcart as $k=>$v){
                $ids[$k] =$k; 
                $total['count'] += $v;
            }
            $products = K::M('mall/product')->items_by_ids($ids);
            foreach($products as $k=>$product){
                $total['price'] += $product['price'] * $mallcart[$k];
                $total['jifen'] += $product['jifen'] * $mallcart[$k];
                $freight[] = $product['freight'];
            }
            $total['price'] = $total['price'] + max($freight);
            $total['freight'] = max($freight);
        }
        $this->pagedata['total']= $total;
        $this->tmpl = 'mall/index.html';
    }

    // 商品列表
    public function items($cate_id){
        $filter = $orderby = array();
        if($cate_id == 0){
            //全部分类
            $filter['filter'] = '>:0';
        }else{
            $filter['cate_id'] = $cate_id;
            $this->pagedata['cate']= K::M('mall/cate')->detail($cate_id);
        }
        $filter['closed'] = 0;
        $product = K::M('mall/product') -> items($filter,$orderby,1,null);
        $this->pagedata['product'] = $product;
        $cates = K::M('mall/cate')->items();
        foreach($cates as $k => $v){
            if($v['parent_id'] > 0){
                $cates[$v['parent_id']]['children'][] = $v;
                unset($cates[$k]);
            }
        }
        $this->pagedata['cates']= $cates;
        if($mallcart = unserialize($this->cookie->get('mallcart'))) {
            foreach($mallcart as $k=>$v){
                $ids[$k] =$k;
                $total['count'] += $v;
            }
            $products = K::M('mall/product')->items_by_ids($ids);
            foreach($products as $k=>$product){
                $total['price'] += $product['price'] * $mallcart[$k];
                $total['jifen'] += $product['jifen'] * $mallcart[$k];
                $freight[] = $product['freight'];
            }
            $total['price'] = $total['price'] + max($freight);
            $total['freight'] = max($freight);
        }
        $this->pagedata['cate_id']= $cate_id;
        $this->pagedata['total']= $total;
        $this->tmpl = 'mall/items.html';
    }

    // 商品详情
    public function detail($product_id)
    {
        $product_id = (int)$product_id;
        if(!$product_id){
            $this->error(404);
        }else if(!$detail = K::M('mall/product')->detail($product_id)){
            $this->error(404);
        }else{
            $mallcart = unserialize($this->cookie->get('mallcart'));
            /* foreach($mallcart as $k=>$v){
                $product = K::M('mall/product')->detail($k);
                $total['count'] += $v;
                $total['price'] += $product['price'] * $v;
                $total['jifen'] += $product['jifen'] * $v;
                if($product_id == $k){
                    $this->pagedata['this_count']= $v;
                }
            } */
            foreach($mallcart as $k=>$v){
                $ids[$k] =$k;
                $total['count'] += $v;
                if($product_id == $k){
                    $this->pagedata['this_count']= $v;
                }
            }
            $products = K::M('mall/product')->items_by_ids($ids);
            foreach($products as $k=>$product){
                $total['price'] += $product['price'] * $mallcart[$k];
                $total['jifen'] += $product['jifen'] * $mallcart[$k];
            }
            $this->pagedata['total']= $total;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'mall/detail.html';
        }
    }
}