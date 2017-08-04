<?php require("up.php"); ?>
<?php require("tools.php"); ?>
<?php require("../function.php"); ?>
<?php
if ($_COOKIE['admin_usr_level'] != "1") {

    print "<script>alert('对不起，你没有该管理权限！');history.go(-1)</script>";
}
$search = "";
if (@$_GET["usr_row_status"] <> "") {
    $search = $search . " where usr_row_status ='" . $_GET["usr_row_status"] . "' ";
}

if (@$_GET['usr_name'] <> "") {
    if ($search == "") {
        $search .= " WHERE ";
    } else {
        $search .= " AND ";
    }
    $search .= " usr_name  like '%" . $_GET['usr_name'] . "%' or usr_description  like  '%" . $_GET['usr_name'] . "%'";
}

$table = "users";

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
    <H1><SPAN class=action-span><A 
                href="user_Edit.php?Result=Add">新增用户</A></SPAN> <SPAN 
            class=action-span1><A 
                href="user_list.php">明富 管理中心</A> - 用户列表 
        </SPAN>
        <DIV style="CLEAR: both"></DIV></H1>


    <DIV class=form-div>
        <FORM name=searchForm action=user_list.php method="get"><IMG height=22 alt=SEARCH 
                                                                     src="images/icon_search.gif" width=26 border=0> &nbsp;数据状态 
            <SELECT name=usr_row_status>
                <OPTION value='' selected>所有状态</OPTION>

                <option value='1' >未审核</option>
                <option value='2' >已审核</option>
            </SELECT> 
            &nbsp;&nbsp;姓名 &nbsp;
            <INPUT name=username> <INPUT type=submit value=" 搜索 "> </FORM></DIV>
    <DIV class=form-div>共搜索到<font color="#FF0000"><?php print($result_num); ?></font>条符合条件的信息</DIV>
    <?php if ($result_num <= 0) { ?>

    <center><BR><BR><?php print($word); ?></center>

<?php } else { ?>
    <FORM name=listForm action="users_del.php" method=post><!-- start users list -->
        <DIV class=list-div id=listDiv><!--用户列表部分-->
            <TABLE cellSpacing=1 cellPadding=3>
                <TBODY>
                    <TR>
                        <TH><INPUT onClick="CheckAll(this.form)" name="buttonAllSelect"  id="submitAllSearch" type=checkbox> 序号<IMG 
                                src="images/sort_desc.gif"> </TH>
                        <TH>姓名</TH>
                        <TH>用户级别</TH>
                        <TH>审核状态</TH>
                        <TH>用户性质</TH>
                        <TH>创建者</TH>
                        <TH>创建日期</TH>
                        <TH width=200>描述</TH>

                        <TH>操作</TH>
                    </TR>
                    <?php while ($row = mysql_fetch_array($result)) { ?>  
                        <TR>
                            <TD><INPUT type=checkbox value=<?php print(HtmlOut($row["usr_id"])); ?>  name=id><?php print(HtmlOut($row["usr_id"])); ?></TD>
                            <TD  ><?php print(HtmlOut($row["usr_name"])); ?></TD>
                            <TD><div align="center">
                                    <?php
                                    if ($row["usr_level"] == "1") {
                                        print "超级";
                                    } else {
                                        print "普通";
                                    }
                                    ?>
                                </div>      </TD>
                            <TD align=middle>
                                <div align="center">
                                    <?php if ($row["usr_row_status"] == 2) { ?>
                                        <IMG src="images/yes.gif">
                                        <?php
                                    } else {
                                        ?>
                                        <A title=审核 
                                           href="javascript:confirm_redirect('您确定要审核此数据吗？',%20'audit.php?table=users&key=usr_id&status=usr_row_status&id=<?php print(HtmlOut($row["usr_id"])); ?>')">
                                            <IMG src="images/no.gif" border="0"></A>
                                    <?php }
                                    ?>
                                </div></TD>
                            <TD>
                                <div align="center">
                                    <?php
                                    if ($row["usr_class"] == "1") {
                                        print "输入";
                                    } elseif ($row["usr_class"] == "2") {
                                        print "审核";
                                    } else {
                                        print "维护";
                                    }
                                    ?>
                                </div></TD>
                            <TD><div align="center"><?php print(HtmlOut($row["usr_create_user_id"])); ?></div></TD>
                            <TD><div align="center"><?php print(HtmlOut($row["usr_create_date"])); ?></div>
                                <div align="center"></div></TD>
                            <TD><?php print(HtmlOut($row["usr_description"])); ?></TD>

                            <TD align=middle><A title=编辑 
                                                href="user_edit.php?Result=Modify&id=<?php print(HtmlOut($row["usr_id"])); ?>"><IMG 
                                        height=16 src="images/icon_edit.gif" width=16 
                                        border=0></A> <A title=移除 
                                                 href="javascript:confirm_redirect('您确定要删除该客户账号吗？',%20'users_del.php?act=remove&id=<?php print(HtmlOut($row["usr_id"])); ?>')"><IMG 
                                        height=16 src="images/icon_drop.gif" width=16 
                                        border=0></A> </TD>
                        </TR>
                        <?php
                        $n++;
                        if ($n > $pagesize)
                            break;
                    }
                    ?> 
                    <TR>
                        <TD colSpan=2><INPUT name='submitDelSelect'  id='submitDelSelect'   type=submit value=删除></TD>
                        <TD noWrap align=right colSpan=8><!-- $Id: page.htm 14216 2008-03-10 02:27:21Z testyang $ -->
                            <DIV id=turn-page></DIV></TD></TR></TBODY></TABLE>
        </DIV><!-- end users list --></FORM>
    <?php
    if (@$_GET["usr_row_status"] == "" and @$_GET["usr_name"] == "") {
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