<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Comment extends Ctl_Web_Ucenter {


    public function index($page=1)
    {
        $pager = $filter = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $pager['count'] = $count = 0;
        
        $filter = array('uid'=>$this->uid,'order_status'=>8,'comment_status'=>1);
        $new_3month = __TIME - 86400*90;
        //$filter['dateline'] = ">=:".$new_3month;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $order_ids = $shop_ids = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($shop_ids){
                $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($order_ids){
                $products = K::M('order/product')->items(array('order_id'=>$order_ids)); 
                $comments = K::M('shop/comment')->items(array('order_id'=>$order_ids)); 
            }
            $comment_ids = array();
            foreach($comments as $val){
                $comment_ids[$val['comment_id']] = $val['comment_id'];
            }
            if($comment_ids){
                $photos = K::M('shop/photo')->items(array('comment_id'=>$comment_ids));
            }
            foreach($comments as $k=>$val){
                if($val['score']<=2){
                    $comments[$k]['ping'] = "差评";
                }elseif($val['score']>=4){
                    $comments[$k]['ping'] = "好评";
                }else{
                    $comments[$k]['ping'] = "中评";
                }
                foreach($photos as $kk=>$v){
                    if($val['comment_id'] == $v['comment_id']){
                        $comments[$k]['photos'][] = $v;
                    }
                }
            }
            //print_r($comments);die;
            foreach($items as $k=>$val){
                foreach($products as $kk=>$v){
                    if($v['order_id'] == $val['order_id']){
                        $items[$k]['product'][] = $v;
                    }
                }
                foreach($comments as $vv){
                    if($vv['order_id'] == $val['order_id']){
                        $items[$k]['comment'] = $vv;
                    }
                }
            }
        }
        //print_r($this->system->db->SQLLOG());die;
        //print_r($items);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'web/ucenter/comment/items.html';
    }
    
    

    
    public function detail($order_id){
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }elseif($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法的订单操作'),213);
        }else{
            $detail['comment'] = K::M('shop/comment')->find(array('order_id'=>$order_id));
            $detail['comment']['photos'] = K::M('shop/photo')->items(array('comment_id'=>$detail['comment']['comment_id']));
            
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->pagedata['products'] = K::M('order/product')->items(array('order_id'=>$order_id));
            $this->pagedata['logs'] = K::M('order/log')->items(array('order_id'=>$order_id),array('log_id'=>'desc')); 
            $this->tmpl = 'web/ucenter/comment/detail.html';
        }
    }

}
