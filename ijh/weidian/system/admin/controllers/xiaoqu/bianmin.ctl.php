<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Bianmin extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['xiaoqu_id']){$filter['xiaoqu_id'] = $SO['xiaoqu_id'];}
if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
if($SO['phone']){$filter['phone'] = "LIKE:%".$SO['phone']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('xiaoqu/bianmin')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $xiaoqu_ids = array();
            foreach($items as $k=>$v){
                $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
            }
            $xiaoqu_list = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
            $this->pagedata['xiaoqu_list'] = $xiaoqu_list;
        }

        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/bianmin/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/bianmin/so.html';
    }

    public function xiaoqu($xiaoqu_id, $page=1)
    {
        if(!$xiaoqu_id = (int)$xiaoqu_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else{
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 50;
            $filter['xiaoqu_id'] = $xiaoqu_id;
            if($items = K::M('xiaoqu/bianmin')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
                $xiaoqu_ids = array();
                foreach($items as $k=>$v){
                    $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                }
                $xiaoqu_list = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
                $this->pagedata['xiaoqu_list'] = $xiaoqu_list;
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/bianmin/items.html';            
        }
    }


    public function detail($bianmin_id = null)
    {
        if(!$bianmin_id = (int)$bianmin_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/bianmin/detail.html';
        }
    }

    public function create($xiaoqu_id=null)
    {
        if(!($xiaoqu_id = (int)$xiaoqu_id) && !($xiaoqu_id = (int)$this->GP('xiaoqu_id'))){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['xiaoqu_id'] = $xiaoqu_id;
            if($bianmin_id = K::M('xiaoqu/bianmin')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?xiaoqu/bianmin-index.html');
            } 
        }else{
            $cate_list = K::M('xiaoqu/bianmin/cate')->fetch_all();
            $this->pagedata['cate_list'] = $cate_list;
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/bianmin/create.html';
        }
    }

    public function edit($bianmin_id=null)
    {
        if(!($bianmin_id = (int)$bianmin_id) && !($bianmin_id = $this->GP('bianmin_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(K::M('xiaoqu/bianmin')->update($bianmin_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $cate_list = K::M('xiaoqu/bianmin/cate')->fetch_all();
            $this->pagedata['cate_list'] = $cate_list;
        	$this->pagedata['detail'] = $detail;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
        	$this->tmpl = 'admin:xiaoqu/bianmin/edit.html';
        }
    }



    public function delete($bianmin_id=null)
    {
        if($bianmin_id = (int)$bianmin_id){
            if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/bianmin')->delete($bianmin_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('bianmin_id')){
            if(K::M('xiaoqu/bianmin')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}