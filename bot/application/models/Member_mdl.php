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
class Member_mdl extends CI_Model {
    public $_config = array();
    public function __construct() {
        parent::__construct();  
    }
     
    public function adminhasLogin() {
        $admin_session = $this->session->userdata('admin_session');
        if (!empty($admin_session)) {
            //$member_username = unserialize($member_session);
            //echo "hehe".$admin_session;
            return true;
        } else {
            return false;
        }
    }
    public function login($username, $password) {
        $data = array();
        $this->db->select('*')->from("member")->where(array(
            "username" => $username,
            "password" => $password
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
    public function info_view($username) {
        $data = array();
        $this->db->select('*')->from("member")->where(array(
            "username" => $username
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return FALSE;
        }
    }
    public function member_user_add($data) {
        if ($this->db->insert("member", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function sendmessage($touid, $title, $inf, $fromuid) {
        $data = array();
        $data['touid'] = $touid;
        $data['fromuid'] = $fromuid;
        $data['title'] = $title;
        $data['inf'] = $inf;
        if ($this->db->insert("message", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function member_user_check($username) {
        $this->db->select('*')->from("member")->where(array(
            "username" => $username
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
  

    
    public function member_user_update($username, $data) {
        $this->db->where('username', $username);
        if ($this->db->update("member", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function finger_add($data) {
        if ($this->db->insert("login_log", $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function member_list() {
        $data = array();
        $query = $this->db->query("SELECT * FROM  member");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
    public function role_check_id($username,$id) {
      $member=$this->info_view($username);	
      $task_group = json_decode($member['grouplist'], true);
     echo $id;
      $nb=$this->db->query("select nb_guid,nb_group from netbot where nb_id='".$id."' limit 1 ")->row();
      $gexps = $this->db->query("SELECT nge_group_id FROM netbot_group_expand where nge_netbot_id='" . $nb->nb_guid . "'")->result_array();
      $netbot_groups=array();
      $netbot_groups[]=$nb->nb_group;
      foreach ($gexps as $gexp) {
          $netbot_groups[]=$gexp['nge_group_id'];	 
      }      
       $groups_intersect=array_intersect($netbot_groups,$task_group);             
        if(empty($groups_intersect)) {
            return false;
        } else {
            return true;
        }
    }
    
     public function role_check_guid($username,$guid) {
      $member=$this->info_view($username);	
      $task_group = json_decode($member['grouplist'], true);

      $nb_group=$this->db->query("select nb_group from netbot where nb_guid='".$guid."' limit 1 ")->row()->nb_group;
      $gexps = $this->db->query("SELECT nge_group_id FROM netbot_group_expand where nge_netbot_id='" . $guid . "'")->result_array();
      $netbot_groups=array();
      $netbot_groups[]=$nb_group;
      foreach ($gexps as $gexp) {
          $netbot_groups[]=$gexp['nge_group_id'];	 
      }      
       $groups_intersect=array_intersect($netbot_groups,$task_group);             
        if(empty($groups_intersect)) {
            return false;
        } else {
            return true;
        }
    }
    public function del($id) {
    	  $sql="delete from  member  where  id=".$id;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
}

