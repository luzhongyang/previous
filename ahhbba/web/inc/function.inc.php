<?php

/**
 * 读文件函数
 * */
function read_file($filename, $method = "rb") {
    if ($handle = @fopen($filename, $method)) {
        @flock($handle, LOCK_SH);
        $filedata = @fread($handle, @filesize($filename));
        @fclose($handle);
    }
    return $filedata;
}

/**
 * 写文件函数
 * */
function write_file($filename, $data, $method = "rb+", $iflock = 1) {
    @touch($filename);
    $handle = @fopen($filename, $method);
    if ($iflock) {
        @flock($handle, LOCK_EX);
    }
    @fputs($handle, $data);
    if ($method == "rb+")
        @ftruncate($handle, strlen($data));
    @fclose($handle);
    @chmod($filename, 0777);
    if (is_writable($filename)) {
        return 1;
    } else {
        return 0;
    }
}

/**
 * 图像处理函数
 * */
function gdpic($srcFile, $dstFile, $width, $height, $type = '') {
    require_once(PHP168_PATH . "inc/waterimage.php");
    if (is_array($type)) {
        //截取一部分,以满足匹配尺寸
        cutimg($srcFile, $dstFile, $x = $type[x] ? $type[x] : 0, $y = $type[y] ? $type[y] : 0, $width, $height, $x2 = $type[x2] ? $type[x2] : 0, $y2 = $type[y2] ? $type[y2] : 0, $scale = $type[s] ? $type[s] : 100, $fix = $type[fix] ? $type[fix] : '');
    } elseif ($type == 1) {
        //成比例的缩放
        ResizeImage($srcFile, $dstFile, $width, $height);
    } else {
        //与尺寸不匹配时.用色彩填充
        gdfillcolor($srcFile, $dstFile, $width, $height);
    }
}

/**
 * 删除文件,值不为空，则返回不能删除的文件名
 * */
function del_file($path) {
    if (file_exists($path)) {
        if (is_file($path)) {
            if (!@unlink($path)) {
                $show.="$path,";
            }
        } else {
            $handle = opendir($path);
            while (($file = readdir($handle)) != '') {
                if (($file != ".") && ($file != "..") && ($file != "")) {
                    if (is_dir("$path/$file")) {
                        $show.=del_file("$path/$file");
                    } else {
                        if (!@unlink("$path/$file")) {
                            $show.="$path/$file,";
                        }
                    }
                }
            }
            closedir($handle);
            if (!@rmdir($path)) {
                $show.="$path,";
            }
        }
    }
    return $show;
}

function Tblank($string, $msg = "内容不能全为空格") {
    $string = str_replace("&nbsp;", "", $string);
    $string = str_replace(" ", "", $string);
    $string = str_replace("　", "", $string);
    $string = str_replace("\r", "", $string);
    $string = str_replace("\n", "", $string);
    $string = str_replace("\t", "", $string);
    if (!$string) {
        showerr($msg);
    }
}

/**
 * 数据表字段信息处理函数
 * */
function table_field($table, $field = '') {
    global $db;
    $query = $db->query(" SELECT * FROM $table limit 1");
    $num = mysql_num_fields($query);
    for ($i = 0; $i < $num; $i++) {
        $f_db = mysql_fetch_field($query, $i);
        $showdb[] = $f_db->name;
    }
    if ($field) {
        if (in_array($field, $showdb)) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return $showdb;
    }
}

/**
 * 判断数据表是否存在
 * */
function is_table($table) {
    global $db;
    $query = $db->query("SHOW TABLE STATUS");
    while ($array = $db->fetch_array($query)) {
        if ($table == $array[Name]) {
            return 1;
        }
    }
}

/**
 * 上传文件
 * */
function upfile($upfile, $array) {
    global $db, $lfjuid, $pre, $webdb, $groupdb, $lfjdb;

    $filename = $array[name];
    $FY = strtolower(strrchr(basename($upfile), "."));
    if ($FY && $FY != '.tmp')
        die("上传文件有误");
    $path = makepath(PHP168_PATH . $array[path]);

    if ($path == 'false') {
        showerr("不能创建目录$array[path]，上传失败", 1);
    } elseif (!is_writable($path)) {
        showerr("目录不可写$path", 1);
    }

    $size = abs($array[size]);

    $filetype = strtolower(strrchr($filename, "."));

    if (!$upfile) {
        showerr("文件不存在，上传失败", 1);
    } elseif (!$filetype) {
        showerr("文件不存在，或文件无后缀名,上传失败", 1);
    } else {
        if ($filetype == '.php' || $filetype == '.asp' || $filetype == '.aspx' || $filetype == '.jsp' || $filetype == '.cgi') {
            showerr("系统不允许上传可执行文件,上传失败", 1);
        }

        if ($groupdb[upfileType] && !in_array($filetype, explode(" ", $groupdb[upfileType]))) {
            showerr("你所上传的文件格式为:$filetype,而你所在用户组仅允许上传的文件格式为:$groupdb[upfileType]", 1);
        } elseif (!in_array($filetype, explode(" ", $webdb[upfileType]))) {
            showerr("你所上传的文件格式为:$filetype,而系统仅允许上传的文件格式为:$webdb[upfileType]", 1);
        }

        if ($groupdb[upfileMaxSize] && ($groupdb[upfileMaxSize] * 1024) < $size) {
            showerr("你所上传的文件大小为:" . ($size / 1024) . "K,而你所在用户组仅允许上传的文件大小为:{$groupdb[upfileMaxSize]}K", 1);
        }
        if (!$groupdb[upfileMaxSize] && $webdb[upfileMaxSize] && ($webdb[upfileMaxSize] * 1024) < $size) {
            showerr("你所上传的文件大小为:" . ($size / 1024) . "K,而系统仅允许上传的文件大小为:{$webdb[upfileMaxSize]}K", 1);
        }
    }
    $oldname = preg_replace("/(.*)\.([^.]*)/is", "\\1", $filename);
    if (eregi("(.jpg|.png|.gif)$", $filetype)) {
        $tempname = "{$lfjuid}_" . date("YmdHms_", time()) . rands(5) . $filetype;
    } else {
        $tempname = "{$lfjuid}_" . date("YmdHms_", time()) . base64_encode(urlencode($oldname)) . $filetype;
    }
    $newfile = "$path/$tempname";

    if (@move_uploaded_file($upfile, $newfile)) {
        @chmod($newfile, 0777);
        $ck = 2;
    }
    if (!$ck) {
        if (@copy($upfile, $newfile)) {
            @chmod($newfile, 0777);
            $ck = 2;
        }
    }
    if ($ck) {
        if ($array[updateTable]) {
            if (($array[size] + $lfjdb[usespace]) > ($webdb[totalSpace] * 1048576 + $groupdb[totalspace] * 1048576 + $lfjdb[totalspace])) {
                unlink($newfile);
                showerr("你的空间不足,上传失败", 1);
            }

            $db->query("UPDATE {$pre}memberdata SET usespace=usespace+'$size' WHERE uid='$lfjuid' ");
        }
        return $tempname;
    } else {
        showerr("请检查空间问题,上传失败", 1);
    }
}

