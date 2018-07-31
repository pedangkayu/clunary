<?php
if($mode=='add'){
	$title = 'Tambah Log Belanja';
}elseif($mode=='edit'){
	$title = 'Edit Log Belanja';
	$dt = $log_coa_ledger->row();
}elseif($mode=='view'){
	$title = 'View Log Belanja';
	$dt = $log_coa_ledger->row();
}elseif($mode=='verifikasi'){
	$title = 'Verifikasi Log Belanja';
	$dt = $log_coa_ledger->row();
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
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Tanggal Belanja <font color="orange">(*)</font></label>
						<div class="input-group date date-picker">
							<input type="text" id="date_pindahbuku" class="form-control input-xlarge <?php echo ($mode=='view')? '' : 'datepicker';?>" name="date_pindahbuku" value="<?php echo (@$dt->date_pindahbuku) ? date('d F Y',strtotime(@$dt->date_pindahbuku)) : date('d F Y') ;?>" readonly/> 
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Pegawai Belanja <font color="orange">(*)</font></label>
						<select class="form-control input-xlarge select2me" id="kode_eksekutor" disabled>
							<option value="">- Pegawai Belanja -</option>
							<?php
							foreach ($pegawai->result() as $r) {
								$terpilih = '';
								if($r->jabatan != 'admin' && $r->kode_pegawai==@$dt->kode_eksekutor){
									$terpilih = 'selected';
								}
								if($r->jabatan != 'admin'){
									echo '<option value="'.$r->kode_pegawai.'" '.$terpilih.'>'.$r->nama_lengkap.'</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Selisih (Rp)<font color="orange">(*)</font> </label>
						<input type="text" class="form-control input-large" id="selisih" value="<?php echo @$dt->selisih; ?>" placeholder="Selisih (Masukkan Angka)" onkeyup="formatNumber(this)" readonly>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Catatan<font color="orange">(*)</font> </label>
						<textarea class="form-control input-xlarge" id="catatan" readonly><?php echo @$dt->catatan;?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label"><b>Daftar Belanja</b> </label>
					</div>
				</div>
			</div>
			<div class="row form_bahan" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Bahan <font color="orange">(*)</font></label><br>
						<select class="form-control input-xlarge select2me" id="id_bahan" disabled>
							<option value="">- Nama Bahan -</option>
							<?php
							foreach ($bahan->result() as $r) {
								echo '<option value="'.$r->id_bahan.'">'.$r->nama_bahan.' ('.$r->satuan.')</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Harga Satuan <font color="orange">(*)</font></label>
						<input type="text" class="form-control input-xlarge" id="harga" placeholder="Jumlah (Masukkan Angka)" readonly>
					</div>
					<div class="form-group">
						<label class="control-label">Jumlah <font color="orange">(*)</font></label>
						<input type="text" class="form-control input-xlarge" id="jml_bahan" placeholder="Jumlah (Masukkan Angka)" onkeyup="formatNumber(this)" readonly>
					</div>
				</div>
			</div>
			<div class="row form_bahan" style="display:none;">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
					<button type="button" class="btn blue" onclick="add_item_log();">Tambah</button>
				</div>
			</div>
			<table class="table table-bordered table-hover" id="table_item_log">
				<thead>
				<tr>
					<th>#</th>
					<th>Nama</th>
					<th>Satuan</th>
					<th>Harga</th>
					<th>Jumlah Beli</th>
					<th>Total Harga</th>
					<th>Aksi</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<br>
			<div id="total_belanja_nominal" align="right"><b>Total Belanja : Rp 0</b></div>
		</div>	
		<div class="form-actions right">
			<?php
			if($mode=='add'){
				echo '<button type="button" class="btn default" onclick="btn_close();">Cancel</button>';
				echo '<button type="button" class="btn blue" onclick="save();">Simpan</button>';
			}elseif($mode=='edit'){
				echo '<button type="button" class="btn default" onclick="btn_close();">Close</button>';
				echo '<button type="button" class="btn green" onclick="save();">Update</button>';
			}elseif($mode=='view'){
				echo '<button type="button" class="btn default" onclick="btn_close();">Close</button>';
			}elseif($mode=='verifikasi'){
				echo '<button type="button" class="btn default" onclick="btn_close();">Close</button>';
				echo '<button type="button" class="btn btn-warning" onclick="verifikasi();">Verifikasi</button>';
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
id_log_coa_ledger = 0;
total_belanja_nominal = 0;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
	$('.form_bahan').removeAttr('style');
	if(mode=='edit'){
		id_log_coa_ledger = <?php echo json_encode(@$dt->id_log_coa_ledger);?>;
		update_total_belanja_nominal(id_log_coa_ledger);
	}
}else if(mode=='view' || mode=='verifikasi'){
	id_log_coa_ledger = <?php echo json_encode(@$dt->id_log_coa_ledger);?>;
	update_total_belanja_nominal(id_log_coa_ledger);
}

$('.datepicker').datepicker({
	format: 'dd MM yyyy',
    autoclose: true,
});

$('select.select2me').select2({
    placeholder: "Select",
    allowClear: true
});

function update_total_belanja_nominal (id) {
	$.post('<?php echo site_url();?>/keuangan/c_belanjabahan/update_total_belanja_nominal', {id_log_coa_ledger:id}, function(res) {
		total_belanja_nominal = res.total_belanja_nominal;
		$('#total_belanja_nominal').html('<b>Total Belanja : Rp '+addCommas(total_belanja_nominal)+'</b>');
	});
}

$('#kode_eksekutor').change(function(event) {
	event.preventDefault();
	kode_eksekutor = $(this).val();
	if(kode_eksekutor==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : 'Pegawai Belanja tidak boleh kosong.', //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url();?>/keuangan/c_belanjabahan/change_eksekutor', {id_log_coa_ledger:id_log_coa_ledger, kode_eksekutor:kode_eksekutor}, function(res) {
			if(res.stat){
				id_log_coa_ledger = res.new_id_log_coa_ledger;
				table_item_log.getDataTable().ajax.reload();
			}
		});
	}
});

$('#id_bahan').change(function(event) {
	event.preventDefault();
	if(id_log_coa_ledger==0){
		alert('Tanda (*) wajib diisi.');
	}else{
		id_bahan = $('#id_bahan').val();
		$.post('<?php echo site_url("keuangan/c_belanjabahan/cek_bahan");?>', {id_log_coa_ledger:id_log_coa_ledger, id_bahan:id_bahan}, function(res) {
			if(res.jml>0){
				alert('Bahan tersebut sudah ada.');
				$('#id_bahan').val('');
			}
		});
	}
});

function btn_close () {
	if(mode=='add'){
		if(id_log_coa_ledger==0){
			$('#form_add_edit').attr('style', 'display:none;');
		}else{
			var sure = confirm('Apakah Anda yakin menghapus bahan belanja ini?');
			if(sure){
				$.post('<?php echo site_url();?>/keuangan/c_belanjabahan/delete_permanent', {id_log_coa_ledger: id_log_coa_ledger}, function(res) {
					delete table_item_log;
					table_logbelanja.getDataTable().ajax.reload();
					$('#form_add_edit').attr('style', 'display:none;');
				});
			}
		}
	}else{
		delete table_item_log;
		table_logbelanja.getDataTable().ajax.reload();
		$('#form_add_edit').attr('style', 'display:none;');
	}
}

function add_item_log () {
	if(id_log_coa_ledger==0){
		alert('Tanda (*) tidak boleh kosong.');
	}else{
		id_bahan  = $('#id_bahan').val();
		jml_bahan = $('#jml_bahan').val();
		harga     = $('#harga').val();
		if(id_bahan=='' || jml_bahan=='' || harga==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Bahan dan Jumlah Bahan wajib diisi", //ini isi pesan
				title : 'warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("keuangan/c_belanjabahan/insert_item_log");?>', {id_log_coa_ledger:id_log_coa_ledger, id_bahan:id_bahan, harga:harga, jml_bahan:jml_bahan}, function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : "Data Bahan berhasil ditambahkan.", //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					table_item_log.getDataTable().ajax.reload();
					update_total_belanja_nominal(id_log_coa_ledger);
					$('#id_bahan').val('');
					$('#harga').val('');
					$('#jml_bahan').val('');
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

function btn_delete_item_log (id) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
	if (sure) {
		$.post('<?php echo site_url(); ?>/keuangan/c_belanjabahan/delete_item_log?id='+id, {}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Bahan berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_item_log.getDataTable().ajax.reload();
			}
		});
	}
}

function save () {
	if(id_log_coa_ledger==0){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		date_pindahbuku = $('#date_pindahbuku').val();
		kode_eksekutor     = $('#kode_eksekutor').val();
		selisih    = $('#selisih').val();
		catatan     = $('#catatan').val();
		if(date_pindahbuku=='' || kode_eksekutor=='' || selisih==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url();?>/keuangan/c_belanjabahan/cek_item_log', {id_log_coa_ledger: id_log_coa_ledger}, function(res) {
				if(res.jml==0){
					NotifikasiToast({
						type : 'warning', // ini tipe notifikasi success,warning,info,error
						msg : "Anda belum memasukkan bahan belanja (min 1).", //ini isi pesan
						title : 'Warning', //ini judul pesan
					});
				}else{
					$.post('<?php echo site_url("keuangan/c_belanjabahan/update");?>', 
																	{
																		id_log_coa_ledger:id_log_coa_ledger,
																		date_pindahbuku:date_pindahbuku,
																		kode_eksekutor:kode_eksekutor,
																		selisih:selisih,
																		catatan:catatan,
																	}, 
																	function(res) {
						if(res.stat){
							NotifikasiToast({
								type : 'success', // ini tipe notifikasi success,warning,info,error
								msg : 'Log Belanja berhasil diperbarui.', //ini isi pesan
								title : 'Success', //ini judul pesan
							});
							delete table_item_log;
							$('#form_add_edit').attr('style', 'display:none;');
							table_logbelanja.getDataTable().ajax.reload();
						}else{
							NotifikasiToast({
								type : 'error', // ini tipe notifikasi success,warning,info,error
								msg : res.pesan, //ini isi pesan
								title : 'Error', //ini judul pesan
							});
						}
					});
				}
			});
		}
	}
}

