<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search " action="#" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="start <?php if($page['menu1']=="main") echo " active open";?>">
					<a href="javascript:;">
					<i class="icon-home"></i>
					<span class="title">控制中心</span>
					<span class="selected"></span>
				
					</a>
					<ul class="sub-menu">
						<li <?php if($page['menu2']=="netbot") echo "class=\"active\"";?>>
							<a href="/index.php/admin/netbot">
							<i class="icon-tag"></i>
							<span class="badge badge-roundless badge-danger">Bot</span>主机管理</a>
						</li>
							<li <?php if($page['menu2']=="task") echo "class=\"active\"";?>>
							<a href="/index.php/admin/task">
							<i class="icon-handbag"></i>
							<span class="badge badge-roundless badge-success">Task</span>任务管理</a>
						</li>
					
					</ul>
				</li>
					<li <?php if($page['menu1']=="data") echo "class=\"active open\"";?>>
					<a href="javascript:;">
					<i class="icon-rocket"></i>
					<span class="title">数据管理</span>
					<span class="selected"></span>
				
					</a>
					<ul class="sub-menu">
			
		
				
								<li <?php if($page['menu2']=="datacron") echo "class=\"active\"";?>>
							<a href="/index.php/admin/tasklist/cron">
							<i class="icon-handbag"></i>
							【计划】队列</a>
						</li>
						
							<li <?php if($page['menu2']=="datachat") echo "class=\"active\"";?>>
							<a href="/index.php/admin/tasklist/chat">
							<i class="icon-handbag"></i>
							【即时】队列</a>
						</li>
				
					
					
					</ul>
				</li>
				<?php  if($this->user_role=="administrator"){ ?>
				<li <?php if($page['menu1']=="system") echo "class=\"active open\"";?>>
					<a href="javascript:;">
					<i class="icon-basket"></i>
					<span class="title">系统设置</span>
					<span class="selected"></span>
				
					</a>
					<ul class="sub-menu">
						<li <?php if($page['menu2']=="user") echo "class=\"active\"";?>>
							<a href="/index.php/admin/user">
							<i class="icon-home"></i>
							管理员设置</a>
						</li>
						<li <?php if($page['menu2']=="group") echo "class=\"active\"";?>>
							<a href="/index.php/admin/group">
							<i class="icon-basket"></i>
							分组管理</a>
						</li>
					
						<li <?php if($page['menu2']=="app") echo "class=\"active\"";?>>
							<a href="/index.php/admin/app">
							<i class="icon-handbag"></i>
							插件管理</a>
						</li>
						
								<li <?php if($page['menu2']=="node") echo "class=\"active\"";?>>
							<a href="/index.php/admin/node">
							<i class="icon-handbag"></i>
							节点管理</a>
						</li>
						
						
			
					</ul>
				</li>
			<?php } ?>
				
			
				<!-- BEGIN ANGULARJS LINK -->
				<li class="tooltips" data-container="body" data-placement="right" data-html="true" data-original-title="测试控制">
					<a href="/index.php/admin/test" target="_blank">
					<i class="icon-paper-plane"></i>
					<span class="title">
					测试控制 </span>
					</a>
				</li>
				<!-- END ANGULARJS LINK -->
				
		
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>