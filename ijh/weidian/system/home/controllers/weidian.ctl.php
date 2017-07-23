<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Weidian extends Ctl
{
    public function index()
    {


        $this->tmpl = 'shop/weidian.html';
    }

    public function loaditems()
    {

        if (!$this->checksubmit()) {
            $this->msgbox->add('请求出错', -2)->response();
        }
        $cate_list = K::M('shop/cate')->fetch_all();
        $filter = $pager = $orderby = array();

        //排序
        $orderby['dateline'] = 'DESC';

        $page = max((int)$this->GP('page'), 1);
        $limit = 100;
        $filter['audit'] = 1;
        if (($page <= 100) && $shop_list = K::M('weidian/weidian')->items($filter, $orderby, 1, $limit, $count)) {

        } else {
            $this->msgbox->add('暂无开通的微店', 211);
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => array_values($shop_list)));

    }
}