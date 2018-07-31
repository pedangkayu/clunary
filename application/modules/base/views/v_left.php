<?php
$url = $this->session->userdata(base_url().'url');
$menu_parent = $this->session->userdata(base_url().'menu_parent');
?>
<div class="page-sidebar-wrapper">
	<div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
		<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="start <?php echo ($menu_parent=='dashboard') ? 'active' : '' ;?> ">
				<a href="<?php echo site_url();?>dashboard"><i class="icon-home"></i><span class="title">Dashboard</span></a>
			</li>
			<?php
			if($this->session->userdata(base_url().'kode_role')=='5' || $this->session->userdata(base_url().'kode_role')=='4'){
				?>
				<li class="<?php echo ($menu_parent=='mastermeja') ? 'active open' : '';?>">
					<a href="javascript:;">
					<i class="fa fa-bars"></i>
					<span class="title">Master Meja</span>
					<?php echo ($menu_parent=='mastermeja') ? '<span class="selected"></span>' : '';?>
					<span class="arrow <?php echo ($menu_parent=='mastermeja') ? 'open' : '';?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo ($url=='master/c_areaduduk') ? 'active' : '';?>">
							<a href="<?php echo site_url('areaduduk'); ?>">
							<i class="fa fa-th"></i>
							Area Duduk</a>
						</li>
						<li class="<?php echo ($url=='master/c_meja') ? 'active' : '';?>">
							<a href="<?php echo site_url('meja'); ?>">
							<i class="fa fa-cube"></i>
							Meja</a>
						</li>
						<li class="<?php echo ($url=='master/c_mejareservasi') ? 'active' : '';?>" style="display:none;">
							<a href="<?php echo site_url('master/c_mejareservasi'); ?>">
							<i class="fa fa-ge"></i>
							Meja Reservasi</a>
						</li>
					</ul>
				</li>
				<li class="<?php echo ($menu_parent=='mastermenu') ? 'active open' : '';?>">
					<a href="javascript:;">
					<i class="fa fa-bars"></i>
					<span class="title">Master Menu</span>
					<?php echo ($menu_parent=='mastermenu') ? '<span class="selected"></span>' : '';?>
					<span class="arrow <?php echo ($menu_parent=='mastermenu') ? 'open' : '';?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo ($url=='master/c_satuan') ? 'active' : '';?>">
							<a href="<?php echo site_url('satuan'); ?>">
							<i class="fa fa-circle-o"></i>
							Satuan</a>
						</li>
						<li class="<?php echo ($url=='master/c_bahan') ? 'active' : '';?>">
							<a href="<?php echo site_url('bahan'); ?>">
							<i class="fa fa-leaf"></i>
							Bahan</a>
						</li>
						<li class="<?php echo ($url=='master/c_kategori') ? 'active' : '';?>">
							<a href="<?php echo site_url('kategori'); ?>">
							<i class="fa fa-thumbs-o-up"></i>
							Kategori Menu</a>
						</li>
						<li class="<?php echo ($url=='master/c_menu') ? 'active' : '';?>">
							<a href="<?php echo site_url('menu'); ?>">
							<i class="fa fa-cutlery"></i>
							Menu</a>
						</li>
					</ul>
				</li>
				<li class="<?php echo ($menu_parent=='transaksi') ? 'active open' : '';?>">
					<a href="javascript:;">
					<i class="fa fa-bars"></i>
					<span class="title">Data Inventory</span>
					<?php echo ($menu_parent=='transaksi') ? '<span class="selected"></span>' : '';?>
					<span class="arrow <?php echo ($menu_parent=='transaksi') ? 'open' : '';?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo ($url=='transaksi/c_inventorybahan') ? 'active' : '';?>">
							<a href="<?php echo site_url('inventorybahan'); ?>">
							<i class="fa fa-recycle"></i>
							Inventory Bahan</a>
						</li>
						<li class="<?php echo ($url=='transaksi/c_reservasimeja') ? 'active' : '';?>" style="display:none;">
							<a href="<?php echo site_url('transaksi/c_reservasimeja'); ?>">
							<i class="icon-diamond"></i>
							Reservasi Meja</a>
						</li>
					</ul>
				</li>
				<li class="<?php echo ($menu_parent=='keuangan') ? 'active open' : '';?>">
					<a href="javascript:;">
					<i class="fa fa-bars"></i>
					<span class="title">Data Transaksi</span>
					<?php echo ($menu_parent=='keuangan') ? '<span class="selected"></span>' : '';?>
					<span class="arrow <?php echo ($menu_parent=='keuangan') ? 'open' : '';?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo ($url=='keuangan/c_pendapatan') ? 'active' : '';?>">
							<a href="<?php echo site_url('pendapatan'); ?>">
							<i class="fa fa-briefcase"></i>
							Pendapatan</a>
						</li>
						<li class="<?php echo ($url=='keuangan/c_belanjabahan') ? 'active' : '';?>">
							<a href="<?php echo site_url('belanjabahan'); ?>">
							<i class="fa fa-briefcase"></i>
							Belanja Bahan</a>
						</li>
						<li class="<?php echo ($url=='keuangan/c_reservasimeja') ? 'active' : '';?>">
							<a href="<?php echo site_url('pindahbuku'); ?>">
							<i class="fa fa-briefcase"></i>
							Pemindah Bukuan</a>
						</li>
						<li class="<?php echo ($url=='keuangan/c_pendingbill') ? 'active' : '';?>">
							<a href="<?php echo site_url('pendingbill'); ?>">
							<i class="fa fa-briefcase"></i>
							Pending Bill</a>
						</li>
						<li class="<?php echo ($url=='keuangan/c_bill') ? 'active' : '';?>">
							<a href="<?php echo site_url('bill'); ?>">
							<i class="fa fa-briefcase"></i>
							Bill</a>
						</li>
					</ul>
				</li>
				<li class="<?php echo ($menu_parent=='mastersystem') ? 'active open' : '';?>">
					<a href="javascript:;">
					<i class="fa fa-bars"></i>
					<span class="title">Pengaturan System</span>
					<?php echo ($menu_parent=='mastersystem') ? '<span class="selected"></span>' : '';?>
					<span class="arrow <?php echo ($menu_parent=='mastersystem') ? 'open' : '';?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="<?php echo ($url=='master/c_constants') ? 'active' : '';?>">
							<a href="<?php echo site_url('profil'); ?>">
							<i class="fa fa-legal"></i>
							Restoran & Kantor</a>
						</li>
						<li class="<?php echo ($url=='master/c_pegawai') ? 'active' : '';?>">
							<a href="<?php echo site_url('pegawai'); ?>">
							<i class="fa fa-users"></i>
							Pegawai</a>
						</li>
					</ul>
				</li>
				<?php
			}
			?>
		</ul>
		
	</div>
</div>