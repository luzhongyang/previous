<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}
class Mdl_Cooperation_Cooperation extends Mdl_Table {
    protected $_table = 'cooperation';
    protected $_pk = 'cooperation_id';
    protected $_cols = 'cooperation_id,name,city_name,mobile,qq,audit,dateline';
    protected $_orderby = array('dateline'=>'DESC', 'cooperation_id'=>'DESC');
    
    public function check_mobile($mobile, $detail)
    {
        if(!K::M('verify/check')->mobile($mobile)){
            $this->msgbox->add('手机号码格式不正确', 511);
            return false;
        }elseif(K::M('cooperation/cooperation')->count(array('mobile'=>$mobile))){
            $this->msgbox->add('您已经申请过了', 512);
            return false;
        }
        return $mobile;
    }

}
