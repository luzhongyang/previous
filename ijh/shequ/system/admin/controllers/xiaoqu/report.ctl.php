<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Report extends Ctl
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['report_id']){$filter['report_id'] = $SO['report_id'];}
if($SO['xiaoqu_id']){$filter['xiaoqu_id'] = $SO['xiaoqu_id'];}
if($SO['uid']){$filter['uid'] = $SO['uid'];}
if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/report')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $xiaoqu_ids = $uids = $yezhu_ids = array();
            foreach($items as $k=>$v){
                $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                $uids[$v['uid']] = $v['uid'];
                $yezhu_ids[$v['yezhu_id']] = $v['yezhu_id'];
            }
            $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            $this->pagedata['yezhu_list'] = K::M('xiaoqu/yezhu')->items_by_ids($yezhu_ids);
            $this->pagedata['xiaoqu_list'] = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/report/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/report/so.html';
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
            if($items = K::M('xiaoqu/report')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
                $xiaoqu_ids = $uids = $yezhu_ids = array();
                foreach($items as $k=>$v){
                    $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                    $uids[$v['uid']] = $v['uid'];
                    $yezhu_ids[$v['yezhu_id']] = $v['yezhu_id'];
                }
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
                $this->pagedata['yezhu_list'] = K::M('xiaoqu/yezhu')->items_by_ids($yezhu_ids);
                $this->pagedata['xiaoqu_list'] = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['xiaoqu'] = $xiaoqu;
           $this->tmpl = 'admin:xiaoqu/report/items.html';         
        }
    }

    public function detail($report_id = null)
    {
        if(!$report_id = (int)$report_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
            $this->pagedata['yezhu'] = K::M('xiaoqu/yezhu')->detail($detail['yezhu_id']);
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->tmpl = 'admin:xiaoqu/report/detail.html';
        }
    }


    public function reply($report_id=null)
    {
        if(!($report_id = (int)$report_id) && !($report_id = $this->GP('report_id'))){
            $this->msgbox->add('未指定要回复的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
            $this->msgbox->add('您要回复的内容不存在或已经删除', 212);
        }else if($content = $this->checksubmit('reply_content')){
            if(K::M('xiaoqu/report')->update($report_id,array('reply'=>$content, 'reply_time'=>__TIME, 'status'=>1))){
                $yezhu = K::M('xiaoqu/yezhu')->detail($detail['yezhu_id']);
                $title = sprintf('您[%s]的投诉已处理', $yezhu['house']);
                $content = sprintf("您[%s]的投诉已处理(%s)", $yezhu['house'], $content);
                K::M('member/member')->send($detail['uid'], $title, $content, 'xiaoqu/report', $report_id);
                $this->msgbox->add('回复投诉成功');
            }  
        }      
    }


    public function delete($report_id=null)
    {
        if($report_id = (int)$report_id){
            if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/report')->delete($report_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('report_id')){
            if(K::M('xiaoqu/report')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}