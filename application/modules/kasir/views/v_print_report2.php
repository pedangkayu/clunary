<script src="<?php echo base_url().'assets_kasir/js/jquery-latest.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function(){

	/*! Fades in page on load */
	//$('.notifikasi').css('display', 'none');
	$('.notifikasi').slideDown(500);
	setTimeout(function() {
		$(".notifikasi").fadeOut(1000);
	    },3000)

	function rupiah(nStr) {
   	nStr += '';
   	x = nStr.split('.');
   	x1 = x[0];
   	x2 = x.length > 1 ? '.' + x[1] : '';
   	var rgx = /(\d+)(\d{3})/;
   	while (rgx.test(x1))
   		{
    	  x1 = x1.replace(rgx, '$1' + '.' + '$2');
   		}
   	return "Rp. " + x1 + x2;
   	}


	$('#saldo_kasir').keyup(function(){
		//alert('press');

		var saldo_kasir = parseInt($('#saldo_kasir').val());
		var saldo_online = parseInt($('#total_payonline').text());
		var saldo_akhir =  saldo_online+saldo_kasir;

		var total_kas_sistem = parseInt($('#total_kas_sistem').val());
		
		var selisih = saldo_akhir-total_kas_sistem;
		
		$('#saldo_akhir').val(saldo_akhir);
		
		$('#selisih').val(selisih);
	
	});
	$('.nav_li').click(function(){
		$('.nav_li').css({'background':'#DE0000','color':'#fff'});
		$(this).css({'background':'#fff', 'color':'#DE0000'});
		var id= $(this).attr('id');
		$('.isine').hide('fast');
		$('.'+id).fadeIn('fast');
	});
	
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        window.print();
        document.location.href = '<?php echo site_url("kasir/c_kasir");?>';
        setTimeout("closePrintView()", 3000);
    });
    //function closePrintView() {
        
</script>
<style type="text/css">
div { box-sizing:border-box;}
h2 {
	margin: 0;
	padding: 0;
}
body{ margin: 0;
	font-family: sans-serif; font-size: 0.9em;
}
.wrapper { width: 7.6cm;background: #fff; padding: 10px; box-sizing:border-box;  position: relative;}

._audit {
	border: 0px solid #333; padding-bottom: 10px;
}
._audit h3 {color:#000; padding: 5px; margin: 0; }
.tr { border:0px solid #f00; padding:0px; margin: 0px 0px 0px 0px; overflow: hidden;}
.label {display: inline-block; width: 55%;}
.isi {display: inline-block; width: 40%; text-align: right; padding: 0 5px;}
._audit input { display: inline-block; width: 100%; text-align: right; padding: 5px; font-size: 1em; font-weight: bolder;}
.saldo_awal { border: none; /*background: #ccc;*/}
.tr textarea { width: 100%;  resize:none; min-height: 90px; padding: 5px;   font-size: 1.2em;}
.tr button { width: 50%; font-size: 1.5em; line-height: 25px;}
.btn_d {width: 100%;}
.notifikasi {
	width: 95%; position: absolute; padding: 10px; text-align: center; font-size: 1em; background: #ccc; box-shadow: 2px 4px 5px #333;
	display:none ;
}

.total_ {display: block; width: 30%;  color: #666; padding: 5px 10px; text-align: right; font-weight: bolder; font-style: normal; 
	border-top: 2px solid #000; margin-right: 0px; margin-left: auto; }
#tit {
	background: ;
	margin: 0%;
	padding: 1%;
	border-bottom: 1px solid #333;
}
#cont {
	background: ;
	margin: 0%;
	padding: 0%;
	margin-top: 5px;
}
#cont table {
	width: 100%;
}
#cont table th {
	/*background: #E03636;*/
	border-bottom: 1px solid #999;
	padding: 10px 5px 5px 5px;
}
.tit_penjualan {
	font-weight: bold;
	padding: 5px;
}

#nav {
	display: none;
	border: 1px solid #DE0000;
	margin: 0%;
	padding: 0%;
	box-sizing:border-box;
	overflow: hidden;
	background: ;	

}

.nav_li {
	float: left;
	width: 50%;
	text-align: center;
	color: #fff;
	font-weight: bold;
	padding: 5px;
	box-sizing:border-box;
	cursor:pointer;
	background: #DE0000;

}
.isine {
	width: 100%;
	min-height: 100px;
}
/*.fonte {
	display: block;
	width: 100%;
	color: #DE0000;
	background: #fff;
}*/
.tot_tag {
	/*background: #DE0000;*/
	margin:0;
	width: 100%;
	padding: 5px;
	text-align: right;

}
#fon {
	background: #fff;
	color:#DE0000;
}
.totalan {
	clear: both;
	margin-top: 10px;
	border-top: 1px solid #333;
	display: block;
	padding: 10px;
}
.trh{
	float: left;
	text-align: center;
	color: #000;
	border-bottom: 0px solid #000;
	padding: 5px;
	box-sizing:border-box;
	margin: 0;
}
 .tri{
	float: left;
padding: 0 2px;}
	.www{
	border: 0px solid #DE0000;
	margin-top: 5px;
	margin-bottom: 5px;
	padding: 0px;
	}
.bk{
	/*background: #ccc;*/
}


