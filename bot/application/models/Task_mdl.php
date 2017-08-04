<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Task_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
      
        
    }
     
    public function add($data) {
        if ($this->db->insert("task", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function info_view($t_id) {
        $data = array();
        $this->db->select('*')->from("task")->where(array(
            "t_id" => $t_id
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
 
  
    
    public function update($t_id, $data) {
        $this->db->where('t_id', $t_id);
        if ($this->db->update("task", $data)) {
            return true;
        } else {
            return false;
        }
    }
 
    public function getlist($netbot="") {
        $data = array();
        $sql="SELECT * FROM task";
        if($netbot){
         $sql .=" where t_netbot=2 and t_group='".$netbot."'";	
        }
   
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
     public function getlist_user($username,$netbot="") {
        $data = array();
        $sql="SELECT * FROM task";  
        $sql .=" where username='".$username."'";	
       if($netbot){
         $sql .=" and t_netbot=2 and t_group='".$netbot."'";	
        }
   
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
   public function del($t_id) {
    	  $sql="delete from  task  where  t_id=".$t_id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
 
   
   
}

