<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Bill extends Ctl
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['bill_id']){$filter['bill_id'] = $SO['bill_id'];}
if($SO['yezhu_id']){$filter['yezhu_id'] = $SO['yezhu_id'];}
if($SO['bill_sn']){$filter['bill_sn'] = "LIKE:%".$SO['bill_sn']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/bill')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $xiaoqu_ids = $yezhu_ids = $uids = array();
            foreach($items as $k=>$v){
                $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                $yezhu_ids[$v['yezhu_id']] = $v['yezhu_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            $this->pagedata['yezhu_list'] = K::M('xiaoqu/yezhu')->items_by_ids($yezhu_ids);
            $this->pagedata['xiaoqu_list'] = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/bill/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/bill/so.html';
    }

    public function yezhu($yezhu_id, $page=1)
    {
        if(!$yezhu_id = (int)$yezhu_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('业主不存在或已经删除', 212);
        }else{
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 50;
            $filter['xiaoqu_id'] = $xiaoqu_id;
            if($items = K::M('xiaoqu/bill')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
                $xiaoqu_ids = $yezhu_ids = $uids = array();
                foreach($items as $k=>$v){
                    $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                    $yezhu_ids[$v['yezhu_id']] = $v['yezhu_id'];
                    $uids[$v['uid']] = $v['uid'];
                }
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
                $this->pagedata['yezhu_list'] = K::M('xiaoqu/yezhu')->items_by_ids($yezhu_ids);
                $this->pagedata['xiaoqu_list'] = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['yezhu'] = $yezhu;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
            $this->tmpl = 'admin:xiaoqu/bill/items.html';
        }
    }


    public function detail($bill_id = null)
    {
        if(!$bill_id = (int)$bill_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/bill/detail.html';
        }
    }

    public function create($yezhu_id=null)
    {
        if(!($yezhu_id = (int)$yezhu_id) && !($yezhu_id = (int)$this->GP('yezhu_id'))){
            $this->msgbox->add('未指定业主，不可创建账单', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('业主不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['total_price']  = (float)$data['wuye_price'];
            $data['total_price'] += (float)$data['chewei_price'];
            $data['total_price'] += (float)$data['shui_price'];
            $data['total_price'] += (float)$data['dian_price'];
            $data['total_price'] += (float)$data['ranqi_price'];
            $data['yezhu_id'] = $yezhu_id;
            $data['uid'] = $yezhu['uid'];
            $data['xiaoqu_id'] = $yezhu['xiaoqu_id'];
            if($bill_id = K::M('xiaoqu/bill')->create($data)){
                $this->msgbox->add('添加缴费账单成功');
                $this->msgbox->set_data('forward', '?xiaoqu/bill-yezhu-'.$yezhu_id.'.html');
            } 
        }else{
            $this->pagedata['yezhu'] = $yezhu;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
           $this->tmpl = 'admin:xiaoqu/bill/create.html';
        }
    }

    public function edit($bill_id=null)
    {
        if(!($bill_id = (int)$bill_id) && !($bill_id = $this->GP('bill_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['total_price']  = (float)$data['wuye_price'];
            $data['total_price'] += (float)$data['chewei_price'];
            $data['total_price'] += (float)$data['shui_price'];
            $data['total_price'] += (float)$data['dian_price'];
            $data['total_price'] += (float)$data['ranqi_price'];
            if(K::M('xiaoqu/bill')->update($bill_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['yezhu'] = K::M('xiaoqu/yezhu')->detail($detail['yezhu_id']);
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
            $this->tmpl = 'admin:xiaoqu/bill/edit.html';
        }
    }



    public function delete($bill_id=null)
    {
        if($bill_id = (int)$bill_id){
            if(!$detail = K::M('xiaoqu/bill')->detail($bill_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/bill')->delete($bill_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('bill_id')){
            if(K::M('xiaoqu/bill')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}