<?php 
require("../inc/conn.php"); 
require("admincheckrole.php"); 

$refer = $_SERVER["HTTP_REFERER"];

if ($_REQUEST['id'] == '') {
    echo "<script language=JavaScript>{window.alert('你没有选择要操作的数据！');window.location.href='$refer';}</script>";
} else {
    if($_REQUEST['id'] < 1000) {
         echo "<script language=JavaScript>{window.alert('该分类不能删除！');window.location.href='$refer';}</script>";
    }else {
        mysql_query("DELETE  FROM  hb_class  WHERE   id=" . $_GET['id']);
    }  
}
?>