<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Baoxiu extends Ctl_Xiaoqu
{
   /**
   * 报修
   */
   public function index(){
       $this->check_login();
       $this->pagedata['xiaoqu'] = $this->xiaoqu;
       $yezhu_id = $this->system->cookie->get('UxYezhuId');//获取当前小区ID
       $this->pagedata['yezhu_id'] = $yezhu_id;
       $this->tmpl = 'xiaoqu/baoxiu/index.html';
   }
   
   /**
    * 提交报修
    */
   public function create(){

       $this->check_login();
       $data = $this->checksubmit('data');
       if(!$data['xiaoqu_id']){
           $this->msgbox->add('小区错误',211);
       }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($data['xiaoqu_id'])){
           $this->msgbox->add('不存在的小区',212);
       }else if(!$data['contact']){
           $this->msgbox->add('联系人没有填写',213);
       }else if(!$data['mobile']){
           $this->msgbox->add('手机号没有填写',214);
       }else if(!K::M('verify/check')->mobile($data['mobile'])){
           $this->msgbox->add('手机号有误', 215);
       }else if(!$data['yuyue_time']){
           $this->msgbox->add('希望处理时间没有选择',216);
       }else if(!$data['content']){
           $this->msgbox->add('报修内容没有填写',217);
       }else{
            $data['uid'] = $this->uid;
            $data['yuyue_time'] = strtotime($data['yuyue_time']);
            if($create = K::M('xiaoqu/baoxiu')->create($data)){
               //传图
                if($_FILES['data']){
                     foreach($_FILES['data'] as $k => $v){
                         foreach($v as $kk => $vv){
                             $attachs[$kk][$k] = $vv;
                         }
                     }
                 }
                 $upload = K::M('magic/upload');
                 $images = '';
                 foreach($attachs as $k => $attach){
                     if($attach['error'] == UPLOAD_ERR_OK){
                         if($a = $upload->upload($attach,'repair')){
                             K::M('xiaoqu/baoxiu/photo')->create(array('baoxiu_id'=>$create,'photo'=>$a['photo']));
                         }
                     }
                 }
                 //传图end
               $this->msgbox->add('提交成功');
           }else{
               $this->msgbox->add('提交失败',300);
           }
     
       }
   }
   
   /**
    * 报修记录
    */
   public function log(){
       $this->check_login();
       $this->tmpl = 'xiaoqu/baoxiu/log.html';
   }
   
   /**
    * 加载
    */
   public function loaddata($page = 1){
        $page = max((int)$page, 1);
        $filter = array();
        $filter['xiaoqu_id'] = $this->xiaoqu_id;
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $limit = 10;
        
        $count_num = K::M('xiaoqu/baoxiu')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        
        $list = K::M('xiaoqu/baoxiu')->items($filter,null, $page, $limit,$count);
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['list'] = $list;
        $this->tmpl = 'xiaoqu/baoxiu/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html',trim($html));
        $this->msgbox->json();
   }
   
   /**
    * 提醒
    */
   public function notice($baoxiu_id){
       $this->check_login();
       if(!$baoxiu_id){
           $this->msgbox->add('内容不正确',211);
       }else if(!$baoxiu = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
           $this->msgbox->add('内容不存在',212);
       }else if($baoxiu['uid'] != $this->uid){
           $this->msgbox->add('非法操作',213);
       }else if(($baoxiu['tx_time'] + 3600) > time()){
           $this->msgbox->add('您已经提醒过了,请耐心等待处理',214);
       }else{
           K::M('xiaoqu/baoxiu')->update($baoxiu_id,array('tx_time'=>time()));
           $this->msgbox->add('提醒成功');
       }
   }
   
   
   /**
    * 撤销
    */
   public function delete($baoxiu_id){
       if(!$baoxiu_id){
           $this->msgbox->add('内容不正确',211);
       }else if(!$baoxiu = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
           $this->msgbox->add('内容不存在',212);
       }else if($baoxiu['uid'] != $this->uid){
           $this->msgbox->add('非法操作',213);
       }else{
           K::M('xiaoqu/baoxiu')->delete($baoxiu_id);
           $this->msgbox->add('撤销成功');
       }
   }
   
}
