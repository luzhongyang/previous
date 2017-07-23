<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Wuye extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_wuye';
    protected $_pk = 'wuye_id';
    protected $_cols = 'wuye_id,title,mobile,passwd,money,total_money,tixian_percent,tixian_money,contact,phone,aidit,closed,clienip,dateline';
    protected $_orderby = array('wuye_id'=>'DESC');
    public function mobile($mobile)
    {
    	return $this->detail_by_mobile($mobile);
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
    public function update_money($wuye_ids, $money, $intro)
    {
        
        if(!$money = (float)$money){
            $this->msgbox->add(L('更变的余额值非法'), 411);
        }else if(empty($intro)){
            $this->msgbox->add(L('余额变更日志不可为空'), 412);
        }else{
            if($wuye_ids = K::M('verify/check')->ids($wuye_ids)){
                foreach(explode(',', $wuye_ids) as $wuye_ids){
                        $sql = "UPDATE ".$this->table($this->_table)." SET `money`=`money`+{$money} WHERE wuye_id='$wuye_ids'";
                    if($this->db->Execute($sql)){
                        K::M('xiaoqu/wuye/log')->log($wuye_ids, $money, $intro);
                    }
                }
                return true;
            }
        }
        return false;
    }
    protected function _check($data, $wuye_id=null)
    {
        if(isset($data['passwd']) && !preg_match('/^[0-9a-f]{32}$/i', $data['passwd'])){
            if($wuye_id && $data['passwd'] == '******'){
                unset($data['passwd']);
            }else{
                $data['passwd'] = md5($data['passwd']);
            }
        } 
        if(isset($data['mobile'])){
            $mobile = $data['mobile'];
            if($a = $this->detail_by_mobile($mobile)){
                if(empty($wuye_id) || ($a['wuye_id'] != $wuye_id)){
                    $this->msgbox->add('手机号码已经存在', 511);
                }
            }
        }
        return parent::_check($data, $wuye_id);		
    }
    
    public function wuye($u, $l='wuye_id')
    {
        $l = strtolower($l);
        switch ($l) {
            case 'wuye_id':
                $field = 'wuye_id';
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
    
    protected function _format_row($row)
    {
        $xiaoqu = K::M('xiaoqu/xiaoqu')->find(array('wuye_id'=>$row['wuye_id']));
        $row['xiaoqu'] = $xiaoqu;
        return $row;
    }
    
    
}