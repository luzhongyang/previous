<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Sign extends Ctl_Card
{
    public function index()
    {
        $today = strtotime(date('Y-m-d'));
        $filter = array(
            'uid'=>$this->uid,
            'card_id'=>$this->card['card_id'],
            'dateline'=> '>:'.$today
        );

        if($sign = K::M('card/sign')->find($filter)){
           
            $this->pagedata['sign'] = $sign;
        }
       
        $this->tmpl = 'shop/card/sign/index.html';
    }
    
    
    public function exchange(){
        $product_id = (int)$this->GP('product_id');
        if(!$product_id){
            $this->msgbox->add('不存在的商品!',211);
        }else if(!$product = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('不存在的商品!',212);
        }else if($this->card['jifen'] < $product['jifen']){
            $this->msgbox->add('抱歉卡上积分不足!',213);
        }else{
            K::M('jifen/product')->update_count($product_id,'stock',-1);
            $num = 1;
            $total_jifen = $num*$product['jifen'];
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

            K::M('jifen/order')->create($order_data);

            K::M('card/card')->update_count($this->card['card_id'],'jifen',($total_jifen*-1));
            $card_log_data = array(
                'card_id'=>$this->card['card_id'],
                'type'=>'jifen',
                'number'=>$total_jifen,
                'intro'=>'兑换商品：（'.$product['title'].'）'.$num.'个',
                'day'=>date('Ymd'),
                'dateline'=>time()
            );
            K::M('card/log')->create($card_log_data,true);
            $this->msgbox->add('兑换成功!');
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
        $this->tmpl = 'shop/card/sign/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    /**
     * 积分明细
     */
    public function jifeninfo()
    {
        $this->tmpl = 'shop/card/sign/jifeninfo.html';
    }

    /**
     * 积分明细load
     */
    public function jifeninfo_loaditems($page = 1)
    {

        $filter = array(
            'card_id' => $this->card['card_id'],
            'type'    => array('jifen','money')
        );
        $page = max((int) $page, 1);
        $limit = 10;
        if(!$items = K::M('card/log')->items($filter, array('log_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }
        $array = array();
        foreach ($items as $items){

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
        $this->tmpl = 'shop/card/sign/jifeninfo_loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    /**
     * 兑换记录
     */
    public function jifenorder()
    {
        $this->tmpl = 'shop/card/sign/jifenorder.html';
    }
    
    /**
     * 兑换记录load
     */
    public function jifenorder_loaditems($page = 1)
    {
        $filter = array(
            'uid'=>$this->uid,
            'card_id' => $this->card['card_id'],
            'shop_id'    => SHOP_ID
        );
        
        $page = max((int) $page, 1);
        $limit = 10;
        if(!$items = K::M('jifen/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('jifen/order')->count($filter);
        if($count_num <= $limit){
            $loadst = 0;
        }
        else{
            $loadst = 1;
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/card/sign/jifenorder_loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    /**
     * 签到
     */
    public function sign_handel(){
        $today = strtotime(date('Y-m-d'));
        $filter = array(
            'uid'=>$this->uid,
            'card_id'=>$this->card['card_id'],
            'dateline'=> '>:'.$today
        );
        if($sign = K::M('card/sign')->find($filter)){
            $this->msgbox->add('您已经签到过了！',211);
        }else{
            $cashier = K::M('cashier/cashier')->find(array('shop_id'=>SHOP_ID));
            $jifen = $cashier['sign_jifen'];
            $data = array(
                'uid'=>$this->uid,
                'card_id'=>$this->card['card_id'],
                'jifen'=>$jifen
            );
            $inc = K::M('card/card')->update_count($this->card['card_id'],'jifen',$jifen);
            K::M('card/sign')->create($data);
            $this->msgbox->add('签到成功！');
        }
    }

}
