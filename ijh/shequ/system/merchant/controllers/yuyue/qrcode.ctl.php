<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Yuyue_Qrcode extends Ctl
{
    // 桌号二维码列表
	public function items($page=1)
	{
        $this->check_paidui();
        $this->check_dingzuo();
		$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 24;
        $filter['shop_id'] = $this->shop_id;
        $orderby = array('zhuohao_id'=>'desc');
		if($items = K::M('yuyue/zhuohao')->items($filter, $orderby, $page, $limit, $count)) {
            foreach ($items as $k => $v) {
                $items[$k]['mylink'] = $this->mklink('waimai/product:index', array('shop_id'=>$v['shop_id'], 'zhuohao_id'=>$v['zhuohao_id']), null, 'www');
            }
			$pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}'))); 
		}
        $this->pagedata['common_qrcode'] = $this->mklink('waimai/product:index', array('shop_id'=>$v['shop_id'], 'zhuohao_id'=>'2147483647'), null, 'www');
		$this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
		$this->tmpl = 'merchant:yuyue/qrcode/items.html';
	}
}