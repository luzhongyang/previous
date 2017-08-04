<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3 class="modal-title">【<?php echo $netbot['nb_name'];?>】(<?php echo $netbot['nb_id'];?>)--<?php echo $netbot['nb_guid'];?>  </h4>
</div>
<div class="modal-body" id="waitui">
	
	<div class="tc-list-wrap">            <ul class="tc-list clearfix">                <li>                    <em class="tc-dlist-tit">名称</em>                    <span class="tc-dlist-det"><?php echo $netbot['nb_name'];?></span>                </li>                <li>                    <em class="tc-dlist-tit">当前状态</em>                    <span class="tc-dlist-det" id="stauts"><?php echo $netbot['stauts'];?>
	<?php if($netbot['nb_stauts']==2){ ?>
	<a href="/admin/main/chat?netbotguid=<?php echo $netbot['nb_guid'];?>" class="btn btn-xs blue" target=_chat><i class="fa fa-clock-o"></i>在线管理</a>
	<?php }else{ ?>
			<a href="/admin/main/offline?netbotguid=<?php echo $netbot['nb_guid'];?>" class="btn btn-xs blue" target=_chat><i class="fa fa-clock-o"></i>离线管理</a>
<?php } ?>
		
		</span>                </li>                <li>                    <em class="tc-dlist-tit">更新时间</em>                    <span class="tc-dlist-det"><?php echo $netbot['nb_lasttime'];?></span>               </li>                <li>                    <em class="tc-dlist-tit" >操作：</em>                    <span class="tc-dlist-det" title="" id="action"><?php echo $netbot['action'];?></span>                </li>            </ul>        </div>
	
	
	<div class="row">
		<div class="col-md-12">
	
	 <div class="tabbable tabbable-custom boxless tabbable-reversed">
 <ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_0" data-toggle="tab" onclick="get_app(0);">
									 参 数
								</a>
							</li>
							<li  class="">
								<a href="#tab_1" data-toggle="tab" onclick="get_tasksing();">
									 计划任务
								</a>
							</li>
							
							<li  class="">
								<a href="#tab_2" data-toggle="tab" onclick="get_taskcroning();">
									 队列记录-【计划】
								</a>
							</li>
							
										<li  class="">
								<a href="#tab_3" data-toggle="tab" onclick="get_taskchating();">
									 队列记录-【即时】
								</a>
							</li>
							
					
						
							
						</ul>
						
						 	<div class="tab-content">
						 		
						 		
						 		
 			<div class="tab-pane active"  id="tab_0">
 			
<div class="row static-info">
	<div class="col-md-2 value">名称</div>
	<div class="col-md-2 name">
		<span id="nb_name"><?php echo $netbot['nb_name'];?></span> <a href="javascript:setname('<?php echo $netbot['nb_guid'];?>','<?php echo $netbot['nb_name'];?>')" class="btn btn-xs red"><i class="fa fa-flag"></i> 标注</a>
	</div>
	<div class="col-md-2 value">计算机名</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_cname'];?></div>
</div> 		
<div class="row static-info">
	<div class="col-md-2 value">版本号</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_vid'];?></div>
	<div class="col-md-2 value">操作系统</div>
	<div class="col-md-4 name"><?php echo @$netbot_os[$netbot['nb_os']]?$netbot_os[$netbot['nb_os']]:$netbot['nb_os'];?></div>
</div>	
<div class="row static-info">
	<div class="col-md-2 value">公网IP</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_lastip'];?></div>
	<div class="col-md-2 value">CPU</div>
	<div class="col-md-4 name"><?php if($netbot['nb_amd64']) echo "【64位】";?><?php echo $netbot['nb_cpu'];?></div>
</div>		
<div class="row static-info">
	<div class="col-md-2 value">所属网络</div>
	<div class="col-md-4 name"><?php echo get_nb_internet($netbot['nb_internet']) ;?></div>
	<div class="col-md-2 value">内存</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_mem'];?></div>
</div>		
<div class="row static-info">
	<div class="col-md-2 value">地区</div>
	<div class="col-md-4 name"><?php echo $netbot_area[$netbot['nb_area']];?></div>
	<div class="col-md-2 value">MAC</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_mac'];?></div>
