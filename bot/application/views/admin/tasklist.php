	
<?php  $this->load->view('admin/head');?>				
			<!-- BEGIN PAGE CONTENT-->
			
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
								<i class="fa fa-shopping-cart"></i>任务队列记录
							
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
										<!--<option value="main">移动到主分组</option>
										<option value="expand">加入扩展分组</option>	-->	
									</select>
									
									
									
									
									<button class="btn btn-sm yellow table-group-action-submit"><i class="fa fa-check"></i> Submit</button>
								</div>
								<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
								<thead>
								<tr role="row" class="heading">
									<th width="2%">
										<input type="checkbox" class="group-checkable">
									</th>
										<th width="5%">
										 队列ID
									</th>
									<th width="5%">
										 GUID
									</th>
									<th width="10%">
										 所属任务
									</th>
									<th width="10%">
										 指令
									</th>
									<th width="20">
										 参数
									</th>
									<th width="10%">
										 回调
									</th>
								
									<th width="10%">
										 创建时间
									</th>
									<th width="10%">
										 完成时间
									</th>
										<th width="10%">
										 状态
									</th>
									<th >
										 操作 & 结果
									</th>
								</tr>
								<tr role="row" class="filter">
										<td>
											</td>
									<td>
										<input type="text" class="form-control form-filter input-sm" name="tl_id" placeholder="队列ID">
									</td>
									<td>
										<input type="text" class="form-control form-filter input-sm" name="tl_netbot" placeholder="GUID">
									</td>
												<td>
			
			  
				<input type="text" class="form-control form-filter input-sm" value="<?php echo $taskid ;?>" name="tl_taskid" id="tl_taskid"  placeholder="任务ID">
							
			
				         
			
			
									</td>
									
									
									<td>
			
				       <select name="tl_function" class="form-control form-filter input-sm">
											<option value="">Select...</option>
											<?php
											foreach ($app as $value) {										
											?>
										  <option value="<?php echo $value['app_fun']; ?>"><?php echo $value['app_name']; ?></option>
										
										    <?php
									       }
										   ?>
								
										</select>
				            
			
			
									</td>
									<td>
									
									</td>
									<td>
										<input type="text" class="form-control form-filter input-sm" name="tl_backfun">
									</td>
									<td>
									
											<div class="input-group  date-picker input-daterange" data-date="" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" name="tl_addtime_from" value="" placeholder="from">
											
												<input type="text" class="form-control" name="tl_addtime_to" value="" placeholder="to">
											</div>
									
									</td>
									<td>
										
								
											
								
									
									</td>
									<td>
										<select name="tl_stauts" class="form-control form-filter input-sm">
											<option value="">Select...</option>
											<option value="0">已创建</option>
										<option value="1">已发送</option>
										<option value="2">已完成</option>
										<option value="3">已取消</option>
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



 <script type="text/javascript" src="<?php echo $this->config->item('static'); ?>/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
 

<!-- END PAGE LEVEL PLUGINS -->


<script>
		 var tasktype="<?php echo $tasktype;?>";
      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
handleRecords();
      });
   </script>

<script>

     $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
  var grid = new Datatable();
     function handleRecords(){
       

   $.extend(true, $.fn.DataTable.TableTools.classes, {
            "container": "btn-group tabletools-dropdown-on-portlet",
            "buttons": {
                "normal": "btn btn-sm default",
                "disabled": "btn btn-sm default disabled"
            },
            "collection": {
                "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
            }
        });

           var tl_taskid=$("#tl_taskid").val();
            if(tl_taskid!=""){
            	grid.setAjaxParam("tl_taskid", tl_taskid);
            }


        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function (grid) {
            	
    
            	
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": [
                    [10, 20, 50, 100, 150,1000],
                    [10, 20, 50, 100, 150,1000] // change per page values here
                ],
                "pageLength": 20, // default record count per page
                "ajax": {
                    "url": "/admin/tasklist/getlist/"+tasktype, // ajax source
                    
                },
                  "columnDefs": [{'orderable': false,'targets': [0,5,10] }],
                "order": [
                    [1, "desc"]
                ],
                 "dom": "<'row' <'col-md-12'T>><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>", // datatable layout
          
                  "tableTools": {
                "sSwfPath": "/assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [{
                    "sExtends": "pdf",
                    "sButtonText": "PDF"
                }, {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                }, {
                    "sExtends": "xls",
                    "sButtonText": "Excel"
                }, {
                    "sExtends": "print",
                    "sButtonText": "Print",
                    "sInfo": 'Please press "CTR+P" to print or "ESC" to quit',
                    "sMessage": "Generated by DataTables"
                }]
            }
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
       
       
         
             
            if (action.val() != "" && grid.getSelectedRowsCount() > 0 ) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
           
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: '您没有选择操作项！',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: '您没有选择操作的数据！',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
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
        grid.getDataTable().ajax.reload(); 
       	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	Metronic.unblockUI();
 alert(errorThrown); 
 },  
     
  }); 
  

  
   } 
 
 
</script>