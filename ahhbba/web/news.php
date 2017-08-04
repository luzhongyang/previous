<?php

require ('top.php');

$suffix = NULL;
if (!isset($_GET['id'])) {
    // 如果没有id则随机取一条
    @$sql = "select * from  hb_class  where type='news' order by id asc  limit 1";
    $suffix = 'Company News';
} else {
    $id = (int) $_GET['id'];
    @$sql = "select * from  hb_class  where id=" . $id;
    switch( $id){
        case 4;
            $suffix = 'Company News';
            break;
        case 5;
            $suffix = 'Industry News';
            break;
        case 6;
            $suffix = 'Latest Announcement';
            break;
        default:
            break;
    }
}
$row = mysql_fetch_array(mysql_query($sql));
// 判断结果集是否是数组
if (is_array($row)) {
    $classname = $row['classname'];
} else {
    $classname = "";
}


if($classname == '公司新闻') {
    @$sql2 = "select * from  hb_news  where type='news' and class='公司新闻' order by id desc";
}else if($classname == '行业新闻') {
    @$sql2 = "select * from  hb_news  where type='news' and class='行业新闻' order by id desc";
}else if($classname == '常见问题') {
    @$sql2 = "select * from  hb_news  where type='news' and class='常见问题' order by id desc";
}

$result = mysql_query($sql2);
$pagesize = 4;  //每页记录条数
$result_num = mysql_num_rows($result);

if ($result_num <= 0) {
    if ($search == "") {
        $word = "目前还没有记录!";
    } else {
        $word = "没有查到符合条件的记录!";
    }
} else {
    $maxpage = ceil($result_num / $pagesize);
    @$page = $_GET['page'];
    if (is_long($page) or $page == "") {
        $page = 1;
    } else {
        $page = (int) ($page);
    }
    if ($page < 1) {
        $page = 1;
    } else if ($page > $maxpage) {
        $page = $maxpage;
    }
    mysql_data_seek($result, ($page - 1) * $pagesize);
    $n = 1;
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
                $rlt = mysql_query($sql);
                while ($rows = mysql_fetch_array($rlt)) { ?>
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
        <div id="wz"><p>您现在的位置是：首页 &gt;&gt;<a href="">新闻动态</a> &gt;&gt;<a href=""><?php echo $classname; ?></a></p>
            <h3><?php echo $classname; ?><span><?php echo $suffix; ?></span></h3>
        </div>
        <div class="pbody">                  
            <?php if ($result_num <= 0) { ?>
                <center><BR><BR><?php print($word); ?></center>
            <?php } else { ?>  

            <ul id="nlist">                       
                <?php while ($rows1 = mysql_fetch_array($result)) { ?>
                <li>
                    <a href="content.php?type=news&id=<?php echo $rows1['id'];?>">
                        <span><?php echo $rows1['addtime'];?></span>·<?php echo $rows1['title'];?>
                    </a>
                    <p>&nbsp;&nbsp;<?php echo mb_substr(strip_tags($rows1["inf"]), 0, 115, 'utf-8');?>...
                    </p>
                </li>  
                <?php
                    $n++;
                    if ($n > $pagesize) {break;}
                    }
                ?> 
            </ul>
                       
            <div id="fenye">
            <?php
            if (@$_GET["title"] == "") {
                LastNextPage($maxpage, $page, "width=100% ", "<p  align=center >");
            } else {
                TurnPage($maxpage, $page, "width=100% ", "<p  align=center >");
            }
            ?>
            </div>       
            <?php } ?>
        </div>
        
    </div>  
    <div id="c"></div>  
     
</div>
<script type="text/javascript" src="/inc/AspCms_Statistics.asp"></script>

<?php require('foot.php'); ?>