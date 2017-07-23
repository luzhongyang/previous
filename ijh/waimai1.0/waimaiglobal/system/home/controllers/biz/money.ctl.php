<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Money extends Ctl_Biz
{
    

    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('shop/log')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $this->pagedata['items'] = $items;
        }
        $this->tmpl = 'biz/money/index.html';
    }

    public function log($page=1)
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
        $this->tmpl = 'biz/money/log.html';
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
        $this->tmpl = 'biz/money/txlog.html';
    }
    
    public function tixian(){
        $shop = K::M('shop/shop')->detail($this->shop_id);
        $account = K::M('shop/account')->detail($this->shop_id);
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'money,intro')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else if($data['money'] <0){
                $this->msgbox->add(L('金额不正确'), 212);
            }else if($data['money'] > $this->shop['money']){
                $this->msgbox->add(L('余额不足'), 213);
            }else if(!$account){
                $this->msgbox->add(L('账户未设置'), 214);
                $this->msgbox->set_data('forward',  $this->mklink('biz/shop/account'));
            }else if(!$account['account_type']||!$account['account_name']||!$account['account_number']){
                $this->msgbox->add(L('账户信息不完整'), 215);
                $this->msgbox->set_data('forward',  $this->mklink('biz/shop/account'));
            }else if(K::M('shop/shop')->update_money($this->shop_id,-$data['money'], L('余额提现，扣款'))){
                $end_money = NULL;
                $end_money = $shop['tixian_percent']*$data['money']/100;
                if(K::M('shop/tixian')->create(array('shop_id'=>$this->shop_id,'money'=>$data['money'],'intro'=>$data['intro'],'account_info'=> sprintf(L('开户行：%s，账户：%s,开户人：%s'), $account['account_type'], $account['account_number'],$account['account_name']),'end_money'=>$end_money))){
                    $this->msgbox->add(L('SUCCESS'));
                    $this->msgbox->set_data('forward',  $this->mklink('biz/money/txlog'));
                }
             }else{
                 $this->msgbox->add(L('FAIL'),216);
             }
        }else{
            $this->pagedata['acc'] = $account;
            $this->pagedata['shop'] = $shop;
            $this->tmpl = 'biz/money/tixian.html';
        }          
    }
    
}