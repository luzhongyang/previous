<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weixin_Help extends Mdl_Table
{   
  
    protected $_table = 'weixin_help';
    protected $_pk = 'help_id';
    protected $_cols = 'help_id,shop_id,keyword,title,intro,photo,stime,ltime,use_tips,end_tips,follower_condtion,member_condtion,collect_count,views,end_photo,lastupdate,clientip,dateline';
    
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
	public function format_reply($help_id)
	{
		if($row = $this->detail($help_id)){
			$cfg = K::$system->config->get('attach');
			$a = array('Title'=>$row['title'], 'Description'=>$row['info'], 'PicUrl'=>$cfg['attachurl'].'/'.$row['photo'],
				'Url'=>K::M('helper/link')->mklink('weixin/help:preview', array($help_id), array(), 'www')
				);
			return array($a);
		}
		return false;
	}
}