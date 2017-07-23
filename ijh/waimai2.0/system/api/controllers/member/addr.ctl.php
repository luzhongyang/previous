<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member_Addr extends Ctl
{

    // 会员收货地址列表
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
                $items[$k] = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,lat,lng,tag', $val);
            }
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    // 会员添加地址
    public function create($params)
    {
        $this->check_login();
        if(!$contact = $params['contact']) {
            $this->msgbox->add(L('联系人填写有误'),212);
        }else if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
            $this->msgbox->add(L('手机号不正确'),213);
        }else if(!$house = $params['house']) {
            $this->msgbox->add(L('收货地址有误'),214);
        }else if(!$addr = $params['addr']) {
            $this->msgbox->add(L('详细收货地址有误'),215);
        }else if(!$lat = $params['lat']) {
            $this->msgbox->add(L('经度有误'),216);
        }else if(!$lng = $params['lng']) {
            $this->msgbox->add(L('纬度有误'),217);
        }else {
            $data = array();
            $data['uid'] = $this->uid;
            $data['contact'] = $contact;
            $data['mobile'] = $mobile;
            $data['house'] = $house;
            $data['addr'] = $addr;
            $data['lat'] = $lat;
            $data['lng'] = $lng;
            $data['tag'] = $params['tag'];
            if($addr_id = K::M('member/addr')->create($data)){
                if($params['is_default']){
                    K::M('member/addr')->set_default($this->uid, $addr_id);
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('addr_id'=>$addr_id));
            }
        }
    }


    public function edit($params)
    {
        $this->update($params);
    }

    // 会员修改地址$
    public function update($params)
    {
        $this->check_login();
        if(!$addr_id = (int)$params['addr_id']){
            $this->msgbox->add(L('地址不存在'), 211);
        }else if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add(L('地址不存在'), 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else if(!K::M('verify/check')->len(strlen($params['contact']), 6, 18)) {
            $this->msgbox->add(L('联系人必须是6到18位字符'),214);
        }else if(!K::M('verify/check')->mobile($params['mobile'])) {
            $this->msgbox->add(L('手机号不正确'),215);
        }else if(!$params['house']) {
            $this->msgbox->add(L('收货地址有误'),216);
        }else if(!$params['lng']){
            $this->msgbox->add(L('经度有误'),217);
        }else if(!$params['lat']) {
            $this->msgbox->add(L('纬度有误'),218);
        }else{
            if($data = $this->check_fields($params, 'contact,mobile,addr,house,is_default,lat,lng,tag')){
                if(K::M('member/addr')->update($addr_id, $data)){
                    if($params['is_default']){
                        K::M('member/addr')->set_default($this->uid, $addr_id);
                    }
                    $this->msgbox->add('success');
                }
            }
        }
    }

    // 会员收货地址详情
    public function detail($params)
    {
        $this->check_login();
        $addr_id = (int)$params['addr_id'];
        if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add(L('地址不存在'), 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            $detail = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,lat,lng', $detail);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail));
        }
    }


    public function delete($params)
    {
        $this->check_login();
        $addr_id = (int)$params['addr_id'];
        $detail = K::M('member/addr')->detail($addr_id);
        if(!$detail){
            $this->msgbox->add(L('地址不存在或已被删除'), 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }else {
            if(K::M('member/addr')->delete($addr_id)){
                $this->msgbox->add('success');
            }else {
                $this->msgbox->add(L('删除失败'),214);
            }
        }
    }
}
