<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Node extends Admin_Controller {

	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);           
       $this->load->model('node_mdl');
      if($this->user_role!="administrator"){
       	echo "你没有该项权限！";
       	exit;
      }
    } 
	 
	 
	public function index()
	{
			     $page = array();
        $page['menu1'] = "system";
        $page['menu2'] = "node";
        $page['title'] = "节点管理";
        $page['nav1'] = "系统设置";
        $page['nav2'] = "节点管理";	

		
		
    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/node', $view_data);

	}
	
	public function edit(){
    $id = $this->uri->segment(4);
    
     $node=array();
     $node['id']=0;
     $node['url']="";
     $node['name']="";
     $node['inf']="";    
     $node['title']="添加一个节点";   
    if($id){
    $node=$this->node_mdl->info_view($id);	
    $node['title']="编辑【".$node['name']."】";
    }
    
		$view_data= array();
		$view_data['node']=$node;
		$this->load->view('admin/node_edit', $view_data);
		
	}
	
		public function getlist(){			
		$list = $this->node_mdl->getlist();	
		$records = array();
    $records["aaData"] = array();  
			
		 foreach ($list as $value) {	
		  $set="";
		  $status	="";	
		  $set .= "<a class=\" btn btn-xs blue\" href=\"/admin/node/edit/".$value['id']."\" data-target=\"#ajax\" data-toggle=\"modal\"><i class=\"fa  fa-edit\"></i>修改</a>"; 
		 
		 
		 
		 $set .="<a href=\"javascript:del('".$value['id']."','".$value['name']."')\" class=\"btn btn-xs red\"><i class=\"fa  fa-bank\"></i>删除</a>";
		 
      if($value["status"]==1){	
		   $status .= " <a class=\" btn btn-xs blue\" href=\"javascript:setstatus('".$value['id']."',0)\">
									<i class=\"fa fa-play\"></i>启用
											</a>";
									}else{
									   $status .= " <a class=\" btn btn-xs default\" href=\"javascript:setstatus('".$value['id']."',1)\">
									<i class=\"fa fa-stop\"></i>停用
											</a>";	
									}
		 	
	
		  $id="<input type=\"checkbox\"  name=\"id[]\"  class=\"checkboxes\"  value=\"".$value['id']."\"/>";	
		  
		 
	   $records["aaData"][] = array(
	     	$id,
	     	$value['id'],
	      $value["name"],
        $value["url"],
        $value["addtime"],
        $status,    
        $set
      );
     
   } 
    	
	 echo json_encode($records, JSON_UNESCAPED_UNICODE);
	exit;
	
	
}
	
public function editsave(){
				$id=intval($this->input->post('id'));
				$result=array();
				$result['result']=0;
        $result['msg']=""; 	
        
				$data=array();
		    $data['name']= trim($this->input->post('name'));
		    $data['url']=$this->input->post('url');
		    $data['status']=0;
		    $data['addtime']= date('Y-m-d H:i:s');
		    $data['inf']=$this->input->post('inf');
		  	if(empty($data['name'])){	  	
		  	$result['result']=0;
        $result['msg']="名称不能为空！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	  	
		   }	 
		   
		    if(empty($data['url'])){	  	
		  	$result['result']=0;
        $result['msg']="URL不能为空！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	  	
		    }
		    
		
		    	    	  	  		  		  
		    if($id){
		    //xiugai	
		    $this->node_mdl->update($id,$data);
		    	
		    }else{
		    if($this->node_mdl->check($data['url']))
		    {
		    $result['result']=0;
        $result['msg']="该URL已存在！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	
		    }
		    
		    	
		    //add
		    $this->node_mdl->add($data);	   
		    }	

$result=array();
$result['result']=1;
$result['msg']="保存成功";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;								
		}
	
			public function del()
	{
		
	  $id = intval($this->uri->segment(4));
	  $result=array();
	  if(empty($id))
	  {
	$result['result']=0;
	$result['msg']="参数错误！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;		
	  }
	     $this->node_mdl->del($id);	  
			  $result['result']=1;
			$result['msg']="删除成功！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;	
		
	}
	
	public function setstatus(){
				$id=intval($this->input->post('id'));
				$status=intval($this->input->post('status'));
				 $result=array();
				  if(empty($id))
    {
 
       
        $result['result']=0;
$result['msg']="该ID非法！";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;		
    }	
    	    					
				$tu=array();
				$tu['status']=empty($status) ? 0 : 1;
				$this->node_mdl->update($id,$tu);		
							
    
$result['result']=1;
$result['msg']="保存成功";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;		
		    							
		}
			
}

