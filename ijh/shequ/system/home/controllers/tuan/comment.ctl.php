<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 * check view code by shzhrui
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Comment extends Ctl
{
	// 商家团购的评价列表
    public function index($shop_id, $tuan_id) 
    {    
        if($shop_id = (int)$shop_id) {
            if($shop = K::M('shop/shop')->detail($shop_id)) {
               $shop['star'] = round($shop['score']/$shop['comments'], 2);
            }     
        }
        $this->pagedata['shop'] = $shop;
        $this->pagedata['tuan_id'] = $tuan_id;
    	$this->tmpl = 'tuan/comment.html';
    }

    // 商户全部评价下拉加载
    public function loadcommentitems() 
    {
        $shop_id = (int)$this->GP('shop_id');
        $page = max((int)$this->GP('page'), 1);
 
        if( ($page <= 10) && $comment_list = K::M('shop/comment')->items(array('shop_id'=>$shop_id), array('comment_id'=>'desc'), 1, 10000, $count)){
            $comment_ids = array();
            foreach ($comment_list as $k=>$val){
                $comment_ids[$val['comment_id']] = $val['comment_id'];
                $uids[] = $val['uid'];
            }
            $photo_list = K::M('shop/commentphoto')->items(array('comment_id'=>$comment_ids));
            foreach($photo_list as $kk=>$v){
                $comment_list[$v['comment_id']]['photos'][] = $v;
            }
            foreach ($comment_list as $k=>$val){
                $items[] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,reply,reply_time,dateline,photos', $val);
            }                
            foreach($items as $k => $v){
                $detail = K::M('member/member')->detail($v['uid']);
                $items[$k]['nickname'] = $detail['nickname'];
                $items[$k]['face'] = $detail['face'];
                $items[$k]['reply_time'] = date('Y-m-d H:i:s',$v['reply_time']);
                $items[$k]['dateline'] = date('Y-m-d H:i:s',$v['dateline']);
            }  
            $items = array_slice($items, ($page-1)*10, 10, true);                  
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));     
    }
}