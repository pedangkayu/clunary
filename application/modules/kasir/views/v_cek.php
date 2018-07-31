<html>
<head>
<title></title>
<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){

/*! Fades in page on load */
$('.notifikasi').css('display', 'none');
$('.notifikasi').slideDown(500);
setTimeout(function() {
	$(".notifikasi").fadeOut(1000);
    },5000)

});
</script>

</head>
<body>


<?php
if (isset($status)) {
    if($status==1){ 
        echo "<div class='notifikasi'>Pesanan berhasil di cetak ke kitchen</div>";
    }elseif($status==2){
        echo "<div class='notifikasi'>Telah Dibayar dan di Cetak</div>";
    }elseif($status==3){
        echo "<div class='notifikasi'>Sukses dimasukkan ke pending bill</div>";
    }elseif($status==4){
        echo "<div class='notifikasi'>Saldo Awal Audit berhasil disimpan</div>";
    }elseif($status==5){
        echo "<div class='notifikasi'>Data Audit Berhasil ditutup</div>";
    }elseif($status==6){
        echo "<div class='notifikasi'>Data Pesanan berhasil dibatalkan</div>";
    }elseif($status==44){
        echo "<div class='notifikasi'>Ulangi proses pembayaran.</div>";
    }
}
?>
<div class="intro">
	   <p><img src="http://localhost/osr/assets/admin/logo_kasir.png" alt="logo" class="logo-default" height="200"/></p>
</div>

</body>
</html>

<style type="text/css">
.div { margin: 0; padding: 0;}
body, html {
	margin: 0;
}

</style>

<style>	
body {
	font-family: sans-serif; font-size:0.8em;
}
            .notifikasi{
                box-sizing:border-box;
                position: fixed;
                border: 0px solid ;
                width: 80%;
                top: 10px;
                left: 10%;
                padding: 5px 10px;
                color: #333;
                font-weight: bolder;
                background-color: #ABFFA3;
                text-align: center;
                -webkit-box-shadow: 12px -2px 16px -10px rgba(59,58,59,0.4);
				-moz-box-shadow: 12px -2px 16px -10px rgba(59,58,59,0.4);
				box-shadow: 12px -2px 16px -10px rgba(59,58,59,0.4);
            }
.intro p {
    font-size: 30px; 
    padding-top: 70px;
    color: #035170;
    margin: 0 60px;
    text-align: right;
}
</style>