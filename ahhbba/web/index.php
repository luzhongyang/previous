<?php
    require("inc/conn.php"); 
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $company;?></title>
<meta name="Keywords" content="<?php echo $keywords;?>" >
<meta name="Description" content="<?php echo $keywords;?>">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="favicon.ico" rel="shortcut icon" />
<link href="/css/main.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="/js/index.js"></script> 
<script type="text/javascript" src="/js/jquery1.42.min.js"></script>
<script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
<div id="header">
	<div id="headcon">
    	<a href="/"><img src="/images/headerlogo.jpg"/></a>
        <div class="shijian"><script type="text/javascript" src="/js/clock.js"></script> &nbsp;<a href='#' > 设为首页</a> | <a href='#'  >收藏本站</a></div>
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

<div id="banner">
       <div class="m_banner">
           <?php 
              $sql = "select * from hb_news where class='首页顶部轮播图片' order by id desc";
              $query = mysql_query($sql);
              while($row = mysql_fetch_array($query)) { ?>
            <div class="banner" style=" background-image: url(/pic/<?php echo $row['pic'] ;?>);" ></div>
            <?php } ?>
            <div class="banner_ctrl"> <a href="#" class="prev" title=""></a> <a href="javascript:;" class="next" title="" style="opacity: 0.1;"></a> </div>
      </div>
</div>
    
