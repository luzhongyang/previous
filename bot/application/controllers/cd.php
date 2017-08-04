<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cd extends CI_Controller {
	 
	    public $netbotguid;
	 	  public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
          //error_reporting(0);  
          $this->load->helper('date');
          $this->load->helper("alwin");  
          $this->load->library("fileCache");
          $this->netbotguid="9de5f97ef4e078cc1e3b6f975133a168";     
     
       
    }
    
    
	public function index()
	{

    $Z=$_POST['cmd'];
    $Z1=@$_POST['Z1'];
    $Z2=@$_POST['Z2'];

$R = "";

try { 

switch ($Z)
{
	
/*
得到当前目录的绝对路径]
提交：pass=A&z0=GB2312
返回：目录的绝对路径\t，如果是Windows系统后面接着加上驱动器列表
示例：c:\inetpub\wwwroot\ C:D:E:K:
示例：/var/www/html/
*/

case "A":

$R ="C:/Windows";
$R .="\t";

$file_path=$this->config->item('pathlist_path').'/'.$this->netbotguid; 
$path_hash="treelist";
$file_path=$file_path.'/'.$path_hash .'.txt';
$vars=array();
$treelist_data=$this->chat_send("treelist",$vars,$wait=2,$file_path);


	foreach ($treelist_data as $value){
		$R .=$value['name'].":";
	}





  break;


/*
[目录浏览]
提交：pass=B&z0=GB2312&z1=目录绝对路径
返回：先目录后文件,目录名后要加/，文件名后不要加/
示例：
目录名/\t时间\t大小\t属性\n目录名/\t时间\t大小\t属性\n
文件名\t时间\t大小\t属性\n文件名\t时间\t大小\t属性\n
*/

case "B":
  
   $R .=sprintf("%s/\t%s\t0\t-\n","alwin",date('Y-m-d H:i:s',time())); //目录  Z1
   
   $R .=sprintf("%s\t%s\t%u\t-\n","alwin",date('Y-m-d H:i:s',time()),32768);  //文件
 
  break;


/*
[读取文本文件]
提交：pass=C&z0=GB2312&z1=文件绝对路径
返回：文本文件的内容
*/  
  
case "C":

  $R .="文本文件的内容";
  
  break;


/*
[写入文本文件]
提交：pass=D&z0=GB2312&z1=文件绝对路径&z2=文件内容
返回：成功返回1,不成功返回错误信息

*/


case "D":
  $R = "1";
  break;
  
  
  
  /*
  [删除文件或目录]
提交：pass=E&z0=GB2312&z1=文件或目录的绝对路径
返回：成功返回1,不成功返回错误信息
  */
  
  
  case "E":
    $R = "1";
  break;
  
 /*
 [下载文件]
提交：pass=F&z0=GB2312&z1=服务器文件的绝对路径
返回：要下载文件的内容
 */ 
  case "F":
  header('Content-type: application/text'); 
  header('Content-Disposition: attachment; filename=$Z1'); 
  echo "文件的内容";
  exit();
  break;
  
  /*
  [上传文件]
提交：pass=G&z0=GB2312&z1=文件上传后的绝对路径&z2=文件内容(十六进制文本格式)
返回：要下载文件的内容
  
  */
  
  case "G":
  $R = "1";
  break;
  
  /*
  [复制文件或目录后粘贴]
提交：pass=H&z0=GB2312&z1=复制的绝对路径&z2=粘贴的绝对路径
返回：成功返回1,不成功返回错误信息
  
  */
  case "H":
  $R = "1";
  break;  
  
  
  /*
  [文件或目录重命名]
提交：pass=I&z0=GB2312&z1=原名(绝对路径)&z2=新名(绝对路径)
返回：成功返回1,不成功返回错误信息
  
  */
    case "I":
 
  break;  
  
  /*
  [新建目录]
提交：pass=J&z0=GB2312&z1=新目录名(绝对路径)
返回：成功返回1,不成功返回错误信息
  
  */
  
  
    case "J":
  $R = "1";
  break;  
  
  
  /*
  [修改文件或目录时间]
提交：pass=K&z0=GB2312&z1=文件或目录的绝对路径&z2=时间(格式：yyyy-MM-dd HH:mm:ss)
返回：成功返回1,不成功返回错误信息
  */
  
    case "K":
  $R = "1";
  break;  
  
  /*
  [下载文件到服务器]
提交：pass=L&z0=GB2312&z1=URL路径&z2=下载后保存的绝对路径
返回：成功返回1,不成功返回错误信息
  */
  
     case "L":
  $R = "1";
  break;  
  
  
  /*
  [执行Shell命令(Shell路径前会根据服务器系统类型加上-c或/c参数)]
提交：pass=M&z0=GB2312&z1=(-c或/c)加Shell路径&z2=Shell命令
返回：命令执行结果
  
  */
     case "M":
   $R = "命令执行成功";
  break;  
  
  /*
  [得到数据库基本信息]
提交：pass=N&z0=GB2312&z1=数据库配置信息
返回：成功返回数据库(以制表符\t分隔)， 不成功返回错误信息
  */
  
     case "N":
  $R = "data conn"."\t";
  break;  
  
  /*
  [获取数据库表名]
提交：pass=O&z0=GB2312&z1=数据库配置信息\r\n数据库名
返回：成功返回数据表(以\t分隔)， 不成功返回错误信息
  */
  
     case "O":
    $R .= sprintf("%s/\t","alwin");
  break;  
  
  
  /*
  [获取数据表列名]
提交：pass=P&z0=GB2312&z1=数据库配置信息\r\n数据库名\r\n数据表名
返回：成功返回数据列(以制表符\t分隔)， 不成功返回错误信息
  */
       case "P":
       $R .= sprintf("%s (%s)\t", "id", "int");

  break;  
  
  
/*  
  [执行数据库命令]
提交：pass=Q&z0=GB2312&z1=数据库配置信息\r\n数据库名&z2=SQL命令
返回：成功返回数据表内容， 不成功返回错误信息
注意：返回的第一行为表头，接下去每行分别在列表中显示，列数要求一致。行中的每列后加上\t|\t标记，每行以标记\r\n为结束
 */ 
     case "Q":
  echo "Number 3";
  break;  
  
  
default:
  echo "无参数";
}

} catch (Exception $e) {   
 $R = "ERROR:// ".$e->getMessage();
  
}  
header("Content-type: text/html; charset=utf-8");
print("\x2D\x3E\x7C".$R."\x7C\x3C\x2D");
exit();  


	}
	
	  public function chat_send($tl_function,$tl_vars,$wait=0,$path=""){
  //创建任务
  $tl_netbot=$this->netbotguid;
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
	$tl['tl_type']="chat";
	$this->db->insert("tasklist_chat", $tl);
	$tl['tl_id']=$this->db->insert_id();
  if(!$wait) return $tl['tl_id'];
  $path_hash=md5($tl['tl_id']); 
  $file_path=$this->config->item('tasktmp_path').'/'.$path_hash .'.txt'; 
  
  if($wait==2){       
 	$task_data=$this->wait_task_result2($path);
   }else{
	 $task_data=$this->wait_task_result($file_path);
   }
	     if($task_data){
	     return json_decode($task_data,true);	 	          	      	   
	     }else{
	     return false;	   
	     }

	} 

	 private function wait_task_result2($file){

	 $task_data="";
	 if(file_exists($file)){
	 	$file_old_time = filemtime($file);	 		
	 }else{ 	
	 	$file_old_time = 0;
	 }
	 	 
	 $i=0; 
	 while ($i<100) // check if the data file has been modified 
{ 
  usleep(200000); // sleep 10ms to unload the CPU 
  if($file_old_time==0){
  if(file_exists($file))
  {	
  	$task_data = read_file($file);
  	return $task_data; 	
  }
}else{
    if(filemtime($file)>$file_old_time)
  {	
  	$task_data = read_file($file);
  	return $task_data; 	
  }
}
  
  
  $i++;  
} 	

		return false;


	 }

   private function wait_task_result($file){

 	 $task_data ="";
	 $i=0; 
	 while ($i<100) // check if the data file has been modified 
{ 
  usleep(200000); // sleep 10ms to unload the CPU 
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

