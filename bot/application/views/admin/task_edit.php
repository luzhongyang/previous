<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $task['title'];?></h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
		
				<form role="form" name="form1" id="form1" class="form-horizontal" method="post" action="/admin/task/editsave">
			 <input type="hidden"  name="id"  value="<?php echo $task['t_id'];?>">
		<div class="form-body">
			  
				       <div class="form-group">
										<label class="col-md-2 control-label">任务名称：</label>
										<div class="col-md-8">
											<input type="text" name="t_name" value="<?php echo $task['t_name'];?>"  class="form-control" placeholder="Enter text">
											<span class="help-block">
											 </span>
										</div>
									</div>
									
									  <div class="form-group">
										<label class="col-md-2 control-label">任务版本：</label>
										<div class="col-md-8">
											<input type="text" name="t_hash" value="<?php echo $task['t_hash'];?>"  class="form-control" placeholder="Enter text">
											<span class="help-block">
											 </span>
										</div>
									</div>
									
										  <div class="form-group">
										<label class="col-md-2 control-label">任务备注：</label>
										<div class="col-md-8">									
											<textarea name="t_inf"  class="form-control"><?php echo $task['t_inf'];?></textarea>
											<span class="help-block">
											 </span>
										</div>
									</div>
									
				<div class="form-group">
										<label class="col-md-2 control-label" >任务类型：</label>
										<div class="col-md-4">
											<select class="form-control" name="t_netbot" id="t_netbot" onchange="get_group();" <?php if(!empty($own)) echo "readonly";?>>
												 <?php if(empty($own)) { ?>
												 <?php if($this->user_role=="administrator") { ?>
												<option value="0" <?php if($task['t_netbot']==0) echo "selected";?>>全局任务</option>
												<?php } ?>
												<option value="1" <?php if($task['t_netbot']==1) echo "selected";?>>组任务</option>
											<?php } ?>
												<option value="2" <?php if($task['t_netbot']==2) echo "selected";?>>单机任务</option>
											</select>
										</div>
									</div>
			
			      <div class="form-group">
										<label class="col-md-2 control-label">影响域：</label>
										<div class="col-md-9"  id="t_yxy">
										
										</div>
									</div>
			
        <div class="form-group">
										<label class="col-md-2 control-label" >指令：</label>
										<div class="col-md-4">
											<select class="form-control" name="t_function" id="t_function" onchange="get_vars();">
											
											<?php 
											foreach ($app as $value) {
											?> 	
											<option value="<?php echo $value['app_fun'] ?>" <?php if($task['t_function']==$value['app_fun']) echo "selected";?>><?php echo $value['app_name'] ?></option>
											<?php  	
											} 
											?>
			
											</select>
										</div>
									</div>
		
				<div class="form-group">
										<label class="col-md-2 control-label">参数：</label>
										<div class="col-md-9">
											
											
													<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-comments"></i>指令对应参数
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
							
											<div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
								<strong>说明:</strong> <span id="fun_help"></span>
							</div>
								
								<table class="table table-striped table-bordered table-hover" id="datatable_tasks">
							<thead>
							<tr>
							
							
								<th width=20%>

										参数项									</th>

									<th >

										参数值									</th>

									
							</tr>
							</thead>
							<tbody id="fun_vars">
								
				
							
							</tbody>
							</table>
						</div>
							</div>
						</div>
					
					<!-- END SAMPLE TABLE PORTLET-->
											
											
											
										</div>
									</div>						
									
		  <div class="form-group">
										<label class="col-md-2 control-label">有效期：</label>
										
											<div class="col-md-4">
											<div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" name="t_starttime" value="<?php echo $task['t_starttime'];?>">
												<span class="input-group-addon">
												to </span>
												<input type="text" class="form-control" name="t_endtime" value="<?php echo $task['t_endtime'];?>">
											</div>
											<!-- /input-group -->
											<span class="help-block">
											任务有效时间段 </span>
										</div>
										
									</div>
									
			 <div class="form-group">
										<label class="col-md-2 control-label">重复触发：</label>
										
										<div class="col-md-2">
											<select class="form-control" name="t_repeat" id="t_repeat" onchange="get_repeat();">
												<option value="0" <?php if($task['t_repeat']==0) echo "selected";?>>单次</option>
												<option value="1" <?php if($task['t_repeat']==1) echo "selected";?>>重复执行</option>
											
											
											</select>
										</div>
											<div class="col-md-4" >
													<input type="text" name="t_interval" id="t_interval" value="<?php echo $task['t_interval'];?>"  class="form-control" placeholder="小时数">
												
											</div>
										
									</div>						
				
					 <div class="form-group">
										<label class="col-md-2 control-label">结果返回：</label>
										
										<div class="col-md-2">
											<select class="form-control" name="t_isback" id="t_isback" onchange="get_isback();">
												<option value="1" <?php if($task['t_isback']==1) echo "selected";?>>返回</option>
												<option value="0" <?php if($task['t_isback']==0) echo "selected";?>>不返回</option>
											
											
											</select>
										</div>
											<div class="col-md-4" >
													<input type="text" name="t_backfun" id="t_backfun" value="<?php echo $task['t_backfun'];?>"  class="form-control" placeholder="回调函数名">
												
											</div>
										
									</div>	
									
									
				<!-- BEGIN PORTLET-->
					<div class="portlet light bg-inverse" id="netbot_filter">
						<div class="portlet-title">
							<div class="caption font-red-intense">
								<i class="icon-speech font-red-intense"></i>
								<span class="caption-subject bold uppercase"> 过滤设置</span>
								<span class="caption-helper">智能控制执行机器</span>
							</div>
							<div class="tools">
								<a href="" class="collapse" data-original-title="" title="">
								</a>
							
								<a href="" class="fullscreen" data-original-title="" title="">
								</a>
								
							</div>
						</div>
						<div class="portlet-body">
						
							<div class="form-group">
										<label class="col-md-2 control-label" >地区：</label>
										<div class="col-md-2">
											<select class="form-control" name="t_area_type" id="t_area_type" onchange="get_area();">
												<option value="0" <?php if($task['t_area_type']==0) echo "selected";?>>不限制</option>
												<option value="1" <?php if($task['t_area_type']==1) echo "selected";?>>包含</option>
												<option value="2" <?php if($task['t_area_type']==2) echo "selected";?>>排除</option>
											
											</select>
										</div>
											<div class="col-md-8" id="t_area_str">
											
											<select name="t_area[]" id="t_area" multiple class="form-control select2me" >
												
												
															<?php 
															$t_area=array();
															if($task['t_area']){
																$t_area=json_decode($task['t_area'],true);
															}
															
															
															foreach($netbot_area as $key=>$val) {?>
												
												<option value="<?php echo $key;?>" <?php if(@in_array($key,$t_area)) echo "selected"; ?>><?php echo $val;?></option>
															
												<?php }?>
												
												</select>
												
										</div>
						</div>
					  
					  
					  
						<div class="form-group">
										<label class="col-md-2 control-label" >操作系统：</label>
										<div class="col-md-2">
											<select class="form-control" name="t_os_type" id="t_os_type" onchange="get_os();">
												<option value="0" <?php if($task['t_os_type']==0) echo "selected";?>>不限制</option>
												<option value="1" <?php if($task['t_os_type']==1) echo "selected";?>>包含</option>
												<option value="2" <?php if($task['t_os_type']==2) echo "selected";?>>排除</option>
											
											</select>
										</div>
											<div class="col-md-8" id="t_os_str">
											
											<select name="t_os[]" id="t_os" multiple class="form-control select2me" >
												
												
															<?php 
															$t_os=array();
															if($task['t_os']){
																$t_os=json_decode($task['t_os'],true);
															}
															
															
															foreach($netbot_os as $key=>$val) {?>
												
												<option value="<?php echo $key;?>" <?php if(@in_array($key,$t_os)) echo "selected"; ?>><?php echo $val;?></option>
															
												<?php }?>
												
												</select>
												
										</div>
						</div>
					
					
							<div class="form-group">
										<label class="col-md-2 control-label" >节点：</label>
										<div class="col-md-2">
											<select class="form-control" name="t_url_type" id="t_url_type" onchange="get_url();">
												<option value="0" <?php if($task['t_url_type']==0) echo "selected";?>>不限制</option>
												<option value="1" <?php if($task['t_url_type']==1) echo "selected";?>>包含</option>
												<option value="2" <?php if($task['t_url_type']==2) echo "selected";?>>排除</option>
											
											</select>
										</div>
											<div class="col-md-8" id="t_url_str">
											
											<select name="t_url[]" id="t_url" multiple class="form-control select2me" >
												
												
															<?php 
															$t_url=array();
															if($task['t_url']){
																$t_url=json_decode($task['t_url'],true);
															}
															
															
															foreach($netbot_url as $key=>$val) {?>
												
												<option value="<?php echo $key;?>" <?php if(@in_array($key,$t_url)) echo "selected"; ?>><?php echo $val;?></option>
															
												<?php }?>
												
												</select>
												
										</div>
						</div>
					
						</div>
					</div>
					<!-- END PORTLET-->
	
			
									
			
	  </div>
		   </form>
		
		
		
		
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">返回</button>
	<button type="button" class="btn blue"  onclick="edit_save();" >保存设置</button>
