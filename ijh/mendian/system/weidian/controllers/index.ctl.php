<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Index extends Ctl
{

    /**
     * 微店首页
     */
    public function index()
    {


        if('/weidian' == $_SERVER['REQUEST_URI'] || '/weidian/' == $_SERVER['REQUEST_URI']){
            $this->shop_id = K::M('system/session')->delete('WEIDIAN_SHOP_ID');//删除当前微店shopid
            $this->tmpl = 'weidian/index/weidian.html';
        }
        else{

            //店铺幻灯片
            $banner = K::M('weidian/banner')->items(array('shop_id' => $this->shop_id, 'closed' => 0, 'audit' => 1), array('orderby' => 'desc'), 1, 5);
            $this->pagedata['banner'] = $banner;
            //店铺活动
            $huodong = K::M('weidian/huodong')->find(array('shop_id'=>$this->shop_id,'display'=>1),array('id'=>'desc'));
            $this->pagedata['huodong'] = $huodong;
            //店铺优惠券
            $coupon = K::M('shop/coupon')->items(array('shop_id' => $this->shop_id, 'ltime' => '>:' . time(), 'sku' => '>:0', 'closed' => 0));
            $coupon_ids = array();
            foreach($coupon as $k => $v){
                $coupon_ids[$v['coupon_id']] = $v['coupon_id'];
            }
            $in_my_coupon = K::M('member/coupon')->items(array('coupon_id' => $coupon_ids, 'uid' => $this->uid));
            foreach($in_my_coupon as $k => $v){
                $new_in_my_coupon[$v['coupon_id']] = $v;
            }
            foreach($coupon as $k => $v){
                if($new_in_my_coupon[$v['coupon_id']]){
                    $coupon[$k]['have'] = 1;
                }
                else{
                    $coupon[$k]['have'] = 0;
                }
            }

            $this->pagedata['coupon'] = $coupon;
            //店铺推荐单品
            $filter = array(
                'shop_id'   => $this->shop_id,
                'type'      => 'default',
                'closed'    => 0,
                'is_onsale' => 1
            );

            if($title = strip_tags(trim($this->GP('title')))){
                $filter['title'] = "LIKE:%" . $title . "%";
            }
            $product = K::M('weidian/product')->items($filter, array('dateline' => 'desc'), 1, 4);
            $this->pagedata['product'] = $product;
            $this->pagedata['is_index'] = 1;
            $this->tmpl = 'weidian/index/index.html';
        }
    }
    
    /**
     * 微店列表
     */
    public function loaditems($page = 1)
    {

        //查询默认拼团列表
        $filter = array(
            'have_weidian'  => 1,
            'closed'  => 0
        );

        $page = max((int) $page, 1);
        $limit = 10;

        if(!$items = K::M('shop/shop')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }else{
            foreach($items as $k => $v){
                $v['juli'] = K::M('helper/round')->juli($v['lng'], $v['lat'], $lng, $lat);
                $items[$k]['juli_label'] = K::M('helper/format')->juli($v['juli']);
                $items[$k]['mark'] = ($val['score']/$val['comments']) ? round($val['score']/$val['comments'],2) : 0 ;
                $items[$k]['link'] = 'weidian_'.$v['shop_id'];
            }
        }
  
        $count_num = K::M('weidian/product')->count($filter);
        if($count_num <= $limit){
            $loadst = 0;
        }
        else{
            $loadst = 1;
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'weidian/index/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

}
