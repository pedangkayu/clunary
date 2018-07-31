<?php
function rupiah($data='')
	{
		$rupiah = "";
		$jml    = strlen($data);

		while($jml > 3){
			$rupiah = ".".substr($data,-3).$rupiah;
			$l      = strlen($data)-3;
			$data   = substr($data,0,$l);
			$jml    = strlen($data);
		}
		$rupiah = $data.$rupiah;
		return $rupiah;
	}
?>
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


	$('#saldo_akhir').keyup(function(){
		var saldo_akhir = parseInt($('#saldo_akhir').val());
		var total_kas_sistem = parseInt($('#total_kas_sistem').val());
		var selisih = saldo_akhir-total_kas_sistem;
		$('#selisih').val(selisih);
	
	});
	
});
</script>

<div class="wrapper">
	<div class="_audit">
		<h3>Close Audit </h3>
		<form action="<?php echo site_url();?>/kasir/c_transaksi/save_close" method="post" target="_top">
			<?php
			$dt = $data_audit->row_array();
			$saldo_awal	=	$dt['saldo_awal'];
			$id_audit	=	$dt['id_audit'];
			?>
			<input type="hidden" name="id_audit" value="<?php echo $id_audit; ?>">
			<div class="tr">
				<div class="label">Saldo Awal</div>
				<div class="isi">
					<input class="saldo_awal" value="<?php echo $saldo_awal; ?>"type="hidden" name="saldo_awal" >
					<input class="saldo_awal" value="<?php echo rupiah($saldo_awal); ?>"type="text" readonly>
				</div>
			</div>
			<?php
			$d2 = $data_close->row_array();
			$jumlah_transaksi=$d2['jumlah_transaksi'];
			$pay_diterima =$d2['pay_diterima'];
			$pay_kembali=$d2['pay_kembali'];
			
			$kembalian = ($pay_diterima-$jumlah_transaksi)-$pay_kembali;
			$pemasukanbysistem=($jumlah_transaksi+$saldo_awal)+$kembalian;
			?>
			<div class="tr">
				<div class="label">Jumlah Semua Transaksi</div>
				<div class="isi">
					<input class="saldo_awal" value="<?php echo $jumlah_transaksi; ?>" type="hidden" name="jumlah_trans">
					<input class="saldo_awal" value="<?php echo rupiah($jumlah_transaksi); ?>" type="text" readonly>
				</div>
			</div>

			<?php
			for ($i=0; $i < count($ar_payment); $i++) { 
				?>
				<div class="tr">
					<div class="label">
						<div class="label1">-<?php echo $ar_payment[$i]['payment_method'];?></div>
						<div class="label2">(<?php echo rupiah($ar_payment[$i]['count_cash']); ?>)</div>
						<div class="label3"><?php echo rupiah($ar_payment[$i]['sum_total_after_tax']); ?></div>
					</div>
					<div class="isi">

					</div>
				</div>
				<?php
			}
			?>
			
			
			
			<div hidden class="tr" style="display:;">
				<div class="label">Kurang/Lebih Kembalian</div>
				<div class="isi"><input value="<?php echo $kembalian; ?>" readonly class="saldo_awal">
				</div>
			</div>
			
			<div class="tr">
				<div class="label">Perhitungan di Sistem</div>
				<div class="isi">
					<input type="text" value="<?php echo rupiah($pemasukanbysistem); ?>" readonly class="saldo_awal">
					<input name="total_kas_sistem" type="hidden" id="total_kas_sistem" value="<?php echo $pemasukanbysistem; ?>" readonly class="saldo_awal">
				</div>
			</div>
			
			<div id="total_payonline" style="display:none;"><?php echo $total_payment; ?></div>		
			
			<div class="tr">
				<div class="label">Total Kas di kasir</div>
				<div class="isi"><input id="saldo_kasir" value="<?php echo rupiah($saldo_awal+$ar_payment[0]['sum_total_after_tax']);?>" readonly></div>
			</div>
			
			<div class="tr">
				<div class="label">Saldo Akhir/Real</div>
				<div class="isi">
					<input name="saldo_akhir" id="saldo_akhir">
				</div>
			</div>
			
			<div class="tr">
				<div class="label">Selisih</div>
				<div class="isi"><input name="selisih" id="selisih">
				</div>
			</div>
			
			<div class="tr">
					<div>note * :</div><textarea name="note"></textarea>
			</div>

			<input type="hidden" name="id_audit" value="<?php echo $id_audit; ?>">
			<?php
			for ($i=0; $i < count($ar_payment); $i++) { 
				?>
				<input type="hidden" name="method[]" value="<?php echo $ar_payment[$i]['payment_method']; ?>">
				<input type="hidden" name="count[]" value="<?php echo $ar_payment[$i]['count_cash']; ?>">
				<input type="hidden" name="nomin[]" value="<?php echo $ar_payment[$i]['sum_total_after_tax']; ?>">
				<?php
			}
			?>

			<div class="tr">
				<button name="save_close">Simpan</button>
			</div>
		</form>
		<form action="<?php echo site_url();?>/kasir/c_transaksi/print_report_sementara" method="post" target="_top">
			<input type="hidden" name="tgl_submit" value="<?php echo date('Y-m-d', strtotime($dt['date_submit']))?>">
			<div class="tr">
				<button name="save_close">Print Report Sementara</button>
			</div>
		</form>
		<div class="tr">
			<button id="export_cost_menu">Download Cost Menu Penjualan</button>
		</div>
	</div>
</div>

<script type="text/javascript">
$('#export_cost_menu').click(function (e) { 
	e.preventDefault();
    id_audit = <?php echo json_encode($dt['id_audit']);?>;
	location.replace("<?php echo site_url(); ?>kasir/c_transaksi/export?id_audit="+id_audit); 
});
</script>

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
.label {float: left; width: 70%;}
.isi {float: left; width: 30%; text-align: right; padding: 0 5px;}
.label1 {float: left; width: 30%; padding-left:10px; }
.label2 {float: left; width: 20%; text-align: right;}
.label3 {float: left; width: 50%; text-align: right;}
._audit input { display: inline-block; width: 100%; text-align: right; padding: 5px; font-size: 1em; font-weight: bolder;}
.saldo_awal { border: none; background: #ccc;}
.tr textarea { width: 100%;  resize:none; min-height: 90px; padding: 5px;   font-size: 1.2em;}
.tr button { width: 100%; font-size: 1.5em; line-height: 25px;}
.btn_d {width: 100%;}
.notifikasi {
	width: 95%; position: absolute; padding: 10px; text-align: center; font-size: 1em; background: #ccc; box-shadow: 2px 4px 5px #333;
	display:none ;
}
</style>

