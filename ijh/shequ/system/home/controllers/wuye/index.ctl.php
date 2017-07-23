<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_index extends Ctl_Wuye
{
    
    /**
     * 首页先预留
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $count = array();
        $count['yezhu'] = K::M('xiaoqu/yezhu')->count(array('xiaoqu_id'=>$this->xiaoqu_id,'audit'=>1,'closed'=>0));//业主数量
        $count['bianmin'] = K::M('xiaoqu/bianmin')->count(array('xiaoqu_id'=>$this->xiaoqu_id));//便民服务数量
        $count['bill'] = K::M('xiaoqu/bill')->count(array('xiaoqu_id'=>$this->xiaoqu_id,'pay_status'=>0,'closed'=>0));//未缴费订单
        $count['tixian'] = K::M('xiaoqu/wuye/tixian')->count(array('wuye_id'=>$this->wuye_id,'status'=>0));//未处理提现
        $count['report'] = K::M('xiaoqu/report')->count(array('xiaoqu_id'=>$this->xiaoqu_id,'status'=>0,'closed'=>0));//未处理投诉
        $count['baoxiu'] = K::M('xiaoqu/baoxiu')->count(array('xiaoqu_id'=>$this->xiaoqu_id,'status'=>0,'closed'=>0));//未处理报修
        $this->pagedata['count'] = $count;
        $this->tmpl = 'wuye/index.html';
    }
    
    /**
     * 物业绑定小区
     */
    public function bind($page){
        if($is_bind = K::M('xiaoqu/xiaoqu')->find(array('wuye_id'=>$this->wuye_id))){
            $this->msgbox->add('您已经绑定过了！',211);
            $this->msgbox->set_data('forward', '/wuye/index/index');
        }else{
            $filter = $pager =  array();
            $pager['page'] = $page = max((int)$page, 1);
            $pager['limit'] = $limit = 10;
            $filter['audit'] = 1;
            $filter['closed'] = 0;
            $filter['wuye_id'] = 0;
            if($items = K::M('xiaoqu/xiaoqu')->items($filter, array('xiaoqu_id'=>'desc'), $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'wuye/bind.html';
        }
        
    }
    
    /**
     * 绑定小区确认
     */
    public function bind_sub(){
        $xiaoqu_id = $this->GP('xiaoqu_id');
        if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('错误的小区！',211);
        }else if($xiaoqu['wuye_id'] > 0){
            $this->msgbox->add('该小区已经绑定过物业了！',212);
        }else{
            K::M('xiaoqu/xiaoqu')->update($xiaoqu_id,array('wuye_id'=>$this->wuye_id));
            $this->msgbox->add('绑定成功!');
        }
    }
    
    
     
    
}
