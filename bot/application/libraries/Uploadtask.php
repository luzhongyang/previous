<?php
class Uploadtask{
  public $upload_inputname;					//上传文件名
	public $upload_name;					//上传文件名
	public $upload_tmp_name;				//上传临时文件名
	public $upload_final_name;				//上传文件的最终文件名
	public $upload_target_dir;				//文件被上传到的目标目录
	public $upload_target_name;				//文件被上传到的目标目录
	public $upload_target_path;			    //文件被上传到的最终路径
	public $upload_filetype ;				//上传文件类型
	public $allow_uploadedfile_type;		//允许的上传文件类型
	public $upload_file_size;				//上传文件的大小
	public $allow_uploaded_maxsize=50000000; 	//允许上传文件的最大值
	//构造函数
	public function __construct()
	{
		
	
		$this->allow_uploadedfile_type = array('jpeg','jpg','png','gif','bmp','doc','zip','rar','txt','wps');
		
		$this->upload_target_dir="./taskdata/upload";
		$this->upload_target_name="";
	}
	//文件上传
	public function upload_file()
	{
		$inputname=$this->upload_inputname;
		$this->upload_name = $_FILES[$inputname]["name"]; //取得上传文件名
		$this->upload_filetype = $_FILES[$inputname]["type"];
		$this->upload_tmp_name = $_FILES[$inputname]["tmp_name"];
		$this->upload_file_size = $_FILES[$inputname]["size"];
		
		
		$upload_filetype = $this->getFileExt($this->upload_name);
	
			if($this->upload_file_size < $this->allow_uploaded_maxsize)
			{
				if(!is_dir($this->upload_target_dir))
				{
					mkdir($this->upload_target_dir);
					chmod($this->upload_target_dir,0777);
				}
				//$this->upload_final_name = date("YmdHis").rand(0,100).'.'.$upload_filetype;
				$this->upload_final_name = $this->upload_target_name.'.'.$upload_filetype;
				$this->upload_target_path = $this->upload_target_dir."/".$this->upload_final_name;
				if(!move_uploaded_file($this->upload_tmp_name,$this->upload_target_path))
					return false;
					
					$backmsg=array();
					$backmsg['filename']=$this->upload_final_name;
					$backmsg['filesize']=$this->upload_file_size;
					$backmsg['filetype']=$upload_filetype;
					return 	$backmsg;
			}
			else
			{
			return false;
			}
	
	}
   /**
    *获取文件扩展名
    *@param String $filename 要获取文件名的文件
    */
   public function getFileExt($filename){
   		$info = pathinfo($filename);
   		return $info['extension'];
   }
	
}
?>