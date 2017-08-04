<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Chat_Controller {
 
	    private $sql;
	 	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        //error_reporting(0);  
          $this->load->helper('date');
          $this->load->helper("alwin");  
          $this->load->library("FileCache");     
          $this->path = $this->input->get('path');
          
       
    }
    
    
	public function index()
	{
		$view_data=array();
    $this->load->view('chat/setting', $view_data);
	}
	 public function slider() {
	 	
	 	
	 	 $slider=$this->input->get('slider');
	 	 
	 	 if($slider=="help")
	 	 {
	 	 		$view_data=array();
    $this->load->view('chat/help', $view_data);
	 	 }else{
	 	 
	 	  echo "<h1>该功能未启用</h1>";
	   }
	}
	
	    /**
     * 参数设置
     * 可以同时修改多个：key=a,b,c&value=1,2,3
     */
    public function set(){
        $file = $this->config->item('data_path').'/config.php';	
    
        $key   =  $this->input->get('k');
        $value =  $this->input->get('v');
        if ($key !='' && $value != '') {
        	
      $sql=new FileCache();
			$sql->setFileName($file);
			$conf = $sql->get();

            $arr_k = explode(',', $key);
            $arr_v = explode(',',$value);
            $num = count($arr_k);

            for ($i=0; $i < $num; $i++) { 
                $conf[$arr_k[$i]] = $arr_v[$i];
            }
            $sql->reset($conf);
            show_json("设置成功");
        }else{
            show_json("设置失败",false);
        }
    }
	
	
	


	
	
}

