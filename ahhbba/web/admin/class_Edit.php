<?php
require("up.php");
$type = @$_GET['type'];
?>

<BODY>
    <H1><SPAN class=action-span><A 
                href="class_Edit.php?Result=Add&type=<?php echo $type; ?>">新增分类</A></SPAN> <SPAN 
            class=action-span1><A 
                href="main.php">豪邦后台管理中心</A> - 分类管理 
        </SPAN>
        <DIV style="CLEAR: both"></DIV></H1>
    <SCRIPT src="js/utils.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/Calendar.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/ajax.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/listtable.js" type=text/javascript></SCRIPT>
    <?php
    $refer = "class_list.php?&type=" . $type . "";
    if (isset($_GET["action"]) == "save") {
        switch (@$_GET["Result"]) {
            case("Add"): {
                    $sql = "select * from hb_class where  classname='" . $_POST['classname'] . "' ";
                    if (mysql_num_rows(mysql_query($sql)) > 0) {
                        echo "<script language=JavaScript>{window.alert('添加失败，该分类已存在！');window.location.href='$refer';}</script>";
                        exit;
                    }    
 
                    $sql1 = "insert into hb_class (classname,type) values ('" . $_POST['classname'] . "','" . $_POST['type'] . "')";
                    if (mysql_query($sql1)) {
                        echo "<script language=JavaScript>{window.alert('添加成功！');window.location.href='$refer';}</script>";
                        exit;
                    } else {
                        echo "<script language=JavaScript>{window.alert('添加失败！');window.location.href='$refer';}</script>";
                        exit;
                    };
                };
                break;
            case("Modify"): {
 
                    $s = "update  hb_class set classname='" . $_POST['classname'] . "' where id=" . $_GET['id'] . " ";
                    if (mysql_query($s)) {

                    $s = "update  hb_news set class='" . $_POST['classname'] . "' where class='" . $_POST['oldclass'] . "' "; mysql_query($s);
                    echo "<script language=JavaScript>{window.alert('修改成功！');window.location.href='$refer';}</script>";
                        exit;
                    } else {
                        echo $s;
                        exit;
                        echo "<script language=JavaScript>{window.alert('修改失败！');window.location.href='$refer';}</script>";
                        exit;
                    }
                };
                break;
        }
    } else {
        if (isset($_GET['Result']) == "Modify") {
            @$sql = "select * from hb_class where id=" . $_GET['id'];
            if (@$row = mysql_fetch_array(mysql_query($sql))) {
                $id = $row["id"];
                $classname = $row["classname"];
            }
        }
    }
    ?>


    <script language="JavaScript" src="check.js"></script>
    <script LANGUAGE="javascript">
<!--


        function add_onsubmit(add) {
            /* 如需验证二次密码时用
             if(listForm.password.value!=listForm.repassword.value){
             alert('两次密码不相同!');
             return false;
             }
             */

            //公告端验证
            if (!checkvalue(listForm.classname, 0, 0, 1, "名称"))
                return false;



        }
//-->
    </SCRIPT>


    <FORM name=listForm action="class_Edit.php?action=save&type=<?php echo $type; ?>&Result=<?php print($_GET['Result']); ?>&id=<?php print(@$_GET['id']); ?>" method=post  LANGUAGE=javascript onSubmit="return add_onsubmit(this)">
        <DIV class=list-div id=listDiv>
            <table id=list-table cellspacing=1 cellpadding=2 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3">分类名称:<input name="classname" type="text" value="<?php print(@$classname); ?>"  size=60>

                            <input name="type" type="hidden" value="<?php print(@$type); ?>" >
                            <input name="oldclass" type="hidden" value="<?php print(@$classname); ?>" >
                            <font color="red">*

                            </font></td>
                    </tr>
                    <tr>
                        <td width="20%" align="right">&nbsp;</td>
                        <td colspan="5"><input name="submit" type=submit value=" 提 交 ">
                        <input name="button" type=button onClick="location.href = 'class_list.php?type=<?php echo $type; ?>'" value=" 返 回 "></td>
                    </tr>
                </tbody>
            </table>
        </DIV>
    </FORM>
    <?php require("down.php"); ?>

