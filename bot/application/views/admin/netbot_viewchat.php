<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Metronic | Page Layouts - Blank Page</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!--<link href="http://fonts.useso.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>-->
<link href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo $this->config->item('static'); ?>/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="<?php echo $this->config->item('static'); ?>/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('static'); ?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>


<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/admin/pages/css/netbot.css"/>


<!-- END PAGE LEVEL STYLES -->

<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-header-fixed page-footer-fixed page-quick-sidebar-over-content">

		
		<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject"> 主机信息</span>
								<span class="caption-helper"><?php echo $netbot['nb_guid'];?></span>
							</div>
							<div class="actions">
							
							
						
								<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;">
								</a>
							</div>
						</div>
						<div class="portlet-body">
				
									 
<div class="row">												
	<div class="tc-list-wrap">            <ul class="tc-list clearfix">                <li>                    <em class="tc-dlist-tit">名称</em>                    <span class="tc-dlist-det"><?php echo $netbot['nb_name'];?></span>                </li>                <li>                    <em class="tc-dlist-tit">当前状态</em>                    <span class="tc-dlist-det" id="stauts"><?php echo $netbot['stauts'];?>
		
		
		</span>                </li>                <li>                    <em class="tc-dlist-tit">更新时间</em>                    <span class="tc-dlist-det"><?php echo $netbot['nb_lasttime'];?></span>               </li>                <li>                    <em class="tc-dlist-tit" >操作：</em>                    <span class="tc-dlist-det" title="" id="action"><?php echo $netbot['action'];?></span>                </li>            </ul>        </div>
	
	</div>
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
          	<div class="col-md-3 name">
          		<span id="nb_name"><?php echo $netbot['nb_name'];?></span> <a href="javascript:setname('<?php echo $netbot['nb_guid'];?>','<?php echo $netbot['nb_name'];?>')" class="btn btn-xs red"><i class="fa fa-flag"></i> 标注</a>
          	</div>
          	<div class="col-md-2 value">计算机名</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_cname'];?></div>
          </div> 		
          <div class="row static-info">
          	<div class="col-md-2 value">版本号</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_vid'];?></div>
          	<div class="col-md-2 value">操作系统</div>
          	<div class="col-md-3 name"><?php echo @$netbot_os[$netbot['nb_os']]?$netbot_os[$netbot['nb_os']]:$netbot['nb_os'];?></div>
          </div>	
          <div class="row static-info">
          	<div class="col-md-2 value">公网IP</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_lastip'];?></div>
          	<div class="col-md-2 value">CPU</div>
          	<div class="col-md-3 name"><?php if($netbot['nb_amd64']) echo "【64位】";?><?php echo $netbot['nb_cpu'];?></div>
          </div>		
          <div class="row static-info">
          	<div class="col-md-2 value">所属网络</div>
          	<div class="col-md-3 name"><?php echo get_nb_internet($netbot['nb_internet']) ;?></div>
          	<div class="col-md-2 value">内存</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_mem'];?></div>
          </div>		
          <div class="row static-info">
          	<div class="col-md-2 value">地区</div>
          	<div class="col-md-3 name"><?php echo $netbot_area[$netbot['nb_area']];?></div>
          	<div class="col-md-2 value">MAC</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_mac'];?></div>
          </div>
          <div class="row static-info">
          	<div class="col-md-2 value">创建时间</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_addtime'];?></div>
          	<div class="col-md-2 value">虚拟机</div>
          	<div class="col-md-3 name">
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
          	<div class="col-md-3 name"><?php echo $netbot['nb_lasttime'];?></div>
          	<div class="col-md-2 value">主分组</div>
          	<div class="col-md-3 name"><?php echo $netbot['ng_name'];?></div>
          </div>	
          <div class="row static-info">
          	<div class="col-md-2 value">GUID</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_guid'];?></div>
          	<div class="col-md-2 value">扩展分组</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_group_expand'];?></div>
          </div>	
          <div class="row static-info">
          	<div class="col-md-2 value">请求间隔</div>
          	<div class="col-md-3 name">
          		<span id="nb_interval"><?php echo $netbot['nb_interval'];?></span> <a href="javascript:setstauts('<?php echo $netbot['nb_guid'];?>',11,'<?php echo $netbot['nb_interval'];?>')" class="btn btn-xs blue"><i class="fa fa-clock-o"></i>修改默认值</a>
          	</div>
          	<div class="col-md-2 value">主上线地址</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_url'];?>[<?php echo $netbot['nb_lasturl'];?>]</div>
          </div>	
          <div class="row static-info">
          	<div class="col-md-2 value">备注</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_inf'];?></div>
          	<div class="col-md-2 value">备用上线地址</div>
          	<div class="col-md-3 name"><?php echo $netbot['nb_url_bak'];?></div>
          </div>

