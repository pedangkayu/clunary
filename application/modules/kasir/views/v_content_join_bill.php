
<script type="text/javascript">
	$('#close').click(function(){
		$('#pending_bill_list').hide("slow");
	});

	$('.pending_bill_list_item').on('click', function(){
		var tampung = $('#tampung').text(); 
		if (tampung==0){
			var tampung =$(this).val();
			$('#tampung').text(tampung);
			$(this).css('background', '#fff');
		} else {
			if(tampung.contains($(this).val())){
				var remove = tampung.replace($(this).val(),'0');
				$('#tampung').text(remove);
				$(this).css('background', '');
			} else {
				var tampung = tampung + ',' + $(this).val();
				$('#tampung').text(tampung);
				$(this).css('background', '#fff');
			}
		}
		//var rmkoma = tampung.split(',').join(' ');
		awal = $('#id_pesanan_pend').val();
		$('#id_pesanan_pend').val(tampung);
		//alert(tampung);

		// $.post('<?php echo site_url();?>/kasir/c_transaksi/proses_join', {id : tampung}, function(res) {
	});
		$('#add_j').click(function(){
			var tampung=$('#tampung').text();
			// var strtampung = ''
			$.post('<?php echo site_url();?>/kasir/c_transaksi/proses_join/'+tampung, function(res) {
				$('#tampil_list_pending').html(res.hasil);
			});
			$('#pending_bill_list').hide("slow");
		});
</script>


<div id="id_daftar_pending_bill"><b>Daftar Pending Bill</b> </div>
<div id="tampung" hidden></div>

<?php
foreach ($list_pending->result_array() as $r) {
	?>
	<div class="w_btn_pending">
		<button class="pending_bill_list_item" value="<?php echo $r['id_pesanan']; ?>">
			<div><?php echo $r['kode_meja']; ?></div>
			<div><?php echo $r['nama_pemesan']; ?></div>
			<div><?php //echo $r['tagihan']; ?></div>
		</button>
	</div>
	
	<?php
}
?>


<div id="w_adj">
	<div id="add_j">Tambahkan</div>
	<div id="close">Close</div>
</div>
<style type="text/css">
#w_adj {
	position: absolute;
	bottom: 5px;
	right:5px; 

	
}
#add_j, #close{
	clear: both;
	background: #0f0;
	padding: 5px;
	display: inline-block;
	margin: 0px;
	margin-left:5px; 
	cursor: pointer;
	border-radius: 3px;
	text-align: center;
}
</style>