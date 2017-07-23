<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Comment extends Ctl_Weidian
{

	public function comment()
	{
		$filter['shop_id'] = $this->shop_id;
        $orderby = array('comment_id'=>'desc');
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        if($items = K::M('weidian/comment')->items($filter,$orderby,$page,$limit,$count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink('merchant/weidian/order/comment', array('{page}')));
        }
        foreach ($items as $k => $v) {
        	$uids[] = $v['uid'];
        }
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'merchant:weidian/comment/comment.html';
	}	

	public function comment_wait()
	{
		$filter['shop_id'] = $this->shop_id;
        $filter['reply_time'] = 0;
        $orderby = array('comment_id'=>'desc');
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        if($items = K::M('weidian/comment')->items($filter,$orderby,$page,$limit,$count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink('merchant/weidian/order/comment_wait', array('{page}')));
        }
         foreach ($items as $k => $v) {
        	$uids[] = $v['uid'];
        }
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'merchant:weidian/comment/comment_wait.html';
	}

	public function detail($comment_id)
	{
		 if(!$comment_id = (int)$comment_id){
            $this->error(404);
        }else if(!$detail = K::M('weidian/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在或已经删除', 211);
        }else if($detail['shop_id'] != $this->shop['shop_id']){
            $this->msgbox->add('您没有权限查看该评论', 212);
        }else{
            $photos = K::M('weidian/commentphoto')->items(array('comment_id'=>$comment_id),array('photo_id'=>'desc'));
            $this->pagedata['user'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['photos'] = $photos;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:weidian/comment/detail.html';
        }
		
	}

	public function reply($comment_id)
	{
		if(!($comment_id = (int)$comment_id) && !($comment_id = $this->GP('comment_id')) && !($comment_id = $_POST['data']['comment_id'])){
            $this->msgbox->add('未指定要回复的评论ID', 211);
        }else if(!$detail = K::M('weidian/comment')->detail($comment_id)){
            $this->msgbox->add('您要回复的评论不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            $data['reply'] = htmlspecialchars($data['reply']);
            if(empty($data['reply'])){
                $this->msgbox->add('回复内容不能为空')->response();
            }
            $data['reply_time'] = __TIME;
            $data['reply_ip'] = __IP;
            if(K::M('weidian/comment')->update($comment_id, $data)){
                $this->msgbox->add('回复成功');
            }  
        }
	}
}