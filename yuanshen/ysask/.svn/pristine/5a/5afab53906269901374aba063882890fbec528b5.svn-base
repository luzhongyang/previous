<?php
namespace Api\Controller;
use Think\Controller;
use Think\Upload;
use Think\Image;
ini_set('max_execution_time', 0);
class UploadsController extends Controller{

	//上传文件
	public function uploadify() {
		$savePath = 'avatar';
		if (!empty($_FILES)) {
			$url = $this->_uploadimg($savePath,false);
			$img = new Image(Image::IMAGE_GD,'.'.$url['image']);
			$img->thumb(430,310)->save('.'.$url['image']);
			$img_info = getimagesize($url['image']);
			$width = $img_info[0];
			$height = $img_info[1];
			$this->ajaxReturn(array('status' => 1,'info' => '上传成功','url' => $url['image'],'width' => $width, 'height' => $height));
		}
	}

	//通用上传图片
	public function upload() {
		$savePath = 'static';
		if (!empty($_FILES)) {
			$url = $this->_uploadimg($savePath,false);//true 生成缩略图
			$this->ajaxReturn(array('status' => 1,'info' => '上传成功','url' => $url['image'], 'm_url' => $url['m_image']));
		}
	}

	//上传图片
	public function uploadimg() {
		$savePath = 'joke';
		if (!empty($_FILES)) {
			$url = $this->_uploadimg($savePath,true);//true 生成缩略图
			$this->ajaxReturn(array('status' => 1,'info' => '上传成功','url' => $url['image'], 'm_url' => $url['m_image']));
		}
	}

	//上传视频
	public function uploadvedio() {
		$savePath = 'joke';
		if (!empty($_FILES)) {
			$url = $this->_uploadvedio($savePath);
			$this->ajaxReturn(array('status' => 1,'info' => '上传成功','url' => $url));
		}
	}

	//上传图片类
	private function _uploadimg($savePath,$is_water){
		$exts = array();
		if(trim(C('upload_img')) != '') {
			array_push($exts, C('upload_img'));
		}
		if(count($exts) > 0) {
			$exts = implode(',', $exts);
		}else {
			$exts = '*';
		}

		$config = array(
			'maxSize' => C('upload_size')*1048576,
			'exts' => explode(',', $exts),
			'rootPath' => './'.C('upload_path').'/',
			'savePath' => $savePath.'/',
			'subName' => array('date', C('upload_style')),
			'saveName' => array('uniqid', '')
		);

		//导入上传类,判断上传类型

		if(C('file_type') == 1) {
			//	本地存储
			$upload = new Upload($config);
			if ($info = $upload->upload()) {
				$path = './'.C('upload_path').'/'.$info['file']['savepath'].$info['file']['savename'];
				//水印
				if($info['file']['ext'] != 'gif' && $info['file']['ext'] != 'GIF') {
					$img = new Image(Image::IMAGE_GD,$path);
					if(C('water_status') == 1 && $is_water) {
						//图片水印
						if(C('water_type') == 2) {
							$source = '.'.C('water_img');
							$img->water($source,C('water_pos'),C('water_alpha'))->save($path);
						}
						//文字水印
						if(C('water_type') == 1) {
							$img->text(
								C('water_font'),
								C('water_font_path'),
								C('water_font_size'),
								C('water_font_color'),
								C('water_pos')
								)->save($path);
						}
					}
					//缩略图
					$m_path = './'.C('upload_path').'/'.$info['file']['savepath'].'m_'.$info['file']['savename'];
					$img->thumb(661,10000)->save($m_path);
				}
				if($info['file']['ext'] == 'gif' || $info['file']['ext'] == 'GIF') {
					$img = new Image(Image::IMAGE_GD,$path);
					$m_path = './'.C('upload_path').'/'.$info['file']['savepath'].'m_'.$info['file']['savename'];
					$img->thumb(661,10000)->save($m_path,'jpg');
				}
				return array('image' => substr($path, 1), 'm_image' => substr($m_path,1)); //$m_path
			}
		}else if(C('file_type') == 2) {
			//	七牛云存储
			$upload = new \Vendor\Qiniu\Upload();
			if($info = $upload->upload()) {
				if($info['success']) {
					return array('image'=>$info['image'],'m_image'=>$info['m_image']);
				}
			}
		}else if(C('file_type') == 3) {
			//	FTP
			$ftpConfig = array(
				'host'     => C('ftp_host'), //服务器
				'port'     => C('ftp_port'), //端口
				'timeout'  => C('ftp_time'), //超时时间
				'username' => C('ftp_user'), //用户名
				'password' => C('ftp_pass'), //密码
			);
			$config = array(
				'maxSize' => C('upload_size')*1048576,
				'exts' => explode(',', $exts),
				'rootPath' => './'.C('ftp_dir').'/',
				'savePath' => $savePath.'/',
				'subName' => array('date', C('upload_style')),
				'saveName' => array('uniqid', '')
			);
			$upload = new Upload($config,'Ftp',$ftpConfig);
			if($info = $upload->upload()) {
				$path = C('ftp_host') . '/' . 'uploads/static/' . $info['file']['savename'];
				$img = new Image(Image::IMAGE_GD,$path);
				$m_path = C('ftp_host') . '/' . 'uploads/static/' . 'm_'.$info['file']['savename'];
				$img->thumb(661,10000)->save($m_path,'jpg');
				return array('image'=>$path,'m_image'=>$m_path);
			}
		}else if(C('file_type') == 4) {
			//	阿里云OSS存储
			$upload = new \Vendor\AliyunOSS\Upload();
			if($info = $upload->upload()) {
				if($info['success']) {
					return array('image'=>$info['image'],'m_image'=>$info['m_image']);
				}
			}
		}

		//捕获上传异常
		return $upload->getError();
	}

