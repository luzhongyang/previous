<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Baoxiu extends Ctl
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['baoxiu_id']){$filter['baoxiu_id'] = $SO['baoxiu_id'];}
            if($SO['uid']){$filter['uid'] = $SO['uid'];}
            if($SO['contact']){$filter['contact'] = "LIKE:%".$SO['contact']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
            if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/baoxiu')->items($filter, null, $page, $limit, $count)){
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
        $this->tmpl = 'admin:xiaoqu/baoxiu/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/baoxiu/so.html';
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
            if($items = K::M('xiaoqu/baoxiu')->items($filter, null, $page, $limit, $count)){
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
            $this->tmpl = 'admin:xiaoqu/baoxiu/items.html';            
        }
    }

    public function detail($baoxiu_id = null)
    {
        if(!$baoxiu_id = (int)$baoxiu_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
            $this->pagedata['yezhu'] = K::M('xiaoqu/yezhu')->detail($detail['yezhu_id']);
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->tmpl = 'admin:xiaoqu/baoxiu/detail.html';
        }
    }

    public function reply($baoxiu_id=null)
    {
        if(!($baoxiu_id = (int)$baoxiu_id) && !($baoxiu_id = $this->GP('baoxiu_id'))){
            $this->msgbox->add('未指定要回复的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('您要回复的内容不存在或已经删除', 212);
        }else if($content = $this->checksubmit('reply_content')){
            if(K::M('xiaoqu/baoxiu')->update($baoxiu_id,array('reply'=>$content, 'reply_time'=>__TIME, 'status'=>1))){
                $yezhu = K::M('xiaoqu/yezhu')->detail($detail['yezhu_id']);
                $title = sprintf('您[%s]的报修已处理', $yezhu['house']);
                $content = sprintf("[%s]的报修已处理(%s)", $yezhu['house'], $content);
                K::M('member/member')->send($detail['uid'], $title, $content, 'xiaoqu/baoxiu', $baoxiu_id);
                $this->msgbox->add('回复报修成功');
            }  
        }
    }

    public function delete($baoxiu_id=null)
    {
        if($baoxiu_id = (int)$baoxiu_id){
            if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/baoxiu')->delete($baoxiu_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('baoxiu_id')){
            if(K::M('xiaoqu/baoxiu')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}