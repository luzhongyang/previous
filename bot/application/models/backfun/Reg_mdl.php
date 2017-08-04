<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reg_mdl extends CI_Model {
	
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
      	$this->load->model('netbot_mdl');
      	 if($this->pnetbot['code']==1)
      	 {       	 	    
                $tl_up = array();
                $tl_up['nb_reg'] =1;
                $this->netbot_mdl->update($this->pnetbot['tl_netbot'], $tl_up);
        }else{
        	      //$this->netbot_mdl->del($this->pnetbot['tl_netbot']);
        }
  	   return true;
      }
      

}