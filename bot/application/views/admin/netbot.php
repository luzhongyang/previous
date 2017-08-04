
<?php  $this->load->view('admin/head');?>				
<!-- BEGIN PAGE CONTENT-->


<div class="row">
<div class="col-md-12">
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="portlet box grey-cascade" id="portletchatlist">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-globe"></i>已激活主机列表
			</div>
			<div class="tools">

				<a href="javascript:get_chatlisting();" ><i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
				</a>		
			</div>
		</div>
		<div class="portlet-body">
			
			<div class="table-scrollable">
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="10%">
								GUID
							</th>
							<th width="10%">
								名称 
							</th>
							<th width="10%">
								计算机名 
							</th>
							<th width="10%">
								操作人
							</th>
							<th width="20%">
								激活时间
							</th>
							<th width="15%">
								激活状态
							</th>
							<th >
								操作
							</th>
						</tr>
					</thead>
					<tbody id="chatlist">

					</tbody>
				</table>
			</div>
			

		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>



<div class="row">
<div class="col-md-12">

				<!--<div class="note note-danger">
					<p>
						 NOTE: The below datatable is not connected to a real database so the filter and sorting is just simulated for demo purposes only.
					</p>
				</div> -->
				<!-- Begin: life time stats -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-shopping-cart"></i>主机列表

						</div>
						<div class="tools">

						</div>

					</div>
					<div class="portlet-body">
						<div class="table-container">
							<div class="table-actions-wrapper">
								<span>
								</span>
								<select class="table-group-action-input form-control input-inline input-small input-sm" onchange="get_groupset();" id="group_action">
									<option value="">选择操作...</option>
									<option value="main">移动到主分组</option>
									<option value="expand">加入扩展分组</option>		
								</select>
								
								<select class="form-control input-inline input-small input-sm" id="group_set">
									<option value="">选择值...</option>

								</select>
								
								
								<button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
							</div>
							<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
								<thead>
									<tr role="row" class="heading">
										<th width="2%">
											<input type="checkbox" class="group-checkable">
										</th>
										<th width="15%">
											GUID
										</th>
										<th width="15%">
											注册时间
										</th>
										<th width="15%">
											更新时间
										</th>
										<th width="5%">
											标注名
										</th>
										<th width="5%">
											计算机名
										</th>
										<th width="5%">
											版本
										</th>
										<th width="8%">
											【主分组】
										</th>
										<th width="8%">
											所在地区
										</th>
										<th width="8%">
											主机状态
										</th>
										<th >
											操作
										</th>
									</tr>
									<tr role="row" class="filter">
										<td>
										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="nb_guid">
										</td>
										<td>
											<div class="input-group  date-picker input-daterange" data-date="" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" name="nb_add_from" value="" placeholder="from">

												<input type="text" class="form-control" name="nb_add_to" value="" placeholder="to">
											</div>
										</td>


										<td>

											<div class="input-group  date-picker input-daterange" data-date="" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" name="nb_date_from" value="" placeholder="from">

												<input type="text" class="form-control" name="nb_date_to" value="" placeholder="to">
											</div>




										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="nb_name">
										</td>
										<td>
											<input type="text" class="form-control form-filter input-sm" name="nb_cname">
										</td>
										<td>

											<input type="text" class="form-control form-filter input-sm" name="nb_vid" placeholder=""/>

										</td>
										<td>



											<select name="nb_group" class="form-control form-filter input-sm">
												<option value="">Select...</option>
												<?php
												foreach ($group_main as $value) {										
													?>
													<option value="<?php echo $value['ng_id']; ?>"><?php echo $value['ng_name']; ?></option>

													<?php
												}
												?>

											</select>

										</td>
										<td>
											<select name="nb_area" id="nb_area"  class="form-control form-filter input-sm" >
												<option value="">Select...</option>

												<?php 
												foreach($netbot_area as $key=>$val) {?>
												
												<option value="<?php echo $key;?>" ><?php echo $val;?></option>

												<?php }?>

											</select>
										</td>
										<td>
											<select name="nb_stauts" class="form-control form-filter input-sm">
												<option value="">Select...</option>
												<option value="1">正常</option>
												<option value="2">激活</option>
												<option value="3">静默</option>
												<option value="0">断开</option>
											</select>
										</td>
										<td>
											<div class="margin-bottom-5">
												<button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> 搜索</button>
											</div>
											<button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> 重置</button>
										</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- End: life time stats -->
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




		<!-- BEGIN PAGE LEVEL STYLES -->
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/select2/select2.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

		<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('static'); ?>/assets/admin/pages/css/netbot.css"/>







		<!-- END PAGE LEVEL STYLES -->
		<?php  $this->load->view('admin/foot');?>	

		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/select2/select2.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>




		<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>



		<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>


		<script src="<?php echo $this->config->item('static'); ?>/assets/global/scripts/datatable.js"></script>
		<script src="<?php echo $this->config->item('static'); ?>/assets/admin/pages/scripts/alwin-table-ajax.js"></script>


		<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


		<!-- END PAGE LEVEL PLUGINS -->


		<script>
			jQuery(document).ready(function() {    
     Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
TableAjax.init();
get_chatlisting();




});

 //$("#nb_area").select2();  

