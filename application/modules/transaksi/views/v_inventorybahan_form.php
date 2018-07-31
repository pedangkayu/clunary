<?php
if($mode=='add'){
	$title = 'Tambah Transaksi Inventory';
}elseif($mode=='edit'){
	$title = 'Edit Transaksi Inventory';
	$dt = $inventorybahan->row();
	$dt_log = $log->row();
	$in_use_to = '';
}elseif($mode=='view'){
	$title = 'View Transaksi Inventory';
	$dt = $inventorybahan->row();
}
?>
<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>
			<?php echo $title;?>
		</div>
		<div class="tools">
			<a class="" href="javascript:;btn_close()" data-original-title="" title=""><font color="white"><b>X</b></font></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form role="form">
			<div class="form-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Jenis Perubahan <font color="orange">(*)</font></label><br>
							<select class="form-control input-xlarge" id="jenis_perubahan" onchange="change_jenisperubahan()" disabled>
								<option value="">- Jenis Perubahan -</option>
								<?php
								$arr_perubahan = array('IN','USE','ADJ','RET', 'SUM');
								foreach ($perubahan->result() as $r) {
									if(in_array($r->id_perubahan, $arr_perubahan)){
										$terpilih = '';
										if($r->id_perubahan==@$dt->jenis_perubahan){
											$terpilih = 'selected';
										}
										echo '<option value="'.$r->id_perubahan.'" '.$terpilih.'>'.$r->id_perubahan.' : '.$r->perubahan.'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6 in_use" style="display:none;">
						<div class="form-group">
							<label class="control-label label_in_use">Dari <font color="orange">(*)</font></label>
							<?php
								if(@$dt->jenis_perubahan=='IN'){
									$in_use_to = @$dt_log->dari;
								}elseif(@$dt->jenis_perubahan=='USE'){
									$in_use_to = @$dt_log->out_to;
								}
							?>
							<input type="text" class="form-control input-xlarge" id="in_use_to" value="<?php echo @$in_use_to;?>" placeholder="Dari" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Bahan <font color="orange">(*)</font></label><br>
							<select class="form-control input-xlarge select2me" id="id_bahan" disabled>
								<option value="">- Nama Bahan -</option>
								<?php
								foreach ($bahan->result() as $r) {
									$terpilih = '';
									if($r->id_bahan == @$dt->id_bahan){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->id_bahan.'" '.$terpilih.'>'.$r->nama_bahan.' - '.$r->alias1.' ('.$r->satuan.')</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Jumlah <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="qty" value="<?php echo @$dt->qty; ?>" placeholder="Jumlah" maxlength="7" disabled>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions right">
				<?php
				$title_closebutton = 'Cancel';
				if($mode=='add'){
					echo '<button type="button" class="btn blue" onclick="insert();">Tambah</button>';
				}elseif($mode=='edit'){
					echo '<button type="button" class="btn green" onclick="update();">Update</button>';
				}elseif($mode=='view'){
					$title_closebutton = 'Close';
				}
				?>
				<button type="button" class="btn default" onclick="btn_close();"><?php echo $title_closebutton;?></button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$('select.select2me').select2({
    placeholder: "Select",
    allowClear: true
});

id = <?php echo json_encode(@$dt->id);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}else if(mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
	$('#jenis_perubahan').prop('disabled', true);
	change_jenisperubahan();
}

function insert () {
	jenis_perubahan = $('#jenis_perubahan').val();
	id_bahan        = $('#id_bahan').val();
	qty             = $('#qty').val();
	in_use_to       = $('#in_use_to').val();
	if(jenis_perubahan=='SUM'){
		if(jenis_perubahan=='' || id_bahan==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi, kecuali Jumlah.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("transaksi/c_inventorybahan/insert");?>', 
															{
																jenis_perubahan:jenis_perubahan,
																id_bahan:id_bahan,
																qty:qty,
															}, 
															function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : 'Transaksi Inventory berhasil ditambahkan.', //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					$('#form_add_edit').attr('style', 'display:none;');
					table_inventorybahan.getDataTable().ajax.reload();
					table_bahanstock.getDataTable().ajax.reload();
				}else{
					NotifikasiToast({
						type : 'error', // ini tipe notifikasi success,warning,info,error
						msg : res.pesan, //ini isi pesan
						title : 'Error', //ini judul pesan
					});
				}
			});
		}
	}else if(jenis_perubahan=='IN' || jenis_perubahan=='USE'){
		if(jenis_perubahan=='' || id_bahan=='' || qty=='' || in_use_to==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("transaksi/c_inventorybahan/insert");?>', 
															{
																jenis_perubahan:jenis_perubahan,
																id_bahan:id_bahan,
																qty:qty,
																in_use_to:in_use_to,
															}, 
															function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : 'Transaksi Inventory berhasil ditambahkan.', //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					$('#form_add_edit').attr('style', 'display:none;');
					table_inventorybahan.getDataTable().ajax.reload();
					table_bahanstock.getDataTable().ajax.reload();
				}else{
					NotifikasiToast({
						type : 'error', // ini tipe notifikasi success,warning,info,error
						msg : res.pesan, //ini isi pesan
						title : 'Error', //ini judul pesan
					});
				}
			});
		}
	}else{
		if(jenis_perubahan=='' || id_bahan=='' || qty==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("transaksi/c_inventorybahan/insert");?>', 
															{
																jenis_perubahan:jenis_perubahan,
																id_bahan:id_bahan,
																qty:qty,
															}, 
															function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : 'Transaksi Inventory berhasil ditambahkan.', //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					$('#form_add_edit').attr('style', 'display:none;');
					table_inventorybahan.getDataTable().ajax.reload();
					table_bahanstock.getDataTable().ajax.reload();
				}else{
					NotifikasiToast({
						type : 'error', // ini tipe notifikasi success,warning,info,error
						msg : res.pesan, //ini isi pesan
						title : 'Error', //ini judul pesan
					});
				}
			});
		}
	}
}

