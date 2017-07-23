<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui_index extends Ctl_Ditui
{
    // 管理中心
    public function index()
    {
        $near_seven = date('Y-m-d', strtotime('-7 days'));
        $near_month = date('Y-m-d', strtotime('-31 days'));
        
    	if($detail = K::M('ditui/ditui')->detail($this->ditui_id)) {
    		$this->pagedata['mylink'] = $this->mklink('market:invite', array('args'=>$detail['pid']));  // 推广链接
            $this->pagedata['users'] = $detail;  //注册用户数、下单会员数、总收益
    	}

        // 注册商户数
        if($shops = K::M('ditui/shop')->count(array('ditui_id'=>$this->ditui_id))) {
            $this->pagedata['shops'] = $shops;
        }

        // 近一月近一周地推会员数
        $filter = array();
        $filter['ditui_id'] = $this->ditui_id;
        if($month_members = K::M('ditui/member')->ditui_member($filter, 1, 31)) {
            foreach($month_members as $k=>$v) {
                if($v['date'] >= $near_seven) {$week_users += $v['uids'];}
                if($v['date'] >= $near_month) {$month_users += $v['uids'];}
            }
            $this->pagedata['week_users'] = $week_users;
            $this->pagedata['month_users'] = $month_users;
        }
        $this->pagedata['datas'] = $month_members;
        // 近一月近一周地推商家数
        if($month_shops = K::M('ditui/shop')->ditui_shop($filter, 1, 31)) {
            foreach($month_shops as $k=>$v) {
                if($v['date'] >= $near_seven) {$week_shopids += $v['shopids'];}
                if($v['date'] >= $near_month) {$month_shopids += $v['shopids'];}
            }
            $this->pagedata['week_shopids'] = $week_shopids;
            $this->pagedata['month_shopids'] = $month_shopids;
        } 

        // 近一月近一周成功注册会员下单数
        if($month_order = K::M('ditui/member')->first_amount($filter, 1, 31)) {
            foreach($month_order as $k=>$v) {
                if($v['date'] >= $near_seven) {$week_first += $v['first'];}
                if($v['date'] >= $near_month) {$month_first += $v['first'];}
            }
            $this->pagedata['week_first'] = $week_first;
            $this->pagedata['month_first'] = $month_first;
        }
        $this->tmpl = 'ditui/index.html';
    }


}