/**
 * 生成目录
 * */
function makepath($path) {
    //这个\没考虑
    $detail = explode("/", $path);
    foreach ($detail AS $key => $value) {
        if ($value == '' && $key != 0) {
            //continue;
        }
        $newpath.="$value/";
        if ((eregi("^\/", $newpath) || eregi(":", $newpath)) && !strstr($newpath, PHP168_PATH)) {
            continue;
        }
        if (!is_dir($newpath)) {
            if (substr($newpath, -1) == '\\' || substr($newpath, -1) == '/') {
                $_newpath = substr($newpath, 0, -1);
            } else {
                $_newpath = $newpath;
            }
            if (!mkdir($_newpath) && !file_exists($_newpath)) {
                return 'false';
            }
            @chmod($newpath, 0777);
        }
    }
    return $path;
}

/**
 * 取得真实目录
 * */
function tempdir($file) {
    global $webdb;
    if (ereg("://", $file)) {
        return $file;
    }
    //镜像点
    elseif ($webdb[mirror] && !file_exists(PHP168_PATH . "$webdb[updir]/$file")) {
        return $webdb[mirror] . "/" . $file;
    } else {
        return $webdb[www_url] . "/" . $webdb[updir] . "/" . $file;
    }
}

/**
 * 截取字符
 * */
function get_word($content, $length, $more = 1) {
    if (!$more) {
        $length = $length + 2;
    }
    if ($length > 10) {
        $length = $length - 2;
    }
    if ($length && strlen($content) > $length) {
        $num = 0;
        for ($i = 0; $i < $length - 1; $i++) {
            if (ord($content[$i]) > 127) {
                $num++;
            }
        }
        $num % 2 == 1 ? $content = substr($content, 0, $length - 2) : $content = substr($content, 0, $length - 1);
        $more && $content.='..';
    }
    return $content;
}

/**
 * 过滤安全字符
 * */
function filtrate($msg) {
    $msg = str_replace('&amp;', '&', $msg);
    $msg = str_replace('&nbsp;', ' ', $msg);
    $msg = str_replace('"', '&quot;', $msg);
    $msg = str_replace("'", '&#39;', $msg);
    $msg = str_replace("<", "&lt;", $msg);
    $msg = str_replace(">", "&gt;", $msg);
    $msg = str_replace("\t", "   &nbsp;  &nbsp;", $msg);
    $msg = str_replace("\r", "", $msg);
    $msg = str_replace("   ", " &nbsp; ", $msg);
    return $msg;
}

/* 过滤不健康的字 */

function replace_bad_word($str) {
    @include(PHP168_PATH . "php168/limitword.php");
    $Limitword || $Limitword = array();
    foreach ($Limitword AS $old => $new) {
        $str = str_replace($old, "^$new", $str);
    }
    return $str;
}

/**
 * 取固定图片大小
 * */
function pic_size($pic, $w, $h, $url) {
    global $updir, $webdb, $N_path;
    $rand = rands(5);
    $show = "<script>
			function resizeimage_$rand(obj) {
				var imageObject;
				var MaxW = $w;
				var MaxH = $h;
				imageObject = obj;
				var oldImage = new Image();
				oldImage.src = imageObject.src;
				var dW = oldImage.width;
				originalw=dW;
				var dH = oldImage.height;
				originalh=dH;
				if (dW>MaxW || dH>MaxH) {
					a = dW/MaxW;
					b = dH/MaxH;
					if (b>a) {
						a = b;
					}
					dW = dW/a;
					dH = dH/a;
				}
				if (dW>0 && dH>0) {
					imageObject.width = dW;
					imageObject.height = dH;
				}
			}
			</script>";
    return "$show<a href='$url' target='_blank'><img onload='resizeimage_$rand(this)' src='$pic' border=0 width='$w' height='$h'></a>";
}

/**
 * 模板相关函数
 * */
function html($html, $tpl = '') {
    global $STYLE;
    if ($tpl && strstr($tpl, PHP168_PATH) && file_exists($tpl)) {
        return $tpl;
    } elseif ($tpl && file_exists(PHP168_PATH . $tpl)) {
        return PHP168_PATH . $tpl;
    } elseif (file_exists(PHP168_PATH . "template/" . $STYLE . "/" . $html . ".htm")) {
        return PHP168_PATH . "template/" . $STYLE . "/" . $html . ".htm";
    } else {
        return PHP168_PATH . "template/default/" . $html . ".htm";
    }
}

/**
 * 分页
 * */
