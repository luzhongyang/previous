<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class SmslogModel extends CommonModel{
    protected $pk   = 'log_id';
    protected $tableName =  'sms_log';
    
    public function lasttime_by_ip($ip){
        $res = $this->field('dateline')->where(array('clientip'=>$ip))->order(array('log_id'=>'desc'))->find();
        //$sql = "SELECT dateline FROM ".$this->table($this->_table)." WHERE clientip='$ip' ORDER BY log_id DESC LIMIT 1";
        return (int)$res['dateline'];
    }
    
}