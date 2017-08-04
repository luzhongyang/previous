<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	
	   <script type="text/javascript" src="jquery.min.js"></script> 
	   <script src="/ajaxfileupload.js" type="text/javascript" type="text/javascript"></script>
    <script> 
    	
    	 function cleardata(){ 
    	 	 $("#content").html(''); 
    	}
    function send(){ 
    	
    	 var guid="1779de7fe206101badd5101aebb0d788";
    	 var word=jQuery("#word").val();
    	  var tasktype="cron";
    	 if($('#chat').is(':checked')) {
    tasktype="chat";
}
      		jQuery.ajax({  
    url: '/bot/gettask/'+tasktype, 
    async: true,  
    dataType: 'text',  
     data: {"guid":guid,"data":word}, 
    type: 'POST',    
   
   success: function (data) { 
   	
   	 if(data.result==0){
   	  //alert(data.msg);
   	  //$("#content").append('<p>' + data.msg +'</p>'); 
   	 
   }else{
   	 $("#content").append('<p>' + data +'</p>'); 
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
    } 
 
  function push(){ 
  	
  		 var guid="1779de7fe206101badd5101aebb0d788";
  		 var word2=new String;
    	  word2=jQuery("#word2").val();
    	 
        $.ajaxFileUpload
            (
                {
                    url: '/bot/push', //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    fileElementId: 'taskfile', //文件上传域的ID
                    type: 'POST',
                    data: {"guid":guid,"data":word2},
                    dataType: 'Text', //返回值类型 一般设置为json
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                         
                            if (data.result==0) {
                            	 $("#content").append('<p>' + data +'</p>'); 
                            } else {
                            		 $("#content").append('<p>' + data +'</p>'); 
                            }
                        
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        alert(e);
                    }
                }
            )
 
}
 
 
    </script> 
	
	
	
	
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<p><a href=# onClick="cleardata()" >清空</a></p>

	
		<code  id="content">
			
	
			
			</code>


		<p>
			
			    <form action="" method="get" onSubmit="send();return false;"> 
      是否chat:<input name="chat" id="chat"  type="checkbox" value="1" />
      <textarea  name="word" id="word"  cols="100" rows="8"></textarea>
      <input type="submit" name="submit" value="get" /> 
    </form> 
			
			</p>
			
				<p>
			
			    <form action="" method="get" onSubmit="push();return false;"> 
      <!--上传文件:<input name="taskfile" id="taskfile" type="file" />-->
      <textarea  name="word2" id="word2"  cols="100" rows="8"></textarea>
      <input type="submit" name="submit" value="push" /> 
    </form> 
			
			</p>
			
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>