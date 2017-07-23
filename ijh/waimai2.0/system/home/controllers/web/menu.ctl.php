<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Web_Menu extends Ctl_Web
{
   public function index($shop_id)
   {
       //$this->error(404);
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add(L('商家不存在'), 301);
        }elseif(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'), 302);
        }elseif($detail['closed'] != 0||$detail['audit'] !=1){
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        }else{
            if($kw = $this->GP('kw')){
                $filter['title'] = "LIKE:%" . $kw . "%";
                $pager['kw'] = $kw;
                $this->pagedata['pager'] = $pager;
            }
            $filter['shop_id'] = $shop_id;

            $this->pagedata['act'] = $this->request['act'];
            $cates = K::M('waimai/productcate')->tree($shop_id);
            $products = K::M('waimai/product')->items($filter);
            $yh = K::M('shop/youhui')->items(array('shop_id'=>$shop_id));
            foreach($yh as $k=>$val){
                $detail['youhui_str'] .= sprintf(L("满%s减%s；"), $val['order_amount'], $val['youhui_amount']);
            }
            if($res = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
                $detail['collect'] = 1;
            }else{
                $detail['collect'] = 0;
            }
            $detail['collect_num'] = K::M('shop/collect')->count(array('shop_id'=>$shop_id));

            $carts = $this->getcart($shop_id);
            foreach($products as $k=>$val){
                if($val['is_onsale'] == 1) {
                    $pro_items[$k] = $val;
                }
            }
            $total = 0;
            foreach ($carts as $k=>$val){
                $total += $val['cart_num'];
            }
            $lng = $this->system->cookie->get('lng');
            $lat = $this->system->cookie->get('lat');
            if($detail['lng'] && $detail['lat'] && $lng && $lat){
                $juli = K::M('helper/round')->getdistances($detail['lng'], $detail['lat'], $lng, $lat);
                $juli = ceil($juli / 10);
                $juli = $juli/100;//新距离计算方式wu.
                $_freight = array();
                $_max_freight = array('fkm' => 0, 'fm' => 0);
                foreach($detail['freight_stage'] as $k => $v){
                    if($juli <= $v['fkm']){
                        if($_freight && $_freight['fkm'] > $v['fkm']){
                            $_freight = $v;
                        }else if(empty($_freight)){
                            $_freight = $v;
                        }
                    }
                    if($v['fkm'] > $_max_freight['fkm']){
                        $_max_freight = $v;
                    }
                }
                $freight = $_freight['fm'] ? $_freight['fm'] : $_max_freight['fm'];
            }else{
                $freight = 0;
            }
            $this->pagedata['products'] = $pro_items;
            $this->pagedata['total'] = $total;
            $this->pagedata['url'] = $this->mklink('shop:detail', array('args'=>$shop_id));  
            $this->pagedata['cates'] = $cates;
            $this->pagedata['cate_all'] = K::M('waimai/productcate')->items(array('shop_id'=>$shop_id));
            $this->pagedata['detail'] = $detail;
            $this->pagedata['freight_price'] = $freight;
            $this->tmpl = 'web/menu.html';
        }
   }
   
   public function comment($shop_id, $page=1)
   {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add(L('商家不存在'), 301);
        }elseif(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在'), 302);
        }elseif($detail['closed'] != 0||$detail['audit'] !=1){
            $this->msgbox->add(L('商家未通过审核或商家被删除'), 303);
        }else{
            if($res = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$shop_id))){
                $detail['collect'] = 1;
            }else{
                $detail['collect'] = 0;
            }
            $detail['collect_num'] = K::M('shop/collect')->count(array('shop_id'=>$shop_id));
            //评论分页
            $pager = $filter = array();
            $pager['page'] = $page = max((int)$page, 1);
            $pager['limit'] = $limit = 10;
            $pager['count'] = $count = 0;
            $st = (int) $this->GP('st');
            $filter = array('shop_id'=>$shop_id,'closed'=>0);
            if($st == 3){
                $filter[':SQL'] = " ( score_fuwu<3 || score_kouwei <3) "; //差评
            }elseif($st ==2){
                $filter[':SQL'] = " ( score_fuwu=3 && score_kouwei =3) ";  //中评
            }elseif($st == 1){
                $filter['score_fuwu'] = '>:3';
                $filter['score_kouwei'] = '>:3'; //好评
            }
            if($items = K::M('shop/comment')->items($filter, array('comment_id'=>'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}'),array('st'=>$st)));
            }
            $comment_ids = $uids = array();
            foreach($items as $k=>$val){
                $uids[$val['uid']] = $val['uid'];
                $comment_ids[$val['comment_id']] = $val['comment_id'];
            }
            if($comment_ids){
                $photos = K::M('shop/photo')->items(array('comment_id'=>$comment_ids));
            }
            if($uids){
                $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
            }
            foreach($items as $k=>$val){
                foreach($photos as $kk=>$v){
                    if($val['comment_id'] == $v['comment_id']){
                        $items[$k]['photos'][] = $v; 
                    }
                }
            }
            $this->pagedata['st'] = $st;
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['url'] = $this->mklink('shop:detail', array('args'=>$shop_id));  
            $this->pagedata['avg_comment'] = round($detail['praise_num'] / $detail['comments'], 2) * 100 . '%';
            $this->pagedata['counts'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0));                
            $this->pagedata['count1'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score_fuwu'=>'>:3','score_kouwei'=>'>:3'));  
            $this->pagedata['count2'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,':SQL'=>'( score_fuwu=3 && score_kouwei =3)'));      
            $this->pagedata['count3'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,':SQL'=>'( score_fuwu<3 || score_kouwei <3)'));  
            $this->pagedata['num5'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>5));
            $this->pagedata['num4'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>4));
            $this->pagedata['num3'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>3));
            $this->pagedata['num2'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>2));
            $this->pagedata['num1'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>1));
            $this->pagedata['detail'] = $detail;
            $this->pagedata['act'] = $this->request['act'];
            $this->tmpl = 'web/comment.html';
        }
   }
   
   public function ajax_childcate()
   {
        $parent_id = (int)$this->GP('parent_id');
        $shop_id = (int)$this->GP('shop_id');
        if($parent_id > 0 && $shop_id > 0) {
            if($cate = K::M('waimai/productcate')->items(array('parent_id'=>$parent_id,'shop_id'=>$shop_id))) {
                $items = $cate;
            }else {
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',array('items'=>array_values($items)));
        }
   }

   public function ajax_spec()
   {
        $spec_items = array();
        $product_id = (int)$this->GP('product_id');
        $shop_id = (int)$this->GP('shop_id');
        if($pro = K::M('waimai/product')->detail($product_id)) {
            if($pro['shop_id'] == $shop_id && $pro['is_spec'] == 1) {
                $spec_items = K::M('waimai/productspec')->items(array('product_id'=>$product_id));
                foreach ($spec_items as $key => $value) {
                    $spec_items[$key]['title'] = $pro['title'];
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data',array('items'=>array_values($spec_items)));
            }
        }
   }
}
