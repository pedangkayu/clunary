<?php
if($mode=='add'){
	$title = 'Tambah Pegawai';
}elseif($mode=='edit'){
	$title = 'Edit Pegawai';
	$dt = $pegawai->row();
}elseif($mode=='view'){
	$title = 'View Pegawai';
	$dt = $pegawai->row();
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
						<label class="control-label">Kode Pegawai <font color="orange">(*)</font></label>
						<input type="text" class="form-control input-large" id="kode_pegawai" value="<?php echo @$dt->kode_pegawai; ?>" placeholder="Kode Pegawai" disabled>
						<button type="button" class="btn blue" id="btn_cek_kodepegawai" onclick="cek_kodepegawai();" style="<?php echo ($mode=='view' || $mode=='edit') ? 'display:none;' : ''?>">Cek</button>
					</div>
				</div>
			</div>
			<div id="form_pegawai" style="<?php echo ($mode=='view') ? '' : 'display:none;';?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Password <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-large" id="password" value="<?php echo @$dt->password; ?>" placeholder="Password" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Jabatan <font color="orange">(*)</font></label>
							<select class="form-control input-large" id="kode_role" disabled>
								<option value="">- Jabatan -</option>
								<?php
								foreach ($role->result() as $r) {
									$terpilih = '';
									if($r->kode_role==@$dt->kode_role){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->kode_role.'" data-jabatan="'.$r->jabatan.'" '.$terpilih.'>'.$r->jabatan.'</value>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nama Lengkap <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="nama_lengkap" value="<?php echo @$dt->nama_lengkap; ?>" placeholder="Nama Lengkap" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Nama Panggilan</label>
							<input type="text" class="form-control input-xlarge" id="nama_panggilan" value="<?php echo @$dt->nama_panggilan; ?>" placeholder="Nama Panggilan" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Tempat Lahir <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="tempat_lahir" value="<?php echo @$dt->tempat_lahir; ?>" placeholder="Tempat Lahir" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Tanggal Lahir</label>
							<div class="input-group date date-picker">
								<input type="text" id="tanggal_lahir" class="form-control input-xlarge <?php echo ($mode=='view')? '' : 'datepicker';?>" name="tanggal_lahir" value="<?php echo (@$dt->tanggal_lahir) ? date('d F Y',strtotime(@$dt->tanggal_lahir)) : date('d F Y') ;?>" readonly/> 
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Jenis Kelamin <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="gender" disabled>
								<option value="">- Gender -</option>
								<option value="m" <?php echo (@$dt->gender=='m') ? 'selected' : '';?>>Laki-Laki</option>
								<option value="f" <?php echo (@$dt->gender=='f') ? 'selected' : '';?>>Perempuan</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Agama <font color="orange">(*)</font></label>
							<select class="form-control input-xlarge" id="agama" disabled>
								<option value="">- Agama -</option>
								<?php
								foreach ($agama->result() as $r) {
									$terpilih = '';
									if($r->nama_agama==@$dt->agama){
										$terpilih = 'selected';
									}
									echo '<option value="'.$r->nama_agama.'" '.$terpilih.'>'.$r->nama_agama.'</value>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Telp <font color="orange">(*)</font></label>
							<input type="text" class="form-control input-xlarge" id="telp1" value="<?php echo @$dt->telp1; ?>" placeholder="Telp" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Alamat</label>
							<textarea class="form-control input-xlarge" id="alamat" readonly><?php echo @$dt->alamat;?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Mulai Bekerja <font color="orange">(*)</font></label>
							<div class="input-group date date-picker">
								<input type="text" id="mulai_bekerja" class="form-control input-xlarge <?php echo ($mode=='view')? '' : 'datepicker';?>" name="mulai_bekerja" value="<?php echo (@$dt->mulai_bekerja) ? date('d F Y',strtotime(@$dt->mulai_bekerja)) : date('d F Y') ;?>" readonly/> 
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Catatan</label>
							<textarea class="form-control input-xlarge" id="catatan" readonly><?php echo @$dt->catatan;?></textarea>
						</div>
					</div>
				</div>
				<form action="" method="post" enctype="multipart/form-data" id="form_upload" >
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<?php
								if($mode=='view'){
									echo '<label class="control-label">Foto</label>';
								}else{
									echo '<label class="control-label">&nbsp;&nbsp;&nbsp;<button id="aaa" class="btn btn-green" onclick="event.preventDefault();klikUpload();">Upload Foto</button></label>';
								}
								?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-9">
									<div id="container">
										<input id="cover" onchange="$('#form_upload').submit();" name="cover" type="file" accept="image/*" style="display:none">
										<div id="listImage">
											<?php
											$gambar_url = base_url().'uploads/pegawai/avatar.png';
											if(!empty($dt->foto)){
												$gambar_url = base_url().'uploads/pegawai/'.$dt->foto;
											}
											?>
											<div  id="cover_container" class="imgContainer imgTab">
						        				<img id="imgcover" src="<?php echo $gambar_url; ?>" height="200" width="200">
						                    </div>
							            </div>
							        </div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="form-actions right">
			<?php
			$title_closebutton = 'Cancel';
			if($mode=='add'){
				echo '<button type="button" class="btn blue" onclick="update();">Tambah</button>';
			}elseif($mode=='edit'){
				echo '<button type="button" class="btn green" onclick="update();">Update</button>';
			}elseif($mode=='view'){
				$title_closebutton = 'Close';
			}
			?>
			<button type="button" class="btn default" onclick="btn_close();"><?php echo $title_closebutton;?></button>
		</div>
	</div>
</div>

<script type="text/javascript">
id_pegawai = '0';
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
	$('#tanggal_lahir').prop('readonly', true);
	$('#mulai_bekerja').prop('readonly', true);
	if(mode=='edit'){
		id_pegawai = <?php echo json_encode(@$dt->kode_pegawai);?>;
		$('#kode_pegawai').prop('disabled', true);
		$('#btn_cek_kodepegawai').prop('disabled', true);
		$('#form_pegawai').removeAttr('style');
	}
}else{
	$('#aaa').prop('disabled', true);
}

$('.datepicker').datepicker({
	format: 'dd MM yyyy',
    autoclose: true,
});

function cek_kodepegawai () {
	kode_pegawai = $('#kode_pegawai').val();
	if(kode_pegawai==''){
		alert('Kode Pegawai tidak boleh kosong');
	}else{
		$.post('<?php echo site_url();?>/master/c_pegawai/cek_kode', {id_pegawai:id_pegawai, kode_pegawai:kode_pegawai}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'info', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Info', //ini judul pesan
				});
				if(res.last_id!='0'){
					id_pegawai=res.last_id;
				}
				$('#kode_pegawai').prop('disabled', true);
				$('#btn_cek_kodepegawai').prop('disabled', true);
				$('#form_pegawai').removeAttr('style');
			}else{
				NotifikasiToast({
					type : 'warning', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Warning', //ini judul pesan
				});
			}
		});
	}
}

