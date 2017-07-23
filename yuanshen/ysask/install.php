<?php
//检查是否安装
if(file_exists("Data/install.lock")){
	header("Location: /"); 
	die();
}else{
	header("Location: /index.php?m=install&c=index&a=index"); 
}
?>