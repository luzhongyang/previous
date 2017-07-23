<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Report_Index extends Ctl_Wuye
{
    
    /**
     * 投诉记录列表
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['closed'] = 0;
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $report_ids = array();
        if($items = K::M('xiaoqu/report')->items($filter, array('report_id'=>'desc'), $page, $limit, $count)){
            foreach($items as $k => $v){
                $report_ids[$v['report_id']] = $v['report_id'];
            }
            if($report_photo = K::M('xiaoqu/report/photo')->items(array('report_id'=>$report_ids))){
                foreach($report_photo as $k => $v){
                    $items[$v['report_id']]['photo'][] = $v;
                    $items[$v['report_id']]['photo_count'] += 1;
                }
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/report/index.html';
    }
    
    
    /**
     * 投诉详情
     */
    public function detail($report_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
            $this->msgbox->add('该服务不存在!',211);
        }else{
            $detail['member'] = K::M('member/member')->detail($detail['uid']);
            if($photo = K::M('xiaoqu/report/photo')->items(array('report_id'=>$detail['report_id']), array('photo_id'=>'desc'))){
                $detail['photo'] = $photo;
            }
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/report/detail.html';
        }
    }
    
    /**
     * 投诉回复
     */
    public function reply($report_id){
        if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
            $this->msgbox->add('您要回复的投诉不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['reply'] = htmlspecialchars($data['reply']);
            if(empty($data['reply'])){
                $this->msgbox->add('回复内容不能为空');
            }
            $data['status'] = 1;
            $data['reply_time'] = __TIME;
            if(K::M('xiaoqu/report')->update($report_id, $data)){
                $this->msgbox->add('回复成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/report/reply.html';
        } 
    }
    
    /**
     * 删除投诉
     */
    public function delete($report_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
            $this->msgbox->add('不存在的投诉',211);
        }else{
            if(K::M('xiaoqu/report')->delete($report_id)){
                $this->msgbox->add('删除内容成功');
            }
        }
    }
    
    /**
     * 设置状态
     */
     public function set_status($report_id,$status){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/report')->detail($report_id)){
            $this->msgbox->add('不存在的投诉',211);
        }else if(!in_array($status,array(-1,0,1))){
            $this->msgbox->add('错误',212);
        }else{
            if(K::M('xiaoqu/report')->update($report_id,array('status'=>$status))){
                $this->msgbox->add('设置成功');
            }
        }
    }
    
}
