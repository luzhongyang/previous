<? require("connection.php"); ?>
<? require("tools.php"); ?>
<? require("checkrole.php"); ?>  
<? require("smtp.php"); ?>
<?
$refer = $_SERVER["HTTP_REFERER"];
$smtpserver = "smtp.163.com";//SMTP服务器

$smtpserverport =25;//SMTP服务器端口

$smtpusermail = "mengyuan5@163.com";//SMTP服务器的用户邮箱



$smtpuser = "mengyuan5";//SMTP服务器的用户帐号

$smtppass = "302107";//SMTP服务器的用户密码

$accountno=$_POST['accountno'] ;
$marketno=$_POST['marketno'] ;


$sql1="select * from market where marketid='".$marketno."' " ;
$result1=mysql_query(mysql_query$sql1);
$row1=mysql_fetch_array($result1);
$marketname=$row1["name"];

$sql2="select * from company where accountno='".$accountno."' " ;
$result2=mysql_query(mysql_query$sql2);
$row2=mysql_fetch_array($result2);
$companyname=$row2["name"];

$sql3="select * from muser where accountno='".$accountno."' " ;
$result3=mysql_query(mysql_query$sql3);

while($row3 = mysql_fetch_array($result3)){    

$smtpemailto = $row3["email"];//发送给谁
$mailsubject = "来自".$marketname."的邀请";//邮件主题

$mailbody = $companyname."<h1>你好，我们邀请你参加</h1>";//邮件内容

$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件

$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.

$smtp->debug = false;//是否显示发送的调试信息

$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);


}

echo  "<script language=JavaScript>{window.alert('邮件发送成功');window.location.href='$refer';}</script>" ;

?>

