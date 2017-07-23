<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Wuyetixian extends Ctl
{
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['tixian_id']){$filter['tixian_id'] = $SO['tixian_id'];}
            if($SO['wuye_id']){$filter['wuye_id'] = $SO['wuye_id'];}
            if($SO['status']){$filter['status'] = $SO['status'];}
            if(is_array($SO['updatetime'])){if($SO['updatetime'][0] && $SO['updatetime'][1]){$a = strtotime($SO['updatetime'][0]); $b = strtotime($SO['updatetime'][1])+86400;$filter['updatetime'] = $a."~".$b;}}
        }
        $orderby = array('tixian_id'=>'DESC');
        if($items = K::M('xiaoqu/wuye/tixian')->items($filter, $orderby, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $wuye_ids = array();
            foreach($items as $k=>$v){
                $wuye_ids[$v['wuye_id']] = $v['wuye_id'];
            }
            $this->pagedata['wuye_list'] = K::M('xiaoqu/wuye')->items_by_ids($wuye_ids);
        }
        $this->pagedata['items']  = $items;
        $this->pagedata['pager']  = $pager;
        $this->tmpl = 'admin:xiaoqu/wuye/tixian/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/wuye/tixian/so.html';
    }

    public function detail($tixian_id = null)
    {
        if(!$tixian_id = (int)$tixian_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/wuye/tixian')->detail($tixian_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/wuye/tixian/detail.html';
        }
    }

    public function edit($tixian_id=null)
    {
        if(!($tixian_id = (int)$tixian_id) && !($tixian_id = $this->GP('tixian_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/wuye/tixian')->detail($tixian_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){

            if(K::M('xiaoqu/wuye/tixian')->update($tixian_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/wuye/tixian/edit.html';
        }
    }

    public function doaudit($tixian_id=null)
    {
        if($tixian_id = (int)$tixian_id){
            if(K::M('xiaoqu/wuye/tixian')->update($tixian_id, array('status'=>1,'updatetime'=>__TIME))){
                $this->msgbox->add('通过审核成功');
            }
        }else if($ids = $this->GP('tixian_id')){
            if(K::M('xiaoqu/wuye/tixian')->update($ids, array('status'=>1,'updatetime'=>__TIME))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function reason($tixian_id=null)
    {
        if(!($tixian_id = (int)$tixian_id) && !($tixian_id = (int)$this->GP('tixian_id'))){
            $this->msgbox->add('未指要操作的体现ID', 211);
        }else if(!$detail = K::M('xiaoqu/wuye/tixian')->detail($tixian_id)){
            $this->msgbox->add('提现不存在或已经删除', 212);
        }else if(!empty($detail['status'])){            
            $this->msgbox->add('提现申请状态不可退回', 213);
        }else if($reason_content = $this->checksubmit('reason')){
            if(K::M('xiaoqu/wuye/tixian')->update($tixian_id, array('status'=>2, 'reason'=>$reason_content, 'updatetime'=>__TIME))){
                K::M('xiaoqu/wuye')->update_money($detail['wuye_id'], $detail['money'], $reason_content.',退回到帐户余额');
                $this->msgbox->add('退回提现申请成功');
            }            
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/wuye/tixian/reason.html';
        }
    } 

    public function delete($tixian_id=null)
    {
        if($tixian_id = (int)$tixian_id){
            if(!$detail = K::M('xiaoqu/wuye/tixian')->detail($tixian_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/wuye/tixian')->delete($tixian_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('tixian_id')){
            if(K::M('xiaoqu/wuye/tixian')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

}
