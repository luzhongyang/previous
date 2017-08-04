<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * base controller
 *
 * @package BOSS
 * @subpackage Libraries
 * @category Libraries
 * @author Niap
 * @link https://github.com/Niap/boss-project/
 */



class Admin_Controller extends CI_Controller{
	public $user = NULL;
	public $user_role = NULL;
	function __construct(){
		parent::__construct();	
		$this->load->library('session');
		$this->load->model('member_mdl');
		if(!$this->member_mdl->adminhasLogin()) {
			redirect('/verify/admin');	
			exit;
		}		
		$this->user =$this->session->userdata('admin_session');	
		$this->user_role =$this->session->userdata('admin_role_session');	
		
    $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
		$this->controller = $this->router->fetch_class();
		$this->method = $this->router->fetch_method();
	}
}

class Chat_Controller extends CI_Controller{
	public $user = NULL;
	public $user_role = NULL;
	public $netbotguid = NULL;
	function __construct(){
		parent::__construct();	
		$this->load->library('session');
		$this->load->model('member_mdl');
		if(!$this->member_mdl->adminhasLogin()) {
			redirect('/verify/admin');	
			exit;
		}		
		$this->user =$this->session->userdata('admin_session');	
		$this->user_role =$this->session->userdata('admin_role_session');	
		
		if(isset($_SERVER['HTTP_REFERER'])){
     $ref=$_SERVER['HTTP_REFERER'];        
     $ref_query=parse_url($ref, PHP_URL_QUERY);
     parse_str($ref_query, $ref_query_arr);
     
   
     if (array_key_exists("netbotguid",$ref_query_arr)){
     	  if($ref_query_arr['netbotguid']!=$_SESSION['netbotguid']){
     	   if($this->input->is_ajax_request())
   {
   echo "{\"code\":false,\"use_time\":0.01,\"data\":\"500\"}";
  }else{
 	 redirect('/500.htm');	
  }
			  exit;
		    }
     } 
     
     if($_SESSION['netbottype']!="offline"){
     	  $this->load->model('chatlist_mdl');
       if(!$this->chatlist_mdl->check3($this->user,$_SESSION['netbotguid']))
      {
    if($this->input->is_ajax_request())
   {
   echo "{\"code\":false,\"use_time\":0.01,\"data\":\"500\"}";
  }else{
 	 redirect('/500.htm');	
  }
      exit; 	
      }
      
    }
         
   }

    $this->netbotguid =$_SESSION['netbotguid'];
    $this->netbottype =$_SESSION['netbottype'];
    $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
		$this->controller = $this->router->fetch_class();
		$this->method = $this->router->fetch_method();
	}
}



?>