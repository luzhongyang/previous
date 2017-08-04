<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $node['title'];?></h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
		
				<form role="form" name="form1" id="form1" class="form-horizontal" method="post" action="/admin/node/editsave">
			 <input type="hidden"  name="id"  value="<?php echo $node['id'];?>">
		<div class="form-body">
			  
				       <div class="form-group">
										<label class="col-md-2 control-label">名称：</label>
										<div class="col-md-8">
											<input type="text" name="name" value="<?php echo $node['name'];?>"  class="form-control" placeholder="Enter text">
											<span class="help-block">
											 </span>
										</div>
									</div>
									
			
		
			 <div class="form-group">
										<label class="col-md-2 control-label">路径：</label>
										<div class="col-md-9">
											<input type="text" name="url" value="<?php echo $node['url'];?>" class="form-control" placeholder="Enter text">
											<span class="help-block">
										 </span>
										</div>
									</div>
							
									
									
			<div class="form-group">
										<label class="col-md-2 control-label">备注：</label>
										<div class="col-md-9">
											<textarea name="inf" class="form-control" rows="3"><?php echo $node['inf'];?></textarea>
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