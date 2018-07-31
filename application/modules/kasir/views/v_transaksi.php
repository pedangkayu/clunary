<?php
function rupiah($data) {
  $rupiah = "";
  $jml    = strlen($data);

  while($jml > 3)
  {
     $rupiah = ".".substr($data,-3).$rupiah;
     $l      = strlen($data)-3;
     $data   = substr($data,0,$l);
     $jml    = strlen($data);
  }
  $rupiah =$data.$rupiah;
  return $rupiah;
};?>

<?php
$dt             = $pemesanan->row_array();
$id             = $dt['id_pesanan'];
$meja           = $dt['kode_meja'];
$pemesan        = $dt['nama_pemesan'];
$status_pesan   = $dt['status_pemesanan'];
$total_order    = $dt['total_biaya'];
$kode_pemesanan = $dt['kode_pemesanan'];
?>
<script type="text/javascript" src="<?php echo base_url();?>assets_kasir/js/jquery-latest.js"></script>
<script type="text/javascript">

function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');
}
function cek (){
	alert('hello');
}

function btn_batal_order (id) {
	var sure = confirm('Apakah Anda yakin membatalkan transaksi ini?');
	if(sure){
		$.post('<?php echo site_url();?>kasir/c_transaksi/batal_order', {id:id}, function(res) {
		});
	}
}


// function change_disc(kode_menu){
// 	var disc_item = parseInt($('#'+kode_menu).val());
// 	var harga_item = $('#'+kode_menu).data('harga');
// 	if(disc_item>100 || !parseInt($('#'+kode_menu).val())){
// 		if(disc_item==0){
// 			var disc_item_price = harga_item * (disc_item/100);
// 			$('#price'+kode_menu).html(harga_item-disc_item_price);
// 		}else{
// 			alert('Diskon per item harus diantara 0 - 100');
// 			$('#'+kode_menu).val('0');
// 			$('#price'+kode_menu).html(harga_item);
// 		}
// 	}else{
// 		var disc_item_price = harga_item * (disc_item/100);
// 		$('#price'+kode_menu).html(harga_item-disc_item_price);
// 	}
// 	// console.log($('#'+kode_menu).data('harga'));
// 	// $('.disc_item').val();
// }

$(document).ready(function(){
	
    $(".val_dis").keyup(function(){
		var id_pesanan_pend_dis = $('#id_pesanan_pend').val();
		var id_pesanan_main_dis = $('#id_pesanan_main').val();
    	var total = 0;
    	$.post('<?php echo site_url();?>/kasir/c_transaksi/get_total_pesanan', {id_pesanan_main_dis:id_pesanan_main_dis,id_pesanan_pend_dis: id_pesanan_pend_dis}, function(res) {
    		total_suteki = res.total_suteki;
    		total_fonte = res.total_fonte;

    		var dis_suteki = $("#val_dis").val();
    		var dis_fonte = $("#val_dis_fonte").val();
	        var total_order_dis = $('#totale').text();
	        var nil_diskon_suteki = total_suteki * dis_suteki /100;
	        var nil_diskon_fonte = total_fonte * dis_fonte /100;
	        var terdiskon = total_order_dis - nil_diskon_fonte;
	        // var nilaitax = parseInt($('#nilaitax').text());
	        var nilaiservice = parseInt($('#nilaiservice').text());
	        var adt = terdiskon+nilaiservice;
	       
	        $("#gtotal1").val(convertToRupiah(adt));
	        $("#gtotal2").val(adt);
	        $("#gtotal22").val(adt);
	        $("#diskon_suteki1").val(dis_suteki);
	        $("#diskon_suteki2").val(dis_suteki);
	        $("#diskon_fonte1").val(dis_fonte);
	        $("#diskon_fonte2").val(dis_fonte);
    	});
    });

    $('#btn_join').click(function(){
  		var idm = $('#idd').html();
  		$('#pending_bill_list').load('<?php echo site_url();?>/kasir/c_transaksi/content_join_bill/'+idm, function() {
  			$(this).slideDown('fast');
  		});;
  	});

  	$('.btn_joinkan').click(function(){
  		
  		var id= $(this).val();
  		
  		$('.x_id_pesanan').text(id);
  	});
	
	var countklick = 0;
	
	
	$('#tampil_list_pending').change(function(){
		alert('yaa');
	});

});


