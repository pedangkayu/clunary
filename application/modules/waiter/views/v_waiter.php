<div class="page-content">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase">Order Pesanan</span>
					</div>
					<div class="actions" style="display:none;">
						<a href="#" class="btn btn-circle btn-danger btn-sm" onclick="btn_add()">
						<i class="fa fa-plus"></i> Add </a>
						<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#">
						</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="tabbable tabbable-tabdrop" id="tabcontent">
						
					</div>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
	</div>
</div>

<div id="modal_form" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>

<div id="modal_form_confirm" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>

<div id="modal_form_pesanan" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
</div>

<script type="text/javascript">
status_pemesanan = <?php echo json_encode($status_pemesanan);?>;
update();

function update () {
	$('#tabcontent').load('<?php echo site_url();?>/waiter/c_waiter/load_order/'+status_pemesanan);
	window.setTimeout(update, 5000);
}

function btn_add () {
	$("#modal_form").load('<?php echo site_url(); ?>/waiter/c_waiter/form_add',function() {
		$(this).modal("show");
	});
}
</script>