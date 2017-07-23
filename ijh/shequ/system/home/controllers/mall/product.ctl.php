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
        $this->pagedata['cate_list']= K::M('mall/cate')->items(array('parent_id'=>0),array('cate_id'=>'desc'),1,7);
        $this->pagedata['product_list']= K::M('mall/product')->items(array('closed'=>0),array('orderby'=>'asc'),1,4);

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
        if($cate_id > 0){
            $this->pagedata['cate']= K::M('mall/cate')->detail($cate_id);
        }
        //print_r(K::M('mall/cate')->detail($cate_id));die;
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
    
    
    public function loaditems($page=1){
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int)$page, 1);
        $cate_id = (int)$this->GP('cate_id');
        if($cate_id == 0){
            //全部分类
            $filter['filter'] = '>:0';
        }else{
            $filter['cate_id'] = $cate_id;
        }
        $filter['closed'] = 0;
        if(!$items = K::M('mall/product')->items($filter, $orderby, $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('mall/product')->count($filter);
        //print_r($count_num);die;
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        
        $this->tmpl = 'mall/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
        
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
            $detail['info'] = htmlspecialchars_decode($detail['info']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'mall/detail.html';
        }
    }
}