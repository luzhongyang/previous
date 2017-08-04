<?php require("up.php"); ?>
<?php require("tools.php"); ?>

<?php
$search = "";


if (@$_GET['content'] <> "") {
    $content = $_GET['content'];
    if ($search == "") {
        $search .= " WHERE ";
    } else {
        $search .= " AND ";
    }
    $search .= " content  like '%" . $content . "%'  ";
}


$table = "guestbook";

$sql = "select * from " . $table . $search;

//请参考下面代码排序
//$sql="select * from " . $table . $search  ." order by id DESC";
//echo $sql;exit();

$result = mysql_query($sql);

$pagesize = 10;  //每页记录条数

$result_num = mysql_num_rows($result);

if ($result_num <= 0) {
    if ($search == "") {
        $word = "目前还没有记录!";
    } else {
        $word = "没有查到符合条件的记录!";
    }
} else {

    $maxpage = ceil($result_num / $pagesize);
    @$page = $_GET['page'];
    if (is_long($page) or $page == "") {
        $page = 1;
    } else {
        $page = (int) ($page);
    }

    if ($page < 1) {
        $page = 1;
    } else if ($page > $maxpage) {
        $page = $maxpage;
    }

    mysql_data_seek($result, ($page - 1) * $pagesize);
    $n = 1;
}
?>
<BODY>
    <H1><SPAN class=action-span></SPAN> <SPAN 
            class=action-span1><A 
                href="guestbook_list.php">尚峰装饰 管理中心</A> - 成员单位列表 
        </SPAN>
        <DIV style="CLEAR: both"></DIV></H1>


    <DIV class=form-div>
        <FORM name=searchForm action="guestbook_list.php" method="get"><IMG height=22 alt=SEARCH 
                                                                            src="images/icon_search.gif" width=26 border=0> &nbsp;
            &nbsp;&nbsp;留言:
            <INPUT name=content >  <INPUT type=submit value=" 搜索 "> </FORM></DIV>
    <DIV class=form-div>共搜索到<font color="#FF0000"><?php print($result_num); ?></font>条符合条件的信息</DIV>
    <?php if ($result_num <= 0) { ?>

    <center><BR><BR><?php print($word); ?></center>

<?php } else { ?>
    <FORM name=listForm action="" method=post><!-- start users list -->
        <DIV class=list-div id=listDiv><!--用户列表部分-->
            <TABLE cellSpacing=1 cellPadding=3 width="100%">
                <TBODY>
                    <TR>

                        <TH >名称</TH>
                        <TH >类别</TH>
                        <TH >性别</TH>
                        <TH >邮箱</TH>
                        <TH >电话</TH>
                        <TH >时间</TH>
                        <TH  >操作</TH>
                    </TR>
                    <?php while ($row = mysql_fetch_array($result)) { ?>  
                        <TR>

                            <TD  ><?php print($row["name"]); ?></TD>
                            <TD  ><?php print($row["type"]); ?></TD>
                            <TD  ><?php print($row["sex"]); ?></TD>
                            <TD  ><?php print($row["email"]); ?></TD>
                            <TD  ><?php print($row["tel"]); ?></TD>
                            <TD  ><?php print($row["addtime"]); ?></TD>


                            <TD align=middle width=100> <A title=移除 
                                                           href="javascript:confirm_redirect('您确定要删除该数据吗？',%20'guestbook_del.php?act=remove&id=<?php print($row["id"]); ?>')"><IMG 
                                        height=16 src="images/icon_drop.gif" width=16 
                                        border=0></A> </TD>
                        </TR>
                        <TR>
                            <TD colSpan=7 >【留言内容】：&nbsp;<?php print($row["content"]); ?></TD>

                        </TR>




                        <?php
                        $n++;
                        if ($n > $pagesize)
                            break;
                    }
                    ?> 
                    <TR>
                        <TD colSpan=7>&nbsp;</TD>

                    </TR></TBODY></TABLE>
        </DIV><!-- end users list --></FORM>
    <?php
    if (@$_GET["title"] == "") {
        LastNextPage($maxpage, $page, "width=100% ", "<p  align=center class=font2>");
    } else {
        TurnPage($maxpage, $page, "width=100% ", "<p  align=center class=font2>");
    }
    ?>
<?php } ?>
<SCRIPT language=JavaScript>
<!--
    function CheckAll(form)
    {
        if (form.submitAllSearch.checked == true) {
            for (var i = 0; i < form.elements.length; i++)
            {
                var e = form.elements[i];
                e.checked = true;
            }
        }
        else {
            for (var i = 0; i < form.elements.length; i++)
            {
                var e = form.elements[i];
                e.checked = false;
            }
        }
    }
</script>
</BODY></HTML>