function getpage($table, $choose, $url, $rows = 20, $total = '') {
    global $page, $db;
    if (!$page) {
        $page = 1;
    }
    //当存在$total的时候.就不用再读数据库
    if (!$total && $table) {
        $query = $db->get_one("SELECT COUNT(*) AS num  FROM $table $choose");
        $total = $query['num'];
    }
    $totalpage = @ceil($total / $rows);
    $nextpage = $page + 1;
    $uppage = $page - 1;
    if ($nextpage > $totalpage) {
        $nextpage = $totalpage;
    }
    if ($uppage < 1) {
        $uppage = 1;
    }
    $s = $page - 3;
    if ($s < 1) {
        $s = 1;
    }
    $b = $s;
    for ($ii = 0; $ii < 6; $ii++) {
        $b++;
    }
    if ($b > $totalpage) {
        $b = $totalpage;
    }
    for ($j = $s; $j <= $b; $j++) {
        if ($j == $page) {
            $show.=" <a href='#'><font color=red>$j</font></a>";
        } else {
            $show.=" <a href=\"$url&page=$j\" title=\"第{$j}页\">$j</a>";
        }
    }
    $showpage = "<a href=\"$url&page=1\" title=\"首页\">&lt;&lt;</A> <a href=\"$url&page=$uppage\" title=\"上一页\">&lt;</A>  {$show}  <a href=\"$url&page=$nextpage\" title=\"下一页\">&gt;</A> <a href=\"$url&page=$totalpage\" title=\"尾页\">&gt;&gt;</A> <a href='#'><font color=red>$page</font>/$totalpage</a>";
    if ($totalpage > 1) {
        return $showpage;
    }
}

/**
 * 页面跳转函数
 * */
function refreshto($url, $msg, $time = 1) {
    if ($time == 0) {
        header("location:$url");
    } else {
        require(PHP168_PATH . "template/default/refreshto.htm");
    }
    exit;
}

/**
 * 警告页面函数
 * */
function showerr($msg, $type = '') {
    require_once(PHP168_PATH . "php168/level.php");
    if ($type == 1) {
        $msg = str_replace("'", "\'", $msg);
        echo "<SCRIPT LANGUAGE=\"JavaScript\">
		<!--
		alert('$msg');
		history.back(-1);
		//-->
		</SCRIPT>";
    } else {
        extract($GLOBALS);
        require(PHP168_PATH . "template/default/showerr.htm");
    }
    exit;
}

/**
 * 取得随机字符
 * */
