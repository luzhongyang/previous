<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: gold.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */

Import::M('member/member');
class Mdl_Member_Money extends Mdl_Member_Member
{

    public function update($uids, $money, $intro='')
    {

        if(!$money = (float)$money){
            $this->msgbox->add(L('更变的余额值非法'), 411);
        }else if(empty($intro)){
            $this->msgbox->add(L('未填写充值说明'), 412);
        }else{
            if($uids = K::M('verify/check')->ids($uids)){
                foreach(explode(',', $uids) as $uid){
                    if($money > 0){
                        $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money},`total_money`=`total_money`+{$money} WHERE uid='$uid'";
                    }else{
                        $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE uid='$uid'";
                    }
                    if($this->db->Execute($sql)){
                        K::M('member/log')->log($uid, 'money', $money, $intro);
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function package()
    {
        return array(
            '1' => '1',
            '500'  => '50',
            '2000' => '250',
            '5000' => '600',
        );
    }
}
