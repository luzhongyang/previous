<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Tixian extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['tixian_id']){$filter['tixian_id'] = $SO['tixian_id'];}
            if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
            if($SO['status']){$filter['status'] = $SO['status'];}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/tixian')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/tixian/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:staff/tixian/so.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if($tixian_id = K::M('log/tixian')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?staff/tixian-index.html');
            } 
        }else{
           $this->tmpl = 'admin:staff/tixian/create.html';
        }
    }

    public function edit($tixian_id=null)
    {
        if(!($tixian_id = (int)$tixian_id) && !($tixian_id = $this->GP('tixian_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('staff/tixian')->detail($tixian_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('log/tixian')->update($tixian_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:staff/tixian/edit.html';
        }
    }

    public function detail($tixian_id=null)
    {
        if(!($tixian_id = (int)$tixian_id) && !($tixian_id = $this->GP('tixian_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('staff/tixian')->detail($tixian_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if($detail['status']){
                unset($data['status'], $data['reason']);
            }else if($data['status']==2){//拒绝
                if($data['reason']){
                    $this->err->add('拒绝理由不能为空', 213);
                }else if(K::M('log/tixian')->update($tixian_id, $data)){
                    K::M('staff/money')->update($detail['staff_id'], $detail['money'], '提现被拒绝('.$data['reason'].')');
                    $this->msgbox->add('拒绝提现成功');
                }
            }else if(K::M('log/tixian')->update($tixian_id, $data)){
                $this->msgbox->add('处理体现成功');
            }  
        }else{
            if($staff_id = $detail['staff_id']){
                $this->pagedata['staff'] = K::M('staff/staff')->detail($staff_id);
            }
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:staff/tixian/detail.html';
        }        
    }

    public function doaudit($tixian_id=null)
    {
        if($tixian_id = (int)$tixian_id){
            if(K::M('staff/tixian')->batch($tixian_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('tixian_id')){
            if(K::M('staff/tixian')->batch($ids, array('audit'=>1))){
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
        }else if(!$detail = K::M('staff/tixian')->detail($tixian_id)){
            $this->msgbox->add('提现不存在或已经删除', 212);
        }else if(!empty($detail['status'])){
            $this->msgbox->add('提现申请状态不可退回', 213);
        }else if($reason_content = $this->checksubmit('reason')){
            if(K::M('staff/tixian')->update($tixian_id, array('status'=>2, 'reason'=>$reason_content, 'updatetime'=>__TIME))){
                K::M('staff/staff')->update_money($detail['staff_id'], $detail['money'], $reason_content.',退回到帐户余额');
                $this->msgbox->add('退回提现申请成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:shop/tixian/reason.html';
        }
    } 

}