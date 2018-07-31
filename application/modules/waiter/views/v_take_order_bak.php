<div class="page-content">
	<div class="row">
		<div class="col-md-12">
			<div id="form_order" style="display:none;">
				
			</div>
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase">List Menu</span>
					</div>
					<div class="actions">
						<?php
						if($core_mode!='edit_pesanan'){
							?>
							<a href="#" class="btn btn-circle btn-danger btn-sm" onclick="btn_add()">
							<i class="fa fa-plus"></i> Add </a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="portlet-body">
					<div class="container-fluid">
						<div class="row take-order">
							<ul class="nav nav-pills">
								<li class="">
									<a href="#cari" data-toggle="tab">Cari</a>
								</li>
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
								<div class="tab-pane fade" id="cari">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Nama Menu" id="txt_search" onkeypress='return enter_search(event)'>
											</div>
										</div>
										<div class="col-md-6">
											<button type="button" class="btn default" onclick="btn_cari();">Cari</button>
										</div>
									</div>
									<div id="content_cari" style="display:none;">
										
									</div>
								</div>
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
												<div class="col-lg-2 col-sm-3 col-xs-6 col-md-2">
													<div class="product-container">
														<div class="product <?php echo ($rr->flag_hapus==1) ? 'product-ntfnd' : '';?>">
															<span class="product-img">
																<img src="<?php echo base_url().'assets/global/img/flags/jp.png';?>" title="">
																<!-- <!img src="<?php echo base_url().'uploads/menu/'.$gambar;?>" title="Nasi Goreng"> -->
															</span>
															<h4 class="prd-name"><?php echo $rr->nama_menu;?></h4>
															<span class="product-price">Rp <?php echo $rr->harga;?>,-</span>
														</div>
														<?php 
														if($rr->flag_hapus!=1){
															?>
															<div class="list_product" style="display:none;">
																<div class="qty">
																	<i class="fa fa-plus qty_plus"></i><input type="text" class="r" name="qty"><i class="qty_min fa fa-minus"></i>
																</div>
																<div class="btn btn-order" data-kode_menu="<?php echo $rr->kode_menu;?>">
																	<i class="fa fa-cutlery"></i>Pesan
																</div>
															</div>
															<?php
														}
														?>
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
							
							<!-- <div class="col-lg-2 col-sm-3 col-xs-6 col-md-2">
								<div class="product-container">
									<div class="product product-ntfnd">
										<span class="product-img">
											<img src="<?php echo base_url();?>uploads/menu/Nasi-Pecel-Surabaya.jpg" title="Nasi Goreng">
										</span>
										<h4 class="prd-name">Nasi Goreng Jumbo Enak</h4>
										<span class="product-price">Habis</span>
									</div>
									<div class="qty">
										<i class="fa fa-plus"></i><input type="text" class="r" name="qty"><i class="fa fa-minus"></i>
									</div>
									<div class="btn btn-order"><i class="fa fa-cutlery"></i>Pesan</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
	</div>
</div>

<div id="modal_edit_listorder" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>

<div id="modal_form_confirm" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>

<script type="text/javascript">
klik_add = 0;
core_mode = <?php echo json_encode($core_mode);?>;
if(core_mode=='edit_pesanan'){
	id = <?php echo json_encode($id);?>;
	btn_edit(id);
}

function btn_add () {
	klik_add = 1;
	$("#form_order").load('<?php echo site_url(); ?>/waiter/c_waiter/form_add_order',function() {
		$(this).removeAttr('style');
		$('.list_product').removeAttr('style');
	});
}

function btn_edit (id) {
	$("#form_order").load('<?php echo site_url(); ?>/waiter/c_waiter/form_edit_order/'+id,function() {
		$(this).removeAttr('style');
		$('.list_product').removeAttr('style');
	});
}

function btn_cari () {
	txt_search = $('#txt_search').val();
	$('#content_cari').load('<?php echo site_url();?>/waiter/c_waiter/cari_menu/'+txt_search,function() {
		$(this).removeAttr('style');
		if(klik_add==1){
			$('.list_product').removeAttr('style');
		}
		if(core_mode=='edit_pesanan'){
			$('.list_product').removeAttr('style');
			// id = <?php echo json_encode($id);?>;
			// btn_edit(id);
		}
	});
}

// <start> jquery khusus plus minus pesan take order waiter
$('.qty').find('input[type=text]').val(0);

$('.qty_plus').click(function(event) {
	event.preventDefault();
	qty_sekarang = Number($(this).parent().find('input[type=text]').val())+1;
	$(this).parent().find('input[type=text]').val(qty_sekarang);
});

$('.qty_min').click(function(event) {
	event.preventDefault();
	qty_sekarang = Number($(this).parent().find('input[type=text]').val())-1;
	if(qty_sekarang<0){
		$(this).parent().find('input[type=text]').val(0);
	}else{
		$(this).parent().find('input[type=text]').val(qty_sekarang);
	}
});

// <end> jquery khusus plus minus pesan take order waiter

function enter_search (event) {
	var keypressed = event.keyCode || event.which;
    if (keypressed == 13) {
      btn_cari();
    }
}

</script>