function rands($length) {
    $hash = '';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($chars) - 1;
    mt_srand((double) microtime() * 1000000);
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 简体中文转UTF8编码
 * */
function gbk2utf8($text) {
    $fp = fopen(PHP168_PATH . "inc/gbkcode/gbk2utf8.table", "r");
    while (!feof($fp)) {
        list($gb, $utf8) = fgetcsv($fp, 10);
        $charset[$gb] = $utf8;
    }
    fclose($fp);  //以上读取对照表到数组备用wl__hd_sg2_02.gif
    //提取文本中的成分，汉字为一个元素，连续的非汉字为一个元素
    preg_match_all("/(?:[\x80-\xff].)|[\x01-\x7f]+/", $text, $tmp);
    $tmp = $tmp[0];
    //分离出汉字
    $ar = array_intersect($tmp, array_keys($charset));
    //替换汉字编码
    foreach ($ar as $k => $v)
        $tmp[$k] = $charset[$v];
    //返回换码后的串
    return join('', $tmp);
}

/**
 * 各模块的评论
 * */
function list_comments($SQL, $which = '*', $leng = 400) {
    global $db, $pre;
    $query = $db->query("SELECT $which FROM `{$pre}comments` $SQL");
    while ($rs = $db->fetch_array($query)) {
        if (!$rs[username]) {
            $detail = explode(".", $rs[ip]);
            $rs[username] = "$detail[0].$detail[1].$detail[2].*";
        }
        $rs[posttime] = date("Y-m-d H:i:s", $rs[posttime]);
        $rs[content] = get_word($rs[full_content] = $rs[content], $leng);
        $rs[content] = str_replace("\n", "<br>", $rs[content]);
        $listdb[] = $rs;
    }
    return $listdb;
}

/* 取得表的类型 */

function get_table($type) {
    global $pre;
    if ($type == "0" || $type == "article") {
        $array = array("id" => "0", "sort" => "{$pre}sort", "c" => "{$pre}article", "key" => "article", "name" => "文章");
    } elseif ($type == "1" || $type == "log") {
        $array = array("id" => "1", "sort" => "{$pre}log_sort", "c" => "{$pre}log_article", "key" => "log", "name" => "日志");
    } elseif ($type == "2" || $type == "down" || $type == "download") {
        $array = array("id" => "2", "sort" => "{$pre}down_sort", "c" => "{$pre}down_software", "key" => "down", "name" => "下载");
    } elseif ($type == "3" || $type == "photo") {
        $array = array("id" => "3", "sort" => "{$pre}photo_sort", "c" => "{$pre}photo_pic", "key" => "photo", "name" => "相片");
    } elseif ($type == "4" || $type == "mv" || $type == "video") {
        $array = array("id" => "4", "sort" => "{$pre}mv_sort", "c" => "{$pre}mv_video", "key" => "mv", "name" => "视频");
    } elseif ($type == "5" || $type == "shop") {
        $array = array("id" => "5", "sort" => "{$pre}shop_sort", "c" => "{$pre}shop_product", "key" => "shop", "name" => "商城");
    } elseif ($type == "6" || $type == "music" || $type == "song") {
        $array = array("id" => "6", "sort" => "{$pre}music_sort", "c" => "{$pre}music_song", "key" => "music", "name" => "音乐");
    } elseif ($type == "7" || $type == "flash") {
        $array = array("id" => "7", "sort" => "{$pre}flash_sort", "c" => "{$pre}flash_swf", "key" => "flash", "name" => "FLASH");
    }
    return $array;
}

/**
 * 加密与解密函数
 * */
function mymd5($string, $action = "EN") { //字符串加密和解密 
    global $webdb, $onlineip;
    $secret_string = $webdb[mymd5] . '5*j,.^&;?.%#@!'; //绝密字符串,可以任意设定 

    if ($string == "")
        return "";
    if ($action == "EN")
        $md5code = substr(md5($string), 8, 10);
    else {
        $md5code = substr($string, -10);
        $string = substr($string, 0, strlen($string) - 10);
    }
    //$key = md5($md5code.$_SERVER["HTTP_USER_AGENT"].$secret_string);
    $key = md5($md5code . $secret_string);
    $string = ($action == "EN" ? $string : base64_decode($string));
    $len = strlen($key);
    $code = "";
    for ($i = 0; $i < strlen($string); $i++) {
        $k = $i % $len;
        $code .= $string[$i] ^ $key[$k];
    }
    $code = ($action == "DE" ? (substr(md5($code), 8, 10) == $md5code ? $code : NulL) : base64_encode($code) . "$md5code");
    return $code;
}

function pwd_md5($code) {
    global $webdb;
    //动网论坛有点另类
    //if(ereg("^dvbbs",$webdb[passport_type])){
    //	return substr(md5($code),8,16);
    //}else{
    return md5($code);
    //}
}

function set_cookie($name, $value, $cktime = 0) {
    global $webdb;
    if ($cktime != 0) {
        $cktime = time() + $cktime;
    }
    if ($value == '') {
        $cktime = time() - 31536000;
    }
    $S = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
    if ($webdb[cookiePath]) {
        $path = $webdb[cookiePath];
    } else {
        $path = "/";
    }
    $domain = $webdb[cookieDomain];
    setCookie("$webdb[cookiePre]$name", $value, $cktime, $path, $domain, $S);
}

function get_cookie($name) {
    global $webdb;
    return $_COOKIE["$webdb[cookiePre]$name"];
}

/**
 * 取得用户数据
 * */
function User_db() {
    global $db, $timestamp, $webdb, $onlineip, $TB, $pre;
    list($lfjuid, $lfjid, $lfjpwd) = explode("\t", get_cookie('passport'));
    if (!$lfjuid || !$lfjpwd) {
        return '';
    }
    $detail = $db->get_one("SELECT M.$TB[username] AS username,M.$TB[password] AS password,D.* FROM $TB[table] M LEFT JOIN {$pre}memberdata D ON M.$TB[uid]=D.uid WHERE M.$TB[uid]='$lfjuid' ");
    if (mymd5($detail[password]) != $lfjpwd) {
        setcookie('passport', '', 0, '/');
        return '';
    }
    if ($webdb[passport_type] && !$detail[uid]) {
        Add_memberdata($detail[username]);
    }
    return $detail;
}

function add_user($uid, $money) {
    global $db, $pre, $timestamp, $webdb, $pre;
    //$db->query(" UPDATE {$pre}memberdata SET money=money+'$webdb[postArticleMoney]' WHERE uid='$uid' ");
    plus_money($uid, $money, $moneytype = '');
}

function blog_jump($uid, $fid, $id) {
    
}

//sock方式打开远程文件
function sockOpenUrl($url, $method = 'GET', $postValue = '') {
    $method = strtoupper($method);
    if (!$url) {
        return '';
    } elseif (!ereg("://", $url)) {
        $url = "http://$url";
    }
    $urldb = parse_url($url);
    $port = $urldb[port] ? $urldb[port] : 80;
    $host = $urldb[host];
    $query = '?' . $urldb[query];
    $path = $urldb[path] ? $urldb[path] : '/';
    $method = $method == 'GET' ? "GET" : 'POST';

    $fp = fsockopen($host, 80, $errno, $errstr, 30);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
    } else {
        $out = "$method $path$query HTTP/1.1\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Cookie: c=1;c2=2\r\n";
        $out .= "Referer: $url\r\n";
        $out .= "Accept: */*\r\n";
        $out .= "Connection: Close\r\n";
        if ($method == "POST") {
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $length = strlen($postValue);
            $out .= "Content-Length: $length\r\n";
            $out .= "\r\n";
            $out .= $postValue;
        } else {
            $out .= "\r\n";
        }
        fwrite($fp, $out);
        while (!feof($fp)) {
            $file.= fgets($fp, 256);
        }
        fclose($fp);
        if (!$file) {
            return '';
        }
        $ck = 0;
        $string = '';
        $detail = explode("\r\n", $file);
        foreach ($detail AS $key => $value) {
            if ($value == '') {
                $ck++;
                if ($ck == 1) {
                    continue;
                }
            }
            if ($ck) {
                $stringdb[] = $value;
            }
        }
        $string = implode("\r\n", $stringdb);
        //$string=preg_replace("/([\d]+)(.*)0/is","\\2",$string);
        return $string;
    }
}

/* 统计附件 */

function get_content_attachment($str) {
    global $webdb;
    $rule = str_replace("/", "\/", $webdb[www_url]);
    $rule = str_replace(".", "\.", $rule);
    preg_match_all("/$rule\/([a-z_\.0-9A-Z]+)\/([a-z_\.\/0-9A-Z=]+)/is", $str, $array);
    $filedb = $array[2];
    return $filedb;
}

/* 删除附件 */

function delete_attachment($uid, $str) {
    global $webdb, $db, $pre;
    if (!$str || !$uid) {
        return;
    }
    //真实地址还原
    $str = En_TruePath($str, 0);

    $filedb = get_content_attachment($str);
    foreach ($filedb AS $key => $value) {
        $name = basename($value);
        $detail = explode("_", $name);
        //获取文件的UID与用户的UID一样时.才删除.不要乱删除
        if ($detail[0] && $detail[0] == $uid) {
            $turepath = PHP168_PATH . $webdb[updir] . "/" . $value;
            $size = @filesize($turepath);
            if ($size && @unlink($turepath)) {
                $db->query(" UPDATE {$pre}memberdata SET usespace=usespace-'$size' WHERE uid='$uid' ");
            }
            //ftp_delfile($value);
        }
    }
}

