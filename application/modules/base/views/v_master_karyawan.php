<div class="page-content">
	<!-- BEGIN PAGE HEAD -->
<div class="row">
	<div class="col-md-12">
	<div class="portlet box grey-cascade">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-user"></i>Master Data Karyawan [RAHASIA]
			</div>
			<div class="actions">
				<a class="btn btn-default btn-sm" data-toggle="modal" href="#" id="add">
				<i class="fa fa-plus"></i> Upload Excel </a>
				
			</div>
		</div>
		<div class="portlet-body">
			aa
		</div>
	</div>
	</div>
	</div>
	<!-- END PAGE CONTENT INNER -->	
</div>

<!-- MODAL EDIT -->
<div id="modal_add_bidang" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>


<script type="text/javascript">
$("#add").click(function(e) {
	e.preventDefault();
	$("#modal_add_bidang").load('<?php echo site_url(); ?>/base/c_base/modal_add_master_karyawan',function() {
		$(this).modal("show");
	});
});
</script>
