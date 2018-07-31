<?php
function rupiah($data) {
  $rupiah = "";
  $jml    = strlen($data);

  while($jml > 3)
  {
     $rupiah = ".".substr($data,-3).$rupiah;
     $l      = strlen($data)-3;
     $data   = substr($data,0,$l);
     $jml    = strlen($data);
  }
  $rupiah =$data.$rupiah;
  return $rupiah;
}
?>
<html>
<head>
	<title>lihat audit</title>
	
	<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#cetak').click(function(){
				window.print();

			});
		});
	</script>
</head>
<body>
	<div id="wrapper">
		<?php if($st==1) { ?>
		<table class="tb1" border="0" cellspacing="0" celladding="0">
			<tr>
				<th width="10%">ID</th>
				<th width="40%">Open Time</th>
				<th width="40%">Close Time</th>
				<th width="10%"></th>
			</tr>
			<?php foreach ($lihat_audit->result_array() as $rw){ ?>
			<tr>
				<td> <?php echo $rw['id_audit'];?></td>
				<td> <?php echo $rw['date_submit']; ?> </td>
				<td><?php echo $rw['date_modify']; ?></td>
				<?php $id = $rw['id_audit']; ?>
				<td><a href="<?php echo site_url().'/kasir/c_transaksi/lihat_audit_detail/'.$id;?>">detail</a></td>
			</tr>
			<?php } ?>
		</table>

		<?php }
		else {?>
			<?php $det = $detail_audit->row_array(); ?>
			<table class="tb2" border="0" cellspacing="0" celladding="0" style="margin-top:50px;">
				<tr>
					<td colspan="3"><h3>Detail Data Audit</h3></td>
				</tr>
				<tr>
					<td><b>Open Audit</b></td>
					<td colspan="2" align="right"> <?php echo $det['date_submit']; ?> </td>
				</tr>
				<tr>
					<td><b>Close Audit</b></td>
					<td colspan="2" align="right"> <?php echo $det['date_submit']; ?></td>
				</tr>
				<tr>
					<td><b>Audit Oleh</b></td>
					<td align="right" colspan="2"> <?php echo $det['kode_pegawai']; ?></td>
				</tr>
				<tr>
					<td><b>Saldo Awal</b></td>
					<td align="right" colspan="2"> <?php echo rupiah($det['saldo_awal']); ?></td>
				</tr>
				<tr>
					<td><b>Saldo System</b></td>
					<td align="right" colspan="2"> <?php echo rupiah($det['saldo_system']); ?></td>
				</tr>
				<tr>
					<td><b>Saldo Akhir</b></td>
					<td align="right" colspan="2"> <?php echo rupiah($det['saldo_akhir']); ?></td>
				</tr>
				<tr>
					<td><b>Selisih</b></td>
					<td colspan="2" align="right"> <?php echo rupiah($det['selisih']); ?></td>
				</tr>
				<tr>
					<td><b>Catatan</b></td>
					<td align="right" colspan="2"> <?php echo $det['catatan']; ?></td>
				</tr>
				<tr><td colspan="3"><h4>Detail Pendapatan </h4></td></tr>
				<tr>
					<th>Jenis</th>
					<th>Jumlah</th>
					<th>Total</th>
				</tr>

				<?php foreach($list_income->result_array() as $k){?>
				<tr>
					<td><?php echo $k['payment_method']; ?></td>
					<td align="center"><?php echo $k['jumlah_trans']; ?></td>
					<td align="right"><?php echo rupiah($k['total_trans']); ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2" align="right">Total Pendapatan</td>
					<td align="right"><?php echo rupiah($det['saldo_system']-$det['saldo_awal']); ?></td>
				</tr>

				<tr>
					<td colspan="3"><a id="cetak">Cetak</a><a href="">Kembali</a></td>
				</tr>
			</table>
		
		<?php }
		 ?>

	</div>

</body>
</html>
<style type="text/css">
body {
	margin:0; padding: 0; font-size: 0.8em; font-family: sans-serif;
	box-sizing:border-box;
}
#wrapper {
	width: 100%;
	box-sizing:border-box;
	margin-top: 5px;
}
.tb1 {
	width: 95%;
	margin: 0 auto;
	box-sizing:border-box;
	font-size: 1em;

}
.tb1 th {
	box-sizing:border-box;
	background: #666;
	color: #fff;
	font-weight: bolder;
	padding: 5px 0;
}
.tb1 a {
	text-decoration: none;
	color :#666;
	display: inline-block;
	padding: 5px;
	margin: 2px 2px 2px 2px;
	border: 1px solid #666;
}

.tb2 {
	width: 8cm;
	font-size: 1em;
	margin: 0 auto;

}
.tb2 h4 {
	/*background: #666;*/
	color: #000;
	font-weight: bolder;
	padding: 4px;
	margin:0;
	margin-top: 5px;
	border-bottom: 1px solid #000;
}
.tb2 a {
	text-decoration: none;
	color :#666;
	display: inline-block;
	padding: 5px;
	margin: 10px 2px 2px 2px;
	border: 1px solid #666;
	cursor: pointer;
}
.tb2 a:hover {
	background: #666;
	color:#000;
}
</style>
