<?php

require ('top.php');

// 判断表单如果没有id则随机取出一条记录显示
$suffix = NULL;
if (!isset($_GET['id'])) {
    @$sql = "select * from  hb_news  where type='aboutus' order by id asc  limit 1";
    $suffix = 'About us';
} else {
    $id = (int) $_GET['id'];
    @$sql = "select * from  hb_news  where id=" . $id;
    switch( $id){
        case 1;
            $suffix = 'About us';
            break;
        case 2;
            $suffix = 'Organizations';
            break;
        case 3;
            $suffix = 'Qualification';
            break;
        case 4;
            $suffix = 'Activity';
            break;
        case 5;
            $suffix = 'Organizations';
            break;
        default:
            break;
    }
}

$row = mysql_fetch_array(mysql_query($sql));

// 判断结果集是否是数组
if (is_array($row)) {
    $ccid = $row['id'];
    $title = $row['title'];
    $pic = $row['pic'];
    $inf = $row['inf'];
} else {
    $title = "";
    $pic = "";
    $inf = "";
}
  
?>

<!--content-->
<div id="con">
    <div id="left">
	<div id="lm">
            <h3 id="bt"><span>关于我们</span>About us</h3>
            <ul id="lb"> 
            <?php
                @$sql2 = "select * from  hb_news  where type='aboutus' order by id asc";
                $result2 = mysql_query($sql2);
                while ($rows2 = mysql_fetch_array($result2)) { ?>	
                <li><a href="aboutus.php?id=<?php echo $rows2['id'];?>"><?php echo $rows2['title'];?></a></li>
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
                <div class="lianxifang"><?php echo $row1['inf'];?>
                </div>
            </p>                  
        </div>  
    </div>
    


    <div id="right">
    	<div id="wz"><p>您现在的位置是：首页 &gt;&gt;<a href="">关于我们</a> &gt;&gt;<a href=""><?php echo $title; ?></a></p>
            <h3><?php echo $title; ?><span><?php echo $suffix; ?></span></h3>
        </div>
        <div id="body">
            <p style="line-height: 1.75em;"><span style="font-size: 14px;">&nbsp; <?php echo $inf; ?></span></p>  
        </div>
    </div>
    <div id="c"></div>
</div>
<script type="text/javascript" src="/inc/AspCms_Statistics.asp"></script>

<?php require('foot.php'); ?>