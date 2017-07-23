<?php
/*清空系统缓存*/
function clear_cache(){
	$dirs = array ();
	// runtime/
	$rootdirs = scan_dir( RUNTIME_PATH."*" );
	//$noneed_clear=array(".","..","Data");
	$noneed_clear=array(".","..");
	$rootdirs=array_diff($rootdirs, $noneed_clear);
	foreach ( $rootdirs as $dir ) {			
		if ($dir != "." && $dir != "..") {
			$dir = RUNTIME_PATH . $dir;
			if (is_dir ( $dir )) {
				//array_push ( $dirs, $dir );
				$tmprootdirs = scan_dir ( $dir."/*" );
				foreach ( $tmprootdirs as $tdir ) {
					if ($tdir != "." && $tdir != "..") {
						$tdir = $dir . '/' . $tdir;
						if (is_dir ( $tdir )) {
							array_push ( $dirs, $tdir );
						}else{
							@unlink($tdir);
						}
					}
				}
			}else{
				@unlink($dir);
			}
		}
	}
	$dirtool=new \Dir("");
	foreach ( $dirs as $dir ) {
		$dirtool->delDir ( $dir );
	}
}

/*判断是否为SAE*/
function is_sae(){
	if(defined('APP_MODE') && APP_MODE=='sae'){
		return true;
	}else{
		return false;
	}
}

/**
 * 返回带协议的域名
 */
function get_host(){
	$host=$_SERVER["HTTP_HOST"];
	$protocol=is_ssl()?"https://":"http://";
	return $protocol.$host;
}

/**
 * 替代scan_dir的方法
 * @param string $pattern 检索模式 搜索模式 *.txt,*.doc; (同glog方法)
 * @param int $flags
 */
function scan_dir($pattern,$flags=null){
	$files = array_map('basename',glob($pattern, $flags));
	return $files;
}

/*数据库名称标识*/
function gettablename($tablename){
	if (0 < strpos($tablename, "ads")) {
		return "广告";
	}

	if (0 < strpos($tablename, "comment")) {
		return "评论";
	}

	if (0 < strpos($tablename, "guestbook")) {
		return "留言";
	}

	if (0 < strpos($tablename, "badword")) {
		return "敏感词";
	}

	if (0 < strpos($tablename, "admin")) {
		return "后台用户";
	}

	if (0 < strpos($tablename, "special")) {
		return "专题";
	}

	if (0 < strpos($tablename, "user_audit")) {
		return "会员审核";
	}
	if (0 < strpos($tablename, "user_fans")) {
		return "会员粉丝";
	}
	if (0 < strpos($tablename, "user_msg")) {
		return "会员私信";
	}
	if (0 < strpos($tablename, "user_openid")) {
		return "会员第三方登录";
	}
	if (0 < strpos($tablename, "user_record")) {
		return "会员信息记录";
	}
	if (0 < strpos($tablename, "user_trace")) {
		return "会员消息记录";
	}
	if (0 < strpos($tablename, "user")) {
		return "会员";
	}

	if (0 < strpos($tablename, "slide_type")) {
		return "幻灯片类别";
	}

	if (0 < strpos($tablename, "slide")) {
		return "幻灯片";
	}

	if (0 < strpos($tablename, "link")) {
		return "友情链接";
	}

	if (0 < strpos($tablename, "chain")) {
		return "内链优化";
	}

	if (0 < strpos($tablename, "search")) {
		return "搜索关键词";
	}

	if (0 < strpos($tablename, "tags")) {
		return "Tag标签";
	}

	if (0 < strpos($tablename, "role")) {
		return "角色";
	}

	if (0 < strpos($tablename, "node")) {
		return "权限菜单";
	}

	if (0 < strpos($tablename, "usergroup")) {
		return "会员权限组";
	}

	if (0 < strpos($tablename, "auth_group")) {
		return "管理员组";
	}

	if (0 < strpos($tablename, "joke")) {
		return "笑话内容表";
	}

	if (0 < strpos($tablename, "level")) {
		return "用户等级";
	}
	
	if (0 < strpos($tablename, "shop_cate")) {
		return "商品类别";
	}
	
	if (0 < strpos($tablename, "shop_order")) {
		return "商品订单";
	}

	if (0 < strpos($tablename, "shop")) {
		return "商品";
	}

	if (0 < strpos($tablename, "seo")) {
		return "SEO配置";
	}

	if (0 < strpos($tablename, "menu")) {
		return "笑话类别";
	}

	if (0 < strpos($tablename, "log")) {
		return "管理员登录日志";
	}

	if (0 < strpos($tablename, "mailtpl")) {
		return "邮箱模板";
	}
}
	
