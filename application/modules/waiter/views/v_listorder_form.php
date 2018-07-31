<?php
$dt_ls = $listorder->row(); 
?>
<!-- MODAL TAMBAH -->
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" onclick="event.preventDefault();btn_close_update_listorder();">X</button>
			<h4 class="modal-title">
				Edit Jumlah Pesanan
			</h4>
		</div>
		<div class="modal-body">
			<div class="form-body">
				<form class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">Menu</label>
							<div class="col-md-5">
								<?php echo $dt_ls->nama_menu;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Harga</label>
							<div class="col-md-5">
								<?php echo $dt_ls->harga;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Jumlah</label>
							<div class="col-md-5">
								<select class="form-control" id="jml_menu_listorder">
									<?php
									for ($i=1; $i <= 100; $i++) {
										$terpilih = '';
										if($i==$dt_ls->jml_menu){
											$terpilih = 'selected';
										}
										echo '<option value="'.$i.'" '.$terpilih.'>'.$i.'</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</form>
				<button type="button" class="btn blue" onclick="btn_update_listorder()">Update</button>
			</div>
		</div>
		<div class="modal-footer">
			
		</div>
	</div>
</div>

<script type="text/javascript">

function btn_close_update_listorder () {
	$('#modal_edit_listorder').modal('hide');
}

function btn_update_listorder () {
	id_pesanan_listorder = <?php echo json_encode($dt_ls->id_pesanan);?>;
	kode_menu_listorder = <?php echo json_encode($dt_ls->kode_menu);?>;
	jml_menu_listorder = $('#jml_menu_listorder').val();
	$.post('<?php echo site_url();?>/waiter/c_waiter/update_listorder', {id_pesanan:id_pesanan_listorder, kode_menu:kode_menu_listorder, jml_menu:jml_menu_listorder}, function(res) {
		if(res.stat){
			table_listorder.getDataTable().ajax.reload();
			update_total_bayar(id_pesanan_listorder);
			NotifikasiToast({
				type : 'success', // ini tipe notifikasi success,warning,info,error
				msg : "Menu berhasil diupdate.", //ini isi pesan
				title : 'Success', //ini judul pesan
			});
			$('#modal_edit_listorder').modal('hide');
		}else{
			alert(res.pesan);
		}
	});
}
</script>