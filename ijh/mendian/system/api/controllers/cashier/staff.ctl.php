<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Staff extends Ctl_Cashier 
{
    
    public function items($params)
    {
        $this->check_owner();
        $page = max((int)$params['page'], 1);
        $limit = 20;
        if($items = K::M('cashier/staff')->items(array('shop_id'=>$this->shop_id, 'closed'=>0), null, $page, $limit, $count)){
            foreach($items as $k=>$v){
                unset($v['passwd']);
                $items[$k] = $v;
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }
    
    public function detail($params)
    {
        if(!$this->staff['is_owner']){
            $staff_id = $this->staff['staff_id'];
        }else if(!$staff_id = (int)$params['staff_id']){
            $staff_id = $this->staff['staff_id'];
        }
        if(!$staff_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$staff = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('收银员不存在', 212);
        }else if($staff['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限查看', 213);
        }else{
            unset($staff['passwd']);
            $this->msgbox->set_data('data', array('staff_detail'=>$staff));
        }
    }

    public function create($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'name,mobile,passwd')){
            $this->msgbox->add('参数错误', 211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add("手机号码不正确", 212);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($staff_id = K::M('cashier/staff')->create($data)){
                $this->msgbox->set_data('data', array('staff_id'=>$staff_id));
            }
        }
    }

    public function edit($params)
    {
        $this->check_owner();
        if(!$staff_id = (int)$params['staff_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$data = $this->check_fields($params, 'name,mobile,passwd')){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(!$staff = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('收银员不存在', 212);
        }else if($staff['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限修改', 213);
        }else if(K::M('cashier/staff')->update($staff_id, $data)){
            $this->msgbox->set_data(array('staff_id'=>$staff_id));
        }
    }

    public function delete($params)
    {
        $this->check_owner();
        if(!$staff_id = (int)$params['staff_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$staff = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('收银员不存在', 212);
        }else if($staff['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限删除', 213);
        }else if($staff['is_owner']){
            $this->msgbox->add('店主不可删除', 213);
        }else if(K::M('cashier/staff')->delete($staff_id)){
           $this->msgbox->set_data('data', array('staff_id'=>$staff_id));
        }
    }

    //邀请收银员
    public function invite($params)
    {
        $this->check_owner();
        if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码不正确', 211);
        }else if($staff = K::M('cashier/staff')->detail_by_mobile($mobile)){
            if($staff['shop_id'] == $this->shop_id){
                $this->msgbox->add('手机号已经存在', 212);
            }else{
                $this->msgbox->add('该手机号已经绑定过其他商户', 213);
            }
        }else{
            $url = $this->shop['url'].'/card/invite/index-'.$mobile.'.html';
            if($ret = K::M('net/http')->callapi('tools/shorturl', array('url_long'=>$url))){
                $url = $ret['url_short'];
            }
            if(!K::M('sms/sms')->send($mobile, 'cashier_invite_staff', array('url'=>$url, 'shop_title'=>$this->shop['title']))){
                $this->msgbox->add('发送邀请失败', 214);
            }
        }
    }

    public function doaudit($params)
    {
        $this->check_owner();
        if(!$staff_id = (int)$params['staff_id']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$staff = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('收银员不存或已近删除', 212);
        }else if($staff['shop_id']  != $this->shop_id){
            $this->msgbox->add('越权操作', 213);
        }else if(K::M('cashier/staff')->update($staff_id, array('audit'=>1))){
            $this->msgbox->set_data(array('staff_id'=>$staff_id));
        }
    }

    public function setpasswd($params)
    {
        if(!$old_passwd = $params['old_passwd']){
            $this->msgbox->add('旧密码不正确', 211);
        }else if(md5($old_passwd) != $this->staff['passwd']){
            $this->msgbox->add('旧密码不正确', 212);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add('新密码不正确', 213);
        }else if($old_passwd == $new_passwd){
            $this->msgbox->add('新旧密码不能相同', 213);
        }else if(strlen($new_passwd) < 6){
            $this->msgbox->add('密码长度不能少于6位', 214);
        }else if(K::M('cashier/staff')->update($this->staff_id, array('passwd'=>md5($new_passwd)))){
            if($staff = $this->auth->login($this->staff_id, $new_passwd)){
                $staff = $this->filter_fields('staff_id,shop_id,name,mobile,face,is_owner,audit', $staff);
                $staff['token'] = $this->auth->token;
                $this->msgbox->set_data('data', $staff);
            }    
        }
    }

    public function setinfo($params)
    {
        if(!$data = $this->check_fields($params, 'name')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(empty($data['name'])){
            $this->msgbox->add('昵称不能为空', 211);
        }else if(K::M('cashier/staff')->update($this->staff_id, $data)){
            $this->msgbox->set_data('data', array('staff_id'=>$this->staff_id));
        }
    }

    public function jiaoban($params)
    {
        $this->check_owner();
        if(!$staff_id = (int)$params['staff_id']){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$staff = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('收银员不存在', 212);
        }else if($staff['shop_id'] != $this->shop_id){
            $this->msgbox->add('收银员不存在', 213);
        }else if(empty($staff['day_orders']) && empty($staff['day_refund_count'])){
            $this->msgbox->add('当前没有首款记录无需交班', 214);
        }else if(!K::M('cashier/staff')->jiaoban($staff_id, $staff)){
            $this->msgbox->add('收银员交接班失败', 215);
        }else{
            $this->msgbox->set_data(array('staff_detail'=>$staff_detail));
        }
    }
}