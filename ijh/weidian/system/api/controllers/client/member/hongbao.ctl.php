<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_Hongbao extends Ctl
{
    /* 红包列表
     * $page,必填
     */
    public function index($params)
    {
        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        if($items = K::M('hongbao/hongbao')->items($filter, null, $page, 20)){
            $time = time();
            foreach($items as $key=>$item){
                if(empty($item['used_time'])){
                    //考虑$item['stime']<=$time和$time<$item['stime']
                    if($time<=$item['ltime']){
                        $items[$key]['status'] = 1;//未使用
                    }else if($time>$item['ltime']){
                        $items[$key]['status'] = 2;//已过期
                    }
                }else{
                    $items[$key]['status'] = 3;//已使用
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }
    /* 红包兑换
     * $sn,必填
     */
    public function exchange($params)
    {
        $this->check_login();
        if(!$sn = $params['sn']){
            $this->msgbox->add('兑换码不能为空',202);
        }else if(!$result = K::M('hongbao/hongbao')->find(array('hongbao_sn'=>$sn,'ltime'=>'>:'.time()))){
            $this->msgbox->add('兑换码不存在或红包已过期',203);
        }else if($result['uid']>0){
            $this->msgbox->add('该兑换码已被兑换',204);
        }else if($result['order_id']>0){
            $this->msgbox->add('该兑换码已使用过',205);
        }else{
            if(K::M('hongbao/hongbao')->update($result['hongbao_id'],array('uid'=>$this->uid))){
                $this->msgbox->add('success');
            }
        }
    }
    //红包规则,返回网址
    public function rule()
    {
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',$this->mklink('page',array('hongbao')));
    }
}
