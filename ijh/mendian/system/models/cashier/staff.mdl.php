<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Staff extends Mdl_Table
{   
  
    protected $_table = 'cashier_staff';
    protected $_pk = 'staff_id';
    protected $_cols = 'staff_id,shop_id,is_owner,name,mobile,passwd,day_orders,day_price,day_money,day_alipay,day_wxpay,day_chongzhi,day_refund,day_refund_count,day_refund_cash,day_refund_money,day_refund_money,day_refund_wxpay,day_refund_alipay,audit,loginip,lastlogin,closed,dateline';

    public function staff($u, $l='staff_id')
    {
        $l = strtolower($l);
        switch ($l) {
            case 'staff_id':
                $field = 'staff_id';
                break;
            case 'mobile':
                $field = 'mobile';
                break;
            default:
                return false;
        }
        $sql = "SELECT * FROM " . $this->table($this->_table) . " WHERE " . $this->field($field, $u);
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
        }
        return $row;
    }

    public function detail_by_mobile($mobile)
    {
        if(!$mobile = K::M('verify/check')->mobile($mobile)){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE ".$this->field('mobile', $mobile);
        if ($row = $this->db->GetRow($sql)) {
            $row = $this->_format_row($row);
        }
        return $row;
    }

    public function mobile($mobile)
    {
        return $this->detail_by_mobile($mobile);
    }

    public function update_mobile($staff_id, $mobile)
    {
        if(!$mobile = K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add(L('手机号码不正确'), 511);
            return false;
        }else if($a = $this->detail_by_mobile($mobile)){
            if($a['staff_id'] != $staff_id){
                $this->msgbox->add(L('手机号码已经存在'), 512);
                return false;
            }
        }
        return $this->update($staff_id, array('mobile'=>$mobile), true);
    }
    
    public function send($staff_id, $title, $content, $extras=array())
    {
        return K::M('jpush/device')->send_cashier($staff_id, $title, $content, $extras);
    }

    protected function _check($data, $staff_id=null)
    {
        if(isset($data['passwd']) && !preg_match('/^[0-9a-f]{32}$/i', $data['passwd'])){
            if($staff_id && $data['passwd'] == '******'){
                unset($data['passwd']);
            }else{
                $data['passwd'] = md5($data['passwd']);
            }
        } 
        if(isset($data['mobile'])){
            $mobile = $data['mobile'];
            if($mobile = K::M('verify/check')->mobile($data['mobile'])){
                if($a = $this->staff($mobile, 'mobile')){
                    if(empty($staff_id) || ($a['staff_id'] != $staff_id)){
                        $this->msgbox->add('手机号码已经存在', 511);
                        return false;
                    }
                }                
            }else{
                unset($data['mobile']);
            }
        }
        return parent::_check($data, $staff_id);        
    }

    public function update_order($staff_id, $number, $type='cash')
    {
        if(!in_array($type, array('cash', 'money', 'wxpay', 'alipay', 'refund'))){
            $this->msgbox->add('不支持的资金类型', 511);
        }else if($number = floatval($number)){
            $this->msgbox->add('金额不正确', 512);
        }else if($this->update($staff_id, array("`day_{$type}`"=>"`day_{$type}`+{$number}", 'orders'=>'`orders`+1'), true)){
            return true;
        }
        return false;
    }


    public function jiaoban($staff_id, $staff=null)
    {
        if(empty($staff) && !($staff = $this->detail($staff_id))){
            return false;
        }else if(empty($staff['day_orders']) && empty($staff['day_refund_count'])){
            return false;
        }else{
            $data = array('staff_id'=>$staff_id, 'shop_id'=>$staff['shop_id']);
            $data['day_orders'] = $staff['day_orders'];
            $data['day_cash'] = $staff['day_cash'];
            $data['day_money'] = $staff['day_money'];
            $data['day_wxpay'] = $staff['day_wxpay'];
            $data['day_alipay'] = $staff['day_alipay'];
            $data['day_chongzhi'] = $staff['day_chongzhi'];
            $data['day_refund'] = $staff['day_refund'];
            $data['day_refund_count'] = $staff['day_refund_count'];
            $data['day_refund_cash'] = $staff['day_refund_cash'];
            $data['day_refund_money'] = $staff['day_refund_money'];
            $data['day_refund_wxpay'] = $staff['day_refund_wxpay'];
            $data['day_refund_alipay'] = $staff['day_refund_alipay'];
            $data['day'] = date('Ymd', __TIME);
            $data['dateline'] = __TIME;
            if(K::M('cashier/staff/log')->create($data)){
                $a = array(
                    'day_orders'=>0, 
                    'day_cash'=>0, 
                    'day_money'=>0, 
                    'day_alipay'=>0, 
                    'day_wxpay'=>0,
                    'day_chongzhi'=>0,
                    'day_refund'=>0,
                    'day_refund_count' => 0,
                    'day_refund_cash' => 0,
                    'day_refund_money' => 0,
                    'day_refund_wxpay' => 0,
                    'day_refund_alipay' => 0
                );
                return $this->update($staff_id, $a, true);
            }
        }
        return false;
    }
}