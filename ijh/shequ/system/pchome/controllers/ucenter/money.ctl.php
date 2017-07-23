<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Money extends Ctl_Ucenter
{
    /**
     * 我的余额
     */
    public function index($page=1){
        
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['type'] = 'money';
        $items = K::M("member/log")->items($filter, $orderby, $page, $limit, $count);
        $pager['count'] = $count;
        $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/money/index',array($st,'{page}'),null,'base'));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/money/index.html';

    }
    
    /**
     * 充值余额
     */
    public function recharge(){
        if($money_pack = K::M('member/money')->package()){
            $this->pagedata['money_pack'] = $money_pack;
        }
        $this->tmpl = 'pchome/ucenter/money/recharge.html';
    }

}
