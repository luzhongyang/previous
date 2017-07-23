<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Tiebareply extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['reply_id']){$filter['reply_id'] = $SO['reply_id'];}
if($SO['tieba_id']){$filter['tieba_id'] = $SO['tieba_id'];}
if($SO['uid']){$filter['uid'] = $SO['uid'];}
if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/tieba/reply')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/tieba/reply/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/tieba/reply/so.html';
    }

    public function detail($reply_id = null)
    {
        if(!$reply_id = (int)$reply_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/tieba/reply')->detail($reply_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/tieba/reply/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($reply_id = K::M('xiaoqu/tieba/reply')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?xiaoqu/tiebareply-index.html');
            } 
        }else{
           $this->tmpl = 'admin:xiaoqu/tieba/reply/create.html';
        }
    }

    public function edit($reply_id=null)
    {
        if(!($reply_id = (int)$reply_id) && !($reply_id = $this->GP('reply_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/tieba/reply')->detail($reply_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('xiaoqu/tieba/reply')->update($reply_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:xiaoqu/tieba/reply/edit.html';
        }
    }

    public function doaudit($reply_id=null)
    {
        if($reply_id = (int)$reply_id){
            if(K::M('xiaoqu/tieba/reply')->batch($reply_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('reply_id')){
            if(K::M('xiaoqu/tieba/reply')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($reply_id=null)
    {
        if($reply_id = (int)$reply_id){
            if(!$detail = K::M('xiaoqu/tieba/reply')->detail($reply_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/tieba/reply')->delete($reply_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('reply_id')){
            if(K::M('xiaoqu/tieba/reply')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}