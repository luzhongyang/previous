<?php
/*
 *   Filename:    authpage.php 
 *   Author:   hutuworm 
 *   Date:   2003-04-28 
 *   @Copyleft    hutuworm.org 
 */

srand((double) microtime() * 1000000);

//验证用户输入是否和验证码一致 
if (isset($HTTP_POST_VARS['authinput'])) {
    if (strcmp($HTTP_POST_VARS['authnum'], $HTTP_POST_VARS['authinput']) == 0)
        echo "验证成功！";
    else
        echo "验证失败！";
}

//生成新的四位整数验证码 
while (($authnum = rand() % 10000) < 1000);
?> 
<form action=authpage.php method=post> 
    <table> 
        请输入验证码：<input type=text name=authinput style="width: 80px"><br> 
        <input type=submit name="验证" value="提交验证码"> 
        <input type=hidden name=authnum value=<? echo $authnum; ?>> 
               <img src=authimg.php?authnum=<? echo $authnum; ?>><br> <img src=this.php> 
    </table> 
</form>