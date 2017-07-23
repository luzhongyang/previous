<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Bank extends Ctl_Ucenter_Shop
{

    /**
     * 身份认证、绑定银行卡
     */
    public function index()
    {
        $account = K::M('fenxiao/account')->find(array('uid'=>$this->uid));
        if($data = $this->checksubmit('data')){
            $data['uid'] = $this->uid;
            if($account){
                $this->msgbox->add('您已经绑定过了!',210);
            }else if(!$data['real_name'] = strip_tags($data['real_name'])){
                $this->msgbox->add('没有填写真实姓名!',211);
            }else if(!$data['card_no'] = strip_tags($data['card_no'])){
                $this->msgbox->add('没有填写身份证号码!',212);
            }else if(!$data['account_type'] = strip_tags($data['account_type'])){
                $this->msgbox->add('没有填写开户银行!',213);
            }else if(!$data['account_number'] = strip_tags($data['account_number'])){
                $this->msgbox->add('没有填写开户银行帐号!',214);
            }else if($account_id = K::M('fenxiao/account')->create($data)){
                $this->msgbox->add('绑定成功!');
            }else{
                $this->msgbox->add('绑定失败!',215);
            }
        }else{
            if($account){
                $this->pagedata['account'] = $account;
                $this->tmpl = "fenxiao/ucenter/shop/bank/success.html";
            }else{
                $bank_list = K::M('fenxiao/account')->bank_items();
                $this->pagedata['bank_list'] = $bank_list;
                $this->tmpl = "fenxiao/ucenter/shop/bank/index.html"; 
            }
        }
    }
    
    /**
     * 我的银行卡
     */
    public function my_bank(){
        $account = K::M('fenxiao/account')->find(array('uid'=>$this->uid));
        if(!$account){
            $this->msgbox->add('您还没有添加银行卡!',212)->response();
            $this->err->set_data('forward', 'ucenter/shop/bank/index/');
        }
        $m1 = substr($account['account_number'],0,3);
        $m2 = substr($account['account_number'],-4);
        $m3 = substr($account['account_number'],4,-4);
        
        $_str = "";
        for($i=1;$i<=strlen($m3);$i++){
            $_str .= "*";
        }
        $account['account_number'] = $m1.$_str.$m2;
        $this->pagedata['account'] = $account;
        $this->tmpl = "fenxiao/ucenter/shop/bank/my.html"; 
    }
    
    /**
     * 更换银行卡
     */
    public function change_bank(){
        $account = K::M('fenxiao/account')->find(array('uid'=>$this->uid));
        if(!$account){
            $this->msgbox->add('您还没有添加银行卡!',212)->response();
            $this->err->set_data('forward', 'ucenter/shop/bank/index/');
        }
        $this->pagedata['account'] = $account;
        $bank_list = K::M('fenxiao/account')->bank_items();
        $this->pagedata['bank_list'] = $bank_list;
        if($data = $this->checksubmit('data')){
            if(!$data['account_type'] = strip_tags($data['account_type'])){
                $this->msgbox->add('银行没有选择!',211);
            }else if(!$data['account_number'] = strip_tags($data['account_number'])){
                $this->msgbox->add('卡号没有填写!',212);
            }else if(!$data['account_number2'] = strip_tags($data['account_number2'])){
                $this->msgbox->add('确认卡号没有填写!',213);
            }else if($data['account_number'] != $data['account_number2']){
                $this->msgbox->add('两次卡号输入不一致!',214);
            }else if($up = K::M('fenxiao/account')->update($account['id'],$data)){
                $this->msgbox->add('更换成功!');
            }else{
                $this->msgbox->add('更换失败!',215);
            }
        }else{
            $this->tmpl = "fenxiao/ucenter/shop/bank/change.html"; 
        }
    }
    
    
    /**
     * 申请提现
     */
    public function reg_money(){
        if(!$account = K::M('fenxiao/account')->find(array('uid'=>$this->uid))){
            $this->msgbox->add('请先完善提现帐号信息!',219);
            $url = $this->mklink('ucenter/shop/bank/index',null,null,'base');
            header("Location:".$url);
        }else{
            $this->pagedata['account'] = $account;
            if($data = $this->checksubmit('data')){
                if(!$data['money'] = (float)$data['money']){
                    $this->msgbox->add('没有填写提现金额!',211);
                }elseif($data['money'] <1){
                    $this->msgbox->add('提现金额不足1元!',211);
                }else if($data['money'] > $this->FENXIAO['money']){
                    $this->msgbox->add('余额不足!',212);
                }else if(!$data['account_info'] = strip_tags($data['account_info'])){
                    $this->msgbox->add('没有提现帐号信息!',212);
                }else{
                    $data['sid'] = $this->FENXIAO['sid'];
                    $data['intro'] = "《".$this->FENXIAO['title']."》申请提现".$data['money']."元";
                    if(K::M('fenxiao/fenxiao')->update_money($data['sid'],-$data['money'],$data['intro'])){
                        if($tixian = K::M('fenxiao/tixian')->create($data,true)){
                            $this->msgbox->add('提现成功!');
                        }else{
                            $this->msgbox->add('提现失败!',212);
                        }
                    }
                }
            }else{
                $this->tmpl = "fenxiao/ucenter/shop/bank/reg_money.html"; 
            }
        }
    }
    
    /**
     * 提现记录
     */
    public function reg_log(){
        $now = __TIME;
        $month = __TIME - 86400*30;
        $tixian_log = K::M('fenxiao/tixian')->items(array('sid'=>$this->FENXIAO['sid']),array('dateline'=>'>:'.$month));
        $total_money = 0;
        foreach($tixian_log as $k => $v){
            $total_money += $v['money'];
        }
        $this->pagedata['total_money'] = $total_money;
        $this->pagedata['tixian_log'] = $tixian_log;
        $this->tmpl = "fenxiao/ucenter/shop/bank/reg_log.html";
        
    }

}
