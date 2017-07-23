<?php
namespace Vendor\Qiniu;

use Vendor\Qiniu\Auth;
use Vendor\Qiniu\Storage\UploadManager;

class Upload {

	public function upload()
	{


		// 用于签名的公钥和私钥
        $accessKey = C('qiniu_access_key');
        $secretKey = C('qiniu_secret_key');

        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);

        // 要上传的空间
        $bucket = C('qiniu_sitename');

        // 生成上传Token
        $token = $auth->uploadToken($bucket);

        // 构建 UploadManager 对象

        $uploadMgr = new UploadManager;

        // 上传文件到七牛
        $filePath = $_FILES['file']['tmp_name']; 	 // 要上传文件的本地路径

        $pri_key = 'f6075a5e1ab5a3da64b42771759672f2';

        $fname = date('Ymd_').strtoupper(md5(microtime().$pri_key.uniqid())).".png";

        $key = $fname;  			                 // 上传到七牛后保存的文件名

        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
        	$err['success'] = false;
        	return $err;
        } else {
        	$ret['success'] = true;
        	$ret['image'] = $ret['m_image'] = C('qiniu_siteurl') . $ret['key'];
			return $ret;
        }
	}
}