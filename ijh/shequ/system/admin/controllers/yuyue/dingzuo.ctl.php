<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Yuyue_Dingzuo extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = "LIKE:%".$SO['shop_id']."%";}
            if($SO['contact']){$filter['contact'] = "LIKE:%".$SO['contact']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}
            }
        }
        if($items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $shop_ids = $uids = $zhuohao_ids = array();
            foreach($items as $v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                if($v['uid']){
                    $uids[$v['uid']] = $v['uid'];
                }
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($uids){
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            }
            if($shop_ids){
                $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($zhuohao_ids){
                $this->pagedata['zhuohao_list'] = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:yuyue/dingzuo/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:yuyue/dingzuo/so.html';
    }
    public function detail($dingzuo_id = null)
    {
        if(!$dingzuo_id = (int)$dingzuo_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:yuyue/dingzuo/detail.html';
        }
    }

    public function edit($dingzuo_id=null)
    {
        if(!($dingzuo_id = (int)$dingzuo_id) && !($dingzuo_id = $this->GP('dingzuo_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('yuyue/dingzuo')->update($dingzuo_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:yuyue/dingzuo/edit.html';
        }
    }

    public function delete($dingzuo_id=null)
    {
        if($dingzuo_id = (int)$dingzuo_id){
            if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('yuyue/dingzuo')->delete($dingzuo_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('dingzuo_id')){
            if(K::M('yuyue/dingzuo')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}