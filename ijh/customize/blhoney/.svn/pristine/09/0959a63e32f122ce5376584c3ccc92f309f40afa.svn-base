<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Ditui_Member extends Ctl_Ditui
{
	public function index($page=1)
    { 
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['ditui_id'] = $this->ditui_id;
        if($items = K::M('ditui/member')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $uids = array();
        foreach($items as $k=>$val){
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['members'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'ditui/member/index.html';
    }
}