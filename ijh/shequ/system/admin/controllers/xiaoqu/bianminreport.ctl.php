<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Xiaoqu_Bianminreport extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['report_id']){$filter['report_id'] = $SO['report_id'];}
if($SO['bianmin_id']){$filter['bianmin_id'] = $SO['bianmin_id'];}
if($SO['uid']){$filter['uid'] = $SO['uid'];}
if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('xiaoqu/bianmin/report')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $bianmin_ids = $yezhu_ids = array();
            foreach($items as $k=>$v){
                $bianmin_ids[$v['bianmin_id']] = $v['bianmin_id'];
                $yezhu_ids[$v['yezhu_id']] = $v['yezhu_id'];
            }
            if($bianmin_ids){
                $this->pagedata['bianmin_list'] = K::M('xiaoqu/bianmin')->items_by_ids($bianmin_ids);
            }
            if($yezhu_ids){
                $this->pagedata['yezhu_list'] = K::M('xiaoqu/yezhu')->items_by_ids($yezhu_ids);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/bianmin/report/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/bianmin/report/so.html';
    }
    public function detail($report_id = null)
    {
        if(!$report_id = (int)$report_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/bianmin/report')->detail($report_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $bianmin = K::M('xiaoqu/bianmin')->detail($detail['bianmin_id']);
            $this->pagedata['detail'] = $detail;
            $this->pagedata['bianmin'] = $bianmin;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($bianmin['xiaoqu_id']);
            $this->pagedata['yezhu'] = K::M('xiaoqu/yezhu')->detail($detail['yezhu_id']);
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->tmpl = 'admin:xiaoqu/bianmin/report/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($report_id = K::M('xiaoqu/bianmin/report')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?xiaoqu/bianminreport-index.html');
            } 
        }else{
           $this->tmpl = 'admin:xiaoqu/bianmin/report/create.html';
        }
    }
    public function edit($report_id=null)
    {
        if(!($report_id = (int)$report_id) && !($report_id = $this->GP('report_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/bianmin/report')->detail($report_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('xiaoqu/bianmin/report')->update($report_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:xiaoqu/bianmin/report/edit.html';
        }
    }

    public function delete($report_id=null)
    {
        if($report_id = (int)$report_id){
            if(!$detail = K::M('xiaoqu/bianmin/report')->detail($report_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/bianmin/report')->delete($report_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('report_id')){
            if(K::M('xiaoqu/bianmin/report')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}