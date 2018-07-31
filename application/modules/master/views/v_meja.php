<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
	<div class="row">
		<div class="col-md-12">
			<div id="form_add_edit" style="display:none;"></div>
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cube"></i>Data Meja
					</div>
					<div class="actions">
						<a class="btn btn-primary btn-sm" href="javascript:;btn_add();">
						<i class="fa fa-plus"></i> Tambah </a>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-bordered table-hover" id="table_meja">
					<thead>
					<tr>
						<th>#</th>
						<th>Area Duduk</th>
						<th>Kode</th>
						<th>Kapasitas</th>
						<th>Dipesan</th>
						<th>Digunakan</th>
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
<div id="modal_meja" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>


<script type="text/javascript">

var table_meja = new Datatable();
table_meja.init({
    src: $("#table_meja"),
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
            "url": "<?php echo site_url() ?>/master/c_meja/get", // ajax source
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
            [2, "asc"]
        ]// set first column as a default sort by asc
    }
});

function btn_close () {
	$('#form_add_edit').attr('style', 'display:none;');
}

function btn_add () {
	$("#form_add_edit").load('<?php echo site_url(); ?>/master/c_meja/form_add',function() {
		$(this).removeAttr('style');
	});
}

function btn_edit (kode_meja) {
	// kode_meja = encodeURI(kode_meja);
	$("#form_add_edit").load('<?php echo site_url(); ?>/master/c_meja/form_edit?kode_meja='+kode_meja,function() {
		$(this).removeAttr('style');
	});
}



function btn_delete (kode_meja) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
		if (sure) {
			$.post('<?php echo site_url(); ?>/master/c_meja/delete?kode_meja='+kode_meja, {}, function(res) {
				if(res.stat){
					NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Meja berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				table_meja.getDataTable().ajax.reload();
				}
			});
		}
}

function insert () {
	kode_meja      = $('#kode_meja').val();
	kode_areaduduk = $('#kode_areaduduk').val();
	kapasitas      = $('#kapasitas').val();
	if(kode_meja=='' || kode_areaduduk=='' || kapasitas==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_meja/insert");?>', 
														{
															kode_meja:kode_meja,
															kode_areaduduk:kode_areaduduk,
															kapasitas:kapasitas,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Meja berhasil ditambahkan.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_meja.getDataTable().ajax.reload();
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
	kode_meja      = $('#kode_meja').val();
	kode_areaduduk = $('#kode_areaduduk').val();
	kapasitas      = $('#kapasitas').val();
	if(kode_meja=='' || kode_areaduduk=='' || kapasitas==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_meja/update");?>', 
														{
															id:id,
															kode_meja:kode_meja,
															kode_areaduduk:kode_areaduduk,
															kapasitas:kapasitas,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'Meja berhasil diperbarui.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_meja.getDataTable().ajax.reload();
			}else{
				NotifikasiToast({
					type : 'error', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Error', //ini judul pesan
				});
				$("#form_add_edit").removeAttr('style');
				table_meja.getDataTable().ajax.reload();
			}
		});
	}
}
</script>
