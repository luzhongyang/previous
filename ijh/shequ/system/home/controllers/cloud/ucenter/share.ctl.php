<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Cloud_Ucenter_Share extends Ctl_Cloud_Ucenter
{

    public function index() 
    {
       
        $this->tmpl = 'cloud/ucenter/share/items.html';
    }

    
    public function loaddata($page=1){
        
        $filter = array('uid'=>$this->uid);
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('cloud/share')->items($filter,null, $page, $limit, $count)){
            $items = array();
        }
        $goods_id = $uids = $attr_ids = $share_ids = array();
        foreach($items as $k=>$v){
            $goods_id[$v['goods_id']] = $v['goods_id'];
            $attr_ids[$v['attr_id']] = $v['attr_id'];
            $share_ids[$v['share_id']] = $v['share_id'];
        }
        if($goods_ids){
            $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_id);
        }
        if($attr_ids){
            $this->pagedata['attrs'] = K::M('cloud/attr')->items_by_ids($attr_ids);
        }
        $photos = K::M('cloud/sharephoto')->items(array('share_id'=>$share_ids));
        foreach($items as $k=>$v){
            foreach($photos as $k1=>$v1){
                if($v['share_id'] == $v1['share_id']){
                    $items[$k]['photos'][] = $v1['photo'];
                }
            }
        }
        $count_num = K::M('cloud/share')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/ucenter/share/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    
    
    /*晒单*/
    public function add($attr_id){
        $this->check_login();
        if(!$attr_id = (int)$attr_id){
            $this->msgbox->add('该云购不存在!',211);
        }else if(!$detail = K::M('cloud/attr')->detail($attr_id)){
            $this->msgbox->add('该云购不存在!',212);
        }else if($detail['win_uid'] != $this->uid){
            $this->msgbox->add('该云购中奖人不是你哦!',213);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'cloud/ucenter/share/add.html';
        }
    }
    
    public function handle()  //外卖商家和普通商家评论通用
    {
        $this->check_login();
        if($this->checksubmit()){
            $data = $this->GP('data');
            $file = $_FILES;
            if(!$this->uid){
                $this->msgbox->add('您还没有登录!',101);
            }else if(!$data['attr_id']){
                $this->msgbox->add('该云购不存在!',211);
            }else if(!$detail = K::M('cloud/attr')->detail($data['attr_id'])){
                $this->msgbox->add('该云购不存在!',212);
            }else if($detail['share_status'] == 1){
                $this->msgbox->add('你已经晒过单了!',213);
            }else if($detail['win_uid'] != $this->uid){
                $this->msgbox->add('该云购中奖人不是你!',213);
            }else if(!$data['content']){
                $this->msgbox->add('请填写晒单内容!',214);
            }else{
                $data['goods_id'] = $detail['goods_id'];
                $data['uid'] = $this->uid;
                $data['clientip'] = __IP;
                $data['dateline'] = __TIME;
                if($share_id = K::M('cloud/share')->create($data)){
                    if($file){
                        //插入图片
                        foreach($file as $k => $v){
                            if($a = K::M('magic/upload')->upload($v,'photo')){
                                $photo_data = array(
                                    'share_id' => $share_id,
                                    'photo' => $a['photo']
                                );
                                $create_photo = K::M('cloud/sharephoto')->create($photo_data);
                            }
                        }
                    }
                    K::M('cloud/attr')->update($data['attr_id'],array('share_status'=>1));
                    $this->msgbox->add('晒单成功!');
                }else{
                    $this->msgbox->add('晒单失败!',217);
                }
            }

        }

    }
    

}
