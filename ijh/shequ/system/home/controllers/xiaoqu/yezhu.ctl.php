<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Yezhu extends Ctl_Xiaoqu
{
    /**
     * 我的地址列表
     */
   public function index(){
       $this->check_login();
       $list = K::M('xiaoqu/yezhu')->items(array('uid'=>$this->uid,'audit'=>1,'closed'=>0));
       $xiaoqu_ids = array();
       foreach($list as $k => $v){
           $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
       }
       $xiaoqus = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
       foreach($list as $k => $v){
           $list[$k]['title'] = $xiaoqus[$v['xiaoqu_id']]['title'];
           if ($xiaoqus[$v['xiaoqu_id']] === null || $xiaoqus[$v['xiaoqu_id']]['audit'] == 0) {// 只显示没被删除并且已审核小区所拥有的业主 edit by zhuhongwei 2016-11-30 10:59:49
              unset($list[$k]);
           }
       }
       $this->pagedata['list'] = $list;
       $this->pagedata['yezhu'] = 1;
       $this->tmpl = 'xiaoqu/yezhu/my.html';
   }
   /**
    * 创建地址
    * @param type $xiaoqu_id
    */
   public function create($xiaoqu_id){
       $this->check_login();
       if((int)$xiaoqu_id){
           $detail = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id);
           $this->pagedata['xiaoqu'] = $detail;
       }
       $this->tmpl = 'xiaoqu/yezhu/create.html';
   }
   
   /**
    * 创建地址表单提交
    */
   public function create_handel(){
       $this->check_login();
       $data = $this->checksubmit('data');
       if(!$data['xiaoqu_id']){
           $this->msgbox->add('小区不正确',211)->response();
       }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($data['xiaoqu_id'])){
           $this->msgbox->add('不存在的小区',212)->response();
       }else if(!$data['house_louhao']){
           $this->msgbox->add('楼栋号没有填写',213)->response();
       }else if(!$data['house_huhao']){
           $this->msgbox->add('户号没有填写',215)->response();
       }else if(!$data['contact']){
           $this->msgbox->add('联系人没有填写',216)->response();
       }else if(!$data['mobile']){
           $this->msgbox->add('手机号没有填写',217)->response();
       }else if(!K::M('verify/check')->mobile($data['mobile'])){
            $this->msgbox->add('手机号有误', 218)->response();
       }else{
           $data['uid'] = $this->uid;
           if(!$address_id = K::M('xiaoqu/yezhu')->create($data)){
                $this->msgbox->add('入驻失败',300)->response();
           }else{
                $this->msgbox->add('入驻成功，请等待物业审核！');
                $this->msgbox->set_data('forward', $this->mklink('xiaoqu',null,null,'base'));
           }
       }
   }
   
   /**
    * 修改地址
    * @param type $address_id
    */
   public function edit($yezhu_id){
       $this->check_login();
       if(!(int)$yezhu_id){
           $this->msgbox->add('不存在的地址',211)->response();
       }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
           $this->msgbox->add('不存在的地址',212)->response();
       }else if($yezhu['uid'] != $this->uid){
           $this->msgbox->add('非法操作',213)->response();
       }else{
           $detail = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
           $yezhu['title'] = $detail['title'];
           $this->pagedata['yezhu'] = $yezhu;
       }
       $this->tmpl = 'xiaoqu/yezhu/edit.html';
   }
   
   /**
    * 修改地址表单提交
    */
   public function edit_handel(){
       $this->check_login();
       $data = $this->checksubmit('data');
       if(!$data['yezhu_id']){
           $this->msgbox->add('地址选择不正确',211)->response();
       }else if(!$yezhu_id = K::M('xiaoqu/yezhu')->detail($data['yezhu_id'])){
           $this->msgbox->add('不存在的地址',212)->response();
       }else if(!$data['house_louhao']){
           $this->msgbox->add('楼栋号没有填写',213)->response();
       }else if(!$data['house_huhao']){
           $this->msgbox->add('户号没有填写',215)->response();
       }else if(!$data['contact']){
           $this->msgbox->add('联系人没有填写',216)->response();
       }else if(!$data['mobile']){
           $this->msgbox->add('手机号没有填写',217)->response();
       }else if(!K::M('verify/check')->mobile($data['mobile'])){
            $this->msgbox->add('手机号有误', 218)->response();
       }else{
           $data['uid'] = $this->uid;
           if(!$update = K::M('xiaoqu/yezhu')->update($data['yezhu_id'],$data)){
                $this->msgbox->add('修改失败',300)->response();
                $this->msgbox->set_data('forward', $this->mklink('xiaoqu/yezhu:index'));
           }else{
                $this->msgbox->add('修改成功');
                $this->msgbox->set_data('forward', $this->mklink('xiaoqu/yezhu:index'));
           }
       }
   }
   
   /**
    * 删除地址
    */
   public function delete($yezhu_id){
       $this->check_login();
       if(!(int)$yezhu_id){
           $this->msgbox->add('地址错误',211);
       }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
           $this->msgbox->add('不存在的地址',212);
       }else if($yezhu['uid'] != $this->uid){
           $this->msgbox->add('非法操作',213);
       }else{
           $del = K::M('xiaoqu/yezhu')->delete($yezhu_id);
           $this->msgbox->add('删除成功');
       }
   }
   
   
   
}
