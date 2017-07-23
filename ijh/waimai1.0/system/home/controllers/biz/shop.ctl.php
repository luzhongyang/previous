<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Shop extends Ctl_Biz
{
    

    public function index()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,info,addr,lat,lng,logo,phone,yy_status,yy_stime,yy_ltime,first_amount')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else{
                if($attach = $_FILES['shop_logo']){
                    if(UPLOAD_ERR_OK == $attach['error']){
                        if($a = K::M('magic/upload')->upload($attach, 'shop', $this->shop['logo'])){
                            $data['logo'] = K::M('content/html')->encode($a['photo']);
                        }
                    }
                }
   
                if($data['lat'] == '' || $data['lng'] == ''){
                    $this->msgbox->add(L('经纬度必须设置'), 212);
                }else if(K::M('shop/shop')->update($this->shop_id, $data)){
                    $this->msgbox->add(L('SUCCESS'));
                }
            }
        }else{
            $stime = mktime(0,0,0,date("m",time()),date("d",time()),date("Y",time()));
            $etime = mktime(23,59,59,date("m",time()),date("d",time()),date("Y",time()));
            $list = array();
            for($start = $stime; $start<=$etime; $start+=1800) {
               $times[] = date('H:i',$start);
            }
            $this->pagedata['times'] = $times;
            $this->tmpl = 'biz/shop/index.html';
        }
    }

    public function passwd()
    {
        if($data = $this->checksubmit('data')){
            $session =K::M('system/session')->start();
            if(!$data['passwd']){
                $this->msgbox->add(L('请填写当前密码'), 211);
            }else if(!$data['new_passwd']){
                $this->msgbox->add(L('请填写新密码'), 212);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add(L('请填写确认新密码'), 213);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add(L('新密码两次输入不一致'), 214);
            }else if(md5($data['passwd']) != $this->shop['passwd']){
                $this->msgbox->add(L('当前密码不正确'), 215);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add(L('新密码不能和当前密码相同'), 216);
            }else{
                $new_passwd = md5($data['new_passwd']);
                if(K::M('shop/shop')->update($this->shop_id,array('passwd'=>$new_passwd))){
                    $this->msgbox->add(L('SUCCESS'));
                }        
            }
        }else{
            $this->tmpl = 'biz/shop/passwd.html';
        }        
    }
    
    public function mobile()
    {
        $session = K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if($passwd = $data['passwd']){
                $this->msgbox->add(L('密码不能为空'), 211);
            }else if(md5($passwd) != $this->shop['passwd']){
                $this->msgbox->add(L('登录密码不正确'), 212);
            }else if(!$mobile = $data['mobile']){
                $this->msgbox->add(L('手机号不能为空'), 213);
            }else if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add(L('手机号不正确'), 214);
            }else if($mobile == $this->shop['mobile']){
                $this->msgbox->add(L('新手机号与当前手机号相同'), 215);
            }else if(!$sms_code = $data['code']){
                $this->msgbox->add(L('验证码不能为空'), 216);
            }else if($sms_code != $session->get('code_'.$mobile)){
                $this->msgbox->add(L('验证码不正确'), 217);
            }else if(K::M('shop/shop')->update_mobile($this->shop_id, $mobile)){
                $session->delete('code_'.$mobile);
                $this->msgbox->add(L('SUCCESS'));
            }
        }else{
            $this->pagedata['mobile'] = $this->shop['mobile'];
            $this->tmpl = 'biz/shop/mobile.html';
        }        
    }

    public function account()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'account_type,account_name,account_number')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else if($account_info = K::M('shop/account')->detail($this->shop_id)){
                K::M('shop/account')->update($this->shop_id, $data);
                $this->msgbox->add(L('修改提现帐号成功'));
            }else{
                $data['shop_id'] = $this->shop_id;
                K::M('shop/account')->create($data);
                $this->msgbox->add(L('添加提现帐号成功'));
            }
        }else{
            $this->pagedata['account_info'] = K::M('shop/account')->detail($this->shop_id);
            $this->pagedata['bank_list'] = K::M('data/data')->bank_list();
            $this->tmpl = 'biz/shop/account.html';
        }          
    }
    
    
    public function pei(){
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'min_amount,freight,pei_distance,pei_type,pei_amount')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }else{
                K::M('shop/shop')->update($this->shop_id,$data);
                $this->msgbox->add(L('SUCCESS'));
            }
        }else{
            $this->pagedata['detail'] = $this->shop;
            $this->tmpl = 'biz/shop/pei.html';
        }          
    }

    public function youhui()
    {
        if($data = $this->checksubmit('data')){
            $datas = array();
            foreach ($data['order_amount'] as $k=>$val){
                if(($a = (float)$val) && ($b = (float)$data['youhui_amount'][$k])){
                    $datas[$a] = $b;
                }
            }
            if(K::M('shop/youhui')->update_youhui($this->shop_id, $datas)){
               $this->msgbox->add(L('成功'));
            }  
        }else{
            $filter = array('shop_id'=>$this->shop_id);
            if($items = K::M('shop/youhui')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'biz/shop/youhui.html';
        }
    }
    
    public function yhdelete()
    {
        if($youhui_id = (int)$this->GP('youhui_id')){
            if(!$detail = K::M('shop/youhui')->detail($youhui_id)){
                $this->msgbox->add(L('你要删除的优惠不存在或已经删除'), 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }else{
                if(K::M('shop/youhui')->delete($youhui_id)){
                    K::M('shop/shop')->change_youhui($detail['shop_id']);
                    $this->msgbox->add(L('SUCCESS'));
                }
            }
        }else{
            $this->msgbox->add(L('未指定要删除的优惠ID'), 401);
        }
    }  

    
}