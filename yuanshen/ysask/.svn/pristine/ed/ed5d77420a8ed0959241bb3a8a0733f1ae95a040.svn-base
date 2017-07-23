<?php
namespace Vendor\AliyunOSS;

use Vendor\AliyunOSS\OssClient;
use Vendor\AliyunOSS\Core\OssException;

class Upload {

	/*上传文件*/
	public function upload()
	{

		// 用于签名的公钥和私钥
        $accessKey = C('aliyun_access_key');
        $secretKey = C('aliyun_secret_key');
        $endpoint = C('aliyun_siteurl');
        $bucket = C('aliyun_sitename');

        // 	初始化签权对象
        $ossClient = new OssClient($accessKey, $secretKey, $endpoint);

        $pri_key = 'f6075a5e1ab5a3da64b42771759672f2';

        $fname = date('Ymd_').strtoupper(md5(microtime().$pri_key.uniqid())).".png";
        $object = "uploads/" . $fname;
	    $filePath = $_FILES['file']['tmp_name'];

	    //	上传文件
	    $rlt = $ossClient->uploadFile($bucket, $object, $filePath);
	    if($rlt['info']['http_code'] == 200) {
	    	$rlt['success'] = true;
	    	$rlt['image'] = $rlt['m_image'] = $rlt['info']['url'];
	    }else {
	    	$rlt['success'] = false;
	    	$rlt['image'] = $rlt['m_image'] = '';
	    }
	    return $rlt;
	}
}