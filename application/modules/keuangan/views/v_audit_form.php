<?php
if($mode=='edit'){
	$title = 'Edit Audit';
	$dt = $audit->row();
}elseif($mode=='view'){
	$title = 'View Audit';
	$dt = $audit->row();
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
						<label class="control-label">Pegawai</label>
						<input type="text" class="form-control input-xlarge" id="jml_bahan" value="<?php echo $dt->nama_lengkap.' ('.$dt->kode_pegawai.')';?>" readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Open</label>
						<input type="text" class="form-control input-xlarge" id="jml_bahan" value="<?php echo date('d F Y (H:i)',strtotime($dt->date_submit));?>" readonly>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Close</label>
						<input type="text" class="form-control input-xlarge" id="jml_bahan" value="<?php echo date('d F Y (H:i)',strtotime($dt->date_modify));?>" readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Saldo Awal</label>
						<input type="text" class="form-control input-large form_edit" id="saldo_awal" value="<?php echo ($mode=='view') ? 'Rp '.number_format($dt->saldo_awal, 2, ',', '.') : $dt->saldo_awal;?>" onkeyup="formatNumber(this);change_saldoawal()" readonly>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label"><?php echo ($mode=='edit') ? 'Saldo Sistem (Saldo Awal + Total Transaksi)' : 'Saldo System';?></label>
						<input type="text" class="form-control input-large" id="saldo_system" value="<?php echo ($mode=='view') ? 'Rp '.number_format($dt->saldo_system, 2, ',', '.') : $dt->saldo_system;?>" onkeyup="change_saldoakhir()" readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Saldo Akhir</label>
						<input type="text" class="form-control input-large form_edit" id="saldo_akhir" value="<?php echo ($mode=='view') ? 'Rp '.number_format($dt->saldo_akhir, 2, ',', '.') : $dt->saldo_akhir;?>" onkeyup="formatNumber(this);change_saldoakhir()" readonly>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label"><?php echo ($mode=='edit') ? 'Selisih (Saldo Akhir - Saldo System)' : 'Selisih';?></label>
						<input type="text" class="form-control input-large" id="selisih" value="<?php echo ($mode=='view') ? 'Rp '.number_format($dt->selisih, 2, ',', '.') : $dt->selisih;?>" readonly>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label"><b>Detail Pesanan Menu</b></label>
					</div>
				</div>
			</div>
			<table class="table table-bordered table-hover" id="table_audit_detail_pesanan">
				<thead>
				<tr>
					<th>#</th>
					<th>Nama Menu</th>
					<th>Harga (Rp)</th>
					<th>Jml Menu</th>
					<th>Total (Rp)</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<br>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label"><b>Total Detail</b></label>
					</div>
				</div>
			</div>
			<table class="table table-bordered table-hover" id="table_audit_detail">
				<thead>
				<tr>
					<th>#</th>
					<th>Payment Method</th>
					<th>Jml Transaksi</th>
					<th>Total (Rp)</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<div align="right"><b>Total Detail : Rp. <?php echo number_format($total_transaksi, 2, ',', '.');?></b></div>
		</div>	
		<div class="form-actions right">
			<?php
			if($mode=='edit'){
				echo '<button type="button" class="btn green" onclick="update();">Update</button>';
				echo '<button type="button" class="btn default" onclick="btn_close();">Cancel</button>';
			}elseif($mode=='view'){
				echo '<button type="button" class="btn default" onclick="btn_close();">Close</button>';
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
id   = <?php echo json_encode(@$dt->id_audit);?>;
total_transaksi   = <?php echo json_encode(@$total_transaksi);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='edit'){
	$('.form_edit').removeAttr('readonly');
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

var table_audit_detail_pesanan = new Datatable();
table_audit_detail_pesanan.init({
    src: $("#table_audit_detail_pesanan"),
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
            "url": "<?php echo site_url() ?>/keuangan/c_audit/get_auditdetailpesanan", // ajax source
            data: function (d) {
            	d.id_audit = id;
            }
        },
        "columns": [
	        {"orderable": false},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	    ],
        "order": [
            [1, "asc"]
        ]// set first column as a default sort by asc
    }
});

var table_audit_detail = new Datatable();
table_audit_detail.init({
    src: $("#table_audit_detail"),
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
            "url": "<?php echo site_url() ?>/keuangan/c_audit/get_auditdetail", // ajax source
            data: function (d) {
            	d.id_audit = id;
            }
        },
        "columns": [
	        {"orderable": false},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	    ],
        "order": [
            [2, "asc"]
        ]// set first column as a default sort by asc
    }
});

// $('#saldo_awal').change(function(event) {
// 	event.preventDefault();
// 	saldo_awal = $(this).val();
// 	saldo_awal = saldo_awal.split('.').join("");
// 	saldo_system = Number(saldo_awal) + Number(total_transaksi);
// 	$('#saldo_system').val(saldo_system);
// });

function change_saldoawal () {
	saldo_awal = $('#saldo_awal').val();
	// saldo_awal = saldo_awal.split('.').join("");
	saldo_system = Number(saldo_awal) + Number(total_transaksi);
	$('#saldo_system').val(saldo_system);
}

function change_saldoakhir () {
	saldo_system = $('#saldo_system').val();
	saldo_akhir = $('#saldo_akhir').val();
	// selisih = saldo_awal.split('.').join("");
	selisih = Number(saldo_akhir) - Number(saldo_system);
	$('#selisih').val(selisih);
}

function update () {
	saldo_awal = $('#saldo_awal').val();
	saldo_system = $('#saldo_system').val();
	saldo_akhir = $('#saldo_akhir').val();
	selisih = $('#selisih').val();
	if(Number(saldo_awal)==0 || Number(saldo_akhir)==0){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Saldo Awal dan Saldo Akhir tidak boleh nol.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url();?>/keuangan/c_audit/update', {id_audit:id, saldo_awal:saldo_awal, saldo_system:saldo_system, saldo_akhir:saldo_akhir, selisih:selisih}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Audit berhasil dirubah", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_audit.getDataTable().ajax.reload();
			}
		});
	}
}
</script>