/*-------------------文件夹与文件操作开始--------------------*/
//读取文件
function read_file($l1){
	 $ctx = stream_context_create(array('http'=>array('timeout'=>30)));
	return @file_get_contents($l1, 0, $ctx);
}
//写入文件
function write_file($l1, $l2=''){
	$dir = dirname($l1);
	if(!is_dir($dir)){
		mkdirss($dir);
	}
	return @file_put_contents($l1, $l2);
}
//递归创建文件
function mkdirss($dirs,$mode=0777) {
	if(!is_dir($dirs)){
		mkdirss(dirname($dirs), $mode);
		return @mkdir($dirs, $mode);
	}
	return true;
}

/**
 * 功能：计算文件大小
 * @param int $bytes
 * @return string 转换后的字符串
 */
function get_byte($bytes) {
	if (empty($bytes)) {
		return '--';
	}
	$sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $sizetext[$i];
}

//将数组转化为树形数组   
function arrToTree($data,$pid){  
	$tree = array();  
	foreach($data as $k => $v){  
		if($v['pid'] == $pid){  
			$v['pid'] = arrToTree($data,$v['id']);  
			$tree[] = $v;  
		}
	}
	return $tree;  
}

//根据树形数组生成select控件
function outNodeSelect($tree,$currentid){
	$html = '';  
	foreach($tree as $t){    
		if(empty($t['pid'])){
			if($currentid==$t['id']){
				$html.='<option value="'.$t['id'].'" selected="selected">';
			}else{
				$html.='<option value="'.$t['id'].'">';
			}

			for($i=1; $i<$t['level']; $i++) {
				$html.='&nbsp;&nbsp;&nbsp;&nbsp;';
				if($i==$t['level']-1){
					$html.='|-'; 
				}
			}
			$html.=$t['title'];
			$html.='</option>';
		}else{
			if($currentid==$t['id']){
				$html.='<option value="'.$t['id'].'" selected="selected">';
			}else{
				$html.='<option value="'.$t['id'].'">';
			}

			for($i=1; $i<$t['level']; $i++) {
			$html.='&nbsp;&nbsp;&nbsp;&nbsp;'; 
				if($i==$t['level']-1){
					$html.='|-'; 
				}
			}
			$html.=$t['title'];
			$html.='</option>';
			$html.=outNodeSelect($t['pid'],$currentid);
		}
	}   
	return $html;  
}

//输出菜单
function outNode($tree){
	$html = ''; 
	foreach($tree as $t){ 
		$editurl=U('Node/edit',array('id'=>$t['id']));
		$addurl=U('Node/add',array('id'=>$t['id']));
		$delurl=U('Node/foreverdel',array('id'=>$t['id']));
		if(empty($t['pid'])){
			$html.='<tr>';
			$html.='<td class="text-center"><input type="checkbox" name="key" value="'.$t['id'].'"></td>';
			$html.='<td class="text-center">'.$t['id'].'</td>';
			if($t['level']==1){
				$html.='<td style="text-align:left;"><a style="padding-left: '.(($t['level']-1)*20).'px; font-weight: bold;" href="'.$editurl.'">'.$t['title'].'</a></td>';
			}  else {
				$html.='<td style="text-align:left;"><a style="padding-left: '.(($t['level']-1)*20).'px;" href="'.$editurl.'">|-'.$t['title'].'</a></td>';
			}
			$html.='<td class="text-center">'.$t['sort'].'</td>';		

			$html.='<td class="text-center"><div class="btn-group"><a href="'.$addurl.'"><button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 添加子菜单</button></a> <a href="'.$editurl.'"><button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 编辑</button></a> <a href="'.$delurl.'"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-trash-o"></i> 删除</button></a></div></td>';

			$html.='</tr>';
		}else{
			$html.='<tr>';
			$html.='<td class="text-center"><input type="checkbox" name="key" value="'.$t['id'].'"></td>';
			$html.='<td class="text-center">'.$t['id'].'</td>';
			if($t['level']==1){
				$html.='<td style="text-align:left;"><a style="padding-left: '.(($t['level']-1)*20).'px; font-weight: bold;" href="'.$editurl.'">'.$t['title'].'</a></td>';
			}else{
				$html.='<td style="text-align:left;"><a style="padding-left: '.(($t['level']-1)*20).'px;" href="'.$editurl.'">|-'.$t['title'].'</a></td>';
			}
			$html.='<td class="text-center">'.$t['sort'].'</td>';     
			$html.='<td class="text-center"><div class="btn-group"><a href="'.$addurl.'"><button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 添加子菜单</button></a> <a href="'.$editurl.'"><button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 编辑</button></a> <a href="'.$delurl.'"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-trash-o"></i> 删除</button></a></div></td>';
			$html.='</tr>';
			$html.=outNode($t['pid']);
		}
	}   
	return $html;  
}

