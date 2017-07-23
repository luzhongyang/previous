<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*消息中心*/
class Ctl_Ucenter_Msg extends Ctl_Ucenter
{
	public function index() 
	{
        if(!$msg = K::M('member/message')->count(array('uid'=>$this->uid))) {
            $msg = 0;
        }
        $this->pagedata['msgnums'] = $msg;
        $filter = $items = $msglist = array();
        $filter['uid'] = $this->uid;
        $page = max((int) $this->GP('page'), 1);
        $limit = 10;
        $msglist = K::M('member/message')->items($filter, array('message_id'=>'desc'), $page, $limit, $count);
        foreach($msglist as $k=>$val) {
            $msglist[$k]['time'] = date("Y-m-d", $val['dateline']);
            if($val['type']==1) { //红包消息
                $msglist[$k]['url'] = $this->mklink('ucenter/hongbao:index');
                if($val['is_read']==0){
                    $msglist[$k]['ico'] = 2;
                }else{
                    $msglist[$k]['ico'] = 4;
                }
            }else if($val['type']==2) { // 订单消息
                if($val['order_id']) {
                    $order = K::M('order/order')->detail($val['order_id']);
                    if($order['from'] == 'waimai'){
                        $msglist[$k]['url'] = $this->mklink('waimai/order:detail', array('args'=>$val['order_id']));
                    }
                    else if($order['from'] == 'pintuan'){
                        $msglist[$k]['url'] = $this->mklink('pintuan/tuan_order_detail', array('args'=>$val['order_id']));
                    }
                    else if($order['from'] == 'mall'){
                        $msglist[$k]['url'] = $this->mklink('mall/order:detail', array('args'=>$val['order_id']));
                    }
                    else if($order['from'] == 'paotui'){
                        $msglist[$k]['url'] = $this->mklink('paotui:detail', array('args'=>$val['order_id']));
                    }
                }
            
                if($val['is_read']==0){
                    $msglist[$k]['ico'] = 1;
                }else{
                    $msglist[$k]['ico'] = 3;
                }
            }
        }
        foreach($msglist as $val){
            $items[] = $val;
        }
        $this->pagedata['items'] = $items;
		$this->tmpl = "ucenter/msg/index.html";
	}

	public function msglist()
    {
    	$filter = $items = $msglist = array();
    	$filter['uid'] = $this->uid;
        $page = max((int) $this->GP('page'), 1);
        $limit = 10;
        $msglist = K::M('member/message')->items($filter, array('message_id'=>'desc'), $page, $limit, $count);
    	foreach($msglist as $k=>$val) {       
           $msglist[$k]['time'] = date("Y-m-d", $val['dateline']);
           if($val['type']==1) { //红包消息
               $msglist[$k]['url'] = $this->mklink('ucenter/hongbao:index');
           }else if($val['type']==2) { // 订单消息
               $msglist[$k]['url'] = $this->mklink('order:detail', array('args'=>$val['order_id']));
           }
        }
        foreach($msglist as $val){
            $items[] = $val;
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => $items));
    }

    public function getmsgs() {
        $filter = array();
        $filter['uid'] = $this->uid;
        $filter['is_read'] = 0;
        $counts = K::M('member/message')->count($filter);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('rows'=>$counts));
    }

    public function setread() {
        $data = array();
        $data['message_id'] = intval($this->GP('message_id'));
        if(!$detail = K::M('member/message')->detail($data['message_id'])) {
            $this->msgbox->add(L('消息不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),212);
        }else {
            if($detail['is_read'] == 0) {
                $data['is_read'] = 1;
                if(K::M('member/message')->update($data['message_id'],$data)) {
                    $this->msgbox->add(L('操作成功'));
                }else {
                    $this->msgbox->add(L('FAIL'),213);
                }
            }      
        }   
    }
}