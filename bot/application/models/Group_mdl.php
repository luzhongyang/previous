<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Group_mdl extends CI_Model {
    public $_config = array();
    public function __construct() {
        parent::__construct();
      
        
    }
     
    public function add($data) {
        if ($this->db->insert("groups", $data)) {
            return true;
        } else {
            return false;
        }
    }
  
    public function check($ng_name) {
        $this->db->select('*')->from("groups")->where(array(
            "ng_name" => $ng_name
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
  
    
    public function update($ng_id, $data) {
        $this->db->where('ng_id', $ng_id);
        if ($this->db->update("groups", $data)) {
            return true;
        } else {
            return false;
        }
    }
 
  public function getlist($ng_type="") {
        $data = array();
        $sql="SELECT * FROM groups";
        if(!empty($ng_type)) $sql .=" where ng_type='".$ng_type."'";
        $sql .=" order by ng_type desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
      public function getlist_user($username,$ng_type="") {
        $data = array();        
         $member=$this->member_mdl->info_view($username);	
         $task_group = json_decode($member['grouplist'], true);       
        $sql="SELECT * FROM groups where ng_id   in (".implode(",", $task_group).") ";  
     if(!empty($ng_type)){    
		    $sql .=" and ng_type='".$ng_type."' ";
     }
        
        $sql .=" order by ng_type desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
   public function del($ng_id) {
    	  $sql="delete from  groups  where  ng_id=".$ng_id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
   
}

