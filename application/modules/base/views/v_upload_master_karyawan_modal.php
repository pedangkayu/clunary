<!-- MODAL TAMBAH -->
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" onclick="btn_close_modal();"></button>
			<h4 class="modal-title">
				Upload Excel Master Karyawan
			</h4>
		</div>
		<div class="modal-body">
			<div class="form-body">
				<form method="post" class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-md-4">Nama District<span class="required">
						* </span>
						</label>
						<div class="col-md-6">
							<select class="form-control select2me" name="select" id="district_id">
								<option value="">-- Pilih --</option>
								<?php
								foreach ($district->result_array() as $dis) {
									echo '<option value="'.$dis['district_id'].'">'.$dis['district_kode'].' - '.$dis['district_nama'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
				</form>
				<form action="" method="post" enctype="multipart/form-data" id="form_upload_karyawan" class="form-horizontal">
					<div class="form-group" >
						<label class="control-label col-md-2">File <span class="required">
						* </span>
						</label>
						<div class="col-md-4">
							<button id="dokumenUploadButton" class="btnSize btn btn-green text-uppercase pull-right col-md-12">Upload</button>
							<div id='container_dokumen'>
								<input id="cover_dokumen" onchange="$('#form_upload_karyawan').submit();" name="cover_dokumen" type="file" accept="file/*" style="display:none">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn blue" onclick="event.preventDefault();btn_close_modal();">Close</button>
		</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$('select.select2me').select2({
    placeholder: "Select",
    allowClear: true
});

$("#dokumenUploadButton").click(function (e) {
    e.preventDefault();
	district_id            = $('#district_id').val();
    if(district_id==''){
    	alert('Anda belum memilih district.');
    }else{
		$('#cover_dokumen').click();
    }
    
});
var requestStack = {};
$('#form_upload_karyawan').submit(function (e) {
    var formData = new FormData(($(this)[0]));
	formData.append('district_id', $('#district_id').val());
    var c = 0;
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
        url: '<?php echo site_url(); ?>/base/c_base/upload_master_karyawan',
        data: formData,
        beforeSend: function () {
            $(element).hide().appendTo("#container_dokumen").fadeIn(300);
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

        }
    })
	.done(function(data) {
        alert('selesai');
        btn_close_modal();
	});
    e.preventDefault();
});

function btn_close_modal () {
	$("#modal_add_bidang").modal("hide");
}

</script>