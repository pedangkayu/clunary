<?php
$dt = $data_utama->row_array();
?>
<html>
<head>
	<title>Print Order</title>
<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        window.print();
        document.location.href = '<?php echo site_url("kasir/c_kasir/index/2");?>';
        setTimeout("closePrintView()", 3000);
    });
    //function closePrintView() {
        
</script>
</head>
<body>
	<div class="wrapper">
		<div class="header_bill">
			<div class="title"><h3><?php echo $resto_nama;?></h3><p><?php echo $resto_alamat;?>. Telp : <?php echo $resto_telp;?></p></div>
		</div>
		<div class="isi_bill">
			<div class="id_bill">
				<?php echo $dt['id_pesanan'].'|'.$dt['kode_pemesanan']; ?> <br>
				<?php echo $dt['submit_pada']; ?> | cashier :<?php echo $dt['submit_oleh'].'  Meja :'.$dt['kode_meja']; ?>
			</div>
			<h3>Order To Kitchen</h3>
			<div class="customer"> Mr/Mrs : <?php echo $dt['nama_pemesan'];?></div>
			<div class="th">
				<div class="qty">qty</div>
				<div class="item">item</div>
			</div>
			<?php
			foreach ($detail_pesanan->result_array() as $data) {
				?>
				<div class="tr">
					<div class="qty"> <?php echo $data['qty']; ?> </div>
					<div class="item"><?php echo $data['nama_menu']; ?></div>
				</div>	
				<?php
			}
			?>
			
 
			<br><br>
			<div class="line"></div>
			<div class="notes"> catatan : <br><?php echo $dt['note']; ?> </div>
		</div>
		<div class="footer_bill">
			
		</div>
	</div>
</body>
</html>

<style type="text/css">

body {width: 7.6cm; border:1px solid #f00; margin: 0; padding: 0.3cm; box-sizing:border-box; font-family: sans-serif; font-size: 0.8em;}
.wrapper {
	width: 100%; border:0px solid #0f0; margin: 0; padding:0; box-sizing:border-box;
}
.header_bill {
	background: ; overflow: hidden;
	padding: 5px;
	margin-bottom: 3px;
	border-bottom: 1px solid #666;
}
.title{ float: left; width: 100%; padding-left: 5px; box-sizing:border-box; text-align: center;}
.title h3{ margin:0; padding: 0; font-size: 1.2em; }
.title p { margin: 0; padding: 0;}

.isi_bill { }
.id_bill { font-size: 0.9em; text-align: left; font-weight: normal; padding:3px; border-bottom: 1px solid #666; margin-bottom: 3px;}

.th { background: ; overflow: hidden; padding: 3px; font-weight:bold;}
.tr { overflow: hidden; padding: 0px 5px;}
.qty { width: 10%; float: left;}
.item { width: 85%; float: left;}
.line { border-bottom: 1px solid #666; margin: 3px 0;}

.customer {
	padding: 5px 3px 3px 3px;
	font-weight: bold;
	border-bottom: 1px solid #666;
	margin-bottom: 3px;
}

.tb { text-align: right; padding: 0 3px;}
.tb label {  display: inline-block; width: 20%;}


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