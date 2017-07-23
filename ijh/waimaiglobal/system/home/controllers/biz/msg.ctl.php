<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Msg extends Ctl_Biz
{

    public function order($page=1)
    {
        $data = $this->getitems(1,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = L('暂无订单消息');
        $this->tmpl = 'biz/msg/index.html';    
    }

    public function comment($page=1)
    {
        $data = $this->getitems(2,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = L('暂无评价消息');
        $this->tmpl = 'biz/msg/index.html';          
    }
 
    public function complain($page=1)
    {
        $data = $this->getitems(3,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = L('暂无投诉消息');
        $this->tmpl = 'biz/msg/index.html';          
    }

    public function system($page=1)
    {
        $data = $this->getitems(4,$page);
        $this->pagedata['items'] = $data['items'];
        $this->pagedata['pager'] = $data['pager'];
        $this->pagedata['newmsg'] = L('暂无系统消息');
        $this->tmpl = 'biz/msg/index.html';          
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
        }
        $data['items'] = $items;
        $data['pager'] = $pager;
        return $data;
    }

    public function setread($msg_id) 
    {
        if($msg_id != (int)$msg_id) {
            $this->msgbox->add(L('消息不存在或已被删除'),210);
        }else if(!$detail = K::M('shop/msg')->detail($msg_id)) {
            $this->msgbox->add(L('消息不存在或已经删除'),211);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'),212);
        }else {
            if($detail['is_read'] == 0) {
                if(K::M('shop/msg')->update($msg_id,array('is_read'=>1))) {
                    $this->msgbox->add(L('SUCCESS'));
                }else {
                    $this->msgbox->add(L('FAIL'),213);
                }
            }      
        }
    }
}