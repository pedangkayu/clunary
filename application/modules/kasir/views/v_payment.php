<?php
function rupiah($data='')
	{
		$rupiah = "";
		$jml    = strlen($data);

		while($jml > 3){
			$rupiah = ".".substr($data,-3).$rupiah;
			$l      = strlen($data)-3;
			$data   = substr($data,0,$l);
			$jml    = strlen($data);
		}
		$rupiah = $data.$rupiah;
		return $rupiah;
	}
?>
<html>
<head>
	<title></title>


<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');
	}

	var count= 0;
	

    $("#in_jumlahuang").click(function(){
    	$(this).css('background','#ccc');
    	$(this).keyup(function(){
    		var tagihan = $('#total_pay_0').val();
    		var in_uang = $(this).val();
    		var res = in_uang-tagihan;

    		$('#in_uangkembali').val(res);
    		$('#in_uangkembali_dis').val(convertToRupiah(res));

    		var ink = $('#in_uangkembali').val();
    		if(ink>=0){
    			$('#btn_print').attr('disabled', false);
    			$('#btn_print_only').attr('disabled', true);
    		} else {
    			$('#btn_print').attr('disabled', true);
    			$('#btn_print_only').attr('disabled', false);
    		}
    	});
    	
	});
	    	
});
</script>



</head>
<body>
<div class="wrapper">
<?php
if(isset($paysave)){
	if($action!='pay') $dis ='disabled'; else $dis='';
	?>
<div id="payment_field">
	<form action="<?php echo site_url('kasir/c_transaksi/proses_pay');?>" method="POST" target="_top">
	<!-- data post dri form sebelumnya ---->
			<input type="text" name="id_pesanan_main" value="<?php echo $id_pesanan_main; ?>" style="display:none;">
			<input type="text" id="id_pesanan_pend" name="id_pesanan_pend" value="<?php echo $id_pesanan_pend; ?>" style="display:none;">
			<input type="text" name="diskon_suteki" id="diskon_suteki" value="<?php echo $diskon_suteki; ?>" style="display:none;">
			<input type="text" name="diskon_fonte" id="diskon_fonte" value="<?php echo $diskon_fonte; ?>" style="display:none;">

			<!-- input type="text" name="tax_v" value="<?php echo $pajak; ?>" style="display:none;" -->
			<!-- input type="text" name="tax_value" value="<?php echo $tax_value;?>" style="display:none;" -->
			<!-- input type="text" name="tax_price" value="<?php echo $tax_price; ?>" style="display:none;" -->

			<input type="text" name="service_fee_value" value="<?php echo $service_fee_value;?>" style="display:none;">
			<input type="text" name="service_fee_price" value="<?php echo $service_fee_price; ?>" style="display:none;">
			<input type="text" name="total_order" value="<?php echo $total_order; ?>" style="display:none;">
			<input type="text" name="status" value="<?php echo $status; ?>" style="display:none;">

		<!-- input type="text" name="id_pesanan" value="<?php echo $_POST['id_pesanan']; ?>" style="display:none;" -->
		<table>
			<tr>
				<td colspan="2" align="right">
						<input type="hidden" name="total_pay" id="total_pay_0"  value="<?php echo $total_pay; ?>" >
						<input type="text" id="total_pay" value="<?php echo rupiah($total_pay); ?>" readonly>
				</td>
			</tr>
			<tr class="  <?php echo $dis; ?>">
				<td width="50%">Cara Pembayaran</td>
				<td width="50%" align="right">
					<div class="cara_bayar">
						<select class="option_pay" name="option_pay"   <?php echo $dis; ?> >
							<?php
							foreach ($paymentmethod->result() as $r) {
								echo '<option value="'.$r->payment_method.'">'.$r->payment_method.'</option>';
							}
							?>
						</select>
					</div>
				</td>
			</tr>
			<tr class="  <?php echo $dis; ?>">
				<td>Jumlah Uang</td>
				<td align="right"><div class="jumlah_uang">
					<input type="text" name="jumlah_uang" class="in_jumlahuang" id="in_jumlahuang" autocomplete="off" <?php echo $dis; ?> >
					<div id="tmp" style="display:none;"></div>
				</div></td>
			</tr>
			<tr class="  <?php echo $dis; ?>">
				<td>Uang Kembali</td>
				<td align="right"><div class="uang_kembali">
					<input type="hidden" name="uang_kembali" class="in_uangkembali" id="in_uangkembali" readonly>
					<input type="text" name="uang_kembali_x" class="in_uangkembali" id="in_uangkembali_dis" readonly   <?php echo $dis; ?>>
				</div></td>
			</tr>
			<tr>
				<td colspan="2">
				        <button name="print" id="btn_print" class="btn_savep" value="pay" onclick="SubmitMe()">Pay & Print</button>
					    <button name="print" id="btn_print_only" class="btn_savep" value="print" >Print Invoice</button>
				</td>
				
			</tr>
		</table>
	</form>

<!-- div class="keypad">
	<div class="numpad">
		<div class="w_numkey">
			<button class="numkey" value="7">7</button>
			<button class="numkey" value="8">8</button>
			<button class="numkey" value="9">9</button>
			<button class="numkey" value="4">4</button>
			<button class="numkey" value="5">5</button>
			<button class="numkey" value="6">6</button>
			<button class="numkey" value="1">1</button>
			<button class="numkey" value="2">2</button>
			<button class="numkey" value="3">3</button>
			<button class="numkey" value="">+/-</button>
			<button class="numkey" value="0">0</button>
			<button class="numkey" value=",">,</button>

		</div>
		<div class="w_funkey">
			<button class="funkey" value="" id="del">Dell</button>
			<button class="funkey" id="clear" value="">Clear</button>
		</div>

	</div>
</div -->

<?php 
}
?>
</div>

