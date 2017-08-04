	
<?php  $this->load->view('admin/head');?>				
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					 Page content goes here888
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