//输出栏目
function outMenuNode($tree){
	$html = '';  
	foreach($tree as $t){    
		if(empty($t['pid'])){ 
			$url=U($t['modelname'].'/index',array('catid'=>$t['id']));
			$html .= "<li><a href=\"".$url."\">{$t['catname']}</a></li>";
		}else{  
			$html .="<li class=\"m-expanded\"><span>{$t['catname']}</span><ul>";   
			$html .=outMenuNode($t['pid']);  
			$html  = $html.'</ul></li>';  
		}
	}   
	return $html;  
}

//权限组菜单输出
function outMenu($tree,$nodeRoleList){  
	$html = '';  
	foreach($tree as $t){  
		if(in_array($t['id'],$nodeRoleList)){
			if(empty($t['pid'])){  
				$html .= '<li><span class="zjj"></span><input class="J_checkitem" type="checkbox" name="menu_id[]" value="'.$t['id'].'" checked=true class="J_checkitem" level="'.$t['level'].'">&nbsp;'.$t['title'].'</li>';
			}else{  
				$html .= '<li class="m-expanded"><span class="zj"></span><input class="J_checkitem" type="checkbox" name="menu_id[]" value="'.$t['id'].'" checked=true class="J_checkitem" level="'.$t['level'].'"><span>&nbsp;'.$t['title'].'</span><ul>';   
				$html .=outMenu($t['pid'],$nodeRoleList);  
				$html  = $html.'</ul></li>';  
			}  
		}else{
			if(empty($t['pid'])){  
			$html .= '<li><span class="zjj"></span><input class="J_checkitem" type="checkbox" name="menu_id[]" value="'.$t['id'].'" class="J_checkitem" level="'.$t['level'].'">&nbsp;'.$t['title'].'</li>';
			}else{  
			$html .='<li class="m-expanded"><span class="zj"></span><input class="J_checkitem" type="checkbox" name="menu_id[]" value="'.$t['id'].'" class="J_checkitem" level="'.$t['level'].'"><span>&nbsp;'.$t['title'].'</span><ul>';   
			$html .=outMenu($t['pid'],$nodeRoleList);  
			$html  = $html.'</ul></li>';  
			} 
		}
	}   
	return $html;  
}

// 汉字转拼音
function pinyin($str,$ishead=0,$isclose=1){
	$str = u2g($str);//转成GBK
	global $pinyins;
	$restr = '';
	$str = trim($str);
	$slen = strlen($str);
	if($slen<2){
		return $str;
	}
	if(count($pinyins)==0){
		$fp = fopen('./Application/Admin/Conf/pinyin.dat','r');
		while(!feof($fp)){
			$line = trim(fgets($fp));
			$pinyins[$line[0].$line[1]] = substr($line,3,strlen($line)-3);
		}
		fclose($fp);
	}
	for($i=0;$i<$slen;$i++){
		if(ord($str[$i])>0x80){
			$c = $str[$i].$str[$i+1];
			$i++;
			if(isset($pinyins[$c])){
				if($ishead==0){
					$restr .= $pinyins[$c];
				}
				else{
					$restr .= $pinyins[$c][0];
				}
			}else{
				//$restr .= "_";
			}
		}else if( eregi("[a-z0-9]",$str[$i]) ){
			$restr .= $str[$i];
		}
		else{
			//$restr .= "_";
		}
	}
	if($isclose==0){
		unset($pinyins);
	}
	return $restr;
}
//根据ID获取会员组名称
function getgroup($id){
	if(empty($id)){
		return '未知会员组';
	}
	$Role = M("UserGroup");
	$list = $Role->getField('id,name');
	$name = $list [$id];
	return $name;
}

