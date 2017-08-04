<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends Admin_Controller {

	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
         $this->load->helper("netbot");   
       $this->load->model('task_mdl');
    } 
	 
	 
	public function index()
	{
		
	     $page = array();
        $page['menu1'] = "main";
        $page['menu2'] = "task";
        $page['title'] = "计划任务管理";
        $page['nav1'] = "控制中心";
        $page['nav2'] = "计划任务管理";	
	
		
    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/task', $view_data);

	}
	
	public function edit(){
    $id = intval($this->uri->segment(4));
    $own = $this->uri->segment(5);
    $error=array();
    
  
    $task=array();
     $task['t_id']=0;
     $task['t_name']="";
     $task['t_inf']="";
     $task['t_stauts']=0;
     $task['t_starttime']=date('Y-m-d');
         
     $task['t_addtime']=date('Y-m-d');
     $task['t_endtime']=date('Y-m-d',strtotime("+8 week"));
     $task['t_group']="";   
       if(!empty($own)){    

      	 $task['t_group']=$own;   
      }else{
      	 $task['t_group']="";   
      }
        
     $task['t_interval']="";
     $task['t_hour']="";
     $task['t_os_type']=0;
     $task['t_os']="";
     $task['t_cpu']="";
     $task['t_mem']="";
     $task['t_area']="";
     $task['t_hash']="";
     $task['t_finish_num']=0;
     $task['t_netbot']=2;
     
     $task['t_area_type']=0;
     $task['t_area']="";
    
     $task['t_url_type']=0;
     $task['t_url']="";
    
     $task['t_repeat']=0;
     $task['t_isback']=1;
     $task['t_backfun']="";
     $task['t_app']="";
     $task['t_function']="";
     $task['t_vars']="";
     $task['title']="添加一个计划任务";   
    if($id){
    $task=$this->task_mdl->info_view($id);	
    $task['title']="编辑【".$task['t_name']."】";
    
      if($this->user_role!="administrator")
	{
		
		if($task['username']!=$this->user)
		{		
		  $error['msg'] ="您没有该主机权限！"; 	
      goto endedit;
    }
  }
     
    
    
    }
    
    $this->load->model('app_mdl');
    $app = $this->app_mdl->getlist();
   
   	$this->config->load('area', TRUE);
    $netbot_area  = $this->config->item('netbot_area','area'); 	
    
    $this->config->load('os', TRUE);
    $netbot_os  = $this->config->item('netbot_os','os'); 	
    $this->load->model('Selectdb_mdl');
    $node = $this->Selectdb_mdl->node();
    

		$view_data= array();
		$view_data['task']=$task;
		$view_data['app']=$app;
		$view_data['netbot_area']=$netbot_area;
		$view_data['netbot_os']=$netbot_os;
			$view_data['netbot_url']=$node;
		$view_data['id']=$id;
		  if(!empty($own)){    
      	$view_data['own']=$task['t_group'];
      }else{
      	 $view_data['own']="";
      }
     
   endedit:   
	 if(!empty($error)){
    $this->load->view('admin/error', $error);
  }else{
		$this->load->view('admin/task_edit', $view_data);
	}
	
	}
		public function botsearch(){
		$q=$this->input->get('q');
		$page_limit=$this->input->get('page_limit');
		$page=$this->input->get('page');

			
		$netbot = $this->db->query("SELECT * FROM netbot where nb_guid like '%".$q."%' or  nb_name  like '%".$q."%' ")->result_array(); 	
		 $result=array();
		 $result['items']=array(); 
		foreach ($netbot as $value) { 	 
		$data=array();
	  $data['id']=$value['nb_guid'];
	  $data['text']=$value['nb_guid']."[".$value['nb_name']."]"; 
		$result['items'][]=$data; 	 
		 	 
		} 
  
	  $result['total']=10;

	
	 ECHO  json_encode($result,JSON_UNESCAPED_UNICODE);
   }
	
	public function getgroup(){
    $id=$_POST['id'];
    $t_netbot=$_POST['t_netbot'];
    $this->load->model('group_mdl');

		
		    if($this->user_role!="administrator"){ 
     	 $group_list=$this->group_mdl->getlist_user($this->user);
    }else{
    	 $group_list=$this->group_mdl->getlist();
    }
		
   
    $task_group ="";
    
    if($id){
    $task = $this->db->query("SELECT * FROM task where t_id=" . $id . "  limit 1")->row_array();     
       if($t_netbot==$task['t_netbot']){
        $task_group=$task['t_group'];
      }
    }
   
  $html=""; 
  
  if($t_netbot==1){
  $html .="<select name=\"t_group[]\" id=\"t_group\" multiple class=\"form-control select2me\" >";
   if(!empty($task_group)) 
 {
 	$task_group=json_decode($task_group,true);
}else{
	$task_group=array();
}
   
   foreach($group_list as $value) {
   	
		if(in_array($value['ng_id'],$task_group)) {
			$selected="selected";
		}else{
			$selected="";
		}

			$html .="<option value=\"".$value['ng_id']."\"  ".$selected." >[".$value['ng_type']."]".$value['ng_name']."</option>";
		}
			$html .="</select><script> ss1();</script>";
		}elseif($t_netbot==2){

			$html .="<input type=\"hidden\" id=\"t_group\" name=\"t_group\"    value=\"".$task_group."\" class=\"form-control select2\"><script> ss2();</script>";



		}else{
			$html .="影响所有主机!<input type=\"hidden\" id=\"t_group\" name=\"t_group\" value=\"\">";	
			$html .="</select><script> ss1();</script>";
		} 



		echo $html;
		exit;
   
		
	}
	
	public function getvars(){
    $html=""; 
    $rowCount=0;
    $t_function=$_POST['t_function'];
    $id=$_POST['id'];
    $app = $this->db->query("SELECT * FROM app where app_fun='" . $t_function . "'  limit 1")->row_array(); 
    
    if($id){
    $task = $this->db->query("SELECT * FROM task where t_id=" . $id . "  limit 1")->row_array();    
    }
 
    //权限判断
 
 
     //权限判断
        
    if(empty($app['app_vars'])){  
    	
    	if($id && $t_function==$task['t_function']){
    	 $t_vars=$task['t_vars'];
    	}else{
    		$t_vars="";
    	}
    	
     $html .="<tr><td  colspan=\"2\"><input type=\"text\"  class=\"form-control\" value=\"".$t_vars."\" name=\"onevars\"></td></tr>";
   
     
         
    }else{
    
    if($id && $t_function==$task['t_function']){
    	 	 $t_vars=json_decode($task['t_vars'], true);
    }else{
     	 $t_vars="";
    }
     
    
    $app_vars=json_decode($app['app_vars'],TRUE);
    $app_vars=$app_vars['data'];
 
    
      foreach($app_vars as $val) {
         $input_str="";
         switch ($val['formtype']) { 
      		case "select":
      		 		
      		 			$input_str="<select name=\"task_cs[".$val['formname']."]\"   class=\"form-control\">";

	
	 foreach ($val['formdata'] as $dkey=>$dval) 	  
	 {
	  if(!empty($t_vars) && $dkey==@$t_vars[$val['formname']]) 
	  {
	   $selected="selected";
	  }else{
	  $selected="";
	  }
	 
	 	$input_str=$input_str."<option value=\"".$dkey."\"  ".$selected.">".$dval."</option>";
	 	
	 }
		$input_str=$input_str."</select>";
      		 		
      		 		  
      		 	break;
      		 	
      		case "selectdb":
      		 	  $this->load->model('Selectdb_mdl');
      		 	  $formdata=array();
      		 	  $formdata=$this->Selectdb_mdl->$val['formdata']();		
      		 $input_str="<select name=\"task_cs[".$val['formname']."]\"   class=\"form-control\">";
		 $input_str .="<option value=\"\">Select...</option>";
	
	 foreach ($formdata as $dkey=>$dval) 	  
	 {
	  if(!empty($t_vars) && $dkey==@$t_vars[$val['formname']]) 
	  {
	   $selected="selected";
	  }else{
	  $selected="";
	  }
	 
	 	$input_str=$input_str."<option value=\"".$dkey."\"  ".$selected.">".$dval."</option>";
	 	
	 }
		$input_str=$input_str."</select>";
      		 		
      		 		  
      		 	break;	 	
      		 	
      		 	
      		case "textarea":
      		if(empty($id)){
      		$t_vars_val=$val['formdata'];	
      		}else{	
      		  if(!empty($t_vars)){
      		  	$t_vars_val=@$t_vars[$val['formname']];
      		  }else{
      		  	$t_vars_val="";
      		  }
      		}
      		 	$input_str="<textarea name=\"task_cs[".$val['formname']."]\"  class=\"form-control\">".$t_vars_val."</textarea>";	
      		 	     		 		  
      		 	break; 	
      		 	
      		case "pathlist":
      		$rowCount=1;	
      		$input_str="<table class=\"table table-striped table-bordered table-hover\" id=\"pathlist\"><thead><tr><th width=\"70%\">路径</th><th>属性</th><th><a href=\"#\" onclick=\"addRow()\">+</a></th></tr></thead><tbody id=\"optionContainer\">"; 	
      		 	
      		 if(empty($t_vars)){
      		 	
      		 $input_str .="<tr id=\"pathlist1\"><td><input type=\"text\" class=\"form-control\" name=\"task_cs[list][path][]\"></td><td><select class=\"form-control\" name=\"task_cs[list][type][]\"><option value=\"file\">文 件</option><option value=\"folder\">文件夹</option></select></td><td></td></tr>"; 		
      		 	
      		 }else{
      		 	$rowCount=count($t_vars['list']);
      		 	if(empty($rowCount)) $rowCount=1;
      		 	foreach ($t_vars['list'] as $tkey=> $tval) {
      		 	 	$keyid=$tkey+1;
      		 	 	if($tval['type']=="folder"){
      		 	 		$vss1="";
      		 	 		$vss2="selected";
      		 	 	}else{
      		 	 		$vss1="selected";
      		 	 		$vss2="";
      		 	 	}
      		 	
      		 	 	
      		 	 	
      		 	  $input_str .="<tr id=\"pathlist".$keyid."\"><td><input type=\"text\" class=\"form-control\" value=\"".$tval['path']."\" name=\"task_cs[list][path][]\"></td><td><select class=\"form-control\" name=\"task_cs[list][type][]\"><option value=\"file\" ".$vss1.">文 件</option><option value=\"folder\" ".$vss2.">文件夹</option></select></td><td><a href=\"#\" onclick=delRow('".$keyid."')>删</a></td></tr>"; 		
      		 	 	
      		 	} 
      		 	
      		 	
      		}
      		 	
 
      		 	
      		$input_str .="</tbody></table>"; 	 		  
      		 	break; 		
      		 	
      		default: 	
      		if(empty($id)){
      		$t_vars_val=$val['formdata'];	
      		}else{	  
      		  if(!empty($t_vars)){
      		  	$t_vars_val=@$t_vars[$val['formname']];
      		  }else{
      		  	$t_vars_val="";
      		  }
      		}
      		  
      		$input_str="<input name=\"task_cs[".$val['formname']."]\" type=\"text\" class=\"form-control\" value=\"".$t_vars_val."\" >";

      		
      		 }
      
      
      $html .="<tr><td>".@$val['formtitle']."</td><td>".$input_str."</td></tr>"; 
      
    	
      }
    	
    	
    }
    
     $html .="<script>$('#fun_help').html('".$app['app_help']."');</script>";
    
   if(!$id ){
   $html .="<script>$('#t_backfun').val('".$app['app_backfun']."');</script>";
   }
   echo $html;
  
   if($rowCount){
    $view_data= array();
    $view_data['rowCount']=$rowCount;
		$this->load->view('admin/task_vars', $view_data);
	 }else{
	 	exit;
	}
 
   
		
	}
	
	
	
	
	
		public function getlist(){	
			
		$own = $this->uri->segment(4);

			if($this->user_role=="administrator"){ 			
		   $list = $this->task_mdl->getlist($own);	
	   }else{
		  $list = $this->task_mdl->getlist_user($this->user,$own);	
	   }
			
	

		
		$records = array();
    $records["aaData"] = array();  
			
		$task_type=array();
		$task_type[0]="全局";
		$task_type[1]="组";
		$task_type[2]="单机";
			
			
		 foreach ($list as $value) {	
		  $set="";
		  $stauts	="";	
		  if(empty($own)){
		  $set .= "<a class=\" btn btn-xs \" href=\"/admin/task/edit/".$value['t_id']."\" data-target=\"#ajax\" data-toggle=\"modal\" title=\"编辑\"><i class=\"fa  fa-edit\"></i></a>"; 
		 }else{
		   $set .= "<a class=\" btn btn-xs \" href=\"/admin/task/edit/".$value['t_id']."/".$value['t_group']."\" data-target=\"#ajax\" data-toggle=\"modal\" title=\"编辑\"><i class=\"fa  fa-edit\"></i></a>"; 
		
		}
		
		$set .="<a href=\"javascript:del('".$value['t_id']."','".$value['t_name']."')\" class=\"btn btn-xs \"><i class=\"fa  fa-bank\"></i></a>";
		
		 $set .= "<a class=\" btn btn-xs \" href=\"/admin/tasklist/cron/".$value['t_id']."\" target=\"tasklist\" title=\"完成队列\"><i class=\"fa  fa-tasks\"></i></a>"; 
		
      if($value["t_stauts"]==0){	
		   $stauts .= " <a class=\" btn btn-xs default\" href=\"javascript:taskstatus('".$value['t_id']."',1)\">
									<i class=\"fa fa-stop\"></i>停用
											</a>";
									}else{
									   $stauts .= " <a class=\" btn btn-xs blue\" href=\"javascript:taskstatus('".$value['t_id']."',0)\">
									<i class=\"fa fa-play\"></i>启用
											</a>";	
									}
		 	
	
		  $id=$value['t_id'];	

		 
	   $records["aaData"][] = array(
	     	$id,
	      $value["t_name"],
        $value["t_starttime"],
        $value["t_endtime"],
        $task_type[$value["t_netbot"]],
        $value["t_group_name"],
        $value["t_function"],
        $value["t_repeat"],
        $value["t_finish_num"],
        $stauts,    
        $set
      );
     
   } 
    	
	 echo json_encode($records, JSON_UNESCAPED_UNICODE);
	exit;
	
	
}
	