function btn_close () {
	if(mode=='add'){
		if(id_pegawai=='0'){
			$('#form_add_edit').attr('style', 'display:none;');
		}else{
			$.post('<?php echo site_url();?>/master/c_pegawai/delete_permanent', {id_pegawai:id_pegawai}, function(res) {
				if(res.stat){
					$('#form_add_edit').attr('style', 'display:none;');
				}
			});
		}
	}else if(mode=='edit' || mode=='view'){
		$('#form_add_edit').attr('style', 'display:none;');
	}
}

function update () {
	if(id_pegawai=='0'){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi termasuk upload foto.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		kode_pegawai   = $('#kode_pegawai').val();
		password       = $('#password').val();
		nama_lengkap   = $('#nama_lengkap').val();
		nama_panggilan = $('#nama_panggilan').val();
		tempat_lahir   = $('#tempat_lahir').val();
		tanggal_lahir  = $('#tanggal_lahir').val();
		gender         = $('#gender').val();
		agama          = $('#agama').val();
		telp1          = $('#telp1').val();
		alamat         = $('#alamat').val();
		mulai_bekerja  = $('#mulai_bekerja').val();
		catatan        = $('#catatan').val();
		kode_role      = $('#kode_role').val();
		jabatan        = $('#kode_role').find(':selected').data('jabatan');
	}
		
	if(kode_pegawai=='' || nama_lengkap=='' || tempat_lahir=='' || tanggal_lahir=='' || gender=='' || agama=='' || telp1=='' || mulai_bekerja=='' || password=='' || kode_role==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url("master/c_pegawai/update");?>', 
														{
															id_pegawai:id_pegawai,
															kode_pegawai:kode_pegawai,
															nama_lengkap:nama_lengkap,
															nama_panggilan:nama_panggilan,
															tempat_lahir:tempat_lahir,
															tanggal_lahir:tanggal_lahir,
															gender:gender,
															agama:agama,
															telp1:telp1,
															alamat:alamat,
															mulai_bekerja:mulai_bekerja,
															catatan:catatan,
															kode_role:kode_role,
															jabatan:jabatan,
															password:password,
														}, 
														function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : 'pegawai berhasil diperbarui.', //ini isi pesan
					title : 'Success', //ini judul pesan
				});
				$('#form_add_edit').attr('style', 'display:none;');
				table_pegawai.getDataTable().ajax.reload();
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

var requestStack = {};
var deleteCoverClick = function (e) {
    e.preventDefault();
    var r = confirm("Apakah Anda yakin?");
    if (r == true) {
        var file = $("#cover_container").find("img").attr('src');
        $.post('<?php echo site_url() . '/user_management/c_karyawan/deleteImage'; ?>', {karyawan_id:karyawan_id,file: file}, function (data, textStatus, jqXHR) {
            $("#cover_container").fadeOut(300, function () {
                $(this).find("cover").attr('src', '');
                delete($(this).find("cover"));
                $(this).remove();
            });
        });
    }
    console.log(karyawan_id);
};

$("[id^=coverdelete]").click(deleteCoverClick);
var c = 0;

