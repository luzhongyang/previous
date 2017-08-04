<?php require("up.php"); ?>
<BODY>
    <H1><SPAN class=action-span><A 
                href="user_Edit.php?Result=Add">新增用户</A></SPAN> <SPAN 
            class=action-span1><A 
                href="main.php">明富 管理中心</A> - 用户操作 
        </SPAN>
        <DIV style="CLEAR: both"></DIV></H1>
    <SCRIPT src="js/utils.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/Calendar.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/ajax.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/listtable.js" type=text/javascript></SCRIPT>
    <?php
    $refer = "user_list.php";
    if ($_COOKIE['admin_usr_level'] != "1") {

        print "<script>alert('对不起，你没有该管理权限！');history.go(-1)</script>";
    }
    if (isset($_GET["action"]) == "save") {
        switch (@$_GET["Result"]) {
            case("Add"): {
                    admin_add("1");
                    @$sql = "select * from users where usr_name='" . $_POST['usr_name'] . "' ";
                    if (mysql_num_rows(mysql_query($sql)) > 0) {
                        echo "<script language=JavaScript>{window.alert('添加失败，该用户已存在！');window.location.href='$refer';}</script>";
                        exit;
                    }

                    @$sql = "insert into users (usr_name,usr_password,usr_description,usr_level,usr_class,usr_create_user_id,usr_create_date,usr_update_user_id,usr_update_date,usr_row_status) values ('" . $_POST['usr_name'] . "','" . md5($_POST['usr_password']) . "','" . $_POST['usr_description'] . "','" . $_POST['usr_level'] . "','" . $_POST['usr_class'] . "','" . $_COOKIE['admin_adminname'] . "','" . date("Y-m-d H:i:s") . "','" . $_COOKIE['admin_adminname'] . "','" . date("Y-m-d H:i:s") . "','1')";
                    if (mysql_query($sql)) {
                        echo "<script language=JavaScript>{window.alert('添加成功！');window.location.href='$refer';}</script>";
                        exit;
                    } else {

                        echo "<script language=JavaScript>{window.alert('添加失败！');window.location.href='$refer';}</script>";
                        exit;
                    };
                };
                break;
            case("Modify"): {
                    admin_add("1");
                    if ($_POST['usr_password'] != '') {
                        $usr_password = "usr_password='" . md5($_POST['usr_password']) . "',";
                    } else {
                        $usr_password = '';
                    }

                    $s = "update  users set " . $usr_password . "  usr_description='" . $_POST['usr_description'] . "',usr_level='" . $_POST['usr_level'] . "',usr_class='" . $_POST['usr_class'] . "',usr_update_user_id='" . $_COOKIE['admin_adminname'] . "',usr_update_date='" . date("Y-m-d H:i:s") . "'  where usr_id=" . $_GET['id'];

                    if (mysql_query($s)) {
                        echo "<script language=JavaScript>{window.alert('修改成功！');window.location.href='$refer';}</script>";
                        exit;
                    } else {


                        echo "<script language=JavaScript>{window.alert('修改失败！');window.location.href='$refer';}</script>";
                        exit;
                    }
                };
                break;
        }
    } else {
        if (isset($_GET['Result']) == "Modify") {
            @$sql = "select * from users where usr_id=" . $_GET['id'];
            if (@$row = mysql_fetch_array(mysql_query($sql))) {
                $usr_name = $row["usr_name"];
                $usr_description = $row["usr_description"];
                $usr_level = $row["usr_level"];
                $usr_class = $row["usr_class"];
                $usr_create_user_id = $row["usr_create_user_id"];
                $usr_create_date = $row["usr_create_date"];
                $usr_update_user_id = $row["usr_update_user_id"];
                $usr_update_date = $row["usr_update_date"];
                $usr_row_status = $row["usr_row_status"];


                if ($_COOKIE['admin_usr_level'] != "1" and $usr_row_status == "2") {
                    echo "<script language=JavaScript>{window.alert('已审核过，您无法进行此操作！');window.location.href='$refer';}</script>";
                    exit;
                }
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

            //客户端验证
            if (!checkvalue(listForm.usr_name, 0, 0, 1, "姓名"))
                return false;
<?php
if (isset($_GET['Result']) != "Modify") {
    ?>
                if (!checkvalue(listForm.usr_password, 0, 0, 1, "密码"))
                    return false;
    <?php
}
?>

        }
//-->
    </SCRIPT>
    <FORM name=listForm action="user_Edit.php?action=save&Result=<?php print($_GET['Result']); ?>&id=<?php print(@$_GET['id']); ?>" method=post  LANGUAGE=javascript onSubmit="return add_onsubmit(this)">
        <DIV class=list-div id=listDiv>
            <table id=list-table cellspacing=1 cellpadding=2 width="85%">
                <tbody>
                    <tr>
                        <th><div align="right">姓名:</div></th>
                <td><input name="usr_name" type="text" value="<?php print(@$usr_name); ?>">
                    <font color="red">*</font>  
                    <?php
                    if (@$usr_name != '') {
                        echo "[创建：" . $usr_create_user_id . "][时间：" . $usr_create_date . "][最后异动：" . $usr_update_user_id . "][时间：" . $usr_update_date . "]";
                        if ($usr_row_status == '2') {
                            echo "已审核";
                        } else {
                            echo "未审核";
                        }
                    }
                    ?>

                </td>
                </tr>
                <tr>
                    <th><div align="right">口令:</div></th>
                <td><input name="usr_password" value="" type="text">
                    <font color="red">*</font></td>

                </tr>
                <tr>
                    <th><div align="right">用户级别:</div></th>
                <td><select name="usr_level">
                        <option value="1" <?php
                        if (@$usr_level === "1") {
                            print("selected");
                        }
                        ?>>超级</option>
                        <option value="2" <?php
                        if (@$usr_level === "2") {
                            print("selected");
                        }
                        ?>>普通</option>
                    </select>
                    <font color="red">*</font></td>

                </tr>
                <tr>
                    <th width="20%"><div align="right">用户性质:</div></th>
                <td colspan="3"><select name="usr_class">
                        <option value="1" <?php
                        if (@$usr_class === "1") {
                            print("selected");
                        }
                        ?>>输入</option>
                        <option value="2" <?php
                        if (@$usr_class === "2") {
                            print("selected");
                        }
                        ?>>审核</option>
                        <option value="3" <?php
                        if (@$usr_class === "3") {
                            print("selected");
                        }
                        ?>>维护</option>
                    </select>
                    <font color="red">* </font></td>
                </tr>
                <tr>
                    <th width="20%"><div align="right">描述:</div></th>
                <td colspan="3"><textarea name="usr_description" rows="5"class="textfield" id="guimo" style="WIDTH: 96%;"><?php print(@$usr_description); ?></textarea>        </td>
                </tr>

                <tr>
                    <td width="20%" align="right">&nbsp;</td>
                    <td colspan="3"><input name="submit" type=submit value=" 提 交 ">
                        <input name="button" type=button onClick="location.href = 'user_list.php'" value=" 返 回 "></td>
                </tr>
                </tbody>
            </table>
        </DIV>
    </FORM>
    <?php require("down.php"); ?>
    <?php ?>