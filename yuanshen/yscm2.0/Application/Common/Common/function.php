<?php
//获取用户头像和用户名
function getusernamepic($id){
	$Role = D("user");
	$list = $Role->getField('id,username,avatar');
	$list = $list [$id];
	$list = "<img src='".$list['avatar']."' width='80' /><br />".$list['username'];
	return $list;
}

/**
 * 发送邮件
 * @param string $address
 * @param string $subject
 * @param string $message
 * @return array<br>
 * 返回格式：<br>
 * array(<br>
 * 	"error"=>0|1,//0代表出错<br>
 * 	"message"=> "出错信息"<br>
 * );
 */
function send_email($address,$title,$message){
	import("PHPMailer");
	$mail=new \PHPMailer();
	// 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();
	$mail->IsHTML(true);
	// 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';
	// 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($address);
	// 设置邮件正文
	$mail->Body=$message;
	// 设置邮件头的From字段。
	$mail->From=C('mail_address');
	// 设置发件人名字
	$mail->FromName=C('mail_fromname');;
	// 设置邮件标题
	$mail->Subject=$title;
	// 设置SMTP服务器。
	$mail->Host=C('mail_smtp');
	// 设置SMTP服务器端口。
	$port=C('mail_smtp_port');
	$mail->Port=empty($port)?"25":$port;
	// 设置为"需要验证"
	$mail->SMTPAuth=true;
	// 设置用户名和密码。
	$mail->Username=C('mail_loginname');
	$mail->Password=C('mail_password');
	//以下是支持QQ个人邮箱的
	$mail->Port = '465'; 
	$mail->SMTPSecure = 'ssl'; 
	// 发送邮件。
	if(!$mail->Send()) {
		$mailerror=$mail->ErrorInfo;
		return array("error"=>1,"message"=>$mailerror);
	}else{
		return array("error"=>0,"message"=>"success");
	}
}

/*生成随机6位数*/
function rand_six_num(){
	return mt_rand(100000,999999);
}

/*密码保存16位*/

function substr_pwd($pwd){
	$pwd = md5(md5($pwd));
	if(strlen($pwd) == 32) {
		return substr($pwd, 8, 16);
	}else{
		return $pwd;
	}
	
}

/*取前面几位*/
function substr_str($str){
		return substr($str,0,6);
	}

//开发调试
function show_bug($msg){
	echo "<pre style='color:red'>";
	var_dump($msg);
	echo "</pre>";
	exit();
} 

/** 检测是否有敏感词*/
function check_word($content) {
	$word = D('badword')->field('badword')->select();
	$names = array_column($word, 'badword');
	foreach ($names as $key => $value) {
		if(strpos($content, $value) > -1) {
			return false;
			exit();
		}
	}
	return true;
}

/** 检测是否有特殊用户名*/
function check_nickname($content) {
	$word = str_replace('，',',',C('banned_user'));
	$word = explode(',',$word);	
	foreach ($word as $key => $value) {
		if(stripos($content, $value) > -1) {
			return true;
			exit();
		}
	}
	return false;
}

// 获取广告调用地址
function getadsurl($str,$charset="utf-8"){
	return '<script type="text/javascript" src="'.C('site_url').C('ads_file').'/'.$str.'.js" charset="'.$charset.'"></script>';
}

/**
 * geetest检测验证码
 */
function geetest_chcek_verify($data){
	$geetest_id = C('GEETEST_ID');
	$geetest_key = C('GEETEST_KEY');
	$geetest=new \Geetestlib($geetest_id,$geetest_key);
	$user_id=$_SESSION['geetest']['user_id'];
	if ($_SESSION['geetest']['gtserver']==1) {
		$result=$geetest->success_validate($data['geetest_challenge'], $data['geetest_validate'], $data['geetest_seccode'], $user_id);
		if ($result) {
			return true;
		} else{
			return false;
		}
	}else{
		if ($geetest->fail_validate($data['geetest_challenge'],$data['geetest_validate'],$data['geetest_seccode'])) {
			return true;
		}else{
			return false;
		}
	}
}

//MYSQL版本低于5.5时  启用自定义array_column涵数
if(!function_exists('array_column')){
	function array_column($input, $columnKey, $indexKey = NULL){
		$columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
		$indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
		$indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
		$result = array();
		foreach ((array)$input AS $key => $row){ 
			if ($columnKeyIsNumber){
				$tmp = array_slice($row, $columnKey, 1);
				$tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
			}else{
				$tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
			}
			if(!$indexKeyIsNull){
				if ($indexKeyIsNumber){
					$key = array_slice($row, $indexKey, 1);
					$key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
					$key = is_null($key) ? 0 : $key;
				}else{
					$key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
				}
			}
			$result[$key] = $tmp;
		}
		return $result;
	}
}

