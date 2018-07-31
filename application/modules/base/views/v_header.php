<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo site_url('dashboard/c_dashboard');?>">
			<img src="<?php echo base_url();?>assets/admin/layout/img/logo.png" alt="logo" class="logo-default"/>
			</a>
			
		</div>
		<!-- END LOGO -->
		
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li class="separator hide">
					</li>
					
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile">
						<?php
							echo $this->session->userdata(base_url().'nama_lengkap');
							$photo = $this->session->userdata(base_url().'foto');
						?> </span>
						<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
						<!-- <img alt="" class="img-circle" src="<?php echo base_url();?>uploads/foto/<?php echo $photo;?>"/> -->
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li style="display:none;">
								<a href="<?php echo site_url(); ?>profil">
								<i class="fa fa-gear"></i> Setting </a>
							</li>
							<li>
								<a href="<?php echo site_url(); ?>/front_office/c_login/logout">
								<i class="icon-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
					
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>