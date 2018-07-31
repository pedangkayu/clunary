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
 

<?php
$dt = $data_utama->row_array();
$dtt = $data_pesanan_semua->row_array();
?>
<html>
<head>
	<title>Print Bill</title>

<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        window.print();
		SubmitMe();
        document.location.href = '<?php echo site_url("kasir/c_kasir/index/2");?>';
        setTimeout("closePrintView()", 90000);
    });
    //function closePrintView() {}
        
</script>

 



</head>
<body>
	<div class="wrapper">
		<div class="header_bill">
			<div class="title">
			<img src="<?php echo base_url();?>assets_kasir/image/printlogo.gif" width="105%">
			<!-- h3><?php echo $resto_nama;?></h3>
		    <p><?php echo $resto_alamat;?> <br> Telp : <?php echo $resto_telp;?></p -->
			</div>

		</div>
		<div class="isi_bill">
			<div class="id_bill">
				<?php echo 'Kode : '.$dt['kode_pemesanan'].' <br> Kasir : '.$dt['submit_oleh']; ?> 
				<?php echo $dt['submit_pada']; ?> <br> <?php echo '  Meja : '.$dt['kode_meja']; ?> &middot; <?php echo '  No. Nota : '.$dt['counter_nota']; ?>
			</div>

			<div class="customer"> Mr/Mrs : <?php echo $dt['nama_pemesan'];?></div>
			<div class="th">
				<div class="qty">qty</div>
				<div class="item" style="text-align:center">item</div>
				<div class="price" align="right">price</div>
			</div>
			<?php
			foreach ($data_pesanan_menu_semua->result_array() as $data) {
				?>
				<div class="tr">
					<div class="qty"><?php echo $data['jml']; ?></div>
					<div class="item"><?php echo $data['nama_menu']; ?></div>
					<?php
					if($data['discount']==0){
						?>
						<div class="price" align="right"><?php echo rupiah($data['jml']*$data['harga']); ?></div>
						<?php
					}else{
						?>
						<div class="price" align="right"></div>
						<?php
					}
					?>
				</div>
				<?php
				if($data['discount']!=0){
					?>
					<div class="tr">
						<div class="qty"></div>
						<div class="item" align="right"><i><?php echo $data['jml']*$data['harga']; ?> - <?php echo $data['discount']; ?>%</i></div>
						<div class="price" align="right"><i><?php echo rupiah($data['jml']*$data['subtotal']); ?></i></div>
					</div>
					<?php
				}
			}
			?>
			<div class="line"></div>
			<div class="tb">
				<div class="total">total : <label><?php echo rupiah($dtt['total_biaya']); ?></label></div>
  				<!-- div class="tax">Tax <?php echo $dtt['tax']*100; ?>% : <label><?php echo rupiah($dtt['tax_price']); ?></label></div -->
  				<!-- div class="servis">Servis % : <label><?php echo rupiah($dtt['service']); ?></label></div -->
				<div class="servis" style="font-style: italic; font-size: 0.8em;">Diskon <?php echo rupiah($dtt['discount_promo_fonte']); ?> % : <label> (<?php echo rupiah($dtt['nilai_discount_promo_fonte']); ?>)</label></div>
				<!-- div class="disc">Disc Promo <?php echo $dtt['discount_promo'];?>% : 
				<label><?php echo rupiah($dtt['nilai_discount_promo_suteki']);?></label></div -->
				<div class="gtotal">total akhir : <label><?php echo rupiah($dtt['total_biaya_after_tax']); ?></label></div>
				<div class="pay">dibayar : <label><?php if($dtt['pay']<=0) echo ''; else echo rupiah($dtt['pay']); ?></label></div>
				<div class="kembali">kembali : <label><?php if($dtt['kembali']<0) echo ''; else echo rupiah($dtt['kembali']); ?></label></div>
				<div class="kembali" style="font-size: 0.8em;">cara bayar : <label><?php if($dtt['pay']<0) echo ''; else echo ($dtt['payment_method']); ?></label></div>
			</div>
			<div class="line"></div>
		</div>
		<div class="footer_bill">
			<p>Hatur Nuhun..</p>
			<p><?php echo $resto_website;?></p>
		</div>
	</div>
</body>
</html>

<style type="text/css">

 


body {width: 5.6cm; margin: 0; padding: 0.2cm; box-sizing:border-box; font-family: sans-serif; font-size: 0.8em;}
.wrapper {
	width: 100%; border:0px solid #0f0; margin: 0; padding:0; box-sizing:border-box;
}

.header_bill {
	 
    background-repeat:   no-repeat;
    background-position: left; 
	height: 80px;
	overflow: hidden;
	padding: 5px;
	margin-bottom: 3px;
	border-bottom: 1px solid #666;
}

.title{ float: left; width: 100%; padding-left: 0px; box-sizing:border-box; text-align: center;}
.title h3{ margin:0; padding: 0; font-size: 1.2em; }
.title p { margin: 0; padding: 0;}

.isi_bill { }
.id_bill { font-size: 0.9em; text-align: left; font-weight: normal; padding:3px; border-bottom: 1px solid #666; margin-bottom: 3px;}

.th { background: ; overflow: hidden; padding: 3px; font-weight:bold;}
.tr { overflow: hidden; padding: 0px 5px;}
.qty { width: 10%; float: left;}
.item { width: 60%; float: left;}
.line { border-bottom: 1px solid #666; margin: 3px 0;}

.customer {
	padding: 5px 3px 3px 3px;
	font-weight: bold;
	border-bottom: 1px solid #666;
	margin-bottom: 3px;
}

.tb { text-align: right; padding: 0 3px;}
.tb label {  display: inline-block; width: 30%;}


.footer_bill { padding-top:10px;}
.footer_bill p {
	margin: 0; padding: 0; text-align: center;
}
.notes {
	clear: both;
	border: 0px solid #000;
	text-align: left;
	font-style: italic;
	padding: 2%;
	border: 1px solid #333;
}
h3 {
	margin: 0; padding: 0;
}
</style>