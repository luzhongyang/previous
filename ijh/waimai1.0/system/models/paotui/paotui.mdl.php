<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Paotui_Paotui extends Mdl_Table
{   
  
    protected $_table = 'paotui';
    protected $_pk = 'paotui_id';
    protected $_cols = 'paotui_id,uid,addr,house,contact,mobile,lat,lng,time,o_addr,o_house,o_contact,o_mobile,o_lng,o_lat,o_time,intro,photo,voice,voice_time,paotui_amount,danbao_amount,jiesuan_amount,type,staff_id,order_status,pay_status,pay_time,pay_code,pay_ip,day,clientip,dateline';
    protected $_orderby = array('paotui_id'=>'DESC');

    public function create($data, $checked=false)
    {
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        $data['day'] = date('Ymd', $data['dateline']);
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }

    //取消/退单 退回跑腿费用+担保金额到余额
    public function cancel($paotui_id=null, $paotui=null, $from='member')
    {
    	$money = NULL;
        $paotui_id = (int)$paotui_id;
        if(!$paotui && !($paotui = $this->detail($paotui_id))){
            return false;
        }else if(in_array($paotui['order_status'], array(0, 1, 2, 3, 4, 5))){    ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            if($from == 'member' && $paotui['order_status'] == 1){              //用户可以在未接单时直接退单
                $this->msgbox->add(L('配送员已接单不可取消'), 451);
                return false;
            }
            if($this->update($paotui['paotui_id'], array('order_status'=>-1))){
                if($paotui['pay_status'] === 1){
                    $money = $paotui['paotui_amount'] + $paotui['danbao_amount'];
                }
                if($money > 0){ //退回到余额
                    $member_log = sprintf(L('跑腿订单(ID:%s)取消退回到余额'), $paotui['paotui_id']);
                    K::M('member/member')->update_money($paotui['uid'], $money, $member_log);
                }

                if($from == 'admin'){
                    $log = sprintf(L('管理员取消跑腿订单(ID:%s)'), $paotui['paotui_id']);
                }else if($form == 'staff'){
                    $log = sprintf(L('配送员取消跑腿订单(ID:%s)'), $paotui['paotui_id']);
                }else{
                    $log = sprintf(L('用户取消跑腿订单(ID:%s)'), $paotui['paotui_id']);
                }
                K::M('paotui/log')->create(array('type'=>-1, 'from'=>$from, 'log'=>$log, 'paotui_id'=>$paotui['paotui_id']));
                return true;
            }
        }
        return false;
    }
    
    
     protected function _format_row($row)
    {
        if($row['order_status'] < 0){
            $label = L('已取消');
        }else if($row['order_status'] == 0 && $row['staff_id'] == 0 && $row['pay_status'] == 1){
            $label = L('待接单');
        }else if(in_array($row['order_status'],array(1,2))){
            $label = L('已接单');
        }else if($row['type'] == 'song' && $row['order_status'] == 3){
            $label = L('已取件');
        }else if($row['type'] == 'buy' && $row['order_status'] == 3){
            $label = L('已购买');
        }else if($row['order_status'] == 4){
            $label = L('等待确认');
        }else if($row['type'] == 'buy' && $row['order_status'] == 5){
            $label = L('需付差价');
        }else if($row['order_status'] == 8){
            $label = L('已经完成');
        }
        $row['order_status_label'] = $label;
        
        if($row['order_status'] == 0 && $row['pay_status'] == 0){
            if(($row['dateline'] - time()) < 1800){
                $row['pay_label'] = L('订单逾期未支付半小时自动取消');
            }else{
                $row['pay_label'] = array();
            }
        }
        return $row;
        
    }
    
    
    public function update($pk, $data, $checked=false)
    {
        $this->_checkpk();
        if(!$checked && !($data = $this->_check($data,  $pk))){
            return false;
        }
        if($ret = $this->db->update($this->_table, $data, $this->field($this->_pk, $pk))){
            $this->flush();
        }
        return $ret;
    }
     
       
    public function set_payed($paotui_id, $trade=array())
    {        
        if(!$paotui = $this->detail($paotui_id)){
            return false;
        }else{
            if($res = $this->db->update($this->_table, array('pay_status'=>1), "paotui_id='{$paotui_id}'", true)){
                $a = array('online_pay'=>1, 'pay_ip'=>__IP,'pay_time'=>__TIME, 'pay_code'=>$trade['code']);
                $logstr = L('订单支付成功');
                if($paotui['type'] == 'buy' && $paotui['jiesuan_amount']>0 && $paotui['order_status'] == 5){ //二次付款时自动设置订单为完成状态
                    $a['order_status'] = 8;
                    $logstr = sprintf(L('订单补价结算(ID:%s)'), $paotui['paotui_id']);
                }
                $this->update($paotui_id, $a, true);
                K::M('paotui/log')->create(array('paotui_id'=>$paotui_id,'from'=>'payment','log'=>$logstr,'type'=>2));
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
        $a = array('title'=>L('恭喜您！跑腿订单支付成功！'), 'items' => array('OrderSn' => $paotui['paotui_id'], 'OrderStatus' => L('跑腿订单支付成功')), 'remark' =>sprintf(L('恭喜,您的订单于%s支付成功，订单交易完成！'), date('Y-m-d H:i:s',time())));
        $url = K::M('helper/link')->mklink('paotui:detail',array($paotui['paotui_id']), array(), 'www');
        return K::M('weixin/wechat')->wechat_client()->sendTempMsg($wx_openid, $wx_config['tmpl_order_status'], $url, $a);
    }

}