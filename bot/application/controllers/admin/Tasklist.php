<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasklist extends Admin_Controller {

  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
         
      $this->load->model('tasklist_mdl');
        $this->load->helper("netbot");   
    }
    
	public function index()
	{

	}
	
		public function cron()
	{
		$this->load->model('app_mdl');
    $app = $this->app_mdl->getlist();
    $taskid = $this->uri->segment(4);
        $page = array();
        $page['menu1'] = "data";
        $page['menu2'] = "datacron";
        $page['title'] = "主机管理";
        $page['nav1'] = "数据管理";
        $page['nav2'] = "计划任务队列";	
    
    
    $view_data= array();
    $view_data['tasktype']="cron";
     $view_data['app']= $app;
      $view_data['page']= $page;
      if(empty($taskid))
      {
      	 $view_data['taskid']= "";
      }else{
      	 $view_data['taskid']= $taskid;
      }
     
     
     
		$this->load->view('admin/tasklist', $view_data);


	}
	
		public function chat()
	{
  		$this->load->model('app_mdl');
    $app = $this->app_mdl->getlist();
     $page = array();
        $page['menu1'] = "data";
        $page['menu2'] = "datacron";
        $page['title'] = "即时任务队列";
        $page['nav1'] = "数据管理";
        $page['nav2'] = "即时任务队列";	
    
    
    $view_data= array();
    $view_data['tasktype']="chat";
     $view_data['app']= $app;
      $view_data['page']= $page;
      $view_data['taskid']= "";
		$this->load->view('admin/tasklist', $view_data);


	}
	
	

	
		public function getlist()
	{
	 $tasktype = $this->uri->segment(4);

	 $table="tasklist_cron";
	 if($tasktype=="chat"){
	 	 $table="tasklist_chat";
	 }

	 $post=$this->input->post();

	$customActionType="";
	if(isset($post['customActionType']))
	{
		$customActionType=$post['customActionType'];
		if($customActionType=="group_action")
	{
	$customActionName=$post['customActionName'];
	$id=$post['id'];	
	//操作
	
	
	
	}
		
	}
	

	$action="";
	if(isset($post['action']))
	{
	$action=$post['action'];
  }
  
	$filter="";
	if($this->user_role!="administrator"){ 	 	
	 	  if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" username='".$this->user."' ";	 	
	}
	
	   if(!empty($post['tl_taskid']))
    {
     if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" tl_taskid='".$post['tl_taskid']."' ";
	  }
	
	
	if($action=="filter")
	{
    if(!empty($post['tl_netbot']))
    {
     if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" tl_netbot='".$post['tl_netbot']."' ";
	  }
	  
	
	  
	     if(!empty($post['tl_function']))
    {
     if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" tl_function='".$post['tl_function']."' ";
	  }
	  
	   if($post['tl_stauts']!="")
    {
     if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" tl_stauts='".$post['tl_stauts']."' ";
	  }
	  
	  
	 
	   if(!empty($post['tl_addtime_from']))
    {
     if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" tl_addtime>'".$post['tl_addtime_from']."' ";
	  }
	  
	  if(!empty($post['tl_addtime_to']))
    {
     if($filter==""){$filter .=" where ";}else{$filter .=" and ";}
		 $filter .=" tl_addtime<'".$post['tl_addtime_to']."' ";
	  }
	  
 
	}
	
	//print_r($_POST);
	//exit;
	
  $column=$post['order'][0]['column'];
  $dir=$post['order'][0]['dir'];
  
  $start=$post['start'];
  $length=$post['length'];
  
  
  $order="";
  
  switch ($column) 
  { 	
  	case 1: 
  	$order="tl_id";
  	break; 
  	

  	
  	case 2: 
  	$order="tl_netbot";
  	break; 	
  	
  	  	case 3: 
  	$order="tl_taskid";
  	break; 	
  	
  	case 4: 
  	$order="tl_function";
  	break; 	
  	
  	case 5: 
  	$order="tl_vars";
  	break; 	
  	
  	case 6: 
  	$order="tl_backfun";
  	break; 	
  	
  		case 7: 
  	$order="tl_addtime";
  	break; 	
  
  		case 8: 
  	$order="tl_finishtime";
  	break; 	
  	
  			case 9: 
  	$order="tl_stauts";
  	break; 	
  
  	default: 		  
  	// default actions 
  }
  
		
	 $sql="SELECT * FROM ".$table." ".$filter;
	 $sql2="SELECT count(*) as mcnt FROM  ".$table." ".$filter;	 
	 $sql .=" order by ".$order." ".$dir;
	 $sql .=" limit ".$start.",".$length;	 
	 $query = $this->db->query($sql);
	 $netbots = $query->result_array();
	 
	$mcnt=$this->db->query($sql2)->row()->mcnt;
	

	$iTotalRecords = $mcnt;
  $iDisplayLength = intval($_REQUEST['length']);
  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
  $iDisplayStart = intval($_REQUEST['start']);
  $sEcho = intval($_REQUEST['draw']);
  
  $records = array();
  $records["data"] = array(); 

  $end = $iDisplayStart + $iDisplayLength;
  $end = $end > $iTotalRecords ? $iTotalRecords : $end;

  $status_list = array(
    array("info" => "已创建"),
    array("success" => "已发送"),
    array("danger" => "已完成"),
    array("warning" => "已取消")
  );


foreach ($netbots as $value) {
 	 $status = $status_list[$value['tl_stauts']];

 	 $id = $value['tl_id'];
 	 $guid = $value['tl_netbot'];
 
 $ss= '<span class="label label-sm label-'.(key($status)).'">'.(current($status)).'</span>';
 $set="";
 
 

 if($value['tl_stauts']==0){
  $set .="<a href=\"javascript:cancel('".$value['tl_id']."','".$value['tl_type']."')\" class=\"btn btn-xs red\"><i class=\"fa  fa-sign-out\"></i>撤回</a>";
   
}
if($value['tl_stauts']==2){
	

  $set .="<a href=\"/admin/tasklist/getdata/".$value['tl_id']."/".$value['tl_type']."\" class=\"btn btn-xs blue\" data-target=\"#info\" data-toggle=\"modal\"><i class=\"fa fa-database\"></i> data</a>"; 


if(!empty($value['tl_filename'])){
	$downloadurl=$this->config->item('mydownload_url')."/".$guid."/".$value['tl_filename'];
  $set .="<a href=\"".$downloadurl."\" class=\"btn btn-xs blue\" target=\"_blank\" title=\"".$value['tl_oldpath']."\"><i class=\"fa fa-cloud-download\"></i> file</a>"; 
} 
}


 if(empty($value['tl_vars']) || $value['tl_vars']=="[]"){
$vars="无";
   
}else {
 	
 	  $vars ="<a href=\"/admin/tasklist/getvars/".$value['tl_id']."/".$value['tl_type']."\" class=\"btn btn-xs \" data-target=\"#info\" data-toggle=\"modal\"><i class=\"fa fa-file-text\"></i></a>";

}


 	  $records["data"][] = array(
      '<input type="checkbox" name="id[]" value="'.$id.'">',
      $id,
       $guid,
       $value['tl_taskid'],
      $value['tl_function'],
       $vars,
     $value['tl_backfun'],
      $value['tl_addtime'],
      $value['tl_finishtime'],
      $ss,
     $set,
   );
 	
 	
} 




  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
    $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
    $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
  }

  $records["draw"] = $sEcho;
  $records["recordsTotal"] = $iTotalRecords;
  $records["recordsFiltered"] = $iTotalRecords;
  
  echo json_encode($records);
	
  }
	
			public function getlistbyguid()
	{	 
   $tasktype = $this->uri->segment(4);
   $guid = $this->uri->segment(5);
   
	 $table="tasklist_cron";
	 if($tasktype=="chat"){
	 	 $table="tasklist_chat";
	 }

	 $filter ="where tl_netbot='".$guid."' ";
	 $sql="SELECT * FROM ".$table." ".$filter;
	 $query = $this->db->query($sql);
	 $netbots = $query->result_array();
	 
  $records = array();
  $records["data"] = array(); 

  $status_list = array(
    array("info" => "已创建"),
    array("success" => "已发送"),
    array("danger" => "已完成"),
    array("warning" => "已取消")
  );


foreach ($netbots as $value) {
 	 $status = $status_list[$value['tl_stauts']];

 	 $id = $value['tl_id'];
 	 $guid = $value['tl_netbot'];
 
 $ss= '<span class="label label-sm label-'.(key($status)).'">'.(current($status)).'</span>';
 $set="";
 
 

 if($value['tl_stauts']==0){
  $set .="<a href=\"javascript:cancel('".$value['tl_id']."','".$value['tl_type']."')\" class=\"btn btn-xs red\"><i class=\"fa  fa-sign-out\"></i>撤回</a>";
   
}
if($value['tl_stauts']==2){
	

  $set .="<a href=\"/admin/tasklist/getdata/".$value['tl_id']."/".$value['tl_type']."\" class=\"btn btn-xs blue\" data-target=\"#info\" data-toggle=\"modal\"><i class=\"fa fa-database\"></i> data</a>"; 


if(!empty($value['tl_filename'])){
	$downloadurl=$this->config->item('mydownload_url')."/".$guid."/".$value['tl_filename'];
  $set .="<a href=\"".$downloadurl."\" class=\"btn btn-xs blue\" target=\"_blank\" title=\"".$value['tl_oldpath']."\"><i class=\"fa fa-cloud-download\"></i> file</a>"; 
} 
}


 if(empty($value['tl_vars']) || $value['tl_vars']=="[]"){
$vars="无";
   
}else {
 	
 	  $vars ="<a href=\"/admin/tasklist/getvars/".$value['tl_id']."/".$value['tl_type']."\" class=\"btn btn-xs \" data-target=\"#info\" data-toggle=\"modal\"><i class=\"fa fa-file-text\"></i></a>";

}


 	  $records["data"][] = array(
      '<input type="checkbox" name="id[]"  class="checkboxes" value="'.$id.'">',
      $id,
       $guid,
       $value['tl_taskid'],
      $value['tl_function'],
       $vars,
     $value['tl_backfun'],
      $value['tl_addtime'],
      $value['tl_finishtime'],
      $ss,
     $set,
   );
 	
 	
} 

  echo json_encode($records);	
  }
	
	
	
	public function getvars()
	{
		$id = $this->uri->segment(4);
		 $type = $this->uri->segment(5);
		 $tasklist=$this->tasklist_mdl->info_view($id,$type);
		 $view_data= array();
		 $view_data['title']=$id."-任务参数";
		 $view_data['info']=$tasklist['tl_vars'];
		$this->load->view('admin/info', $view_data);
	}
	
		public function getdata()
	{
		 $id = $this->uri->segment(4);
		 $type = $this->uri->segment(5);
		 
		 $tl_data=$this->db->query("select tl_data from taskdata_".$type."  where id=".$id."  limit 1")->row()->tl_data;
	
		 	 $view_data= array();
		 $view_data['title']=$id."-任务结果";
		 $view_data['info']=$tl_data;
		$this->load->view('admin/info', $view_data);
	}
			public function cancel(){
				$id=intval($this->input->post('id'));
				$type=$this->input->post('type');
				 $result=array();
		if(empty($id))
    {  
    $result['result']=0;
    $result['msg']="该ID非法！";
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
    exit;		
    }	
   $this->db->query("update tasklist_".$type." set tl_stauts=3  where tl_id='" . $id."' and tl_stauts=0");  	    										  
$result['result']=1;
$result['msg']="操作成功";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;		
		    							
		}
	
			
}

