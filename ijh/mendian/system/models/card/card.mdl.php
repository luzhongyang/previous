<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Card extends Mdl_Table
{

    protected $_table = 'card';
    protected $_pk = 'card_id';
    protected $_cols = 'card_id,number,shop_id,staff_id,wx_openid,uid,grade_id,mobile,name,sex,Y,M,D,orders,total_money,money,total_jifen,jifen,dateline,closed';

    public function detail_by_uid($uid, $shop_id)
    {
        if(!($uid = (int)uid) || !($shop_id = (int)$shop_id)){
            return false;
        }
        if($row = $this->db->GetRow("SELECT * FROM ".$this->table($this->_table)." WHERE uid={$uid} AND shop_id={$shop_id}")){
            $row = $this->_format_row($row);
        }
        return $row;
    }

    public function detail_by_wx_openid($wx_openid)
    {
        if($row = $this->db->GetRow("SELECT * FROM ".$this->table($this->_table)." WHERE wx_openid='{$wx_openid}'")){
            $row = $this->_format_row($row);
        }
        return $row;
    }

    //消费会员卡
    public function update_order($card_id, $money, $intro='', $order_id=0)
    {
        if(!$card_id = (int)$card_id){
            $this->msgbox->add('会员卡错误', 411);
        }else if(($money = (float)$money) <= 0){
            $this->msgbox->add('消费金额非法', 412);
        }else if(empty($intro)){
            $this->msgbox->add('消费说明不能为空', 413);
        }else if(!$card = $this->detail($card_id)){
            $this->msgbox->add('会员卡错误', 414);
        }else{
            $sql = "UPDATE ".$this->table($this->_table)." SET `orders`=`orders`+1,`total_money`=`total_money`+{$money} WHERE card_id='$card_id'";
            if($this->db->Execute($sql)){
                if($shop = K::M('cashier/cashier')->detail($card['shop_id'])){
                    //消费后自动送积分
                    list($xfm, $xfj) = explode(':', $shop['xf_jifen']);
                    if(($xfm = (int)$xfm) && ($xfj = (int)$xfj)){
                        if($xf_jifen = intval($money/$xfm)*$xfj){
                            $this->update_jifen($card_id, $xf_jifen, "消费￥{$money}赠送{$xf_jifen}积分");
                        }
                    }
                    //消费后自动判断是否升级会员等级
                    if($grade_list = K::M('card/grade')->items_by_shop_id($card['shop_id'])){
                        $card_money = $card['total_money'] + $money;
                        $new_grade = array();
                        foreach($grade_list as $v){
                            if($card_money > $v['need_money']){
                                $new_grade = $v;
                            }
                        }
                        if($new_grade){
                            $new_grade_id = $card['grade_id'];
                            if($card_grade = $grade_list[$card['grade_id']]){
                                if($card_grade['need_money'] < $new_grade['need_money']){
                                    $new_grade_id = $new_grade['grade_id'];
                                }
                            }
                            if($new_grade_id != $card['grade_id']){
                                if($this->update($card_id, array('grade_id'=>$new_grade_id), true)){
                                    //可以增加发送短信及消息功能
                                }
                            }
                        }

                    }
                }
                K::M('card/log')->log($card_id, $order_id, 'order', $money, $intro);
            }
        }
        return false;
    }

    public function update_chongzhi($card_id, $money, $intro='', $order_id=0)
    {
        if(!$card_id = (int)$card_id){
            $this->msgbox->add('未指定会员卡', 411);
        }else if(($money = (float)$money) <= 0){
            $this->msgbox->add('充值的金额值不合法', 413);
        }else if(empty($intro)){
            $this->msgbox->add('未填写充值说明', 414);
        }else{
            $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE card_id='$card_id'";
            if($res = $this->db->Execute($sql)){
                K::M('card/log')->log($card_id, $order_id, 'chongzhi', $money, $intro);
            }
            return $res;
        }
        return false;  
    }

    public function update_money($card_id, $money, $intro='', $order_id=0)
    {
        if(!$card_id = (int)$card_id){
            $this->msgbox->add('未指定会员卡', 411);
        }else if(!$money = (float)$money){
            $this->msgbox->add('更变的余额值非法', 413);
        }else if(empty($intro)){
            $this->msgbox->add('未填写充值说明', 414);
        }else{
            $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE card_id='$card_id'";
            if($this->db->Execute($sql)){
                K::M('card/log')->log($card_id, $order_id, 'money', $money, $intro);
            }
        }
        return false;
    }

    public function update_jifen($card_id, $jifen, $intro='', $order_id=0)
    {
        if(!$card_id = (int)$card_id){
            $this->msgbox->add('未指定会员卡', 411);
        }else if(!$jifen = (int)$jifen){
            $this->msgbox->add('更变的积分值非法', 411);
        }else if(empty($intro)){
            $this->msgbox->add('变更日志不可为空', 412);
        }else{
            if($jifen > 0){
                $sql = "UPDATE ".$this->table($this->_table)." SET `total_jifen`=`total_jifen`+{$jifen}, `jifen`=`jifen`+{$jifen} WHERE card_id='$card_id'";
            }else{
                $sql = "UPDATE ".$this->table($this->_table)." SET `jifen`=`jifen`+{$jifen} WHERE card_id='$card_id'";
            }

            if($this->db->Execute($sql)){
                K::M('card/log')->log($card_id, $order_id, 'jifen', $jifen, $intro, $admin);
            }
        }
        return false;
    }


    public function create_card_number($shop_id)
    {
        if($shop_id = (int)$shop_id){
            $filter['shop_id'] = $shop_id;
        }
        $i = rand(1000, 99999999);
        do{
            if (99999999 == $i) {
                $i = rand(1000, 99999999);
            }
            ++$i;
            $number = sprintf("%04d", $shop_id) . str_pad($i, 4, "0", STR_PAD_LEFT);
            $filter['number'] = $number;
            $have_number = $this->count($filter);
        } while ($have_number);
        return $number;
    }

    protected function _check($row, $card_id=null)
    {
        if(isset($row['mobile']) || isset($row['number'])){
            if($card_id){
                if(!$card = $this->detail($card_id)){
                    $this->msgbox->add('会员卡错误', 511);
                    return false;
                }
                $shop_id = $card['shop_id'];
            }else if(!$shop_id = $row['shop_id']){
                $this->msgbox->add('商户未指定', 512);
                return false;
            }
            if($row['mobile'] && ($a = $this->find(array('shop_id'=>$shop_id, 'mobile'=>$row['mobile'])))){
                if(empty($card_id) || ($a['card_id'] != $card_id)){
                    $this->msgbox->add('手机号码已经绑定', 513);
                    return false;
                }
            }
            if($row['number'] && ($a = $this->find(array('shop_id'=>$shop_id, 'number'=>$row['number'])))){
                if(empty($card_id) || ($a['card_id'] != $card_id)){
                    if(empty($card_id)){
                        $this->msgbox->add('会员卡号已存在', 514);
                    }else{
                        $this->msgbox->add('会员卡号已经绑定', 514);
                    }
                    return false;
                }
            }
        }
        if(empty($card_id) && empty($row['number'])){
            $row['number'] = $this->create_card_number($row['shop_id']);
        }
        return parent::_check($row, $card_id);
    }

    //根据条件查询所有结果
    public function items_by_filter($data, $shop_id=0)
    {
        if (!empty($data['kw']) || !empty($data['month']) || !empty($data['grade_id']) && !empty($shop_id)) {
            $items = array();
            $filter = array('shop_id'=>(int)$shop_id,'closed'=>0);
            if (!empty($data['filter_id'])) {// 有反选(去除的)会员卡ID 
                if ($valid_ids = K::M('verify/check')->ids(trim($data['filter_id'], ','))) {// 验证其合法性
                    $filter[':SQL'] = "(`card_id` NOT IN(".$valid_ids."))";
                }else{
                    return false; // 不合法就不往下执行了
                }
            }elseif (!empty($data['card_id'])) {// 有多选的会员卡ID
                if ($valid_ids = K::M('verify/check')->ids(trim($data['card_id'], ','))) {// 验证其合法性
                    $filter[':SQL'] = "(`card_id` IN(".$valid_ids."))";
                }else{
                    return false; // 不合法就不往下执行了
                }
            }
            if (!empty($data['kw'])) {// 关键词
                if(is_numeric($data['kw'])){
                    $filter[':OR'] = array('mobile'=>'LIKE:'.$data['kw'].'%', 'number'=>'LIKE:'.$data['kw'].'%');
                }else{
                    $filter['name'] = 'LIKE:%'.$data['kw'].'%';
                }
            }
            if (!empty($data['month'])) {// 月份
                $filter['M'] = (int)$data['month'];
            }
            if (!empty($data['grade_id'])) {// 会员等级
                $filter['grade_id'] = (int)$data['grade_id'];
            }
            if ($items = $this->items($filter)) {
                return $items;
            }
        }
        return false;
    }
}
