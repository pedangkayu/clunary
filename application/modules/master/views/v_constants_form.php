<?php
if($mode=='edit_resto'){
	$title = 'Edit Informasi Resto';
}elseif($mode=='edit_kantor'){
	$title = 'Edit Informasi Kantor';
}elseif($mode=='rekening'){
	if($submode=='add_rekening'){
		$title = 'Tambah Rekening';
	}elseif($submode=='edit_rekening'){
		$title = 'Edit Rekening';
	}
}
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title"><?php echo $title;?></h4>
		</div>
		<div class="modal-body">
			<?php
			if($mode=='edit_resto'){
				?>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-md-3 control-label">Nama Resto</label>
						<div class="col-md-9">
							<?php
							foreach ($constants->result() as $r) {
								if($r->variabel=='resto_nama'){
									?>
									<input type="text" class="form-control" placeholder="Nama Resto" id="resto_nama" value="<?php echo $r->var_value;?>" >
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
									<textarea class="form-control" placeholder="Alamat" id="resto_alamat" ><?php echo @$r->var_value;?></textarea>
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
									<input type="text" class="form-control" placeholder="Kode Pos" id="resto_kodepos" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Telepon" id="resto_telp" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Fax" id="resto_fax" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Website" id="resto_website" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Email" id="resto_email" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Tax / Pajak" id="tax" value="<?php echo $r->var_value;?>" onkeyup="formatNumber(this)" >
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
									<input type="text" class="form-control" placeholder="Service Fee" id="service_fee" value="<?php echo $r->var_value;?>" onkeyup="formatNumber(this)" >
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
									<input type="text" class="form-control" placeholder="Discount All Item" id="all_item_discount" value="<?php echo $r->var_value;?>" onkeyup="formatNumber(this)" >
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
									<input type="text" class="form-control" placeholder="Kitchen Pool Time" id="kitchen_pool_time_s" value="<?php echo $r->var_value;?>" onkeyup="formatNumber(this)" >
									<?php
								}
							}
							?>
						</div>
					</div>
				</form>
				<form action="" method="post" enctype="multipart/form-data" id="form_upload_resto" class="form-horizontal">
					<div class="form-group">
						<label class="col-md-3 control-label">Logo</label>
						<div class="col-md-9">
							<button id="restoUploadButton" class="btn btn-green ">Upload</button>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-9">
							<?php
							foreach ($constants->result() as $r) {
								if($r->variabel=='resto_gambar'){
									?>
									<div id="container_resto">
										<input id="cover_resto" onchange="$('#form_upload_resto').submit();" name="cover" type="file" accept="image/*" style="display:none">
										<div id="listImage_resto">
											<?php
											$gambar_url = base_url().'uploads/system/avatar.png';
											if(!empty($r->var_value)){
												$gambar_url = base_url().'uploads/system/'.$r->var_value;
											}
											?>
											<div  id="cover_container_resto" class="imgContainer imgTab">
						        				<img id="imgcover" src="<?php echo $gambar_url; ?>" height="200" width="200">
						                    </div>
							            </div>
							        </div>
									<?php
								}
							}
							?>	
						</div>
					</div>
				</form>
				<?php
			}elseif($mode=='edit_kantor'){
				?>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-md-3 control-label">Nama Kantor</label>
						<div class="col-md-9">
							<?php
							foreach ($constants->result() as $r) {
								if($r->variabel=='kantor_nama'){
									?>
									<input type="text" class="form-control" placeholder="Nama Kantor" id="kantor_nama" value="<?php echo $r->var_value;?>" >
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
									<textarea class="form-control" placeholder="Alamat" id="kantor_alamat" ><?php echo $r->var_value;?></textarea>
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
									<input type="text" class="form-control" placeholder="Kode Pos" id="kantor_kodepos" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Telepon" id="kantor_telp" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Fax" id="kantor_fax" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Website" id="kantor_website" value="<?php echo $r->var_value;?>" >
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
									<input type="text" class="form-control" placeholder="Email" id="kantor_email" value="<?php echo $r->var_value;?>" >
									<?php
								}
							}
							?>
						</div>
					</div>
				</form>
				<form action="" method="post" enctype="multipart/form-data" id="form_upload_kantor" class="form-horizontal">
					<div class="form-group">
						<label class="col-md-3 control-label">Logo</label>
						<div class="col-md-9">
							<button id="kantorUploadButton" class="btn btn-green ">Upload</button>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-9">
							<?php
							foreach ($constants->result() as $r) {
								if($r->variabel=='kantor_gambar'){
									?>
									<input id="cover_kantor" onchange="$('#form_upload_kantor').submit();" name="cover" type="file" accept="image/*" style="display:none">
									<div id="listImage_kantor">
										<?php
										$gambar_url = base_url().'uploads/system/avatar.png';
										if(!empty($r->var_value)){
											$gambar_url = base_url().'uploads/system/'.$r->var_value;
										}
										?>
										<div  id="cover_container_kantor" class="imgContainer imgTab">
					        				<img id="imgcover" src="<?php echo $gambar_url; ?>" height="200" width="200">
					                    </div>
						            </div>
									<?php
								}
							}
							?>	
						</div>
					</div>
				</form>
				<?php
			}elseif($mode=='rekening'){
				if($submode=='edit_rekening'){
					$dt = $coa_ledger->row();
				}
				?>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-md-3 control-label">Nama Bank <font color="orange">(*)</font></label>
						<div class="col-md-9">
							<input type="text" class="form-control" placeholder="Nama Bank" id="nama_rek" value="<?php echo @$dt->nama_rek;?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">No Rekening <font color="orange">(*)</font></label>
						<div class="col-md-9">
							<input type="text" class="form-control" placeholder="No Rekening" id="no_rek" value="<?php echo @$dt->no_rek;?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Atas Nama <font color="orange">(*)</font></label>
						<div class="col-md-9">
							<input type="text" class="form-control" placeholder="Atas Nama" id="atasnama" value="<?php echo @$dt->atasnama;?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Kode <font color="orange">(*)</font></label>
						<div class="col-md-9">
							<input type="text" class="form-control" placeholder="Kode" id="payment_method" value="<?php echo @$dt->payment_method;?>" >
						</div>
					</div>
				</form>
				<?php
			}
			?>
				
		</div>
		<div class="modal-footer">
			<button type="button" class="btn default" id="btn_cancel">Cancel</button>
			<?php
			if($mode=='edit_resto'){
				echo '<button type="button" class="btn blue" onclick="btn_simpan_resto()">Simpan</button>';
			}elseif($mode=='edit_kantor'){
				echo '<button type="button" class="btn blue" onclick="btn_simpan_kantor()">Simpan</button>';
			}elseif($mode=='rekening'){
				if($submode=='add_rekening'){
					echo '<button type="button" class="btn blue" onclick="btn_insert_rekening()">Tambah</button>';
				}elseif($submode=='edit_rekening'){
					echo '<button type="button" class="btn blue" onclick="btn_update_rekening()">Simpan</button>';
				}
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
var tipeupload='';
var foto_awal='';
mode = <?php echo json_encode($mode);?>;
$('#btn_cancel').click(function(event) {
	event.preventDefault();
	location.reload();
});

function btn_simpan_resto () {
	$.post('<?php echo site_url("master/c_constants/update_resto");?>', 
															{
																resto_nama:$('#resto_nama').val(),
																resto_alamat:$('#resto_alamat').val(),
																resto_telp:$('#resto_telp').val(),
																resto_kodepos:$('#resto_kodepos').val(),
																resto_fax:$('#resto_fax').val(),
																resto_website:$('#resto_website').val(),
																resto_email:$('#resto_email').val(),
																tax:$('#tax').val(),
																resto_service_fee:$('#service_fee').val(),
																all_item_discount:$('#all_item_discount').val(),
																kitchen_pool_time_s:$('#kitchen_pool_time_s').val(),
															},
															function(res) {
		if(res.stat){
			location.reload();
		}
	});
}

function btn_simpan_kantor () {
	$.post('<?php echo site_url("master/c_constants/update_kantor");?>', 
															{
																kantor_nama:$('#kantor_nama').val(),
																kantor_alamat:$('#kantor_alamat').val(),
																kantor_telp:$('#kantor_telp').val(),
																kantor_kodepos:$('#kantor_kodepos').val(),
																kantor_fax:$('#kantor_fax').val(),
																kantor_website:$('#kantor_website').val(),
																kantor_email:$('#kantor_email').val(),
															},
															function(res) {
		if(res.stat){
			location.reload();
		}
	});
}


function formatNumber(myElement) { // JavaScript function to insert thousand separators
	var myVal = ""; // The number part
	var myDec = ""; // The digits pars
	// Splitting the value in parts using a dot as decimal separator
	var parts = myElement.value.toString().split(",");
	// Filtering out the trash!
	parts[0] = parts[0].replace(/[^0-9]/g,""); 
	// Setting up the decimal part
	if ( ! parts[1] && myElement.value.indexOf(",") > 1 ) { myDec = ",00" }
	if ( parts[1] ) { myDec = ","+parts[1] }
	// Adding the thousand separator
	// while ( parts[0].length > 3 ) {
	// 	myVal = "."+parts[0].substr(parts[0].length-3, parts[0].length )+myVal;
	// 	parts[0] = parts[0].substr(0, parts[0].length-3)
	// }
	myElement.value = parts[0]+myVal+myDec;
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

$("#restoUploadButton").click(function (e) {
	tipeupload = 'manual';
	foto_awal = $.trim($("#cover_container_resto").find("img").attr('src'));
    $('#cover_resto').click();
    e.preventDefault();
});

$('#form_upload_resto').submit(function (e) {
	$("[id^=coverdelete]").click(deleteCoverClick); //delete
	$("#cover_container_resto").remove();
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
        url: '<?php echo site_url(); ?>base/c_base/upload_logo',
        data: formData,
        beforeSend: function () {
            $(element).hide().appendTo("#container_resto").fadeIn(300);
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
            			"<div  id=\"cover_container_resto\" class=\"imgContainer imgTab\">" +
            			"<img id=\"imgcover\" src=\"<?php echo base_url().'uploads/system/'; ?>"+data.data.file_name+ "\" height=\"200\" width=\"200\">"+
                        "</div>";
            $("#listImage_resto").html(element).fadeIn(300);
            // $("#imgcover").attr("src", "<?php echo base_url().'uploads/system/'; ?>"+data.data.file_name);
            // $('#container').html(element);
            $.post('<?php echo site_url(); ?>/master/c_constants/save_upload', {jenis:'resto',file_name: data.data.file_name}, function(res) {
            	
            });
            $("#coverdelete").click(deleteCoverClick);
        }
    });
    e.preventDefault();
});