/* 移动附件 */

function move_attachment($uid, $str, $newdir) {
    global $webdb, $db, $pre;
    if (!$str || !$uid || !$newdir) {
        return $str;
    }
    $filedb = get_content_attachment($str);
    foreach ($filedb AS $key => $value) {
        $name = basename($value);
        $detail = explode("_", $name);
        //获取文件的UID与用户的UID一样时.才删除.不要乱删除
        if ($detail[0] && $detail[0] == $uid) {
            $turepath = PHP168_PATH . $webdb[updir] . "/" . $value;
            if (!is_dir(PHP168_PATH . $webdb[updir] . "/" . $newdir)) {
                makepath(PHP168_PATH . $webdb[updir] . "/" . $newdir);
            }
            //图片加水印
            if ($webdb[is_waterimg] && (eregi(".gif$", $turepath) || eregi(".jpg$", $turepath))) {
                include_once(PHP168_PATH . "inc/waterimage.php");
                imageWaterMark($turepath, $webdb[waterpos], PHP168_PATH . $webdb[waterimg]);
            }
            if (@rename($turepath, PHP168_PATH . $webdb[updir] . "/$newdir/$name")) {
                $str = str_replace("$value", "$newdir/$name", $str);
            }
        }
    }
    return $str;
}

//对真实地址做处理
function En_TruePath($content, $type = 1) {
    global $webdb;
    if ($type == 1) {
        $content = str_replace("$webdb[www_url]/$webdb[updir]", "http://www_php168_com/Tmp_updir", $content);
        $content = str_replace("$webdb[www_url]", "http://www_php168_com", $content);
    } else {
        $content = str_replace("http://www_php168_com/Tmp_updir", "$webdb[www_url]/$webdb[updir]", $content);
        $content = str_replace("http://www_php168_com", "$webdb[www_url]", $content);
    }
    return $content;
}

function Get_SonFid($table, $fid = 0) {
    global $db;
    $query = $db->query("SELECT fid,sons FROM $table WHERE fup=$fid");
    while ($rs = $db->fetch_array($query)) {
        if ($rs[sons]) {
            $array2 = Get_SonFid($table, $rs[fid]);
            if ($array2) {
                foreach ($array2 AS $key => $value) {
                    $array[] = $value;
                }
            }
        }
        $array[] = $rs[fid];
    }
    return $array;
}

/* 文件缓存 */

function php_cache($dirname, $cacheTime, $type) {
    global $webdb, $content, $jobs;
    if (!$cacheTime || $jobs == 'show') {
        return;
    }
    if ($type == 1) {
        $cacheTime = $cacheTime * 60;
        if (time() - filemtime(PHP168_PATH . "cache/php_cache/$dirname.htm") < $cacheTime) {
            include_once(PHP168_PATH . "cache/php_cache/$dirname.htm");
            exit;
        }
    } elseif ($type == 2) {

        makepath(dirname(PHP168_PATH . "cache/php_cache/$dirname"));
        write_file(PHP168_PATH . "cache/php_cache/$dirname.htm", $content);
    }
}

//静态网页处理
function Explain_HtmlUrl() {
    global $fid, $aid, $id, $page, $WEBURL;
    $detail = explode("fid-", $WEBURL);
    $detail2 = explode(".", $detail[1]);
    $rs = explode("-", $detail2[0]);
    $fid = $rs[0];     //LIST页的fid,bencandy页的fid
    $rs[1] && $$rs[1] = $rs[2];  //可能是LIST页的PAGE,也可能是bencandy页的id
    $rs[3] && $$rs[3] = $rs[4];  //bencandy页的page
}

//获取用户积分
function get_money($uid, $moneytype = '') {
    global $db, $pre, $_pre, $webdb, $TB_pre, $lfjdb;

    if ($moneytype == '') {
        $moneytype = 'money';
    }

    if ($webdb[UseMoneyType] == 'bbs' && $webdb[passport_type]) {
        if (eregi("^pwbbs", $webdb[passport_type])) {
            $rs = $db->get_one("SELECT * FROM {$TB_pre}memberdata WHERE uid='$uid'");
            return $rs[$moneytype];
        } elseif (eregi("^dzbbs", $webdb[passport_type])) {
            $rs = $db->get_one("SELECT * FROM {$TB_pre}members WHERE uid='$uid'");
            return $rs[extcredits1];
        }
    } else {
        if ($lfjdb[uid] == $uid) {
            return $lfjdb[money];
        } else {
            $rs = $db->get_one("SELECT * FROM {$pre}memberdata WHERE uid='$uid'");
            return $rs[money];
        }
    }
}

//增减用户积分
function plus_money($uid, $money, $moneytype = '') {
    global $db, $pre, $_pre, $webdb, $TB_pre, $lfjdb;

    if ($moneytype == '') {
        $moneytype = 'money';
    }

    if ($webdb[UseMoneyType] == 'bbs') {
        if (eregi("^pwbbs", $webdb[passport_type])) {
            $db->query("UPDATE {$TB_pre}memberdata SET $moneytype=$moneytype+'$money' WHERE uid='$uid'");
        } elseif (eregi("^dzbbs", $webdb[passport_type])) {
            $db->query("UPDATE {$TB_pre}members SET extcredits1=extcredits1+'$money' WHERE uid='$uid'");
        }
    } else {
        $db->query("UPDATE {$pre}memberdata SET money=money+'$money' WHERE uid='$uid'");
    }
}

/* 页面显示,强制过滤关键字 */

