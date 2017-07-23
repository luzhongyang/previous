<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Msg extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['msg_id']){$filter['msg_id'] = $SO['msg_id'];}
            if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
            if($SO['is_read']){$filter['is_read'] = $SO['is_read'];}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/msg')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $staff_ids = array();
            foreach($items as $v){
                $staff_ids[$v['staff_id']] = $v['staff_id'];
            }
            if($staff_ids){
                $this->pagedata['staff_list'] = K::M('staff/staff')->items_by_ids($staff_ids);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/msg/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:staff/msg/so.html';
    }

    public function detail($msg_id = null)
    {
        if(!$msg_id = (int)$msg_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('staff/msg')->detail($msg_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
            $this->tmpl = 'admin:staff/msg/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($msg_id = K::M('staff/msg')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?staff/msg-index.html');
            } 
        }else{
           $this->tmpl = 'admin:staff/msg/create.html';
        }
    }

    public function edit($msg_id=null)
    {
        if(!($msg_id = (int)$msg_id) && !($msg_id = $this->GP('msg_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('staff/msg')->detail($msg_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){            
            if(K::M('staff/msg')->update($msg_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
            $this->pagedata['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
        	$this->tmpl = 'admin:staff/msg/edit.html';
        }
    }



    public function delete($msg_id=null)
    {
        if($msg_id = (int)$msg_id){
            if(!$detail = K::M('staff/msg')->detail($msg_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('staff/msg')->delete($msg_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('msg_id')){
            if(K::M('staff/msg')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}