<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
	<div class="row">
		<div class="col-md-12">
			<div id="form_add_edit" style="display:none;"></div>
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-briefcase"></i>Data Pendapatan
					</div>
					<div class="actions" style="display:none;">
						<a class="btn btn-primary btn-sm" href="javascript:;btn_add();">
						<i class="fa fa-plus"></i> Tambah keuangan</a>
					</div>
				</div>
				<div class="portlet-body">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">
							Data Pendapatan </a>
						</li>
						<li>
							<a href="#tab_1_2" data-toggle="tab">
							Data Audit </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab_1_1">
							<form class="form-horizontal">
								<div class="form-group">
									<div class="col-md-1">
										<label class="control-label">Filter</label>
									</div>
									<div class="col-md-4">
										<div class="input-group input-large date-picker input-daterange" data-date-format="dd/mm/yyyy">
											<input type="text" class="form-control date_mulai" name="from">
											<span class="input-group-addon">
											to </span>
											<input type="text" class="form-control date_sampai" name="to">
										</div>
										<!-- /input-group -->
										<span class="help-block">
										Select date range </span>
									</div>
									<div class="col-md-2">
										<select class="form-control" id="filter_jenis">
											<option value="">- Jenis Laporan -</option>
											<option value="1">Harian</option>
											<option value="2">Bulanan</option>
											<option value="3" style="display:none;">Tahunan</option>
										</select>
									</div>
									<div class="col-md-2">
										<button type="button" class="btn blue" id="unduh_pendapatan"><i class="fa fa-download"></i> Download</button>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover" id="table_pendapatan">
							<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Saldo System</th>
								<th>Saldo Real</th>
								<th>Selisih</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="tab_1_2">
							<form class="form-horizontal">
								<div class="form-group">
									<div class="col-md-1">
										<label class="control-label">Filter</label>
									</div>
									<div class="col-md-4">
										<div class="input-group input-large date-picker input-daterange" data-date-format="dd/mm/yyyy">
											<input type="text" class="form-control date_mulai_audit" name="from_audit">
											<span class="input-group-addon">
											to </span>
											<input type="text" class="form-control date_sampai_audit" name="to_audit">
										</div>
										<!-- /input-group -->
										<span class="help-block">
										Select date range </span>
									</div>
									<div class="col-md-2">
										<select class="form-control" id="filter_jenis_audit">
											<option value="">- Jenis Laporan -</option>
											<option value="1">Harian</option>
											<option value="2">Bulanan</option>
											<option value="3" style="display:none;">Tahunan</option>
										</select>
									</div>
									<div class="col-md-2">
										<button type="button" class="btn blue" id="unduh_audit"><i class="fa fa-download"></i> Download</button>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover" id="table_audit">
							<thead>
							<tr>
								<th>#</th>
								<th>Open</th>
								<th>Close</th>
								<th>Pegawai</th>
								<th>Saldo Awal</th>
								<th>Saldo Sistem</th>
								<th>Saldo Akhir</th>
								<th>Selisih</th>
								<th>Catatan</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
							</table>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->	
</div>

<!-- MODAL EDIT -->
<div id="modal_meja" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>


<script type="text/javascript">
tgl_mulai = '';
tgl_sampai = '';

var table_pendapatan = new Datatable();
table_pendapatan.init({
	
    src: $("#table_pendapatan"),
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
        "sDom": "Rprltpi",
        "lengthMenu": [
            [10, 20, 50, 100, 150, -1],
            [10, 20, 50, 100, 150, "All"] // change per page values here
        ],
        "pageLength": 10, // default record count per page
        "ajax": {
            "url": "<?php echo site_url() ?>/keuangan/c_pendapatan/get", // ajax source
            data: function (d) {
            	d.tgl_mulai = tgl_mulai;
            	d.tgl_sampai = tgl_sampai;
            }
        },
        "columns": [
	        {"orderable": false},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": false},
	    ],
        "order": [
            [1, "desc"]
        ],
    }
});

function btn_close () {
	$('#form_add_edit').attr('style', 'display:none;');
}

function btn_view (id) {
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_pendapatan/form_view?id='+id,function() {
		$(this).removeAttr('style');
	});
}

function btn_delete (id) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
	if (sure) {
		$.post('<?php echo site_url(); ?>/keuangan/c_pendapatan/delete?id='+id, {}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data pendapatan berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_pendapatan.getDataTable().ajax.reload();
			}
		});
	}
}

