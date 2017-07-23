<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Member_Suggestion extends Ctl
{
	public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['id']){$filter['id'] = $SO['id'];}
			if($SO['uid']){$filter['uid'] = $SO['uid'];}
			if($SO['title']){$filter['content'] = "LIKE:%".$SO['title']."%";}
			if(is_array($SO['clientip'])){
				if($SO['clientip'][0] && $SO['clientip'][1]){
					$a = strtotime($SO['clientip'][0]); 
					$b = strtotime($SO['clientip'][1])+86400;
					$filter['clientip'] = $a."~".$b;
				}
			}
        }
        if($items = K::M('member/suggestion')->items($filter, array('id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $uids = array();
        foreach($items as $k=>$val){
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:member/suggestion/items.html';
    }

	public function detail($id)
	{
		if(!$id = (int)$id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('member/suggestion')->detail($id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $detail['user'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:member/suggestion/detail.html';
        }
	}

	public function so()
    {
        $this->tmpl = 'admin:member/suggestion/so.html';
    }

    public function delete($id=null)
    {
        if($id = (int)$id){
            if(!$detail = K::M('member/suggestion')->detail($id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('member/suggestion')->delete($id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('id')){
            if(K::M('member/suggestion')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}