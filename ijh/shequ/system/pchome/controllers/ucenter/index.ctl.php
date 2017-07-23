<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Index extends Ctl_Ucenter
{

    public function index()
    {
        $filter = array('uid'=>$this->uid,'closed'=>0,'from' => "<>:weidian");
        if (!$items = $this->_order_items($filter, array('order_id'=>'desc'), 1, 5)) {
            $items= array();
        }
        //print_r($items);die;
        $this->pagedata['items'] = $items;
        //未使用红包数
        $this->pagedata['hongbao_count'] = K::M('hongbao/hongbao')->count(array('uid'=>$this->uid, 'order_id'=>0,'ltime'=>'>:'.__TIME));
        $this->tmpl = 'pchome/ucenter/index.html';
    }
    
    
    protected function _order_items($filter, $orderby, $page=1, $limit=10, &$count=0)
    {
        $items = array();
        if($order_list = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $order_ids = $shop_ids = $staff_ids = $waimai_shop_ids = array();
            foreach($order_list as $k=>$v){
                if($v['shop_id']){
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                }
                $staff_ids[$v['staff_id']] = $v['staff_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
                if($v['from'] == 'tuan'){
                    $tuan_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'maidan'){
                    $maidan_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'waimai'){
                    $waimai_shop_ids[$v['shop_id']] = $v['shop_id'];
                    $waimai_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'paotui'){
                    $paotui_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'house'){
                    $house_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'weixiu'){
                    $weixiu_order_ids[$v['order_id']] = $v['order_id'];
                }elseif($v['from'] == 'mall'){
                    $mall_order_ids[$v['order_id']] = $v['order_id'];
                }
            }
            if($tuan_order_ids){
                if($tuan_order_list = K::M('tuan/order')->items_by_ids($tuan_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $tuan_order_list[$v['order_id']]){
                            $row['photo'] = $v['tuan_photo'];
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                }
            }
            if($maidan_order_ids){
                if($maidan_order_list = K::M('maidan/order')->items_by_ids($maidan_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $maidan_order_list[$v['order_id']]){
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                }
            }
            if($waimai_order_ids){
                if($waimai_order_list = K::M('waimai/order')->items_by_ids($waimai_order_ids)){
                    $waimai_list = K::M('waimai/waimai')->items_by_ids($waimai_shop_ids);
                    foreach($order_list as $k=>$v){
                        if($row = $waimai_order_list[$v['order_id']]){
                             if($a = $waimai_list[$v['shop_id']]){
                                $v['waimai_title'] = $a['title'];
                                $v['waimai_logo'] = $a['logo'];
                            }else{
                                $v['waimai_title'] = '';
                                $v['waimai_logo'] = 'default/shop.png';
                            }
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                    $order_products = K::M('waimai/orderproduct')->items(array('order_id'=>$waimai_order_ids));
                    $product_ids = array();
                    foreach($order_products as $k=>$v){
                        $product_ids[$v['product_id']] = $v['product_id'];
                    }
                    if($product_ids){
                        $products = K::M('waimai/product')->items_by_ids($product_ids);
                    }
                    foreach($order_products as $k=>$v){
                        foreach($products as $k1=>$v1){
                            if($v['product_id'] == $v1['product_id']){
                                $order_products[$k]['product'] = $v1;
                            }
                        }
                    }
                    foreach($order_list as $k=>$v){
                        foreach($order_products as $k1=>$v1){
                            if($v['order_id'] == $v1['order_id']){
                                $order_list[$k]['order_products'][] = $v1;
                            }
                        }
                    }  
                }
            }
            if($paotui_order_ids){
                if($paotui_order_list = K::M('paotui/order')->items_by_ids($paotui_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $paotui_order_list[$v['order_id']]){
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                }
            }
            if($weixiu_order_ids){
                if($weixiu_order_list = K::M('weixiu/order')->items_by_ids($weixiu_order_ids)){
                    $weixiu_cate_list = K::M('weixiu/cate')->fetch_all();
                    foreach($order_list as $k=>$v){
                        if($row = $weixiu_order_list[$v['order_id']]){
                            $row['icon'] = $weixiu_cate_list[$row['cate_id']]['icon'];
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                }
            }
            if($house_order_ids){
                if($house_order_list = K::M('house/order')->items_by_ids($house_order_ids)){
                    $house_cate_list = K::M('house/cate')->fetch_all();
                    foreach($order_list as $k=>$v){
                        if($row = $house_order_list[$v['order_id']]){
                            $row['icon'] = $house_cate_list[$row['cate_id']]['icon'];
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                }
            }
            //积分商城订单
            if($mall_order_ids){
                $order_products = K::M('mall/order/product')->items(array('order_id'=>$mall_order_ids));
                $product_ids = array();
                foreach($order_products as $k=>$v){
                    $product_ids[$v['product_id']] = $v['product_id'];
                }
                if($product_ids){
                    $products = K::M('mall/product')->items_by_ids($product_ids);
                }
                foreach($order_products as $k=>$v){
                    foreach($products as $k1=>$v1){
                        if($v['product_id'] == $v1['product_id']){
                            $order_products[$k]['product'] = $v1;
                        }
                    }
                }
                foreach($order_list as $k=>$v){
                    foreach($order_products as $k1=>$v1){
                        if($v['order_id'] == $v1['order_id']){
                            $order_list[$k]['order_products'][] = $v1;
                        }
                    }
                }
            }
            $shops = K::M('shop/shop')->items_by_ids($shop_ids);
            foreach($order_list as $k=>$v){
                foreach($shops as $k1=>$v1){
                    if($v['shop_id'] == $v1['shop_id']){
                        $order_list[$k]['shop'] = $v1;
                    }
                }
            }
        }
        return $order_list;
    }

}
