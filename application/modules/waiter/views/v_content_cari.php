<?php
foreach ($data_menu->result() as $rr) {
	$gambar = 'no-image.jpg';
	if(!empty($rr->gambar_menu)){
		$gambar = $rr->gambar_menu;
	}
	?>
	<div class="col-lg-2 col-sm-3 col-xs-6 col-md-2">
		<div class="product-container">
			<div class="product <?php echo ($rr->flag_hapus==1) ? 'product-ntfnd' : '';?>">
				<span class="product-img">
					<img src="<?php echo base_url().'assets/global/img/flags/jp.png';?>" title="">
					<!-- <!img src="<?php echo base_url().'uploads/menu/'.$gambar;?>" title="Nasi Goreng"> -->
				</span>
				<h4 class="prd-name"><?php echo $rr->nama_menu;?></h4>
				<span class="product-price">Rp <?php echo $rr->harga;?>,-</span>
			</div>
			<?php 
			if($rr->flag_hapus!=1){
				?>
				<div class="list_product" style="display:none;">
					<div class="qty">
						<i class="fa fa-plus qty_plus2"></i><input type="text" class="r" name="qty"><i class="qty_min2 fa fa-minus"></i>
					</div>
					<div class="btn btn-order2" data-kode_menu="<?php echo $rr->kode_menu;?>">
						<i class="fa fa-cutlery"></i>Pesan
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}
?>

<script type="text/javascript">
$('.qty').find('input[type=text]').val(0);

$('.qty_plus2').click(function(event) {
	event.preventDefault();
	qty_sekarang = Number($(this).parent().find('input[type=text]').val())+1;
	$(this).parent().find('input[type=text]').val(qty_sekarang);
});

$('.qty_min2').click(function(event) {
	event.preventDefault();
	qty_sekarang = Number($(this).parent().find('input[type=text]').val())-1;
	if(qty_sekarang<0){
		$(this).parent().find('input[type=text]').val(0);
	}else{
		$(this).parent().find('input[type=text]').val(qty_sekarang);
	}
});

$('.btn-order2').click(function(event) {
	event.preventDefault();
	kode_menu = $(this).data('kode_menu');
	jml_menu = Number($(this).parent().find('input[type=text]').val());
	if(jml_menu<1){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Jumlah menu minimal 1.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url();?>/waiter/c_waiter/add_pesanmenu', {id_pesanan:id_pesanan, kode_menu:kode_menu, jml_menu:jml_menu}, function(res) {
			if(res.stat){
				id_pesanan = res.id_pesanan;
				$(this).parent().find('input[type=text]').val(0);
				table_listorder.getDataTable().ajax.reload();
				update_total_bayar(id_pesanan);
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Menu berhasil ditambahkan.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
			}else{
				alert(res.pesan);
			}
		});
	}
});
</script>