</script>

<script>
var interval = null;//每隔一秒执行一次redoMethod()

function get_chatlisting_start() { 
if(interval){
	clearInterval(interval);
	interval = null;
}
interval =   setInterval(function(){   
	get_chatlisting();
},5000);

}

function get_chatlisting_stop() { 
if(interval){
	clearInterval(interval);
	interval = null;
}	
}


function get_chatlisting() { 

Metronic.blockUI({
	target: '#portletchatlist',              
	cenrerY: true,
	animate: true
});        
jQuery.ajax({  
	url: '/admin/netbot/getchatlist', 
	async: true,  
	dataType: 'json',  
	data: {}, 
	type: 'POST',    

	success: function (data) { 	
		if(data.result==1){
			jQuery("#chatlist").html(data.msg);
		}else{
			jQuery("#chatlist").html("<tr><td colspan=7 align=center>"+data.msg+"</td></tr>");
		}
		Metronic.unblockUI('#portletchatlist');
	}, 
	error: function (XMLHttpRequest, textStatus, errorThrown) { 
		Metronic.unblockUI('#portletchatlist');
		alert(errorThrown); 
	},  

}); 


}

function addchat() {
var guid=jQuery("#setstauts_guid").val(); 
var val=jQuery("#setstauts_val").val(); 
if(val<500) 
{
	alert("间隔值不能小于500毫秒!");
	return false;
}

jQuery('#setstauts').modal("hide");               
Metronic.blockUI();

jQuery.ajax({  
	url: '/admin/netbot/addchat', 
	async: true,  
	dataType: 'json',  
	data: {"guid":guid,"val":val}, 
	type: 'POST',    

	success: function (data) { 

		Metronic.unblockUI();
		if(data.result==0){
			alert(data.msg);
		}else{
			get_chatlisting();
			get_chatlisting_start();

		}

	}, 
	error: function (XMLHttpRequest, textStatus, errorThrown) { 
		Metronic.unblockUI();
		alert(errorThrown); 
	},  

}); 



} 

function stopchat(id,guid){

bootbox.setDefaults({locale:"zh_CN"}); 
bootbox.confirm("您确认要停止激活【"+guid+"】吗?", function(result) {
	if(result){
		stopchat_go(id);

	}
}); 

}


function stopchat_go(id) {            
Metronic.blockUI();

jQuery.ajax({  
	url: '/admin/netbot/stopchat', 
	async: true,  
	dataType: 'json',  
	data: {"id":id}, 
	type: 'POST',    

	success: function (data) { 

		Metronic.unblockUI();
		if(data.result==0){
			alert(data.msg);
		}else{
			get_chatlisting();
			get_chatlisting_stop();
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
		switch(stauts)
		{

			case "3":
			if(val>500) 
			{
				alert("间隔值不能大于500小时!");
				return false;
			}
			break;
			case "11":   
			if(val<10) 
			{
				alert("间隔值不能小于10秒!");
				return false;
			}
			break;
		}  
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

function get_groupset(){
var ng_type=$('#group_action').val();

if(ng_type==""){
	return false;
}

jQuery.ajax({  
	url: '/admin/netbot/getgroupset', 
	async: true,  
	dataType: 'html', 
	data: {"ng_type":ng_type}, 
	type: 'POST',  

	success: function (data) { 
		$('#group_set').html(data);  
	}, 
	error: function (XMLHttpRequest, textStatus, errorThrown) { 
		alert(errorThrown); 
	},  

}); 




} 



</script>