</script>
<div class="wrapper">
	<div class="w_transaksi">
		<div class="header_transaksi">
			<div class="ket_">
				  
				<label class="isi"><?php echo $kode_pemesanan.'/'.$meja.'/'.$pemesan;?> ID : 
				<label id="idd"><?php echo $id; ?></label></label>
			</div>
			<?php
			if($status_pesan==2 or $status_pesan==3){
				?>
				<div class="btn_join_bill" id="btn_join">Join Bill</div>
				<?php
			}
			?>
			<!-- div class="total_payed">Total Pay (Rp): <br><span id="grandtotal1"><?php echo  $total_order + ($total_order*0.1); ?></span></div -->
		</div>
		<!-- div class="displaytotal">Rp<br><span>100.000</span></div>-->
		<div class="detail_transaksi">
			<div class="rowname">
				
				<div class="rowname1">Qty</div>
				<div class="rowname0">Item</div>
				<div class="rowname2">Subtotal</div>
			</div>
			<div class="w-rowlist">
			<?php
			
			$total_bayar=0;
			$total_order=0;
			foreach ($list_pesanan->result_array() as $r) {
				$total_bayar = $total_bayar + $r['subtotal'];
				$total_order = $total_order + $r['harga'];
				?>
				<div class="rowlist">
					<div class="rowlist1"><?php echo $r['qty']; ?></div>
					<div class="rowlist0"><?php echo $r['nama_menu']; ?></div>
					<div class="rowlist2" id="<?php echo 'price'.$r['kode_menu'];?>"><?php echo rupiah($r['harga']);?></div>
				</div>
				<?php
				if($r['discount']!=0){
					?>
					<div class="rowlist">
						<div class="rowlist1"></div>
						<div class="rowlist0"></div>
						<div class="rowlist2" id="<?php echo 'price'.$r['kode_menu'];?>"><i>(-<?php echo $r['discount'];?>%) <?php echo rupiah($r['subtotal']);?></i></div>
					</div>
					<?php
				}
				?>
				<?php
			}
			?>
			</div>
			<div class="w_total_xx">Total Bill : 
				<input type="hidden" id="total_order" value="<?php echo $total_order; ?>">
				<input type="hidden" id="total_bayar" value="<?php echo $total_bayar; ?>">
				<input type="hidden" size="10" id="total_main_bill"  class="totalan"value="<?php echo $total_bayar; ?>" readonly>
				<input type="text" size="10" id="total_main_"  class="totalan"value="<?php echo rupiah($total_bayar); ?>" readonly>
			</div>
		</div>
		<?php
		if($status_pesan==2 or $status_pesan==3){
			?>
			<div class="list_to_join" id="list_to_join">
				<p id="p">Bill yang akan digabung :</p>
				<div id="tampil_list_pending">
					<!-- content list pending yang akan digabung -->
				</div>	
			</div>
			<?php
		}
		?>

		<div class="pending_bill_list" id="pending_bill_list">
				<!-- content join bill -->
		</div>

		<?php
		if($status_pesan==2 or $status_pesan==3){
			?>
			<div class="w_dpx">
				<table border="0">
					<tr>
						<td width="26%">Total Order </td>
						<td width="3%">:</td>
						<td width="12%" align="right">
							<div class="total_order jadirupiah" id="totale" hidden><?php echo $total_bayar; ?></div>
							<div class="total_order jadirupiah" id="totale_h"><?php echo rupiah($total_bayar); ?></div>
						</td>
						<td align="right"width="50%" rowspan="3">Total Bayar (Rp)
						
							<?php $total_pay=$total_bayar + ($total_order*$service_fee); ?>
							<!-- input type="text" id="gtotal" name="total_bayar" class="grandtotal" value="<?php echo $total_pay; ?>" readonly -->
							<input type="text" id="gtotal1" name="total_bayar_h" class="grandtotal" value="<?php echo rupiah($total_pay); ?>" readonly>
								
							</td>
					</tr>
					<!-- tr>
						<td>+ Tax <?php echo $pajak*100;?>%  </td>
						<td>:</td> <?php $tax=$total_bayar*$pajak; ?>
						<td align="right"><div class="val_tax" id="nilaitax"><?php echo $tax; ?></div></td>
					</tr -->

					<tr>
						<td>+ Service <?php echo $service_fee*100;?>%  </td>
						<td>:</td> <?php $service_fee_price=$total_order*$service_fee; ?>
						<td align="right">
							<div class="val_tax" id="nilaiservice" hidden><?php echo $service_fee_price; ?></div>
							<div class="val_tax" id="nilaiservice_h"><?php echo rupiah($service_fee_price); ?></div>
						</td>
					</tr>

					
					<tr>
						<td>Disc (%) </td>
						<td>:</td>
						<td align="right"><div class="val_dis"><input type="text" id="val_dis_fonte" name="value_diskon_fonte"></div></td>
					</tr>

					<!-- tr>
						<td>Disc Gundala (%) </td>
						<td>:</td>
						<td align="right"><div class="val_dis"><input type="text" id="val_dis" name="value_diskon"></div></td>
					</tr -->

				</table>
			</div>
			<?php
		}
		?>
			
	</div>
	<div class="keyboard">
		<?php
		if($status_pesan==2){
			?>
			<form action ="<?php echo site_url('kasir/c_transaksi/payment');?>" method="POST">
				<div class="btn_pay">
						<input id="id_pesanan_main" type="text" name="id_pesanan_main" value="<?php echo $id; ?>" style="display:none	;">
						<input id="id_pesanan_pend" type="text" name="id_pesanan_pend" value="0" style="display:	none;">
						<input id="tax_v" name="tax_v" type="hidden" value="<?php echo $pajak; ?>">
						<input type="text" name="diskon_suteki" id="diskon_suteki1" value="0" style="display:none;">
						<input type="text" name="diskon_fonte" id="diskon_fonte1" value="0" style="display:none;">
						<input type="text" name="tax_value" id="tax_value" value="<?php echo $pajak*100;?>" style="display:none;">
						<input type="text" name="tax_price" id="tax_price" value="<?php echo $tax; ?>" style="display:none;">
						<input type="text" name="service_fee_value" id="service_fee_value" value="<?php echo $service_fee*100;?>" style="display:none;">
						<input type="text" name="service_fee_price" class="service_fee_price" value="<?php echo $service_fee_price; ?>" style="display:none;">
						<input type="text" name="total_order" id="tax_price" value="<?php echo $total_bayar; ?>" style="display:none;">
						<input type="text" name="total_pay" id="gtotal2" value="<?php echo $total_pay; ?>" style="display:none;">
						<input type="text" name="action"  value="pay" style="display:none;">
						<input type="text" name="status"  value="<?php echo $status_pesan; ?>" style="display:none;">
						<button class="bt" name="paysave">Payment</button>
				</div>

				<div class="btn_pay" style="margin-left:10px;">
						<button class="bt" name="paysave">Print Bill</button>
				</div>
			</form>
 
            <div style="border: 1px dashed #DDD; margin-top:40px; margin-bottom: 12px;"></div>
			<form action ="<?php echo site_url('kasir/c_transaksi/proses_pending_bill');?>" method="POST" target="_top">
				<div class="btn_pay">
					<input type="text" name="id_pesanan" value="<?php echo $id; ?>" style="display:none;">
					<button class="bt" name="pendingbill">Pending Bill</button>
				</div>	
			</form>

 	
		<?php
		}elseif($status_pesan==3){
			?>
			<form action ="<?php echo site_url('kasir/c_transaksi/payment');?>" method="POST">
			<div class="btn_pay">
					<button class="bt" name="paysave">Print Bill</button>
			</div>
			</form>
			
			<!-- div class="btn_pay">
				<form action ="<?php echo site_url('kasir/c_transaksi/hapus_pending_bill');?>" method="POST" target="_top">
					<input type="text" name="id_pesanan" value="<?php echo $id; ?>" style="display:none;">
					<button class="bt" name="hapus_pending_bill">Hapus Pending</button>
				</form>
			</div -->

			<?php
		}elseif($status_pesan==4){
			?>
			<form action ="<?php echo site_url('kasir/c_transaksi/payment');?>" method="POST">
			<div class="btn_pay">
					<button class="bt" name="paysave">Print Bill</button>
			</div>
			</form>
			<?php
		}
		?>
		<?php if($status_pesan==1) { ?>

		<div class="btn_ptk">
			<div class="ptk">
				<form action="<?php echo site_url('kasir/c_transaksi/ordertokitchen');?>" method="POST" target="_top">
					<input type="text" name="id_pesanan" value="<?php echo $id; ?>" style="display:none;">
					<input type="text" name="ch_status_pemesanan" value="2" style="display:none;">
					<button class="" name="print_k">Order to Kitchen</button>
				</form>
			</div>

			<div class="ptk">
				<form action="<?php echo site_url('kasir/c_transaksi/batal_order');?>" method="POST" target="_top">
					<input type="text" name="id_pesanan" value="<?php echo $id; ?>" style="display:none;">
					<button class="" onclick="return confirm('Apakah Anda yakin membatalkan pesanan ini?');">Batal</button>
				</form>
			</div>
		</div>
		
		<?php }

		?>
	</div> 
		 
