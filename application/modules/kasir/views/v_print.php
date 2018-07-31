<?php
$dt = $data_utama->row_array();
$dtt = $data_pesanan_semua->row_array();
?>
<html>
<head>
	<title>Print Bill</title>
<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        window.print();
        document.location.href = '<?php echo site_url("kasir/c_kasir/index/2");?>';
        //setTimeout("closePrintView()", 3000);
    });
    //function closePrintView() {
        
</script>
</head>
<body>
	<table>
		<tr>
			<td>asdf</td>
		</tr>
	</table>
</body>
</html>