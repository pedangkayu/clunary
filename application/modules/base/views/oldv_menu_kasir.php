<style type="text/css">
.c1 {
	background: #f00;
}

.li_re {
	position: relative;
}
.li_abs {
	position: absolute;
	width: 100%;
	bottom: 0;
	left: 0;
	overflow: hidden;
}
.li_abs a {
	float: left;
	background: #ccc;
	width: 45%;
	margin: 2%;
	text-align: center;
	color: #fff;
	font-weight: bolder;
	padding: 5px;
	box-sizing:border-box;
	text-decoration: none;
	border-radius: 2px;
}
</style>
<div class="right">
	<h3>Daftar Order/Transaksi - time : <?php
	date_default_timezone_set("Asia/Jakarta"); $dt = new DateTime(); echo $dt->format('Y-m-d H:i:s'); ?> </h3>
	<ul class="progresmenu">
		<h4>Daftar Order Progress</h4>
		<?php
		if($is_open_audit){
			foreach($showtable as $row){
			?>
				<a href="<?php echo site_url().'/kasir/c_transaksi/transaksi?id='.$row['id_pesanan']; ?>" target="checker">				
				<li class="listorder">
						<?php 
							if($row['status_pemesanan']==1){ $class="c1"; $state="Progres";} 
							if($row['status_pemesanan']==2){ $class="c2"; $state="Served";}
							if($row['status_pemesanan']==3){ $class="c3"; $state="Pending";}
						?>
					
						<div class="w_order <?php echo $class; ?>">
							<label>Meja</label> : <?php echo $row['kode_meja'];?><BR>
							<label>Nama</label> : <?php echo $row['nama_pemesan']; ?>
							<label>Status</label> : <?php echo $state; ?>
						<div>
<!-- 						<div class="status_order"><?php echo $class; ?></div>
 -->					
				</li>

				</a>
			<?php
			}
		}else{
			echo '<h3 align="center">Anda Belum Membuka Audit</h3>';
		}
		?>	
	</ul>
	<ul class="payedmenu" style="overflow-y:scroll;">
		<h4>Transaksi Lunas</h4>
		<div id="filt">
		
		</div>
		<?php 
		foreach($showpayed as $row){
			$id = $row['id_pesanan'];
			?>
							
				<li class="listorder li_re">
						<?php 
							if($row['status_pemesanan']==1){ $class="c1"; $state="Progres";} 
							if($row['status_pemesanan']==2){ $class="c2"; $state="Served";}
							if($row['status_pemesanan']==3){ $class="c3"; $state="Pending";}
							if($row['status_pemesanan']==4){ $class="c4"; $state="Lunas";}
						?>
					
						<div class="w_order <?php echo $class; ?>">
							<label>Meja</label> : <?php echo $row['kode_meja'];?><BR>
							<label>Nama</label> : <?php echo $row['nama_pemesan']; ?>
							<label>Status</label> : <?php echo $state; ?>
						<div>	
<!-- 						<div class="status_order"><?php echo $class; ?></div>
 -->					
				<div class="li_abs">
					<a href="<?php echo site_url().'/kasir/c_transaksi/print_bill_lunas/'.$id ?>" target="_top">Cetak</a>
					<!-- <a href="#" >Lihat</a> -->
				
				</div>		
				</li>
				
			<?php
			}

			?>

	</ul>
	

</div>