function update () {
	jenis_perubahan = $('#jenis_perubahan').val();
	id_bahan        = $('#id_bahan').val();
	qty             = $('#qty').val();
	in_use_to       = $('#in_use_to').val();
	if(jenis_perubahan=='IN' || jenis_perubahan=='USE'){
		if(jenis_perubahan=='' || id_bahan=='' || qty=='' || in_use_to==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("transaksi/c_inventorybahan/update");?>', 
															{
																id:id,
																jenis_perubahan:jenis_perubahan,
																id_bahan:id_bahan,
																qty:qty,
																in_use_to:in_use_to,
															}, 
															function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : 'Transaksi Inventory berhasil diperbarui.', //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					$('#form_add_edit').attr('style', 'display:none;');
					table_inventorybahan.getDataTable().ajax.reload();
					table_bahanstock.getDataTable().ajax.reload();
				}else{
					NotifikasiToast({
						type : 'error', // ini tipe notifikasi success,warning,info,error
						msg : res.pesan, //ini isi pesan
						title : 'Error', //ini judul pesan
					});
				}
			});
		}
	}else{
		if(jenis_perubahan=='' || id_bahan=='' || qty==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("transaksi/c_inventorybahan/update");?>', 
															{
																id:id,
																jenis_perubahan:jenis_perubahan,
																id_bahan:id_bahan,
																qty:qty,
															}, 
															function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : 'Transaksi Inventory berhasil diperbarui.', //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					$('#form_add_edit').attr('style', 'display:none;');
					table_inventorybahan.getDataTable().ajax.reload();
					table_bahanstock.getDataTable().ajax.reload();
				}else{
					NotifikasiToast({
						type : 'error', // ini tipe notifikasi success,warning,info,error
						msg : res.pesan, //ini isi pesan
						title : 'Error', //ini judul pesan
					});
				}
			});
		}
	}
}

function formatNumber(myElement) { // JavaScript function to insert thousand separators
	var myVal = ""; // The number part
	var myDec = ""; // The digits pars
	// Splitting the value in parts using a dot as decimal separator
	var parts = myElement.value.toString().split(",");
	// Filtering out the trash!
	parts[0] = parts[0].replace(/[^0-9]/g,""); 
	// Setting up the decimal part
	if ( ! parts[1] && myElement.value.indexOf(",") > 1 ) { myDec = ",00" }
	if ( parts[1] ) { myDec = ","+parts[1] }
	// Adding the thousand separator
	// while ( parts[0].length > 3 ) {
	// 	myVal = "."+parts[0].substr(parts[0].length-3, parts[0].length )+myVal;
	// 	parts[0] = parts[0].substr(0, parts[0].length-3)
	// }
	myElement.value = parts[0]+myVal+myDec;
}

function change_jenisperubahan () {
	if($('#jenis_perubahan').val()=='SUM'){
		$('#qty').prop('disabled', true);
		$('.in_use').attr('style', 'display:none;');
	}else if($('#jenis_perubahan').val()=='IN'){
		$('#qty').prop('disabled', false);
		$('.in_use').removeAttr('style');
		$('.label_in_use').html('Dari <font color="orange">(*)</font>');
		$('#in_use_to').attr('placeholder', 'Dari');
	}else if($('#jenis_perubahan').val()=='USE'){
		$('#qty').prop('disabled', false);
		$('.in_use').removeAttr('style');
		$('.label_in_use').html('Untuk <font color="orange">(*)</font>');
		$('#in_use_to').attr('placeholder', 'Untuk');
	}else{
		$('#qty').prop('disabled', false);
		$('.in_use').attr('style', 'display:none;');
	}
}

</script>