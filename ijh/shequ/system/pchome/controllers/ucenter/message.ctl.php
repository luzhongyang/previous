<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Message extends Ctl_Ucenter
{
    /**
     * 我的消息
     */
    public function index($page){
        
        $filter = $pager = $items = $orderby = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $orderby['dateline'] = 'desc';
        $orderby['is_read'] = 'asc';
        $filter['uid'] = $this->uid;
        $items = K::M("member/message")->items($filter, $orderby, $page, $limit, $count);
        $pager['count'] = $count;
        $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/message/index',array($st,'{page}'),null,'base'));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/message/index.html';

    }

}
