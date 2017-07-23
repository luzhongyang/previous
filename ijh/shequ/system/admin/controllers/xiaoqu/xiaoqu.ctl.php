<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Xiaoqu extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['xiaoqu_id']){$filter['xiaoqu_id'] = $SO['xiaoqu_id'];}
if($SO['city_id']){$filter['city_id'] = $SO['city_id'];}
if($SO['area_id']){$filter['area_id'] = $SO['area_id'];}
if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
if($SO['phone']){$filter['phone'] = $SO['phone'];}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/xiaoqu')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/xiaoqu/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/xiaoqu/so.html';
    }

    public function detail($xiaoqu_id = null)
    {
        if(!$xiaoqu_id = (int)$xiaoqu_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/xiaoqu/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if(empty($data['title'])){
                $this->msgbox->add('名称不能为空', 212);
            }else if(empty($data['addr'])){
                $this->msgbox->add('小区地址不能为空', 213);
            }else if(K::M('xiaoqu/xiaoqu')->find(array('wuye_id'=>$data['wuye_id']))) {
                $this->msgbox->add('该物业已入驻其他小区', 214);
            }else if(!$wuye = K::M('xiaoqu/wuye')->detail($data['wuye_id'])){
                $this->msgbox->add('物业不存在或已被删除', 215);
            }else{
                if (!empty($wuye['phone'])) {
                    $data['phone'] = $wuye['phone'];
                }
                if($xiaoqu_id = K::M('xiaoqu/xiaoqu')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward', '?xiaoqu/xiaoqu-index.html');
                }
            }
        }else{
           $this->tmpl = 'admin:xiaoqu/xiaoqu/create.html';
        }
    }

    public function edit($xiaoqu_id=null)
    {
        if(!($xiaoqu_id = (int)$xiaoqu_id) && !($xiaoqu_id = $this->GP('xiaoqu_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(empty($data['title'])){
                $this->msgbox->add('名称不能为空', 213);
            }else if(empty($data['addr'])){
                $this->msgbox->add('小区地址不能为空', 214);
            }else if(K::M('xiaoqu/xiaoqu')->find(array('wuye_id'=>$data['wuye_id']))) {
                $this->msgbox->add('该物业已入驻其他小区', 215);
            }else if(!$wuye = K::M('xiaoqu/wuye')->detail($data['wuye_id'])){
                $this->msgbox->add('物业不存在或已被删除', 216);
            }else{
                if (!empty($wuye['phone'])) {
                    $data['phone'] = $wuye['phone'];
                }
                if(K::M('xiaoqu/xiaoqu')->update($xiaoqu_id, $data)){
                    $this->msgbox->add('修改内容成功');
                }
            }
        }else{
        	$this->pagedata['detail'] = $detail;
            $user= K::M('xiaoqu/wuye')->detail($detail['wuye_id']);
            $this->pagedata['user'] = $user;
        	$this->tmpl = 'admin:xiaoqu/xiaoqu/edit.html';
        }
    }

    public function doaudit($xiaoqu_id=null)
    {
        if($xiaoqu_id = (int)$xiaoqu_id){
            if(K::M('xiaoqu/xiaoqu')->batch($xiaoqu_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('xiaoqu_id')){
            if(K::M('xiaoqu/xiaoqu')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($xiaoqu_id=null)
    {
        if($xiaoqu_id = (int)$xiaoqu_id){
            if(!$detail = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/xiaoqu')->delete($xiaoqu_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('xiaoqu_id')){
            if(K::M('xiaoqu/xiaoqu')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}