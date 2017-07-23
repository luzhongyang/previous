<?php

!defined('IN_ASK2') && exit('Access Denied');
class paylogmodel {

    var $db;
    var $base;


    function paylogmodel(&$base) {
      
          $this->base = $base;
        $this->db = $base->db;
    }

    function addlog($type,$typeid,$money,$openid='',$fromuid='',$touid=''){
    	$time=$this->base->time;
      $this->db->query("INSERT INTO ".DB_TABLEPRE."paylog SET type='$type',typeid=$typeid,money=$money,openid='$openid',fromuid=$fromuid,touid=$touid,`time`=$time");
    	 $id = $this->db->insert_id();
    	 return $id;
    }
    function delete($id){
    	   $this->db->query("DELETE FROM ".DB_TABLEPRE."paylog WHERE `id` IN ('$id')");
    }

    function selectbyfromuid($fromuid,$typeid){
    	 $one = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "paylog WHERE fromuid=$fromuid and typeid=$typeid");
    	 return $one;
    }

}

?>
