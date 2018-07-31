<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
	<div class="row">
		<div class="col-md-6">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-legal"></i>Informasi Restoran
					</div>
					<div class="actions">
						<a class="btn btn-primary btn-sm" data-toggle="modal" onclick="btn_edit_resto();">
						<i class="fa fa-pencil"></i> Edit </a>
					</div>
				</div>
				<div class="portlet-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="col-md-3 control-label">Nama Resto</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_nama'){
										?>
										<input type="text" class="form-control" placeholder="Nama Resto" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Alamat</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_alamat'){
										?>
										<textarea class="form-control" placeholder="Alamat" readonly><?php echo $r->var_value;?></textarea>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Kode Pos</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_kodepos'){
										?>
										<input type="text" class="form-control" placeholder="Kode Pos" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Telp</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_telp'){
										?>
										<input type="text" class="form-control" placeholder="Telepon" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Fax</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_fax'){
										?>
										<input type="text" class="form-control" placeholder="Fax" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Website</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_website'){
										?>
										<input type="text" class="form-control" placeholder="Website" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Email</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_email'){
										?>
										<input type="text" class="form-control" placeholder="Email" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Tax / Pajak (%)</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='tax'){
										?>
										<input type="text" class="form-control" placeholder="Tax / Pajak" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Service Fee (%)</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_service_fee'){
										?>
										<input type="text" class="form-control" placeholder="Service Fee" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Discount All Item</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='all_item_discount'){
										?>
										<input type="text" class="form-control" placeholder="Discount All Item" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Kitchen Pool Time</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kitchen_pool_time_s'){
										?>
										<input type="text" class="form-control" placeholder="Kitchen Pool Time" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Logo</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='resto_gambar'){
										if(empty($r->var_value)){
											echo '<img src="'.base_url().'uploads/system/avatar.png" height="200" width="200">';
										}else{
											echo '<img src="'.base_url().'uploads/system/'.$r->var_value.'" height="200" width="200">';
										}
										?>
										<?php
									}
								}
								?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-legal"></i>Informasi Kantor
					</div>
					<div class="actions">
						<a class="btn btn-primary btn-sm" onclick="btn_edit_kantor();">
						<i class="fa fa-pencil"></i> Edit </a>
					</div>
				</div>
				<div class="portlet-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="col-md-3 control-label">Nama Kantor</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_nama'){
										?>
										<input type="text" class="form-control" placeholder="Nama Kantor" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Alamat</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_alamat'){
										?>
										<textarea class="form-control" placeholder="Alamat" readonly><?php echo $r->var_value;?></textarea>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Kode Pos</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_kodepos'){
										?>
										<input type="text" class="form-control" placeholder="Kode Pos" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Telp</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_telp'){
										?>
										<input type="text" class="form-control" placeholder="Telepon" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Fax</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_fax'){
										?>
										<input type="text" class="form-control" placeholder="Fax" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Website</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_website'){
										?>
										<input type="text" class="form-control" placeholder="Website" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Email</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_email'){
										?>
										<input type="text" class="form-control" placeholder="Email" value="<?php echo $r->var_value;?>" disabled>
										<?php
									}
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Logo</label>
							<div class="col-md-9">
								<?php
								foreach ($constants->result() as $r) {
									if($r->variabel=='kantor_gambar'){
										if(empty($r->var_value)){
											echo '<img src="'.base_url().'uploads/system/avatar.png" height="200" width="200">';
										}else{
											echo '<img src="'.base_url().'uploads/system/'.$r->var_value.'" height="200" width="200">';
										}
										?>
										<?php
									}
								}
								?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-legal"></i>Rekening
					</div>
					<div class="actions">
						<a class="btn btn-primary btn-sm" data-toggle="modal" onclick="btn_add_rekening();">
							<i class="fa fa-plus"></i> Tambah
						</a>
					</div>
				</div>
				<div class="portlet-body">
					<form class="form-horizontal" role="form">
						<?php
						$i = 0;
						foreach ($coa_ledger->result() as $r) {
							$i++;
							?>
							<div class="form-group">
								<label class="col-md-3 control-label"><b>Rekening <?php echo $i;?>:</b></label>
								<a class="btn btn-success btn-sm" data-toggle="modal" onclick="btn_edit_rekening(<?php echo $r->id_coa_ledger;?>);">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a class="btn btn-danger btn-sm" data-toggle="modal" onclick="btn_delete_rekening(<?php echo $r->id_coa_ledger;?>);">
									<i class="fa fa-remove"></i> Hapus
								</a>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Nama Bank</label>
								<div class="col-md-9">
									<input type="text" class="form-control" placeholder="Nama Bank" value="<?php echo $r->nama_rek;?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">No Rekening</label>
								<div class="col-md-9">
									<input type="text" class="form-control" placeholder="No Rekening" value="<?php echo $r->no_rek;?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Atas Nama</label>
								<div class="col-md-9">
									<input type="text" class="form-control" placeholder="Atas Nama" value="<?php echo $r->atasnama;?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Kode</label>
								<div class="col-md-9">
									<input type="text" class="form-control" placeholder="Kode" value="<?php echo $r->payment_method;?>" disabled>
								</div>
							</div>
							<?php
						}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->	
</div>

<!-- MODAL EDIT -->
<div id="modal_form" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>


<script type="text/javascript">

function btn_edit_resto () {
	$("#modal_form").load('<?php echo site_url(); ?>/master/c_constants/form_edit_resto',function() {
		$(this).modal('show');
	});
}

function btn_edit_kantor () {
	$("#modal_form").load('<?php echo site_url(); ?>/master/c_constants/form_edit_kantor',function() {
		$(this).modal('show');
	});
}

function btn_add_rekening () {
	$("#modal_form").load('<?php echo site_url(); ?>/master/c_constants/form_add_rekening',function() {
		$(this).modal('show');
	});
}

function btn_edit_rekening (id_coa_ledger) {
	$("#modal_form").load('<?php echo site_url(); ?>/master/c_constants/form_edit_rekening?id='+id_coa_ledger,function() {
		$(this).modal('show');
	});
}

function btn_delete_rekening (id_coa_ledger) {
	var sure = confirm('Apakah Anda yakin menghapus rekening ini?');
	if(sure){
		$.post('<?php echo site_url();?>master/c_constants/delete_rekening', {id_coa_ledger:id_coa_ledger}, function(res) {
			if(res.stat){
				location.reload();
			}
		});
	}
}

</script>
