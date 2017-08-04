<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class App_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
      
        
    }
     
    public function add($data) {
        if ($this->db->insert("app", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function info_view($app_id) {
        $data = array();
        $this->db->select('*')->from("app")->where(array(
            "app_id" => $app_id
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
    public function check($app_fun) {
        $this->db->select('*')->from("app")->where(array(
            "app_fun" => $app_fun
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
  
    
    public function update($app_id, $data) {
        $this->db->where('app_id', $app_id);
        if ($this->db->update("app", $data)) {
            return true;
        } else {
            return false;
        }
    }
 
    public function getlist($app_type="") {
        $data = array();
        $sql="SELECT * FROM app  where app_stauts=1 ";
        if(!empty($app_type)) $sql .=" and app_type='".$app_type."'";     
        $sql .=" order by app_type desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
   public function getlist_all($app_type="") {
        $data = array();
        $sql="SELECT * FROM app";
        if(!empty($app_type)) $sql .=" where app_type='".$app_type."'";
        $sql .=" order by app_type desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
 
   public function del($app_id) {
    	  $sql="delete from  app  where  app_id=".$app_id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
   
}

