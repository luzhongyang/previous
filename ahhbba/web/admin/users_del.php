<?php require("../inc/conn.php"); ?>
<?php require("admincheckrole.php"); ?>
<?php

$refer = $_SERVER["HTTP_REFERER"];
if ($_COOKIE['admin_usr_level'] != "1") {

    print "<script>alert('对不起，你没有该管理权限！');history.go(-1)</script>";
}
if ($_POST['id'] == '' and $_GET['id'] == '') {
    echo "<script language=JavaScript>{window.alert('你没有选择要操作的用户！');window.location.href='$refer';}</script>";
} else {
    admin_add("1");
    if ($_COOKIE['admin_usr_level'] != "1") {
        mysql_query("DELETE FROM  users  WHERE usr_row_status='1' and  usr_id in (" . $_POST['id'] . ")");
        mysql_query("DELETE FROM  users  WHERE usr_row_status='1' and   usr_id in (" . $_GET['id'] . ")");
    } else {
        mysql_query("DELETE FROM  users  WHERE  usr_id in (" . $_POST['id'] . ")");
        mysql_query("DELETE FROM  users  WHERE    usr_id in (" . $_GET['id'] . ")");
    }

    header("location:user_list.php");
}
?>