<?php
@session_start();
?>
<?php require("../inc/conn.php"); ?>
<?php
$errormsg = "";
if (isset($_POST['username'])) {


    $user = mysql_real_escape_string($_POST['username']);
    $pass = mysql_real_escape_string($_POST['password']);
    //$pass=md5($pass);
    if ($errormsg == "") {
        $sql = "select * from hb_admin where username= '" . $user . "' and password='" . $pass . "'  ";
        $result = mysql_query($sql);
        $num = mysql_num_rows($result);

        if ($num < 1) {
            $errormsg = "用户名或密码不正确，请重新登录！";
        } else {
            $row = mysql_fetch_array($result);


            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];



            echo "<script language=JavaScript>{window.location.href='index.php';}</script>";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>豪邦保安 管理中心</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <center>
            <div class="top"></div>
            <div class="mid_box">
                <div class="mid">
                    <div class="mid_left"></div>
                    <div class="mid_cen"></div>
                    <FORM name=theForm onSubmit="return validate()" action=? 
                          method=post>
                        <div class="mid_right">
                            <div class="from_box">
                                <table width="254" border="0" cellspacing="0" cellpadding="0">

                                    <tr>
                                        <td width="51" height="49">&nbsp;</td>
                                        <td width="203"><input name=username type="text" class="from" id="textfield"   /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="from_box2">
                                <table width="254" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="51" height="49">&nbsp;</td>
                                        <td width="203"><input name=password type="password" class="from" id="textfield"  /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="login_an">
                                <label>
                                    <input type="image" name="button" id="button" value="进入管理中心" src="images/img_14.png" width="254" height="47" />
                                </label>
                            </div>
                            <div class="wz">&raquo;<?php print($errormsg); ?></div>
                        </div>
                    </FORM>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="bottom"></div>
        </center>
        <SCRIPT language=JavaScript>
            <!--
          document.forms['theForm'].elements['username'].focus();

            /**
             * 检查表单输入的内容
             */
            function validate()
            {
                var validator = new Validator('theForm');
                validator.required('username', '账号不能为空');
                validator.required('password', '密码不能为空');

                return validator.passed();
            }

//-->
        </SCRIPT>
    </body>
</html>
