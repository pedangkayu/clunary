<!DOCTYPE html>
<html>
<head>
 	
  <script src="<?php echo base_url().'assets_kasir/js/jquery-latest.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets_kasir/js/jquery-1.10.2.min.js'; ?>"></script>
  <script type="text/javascript">
	$(document).ready(function(){
	//auto load
	setInterval(function(){$(".right").load(location.href + ' .right')}, 2000);

	//onclick
	/*
	$(".listorder").click(function() {
		//$("#checker").load('<?php echo base_url().'transaction/insert.php'; ?>');
		$(".cb").load('tes.php');
	}); */   	
	});

	function btn_logout () {
		is_open_audit = <?php echo json_encode($is_open_audit);?>;
		if(is_open_audit){
			alert('Anda Belum Menutup Audit');
		}else{
			window.location.replace("<?php echo site_url('front_office/c_login/logout'); ?>");
		}
	}

   
  </script>
  
</head>

<body>
<div class="wrapper">
<div class="header">
	<ul>
		<li><a href="<?php echo site_url('kasir');?>">Kasir</a></li>
		<li><a href="<?php echo site_url().'kasir/audit'; ?>" target="checker">Audit</a></li>
		<li><a href="<?php echo site_url().'kasir/report_audit'; ?>" target="checker">Report</a></li>
		<li><a href="#">Registrasi Member</a></li>
		<li><a href="#">Login as : <?php echo $this->session->userdata(base_url().'nama_lengkap').' ('.$this->session->userdata(base_url().'kode_pegawai').')'; ?></a></li>
		<li><a href="#" onClick="btn_logout()">Logout</a></li>
	
	</ul>
	
</div>
<div class="wrapper_left">
	<div class="left">
		<h3>Cashier | <a href="kasirr">eeee</a></h3>

		<?php echo @$content_layout;?>
		<!-- <iframe name="checker" src="<?php echo base_url().'/transaction/check.php'; ?>" frameborder="0" width="100%" height="580px" style="padding:0; overflow:hidden;">			
	
		</iframe>  -->
	</div>
</div>
<div class="wrapper_right">
	<?php 
	// include 'menu.php'; //echo $menu;
	if (isset($menu) && !empty($menu)) {
        echo $menu;
    }
	?>


</div>
</div>
</body>
</html>
 
<style type="text/css">
body { font-family: sans-serif; font-size:0.9em; padding:0; margin: 0; height: 600px;} 
.wrapper { width: 100%; vertical-align: top; margin: 0; padding: 0;}
.header { background: #000;
}
.header ul { margin: 0; padding: 0; overflow: hidden; display: inline-block;}

.header ul li {
	list-style: none; color: #fff; float: left;
}
.pelogin { display: inline-block; color: #fff; vertical-align: top; padding: 5px;}
.header ul li a { color: #fff; text-decoration:none; font-size: 1.2em; padding: 5px 10px; display: inline-block;}
.left h3, .right h3 {padding: 0; margin: 0; background: #333; color: #fff; 
	text-align: center; padding: 10px; }
.wrapper_left {float: left; width: 30%; vertical-align: top;border:0px solid #333; 
	min-height: 625px; max-height: 625px; box-sizing:border-box;}

.left{box-sizing:border-box;  width:100%; }


.wrapper_right {width: 70%;  border:0px solid #333; float: left; box-sizing:border-box; min-height: 625px; background: #999; }
.right{width: 100%; overflow: hidden;}
.right ul { margin: 0; padding: 5px;  overflow: hidden; height: 550px; float: left;}
.right ul h4 { background: #ccc; margin: 0; padding: 5px;}
.right ul a { text-decoration: none; color:  #000;}
.right ul li {background: ; list-style: none;  text-align: left; display: inline-block;  border:0px solid #333; margin: 5px; border-radius: 50%;
				width: 100px; height: 85px; vertical-align: top; font-size: 0.9em; cursor: pointer; }
.left table { margin: 0px;font-style: italic; font-weight: normal; border-collapse: collapse; padding: 10px;}
.left table th { background: #ccc;}
.w_order{  position: relative; background: #038fa4; 
	vertical-align: top;
	border-radius: 0; padding: 5px;
	width:100px; min-height: 75px; height: 65px; border:1px solid #fff;bottom: 0; top:0px; left: 0px; }
.meja { font-size: 25px; border:1px solid #fff;  color: #fff; border-radius: 0px; width: ;  padding:0px 10px;
			margin: 0 auto; box-sizing:border-box; text-align: center; }
.nama_p { font-size: 15px; border:1px solid #333; color: #fff; border-radius: 10px; width: 70px;  padding:0px 10px;
		margin: 0 auto; box-sizing:border-box; text-align: center; border:0px solid #fff;}
.status_order { position: absolute; bottom:-10px; right: -25px;  width: 30px; height: 30px; border-radius: 50%;}
/*.s_printed { background-image: url('<?php echo base_url();?>assets_kasir/image/s_printed.png'); background-size: 100%;}
.s_billed { background-image: url('<?php echo base_url();?>assets_kasir/image/s_billed.png'); background-size: 100%;}*/
.order_right {
	vertical-align: top;
	width: 50%;
	float: left;
	border: 1px solid #ccc;
}
.order_left {
	
	border: 1px solid #ccc;	
}
.c1 {
	background: #f00;
}
.c2 {
	background: #0f0;
}
.c3 {
	background: #f0f;
}

.c4{
	background: #035bfb;
}

.w_order label {
	width: 40px;
	/*background: #ccc;*/
	display: inline-block;

}
.progresmenu { background: ;
	box-sizing:border-box;
 display: block; width: 60%; 
}
.payedmenu{
	width: 38%;
	box-sizing:border-box;
	border-left: 1px solid #000;
	/*background: #73a4ff;*/
}
</style>