<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Comment extends Mdl_Table
{   
  
    protected $_table = 'shop_comment';
    protected $_pk = 'comment_id';
    protected $_cols = 'comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,closed,clientip,dateline,mark';
    
    public function create($data)
    {   
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        return $this->db->insert($this->_table, $data, true);
    }

    public function detail_by_order($order_id)
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE order_id='{$order_id}' LIMIT 1";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }
    
    public function timestr($minute)
    {
        $str = '';
        if($minute <= 60){
            $str = L('准时送达');
        }else if($minute >= 180){
            $str = L('3小时以上');
        }else{
            if($minute%60 == 0){
                $str = sprintf(L('%s小时'), intval($minute/60));
            }else{
                $str = sprintf(L('%s小时%s分钟'), intval($minute/60),($minute%60));
            }
            
        }
        return $str;
    }
    
    
    public function peitime()
    {
        $peitime = array();
        for($i=10;$i<=180;$i=$i+10){
            $peitime[$i] = $i;
        }
        foreach($peitime as $k =>$v){
            if($v%60 == 0){
                $peitime[$k] = sprintf(L('%s小时'), ($v/60));
            }else{
                $peitime[$k] = sprintf(L('%s分钟'), $v);
            }
        }
        $peitime[181] = L('3小时以上');
        return $peitime;
    }

    protected function _format_row($row)
    {
        $row['pei_time_label'] = $this->timestr($row['pei_time']);
        return $row;
    }

    // 计算好评、中评、差评
    public function getlevel()
    {
        
    }

}