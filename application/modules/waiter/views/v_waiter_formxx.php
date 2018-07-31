<?php
if($mode=='edit' || $mode=='view'){
	$dt = $pesanan->row(); 
}
?>
<!-- MODAL TAMBAH -->
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" onclick="event.preventDefault();btn_close();">X</button>
			<h4 class="modal-title">
				<?php
				if($mode=='add'){
					echo 'Add Pesanan';
				}elseif($mode=='edit'){
					echo 'Edit Pesanan - ID: '.$dt->kode_pemesanan;
				}elseif($mode=='view'){
					echo 'View Pesanan - ID: '.$dt->kode_pemesanan;
				}
				?>
			</h4>
		</div>
		<div class="modal-body">
			<div class="form-body">
				<ul class="nav nav-pills">
					<li class="active">
						<a href="#pesanan" data-toggle="tab">Pesanan</a>
					</li>
					<li>
						<a href="#detail" data-toggle="tab">List Menu</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active in" id="pesanan">
						<form class="form-horizontal">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-2 control-label">Nama Customer <font color="orange">*</font></label>
									<div class="col-md-5">
										<input type="text" class="form-control" placeholder="Nama Customer" id="nama_pemesan" value="<?php echo @$dt->nama_pemesan;?>" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">No Meja <font color="orange">*</font></label>
									<div class="col-md-5">
										<select class="form-control" id="kode_meja" disabled>
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
								<div class="form-group">
									<label class="col-md-2 control-label">Catatan</label>
									<div class="col-md-5">
										<textarea class="form-control" rows="5" id="note" readonly><?php echo @$dt->note;?></textarea>
									</div>
								</div>
							</div>
						</form>
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
						<div id="total_bayar"><b>Total Bayar : Rp 0</b></div>
						<br>
						<br>
						<?php
						if($mode=='add' || $mode=='edit'){
							echo '<button type="button" class="btn blue" onclick="btn_orderkekasir()">Konfirmasi</button>';
						}
						?>
					</div>
					<div class="tab-pane fade" id="detail">
						<ul class="nav nav-pills">
							<?php
							$i = 0;
							foreach ($kategori->result() as $r) {
								$i++;
								$tab = 'tab'.$i;
								?>
								<li class="<?php echo ($i==1) ? 'active' : '';?>">
									<a href="#<?php echo $tab;?>" data-toggle="tab"><?php echo $r->nama_kategori;?></a>
								</li>
								<?php
							}
							?>
						</ul>
						<div class="tab-content">
							<?php
							$i = 0;
							foreach ($kategori->result() as $r) {
								$i++;
								$tab = 'tab'.$i;
								?>
								<div class="tab-pane fade <?php echo ($i==1) ? 'active in' : '';?>" id="<?php echo $tab;?>">
									<?php
									foreach ($menu->result() as $rr) {
										if($rr->kode_kategori==$r->kode_kategori){
											$gambar = 'no-image.jpg';
											if(!empty($rr->gambar_menu)){
												$gambar = $rr->gambar_menu;
											}
											?>
											<div class="col-sm-12 col-md-3">
												<div class="thumbnail">
													<img src="<?php echo base_url().'uploads/menu/'.$gambar;?>" alt="" style="width: 100%; height: 200px;">
													<div class="caption">
														<h3><?php echo $rr->nama_menu;?></h3>
														<?php
														if($mode=='add' || $mode=='edit'){
															?>
															<p>
																<div class="form-group last">
																		<div class="spinner4">
																			<div class="input-group" style="width:150px;">
																				<div class="spinner-buttons input-group-btn">
																					<button type="button" class="btn spinner-up blue">
																					<i class="fa fa-plus"></i>
																					</button>
																				</div>
																				<input type="text" class="spinner-input form-control jml_menu" maxlength="3" readonly>
																				<div class="spinner-buttons input-group-btn">
																					<button type="button" class="btn spinner-down red">
																					<i class="fa fa-minus"></i>
																					</button>
																				</div>
																			</div>
																		</div>
																</div>
																<a href="javascript:;" class="btn blue btn_pesanmenu" data-kode_menu="<?php echo $rr->kode_menu;?>">
																Pesan </a>
															</p>
															<?php
														}
														?>
													</div>
												</div>
											</div>
											<?php
										}
									}
									?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			
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

$('.spinner4').spinner({value:0, step: 1, min: 0, max: 100});

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
		total_bayar = res.total_bayar;
		$('#total_bayar').html('<b>Total Bayar : Rp '+addCommas(total_bayar)+'</b>');
	});
}

function update_total_bayar_fix () {
	$.post('<?php echo site_url();?>/waiter/c_waiter/update_total_bayar_fix', {id_pesanan:id_pesanan}, function(res) {
		total_bayar = res.total_bayar;
		$('#total_bayar').html('<b>Total Bayar : Rp '+total_bayar+'</b>');
	});
}

$('.btn_pesanmenu').click(function(event) {
	event.preventDefault();
	kode_menu = $(this).data('kode_menu');
	jml_menu = $(this).parent().find('.jml_menu').val();
	$.post('<?php echo site_url();?>/waiter/c_waiter/add_pesanmenu', {id_pesanan:id_pesanan, kode_menu:kode_menu, jml_menu:jml_menu}, function(res) {
		if(res.stat){
			id_pesanan = res.id_pesanan;
			$(this).parent().find('.jml_menu').val(0);
			table_listorder.getDataTable().ajax.reload();
			update_total_bayar(id_pesanan);
			NotifikasiToast({
				type : 'success', // ini tipe notifikasi success,warning,info,error
				msg : "Menu berhasil ditambahkan.", //ini isi pesan
				title : 'Success', //ini judul pesan
			});
		}
	});
});

function btn_close () {
	delete table_listorder;
	$('#modal_form').modal("hide");
}

function btn_orderkekasir () {
	if(id_pesanan==0){
		alert('Anda belum menambahkan menu yang diorder.');
	}else{
		nama_pemesan = $('#nama_pemesan').val();
		kode_meja    = $('#kode_meja').val();
		note         = $('#note').val();
		if(nama_pemesan=='' || kode_meja==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Nama Customer dan No Meja wajib diisi.", //ini isi pesan
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
</script>