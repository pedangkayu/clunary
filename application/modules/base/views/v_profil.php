<?php
$kar = $pegawai->row_array();
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Setting Profil</h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
		<!-- END PAGE HEAD -->
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row profile">
			<div class="col-md-12">
				<!--BEGIN TABS-->
				<div class="tabbable tabbable-custom tabbable-noborder">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_3" data-toggle="tab">
							Account </a>
						</li>
						<li style="display:none">
							<a href="#tab_1_6" data-toggle="tab">
							Help </a>
						</li>
					</ul>
					<div class="tab-content">
						
						<div class="tab-pane active" id="tab_1_3">
							<div class="row profile-account">
								<div class="col-md-3">
									<ul class="ver-inline-menu tabbable margin-bottom-10">
										<?php
										if($pegawai->num_rows()>0){
											?>
											<li class="active">
												<a data-toggle="tab" href="#tab_1-1">
												<i class="fa fa-cog"></i> Personal info </a>
												<span class="after">
												</span>
											</li>
											<?php
										}
										?>
										<li class="<?php echo ($pegawai->num_rows()==0) ? 'active' : ''?>">
											<a data-toggle="tab" href="#tab_3-3">
											<i class="fa fa-lock"></i> Change Password </a>
										</li>
									</ul>
								</div>
								<div class="col-md-9">
									<div class="tab-content">
										<?php
										if($pegawai->num_rows()>0){
											?>
											<div id="tab_1-1" class="tab-pane active">
												<div class="form-group keduanya">
													<label class="control-label">Mulai Bekerja</label>
													<input type="text" placeholder="Tanggal Masuk" class="form-control" value="<?php echo ($kar['mulai_bekerja']!='') ? date('d F Y', strtotime($kar['mulai_bekerja'])) : '';?>" disabled/>
												</div>
												<div class="form-group">
													<label class="control-label">Jabatan</label>
													<input type="text" class="form-control" value="<?php echo $kar['jabatan']?>" disabled/>
												</div>
												<div class="form-group">
													<label class="control-label">Nama Lengkap</label>
													<input type="text" class="form-control" value="<?php echo $kar['nama_lengkap']?>" />
												</div>
												<div class="form-group">
													<label class="control-label">Nama Panggilan</label>
													<input type="text" class="form-control" value="<?php echo $kar['nama_panggilan']?>" />
												</div>
												<div class="form-group">
													<label class="control-label">No Telepon</label>
													<input type="text" placeholder="No Telepon" id="telp1" class="form-control" value="<?php echo $kar['telp1']?>"/>
												</div>
												<div class="form-group">
													<label class="control-label">Alamat</label>
													<textarea class="form-control" rows="3" placeholder="Alamat" id="alamat"><?php echo $kar['alamat']?></textarea>
												</div>
												<div class="margiv-top-10">
													<button href="javascript:;" class="btn blue" onclick="btn_save_profil()">
													Simpan Profil </button>
												</div>
											</div>
											<?php
										}
										?>
										<div id="tab_3-3" class="tab-pane <?php echo ($pegawai->num_rows()==0) ? 'active' : ''?>">
												<div class="form-group">
													<label class="control-label">Password Lama</label>
													<input type="password" id="pass_lama" class="form-control"/>
												</div>
												<div class="form-group">
													<label class="control-label">Password Baru</label>
													<input type="password" id="pass_baru" class="form-control"/>
												</div>
												<div class="form-group">
													<label class="control-label">Ulangi Password Baru</label>
													<input type="password" id="pass_baru2" class="form-control"/>
												</div>
												<div class="margin-top-10">
													<button class="btn blue" onclick="btn_save_pass()">
													Ganti Password </button>
												</div>
										</div>
									</div>
								</div>
								<!--end col-md-9-->
							</div>
						</div>
						
						<!--end tab-pane-->
						<div class="tab-pane" id="tab_1_6">
							<div class="row">
								<div class="col-md-3">
									<ul class="ver-inline-menu tabbable margin-bottom-10">
										<li class="active">
											<a data-toggle="tab" href="#tab_1">
											<i class="fa fa-briefcase"></i> General Questions </a>
											<span class="after">
											</span>
										</li>
										<li>
											<a data-toggle="tab" href="#tab_2">
											<i class="fa fa-group"></i> Membership </a>
										</li>
										<li>
											<a data-toggle="tab" href="#tab_3">
											<i class="fa fa-leaf"></i> Terms Of Service </a>
										</li>
										<li>
											<a data-toggle="tab" href="#tab_1">
											<i class="fa fa-info-circle"></i> License Terms </a>
										</li>
										<li>
											<a data-toggle="tab" href="#tab_2">
											<i class="fa fa-tint"></i> Payment Rules </a>
										</li>
										<li>
											<a data-toggle="tab" href="#tab_3">
											<i class="fa fa-plus"></i> Other Questions </a>
										</li>
									</ul>
								</div>
								<div class="col-md-9">
									<div class="tab-content">
										<div id="tab_1" class="tab-pane active">
											<div id="accordion1" class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1">
														1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
														</h4>
													</div>
													<div id="accordion1_1" class="panel-collapse collapse in">
														<div class="panel-body">
															 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_2">
														2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
														</h4>
													</div>
													<div id="accordion1_2" class="panel-collapse collapse">
														<div class="panel-body">
															 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-success">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_3">
														3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
														</h4>
													</div>
													<div id="accordion1_3" class="panel-collapse collapse">
														<div class="panel-body">
															 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-warning">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_4">
														4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
														</h4>
													</div>
													<div id="accordion1_4" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-danger">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_5">
														5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
														</h4>
													</div>
													<div id="accordion1_5" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_6">
														6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
														</h4>
													</div>
													<div id="accordion1_6" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_7">
														7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
														</h4>
													</div>
													<div id="accordion1_7" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="tab_2" class="tab-pane">
											<div id="accordion2" class="panel-group">
												<div class="panel panel-warning">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_1">
														1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
														</h4>
													</div>
													<div id="accordion2_1" class="panel-collapse collapse in">
														<div class="panel-body">
															<p>
																 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</p>
															<p>
																 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</p>
														</div>
													</div>
												</div>
												<div class="panel panel-danger">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_2">
														2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
														</h4>
													</div>
													<div id="accordion2_2" class="panel-collapse collapse">
														<div class="panel-body">
															 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-success">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_3">
														3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
														</h4>
													</div>
													<div id="accordion2_3" class="panel-collapse collapse">
														<div class="panel-body">
															 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_4">
														4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
														</h4>
													</div>
													<div id="accordion2_4" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_5">
														5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
														</h4>
													</div>
													<div id="accordion2_5" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_6">
														6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
														</h4>
													</div>
													<div id="accordion2_6" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_7">
														7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
														</h4>
													</div>
													<div id="accordion2_7" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="tab_3" class="tab-pane">
											<div id="accordion3" class="panel-group">
												<div class="panel panel-danger">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_1">
														1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
														</h4>
													</div>
													<div id="accordion3_1" class="panel-collapse collapse in">
														<div class="panel-body">
															<p>
																 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
															</p>
															<p>
																 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
															</p>
															<p>
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</p>
														</div>
													</div>
												</div>
												<div class="panel panel-success">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_2">
														2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
														</h4>
													</div>
													<div id="accordion3_2" class="panel-collapse collapse">
														<div class="panel-body">
															 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_3">
														3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
														</h4>
													</div>
													<div id="accordion3_3" class="panel-collapse collapse">
														<div class="panel-body">
															 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_4">
														4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
														</h4>
													</div>
													<div id="accordion3_4" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_5">
														5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
														</h4>
													</div>
													<div id="accordion3_5" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_6">
														6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
														</h4>
													</div>
													<div id="accordion3_6" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_7">
														7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
														</h4>
													</div>
													<div id="accordion3_7" class="panel-collapse collapse">
														<div class="panel-body">
															 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end tab-pane-->
					</div>
				</div>
				<!--END TABS-->
			</div>
		</div>
		<!-- END PAGE CONTENT-->
		<!-- BEGIN QUICK SIDEBAR -->
		<!-- END QUICK SIDEBAR -->
	</div>
