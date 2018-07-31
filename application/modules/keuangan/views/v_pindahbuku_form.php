<?php
if($mode=='add'){
	$title = 'Tambah Pindah Buku';
}elseif($mode=='edit'){
	$title = 'Edit Pindah Buku';
	$dt = $pindahbuku->row();
}elseif($mode=='view'){
	$title = 'View Pindah Buku';
	$dt = $pindahbuku->row();
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
							<label class="control-label">Tgl Transaksi <font color="orange">(*)</font></label>
							<div class="input-group date form_datetime input-xlarge">
								<input type="text" id="date_pindahbuku" size="16" readonly class="form-control" value="<?php echo (@$dt->date_pindahbuku=='') ? '' : date('d M Y - H:i', strtotime(@$dt->date_pindahbuku));?>">
								<span class="input-group-btn">
								<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Pegawai <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="kode_eksekutor" disabled>
								<option value="">- Pegawai -</option>
								<?php
								foreach ($pegawai->result() as $r) {
									$terpilih = '';
									if($r->kode_pegawai==@$dt->kode_eksekutor){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->kode_pegawai.'" '.$terpilih.'>'.$r->nama_lengkap.'</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Sumber <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="source_reg" disabled>
								<option value="">- Sumber -</option>
								<?php
								foreach ($param_coa_ledger->result() as $r) {
									$terpilih = '';
									if($r->nama_rek==@$dt->source_reg){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->nama_rek.'" '.$terpilih.'>'.$r->nama_rek.'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Tujuan <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="destination_reg" disabled>
								<option value="">- Tujuan -</option>
								<?php
								foreach ($param_coa_ledger->result() as $r) {
									$terpilih = '';
									if($r->nama_rek==@$dt->destination_reg){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->nama_rek.'" '.$terpilih.'>'.$r->nama_rek.'</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nominal (Rp) <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="nominal_reg" value="<?php echo @$dt->nominal_reg; ?>" placeholder="Nominal (Masukkan Angka)" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Selisih (Rp) <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="selisih" value="<?php echo @$dt->selisih; ?>" placeholder="Selisih (Masukkan Angka)" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Catatan</label>
							<textarea class="form-control input-xlarge" id="catatan" placeholder="Catatan" readonly><?php echo @$dt->catatan;?></textarea>
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

id   = <?php echo json_encode(@$dt->id_log_coa_ledger);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}

function insert () {
	date_pindahbuku = $('#date_pindahbuku').val();
	kode_eksekutor  = $('#kode_eksekutor').val();
	source_reg      = $('#source_reg').val();
	destination_reg = $('#destination_reg').val();
	nominal_reg     = $('#nominal_reg').val();
	selisih         = $('#selisih').val();
	catatan         = $('#catatan').val();
	if(date_pindahbuku=='' || kode_eksekutor=='' || source_reg=='' || destination_reg=='' || nominal_reg=='' || selisih==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi dan harga harus angka (Gunakan titik sebagai separator).", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("keuangan/c_pindahbuku/insert");?>', 
														{
															date_pindahbuku:date_pindahbuku,
															kode_eksekutor:kode_eksekutor,
															source_reg:source_reg,
															destination_reg:destination_reg,
															nominal_reg:nominal_reg,
															selisih:selisih,
															catatan:catatan,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Data Pindah Buku berhasil ditambahkan.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_pindahbuku.getDataTable().ajax.reload();
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
	date_pindahbuku = $('#date_pindahbuku').val();
	kode_eksekutor  = $('#kode_eksekutor').val();
	source_reg      = $('#source_reg').val();
	destination_reg = $('#destination_reg').val();
	nominal_reg     = $('#nominal_reg').val();
	selisih         = $('#selisih').val();
	catatan         = $('#catatan').val();
	if(date_pindahbuku=='' || kode_eksekutor=='' || source_reg=='' || destination_reg=='' || nominal_reg=='' || selisih==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi dan harga harus angka (Gunakan titik sebagai separator).", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("keuangan/c_pindahbuku/update");?>', 
														{
															id:id,
															date_pindahbuku:date_pindahbuku,
															kode_eksekutor:kode_eksekutor,
															source_reg:source_reg,
															destination_reg:destination_reg,
															nominal_reg:nominal_reg,
															selisih:selisih,
															catatan:catatan,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Data Pindah Buku berhasil diperbarui.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_pindahbuku.getDataTable().ajax.reload();
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

$(".form_datetime").datetimepicker({
    isRTL: Metronic.isRTL(),
    format: "dd MM yyyy - hh:ii",
    autoclose: true,
    todayBtn: true,
    pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
    minuteStep: 1
});
</script>