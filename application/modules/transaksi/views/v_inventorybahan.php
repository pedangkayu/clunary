<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
	<div class="row">
		<div class="col-md-12">
			<div id="form_add_edit" style="display:none;"></div>
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-recycle"></i>Transaksi Inventory Bahan
					</div>
					<div class="actions">
						<a class="btn btn-primary btn-sm" href="javascript:;btn_add();">
						<i class="fa fa-plus"></i> Tambah Transaksi</a>
					</div>
				</div>
				<div class="portlet-body">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_2" data-toggle="tab">
							Informasi Stock Bahan </a>
						</li>
						<li>
							<a href="#tab_1_1" data-toggle="tab">
							Transaksi Inventory Bahan </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab_1_2">
							<form class="form-horizontal">
								<div class="form-group">
									<div class="col-md-1">
										<label class="control-label">Filter</label>
									</div>
									<div class="col-md-2">
										<select class="form-control" id="filterstatus">
											<option value="all">-Status-</option>
											<option value="aman">Aman</option>
											<option value="kurang">Kurang</option>
										</select>
									</div>
									<div class="col-md-2">
										<button type="button" class="btn blue" id="unduh_stock"><i class="fa fa-download"></i> Download</button>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover" id="table_bahanstock">
							<thead>
							<tr>
								<th>#</th>
								<th>Bahan</th>
								<th>Min Stock</th>
								<th>Jumlah Stock</th>
								<th>Satuan</th>
								<th>Harga</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
							</table>
						</div>
						<div class="tab-pane fade " id="tab_1_1">
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
										<button type="button" class="btn blue" id="unduh_transaksi"><i class="fa fa-download"></i> Download</button>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover" id="table_inventorybahan">
							<thead>
							<tr>
								<th>#</th>
								<th>Bahan</th>
								<th>Satuan</th>
								<th>Tgl Update</th>
								<th>Kode Perubahan</th>
								<th>Perubahan</th>
								<th>Jumlah</th>
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
filterstatus = '';

var table_inventorybahan = new Datatable();
table_inventorybahan.init({
    src: $("#table_inventorybahan"),
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
            "url": "<?php echo site_url() ?>/transaksi/c_inventorybahan/get", // ajax source
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
			{"orderable": false}
	    ],
        "order": [
            [3, "desc"]
        ]// set first column as a default sort by asc
    }
});

var table_bahanstock = new Datatable();
table_bahanstock.init({
    src: $("#table_bahanstock"),
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
            "url": "<?php echo site_url() ?>/transaksi/c_inventorybahan/get_stock", // ajax source
            data: function (d) {
            	d.filterstatus = filterstatus;
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
            [3, "asc"]
        ]// set first column as a default sort by asc
    }
});

function btn_close () {
	$('#form_add_edit').attr('style', 'display:none;');
}

function btn_add () {
	$("#form_add_edit").load('<?php echo site_url(); ?>/transaksi/c_inventorybahan/form_add',function() {
		$(this).removeAttr('style');
	});
}

function btn_edit (id) {
	// kode_meja = encodeURI(kode_meja);
	$("#form_add_edit").load('<?php echo site_url(); ?>/transaksi/c_inventorybahan/form_edit?id='+id,function() {
		$(this).removeAttr('style');
	});
}

function btn_delete (id) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
		if (sure) {
			$.post('<?php echo site_url(); ?>/transaksi/c_inventorybahan/delete?id='+id, {}, function(res) {
				if(res.stat){
					NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Transaksi Inventory berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_inventorybahan.getDataTable().ajax.reload();
				}
			});
		}
}

$('#unduh_transaksi').click(function (e) { 
	e.preventDefault();      					
    a = $('input[name="from"]').val().split("/");
	tgl_mulai = a[2]+"-"+a[1]+"-"+a[0];

	b = $('input[name="to"]').val().split("/");
	tgl_sampai = b[2]+"-"+b[1]+"-"+b[0];

	if($('input[name="from"]').val()=='' || $('input[name="to"]').val()==''){
		alert("Silahkan isikan tanggal mulai dan akhir.");
	}else{
		// location.replace("<?php echo base_url(); ?>index.php/transaksi/c_inventorybahan/export?perusahaan_id="+perusahaan_id+"&gate_id="+gate_id+"&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
		location.replace("<?php echo site_url(); ?>/transaksi/c_inventorybahan/export?mode=unduh_transaksi&tgl_mulai="+tgl_mulai+"&tgl_sampai="+tgl_sampai);
	}	 
});

$('#unduh_stock').click(function (e) { 
	e.preventDefault();      					
	filterstatus = $('#filterstatus').val();
	location.replace("<?php echo site_url(); ?>/transaksi/c_inventorybahan/export?mode=unduh_stock&filterstatus="+filterstatus);
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

	table_inventorybahan.getDataTable().ajax.reload();

});

$('#filterstatus').change(function(event) {
	event.preventDefault();
	filterstatus = $(this).val();
	table_bahanstock.getDataTable().ajax.reload();
});

</script>
