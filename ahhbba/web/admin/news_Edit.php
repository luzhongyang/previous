<?php
require("up.php");
include("../inc/ieb_upload.inc");
$type = @$_GET['type'];

?>
<script type="text/javascript" charset="utf-8" src="/ueadmin/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueadmin/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueadmin/lang/zh-cn/zh-cn.js"></script>

<BODY>
    <H1><SPAN class=action-span><A href="#">新增文章</A></SPAN> <SPAN class=action-span1><A href="main.php">豪邦后台管理中心</A> - 文章操作</SPAN>
    <DIV style="CLEAR: both"></DIV></H1>
    <SCRIPT src="js/utils.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/Calendar.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/ajax.js" type=text/javascript></SCRIPT>
    <SCRIPT src="js/listtable.js" type=text/javascript></SCRIPT>
    <?php
    $refer = "news_list.php?&type=".$type."";
    $at_content="";
    if (isset($_GET["action"])=="save"){

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
                    $sql = "select * from hb_news where id='" . $_POST['id'] . "' ";
                    if (mysql_num_rows(mysql_query($sql)) > 0) {
                        echo $sql;
                        
                        echo "<script language=JavaScript>{window.alert('添加失败，该文章已存在！');window.location.href='$refer';}</script>";
                        exit;
                    }
                    $sql1 = "insert into hb_news (title,pic,inf,addtime,class,type,sort_order) values ('" . $_POST['title'] . "','" . $pic . "','" . $_POST['content'] . "','" . date("Y-m-d H:i:s") . "','" . $_POST['classname'] . "','" . $type ."'      ,'" . $_POST['sort_order'] . "' )";                 
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
                    $s = "update  hb_news set title='" . $_POST['title'] . "',pic='" . $pic . "',class='" . $_POST['classname'] . "',inf='" . $_POST['content'] . "',addtime='" . date("Y-m-d H:i:s") . "'       ,sort_order=" . $_POST['sort_order'] . "               where id='" . $_GET['id'] . "' ";          
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
            @$sql = "select * from hb_news where id=" . $_GET['id'];
            if (@$row = mysql_fetch_array(mysql_query($sql))) {
                $id = $row["id"];
                $title = $row["title"];
                $content = $row["inf"];
                $addtime = $row["addtime"];
                $pic = $row["pic"];
                $newsclass = $row["class"];
                $sort_order = $row["sort_order"];
            }
        }
    }
    ?>
    <FORM name=listForm action="news_Edit.php?action=save&Result=<?php print($_GET['Result']); ?>&id=<?php print(@$_GET['id']); ?>&type=<?php print(@$type); ?>" method=post  LANGUAGE=javascript onSubmit="return add_onsubmit(this)" enctype="multipart/form-data">
        <DIV class=list-div id=listDiv>
            <table id=list-table cellspacing=1 cellpadding=5 width="100%">
                <tbody>

                    <tr>

                        <td colspan="3">
                            <br>
                            标题:&nbsp;&nbsp;&nbsp;&nbsp;<input name="title" type="text" value="<?php print(@$title); ?>"  size=60>
                            <font color="red">*
                            <?php
                           // echo "[时间：" . $addtime . "]";
                            ?>
                            </font></td>
                    </tr>

                    <tr>

                        <td colspan="3">
                            <br>
                            类别:&nbsp;&nbsp;&nbsp;&nbsp;


                            <select name="classname">
                             <?php
                                $sql = "SELECT classname from hb_class where type='" . $type . "' ";
                                $result = mysql_query($sql);

                                while ($class = mysql_fetch_array($result)) { ?>
                                    <option value="<?php echo $class['classname']; ?>" <?php if ($newsclass == $class['classname']) echo "selected"; ?>><?php echo $class['classname']; ?></option>
                             <?php
                                }
                             ?>
                            </select>

                        </td>
                    </tr>  
                    <tr>
                        <td colspan="3">
                            <br>
                            排序:&nbsp;&nbsp;&nbsp;&nbsp;                          
                            <input type="text" name='sort_order'  value="<?php echo $sort_order; ?>" size="15" />
                        </td>
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

                        <td colspan="3">
                            <label><br>
                                <textarea name="content" id="content"  style="width:800px;height:500px;">
                                    <?php echo $content; ?>
                                </textarea>
                            </label>
                            <font color="red">*</font>
                            <label></label>
                        </td>
                    </tr>


                    <tr>
                        <td width="20%" align="right">&nbsp;</td>
                        <td colspan="5"><input name="submit" type=submit value=" 提 交 ">
                        <input name="button" type=button onClick="location.href = 'news_list.php'" value=" 返 回 "></td>
                    </tr>
                </tbody>
            </table>
        </DIV>
    </FORM>
    <script type="text/javascript">

        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('content');



    </script>
    <?php require("down.php"); ?>


