<?php require("../inc/conn.php"); ?>
<?php require("admincheckrole.php"); ?>
<?php

$refer = $_SERVER["HTTP_REFERER"];

if ($_POST['id'] == '' and $_GET['id'] == '') {
    echo "<script language=JavaScript>{window.alert('你没有选择要操作的数据！');window.location.href='$refer';}</script>";
} else {
    mysql_query("DELETE  FROM  guestbook  WHERE   id=" . $_GET['id']);

    echo "<script language=JavaScript>{window.location.href='$refer';}</script>";
}
?>