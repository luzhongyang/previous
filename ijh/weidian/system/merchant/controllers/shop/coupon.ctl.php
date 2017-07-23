<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Coupon extends Ctl
{

    public function index($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_amount']){$filter['order_amount'] = $SO['order_amount'];}
            if($SO['coupon_amount']){$filter['coupon_amount'] = $SO['coupon_amount'];}
            if($SO['sku']){$filter['sku'] = $SO['sku'];}
            if($SO['picked']){$filter['picked'] = $SO['picked'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['stime'])){if($SO['stime'][0] && $SO['stime'][1]){$a = strtotime($SO['stime'][0]); $b = strtotime($SO['stime'][1])+86400;$filter['stime'] = $a."~".$b;}}
            if(is_array($SO['ltime'])){if($SO['ltime'][0] && $SO['ltime'][1]){$a = strtotime($SO['ltime'][0]); $b = strtotime($SO['ltime'][1])+86400;$filter['ltime'] = $a."~".$b;}}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }

        if($items = K::M('shop/coupon')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }

        $cate = K::M('shop/cate')->detail($this->shop['cate_id']);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['shop'] = $this->shop;
        $this->tmpl = 'merchant:shop/coupon/index.html';
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
                $data['stime'] = time();
                $data['ltime'] = strtotime($data['ltime'])+86399;
                if(K::M('shop/coupon')->create($data)){
                    $this->msgbox->add('创建成功!');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/coupon:index'));
                 }else{
                     $this->msgbox->add('创建失败!',300);
                 }
            }
        }else{
            $this->tmpl = 'merchant:shop/coupon/create.html';
        }          
    }
    
    public function delete($coupon_id=null)
    {
        // if($coupon_id = (int)$coupon_id){
        //     if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
        //         $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
        //     }else if($detail['shop_id'] != $this->shop_id){
        //         $this->msgbox->add('非法操作', 213);
        //     }else{
        //         if(K::M('shop/coupon')->delete($coupon_id)){
        //             $this->msgbox->add('删除内容成功');
        //         }
        //     }
        // }else{
        //     $this->msgbox->add('未指定要删除的内容ID', 401);
        // }
        if($coupon_id = (int)$coupon_id){
            $m_coupon = K::M('member/coupon')->find(array('coupon_id' => $coupon_id));
            if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
                $this->msgbox->add('你要删除的优惠券不存在或已经删除', 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }
            else if($m_coupon && $detail['ltime'] > __TIME){  // 当券未过期且用户领取过了不能删除
                $this->msgbox->add('未过期不能删除', 214);
            }
            else{
                if(K::M('shop/coupon')->delete($coupon_id)){
                    //K::M('shop/shop')->change_coupon($detail['shop_id']);
                    $this->msgbox->add('操作成功');
                }
            }
        }
        else{
            $this->msgbox->add('未指定要删除的优惠ID', 401);
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
                $data['ltime'] = strtotime($data['ltime'])+86399;
            }
            if(K::M('shop/coupon')->update($coupon_id, $data)){
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/coupon:index'));
            }
        }else{
            //查询是否有人领取过该店优惠券
            $member_coupon = K::M('member/coupon')->items(array('coupon_id'=>$coupon_id));
            $this->pagedata['member_coupon'] = $member_coupon;
            
            $detail['stime'] = date('Y-m-d H:i:s',$detail['stime']);
            $detail['ltime'] = date('Y-m-d H:i:s',$detail['ltime']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:shop/coupon/edit.html';
        }
    }
    
    public function so() 
    {
        $this->tmpl = 'merchant:shop/coupon/so.html';
    }
}