<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
	<div class="row">
		<div class="col-md-12">
			<div id="form_add_edit" style="display:none;"></div>
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-briefcase"></i>Data Belanja Bahan
					</div>
					<div class="actions" >
						<a class="btn btn-primary btn-sm" href="javascript:;btn_add();">
						<i class="fa fa-plus"></i> Tambah Belanja</a>
					</div>
				</div>
				<div class="portlet-body">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">
							Belanja Bahan </a>
						</li>
						<li>
							<a href="#tab_1_2" data-toggle="tab">
							Log Belanja </a>
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
										<button type="button" class="btn blue" id="unduh_belanjabahan"><i class="fa fa-download"></i> Download</button>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover" id="table_belanjabahan">
							<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Bahan</th>
								<th>Satuan</th>
								<th>Jumlah</th>
								<th>Harga</th>
								<th>Total</th>
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
											<input type="text" class="form-control date_mulai_logbelanja" name="from_logbelanja">
											<span class="input-group-addon">
											to </span>
											<input type="text" class="form-control date_sampai_logbelanja" name="to_logbelanja">
										</div>
										<!-- /input-group -->
										<span class="help-block">
										Select date range </span>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover" id="table_logbelanja">
							<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Pegawai</th>
								<th>Total Belanja</th>
								<th>Selisih</th>
								<th>Catatan</th>
								<th>Status</th>
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

var table_belanjabahan = new Datatable();
table_belanjabahan.init({
    src: $("#table_belanjabahan"),
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
            "url": "<?php echo site_url() ?>/keuangan/c_belanjabahan/get", // ajax source
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
	        {"orderable": true},
	        {"orderable": true},
	    ],
        "order": [
            [1, "desc"]
        ]// set first column as a default sort by asc
    }
});

$('#unduh_belanjabahan').click(function (e) { 
	e.preventDefault();
	filter_jenis = $('#filter_jenis').val();

    a = $('input[name="from"]').val().split("/");
	tgl_mulai = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to"]').val().split("/");
	tgl_sampai = b[2]+"-"+b[1]+"-"+b[0];

	if(filter_jenis=='' || $('input[name="from"]').val()=='' || $('input[name="to"]').val()==''){
		alert("Silahkan isikan tanggal mulai dan akhir serta Jenis Laporan tidak boleh kosong.");
	}else{
		// location.replace("<?php echo base_url(); ?>index.php/keuangan/c_belanjabahan/export?perusahaan_id="+perusahaan_id+"&gate_id="+gate_id+"&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
		location.replace("<?php echo site_url(); ?>/keuangan/c_belanjabahan/export?jenis_laporan="+filter_jenis+"&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
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

	table_belanjabahan.getDataTable().ajax.reload();

});


tgl_mulai_logbelanja = '';
tgl_sampai_logbelanja = '';

var table_logbelanja = new Datatable();
table_logbelanja.init({
    src: $("#table_logbelanja"),
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
            "url": "<?php echo site_url() ?>/keuangan/c_belanjabahan/get_logbelanja", // ajax source
            data: function (d) {
            	d.tgl_mulai = tgl_mulai_logbelanja;
            	d.tgl_sampai = tgl_sampai_logbelanja;
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
	        {"orderable": false},
	    ],
        "order": [
            [1, "desc"]
        ]// set first column as a default sort by asc
    }
});

$('.date_mulai_logbelanja').change(function(e) {
	a = $('input[name="from_logbelanja"]').val().split("/");
	tgl_mulai_logbelanja = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to_logbelanja"]').val().split("/");
	tgl_sampai_logbelanja = b[2]+"-"+b[1]+"-"+b[0];

	// table_inventorybahan.getDataTable().ajax.reload();

});

$('.date_sampai_logbelanja').change(function(e) {
	// e.preventDefault();
	a = $('input[name="from_logbelanja"]').val().split("/");
	tgl_mulai_logbelanja = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to_logbelanja"]').val().split("/");
	tgl_sampai_logbelanja = b[2]+"-"+b[1]+"-"+b[0];

	table_logbelanja.getDataTable().ajax.reload();

});

function btn_add () {
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_belanjabahan/form_add',function() {
		$(this).removeAttr('style');
	});
}

function btn_edit (id) {
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_belanjabahan/form_edit?id_log_coa_ledger='+id,function() {
		$(this).removeAttr('style');
	});
}

function btn_verifikasi (id) {
	$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_belanjabahan/form_verifikasi?id_log_coa_ledger='+id,function() {
		$(this).removeAttr('style');
	});
}

function btn_view (id) {
	$.post('<?php echo site_url();?>/keuangan/c_belanjabahan/cek_item_log', {id_log_coa_ledger:id}, function(res) {
		if(res.jml==res.jml_item_belanja){
			$("#form_add_edit").load('<?php echo site_url(); ?>/keuangan/c_belanjabahan/form_view?id_log_coa_ledger='+id,function() {
				$(this).removeAttr('style');
			});
		}else{
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Data Log Belanja tersebut sudah direduksi.", //ini isi pesan
				title : 'Success', //ini judul pesan
			});
		}
	});
}

function btn_delete (id) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
	if (sure) {
		$.post('<?php echo site_url(); ?>/keuangan/c_belanjabahan/delete', {id_log_coa_ledger:id}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Log Belanja berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_logbelanja.getDataTable().ajax.reload();
			}
		});
	}
}

function btn_delete_permanent (id) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
	if (sure) {
		$.post('<?php echo site_url(); ?>/keuangan/c_belanjabahan/delete_permanent', {id_log_coa_ledger:id}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Log Belanja berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_logbelanja.getDataTable().ajax.reload();
			}
		});
	}
}



</script>