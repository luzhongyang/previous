<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Account extends Ctl_Staff
{
    /**
     * 资料管理首页
     * @param $this->staff_id
     */
    public function index($params)
    {
        
        //基本信息
        $detail = K::M('staff/staff')->detail($this->staff_id);
        //认证信息
        $verify = K::M('staff/verify')->detail($this->staff_id);
        if(is_array($verify)){
            $detail += $verify;
        }
        $detail = $this->filter_fields('staff_id,city_id,from,name,mobile,face,sex,verify_name,id_name,id_number,id_photo,status,intro', $detail);
        //技能选择

        if($detail['from'] == 'house'){
            if($tech_items = K::M('house/attr')->items(array('staff_id'=>$this->staff_id))){
                $detail['tech_number']  = count($tech_items);
            }else{
                $detail['tech_number']  = 0;
            }
        }
        if($detail['from'] == 'weixiu'){
            if($tech_items = K::M('weixiu/attr')->items(array('staff_id'=>$this->staff_id))){
               $detail['tech_number']  = count($tech_items); 
            }else{
               $detail['tech_number']  = 0;
            }
        }
        $account = K::M('staff/account')->items(array('staff_id'=>$this->staff_id));
        $account = reset($account);

        if(empty($account)){
            $detail['is_account'] = 0;//未开户
            $detail['account_info'] = array(
                'account_number' =>'',
                'account_name'  => '',
                'account_value'  => '',
                'account_title'  => '',
            );
        }else{
            $detail['is_account'] = 1;//开户
            $detail['account_info'] = array(
                'account_number' => $account['account'],
                'account_name'  => $account['name'],
                'account_value'  => $account['type'],
                'account_title'  => $account['title']
            );
        }
        if($verify){
            $detail['verify'] = array(
                'verify' => $verify['verify'],
                'id_name'   => $verify['id_name'],
                'id_number' => $verify['id_number'],
                'id_photo'  => $verify['id_photo'],
            );
        }else{
            $detail['verify'] = array(
                'verify' => 3,
                'id_name'   => '',
                'id_number' => '',
                'id_photo'  => '',
            );
        }

        $this->msgbox->set_data('data', $detail);
    }
    /**
     * 修改密码
     * @param $this->staff_id
     * @param $oldpswd
     * @param $newpswd
     */
    public function editpswd($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',200);
        }else if(!$oldpswd=$params['oldpswd']){
            $this->msgbox->add('旧密码不正确',200);
        }else if(!K::M('staff/staff')->check_pswd($this->staff_id, $oldpswd)){
            $this->msgbox->add('旧密码不正确',201);
        }else if(!$newpswd=$params['newpswd']){
            $this->msgbox->add('新密码不正确',202);
        }else{
            if(K::M('staff/staff')->update($this->staff_id, array('passwd'=>md5($newpswd)))){
                $this->msgbox->add('修改密码成功');
            }else{
                $this->msgbox->add('修改密码失败',203);
            }
        }
    }
    /**
     * 更换手机号
     * @param $this->staff_id
     * @param $mobile
     * @param $sms_code
     */
    public function update_mobile($params)
    {
        $session = K::M('system/session')->start();
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',211);
        }else if(!$sms_code = $params['sms_code']){
            $this->msgbox->add('验证码不正确',212);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号不正确',213);
        }else if($session->get('code_'.$mobile) != $sms_code){
            $this->msgbox->add('验证码不正确',214);
        }else if(K::M('staff/staff')->update_mobile($this->staff_id, $mobile)){
            $this->msgbox->add('修改手机号码成功');
        }
    }
    /**
     * 修改真实姓名,只能修改一次
     * @param $this->staff_id
     * @param $name
     */
    public function update_name($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',211);
        }else if(!$name = $params['name']){
            $this->msgbox->add('真实姓名不合法',212);
        }else{
            
            $arr_verify = K::M('staff/verify')->detail($this->staff_id);
            
            if(1==$arr_verify['verify']){
                $this->msgbox->add('认证后不可修改真实姓名', 213);
            }
            else if(!K::M('staff/staff')->update($this->staff_id, array('name'=>$name))){
                $this->msgbox->add('修改真实姓名失败',214);
            }else{
                //只允许修改一次用户名
                K::M('staff/staff')->update($this->staff_id, array('updatetime' => 1));
                $this->msgbox->add('修改真实姓名成功');
            }
        }
    }

    /**
     * 修改个人简介
     */
    public function update_intro($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',211);
        }else if(!$intro = $params['intro']){
            $this->msgbox->add('个人简介不合法',212);
        }else{
            if(!K::M('staff/staff')->update($this->staff_id, array('intro'=>$intro))){
                $this->msgbox->add('修改简介失败',214);
            }else{
                $this->msgbox->add('修改简介成功');
            }
        }
    }

    /**
     * 开户行设置
     * @param $this->staff_id
     * @param $account_type,
     * @param $account_name,
     * @param $account_title,
     * @param $account
     */
    public function account_set($params)
    {
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',211);
        }else if(!empty($params)){
            if(!$account_type = $params['account_type']){
                $this->msgbox->add('账户类型不正确',212);
            }else if(!$account_name = $params['account_name']){
                $this->msgbox->add('开户人不正确',213);
            }else if(!$account = $params['account']){
                $this->msgbox->add('账户不正确',213);
            }else{
                $data = array(
                    'staff_id' => $this->staff_id,
                    'type' => $account_type,
                    'name' => $account_name,
                    'account' => $account,
                    'title' => $params['account_title'],
                    'is_default' => 0,
                    'dateline' => time()
                );
                if(K::M('staff/account')->account($data, $this->staff_id)){
                    $this->msgbox->add('账户设置成功');
                }else{
                    K::M('staff/account')->create($data);
                }
            }
        } else {
            $bank_list = K::M('staff/account')->bank_items();
            $this->msgbox->set_data('data', array('items'=>array_values($bank_list)));
        }
    }
    /**
     * 更换头像
     * @param $this->staff_id
     * @param FILE['face']
     */
    public function update_face($params)
    {
        if(!($face = $_FILES['face']) || $face['error']) {
            $this->msgbox->add('头像不正确', 211);
        }else {
            if($a = K::M('magic/upload')->upload($face)) {
                if(K::M('staff/staff')->update($this->staff_id,array('face'=>$a['photo']))) {
                    $this->msgbox->set_data('data', array('face'=>$data['face']));
                }
            }
        }
    }
    /**
     * 技能列表
     * @param $options,技能选项
     */
    public function techs($params)
    {
        $from = $this->staff['from'];
        if($options = $params['options']){
            foreach($options as $k=>$v){
                $options[$k]['staff_id'] = $this->staff_id;
            }
            if(!K::M("{$from}/attr")->insertAll($options,$this->staff_id)){
                $this->msgbox->add('提交数据失败',207);
            }else{
                $this->msgbox->add('提交数据成功');
                $this->msgbox->set_data('data',array('sql'=>$this->system->db->SQLLOG()));
            }

        }else{

            $chosed = $cate = array();
            if($from != "paotui"){
                $chosed = K::M("{$from}/attr")->items(array('staff_id'=>$this->staff_id));
            }

            $cate = K::M("{$from}/cate")->items(array('parent_id'=>'>:0'));
            foreach($cate as $k=>$item){
                foreach($chosed as $v){
                    if($item['cate_id'] == $v['cate_id']){
                        $cate[$k]['is_selected'] = 1;//选中
                    }
                }
            }
            foreach($cate as $k=>$item){
                if(!isset($item['is_selected'])){
                    $cate[$k]['is_selected'] = 0;
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($cate)));
        }
    }

    /**
     * 更新性别
     * @param $sex,1:男,2:女
     */
    public function sex($params)
    {
        if($params['sex'] < 1){
            $this->msgbox->add('参数不正确',200);
        } else {
            if(K::M('staff/staff')->update($this->staff_id, array('sex'=>$params['sex']))){
               $this->msgbox->add('更新性别成功');
            }else{
                $this->msgbox->add('更新性别失败',201);
            }
        }
    }
    /**
     * 是否允许更新姓名, 增加实名认证,如果实名认证,不可修改返回1
     * 0:不允许,1:允许
     */
    public function is_name()
    {
        $staff_id = $this->staff_id;
        //取消只能修改一次的流程,改为不认证,始终可以修改
//        $detail = K::M('staff/staff')->detail($staff_id);
//        $name_status = empty($detail['updatetime']) ? 1 : 0;
        $name_status = 1;
        $arr_verify = K::M('staff/verify')->detail($this->staff_id);
        if(1==$arr_verify['verify']){
            $name_status = 0;
        }
        $this->msgbox->set_data('data', array('name_status'=> $name_status ));
    }


    //提交认证资料
    public function verify($params)
    {
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
            if($attach = $_FILES['photo']){
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

    /*服务人员工作状态*/
    public function set_status($params)
    {
        $this->check_login();
        if(!in_array($params['status'], array(0, 1))){
            $this->msgbox->add('状态错误', 211);
        }else if(K::M('staff/staff')->update($this->staff_id, array('status'=>$params['status']))){
            $this->msgbox->add('success');
            $status = K::M('staff/staff')->detail($this->staff_id);
            $this->msgbox->set_data('status',$status['status']);
        }
    }
}