$('#unduh_pendapatan').click(function (e) { 
	e.preventDefault();
	filter_jenis = $('#filter_jenis').val();

    a = $('input[name="from"]').val().split("/");
	tgl_mulai = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to"]').val().split("/");
	tgl_sampai = b[2]+"-"+b[1]+"-"+b[0];

	if(filter_jenis=='' || $('input[name="from"]').val()=='' || $('input[name="to"]').val()==''){
		alert("Silahkan isikan tanggal mulai dan akhir serta Jenis Laporan tidak boleh kosong.");
	}else{
		// location.replace("<?php echo base_url(); ?>index.php/keuangan/c_pendapatan/export?perusahaan_id="+perusahaan_id+"&gate_id="+gate_id+"&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
		location.replace("<?php echo site_url(); ?>/keuangan/c_pendapatan/export?jenis_laporan="+filter_jenis+"&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
	}	 
});

$('.date-picker').datepicker({
    rtl: Metronic.isRTL(),
    orientation: "left",
    autoclose: true
});

$('.date_mulai').change(function(e) {
	a = $('input[name="from"]').val().split("/");
	tgl_mulai = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to"]').val().split("/");
	tgl_sampai = b[2]+"-"+b[1]+"-"+b[0];

	// table_inventorybahan.getDataTable().ajax.reload();

});

$('.date_sampai').change(function(e) {
	// e.preventDefault();
	a = $('input[name="from"]').val().split("/");
	tgl_mulai = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to"]').val().split("/");
	tgl_sampai = b[2]+"-"+b[1]+"-"+b[0];

	table_pendapatan.getDataTable().ajax.reload();

});

// audit
tgl_mulai_audit = '';
tgl_sampai_audit = '';

var table_audit = new Datatable();
table_audit.init({
    src: $("#table_audit"),
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
            "url": "<?php echo site_url() ?>/keuangan/c_audit/get", // ajax source
            data: function (d) {
            	d.tgl_mulai = tgl_mulai_audit;
            	d.tgl_sampai = tgl_sampai_audit;
            }
        },
        "columns": [
	        {"orderable": false},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
	        {"orderable": true},
			{"orderable": false}
	    ],
        "order": [
            [1, "desc"]
        ]// set first column as a default sort by asc
    }
});

function btn_view_audit (id) {
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_audit/form_view?id='+id,function() {
		$(this).removeAttr('style');
	});
}

function btn_edit_audit (id) {
	// kode_meja = encodeURI(kode_meja);
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_audit/form_edit?id='+id,function() {
		$(this).removeAttr('style');
	});
}

function btn_delete_audit (id) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
	if (sure) {
		$.post('<?php echo site_url(); ?>/keuangan/c_audit/delete?id='+id, {}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Audit berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_audit.getDataTable().ajax.reload();
			}
		});
	}
}

$('#unduh_audit').click(function (e) { 
	e.preventDefault();
	filter_jenis_audit = $('#filter_jenis_audit').val();

    a = $('input[name="from_audit"]').val().split("/");
	tgl_mulai_audit = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to_audit"]').val().split("/");
	tgl_sampai_audit = b[2]+"-"+b[1]+"-"+b[0];

	if(filter_jenis_audit=='' || $('input[name="from_audit"]').val()=='' || $('input[name="to_audit"]').val()==''){
		alert("Silahkan isikan tanggal mulai dan akhir serta Jenis Laporan tidak boleh kosong.");
	}else{
		// location.replace("<?php echo base_url(); ?>index.php/keuangan/c_audit/export?perusahaan_id="+perusahaan_id+"&gate_id="+gate_id+"&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
		location.replace("<?php echo site_url(); ?>/keuangan/c_audit/export?jenis_laporan="+filter_jenis_audit+"&tgl_mulai="+tgl_mulai_audit+"&tgl_sampai="+tgl_sampai_audit);
	}	 
});

$('.date_mulai_audit').change(function(e) {
	a = $('input[name="from_audit"]').val().split("/");
	tgl_mulai_audit = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to_audit"]').val().split("/");
	tgl_sampai_audit = b[2]+"-"+b[1]+"-"+b[0];

	// table_inventorybahan.getDataTable().ajax.reload();
 
});

$('.date_sampai_audit').change(function(e) {
	// e.preventDefault();
	a = $('input[name="from_audit"]').val().split("/");
	tgl_mulai_audit = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to_audit"]').val().split("/");
	tgl_sampai_audit = b[2]+"-"+b[1]+"-"+b[0];

	table_audit.getDataTable().ajax.reload();

});

function btn_view_pendapatan (tgl_submit) {
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_pendapatan/form_view?tgl_submit='+tgl_submit,function() {
		$(this).removeAttr('style');
	});
}
</script>