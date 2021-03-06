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
	
});
</script>

<div class="wrapper">
	<div class="_audit">
		<h3>Print Report</h3>
		<div class="tr">
			<!-- <div class="label">Tanggal :</div> -->
		</div>
		<?php
		foreach ($data_report->result_array() as $d) {
			?>
			<div class="tr">
				<form method="post" action="<?php echo site_url();?>/kasir/c_transaksi/report_detail" method="post">

					<input type="text" name="tgl_report" value="<?php echo $d['date_submit'];?>" style="display:none;">

					<div class="label"><?php echo 'Tanggal : '.date('d F Y', strtotime($d['date_submit']));?></div>

					<div class="isi"><button type="submit" class="btn_detail">Detail</button></div>
				</form>
			</div>
			<?php
		}
		?>
	</div>
</div>

<style type="text/css">
div { box-sizing:border-box;}
body{ margin: 0;
	font-family: sans-serif; font-size: 0.8em;
}
.wrapper { width: 100%;background: #fff; padding: 10px; box-sizing:border-box;  position: relative;}

._audit {
	border: 1px solid #333; padding-bottom: 10px;
}
._audit h3 {background: #e5001b; padding: 5px; margin: 0; }
.tr { border:0px solid #f00; overflow: hidden; padding: 0 5px; margin: 5px 0px;}
.label {float: left; width: 70%; border: 1px solid #ccc;}
.isi {float: left; width: 30%; text-align:right; padding: 0 5px;}
.label1 {float: left; width: 40%; padding-left:10px; }
.label2 {float: left; width: 50%; text-align: right;}
._audit input { display: inline-block; width: 100%; text-align: right; padding: 5px; font-size: 1em; font-weight: bolder;}
.saldo_awal { border: none; background: #ccc;}
.tr textarea { width: 100%;  resize:none; min-height: 90px; padding: 5px;   font-size: 1.2em;}
/*.tr button { width: 50%; font-size: 1.5em; line-height: 25px;}*/
.btn_d {width: 100%;}
.notifikasi {
	width: 95%; position: absolute; padding: 10px; text-align: center; font-size: 1em; background: #ccc; box-shadow: 2px 4px 5px #333;
	display:none ;
}

.btn_detail {
	background: #ccc;
}
</style>

