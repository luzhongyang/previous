<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Admin_Controller {
 public function __construct() {
        parent::__construct();
       //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
       //$this->load->helper("netbot");   
       //$this->load->model('task_mdl');
    } 
    
	public function index()
	{		
        $page = array();
        $page['menu1'] = "main";
        $page['menu2'] = "main";
        $page['title'] = "我的首页";
        $page['nav1'] = "控制中心";
        $page['nav2'] = "我的首页";	
	
    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/test', $view_data);
 
      

	}
	
public function cleanall(){
	$this->task_cron();
	$this->task_chat();
	$this->chatlist();
	$this->task_files();
	$this->path();
	$this->tmp();
	$this->upload();
	$this->download();
	$this->memcache();

	
}

public function task_cron(){
	$sql="TRUNCATE TABLE taskdata_cron";
   $this->db->query($sql);
 $sql="TRUNCATE TABLE tasklist_cron";
   $this->db->query($sql);
   echo "<br>==task_cron clean==<br>";
   echo $sql;		
}

public function task_chat(){
	 $sql="TRUNCATE TABLE taskdata_chat";
   $this->db->query($sql);
	 $sql="TRUNCATE TABLE tasklist_chat";
   $this->db->query($sql);
   echo "<br>==task_chat clean==<br>";
   echo $sql;	
}

public function task(){
	 $sql="TRUNCATE TABLE task";
   $this->db->query($sql);
   echo "<br>==task clean==<br>";
   echo $sql;	
}

public function chatlist(){
	 $sql="TRUNCATE TABLE chatlist";
   $this->db->query($sql);
   echo "<br>==chatlist clean==<br>";
   echo $sql;	
}

public function netbot(){
	 $sql="TRUNCATE TABLE netbot";
   $this->db->query($sql);
   
   $sql2="TRUNCATE TABLE netbot_group_expand";
   $this->db->query($sql2);
   echo "<br>==chatlist netbot_group_expand clean==<br>";
   echo $sql."|".$sql2;	
}


public function task_files(){
	 $sql="TRUNCATE TABLE task_files";
   $this->db->query($sql);
   echo "<br>==task_files clean==<br>";
   echo $sql;	
}

public function path(){
   $path="D:/shifan/trunk/wwwroot/taskdata/pathlist";
   $this->rmdirs($path);
    $this->deletedirs($path);
   echo "<br>==path clean==<br>";
}

public function tmp(){
	 $path="D:/shifan/trunk/wwwroot/taskdata/tmp";
   $this->rmdirs($path);

   echo "<br>==tmp clean==<br>";
}

public function upload(){
	 $path="D:/shifan/trunk/wwwroot/taskdata/upload";
   $this->rmdirs($path);

   echo "<br>==upload clean==<br>";
}


public function download(){
	 $path="D:/shifan/trunk/wwwroot/taskdata/download";
   $this->rmdirs($path);

   echo "<br>==download clean==<br>";
}


 public function rmdirs($dir){
       
        $dir_arr = scandir($dir);
        foreach($dir_arr as $key=>$val){
            if($val == '.' || $val == '..'){}
            else {
                if(is_dir($dir.'/'.$val))    
                {                            
                    if(@$this->rmdirs($dir.'/'.$val) == 'true'){}    //去掉@您看看                
                    else
                    $this->rmdirs($dir.'/'.$val);                    
                }
                else                
                unlink($dir.'/'.$val);
            }
        }
        return true;
    }    

 public function deletedirs($dir){
       
        $dir_arr = scandir($dir);
        foreach($dir_arr as $key=>$val){
            if($val == '.' || $val == '..'){}
            else {                                                     
                  rmdir($dir.'/'.$val);                                
            }
        }
        return true;
    } 




	public function memcache(){
   $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
   $this->cache->clean();
    echo "<br>==memcache clean==<br>";
 }

 	public function cron()
	{
		  header("Content-Type:text/html; charset=utf-8");
      echo "==即时队列状态改变==<br>";
      $this->cron1();
       echo "<br>==激活状态状态改变==<br>";
      $this->cron2();
       echo "<br>==主机状态改变==<br>";
      $this->cron3();
      
     // $this->load->view('blank');
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
   



}

