<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends Admin_Controller {

	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);           
       $this->load->model('app_mdl');
      if($this->user_role!="administrator"){
       	echo "你没有该项权限！";
       	exit;
      }
    } 
	 
	 
	public function index()
	{
			     $page = array();
        $page['menu1'] = "system";
        $page['menu2'] = "app";
        $page['title'] = "插件管理";
        $page['nav1'] = "系统设置";
        $page['nav2'] = "插件管理";	

		
		
    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/applist', $view_data);

	}
	
	public function edit(){
    $id = $this->uri->segment(4);
    
    $app=array();
     $app['app_id']=0;
     $app['app_type']="netbot";
     $app['app_help']="";
     $app['app_vars']="";
     $app['app_name']="";
     $app['app_isback']="";
     $app['app_fun']="";
     
     $app['app_backfun']="";
     $app['app_stauts']=0;
     $app['app_plugurl']="";
      $app['app_plugmd5']="";
      $app['title']="添加一个指令";   
    if($id){
    $app=$this->app_mdl->info_view($id);	
    $app['title']="编辑【".$app['app_name']."】";
    }
    
		$view_data= array();
		$view_data['app']=$app;
		$this->load->view('admin/app_edit', $view_data);
		
	}
	
		public function getlist(){			
		$list = $this->app_mdl->getlist_all();	
		$records = array();
    $records["aaData"] = array();  
			
		 foreach ($list as $value) {	
		  $set="";
		  $stauts	="";	
		  $set .= "<a class=\" btn btn-xs blue\" href=\"/admin/app/edit/".$value['app_id']."\" data-target=\"#ajax\" data-toggle=\"modal\"><i class=\"fa  fa-edit\"></i>修改</a>"; 
		 
		 
		 
		 if($value["app_type"]!="netbot"){	
		 $set .="<a href=\"javascript:del('".$value['app_id']."','".$value['app_name']."')\" class=\"btn btn-xs red\"><i class=\"fa  fa-bank\"></i>删除</a>";
		 }
      if($value["app_stauts"]==1){	
		   $stauts .= " <a class=\" btn btn-xs blue\" href=\"javascript:setstatus('".$value['app_id']."',0)\">
									<i class=\"fa fa-play\"></i>启用
											</a>";
									}else{
									   $stauts .= " <a class=\" btn btn-xs default\" href=\"javascript:setstatus('".$value['app_id']."',1)\">
									<i class=\"fa fa-stop\"></i>停用
											</a>";	
									}
		 	
	
		  $id="<input type=\"checkbox\"  name=\"id[]\"  class=\"checkboxes\"  value=\"".$value['app_id']."\"/>";	
		  
		 
	   $records["aaData"][] = array(
	     	$id,
	     	$value['app_id'],
	      $value["app_name"],
        $value["app_type"],
        $value["app_fun"],
        $value["app_backfun"],
        $stauts,    
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
		    $data['app_name']= trim($this->input->post('app_name'));
		    
		     $data['app_vars']=$this->input->post('app_vars');
		      if(empty($id))
		      {
		    $data['app_fun']= trim($this->input->post('app_fun'));
		    $data['app_type']=$this->input->post('app_type');
		    
		    }
		    $app_backfun=trim($this->input->post('app_backfun'));
		    $app_backfun =strtolower($app_backfun);
         $app_backfun = ucfirst($app_backfun);
		    $data['app_backfun']= $app_backfun;
		    $data['app_plugurl']= trim($this->input->post('app_plugurl'));
		    
		    $tl_plug_md5=trim($this->input->post('app_plugmd5'));
		   if($tl_plug_md5 && strlen($tl_plug_md5)!=32)
		   {
		   	$result['result']=0;
        $result['msg']="插件MD5值不是32位的MD5值！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	 
		   }
		    $data['app_plugmd5']= $tl_plug_md5;
		     
		    $data['app_help']=str_replace(PHP_EOL, '',nl2br($this->input->post('app_help')));;
		  	if(empty($data['app_name'])){	  	
		  	$result['result']=0;
        $result['msg']="名称不能为空！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	  	
		   }	 
		   
		    if(empty($id) && empty($data['app_fun'])){	  	
		  	$result['result']=0;
        $result['msg']="指令不能为空！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	  	
		    }
		    
		       if(empty($data['app_plugurl']) Xor empty($data['app_plugmd5'])){	  	
		  	$result['result']=0;
        $result['msg']="带插件的指令MD5和URL都不能为空！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	  	
		    }
		    
		    	  	
		  		  		  
		    if($id){
		    //xiugai	
		    $this->app_mdl->update($id,$data);
		    	
		    }else{
		    	
		 
		       if($this->app_mdl->check($data['app_fun'])){	  	
		  	$result['result']=0;
        $result['msg']="该指令名已存在！"; 			
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
        exit;	  	
		    }
		    
		    if($data['app_type']=="robot")
		    {
		    	//创建机器人数据表
		   $sql="CREATE TABLE IF NOT EXISTS `robot_keyboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` int(40) NOT NULL,
  `robot_data` longtext NOT NULL,
  `robot_file` varchar(100) NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

     if(!$this->db->query($sql))
     {
     	
     	$result=array();
$result['result']=0;
$result['msg']="数据表创建失败！";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;	
    }

   	
		    	
		    }
		    
		  	
		    //add
		    $this->app_mdl->add($data);	   
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
	  $app=$this->app_mdl->info_view($id);	
	  if($app['app_stauts']>0)
	    {
	$result['result']=0;
	$result['msg']="启用状态下的指令不能删除！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;		
	  }
	  
	    if($app['app_type']=="netbot")
	    {
	$result['result']=0;
	$result['msg']="系统内置指令不能删除！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;		
	  }
	  
	     $this->app_mdl->del($id);	  
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
				$tu['app_stauts']=empty($status) ? 0 : 1;
				$this->app_mdl->update($id,$tu);		
							
    
$result['result']=1;
$result['msg']="保存成功";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;		
		    							
		}
			
			
}

