<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Hongbao extends Ctl_Ucenter {


    public function index($page = 1) 
    {
        $this->tmpl = 'ucenter/hongbao/index.html';
    }
    
    
    public function lists()
    {
        $money= $this->GP('money');
        $filter = $pager = array();
        $filter['uid'] = $this->uid;
        $filter['order_id'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        $filter['min_amount'] = '<=:' .$money;
        $items = K::M('hongbao/hongbao')->items($filter, array('amount'=>'desc'));
        $this->pagedata['items'] = $items;
        $this->tmpl = 'ucenter/hongbao/lists.html';
    }

    public function hongbao_list()
    {
        
        $filter = $pager = array();
        $page = max((int) $this->GP('page'), 1);
        $pager['limit'] = $limit = 10;
        $filter['uid'] = $this->uid;
        $filter['order_id'] = 0;
        $filter['ltime'] = '>:' . __TIME;
        if (!$items = K::M('hongbao/hongbao')->items($filter, null, $page, $limit, $count)) {
            $items= array();
        }else{
            foreach($items as $k => $v){
                $items[$k]['dateline'] = date('Y-m-d',$v['dateline']);
            }
        }
        $this->pagedata['items'] = $items;
        $this->msgbox->set_data('data', array('items' => array_values($items)));
    }

    public function exchange()
    {
        if ($hongbao_sn = $this->GP('hongbao_sn')) {
            $detail = K::M('hongbao/hongbao')->find(array('hongbao_sn' => $hongbao_sn, 'order_id' => 0, 'ltime' => '>:' . time()));
            if (empty($detail)) {                
                $this->msgbox->add('红包不存在', 212);
            } else if ($detail['uid'] != 0) {
                $this->msgbox->add('已经被兑换了', 213);
            } else if (false !== K::M('hongbao/hongbao')->update($detail['hongbao_id'], array('uid' => $this->uid))) {
                K::M('message/message')->create(array('uid'=>$this->uid,'title'=>'恭喜你获得一个'.$detail['amount'].'元红包','type'=>1,'content'=>'红包金额'.$detail['amount'].'元,可用于支付时抵扣相应的金额','type'=>1));
                $this->msgbox->add('兑换成功');
            } else {
                $this->msgbox->add('兑换失败', 214);
            }
        } else {
            $this->tmpl = 'ucenter/hongbao/exchange.html';
        }
    }

}
