<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pathlist_mdl extends CI_Model {
	
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
       $task = $this->bot->tl_info;
                $tl_vars = json_decode($task['tl_vars'], TRUE);
                $path_hash = md5($tl_vars['path']);
                $file_path = $this->config->item('pathlist_path') . '/' . $this->pnetbot['tl_netbot'];
                if (!is_dir($file_path)) {
                    mkdir($file_path);
                    chmod($file_path, 511);
                }
                $file_path = $file_path . '/' . $path_hash . '.txt';
                $path_data = $this->pnetbot['data'];
                $path_str = $path_data;
                write_file($file_path, $path_str);
       }
  	   return true;
      }
      

}