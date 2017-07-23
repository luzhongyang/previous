<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cloud_Order extends Ctl
{
    public function index($page = 1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){
                $filter['title'] = "LIKE:%" . $SO['title'] . "%";
            }
        }
        $filter['closed'] = 0;
        if($items = K::M('cloud/order')->items($filter, array('dateline'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
        }
        $attr_ids = $goods_ids = $uids = array();
        foreach($items as $k => $v){
            $goods_ids[$v['goods_id']] = $v['goods_id'];
            $attr_ids[$v['attr_id']] = $v['attr_id'];
            $uids[$v['uid']] = $v['uid'];
        }
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_ids);
        $this->pagedata['attrs'] = K::M('cloud/attr')->items_by_ids($attr_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cloud/order/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cloud/order/so.html';
    }
 
    public function delete($order_id = null)
    {
        if($order_id = (int) $order_id){
            if(!$detail = K::M('cloud/order')->detail($order_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else{
                if(K::M('cloud/order')->delete($order_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else if($ids = $this->GP('order_id')){
            foreach($ids as $id){
                K::M('cloud/order')->delete($id);
            }
            $this->msgbox->add('批量删除内容成功');
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}
