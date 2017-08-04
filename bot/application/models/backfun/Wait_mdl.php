<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Wait_mdl extends CI_Model {
	
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
        $path_hash = md5($this->pnetbot['tl_id']);
        $file_path = $this->config->item('tasktmp_path')."/".$this->bot->pnetbot['tl_type'];
        $file_path = $file_path . '/' . $path_hash . '.txt';
        write_file($file_path, $this->json_data);

  	   return true;
      }
      

}