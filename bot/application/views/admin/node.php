	
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
								<i class="fa fa-globe"></i>节点设置
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
												<a href="/admin/node/edit/0" role="button" class="btn red" data-target="#ajax" data-toggle="modal">
														<i class="fa fa-pencil"></i> 添加一个节点
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
							<table class="table table-striped table-bordered table-hover" id="applist">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#applist .checkboxes"/>
								</th>
								<th >
									 ID
								</th>
								<th width="20%">
									 节点名称
								</th>
								<th >
									 节点URL
								</th>
								<th width="15%">
									添加时间
								</th>
								<th width="10%">
									 节点状态
								</th>
					
									<th width="10%">
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
var table = $('#applist');
   function get_listing() {  
             table.dataTable({
            	"bStateSave":true,  //保存状态
            	"deferRender": true, //延时渲染
			        "bDestroy":true,     //重置数据
			        "bAutoWidth":false,
              "bProcessing" : true,//加载数据时候是否显示进度条
            //"bServerSide" : true,//是否从服务加载数据
              "sAjaxSource": '/admin/node/getlist',
               "fnInitComplete": function (){
		  Metronic.initUniform($('input[type="checkbox"]', table)); 
        },
        "pageLength": 25,            
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
                    { 'bSortable': false, 'aTargets': [0,6] },
                    { "bSearchable": false, "aTargets": [0,6]}]
    });
    
      var tableWrapper = jQuery('#applist_wrapper');

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
  function edit_save() {

	  	jQuery.ajax({  
    url: '/admin/node/editsave', 
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
	   bootbox.confirm("您确认要删除指令【"+name+"】吗?", function(result) {
		                if(result){
                  del_go(id);
                   
                 }
                }); 
	
	}
	
		function del_go(id) {
    
		jQuery.ajax({  
    url: '/admin/node/del/'+id, 
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
   
   
   					function setstatus(id,status){
			

		 bootbox.setDefaults({locale:"zh_CN"}); 
	   bootbox.confirm("您确认要改变【"+id+"】状态吗?", function(result) {
		                if(result){
                  setstatus_go(id,status);
                   
                 }
                }); 
	
	}
	
	
		 	function setstatus_go(id,status) {            
      Metronic.blockUI();                           
		  jQuery.ajax({  
      url: '/admin/node/setstatus', 
      async: true,  
      dataType: 'json',  
      data: {"id":id,"status":status}, 
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