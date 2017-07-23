<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*余额明细*/
class Ctl_Ucenter_Money extends Ctl_Ucenter
{
	public function index()
	{
		$filter = array();
        $filter['uid']  = $this->uid;
        $filter['type'] = 'money';
        $orderby = array('dateline'=>'desc');
        $count = 0;
        $tyd = strtotime(date('Y-m-d', time()-30*86400));  //30天前
        $filter['dateline'] = $tyd.'~'.time();// 今天
        if($items = K::M('member/log')->items($filter, $orderby, $page, $limit, $count)){
            $this->pagedata['items'] = $items;
        }
        $this->tmpl = "ucenter/money/index.html";
	}

	public function recharge()
	{
        $money_pack = array();
        if($money_pack = K::M('member/money')->package()) {
            $this->pagedata['money_pack'] = $money_pack;
            $this->pagedata['uid'] = $this->uid;
        }
		$this->tmpl = "ucenter/money/recharge.html";
	}
}
