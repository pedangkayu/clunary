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

		$('#drop').click(function(){

		});  	
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
		<li><a href="#">Login as <?php echo $this->session->userdata(base_url().'nama_lengkap').' ('.$this->session->userdata(base_url().'kode_pegawai').')'; ?></a></li>
		<li><a href="#" onClick="btn_logout()">Logout</a></li>
	</ul>
</div>

<div class="wrapper_left">
	<div class="left">
		
		<?php echo @$content_layout;?>
		<!-- iframe name="checker" src="<?php echo base_url().'/transaction/check.php'; ?>" frameborder="0" width="100%" height="580px" style="padding:0; overflow:hidden;">			

		</iframe -->
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
<div class="wrapper_right_2">
	<h3 style="margin: 0; background: #333; color: #fff; padding: 10px; text-align: center;">Nota Hari Ini</h3>

	<div class="cetak_lunas" style="overflow-y: scroll; list-style: none; height: 600px; padding: 5px;">

			<?php 
				foreach($showpayed as $row){
				$id = $row['id_pesanan'];
			?>

				<a class="arsip" href="<?php echo site_url().'kasir/c_transaksi/print_bill_lunas/'.$id ?>" target="_top">
				<div class="nomerarsip"><?php echo $row['counter_nota'];?> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['kode_meja'];?></div>
				<?php echo $row['kode_pemesanan'];?>  
				</a> 
				 
			<?php
			}?>
		 
		

		<!-- <?php 
		foreach($showpayed as $row){
			$id = $row['id_pesanan'];
			?>
							
				<li class="listorder li_re">
						<?php 
							if($row['status_pemesanan']==1){ $class="c1"; $state="Progres";} 
							if($row['status_pemesanan']==2){ $class="c2"; $state="Served";}
							if($row['status_pemesanan']==3){ $class="c3"; $state="Pending";}
							if($row['status_pemesanan']==4){ $class="c4"; $state="Lunas";}
						?>
					
						<div class="w_order <?php echo $class; ?>">
							<label>Meja</label> : <?php echo $row['kode_meja'];?><BR>
							<label>Nama</label> : <?php echo $row['nama_pemesan']; ?>
							<label>Status</label> : <?php echo $state; ?>
						<div>	
					
				<div class="li_abs">
					<a href="<?php echo site_url().'/kasir/c_transaksi/print_bill_lunas/'.$id ?>" target="_top">Cetak</a>
				
				</div>		
				</li>
				
			<?php
			}

			?> -->




	</div>
	
</div>
</div>
</body>
</html>
 

<style type="text/css">
 

.arsip:hover {
		background-image: url('<?php echo base_url();?>assets_kasir/image/bg_nota2.png');
		color: #FFF;
}

 .arsip{
	border-radius: 10px 0 10px 0;
	text-decoration: none; 
	color: #FFF;
	display: inline-block; 
	width: 80px;  
	font-size:0.6em; 
	margin-top: 5px; 
	padding-top: 5px;
	padding: 5px;
	text-align:center; 
	background-image: url('<?php echo base_url();?>assets_kasir/image/bg_nota1.png');
}

.nomerarsip {
	text-align: center; 
	font-size:  14px;
	padding-bottom: 1px;
}



body { font-family: sans-serif; font-size:0.9em; padding:0; margin: 0; height: 600px;} 
.wrapper { width: 100%; vertical-align: top; margin: 0; padding: 0;}
.header { background: #000;
}
.header ul { margin: 0; padding: 0; overflow: hidden; display: inline-block;  font-size:0.7em; }

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


.wrapper_right {width: 45%;  border:0px solid #333; float: left; box-sizing:border-box; min-height: 625px; background: #F6F2F2; }
.right{width: 100%; overflow: hidden;}
.right ul { margin: 0; padding: 5px;  overflow: hidden; height: 550px; float: left; }
.right ul h4 { margin: 0; padding: 5px;}
.right ul a { text-decoration: none; color:  #000;}
.right ul li {list-style: none;  text-align: left; display: inline-block;  border:0px solid #333; margin: 5px; border-radius: 50%;
				width: 100px; height: 85px; vertical-align: top; font-size: 0.9em; cursor: pointer; }
.left table { margin: 0px;font-style: italic; font-weight: normal; border-collapse: collapse; padding: 10px;}
.left table th { background: #ccc;}


.w_order{  
	margin-top: 10px;
	position: relative; 
	vertical-align: top;
	border-radius: 5px; 
	padding: 8px;
	width:100px; 
	min-height: 60px; 
	border: dotted 2px solid #fff; 
	top:0px; 
	left: 0px; box-shadow:0 2px 5px 2px rgba(0, 0, 0, 0.1);
	}

h5 {
	color:  #FFF;
	font-size: 1.0em;
	text-align: center;
	margin-top: 6px;
	margin-bottom: 6px;
}


.meja { font-size: 50px; color: #FFFFFF; 
        padding:0px 10px;
		margin: 0 auto; box-sizing:border-box; 
		text-align: center; 
		font-weight: bolder;
	}



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
	background: #D80014;
}
.c2 {
	background: #3CA701;
}
.c3 {
	background: #00A2FF;
}

.c4{
	background: #035bfb;
}

.w_order label {
	width: 40px;
	display: inline-block;

}
.progresmenu { background: ;
	box-sizing:border-box;
 display: block; width: 100%; 
}
.payedmenu{
	width: 38%;
	box-sizing:border-box;
	border-left: 1px solid #000;
	/*background: #73a4ff;*/
}
.cetak_lunas {
	padding: 0; margin: 0;
}
.cetak_lunas li {
	display: inline-block;
	width: 80px;
}
</style>