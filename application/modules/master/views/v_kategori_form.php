<?php
if($mode=='add'){
	$title = 'Tambah Kategori Menu';
}elseif($mode=='edit'){
	$title = 'Edit Kategori Menu';
	$dt = $kategori->row();
}elseif($mode=='view'){
	$title = 'View Kategori Menu';
	$dt = $kategori->row();
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
		<form role="form">
			<div class="form-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Kode Kategori Menu <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="kode_kategori" value="<?php echo @$dt->kode_kategori; ?>" placeholder="Kode Kategori Menu" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nama Kategori Menu <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="nama_kategori" value="<?php echo @$dt->nama_kategori; ?>" placeholder="Nama Kategori Menu" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Urutan <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="order_kategori" value="<?php echo @$dt->order_kategori; ?>" placeholder="Urutan" onkeyup="formatNumber(this)" disabled>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions right">
				<?php
				$title_closebutton = 'Cancel';
				if($mode=='add'){
					echo '<button type="button" class="btn blue" onclick="insert();">Tambah</button>';
				}elseif($mode=='edit'){
					echo '<button type="button" class="btn green" onclick="update();">Update</button>';
				}elseif($mode=='view'){
					$title_closebutton = 'Close';
				}
				?>
				<button type="button" class="btn default" onclick="btn_close();"><?php echo $title_closebutton;?></button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
id = <?php echo json_encode(@$dt->kode_kategori);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}


</script>