</div>
<div class="row static-info">
	<div class="col-md-2 value">创建时间</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_addtime'];?></div>
	<div class="col-md-2 value">虚拟机</div>
	<div class="col-md-4 name">
		<?php if($netbot['nb_vm'])
  	     {
  	       echo "是";
  	    }else{
  	       echo "否";	
  	    } ?>
	</div>
</div>
<div class="row static-info">
	<div class="col-md-2 value">更新时间</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_lasttime'];?></div>
	<div class="col-md-2 value">主分组</div>
	<div class="col-md-4 name"><?php echo $netbot['ng_name'];?></div>
</div>	
<div class="row static-info">
	<div class="col-md-2 value">GUID</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_guid'];?></div>
	<div class="col-md-2 value">扩展分组</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_group_expand'];?></div>
</div>	
<div class="row static-info">
	<div class="col-md-2 value">请求间隔</div>
	<div class="col-md-2 name">
		<span id="nb_interval"><?php echo $netbot['nb_interval'];?></span> <a href="javascript:setstauts('<?php echo $netbot['nb_guid'];?>',11,'<?php echo $netbot['nb_interval'];?>')" class="btn btn-xs blue"><i class="fa fa-clock-o"></i>修改默认值</a>
	</div>
	<div class="col-md-3 value">主上线地址</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_url'];?>[<?php echo $netbot['nb_lasturl'];?>]</div>
</div>	
<div class="row static-info">
	<div class="col-md-2 value">备注</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_inf'];?></div>
	<div class="col-md-2 value">备用上线地址</div>
	<div class="col-md-4 name"><?php echo $netbot['nb_url_bak'];?></div>
</div>	

 	
 			</div>
 			
 				<div class="tab-pane "  id="tab_1">
 				
 				
 		
					
					
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a href="/admin/task/edit/0/<?php echo $netbot['nb_guid'];?>" role="button" class="btn red" data-target="#ajax" data-toggle="modal">
														<i class="fa fa-pencil"></i> 添加一个本机计划任务
										</a>
									
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="javascript:;">
													Print </a>
												</li>
												<li>
													<a href="javascript:;">
													Save as PDF </a>
												</li>
												<li>
													<a href="javascript:;">
													Export to Excel </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
								<table class="table table-striped table-bordered table-hover" id="tasks">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#tasks .checkboxes"/>
								</th>
								<th >
									 任务名称
								</th>
								<th width="10%">
									 开始时间
								</th>
								<th width="10%">
									 结束时间
								</th>
								<th width="5%">
									类型
								</th>
								<th width="15%">
									 影响域
								</th>
									<th width="10%">
									 指令
								</th>
									<th width="5%">
									 重复
								</th>
									<th width="5%">
									 完成
								</th>
									<th width="10%">
									 状态
								</th>
									<th width="15%">
									 操作&队列
								</th>
							</tr>
							</thead>
							<tbody>
								
								
								
						  </tbody>	
							</table>
					
					
					
					
			
 				
 				
 			</div>
 			
 					<div class="tab-pane "  id="tab_2">
 				
 				
 		
					
					
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
										<a href="/admin/task/edit/0" role="button" class="btn green" data-target="#ajax" data-toggle="modal">
														<i class="fa fa-pencil"></i> 添加一个计划任务
										</a>
									
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="javascript:;">
													Print </a>
												</li>
												<li>
													<a href="javascript:;">
													Save as PDF </a>
												</li>
												<li>
													<a href="javascript:;">
													Export to Excel </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
								<table class="table table-striped table-bordered table-hover" id="taskcron">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#taskcron .checkboxes"/>
								</th>
									<th width="5%">
										 队列ID
									</th>
									<th width="10%">
										 GUID
									</th>
									<th width="5%">
										 任务
									</th>
									<th width="5%">
										 指令
									</th>
									<th width="20">
										 参数
									</th>
									<th width="5%">
										 回调
									</th>
								
									<th width="15%">
										 创建时间
									</th>
									<th width="15%">
										 完成时间
									</th>
										<th width="5%">
										 状态
									</th>
									<th >
										 操作 & 结果
									</th>
							</tr>
							</thead>
							<tbody>
								
								
								
						  </tbody>	
							</table>
					
					
					
					
			
 				
 				
 			</div>
 			
 				<div class="tab-pane "  id="tab_3">
 				
 							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a href="javascript:;" role="button" class="btn blue" >
														<i class="fa fa-pencil"></i> 发送一个本机指令
										</a>
									
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="#">
													Print </a>
												</li>
												<li>
													<a href="#">
													Save as PDF </a>
												</li>
												<li>
													<a href="#">
													Export to Excel </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<table class="table table-striped table-bordered table-hover" id="taskchat">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#taskchat .checkboxes"/>
								</th>
							<th width="5%">
										 队列ID
									</th>
									<th width="10%">
										 GUID
									</th>
									<th width="5%">
										 任务
									</th>
									<th width="5%">
										 指令
									</th>
									<th width="20">
										 参数
									</th>
									<th width="5%">
										 回调
									</th>
								
									<th width="15%">
										 创建时间
									</th>
									<th width="15%">
										 完成时间
									</th>
										<th width="5%">
										 状态
									</th>
									<th >
										 操作 & 结果
									</th>
							</tr>
							</thead>
							<tbody>
								
								
								
						  </tbody>	
							</table>
 				
 				
 			</div>
 			
 			
 			
 			
 			
 			
 			  </div>
 			  
 			  
 			</div>

	
	
	
	
	</div>
	</div>
	
	
