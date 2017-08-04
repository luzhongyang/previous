<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screen extends Chat_Controller {


	 
	    public $path;
	 	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
          $this->load->helper('date');
          $this->load->helper("alwin");  
          $this->load->library("FileCache");
          $this->load->model('chat_mdl');         
          $this->path = $this->input->get('path');
          
       
    }
    
    
	public function index()
	{


    $view_data= array();
		$this->load->view('chat/screen', $view_data);
	}
	
  /*
	 $result =String2Hex($result);
   $result =Hex2String($result);
   $result =urlencode($result);
   $result =gzcompress($result);
   $result =td_xor_encode($result);	
   $result = td_xor_decode($result);
   $result = gzuncompress($result);	
   $result =urldecode($result);
   write_file("c:/result.jpg",  $result);
	
	*/
	// 开始查看屏幕
	public function send(){
		 //usleep(200000); 
  //创建任务
  //header('Content-Type: application/text; charset=utf-8');
  $result="";

	$vars=array();
	$vars['digit']=$this->input->post('digit');
  $result=$this->chat_mdl->chat_send_screen("screen",$vars);
 
  if($result){ 	
  $result = gzuncompress($result);	
  $result	=base64_encode($result);
}else{
	$result="error";
}
  echo $result;
	}
  
  
  public function addmouse(){
  	
  		$type=$_POST['type'];
  		$x=$_POST['x'];
  		$y=$_POST['y'];

	$vars=array();
	$vars['type']=$type;
	$vars['x']=$x;
	$vars['y']=$y;
  $task_data=$this->chat_mdl->chat_send("addmouse",$vars,0);	
   show_json("ok");
  }
  
   public function addkeyboard(){
  	 		$key=$_POST['key'];
  	
	$vars=array();
	$vars['key']=$key;
  $task_data=$this->chat_mdl->chat_send("addkeyboard",$vars,0);	
   show_json("ok");
  	
  }


	
	


	
}

