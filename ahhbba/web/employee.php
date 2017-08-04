<?php

require ('top.php');

@$sql = "select * from  hb_class  where type='employee'";
$row = mysql_fetch_array(mysql_query($sql));	

@$sql2 = "select * from  hb_news  where type='employee' order by id desc";
$result = mysql_query($sql2);
$pagesize = 6;  //每页记录条数
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
            <h3 id="bt"><span>员工风采</span>Employee</h3>
            <ul id="lb"> 
                <li><a href="employee.php"><?php echo $row['classname'];?></a></li>
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
    	<div id="wz"><p>您现在的位置是：首页 &gt;&gt;<a href="">员工风采</a> &gt;&gt;<a href=""><?php echo $row['classname'];?></a></p>
            <h3><?php echo $row['classname'];?><span>Employee</span></h3>
        </div>
        <div class="pbody">
            <?php if ($result_num <= 0) { ?>
                <center><BR><BR><?php print($word); ?></center>
            <?php } else { ?>  
            <ul id="plist">
               <?php while ($rows1 = mysql_fetch_array($result)) { ?>
            	<li><a href="empcontent.php?type=employee&id=<?php echo $rows1['id'];?>"><img src="/pic/<?php echo $rows1['pic'];?>"><br><?php echo $rows1['title'];?></a></li>           
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