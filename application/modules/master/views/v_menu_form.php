<?php
if($mode=='add'){
	$title = 'Tambah Menu';
}elseif($mode=='edit'){
	$title = 'Edit Menu';
	$dt = $menu->row();
}elseif($mode=='view'){
	$title = 'View Menu';
	$dt = $menu->row();
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
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_1_1" data-toggle="tab">
					Informasi Menu </a>
				</li>
				<li>
					<a href="#tab_1_2" data-toggle="tab">
					Informasi Komposisi </a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade active in" id="tab_1_1">
					<div class="form-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Perusahaan <font color="orange">(*)</font></label>
									<select class="form-control input-xlarge" id="id_perusahaan" disabled>
										<option value="">- Perusahaan -</option>
										<?php
										foreach ($perusahaan->result() as $r) {
											$terpilih = '';
											if($r->id_perusahaan==@$dt->id_perusahaan){
												$terpilih = 'selected';
											}
											echo '<option value="'.$r->id_perusahaan.'" '.$terpilih.'>'.$r->nama_perusahaan.'</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Kategori Menu <font color="orange">(*)</font></label>
									<select class="form-control input-xlarge" id="kode_kategori" disabled>
										<option value="">- Kategori Menu -</option>
										<?php
										foreach ($kategori->result() as $r) {
											$terpilih = '';
											if($r->kode_kategori==@$dt->kode_kategori){
												$terpilih = 'selected';
											}
											echo '<option value="'.$r->kode_kategori.'" '.$terpilih.'>'.$r->nama_kategori.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Status</label><br>
									<input type="checkbox" id="status_menu" class="make-switch" data-on-color="success" data-off-color="warning" data-on-text="&nbsp;Aktif&nbsp;" data-off-text="&nbsp;Nonaktif&nbsp;" <?php echo ($mode=='add' || @$dt->flag_hapus==0) ? 'checked' : '';?>>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Nama Menu <font color="orange">(*)</font></label>
									<input type="text" class="form-control input-xlarge" id="nama_menu" value="<?php echo @$dt->nama_menu; ?>" placeholder="Nama menu" disabled>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Nama Alias <font color="orange">(*)</font></label>
									<input type="text" class="form-control input-xlarge" id="alias_menu" value="<?php echo @$dt->alias_menu; ?>" placeholder="Nama Alias" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Deskripsi <font color="orange">(*)</font></label>
									<textarea class="form-control input-xlarge" id="deskripsi" readonly><?php echo @$dt->deskripsi;?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Harga (Rp) <font color="orange">(*)</font></label>
									<input type="text" class="form-control input-large" id="harga" value="<?php echo @$dt->harga; ?>" placeholder="Harga (Masukkan Angka)" onkeyup="formatNumber(this)" disabled>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Discount (%)</label>
									<input type="text" class="form-control input-large" id="discount" value="<?php echo @$dt->discount; ?>" placeholder="Discount (Masukkan Angka)" onkeyup="formatNumber(this)" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Gambar <font color="orange">(* Ukuran 500x500)</font></label><br>
									<button id="beritaImageUploadButton" class="btn btn-green ">Upload</button><br>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<center>
								<form action="" method="post" enctype="multipart/form-data" id="form_upload" class="form-horizontal">
									<div class="form-group">
										<input id="cover" onchange="$('#form_upload').submit();" name="cover" type="file" accept="image/*" style="display:none">
										<div id="listImage">
											<?php
											$gambar_url = base_url().'uploads/menu/no-image.jpg';
											if(!empty($dt->gambar_menu)){
												$gambar_url = base_url().'uploads/menu/'.@$dt->gambar_menu;
											}
											?>
											<div  id="cover_container" class="imgContainer imgTab">
						        				<img id="imgcover" src="<?php echo $gambar_url; ?>" height="300" width="300">
						                    </div>
							            </div>
									</div>
								</form>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="tab_1_2">
					<div class="form-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Bahan <font color="orange">(*)</font></label><br>
									<select class="form-control input-xlarge select2me" id="kode_bahan" disabled>
										<option value="">- Nama Bahan -</option>
										<?php
										foreach ($bahan->result() as $r) {
											echo '<option value="'.$r->id_bahan.'">'.$r->nama_bahan.' ('.$r->satuan.')</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Jumlah <font color="orange">(*)</font></label>
									<input type="text" class="form-control input-xlarge" id="jml_bahan" placeholder="Jumlah (Masukkan Angka)" onkeyup="formatNumber(this)" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
							</div>
							<div class="col-md-6">
								<button type="button" class="btn blue" onclick="add_komposisi();">Tambah</button>
							</div>
						</div>
						<table class="table table-bordered table-hover" id="table_bahanmenu">
							<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Satuan</th>
								<th>Jumlah</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			<div class="form-actions right">
				<?php
				$title_closebutton = 'Cancel';
				if($mode=='add'){
					echo '<button type="button" class="btn blue" onclick="save();">Simpan</button>';
				}elseif($mode=='edit'){
					echo '<button type="button" class="btn green" onclick="save();">Update</button>';
				}elseif($mode=='view'){
					$title_closebutton = 'Close';
				}
				?>
				<button type="button" class="btn default" onclick="btn_close();"><?php echo $title_closebutton;?></button>
			</div>
	</div>
</div>

<script type="text/javascript">
var tipeupload='';
var foto_awal='';
kode_menu = 0;
id   = <?php echo json_encode(@$dt->id_menu);?>;
mode = <?php echo json_encode($mode);?>;
if(mode=='add' || mode=='edit'){
	$('.form-control').removeAttr('disabled');
	$('.form-control').removeAttr('readonly');
	if(mode=='edit'){
		kode_menu = <?php echo json_encode(@$dt->kode_menu);?>;
	}
}
$('.make-switch').bootstrapSwitch();
$('select.select2me').select2({
    placeholder: "Select",
    allowClear: true
});

$('#kode_bahan').change(function(event) {
	event.preventDefault();
	if(kode_menu==0){
		alert('Silahkan lengkapi Informasi Menu termasuk upload gambar.');
	}else{
		kode_bahan = $('#kode_bahan').val();
		$.post('<?php echo site_url("master/c_menu/cek_bahanmenu");?>', {kode_menu:kode_menu, kode_bahan:kode_bahan}, function(res) {
			if(res.jml>0){
				alert('Bahan tersebut sudah ada.');
				$('#kode_bahan').val('');
			}
		});
	}
});

function save () {
	if(kode_menu==0){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : "Tanda (*) wajib diisi termasuk upload gambar.", //ini isi pesan
			title : 'Warning', //ini judul pesan
		});
	}else{
		id_perusahaan = $('#id_perusahaan').val();
		kode_kategori = $('#kode_kategori').val();
		nama_menu     = $('#nama_menu').val();
		alias_menu    = $('#alias_menu').val();
		deskripsi     = $('#deskripsi').val();
		harga         = $('#harga').val();
		discount      = $('#discount').val();
		status_menu   = $('#status_menu:checked').val();
		if(id_perusahaan=='' || kode_kategori=='' || nama_menu=='' || alias_menu=='' || deskripsi=='' || harga==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Tanda (*) wajib diisi termasuk upload gambar.", //ini isi pesan
				title : 'Warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url();?>/master/c_menu/cek_komposisi', {kode_menu: kode_menu}, function(res) {
				if(res.jml==0){
					NotifikasiToast({
						type : 'warning', // ini tipe notifikasi success,warning,info,error
						msg : "Anda belum memasukkan komposisi (min 1).", //ini isi pesan
						title : 'Warning', //ini judul pesan
					});
				}else{
					$.post('<?php echo site_url("master/c_menu/update");?>', 
																	{
																		kode_menu:kode_menu,
																		id_perusahaan:id_perusahaan,
																		kode_kategori:kode_kategori,
																		nama_menu:nama_menu,
																		alias_menu:alias_menu,
																		deskripsi:deskripsi,
																		harga:harga,
																		discount:discount,
																		status_menu:status_menu,
																	}, 
																	function(res) {
						if(res.stat){
							NotifikasiToast({
								type : 'success', // ini tipe notifikasi success,warning,info,error
								msg : 'Menu berhasil diperbarui.', //ini isi pesan
								title : 'Success', //ini judul pesan
							});
							$('#form_add_edit').attr('style', 'display:none;');
							table_menu.getDataTable().ajax.reload();
						}else{
							NotifikasiToast({
								type : 'error', // ini tipe notifikasi success,warning,info,error
								msg : res.pesan, //ini isi pesan
								title : 'Error', //ini judul pesan
							});
							$("#form_add_edit").removeAttr('style');
							table_menu.getDataTable().ajax.reload();
						}
					});
				}
			});
		}
	}
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

function add_komposisi () {
	if(kode_menu==0){
		alert('Silahkan lengkapi Informasi Menu termasuk upload gambar.');
	}else{
		kode_bahan = $('#kode_bahan').val();
		jml_bahan = $('#jml_bahan').val();
		if(kode_bahan=='' || jml_bahan==''){
			NotifikasiToast({
				type : 'warning', // ini tipe notifikasi success,warning,info,error
				msg : "Bahan dan Jumlah Bahan wajib diisi", //ini isi pesan
				title : 'warning', //ini judul pesan
			});
		}else{
			$.post('<?php echo site_url("master/c_menu/insert_bahanmenu");?>', {kode_menu:kode_menu, kode_bahan:kode_bahan, jml_bahan:jml_bahan}, function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : "Data Bahan Komposisi berhasil ditambahkan.", //ini isi pesan
						title : 'Success', //ini judul pesan
					});
					table_bahanmenu.getDataTable().ajax.reload();
					$('#kode_bahan').val('');
					$('#jml_bahan').val('');
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
}

function btn_delete_bahanmenu (id_bahanmenu) {
	var sure = confirm("Apakah Anda yakin menghapus data ini?");
	if (sure) {
		$.post('<?php echo site_url(); ?>/master/c_menu/delete_bahanmenu?id_bahanmenu='+id_bahanmenu, {}, function(res) {
			if(res.stat){
				NotifikasiToast({
					type : 'success', // ini tipe notifikasi success,warning,info,error
					msg : "Data Bahan Komposisi berhasil dihapus.", //ini isi pesan
					title : 'Success', //ini judul pesan
				});
			table_bahanmenu.getDataTable().ajax.reload();
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

$("#beritaImageUploadButton").click(function (e) {
	tipeupload = 'manual';
	foto_awal = $.trim($("#cover_container").find("img").attr('src'));
    $('#cover').click();
    e.preventDefault();
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
        url: '<?php echo site_url(); ?>base/c_base/upload_img',
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
            			"<img id=\"imgcover\" src=\"<?php echo base_url().'uploads/menu/'; ?>"+data.data.file_name+ "\" height=\"400\" width=\"300\">"+
                        "</div>";
            $("#listImage").html(element).fadeIn(300);
            $("#imgcover").attr("src", "<?php echo base_url().'uploads/menu/'; ?>"+data.data.file_name);
            // $('#container').html(element);
            $.post('<?php echo site_url(); ?>/master/c_menu/save_upload', {kode_menu: kode_menu,file_name: data.data.file_name}, function(res) {
            	if(kode_menu==0){
            		kode_menu = res.last_id;
            	}
            });
            $("#coverdelete").click(deleteCoverClick);
        }
    });
    e.preventDefault();
});

var table_bahanmenu = new Datatable();
table_bahanmenu.init({
    src: $("#table_bahanmenu"),
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
            "url": "<?php echo site_url() ?>/master/c_menu/get_bahanmenu", // ajax source
            data: function (d) {
            	d.kode_menu = kode_menu;
            	d.mode = mode;
            }
        },
        "columns": [
	        {"orderable": false},
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
</script>