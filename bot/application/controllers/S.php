<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class S extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('bot');
        $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
        $this->config->load('dy');         	
        $this->load->model('bot_mdl', 'bot');
        
    }

  public function index()
  {
  	$this->bot->t();
  }
  
    public function c()
  {
  	$this->bot->c();
  }
 
     public function p()
  {
  	$this->bot->p();
  }
 
}