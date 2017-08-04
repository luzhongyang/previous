<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends Admin_Controller {

  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
       if($this->user_role!="administrator"){
       	echo "你没有该项权限！";
       	exit;
      } 
       $this->load->model('group_mdl');
    }
    
	public function index()
	{
		     $page = array();
        $page['menu1'] = "system";
        $page['menu2'] = "group";
        $page['title'] = "分组管理";
        $page['nav1'] = "系统设置";
        $page['nav2'] = "分组管理";	
	

    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/group', $view_data);


	}
	
	
		public function getlist(){
			
	
	  $list=$this->group_mdl->getlist();
	  $grouptype=array(
	         "main" => "主分组",
	         "expand" => "扩展分组"
	        );
	
		$records = array();
    $records["aaData"] = array();  
			
			
			
		 foreach ($list as $value) {	
		  $set="";	
		  $set .="<a href=\"javascript:group_del('".$value['ng_id']."','".$value['ng_name']."')\" class=\"btn btn-xs red\">删除</a>";
		  $set .="<a href=\"javascript:setname('".$value['ng_id']."','".$value['ng_name']."')\" class=\"btn btn-xs green\">改名</a>";
		  
		  if($value['ng_type']=="expand"){
		  	  $set .="<a href=\"javascript:group_set('".$value['ng_id']."','".$value['ng_name']."')\" class=\"btn btn-xs blue\">管理</a>";
		  }
   	 	
		  $id="<input type=\"checkbox\"  name=\"id[]\"  class=\"checkboxes\"  value=\"".$value['ng_id']."\"/>";			 			 	
	   $records["aaData"][] = array(
	     	$id,
	     	$value['ng_id'],
	      $value["ng_name"],
        $grouptype[$value["ng_type"]],          
        $set
      );
     
   } 
    	
	 echo json_encode($records, JSON_UNESCAPED_UNICODE);
	exit;
	
	
}

	public function setname(){
				$id=$this->input->post('id');					
				$name	=$this->input->post('name');
				$result=array();		  	     
       if(empty($id) || empty($name))
       {
    
       	      $result['result'] = 0;
            $result['msg'] = "值不能为空！";
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;	       	
       }     
        if ($this->group_mdl->check($name)) {
  
        $result['result'] = 0;
            $result['msg'] = "名称已存在！";
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;	 
        }
       
       
      //更新用户和TASK 组名称 
      
      
        //更新用户和TASK 组名称 
       
      $data=array();
      $data['ng_name']=$name;    
      $this->group_mdl->update($id,$data);            
     	      $result['result'] = 1;
            $result['msg'] = "修改成功";
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;	 
		    							
		}
	

		public function getexpandlist(){
		$group_id = $this->uri->segment(4);

	  $this->load->model('groupexpand_mdl');
	  $list=$this->groupexpand_mdl->getlist($group_id);

		$records = array();
    $records["aaData"] = array();  
			if(empty($group_id))
			{
				 echo json_encode($records, JSON_UNESCAPED_UNICODE);
	exit;
			}

		 foreach ($list as $value) {	
		  $set="";	
		  $set .="&nbsp;&nbsp;<a href=\"javascript:groupexpand_del('".$value['nge_id']."','".$value['nb_guid']."')\" class=\"btn blue\">移除</a>";
   	 	
		  $id="<input type=\"checkbox\"  name=\"id[]\"  class=\"checkboxes\"  value=\"".$value['nge_id']."\"/>";			 			 	
	   $records["aaData"][] = array(
	     	$id,
	      $value["nb_guid"],
	      $value["nb_name"],          
        $set
      );
     
   } 
    	
	 echo json_encode($records, JSON_UNESCAPED_UNICODE);
	exit;
	
	
}
	
	public function add()
	{			
		$ng_name=$this->input->post('ng_name');
		$ng_type=$this->input->post('ng_type');
				
		$result=array();
		 if ($this->group_mdl->check($ng_name)) {
        
$result['result']=0;
$result['msg']="组名已存在"; 			
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;
        }
			
		$data=array();
		$data['ng_name']=$ng_name;
		$data['ng_type']=$ng_type;
		
		 if ($this->group_mdl->add($data)) {
            $data['result'] = 1;
            $data['msg'] = "添加成功";
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $data['result'] = 0;
            $data['msg'] = "数据处理出错";
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
		
		
	}
	
			public function del()
	{
		
	  $id = $this->uri->segment(4);
	  
	  if($id==1)
	  {
	$result['result']=0;
	$result['msg']="默认分组不能删除！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;		
	  }
	  
	 	  $result['result']=0;
			$result['msg']="暂不允许删除分组！";
	    echo json_encode($result, JSON_UNESCAPED_UNICODE);
	    exit;	 
	  
	  
	 //删除主分组
	 
	   //设置分组为默认分组
	   
	   
	   //从用户权限中删除分组
	 
	 
	 
  //删除扩展分组 
	  
	  
	  
		$this->group_mdl->del($id);	
			  $result['result']=1;
			$result['msg']="删除成功！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;	
		
	}
	
			public function expanddel()
	{
		
	  $id = $this->uri->segment(4);
	  $this->load->model('groupexpand_mdl');
		$this->groupexpand_mdl->del($id);	
			  $result['result']=1;
			$result['msg']="删除成功！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;	
		
	}
	
			
}

