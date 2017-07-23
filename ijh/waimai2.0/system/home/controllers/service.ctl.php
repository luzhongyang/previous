<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Service extends Ctl {

	public function index()
	{
		$filter = array();
        $filter['from'] = 'help';
        $page= max(intval($page), 1);
        $items = K::M('article/article')->items($filter, array('article_id'=>'desc'), $page, 20, $count);
        $this->pagedata['items'] = $items;
        $this->pagedata['count'] = $count;
		$this->tmpl = 'ucenter/service/index.html';
	}

	public function detail($article_id)
	{
		$article_id = (int)$article_id;
		$detail = K::M('article/article')->detail($article_id);
		$content = K::M('article/content')->find(array($article_id));
		$detail['content'] = $content['content'];
		$this->pagedata['detail'] = $detail;
		$this->tmpl = 'ucenter/service/detail.html';
	}

}