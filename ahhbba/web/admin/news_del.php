<?php require("../inc/conn.php"); ?>
<?php require("admincheckrole.php"); ?>
<?php

$refer = $_SERVER["HTTP_REFERER"];

if ( $_GET['id'] == '') {
    echo "<script language=JavaScript>{window.alert('你没有选择要操作的数据！');window.location.href='$refer';}</script>";
} else {

if($_GET['id']==2){
  echo "<script language=JavaScript>{window.alert('该调数据为系统数据，不允许删除！');window.location.href='$refer';}</script>";
exit;
}
    mysql_query( "DELETE  FROM  hb_news  WHERE   id=" . $_GET['id']);
    echo "<script language=JavaScript>{window.location.href='$refer';}</script>";
       
}
?>