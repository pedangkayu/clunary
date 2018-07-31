<!-- <button type="button" onclick="cetak('e1','P');" class="btn default">Cetak Surat Izin</button> -->

<script type="text/javascript">
	function cetak(jenis,orientasi) {
		window.open("<?php echo site_url(); ?>c_form_cetak/cetak/"+pk_id+"/"+jenis+"/"+orientasi,"_blank")     	
    }
</script>