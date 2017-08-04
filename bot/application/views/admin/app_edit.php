	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $app['title'];?></h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
		
				<form role="form" name="form1" id="form1" class="form-horizontal" method="post" action="/admin/app/editsave">
			 <input type="hidden"  name="id"  value="<?php echo $app['app_id'];?>">
		<div class="form-body">
			  
				       <div class="form-group">
										<label class="col-md-2 control-label">名称：</label>
										<div class="col-md-8">
											<input type="text" name="app_name" value="<?php echo $app['app_name'];?>"  class="form-control" placeholder="Enter text">
											<span class="help-block">
											 </span>
										</div>
									</div>
									
				<div class="form-group">
										<label class="col-md-2 control-label" >类型：</label>
										<div class="col-md-4">
											<select class="form-control" name="app_type" <?php if($app['app_id'])  echo "disabled";?>>
												<option value="netbot" <?php if($app['app_type']=="netbot") echo "selected";?>>内部</option>
												<option value="exe" <?php if($app['app_type']=="exe") echo "selected";?>>外部EXE</option>
												<option value="dll" <?php if($app['app_type']=="dll") echo "selected";?>>外部DLL</option>
												<option value="robot" <?php if($app['app_type']=="robot") echo "selected";?>>机器人</option>
											
												
											</select>
										</div>
									</div>
			
			  <div class="form-group">
										<label class="col-md-2 control-label">指令：</label>
										<div class="col-md-4">
											<input type="text" name="app_fun" value="<?php echo $app['app_fun'];?>" class="form-control" placeholder="Enter text" <?php if($app['app_id'])  echo "disabled";?>>
											<span class="help-block">
										 </span>
										</div>
									</div>
			  <div class="form-group">
										<label class="col-md-2 control-label">回调：</label>
										<div class="col-md-4">
											<input type="text" name="app_backfun" value="<?php echo $app['app_backfun'];?>" class="form-control" placeholder="Enter text">
											<span class="help-block">
										 </span>
										</div>
									</div>
				<div class="form-group">
										<label class="col-md-2 control-label">MD5：</label>
										<div class="col-md-9">
											<input type="text" name="app_plugmd5" value="<?php echo $app['app_plugmd5'];?>" class="form-control" placeholder="Enter text">
											<span class="help-block">
										 </span>
										</div>
									</div>
			 <div class="form-group">
										<label class="col-md-2 control-label">路径：</label>
										<div class="col-md-9">
											<input type="text" name="app_plugurl" value="<?php echo $app['app_plugurl'];?>" class="form-control" placeholder="Enter text">
											<span class="help-block">
										 </span>
										</div>
									</div>
				<div class="form-group">
										<label class="col-md-2 control-label">参数：</label>
										<div class="col-md-9">
											<textarea name="app_vars" class="form-control" rows="3"><?php echo $app['app_vars'];?></textarea>
										</div>
									</div>						
									
									
			<div class="form-group">
										<label class="col-md-2 control-label">说明：</label>
										<div class="col-md-9">
											<textarea name="app_help" class="form-control" rows="3"><?php echo $app['app_help'];?></textarea>
										</div>
									</div>
			
	  </div>
		   </form>
		
		
		
		
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">返回</button>
	<button type="button" class="btn blue"  onclick="edit_save();" >保存设置</button>
</div>