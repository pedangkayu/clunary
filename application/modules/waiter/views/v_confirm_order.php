<?php
$dt_co = $pesanan->row(); 
?>
<!-- MODAL TAMBAH -->
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" onclick="event.preventDefault();btn_batal_orderkekasir();">X</button>
			<h4 class="modal-title">
				<?php
				if($mode=='confirm'){
					echo 'Konfirmasi Pesanan - ID: '.$dt_co->kode_pemesanan;
				}
				?>
			</h4>
		</div>
		<div class="modal-body">
			<div class="form-body">
				<form class="form-horizontal">
					<table border="0">
						<tr>
							<td><b>Konsumen </b></td>
							<td>&nbsp;:&nbsp;</td>
							<td><?php echo @$dt_co->nama_pemesan;?></td>
						</tr>
						<tr>
							<td><b>Nomor Meja </b></td>
							<td>&nbsp;:&nbsp;</td>
							<td><?php echo @$dt_co->kode_meja;?></td>
						</tr>
						<tr>
							<td><b>Catatan </b></td>
							<td>&nbsp;:&nbsp;</td>
							<td> <?php echo @$dt_co->note;?></td>
						</tr>
					</table>
					<br>
				</form>
				
				<table class="table table-bordered table-hover" id="table_listorder_confirm">
					<thead>
					<tr>
						<th>#</th>
						<th>Menu</th>
						<th>Harga</th>
						<th>Discount</th>
						<th>Jumlah</th>
						<th>Total</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<br>
				<div id="total_bayar_co">Total Bayar : <b>Rp 0</b></div>
				<br>
				<br>
				<button type="button" class="btn default" onclick="btn_batal_orderkekasir()">Batal</button>
				<button type="button" class="btn blue" onclick="btn_orderkekasir_fix()">Order Ke Kasir</button>
			</div>
		</div>
		<div class="modal-footer">
			
		</div>
	</div>
</div>

<script type="text/javascript">
id_pesanan_co = 0;
total_bayar_co = 0;
mode2 = <?php echo json_encode($mode);?>;
if(mode2=='confirm'){
	id_pesanan_co = <?php echo json_encode(@$dt_co->id_pesanan);?>;
	$('.form-control').prop('disabled', false);
	$('.form-control').prop('readonly', false);
	update_total_bayar_co(id_pesanan_co);
}

table_listorder_confirm = new Datatable();
table_listorder_confirm.init({
    src: $("#table_listorder_confirm"),
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
            "url": "<?php echo site_url() ?>/waiter/c_waiter/get_listorder", // ajax source
            data: function (d) {
            	d.id_pesanan = id_pesanan;
            	d.mode = mode2;
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

function update_total_bayar_co () {
	$.post('<?php echo site_url();?>/waiter/c_waiter/update_total_bayar', {id_pesanan:id_pesanan}, function(res) {
		total_bayar = res.total_bayar;
		$('#total_bayar_co').html('<b>Total Bayar : Rp '+addCommas(total_bayar)+'</b>');
	});
}

function btn_batal_orderkekasir () {
	delete table_listorder_confirm;
	$('#modal_form_confirm').modal("hide");
}

function btn_orderkekasir_fix () {
	$.post('<?php echo site_url();?>/waiter/c_waiter/order_ke_kasir/'+id_pesanan_co, {}, function(res) {
		if(res.stat){
			NotifikasiToast({
				type : 'success', // ini tipe notifikasi success,warning,info,error
				msg : "Data Pesanan berhasil diorder ke Kasir.", //ini isi pesan
				title : 'Success', //ini judul pesan
			});
			window.location.replace('<?php echo site_url();?>waiter/c_waiter/take_order');
			// btn_batal_orderkekasir();
			// delete table_listorder;
			// $('#form_order').attr('style', 'display:none;');
			// $('.list_product').attr('style', 'display:none;');
		}else{
			alert(res.pesan);
		}
	});
}
</script>