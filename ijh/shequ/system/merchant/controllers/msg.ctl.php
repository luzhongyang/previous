<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Msg extends Ctl
{

    public function order($page=1)
    {
        $data = $this->getitems(1,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = '暂无订单消息';
        $this->tmpl = 'merchant:msg/order.html';    
    }

    public function comment($page=1)
    {
        $data = $this->getitems(2,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = '暂无评价消息';
        $this->tmpl = 'merchant:msg/comment.html';
    }
 
    public function complain($page=1)
    {
        $data = $this->getitems(3,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = '暂无投诉消息';
        $this->tmpl = 'merchant:msg/complain.html';
    }

    public function system($page=1)
    {
        $data = $this->getitems(4,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = '暂无系统消息';
        $this->tmpl = 'merchant:msg/system.html';          
    }

    public function getitems($type,$page) {
        $filter = $pager = $data =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['type'] = $type;
        $filter['is_read'] = array(0,1,2);
        $orderby = array('msg_id'=>'desc');
        if($items = K::M('shop/msg')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $ids_unread = array();
            foreach($items as $k=>$v)
            {
                if(0 == is_read){
                    $ids_unread[$v['msg_id']] = $v['msg_id'];
                }
            }
            if(count($ids_unread)>0){
                K::M('shop/msg')->update($ids_unread,array('is_read'=>1));
            }

        }

        $data['items'] = $items;
        $data['pager'] = $pager;
        return $data;
    }

    public function setread($msg_id) 
    {
        if($msg_id != (int)$msg_id) {
            $this->msgbox->add('消息id不存在',210);
        }else if(!$detail = K::M('shop/msg')->detail($msg_id)) {
            $this->msgbox->add("你要设置的消息不存在或已经删除",211);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add("非法的数据请求",212);
        }else {
            if($detail['is_read'] == 0) {
                if(K::M('shop/msg')->update($msg_id,array('is_read'=>1))) {
                    $this->msgbox->add('设置消息状态为已读');
                }else {
                    $this->msgbox->add('设置消息状态失败',213);
                }
            }      
        }
    }
}