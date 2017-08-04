<?php
require("up.php");
include("../inc/ieb_upload.inc");
$type = @$_GET['type'];
?>


<BODY>
    <H1><SPAN class=action-span><A 
                href="#">新增成员单位</A></SPAN> <SPAN 
            class=action-span1><A 
                href="main.php">尚峰装饰 管理中心</A> - 新增成员单位 
        </SPAN>
        <DIV style="CLEAR: both"></DIV></H1>
    <SCRIPT src="js/utils.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/Calendar.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/ajax.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/listtable.js" type=text/javascript></SCRIPT>
    <?php
    $refer = "link_list.php";
    $at_content = "";
    $px = "100";
    if (isset($_GET["action"]) == "save") {

        $upfos = new ieb_upload('file', '../pic');
        $upfos->upload();
        $upfos->thumb();
        $pic = $upfos->UpFile();
        if (!$pic) {
            $pic = $_POST['pic'];
        }


        echo $upfos->filePath();
        echo $upfos->thumbMap();

        switch (@$_GET["Result"]) {
            case("Add"): {
                    @$sql = "select * from hb_link where id='" . $_POST['id'] . "' ";
                    if (mysql_num_rows(mysql_query($sql)) > 0) {
                        echo $sql;
                        exit;
                        echo "<script language=JavaScript>{window.alert('添加失败，该文章已存在！');window.location.href='$refer';}</script>";
                        exit;
                    }

                    @$sql = "insert into hb_link (linkname,pic,url,px) values ('" . $_POST['title'] . "','" . $pic . "','" . $_POST['url'] . "','" . $_POST['px'] . "')";
                    if (mysql_query($sql)) {
                        echo "<script language=JavaScript>{window.alert('添加成功！');window.location.href='$refer';}</script>";
                        exit;
                    } else {
                        echo $sql;


                        echo "<script language=JavaScript>{window.alert('添加失败！');window.location.href='$refer';}</script>";
                        exit;
                    };
                };
                break;
            case("Modify"): {


                    $s = "update  hb_link set linkname='" . $_POST['title'] . "',pic='" . $pic . "',url='" . $_POST['url'] . "',px='" . $_POST['px'] . "' where id='" . $_GET['id'] . "' ";

                    if (mysql_query($s)) {
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
            @$sql = "select * from hb_link where id=" . $_GET['id'];
            if (@$row = mysql_fetch_array(mysql_query($sql))) {
                $id = $row["id"];

                $linkname = $row["linkname"];
                $url = $row["url"];
                $pic = $row["pic"];
                $px = $row["px"];
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
            if (!checkvalue(listForm.title, 0, 0, 1, "标题"))
                return false;



        }
//-->
    </SCRIPT>


    <FORM name=listForm action="link_Edit.php?action=save&Result=<?php print($_GET['Result']); ?>&id=<?php print(@$_GET['id']); ?>" method=post  LANGUAGE=javascript onSubmit="return add_onsubmit(this)" enctype="multipart/form-data">
        <DIV class=list-div id=listDiv>
            <table id=list-table cellspacing=1 cellpadding=5 width="100%">
                <tbody>

                    <tr>

                        <td colspan="3">
                            <br>
                            名称:&nbsp;&nbsp;&nbsp;&nbsp;<input name="title" type="text" value="<?php print(@$linkname); ?>"  size=60>
                            <font color="red">*

                            </font></td>
                    </tr>



                    <tr>

                        <td colspan="3">
                            <br>
                            图片:&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="file"> 

                            <input name="pic" type="hidden"  value="<?php print(@$pic); ?>"> 
                            <font color="red">*
                            <?php
                            if ($pic)
                                echo "<img src=../pic/" . $pic . " height=100 >";
                            ?>
                            </font></td>
                    </tr>

                    <tr>

                        <td colspan="3"><label><br>
                                网址:<input name="url" type="text" value="<?php print(@$url); ?>"  size=60> 


                            </label>
                            <font color="red">*</font>
                            <label>          </label></td>
                    </tr>

                    <tr>

                        <td colspan="3"><label><br>
                                排序:<input name="px" type="text" value="<?php print(@$px); ?>"  size=20> 


                            </label>
                            <font color="red">*</font>
                            <label>          </label></td>
                    </tr>

                    <tr>
                        <td width="20%" align="right">&nbsp;</td>
                        <td colspan="5"><input name="submit" type=submit value=" 提 交 ">
                            <input name="button" type=button onClick="location.href = 'link_list.php'" value=" 返 回 "></td>
                    </tr>
                </tbody>
            </table>
        </DIV>
    </FORM>
    <?php require("down.php"); ?>


