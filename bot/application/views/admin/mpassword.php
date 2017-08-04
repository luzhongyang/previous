	
<?php  $this->load->view('admin/head');?>				
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		
		<div class="portlet box blue ">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i>修改我的密码
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
					<a href="#portlet-config" data-toggle="modal" class="config">
					</a>
					<a href="javascript:;" class="reload">
					</a>
					<a href="javascript:;" class="remove">
					</a>
				</div>
			</div>
			<div class="portlet-body form">
				
				
				
				
				<!-- BEGIN FORM-->
				<form action="/admin/main/mpasswordsave" id="form_task_add" class="form-horizontal form-bordered form-row-stripped" method="POST" >
					
					<div class="form-body">
						
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button>
							您有一些错误的填写. 请检查.
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button>
							表单填写正确!
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">用户名
								<span class="required">
									*
								</span>
							</label>
							<div class="col-md-4">
								<h4><?php echo $info['username']; ?></h4>
								<span class="help-block">
									
								</span>
							</div>
						</div>	
						
						
						
						<hr>
						
						<div class="form-group">
							<label class="control-label col-md-3">原密码
								<span class="required">
									*
								</span>
							</label>
							<div class="col-md-3">
								<input type="password"  class="form-control" name="opassword" placeholder="输入您的原密码" value="">
								<span class="help-block">
									
								</span>
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-md-3">新密码
								<span class="required">
									*
								</span>
							</label>
							<div class="col-md-3">
								<input type="password"  class="form-control" name="password" id="register_password" placeholder="输入您的新密码" value="">
								<span class="help-block">
									
								</span>
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-md-3">新密码确认
								<span class="required">
									*
								</span>
							</label>
							<div class="col-md-3">
								<input type="password"  class="form-control" name="rpassword" placeholder="再次输入您的新密码"  value="">
								<span class="help-block">
									
								</span>
							</div>
						</div>	
						
						
						
						
						<div class="form-actions fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-offset-3 col-md-4">
										<button type="submit" class="btn green"><i class="fa fa-check"></i> 我要更新资料</button>
										<button type="button"  onclick="javascript:history.go(-1)" class="btn default">返回</button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<!-- END FORM-->
				</div>
			</div>	
		</div>
		
		
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


<?php  $this->load->view('admin/foot');?>	

<script>
	jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features

});
	
	
	

	
	
	
	
</script>