#top {
	position: absolute;
	top:0;
	width: 100%;
	border: 0px solid #0f0;
}
#bottom {
	margin-top: 120px;
}
</style>
<?php
$dt = $pendapatan->row();
?>
<div class="wrapper">
	<div class="_audit">
		<div id="bottom">
		<div id="cont">
			<h3>Data Penjualan Fonte</h3>
			<div id="nav">
				<div class="nav_li" id="fon">Fonte</div>
				<div class="nav_li" id="sut">Suteki</div>
			</div>
			<div class="fonte isine fon">
				<div class="www">
					<div class="tr">
						<div class="trh" style="width:5%">Qty</div>
						<div class="trh" style="width:40%">Menu</div>
						<div class="trh" style="width:25%">Harga</div>
						<div class="trh" style="width:30%">Total</div>
					</div>
					<?php
					$total_fonte=0;
					$trc=0;
					 foreach ($detail_report->result() as $r): ?>
					<?php
					if($trc%2==0) $trs='bk'; else $trs='wt';
					if($r->id_perusahaan==100){
						?>
					<div class="tr <?php echo $trs; ?>">
						<div class="tri" style="width:5%; text-align:center;color:#000;"><?php echo $r->jml_menu;?></div>
						<div class="tri" style="width:40%; text-align:left;color:#000;"><?php echo $r->nama_menu;?></div>
						<div class="tri" style="width:25%; text-align:right; color:#000;"><?php echo 'Rp'.number_format($r->harga,  0, ',', '.');?></div>
						<div class="tri" style="width:30%; text-align:right;color:#000;"><?php echo 'Rp'.number_format($r->total, 0, ',', '.');?></div>
					</div>
						<?php
						$total_fonte=$total_fonte+$r->total;
						$trc++;
						}
						?>
						<?php  endforeach ?>
					<div class="tr" >
						<div style="border-top:1px solid #999; margin-top:10px; text-align:right;color:#000;">
						Total Penjualan Fonte :  <?php echo 'Rp'.number_format($total_fonte, 0, ',', '.'); ?></div> 
					</div>
				</div>
			</div>
			




			<h3>Data Penjualan Suteki</h3>

			<div class="suteki isine fon">
				<div class="www">
					<div class="tr">
						<div class="trh" style="width:5%">Qty</div>
						<div class="trh" style="width:40%">Menu</div>
						<div class="trh" style="width:25%">Harga</div>
						<div class="trh" style="width:30%">Total</div>
					</div>
					<?php
					$total_suteki=0;
					$trc=0;
					 foreach ($detail_report->result() as $r): ?>
					<?php
					if($trc%2==0) $trs='bk'; else $trs='wt';
					if($r->id_perusahaan==127){
						?>
					<div class="tr <?php echo $trs; ?>">
						<div class="tri" style="width:5%; text-align:center;color:#000;"><?php echo $r->jml_menu;?></div>
						<div class="tri" style="width:40%; text-align:left;color:#000;"><?php echo $r->nama_menu;?></div>
						<div class="tri" style="width:25%; text-align:right; color:#000;"><?php echo 'Rp'.number_format($r->harga,  0, ',', '.');?></div>
						<div class="tri" style="width:30%; text-align:right;color:#000;"><?php echo 'Rp'.number_format($r->total, 0, ',', '.');?></div>
					</div>
						<?php
						$total_suteki=$total_suteki+$r->total;
						$trc++;
						}
						?>
						<?php  endforeach ?>
					<div class="tr" ><div style="border-top:1px solid #999; margin-top:10px; text-align:right;color:#000;">
						Total Penjualan Fonte :  <?php echo 'Rp'.number_format($total_suteki, 0, ',', '.'); ?></div> 
					</div>
				</div>
			</div>
		</div>

			<!-- end of content -->
				<?php $servis=0.05*($total_fonte+$total_suteki);
				$penjualan= $total_transaksi-$servis;
				 ?>
		<div id="top">
			<h3>Report <?php echo date('d F Y', strtotime($tgl_submit));?></h3>
			<div id="tit">
				<div class="tr">
					<div class="label">Saldo System  </div>:
					<div class="isi"><?php echo 'Rp '.number_format($dt->total_system, 0, ',', '.');?></div>
				</div>
				<div class="tr">
					<div class="label">Saldo Akhir </div>:
					<div class="isi"> <?php echo 'Rp '.number_format($dt->total_real, 0, ',', '.');?></div>
				</div>
				<div class="tr">
					<div class="label"> Total Penjualan</div>:
					<div class="isi"><?php echo 'Rp '.number_format($penjualan, 0, ',', '.');?></div>
				</div>
				<div class="tr">
					<div class="label"> Total Service </div>:
					<div class="isi"><?php echo 'Rp '.number_format($servis, 0, ',', '.');?></div>
				</div>
				<div class="tr">
					<div class="label">Total Penjualan + Servis </div>:
					<div class="isi"><?php echo 'Rp '.number_format($total_transaksi, 2, ',', '.');?></div>
				</div>
			</div>
		</div>
			<!-- <div class="suteki isine sut">
				<div class="tr">
					<table cellpadding="0" cellspacing="0">

						<tr>
							<th width="50%">Menu</th>
							<th width="20%">Harga</th>
							<th width="10%">Qty</th>
							<th width="20%">Total</th>
						</tr>
						<?php foreach ($detail_report->result() as $r): ?>
							<?php
							$total_per=0;
							if($r->id_perusahaan==127){
								?>
								<tr>
									<td><?php echo $r->nama_menu;?></td>
									<td align="right"><?php echo 'Rp'.number_format($r->harga,  0, ',', '.');?></td>
									<td align="center"><?php echo $r->jml_menu;?></td>
									<td align="right"><?php echo 'Rp'.number_format($r->total, 0, ',', '.');?></td>
								</tr>
								<?php
							}
							?>
						<?php endforeach ?>
					</table>
				</div>
			</div> -->
		</div>
	</div>
</div>



