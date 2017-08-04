<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">为用户【<?php echo $member['username']; ?>】授权</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<h4>选择分配访问的组</h4>
			<p>
		
				<form role="form" name="form1" id="form1" class="form-horizontal" method="post" action="/admin/user/rolesave">
			<input type="hidden"  name="username"  value="<?php echo $member['username'];?>">
		<div class="form-group form-md-line-input">
										<label class="col-md-2 control-label" for="form_control_1"></label>
										<div class="col-md-10">
											<div class="md-checkbox-list">
												<?php
												
												foreach ($group_list as $key=> $value){
												 	
												 ?>
											
												<div class="md-checkbox <?php if($value['ng_type']=="expand") echo "has-warning";?>"  >
													<input type="checkbox" id="checkbox_<?php echo $key;?>" name="role[]" class="md-check" value="<?php echo $value['ng_id'];?>" <?php if(in_array($value['ng_id'],$membergroup)) echo "checked";   ?>>
													<label for="checkbox_<?php echo $key;?>">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>
													<?php echo $value['ng_name'];?>(<?php echo $value['ng_type'];?>) </label>
												</div>
												
												<?php	
												} 
												?>
												
									
									
									
									
											</div>
										</div>
									</div>
		   </form>
			</p>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">返回</button>
	<button type="button" class="btn blue"  onclick="role_save();" >保存设置</button>
</div>