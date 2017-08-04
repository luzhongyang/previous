<?php
require("up.php");
include("../inc/ieb_upload.inc");
?>


<BODY>
    <H1><SPAN class=action-span><A 
                href="#">网站配置</A></SPAN> <SPAN 
            class=action-span1><A 
                href="main.php">管理中心</A> - 网站配置 
        </SPAN>
        <DIV style="CLEAR: both"></DIV></H1>
    <SCRIPT src="js/utils.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/Calendar.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/ajax.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/listtable.js" type=text/javascript></SCRIPT>
    <?php
    $refer = "siteconfig.php";
    if (isset($_GET["action"]) == "save") {
                    $s = "update  hb_config set  email='".$_POST['email']."',title='".$_POST['title']."',keywords='".$_POST['keywords']."',phone='".$_POST['phone']."',fax='".$_POST['fax']."',address='".$_POST['address']."',company='".$_POST['company']."',beian='".$_POST['beian']."' where id=1 ";

                    if (mysql_query($s)) {
                        echo "<script language=JavaScript>{window.alert('修改成功！');window.location.href='$refer';}</script>";
                        exit;
                    } else {
                        echo $s;
                        exit;

                        echo "<script language=JavaScript>{window.alert('修改失败！');window.location.href='$refer';}</script>";
                        exit;
                    }  
    } else {
       
            @$sql = "select * from hb_config where id=1";
            if (@$row = mysql_fetch_array(mysql_query($sql))) {
                $id = $row["id"];
                $email = $row["email"];
                $title = $row["title"];
                $keywords = $row["keywords"];
                $phone = $row["phone"];
                $fax = $row["fax"];
                $address = $row["address"];
                $company = $row["company"];
                $beian = $row["beian"];
            }
       
    }
    ?>

    <FORM name=listForm action="siteconfig.php?action=save" method=post  LANGUAGE=javascript onSubmit="return add_onsubmit(this)" enctype="multipart/form-data">
        <DIV class=list-div id=listDiv>
            <table id=list-table cellspacing=1 cellpadding=5 width="100%">
                <tbody>

                    <tr>

                        <td colspan="3">
                            <br>
                            网站标题:&nbsp;&nbsp;&nbsp;&nbsp;<input name="title" type="text" value="<?php print(@$title); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>

                    <tr>

                        <td colspan="3">
                            <br>
                            关&nbsp;&nbsp;键&nbsp;&nbsp;词:&nbsp;&nbsp;&nbsp;&nbsp;<input name="keywords" type="text" value="<?php print(@$keywords); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>
                       <tr>

                        <td colspan="3">
                            <br>
                            邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱:&nbsp;&nbsp;&nbsp;&nbsp;<input name="email" type="text" value="<?php print(@$email); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>   <tr>

                        <td colspan="3">
                            <br>
                            电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话:&nbsp;&nbsp;&nbsp;&nbsp;<input name="phone" type="text" value="<?php print(@$phone); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>   <tr>

                        <td colspan="3">
                            <br>
                            传&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真:&nbsp;&nbsp;&nbsp;&nbsp;<input name="fax" type="text" value="<?php print(@$fax); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>   <tr>

                        <td colspan="3">
                            <br>
                            公司地址:&nbsp;&nbsp;&nbsp;&nbsp;<input name="address" type="text" value="<?php print(@$address); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>   <tr>

                        <td colspan="3">
                            <br>
                            公司名称:&nbsp;&nbsp;&nbsp;&nbsp;<input name="company" type="text" value="<?php print(@$company); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>
                    <tr>

                        <td colspan="3">
                            <br>
                            备&nbsp;&nbsp;案&nbsp;&nbsp;号:&nbsp;&nbsp;&nbsp;&nbsp;<input name="beian" type="text" value="<?php print(@$beian); ?>"  size=40>
                            <font color="red">*

                            </font></td>
                    </tr>
                    <tr>
                        <td width="20%" align="right">&nbsp;</td>
                        <td colspan="5"><input name="submit" type=submit value=" 提 交 ">
                            <input name="button" type=button onClick="location.href = 'siteconfig.php'" value=" 返 回 "></td>
                    </tr>
                </tbody>
            </table>
        </DIV>
    </FORM>
    <?php require("down.php"); ?>