function kill_badword($content) {
    global $webdb, $Limitword;
    if ($webdb[kill_badword]) {
        if (!$content) {
            $content = ob_get_contents();
            $ck++;
        }

        @include_once(PHP168_PATH . "php168/limitword.php");

        foreach ($Limitword AS $key => $value) {
            $content = str_replace($key, $value, $content);
        }
        if ($ck) {
            ob_end_clean();
            ob_start();
            echo $content;
        } else {
            return $content;
        }
    } else {
        return $content;
    }
}

//发站内消息
function pm_msgbox($array) {
    global $db, $pre, $timestamp, $webdb, $TB_pre, $TB;
    if (ereg("^pwbbs", $webdb[passport_type])) {
        if (strlen($array[title]) > 130) {
            showerr("标题不能大于65个汉字");
        }
        if (is_table("{$TB_pre}msgc")) {
            $db->query("INSERT INTO `{$TB_pre}msg` (`touid`,`fromuid`, `username`, `type`, `ifnew`, `mdate`) VALUES ('$array[touid]','$array[fromuid]', '$array[fromer]', 'rebox', '1', '$timestamp')");
            $mid = $db->insert_id();
            $db->query("INSERT INTO `{$TB_pre}msgc` (`mid`, `title`, `content`) VALUES ('$mid','$array[title]','$array[content]')");
            $db->query("UPDATE $TB[table] SET newpm=1 WHERE uid='$array[touid]'");
        } else {
            $db->query("INSERT INTO `{$TB_pre}msg` (`touid`,`fromuid`, `username`, `type`, `ifnew`, `title`, `mdate`, `content`) VALUES ('$array[touid]','$array[fromuid]', '$array[fromer]', 'rebox', '1', '$array[title]', '$timestamp', '$array[content]')");
            $db->query("UPDATE $TB[table] SET newpm=1 WHERE uid='$array[touid]'");
        }
    } elseif (ereg("^dzbbs7", $webdb[passport_type])) {
        if (strlen($array[title]) > 75) {
            showerr("标题不能大于32个汉字");
        }
        uc_pm_send('$array[fromuid]', '$array[touid]', '$array[title]', '$array[content]', 1, 0, 1);
    } elseif (ereg("^dzbbs", $webdb[passport_type])) {
        if (strlen($array[title]) > 75) {
            showerr("标题不能大于32个汉字");
        }
        $db->query("INSERT INTO `{$TB_pre}pms` ( `msgfrom`, `msgfromid`, `msgtoid`, `folder`, `new`, `subject`, `dateline`, `message`) VALUES ( '$array[fromer]', '$array[fromuid]', '$array[touid]', 'inbox', 1, '$array[title]', '$timestamp', '$array[content]')");
        $db->query("UPDATE $TB[table] SET newpm=1 WHERE uid='$array[touid]'");
    } else {
        if (strlen($array[title]) > 130) {
            showerr("标题不能大于65个汉字");
        }
        $db->query("INSERT INTO `{$pre}pm` (`touid`,`fromuid`, `username`, `type`, `ifnew`, `title`, `mdate`, `content`) VALUES ('$array[touid]','$array[fromuid]', '$array[fromer]', 'rebox', '1', '$array[title]', '$timestamp', '$array[content]')");
        //$db->query("UPDATE `{$pre}memberdata` SET newpm=1 WHERE uid='$array[touid]'");
    }
}

//删除文章的函数
function delete_article($aid, $rid, $forcedel = 0) {
    global $db, $pre, $webdb;
    if ($rid) {
        $rsdb = $db->get_one("SELECT R.*,A.* FROM {$pre}article A LEFT JOIN {$pre}reply R ON A.aid=R.aid WHERE R.rid='$rid'");
    } elseif ($aid) {
        $rsdb = $db->get_one("SELECT R.*,A.* FROM {$pre}article A LEFT JOIN {$pre}reply R ON A.aid=R.aid WHERE A.aid='$aid' ORDER BY R.rid ASC LIMIT 1");
        if (!$rsdb[rid]) {
            $db->query("DELETE FROM {$pre}article WHERE aid='$aid'");
        }
    }
    if (!$rsdb) {
        return;
    }
    if ($rsdb[topic]) {
        if ($forcedel || $webdb[ForceDel]) {
            $rsdb[picurl] && delete_attachment($rsdb[uid], tempdir($rsdb[picurl]));
            $query = $db->query("SELECT * FROM {$pre}reply WHERE aid='$rsdb[aid]'");
            while ($rs = $db->fetch_array($query)) {
                delete_attachment($rs[uid], $rs[content]);
            }
            if ($rsdb[mid]) {
                $db->query("DELETE FROM {$pre}article_content_$rsdb[mid] WHERE aid='$rs[aid]'");
            }
            $db->query("DELETE FROM {$pre}collection WHERE aid='$rsdb[aid]' ");
            $db->query("DELETE FROM {$pre}article WHERE aid='$rsdb[aid]' ");
            $db->query("DELETE FROM {$pre}reply WHERE aid='$rsdb[aid]' ");
            //财富处理
            Give_article_money($rsdb[uid], 'del');
            if ($rsdb[levels]) {
                Give_article_money($rsdb[uid], 'uncom');
            }
        } else {
            $db->query("UPDATE {$pre}article SET yz=2 WHERE aid='$rsdb[aid]'");
        }
    } else {
        $db->query("DELETE FROM {$pre}reply WHERE rid='$rsdb[rid]'");
        delete_attachment($rsdb[uid], $rsdb[content]);
        if ($rsdb[mid]) {
            $db->query("DELETE FROM {$pre}article_content_$rsdb[mid] WHERE rid='$rsdb[rid]'");
        }
        $db->query("UPDATE {$pre}article SET pages=pages-1 WHERE aid='$rsdb[aid]'");
    }
}

