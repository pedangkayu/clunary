<?php
if($mode=='add'){
	$title = 'Tambah Bahan';
}elseif($mode=='edit'){
	$title = 'Edit Bahan';
	$dt = $bahan->row();
}elseif($mode=='view'){
	$title = 'View Bahan';
	$dt = $bahan->row();
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
							<label class="control-label">Nama Bahan <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="nama_bahan" value="<?php echo @$dt->nama_bahan; ?>" placeholder="Nama Bahan" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Kategori <font color="orange">(*)</font></label>
							<select class="form-control" id="id_coa" disabled>
								<option value="">- Kategori -</option>
								<option value="15" <?php echo (@$dt->id_coa==15) ? 'selected' : '';?>>Bahan Makanan</option>
								<option value="16" <?php echo (@$dt->id_coa==16) ? 'selected' : '';?>>Bumbu Makanan</option>
								<option value="17" <?php echo (@$dt->id_coa==17) ? 'selected' : '';?>>Barang Habis Pakai (BHP)</option>
								<option value="23" <?php echo (@$dt->id_coa==23) ? 'selected' : '';?>>Bahan Pokok</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Harga (Rp) <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="harga_bahan" value="<?php echo @$dt->harga_bahan; ?>" placeholder="Harga Bahan (Masukkan Angka)" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Satuan <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="satuan" disabled>
								<option value="">- Satuan -</option>
								<?php
								foreach ($param_satuan->result() as $r) {
									$terpilih = '';
									if($r->kode_satuan==@$dt->satuan){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->kode_satuan.'" '.$terpilih.'>'.$r->satuan.' ('.$r->kode_satuan.')</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Min Stock Alert <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="minimum_stock_alert" value="<?php echo @$dt->minimum_stock_alert; ?>" placeholder="Min Stock Alert (Masukkan Angka)" onkeyup="formatNumber(this)" disabled>
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
id   = <?php echo json_encode(@$dt->id_bahan);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}

function insert () {
	nama_bahan          = $('#nama_bahan').val();
	id_coa              = $('#id_coa').val();
	harga_bahan         = $('#harga_bahan').val();
	satuan              = $('#satuan').val();
	minimum_stock_alert = $('#minimum_stock_alert').val();
	if(nama_bahan=='' || id_coa=='' || harga_bahan=='' || satuan=='' || minimum_stock_alert==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi dan harga harus angka (Gunakan titik sebagai separator).", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_bahan/insert");?>', 
														{
															nama_bahan:nama_bahan,
															id_coa:id_coa,
															harga_bahan:harga_bahan,
															satuan:satuan,
															minimum_stock_alert:minimum_stock_alert,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Bahan berhasil ditambahkan.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_bahan.getDataTable().ajax.reload();
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

function update () {
	nama_bahan          = $('#nama_bahan').val();
	id_coa              = $('#id_coa').val();
	harga_bahan         = $('#harga_bahan').val();
	satuan              = $('#satuan').val();
	minimum_stock_alert = $('#minimum_stock_alert').val();
	if(nama_bahan=='' || id_coa=='' || harga_bahan=='' || satuan=='' || minimum_stock_alert==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi dan harga harus angka (Gunakan titik sebagai separator).", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_bahan/update");?>', 
														{
															id:id,
															nama_bahan:nama_bahan,
															id_coa:id_coa,
															harga_bahan:harga_bahan,
															satuan:satuan,
															minimum_stock_alert:minimum_stock_alert,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Bahan berhasil diperbarui.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_bahan.getDataTable().ajax.reload();
			}else{
				NotifikasiToast({
					type : 'error', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Error', //ini judul pesan
				});
				$("#form_add_edit").removeAttr('style');
				table_bahan.getDataTable().ajax.reload();
			}
		});
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

function btn_close () {
	$('#form_add_edit').attr('style', 'display:none;');
}
</script>