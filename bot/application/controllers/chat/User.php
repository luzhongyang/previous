<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Chat_Controller {

	 
	 	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
          $this->load->helper('date');
       
    }
    
    
	public function index()
	{
		$view_data= array();
	
		$this->load->view('chat/explorer', $view_data);
	}
		public function common_js()
	{
		$this->config->load('chat', TRUE);
    $chat_lng  = $this->config->item('chat_lng','chat'); 
    $the_config = array(
  'lang'=> 'zh_CN',
  'is_root'=> 1,
  'user_name'=> 'admin',
  'web_root'=> '/home/wwwroot/www.bot.com/',
  'web_host'=> 'http://www.bot.com/',
  'static_path'=> '/static/',
  'basic_path'=> '/home/wwwroot/www.bot.com/',
  'version'=> '3.12',
  'app_host'=> 'http://www.bot.com/',
  'office_server'=> '',
  'myhome'=> '/home/wwwroot/www.bot.com/',
  'upload_max'=> 2097152,
  'json_data'=> '',
  'theme'=> 'metro/green_',
  'list_type'=> 'icon',
  'sort_field'=> 'name',
  'sort_order'=> 'up',
  'musictheme'=> 'mp3player',
  'movietheme'=> 'webplayer'
        );
        $auth=null;
        $js  = 'LNG='.json_encode($chat_lng).';';
        $js .= 'AUTH='.json_encode($auth).';';
        $js .= 'G='.json_encode($the_config).';';
        header("Content-Type:application/javascript");
        echo $js;		
	}
	

	
}

