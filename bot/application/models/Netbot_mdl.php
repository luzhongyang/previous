<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');
class Netbot_mdl extends CI_Model {
    public $_config = array();
    public function __construct() {
        parent::__construct();
      
        
    }
     
    public function add($data) {
        if ($this->db->insert("netbot", $data)) {
            return true;
        } else {
            return false;
        }
    }
  
    public function info($nb_guid) {
        $this->db->select('*')->from("netbot")->where(array(
            "nb_guid" => $nb_guid
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
             $data = $query->row_array();
            return $data;
        } else {
            return false;
        }
    }
    
    
    
   public function infoid($id) {
        $this->db->select('*')->from("netbot")->where(array(
            "nb_id" => $id
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
             $data = $query->row_array();
            return $data;
        } else {
            return false;
        }
    }
    
    public function update($nb_guid, $data) {
        $this->db->where('nb_guid', $nb_guid);
        if ($this->db->update("netbot", $data)) {
        	
        	
        	
            return true;
        } else {
            return false;
        }
    }
    
      public function mc_info($nb_guid,$mc_time=6000) {
      	$netbot = $this->cache->get($nb_guid);
      	if (empty($netbot)) {
        $this->db->select('*')->from("netbot")->where(array(
            "nb_guid" => $nb_guid
        ))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
             $data = $query->row_array();
              $this->cache->save($nb_guid, $data, $mc_time);
            return $data;
        } else {
            return false;
        }
      }else{
      
      return $netbot;
    }
    
    }
    
     public function mc_update($nb_guid, $data,$mc_time=6000) {
        $this->db->where('nb_guid', $nb_guid);
        if ($this->db->update("netbot", $data)) {
        	
        	 $netbot = $this->info($nb_guid);
        	 $this->cache->save($nb_guid, $netbot, $mc_time);
        	
            return true;
        } else {
            return false;
        }
    }
 
    public function getlist($nb_group=0) {
        $data = array();
        $sql="SELECT * FROM netbot";
        if(!empty($nb_group)) $sql .=" where nb_group=".$nb_group." ";
        $sql .=" order by nb_lasttime desc";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
 
   public function del($nb_guid) {
    	  $sql="delete from  netbot  where  nb_guid=".$nb_guid;
    
      if ( $this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
   } 
   
   	public function tl_send($tl_netbot,$tl_function,$tl_vars,$tl_type="chat",$wait=1){

     	//创建任务
  $app = $this->db->query("SELECT * FROM app where app_fun='" . $tl_function . "'  limit 1")->row_array(); 

	$task_vars=json_encode($tl_vars,JSON_UNESCAPED_UNICODE);
	
	$tl=array();
	$tl['tl_netbot']=$tl_netbot;
	$tl['tl_taskid']=0;
	$tl['tl_addtime']=date("Y-m-d H:i:s");
	$tl['tl_stauts']=0;
	$tl['tl_isback']=1;	
	$tl['tl_backfun']=$app['app_backfun'];
	$tl['tl_app']=$app['app_type'];
	$tl['tl_function']=$app['app_fun'];
	$tl['tl_plug_url']=$app['app_plugurl'];
	$tl['tl_plug_md5']=$app['app_plugmd5'];
	
	
		$tl['tl_vars']=$task_vars;
	$tl['tl_type']=$tl_type;
	$tl['username']=$this->user;
	$this->db->insert("tasklist_".$tl_type, $tl);
	$tl['tl_id']=$this->db->insert_id();

	//$td=array();
	//$td['tl_vars']=$task_vars;
	//$td['id']=$tl['tl_id'];

	//$this->db->insert("taskdata_".$tl_type, $td);	
		
		
	if($tl_type=="chat")
	{
		 $this->cache->save("chat".$tl_netbot,1,100);
	}else{
		$mc_up=array();
	$mc_up['nb_task_new']=1;
	$this->mc_update($tl_netbot,$mc_up);

	}
	
		

   if(!$wait) return $tl['tl_id'];
  $path_hash=md5($tl['tl_id']); 
  $file_path=$this->config->item('tasktmp_path')."/".$tl_type.'/'.$path_hash .'.txt';        
  $task_data=$this->wait_task_result($file_path);

	     if($task_data){
	     return json_decode($task_data,true);	 	          	      	   
	     }else{
	     return false;	   
	     }

	}
   
   
   private function wait_task_result($file){

 	 $task_data ="";
	 $i=0; 
	 while ($i<40) // check if the data file has been modified 
{ 
  usleep(500000); // sleep 10ms to unload the CPU 
  if(file_exists($file))
  {	
  	$task_data = read_file($file);
  	//unlink($file);
  	return $task_data; 	
  }
 
  $i++;  
} 	

		return false;


	 }
	   
   
}

