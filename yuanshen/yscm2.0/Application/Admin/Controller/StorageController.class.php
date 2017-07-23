<?php
/**
* 文件存储配置
*/
namespace Admin\Controller;
use Think\Controller;
class StorageController extends BaseController{
	
	public function _initialize() {
		parent::_initialize();//加载父级初始配置
	}

	/*文件存储类型*/
	public function index(){
		if(IS_POST){			
			$support_storages=array("Local","Qiniu");
			$type=$_POST['type'];
			if(in_array($type, $support_storages)){
				$result=sp_set_cmf_setting(array('storage'=>$_POST));
				if($result!==false){
					sp_set_dynamic_config(array("FILE_UPLOAD_TYPE"=>$type,"UPLOAD_TYPE_CONFIG"=>$_POST[$type]));
					$this->success("设置成功！");
				}else{
					$this->error("设置出错！");
				}
			}else{
				$this->error("文件存储类型不存在！");
			}		
		}else{
			$this->assign(sp_get_cmf_settings('storage'));
			$this->display();
		}
	}	
}