/*根据ID获取角色名称*/
function getRole($id){
	$group = M('AuthGroupAccess')->where('uid='.(int)$id)->find();
	$Role = M("AuthGroup")->where('id='.(int)$group['group_id'])->find();
	return $Role['title'];
}

//系统登录日志
function login_log($msg){
	if($msg){
		$obj=M('log');
		$data['username']=I('post.username');
		$data['content']=$msg;
		$data['ip']=get_client_ip(0,true);
		$data['create_time']=time();
		if($obj->add($data)){
			return true;
		}		
	}
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list,$field, $sortby='asc') {
	if(is_array($list)){
		$refer = $resultSet = array();
		foreach ($list as $i => $data)
			$refer[$i] = &$data[$field];
		switch ($sortby) {
			case 'asc': // 正向排序
			asort($refer);
			break;
		case 'desc':// 逆向排序
			arsort($refer);
			break;
		case 'nat': // 自然排序
			natcasesort($refer);
			break;
		}
		foreach ( $refer as $key=> $val)
		$resultSet[] = &$list[$key];
		return $resultSet;
	}
	return false;
}

/*-------------------------------------------------模板常用函数-----------------------------------------------------------------*/

//根据IP地址获取地理位置
function area($ip){
	$ips = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
	$area = $ips->getlocation($ip); // 获取某个IP地址所在的位置
	return $area['country'];
}

//URL替换
function url_repalce($xmlurl, $order = "asc"){
	if ($order == "asc") {
		return str_replace(array("|", "@", "#", "||"), array("/", "=", "&", "//"), $xmlurl);
	}
	else {
		return str_replace(array("/", "=", "&", "||"), array("|", "@", "#", "//"), $xmlurl);
	}
}

/**
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 * @return string
 */
function byte_format($size, $dec=2){
	$a = array("B", "KB", "MB", "GB", "TB", "PB");
	$pos = 0;
	while ($size >= 1024) {
		 $size /= 1024;
		   $pos++;
	}
	return round($size,$dec)." ".$a[$pos];
}

// 文件大小
function getdirsize($dir){
	$dirlist = opendir($dir);
	while (false !== $folderorfile = readdir($dirlist)) {
		if (($folderorfile != ".") && ($folderorfile != "..")) {
			if (is_dir("$dir/$folderorfile")) {
				$dirsize += getdirsize("$dir/$folderorfile");
			}
			else {
				$dirsize += filesize("$dir/$folderorfile");
			}
		}
	}
	closedir($dirlist);
	return $dirsize;
}

// 获取时间颜色
function getcolordate($type='Y-m-d H:i:s',$time,$color='red'){
	if((time()-$time)>86400){
	    return date($type,$time);
	}else{
	    return '<font color="'.$color.'">'.date($type,$time).'</font>';
	}
}