</body>
</html>
<style type="text/css">
body {font-family: sans-serif; font-size:0.8em; margin: 0; padding: 0; width: 100%;}

#payment_field{
	 background: #149314;
	 background: #ccccff;
	 background: #666;
	 background: #fff;
	background: #F2F2F2;
	 padding:10px;
	 margin: 0px;
	 border: 0px solid #666;
	 border-radius: 5px;
}
.wrapper { padding: 0; margin: 10px; border:1px solid #ccccff;
	  }
#payment_field table {font-family: sans-serif; font-size:1em; width: 100%;}

#payment_field input, #payment_field select {

	border: 1px solid #999;
	box-shadow: inset -2px -1px 9px -4px #8F8D8D;
-webkit-box-shadow: inset -2px -1px 9px -4px #8F8D8D;
-moz-box-shadow: inset -2px -1px 9px -4px #8F8D8D;
-o-box-shadow: inset -2px -1px 9px -4px #8F8D8D;
}
#total_pay {
	font-size: 3em;
	text-align: right;
	width: 50%;
}
.option_pay { width: 50%; padding: 5px;}
#in_jumlahuang:focus{
	

}


.in_uangkembali, .in_jumlahuang{
	text-align: right;padding: 3px 7px 5px 7px;
	color:#333; font-size: 1.5em;
	width: 50%;
}
.btn_savep { font-size: 1em; line-height: 50px;}
.keypad {display: ;
	margin: 0px; padding:0px ; box-sizing:border-box;
	}
.numpad {
	box-sizing:border-box;
	width: 100%;
	background: #ccccff;
	background: #C2C2C2;
	overflow: hidden;
	border: 0px solid #666;
	padding: 10px;
	border-radius: 0px;
}
.w_numkey{
	width: 70%;
	float: left;
	background:;
}
.w_funkey {
	width: 30%;
	float: left;
	background:;
	background: ;
}
.numkey {
	width: 32%;
	margin: 0;
	font-size: 1.5em;
	line-height: 50px;

}
.funkey {
	width: 100%;
	font-size: 1.5em; line-height: 50px;
}
#use_osk {
	display: inline-block;
	width: 10px;
	height: 10px;
	border: 1px solid #666;
	margin: 10px 1px 0px 5px;
	background: #000;
}
.disabled {
	opacity: 0.4;
	 
}
</style>
