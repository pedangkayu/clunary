<?php
if($mode=='add'){
	$title = 'Tambah Area Duduk';
}elseif($mode=='edit'){
	$title = 'Edit Area Duduk';
	$dt = $areaduduk->row();
}elseif($mode=='view'){
	$title = 'View Area Duduk';
	$dt = $areaduduk->row();
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
							<label class="control-label">Kode Area Duduk <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="kode_areaduduk" value="<?php echo @$dt->kode_areaduduk; ?>" placeholder="Kode Area Duduk" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nama Area <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="nama_area" value="<?php echo @$dt->nama_area; ?>" placeholder="Nama Area Duduk" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Deskripsi </label>
							<textarea class="form-control input-xlarge" id="deskripsi" readonly><?php echo @$dt->deskripsi;?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Lantai <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="lantai" disabled>
								<option value="">- Lantai -</option>
								<?php
								for ($i=1; $i <= 10; $i++) {
									$terpilih = '';
									if($i==@$dt->lantai){
										$terpilih = 'selected';
									}
									echo '<option value="'.$i.'" '.$terpilih.'>Lantai '.$i.'</option>';
								}
								?>
							</select>
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
id = <?php echo json_encode(@$dt->kode_areaduduk);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}


</script>