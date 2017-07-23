<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_Addr extends Ctl
{
    /* 地址列表
     * $page,必须
     */
    public function index($params)
    {
        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        $orderby = array('addr_id'=>'desc');
        $count = 0;
        if($items = K::M('member/addr')->items($filter, $orderby, $page, 10, $count)){
            foreach($items as $k=>$val){
                $items[$k] = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,type,lat,lng', $val);
            }
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }
    /* 添加地址
     * $contact,必填
     * $mobile,必填
     * $house,必填
     * $addr,必填
     * $lat,必填
     * $lng,必填
     * $is_default,必填
     */

    public function create($params)
    {
        $this->check_login();
        if(!$contact = $params['contact']) {
            $this->msgbox->add('联系人填写有误',212);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add('手机号码有误',213);
        }else if(!$house = $params['house']) {
            $this->msgbox->add('收货地址有误',214);
        }else if(!$addr = $params['addr']) {
            $this->msgbox->add('详细收货地址有误',215);
        }else if(!$lat = $params['lat']) {
            $this->msgbox->add('经度有误',216);
        }else if(!$lng = $params['lng']) {
            $this->msgbox->add('纬度有误',217);
        }else if(!in_array($params['type'],array(0,1,2,3,4))) {
            $this->msgbox->add('地址类型错误',217);
        }else {
            $data = array();
            $data['uid'] = $this->uid;
            $data['contact'] = $contact;
            $data['mobile'] = $mobile;
            $data['house'] = $house;
            $data['addr'] = $addr;
            $data['lat'] = $lat;
            $data['lng'] = $lng;
            $data['type'] = $params['type'];

            if($addr_id = K::M('member/addr')->create($data)){
                if($params['is_default']){
                    K::M('member/addr')->set_default($this->uid, $addr_id);
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('addr_id'=>$addr_id));
            }
        }
    }
    /* 更新地址
     * $addr_id,必填
     * $contact,必填
     * $mobile,必填
     * $house,必填
     * $lng,必填
     * $lat,必填
     */
     
    public function update($params)
    {
        $this->check_login();
        if(!$addr_id = (int)$params['addr_id']){
            $this->msgbox->add('地址ID错误', 211);
        }else if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('修改的地址不存在', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法的数据请求', 213);
        }else if(!K::M('verify/check')->len(strlen($params['contact']),2,12)) {
            $this->msgbox->add('联系人必须是2到12位字符',214);
        }else if(!K::M('verify/check')->mobile($params['mobile'])) {
            $this->msgbox->add("手机号码有误",215);
        }else if(!$params['house']) {
            $this->msgbox->add("收货地址有误",216);
        }else if(!$params['lng']){
            $this->msgbox->add("经度有误",217);
        }else if(!$params['lat']) {
            $this->msgbox->add("纬度有误",218);
        }else if(!in_array($params['type'],array(0,1,2,3,4))) {
            $this->msgbox->add('地址类型错误',217);
        }else{
            if($data = $this->check_fields($params, 'contact,mobile,addr,house,is_default,type,lat,lng')){
                if(K::M('member/addr')->update($addr_id, $data)){
                    if($params['is_default']){
                        K::M('member/addr')->set_default($this->uid, $addr_id);
                    }
                    $this->msgbox->add('success');
                }
            }
        }
    }
    /* 地址详情
     * $addr_id,必填
     */
    public function detail($params)
    {
        $this->check_login();
        $addr_id = (int)$params['addr_id'];
        if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('地址不存在', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法的数据请求', 213);
        }else{
            $detail = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,type,lat,lng', $detail);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail));
        }
    }
    /* 删除地址
     * $addr_id,必填
     */
    public function delete($params)
    {
        $this->check_login();
        $addr_id = (int)$params['addr_id'];
        $detail = K::M('member/addr')->detail($addr_id);
        if(!$detail){
            $this->msgbox->add('地址不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法数据请求', 213);
        }else {
            if(K::M('member/addr')->delete($addr_id)){
                $this->msgbox->add('success');
            }else {
                $this->msgbox->add('删除失败',214);
            }
        }
    }
    /* 默认地址
     * $addr_id,必填
     */
    public function moren($params)
    {
        $this->check_login();
        if(!$detail=K::M('member/addr')->detail($params['addr_id'])){
            $this->msgbox->add('地址不存在或已经删除', 212);
        }elseif($detail['uid'] != $this->uid){
            $this->msgbox->add('非法数据请求', 213);
        }else{
            if(K::M('member/addr')->set_default($this->uid, $params['addr_id'])){
                $this->msgbox->add('success');
            }
            $this->msgbox->add('删除失败',214);
        }
    }
}
