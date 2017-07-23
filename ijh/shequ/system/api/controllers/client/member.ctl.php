<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member extends Ctl
{
    //测试
    public function index()
    {
        $this->check_login();
        $this->msgbox->set_data('data','HERE');
    }
    /* 更换手机号码
     * $new_mobile,必须
     * $sms_code,必须
     */
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
            $this->msgbox->add('验证码不正确',213);
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
    /* 更换头像
     * $face,必须
     */
    public function updateface($params)
    {
        $this->check_login();
        if(!($face = $_FILES['face']) || $face['error']) {
            $this->msgbox->add('头像不正确', 211);
        }else {
            if($a = K::M('magic/upload')->upload($face)) {
                $data['face'] = $a['photo'];
                if(K::M('member/member')->update($this->uid,array('face'=>$data['face']))) {
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('face'=>$data['face']));
                }
            }
        }
    }

    /* 更换昵称
     * $nickname,必须
     */
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
    /* 修改密码
     * $sms_code,必须
     * $new_passwd,必须
     */
    public function passwd($params)
    {
        $this->check_login();
        $session =K::M('system/session')->start();
        if(!$params['sms_code']){
            $this->msgbox->add('短信验证码不能为空',212);
        }else if(!$session->get('code_'.$this->MEMBER['mobile']) || $params['sms_code'] != $session->get('code_'.$this->MEMBER['mobile'])){
            $this->msgbox->add('验证码不正确',213);
        }else if(!$params['new_passwd']){
            $this->msgbox->add('新密码不能为空',214);
        }else{
            if(K::M('member/member')->update($this->uid,array('passwd'=>md5($params['new_passwd'])))){
                $this->msgbox->add('success');
            }
        }
    }
    //会员信息
    public function info()
    {
        $this->check_login();
        $detail = K::M('member/member')->detail($this->uid);
        $detail = $this->filter_fields('uid,nickname,face,mobile,money,orders,jifen,wx_openid,wx_unionid,loginip,lastlogin', $detail);
        $detail['all_orders'] = $detail['orders'];
        unset($detail['orders']);

        //未使用红包数
        $detail['hongbao_count'] = K::M('hongbao/hongbao')->count(array('uid'=>$this->uid, 'order_id'=>0,'ltime'=>'>:'.__TIME));
        //新消息数
        $detail['msg_new_count'] = K::M('member/message')->count(array('uid'=>$this->uid, 'is_read'=>0));
        //待评价
        $detail['order_comment_count'] = K::M('order/order')->count(array('uid'=>$this->uid, 'comment_status'=>0, 'order_status'=>'8', 'closed'=>0));
        $detail['no_comment_count'] = $detail['order_comment_count'];
        //待付款
        $detail['go_pay_count'] = K::M('order/order')->count(array('uid'=>$this->uid, 'from'=>"<>:'maidan'", 'pay_status'=>0, 'order_status'=>'>=:0', 'online_pay'=>1, 'closed'=>0));//待支付
        //待使用
        $detail['tuan_ticket_count'] = K::M('tuan/ticket')->count(array('uid'=>$this->uid, 'status'=>0, 'ltime'=>'>:'.__TIME));//团购券
        $detail['cancle_pay_count'] = 0;//已取消,不显示已取消的条数，由于取消的没法进行消除数量的机制
        $this->msgbox->set_data('data', $detail);
    }
    /* 绑定微信
     * $wx_openid,必须
     * $wx_nickname,必须
     * $wx_face,必须
     */
    public function bindweixin($params)
    {
        $this->check_login();

        if(!$params['wx_openid'] || !$params['wx_unionid']){
            $this->msgbox->add('微信openid不能为空',211);
        }else if(!$params['wx_nickname']){
            $this->msgbox->add('微信昵称不能为空',212);
        }else if(!$params['wx_face']){
            $this->msgbox->add('微信头像不能为空',213);
        }else{
            if($wx_headimgurl = $params['wx_face']){
                if($face = file_get_contents($wx_headimgurl)){
                    K::M('member/face')->update_face($this->uid, '', $face);
                }
            }
            $a = array('wx_openid'=>$params['wx_openid'], 'wx_unionid'=>$params['wx_unionid'],'nickname'=>$params['wx_nickname']);
            if(K::M('member/member')->update($this->uid, $a)){
               $this->msgbox->add('success');
            }else{
                $this->msgbox->add('绑定失败',214);
            }
        }
    }
    //解除微信绑定
    public function nobindweixin()
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
            $this->msgbox->add('绑定失败',214);
        }
    }
    /* 会员消息
     * $type,可选
     * $is_read,可选
     * $page,当前页
     */
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
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }
    /* 读取消息并更改状态
     * $message_id,必须
     */
    public function readmsg($params)
    {
        $this->check_login();
        if(!$msg_id = $params['message_id']) {
            $this->msgbox->add("消息ID未指定",211);
        }else if(!$detail = K::M('member/message')->detail($msg_id)) {
            $this->msgbox->add('消息不存在',212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法的数据请求', 213);
        }else {
            if($detail['is_read'] == 0) {
                if($update = K::M('member/message')->update(array('message_id'=>$msg_id),array('is_read'=>1))){
                    $this->msgbox->add('success');
                }
            }
        }
    }
    /* 删除消息或清空消息 */
    public function delmsg($params)
    {
        $this->check_login();
        if($params['message_id'] == '-1'){
            if(K::M('member/message')->delete_by_uid($this->uid)){
                $this->msgbox->add('success');
            }else{
                $this->msgbox->add('未知错误',212);
            }
        }elseif(!$msg_id = $params['message_id']) {
            $this->msgbox->add("消息ID未指定",211);
        }else if(!$detail = K::M('member/message')->detail($msg_id)) {
            $this->msgbox->add('消息不存在',212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法的数据请求', 213);
        }else if($update = K::M('member/message')->delete($msg_id)){
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add('未知错误',212);
        }
    }
    /* 金额日志
     * $page,必须
     */
    public function log($params)
    {
        $this->check_login();
        $filter = array();
        $filter['type'] = 'money';
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        $count = 0;
        if($moneys = K::M('member/log')->items($filter, array('log_id'=>'DESC'), $page, 10, $count)){
            $items = array();
            foreach($moneys as $k=>$val){
                $items[] = $this->filter_fields('log_id,uid,type,number,intro,dateline', $val);
            }
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count, 'money'=>$this->MEMBER['money']));
    }
    /* 意见反馈
     * $content,必须
     */
    public function feedback($params)
    {
        $this->check_login();
        $data = array('uid'=>$this->uid,'content'=>$params['content'],'deadline'=>time());
        if(!K::M('member/feedback')->add($data)){
            $this->msgbox->add('提交数据失败', 213);
        }
        $this->msgbox->add('success');
    }

    public function invite()
    {
        $this->check_login();
        if(!$invite = K::M('member/invite')->invite_count($this->uid)){
            $invite = array('uid'=>$this->uid, 'invite_count'=>'0', 'invite_money'=>'0');
        }else{
            $invite['uid'] = $this->uid;
            $invite['invite_count'] = (int)$invite['invite_count'];
            $invite['invite_money'] = (float)$invite['invite_money'];
        }
        $cfg = $this->system->config->get('invite');
        $invite['invite_reg_money'] = $cfg['invite_reg_money'];
        $invite['invite_order_money'] = $cfg['invite_order_money'];
        $invite['hongbao_amount'] = $cfg['hongbao_amount'];
        $invite['hongbao_min_amount'] = $cfg['hongbao_min_amount'];
        $siteCfg = $this->system->config->get('site');
        $invite['share_title'] = $siteCfg['title'];
        $invite['share_photo'] = $siteCfg['siteurl'] . './attachs/' . $cfg['share_photo'];
        $invite['share_url'] = $this->mklink('market/invite',array($this->MEMBER['pid']), null, 'www');
        $this->msgbox->set_data('data', $invite);
        $this->msgbox->add('success');
    }
}