//百度推送
function pushToBaidu($urls){
	$api =C('site_baidu_api');
	$ch = curl_init();
	$options =  array(
		CURLOPT_URL => $api,
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POSTFIELDS => implode("\n", $urls), //一行一个URL地址
		CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	return $result;
}
//模板文件名识别
function gettplname($filename){
	if ("Public_footer.html" == $filename) {
		return "底部公用模板";
	}else if ("Public_header.html" == $filename) {
		return "顶部公用模板";
	}else if ("Index_index.html" == $filename) {
		return "网站首页模板";
	}else if ("Index_text.html" == $filename) {
		return "段子列表模板";
	}else if ("Index_pic.html" == $filename) {
		return "图片列表模板";
	}else if ("Index_gif.html" == $filename) {
		return "GIF列表模板";
	}else if ("Index_video.html" == $filename) {
		return "视频列表模板";
	}else if ("Index_godreply.html" == $filename) {
		return "神回复列表模板";
	}else if ("Shop_index.html" == $filename) {
		return "积分商城模板";
	}else if ("Shop_detail.html" == $filename) {
		return "积分商城详细模板";
	}else if ("Shop_exchange.html" == $filename) {
		return "积分商城兑换模板";
	}else if ("Joke_publish.html" == $filename) {
		return "发布内容页模板";
	}else if ("Joke_search.html" == $filename) {
		return "搜索列表模板";
	}else if ("Tags_index.html" == $filename) {
		return "笑点列表模板";
	}else if ("Tags_info.html" == $filename) {
		return "笑点内容列表模板";
	}else if ("Xiaohua_index.html" == $filename) {
		return "内容详细模板";
	}else if ("About_shengming.html" == $filename) {
		return "关于我们->免责声明模板";
	}else if ("About_gonggao.html" == $filename) {
		return "关于我们->公告模板";
	}else if ("About_shengao.html" == $filename) {
		return "关于我们->审稿规则模板";
	}else if ("About_tougao.html" == $filename) {
		return "关于我们->发帖规则模板";
	}else if ("About_shengji.html" == $filename) {
		return "关于我们->升级规则模板";
	}else if ("About_jifen.html" == $filename) {
		return "关于我们->积分规则模板";
	}else if ("About_jianjie.html" == $filename) {
		return "关于我们->简介模板";
	}else if ("About_feedback.html" == $filename) {
		return "关于我们->在线留言模板";
	}else if ("Index_app.html" == $filename) {
		return "APP专题模板";
	}else if ("Hot_index.html" == $filename) {
		return "8小时热门模板";
	}else if ("Hot_week.html" == $filename) {
		return "7天热门模板";
	}else if ("Hot_month.html" == $filename) {
		return "30天热门模板";
	}else if ("Account_login.html" == $filename) {
		return "用户登录模板";
	}else if ("Account_register.html" == $filename) {
		return "用户注册模板";
	}else if ("Account_activate.html" == $filename) {
		return "用户激活成功提示模板";
	}else if ("Account_forgetpassword.html" == $filename) {
		return "找回密码模板";
	}else if ("Account_registersuccess.html" == $filename) {
		return "注册成功后邮件验证模板";
	}else if ("Index_hotjoke.html" == $filename) {
		return "热门贴子模板";
	}else if ("Public_404.html" == $filename) {
		return "404错误模板";
	}else if ("Public_success.html" == $filename) {
		return "成功提示跳转模板";
	}else if ("Public_error.html" == $filename) {
		return "成功提示跳转模板";
	}else {
		return "未知文件";
	}
}

function testwrite($d){
	$tfile = "_cmcms.txt";
	$d = ereg_replace("/\$", "", $d);
	$fp = @fopen($d . "/" . $tfile, "w");

	if (!$fp) {
		return false;
	}
	else {
		fclose($fp);
		$rs = @unlink($d . "/" . $tfile);

		if ($rs) {
			return true;
		}
		else {
			return false;
		}
	}
}


/*=================字符串处理开始=========================*/
// 转换成JS
function tojs($l1, $l2=1){
	$I1 = str_replace(array("\r", "\n"), array('', '\n'), addslashes($l1));
	return $l2 ? "document.write(\"$I1\");" : $I1;
}

// 去掉换行
function nr($str){
	$str = str_replace(array("<nr/>","<rr/>"),array("\n","\r"),$str);
	return trim($str);
}
//去掉连续空白
function nb($str){
	$str = str_replace("　",' ',str_replace("&nbsp;",' ',$str));
	$str = eregi_replace("/\n{2,}/",' ',$str);
	return trim($str);
}
// UTF-8转GBK
function u2g($str){
	return iconv("UTF-8","GBK",$str);
}
// GBK转UTF8
function g2u($str){
	return iconv("GBK","UTF-8//ignore",$str);
}