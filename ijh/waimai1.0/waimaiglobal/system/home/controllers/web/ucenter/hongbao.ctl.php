<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Hongbao extends Ctl_Web_Ucenter {


    public function index($page=1)
    {
        $pager = $filter = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 12;
        $pager['count'] = $count = 0;
        $st = (int) $this->GP('st');
        $filter = array('uid'=>$this->uid);
        if($st == 2){
            $filter[':SQL'] = '(`order_id`>0 OR (`stime`>'.__TIME.' AND `ltime`<'.__TIME.'))';
        }else{
            $st = 1;
           $filter[':SQL'] = '(`order_id`=0 AND (`stime`<='.__TIME.' AND `ltime`>='.__TIME.'))';
        }
        if($items = K::M('hongbao/hongbao')->items($filter, array('hongbao_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['st'] = $st;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'web/ucenter/hongbao/items.html';
    }
    
    

    
    public function exchange()
    {
        if ($hongbao_sn = $this->GP('hongbao_sn')) {
            if(!$hongbao_sn){
                $this->msgbox->add(L('请输入红包兑换码'), 212);
            }elseif (!$detail = K::M('hongbao/hongbao')->find(array('hongbao_sn' => $hongbao_sn, 'order_id' => 0, 'ltime' => '>:' . time()))) {       
                $this->msgbox->add(L('红包不存在'), 212);
            } else if ($detail['uid'] != 0) {
                $this->msgbox->add(L('红包已经被使用'), 213);
            } else if (false !== K::M('hongbao/hongbao')->update($detail['hongbao_id'], array('uid' => $this->uid))) {
                K::M('message/message')->create(array('uid'=>$this->uid,'title'=>sprintf(L('恭喜你获得一个%s元红包'), $detail['amount']),'type'=>1,'content'=>sprintf(L('红包金额%s元,可用于支付时抵扣相应的金额'), $detail['amount']),'type'=>1));
                $this->msgbox->add(L('恭喜您兑换红包成功'));
            } else {
                $this->msgbox->add(L('兑换失败'), 214);
            }
        } 
    }

}
