<?php

require "./inc/conn.php";
require './inc/tools.php';
$sql = "select * from hb_config where id=1";
$row = mysql_fetch_array(mysql_query($sql));
$email = $row["email"];
$title = $row["title"];
$keywords = $row["keywords"];
$phone = $row["phone"];
$fax = $row["fax"];
$address = $row["address"];
$company = $row["company"];
$beian = $row["beian"];

?>

<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $company;?></title>
<meta name="Keywords" content="<?php echo $keywords;?>">
<meta name="Description" content="<?php echo $keywords;?>">
<meta http-equiv="X-UA-Compatible" content="IE=7">
<link href="favicon.ico" rel="shortcut icon">
<link href="/css/main.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery1.42.min.js"></script>
<script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
<!--header-->
<div id="header">
	<div id="headcon">
    	<a href="/"><img src="/images/headerlogo.jpg"></a>
        <div class="shijian"><script type="text/javascript" src="/js/clock.js"></script><span id="clock" style="word-break:keep-all"></span> &nbsp;<a href="#"> 设为首页</a> | <a href="#">收藏本站</a></div>
        <div id="c"></div>
    </div>
    <div id="nav">
        <ul>
            <li><a href="/">网站首页</a></li>
            
            <li><a href="aboutus.php">关于我们</a></li>
            
            <li><a href="news.php">新闻动态</a></li>
            
            <li><a href="employee.php">员工风采</a></li>
            
            <li><a href="services.php">服务项目</a></li>
            
            <li><a href="knowledge.php">安保知识</a></li>
            
            <li><a href="case.php">成功案例</a></li>
            
            <li><a href="contactus.php">联系我们</a></li>
            
         </ul>
     </div>
</div>
<?php 
$sql2 = "select * from hb_news where type='banner' and class='分页顶部显示图片'";
$row2 = mysql_fetch_array(mysql_query($sql2));
?>
<div class="top_banner" style="background:url(/pic/<?php echo $row2['pic'];?>);"></div>