</div>

<style>




div { box-sizing:border-box;}
body, html {margin: 0; padding: 0; width: 100%;}
.wrapper {margin: 0; padding: 0; border: 0px solid #f00; 
	box-sizing:border-box;
	font-family: sans-serif; font-size: 0.8em;  width:95%; margin: 5px auto 0px auto;
}
p { margin: 0;}
table { font-size: 10px;}

.header_transaksi {text-align: left; border: 0px solid #666; padding: 0px; background: ; overflow: hidden; margin-bottom: 10px;
				-webkit-box-shadow: 0px 0px 3px 2px #999;
-moz-box-shadow:    0px 0px 3px 2px #999;
box-shadow:         0px 0px 3px 2px #999;
	background:#00A4DB;
}
.header_transaksi .ket_ { border: 0px solid #00A4DB; background:#00A4DB; color: #333; text-transform: uppercase; font-weight: normal; 
		float: left;
		border-radius: 0px; margin-bottom: 0px; padding: 5px 5px;  width: 100%; overflow: hidden; 
		height:25px;max-height: 25px; box-sizing:border-box;
		width: 80%;}

.header_transaksi .label { width:100%; }
.isi {}
.total_payed {float: right; background: #fff;  border:1px solid #666; display: inline-block; padding: ; width: 35%; font-size: 0.9em; padding: 0 5px; text-align: right;}
.total_payed span { font-size: 25px;}

.displaytotal { display: inline-block; text-align: right; width: 40%; padding:17px 7px; border:1px solid #ccc; font-weight: bolder; color: #ff0; 
	background: #0357ae; vertical-align: top; margin: 5px;  }
.displaytotal>span { font-size: 39px;}

.detail_transaksi { border:0px solid #D5E9F0; margin: 0px;padding: 0; border-radius:0px; margin-bottom: 10px; 
	-webkit-box-shadow: 0px 0px 3px 2px #999;
-moz-box-shadow:    0px 0px 3px 2px #999;
box-shadow:         0px 0px 3px 2px #999;
	}
.rowname {color: #333; font-weight: bolder; display: inline-block; width: 100%;  border-top-left-radius: 0px; 
	border-top-right-radius: 0px;
	border:0px solid #00A4DB; background: #00A4DB;box-sizing:border-box; padding: 0 3px;

}
.rowname>div{ margin: 0; 
	display: inline-block;border: 0px solid #ccc;text-align: left; padding: 5px 5px ;text-align: center;
}
.rowname0 { width: 55%;}
.rowname1 { width: 8%;}
.rowname2 { width: 30%;}

.w-rowlist { min-height: 200px; border: 0px solid #f00; max-height: 200px; overflow-y: hidden; background: #fff;}
.rowlist { color: #666; font-style: normal; }
.rowlist>div {display: inline-block; padding: 0px 5px;}
.rowlist0 { width: 55%;}
.rowlist1 { width: 8%; text-align: center;}
.rowlist2 { width: 30%; text-align: right;content:00;}

.total_ {display: block; width: 30%;  color: #666; padding: 5px 10px; text-align: right; font-weight: bolder; font-style: normal; 
	border-top: 2px solid #000; margin-right: 0px; margin-left: auto; }

.w_dpx {background: #00A4DB;display: block; color: #000; font-weight: normal; border-radius: 0px;  
	margin-bottom:10px; box-sizing:border-box; border: #ccc 0px solid; padding: 5px 5px;
	margin: 0px;-webkit-box-shadow: 0px 0px 3px 2px #999;
-moz-box-shadow:    0px 0px 3px 2px #999;
box-shadow:         0px 0px 3px 2px #999; }
.w_dpx table {
	border-collapse: collapse;
	width: 100%;font-size: 0.9em;
}
.w_dpx table td { color: #000; padding: 0 3px;
}
.total_order, .val_tax {
	font-weight: bold;
}
.grandtotal { border: 1px solid #333; text-align: right; background:; color: #333; display: inline-block; width: 80%; font-size: 34px;  padding: 7px 5px 5px 0; }
.val_dis input { padding: 2px 7px;  width: 50px; text-align: right;}
/*---- keyboard css ---- */

.keyboard {box-sizing:border-box;
 	 width: 100%; background: ; overflow: hidden; padding: 0; margin-top: 10px; border: 0px solid #f00;}


.btn_pay {float: left; margin-right: 0px; width: 33%; height: 30px;
	 }
.btn_pay .bt { font-size: 15px; line-height: 20px; width: 100%;}	
.btn_pay form { border: 0px solid #f00;}
.ptk { width: 50%; font-size: 15px; line-height: 20px; float: left;}

.ptk button {
	width: 100%;
	line-height: 30px;
}
.ptk2 { width: 40%; font-size: 15px; line-height: 20px;float: left;}
.cassing {
	float: right;width: 74%;
	border:0px solid #ccc;
	background: #ccc;
}
.cassing table {
	width: 100%;
	borx-sizing:border-box;
	border-collapse: collapse;
	
}
.cassing table td {

	border:1px solid #666;


}
.cassing table td div {
	border:0px solid #ccc;
	font-weight: bolder;

	text-align: center;
	padding: 7px 0;
	border-radius:0px; 
	background: #ccc;
	cursor: pointer;
}





/* ....... */
.pending_bill_list {
	
	width: 96%;
	min-width: 96%;
	display: none;
	font-size: 1em;
	border:0px solid#06D121;
	border-radius:0px; 
	height: 250px;
	background: #fff;
	opacity: 1; 
	position: absolute;
	top: 5px;
	left: 7px;
	max-height: 250px;
	padding: 0px;
	box-sizing:border-box;
	box-shadow: 5px 5px 5px 1px #242424;
-webkit-box-shadow: 5px 5px 5px 1px #242424;
-moz-box-shadow: 5px 5px 5px 1px #242424;
-o-box-shadow: 5px 5px 5px 1px #242424;
}
#id_daftar_pending_bill {
	width: 100%;
	padding: 5px;
	margin-bottom: 10px;
	color:#fff;
	background: #06D121;
}
#add_btn_join {
	display: inline-block;
	
	cursor: pointer;
	text-align: center;
	border-top: 1px solid #000;
	margin-top: 10px;
	padding-top: 5px;
	border:0px solid #f00;
	position: absolute;
	bottom: 5px;
	left: 5px;

}
#add_btn_join button {
	border-radius: 5%;
	line-height: 30px;
	position: relative;
	border: none;
	background: #06D121;
	color: #fff;
	font-weight: bolder;
}


#close_btn_join {
	float: right;
	width: 40%;
	cursor: pointer;
	text-align: right;
	display: inline-block;
}

.w_btn_pending{
width: 15%;
	height: 60px;
	max-height: 60px;
	float: left;
	margin: 0.5%;
	position: relative;
}
.pending_bill_list_item {
	
	width: 100%;
	height: 60px;
	max-height: 60px;
	background: #06D121;
	border: 1px solid #06D121;
	position: absolute;
	padding: 5px; 
	
	border-radius: 5px;
	z-index: 3;
}
.ccl {
	position: absolute;
	bottom:0;right: 0;
	width: 100%; background: #000; line-height: 60px;
	opacity: 0.9;
	text-align: center;
	border: none;
	border-radius: 5px;
	z-index: 2;
	cursor: pointer;
}
.ccl div {
	color: #fff;
}

.btn_join_bill {
	background: #333;
	color: #fff;
	cursor: pointer;
	display:inline-block; ;
	width: 20%;
	float: left;
	height: 25px;
	max-height: 25px;
	padding: 5px;
	box-sizing:border-box;
	text-align: center;
	float: right;

}
.list_to_join {

	border:0px solid #f00;
	padding: 0px;
	margin-bottom: 10px;
	-webkit-box-shadow: 0px 0px 3px 2px #999;
-moz-box-shadow:    0px 0px 3px 2px #999;
box-shadow:         0px 0px 3px 2px #999

}
#tampil_list_pending {
	min-height: 125px;
	max-height: 125px;
}
.tdd {
	display: inline-block;
	border:0px solid #f00;
	width: 20%;
	padding-left: 5px;
}
#p { font-weight: bold; background: #00A4DB; padding: 5px;}

.list_to_join .lis1 { max-height: 100px; height: 100px; overflow-y:scroll; border: 0px solid#0f0;  box-sizing:border-box;}

.w_total_xx { text-align: ; border-top: 1px solid#999; margin: 0 0%; width: 100%; display: block; background: ; }
#p1{ padding: 2px;}

.rowlist0_ {padding: 0px 5px;}

.totalan{ background: ; border: none; padding: 3px 5px; text-align: right;}

.w-rowlist -webkit-scrollbar {
    width: 12px;
}
.rowlist_{margin: 0; padding: 0;	border: 0px solid#f00;}


::-webkit-scrollbar {
    width: 5px;
}
 
/* Track */
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1); 
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #a6a5a5;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1); 
}
::-webkit-scrollbar-thumb:window-inactive {
    background: rgba(0,0,0,0.4); 
}

.abc { border:0px solid #ccc;}
#jsp{ display: inline-block;  padding-left: 5px;}
#btn_jsp{
	display: inline-block;
	
	text-align: center;
	
	background: ;
}

.nop { width: 15%;}
.nap { width: 30%;}
.tag {width: 20%;}
.ff { font-style: italic; font-size: 0.9em;}

/*.....................................*/


.btn_ptk {
	border:0px solid #f00;
	overflow: hidden;
}

</style>