<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>SMP - Login</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url();?>assets/css/login_alluser.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url();?>assets/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/css.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>assets/css/themes/tosca.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="index.html">
	<img src="<?php echo base_url();?>assets/img/logo-big.png" style="height: 50px;" alt=""/>
	</a>
	<h4>Pilih Akun</h4>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<a href="<?php echo site_url();?>/front_office/c_login/login_other?user_id=<?php echo $this->session->userdata(base_url().'USER_ID');?>"><div class="col-md-12 batasPd10">
			<div class="pull-left alluser-avatar-block">
				<img src="<?php echo base_url();?>uploads/foto/<?php echo $this->session->userdata(base_url().'KARYAWAN_PHOTO');?>" class="alluser-avatar">
			</div>
			<div class="alluser-form pull-left">
				<div class="nama"><?php echo $this->session->userdata(base_url().'KARYAWAN_NAMA');?></div>
			</div>
			<div class="alluser-form2 pull-right">
				<i class="fa fa-chevron-right"></i>
			</div>
	</div></a>
	<?php
	foreach ($user->result_array() as $usr) {
		?>
		<a href="<?php echo site_url();?>/front_office/c_login/login_other?user_id=<?php echo $usr['user_id'];?>"><div class="col-md-12 batasPd10">
				<div class="pull-left alluser-avatar-block">
					<img src="<?php echo base_url();?>uploads/foto/<?php echo $usr['karyawan_photo'];?>" class="alluser-avatar">
				</div>
				<div class="alluser-form pull-left">
					<div class="nama"><?php echo $usr['karyawan_nama'];?></div>
				</div>
				<div class="alluser-form2 pull-right">
					<i class="fa fa-chevron-right"></i>
				</div>
		</div></a>
		<?php
	}
	?>
		

</div>
<div class="copyright hide">
	 2014 © Metronic. Admin Dashboard Template.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url();?>assets/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url();?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Login.init();
Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>