<div id="con">
    <div id="xinwen">
        <div class="slideTxtBox">
            <div class="hd">
            	<a href="news.php">更多>></a>
                <ul><li>公司新闻</li><li>行业新闻</li></ul>
            </div>
            <div class="bd">
                <ul style="display: block;">
                    <div class="yt">
                        <?php
                         $sql5 = "select * from  hb_news  where type='news' and class='公司新闻' and sort_order=1";
                         $query5 = mysql_query($sql5);
                         $rows5 = mysql_fetch_array($query5);
                         ?>
                    	<a href="content.php?id=<?php echo $rows5['id'];?>"><img src="/pic/<?php echo $rows5['pic'];?>">
                        <h3><?php echo $rows5['title'];?></h3></a>
                        <div class="xqing"><?php echo mb_substr(strip_tags($rows5["inf"]), 0,100, 'utf-8'); ?>...<a href="content.php?id=<?php echo $rows5['id'];?>">[详情]</a></div>
                    
                        <div id="c"></div>
                    </div>
                    <ul class="xlb">
                        <?php
                        
                        //select * from  hb_class  where type='services' order by id asc;
                            $sql1 = "select * from  hb_news  where type='news' and class='公司新闻' order by id desc limit 0,6";
                            $query1 = mysql_query($sql1);
                            while ($rows1 = mysql_fetch_array($query1)) { ?>
                        <li><a href="content.php?id=<?php echo $rows1['id'];?>">·<?php echo $rows1['title'];?>.</a></li> 
                        <?php } ?>  
                    </ul>

                    <ul class="xlb" style="margin-left:45px;">
                        <?php
                            $sql2 = "select * from  hb_news  where type='news' and class='公司新闻' order by id desc limit 5,6";
                            $query2 = mysql_query($sql2);
                            while ($rows2 = mysql_fetch_array($query2)) { ?>
                        <li><a href="content.php?id=<?php echo $rows2['id'];?>">·<?php echo $rows2['title'];?>.</a></li> 
                        <?php } ?>  
                    </ul>   
                    <div id="c"></div>
                </ul>
                
                <ul style="display: none;">
                    <div class="yt">
                    
                    	<?php
                         $sql5 = "select * from  hb_news  where type='news' and class='行业新闻' and sort_order=1";
                         $query5 = mysql_query($sql5);
                         $rows5 = mysql_fetch_array($query5);
                         ?>
                    	<a href="content.php?id=<?php echo $rows5['id'];?>"><img src="/pic/<?php echo $rows5['pic'];?>">
                        <h3><?php echo $rows5['title'];?></h3></a>
                        <div class="xqing"><?php echo mb_substr(strip_tags($rows5["inf"]), 0,100, 'utf-8'); ?>...<a href="content.php?id=<?php echo $rows5['id'];?>">[详情]</a></div>
                    
                        <div id="c"></div>
                    </div>
                    <ul class="xlb">
                        <?php
                            $sql3 = "select * from  hb_news  where type='news' and class='行业新闻' order by id desc limit 0,6";
                            $query3 = mysql_query($sql3);
                            while ($rows3 = mysql_fetch_array($query3)) { ?>
                        <li><a href="content.php?id=<?php echo $rows3['id'];?>">·<?php echo $rows3['title'];?>.</a></li> 
                        <?php } ?>  
                    </ul>

                    <ul class="xlb" style="margin-left:45px;">
                        <?php
                            $sql4 = "select * from  hb_news  where type='news' and class='行业新闻' order by id desc limit 5,6";
                            $query4 = mysql_query($sql4);
                            while ($rows4 = mysql_fetch_array($query4)) { ?>
                        <li><a href="content.php?id=<?php echo $rows4['id'];?>">·<?php echo $rows4['title'];?>.</a></li> 
                        <?php } ?>  
                    </ul>   
                    <div id="c"></div>
                </ul>
                
	    </div>
	</div>
        <script type="text/javascript">jQuery(".slideTxtBox").slide();</script>
    </div>
    
    <div id="fuwu">
    	<h3 id="bt"><a href="services.php">更多>></a><span>服务项目</span></h3>
        <img src="/images/sawj_32.jpg" />
        <ul class="xm">
               <?php
                    $sql = "select * from  hb_news  where type='services' order by id asc ";
                    $query = mysql_query($sql);
                    while ($rows = mysql_fetch_array($query)) { ?>
                <li><a href="services.php?id=<?php echo $rows['id'];?>">·<?php echo $rows['class'];?></a></li> 
                <?php } ?> 
            <div id="c"></div>
        </ul>
    </div>
    <div id="c"></div>
    <div id="fc">
        <h3 id="bt"><a href="employee.php">更多>></a><span>员工风采</span></h3>
        <div id="c"></div>
        <div class="slideGroup" style="margin:0 auto">
            <div class="parBd">
                <div class="slideBox">
                    <a class="sPrev" href="javascript:void(0)"></a>
                    <ul>
                        <?php
                        $sql = "select * from  hb_news  where type='employee' order by id desc ";
                        $query = mysql_query($sql);
                        while ($rows = mysql_fetch_array($query)) {  ?>
                        <li>
                            <div class="pic"><a href="empcontent.php?type=employee&id=<?php echo $rows['id']; ?>" ><img src="./pic/<?php echo $rows['pic']; ?>" /></a></div>
                            <div class="title"><a href="empcontent.php?type=employee&id=<?php echo $rows['id']; ?>" ><?php echo $rows['title']; ?></a></div>
                        </li>
                        <?php } ?> 
                    </ul>
                    <a class="sNext" href="javascript:void(0)"></a>
                </div><!-- slideBox End -->
            </div><!-- parBd End -->
        </div>

        <script type="text/javascript">
                /* 内层图片无缝滚动 */
                jQuery(".slideGroup .slideBox").slide({ mainCell:"ul",vis:5,prevCell:".sPrev",nextCell:".sNext",effect:"leftMarquee",interTime:50,autoPlay:true,trigger:"click"});
        </script>
    </div>
	<div id="guanyu">
    	<h3 id="bt"><a href="aboutus.php">更多>></a><span>关于我们</span></h3>
        <div class="gy">
            <?php
                $sql = "select * from  hb_news  where title='关于豪邦' ";
                $row = mysql_fetch_array(mysql_query($sql));
            ?>
            <img src="./pic/<?php echo $row['pic'];?>" />
            <h3><?php echo $company; ?></h3>
            <p><?php echo mb_substr(strip_tags($row["inf"]), 0,175, 'utf-8'); ?>...<a href="aboutus.php?id=<?php echo $row['id'];?>">[详情]</a></p>
            <div id="c"></div>
        </div>
        <style type="text/css">
		/* 本例子css */
		.picScroll-left{ width:780px;  overflow:hidden; position:relative;margin-left:18px; padding-top:15px; }
		.picScroll-left .hd .prev,.picScroll-left .hd .next{ display:block;  width:12px; height:22px; float:right;overflow:hidden;cursor:pointer; background:url("/images/sawj_65.jpg") no-repeat;float:left; position:relative; top:66px;}
		.picScroll-left .hd .next{ background:url("/images/sawj_68.jpg") no-repeat;float:right;}
		.picScroll-left .bd{ padding:10px;   }
		.picScroll-left .bd ul{ overflow:hidden; zoom:1; }
		.picScroll-left .bd ul li{ margin:0 9px;width:233px;height:140px;background:url(images/sawj_59.jpg) no-repeat; float:left; _display:inline; overflow:hidden; text-align:center;  }
		.picScroll-left .bd ul li .pic{ text-align:center; }
		.picScroll-left .bd ul li .pic img{ width:221px; height:128px; display:block;  padding:6px;  }

		</style>

        <div class="picScroll-left">
            <div class="hd">
                <a class="next"></a>
                <a class="prev"></a>
            </div>
            <div class="bd">
                <ul class="picList">
                <?php
                    $sql = "select * from  hb_news  where type='banner' and class='首页底部轮播图片' order by id desc ";
                    $query = mysql_query($sql);
                    while ($rows = mysql_fetch_array($query)) {  ?>
                    <li>
                        <div class="pic"><img src="./pic/<?php echo $rows['pic'];?>" /></div>
                    </li>
                <?php } ?> 
                </ul>
            </div>
        </div>

		<script type="text/javascript">
		jQuery(".picScroll-left").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",vis:3});
		</script>
    </div>
    <div id="lianxi">
        <h3 id="bt"><a href="contactus.php">更多>></a><span>联系我们</span></h3>
            <?php @$sql1 = "select * from  hb_news  where type='contactus'";
                $rlt1 = mysql_query($sql1);
                $row1 = mysql_fetch_array($rlt1);
            ?>
            <img src="images/sawj_51.jpg" /><br/><br/><br/><br/>  
            <?php echo $row1['inf'];?>
    </div>
    
    <div id="zhishi">
        <h3 id="bt"><a href="knowledge.php?id=15">更多>></a><span>安保知识</span></h3>
        <ul>
            <?php
                $sql = "select * from  hb_news  where class='安保知识' order by id desc ";
                $query = mysql_query($sql);
                while ($rows = mysql_fetch_array($query)) {  ?>
            <li><a href="knowscontent.php?id=<?php echo $rows['id'];?>"><span><?php echo mb_substr(strip_tags($rows["addtime"]), 0,10, 'utf-8');?></span>·<?php echo $rows['title'];?></a></li>
             <?php } ?> 
        </ul>
    </div>
    <div id="zhishi">
    	<h3 id="bt"><a href="knowledge.php?id=14">更多>></a><span>规章制度</span></h3>
        <ul>
            <?php
                $sql = "select * from  hb_news  where class='规章制度' order by id desc ";
                $query = mysql_query($sql);
                while ($rows = mysql_fetch_array($query)) {  ?>
            <li><a href="knowscontent.php?id=<?php echo $rows['id'];?>"><span><?php echo mb_substr(strip_tags($rows["addtime"]), 0,10, 'utf-8');?></span>·<?php echo $rows['title'];?></a></li>
            <?php } ?> 
        </ul>
    </div>
    <div id="wenti">
    	<h3 id="bt"><a href="news.php?type=news&id=6">更多>></a><span>常见问题</span></h3>
                <?php
                $sql = "select * from  hb_news  where id=18 ";
                $query = mysql_query($sql); 
                $row = mysql_fetch_array($query);
                
                $sql1 = "select * from  hb_news  where id=17 ";
                $query1 = mysql_query($sql1); 
                $row1 = mysql_fetch_array($query1);
                ?>
        <dl class="dl">
            <dt><?php echo $row['title'];?></dt>
            <dd><?php echo mb_substr(strip_tags($row['inf']), 0,60, 'utf-8');?>...<br /><a href="content.php?type=news&id=18">查看详情>></a></dd>
        </dl>
        <dl>
            <dt><?php echo $row1['title'];?></dt>
            <dd><?php echo mb_substr(strip_tags($row1['inf']), 0,60, 'utf-8');?>...<br /><a href="content.php?type=news&id=17">查看详情>></a></dd>
        </dl>
    </div>
    <div id="c"></div>
    <div id="anli">
    	<h3 id="bt"><a href="case.php">更多>></a><span>成功案例</span></h3>
        <div id="c"></div>
        <div class="slideGroup" style="margin:0 auto">
            <div class="parBd">
                <div class="slideBox">
                    <a class="sPrev" href="javascript:void(0)"></a>
                    <ul>
                        <?php
                            $sql = "select * from  hb_news  where type='case' order by id desc ";
                            $query = mysql_query($sql);
                            while ($rows = mysql_fetch_array($query)) {  ?>
                        <li>
                            <div class="pic"><a href="casecontent.php?type=case&id=<?php echo $rows['id'];?>" ><img src="./pic/<?php echo $rows['pic'];?>" /></a></div>
                            <div class="title"><a href="casecontent.php?type=case&id=<?php echo $rows['id'];?>" ><?php echo $rows['title'];?></a></div>
                        </li> 
                        <?php } ?>                         
                    </ul>
                    <a class="sNext" href="javascript:void(0)"></a>
                </div><!-- slideBox End -->
            </div><!-- parBd End -->
        </div>

        <script type="text/javascript">
                /* 内层图片无缝滚动 */
                jQuery(".slideGroup .slideBox").slide({ mainCell:"ul",vis:6,prevCell:".sPrev",nextCell:".sNext",effect:"leftMarquee",interTime:50,autoPlay:true,trigger:"click"});
        </script>
    </div>
    <div id="link">
    	<b>友情链接：</b>
        <?php
            $sql = "select * from  hb_news  where type='link' order by id desc ";
            $query = mysql_query($sql);
            while ($rows = mysql_fetch_array($query)) {  ?>
        <a href="<?php echo strip_tags($rows['inf']);?>" target="_blank"><?php echo $rows['title'];?></a>    
        <?php } ?>     
    </div>
</div>

<div id="c"></div>
<script type="text/javascript" src="/inc/AspCms_Statistics.asp"></script><div id="footer">
    <div id="foot">
        <div id="fle"><img width="240" height="100" src="/images/sawj_87.jpg" /></div>
            <p><?php echo $company;?><br />
            地址：<?php echo $address;?><br />
            全国热线：<?php echo $phone;?>  传　真：<?php echo $fax;?><br /> 
            All Rights Reserved. 技术支持：<a href="http://www.tianda.cc/" target="_blank">合肥天达网络科技</a> </p>
        <div id="ewm"><img src="/images/sawj_84.jpg" /></div>
    </div>
</div>
</body>
</html>
