<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Product extends Ctl
{


    public function cate($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
           $this->msgbox->add(L('商家不存在'),211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
           $this->msgbox->add(L('商家不存在或已被删除'), 212);
        }else if(empty($shop['audit'])){
           $this->msgbox->add(L('商户审核中不可访问'), 213);
        }else{
            $tree = array();
            if($tree = K::M('product/cate')->tree(array('shop_id'=>$shop_id))){
                foreach($tree as $k=>$v){
                    $v = $this->filter_fields('cate_id,parent_id,title,orderby,childrens', $v);
                    foreach($v['childrens'] as $kk=>$vv){
                        $v['childrens'][$kk] = $this->filter_fields('cate_id,parent_id,title,orderby', $vv);
                    }
                    $tree[$k] = $v;
                } 
            }
            $this->msgbox->set_data('data', array('items'=>array_values($tree)));
            $this->msgbox->add('success');
       }
    }

    public function products($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
           $this->msgbox->add(L('商家不存在'),211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'),212);
        }else{
            $page = max((int)$page, 1);
            $limit = 10;
            $filter = array('shop_id'=>$shop_id, 'closed'=>0);
            if($cate_id = (int)$params['cate_id']){
                if($ids =  K::M('product/cate')->children_ids($cate_id)){
                    $ids[] = $cate_id;
                    $filter['cate_id'] = $ids;
                }else{
                    $filter['cate_id'] = $cate_id;
                }
            }
            $items = $cate_list = $cate_ids = $product_ids = array();
            if($items = K::M('product/product')->items($filter, null, $page, $limit, $count)){
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields('product_id,cate_id,shop_id,title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,dateline', $v);
                    if($c = K::M('product/cate')->detail($v['cate_id'])){
                        $items[$k]['parent_id'] = $c['parent_id'];
                    }
   
                }               
            }else{
                $items = array();
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
            $this->msgbox->add('success');
        }        
    }

    public function items($params)
    {
        if(!$shop_id = (int)$params['shop_id']){
           $this->msgbox->add(L('商家不存在'),211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'),212);
        }else{
            $page = max((int)$page, 1);
            $limit = 20;
            $items = $cate_list = $cate_ids = $product_ids = array();
            if($items = K::M('product/product')->items(array('shop_id'=>$shop_id, 'closed'=>0), null, 1, 500, $count)){
                foreach($items as $k=>$v){
                    $product_ids[$v['product_id']] = $v['product_id'];
                    $cate_ids[$v['cate_id']] = $v['cate_id'];
                    $items[$k] = $this->filter_fields('product_id,cate_id,shop_id,title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,dateline', $v);
                }               
            }else{
                $items = array();
            }
            if($cate_items = K::M('product/cate')->items(array('shop_id'=>$shop_id))){
                foreach($cate_items as $k=>$v){
                    if($cate_ids[$v['cate_id']]){
                        $cate_list[$k] = $this->filter_fields('cate_id,title', $v);
                    }
                }
            }
            $shop = $this->filter_fields('shop_id,city_id,city_name,d,youhui,orders,cate_title,title,cate_id,phone,logo,lat,lng,addr,score,score_fuwu,score_kouwei,pei_time,comments,praise_num,min_amount,first_amount,pei_amount,freight,pei_type,yy_status,yy_stime,yy_ltime,is_new,online_pay,info,orders,youhui,youhui_title,order_youhui', $shop);
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'shop'=>$shop, 'cate_list'=>array_values($cate_list), 'total_count'=>$count));
            $this->msgbox->add('success');
        }
    }

    // 商品搜索
    public function search($params)
    {
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add(L('商家不存在'),210);
        }else if(!$title = $params['title']) {
            $this->msgbox->add(L('商品名称不能为空'),211);
        }else if(!$product = K::M('product/product')->items(array('title'=>"LIKE:%".$title."%",'shop_id'=>$shop_id,'closed'=>0))) {
            $this->msgbox->add(L('商品不存在'),212);
        }else {
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($product)));
        }
    }
}
