<?php $this->load->view('base/v_head');?>
<body class="page-md page-header-fixed page-quick-sidebar-over-content page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<?php $this->load->view('base/v_header'); ?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php 
    	if (isset($left_layout) && !empty($left_layout)) {
            echo $left_layout;
        }
    ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<?php echo @$content_layout;?>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php $this->load->view('base/v_footer');?>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