public function editsave(){
	
			
	$post=$this->input->post();	
	$result=array();
	$result['result']=0;
  $result['msg']=""; 		
  
	$id	=	intval($post['id']);
	
	 if($id){
    $taskinfo=$this->task_mdl->info_view($id);
    
    if(empty($taskinfo))
    {
    		$result['msg']="该ID非法！"	; 
        goto end;
    }
    
    	    
    if($this->user_role!="administrator")
	{
		
		if($taskinfo['username']!=$this->user)
		{		
      	$result['msg']="您没有该任务权限！"; 
        goto end;
    }
  }
     
    
    
    }
	
	
	
	$t_hash=$post['t_hash'];
	$t_name	=	$post['t_name'];
	$t_inf=	$post['t_inf'];
	
	
	
	if(empty($t_name))
	{
		$result['msg']="任务名称不能为空！"; 
    goto end;
  }
	
	
	
	$t_function	=	$post['t_function'];
	
	$app = $this->db->query("SELECT * FROM app where app_fun='" . $t_function . "'  limit 1")->row_array(); 
	if(empty($app))
	{
		$result['msg']="指令不存在！"; 
    goto end;
  }

	$t_plug_url	=	$app['app_plugurl'];
	$t_plug_md5	=	$app['app_plugmd5'];
	$t_app=	$app['app_type'];

  
  
	$t_netbot	=	$post['t_netbot'];
	$t_group_name="";
	if($t_netbot<2)
	{
		if($t_netbot==1)
		{
	  if(empty($post['t_group']))
	  {
		 $result['msg']="组不能为空！"; 
     goto end;
    }
    
    $t_g=array();
    
    foreach ($post['t_group'] as $gid) {
     $gname = $this->db->query("SELECT ng_name FROM groups where ng_id=" . $gid . "  limit 1")->row()->ng_name; 		
     $t_group_name .="【".$gname."】";
     $t_g[]=intval($gid); 	
    } 
 
	  $t_group=json_encode($t_g,JSON_UNESCAPED_UNICODE);	
    }else{
 	  $t_group="";
   }
		$t_area_type	=	$post['t_area_type'];
	
	if($t_area_type!=0)
	{
		
			if(empty($post['t_area']))
	{
		$result['msg']="区域值不能为空！"; 
    goto end;
  }	
		
	$t_area=json_encode($post['t_area'],JSON_UNESCAPED_UNICODE);	
	}else{
	$t_area	=	"";	
	}

	$t_os_type	=	$post['t_os_type'];
		if($t_os_type!=0)
	{
		if(empty($post['t_os']))
	{
		$result['msg']="操作系统值不能为空！"; 
    goto end;
  }
	$t_os=json_encode($post['t_os'],JSON_UNESCAPED_UNICODE);	
	}else{
	$t_os	=	"";	
	}
	
		$t_url_type	=	$post['t_url_type'];
		if($t_url_type!=0)
	{
		if(empty($post['t_url']))
	{
		$result['msg']="操作系统值不能为空！"; 
    goto end;
  }
	$t_url=json_encode($post['t_url'],JSON_UNESCAPED_UNICODE);	
	}else{
	$t_url	=	"";	
	}
	
	
	
	
	}else{
		
	  if(empty($post['t_group']))
	  {
		 $result['msg']="主机不能为空！"; 
     goto end;
    }	
	$t_group	=	$post['t_group'];	
	$t_group_name =$post['t_group'];
	$t_area_type=0;
	$t_area	=	"";	
	$t_os_type=0;
	$t_os	=	"";	
	}



	
	
	
	$t_starttime	=	$post['t_starttime'];
	$t_endtime	=	$post['t_endtime'];
	$t_repeat	=	$post['t_repeat'];
	
	if($t_repeat==0)
	{
	$t_interval=0;	
	}else{
		
	if(empty($post['t_interval']))
	{
		$result['msg']="间隔时间不能为空！"; 
    goto end;
  }	
		
	$t_interval	=	intval($post['t_interval']);
	}

	$t_isback	=	$post['t_isback'];
	if($t_isback==0)
	{
	$t_backfun="";	
	}else{
		
		$app_backfun=trim($post['t_backfun']);
		$app_backfun =strtolower($app_backfun);
    $app_backfun = ucfirst($app_backfun);	
	$t_backfun	=	$app_backfun;
	}
	
	if(isset($post['onevars']))
	{
	$task_cs=	$post['onevars'];
	}else{
	$task_cs	=	$post['task_cs'];	
	
	    if(isset($task_cs['list']))
	    {
	    $list=array();
	    foreach ($task_cs['list']['path'] as $key=>$val) 
	    {
	    	if($val){
	     $file=array();	
	     $file['path']=$val;
	     $file['type']=$task_cs['list']['type'][$key];
	     $list[]=	$file; 
	      }    	
	    } 
      $task_cs['list']= $list;
	    }
	    
     	
	$task_cs=	json_encode($task_cs,JSON_UNESCAPED_UNICODE);	
	
	}
  
  $task=array();
  $task['t_hash']=$t_hash;
  $task['t_name']=$t_name;
  $task['t_netbot']=$t_netbot;
  $task['t_group']=$t_group;
  $task['t_group_name']=$t_group_name;
  $task['t_area_type']=$t_area_type;
  $task['t_area']=$t_area;
  $task['t_os_type']=$t_os_type;
  $task['t_os']=$t_os;
  $task['t_function']=$t_function;
  $task['t_starttime']=$t_starttime;
  $task['t_endtime']=$t_endtime;
  $task['t_repeat']=$t_repeat;
  $task['t_interval']=$t_interval;
  $task['t_isback']=$t_isback;
  $task['t_backfun']=$t_backfun;
  $task['t_vars']=$task_cs;
  $task['t_inf']=$t_inf;
  
  $task['t_addtime']=date('Y-m-d H:i:s');
  $task['t_plug_url']=$t_plug_url;
  $task['t_plug_md5']=$t_plug_md5;
  $task['t_app']=$t_app;
   $task['t_stauts']=0;

  if($id){
  $this->task_mdl->update($id,$task);		
  	
  }else{
  $task['username']=$this->user;	
  $this->task_mdl->add($task);		
  }
		
		
$result['result']=1;
$result['msg']="任务保存成功"; 

end:			
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;	
		
		
			
		}
	
	public function taskstatus(){
				$id=intval($this->input->post('id'));
				$status=$this->input->post('status');
				
			  $task=$this->task_mdl->info_view($id);	
				  if(empty($task))
    {
 
        show_json_netbot(NULL,0,'该ID非法！');	
    }	
    	    
    if($this->user_role!="administrator")
	{
		
		if($task['username']!=$this->user)
		{		     
        show_json_netbot(NULL,0,'您没有该任务权限！');	
    }
  }
     
	
				
				if($task['t_stauts']==$status)
				{
				 show_json_netbot(NULL,1,'已改变');	 
			  }
				
				
				$tu=array();
				$tu['t_stauts']=$status;
				$this->task_mdl->update($id,$tu);		
				
				if($status==1)
				{
				//开始清理缓存	
					
			  	if($task['t_netbot']==1){	
					
					 $task_group = json_decode($task['t_group'], true);
					 $main=0;
					 $expand=array();
					foreach ($task_group as $tg) {
						
						 $ng_type = $this->db->query("SELECT ng_type FROM groups where ng_id=" . $tg . "  limit 1")->row()->ng_type;
		         if($ng_type=="main")
		         {
		         	$main=$tg;
		        }else{
		        	$expand[]=$tg;
		        }
 	
					 	
					} 
					 $main_cnt =0;
					if(!empty($main)){									
				  $main_cnt = $this->db->query("SELECT count(*) as cnt FROM netbot where nb_group=" . $main . "  limit 1")->row()->cnt;					  
			   	}	
			   	 $expand_cnt =0;
			   	if(!empty($expand)){			  		  	   		
         $expand_cnt = $this->db->query("SELECT count(distinct nge_netbot_id) as cnt  FROM netbot_group_expand where nge_group_id in (".implode(",", $expand).")  limit 1")->row()->cnt;
         }
					$all_cnt=$expand_cnt+$main_cnt;
						if($all_cnt>10000)
						{
							 $this->cache->clean();		
							 show_json_netbot(NULL,1,'flush');	  
						}
						$ma=array();
					 	if(!empty($main)){		 		
					$main_netbot=$this->db->query("SELECT nb_guid FROM netbot where nb_group=" . $main . " ")->result_array();
					
					$ma=array();
					foreach ($main_netbot as $value) {				 
					 $ma[]=$value['nb_guid'];			 
					} 
					
						}
						$ea=array();
						 	if(!empty($expand)){										
					$expand_netbot = $this->db->query("SELECT distinct nge_netbot_id FROM netbot_group_expand where nge_group_id in (".implode(",", $expand).")  ")->result_array();
				
					foreach ($expand_netbot as $value) {				 
					 $ea[]=$value['nge_netbot_id'];			 
					} 

				}
				
			
				
			
					$netbots = array_merge($ea, $ma);
				
			
				
					foreach ($netbots as $val) {					 	 
	 	        $this->cache->delete($val);					 	 
					} 
					
				}elseif($task['t_netbot']==2)	{
					  $this->cache->delete($task['t_group']);	
				}else{
					 $this->cache->clean();	
				}
					
					
					
					
					
				}	
				
							
        show_json_netbot(NULL,1,'操作成功！');	      	
     
		    							
		}

	
			public function del()
	{
		
	  $id = intval($this->uri->segment(4));
	  $result=array();
	  $result['result']=0;
	  if(empty($id))
	  {
	
	$result['msg']="参数错误！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;		
	  }
	   $taskinfo=$this->task_mdl->info_view($id);
	    	    
    if($this->user_role!="administrator")
	{
		
		if($taskinfo['username']!=$this->user)
		{		
      	$result['msg']="您没有该任务权限！"; 
       	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	      exit;	
    }
  }
	  
	  
	     $this->task_mdl->del($id);	  
			  $result['result']=1;
			$result['msg']="删除成功！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;	
		
	}
			
}