function klikUpload () {
	kode_pegawai = $('#kode_pegawai').val();
	if(kode_pegawai=='' || id_pegawai=='0'){
		alert('Kode Pegawai tidak boleh kosong');
	}else{
		tipeupload = 'manual';
		foto_awal = $.trim($("#cover_container").find("img").attr('src'));
	    $('#cover').click();
		// $('#cover').click();
		// $.post('<?php echo site_url();?>master/c_pegawai/cek_kode', {id_pegawai:id_pegawai, kode_pegawai:kode_pegawai}, function(res) {
		// 	console.log(res.last_id);
		// 	if(res.stat){
		// 		tipeupload = 'manual';
		// 		foto_awal = $.trim($("#cover_container").find("img").attr('src'));
		// 	    $('#cover').click();
		// 		if(res.last_id!='0'){
		// 			id_pegawai = res.last_id;
		// 		}
		// 	}else{
		// 		NotifikasiToast({
		// 			type : 'warning', // ini tipe notifikasi success,warning,info,error
		// 			msg : res.pesan, //ini isi pesan
		// 			title : 'Warning', //ini judul pesan
		// 		});
		// 	}
		// });
	}
}
$("#UploadButton").click(function (e) {
	kode_pegawai = $('#kode_pegawai').val();
	if(kode_pegawai==''){
		alert('Kode Pegawai tidak boleh kosong');
	}else{
		$.post('<?php echo site_url();?>/master/c_pegawai/cek_kode', {id_pegawai:id_pegawai, kode_pegawai:kode_pegawai}, function(res) {
			if(res.stat){
				if(res.last_id!='0'){
					id_pegawai = res.last_id;
				}
				tipeupload = 'manual';
				foto_awal = $.trim($("#cover_container").find("img").attr('src'));
				console.log(foto_awal);
			    $('#cover').click();
			}else{
				NotifikasiToast({
					type : 'warning', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Warning', //ini judul pesan
				});
			}
		});
	}
});

$('#form_upload').submit(function (e) {
	$("[id^=coverdelete]").click(deleteCoverClick); //delete
	$("#cover_container").remove();
    var formData = new FormData(($(this)[0]));
    formData.append('tipeupload',tipeupload);
    formData.append('foto_awal',foto_awal);
    var id = c;
    var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
    if ((filename.length) > 18)
        filename = filename.substr(0, 15) + "...";
    var element = "<div class=\"pgsUpload\" id=\"v" + id + "\">" +
            "<div class=\"nameFileImage\">" +
            "<i class=\"fa fa-paperclip fa-3\"></i>" +
            "<span id=\"name\">" + filename + "</span>" +
            "</div>" +
            "<div class = \"progress progressBar\">" +
            "<div id=\"bar" + id + "\" data-percentage=\"0%\" style=\"width: 0%;\" class=\"progress-bar progress-bar-success progressBarCustom\" role=\"progressbar\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div>" +
            "</div>" +
            "<a id=\"close" + id + "\" href=\"#\"><i class=\"fa fa-times faGreyNew fa-silang fa-3 pull-right\"></i></a>" +
            "<div id=\"percentage" + id + "\" class=\"progressBarPctg pull-right faGreyNew\">0%</div>" +
            "</div>";
    requestStack[id] = $.ajax({
        type: 'POST',
        url: '<?php echo site_url(); ?>base/c_base/upload_pegawai',
        data: formData,
        beforeSend: function () {
            $(element).hide().appendTo("#container").fadeIn(300);
            $("[name=title]").val("");
            $("#close" + id).click(function (e) {
                e.preventDefault();
                $("#v" + id).fadeOut(300, function () {
                    $("#v" + id).remove();
                });
                var xhr = requestStack[id];
                if (xhr && xhr.readyState != 4) {
                    xhr.abort();
                    delete requestStack[id];
                }
            });
            c++;
        },
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        var max = e.total;
                        var current = e.loaded;
                        var Percentage = (current * 100) / max;
                        $("#percentage" + id).html(Math.round(Percentage) + "%");//                                
                        $("#bar" + id).attr("style", "width:" + Math.round(Percentage) + "%;\"");
                        if (Percentage >= 100) {
                            $("#v" + id).fadeOut(800, function () {
                                $("#v" + id).remove();
                            });
                        }
                    }
                }, false);
            }
            return myXhr;
        },
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            d = new Date();
            var element = 
            			"<div  id=\"cover_container\" class=\"imgContainer imgTab\">" +
            			"<img id=\"imgcover\" src=\"<?php echo base_url().'uploads/pegawai/'; ?>"+data.data.file_name+ "\" height=\"200\" width=\"200\">"+
                        "</div>";
            $("#listImage").html(element).fadeIn(300);
            // $("#imgcover").attr("src", "<?php echo base_url().'uploads/pegawai/'; ?>"+data.data.file_name);
            // $('#container').html(element);
            $.post('<?php echo site_url(); ?>/master/c_pegawai/save_upload', {id_pegawai: id_pegawai,file_name: data.data.file_name}, function(res) {
            	
            });
            $("#coverdelete").click(deleteCoverClick);
        }
    });
    e.preventDefault();
});
</script>