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
            $this->pagedata['act'] = $this->request['act'];
            $cates = K::M('product/cate')->items(array('shop_id'=>$shop_id));
            $products = K::M('product/product')->items(array('shop_id'=>$shop_id));
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
                if ($val['sale_type'] == 1) {
                    if ($val['sale_sku'] - $val['sale_count'] > 0) {
                        $products[$k]['sku'] = $val['sale_sku'] - $val['sale_count'];
                    } else {
                        $products[$k]['sku'] = 0;
                    }
                } else {
                    $products[$k]['sku'] = 999;
                }
                
                if ($carts[$val['product_id']]['cart_num'] > 0) {
                    $products[$k]['cart_num'] = $carts[$val['product_id']]['cart_num'];
                } else {
                    $products[$k]['cart_num'] = 0;
                }
            }
            $total = 0;
            foreach ($carts as $k=>$val){
                $total += $val['cart_num'];
            }
            $this->pagedata['total'] = $total;
            $this->pagedata['url'] = $this->mklink('shop:detail', array('args'=>$shop_id));  
            $this->pagedata['cates'] = $cates;
            $this->pagedata['products'] = $products;
            $this->pagedata['detail'] = $detail;
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
                $filter['score'] = "<:3";
            }elseif($st ==2){
               $filter['score'] = 3;
            }elseif($st == 1){
                $filter['score'] = ">:3";
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
            $this->pagedata['counts'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0));
            $this->pagedata['count1'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>'>:3'));
            $this->pagedata['count2'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>3));
            $this->pagedata['count3'] = K::M('shop/comment')->count(array('shop_id'=>$shop_id,'closed'=>0,'score'=>'<:3'));
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
   
   
}