</div>
<!-- END CONTENT -->

<script type="text/javascript">
	
function btn_save_pass() {
	pass_lama = $('#pass_lama').val();
	pass_baru = $('#pass_baru').val();
	pass_baru2 = $('#pass_baru2').val();
	if(pass_lama=='' || pass_baru=='' || pass_baru2==''){
		NotifikasiToast({
			type : 'warning', // ini tipe notifikasi success,warning,info,error
			msg : 'Tidak boleh ada data yang kosong.', //ini isi pesan
			title : 'Peringatan', //ini judul pesan
		});
	}else{
		var sure = confirm("Apakah Anda yakin mengganti password Anda?");
		if(sure){
			$.post('<?php echo site_url() ?>/profil/c_profil/change_pass', {pass_lama:pass_lama, pass_baru:pass_baru, pass_baru2:pass_baru2}, function(res) {
				if(res.stat){
					NotifikasiToast({
						type : 'success', // ini tipe notifikasi success,warning,info,error
						msg : 'Password berhasil diupdate.', //ini isi pesan
						title : 'Peringatan', //ini judul pesan
					});
					alert('Anda harus Login ulang.');
					window.location.replace(res.url);
				}else{
					NotifikasiToast({
						type : 'error', // ini tipe notifikasi success,warning,info,error
						msg : res.pesan, //ini isi pesan
						title : 'Error', //ini judul pesan
					});
				}
			});
		}
			
	}
}

function btn_save_profil () {
	karyawan_tlp = $('#karyawan_tlp').val();
	karyawan_email = $('#karyawan_email').val();
	karyawan_alamat = $('textarea#karyawan_alamat').val();
	karyawan_id = <?php echo json_encode($kar['karyawan_id']);?>;
	var sure = confirm('Apakah Anda yakin menyimpan Profil ini?');
	if(sure){
		$.post('<?php echo site_url() ?>/profil/c_profil/save_profil', {karyawan_id:karyawan_id,karyawan_tlp:karyawan_tlp, karyawan_email:karyawan_email, karyawan_alamat:karyawan_alamat}, function(res) {
			if(res.stat){
				alert('Profil Anda berhasil disimpan.');
				location.reload();
			}else{
				NotifikasiToast({
					type : 'error', // ini tipe notifikasi success,warning,info,error
					msg : res.pesan, //ini isi pesan
					title : 'Error', //ini judul pesan
				});
			}
		});
	}
}
</script>