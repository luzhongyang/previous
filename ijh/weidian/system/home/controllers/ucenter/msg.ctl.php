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
               $msglist[$k]['url'] = $this->mklink('ucenter/order:detail', array('args'=>$val['order_id']));
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
            $this->msgbox->add("你要设置的消息不存在或已经删除",210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add("非法的数据请求",212);
        }else {
            if($detail['is_read'] == 0) {
                $data['is_read'] = 1;
                if(K::M('member/message')->update($data['message_id'],$data)) {
                    $this->msgbox->add('success');
                }else {
                    $this->msgbox->add('error',213);
                }
            }
        }
    }
}
