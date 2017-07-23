<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weixin_Relay extends Mdl_Table
{   
  
    protected $_table = 'weixin_relay';
    protected $_pk = 'relay_id';
    protected $_cols = 'relay_id,shop_id,keyword,title,intro,photo,stime,ltime,use_tips,end_tips,relay_num,max_num,max_gold,min_gold,time,follower_condtion,member_condtion,collect_count,views,end_photo,lastupdate,clientip,dateline';
    
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        return $this->db->insert($this->_table, $data, true);
    }
    public function update($pk, $data, $checked=false)
    {
        $this->_checkpk();
        if(!$checked && !$data = $this->_check_schema($data,  $pk)){
            return false;
        }
        return $this->db->update($this->_table, $data, $this->field($this->_pk, $pk));
    }
    public function format_reply($relay_id)
    {
        if($row = $this->detail($relay_id)){
            $cfg = K::$system->config->get('attach');
            $a = array('Title'=>$row['title'], 'Description'=>$row['info'], 'PicUrl'=>$cfg['attachurl'].'/'.$row['photo'],
                'Url'=>K::M('relayer/link')->mklink('weixin/relay:preview', array($relay_id), array(), 'www')
                );
            return array($a);
        }
        return false;
    }
}