// 重写动态路径
function UU($model,$params = array()){
	//rewrite重写
	if(C('rewrite_type')){
		if($model == 'index/index') {
			$reurl = C('home_page');
		}elseif($model == 'index/text'){
			$reurl = C('joke_text');
		}elseif($model == 'index/pic'){
			$reurl = C('joke_pic');
		}elseif($model == 'index/gif'){
			$reurl = C('joke_gif');
		}elseif($model == 'index/video'){
			$reurl = C('joke_video');
		}elseif($model == 'index/hotjoke'){
			$reurl = C('joke_hotjoke');
		}elseif($model == 'hot/index'){
			$reurl = C('joke_hot_hour');
		}elseif($model == 'hot/week'){
			$reurl = C('joke_hot_week');
		}elseif($model == 'hot/month'){
			$reurl = C('joke_hot_month');
		}elseif($model == 'index/godreply'){
			$reurl = C('joke_godreply');
		}elseif($model == 'tags/index'){
			$reurl = C('joke_tags');
		}elseif($model == 'index/subjoke'){
			$reurl = str_replace(array('$id','$parentdir','$listdir'),array($params['id'],$params['parentdir'],$params['listdir']),C('joke_cate'));
		}elseif($model == 'xiaohua/index'){
			$reurl = str_replace(array('$id','$cid','$parentdir','$listdir'),array($params['id'],$params['cid'],$params['parentdir'],$params['listdir']),C('joke_content'));
		}elseif($model == 'tags/info'){
			$reurl = str_replace(array('$id','$parentdir','$listdir'),array($params['id'],$params['parentdir'],$params['listdir']),C('joke_tags_cate'));
		}elseif($model == 'main/index'){
			$reurl = str_replace(array('$id'),array($params['id']),C('joke_user'));
		}elseif($model == 'main/follows'){
			$reurl = str_replace(array('$id'),array($params['id']),C('joke_user_follows'));
		}elseif($model == 'main/fans'){
			$reurl = str_replace(array('$id'),array($params['id']),C('joke_user_fans'));
		}

		//伪静态规则设置正确
		if($reurl){
			if(isset($params['p'])) {
				$reurl = str_replace(array('$currpath','$page'),array($reurl,$params['p']),C('joke_page'));
			}
			return '/'.$reurl.C('url_html_suffix');
		}
		$reurl = str_replace('Home/', '' ,U($model,$params));
		$reurl = str_replace('Wap/', '' ,$reurl);
		//return str_replace('Home/', '' ,U($model,$params));
		return $reurl;
	}
	return U($model,$params);
}

function deleteHtml($str){
	$str=preg_replace("/\s+/", " ", $str); //过滤多余回车
	$str=preg_replace("/<[ ]+/si","<",$str); //过滤<__("<"号后面带空格)	  
	$str=preg_replace("/<\!--.*?-->/si","",$str); //注释
	$str=preg_replace("/<(\!.*?)>/si","",$str); //过滤DOCTYPE
	$str=preg_replace("/<(\/?html.*?)>/si","",$str); //过滤html标签
	$str=preg_replace("/<(\/?head.*?)>/si","",$str); //过滤head标签
	$str=preg_replace("/<(\/?meta.*?)>/si","",$str); //过滤meta标签
	$str=preg_replace("/<(\/?body.*?)>/si","",$str); //过滤body标签
	$str=preg_replace("/<(\/?link.*?)>/si","",$str); //过滤link标签
	$str=preg_replace("/<(\/?form.*?)>/si","",$str); //过滤form标签
	$str=preg_replace("/cookie/si","COOKIE",$str); //过滤COOKIE标签	  
	$str=preg_replace("/<(applet.*?)>(.*?)<(\/applet.*?)>/si","",$str); //过滤applet标签
	$str=preg_replace("/<(\/?applet.*?)>/si","",$str); //过滤applet标签	  
	$str=preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si","",$str); //过滤style标签
	$str=preg_replace("/<(\/?style.*?)>/si","",$str); //过滤style标签	  
	$str=preg_replace("/<(title.*?)>(.*?)<(\/title.*?)>/si","",$str); //过滤title标签
	$str=preg_replace("/<(\/?title.*?)>/si","",$str); //过滤title标签	  
	$str=preg_replace("/<(object.*?)>(.*?)<(\/object.*?)>/si","",$str); //过滤object标签
	$str=preg_replace("/<(\/?objec.*?)>/si","",$str); //过滤object标签	  
	$str=preg_replace("/<(noframes.*?)>(.*?)<(\/noframes.*?)>/si","",$str); //过滤noframes标签
	$str=preg_replace("/<(\/?noframes.*?)>/si","",$str); //过滤noframes标签	  
	$str=preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si","",$str); //过滤frame标签
	$str=preg_replace("/<(\/?i?frame.*?)>/si","",$str); //过滤frame标签	  
	$str=preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si","",$str); //过滤script标签
	$str=preg_replace("/<(\/?script.*?)>/si","",$str); //过滤script标签
	$str=preg_replace("/javascript/si","Javascript",$str); //过滤script标签
	$str=preg_replace("/vbscript/si","Vbscript",$str); //过滤script标签
	$str=preg_replace("/on([a-z]+)\s*=/si","On\\1=",$str); //过滤script标签
	$str=preg_replace("/&#/si","&＃",$str); //过滤script标签，如javAsCript:alert(
	return trim($str);
}