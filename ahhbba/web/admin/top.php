<?php
@session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE></TITLE>
        <META http-equiv=Content-Type content="text/html; charset=utf-8"><LINK 
            href="css/general.css" type=text/css rel=stylesheet>
        <STYLE type=text/css>#header-div {
                BACKGROUND: #278296; BORDER-BOTTOM: #fff 1px solid
            }
            #logo-div {
                FLOAT: left; HEIGHT: 56px
            }
            #submenu-div {
                HEIGHT: 57px
            }
            #submenu-div ul {
                PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; LIST-STYLE-TYPE: none
            }
            #submenu-div LI {
                PADDING-RIGHT: 10px; PADDING-LEFT: 10px; FLOAT: right; PADDING-BOTTOM: 0px; MARGIN: 3px 0px; BORDER-LEFT: #fff 1px solid; PADDING-TOP: 0px
            }
            #submenu-div A:visited {
                COLOR: #fff; TEXT-DECORATION: none
            }
            #submenu-div A:link {
                COLOR: #fff; TEXT-DECORATION: none
            }
            #submenu-div A:hover {
                COLOR: #f5c29a
            }
            #loading-div {
                CLEAR: right; DISPLAY: block; TEXT-ALIGN: right
            }
            #menu-div {
                FONT-WEIGHT: bold; BACKGROUND: #80bdcb; LINE-HEIGHT: 24px; HEIGHT: 24px
            }
            #menu-div ul {
                PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; LIST-STYLE-TYPE: none
            }
            #menu-div LI {
                BORDER-RIGHT: #192e32 1px solid; FLOAT: left; BORDER-LEFT: #bbdde5 1px solid
            }
            #menu-div A:visited {
                PADDING-RIGHT: 20px; DISPLAY: block; PADDING-LEFT: 20px; BACKGROUND: #9ccbd6; PADDING-BOTTOM: 0px; COLOR: #335b64; PADDING-TOP: 0px; TEXT-DECORATION: none
            }
            #menu-div A:link {
                PADDING-RIGHT: 20px; DISPLAY: block; PADDING-LEFT: 20px; BACKGROUND: #9ccbd6; PADDING-BOTTOM: 0px; COLOR: #335b64; PADDING-TOP: 0px; TEXT-DECORATION: none
            }
            #menu-div A:hover {
                BACKGROUND: #80bdcb; COLOR: #000
            }
            #submenu-div A.fix-submenu {
                CLEAR: both; PADDING-RIGHT: 5px; PADDING-LEFT: 5px; BACKGROUND: #ddeef2; PADDING-BOTTOM: 5px; MARGIN-LEFT: 5px; COLOR: #278296; PADDING-TOP: 3px
            }
            #submenu-div A.fix-submenu:hover {
                PADDING-RIGHT: 5px; PADDING-LEFT: 5px; BACKGROUND: #fff; PADDING-BOTTOM: 5px; COLOR: #278296; PADDING-TOP: 3px
            }
            #menu-div LI.fix-spacel {
                WIDTH: 30px; BORDER-LEFT-STYLE: none
            }
            #menu-div LI.fix-spacer {
                BORDER-RIGHT-STYLE: none
            }
        </STYLE>

        <SCRIPT type=text/javascript>
            function modalDialog(url, name, width, height)
            {
                if (width == undefined)
                {
                    width = 400;
                }
                if (height == undefined)
                {
                    height = 300;
                }

                if (window.showModalDialog)
                {
                    window.showModalDialog(url, name, 'dialogWidth=' + (width) + 'px; dialogHeight=' + (height + 5) + 'px; status=off');
                }
                else
                {
                    x = (window.screen.width - width) / 2;
                    y = (window.screen.height - height) / 2;

                    window.open(url, name, 'height=' + height + ', width=' + width + ', left=' + x + ', top=' + y + ', toolbar=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, modal=yes');
                }
            }

            function ShowToDoList()
            {
                try
                {
                    var mainFrame = window.top.frames['main-frame'];
                    mainFrame.window.showTodoList(adminId);
                }
                catch (ex)
                {
                }
            }


            var adminId = "1";
        </SCRIPT>

        <META content="MSHTML 6.00.3790.4426" name=GENERATOR></HEAD>
    <BODY>
        <DIV id=header-div>
            
            <DIV id=logo-div>
                <IMG src="./images/admin_logo.jpg" alt="ECSHOP - power for e-commerce" width="186" height="56">
            </DIV>
            
            <DIV id=submenu-div>
                <ul>

                    <LI><A href="/" target=_blank>查看网站</A> </LI>

                    <LI><A 
                            href="javascript:window.top.frames['main-frame'].document.location.reload();window.top.frames['header-frame'].document.location.reload()">刷新</A> 
                    </LI>
                    <!--<LI><A href="/" 
                           target=main-frame>修改密码</A> </LI>
                    <LI style="BORDER-LEFT-STYLE: none;color:#ffffff">欢迎你：<?php echo $_SESSION['username']; ?> </LI>-->
                </ul>
                <DIV id=send_info 
                     style="CLEAR: right; PADDING-RIGHT: 10px; PADDING-LEFT: 0px; FLOAT: right; PADDING-BOTTOM: 0px; WIDTH: 40%; COLOR: #ff9900; PADDING-TOP: 5px; TEXT-ALIGN: right">
                    <!--<A class=fix-submenu href="#" target=main-frame>清除缓存</A> -->
                    <A class=fix-submenu  href="adminlogout.php" target=_parent >退出</A> </DIV>
                <DIV id=load-div 
                     style="PADDING-RIGHT: 10px; DISPLAY: none; PADDING-LEFT: 0px; FLOAT: right; PADDING-BOTTOM: 0px; WIDTH: 40%; COLOR: #ff9900; PADDING-TOP: 5px; TEXT-ALIGN: right"><IMG 
                        style="VERTICAL-ALIGN: middle" height=16 alt=正在处理您的请求... 
                        src="index_files/top_loader.gif" width=16> 正在处理您的请求...</DIV></DIV></DIV>
        <DIV id=menu-div>
            <ul>
                <LI class=fix-spacel> </LI>
                <LI><A href="main.php" 
                       target=main-frame>起始页</A> </LI>

                <!--<LI><A href="news_list.php" 
                       target=main-frame>所有子栏目列表</A> </LI>-->

                <LI class=fix-spacer> </LI></ul><BR class=clear></DIV></BODY></HTML>