	//上传视频类
	private function _uploadvedio($savePath){
		$exts = array();
		if(trim(C('upload_video')) != '') {
			array_push($exts, C('upload_video'));
		}
		if(count($exts) > 0) {
			$exts = implode(',', $exts);
		}else {
			$exts = '*';
		}

		$config = array(
				'maxSize' => C('upload_size')*1048576,
				'exts' => explode(',', $exts),
				'rootPath' => './'.C('upload_path').'/',
				'savePath' => $savePath.'/',
				'subName' => array('date', C('upload_style')),
				'saveName' => array('uniqid', '')
				);
		$ftpConfig = array(
				'host'     => C('ftp_host'), //服务器
				'port'     => C('ftp_port'), //端口
				'timeout'  => C('ftp_time'), //超时时间
				'username' => C('ftp_user'), //用户名
				'password' => C('ftp_pass'), //密码
				);
		//导入上传类,判断上传类型
		if(C('file_type')==3){
			$upload = new Upload($config,'Ftp',$ftpConfig);
		}else{
			$upload = new Upload($config);
		}
		if ($info = $upload->upload()) {
			$path =  '/'.C('upload_path').'/'.$info['file']['savepath'].$info['file']['savename'];
			return $path;
		}
		//捕获上传异常
		return $upload->getError();
	}

	//上传文件类
	private function _uploadfile($savePath){
		$exts = array();
		if(trim(C('upload_file')) != '') {
			array_push($exts, C('upload_file'));
		}
		if(count($exts) > 0) {
			$exts = implode(',', $exts);
		}else {
			$exts = '*';
		}
		$config = array(
				'maxSize' => C('upload_size')*1048576,
				'exts' => explode(',', $exts),
				'rootPath' => './'.C('upload_path').'/',
				'savePath' => $savePath.'/',
				'subName' => array('date', C('upload_style')),
				'saveName' => array('uniqid', '')
				);
		$ftpConfig = array(
				'host'     => C('ftp_host'), //服务器
				'port'     => C('ftp_port'), //端口
				'timeout'  => C('ftp_time'), //超时时间
				'username' => C('ftp_user'), //用户名
				'password' => C('ftp_pass'), //密码
				);
		//导入上传类,判断上传类型
		if(C('file_type')==3){
			$upload = new Upload($config,'Ftp',$ftpConfig);
		}else{
			$upload = new Upload($config);
		}
		if ($info = $upload->upload($_FILES)) {
			$path =  '/'.C('upload_path').'/'.$info['file']['savepath'].$info['file']['savename'];
			return $path;
		}
		//捕获上传异常
		return $upload->getError();
	}

	//上传凭证
	public function token() {
		vendor('Qiniu.Auth','','.class.php');
		vendor('Qiniu.Config','','.class.php');
		vendor('Qiniu.Etag','','.class.php');
		vendor('Qiniu.functions','','.class.php');
		vendor('Qiniu.Zone','','.class.php');
		vendor('Qiniu.Http.Client','','.class.php');
		vendor('Qiniu.Http.Error','','.class.php');
		vendor('Qiniu.Http.Request','','.class.php');
		vendor('Qiniu.Http.Response','','.class.php');
		vendor('Qiniu.Process.PersistenFop','','.class.php');
		vendor('Qiniu.Storage.BucketManager','','.class.php');
		vendor('Qiniu.Storage.FormUploader','','.class.php');
		vendor('Qiniu.Storage.ResumeUploader','','.class.php');
		vendor('Qiniu.Storage.UploadManager','','.class.php');

		// 需要填写你的 Access Key 和 Secret Key
		$accessKey = C('qiniu_access_key');
		$secretKey = C('qiniu_secret_key');
		// 构建鉴权对象
		$auth = new \Auth($accessKey, $secretKey);
		// 要上传的空间
		$bucket = C('qiniu_sitename');
		// 生成上传 Token
		$token = $auth->uploadToken($bucket);
		$this->ajaxReturn(array('uptoken' => $token));
	}

	public function qiniu_upload()
	{

	}

}