<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Selectdb_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
      
        
    }
     

    public function node() {
        $data = array();
        $sql="SELECT * FROM node";
        $sql .=" where status=1";
        $sql .=" order by addtime desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {           
        $data[$row["url"]] = $row["name"];            
        }
        return $data;
    }
 
 
   
}

