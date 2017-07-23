<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: about.ctl.php 2034 2013-12-07 03:08:33Z $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cooperation_Cooperation extends Ctl
{
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
            if($SO['qq']){$filter['qq'] = "LIKE:%".$SO['qq']."%";}
            if($SO['audit'] !== 'NULL'){$filter['audit'] = $SO['audit'];}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1]);$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('cooperation/cooperation')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));;
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cooperation/cooperation/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:cooperation/cooperation/so.html';
    }

    public function edit($cooperation_id=null)
    {
        if(!($cooperation_id = (int)$cooperation_id) && !($cooperation_id = (int)$this->GP('cooperation_id'))){
            $this->msgbox->add('未指要修改的内容ID', 211);
        }else if(!$detail = K::M('cooperation/cooperation')->detail($cooperation_id)){
            $this->msgbox->add('你要修改的内容不存在或已被删除', 212);
        }else if($this->checksubmit('data')){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 201);
            }elseif (!K::M('cooperation/cooperation')->check_mobile($data['mobile'], $detail)) {
            	
        	}else{
                if(K::M('cooperation/cooperation')->update($cooperation_id, $data)){
                    $this->msgbox->add('修改内容成功');
                    $this->msgbox->set_data('forward', '?cooperation/cooperation-index.html');
                }
            } 
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cooperation/cooperation/edit.html';
        }
    }

    public function doaudit($cooperation_id=null)
    {
        if($cooperation_id = (int)$cooperation_id){
            if(K::M('cooperation/cooperation')->batch($cooperation_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('cooperation_id')){
            if(K::M('cooperation/cooperation')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
}