<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Node_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
      
        
    }
     
    public function add($data) {
        if ($this->db->insert("node", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function info_view($id) {
        $data = array();
        $this->db->select('*')->from("node")->where(array(
            "id" => $id
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
    public function check($url) {
        $this->db->select('*')->from("node")->where(array(
            "url" => $url
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
  
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        if ($this->db->update("node", $data)) {
            return true;
        } else {
            return false;
        }
    }
 
    public function getlist($status=0) {
        $data = array();
        $sql="SELECT * FROM node";
        if(!empty($status)) $sql .=" where status=".$status;
        $sql .=" order by addtime desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
   public function del($id) {
    	  $sql="delete from  node  where  id=".$id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
   
}

