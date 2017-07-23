<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Baoxiu_Index extends Ctl_Wuye
{
    
    /**
     * 报修记录列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $filter['closed'] = 0;
        $baoxiu_ids = array();
        if($items = K::M('xiaoqu/baoxiu')->items($filter, array('baoxiu_id'=>'desc'), $page, $limit, $count)){
            foreach($items as $k => $v){
                $baoxiu_ids[$v['baoxiu_id']] = $v['baoxiu_id'];
            }
            if($baoxiu_photo = K::M('xiaoqu/baoxiu/photo')->items(array('baoxiu_id'=>$baoxiu_ids))){
                foreach($baoxiu_photo as $k => $v){
                    $items[$v['baoxiu_id']]['photo'][] = $v;
                    $items[$v['baoxiu_id']]['photo_count'] += 1;
                }
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/baoxiu/index.html';
    }
    
    
    /**
     * 报修详情
     */
    public function detail($baoxiu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('该服务不存在!',211);
        }else{
            $detail['member'] = K::M('member/member')->detail($detail['uid']);
            if($photo = K::M('xiaoqu/baoxiu/photo')->items(array('baoxiu_id'=>$detail['baoxiu_id']), array('photo_id'=>'desc'))){
                $detail['photo'] = $photo;
            }
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/baoxiu/detail.html';
        }
    }
    
    
    /**
     * 报修回复
     */
    public function reply($baoxiu_id){
        if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('您要回复的报修不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['reply'] = htmlspecialchars($data['reply']);
            if(empty($data['reply'])){
                $this->msgbox->add('回复内容不能为空');
            }
            $data['status'] = 1;
            $data['reply_time'] = __TIME;
            if(K::M('xiaoqu/baoxiu')->update($baoxiu_id, $data)){
                $this->msgbox->add('回复成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/baoxiu/reply.html';
        } 
    }
    
    /**
     * 删除报修
     */
     public function delete($baoxiu_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('不存在的报修',211);
        }else{
            if(K::M('xiaoqu/baoxiu')->delete($baoxiu_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
    
    /**
     * 设置状态
     */
     public function set_status($baoxiu_id,$status){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('不存在的报修',211);
        }else if(!in_array($status,array(-1,0,1))){
            $this->msgbox->add('错误',212);
        }else{
            if(K::M('xiaoqu/baoxiu')->update($baoxiu_id,array('status'=>$status))){
                $this->msgbox->add('设置成功');
            }
        }
    }
    
}
