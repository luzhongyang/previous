<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Xiaoqu_Wuye extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['wuye_id']){$filter['wuye_id'] = $SO['wuye_id'];}
if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/wuye')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/wuye/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/wuye/so.html';
    }
    public function detail($wuye_id = null)
    {
        if(!$wuye_id = (int)$wuye_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/wuye')->detail($wuye_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/wuye/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($wuye_id = K::M('xiaoqu/wuye')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?xiaoqu/wuye-index.html');
            } 
        }else{
           $this->tmpl = 'admin:xiaoqu/wuye/create.html';
        }
    }
    public function edit($wuye_id=null)
    {
        if(!($wuye_id = (int)$wuye_id) && !($wuye_id = $this->GP('wuye_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/wuye')->detail($wuye_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('xiaoqu/wuye')->update($wuye_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:xiaoqu/wuye/edit.html';
        }
    }
    public function doaudit($wuye_id=null)
    {
        if($wuye_id = (int)$wuye_id){
            if(K::M('xiaoqu/wuye')->batch($wuye_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('wuye_id')){
            if(K::M('xiaoqu/wuye')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    
    
    public function dialog($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['from'] = 'all';
        $pager['limit'] = $limit = 10;
        $pager['multi'] = $multi = ($this->GP('multi') == 'Y' ? 'Y' : 'N');
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        if($items = K::M('xiaoqu/wuye')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO, 'multi'=>$multi));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/wuye/dialog.html';
    }
    public function delete($wuye_id=null)
    {
        if($wuye_id = (int)$wuye_id){
            if(!$detail = K::M('xiaoqu/wuye')->detail($wuye_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/wuye')->delete($wuye_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('wuye_id')){
            if(K::M('xiaoqu/wuye')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
    public function manage($wuye_id)
    {
        K::M('xiaoqu/wuye/auth')->manager($wuye_id);
        header("Location:".'../wuye/index');
    }
}