<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_cashier extends Ctl
{
    
    public function index($page=1)
    {
    	$filter_shop=$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){
                $filter_shop['title'] = "LIKE:%".$SO['title']."%";
            }
            if($SO['mobile']){
                $filter_shop['mobile'] = $SO['mobile'];
            }
            $arr = K::M('shop/shop')->items($filter_shop);
          foreach ($arr as $v){
              $filter['shop_id'][] = $v['shop_id'];
          }
            if($SO['shop_id']){
                unset( $filter['shop_id']);
                $filter['shop_id']=$SO['shop_id'];
            }
            


        }
        if($items = K::M('cashier/cashier')->items($filter, array('shop_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        foreach ($items as $k => $v) {
            $shopids[$v['shop_id']] = $v['shop_id'];
        }
        if($shop_items = K::M('shop/shop')->items_by_ids($shopids)) {
            $this->pagedata['shop_items'] = $shop_items;
        }
        $this->pagedata['moling'] = K::M('cashier/cashier')->moling();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/cashier/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/cashier/so.html';
    }
    public function detail($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('cashier/cashier')->detail($shop_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $detail['shop'] = K::M('shop/shop')->detail($shop_id);
            if($detail['package']){
                $package = explode(",",$detail['package']);
            }
            foreach ($package as $k => $v) {
                $packages[] = explode(":",$v);
            }
            if($detail['discount']){
                $discount = explode(",",$detail['discount']);
            }
            $this->pagedata['discount'] = $discount;
            $this->pagedata['packages'] = $packages;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['moling'] = K::M('cashier/cashier')->moling();
            $this->pagedata['payee_alipay'] = K::M('alipay/alipay')->detail($shop_id);
            $this->pagedata['payee_wxpay'] = K::M('weixin/wxpay')->detail($shop_id);
            $this->tmpl = 'admin:cashier/cashier/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($shop_id = K::M('cashier/cashier')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/cashier-index.html');
            } 
        }else{
           $this->tmpl = 'admin:cashier/cashier/create.html';
        }
    }
    public function edit($shop_id=null)
    {


        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/cashier')->detail($shop_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(K::M('cashier/cashier')->update($shop_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cashier/cashier/edit.html';
        }
    }
    public function doaudit($shop_id=null)
    {
        if($shop_id&&$data=$this->GP('data')){
            if(!K::M('cashier/cashier')->batch($shop_id,$data['audit'])){
                $this->msgbox->add('操作失败',213);
            }else{
                $this->msgbox->add('操作成功');
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('cashier/cashier')->batch($ids,1)){
                $this->msgbox->add('批量修改成功');
            }else{
                $this->msgbox->add('批量修改失败',214);
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if(!$detail = K::M('cashier/cashier')->detail($shop_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cashier/cashier')->delete($shop_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('cashier/cashier')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}