<?php
if($mode=='add'){
	$title = 'Tambah Meja';
}elseif($mode=='edit'){
	$title = 'Edit Meja';
	$dt = $meja->row();
}elseif($mode=='view'){
	$title = 'View Meja';
	$dt = $meja->row();
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
							<label class="control-label">Kode Meja <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="kode_meja" value="<?php echo @$dt->kode_meja; ?>" placeholder="Kode Meja" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Area Duduk <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="kode_areaduduk" disabled>
							<option value="">- Area Duduk -</option>
							<?php
							foreach ($areaduduk->result() as $r) {
								$terpilih = '';
								if($r->kode_areaduduk==$dt->kode_areaduduk){
									$terpilih = 'selected';
								}
								echo '<option value="'.$r->kode_areaduduk.'" '.$terpilih.'>'.$r->nama_area.'</option>';	
							}
							?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Kapasitas <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="kapasitas" disabled>
								<option value="">- Kapasitas -</option>
								<?php
								for ($i=1; $i <= 10; $i++) {
									$terpilih = '';
									if($i==@$dt->kapasitas){
										$terpilih = 'selected';
									}
									echo '<option value="'.$i.'" '.$terpilih.'>'.$i.' Orang</option>';
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
id = <?php echo json_encode(@$dt->kode_meja);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
}


</script>