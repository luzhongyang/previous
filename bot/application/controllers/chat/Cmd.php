<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmd extends Chat_Controller {


	 
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
    if($this->netbottype=="offline")
    {
    	 echo "离线状态下不能进行此操作！";
    	 exit;
    }
  

    $view_data= array();
		$this->load->view('chat/cmd', $view_data);
	}
	
	


		// 获取文件数据
	public function send(){
		$command=$_POST['command'];


     	//创建任务
	$vars=array();
	$vars['command']=$command;
	$vars['iswait']=1;
	$vars['timeout']=10;
  $task_data=$this->chat_mdl->chat_send("cmd",$vars,$wait=1);


	      if($task_data){
	             	      
	      $data=$task_data['data'];  	      
	      $data=urldecode($data);
	      //$data=mb_convert_encoding($data,'utf-8','GBK');  
	      //$data=htmlspecialchars($data); 	 
	      if(empty($data))  $data="命令结果返回为空";    
        show_json($data);
	     }else{
	     	 show_json("读取超时",false);
	   
	     }

	}
	
	


	
}