function get_html_url() {
    global $rsdb, $aid, $rid, $fidDB, $webdb, $fid, $page;
    $id = $aid;
    if ($page < 1) {
        $page = 1;
    }
    $postdb[posttime] = $rsdb[posttime];
    if ($fidDB[bencandy_html]) {
        $filename_b = $fidDB[bencandy_html];
    } else {
        $filename_b = $webdb[bencandy_filename];
    }
    $dirid = floor($aid / 1000);
    if (strstr($filename_b, '$time_')) {
        $time_Y = date("Y", $postdb[posttime]);
        $time_y = date("y", $postdb[posttime]);
        $time_m = date("m", $postdb[posttime]);
        $time_d = date("d", $postdb[posttime]);
        $time_W = date("W", $postdb[posttime]);
        $time_H = date("H", $postdb[posttime]);
        $time_i = date("i", $postdb[posttime]);
        $time_s = date("s", $postdb[posttime]);
    }
    if ($fidDB[list_html]) {
        $filename_l = $fidDB[list_html];
    } else {
        $filename_l = $webdb[list_filename];
    }
    eval("\$array[showurl]=\"$filename_b\";");
    if ($page == 1) {
        if ($webdb[DefaultIndexHtml] == 1) {
            $filename_l = preg_replace("/(.*)\/([^\/]+)/is", "\\1/index.html", $filename_l);
        } else {
            $filename_l = preg_replace("/(.*)\/([^\/]+)/is", "\\1/index.htm", $filename_l);
        }
    }
    eval("\$array[listurl]=\"$filename_l\";");
    return $array;
}

function Remind_msg($MSG) {
    echo "<SCRIPT LANGUAGE='JavaScript'>
	<!--
	alert('$MSG');
	//-->
	</SCRIPT>";
}

function make_module_cache() {
    global $db, $pre;
    $show = "<?php\r\n";
    $query = $db->query("SELECT * FROM {$pre}module ORDER BY list DESC");
    while ($rs = $db->fetch_array($query)) {
        $rs[name] = addslashes($rs[name]);

        $rs[config] = str_replace("'", "\'", $rs[config]);
        $rs[name] = str_replace("'", "\'", $rs[name]);

        $show.="
			\$ModuleDB['{$rs[pre]}']=array('name'=>'$rs[name]',
				'dirname'=>'$rs[dirname]',
				'domain'=>'$rs[domain]',
				'admindir'=>'$rs[admindir]',
				'type'=>'$rs[type]',
				'config'=>'$rs[config]',
				'adminmember'=>'$rs[adminmember]',
				'unite_member'=>'$rs[unite_member]',
				'id'=>'$rs[id]'
			);
			";
    }
    write_file(PHP168_PATH . "php168/module.php", $show);
}

//获取浏览器类型
function browseinfo() {
    $browser = "";
    $browserver = "";
    $Browsers = array("Lynx", "MOSAIC", "AOL", "Opera", "JAVA", "MacWeb", "WebExplorer", "OmniWeb");
    $Agent = $_SERVER["HTTP_USER_AGENT"] ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_SERVER_VARS["HTTP_USER_AGENT"];
    for ($i = 0; $i <= 7; $i++) {
        if (strpos($Agent, $Browsers[$i])) {
            $browser = $Browsers[$i];
            $browserver = "";
        }
    }
    if (ereg("Mozilla", $Agent) && !ereg("MSIE", $Agent)) {
        $temp = explode("(", $Agent);
        $Part = $temp[0];
        $temp = explode("/", $Part);
        $browserver = $temp[1];
        $temp = explode(" ", $browserver);
        $browserver = $temp[0];
        $browserver = preg_replace("/([\d\.]+)/", "\\1", $browserver);
        $browserver = " $browserver";
        $browser = "Netscape Navigator";
    }
    if (ereg("Mozilla", $Agent) && ereg("Opera", $Agent)) {
        $temp = explode("(", $Agent);
        $Part = $temp[1];
        $temp = explode(")", $Part);
        $browserver = $temp[1];
        $temp = explode(" ", $browserver);
        $browserver = $temp[2];
        $browserver = preg_replace("/([\d\.]+)/", "\\1", $browserver);
        $browserver = " $browserver";
        $browser = "Opera";
    }
    if (ereg("Mozilla", $Agent) && ereg("MSIE", $Agent)) {
        $temp = explode("(", $Agent);
        $Part = $temp[1];
        $temp = explode(";", $Part);
        $Part = $temp[1];
        $temp = explode(" ", $Part);
        $browserver = $temp[2];
        $browserver = preg_replace("/([\d\.]+)/", "\\1", $browserver);
        $browserver = " $browserver";
        $browser = "IE";
    }
    if ($browser != "") {
        $browseinfo = "$browser$browserver";
    } else {
        $browseinfo = "未知的浏览器";
    }
    return $browseinfo;
}

//获取操作系统类型
function osinfo() {
    $os = "";
    $Agent = $_SERVER["HTTP_USER_AGENT"] ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_SERVER_VARS["HTTP_USER_AGENT"];
    if (eregi('win', $Agent) && strpos($Agent, '95')) {
        $os = "Windows 95";
    } elseif (eregi('win 9x', $Agent) && strpos($Agent, '4.90')) {
        $os = "Windows ME";
    } elseif (eregi('win', $Agent) && ereg('98', $Agent)) {
        $os = "Windows 98";
    } elseif (eregi('win', $Agent) && eregi('nt 5\.0', $Agent)) {
        $os = "Windows 2000";
    } elseif (eregi('win', $Agent) && eregi('nt 5\.1', $Agent)) {
        $os = "Windows XP";
    } elseif (eregi('win', $Agent) && eregi('nt', $Agent)) {
        $os = "Windows NT";
    } elseif (eregi('win', $Agent) && ereg('32', $Agent)) {
        $os = "Windows 32";
    } elseif (eregi('linux', $Agent)) {
        $os = "Linux";
    } elseif (eregi('unix', $Agent)) {
        $os = "Unix";
    } elseif (eregi('sun', $Agent) && eregi('os', $Agent)) {
        $os = "SunOS";
    } elseif (eregi('ibm', $Agent) && eregi('os', $Agent)) {
        $os = "IBM OS/2";
    } elseif (eregi('Mac', $Agent) && eregi('PC', $Agent)) {
        $os = "Macintosh";
    } elseif (eregi('PowerPC', $Agent)) {
        $os = "PowerPC";
    } elseif (eregi('AIX', $Agent)) {
        $os = "AIX";
    } elseif (eregi('HPUX', $Agent)) {
        $os = "HPUX";
    } elseif (eregi('NetBSD', $Agent)) {
        $os = "NetBSD";
    } elseif (eregi('BSD', $Agent)) {
        $os = "BSD";
    } elseif (ereg('OSF1', $Agent)) {
        $os = "OSF1";
    } elseif (ereg('IRIX', $Agent)) {
        $os = "IRIX";
    } elseif (eregi('FreeBSD', $Agent)) {
        $os = "FreeBSD";
    }
    if ($os == '')
        $os = "Unknown";
    return $os;
}

