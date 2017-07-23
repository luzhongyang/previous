<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Bianmin extends Ctl_Xiaoqu
{
    /**
     * 便民服务列表
     */
   public function index(){
       
       $this->tmpl = 'xiaoqu/bianmin/index.html';
   }
   
   /**
    * 加载
    */
   public function loaddata($page = 1){
       $page = max((int)$page, 1);
       $filter = array();
       $filter['xiaoqu_id'] = $this->xiaoqu_id;
       $limit = 10;
       
       $count_num = K::M('xiaoqu/bianmin')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
       
       $list = K::M('xiaoqu/bianmin')->items($filter,null, $page, $limit,$count);
       $this->msgbox->set_data('loadst', $loadst);
       $this->pagedata['list'] = $list;
       $this->tmpl = 'xiaoqu/bianmin/loaddata.html';
       $html = $this->output(true);
       $this->msgbox->set_data('html',trim($html));
       $this->msgbox->json();
   }
   
   /**
    * 便民服务详情
    * @param type $bianmin_id
    */
   public function detail($bianmin_id){
       if(!$bianmin_id){
           $this->msgbox->add('内容不存在',211);
       }else if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
           $this->msgbox->add('内容不存在',212);
       }else{
           $this->pagedata['detail'] = $detail;
           $this->tmpl = 'xiaoqu/bianmin/detail.html';
       }
   }
   
   /**
    * 便民服务投诉
    * @param type $bianmin_id
    */
   public function report($bianmin_id){
       if(!$bianmin_id){
           $this->msgbox->add('内容不存在',211);
       }else if(!$detail = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
           $this->msgbox->add('内容不存在',212);
       }else{
           $this->pagedata['yezhu_id'] = $this->yezhu_id;
           $this->pagedata['detail'] = $detail;
           $this->tmpl = 'xiaoqu/bianmin/report.html';
       }
   }
   
   /**
    * 便民服务投诉提交
    */
   public function report_handel($bianmin_id){
       $this->check_login();
       $data = $this->checksubmit('data');
       if(!$data['bianmin_id']){
           $this->msgbox->add('没有选择举报对象',211);
       }else if(!$data['title']){
           $this->msgbox->add('投诉类型没有选择',212);
       }else if(!$data['content']){
           $this->msgbox->add('投诉内容没有填写',213);
       }else if($r = K::M('xiaoqu/bianmin/report')->find(array('uid'=>$this->uid,'bianmin_id'=>$bianmin_id))){
           $this->msgbox->add('您已经举报过了',214);
       }else{
           $data['uid'] = $this->uid;
           if(!$report= K::M('xiaoqu/bianmin/report')->create($data)){
                $this->msgbox->add('提交失败',300);
           }else{
                $this->msgbox->add('提交成功!');
           }
       }
   }
   
   
}