</div>

<div class="modal-footer">
	<button type="button" class="btn blue" data-dismiss="modal">返回</button>
	<!--<button type="button" class="btn blue"  onclick="" >保存设置</button>-->
</div>
<script>
	
var guid="<?php echo $netbot['nb_guid'];?>";
var tabletasks = $('#tasks');
   function get_tasksing() {  
             tabletasks.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/task/getlist/'+guid,
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', tabletasks)); 
        },
        "pageLength": 10,            
       // "pagingType": "bootstrap_full_number",
"oLanguage" : { //主要用于设置各种提示文本
"sProcessing" : "正在处理...", //设置进度条显示文本
//"sLengthMenu" : "每页_MENU_行",//显示每页多少条记录
"sEmptyTable" : "没有找到记录",//没有记录时显示的文本
"sZeroRecords" : "没有找到记录",//没有记录时显示的文本
"sInfo" : "总记录数_TOTAL_当前显示_START_至_END_",
"sInfoEmpty" : "",//没记录时,关于记录数的显示文本
"sSearch" : "搜索:",//搜索框前的文本设置
"oPaginate" : {
"sFirst" : "首页",
"sLast" : "未页",
"sNext" : "下页",
"sPrevious" : "上页"
}
},
 "aaSorting": [[0, 'desc']],
"aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [10] },
                    { "bSearchable": false, "aTargets": [10]}]
    });
    
      var tableWrappertasks = jQuery('#tasks_wrapper');

        tabletasks.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).attr("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        tabletasks.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrappertasks.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
    
		}
		
		var tabletaskcron = $('#taskcron');
   function get_taskcroning() {  
             tabletaskcron.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/tasklist/getlistbyguid/cron/'+guid,
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', tabletaskcron)); 
        },
        "pageLength": 10,            
       // "pagingType": "bootstrap_full_number",
"oLanguage" : { //主要用于设置各种提示文本
"sProcessing" : "正在处理...", //设置进度条显示文本
//"sLengthMenu" : "每页_MENU_行",//显示每页多少条记录
"sEmptyTable" : "没有找到记录",//没有记录时显示的文本
"sZeroRecords" : "没有找到记录",//没有记录时显示的文本
"sInfo" : "总记录数_TOTAL_当前显示_START_至_END_",
"sInfoEmpty" : "",//没记录时,关于记录数的显示文本
"sSearch" : "搜索:",//搜索框前的文本设置
"oPaginate" : {
"sFirst" : "首页",
"sLast" : "未页",
"sNext" : "下页",
"sPrevious" : "上页"
}
},
 "aaSorting": [[1, 'desc']],
"aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [10] },
                    { "bSearchable": false, "aTargets": [10]}]
    });
    
      var tableWrappertaskcron = jQuery('#taskcron_wrapper');

        tabletaskcron.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).attr("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        tabletaskcron.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrappertaskcron.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
    
		}
		
			var tabletaskchat = $('#taskchat');
   function get_taskchating() {  
             tabletaskchat.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/tasklist/getlistbyguid/chat/'+guid,
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', tabletaskchat)); 
        },
        "pageLength": 10,            
        //"pagingType": "bootstrap_full_number",
"oLanguage" : { //主要用于设置各种提示文本
"sProcessing" : "正在处理...", //设置进度条显示文本
//"sLengthMenu" : "每页_MENU_行",//显示每页多少条记录
"sEmptyTable" : "没有找到记录",//没有记录时显示的文本
"sZeroRecords" : "没有找到记录",//没有记录时显示的文本
"sInfo" : "总记录数_TOTAL_当前显示_START_至_END_",
"sInfoEmpty" : "",//没记录时,关于记录数的显示文本
"sSearch" : "搜索:",//搜索框前的文本设置
"oPaginate" : {
"sFirst" : "首页",
"sLast" : "未页",
"sNext" : "下页",
"sPrevious" : "上页"
}
},
 "aaSorting": [[1, 'desc']],
"aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [10] },
                    { "bSearchable": false, "aTargets": [10]}]
    });
    
      var tableWrappertaskchat = jQuery('#taskchat_wrapper');

        tabletaskchat.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).attr("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        tabletaskchat.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrappertaskchat.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
    
		}
		
 			function taskstatus(id,status){
			

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要改变【"+id+"】状态吗?", function(result) {
		                if(result){
                  taskstatus_go(id,status);
                   
                 }
                }); 
	
	}
	
	
		 	function taskstatus_go(id,status) {            
      Metronic.blockUI();                           
		  jQuery.ajax({  
      url: '/admin/task/taskstatus', 
      async: true,  
      dataType: 'json',  
      data: {"id":id,"status":status}, 
      type: 'POST',    
   
       success: function (data) { 
   
   	    Metronic.unblockUI();
   	    if(data.result==0){
   	      alert(data.msg);
        }else{
          get_tasksing();   
       	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	Metronic.unblockUI();
 alert(errorThrown); 
 },  
     
  }); 
  

  
   } 
   
   	function setname(guid,name){
    bootbox.prompt("填写你要标注的值?", function(result) {
                    if (result === null) {
                       
                    } else {                 	
                       setname_go(guid,result);
                            
                    }
                });
   
 }
 
 	 	function setname_go(guid,name) {            
      Metronic.blockUI();                           
		  jQuery.ajax({  
      url: '/admin/netbot/setname', 
      async: true,  
      dataType: 'json',  
      data: {"guid":guid,"name":name}, 
      type: 'POST',    
   
       success: function (data) { 
   
   	    Metronic.unblockUI();
   	    if(data.result==0){
   	      alert(data.msg);
        }else{
          $("#nb_name").text(name);   
       	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	Metronic.unblockUI();
 alert(errorThrown); 
 },  
     
  }); 
  

  
   } 
 
     					function cancel(id,type){
			

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要撤回【"+id+"】状态吗?", function(result) {
		                if(result){
                  cancel_go(id,type);
                   
                 }
                }); 
	
	}
	
	
		 	function cancel_go(id,type) {            
      Metronic.blockUI();                           
		  jQuery.ajax({  
      url: '/admin/tasklist/cancel', 
      async: true,  
      dataType: 'json',  
      data: {"id":id,"type":type}, 
      type: 'POST',    
   
       success: function (data) { 
   
   	    Metronic.unblockUI();
   	    if(data.result==0){
   	      alert(data.msg);
        }else{
        	if(type=="cron"){
        get_taskcroning();
      }else{
      	get_taskchating();
      }
       	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	Metronic.unblockUI();
 alert(errorThrown); 
 },  
     
  }); 
  

  
   } 
 
   
</script>
