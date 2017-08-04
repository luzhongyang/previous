	
<?php  $this->load->view('admin/head');?>				
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
				
					 
				</div>
			</div>
			
				<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>管理员设置
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>							
								<a href="javascript:get_listing();" ><i class="fa fa-refresh"></i>
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
												<a href="#myModal_autocomplete" role="button" class="btn red" data-toggle="modal">
														<i class="fa fa-pencil"></i> 添加一个管理账号
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
							<table class="table table-striped table-bordered table-hover" id="userlist">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#userlist .checkboxes"/>
								</th>
								<th width="5%">
									 ID
								</th>
								<th width="10%">
									 用户名
								</th>
								<th width="10%">
									 Email
								</th>
								<th width="10%">
									 类型
								</th>
								<th width="20%">
									 最后登陆时间
								</th>
								<th>
									 组权限
								</th>
									<th width="20%">
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
											<h4 class="modal-title">添加管理账户</h4>
										</div>
										<div class="modal-body form">
											<form action="#" class="form-horizontal form-row-seperated">
												<div class="form-group">
													<label class="col-sm-4 control-label">用户名</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="text" id="username" name="username" class="form-control"/>
														</div>
														<p class="help-block">
															
													
															
														</p>
													</div>
												</div>
												
													<div class="form-group">
													<label class="col-sm-4 control-label">密码</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="text" id="password" name="password" class="form-control"/>
														</div>
														<p class="help-block">
															
														
															
														</p>
													</div>
												</div>
												
												
													<div class="form-group">
													<label class="col-sm-4 control-label">EMAIL</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="email" id="email" name="email" class="form-control"/>
														</div>
														<p class="help-block">
															
													
															
														</p>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-4 control-label">权限</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-search"></i>
															</span>
														
															<select class="form-control last" id="role" name="role">
												<option value="administrator">超级管理员</option>
												<option value="user">操作员</option>
									
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
											<button type="button" class="btn btn-primary" onclick="user_add();"><i class="fa fa-check"></i>确认添加</button>
										</div>
									</div>
</div>
</div>
<div id="editinfo" class="modal fade" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">修改账户资料</h4>
										</div>
										<div class="modal-body form">
											<form action="#" class="form-horizontal form-row-seperated">
												<div class="form-group">
													<label class="col-sm-4 control-label">用户名</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="text" id="et_username" name="et_username" class="form-control" readonly/>
														</div>
														<p class="help-block">
															
			
														</p>
													</div>
												</div>
												
													<div class="form-group">
													<label class="col-sm-4 control-label">密码</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="text" id="et_password" name="et_password" class="form-control"/>
														</div>
														<p class="help-block">
															
															<span class="label label-success label-sm">
																 说明:
															</span>
														
																不修改请留空
															
														</p>
													</div>
												</div>
												
												
													<div class="form-group">
													<label class="col-sm-4 control-label">EMAIL</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user"></i>
															</span>
															<input type="text" id="et_email" name="et_email" class="form-control"/>
														</div>
														<p class="help-block">
															
														
														
																
															
														</p>
													</div>
												</div>
												
										
												
														<div class="form-group">
													<label class="col-sm-4 control-label">权限</label>
													<div class="col-sm-8">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-search"></i>
															</span>
														
															<select class="form-control last" id="et_role" name="et_role">
												<option value="administrator">超级管理员</option>
												<option value="user">操作员</option>
									
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
											<button type="button" class="btn btn-primary" onclick="et_save();"><i class="fa fa-check"></i>确认修改</button>
										</div>
									</div>
	</div>
	</div>


	<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
							<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-body">
											<img src="<?php echo $this->config->item('static'); ?>/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
											<span>
											&nbsp;&nbsp;Loading... </span>
										</div>
									</div>
								</div>
							</div>
							<!-- /.modal -->

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
   function get_listing() {  
             table.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/user/getlist',
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', table)); 
        },
        "pageLength": 5,            
        "pagingType": "bootstrap_full_number",
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
                    { 'bSortable': false, 'aTargets': [0,7] },
                    { "bSearchable": false, "aTargets": [0,7]}]
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

	 function user_add() {
	 	
	 	       	 	
	 	var username=jQuery("#username").val();
	 	var password=jQuery("#password").val();
	 	var email=jQuery("#email").val();
    var role=jQuery("#role  option:selected").val();
   
	 	if(username=="" || password=="" || email==""){
	 	 		   
	   alert("填写不能为空！");
	 		 }else{
	 	
	 	
		jQuery.ajax({  
    url: '/admin/user/save', 
    async: true,  
    dataType: 'json', 
    data: {"username":username,"password":password,"email":email,"role":role}, 
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

  	 	function useredit(username,role,email){
		//jQuery('body').modalmanager('loading');

	    jQuery("#et_username").val(username);
			jQuery("#et_email").val(email);
			jQuery("#et_role").val(role);
		
		jQuery('#editinfo').modal('show');
	
	}
	
   	function et_save() {
		
    var username=jQuery("#et_username").val();
    var password=jQuery("#et_password").val();
    var email=jQuery("#et_email").val();
    var role=jQuery("#et_role").val();

   
		jQuery.ajax({  
    url: '/admin/user/editsave', 
    async: true,  
    dataType: 'json',  
     data: {"username":username,"password":password,"email":email,"role":role}, 
    type: 'POST',    
   
   success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	 jQuery('#editinfo').modal("hide");
   	 get_listing();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
  

  
   } 
    function role_save() {
	  //$("#form1").submit();
	  
	  
	  	jQuery.ajax({  
    url: '/admin/user/rolesave', 
    async: true,  
    dataType: 'json',  
     data:  $('#form1').serialize(), 
    type: 'POST',    
   
    success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	 jQuery('#ajax').modal("hide");
   	 get_listing();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
	  
	  
    }
    
        	function del(id,name){

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要删除用户【"+name+"】吗?", function(result) {
		                if(result){
                  del_go(id);
                   
                 }
                }); 
	
	}
	
		function del_go(id) {
    
		jQuery.ajax({  
    url: '/admin/user/del/'+id, 
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
    
</script>