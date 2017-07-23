<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Wuye_Tixian_Index extends Ctl_Wuye
{
    
    /**
     * 提现记录
     */
    public function index()
    {
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['wuye_id'] = $this->wuye_id;
        if($items = K::M('xiaoqu/wuye/tixian')->items($filter, array('tixian_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/tixian/index.html';
    }
    
    
    /**
     * 绑定银行
     */
    public function bind_bank(){
        $this->check_wuye_bind_xiaoqu();
        if($data = $this->checksubmit('data')){
            $data['name'] = strip_tags($data['name']);
            $data['account'] = strip_tags($data['account']);
            if($data['is_default'] == 1){
                if($items = K::M('xiaoqu/wuye/account')->items(array('wuye_id'=>$this->wuye_id))){
                    $account_ids = array();
                    foreach($items as $k => $v){
                        $account_ids[$v['account_id']] = $v['account_id'];
                    }
                }
                K::M('xiaoqu/wuye/account')->update($account_ids,array('is_default'=>0)); //遍历出ID组批量修改
            }
            if($account_id = K::M('xiaoqu/wuye/account')->create($data)){
                $this->msgbox->add('绑定成功!');
                $this->msgbox->set_data('forward',  $this->mklink('wuye/tixian/index:index'));
            } 
        }else{
            $bank_list = K::M('xiaoqu/wuye/account')->bank_list();
            $mybank = K::M('xiaoqu/wuye/account')->items(array('wuye_id'=>$this->wuye_id));
            $this->pagedata['mybank'] = $mybank;
            $this->pagedata['bank_list'] = $bank_list;
            $this->tmpl = 'wuye/tixian/bind_bank.html';
        }   
    }
    
    
    /**
     * 申请提现
     */
    public function reg(){
        $this->check_wuye_bind_xiaoqu();
        if($data = $this->checksubmit('data')){
            if(!(int)$data['money']){
                $this->msgbox->add('提现金额错误!');
            }else if($data['money'] > $this->wuye['money']){
                $this->msgbox->add('抱歉，余额不足以提现!');
            }else if($tixian_id = K::M('xiaoqu/wuye/tixian')->create($data)){
                //扣除金额
                K::M('xiaoqu/wuye')->update_count($this->wuye_id,'money',-$data['money']);
                //写入余额日志
                K::M('xiaoqu/wuye/log')->create(array('wuye_id'=>$this->wuye_id,'money'=>(-$data['money']),'clientip'=>__IP,'intro'=>'提现成功'));
                $this->msgbox->add('提现成功!');
                $this->msgbox->set_data('forward',  $this->mklink('wuye/tixian/index:index'));
            } 
        }else{
            $items = K::M('xiaoqu/wuye/account')->items(array('wuye_id'=>$this->wuye_id));
            $this->pagedata['items'] = $items;
            $this->tmpl = 'wuye/tixian/reg.html';
        }
    }
    
    /**
     * 余额日志
     */
    public function money_log(){
        $this->check_wuye_bind_xiaoqu();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['wuye_id'] = $this->wuye_id;
        if($items = K::M('xiaoqu/wuye/log')->items($filter, array('log_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'wuye/tixian/money_log.html';
    }
    
    
    /**
     * 修改银行
     */
    public function edit($account_id){
        $this->check_wuye_bind_xiaoqu();
        if(!$detail = K::M('xiaoqu/wuye/account')->detail($account_id)){
            $this->msgbox->add('不存在的银行',211);
        }else if($data = $this->checksubmit('data')){
            $data['is_default'] = 1;
            if(K::M('xiaoqu/wuye/account')->update($account_id, $data)){
                $this->msgbox->add('修改成功');
            }
        }else{
            $bank_list = K::M('xiaoqu/wuye/account')->bank_list();
            $this->pagedata['bank_list'] = $bank_list;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'wuye/tixian/edit.html';
        }
    }
    
}
