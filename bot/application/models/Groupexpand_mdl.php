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
class Groupexpand_mdl extends CI_Model {
    public $_config = array();
    public function __construct() {
        parent::__construct();
      
        
    }
     
    public function add($data) {
        if ($this->db->insert("netbot_group_expand", $data)) {
            return true;
        } else {
            return false;
        }
    }
  
    public function check($nge_netbot_id,$nge_group_id) {
        $this->db->select('*')->from("netbot_group_expand")->where(array(
            "nge_netbot_id" => $nge_netbot_id,
            "nge_group_id" => $nge_group_id
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
  
    
    public function update($nge_id, $data) {
        $this->db->where('nge_id', $nge_id);
        if ($this->db->update("netbot_group_expand", $data)) {
            return true;
        } else {
            return false;
        }
    }
 
    public function getlist($nge_group_id="") {
        $data = array();
        $sql="SELECT * FROM netbot_group_expand as g,netbot as n where g.nge_netbot_id=n.nb_guid";
        if(!empty($nge_group_id)) $sql .=" and g.nge_group_id='".$nge_group_id."'";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
   public function del($nge_id) {
    	  $sql="delete from  netbot_group_expand  where  nge_id=".$nge_id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
   
}

