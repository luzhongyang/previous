<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Startchat_mdl extends CI_Model {
	
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
      	 if($this->pnetbot['code']==1)
      	 {
                $this->load->model('netbot_mdl');
                $tl_info = $this->bot->tasklist_info($this->pnetbot['tl_id'], 'cron');
                $tl_vars = $tl_info['tl_vars'];
                $tl_vars = json_decode($tl_vars, TRUE);
                $tl_up = array();
                $tl_up['nb_stauts_val'] = $tl_vars['interval'];
                $tl_up['nb_stauts'] = 2;
                $this->netbot_mdl->mc_update( $this->pnetbot['tl_netbot'], $tl_up);
                $clup = array();
                $clup['stauts'] = 1;
                $this->bot->cl_up( $this->pnetbot['tl_netbot'], $clup);
               
        }
  	   return true;
      }
      

}