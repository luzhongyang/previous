<?php

require ('top.php');

if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; 
    @$sql2 = "select * from  hb_news  where id=". $id;            
    $rlt2 = mysql_query($sql2);
    $row2 = mysql_fetch_array($rlt2);
    if(is_array($row2)) {
       $class = $row2['class'];
       $title = $row2['title'];
       $inf = $row2['inf'];
       $suffix = '';
       if($class == '公司新闻') {
           $suffix = 'Company News';
       }else if($class == '行业新闻') {
           $suffix = 'Industry News';
       }else if($class == '常见问题') {
           $suffix = 'Latest Announcement';
       }
    }else {
       $class = '';
       $title = '';
       $inf = '';
    } 
}


?>
<!--content-->
<div id="con">
    <div id="left">
	<div id="lm">
            <h3 id="bt"><span>新闻动态</span>News</h3>
            <ul id="lb">
            <?php
                @$sql = "select * from  hb_class  where type='news' order by id asc";
                $result = mysql_query($sql);
                while ($rows = mysql_fetch_array($result)) { ?>
                <li><a href="news.php?type=news&id=<?php echo $rows['id'];?>"><?php echo $rows['classname'];?></a></li>
            <?php } ?>
            </ul>
        </div>
        <div id="lm">
            <h3 id="bt"><span>联系我们</span>Contact us</h3>
            <?php @$sql1 = "select * from  hb_news  where type='contactus'";
                $rlt1 = mysql_query($sql1);
                $row1 = mysql_fetch_array($rlt1);
            ?>
            <p>
                <div class="lianxifang"><?php echo $row1['inf'];?></div>
            </p>
        </div> 
    </div>
    
    <div id="right">
        <div id="wz"><p>您现在的位置是：首页 &gt;&gt;<a href="">新闻动态</a> &gt;&gt;<a href=""><?php echo $class; ?></a></p>
            <h3><?php echo $class; ?><span><?php echo $suffix; ?></span></h3>
        </div>
        <div id="nbody">                         
            <h3><?php echo $title; ?></h3></br>      
            <p><?php echo $inf; ?></p>          
        </div>
    </div>  
     <div id="c"></div>
</div>
<script type="text/javascript" src="/inc/AspCms_Statistics.asp"></script>

<?php require('foot.php'); ?>