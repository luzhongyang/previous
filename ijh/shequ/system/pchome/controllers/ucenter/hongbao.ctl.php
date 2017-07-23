<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Hongbao extends Ctl_Ucenter
{
    /**
     * 我的红包
     */
    public function index($page=1,$type=1){
        $type = (int)$type;
        $filter = $pager = $items = $orderby = array();
        if($type == 1){
            $filter['used_time'] = 0;
            $filter['ltime'] = '>:'.time();
        }else if($type == 2){
            $filter['used_time'] = '>:0';
        }else if($type == 3){
            $filter['ltime'] = '<:'.time();
        }

        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $orderby['dateline'] = 'asc';
        $filter['uid'] = $this->uid;
        $items = K::M("hongbao/hongbao")->items($filter, $orderby, $page, $limit, $count);
        $pager['count'] = $count;
        $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/hongbao/index',array('{page}',$type),null,'base'));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->pagedata['type'] = $type;
        $this->tmpl = 'pchome/ucenter/hongbao/index.html';

    }
    
    //兑换红包
    public function exchange()
    {
        if ($hongbao_sn = $this->GP('sn')) {
            $detail = K::M('hongbao/hongbao')->find(array('hongbao_sn' => $hongbao_sn, 'order_id' => 0, 'ltime' => '>:' . time()));
            if (empty($detail)) {
                $this->msgbox->add('红包不存在',212);
            } else if ($detail['uid'] != 0) {
                $this->msgbox->add('已经被兑换了',213);
            } else if (false !== K::M('hongbao/hongbao')->update($detail['hongbao_id'], array('uid' => $this->uid))) {
                K::M('message/message')->create(array('uid'=>$this->uid,'title'=>'恭喜你获得一个'.$detail['amount'].'元红包','type'=>1,'content'=>'红包金额'.$detail['amount'].'元,可用于支付时抵扣相应的金额','type'=>1));
                $this->msgbox->add('兑换成功');
            } else {
                $this->msgbox->add('兑换失败',214);
            }
        }else{
            $this->msgbox->add('错误',215);
        }
    }

}