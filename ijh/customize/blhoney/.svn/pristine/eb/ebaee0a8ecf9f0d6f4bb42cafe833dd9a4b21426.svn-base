<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Staff_Staff extends Mdl_Table
{

    protected $_table = 'staff';
    protected $_pk = 'staff_id';
    protected $_cols = 'staff_id,name,mobile,passwd,face,money,total_money,orders,loginip,lastlogin,account_type,account_name,account_number,lat,lng,pmid,verify_name,audit,closed,clientip,dateline,tixian_percent,status';

    public function staff($u, $l = 'staff_id')
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

    public function update_mobile($staff_id, $mobile)
    {
        if(!$mobile = K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add('手机号码不正确', 511);
            return false;
        }else if($a = $this->detail_by_mobile($mobile)){
            if($a['staff_id'] != $staff_id){
                $this->msgbox->add('手机号码已经存在', 512);
                return false;
            }
        }
        return $this->update($staff_id, array('mobile'=>$mobile), true);
    }

    public function update_money($staff_ids, $money, $intro)
    {
        if(!$money = (float)$money){
            $this->msgbox->add('更变的余额值非法', 411);
        }else if(empty($intro)){
            $this->msgbox->add('余额变更日志不可为空', 412);
        }else{
            if($staff_ids = K::M('verify/check')->ids($staff_ids)){
                foreach(explode(',', $staff_ids) as $staff_id){
                    if($money > 0){
                        $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE staff_id='$staff_id'";
                    }else{
                        $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money}, `total_money`=`total_money`-{$money} WHERE staff_id='$staff_id'";
                    }
                    if($this->db->Execute($sql)){
                        K::M('staff/log')->log($staff_id, $money, $intro);
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function tixian($staff_id, $money, $staff=null)
    {
        if(($staff == null) && !($staff = $this->detail($staff_id))){
            return false;
        }else if(!$money = (float)$money){
            $this->msgbox->add('提现金额不正确', 411);
        }else if($money > $staff['money']){
            $this->msgbox->add('提现金额不正确', 412);
        }else{
            $account_info = $staff['account_type'].'('.$staff['account_name'].','.$staff['account_number'].')';
            if($this->update_money($staff_id, -$money, '账户资金提现:'.$account_info)){
                $end_money = $staff['tixian_percent']*$money/100;
                return K::M('staff/tixian')->create(array('staff_id'=>$staff_id, 'money'=>$money, 'account_info'=>$account_info,'status'=>0, 'end_money'=>$end_money));
            }
        }
        return false;
    }

    protected function _format_row($row)
    {
        if($city = K::M('data/city')->city($row['city_id'])){
            $row['city_name'] = $city['city_name'];
        }
        if(empty($row['face'])){
            $row['face'] = 'default/face.png';
        }
        $row['pid'] = sprintf("P%05d", $row['uid']);
        return $row;   
    }   

    protected function _check($row, $staff_id=null)
    {
        if($row['passwd'] && !preg_match('/[0-9a-f]{32}/', $row['passwd'])){
            if($staff_id && $row['passwd'] == '******'){
                unset($row['passwd']);
            }else{
                $row['passwd'] = md5($row['passwd']);
            }
        }
        if(isset($row['mobile'])){
            if($a = $this->detail_by_mobile($mobile)){
                if(empty($staff_id) || ($a['staff_id'] != $staff_id)){
                    $this->msgbox->add('手机号码已经存在', 511);
                }
            }
        }
        return parent::_check($row, $staff_id);
    }

}
