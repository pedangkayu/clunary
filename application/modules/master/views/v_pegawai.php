<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
	<div class="row">
		<div class="col-md-12">
			<div id="form_add_edit" style="display:none;"></div>
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-users"></i>Data Pegawai
					</div>
					<div class="actions">
						<a class="btn btn-primary btn-sm" href="javascript:;btn_add();">
						<i class="fa fa-plus"></i> Tambah </a>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-bordered table-hover" id="table_pegawai">
					<thead>
					<tr>
						<th>#</th>
						<th>Kode</th>
						<th>Nama</th>
						<th>Panggilan</th>
						<th>JK</th>
						<th>Alamat</th>
						<th>Jabatan</th>
						<th>Mulai Kerja</th>
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
	<!-- END PAGE CONTENT INNER -->	
</div>

<!-- MODAL EDIT -->
<div id="modal_pegawai" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>


<script type="text/javascript">

var table_pegawai = new Datatable();
table_pegawai.init({
    src: $("#table_pegawai"),
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
            "url": "<?php echo site_url() ?>/master/c_pegawai/get", // ajax source
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
            [1, "asc"]
        ]// set first column as a default sort by asc
    }
});



function btn_add () {
	$("#form_add_edit").load('<?php echo site_url(); ?>/master/c_pegawai/form_add',function() {
		$(this).removeAttr('style');
	});
}

function btn_edit (kode_pegawai) {
	// kode_pegawai = encodeURI(kode_pegawai);
	$("#form_add_edit").load('<?php echo site_url(); ?>/master/c_pegawai/form_edit?kode_pegawai='+kode_pegawai,function() {
		$(this).removeAttr('style');
	});
}

function btn_view (kode_pegawai) {
	// kode_pegawai = encodeURI(kode_pegawai);
	$("#form_add_edit").load('<?php echo site_url(); ?>/master/c_pegawai/form_view?kode_pegawai='+kode_pegawai,function() {
		$(this).removeAttr('style');
	});
}

function btn_delete (kode_pegawai) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
		if (sure) {
			$.post('<?php echo site_url(); ?>/master/c_pegawai/delete?kode_pegawai='+kode_pegawai, {}, function(res) {
				if(res.stat){
					NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data pegawai berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_pegawai.getDataTable().ajax.reload();
				}
			});
		}
}


</script>
