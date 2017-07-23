<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Jifen extends Ctl_Card
{
    public function index()
    {

        $filter = array(
            'card_id'=>$this->card['card_id'],
            'dateline'=> '>:'.$this->system->sdaytime
        );
        $this->pagedata['today_is_sign'] = K::M('card/sign')->count($filter);
        $this->tmpl = 'shop/card/jifen/index.html';
    }


    /**
     *
     */
    public function exchange(){
        $product_id = (int)$this->GP('product_id');
        if(!$product_id){
            $this->msgbox->add('商品不存在!',211);
        }else if(!$product = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('商品不存在!',212);
        }else if($product['shop_id'] != SHOP_ID){
            $this->msgbox->add('商品不存在!', 212);
        }else if($this->card['jifen'] < $product['jifen']){
            $this->msgbox->add('抱歉卡上积分不足!',213);
        }else if((int)$product['stock'] <= 0){
            $this->msgbox->add('商品库存不足!',219);
        } else {
            $num = max((int)$this->GP('num'), 1);
            $total_jifen = $num * $product['jifen'];
            $order_data = array(
                'shop_id'=>SHOP_ID,
                'uid'=>$this->uid,
                'card_id'=>$this->card['card_id'],
                'product_id'=>$product_id,
                'product_title'=>$product['title'],
                'product_number'=>$num,
                'product_jifen'=>$product['jifen'],
                'total_jifen'=>$total_jifen,
                'order_status'=>0
            );
            if($order_id = K::M('jifen/order')->create($order_data)){
                K::M('jifen/product')->update_count($product_id, 'stock', -$num);
                K::M('card/card')->update_jifen($this->card['card_id'], -$total_jifen, '兑换商品：（'.$product['title'].'）'.$num.'个', $order_id);
                $this->msgbox->add('兑换商品成功!');
            }
        }
    }

    public function loaditems($page = 1)
    {
        $filter = array('shop_id' => SHOP_ID);
        $page = max((int) $page, 1);
        $limit = 10;
        if(!$items = K::M('jifen/product')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('jifen/product')->count($filter);
        if($count_num <= $limit){
            $loadst = 0;
        }
        else{
            $loadst = 1;
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/card/jifen/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    /**
     * 积分明细
     */
    public function jifeninfo()
    {

        $this->tmpl = 'shop/card/jifen/jifeninfo.html';
    }

    /**
     * 积分明细load
     */
    public function jifeninfo_loaditems($page = 1)
    {

        $filter = array(
            'card_id' => $this->card['card_id'],
            'type'    => jifen
        );
        $page = max((int) $page, 1);
        $limit = 10;
        if(!$items = K::M('card/log')->items($filter, null, $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('card/log')->count($filter);
        if($count_num <= $limit){
            $loadst = 0;
        }
        else{
            $loadst = 1;
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/card/jifen/jifeninfo_loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    /**
     * 兑换记录
     */
    public function jifenorder()
    {
        $this->tmpl = 'shop/card/jifen/jifenorder.html';
    }
    
    /**
     * 兑换记录load
     */
    public function jifenorder_loaditems($page = 1)
    {
        $filter = array(
            'card_id' => $this->card['card_id'],
            'shop_id'    => SHOP_ID
        );
        $page = max((int) $page, 1);
        $limit = 10;
        if(!$items = K::M('jifen/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }
        $count_num = $count;
        if($count_num <= $limit){
            $loadst = 0;
        } else{
            $loadst = 1;
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/card/jifen/jifenorder_loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    /**
     * 签到
     */
    public function sign_handel()
    {
        $filter = array(
            'card_id'=>$this->card['card_id'],
            'dateline'=> '>:'.$this->system->sdaytime
        );
        if(K::M('card/sign')->count($filter)){
            $this->msgbox->add('您已经签到过了！',211);
        }else{

            $sign_jifen = $this->shop['sign_jifen'];
            $data = array(
                'card_id'=>$this->card['card_id'],
                'jifen'=>$sign_jifen
            );
            K::M('card/sign')->create($data);
            K::M('card/card')->update_jifen($this->card['card_id'], $sign_jifen, '签到赠送'.$sign_jifen.'积分');
            $this->msgbox->add('签到成功！');
            K::M('system/logs')->log("ctl.card.sign_handle", $this->system->db->SQLLOG());
        }
    }

}
