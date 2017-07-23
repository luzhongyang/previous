<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Money extends Ctl
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('shop/log')->items($filter, array('log_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/money/index.html';
    }

    
    public function txlog($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('shop/tixian')->items($filter, array('tixian_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['shop'] = $this->shop;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/money/txlog.html';
    }
    
    // 商户申请提现
    public function tixian(){
        $shop = K::M('shop/shop')->detail($this->shop_id);
        $account = K::M('shop/account')->detail($this->shop_id);
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'money,intro')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if($data['money'] <0){
                $this->msgbox->add('金额不正确', 212);
            }else if($data['money'] > $this->shop['money']){
                $this->msgbox->add('余额不足', 213);
            }else if(!$account){
                $this->msgbox->add('账户未设置', 214);
                $this->msgbox->set_data('forward',  $this->mklink('merchant/shop:account'));
            }else if(!$account['account_type']||!$account['account_name']||!$account['account_number']){
                $this->msgbox->add('账户信息不完整', 215);
                $this->msgbox->set_data('forward',  $this->mklink('merchant/shop:account'));
            }else if(K::M('shop/shop')->update_money($this->shop_id,-$data['money'],'余额提现，扣款')){
                $end_money = NULL;
                $end_money = $shop['tixian_percent']*$data['money']/100;
                if(K::M('shop/tixian')->create(array('shop_id'=>$this->shop_id,'money'=>$data['money'],'intro'=>$data['intro'],'account_info'=>'开户行：'.$account['account_type'].'，账户：'.$account['account_number'].',开户人：'.$account['account_name'],'end_money'=>$end_money))){
                    $this->msgbox->add('提现成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/money:txlog'));
                }
             }else{
                 $this->msgbox->add('提现失败',216);
             }
        }else{
            $this->pagedata['acc'] = $account;
            $this->pagedata['shop'] = $shop;
            $this->tmpl = 'merchant:shop/money/tixian.html';
        }          
    }
    
}