</div>
 			
 				<div class="tab-pane "  id="tab_1">
 				
 				
 		
					
					
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a href="/admin/task/edit/0/<?php echo $netbot['nb_guid'];?>" role="button" class="btn red" data-target="#ajax" data-toggle="modal">
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
									<th width="10%">
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
					</div>
					<!-- END Portlet PORTLET-->			
		
		
	<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
				<div class="modal fade bs-modal-lg" id="ajaxview" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
								<div class="modal-dialog modal-lg2">
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
							
							
	<div class="modal fade bs-modal-lg" id="ajax" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-body">
											<img src="<?php echo $this->config->item('static'); ?>/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
											<span>
											&nbsp;&nbsp;Loading... </span>
										</div>
									</div>
								</div>
							</div>
	<div class="modal fade bs-modal-sm" id="setstauts" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title" id="setstauts_title">修改状态</h4>
										</div>
										<div class="modal-body">
											
											 	<div class="form-group" id="setstauts_setval">
													<label class="col-sm-4 control-label">设置值</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="hidden" id="setstauts_guid" name="setstauts_guid" class="form-control" />
															<input type="hidden" id="setstauts_stauts" name="setstauts_stauts" class="form-control" />
															<input type="text" id="setstauts_val" name="setstauts_val" class="form-control" onkeyup="value=value.replace(/[^\d]/g,'')" />
														</div>
												<p class="help-block" id="setstauts_unit">
															
			
														</p>
													</div>
												</div>
											<div class="clearfix">
</div>
	
												
										</div>
										<div class="modal-footer">
											<button type="button" class="btn default" data-dismiss="modal">取消</button>
											<button type="button" class="btn blue" id="btn-stauts" >确认改变</button>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>

<div class="modal fade bs-modal-lg" id="info" role="dialog"  data-keyboard="false" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-body">
											<img src="<?php echo $this->config->item('static'); ?>/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
											<span>
											&nbsp;&nbsp;Loading... </span>
										</div>
									</div>
								</div>
							</div>

	

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo $this->config->item('static'); ?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>

<!-- END JAVASCRIPTS -->

<script src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>


</body>
<!-- END BODY -->
</html>



<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>




<script src="<?php echo $this->config->item('static'); ?>/assets/global/scripts/datatable.js"></script>
<script src="<?php echo $this->config->item('static'); ?>/assets/admin/pages/scripts/alwin-table-ajax.js"></script>

<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->



<script>
      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
      });
   </script>
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
   
   	 	function setstauts(guid,stauts,info){
		  //jQuery('body').modalmanager('loading');
 jQuery("#setstauts_guid").val(guid);
 jQuery("#setstauts_stauts").val(stauts);
      switch(stauts)
{
case 2:
  jQuery("#setstauts_setval").show();
  jQuery("#setstauts_val").val(1000);
  jQuery("#setstauts_unit").text("单位：毫秒");
  jQuery("#setstauts_title").html("确认 【"+info+"】 该机器吗？");
  jQuery("#btn-stauts").attr('onclick','addchat()');
  break;
case 3:
 jQuery("#setstauts_setval").show();
 jQuery("#setstauts_val").val(100);
 jQuery("#setstauts_unit").text("单位：小时");
 jQuery("#setstauts_title").html("确认 【"+info+"】 该机器吗？");
 jQuery("#btn-stauts").attr('onclick','stauts_save()');
  break;
  case 11:
 jQuery("#setstauts_setval").show();
 jQuery("#setstauts_val").val(info);
 jQuery("#setstauts_unit").text("单位：秒");
 jQuery("#setstauts_title").html("确认修改机器【默认值】吗？");
 jQuery("#btn-stauts").attr('onclick','stauts_save()');
  break;
default:

  jQuery("#setstauts_setval").hide(); 
  jQuery("#setstauts_title").html("确认 【"+info+"】 该机器吗？");
  jQuery("#btn-stauts").attr('onclick','stauts_save()');  
}


	    
			
	
		jQuery('#setstauts').modal('show');
	
	}
 	function stauts_save() {
		
    var guid=jQuery("#setstauts_guid").val();
    var val=jQuery("#setstauts_val").val();
    var stauts=jQuery("#setstauts_stauts").val();
    jQuery('#setstauts').modal("hide"); 
 
     
            
           Metronic.blockUI({
                target: '#waitui',
                //overlayColor: '#889900',
                cenrerY: true,
                animate: true
            });  
            
            
		jQuery.ajax({  
    url: '/admin/netbot/setstauts', 
    async: true,  
    dataType: 'json',  
    data: {"guid":guid,"stauts":stauts,"val":val}, 
    type: 'POST',    
   
   success: function (data) { 
   
   	 Metronic.unblockUI('#waitui');
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	
   	 
   
       switch(stauts)
{

case "3":
jQuery("#stauts").html("<i class=\"fa  fa-eye-slash\"></i>已静默 ("+val+")");
jQuery("#action").html("");
  break;
  case "11":
  jQuery("#nb_interval").html(val);
  break;
default:
jQuery("#stauts").html("<i class=\"fa fa-play\"></i>正常");
jQuery("#action").html("<a href=\"javascript:setstauts('"+guid+"',3,'静默')\" class=\"btn btn-xs blue\"><i class=\"fa fa-eye-slash\"></i>静默</a>");
}
   
  
   
   
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	 Metronic.unblockUI('#waitui');
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