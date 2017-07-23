<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop extends Ctl
{
    

    public function index()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'cate_id,contact,phone,title,logo,banner,lng,lat,addr,thumb,city_id,area_id,business_id')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
               
                if(K::M('shop/shop')->update($this->shop_id, $data)){
                    //如果开通了外卖店铺同步主商户表中的坐标到外卖表中
                    $a = array();
                    if(isset($data['lat']) && isset($data['lng'])){
                        $a = array('lat'=>$data['lat'], 'lng'=>$data['lng']);
                    }
                    if(isset($data['addr'])){
                        $a['addr'] = $data['addr'];
                    }
                    if($a){
                        K::M('waimai/waimai')->update($this->shop_id, $a);
                    }
                    $this->msgbox->add('修改商铺资料成功');
                }
            }
        }else{
           
            $this->pagedata['citys'] = K::M('data/city')->items();
            $this->pagedata['areas'] = K::M('data/area')->items(array('city_id'=>$this->shop['city_id']));
            $this->pagedata['busis'] = K::M('data/business')->items(array('area_id'=>$this->shop['area_id']));
            $this->pagedata['cate_tree'] = K::M('shop/cate')->tree();            
            $this->tmpl = 'merchant:shop/index.html';
        }
    }

    //首页展示信息
    public function see()
    {
        $filter = $pager =  array();
        $filter['shop_id'] = $this->shop_id;

        $this->pagedata['shop_comment_count'] = K::M('shop/comment')->count(array('shop_id'=>$this->shop_id));
        $this->pagedata['waimai_comment_count'] = K::M('waimai/comment')->count(array('shop_id'=>$this->shop_id));
        $this->pagedata['shop_members_count'] = K::M('order/order')->shop_members_count($this->shop_id);
        $this->pagedata['shop_fans_count'] = K::M('member/collect')->count(array('shop_id'=>$this->shop_id,'can_id'=>$this->shop_id,'status'=>1));
        $cate = K::M('shop/cate')->detail($this->shop['cate_id']);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['shop'] = $this->shop;
        $this->tmpl = 'merchant:shop/coupon/see.html';
    }

    public function get_business($area_id)
    {
        if(!$area_id = intval($area_id)){
            $this->msgbox->add('未指定区县', 211);
        }else if(!$options = K::M('data/business')->options($area_id)){
            $options = array();
        }
        $this->msgbox->set_data('options', $options);
        $this->msgbox->json();
    }

    public function passwd()
    {
        if($data = $this->checksubmit('data')){
            $session =K::M('system/session')->start();
            if(!$data['passwd']){
                $this->msgbox->add('旧密码不能为空', 211);
            }else if(!$data['new_passwd']){
                $this->msgbox->add('新密码不能为空', 212);
            }else if(!$data['new_passwd2']){
                $this->msgbox->add('确认密码不能为空', 213);
            }else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add('两次新密码输入不一致', 214);
            }else if(md5($data['passwd']) != $this->shop['passwd']){
                $this->msgbox->add('旧密码不正确', 215);
            }else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add('新密码不能和旧密码一致', 216);
            }else{
                $new_passwd = md5($data['new_passwd']);
                if(K::M('shop/shop')->update($this->shop_id,array('passwd'=>$new_passwd))){
                    $this->msgbox->add('修改登录密码成功');
                }
            }
        }else{
            $this->tmpl = 'merchant:shop/passwd.html';
        }        
    }
    
    public function mobile()
    {
        $session = K::M('system/session')->start();
        if($data = $this->GP('data')){
            if(!$passwd = $data['passwd']){
                $this->msgbox->add('密码不能为空', 211);
            }else if(md5($passwd) != $this->shop['passwd']){
                $this->msgbox->add('登录密码不正确', 212);
            }else if(!$mobile = $data['mobile']){
                $this->msgbox->add('手机号不能为空', 213);
            }else if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add('手机号格式不正确', 214);
            }else if($mobile == $this->shop['mobile']){
                $this->msgbox->add('新手机号与旧手机号相同', 215);
            }else if(!$sms_code = $data['code']){
                $this->msgbox->add('验证码不能为空', 216);
            }else if($sms_code != $session->get('code_'.$mobile)){
                $this->msgbox->add('验证码不正确', 217);
            }else if(K::M('shop/shop')->update_mobile($this->shop_id, $mobile)){
                $session->delete('code_'.$mobile);
                $this->msgbox->add('修改手机成功');
            }
        }else{
            $this->pagedata['mobile'] = $this->shop['mobile'];
            $this->tmpl = 'merchant:shop/mobile.html';
        }
    }

    public function account()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'account_type,account_name,account_number')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if($account_info = K::M('shop/account')->detail($this->shop_id)){
                K::M('shop/account')->update($this->shop_id, $data);
                $this->msgbox->add('修改提现帐号成功');
            }else{
                $data['shop_id'] = $this->shop_id;
                K::M('shop/account')->create($data);
                $this->msgbox->add('添加提现帐号成功');
            }
        }else{
            $this->pagedata['account_info'] = K::M('shop/account')->detail($this->shop_id);
            $this->pagedata['bank_list'] = K::M('data/data')->bank_list();
            $this->tmpl = 'merchant:shop/account.html';
        }          
    }
    
    
    public function pei(){
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'min_amount,freight,pei_distance,pei_type,pei_amount')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                K::M('waimai/waimai')->update($this->shop_id,$data);
                $this->msgbox->add('配送设置成功');
            }
        }else{
            $this->pagedata['detail'] = K::M('waimai/waimai')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/pei.html';
        }          
    }

    public function youhui()
    {
        $this->wmyouhui();
    }

    public function wmyouhui() 
    {
        if($data = $this->checksubmit()){
            if(!$data = $this->check_fields($data, 'youhui_id,order_amount,youhui_amount,orderby')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                $data1 = $data2 = $datas1 = $datas2 = array();
                if($data1 = $this->checksubmit('data1')) {
                    foreach($data1['youhui_id'] as $k=>$v) {
                        foreach($data1['order_amount'] as $k2=>$v2) {
                            if($k == $k2) {
                                $datas1[$v]['order_amount'] = $v2;
                            }  
                        }
                        foreach($data1['youhui_amount'] as $k3=>$v3) {
                            if($k == $k3) {
                                $datas1[$v]['youhui_amount'] = $v3;
                            }
                        }
                        foreach($data1['orderby'] as $k4=>$v4) {
                            if($k == $k4) {
                                $datas1[$v]['orderby'] = $v4;
                            } 
                        }    
                    }  
                    foreach($datas1 as $kk=>$vv) {
                        K::M('waimai/youhui')->update($kk,$vv);
                        $waimai_youhui[] = (int)$vv['order_amount'].':'.(int)$vv['youhui_amount'];
                    } 
                    $waimai_youhui = implode(',', $waimai_youhui);
                      
                }
                if($data2 = $this->checksubmit('data2')) {
                    foreach($data2['order_amount'] as $k=>$v) {
                        $datas2['order_amount'] = $v;
                        foreach($data2['youhui_amount'] as $k2=>$v2) {
                            if($k == $k2) {
                                $datas2['youhui_amount'] = $v2;
                            }
                        }
                        foreach($data2['orderby'] as $k3=>$v3) {
                            if($k == $k3) {
                                $datas2['orderby'] = $v3;
                            }
                        }
                        $datas2['shop_id'] = $this->shop_id;
                        K::M('waimai/youhui')->create($datas2);
                        $waimai_youhui2[] = (int)$datas2['order_amount'].':'.(int)$datas2['youhui_amount'];
                    }  

                    $waimai_youhui2 = implode(',', $waimai_youhui2);
                }
                K::M('waimai/waimai')->update($this->shop_id, array('youhui'=>$waimai_youhui . ',' .$waimai_youhui2));        
                $this->msgbox->add('外卖优惠设置成功'); 
            }
        }else{
            $filter = array('shop_id'=>$this->shop_id);
            if($items = K::M('waimai/youhui')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'merchant:shop/wmyouhui.html';
        }
    }

    public function mdyouhui() 
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'status,type,each_amount,each_youhui,discount,max_youhui')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if(K::M('maidan/maidan')->count(array('shop_id'=>$this->shop_id)) > 0) {
                    
                    K::M('maidan/maidan')->update($this->shop_id,$data);
                }else {
                    $data['shop_id'] = $this->shop_id;
                    K::M('maidan/maidan')->create($data);
                }
                $this->msgbox->add('买单优惠设置成功');
            }
        }else{
            $this->pagedata['tshop'] = K::M('maidan/maidan')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/mdyouhui.html';
        }
    }
    
    public function yhdelete()
    {
        if($youhui_id = (int)$this->GP('youhui_id')){
            if(!$detail = K::M('waimai/youhui')->detail($youhui_id)){
                $this->msgbox->add('你要删除的优惠不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/youhui')->delete($youhui_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的优惠ID', 401);
        }
    }  
    
    public function have()
    {
        $this->waimai();  
    }

    public function waimai()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'have_waimai,tmpl_type')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if(K::M('shop/shop')->update($this->shop_id, array('have_waimai'=>$data['have_waimai']))){
                   K::M('waimai/waimai')->update($this->shop_id, array('tmpl_type'=>$data['tmpl_type']));
                   $this->msgbox->add('提交成功等待管理员审核！');
                   $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/waimai'));
                } 
            }
        }else{
            $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
            $this->pagedata['waimai'] = K::M('waimai/waimai')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/waimai.html';
        }    
    }

    public function printcfg(){
       if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'have_waimai,tmpl_type')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if(K::M('shop/shop')->update($this->shop_id, array('have_waimai'=>$data['have_waimai']))){
                   K::M('waimai/waimai')->update($this->shop_id, array('tmpl_type'=>$data['tmpl_type']));
                   $this->msgbox->add('提交成功等待管理员审核！');
                   $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/waimai'));
                } 
            }
        }else{
            $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
            $this->pagedata['waimai'] = K::M('waimai/waimai')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/printcfg.html';
        }    
    }
    
    
    
    
}