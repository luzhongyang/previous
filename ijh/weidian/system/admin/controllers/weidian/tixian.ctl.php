<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Tixian extends Ctl
{

    public function index($page)
    {   
        $filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 20;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
        }
        if($items = K::M('fenxiao/tixian')->items($filter, null, $page, $limit, $count)){
            $sids = array();
            foreach($items as $k => $v){
                $sids[$v['sid']] = $v['sid'];
            }
            $fenxiaos = K::M('fenxiao/fenxiao')->items_by_ids($sids);
            foreach($items as $k => $v){
                $items[$k]['fenxiao'] = $fenxiaos[$v['sid']];
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weidian/tixian/items.html';
    }
    
    public function doaudit($id=null)
    {
        if($id = (int)$id){
            if(K::M('fenxiao/tixian')->update($id, array('status'=>1,'updatetime'=>__TIME))){
                $this->msgbox->add('通过审核成功');
            }
        }else if($ids = $this->GP('id')){
            if(K::M('shop/tixian')->update($ids, array('status'=>1,'updatetime'=>__TIME))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function so()
    {
        $this->tmpl = 'admin:weidian/tixian/so.html';
    }

    public function reason($id=null)
    {
        if(!($id = (int)$id) && !($id = (int)$this->GP('id'))){
            $this->msgbox->add('未指要操作的体现ID', 211);
        }else if(!$detail = K::M('fenxiao/tixian')->detail($id)){
            $this->msgbox->add('提现不存在或已经删除', 212);
        }else if(!empty($detail['status'])){
            $this->msgbox->add('提现申请状态不可退回', 213);
        }else if($reason_content = $this->checksubmit('reason')){
            if(K::M('fenxiao/tixian')->update($id, array('status'=>2, 'reason'=>$reason_content, 'updatetime'=>__TIME))){
                K::M('fenxiao/fenxiao')->update_money($detail['sid'], $detail['money'], $reason_content.',退回到商户余额');
                $this->msgbox->add('退回提现申请成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weidian/tixian/reason.html';
        }
    }  

}
