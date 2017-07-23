<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Waimai_Comment extends Ctl_Biz_Waimai 
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['closed'] = 0;
        if($st = $this->GP('st')){
            $filter['reply_time'] = 0;
        }
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('waimai/comment')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $uids = array();
        foreach($items as $k=>$val){
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['st'] = $st;
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;    
        $this->tmpl = 'biz/waimai/comment/index.html';
    }



    public function detail($comment_id)
    {
        if(!$comment_id = (int)$comment_id){
            $this->error(404);
        }else if(!$detail = K::M('waimai/comment')->detail($comment_id)){
            $this->msgbox->add('评论不存在或已经删除', 211);
        }else if($detail['shop_id'] != $this->shop['shop_id']){
            $this->msgbox->add('您没有权限查看该评论', 212);
        }else{
            $photos = K::M('waimai/commentphoto')->items(array('comment_id'=>$comment_id),array('photo_id'=>'desc'));
            $this->pagedata['user'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['photos'] = $photos;
            $this->pagedata['detail'] = $detail;
            //print_r($photos);die;
            $this->tmpl = 'biz/waimai/comment/detail.html';
        }
    }
    

    public function reply($comment_id=0)
    {
       if(!($comment_id = (int)$comment_id) && !($comment_id = $this->GP('comment_id'))){
            $this->msgbox->add('未指定要回复的评论ID', 211);
        }else if(!$detail = K::M('waimai/comment')->detail($comment_id)){
            $this->msgbox->add('您要回复的评论不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            $data['reply'] = htmlspecialchars($data['reply']);
            if(empty($data['reply'])){
                $this->msgbox->add('回复内容不能为空');
            }
            $data['reply_time'] = __TIME;
            $data['reply_ip'] = __IP;
            if(K::M('waimai/comment')->update($comment_id, $data)){
                $this->msgbox->add('回复成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/waimai/comment/reply.html';
        }   
    }

}