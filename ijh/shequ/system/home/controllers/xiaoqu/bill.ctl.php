<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Bill extends Ctl_Xiaoqu
{
    /**
     * 缴费列表
     */
   public function index(){
       
       $this->check_login();
        if(!$yezhu_id = $this->yezhu_id){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您不是该小区业主', 214);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您不是该小区业主', 215);
        }else{
            $this->tmpl = 'xiaoqu/bill/index.html';
        }
   }
   
   /**
    * 加载
    */
    public function loaddata($page = 1){
        $this->check_login();
        if(!$yezhu_id = $this->yezhu_id){
            $items = array();
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $items = array();
        }else if($yezhu['uid'] != $this->uid){
            $items = array();
        }else{
            $limit = 10;
            $page = max((int)$page, 1);
            if ($xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id'])) {
                if($items = K::M('xiaoqu/bill')->items(array('yezhu_id'=>$yezhu_id, 'closed'=>0,'xiaoqu_id'=>$xiaoqu['xiaoqu_id']), array('bill_id'=>'DESC'), $page, $limit, $count)){// edit by zhuhongwei 20161125 v1 账单需要绑定到小区
                    $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
                    $wuye = K::M('xiaoqu/xiaoqu')->detail($xiaoqu['wuye_id']);
                    foreach($items as $k=>$v){
                        $v['bill_title'] = date("Y年m月账单", strtotime($v['bill_sn']));
                        $v['xiaoqu_title'] = $xiaoqu['title'];
                        $v['yezhu_name'] = $yezhu['contact'];
                        $v['yezhu_house'] = $yezhu['house'];
                        $v['wuye_name'] = $wuye['title'];
                        $items[$k] = $v;
                    }
                }else{
                    $items = array();
                }
                
                $count_num = K::M('xiaoqu/bill')->count(array('yezhu_id'=>$yezhu_id, 'closed'=>0));
                if($count_num <= $limit){
                    $loadst = 0; 
                }else{
                    $loadst = 1; 
                }

                $this->msgbox->set_data('loadst', $loadst);
                $this->pagedata['items'] = $items;
                $this->tmpl = 'xiaoqu/bill/loaddata.html';

                $html = $this->output(true);
                $this->msgbox->set_data('html',trim($html));
                $this->msgbox->json();
            }
        }
    }
   
   /**s
    * 缴费详情
    * @param type $bill_id
    */
   public function detail($bill_id){
       $this->check_login();
        if(!$bill_id = (int)$bill_id){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$bill = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('帐单不存在或已经删除', 214);
        }else if($bill['uid'] != $this->uid){
            $this->msgbox->add('您没有权限', 215);
        }else if($bill['xiaoqu_id'] != $this->xiaoqu_id){// edit by zhuhongwei 20161125 v1 越权操作包括跨小区
            $this->msgbox->add('您没有权限', 216);
        }else{
            $yezhu = K::M('xiaoqu/yezhu')->detail($bill['yezhu_id']);
            $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
            $wuye = K::M('xiaoqu/xiaoqu')->detail($xiaoqu['wuye_id']);
            $bill['xiaoqu_title'] = $xiaoqu['title'];
            $bill['yezhu_name'] = $yezhu['contact'];
            $bill['yezhu_house'] = $yezhu['house'];
            $bill['wuye_name'] = $wuye['title'];
            $bill['bill_title'] = date("Y年m月账单", strtotime($bill['bill_sn']));
            $this->pagedata['detail'] = $bill;
            //print_r($bill);die;
            $this->tmpl = 'xiaoqu/bill/detail.html';
        }
   }

    /**
    * 缴费付款
    */
   public function pay($bill_id)
    {
        $this->check_login();
        $bill_id = (int)$bill_id;
        if(!$bill_id){
            $this->msgbox->add('订单不存在!',211);
        }else if(!$bill = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('订单不存在!',212);
        }else if($bill['pay_status']){
            $this->msgbox->add('该订单已支付!',213);
        }else if($bill['uid'] != $this->uid){
            $this->msgbox->add('非法操作!',214);
        }else if($bill['xiaoqu_id'] != $this->xiaoqu_id){// edit by zhuhongwei 20161125 v1 越权操作包括跨小区
            $this->msgbox->add('非法操作!',215);
        }else {
            if(defined('IN_WEIXIN')){
                $this->pagedata['weixin'] = 1;
            }
            $this->pagedata['bill'] = $bill;
            $this->tmpl = 'xiaoqu/bill/pay.html';            
        }
    }
   
   
}
