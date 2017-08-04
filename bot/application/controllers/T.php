<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class T extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->helper('bot');
        $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));             	
        $this->load->model('bot_mdl', 'bot');
        
    }

  public function index()
  {
  	$fc=$this->router->fetch_class();
  	$md=$this->router->fetch_method();
  	if(empty($fc)){
  		show_error('fcnull' ,500,'Error');  
  	} 	
  	$ml=$this->config->load($fc,false,true);
  	if(!$ml)
  	{
  		show_error('fcerror' ,500,'Error');
  	}  
  	$ms_rt = $this->config->item('ms_rt');
  
  	if($md=="index"){ 		
  		$this->bot->t();
  		exit;
  	}
  	
  	if($md==$ms_rt['c']){
  			$this->bot->c();
  		exit;
  	}
  		if($md==$ms_rt['p']){
  			$this->bot->p();
  		exit;
  	}
  	show_error('null' ,500,'Error');  
  }
   
}