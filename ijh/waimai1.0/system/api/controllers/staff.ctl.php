<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff extends Ctl
{

    public function index()
    {
        exit('{"error":"0", "message":"staff api test"}');
    }

    public function login($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add(L('登录密码不正确'),212);
        }else if($staff = K::M('staff/auth')->login($mobile, $passwd)){
            $staff = $this->filter_fields('staff_id,name,face,mobile,money,status',$staff);
            $staff['token'] = $this->auth->token;
            if($a = K::M('rongcloud/rongcloud')->init_token('S'.$staff['staff_id'], $staff['name'], $staff['face'])){
                $staff['rongcloud'] = $a;
            }else{
                $staff['rongcloud'] = array('uuid'=>'S'.$staff['staff_id'], 'token'=>'','appkey'=>'');
            }
            $this->msgbox->set_data('data',$staff);
        }
    }

    public function signup($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add(L('登录密码不正确'),214);
        }else if(!$name = $params['name']){
            $this->msgbox->add(L('用户名不能为空'),214);
        }else if($staff = K::M('staff/staff')->staff($mobile, 'mobile')){
            $this->msgbox->add(L('该手机号已经注册'),215);
        }else{
            $a = array('mobile'=>$mobile, 'passwd'=>$passwd);
            if(!$a['name'] = $params['name']){
                $a['name'] = substr($mobile, 1,3).'***'.substr($mobile, -4);
            }            
            if($staff_id = K::M('staff/staff')->create($a)){
                $this->msgbox->set_data('data', array('staff_id'=>$staff_id));
            }
        }
    }

    public function forgot($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add(L('手机号不能为空'),211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add(L('登录密码不正确'),214);
        }else if(!$staff = K::M('staff/staff')->staff($mobile, 'mobile')){
            $this->msgbox->add(L('该手机号未注册过'),215);
        }else if(K::M('staff/staff')->update($staff['staff_id'], array('passwd'=>$new_passwd))){
            $this->msgbox->set_data('data', array('staff_id'=>$staff['staff_id']));
        }
    }

    public function passwd($params)
    {
        $this->check_login();
        $session = K::M('system/session')->start();
        if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!$new_passwd = $params['new_passwd']){
            $this->msgbox->add(L('新密码不正确'),214);
        }else if(K::M('staff/staff')->update($this->staff_id, array('passwd'=>$new_passwd))){
            $this->msgbox->set_data('data', array('staff_id'=>$this->staff_id));
        }
    }

    public function updatemobile($params)
    {
        $this->check_login();
        $session = K::M('system/session')->start();
        if(!$new_mobile = K::M('verify/check')->mobile($params['new_mobile'])){
            $this->msgbox->add(L('手机号不正确'),212);
        }else if($session->get('code_'.$new_mobile) != $params['sms_code']){
            $this->msgbox->add(L('短信验证码不正确'),213);
        }else if(!($passwd = $params['passwd']) || (md5($passwd) != $this->staff['passwd'])){
            $this->msgbox->add(L('登录密码不正确'),214);
        }else if(K::M('staff/staff')->update($this->staff_id, array('mobile'=>$new_mobile))){
            $this->msgbox->set_data('data', array('staff_id'=>$this->staff_id));
        }
    }

    //提交认证资料
    public function verify($params)
    {
        $this->check_login(); 
        $detail = K::M('staff/verify')->detail($this->staff_id);       
        if($detail['verify'] === 1){
            $this->msgbox->add(L('已经认证成功不可修改'),210);
        }else if(!$name = $params['id_name']){
            $this->msgbox->add(L('真实姓名不能为空'), 211);
        }else if(!$id_number = $params['id_number']){
            $this->msgbox->add(L('身份证号码不能为空'), 212);
        }else if(!$id_number = K::M('verify/check')->id_number($id_number)){
            $this->msgbox->add(L('身份证号码不正确'), 213);
        }else{
           $data = array('id_name'=>$name, 'id_number'=>$id_number, 'verify'=>0);
            if($attach = $_FILES['id_photo']){
                if($a = K::M('magic/upload')->upload($attach)){
                    $data['id_photo'] = $a['photo'];
                }
            }
            if(!$detail['staff_id']){
                $data['staff_id'] = $this->staff_id;                
                $res = K::M('staff/verify')->create($data);
            }else{
                $res =K::M('staff/verify')->verify($this->staff_id,$data);
            }
            if($ret) {
                $this->msgbox->add('success');
            }
        }
    }

    public function verifyinfo($params)
    {
        $this->check_login();
        if(!$verify_info = K::M('staff/verify')->detail($this->staff_id)){
            $verify_info = array('staff_id'=>$this->staff,'id_name'=>'','id_number'=>'','id_photo'=>'','verify'=>'','verify_time'=>'','refuse'=>'','updatetime'=>'');
        }
        $this->msgbox->set_data('data', $verify_info);
        $this->msgbox->add('success');
    }

    //结算帐号设置
    public function account($params)
    {
        $this->check_login();
        if(!$account_type = $params['account_type']){
            $this->msgbox->add(L('开户行不能为空'), 211);
        }else if(!$account_name = $params['account_name']){
            $this->msgbox->add(L('开户人不能为空'), 212);
        }else if(!$account_number = $params['account_number']){
            $this->msgbox->add(L('提现帐号不能为空'), 212);
        }else if(K::M('staff/staff')->update($this->staff_id, array('account_name'=>$account_name, 'account_type'=>$account_type, 'account_number'=>$account_number))){
            $this->msgbox->add('success');
        }
    }

    public function info($params)
    {
        $this->check_login();
        $staff = $this->filter_fields('staff_id,name,mobile,face,money,total_money,orders,loginip,lastlogin,account_type,account_name,account_number,lat,lng,pmid,verify_name,audit,pid,tixian_percent', $this->staff);

        if(!$verify = K::M('staff/verify')->detail($this->staff_id)) {
            $staff['refuse'] = '';
            $staff['verify_status'] = L('您还未提交身份认证资料');
        }else {
            $staff['refuse'] = $verify['refuse'];
            if($verify['verify'] == 0 && $verify['id_name'] && $verify['id_number'] && $verify['id_photo']) {
                $staff['verify_status'] = L('已提交认证资料等待管理员审核');
            }  
            $staff['id_name'] = $verify['id_name'];
            $staff['id_number'] = $verify['id_number'];
            $staff['id_photo'] = $verify['id_photo'];
        }
        // staff_id 0等待配送员接单
        $filter = array('staff_id'=>0, 'closed'=>0, 'pay_status'=>1, 'pei_type'=>array(1,2));
        $filter[':SQL'] = "(`order_status`=1 OR (`order_status`=0 AND `pei_type`=2))";
        //使用此函数计算得到结果后，带入sql查询。
        if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
            $squares = K::M('helper/round')->returnSquarePoint($staff['lng'], $staff['lat'], 5); //5KM以内的新订单
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        }
        $staff['order_jie_count'] = (int)K::M('order/order')->count($filter);
        $staff['order_pei_count'] = (int)K::M('order/order')->count(array('staff_id'=>$this->staff_id, 'closed'=>0, 'order_status'=>array(1,2,3)));
        $staff['order_end_count'] = (int)K::M('order/order')->count(array('staff_id'=>$this->staff_id, 'closed'=>0, 'order_status'=>array(4,5,6,7,8)));
        $staff['msg_new_count'] = (int)K::M('staff/msg')->count(array('staff_id'=>$this->staff_id, 'is_read'=>0));
        $this->msgbox->set_data('data', $staff);  
    }

    //上报当前位置接口
    public function location($params)
    {
        
        $this->check_login();
        if(!($lat = $params['lat']) || !($lng = $params['lng'])){
            $this->msgbox->add(L('经纬度不正确'), 211);
        }else if(K::M('staff/staff')->update($this->staff_id, array('lat'=>$lat, 'lng'=>$lng))){
            $this->msgbox->add('success');
        }
        
    }
    
    
    public function set_status($params)
    {
        $this->check_login();
        if(!in_array($params['status'], array(0, 1))){
            $this->msgbox->add(L('状态错误'), 211);
        }else if(K::M('staff/staff')->update($this->staff_id, array('status'=>$params['status']))){
            $this->msgbox->add('success');
            $status = K::M('staff/staff')->detail($this->staff_id);
            $this->msgbox->set_data('status',$status['status']);
        }
    }

}
