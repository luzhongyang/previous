<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tasklist_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
      
        
    }
     
 
    public function info_view($tl_id,$tl_type) {
        $data = array();
        $this->db->select('*')->from("tasklist_".$tl_type)->where(array(
            "tl_id" => $tl_id
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
 
  
    
    public function update($tl_id,$tl_type,$data) {
        $this->db->where('tl_id', $tl_id);
        if ($this->db->update("tasklist_".$tl_type, $data)) {
            return true;
        } else {
            return false;
        }
    }
 
  
 
 
   
}

