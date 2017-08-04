<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

  public function __construct() {
        parent::__construct();
        $this->output->enable_profiler(TRUE);
          //error_reporting(0);  
         
       //$this->load->model('netbot_mdl');
       //$this->load->helper("netbot");   
    }
    
 	public function index()
	{
		    	header("Content-Type:text/html; charset=utf-8");
      echo "==即时队列状态改变==<br>";
      $this->cron1();
       echo "<br>==激活状态状态改变==<br>";
      $this->cron2();
       echo "<br>==主机状态改变==<br>";
      $this->cron3();
      
       	 $this->load->view('welcome_message');
	}
	
	
	
   //计划任务状态改变
   
   //即时队列状态改变
    public function cron1() {
    	//strtotime("+1 week 2 days 4 hours 2 seconds")
   $thistime = date('Y-m-d H:i:s',strtotime("-300 seconds"));
   $sql="update  tasklist_chat set tl_stauts=3  where tl_stauts=0 and tl_addtime<'".$thistime."' ";
   $this->db->query($sql);
   
   echo $sql;
 
   
    }
    
      //激活状态状态改变
    public function cron2() {
    	//strtotime("+1 week 2 days 4 hours 2 seconds")
   $thistime = date('Y-m-d H:i:s',strtotime("-300 seconds"));
   $sql="delete from  chatlist  where  lasttime<'".$thistime."' ";
   $this->db->query($sql);
   
   echo $sql;
   
   
    }
    
   
   //主机状态改变 
   
    public function cron3() {
    	//strtotime("+1 week 2 days 4 hours 2 seconds")
   $thistime = date('Y-m-d H:i:s',strtotime("-600 seconds"));
   $sql="update  netbot set nb_stauts=0  where nb_stauts<3  and nb_lasttime<'".$thistime."' ";
   $this->db->query($sql);
   
   echo $sql;
  
    }
   
   
   //转移数据
   
   

 

}

