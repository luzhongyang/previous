<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop_Coupon extends Ctl_Biz
{

    public function index($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        if($items = K::M('shop/coupon')->items($filter, array('coupon_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/shop/coupon/index.html';
    }
    
    
    //创建优惠券
    public function create(){
        if($data = $this->checksubmit('data')){

            if(!$data = $this->check_fields($data,'order_amount,coupon_amount,stime,ltime,sku')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if($data['order_amount'] <0 || !$data['order_amount']){
                $this->msgbox->add('订单金额不正确', 212);
            }else if($data['coupon_amount'] <0 || !$data['coupon_amount']){
                $this->msgbox->add('优惠金额不正确', 213);
            }else if($data['coupon_amount'] >= $data['order_amount']){
                $this->msgbox->add('优惠金额必须小于订单金额', 214);
            }else if(!$data['ltime']){
                $this->msgbox->add('时间没有设置', 215);
            }else if($data['ltime'] <= $data['stime']){
                $this->msgbox->add('结束时间必须大于开始时间', 216);
            }else if(!$data['sku']){
                $this->msgbox->add('库存没有填写', 217);
            }else{
                $data['shop_id'] = $this->shop_id;
                $data['stime'] = __TIME;
                $data['ltime'] = strtotime($data['ltime']);
                if(K::M('shop/coupon')->create($data)){
                    $this->msgbox->add('创建成功!');
                    $this->msgbox->set_data('forward',  $this->mklink('biz/shop/coupon:index'));
                 }else{
                     $this->msgbox->add('创建失败!',300);
                 }
            }
        }else{
            $this->tmpl = 'biz/shop/coupon/create.html';
        }          
    }
    
    public function delete($coupon_id=null)
    {
        if($coupon_id = (int)$coupon_id){
            if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('shop/coupon')->delete($coupon_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
    /**
     * 编辑优惠券
     */
    public function edit($coupon_id){
        if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
            $this->msgbox->add('不存在的广告',211);
        }else if($data = $this->checksubmit('data')){
            if(isset($data['stime'])){
                $data['stime'] = strtotime($data['stime']);
            }
            if(isset($data['ltime'])){
                $data['ltime'] = strtotime($data['ltime']);
            }
            unset($data['stime']);
            if(K::M('shop/coupon')->update($coupon_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            //查询是否有人领取过该店优惠券
            $member_coupon = K::M('member/coupon')->items(array('coupon_id'=>$coupon_id));
            $this->pagedata['member_coupon'] = $member_coupon;
            
            $detail['stime'] = date('Y-m-d H:i:s',$detail['stime']);
            $detail['ltime'] = date('Y-m-d H:i:s',$detail['ltime']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/shop/coupon/edit.html';
        }
    }
   
}