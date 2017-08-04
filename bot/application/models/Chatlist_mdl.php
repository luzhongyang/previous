<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Chatlist_mdl extends CI_Model {
    public $_config = array();

    public function __construct() {
        parent::__construct();
    }
       
    public function info($id) {
        $data = array();
        $this->db->select('*')->from("chatlist")->where(array(
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
    public function add($data) {
        if ($this->db->insert("chatlist", $data)) {
            return true;
        } else {
            return false;
        }
    }
  
    public function check($username,$guid) {
        $this->db->select('*')->from("chatlist")->where(array(
            "username" => $username,
             "guid" => $guid
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
     public function check3($username,$guid) {
        $this->db->select('*')->from("chatlist")->where(array(
            "username" => $username,
             "stauts" => 1,
             "guid" => $guid
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
     
    public function check2($guid) {
        $this->db->select('*')->from("chatlist")->where(array(
             "guid" => $guid
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    } 
     
        public function check4($guid) {
        $this->db->select('*')->from("chatlist")->where(array(
             "guid" => $guid,
              "stauts" => 0
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            return true;
        } else {
            return false;
        }
    } 
     
     
    public function update($id, $data) {
        $this->db->where('id', $id);
        if ($this->db->update("chatlist", $data)) {
            return true;
        } else {
            return false;
        }
    }
  
    public function getlist() {
        $data = array();
        $query = $this->db->query("SELECT * FROM  chatlist");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function getlist_user($username) {
        $data = array();
        $query = $this->db->query("SELECT * FROM  chatlist where username='".$username."' ");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
      public function del($id) {
    	  $sql="delete from  chatlist  where  id=".$id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   }

}