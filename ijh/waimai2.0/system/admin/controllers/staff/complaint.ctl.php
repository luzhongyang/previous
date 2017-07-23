<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Complaint extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['complaint_id']){$filter['complaint_id'] = $SO['complaint_id'];}
if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/complaint')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/complaint/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:staff/complaint/so.html';
    }

    public function detail($complaint_id = null)
    {
        if(!$complaint_id = (int)$complaint_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('staff/complaint')->detail($complaint_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:staff/complaint/detail.html';
        }
    }



    public function edit($complaint_id=null)
    {
        if(!($complaint_id = (int)$complaint_id) && !($complaint_id = $this->GP('complaint_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('staff/complaint')->detail($complaint_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('staff/complaint')->update($complaint_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:staff/complaint/edit.html';
        }
    }



    public function delete($complaint_id=null)
    {
        if($complaint_id = (int)$complaint_id){
            if(!$detail = K::M('staff/complaint')->detail($complaint_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('staff/complaint')->delete($complaint_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('complaint_id')){
            if(K::M('staff/complaint')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}