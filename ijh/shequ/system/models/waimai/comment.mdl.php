<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Waimai_Comment extends Mdl_Table
{   
  
    protected $_table = 'waimai_comment';
    protected $_pk = 'comment_id';
    protected $_cols = 'comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,content,pei_time,have_photo,reply,reply_ip,reply_time,closed,clientip,dateline';

    public function timestr($minute)
    {
        $str = '';
        if($minute <= 60){
            $str = '准时送达';
        }else if($minute >= 180){
            $str = '3小时以上';
        }else{
            if($minute%60 == 0){
                $str = intval($minute/60).'小时';
            }else{
                $str = intval($minute/60).'小时'.($minute%60).'分钟';
            }
            
        }
        return $str;
    }
    /**
     * 总评论数
     * @param $shop_id
     */
    public function comments($shop_id)
    {
         $sql = "SELECT SUM(`score`) FROM ".$this->table($this->_table)." WHERE `shop_id`={$shop_id}";
        return $this->db->GetOne($sql);
    }
    public function update_score($shop_id)
    {
        if(!$shop_id = (int)$shop_id){
            return false;
        }
        $sql = "SELECT SUM(`score`) total_score, COUNT(1), comment_count FROM ".$this->table($this->_table)." WHERE `shop_id`='{$shop_id}'";
        if($row = $this->GetRow($sql)){
            K::M('waimai/waimai')->update($shop_id, array('score'=>$row['total_score'], 'comments'=>$row['comment_count']));
        }
    }
}