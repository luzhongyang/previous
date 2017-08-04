<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

   public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE);
        $this->load->helper('bot');
        $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
        $this->config->load('dy', TRUE);         	
        $this->load->model('bot_mdl', 'bot');
        
    }
	public function index()
	{
		echo ENVIRONMENT;
		print_r($_SERVER);
		$this->load->view('welcome_message');
	}
}
