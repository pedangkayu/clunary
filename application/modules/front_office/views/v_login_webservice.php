<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
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

<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url(); ?>assets/css/login2.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>assets/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/themes/tosca.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet">
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
	<img src="<?php echo base_url(); ?>assets/img/logo-big.png" style="height: 100px;" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="<?php echo site_url(); ?>/front_office/c_login/process_webservice" method="post">
		<div class="form-title">
			<span class="form-title">Welcome.</span>
			<span class="form-subtitle">WEBSERVICE.</span>
		</div>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" onkeypress='return enter_login(event)' name="password"/>
		</div>
		<div class="form-group">
			<label class="control-label">Tanggal Awal</label>
			<input type="text" name="tgl_awal" class="form-conr=trol">
		</div>
		<div class="form-group">
			<label class="control-label">Tanggal Akhir</label>
			<input type="text" name="tgl_akhir" class="form-conr=trol">
		</div>
		<div class="form-actions">
			<button type="submit" class="btn red btn-primary btn-block uppercase" id="btn_login" >Lihat Data</button><!-- onclick="event.preventDefault();send_login();" -->
		</div>
		
	</form>
	<!-- END LOGIN FORM -->
	
</div>
<div class="copyright hide">
	 2014 © Metronic. Admin Dashboard Template.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/login.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/custom_toast.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
//Login.init();
Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<script type="text/javascript">

// function send_login () {
// 	var username = $("input[name=username]").val();
// 	var password = $("input[name=password]").val();
// 	var tgl_awal = $.trim($('#tgl_awal').val());
// 	var tgl_akhir = $.trim($('#tgl_akhir').val());
	
// 	$.post('<?php echo site_url(); ?>/front_office/c_login/process_webservice', {username:username, password:password,tgl_awal:tgl_awal,tgl_akhir:tgl_akhir}, function(res) {
// 		if(res.status=='ok'){
// 			window.location.replace(res.url); 
// 		}else{
// 			NotifikasiToast({
// 				type : 'error', // ini tipe notifikasi success,warning,info,error
// 				msg : res.pesan, //ini isi pesan
// 				title : 'Error', //ini judul pesan
// 			});
// 		}
// 	});	
// }

function enter_login (event) {
	var keypressed = event.keyCode || event.which;
    if (keypressed == 13) {
      send_login();
    }
}


</script>