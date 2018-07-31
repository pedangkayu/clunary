<?php
$sumharga = 0;
foreach ($list_to_join->result() as $dt_join) {
	$sumharga += $dt_join->sumharga;
}
  //echo $sumharga;
?>
<script type="text/javascript">
function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');
}
	var tp= parseInt($('#total_pending').text());
	var tpx= parseInt(<?php echo json_encode($sumharga);?>);
	var gt= parseInt($('#total_order').val());
	var total_join = tpx+gt;
	var total_joinxxxx = tp+parseInt($('#total_bayar').val());
	var tx = total_join*0.1;

	//var servis = total_join*0.05;
	var servis = total_join*0;
	//alert(total_join);

	$('#totale').text(total_joinxxxx);
	$('#totale_h').text(convertToRupiah(total_joinxxxx));

	$('#nilaitax').text(tx);

	$('#nilaiservice').text(servis);
	$('#nilaiservice_h').text(convertToRupiah(servis));

	$('.service_fee_price').val(servis);

	$('#gtotal1').val(convertToRupiah(total_joinxxxx+servis));
	$('#gtotal2').val(total_joinxxxx+servis);
	$('#gtotal22').val(total_joinxxxx+servis);
</script>



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
	
<div class="lis1">
	<div class="tdd nop ff">ID</div>
	<div class="tdd nap ff">Nama Pemesan</div>
	<div class="tdd tag ff">Tagihan</div>
	<br>
	<?php
	$ttp=0;
	foreach ($list_to_join->result_array() as $result) {
		?>
			<div class="tdd nop"><?php echo $result['id_pesanan']; ?></div>
			<div class="tdd nap"><?php echo $result['nama_pemesan']; ?></div>
			<div class="tdd tag"><?php echo rupiah($result['sumharga']); ?></div>
			<br>
		<?php
		$ttp=$ttp+$result['sumharga'];
	}
	?>
</div>



<div class="w_total_xx">
	<div id="jsp" style="display:none">Total Pending Bill : <b id="total_pending"><?php echo $ttp; ?></b></div>
	<div id="jsp">Total Pending Bill : <b id="total_pending_h"><?php echo rupiah($ttp); ?></b></div>
</div>

<style type="text/css">
	.w_total_xx { text-align: ; border-top: 1px solid#999; margin: 0 0%; width: 100%; display: block; background: ; }
</style>