$("#kantorUploadButton").click(function (e) {
	tipeupload = 'manual';
	foto_awal = $.trim($("#cover_container_kantor").find("img").attr('src'));
    $('#cover_kantor').click();
    e.preventDefault();
});

$('#form_upload_kantor').submit(function (e) {
	$("[id^=coverdelete]").click(deleteCoverClick); //delete
	$("#cover_container_kantor").remove();
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
        url: '<?php echo site_url(); ?>/base/c_base/upload_logo',
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
            			"<div  id=\"cover_container_kantor\" class=\"imgContainer imgTab\">" +
            			"<img id=\"imgcover\" src=\"<?php echo base_url().'uploads/system/'; ?>"+data.data.file_name+ "\" height=\"200\" width=\"200\">"+
                        "</div>";
            $("#listImage_kantor").html(element).fadeIn(300);
            // $("#imgcover").attr("src", "<?php echo base_url().'uploads/system/'; ?>"+data.data.file_name);
            // $('#container').html(element);
            $.post('<?php echo site_url(); ?>/master/c_constants/save_upload', {jenis:'kantor',file_name: data.data.file_name}, function(res) {
            	
            });
            $("#coverdelete").click(deleteCoverClick);
        }
    });
    e.preventDefault();
});

function btn_insert_rekening () {
	nama_rek       = $('#nama_rek').val();
	no_rek         = $('#no_rek').val();
	atasnama      = $('#atasnama').val();
	payment_method = $('#payment_method').val();
	if(nama_rek=='' || no_rek=='' || atasnama=='' || payment_method==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url();?>master/c_constants/insert_rekening', {nama_rek:nama_rek, no_rek:no_rek, atasnama:atasnama, payment_method:payment_method}, function(res) {
			if(res.stat){
				location.reload();
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

function btn_update_rekening () {
	id_coa_ledger = <?php echo json_encode(@$dt->id_coa_ledger);?>;
	nama_rek       = $('#nama_rek').val();
	no_rek         = $('#no_rek').val();
	atasnama      = $('#atasnama').val();
	payment_method = $('#payment_method').val();
	if(nama_rek=='' || no_rek=='' || atasnama=='' || payment_method==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		$.post('<?php echo site_url();?>master/c_constants/update_rekening', {id_coa_ledger:id_coa_ledger, nama_rek:nama_rek, no_rek:no_rek, atasnama:atasnama, payment_method:payment_method}, function(res) {
			if(res.stat){
				location.reload();
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

</script>