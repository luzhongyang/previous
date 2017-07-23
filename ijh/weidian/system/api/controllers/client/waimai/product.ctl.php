<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Waimai_Product extends Ctl
{
    /* 产品列表
     * @param $shop_id int,商店ID
     */
    public function items($params)
    {
        if(!$shop_id= (int)$params['shop_id']){
            $this->msgbox->add('参数错误',211);
        }else if(!$shop = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('商户不存在', 212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户正在审核中', 213);
        }else{
            $cate_list = K::M('waimai/productcate')->items(array('shop_id'=>$shop_id));
            $items = $other_items = array();
            if($product_list = K::M('waimai/product')->items(array('shop_id'=>$shop_id,'closed'=>0,'is_onsale'=>1), null, 1, 500, $count)){
                $product_ids = array();
                foreach($product_list as $k=>$v){                    
                    $product_ids[$v['product_id']] = $v['product_id'];
                    $v['special'] = $v['specs'] = array();
                    $product_list[$k] = $v;
                }
                if($spec_list = K::M('waimai/productspec')->items(array('product_id'=>$product_ids))){
                    foreach($spec_list as $v){
                        $product_list[$v['product_id']]['specs'][] = $v;
                    }
                }
                foreach($product_list as $k=>$v){
                    if($cate = $cate_list[$v['cate_id']]){
                        if($cate['parent_id']){
                            $cate = $cate_list[$cate['parent_id']];                            
                        }
                    }
                    if($cate){
                        if($items[$cate['cate_id']]){
                            $items[$cate['cate_id']]['child'][] = $v;
                        }else{
                            $items[$cate['cate_id']] = $cate;
                            $items[$cate['cate_id']]['child'][] = $v;
                        }
                    }else{
                        $other_items[$k] = $v;
                    }
                }
                if($other_items){
                    $items['other'] = array('cate_id'=>0, 'parent_id'=>0, 'shop_id'=>0, 'title'=>'其它', 'icon'=>'', 'orderby'=>0, 'type'=>0, 'spec'=>0, 'dateline'=>0);
                    $items['other']['child'] = array_values($other_items);
                }
            }
            $shopinfo = $this->filter_fields('shop_id,city_id,cate_id,cate_title,title,logo,pei_distance,pei_type,yy_status,min_amount', $shop);
            $shopinfo['titleString'] = $shop['title']; //为什么要用titleString，只能再赋值该键值
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('waimai/product/index', array($shop_id), null, 'www'),
                'share_title'=> $shop['title'],
                'share_photo'=>$cfg['attachurl'].'/'. $shop['logo'],
                'share_content'=> $shop['title']
            );
            $this->msgbox->set_data('data',array('shopinfo'=>$shopinfo,'products'=>array_values($items),'share'=>$share));
        }
    }

    public function detail($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('参数错误',211);
        }else if(!$product = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('商品不存在或已删除',214);
        }else if(!$shop_detail = K::M('shop/shop')->detail($product['shop_id'])){
            $this->msgbox->add('商户不存在或已删除', 213);
        }else if(!$shop_detail['have_waimai']){
            $this->msgbox->add('商户未开通外送店铺', 213);
        }else if(!$waimai = K::M('waimai/waimai')->detail($product['shop_id'])){
            $this->msgbox->add('商户未开通外送店铺', 213);
        }else{
            if(($product['is_spec'] == 1) && ($spec_items = K::M('waimai/productspec')->items(array('product_id'=>$product_id)))) {
                $photos = array();
                foreach($spec_items as $k=>$v) {
                    $photos[] = $v['spec_photo'];
                }
                $product['photos'] = $photos;
                $product['specs'] = array_values($spec_items);
            }else {
                $product['photos'] = array($product['photo']);
                $product['specs'] = array();
            }
            $product['min_amount'] = $waimai['min_amount'];
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$product));
        }
    }

    // 商超的商品分类
    public function marketgoodscate($params)
    {
        if(!$shop_id = (int)$params['shop_id']) {
            $this->msgbox->add('参数错误', 211);
        }else if(!$shop = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户正在审核中', 213);
        }else {        
            $shopinfo = $this->filter_fields('shop_id,city_id,cate_id,cate_title,title,logo,pei_distance,pei_type,yy_status,min_amount', $shop);
            $shopinfo['titleString'] = $shop['title']; //为什么要用titleString，只能再赋值该键值
            $tree = array();
            if($tree = K::M('waimai/productcate')->tree($shop_id)){
                foreach($tree as $k=>$v){
                    if($v['childrens']){
                        $a = $v;
                        unset($a['childrens']);
                        $a['title'] = '全部'.$a['title'];
                        $v['childrens'][0] = $a;
                    }else{
                        $v['childrens'] = array();
                    }
                    ksort($v['childrens']);
                    $v['childrens'] = array_values($v['childrens']);
                    $tree[$k] = $v;
                }
                // foreach($items as $k=>$v){
                //     if($v['parent_id']){
                //         $tree[$v['parent_id']]['childrens'][] = $v;
                //     }else{
                //         $v['childrens'] = array();
                //         $tree[$v['cate_id']] = array_merge((array)$items[$v['cate_id']], $v);
                //     }
                // }
                // foreach($tree as $k=>$v){
                //     if($v['childrens']){
                //         $a = $items[$k];
                //         $a['title'] = '全部'.$a['title'];
                //         $v['childrens'] = array_merge(array($a), $v['childrens']);
                //         $tree[$k] = $v;
                //     }
                // }

            }           
            $this->msgbox->set_data('data', array('items'=>array_values($tree)));
        }

    }

    // 商超商品列表
    public function marketitems($params)
    {
        if(!$shop_id= (int)$params['shop_id']){
            $this->msgbox->add('参数错误',211);
        }else if(!$shop = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('商户不存在', 212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add('商户正在审核中', 213);
        }else{            
            $filter = array('shop_id'=>$shop_id,'closed'=>0,'is_onsale'=>1);
            if($cate_id = (int)$params['cate_id']) {
                $cate_ids = K::M('waimai/productcate')->children_ids($cate_id);
                $filter['cate_id'] = explode(',', $cate_ids);
            }
            $page = max((int)$params['page'], 1);
            $limit = 10;
            if($items = K::M('waimai/product')->items($filter, null, $page, $limit, $count)) {
                $product_ids = array();
                //伪数据，防止APP使用该字段判断，导致没有字段崩溃的问题
                //$spec = array('spec_id'=>'999','product_id'=>'999','price'=>'999','spec_name'=>'999','spec_photo'=>'999','sale_sku'=>'999','sale_count'=>'999');
                foreach($items as $k=>$v){                    
                    // if($v['is_spec']){
                    //     $v['special'] = array($spec);
                    // }else{
                    //     $v['special'] = array();
                    // }
                    $product_ids[$v['product_id']] = $v['product_id'];
                    $v['special'] = $v['specs'] = array();
                    $items[$k] = $v;
                }
                if($spec_list = K::M('waimai/productspec')->items(array('product_id'=>$product_ids))){
                    foreach($spec_list as $v){
                        $items[$v['product_id']]['specs'][] = $v;
                    }
                }
            }else{
                $items = array();
            }

            $shopinfo = $this->filter_fields('shop_id,city_id,cate_id,cate_title,title,logo,pei_distance,pei_type,yy_status,min_amount', $shop);
            $shopinfo['titleString'] = $shop['title']; //为什么要用titleString，只能再赋值该键值
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'url'=>$this->mklink('waimai/product/index', array($shop_id), null, 'www'),
                'title'=> $shop['title'],
                'photo'=>$cfg['attachurl'].'/'. $shop['logo']
            );
            $this->msgbox->set_data('data',array('shopinfo'=>$shopinfo,'products'=>array_values($items),'share'=>$share));
        }
    }

     // 销量排序从多到少
    protected function sales_order($a, $b)
    {
        if ($a['sale_'] == $b['sales']) {
            return 0;
        }
        return ($a['sales'] > $b['sales']) ? -1 : 1;
    }

}
