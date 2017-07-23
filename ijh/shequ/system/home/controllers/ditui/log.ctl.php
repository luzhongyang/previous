<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Ditui_Log extends Ctl_Ditui
{
    

    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['ditui_id'] = $this->ditui_id;
        if($items = K::M('ditui/ditui')->items($filter, array('log_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $this->pagedata['items'] = $items;
        }
        $this->tmpl = 'ditui/log/index.html';
    }

}