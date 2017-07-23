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
class Ctl_Tuan_Product extends Ctl
{
	// 团购商品列表
    public function goodsitems($shop_id)
    {
        if($shop_id = (int)$shop_id) {
            $detail = K::M("shop/shop")->detail($shop_id);
        }
        $this->pagedata['shop'] = $detail;
    	$this->tmpl = 'tuan/items.html';
    }

    // 下拉加载团购商品列表
    public function loadgoodsitems()
    {
        $filter = array();
        $page = max((int)$this->GP('page'), 1);
        $filter['closed'] = 0;
        $filter['is_onsale'] = 1;
        $shop = K::M('shop/shop')->detail((int)$this->GP('shop_id'));
        if($shop['have_tuan']==1 && $shop['have_quan']==0) {
            $filter['type'] = 'tuan';
        }else if($shop['have_quan']==1 && $shop['have_tuan']==0) {
            $filter['type'] = 'quan';
        }else if($shop['have_tuan']==1 && $shop['have_quan']==1) {
            $filter['type'] = array('tuan','quan');
        }

        $filter['shop_id'] = (int)$this->GP('shop_id');
        if(($page<=10) && $tuan_items = K::M('tuan/tuan')->items($filter,$orderby,1,500,$count)) {
            foreach($tuan_items as $k=>$v) {
                $v['url'] = $this->mklink('tuan/product:goodsdetail', array('args'=>$v['tuan_id']));
                $v['sales'] = $v['sales'] + $v['virtual_sales'];
                $tuan_items[$k] = $v;
            }
            uasort($tuan_items, array($this, 'sales_order'));
            $items = array_slice($tuan_items, ($page-1)*10, 10, true);
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    // 团购商品详情
    public function goodsdetail($tuan_id)
    {
        $this->check_login();
        $filter = $other_tuan = array();
        $lng = $this->request['UxLocation']['lng'];
        $lat = $this->request['UxLocation']['lat'];
        $tuan = K::M('tuan/tuan')->detail($tuan_id);
        if($shop = K::M('shop/shop')->detail($tuan['shop_id'])) {
            if($shop['closed'] == 0 && $shop['audit'] == 1) {
                if($tuan['closed'] == 0 && $tuan['audit'] == 1) {
                    $allow_fields = "tuan_id,shop_id,city_id,type,title,desc,price,market_price,photo,views,stime,ltime,sale_type,sale_sku,sale_count,sales,virtual_sales,info,orderby,audit,closed,clientip,dateline,notice,detail";
                    $tuan = $this->filter_fields($allow_fields, $tuan);
                    $tuan['detail'] = htmlspecialchars_decode($tuan['detail']);
                    if($juli = (int)K::M('helper/round')->juli($shop['lng'], $shop['lat'], $lng, $lat)) {
                        $tuan['juli'] = $juli;
                        $tuan['juli_label'] = K::M('helper/format')->juli($tuan['juli']);
                    }
                    $filter['shop_id'] = $tuan['shop_id'];
                    $filter['tuan_id'] = '<>:'.$tuan_id; // 除了本团购之外的其他四个团购
                    $filter['closed'] = 0;
                    $filter['audit'] = 1;
                    $filter['is_onsale'] = 1;
                    if($other_tuan = K::M('tuan/tuan')->items($filter, array('tuan_id'=>'DESC'), 1, 4, $count)) {
                        foreach($other_tuan as $k=>$v) {
                            $v['url'] = $this->mklink('tuan/product:goodsdetail', array('args'=>$v['tuan_id']));
                            $other_tuan[$k] = $v;
                        }
                    }
                    if($t_order_items = K::M('tuan/order')->items(array('tuan_id'=>$tuan_id,'shop_id'=>$tuan['shop_id']))) {
                        foreach($t_order_items as $k=>$v) {
                            $orderids[] = $v['order_id'];
                        }
                        if($order_items = K::M('order/order')->items(array('order_id'=>$orderids,'order_status'=>8,'from'=>'tuan','shop_id'=>$shop_id))) {
                            foreach($order_items as $k=>$v) {
                                $order_ids[] = $v['order_id'];
                            }
                        }
                    }
                    if($comment_items = K::M('shop/comment')->items(array('order_id'=>$order_ids),array('comment_id'=>'desc'),$page,3,$count)){
                        $ids = array();
                        foreach($comment_items as $k=>$v){
                            $ids[] = $v['comment_id'];
                            $uids[] = $v['uid'];
                            $comment_items[$k]['photos'] = array();
                        }
                        if($photos = K::M('shop/commentphoto')->items(array('comment_id'=>$ids))) {
                            foreach($comment_items as $k=>$v){
                                $comment_items[$k] = $this->filter_fields('comment_id,score,score_fuwu,score_kouwei,uid,content,reply,reply_time,dateline',$v);
                                foreach($photos as $photo){
                                    if($v['comment_id'] == $photo['comment_id']) {
                                        $comment_items[$photo['comment_id']]['photo'][] = $this->filter_fields('photo_id,photo', $photo);
                                    }
                                }
                            }
                        }
                        if($member_items = K::M('member/member')->items(array('uid'=>$uids))) {
                            foreach($member_items as $k1 => $v1) {
                                foreach($comment_items as $k2 => $v2) {
                                    if($v1['uid'] == $v2['uid']) {
                                        $comment_items[$k2]['nickname'] = $v1['nickname'];
                                        $comment_items[$k2]['face'] = $v1['face'];
                                    }
                                }
                            }
                        }
                        $tuan['comments'] = $comment_items;
                    }
                    $tuan['sales'] = $tuan['sales'] + $tuan['virtual_sales'];
                    $this->pagedata['others'] = $other_tuan;
                    $this->pagedata['tuan'] = $tuan;
                    if(isset($_GET['debug'])){
                        header("Content-type: text/html; charset=utf-8");
                        echo '<pre>------<hr />    ';
                        print_r($tuan);
                        die('</pre>');
                    }
                }
                $this->pagedata['shop'] = $shop;
            }
        }
        $this->tmpl = 'tuan/detail.html';
    }

    // 图文详情
    public function tuwendetail($tuan_id)
    {
        if($tuan_id = (int)$tuan_id) {
            if($detail = K::M('tuan/tuan')->detail($tuan_id)) {
                $detail['detail'] = htmlspecialchars_decode($detail['detail']);
                $this->pagedata['detail'] = $detail;
            }
        }
        $this->tmpl = 'tuan/tuwendetail.html';
    }

    public function tuwendetail2()
    {
        if($this->request['IN_APP_CLIENT']){
            $this->tmpl = 'tuan/tuwendetail2.html';
        }else{
           $this->msgbox->add('非法操作', 211);
        }
    }
}