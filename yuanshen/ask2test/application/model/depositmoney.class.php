<?php

!defined('IN_ASK2') && exit('Access Denied');

class depositmoneymodel {

    var $db;
    var $base;

    function depositmoneymodel(&$base) {
        $this->base = $base;
        $this->db = $base->db;
    }

 

    function get($fromuid,$type,$typeid){
    	 $model= $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user_depositmoney WHERE fromuid=$fromuid and type='$type' and typeid=$typeid and state=0");
        return $model;
    }
    function add($fromuid,$needpay,$type,$typeid,$touid=0) {
      
        $this->db->query("INSERT INTO `" . DB_TABLEPRE . "user_depositmoney` (`fromuid`,`needpay`,`type`,`typeid`,`touid`,`state`,`time`) VALUES ($fromuid,$needpay,'$type',$typeid,$touid,'0','{$this->base->time}')");
          $id = $this->db->insert_id();
        
        return $id;
    }

    function remove($fromuid,$type,$typeid) {
    	 $model= $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user_depositmoney WHERE fromuid=$fromuid and type='$type' and typeid=$typeid and state=0");
        if ($model) {
        	$money=$model['needpay']*100;
        	$needpay=$model['needpay'];
        	 $this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid");
        	  $time=time();
            			   $this->db->query("INSERT INTO ".DB_TABLEPRE."paylog SET type='th$type',typeid=$typeid,money=$needpay,openid='',fromuid=0,touid=$fromuid,`time`=$time");
        }
        $this->db->query("DELETE FROM `" . DB_TABLEPRE . "user_depositmoney` WHERE fromuid=$fromuid and type='$type' and typeid=$typeid");
       
    }
  /*更新托管资金状态 */
    function update($fromuid,$type,$typeid){
    	$this->db->query("UPDATE " . DB_TABLEPRE . "user SET  `state`=1 WHERE fromuid=$fromuid and type='$type' and typeid=$typeid");
    }

  

   

}

?>