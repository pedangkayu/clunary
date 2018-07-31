<ul class="row nav nav-pills">
	<li class="<?php echo ($status_pemesanan==0) ? 'active' : '';?>">
		<a href="<?php echo ($status_pemesanan==0) ? '#' : site_url('waiter/c_waiter/order/0');?>">
		Ordering <span class="badge badge-danger"> <?php echo $jml_pesanan0;?> </span></a>
	</li>
	<li class="<?php echo ($status_pemesanan==1) ? 'active' : '';?>">
		<a href="<?php echo ($status_pemesanan==1) ? '#' : site_url('waiter/c_waiter/order/1');?>">
		On Casher<span class="badge badge-info"> <?php echo $jml_pesanan1;?> </span></a>
	</li>
	<li class="<?php echo ($status_pemesanan==2) ? 'active' : '';?>">
		<a href="<?php echo ($status_pemesanan==2) ? '#' : site_url('waiter/c_waiter/order/2');?>">
		Cooking in Kitchen<span class="badge badge-warning"> <?php echo $jml_pesanan2;?> </span></a>
	</li>
	<li class="<?php echo ($status_pemesanan==3) ? 'active' : '';?>" style="display:none;">
		<a href="<?php echo ($status_pemesanan==3) ? '#' : site_url('waiter/c_waiter/order/3');?>">
		Sudah Disajikan<span class="badge badge-success"> <?php echo $jml_pesanan3;?> </span></a>
	</li>
</ul>


<div class="tab-content">
	<div class="tab-pane fade active in">
		<div class="row">
		<?php
		foreach ($pesanan->result() as $r) {
			?>
			<div class="col-lg-2 col-sm-4 col-xs-6 col-md-3">
				<?php
				$warna = '';
				if($status_pemesanan==0){
					$warna = 'red';
				}elseif($status_pemesanan==1){
					$warna = 'blue';
				}elseif($status_pemesanan==2){
					$warna = 'yellow-crusta';
				}elseif($status_pemesanan==3){
					$warna = 'green-meadow';
				}
				?>
				<div class="portlet <?php echo $warna;?> box">
					<div class="portlet-title">
						<div class="caption" title="<?php echo $r->kode_pemesanan;?>">
							<small>ID : <?php echo $r->kode_pemesanan;?></small>
						</div>
						<div class="actions">
							<?php
							if($status_pemesanan==0){
								?>
								<a href="javascript:;btn_editpemesanan(<?php echo $r->id_pesanan;?>)" class="btn btn-success btn-sm">
								<i class="fa fa-pencil"></i> Edit </a>
								<?php
							}else{
								?>
								<a href="javascript:;btn_viewpemesanan(<?php echo $r->id_pesanan;?>)" class="btn btn-info btn-sm">
								<i class="fa fa-search"></i> View </a>
								<?php
							}
							?>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row static-info">
							<div class="col-lg-4 col-sm-4 col-xs-4 col-md-4  name">
								 Name:
							</div>
							<div class="col-lg-8 col-sm-8 col-xs-8 col-md-8 value" title="<?php echo $r->nama_pemesan;?>">
								 <?php echo $r->nama_pemesan;?>
							</div>
						</div>
						<div class="row static-info">
							<div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 name">
								 Table: 
							</div>
							<div class="col-lg-8 col-sm-8 col-xs-8 col-md-8 value" title="<?php echo $r->kode_meja;?>">
								 <?php echo $r->kode_meja;?>
							</div>
						</div>
						<div class="row static-info">
							<div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 name">
								 Note:
							</div>
							<div class="col-lg-8 col-sm-8 col-xs-8 col-md-8 name msg" title="<?php echo ($r->note=='') ? '-' : $r->note;?>">
								 <?php echo ($r->note=='') ? '-' : $r->note;?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>

<script type="text/javascript">
	function btn_editpemesanan (id_pesanan) {
		window.location.replace('<?php echo site_url();?>waiter/c_waiter/take_order/'+id_pesanan);
		  $('#modal_form').load('<?php echo site_url();?>waiter/c_waiter/form_edit/'+id_pesanan,function() {
			$(this).modal('show');
		  });
	}

	function btn_viewpemesanan (id_pesanan) {
		window.location.replace('<?php echo site_url();?>waiter/c_waiter/take_order/'+id_pesanan);
		  $('#modal_form').load('<?php echo site_url();?>waiter/c_waiter/form_edit/'+id_pesanan,function() {
			$(this).modal('show');
		  });
	}
</script>

 
	 
 
 