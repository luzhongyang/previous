<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop_Comment extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
            if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('shop/comment')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $shop_ids = $uids = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            if($shop_ids){
                $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($uids){
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:shop/comment/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:shop/comment/so.html';
    }

    public function detail($comment_id = null)
    {
        if(!($comment_id = (int)$comment_id) && !($comment_id = (int)$this->GP('comment_id'))){
            $this->msgbox->add('未指定评论的ID', 211);
        }else if(!$detail = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在或已经删除', 212);
        }else if($reply_content = $this->checksubmit('reply_content')){
            $a = array('reply'=>$reply_content, 'reply_time'=>__TIME, 'reply_ip'=>__IP);
            if(K::M('shop/comment')->update($comment_id, $a)){
                $this->msgbox->add('回复评论成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['order'] = K::M('order/order')->detail($detail['order_id']);
            if($detail['staff_id']){
                $this->pagedata['staff_id'] = K::M('staff/staff')->detail($detail['staff_id']);
            }
            $this->tmpl = 'admin:shop/comment/detail.html';
        }
    }

    public function reply($comment_id=null)
    {
        if(!($comment_id = (int)$comment_id) && !($comment_id = (int)$this->GP('comment_id'))){
            $this->msgbox->add('未指定评论的ID', 211);
        }else if(!$detail = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在或已经删除', 212);
        }else if($detail['reply']){
            $this->msgbox->add('该评论已回复过了', 213);
        }else if($reply = $this->checksubmit('reply')){
            if(K::M('shop/comment')->update($comment_id, array('reply'=>$reply, 'reply_time'=>__TIME, 'reply_ip'=>__IP))){
                $this->msgbox->add('回复评论成功');
            }else{
                $this->msgbox->add('回复评论失败',214);
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:shop/comment/reply.html';
        }
    }  
    
    
    public function edit($comment_id=null)
    {
        if(!($comment_id = (int)$comment_id) && !($comment_id = $this->GP('comment_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('shop/comment')->detail($comment_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('shop/comment')->update($comment_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:shop/comment/edit.html';
        }
    }

    public function doaudit($comment_id=null)
    {
        if($comment_id = (int)$comment_id){
            if(K::M('shop/comment')->batch($comment_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('comment_id')){
            if(K::M('shop/comment')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($comment_id=null)
    {
        if($comment_id = (int)$comment_id){
            if(!$detail = K::M('shop/comment')->detail($comment_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('shop/comment')->delete($comment_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('comment_id')){
            if(K::M('shop/comment')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}