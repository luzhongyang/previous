<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);          
       $this->load->model('member_mdl');
       if($this->user_role!="administrator"){
       	echo "你没有该项权限！";
       	exit;
      }
    } 
	 
	 
	public function index()
	{
		
     $page = array();
        $page['menu1'] = "system";
        $page['menu2'] = "user";
        $page['title'] = "管理员设置";
        $page['nav1'] = "系统设置";
        $page['nav2'] = "管理员设置";	
		

    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/user', $view_data);


	}
	
	public function role(){
    $username = $this->uri->segment(4);
		$member=$this->member_mdl->info_view($username);
		
		$grouplist=$member['grouplist'];
		$membergroup=array();
		
	  if($grouplist){
	  	$membergroup=json_decode($grouplist,TRUE);  	
	  }
	  
	  $this->load->model('group_mdl');
		$group_list=$this->group_mdl->getlist();
	

		$view_data= array();
		$view_data['membergroup']=$membergroup;
		$view_data['member']=$member;
		$view_data['group_list']=$group_list;
		$this->load->view('admin/role_edit', $view_data);
		
	}
	
		public function rolesave(){
				$username=$this->input->post('username');
		    $role=$this->input->post('role');
		    $grouplist_name="";
		    if(empty($role)){
		    	$grouplist="";
		    }else{
		    
		       foreach ($role as $gid) {
     $gname = $this->db->query("SELECT ng_name FROM groups where ng_id=" . $gid . "  limit 1")->row()->ng_name; 		
     $grouplist_name .="【".$gname."】";
      } 
		    
		    
		    
		    $grouplist=	json_encode($role,JSON_UNESCAPED_UNICODE);
		    }	
		    	    		    
			$data=array();
			$data['grouplist']=$grouplist;
      $data['grouplist_name']=$grouplist_name;
$this->member_mdl->member_user_update($username,$data);
$result=array();
$result['result']=1;
$result['msg']="成功";
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;								
		}
	
		public function getlist(){
			
		$sql="SELECT * FROM  member";	
		$users = $this->db->query($sql)->result_array();
	
		$records = array();
    $records["aaData"] = array();  
			
		 foreach ($users as $user) {	
		  $set="";	
		 
		  $set .="<a href=\"javascript:useredit('".$user['username']."','".$user['role']."','".$user['email']."')\" class=\"btn blue\">修改</a>";
   
 if($user["role"]!="administrator"){	
		  $set .= "<a class=\" btn default\" href=\"/admin/user/role/".$user['username']."\" data-target=\"#ajax\" data-toggle=\"modal\">
									权限<i class=\"fa fa-plus\"></i>
											</a>";
									}
	 if($user["id"]>1){	
		 	 $set .="<a href=\"javascript:del('".$user['id']."','".$user['username']."')\" class=\"btn btn-xs red\"><i class=\"fa  fa-bank\"></i>删除</a>";
		 	}
	
		  $id="<input type=\"checkbox\"  name=\"id[]\"  class=\"checkboxes\"  value=\"".$user['id']."\"/>";	
		  
		 
	   $records["aaData"][] = array(
	     	$id,
	     	$user['id'],
	      $user["username"],
        $user["email"],
        $user["role"],
        $user["lasttime"],
        $user["grouplist_name"],    
        $set
      );
     
   } 
    	
	 echo json_encode($records, JSON_UNESCAPED_UNICODE);
	exit;
	
	
}
	
	public function save()
	{
	
		
	
		
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$email=$this->input->post('email');
		$role=$this->input->post('role');
				
		$result=array();
		 if ($this->member_mdl->member_user_check($username)) {
        
$result['result']=0;
$result['msg']="用户名已存在"; 			
echo json_encode($result,JSON_UNESCAPED_UNICODE);
exit;
        }
		
	
		
		$data=array();
		$data['username']=$username;
		$data['password']=md5($password);
		$data['email']=$email;
		$data['role']=$role;
		
		 if ($this->member_mdl->member_user_add($data)) {
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
	
	public function editsave()
	{
	
		
	
		
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$email=$this->input->post('email');
		$role=$this->input->post('role');

	
		$data=array();
	if($password){
		$data['password']=md5($password);
	}
	
		$data['role']=$role;
	
			if($email){
		$data['email']=$email;
	}


$this->member_mdl->member_user_update($username,$data);
$result=array();
$result['result']=1;
$result['msg']="成功";
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
	  
	  	  if($id==1)
	  {
	$result['result']=0;
	$result['msg']="默认管理员不能删除！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;		
	  }
	     $this->member_mdl->del($id);	  
			  $result['result']=1;
			$result['msg']="删除成功！";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	exit;	
		
	}

			
}

