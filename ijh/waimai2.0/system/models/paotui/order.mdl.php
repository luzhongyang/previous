<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Paotui_Order extends Mdl_Table
{

    protected $_table = 'paotui_order';

    protected $_pk = 'order_id';

    protected $_cols = 'order_id,type,o_addr,o_house,o_contact,o_mobile,o_lng,o_lat,photo,voice,paotui_amount,reward_amount,voice_time';

    protected $_orderby = array('order_id' => 'DESC');

    public function create($data)
    {
        if(!$data = $this->_check($data)){
            return false;
        }

        if($this->db->insert($this->_table, $data)){
            return true;
        }
        else{
            return false;
        }
    }

    public function detail($pk, $closed=false)
    {
        if(!$pk = (int)$pk){
            return false;
        }
        $this->_checkpk();
        $where ="o.order_id=ext.order_id AND o.order_id=".$pk;
        if(empty($closed)){
            $where .= " AND o.closed='0'";
        }
        $sql = "SELECT o.*, ext.* FROM " .$this->table('order')." o, ".$this->table($this->_table)." ext WHERE $where";
        if($detail = $this->db->GetRow($sql)){
            $detail = K::M('order/order')->order_format_row($detail);
        }
        return $detail;
    }
    
    
    public function set_price($order_id, $price, $from='staff')
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        if(($price = (float)$price) <=0){
            return false;
        }
        if(K::M('order/order')->update($order_id, array('order_status'=>5, 'pay_status'=>0, 'total_price'=>$price))){
            $this->update($order_id, array('jiesuan_amount'=>$price));
            $log = array('order_id'=>$order_id, 'status'=>5, 'log'=>sprintf('骑手设置了订单价格:￥%s', $price), 'from'=>$from);
            K::M('order/log')->create($log);
            return true;            
        }
        return false;
    }
    
    protected function _format_row($row)
    {
        if($row['order_status'] < 0){
            $label = L('已取消');
        }
        else if($row['order_status'] == 0 && $row['staff_id'] == 0 && $row['pay_status'] == 1){
            $label = L('待接单');
        }
        else if(in_array($row['order_status'], array(1, 2))){
            $label = L('已接单');
        }
        else if($row['type'] == 'song' && $row['order_status'] == 3){
            $label = L('已取件');
        }
        else if($row['type'] == 'buy' && $row['order_status'] == 3){
            $label = L('已购买');
        }
        else if($row['order_status'] == 4){
            $label = L('等待确认');
        }
        else if($row['type'] == 'buy' && $row['order_status'] == 5){
            $label = L('需付差价');
        }
        else if($row['order_status'] == 8){
            $label = L('已经完成');
        }
        $row['order_status_label'] = $label;

        if($row['photo']){ //如果图片字段结尾多一个','，处理掉并返回为数组
            $str = substr($row['photo'], -1);
            if($str == ','){
                $newstr = substr($row['photo'], 0, strlen($row['photo']) - 1);
            }
            $row['photo'] = explode(',', $newstr);
        }

        if($row['order_status'] == 0 && $row['pay_status'] == 0){
            if(($row['dateline'] - time()) < 1800){
                $row['pay_label'] = L('订单逾期未支付半小时自动取消');
            }
            else{
                $row['pay_label'] = array();
            }
        }
        return $row;
    }

    public function update($pk, $data, $checked = false)
    {
        $this->_checkpk();
        if(!$checked && !($data = $this->_check($data, $pk))){
            return false;
        }
        if($ret = $this->db->update($this->_table, $data, $this->field($this->_pk, $pk))){
            $this->flush();
        }
        return $ret;
    }

    public function set_payed($paotui_id, $trade = array())
    {
        if(!$paotui = $this->detail($paotui_id)){
            return false;
        }
        else{
            if($res = $this->db->update($this->_table, array('pay_status' => 1), "paotui_id='{$paotui_id}'", true)){
                $a = array('online_pay' => 1, 'pay_ip' => __IP, 'pay_time' => __TIME, 'pay_code' => $trade['code']);
                $logstr = L('订单支付成功');
                if($paotui['type'] == 'buy' && $paotui['jiesuan_amount'] > 0 && $paotui['order_status'] == 5){ //二次付款时自动设置订单为完成状态
                    $a['order_status'] = 8;
                    $logstr = sprintf(L('订单补价结算(ID:%s)'), $paotui['paotui_id']);
                }
                $this->update($paotui_id, $a, true);
                K::M('paotui/log')->create(array('paotui_id' => $paotui_id, 'from' => 'payment', 'log' => $logstr, 'type' => 2));
                if($m = K::M('member/member')->detail($paotui['uid'])){
                    if($wx_openid = $m['wx_openid']){
                        $this->payed_wxmsg($wx_openid, $paotui);
                    }
                }
            }
            return $res;
        }
    }

    public function payed_wxmsg($wx_openid, $paotui)
    {
        //获取模版消息配置
        $wx_config = $this->system->config->get('wx_config');
        $a = array('title' => L('恭喜您！跑腿订单支付成功！'), 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => L('跑腿订单支付成功')), 'remark' => sprintf(L('恭喜,您的订单于%s支付成功，订单交易完成！'), date('Y-m-d H:i:s', time())));
        $url = K::M('helper/link')->mklink('paotui:detail', array($paotui['paotui_id']), array(), 'www');
        return K::M('weixin/wechat')->wechat_client()->sendTempMsg($wx_openid, $wx_config['tmpl_order_status'], $url, $a);
    }

}
