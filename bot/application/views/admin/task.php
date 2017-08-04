	
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
								<i class="fa fa-globe"></i>计划任务设置
							</div>
							<div class="tools">
													
								<a href="javascript:get_tasksing();" ><i class="fa fa-refresh"></i>
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
												<a href="/admin/task/edit/0" role="button" class="btn red" data-target="#ajax" data-toggle="modal">
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
							<table class="table table-striped table-bordered table-hover" id="tasks">
							<thead>
							<tr>
								<th class="table-checkbox">
						ID
								</th>
								<th  >
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
								<th width="20%">
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
									<th width="5%">
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

	<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
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

<script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->
<style type="text/css">
.dataTable .table-checkbox {
  width: 20px !important;
}
	</style>
<script>
      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
get_tasksing();

      });
   </script>

<script>
var table = $('#tasks');
   function get_tasksing() {  
             table.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/task/getlist',
               "fnInitComplete": function (){
		 
        },
        "pageLength": 10,            
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
 "aaSorting": [[0, 'desc']],
"aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [10] },
                    { "bSearchable": false, "aTargets": [10]}]
    });
    
   
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
    
    	function del(id,name){

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要删除任务【"+name+"】吗?", function(result) {
		                if(result){
                  del_go(id);
                   
                 }
                }); 
	
	}
	
		function del_go(id) {
    
		jQuery.ajax({  
    url: '/admin/task/del/'+id, 
    async: true,  
    dataType: 'json',  
    type: 'PUT',  
   
   success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	 get_tasksing();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
   } 
   
    
</script>