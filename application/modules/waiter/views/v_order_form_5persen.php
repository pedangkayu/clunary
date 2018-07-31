<?php
if($mode=='add'){
	$title = 'Tambah Order';
}elseif($mode=='edit'){
	$title = 'Edit Order';
	$dt = $pesanan->row();
}elseif($mode=='view'){
	$title = 'View Order';
	$dt = $pesanan->row();
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
						<label class="control-label">Nama Customer</label>
						<input type="text" class="form-control input-xlarge" placeholder="Nama Customer" id="nama_pemesan" value="<?php echo @$dt->nama_pemesan;?>" disabled>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">No Meja <font color="orange">*</font></label>
						<select class="form-control input-xlarge" id="kode_meja" disabled>
							<option value="">- No Meja -</option>
							<?php
							foreach ($meja->result() as $r) {
								$terpilih = '';
								if($r->kode_meja==@$dt->kode_meja){
									$terpilih = 'selected';
								}
								echo '<option value="'.$r->kode_meja.'" '.$terpilih.'>Meja '.$r->kode_meja.'</option>';
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Catatan</label>
						<textarea class="form-control input-xlarge" rows="5" id="note" placeholder="Catatan" readonly><?php echo @$dt->note;?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 table-responsive">
					<table class="table table-bordered table-hover" id="table_listorder">
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
				<div id="total_bayar"><b>Total : Rp 0</b></div>
				<div id="service_fee"><b>Service (5%) : Rp 0</b></div>
				<div id="total_semua"><b>Total Bayar : Rp 0</b></div>
				<br>
				<br>
				</div>
			</div>
		</div>
		<div class="form-actions right">
			<button type="button" class="btn default" onclick="btn_close();"><?php echo ($mode=='view') ? 'Close' : 'Cancel';?></button>
			<?php
			if($mode=='add' || $mode=='edit'){
				echo '<button type="button" class="btn yellow" onclick="pending();">Pending</button>';
				echo '<button type="button" class="btn blue" onclick="btn_orderkekasir()">Konfirmasi</button>';
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
id_pesanan = 0;
total_bayar = 0;
mode = <?php echo json_encode($mode);?>;
if(mode=='add'){
	$('.form-control').prop('disabled', false);
	$('.form-control').prop('readonly', false);
}else if(mode=='edit'){
	id_pesanan = <?php echo json_encode(@$dt->id_pesanan);?>;
	$('.form-control').prop('disabled', false);
	$('.form-control').prop('readonly', false);
	update_total_bayar(id_pesanan);
}else if(mode=='view'){
	id_pesanan = <?php echo json_encode(@$dt->id_pesanan);?>;
	$('.form-control').prop('disabled', true);
	$('.form-control').prop('readonly', true);
	update_total_bayar_fix(id_pesanan);
}

table_listorder = new Datatable();
table_listorder.init({
    src: $("#table_listorder"),
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

function update_total_bayar () {
	$.post('<?php echo site_url();?>/waiter/c_waiter/update_total_bayar', {id_pesanan:id_pesanan}, function(res) {
		// total_bayar = res.total_bayar;
		// $('#total_bayar').html('<b>Total Bayar : Rp '+addCommas(total_bayar)+'</b>');
		total_bayar = res.total_bayar;
		service_fee = total_bayar*5/100;
		total_semua = total_bayar+service_fee;
		$('#total_bayar').html('<b>Total : Rp '+total_bayar+'</b>');
		$('#service_fee').html('<b>Service (5%) : Rp '+service_fee+'</b>');
		$('#total_semua').html('<b>Total Bayar : Rp '+total_semua+'</b>');
	});
}

function update_total_bayar_fix () {
	$.post('<?php echo site_url();?>/waiter/c_waiter/update_total_bayar_fix', {id_pesanan:id_pesanan}, function(res) {
		total_bayar = res.total_bayar;
		service_fee = total_bayar*5/100;
		total_semua = total_bayar+service_fee;
		$('#total_bayar').html('<b>Total : Rp '+total_bayar+'</b>');
		$('#service_fee').html('<b>Service (5%) : Rp '+service_fee+'</b>');
		$('#total_semua').html('<b>Total Bayar : Rp '+total_semua+'</b>');
	});
}

$('.btn-order').click(function(event) {
	event.preventDefault();
	kode_menu = $(this).data('kode_menu');
	jml_menu = Number($(this).parent().find('input[type=text]').val());
	if(jml_menu<1){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Jumlah menu minimal 1.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url();?>/waiter/c_waiter/add_pesanmenu', {id_pesanan:id_pesanan, kode_menu:kode_menu, jml_menu:jml_menu}, function(res) {
			if(res.stat){
				id_pesanan = res.id_pesanan;
				$(this).parent().find('input[type=text]').val(0);
				table_listorder.getDataTable().ajax.reload();
				update_total_bayar(id_pesanan);
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Menu berhasil ditambahkan.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
			}else{
				alert(res.pesan);
			}
		});
	}
});

function btn_orderkekasir () {
	if(id_pesanan==0){
		NotifikasiToast({
			type : 'error', // ini tipe notifikasi success,warning,info,error
			msg : "Anda belum memasukkan menu pesanan.", //ini isi pesan
			title : 'Error', //ini judul pesan
		});
	}else{
		nama_pemesan = $('#nama_pemesan').val();
		kode_meja    = $('#kode_meja').val();
		note         = $('#note').val();
		if(kode_meja==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "No Meja wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url();?>/waiter/c_waiter/update_pesanan', {id_pesanan:id_pesanan, nama_pemesan:nama_pemesan, kode_meja:kode_meja, note:note}, function(res) {
				if(res.stat){
					$('#modal_form_confirm').load('<?php echo site_url();?>/waiter/c_waiter/confirm_order/'+id_pesanan, function() {
						$(this).modal('show');
					});	
				}
			});
		}
	}
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

function btn_delete_listorder (id_pesanan, kode_menu) {
	$.post('<?php echo site_url();?>/waiter/c_waiter/delete_listorder', {id_pesanan:id_pesanan, kode_menu:kode_menu}, function(res) {
		table_listorder.getDataTable().ajax.reload();
		update_total_bayar(id_pesanan);
	});
}

function btn_edit_listorder (id_pesanan, kode_menu) {
	$("#modal_edit_listorder").load('<?php echo site_url(); ?>/waiter/c_waiter/form_edit_listorder?id_pesanan='+id_pesanan+'&kode_menu='+kode_menu,function() {
		$(this).modal('show');
	});
}

function btn_close () {
	delete table_listorder;
	if(mode=='add' || mode=='edit'){
		var sure = confirm('Apakah Anda yakin membatalkan pesanan ini?');
		if(sure){
			$.post('<?php echo site_url();?>/waiter/c_waiter/delete_order_permanen', {id_pesanan:id_pesanan}, function(res) {
				window.location.replace('<?php echo site_url();?>/waiter/c_waiter/take_order');
				// if(mode=='edit'){
				// }else{
				// 	$('#form_order').attr('style', 'display:none;');
				// 	$('.list_product').attr('style', 'display:none;');
				// }
			});
		}
	}else if(mode=='view'){
		$('#form_order').attr('style', 'display:none;');
		$('.list_product').attr('style', 'display:none;');
	}
}

function pending () {
	if(id_pesanan==0){
		NotifikasiToast({
			type : 'error', // ini tipe notifikasi success,warning,info,error
			msg : "Anda belum memasukkan menu pesanan.", //ini isi pesan
			title : 'Error', //ini judul pesan
		});
	}else{
		nama_pemesan = $('#nama_pemesan').val();
		kode_meja    = $('#kode_meja').val();
		note         = $('#note').val();
		if(kode_meja==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "No Meja wajib diisi.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url();?>/waiter/c_waiter/update_pesanan', {id_pesanan:id_pesanan, nama_pemesan:nama_pemesan, kode_meja:kode_meja, note:note}, function(res) {
				if(res.stat){
					if(mode=='edit' || mode=='add'){
						window.location.replace('<?php echo site_url();?>/waiter/c_waiter/take_order');
					}else{
						$('#form_order').attr('style', 'display:none;');
						$('.list_product').attr('style', 'display:none;');
					}
				}
			});
		}
	}
}
</script>