</div>
<script>
	 var id=<?php echo $id;?>;
     get_group();
     get_vars();
     get_area();
     get_os();
     get_url();
     get_repeat();
     get_isback();
      $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
        
        
        
     
    function get_area(){
    	  var t_area_type=$('#t_area_type').val();
    	  if(t_area_type==0){
    	  $('#t_area_str').hide();	
    	  }else{
    	  $('#t_area_str').show();
    	  }
    		
   
    } 
     function get_os(){
    	  var t_os_type=$('#t_os_type').val();
    	  if(t_os_type==0){
    	  $('#t_os_str').hide();	
    	  }else{
    	  $('#t_os_str').show();
    	  }
    		
   
    }  
      function get_url(){
    	  var t_url_type=$('#t_url_type').val();
    	  if(t_url_type==0){
    	  $('#t_url_str').hide();	
    	  }else{
    	  $('#t_url_str').show();
    	  }
    		
   
    }  
        function get_repeat(){
    	  var t_repeat=$('#t_repeat').val();
    	  if(t_repeat==0){
    	  $('#t_interval').hide();	
    	  }else{
    	  $('#t_interval').show();
    	  }
    		
   
    }  
            function get_isback(){
    	  var t_isback=$('#t_isback').val();
    	  if(t_isback==0){
    	  $('#t_backfun').hide();	
    	  }else{
    	  $('#t_backfun').show();
    	  }
    		
   
    }  
      
     
		function ss1() { 
		
		      $(".select2me").select2({
                placeholder: "Select",
                allowClear: true,
                //formatResult: format,
                //formatSelection: format,
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
         
            
      
            
            
		}
		
			function ss2() { 
		
	

  	$("#t_group").select2({
    ajax: {
      url: "/admin/task/botsearch",
      dataType: 'json',
      data: function (term,page) {
        return {
            q: term, 
            page_limit: 10,
            page: page 
        };
      }, 
      results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    
            var more = (page * 10) < data.total;
            return { results: data.items, more: more };
                
                
                }
    },
  
      initSelection: function (element, callback) {
            var data = [{id: element.val(), text: element.val()}];
            callback({id: element.val(), text: element.val()});//这里初始化
        },
    minimumInputLength: 3,
    dropdownCssClass: "bigdrop",
    formatInputTooShort: "请输入受控主机GUID",
    formatNoMatches: "没有匹配的主机GUID",
    formatSearching: "查询中..."
    //formatResult: formatRepo, // omitted for brevity, see the source of this page
   // formatSelection: formatRepoSelection, // omitted for brevity, see the source of this page
  });    
            
            
		}
		
		
	 function formatRepo (repo) {
  
    var markup = '<div>' + repo.title + '</div>';
   
    return markup;
  }
  
  function formatRepoSelection (repo) {
    return repo.title || repo.name;
  }
  
  
   function get_group(){
     var t_netbot=$('#t_netbot').val();
    
    if(t_netbot==2){ 	
    	$('#netbot_filter').hide();
    }else{
    	$('#netbot_filter').show();
    }
     <?php if(empty($own)){ ?>
    jQuery.ajax({  
    url: '/admin/task/getgroup', 
    async: true,  
    dataType: 'html', 
    data: {"id":id,"t_netbot":t_netbot}, 
    type: 'POST',  
   
   success: function (data) { 
   	$('#t_yxy').html(data);
  
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  });
 
    <?php }else{?>
    	 	$('#t_yxy').html('<input type="text" id="t_group" name="t_group"    value="<?php echo $own;?>" class=" form-control " readonly>');	
    <?php }?>	
    }
    
     function get_vars(){
     	
      var t_function=$('#t_function').val();
    
    jQuery.ajax({  
    url: '/admin/task/getvars', 
    async: true,  
    dataType: 'html', 
    data: {"id":id,"t_function":t_function}, 
    type: 'POST',  
   
   success: function (data) { 
   	$('#fun_vars').html(data);
  
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
     	
     	
    }
    
   function edit_save() {

	  	jQuery.ajax({  
    url: '/admin/task/editsave', 
    async: true,  
    dataType: 'json',  
     data:  $('#form1').serialize(), 
    type: 'POST',    
   
    success: function (data) { 
   	
   	 if(data.result==0){
   	 alert(data.msg);
   }else{
   	 jQuery('#ajax').modal("hide");
   	 get_tasksing();
   	}
   	
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
	  
	  
    }
    

	
    
</script>