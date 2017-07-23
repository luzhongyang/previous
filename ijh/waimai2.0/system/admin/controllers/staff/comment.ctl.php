<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Comment extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['comment_id']){$filter['comment_id'] = $SO['comment_id'];}
if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
if($SO['content']){$filter['content'] = "LIKE:%".$SO['content']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/comment')->items($filter, array('comment_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $staff_ids = $uids = array();
            foreach($items as $k=>$v) {
                $staff_ids[$v['staff_id']] = $v['staff_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
            $this->pagedata['uids'] = K::M('member/member')->items_by_ids($uids);
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/comment/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:staff/comment/so.html';
    }

    public function detail($comment_id = null)
    {
        if(!$comment_id = (int)$comment_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('staff/comment')->detail($comment_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['photos'] = K::M('staff/commentphoto')->items(array('comment_id'=>$comment_id));
            $this->pagedata['detail'] = $detail;
            $this->pagedata['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->tmpl = 'admin:staff/comment/detail.html';
        }
    }



    public function edit($comment_id=null)
    {
        if(!($comment_id = (int)$comment_id) && !($comment_id = $this->GP('comment_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('staff/comment')->detail($comment_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('staff/comment')->update($comment_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:staff/comment/edit.html';
        }
    }



    public function delete($comment_id=null)
    {
        if($comment_id = (int)$comment_id){
            if(!$detail = K::M('staff/comment')->detail($comment_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('staff/comment')->delete($comment_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('comment_id')){
            if(K::M('staff/comment')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

    public function reply($comment_id=null)
    {
        if(!($comment_id = (int)$comment_id) && !($comment_id = (int)$this->GP('comment_id'))){
            $this->msgbox->add('未指定评论的ID', 211);
        }else if(!$detail = K::M('staff/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在或已经删除', 212);
        }else if($detail['reply']){
            $this->msgbox->add('该评论已回复过了', 213);
        }else if($reply = $this->checksubmit('reply')){
            if(K::M('staff/comment')->update($comment_id, array('reply'=>$reply, 'reply_time'=>__TIME, 'reply_ip'=>__IP))){
                $this->msgbox->add('回复评论成功');
            }else{
                $this->msgbox->add('回复评论失败',214);
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:staff/comment/reply.html';
        }
    }  

}