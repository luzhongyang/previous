<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 * check view code by shzhrui
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Waimai_Product extends Ctl
{
    /* 产品products */
    public function index($shop =null, $zhuohao_id=0)
    {
        if(!$shop = (int)$shop){
            $this->msgbox->add('参数不正确',100);
        }
        $zhuohao_id = (int) $zhuohao_id;
        if(!empty($zhuohao_id)){
            $this->cookie->set('zhuohao_id', $zhuohao_id);
        }else{
            if($zhuohao_id = $this->cookie->get('zhuohao_id')){
                $this->cookie->delete('zhuohao_id');
            }
        }
        //分类
        $tree = K::M('waimai/productcate')->tree($shop);
        //产品
        $product = K::M('waimai/product')->items(array('shop_id'=>$shop,'closed'=>0,'is_onsale'=>1),array(),1,500);
        //产品分组
        $data = array();
        foreach($tree as $t){
            $data[$t['cate_id']][0]['title'] = $t['title'];
            foreach($product as $pro){
                if($t['cate_id'] == $pro['cate_id']){
                    $data[$t['cate_id']][1][] = $pro;
                }
            }
        }
        $shop_detail = K::M('waimai/waimai')->detail($shop);

        if($shop_detail['tmpl_type'] == 'market') {
            $this->pagedata['shop'] = $shop_detail;
            $this->pagedata['cates'] = $tree;
            $cate = K::M('waimai/cate')->detail($shop_detail['cate_id']);
            $this->pagedata['back_url'] = $this->mklink('waimai/shop:index', array('args'=>$cate['cate_id']));
            $this->tmpl = 'waimai/product/marketgoods.html';
        }else if($shop_detail['tmpl_type'] == 'waimai') {
            $this->pagedata['song']   = $shop_detail['min_amount'];
            $this->pagedata['cates']   = $tree;
            $this->pagedata['product'] = $data;
            $this->pagedata['shop_id'] = $shop_detail['shop_id'];
            $this->pagedata['shop_title'] = $shop_detail['title'];
            $this->tmpl = 'waimai/product/product.html';
        } 
    }


    /* 商品详情 */
    public function detail($product_id)
    {
        if(!$product_id = (int)$product_id){
            $this->msgbox->add('参数不正确',121);
        }else if(!$detail=K::M('waimai/product')->detail($product_id)){
            $this->error(404);
        }else if(!$shop_detail = K::M('waimai/waimai')->detail($detail['shop_id'])){
            $this->msgbox->add('非法访问',124);
        }else{
            if($spec_list=K::M('waimai/productspec')->items(array('product_id'=>$product_id))){                
                foreach($spec_list as $k=>$v) {
                    $spec_list[$k]['package_price'] = $detail['package_price'];
                    $spec_list[$k]['sale_type'] = $detail['sale_type'];
                    if(empty($v['spec_photo'])){
                        $spec_list[$k]['spec_photo'] = $detail['photo'];
                    }
                }               
            }
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = $shop_detail;
            $this->pagedata['spec_list'] = $spec_list;
            $this->tmpl = 'waimai/product/detail.html';
        }
    }

    // 下拉加载商超商品列表
    public function loadmarketgoods()
    {
        $orderby = $filter = array();
        $filter = array('is_onsale'=>1, 'closed'=>0);
        if($this->GP('cate_id') > 0) {
            $filter['cate_id'] = $this->GP('cate_id');
        }
        $filter['shop_id'] = $this->GP('shop_id');
        $page = max((int)$this->GP('page'), 1);
        
        if(($page <= 10) && $goods_items = K::M('waimai/product')->items($filter, $orderby, 1, 500, $count)) {
            foreach($goods_items as $k=>$v) {
                $v['url'] = $this->mklink('waimai/product:detail', array('arg0'=>$v['product_id']));
                $goods_items[$k] = $v;
            }
            uasort($goods_items, array($this, 'sales_order'));
            $items = array_slice($goods_items, ($page-1)*10, 10, true);
        }

        $this->msgbox->add('success');
       // echo '<pre>';print_r($items);die;
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'shop_id'=>$shop_id));
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