function ipfrom($ip) {
    if (!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
        return '';
    }

    if ($fd = @fopen(PHP168_PATH . 'ip.dat', 'rb')) {

        $ip = explode('.', $ip);
        $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

        $DataBegin = fread($fd, 4);
        $DataEnd = fread($fd, 4);
        $ipbegin = implode('', unpack('L', $DataBegin));
        if ($ipbegin < 0)
            $ipbegin += pow(2, 32);
        $ipend = implode('', unpack('L', $DataEnd));
        if ($ipend < 0)
            $ipend += pow(2, 32);
        $ipAllNum = ($ipend - $ipbegin) / 7 + 1;

        $BeginNum = 0;
        $EndNum = $ipAllNum;

        while ($ip1num > $ipNum || $ip2num < $ipNum) {
            $Middle = intval(($EndNum + $BeginNum) / 2);

            fseek($fd, $ipbegin + 7 * $Middle);
            $ipData1 = fread($fd, 4);
            if (strlen($ipData1) < 4) {
                fclose($fd);
                return '- System Error';
            }
            $ip1num = implode('', unpack('L', $ipData1));
            if ($ip1num < 0)
                $ip1num += pow(2, 32);

            if ($ip1num > $ipNum) {
                $EndNum = $Middle;
                continue;
            }

            $DataSeek = fread($fd, 3);
            if (strlen($DataSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $DataSeek = implode('', unpack('L', $DataSeek . chr(0)));
            fseek($fd, $DataSeek);
            $ipData2 = fread($fd, 4);
            if (strlen($ipData2) < 4) {
                fclose($fd);
                return '- System Error';
            }
            $ip2num = implode('', unpack('L', $ipData2));
            if ($ip2num < 0)
                $ip2num += pow(2, 32);

            if ($ip2num < $ipNum) {
                if ($Middle == $BeginNum) {
                    fclose($fd);
                    return '- Unknown';
                }
                $BeginNum = $Middle;
            }
        }

        $ipFlag = fread($fd, 1);
        if ($ipFlag == chr(1)) {
            $ipSeek = fread($fd, 3);
            if (strlen($ipSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $ipSeek = implode('', unpack('L', $ipSeek . chr(0)));
            fseek($fd, $ipSeek);
            $ipFlag = fread($fd, 1);
        }

        if ($ipFlag == chr(2)) {
            $AddrSeek = fread($fd, 3);
            if (strlen($AddrSeek) < 3) {
                fclose($fd);
                return '- System Error';
            }
            $ipFlag = fread($fd, 1);
            if ($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if (strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return '- System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }

            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;

            $AddrSeek = implode('', unpack('L', $AddrSeek . chr(0)));
            fseek($fd, $AddrSeek);

            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;
        } else {
            fseek($fd, -1, SEEK_CUR);
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;

            $ipFlag = fread($fd, 1);
            if ($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if (strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return '- System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;
        }
        fclose($fd);

        if (preg_match('/http/i', $ipAddr2)) {
            $ipAddr2 = '';
        }
        $ipaddr = "$ipAddr1 $ipAddr2";
        $ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
        $ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
        $ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
        if (preg_match('/http/i', $ipaddr) || $ipaddr == '') {
            $ipaddr = '- Unknown';
        }
        return '' . $ipaddr;
    }
}

function ftp_upfile($source, $file) {
    global $webdb;
    if (!$webdb[UseFtp] || !$webdb[FtpHost] || !$webdb[FtpName] || !$webdb[FtpPwd] || !$webdb[FtpPort] || !$webdb[FtpDir]) {
        return "$webdb[www_url]/$webdb[updir]/$file";
    }
    require_once(PHP168_PATH . "inc/ftp.php");
    $ftp = new FTP($webdb[FtpHost], $webdb[FtpPort], $webdb[FtpName], $webdb[FtpPwd], $webdb[FtpDir]);
    $path = dirname($file);
    $detail = explode("/", $path);
    //$pathname=$webdb[FtpDir];
    foreach ($detail AS $key => $value) {
        $pathname.="$value/";
        if (!$ftp->dir_exists($pathname)) {
            $ftp->mkd($pathname);
        }
    }
    $ifput = $ftp->upload($source, $file);
    $ftp->close();
    if ($ifput) {
        unlink($source);
        return "$webdb[mirror]/$file";
    } else {
        return "$webdb[www_url]/$webdb[updir]/$file";
    }
}

function ftp_delfile($file) {
    global $webdb;
    if (!$webdb[UseFtp] || !$webdb[FtpHost] || !$webdb[FtpName] || !$webdb[FtpPwd] || !$webdb[FtpPort] || !$webdb[FtpDir]) {
        return;
    }
    require_once(PHP168_PATH . "inc/ftp.php");
    $ftp = new FTP($webdb[FtpHost], $webdb[FtpPort], $webdb[FtpName], $webdb[FtpPwd], $webdb[FtpDir]);
    $ftp->delete($file);
    $ftp->close();
}

?>