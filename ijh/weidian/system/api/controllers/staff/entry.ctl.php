<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Staff_Entry extends Ctl
{
    /** 
     * 服务端登录
     * @param $mobile,
     * @param $passwd
     */

    public function login($params)
    {
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',212);
        }else if($staff = K::M('staff/auth')->login($mobile, $passwd)){
            $staff = $this->filter_fields('staff_id, city_id,from,name,mobile,face,money,total_money,tixian_percent,tixian_money,orders,score,comments,lat,lng,age,intro,verify_name,token', $staff);    
            $device_info = K::M('jpush/device')->init_device($staff['staff_id'], $params['register_id'], 'staff');            
            $staff['tags']  = array_values($device_info['tags']);
            $this->msgbox->set_data('data', $staff);
        }
    }
    
    
    /**
     * 修改密码
     * @param $mobile
     * @param $sms_code
     * @param $passwd
     */
    public function revise($params)
    {
        $this->check_login();
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if( $params['sms_code'] != $session->get('code_'.$mobile) ){
             $this->msgbox->add('验证码不正确',213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',214);
        }else if(!K::M('shop/auth')->update_passwd($passwd)){
            $this->msgbox->add('密码修改失败',215);
        }else{
            $this->msgbox->add('修改密码成功');
        }
    }
    /** 
     * 申请合作
     * @param $from,类型[house|weixiu|paotui]
     * @param $uname
     * @param $mobile
     * @param $sms_code
     * @param $passwd
     * @param $city_id
     * @param $options,二维数组,array(array('id'=>'','cate_id'=> '', 'cate_title'=>''), ....)
     */
    public function combine($params)
    {       
        $session = K::M('system/session')->start();
        if(!$from = $params['from']){
            $this->msgbox->add('参数不正确111',200);
        }else if(!in_array($from, array('weixiu', 'house', 'paotui'))){
            $this->msgbox->add('参数不正确',200);
        }else if(!$city_id = $params['city_id']){
            $this->msgbox->add('参数不正确',201);
        }else if(!$uname = $params['uname']){
            $this->msgbox->add('用户名不能为空',202);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',203);
        }else if(K::M('staff/staff')->mobile($mobile)){
            $this->msgbox->add('手机号码已被注册',199);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add('短信验证码有误',206);
        }else if(!$passwd=$params['passwd']){
            $this->msgbox->add('密码设置不正确',204);
        }else if(empty($params['options']) && ($from!='paotui')){
            $this->msgbox->add('请选择您的技能',205);
        }else{
            $data = array(
                'from' => $from,
                'city_id' => $city_id,
                'name'=>$uname,
                'verify_name' => 3, //0:待审,1:通过,2:拒绝,3:未提交
                'mobile' => $mobile,
                'passwd' => md5($passwd),
                'lat'=>$params['lat'],
                'lng'=>$params['lat']
            );
            $options = $params['options'];
            if(!$staff_id = K::M('staff/staff')->create($data)){
                $this->msgbox->add('提交数据失败',206);
            }else{
                if(in_array($from, array('weixiu', 'house'))){
                    foreach($options as $k=>$v){
                        $options[$k]['staff_id'] = $staff_id;
                    }
                    if(!K::M("{$from}/attr")->insertAll($options)){
                        $this->msgbox->add('提交数据数据失败',207);exit;
                    }
                }
                //自动登录
                if($staff = K::M('staff/auth')->login($mobile, $passwd)){
                    $staff = $this->filter_fields('staff_id, city_id,from,name,mobile,face,money,total_money,tixian_percent,tixian_money,orders,score,comments,lat,lng,age,intro,verify_name,token', $staff);
                    $device_info = K::M('jpush/device')->init_device($stff['staff_id'], $params['register_id'], 'staff');
                    $staff['tags']  = array_values($device_info['tags']);
                    $this->msgbox->set_data('data', $staff);
                }
            }
        }
    }

    /* 忘记密码
     * @param mobile
     * @param sms_code
     * @param passwd 
     */
    public function forgot($params)
    {
        $session = K::M('system/session')->start();
        if(!$params['mobile']){
            $this->msgbox->add('手机号码有误',211);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',212);
        }else if($session->get('code_'.$mobile) != $params['sms_code']){
            $this->msgbox->add('短信验证码有误',213);
        }else if(!$passwd = $params['passwd']){
            $this->msgbox->add('登录密码不正确',214);
        }else if(!$staff = K::M('staff/staff')->mobile($mobile)){
            $this->msgbox->add('该手机号未注册过',215);
        }else if(K::M('staff/staff')->forget($passwd, $mobile)){
            $this->msgbox->set_data('data', array('staff_id'=>$staff['staff_id']));
        }else {
            $this->msgbox->add('找回密码失败',216);
        }
    }
    /**
     * 实时更新位置
     * @param $lng
     * @param $lat
     */
    public function position($params)
    {
        $this->check_login();
        if(!$params['lng'] || !$params['lat']){
            $this->msgbox->add('参数不正确',200);
        }else{
            $lat = $params['lat'];
            $lng = $params['lng'];
            $data = array(
                'lng' => $lng,
                'lat' => $lat
            );
            K::M('staff/staff')->update($this->staff_id, $data);
            if(!$dateline = (int)$params['dateline']){
                //如果没有传时间戳设置为15分钟前
                $dateline = __TIME - 900;
            }
            $filter = array('staff_id'=>0, 'closed'=>0, 'pay_status'=>1, 'lasttime'=>">:".$dateline);
            if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
                //使用此函数计算得到结果后，带入sql查询。
                $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 5); //5KM以内的新订单
                $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            }  
            if(in_array($this->staff['from'], array('weixiu','house'))){
                $filter['from'] = $this->staff['from'];
            }else{
                $filter[':SQL'] = "((`from`='waimai' AND ((`pei_type`=1 AND `order_status` IN(1,2)) OR (`order_status`=0 AND `pei_type`=2))) OR (`from`='paotui' AND `order_status`=0))";
            }
            // 查询该服务人员的技能分类、根据技能分类id查附属订单表的order_id
            if(in_array($this->staff['from'], array('weixiu', 'house'))){
                if($attr_items = K::M("{$this->staff['from']}/attr")->items(array('staff_id'=>$this->staff_id))) {
                    foreach($attr_items as $k=>$v) {
                        $cate_ids[] = $v['cate_id'];
                    }
                    $filter[$this->staff['from']]['cate_id'] = $cate_ids;
                }
                $new_order_count = K::M("{$this->staff['from']}/order")->order_count($filter);              
            }else{
                $new_order_count = (int)K::M('order/order')->count($filter);
            }
            $this->msgbox->set_data('data', array('new_order'=>$new_order_count, 'dateline'=>__TIME));
        }
    }

}