function verifikasi () {
	var sure = confirm('Apakah Anda yakin Verifikasi Log Belanja ini.');
	if(sure){
		$.post('<?php echo site_url();?>/keuangan/c_belanjabahan/verifikasi', {id_log_coa_ledger:id_log_coa_ledger}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Data Log Belanja berhasil diverifikasi', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				delete table_item_log;
				$('#form_add_edit').attr('style', 'display:none;');
				table_logbelanja.getDataTable().ajax.reload();
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

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}



table_item_log = new Datatable();
table_item_log.init({
    src: $("#table_item_log"),
    onSuccess: function (grid, response) {
        // grid:        grid object
        // response:    json object of server side ajax response
        // execute some code after table records loaded
    },
    onError: function (grid) {
        // execute some code on network or other general error  
    },
    onDataLoad: function(grid) {
        // execute some code on ajax data load
    },
    loadingMessage: 'Loading...',
    dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
        // So when dropdowns used the scrollable div should be removed. 
        //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
        "processing": true,
        "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
        "sDom": "Rfprltpi",
        "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"] // change per page values here
        ],
        "pageLength": 10, // default record count per page
        "ajax": {
            "url": "<?php echo site_url() ?>/keuangan/c_belanjabahan/get_item_log", // ajax source
            data: function (d) {
            	d.id_log_coa_ledger = id_log_coa_ledger;
            	d.mode = mode;
            }
        },
        "columns": [
	        {"orderable": false},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
			{"orderable": false}
	    ],
        "order": [
            [1, "asc"]
        ]// set first column as a default sort by asc
    }
});
</script>