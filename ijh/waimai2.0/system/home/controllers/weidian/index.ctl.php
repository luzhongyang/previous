<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}
class Ctl_Weidian_Index extends Ctl_Weidian
{
	// 首页
	public function index($shop_id)
	{
        $shop = $this->shop;
        $shop['is_best'] = K::M('waimai/product')->find(array('shop_id'=>$shop['shop_id'],'is_best'=>1,'closed'=>0,'is_onsale'=>1));
        $shop['cate_list'] = K::M('waimai/productcate')->items(array('shop_id'=>$shop['shop_id'],'parent_id'=>0),array('cate_id'=>'desc'),1,500,$count);
        $shop['manjian'] = $shop['order_youhui'];
        $this->pagedata['shop'] = $shop;
        $this->pagedata['adv_item'] = K::M('shop/weidianbanner')->items(array('shop_id'=>$_SESSION['WEIDIAN_SHOP_ID'],'closed'=>0),array('orderby'=>'asc'),$page,$limit,$count);
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
		$this->tmpl = 'weidian/'.$this->default_weidian_theme().'/index.html';
	}

	// 外卖商品列表
	public function goodsitems()
	{
		$shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        if(!$shop = K::M('shop/shop')->detail($shop_id)) {
			$this->msgbox->add('商家不存在',210);
		}else if($shop['audit']!=1 || $shop['closed']!=0) {
			$this->msgbox->add('商家不存在或已被删除',211);
		}else if($shop['weidian'] != 1) {
			$this->msgbox->add('该商家暂未开通微店功能',212);
		}else {
			$items = $spec_items = $goods_list = $filter = $pro_ids = array();
			$filter['closed'] = 0;
	        $filter['is_onsale'] = 1;
	        $filter['shop_id'] = $shop_id;
	        $page = max((int)$this->GP('page'), 1);
	        if($cate_id = (int)$this->GP('cate_id')) {
	        	$cate = K::M('waimai/productcate')->items(array('parent_id'=>$cate_id));
	        	foreach($cate as $k=>$v) {
	        		$cate_ids[] = $v['cate_id'];
	        	}
	        	$cate_ids[] = $cate_id;
	        	$filter['cate_id'] = $cate_ids;
	        }
	        if($this->GP('dateline') == 'dateline_asc') {
	        	$orderby['dateline'] = 'asc';
	        }else if($this->GP['dateline'] == 'dateline_desc'){
	        	$orderby['dateline'] = 'desc';
	        }
	        if($this->GP('sales') == 'sales_desc') {
	        	$orderby['sales'] = 'desc';
	        }else if($this->GP('sales') == 'sales_asc'){
	        	$orderby['sales'] = 'asc';
	        }
	        if($this->GP('price') == 'price_desc') {
	        	$orderby['price'] = 'desc';
	        }else if($this->GP('price') == 'price_asc'){
	        	$orderby['price'] = 'asc';
	        }
			if(($page <= 10) && $goods_list = K::M('waimai/product')->items($filter, $orderby, 1, 500, $count)){
				foreach ($goods_list as $k => $v) {
					if($v['is_spec'] != 0) {
						$pro_ids[$v['product_id']] = $v['product_id'];
					}
					$goods_list[$k]['link_url'] = $this->mklink('weidian_'.$shop_id.'/waimai:goods_detail', array('args'=>$v['product_id']));
				}
				$spec_items = K::M('waimai/productspec')->items(array('product_id'=>$pro_ids));
	            $items = $goods_list; 
		        //$items = array_slice($items, ($page-1)*10, 2, true);
	        }else {
	            $items = array();
	        }
			$this->msgbox->add('success');
			$this->msgbox->set_data('data',array('items'=>array_values($items),'spec_items'=>$spec_items));
		}  
	}

	// 店铺推荐商品列表
	public function is_best_goodsitems()
	{
		$shop_id = $_SESSION['WEIDIAN_SHOP_ID'];
        $shop = $this->shop;

        $items = K::M('waimai/product')->items(array('shop_id'=>$shop_id,'closed'=>0,'is_onsale'=>1,'is_best'=>1),array('product_id'=>'desc'),1,500,$count);
        if(is_array($items)) {
            foreach($items as $k=>$v) {
                $items[$k]['url'] = $this->mklink('weidian_'.$shop_id.'/waimai:goods_detail',array('args'=>$v['product_id']));
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/is_best.html';
	}
}