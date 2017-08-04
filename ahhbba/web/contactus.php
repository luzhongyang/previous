<?php

require ('top.php');

@$sql = "select * from  hb_class  where type='contactus'";
$row = mysql_fetch_array(mysql_query($sql));	

@$sql1 = "select * from  hb_news  where type='contactus'";
$row1 = mysql_fetch_array(mysql_query($sql1));	
?>

<!--content-->
<div id="con">
    <div id="left">
	<div id="lm">
    	<h3 id="bt"><span>联系我们</span>Contact Us</h3>
        <ul id="lb">
            <li><a href="contactus.php"><?php echo $row['classname'];?></a></li>                    
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
    	<div id="wz"><p>您现在的位置是：首页 &gt;&gt;<a href="">联系我们</a> &gt;&gt;<a href=""><?php echo $row['classname'];?></a></p>
            <h3><?php echo $row['classname'];?><span>Contact</span></h3>
        </div>
        <div id="body">
            <p style="line-height: 1.75em;"><span style="font-size: 14px;">&nbsp; <?php echo $row1['inf']; ?></span></p>
            <img src="./images/at.jpg" style="float: right;">
        </div>
    </div>
    <div id="c"></div>
</div>
<script type="text/javascript" src="/inc/AspCms_Statistics.asp"></script>

<?php require('foot.php');?>