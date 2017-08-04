<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends Chat_Controller {
 
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
         	 if($this->netbottype=="offline")
    {
    	 echo "离线状态下不能进行此操作！";
    	 exit;
    } 
       
    }
    
    
	public function index()
	{
	
    $editor_config  = $this->getConfig();
    $filename="";
    $view_data= array();
	  $view_data['filename']=$filename;
	  $view_data['editor_config']=$editor_config;
		$this->load->view('chat/edit', $view_data);
	}
	
	
	
		public function edit(){

    $editor_config  = $this->getConfig();
    $filename=$this->input->get('filename');
    $view_data= array();
	  $view_data['filename']=$filename;
	  $view_data['editor_config']=$editor_config;
	  $edit_basepath=urldecode(urldecode($filename));
	    //echo $edit_basepath;
	  $edit_basepath=get_path_father($edit_basepath);
	  //echo $edit_basepath;
	  $_SESSION['edit_basepath']=$edit_basepath;
		$this->load->view('chat/edit', $view_data);

	}

		// 获取文件数据
	public function fileGet(){
		$filename=$this->input->get('filename');
    $filename=urldecode($filename);
     	//创建任务
	$vars=array();
	$vars['path']=$filename;
  $task_data=$this->chat_mdl->chat_send("fileRead",$vars,1);


	      if($task_data){    
	      $list=$task_data['data']; 
	      $list=json_decode($list,true);
	      	      
	      $content=Hex2String($list['content']);
	      //$charset=$list['charset'];	
	     $charset=$this->_get_charset($content);
	   
	   if(empty($charset)) $charset='utf-8';

			$content=mb_convert_encoding($content,'utf-8',$charset);
		            
	      $list['content']=$content; 
	      $list['charset']=$charset;
	                
        show_json($list);
	     }else{
	     	 show_json("读取超时",false);
	   
	     }

	}
	
		private function _get_charset(&$str) {
		if ($str == '') return 'utf-8';
		//前面检测成功则，自动忽略后面
		$check_charset = 'ASCII,UTF-8,GBK';
		$charset=strtolower(mb_detect_encoding($str,$check_charset));
		if (substr($str,0,3)==chr(0xEF).chr(0xBB).chr(0xBF)){
			$charset='utf-8';
		}else if($charset=='cp936'){
			$charset='gbk';
		}
		if ($charset == 'ascii') $charset = 'utf-8';
		return strtolower($charset);
	}
	
	

		public function fileSave(){
	
	$path=$this->input->post('path');
	//$charset=$this->input->post('charset');
	//if(empty($charset)) $charset="utf-8";
	if(empty($path)){
	$path=$_SESSION['edit_basepath']."newfile.txt";
  }
	
	$filestr=$_POST['filestr'];		
	$charset=$this->_get_charset($filestr);
	if(empty($charset)) $charset='utf-8';
	$filestr=mb_convert_encoding($filestr,$charset,'utf-8');
	 	//创建任务
	$vars=array();
	$vars['path']=urldecode($path);
	$vars['charset']=urldecode($charset);
	$vars['filestr']=$filestr;	
	
	 $task_data=$this->chat_mdl->chat_send("fileSave",$vars,1);
	
	    if($task_data){
      
        show_json("操作成功");
	     }else{
	     	 show_json("读取超时",false);
	   
	     }
	
			
	}

		/*
	* 获取编辑器配置信息
	*/
	public function getConfig(){
		$default = array(
			'font_size'		=> '15px',
			'theme'			=> 'clouds',
			'auto_wrap'		=> 0,
			'display_char'	=> 0,
			'auto_complete'	=> 1,
			'function_list' => 1
		);
		$config_file = $this->config->item('data_path').'/editor_config.php';		
		if (!file_exists($config_file)) {//不存在则创建
			$sql=new FileCache();
			$sql->setFileName($config_file);
			$sql->reset($default);
		}else{
			$sql=new FileCache();
			$sql->setFileName($config_file);
			$default = $sql->get();
		}
		if (!isset($default['function_list'])) {
			$default['function_list'] = 1;
		}
		return json_encode($default);
    }
	
	/*
	* 获取编辑器配置信息
	*/
	public function setConfig(){
		$file = $this->config->item('data_path').'/editor_config.php';		
    
		$key= $this->input->get('k');
		$value = $this->input->get('v');
        if ($key !='' && $value != '') {
        	$sql=new FileCache($file);
        	if(!$sql->update($key,$value)){
        		$sql->add($key,$value);//没有则添加一条
        	}
            show_json("修改已生效！");
        }else{
            show_json("修改失败！",false);
        }
    }
	
	
}

