<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Tieba extends Ctl_Xiaoqu
{

    /**
     * 邻里首页,只列出发布在当前小区的内容
     */
    public function index()
    {
        $this->tmpl = 'xiaoqu/tieba/index.html';
    }
    
    /**
    * 加载
    */
   public function loaddata($page = 1){
       $page = max((int)$page, 1);
       $filter = array();
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $filter['closed'] = 0;
        $limit = 10;
        $list = K::M('xiaoqu/tieba')->items($filter, array('dateline'=>'desc'), $page, $limit, $count);
        $uids = $xiaoqu_ids = $tieba_ids = array();
        foreach($list as $k => $v){
            $uids[$v['uid']] = $v['uid'];
            $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
            $tieba_ids[$v['tieba_id']] = $v['tieba_id'];
        }

        $users = K::M('member/member')->items_by_ids($uids);
        $xiaoqus = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);

        foreach($list as $k => $v){
            $list[$k]['face'] = $users[$v['uid']]['face'];
            $list[$k]['nickname'] = $users[$v['uid']]['nickname'];
            $list[$k]['xiaoqu'] = $xiaoqus[$v['xiaoqu_id']];
        }
        
        if($photo_list = K::M('xiaoqu/tieba/photo')->items(array('tieba_id'=>$tieba_ids), null, 1, 100)){
            foreach($photo_list as $v){
                $list[$v['tieba_id']]['photos'][] = $v['photo'];
            }
        }

        $this->pagedata['list'] = $list;
       $this->tmpl = 'xiaoqu/tieba/loaddata.html';
       $html = $this->output(true);
       $this->msgbox->set_data('html',trim($html));
       $this->msgbox->json();
   }

    /**
     * 邻里圈/二手详情
     */
    public function detail($tieba_id)
    {
        if(!$tieba_id){
            $this->msgbox->add('信息不存在', 211);
        }
        else if(!$detail = K::M('xiaoqu/tieba')->detail($tieba_id)){
            $this->msgbox->add('信息不存在', 212);
        }
        else{
            $member = K::M('member/member')->detail($detail['uid']);
            $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
            K::M('xiaoqu/tieba')->update_count($tieba_id,'views',1);
            $detail['face'] = $member['face'];
            $detail['nickname'] = $member['nickname'];
            $detail['xiaoqu'] = $xiaoqu;
            
            
            //评论列表
            $reply_list = K::M('xiaoqu/tieba/reply')->items(array('tieba_id'=>$tieba_id,'closed'=>0),array('dateline'=>'desc'));
            $uids = $at_uids = array();
            foreach($reply_list as $k => $v){
                $uids[$v['uid']] = $v['uid'];
                if($v['at_uid']){
                    $at_uids[$v['at_uid']] = $v['at_uid'];
                }
            }
            if($members = K::M('member/member')->items_by_ids($uids)){
                foreach($reply_list as $k => $v){
                    $reply_list[$k]['nickname'] = $members[$v['uid']]['nickname'];
                    $reply_list[$k]['face'] = $members[$v['uid']]['face'];
                }
            } 

            if($at_members = K::M('member/member')->items_by_ids($at_uids)){
                foreach($reply_list as $k => $v){
                    if($v['at_uid']){
                        $reply_list[$k]['at_nickname'] = $at_members[$v['at_uid']]['nickname'];
                    }
                }
            }
            
            if($photo_list = K::M('xiaoqu/tieba/photo')->items(array('tieba_id'=>$tieba_id))){
                foreach($photo_list as $v){
                    $detail['photos'][] = $v['photo'];
                }
            }

            //评论列表结束
            $this->pagedata['detail'] = $detail;
            $this->pagedata['reply_list'] = $reply_list;
            $this->tmpl = 'xiaoqu/tieba/detail.html';
        }
    }

    /**
     * 发布到二手from = trade
     */
    public function create_trade($xiaoqu_id)
    {
        $this->check_login();
        if(!$xiaoqu_id){
            $xiaoqu_id = $this->xiaoqu_id;
        }
        $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id);
        $this->pagedata['xiaoqu'] = $xiaoqu;
        $this->tmpl = 'xiaoqu/tieba/create_trade.html';
    }

    /**
     * 发布到邻里圈from = topic
     */
    public function create_topic($xiaoqu_id)
    {
        $this->check_login();
        if(!$xiaoqu_id){
            $xiaoqu_id = $this->xiaoqu_id;
        }
        $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id);
        $this->pagedata['xiaoqu'] = $xiaoqu;
        $this->tmpl = 'xiaoqu/tieba/create_topic.html';
    }

    /**
     * 二手或邻里圈表单提交
     */
    public function create()
    {
        $this->check_login();
        $data = $this->checksubmit('data');
        if(!$data['xiaoqu_id']){
            $this->msgbox->add('小区错误', 211);
        }
        else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($data['xiaoqu_id'])){
            $this->msgbox->add('不存在的小区', 212);
        }
        else if(!in_array($data['from'], array('trade','topic'))){
            $this->msgbox->add('发布类型错误', 213);
        }
        else{

            if(!$data['title'] && $data['from'] == 'trade'){ //如果是二手才有标题
                $this->msgbox->add('标题没有填写', 214)->response();
            }
            else if(!$data['price'] && $data['from'] == 'trade'){
                $this->msgbox->add('价格没有填写', 216)->response();
            }
            else if(!$data['mobile'] && $data['from'] == 'trade'){
                $this->msgbox->add('手机号没有填写', 217)->response();
            }
            else if(!K::M('verify/check')->mobile($data['mobile'])  && $data['from'] == 'trade'){
                $this->msgbox->add('手机号有误', 218)->response();
            }
            else if(!$data['content']){
                $this->msgbox->add('内容没有填写', 215)->response();
            }
            

            //传图end
            $data['uid'] = $this->uid;
            if($create = K::M('xiaoqu/tieba')->create($data)){
                //传图
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k => $v){
                        foreach($v as $kk => $vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'neighbor')){
                            K::M('xiaoqu/tieba/photo')->create(array('tieba_id'=>$create,'photo'=>$a['photo']));
                        }
                    }
                }
                $this->msgbox->add('发布成功');
                $this->msgbox->set_data('forward',  $this->mklink('xiaoqu/tieba:index'));
            }
            else{
                $this->msgbox->add('发布失败', 300);
                $this->msgbox->set_data('forward',  $this->mklink('xiaoqu/tieba:index'));
            }
        }
    }

    /**
     * 点赞
     */
    public function ajax_goods()
    {
        $this->check_login();
        if(IS_AJAX){
            if(!$tieba_id = $this->GP('tieba_id')){
                $this->msgbox->add('错误', 211);
            }
            else if(!$detail = K::M('xiaoqu/tieba')->detail($tieba_id)){
                $this->msgbox->add('错误', 212);
            }
            else{
                K::M('xiaoqu/tieba')->update_count($tieba_id,'likes', 1);
                $this->msgbox->add('success')->response();
            }
        }
    }
    
    
    /**
     * 针对帖子发布留言
     */
    public function ajax_reply_handel(){
        $this->check_login();
        if(IS_AJAX){
            if(!$tieba_id = $this->GP('tieba_id')){
                $this->msgbox->add('错误',211);
            }else if(!$content = htmlspecialchars($this->GP('content'))){
                $this->msgbox->add('留言没有填写',212);
            }else{
                $data = array(
                    'tieba_id'=>$tieba_id,
                    'content'=>$content,
                    'uid'=>$this->uid,
                    'at_uid'=>$this->GP('at_uid'),
                    'at_reply_id'=>$this->GP('at_reply_id')
                );
                if($create = K::M('xiaoqu/tieba/reply')->create($data)){
                    K::M('xiaoqu/tieba')->update_count($tieba_id, 'replys', 1);
                    $this->msgbox->add('留言成功');
                }else{
                    $this->msgbox->add('留言失败',300);
                }
            } 
        }
    }

}
