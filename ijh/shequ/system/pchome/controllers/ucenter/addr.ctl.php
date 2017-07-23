<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Addr extends Ctl_Ucenter
{

    /**
     * 用户中心地址
     */
    public function index()
    {
        $addr = K::M('member/addr')->items(array('uid' => $this->uid));
        $this->pagedata['addr'] = $addr;
        $this->tmpl = 'pchome/ucenter/addr/index.html';
    }

    /**
     * 创建用户地址
     */
    public function create()
    {
        $addr_backurl = $this->cookie->get('addr_backurl');
        if($data = $this->checksubmit('data')){
            if($addr_backurl){
                $forward = $addr_backurl;
            }else{
                $forward = $this->mklink('ucenter/addr', null, null, 'base');
            }
            if(!$data['contact'] = K::M('member/addr')->check_contact($data['contact'])){
                $this->msgbox->add('联系人长度为2至16位字符', 210);
            }else if(!$data['mobile'] = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号码有误', 211);
            }else if(!$data['house'] = strip_tags($data['house'])){
                $this->msgbox->add('地址不正确', 212);
            }else if(!$data['addr'] = strip_tags($data['addr'])){
                $this->msgbox->add('详细地址不正确', 213);
            }else if(!$data['lng'] || !$data['lat']){
                $this->msgbox->add('经纬度有误', 213);
            }else if($addr_count = K::M('member/addr')->count(array('uid' => $this->uid)) >= 10){
                $this->msgbox->add('抱歉，每个用户最多只能新增10个地址！', 214);
                $this->cookie->delete('addr_backurl');
                $this->msgbox->set_data('forward', $forward);
            }else{
                $data['uid'] = $this->uid;
                if(!$data['type']){
                    $data['type'] = 0;
                }
                if($addr_id = K::M('member/addr')->create($data)){
                    $this->msgbox->add('新增地址成功');
                    $this->cookie->delete('addr_backurl');
                    $this->msgbox->set_data('forward', $forward);
                }else{
                    $this->msgbox->add('新增地址失败', 215);
                }
            }
        }else{
            $this->tmpl = 'pchome/ucenter/addr/create.html';
        }
    }

    /**
     * 编辑用户地址
     */
    public function edit($addr_id,$url)
    {
        $addr_backurl = $this->cookie->get('addr_backurl');
        if(!$addr_id){
            $this->msgbox->add('非法操作',210);
        }else if(!$deatil=K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('非法操作',211);
        }else if($deatil['uid'] != $this->uid){
            $this->msgbox->add('非法操作',212);
        }else if($data = $this->checksubmit('data')){
            
            if(!$data['contact'] = K::M('member/addr')->check_contact($data['contact'])){
                $this->msgbox->add('联系人长度为2至16位字符',213);
            }else if(!$data['mobile'] = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('手机号码有误',214);
            }else if(!$data['house'] = strip_tags($data['house'])){
                $this->msgbox->add('地址不正确', 215);
            }else if(!$data['addr'] = strip_tags($data['addr'])){
                $this->msgbox->add('详细地址不正确', 216);
            }else if(!$data['lng'] || !$data['lat']){
                $this->msgbox->add('经纬度有误', 217);
            }else{
                if($addr_id = K::M('member/addr')->update($addr_id, $data)){
                    $this->msgbox->add('编辑地址成功');
                    $this->cookie->delete('addr_backurl');
                    if($addr_backurl){
                        $forward = $addr_backurl;
                    }else{
                        $forward = $this->mklink('ucenter/addr', null, null, 'base');
                    }
                    $this->msgbox->set_data('forward', $forward);
                }else {
                    $this->msgbox->add('编辑地址失败',300);
                }
            }
        }else{
            $this->pagedata['detail'] = $deatil;
            $this->tmpl = 'pchome/ucenter/addr/edit.html';
        }
    }
    
    /**
     * 删除用户地址
     */
    public function delete($addr_id)
    {
        if(!$detail = K::M('member/addr')->detail($addr_id)) {
           $this->msgbox->add("你要修改的地址不存在或已经删除".$addr_id,210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add("非法的数据请求",211);
        }else {
            if(K::M('member/addr')->delete($addr_id)){
                $this->msgbox->add('删除成功');
            }else {
                $this->msgbox->add('删除失败',212);
            }
        }
    }

}
