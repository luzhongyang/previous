<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Explorer extends Chat_Controller {


	    private $path;
	 	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
          $this->load->helper('date');
          $this->load->helper("alwin");
          $this->load->model('chat_mdl');       
          $this->path = $this->input->get('path');
       
    }
    
    
	public function index()
	{
		$view_data= array();
		$view_data['dir']=$this->path;
		
		if($view_data['dir']=="undefinedcomputer")
		{
			$view_data['dir']="C:/";
		}
		
		
		$this->load->view('chat/explorer', $view_data);
	}
	
	public function main()
	{
		$view_data= array();
		//$netbotguid = $this->uri->segment(4);	
		//$netbotguid =$this->input->get('netbotguid');
		//$_SESSION['netbotguid']=$netbotguid;
		//unset($_SESSION['history']);
		//unset($_SESSION['path_copy']);            
   // unset($_SESSION['path_copy_type']);
		
		$view_data= array();
		$view_data['dir']="C:/";
		$this->load->view('chat/explorer', $view_data);
	}
	
	  public function historyBack(){
      $this->load->library("History");
   
        $session=$_SESSION['history'];
        if (is_array($session)){
            $hi=new History($session);
            $path=$hi->goback();            
            $_SESSION['history']=$hi->getHistory();
         
             $folderlist=$this->path($path);
              $folderlist= $folderlist['list'];
            $_SESSION['this_path']=$path;
            show_json(array(
                'history_status'=>array('back'=>$hi->isback(),'next'=>$hi->isnext()),
                'thispath'=>$path,
                'list'=>$folderlist
            ));
        }
    }
    public function historyNext(){
      $this->load->library("History");
    
        $session=$_SESSION['history'];
        if (is_array($session)){
            $hi=new History($session);
            $path=$hi->gonext();            
            $_SESSION['history']=$hi->getHistory();
       
             $folderlist=$this->path($path);
	           $folderlist= $folderlist['list'];
   
            $_SESSION['this_path']=$path;
            show_json(array(
                'history_status'=>array('back'=>$hi->isback(),'next'=>$hi->isnext()),
                'thispath'=>$path,
                'list'=>$folderlist
            ));
        }
    }
	
	
	public function pathList()
	{		
	$this->load->library("History");
	
	  $session=isset($_SESSION['history'])?$_SESSION['history']:false;
        $user_path = $this->input->get('path');
        $refresh = $this->input->get('f5');
        
        if (is_array($session)){
            $hi=new History($session);
            if ($user_path==""){
                $user_path=$hi->getFirst();
            }else {
                $hi->add($user_path); 
                $_SESSION['history']=$hi->getHistory();
            }
        }else {
            $hi=new history(array(),20);
            if ($user_path=="")  $user_path='/';
            $hi->add($user_path);
            $_SESSION['history']=$hi->getHistory();
        }

        //回收站不记录前进后退
        if($this->input->get('path') != '*recycle*/' && $this->input->get('type') !=='desktop'){
            $_SESSION['this_path']=$user_path;
        }
	
	  
	      $taskdata=$this->path($this->path,$refresh);
	      
	   
	       
         if($taskdata['code']==1)
       {
       	$list=$taskdata['list'];
       	 $list['history_status']= array('back'=>$hi->isback(),'next'=>$hi->isnext());
       	
        show_json($list);
	     }else{
	     	 show_json($taskdata['info'],false);
	     	 
	     }
	
	}
	
	private function path($path,$refresh="false")
	{
		   $result=array();
		   $result['list']=array();
		   $result['info']="";
		   $result['code']=0;
			 $path_hash=md5($path);
			      
			   $file_path=$this->config->item('pathlist_path').'/'.$this->netbotguid;   
			   		      
        $file_path=$file_path.'/'.$path_hash .'.txt';
        
        
        if($this->netbottype=="offline")
        {
        	  if(file_exists($file_path))
        	  {
        $task_data = read_file($file_path);	
        $task_data =json_decode($task_data,true);		
        $result['list']=$task_data;
		   $result['code']=1;
		   return $result;  	
        	  }else{
       $result['info']="没有该路径缓存数据！";
		   $result['code']=0;
		   return $result;	
        	  	
        	  }
        	
        }
        
        if(file_exists($file_path) && $refresh!="true" ){
        $task_data = read_file($file_path);	
        $task_data =json_decode($task_data,true);		
        }else{
    if(file_exists($file_path))  unlink($file_path);	
		

	//创建任务
	$vars=array();
	$vars['path']=$this->input->get('path');
  $task_data=$this->chat_mdl->chat_send("pathList",$vars,$wait=2,$file_path);

	      
	   }   
	      if($task_data){	      		      	     	       
       $result['list']=$task_data;
		   $result['code']=1;
		   return $result;  
		    
	     }else{	  
	     	   	
	     $result['info']="读取超时";
		   $result['code']=0;
		   return $result;
	   
	}
		
		
		
	}
	
	
	  public function treeList(){
	  	
	  	  $refresh=0;
	  	  $lpath="";
	  	  $task_vars="";
	  	  $path_hash="";
	  	  $tl_function="";
	  	  $type=$this->input->get('type');
	  	  $name=$this->input->post('name');
	      $path=$this->input->post('path');
	      $this_path=$this->input->post('this_path');  
	      $vars=array();
	      if($name=="computer") $type="computer";
	      
	  	  if(!empty($type)){
	  	  	
	  	  	$path_hash="treelist";
	  	  	$task_vars="";
	  	    $tl_function="treeList";
	  	  }else{
	  	  	$type="folder";
	  	  	if(empty($path) || $path=="undefined")
	  	  	{
	        $lpath=$this_path;
	  	  	}else{ 	  		
	  	  	 $lpath=urldecode($path.$name);
	  	  	}
	
	  	
	  	  		$path_hash=md5($lpath);
	  	  		$tl_function="pathList";
	  	  		
	  	  		$vars['path']=$lpath;
	  	  	
	  	  
	  	  		  	  	
	  	  }
	  	 
	  	 
	  	 $file_path=$this->config->item('pathlist_path').'/'.$this->netbotguid;  
	  	 
	  	 
	  	 

        $file_path=$file_path.'/'.$path_hash .'.txt';
        
            if($this->netbottype=="offline")
        {
        	  if(file_exists($file_path))
        	  {
        $treelist_data = read_file($file_path);	
        $treelist_data=json_decode($treelist_data,TRUE);	
        	  }else{
		   show_json("没有该路径缓存数据！",false);
        	  }
        	
        }else{
        
        
        if(file_exists($file_path) && $refresh==0 ){
        $treelist_data = read_file($file_path);	
        $treelist_data=json_decode($treelist_data,TRUE);		
        }else{
		
	//创建任务

	 $treelist_data=$this->chat_mdl->chat_send($tl_function,$vars,$wait=2,$file_path);
	
	
	     
	   }   
	   
	    }
	      if($treelist_data){   
	     	           	
	      
	      if($type=="init"){
	      	$treelist=$this->get_treeList_init($treelist_data);
	      }elseif($type=="computer"){
	      	$treelist=$this->get_treeList_computer($treelist_data);
	      }else{
	      	$treelist=$this->get_treeList_folder($treelist_data);
	      }
	            	  
        show_json($treelist);
	     }else{
	     	 show_json("读取超时",false);
	   
	}
	  	
	  	
	  	
	  	
	  	
	  }
	  
	 public function  pathChmod()
	 {
	 	show_json("该操作对WINDOWS无效!",false,null);
	 }
	  
	  	
	  public function pathInfo()
	 {
	 	 $info_list = json_decode($this->input->post('list'),true);
	 	 $info=$info_list[0]; 
	   $path=rawurldecode( $info['path']);
	   $type=$info['type'];
	   	
	   $name=get_path_this($path);
	   	  
	   $fpath=get_path_father($path);
	   $path_hash=md5($fpath);
	   $file_path=$this->config->item('pathlist_path').'/'.$this->netbotguid;   			   	
	   $file_path=$file_path.'/'.$path_hash .'.txt';
     if(file_exists($file_path))
     {
       $task_data = read_file($file_path);	
       $task_data =json_decode($task_data,true);		
     }
		 	 
		 if(empty($task_data))
		 {
		 	 show_json("读取错误!",false,null);
		 }
		 
		 if($type=="file")
		 {
		 	 $task_data= $task_data['filelist'];
	 	 }else{
			 $task_data= $task_data['folderlist'];
	  }
		 //print_r($task_data);
		 
		// echo "|||".$name;
		//exit;
 
		 $key = array_search($name, array_column($task_data, 'name'));
		
		 $pi=$task_data[$key];
		 
		 $mod="";
		 if($pi["is_readable"])
		 {
		 	$mod .="【可读】";
		 }else{
		 	$mod .="【不可读】";
		}
		 $mod .="  ";
		 if($pi["is_writeable"])
		 {
		 	$mod .="【可写】";
		 }else{
		 	$mod .="【不可写】";
		}
		 
		 if($type=="file")
		 {
	  $info = array(
		'name'			=> $pi["name"],
		'path'			=> $pi["path"],
		'ext'			=> $pi["ext"],
		'type' 			=> 'file',
		'mode'			=> $mod,
		'atime'			=> $pi["atime"], //最后访问时间
		'ctime'			=> $pi["ctime"], //创建时间
		'mtime'			=> $pi["mtime"], //最后修改时间
		'is_readable'	=> $pi["is_readable"],
		'is_writeable'	=> $pi["is_writeable"],
		'size'			=> $pi["size"],
		'size_friendly'	=> $pi["size"]." B"
	  );
	 }else{
		$info = array(
		'name'			=> $pi["name"],
		'path'			=> $pi["path"],
		'type' 			=> 'folder',
		'mode'			=> $mod,
		'atime'			=> $pi["atime"], //访问时间
		'ctime'			=> $pi["ctime"], //创建时间
		'mtime'			=> $pi["mtime"], //最后修改时间		
		'is_readable'	=> $pi["is_readable"],
		'is_writeable'	=> $pi["is_writeable"]
	);
	} 
		 
	  show_json($info); 	 
		 
		 
	 }
	
	
	 public function get_task_filenew()	 
	 {
	 	//更新时间
	 	$sql="update  chatlist set lasttime=now()  where username='".$this->user."' and guid='".$_SESSION['netbotguid']."' ";
    $this->db->query($sql);
    
	 	$tf_new = $this->db->query("SELECT * FROM task_files where tf_stauts=0 and tl_netbot='".$this->netbotguid."' and username='".$this->user."'  limit 1")->row_array();
	 	
	   if(!empty($tf_new))  {  
	   	 $this->db->query("update  task_files set tf_stauts=1  where tf_id=".$tf_new['tf_id']); 
       show_json($tf_new);           
	     }else{
	     	show_json("no  data",false);   
	     }
	    	    
	 }
	
	
	 public function get_task_file()	 
	 {
	 	   $today=date("Y-m-d");	 	
	 	   $tf_list = $this->db->query("SELECT * FROM task_files where tl_netbot='".$this->netbotguid."' and tf_addtime>'".$today."' order by tf_id desc ")->result_array();
 
   
     $str="";
	 	 foreach ($tf_list as $key=> $tf){
	 	$downloadurl=$this->config->item('mydownload_url')."/".$this->netbotguid."/".$tf['tf_name'];
	 	if($tf['tf_oldpath']) 
	 	{
	 		$oldpath="<a href=\"javascript:ui.path.list('".get_path_father($tf['tf_oldpath'])."','tips');\" title=\"".$tf['tf_oldpath']."\">[路径]&nbsp;</a>".$tf['tf_name'];
	 	}else{
	 		$oldpath=$tf['tf_name'];
	 	}
	 	
	 	$str .="<tr class=\"list file\"><td class=\"name\">".$oldpath."</td><td class=\"size\">".$tf['tf_size']."</td><td class=\"path\"><a href=\"".$downloadurl."\" title=\"".$tf['tf_name']."\" target=_blank>[下载]&nbsp;</a>".$tf['tf_name']."</td></tr>";
	 	
	 	
	 	
	     }
	     
	      show_json($str);
	    	    
	 }
	public function netbotopen()	 
	 {
	 	$openpath=$_POST['openpath'];
	 	$opencommand=$_POST['opencommand'];
	 	$openmode=intval($_POST['openmode']);

         
  //创建任务     
	$vars=array();
	$vars['path']=$openpath;
  $vars['command']=$opencommand;
	$vars['mode']=$openmode;
	
   $tl=$this->chat_mdl->chat_send("open",$vars,0);

   $info="指令发送成功！";
   show_json($info);	    
	 }
	
	
	
	  public function get_treeList_init($treelist_data){//树结构

   //$treelist_data=json_decode($treelist_data,TRUE);

    $list=array();
    
     $ldata=array();
     $ldata['name']="收藏夹";
     $ldata['iconSkin']="fav";
     $ldata['menuType']="menuTreeFavRoot";
     $ldata['open']=true;
     
      $lcdata=array();
     
     $ldata['children']=$lcdata;
    

     $list[]= $ldata;
   
   
     $ldata=array();
     $ldata['name']="computer";
     $ldata['iconSkin']="my";
     $ldata['menuType']="menuTreeRoot";
     //$ldata['menuType']="menuTreeFavRoot";
     $ldata['open']=true;
     $ldata['isParent']=true;


 foreach ($treelist_data as $value) {
	       	
	       	
	     $lcdata=array();
       
     $lcdata['name']=$value['name'];
     $lcdata['this_path']=$value['this_path'];
     $lcdata['type']="folder";
     $lcdata['mode']="drwx rwx rwx (0777) ";
     $lcdata['atime']=1432171701;
     $lcdata['ctime']=1432171701;
     $lcdata['mtime']=1432171701;
     $lcdata['is_readable']=$value['is_readable'];
     $lcdata['is_writeable']=$value['is_writeable'];
     $lcdata['isParent']=$value['isParent'];  
   
     $ldata['children'][]=$lcdata;	
	             	
	      } 	


     $list[]= $ldata;



     return $list;

    }
		
	 public function get_treeList_computer($treelist_data){//树结构

   //$treelist_data=json_decode($treelist_data,TRUE);

    $list=array();
    
 foreach ($treelist_data as $value) {
	       	
	       	
	     $lcdata=array();
       
     $lcdata['name']=$value['name'];
     $lcdata['this_path']=$value['this_path'];
     $lcdata['type']="folder";
     $lcdata['mode']="drwx rwx rwx (0777) ";
     $lcdata['atime']=1432171701;
     $lcdata['ctime']=1432171701;
     $lcdata['mtime']=1432171701;
     $lcdata['is_readable']=$value['is_readable'];
     $lcdata['is_writeable']=$value['is_writeable'];
     $lcdata['isParent']=$value['isParent'];  
   
     $list[]=$lcdata;	
	             	
	      } 	

     return $list;

    }
		
	
		
		 public function get_treeList_folder($treelist_data){
	
		 	 //$treelist_data=json_decode($treelist_data,TRUE);
       $treelist_data=$treelist_data['folderlist'];
    $list=array();
    
 foreach ($treelist_data as $value) {
	       	
	       	
	     $lcdata=array();
       
     $lcdata['name']=$value['name'];
     $lcdata['path']=$value['path'];
     $lcdata['type']="folder";
     $lcdata['mode']="drwx rwx rwx (0777) ";
     $lcdata['atime']=$value['mtime'];
     $lcdata['ctime']=$value['mtime'];
     $lcdata['mtime']=$value['mtime'];
     $lcdata['is_readable']=$value['is_readable'];
     $lcdata['is_writeable']=$value['is_writeable'];
     $lcdata['isParent']=$value['isParent'];  
   
     $list[]=$lcdata;	
	             	
	      } 	

     return $list;
		 	
		}
		
		  public function pathCopy(){
        $copy_list = json_decode($this->input->post('list'),true);
        $list_num = count($copy_list);
        for ($i=0; $i < $list_num; $i++) { 
            $copy_list[$i]['path'] =$copy_list[$i]['path'];
        }
        $_SESSION['path_copy']= json_encode($copy_list);            
        $_SESSION['path_copy_type']='copy';
        show_json("【复制】--覆盖剪切板成功！");
    }	
    
     public function pathCuteDrag(){
     	 $path=rawurldecode($this->input->post('path'));
       $list = json_decode($this->input->post('list'),true);    
        $success=0;$error=0;
         foreach ($list as $key=> $value) {
         $list[$key]['path']=rawurldecode($list[$key]['path']);	 
        } 
        
              //创建任务         
	$vars=array();
  $vars['copy_type']="cut";
  $vars['path_past']=$path;
	$vars['list']=$list;
	
	$tl=$this->chat_mdl->chat_send("pathPast",$vars,0);  
   
  $state = ($error ==''?true:false);
  $msg="移动指令发送成功!";
  $data=array();
  show_json($msg,$state,$data); 
        
     
    
     }
     
       public function pathCopyDrag()
       {
       	 show_json("此功能禁用!",false,null);
      }
     
      public function pathPast(){
        if (!isset($_SESSION['path_copy'])){
            show_json("剪切板无内容!",false,null);
        }

        $error = '';
        $data = array();
        $clipboard = json_decode($_SESSION['path_copy'],true);
        $copy_type = $_SESSION['path_copy_type'];
        $path_past=rawurldecode($this->path);
    
        $list_num = count($clipboard);
        if ($list_num == 0) {
            show_json("剪切板无内容!",false,$data);
        }
       
        foreach ($clipboard as $key=> $value) {
         $clipboard[$key]['path']=rawurldecode($clipboard[$key]['path']);	 
        } 
         $data['copy_type']=$copy_type;
        $data['path_past']=trim($path_past); 
        $data['list']=$clipboard;
                
        //创建任务         
	$vars=array();
  $vars['copy_type']=$copy_type;
  $vars['path_past']=$path_past;
	$vars['list']=$clipboard;
	
	$tl=$this->chat_mdl->chat_send("pathPast",$vars,0);  
   
  $state = ($error ==''?true:false);
  $msg="粘贴指令发送成功!";
  show_json($msg,$state,$data);
    }
    
    
     public function pathCute(){
   
        $cute_list = json_decode($this->input->post('list'),true);
        $list_num = count($cute_list);
        for ($i=0; $i < $list_num; $i++) { 
            $cute_list[$i]['path'] = $cute_list[$i]['path'];
        }
        $_SESSION['path_copy']= json_encode($cute_list);            
        $_SESSION['path_copy_type']='cute';
        show_json("【剪切】--覆盖剪切板成功！");
    }
    
    
        public function pathRname(){
         $path=rawurldecode($this->input->post('path'));
        $rname_to= rawurldecode($this->input->post('rname_to'));
    
    
      //创建任务     
	$vars=array();
	$vars['path']=$path;
	$vars['rname_to']=$rname_to;

  $tl=$this->chat_mdl->chat_send("pathRname",$vars,0);    
    
   show_json("重命名指令发送成功！");
    }
    
    
     public function pathDelete(){
        $list = json_decode($this->input->post('list'),true);    
        $success=0;$error=0;
         foreach ($list as $key=> $value) {
         $list[$key]['path']=rawurldecode($list[$key]['path']);	 
        } 
          
        //创建任务     
	$vars=array();
	$vars['list']=$list;

   $tl=$this->chat_mdl->chat_send("pathDelete",$vars,0);    
  
        $state = $error==0?true:false;
        $info = "删除指令发送成功！";       
        show_json($info,$state);
    }
    
    
       public function search(){      	
        $ext        = '';    
        $search= 	$this->input->post('search');      
       	$ext= 	$this->input->post('ext');
        $path=rawurldecode($this->input->post('path'));
          
        if (isset($ext)) $ext= str_replace(' ','',$ext);

          
        //创建任务     
	$vars=array();
	$vars['search']=$search;
	$vars['path']=$path;
	$vars['ext']=$ext;
	$vars['is_case']=0;
	$vars['is_content']=0;
	    
  $task_data=$this->chat_mdl->chat_send("search",$vars,1);    
  
    if($this->netbottype=="offline")
    {
    	 show_json("指令发送成功！离线状态下无法返回结果！",false);
    }
  
  
         if($task_data){	      	      	     	
  
	      $list=$task_data['data'];
	
	      if(empty($list))  show_json("路径不存在或读取失败！",false);
      $list=json_decode($list,true);
        show_json($list);
	     }else{
	     	 show_json("读取超时",false);
	   
	} 

    }
    
     public function zip(){
 
      $zip_list = rawurldecode($this->input->post('list'));
      $zip_list =json_decode($zip_list,TRUE);
         
  //创建任务     
	$vars=array();
	$vars['path']="";
	$vars['list']=$zip_list; 
  $tl=$this->chat_mdl->chat_send("zip",$vars,0);
        $zipname = "name.zip";
        $info="指令发送成功！";
        show_json($info,true,$zipname);
    }
    
  
     public function zipDownload(){
         $zip_list = rawurldecode($this->input->post('list'));
         $zip_list =json_decode($zip_list,TRUE);
         
  //创建任务     
	$vars=array();
  $vars['path']="";
	$vars['list']=$zip_list;
	
   $tl=$this->chat_mdl->chat_send("zipUpload",$vars,0);
        $zipname = "name.zip";
        $info="指令发送成功！";
        show_json($info,true,$zipname);
    } 
      //文件下载后删除,用于文件夹下载
    public function fileDownloadRemove(){
    echo "ok";
    }
    
       public function unzip(){
  
        $path=$this->path; 
        
                
  //创建任务     
	$vars=array();
	$vars['unzip_to']="";
	$vars['path']=rawurldecode($path);

  $tl=$this->chat_mdl->chat_send("unzip",$vars,0);    
       
       show_json("指令发送成功！");
    }
    
     public function clipboard(){
     	if(empty($_SESSION['path_copy']))
     	{
     		$clipboard = array();
     	}else{
        $clipboard = json_decode($_SESSION['path_copy'],true);
      }
        $msg = '';
        if (count($clipboard) == 0){
            $msg = '<div style="padding:20px;">剪贴板无内容!</div>';
        }else{
            $msg='<div style="height:200px;overflow:auto;padding:10px;width:400px"><b>剪贴板状态:'.($_SESSION['path_copy_type']=='cute'?'剪切':'复制').'</b><br/>';
            $len = 40;
            foreach ($clipboard as $val) {
                $val['path'] = rawurldecode($val['path']);
                $path=(strlen($val['path'])<$len)?$val['path']:'...'.substr($val['path'],-$len);
                $msg.= '<br/>'.$val['type'].' :  '.$path;
            }            
            $msg.="</div>";
        }
        show_json($msg);
    }
   
   
       public function mkfile(){
        $new=rawurldecode($this->path);
       $new = rtrim($new,'/');
           
        //创建任务     
	$vars=array();
	$vars['path']=$new;
	$vars['charset']= "utf-8";
	$vars['filestr']="";
       
  $tl=$this->chat_mdl->chat_send("fileSave",$vars,0);    
         
        
    show_json("指令发送成功！");
    }
    
    public function mkdir(){
    	 $new=rawurldecode($this->path);
       $new = rtrim($new,'/');
        
                
        //创建任务     
	$vars=array();
	$vars['path']=$new;
    
        
  $tl=$this->chat_mdl->chat_send("mkdir",$vars,0);    
        
        
        show_json("指令发送成功！");
    } 
    
      public function fileUpload(){
        $save_path = $this->path;
        
  
       
       if ($save_path == '') show_json("上传文件为空",false);
       $fullPath = $this->input->post('fullPath');
       
       
        if (strlen($fullPath) > 1) {//folder drag upload
            $full_path = _DIR_CLEAR(rawurldecode($fullPath));
            $full_path = get_path_father($full_path);
            //$full_path = iconv_system($full_path);
       
                //$save_path = $save_path.$full_path;           
        }
        
   $netbotguid=$this->netbotguid;
   //$this->load->library("uploadto");
   //$upfiles = new Uploadto();
  // $upfiles->upload_target_dir="./download/".$netbotguid;
  // $upfiles->upload_target_name=$this->user;
	// $download_file=$upfiles->upload_file();
      
      
      	 $file_path=$this->config->item('pathlist_path').'/'.$this->netbotguid;  
      
      
        $temp_dir =$this->config->item('download_path')."/tmp/";
        $zz_path=$this->config->item('download_path')."/".$netbotguid."/";
        $upload_filetype = getFileExt($_POST["name"]);
        
        $zz_name=$this->user."_".date("YmdHis").rand(0,100).'.'.$upload_filetype;
        
        $save_path=$save_path.$_POST["name"];
        if(!is_dir($zz_path))
				{
					mkdir($zz_path);
					chmod($zz_path,0777);
				}

        upload_chunk('file',$zz_path,$temp_dir,$zz_name); 
          
       	//创建任务
      
	$vars=array();
	$vars['path']=$this->config->item('download_url')."/".$netbotguid."/".$zz_name;
	$vars['download_to']=$save_path;
  $vars['mode']="8";
  $tl=$this->chat_mdl->chat_send("fileDownload",$vars,0);    
  
  	show_json("成功上传中转站",true,$save_path);

     
      
    }
    
        // 远程下载
    public function serverDownload() {
      
        $uuid = 'download_'.$this->input->get('uuid');
        if ($this->input->get('type') == 'percent') {//获取下载进度
        
                $info = $uuid;
                $result = array(
                    'uuid'      => $uuid,
                    'length'    => 100,
                    'size'      => 100,
                    'time'      => mtime()
                );
                show_json($result);
            
        }else{ 
      
      
    $save_path=rawurldecode($this->input->get('save_path'));
    $url=rawurldecode($this->input->get('url'));
    $filename=get_path_this($url);
    $save_path=$save_path.$filename;
    	//创建任务
      
	$vars=array();
	$vars['path']=$url;
	$vars['download_to']=$save_path;
  $vars['mode']="8";
  $tl=$this->chat_mdl->chat_send("fileDownload",$vars,0);    
  
  show_json("下载指令发送成功",true,$save_path);

    
  }
    
    
    
    }
    
    public function fileDownload(){

  //创建任务     
	$vars=array();
	$vars['path']=rawurldecode($this->path);
  $tl=$this->chat_mdl->chat_send("fileUpload",$vars,0);    
  
 show_json("下载指令发送成功");  
 
        
        
    } 
    

    
}

