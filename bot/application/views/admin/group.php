	
<?php  $this->load->view('admin/head');?>				
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
				
					 
				</div>
			</div>
			
				<div class="row">
				<div class="col-md-6">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>受控机分组管理
							</div>
							<div class="tools">
														
								<a href="javascript:get_listing();" ><i class="fa fa-refresh"></i>
								</a>
							<a href="javascript:;" class="collapse">
								</a>	
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
												<a href="#myModal_autocomplete" role="button" class="btn red" data-toggle="modal">
														<i class="fa fa-pencil"></i> 添加一个分组
										</a>
									
										</div>
									</div>
									<div class="col-md-6">
									
									</div>
								</div>
							</div>
							<table class="table table-striped table-bordered table-hover" id="userlist">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#userlist .checkboxes"/>
								</th>
									<th>
									 ID
								</th>
								<th>
									 名称
								</th>
								<th>
									 类别
								</th>
								
									<th >
									 操作
								</th>
							</tr>
							</thead>
							<tbody>
								
								
								
						  </tbody>	
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
				
					<div class="col-md-6">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>【<span id="egname">扩展组</span>】主机列表
							</div>
							<div class="tools">
														
								<a href="javascript:get_expandlisting();" ><i class="fa fa-refresh"></i>
								</a>
							<a href="javascript:;" class="collapse">
								</a>	
							</div>
						</div>
						<div class="portlet-body">
				
							<table class="table table-striped table-bordered table-hover" id="expandlist">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#expandlist .checkboxes"/>
								</th>
								<th width="20%">
									 GUID
								</th>
								<th width="20%">
									 主机名
								</th>
									<th >
									 操作
								</th>
							</tr>
							</thead>
							<tbody>
								
								
								
						  </tbody>	
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
				
				
			</div>
			
			

			
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	

<?php  $this->load->view('admin/quick-sidebar');?>	

	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->


<div id="myModal_autocomplete" class="modal fade" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">添加分组</h4>
										</div>
										<div class="modal-body form">
											<form action="#" class="form-horizontal form-row-seperated">
												<div class="form-group">
													<label class="col-sm-4 control-label">名称</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="text" id="ng_name" name="ng_name" class="form-control"/>
														</div>
														<p class="help-block">
															
													
															
														</p>
													</div>
												</div>
												
										
												
									
												
												<div class="form-group">
													<label class="col-sm-4 control-label">类别</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-search"></i>
															</span>
														
															<select class="form-control last" id="ng_type" name="ng_type">
												<option value="main">主分组</option>
												<option value="expand">扩展分组</option>
									
											</select>
														
														</div>
														<p class="help-block">
														
														</p>
													</div>
												</div>
											
												
									
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
											<button type="button" class="btn btn-primary" onclick="group_add();"><i class="fa fa-check"></i>确认添加</button>
										</div>
									</div>
</div>
</div>





<?php  $this->load->view('admin/foot');?>	

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<!-- END PAGE LEVEL PLUGINS -->



<script>
      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
get_listing();

      });
   </script>

<script>
var table = $('#userlist');
var table2 = $('#expandlist');
var expandid=0;
   function get_listing() {  
             table.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/group/getlist',
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', table)); 
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
                    { 'bSortable': false, 'aTargets': [0,4] },
                    { "bSearchable": false, "aTargets": [0,4]}]
    });
    
      var tableWrapper = jQuery('#userlist_wrapper');

        table.find('.group-checkable').change(function () {
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

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
    
		}
		
		  function get_expandlisting() {  
             table2.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/group/getexpandlist/'+expandid,
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', table2)); 
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
 "aaSorting": [[2, 'desc']],
"aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [0,3] },
                    { "bSearchable": false, "aTargets": [0,3]}]
    });
    
      var tableWrapper2 = jQuery('#expandlist_wrapper');

        table2.find('.group-checkable').change(function () {
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

        table2.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });

        tableWrapper2.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
    
		}

	 function group_add() {
	 	
	 	       	 	
	 	var ng_name=jQuery("#ng_name").val();
    var ng_type=jQuery("#ng_type  option:selected").val();
   
	 	if(ng_name==""){
	 	 		   
	   alert("填写不能为空！");
	 		 }else{
	 	
	 	
		jQuery.ajax({  
    url: '/admin/group/add', 
    async: true,  
    dataType: 'json', 
    data: {"ng_name":ng_name,"ng_type":ng_type}, 
    type: 'POST',  
   
   success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   		jQuery('#myModal_autocomplete').modal('hide');
   	get_listing();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
  
}
   } 
	
		function group_del(id,name){

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要删除分组【"+name+"】吗?", function(result) {
		                if(result){
                  group_del_go(id);
                   
                 }
                }); 
	
	}
	
		function group_del_go(id) {
    
		jQuery.ajax({  
    url: '/admin/group/del/'+id, 
    async: true,  
    dataType: 'json',  
    type: 'PUT',  
   
   success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	 get_listing();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
   } 
	
		function group_set(id,name){
			$('#egname').text(name);
			expandid=id;
			get_expandlisting(id);
			
		}
	
			function groupexpand_del(id,name){

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要删除【"+name+"】吗?", function(result) {
		                if(result){
                  groupexpand_del_go(id);
                   
                 }
                }); 
	
	}
	
		function groupexpand_del_go(id) {
    
		jQuery.ajax({  
    url: '/admin/group/expanddel/'+id, 
    async: true,  
    dataType: 'json',  
    type: 'PUT',  
   
   success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	 get_expandlisting();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
   } 
	
	   	function setname(id,name){
    bootbox.prompt("填写你要修改的值?", function(result) {
                    if (result === null) {
                       
                    } else {                 	
                       setname_go(id,result);
                            
                    }
                });
   
 }
 
 	 	function setname_go(id,name) {            
      Metronic.blockUI();                           
		  jQuery.ajax({  
      url: '/admin/group/setname', 
      async: true,  
      dataType: 'json',  
      data: {"id":id,"name":name}, 
      type: 'POST',    
   
       success: function (data) { 
   
   	    Metronic.unblockUI();
   	    if(data.result==0){
   	      alert(data.msg);
        }else{
         get_listing();   
       	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	Metronic.unblockUI();
 alert(errorThrown); 
 },  
     
  }); 
  

  
   } 
	
</script>