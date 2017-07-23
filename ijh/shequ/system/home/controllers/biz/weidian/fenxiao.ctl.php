<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

Import::C('biz/weidian/order');
class Ctl_Biz_Weidian_Fenxiao extends Ctl_Biz_Weidian_Order
{

    /**
     * 微分销
     */
    public function index()
    {
        if($data = $this->checksubmit('data')){

            if(K::M('shop/shop')->update($this->shop_id,array('have_fenxiao'=>$data['have_fenxiao']))){
                $this->msgbox->add('设置成功');
            }

        }else{
            $fenxiao = $this->system->config->get('fenxiao');
            $this->shop['have_fenxiao'] = min($fenxiao['level'], $this->shop['have_fenxiao']);
            $this->pagedata['fenxiao'] = $fenxiao;
            $this->pagedata['shop'] = $this->shop;
            $this->tmpl = 'biz/weidian/fenxiao/index.html';
        }
    }
    
    
    /*微分销申请的店铺列表*/
    public function items(){
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('fenxiao/fenxiao')->items($filter, array('sid'=>'desc'), $page, $limit, $count)){
            $shop_ids = $uids = array();
            foreach($items as $k => $v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            $shops = K::M('shop/shop')->items_by_ids($shop_ids);
            $members = K::M('member/member')->items_by_ids($uids);
            foreach($items as $k => $v){
                $items[$k]['member'] = $members[$v['uid']];
                $items[$k]['shop'] = $shops[$v['shop_id']];
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/weidian/fenxiao/items.html';
    }
    
    /*微分销店铺状态设置*/
    public function set_status($sid,$status){
        if(!$sid){
            $this->msgbox->add('分销店铺不存在', 211);
        }elseif(!$fenxiao = K::M('fenxiao/fenxiao')->detail($sid)){
            $this->msgbox->add('分销店铺不存在', 212);
        }else{
            if($status){
                if(!in_array($status,array(1,2))){
                   $this->msgbox->add('设置错误', 213); 
                }else{
                    if(K::M('fenxiao/fenxiao')->update($sid, array('status'=>$status))){
                        $this->msgbox->add('设置成功');
                    }
                }
            }else{
                if($fenxiao['status'] == 1){
                    $set = 2;
                }else if($fenxiao['status'] == 2){
                    $set = 1;
                }
                if(K::M('fenxiao/fenxiao')->update($sid, array('status'=>$set))){
                    $this->msgbox->add('设置成功');
                }
            }
            
        }
    }
    
    public function set_deny($sid){
        if(!$sid){
            $this->msgbox->add('分销店铺不存在', 211);
        }elseif(!$fenxiao = K::M('fenxiao/fenxiao')->detail($sid)){
            $this->msgbox->add('分销店铺不存在', 212);
        }elseif($fenxiao['status'] != 0){
            $this->msgbox->add('分销店铺状态不可拒绝', 213);
        }else{
            $m = K::M('fenxiao/member')->find(array('sid'=>$sid));
            K::M('fenxiao/fenxiao')->delete($sid);
            K::M('fenxiao/member')->delete($m['id']);
            $this->msgbox->add('操作成功');
        }
    }




    /*分销商品列表*/
    public function product(){
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['is_fenxiao'] = 1;
        $filter['type'] = 'default';
        if($items = K::M('weidian/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/weidian/fenxiao/product.html';
    }
    
    
    /**
     * 分销订单列表
     */
    public function orders($page)
    {
        $this->weidian($page, 'fenxiao');
    }
    /**
     * 待发货
     */
    public function f_fahuo($page)
    {
        $this->fahuo($page, 'fenxiao');
    }
    /**
     * 待收货
     */
    public function f_shouhuo($page)
    {
        $this->shouhuo($page, 'fenxiao');
    }
    /**
     * 已收货
     */
    public function f_confirm($page)
    {
        $this->confirm($page, 'fenxiao');
    }
    /**
     * 已完成
     */
    public function f_complete($page)
    {
        $this->complete($page, 'fenxiao');
    }
    /*
     * 已取消
     */
    public function f_cancellist($page)
    {
        $this->cancellist($page, 'fenxiao');
    }
    /**
     * 自提单
     */
    public function f_ziti($page)
    {
        $this->ziti($page, 'fenxiao');
    }
    
}
