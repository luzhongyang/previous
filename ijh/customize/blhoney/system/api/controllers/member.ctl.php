<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member extends Ctl
{

    // 会员消息
    public function msg($params)
    {
        $this->check_login();
        $filter = array();
        if(in_array($params['type'], array(0,1,2,3))){
            if($params['type']>0){
                $filter['type'] = $params['type']; 
            }
        }
        if(in_array($params['is_read'], array(0,1,2))){
            if($params['is_read'] < 2){
                $filter['is_read'] = $params['is_read']; 
            }
        }
        $filter['uid'] = $this->uid;
        $orderby = array('message_id'=>'desc');
        $page = max((int)$params['page'], 1);
        $count = 0;
        if(!$items = K::M('member/message')->items($filter, $orderby, $page, 10, $count)){
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function info($params)
    {
        $this->check_login();
        $detail = K::M('member/member')->detail($this->uid);
        $detail = $this->filter_fields('uid,nickname,face,mobile,money,orders,jifen,wx_openid,loginip,lastlogin',$detail);
        $detail['hongbao_count'] = K::M('hongbao/hongbao')->count(array('uid'=>$this->uid, 'order_id'=>0));
        $detail['msg_new_count'] = K::M('member/message')->count(array('uid'=>$this->uid, 'is_read'=>0));
        $detail['order_comment_count'] = K::M('order/order')->count(array('uid'=>$this->uid, 'order_status'=>8,'comment_status'=>0));
        $this->msgbox->set_data('data', $detail);
        $this->msgbox->add('success');
    }

    // 更新消息状态为已读
    public function readmsg($params)
    {
        $this->check_login();
        if(!$msg_id = $params['message_id']) {
            $this->msgbox->add('消息不存在',211);
        }else if(!$detail = K::M('member/message')->detail($msg_id)) {
            $this->msgbox->add('消息不存在',212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }else {
            if($detail['is_read'] == 0) {
                if($update = K::M('member/message')->update(array('message_id'=>$msg_id),array('is_read'=>1))){
                    $this->msgbox->add('success');
                }
            }     
        } 
    }

    public function passwd($params)
    {
        $this->check_login();
        $session =K::M('system/session')->start();
        if(!$params['sms_code']){
            $this->msgbox->add('短信验证码不能为空',212);
        }else if(!$session->get('code_'.$this->MEMBER['mobile']) || $params['sms_code'] != $session->get('code_'.$this->MEMBER['mobile'])){
            $this->msgbox->add('短信验证码不正确',213);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add('新密码不能为空',214);
        }else{
            if(K::M('member/member')->up_passwd($this->uid,$new_passwd)) {
                $this->msgbox->add('success');
            }
        }
    }


    public function updatename($params)
    {
        $this->check_login();
        if(!$params['nickname']){
            $this->msgbox->add('昵称不能为空',211);
        }else if(!$up = K::M('member/member')->update($this->uid,array('nickname'=>$params['nickname']))){
            $this->msgbox->add('修改失败',212);
        }else{
            $this->msgbox->add('修改成功');
        }
    }

    public function updatemobile($params)
    {
        $this->check_login();
        $session =K::M('system/session')->start();
        if(!$params['new_mobile']){
            $this->msgbox->add('新手机号不能为空',233);
        }else if(!$new_mobile = K::M('verify/check')->mobile($params['new_mobile'])){
            $this->msgbox->add('新手机号不不正确',223);
        }else if(!$params['sms_code']){
            $this->msgbox->add('短信验证码不能为空',231);
        }else if(!$session->get('code_'.$params['new_mobile']) || $params['sms_code'] != $session->get('code_'.$params['new_mobile'])){
            $this->msgbox->add('短信验证码不正确',213);
        }else if($detail = K::M('member/member')->find(array('mobile'=>$params['new_mobile']))){
            $this->msgbox->add('该手机号已经存在',212);
        }else{
            if(K::M('member/member')->update($this->uid,array('mobile'=>$params['new_mobile']))){
                $this->msgbox->add('success');
            }else{
                $this->msgbox->add('修改失败',214);
            }
        }
    }

    public function uploadface($params)
    {
        $this->check_login();
        if(!$face = $params['face']){
            $this->msgbox->add('未上传文件', 211);
        }else if(!$face = base64_decode($face)){
            $this->msgbox->add('文件格式不对', 211);
        }else if($face_url = K::M('member/member')->update_face($this->uid, null, $face)){
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('face'=>$face_url));
        }
    }

    public function bindweixin($params){
        $this->check_login();
        if(!$params['wx_nickname']){
            $this->msgbox->add('微信昵称不能为空',212);
        }else if(!$params['wx_face']){
            $this->msgbox->add('微信头像不能为空',213);
        }else{
            $data = array(
                'wx_openid' => $params['wx_openid'],
                'wx_unionid' => $params['wx_unionid'],
                'nickname' => $params['wx_nickname'],
                'face' => $params['wx_face']
            );
            $bind = K::M('member/member')->update($this->uid,$data);
            if($bind){
               $this->msgbox->add('success');
            }else{
                $this->msgbox->add('绑定失败',214);
            }
        }
    }

    //解除微信绑定
    public function unbindweixin()
    {
        $this->check_login();
        $data = array(
            'wx_openid' => '',
            'wx_unionid' => '',
        );
        $bind = K::M('member/member')->update($this->uid,$data);
        if($bind){
           $this->msgbox->add('success');
        }else{
            $this->msgbox->add('解绑失败',214);
        }
    }

    public function invite()
    {
        if(!$invite = K::M('member/invite')->invite_count($this->uid)){
            $invite = array('uid'=>$this->uid, 'invite_count'=>'0', 'invite_money'=>'0');
        }else{
            $invite['uid'] = $this->uid;
            $invite['invite_count'] = (int)$invite['invite_count'];   //邀请人累计好友注册数
            $invite['invite_money'] = (float)$invite['invite_money']; //邀请人累计邀请奖励收益
        }
        $cfg = $this->system->config->get('invite');
        $invite['invite_reg_money'] = $cfg['invite_reg_money'];       //被邀请人注册账号后奖励给邀请人
        $invite['invite_order_money'] = $cfg['invite_order_money'];   //被邀请人首次下单后奖励给邀请人
        $invite['hongbao_amount'] = $cfg['hongbao_amount'];           //红包奖励给被邀请人
        $invite['hongbao_min_amount'] = $cfg['hongbao_min_amount'];   //所赠红包的使用条件
        $siteCfg = $this->system->config->get('site');
        $invite['share_title'] = $siteCfg['title'];
        $invite['share_photo'] = $cfg['share_photo'];
        $invite['share_url'] = $this->mklink('market/invite',array($this->MEMBER['pid']), null, 'www');
        $this->msgbox->set_data('data', $invite);
        $this->msgbox->add('success');
    }

}
