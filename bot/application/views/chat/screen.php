<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
	<title>ScreenViewer</title>
	<script src="<?php echo $this->config->item('static_chat'); ?>/leftmenu/js/jquery.min.js" type="text/javascript"></script>
</head>
<body  oncontextmenu="return false">

<div id="doc" name="doc">
    图像品质：<select name="digit" id="digit" class="form-control"><option value="1">1位</option><option value="4" selected>4位</option><option value="8">8位</option></select>  <button type="button" name="monitor_sw" id="monitor_sw" onclick="Monitor_Switch()">开始控制桌面</button>
	<span id="textoutput3"></span><span id="textoutput"></span><span id="textoutput2"></span>
	<div id="bd">
		<div id="ScreenArea">
		<img src="" id="ScreenOutput">
		</div>

		<script type="text/javascript"> 
var timer;
var click_count=0;

 $("#ScreenArea").mousemove(function(e)
 {
	 position=getClickPos(e);
	 $("#textoutput").html("【坐标:X:"+position[0]+"Y:"+position[1]+"】");
 });
//<act>4</act><x>124</x><y>3534</y>

$(document).keyup(function(e){
        var key =  e.which;
		//alert("弹起:"+key);

		//addkeyboardcommand(7,key);
		if(key==8){
			return false;
		}
        }
    );
$(document).keydown(function(e){
        var key =  e.which;
		//alert("按下:"+key);
		addkeyboardcommand(6,key);
		if(key==8){
			return false;
		}
        }
    );



$("#ScreenArea").mousedown(function(e)
{
	if(3 == e.which)
	{
		position=getClickPos(e);
		$("#textoutput2").html("右键单击,坐标:X:"+position[0]+"Y:"+position[1]);
		addmousecommand(3,position[0],position[1]);
	}
	else if(1 == e.which)
	{ 
		if(click_count==1)
		{
			clearTimeout(timer);
			click_count=0;
			position=getClickPos(e);
			$("#textoutput2").html("左键双击,坐标:X:"+position[0]+"Y:"+position[1]);
			addmousecommand(2,position[0],position[1]);
			return;
		}
		click_count=1;
		timer=setTimeout(function(){
			position=getClickPos(e);
			$("#textoutput2").html("左键单击,坐标:X:"+position[0]+"Y:"+position[1]);
			addmousecommand(1,position[0],position[1]);
			click_count=0;
			},350);
	}
});
		

function getClickPos(e){
    var xPage = (navigator.appName == 'Netscape')? e.pageX : event.x+document.body.scrollLeft;
    var yPage = (navigator.appName == 'Netscape')? e.pageY : event.y+document.body.scrollTop;
    identifyImage = document.getElementById("ScreenOutput");
    img_x = locationLeft(identifyImage);
    img_y = locationTop(identifyImage);
    var xPos = xPage-img_x;
    var yPos = yPage-img_y;
	return [xPos,yPos]
}
function locationLeft(element){
    offsetTotal = element.offsetLeft;
    scrollTotal = 0;
    if (element.tagName != "BODY"){
       if (element.offsetParent != null)
          return offsetTotal+scrollTotal+locationLeft(element.offsetParent);
    }
    return offsetTotal+scrollTotal;
}
function locationTop(element){
    offsetTotal = element.offsetTop;
    scrollTotal = 0; 
    if (element.tagName != "BODY"){
       if (element.offsetParent != null)
          return offsetTotal+scrollTotal+locationTop(element.offsetParent);
    }
    return offsetTotal+scrollTotal;
}


var start_switch=0;
var sc_id=0;
function Monitor_Switch()
{

	if(start_switch==0)
	{
		document.getElementById("monitor_sw").innerHTML="停止控制桌面";		
		addcommand();
		start_switch=1
	}
	else
	{

		document.getElementById("monitor_sw").innerHTML="开始控制桌面";
		start_switch=0;
    sc_id=0;
	}
}

function addcommand()
{
	   sc_id=sc_id+1;
	  var  digit=$("#digit").val();
	  jQuery.ajax({  
    url: '/chat/screen/send', 
    async: true,  
    dataType: 'text',  
    data: {"digit":digit,"id":"0"}, 
    type: 'POST',     
   success: function (data) { 	
   	if(data!="error")
   	{ 		
    $("#ScreenOutput").attr("src","data:image/jpg;base64,"+data);
    }
    $("#textoutput3").html("【帧数:"+sc_id+"】");  
    if(start_switch==1){
    addcommand();
   }
 
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) {  	  
 //alert(errorThrown); 
 },  
     
  }); 
  
	
}


function addmousecommand(act,x_pos,y_pos)
{
		 if(start_switch==0){
			return false;
		}
		  jQuery.ajax({  
    url: '/chat/screen/addmouse', 
    async: true,  
    dataType: 'text',  
    data: {"type":act,"x":x_pos,"y":y_pos}, 
    type: 'POST',     
   success: function (data) { 		
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) {  	  
 alert(errorThrown); 
 },  
     
  }); 
	

}
function addkeyboardcommand(direction,key_code)
{
		 if(start_switch==0){
			return false;
		}
	  jQuery.ajax({  
    url: '/chat/screen/addkeyboard', 
    async: true,  
    dataType: 'text',  
    data: {"key":key_code}, 
    type: 'POST',     
   success: function (data) { 		
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) {  	  
 alert(errorThrown); 
 },  
     
  }); 
	
}


// 		function getScreenshot(current_cmdid)
//		{	
//			F.mxhr.listen('image/jpeg', function(payload, payloadId) {
//				var img = document.createElement('img');
//				img.src = 'data:image/jpeg;base64,' + payload;
//				alert(img.src);
//				img.width = 1000;
//				img.height = 560;
//				document.getElementById('mxhr-output').appendChild(img);
//			});
//			F.mxhr.load('ScreenCapture.php?send_stream='+current_cmdid);
//			
//			F.mxhr=null;
//		} 
		</script>
	</div> 
	<div id="ft"></div>
</div>

</body>
</html>