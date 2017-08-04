<?php

require ('top.php');

$suffix = NULL;
if (!isset($_GET['id'])) {
    @$sql = "select * from  hb_class  where type='services' order by id asc  limit 1";
    $suffix = 'Building';
} else {
    $id = (int) $_GET['id'];
    @$sql = "select * from  hb_class  where id=" . $id;
    switch( $id){
        case 8;
            $suffix = 'Building';
            break;
        case 9;
            $suffix = 'Financial Sector';
            break;
        case 10;
            $suffix = 'Enterprise Factory';
            break;
        case 11;
            $suffix = 'Real estate sector';
            break;
        case 12;
            $suffix = 'Safeguard style';
            break;
        case 13;
            $suffix = 'Other services';
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

?>

<!--content-->
<div id="con">
    <div id="left">
	<div id="lm">
            <h3 id="bt"><span>服务项目</span>Services</h3>
            <ul id="lb">
            <?php
                @$sql = "select * from  hb_class  where type='services' order by id asc";
                $result = mysql_query($sql);
                while ($rows = mysql_fetch_array($result)) { ?>
                <li><a href="services.php?&id=<?php echo $rows['id'];?>"><?php echo $rows['classname'];?></a></li>
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
        <div id="wz"><p>您现在的位置是：首页 &gt;&gt;<a href="">服务项目</a> &gt;&gt;<a href=""><?php echo $classname; ?></a></p>
            <h3><?php echo $classname; ?><span><?php echo $suffix; ?></span></h3>
        </div>
        <div id="body">
        <p>&nbsp; 我公司自建大型培训中心，常年为大型企事业单位提供各种安全培训。培训中心的教师由公安、消防、生产安全方面的专家组成。还聘英国、德国和香港等国家和地区的安防专家担任培训顾问。</p><p><br></p><p>安全培训项目：消防安全培训；</p><p>防恐安全培训；安全生产培训；</p><p>安全设备、设施的维护、保养与管理；</p><p>突发事件准备与响应培训及演练；</p><p>急救护理培训；个人危机处置培训。</p><p><br></p><p>多年来专注于为大型企业保安布防定制解决方案&nbsp;</p><p>＋ 北京圣安卫嘉保安服务有限公司青岛分公司是经市内保局特许面向社会提供专业化、有偿安全防范服务的人防与技防相结合的特行企业</p><p>＋ 主要承担企事业单位、机关团体、公共场所等的安全守护提供相应的人防、技防服务。</p><p><br></p><p>服务范围广泛，人员储备雄厚</p><p><br></p><p>＋ 服务范围涵盖全国各地，</p><p>＋ 人员储备雄厚，充分做到以人力资源为后盾的发展模式。</p><p>＋ 提供大型活动安保，展会安保、明星护卫等一些临时勤务</p><p><br></p><p>北京圣安卫嘉保安服务有限公司多年来服务客户超过3000家</p><p><br></p><p>专业培训，为大型企业提供高素质人才</p><p><br></p><p>＋ 经过严格的笔试及专业的培训，100%持证上岗</p><p>＋ 项目上队长以上管理干部每季度要进行1-2次培训</p><p>＋ 拥有完善的保安员考核管理制度</p><p>＋ 基地岗前培训、区域岗前培训、区域专员培训、骨干培训</p><p><br></p>
        </div>
    </div>  
     <div id="c"></div>
</div>
<script type="text/javascript" src="/inc/AspCms_Statistics.asp"></script>

<?php require('foot.php'); ?>