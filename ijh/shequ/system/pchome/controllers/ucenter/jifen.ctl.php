<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Jifen extends Ctl_Ucenter
{
    /**
     * 我的积分
     */
    public function index($page){
        
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['type'] = 'jifen';
        $items = K::M("member/log")->items($filter, $orderby, $page, $limit, $count);
        $pager['count'] = $count;
        $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/money/index',array($st,'{page}'),null,'base'));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/jifen/index.html';

    }

}
