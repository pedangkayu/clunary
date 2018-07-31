<?php
if($mode=='add'){
	$title = 'Tambah satuan Menu';
}elseif($mode=='edit'){
	$title = 'Edit satuan Menu';
	$dt = $satuan->row();
}elseif($mode=='view'){
	$title = 'View satuan Menu';
	$dt = $satuan->row();
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
							<label class="control-label">Kode Satuan <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="kode_satuan" value="<?php echo @$dt->kode_satuan; ?>" placeholder="Kode Satuan" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nama Satuan <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="satuan" value="<?php echo @$dt->satuan; ?>" placeholder="Nama Satuan" disabled>
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
id = <?php echo json_encode(@$dt->id_satuan);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}

function btn_close () {
	$('#form_add_edit').attr('style', 'display:none;');
}

function insert () {
	kode_satuan  = $('#kode_satuan').val();
	satuan  = $('#satuan').val();
	if(kode_satuan=='' || satuan==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_satuan/insert");?>', 
														{
															kode_satuan:kode_satuan,
															satuan:satuan,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'satuan berhasil ditambahkan.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_satuan.getDataTable().ajax.reload();
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
	kode_satuan = $('#kode_satuan').val();
	satuan      = $('#satuan').val();
	if(kode_satuan=='' || satuan==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_satuan/update");?>', 
														{
															id:id,
															kode_satuan:kode_satuan,
															satuan:satuan,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'satuan berhasil diperbarui.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_satuan.getDataTable().ajax.reload();
			}else{
				NotifikasiToast({
					type : 'error', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Error', //ini judul pesan
				});
				$("#form_add_edit").removeAttr('style');
				table_satuan.getDataTable().ajax.reload();
			}
		});
	}
}

</script>