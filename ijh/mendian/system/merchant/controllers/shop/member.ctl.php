<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Member extends Ctl
{
    /*我的客户*/
    public function index($page=1)
    { 
        $filter = $pager = $items = array();
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 8;
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        if($items = K::M('order/order')->customs_by_shop($filter, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            foreach($items as $v){
                $uids[$v['uid']] = $v['uid'];
            }
            if($uids){
                $members = K::M('member/member')->items_by_ids($uids);
            }
        }
        $this->pagedata['members'] = $members;
        $this->pagedata['pager'] = $pager;
   
        
        $this->tmpl = 'merchant:shop/member/index.html';
    }

    /*我的粉丝*/
    public function fans($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['can_id'] = $this->shop_id;
        $filter['status'] = 1;
        if($items = K::M('member/collect')->items($filter, null, $page, $limit, $count)){
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
        $this->tmpl = 'merchant:shop/member/fans.html';
    }

    public function detail($uid, $page=1) 
    {
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($uid != (int)$uid) {
            $this->msgbox->add('用户ID不存在',210);
        }else if(!$member = K::M('member/member')->detail($uid)){
            $this->msgbox->add('要查看的客户不存在或已经删除', 211);
        }else{
            $custom = array('uid'=>$member['uid'], 'nickname'=>$member['nickname'], 'mobile'=>$member['mobile']);
            $custom['total_amount'] = $custom['total_order'] = 0;
            if($custom_list = K::M('order/order')->customs_by_shop(array('shop_id'=>$this->shop_id, 'uid'=>$uid,'order_status'=>8), 1, 1)){
                if($custom = $custom_list[$uid]){
                    $member['total_order'] = $custom['total_order'];
                    $member['total_amount'] = $custom['total_amount'];
                }
                $items = K::M('order/order')->items(array('shop_id'=>$this->shop_id, 'uid'=>$uid,'order_status'=>8), null, $page, $limit,$count);
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($uid,'{page}')));
            }
        }
        //print_r($items);die;
        $this->pagedata['member'] = $member;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/member/detail.html';
    }
}