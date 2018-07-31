<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_transaksi extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'kasir/c_transaksi');

		$this->load->model('base/m_base');
	}

	public function cek($status = '')
	{
		$data = array();
		$data['status'] = $status;
		$this->load->view('v_cek', $data, FALSE);
	}

	public function transaksi()
	{
		$id_pesanan = $this->input->get('id');
		$data['pemesanan'] = $this->m_base->get_data('data_pemesanan', array('id_pesanan' => $id_pesanan));

		// list pesanan
		$query = "SELECT  kode_menu, count(kode_menu) as qty, nama_menu, sum(harga) as harga, sum(subtotal) as subtotal, discount from data_pemesanan_menu
				where id_pesanan=$id_pesanan GROUP BY kode_menu";
		$data['list_pesanan'] = $this->db->query($query);

		// tax
		$tax = $this->db->query("SELECT * FROM constants WHERE variabel='tax'")->row();
		$service_fee = $this->db->query("SELECT * FROM constants WHERE variabel='resto_service_fee'")->row();
		$data['pajak'] = $tax->var_value / 100;
		$data['service_fee'] = $service_fee->var_value / 100;
		$this->load->view('v_transaksi', $data, FALSE);
	}

	public function batal_order()
	{
		$id_pesanan          = $this->input->post('id_pesanan');
		$delete_bahanstock 	 = $this->m_base->delete_data('data_bahan_stock', array('id_pesanan' => $id_pesanan));
		$delete_pesanan_menu = $this->m_base->delete_data('data_pemesanan_menu', array('id_pesanan' => $id_pesanan));
		$delete_pesanan      = $this->m_base->delete_data('data_pemesanan', array('id_pesanan' => $id_pesanan));
		redirect('/kasir/c_kasir/index/6');
		// $result['stat']		 = true;
		// if($result['stat']){
		// }
	}

	public function ordertokitchen()
	{
		$id_pesanan = $this->input->post('id_pesanan');
		$ch_status  = $this->input->post('ch_status_pemesanan');
		$data = array('status_pemesanan' => $ch_status);
		$result = $this->m_base->update_data('data_pemesanan', $data, array('id_pesanan' => $id_pesanan));
		
		if($result['stat']){
			// redirect('/kasir/c_transaksi/print_order/'.$id_pesanan);
			redirect('/kasir/c_kasir');
		}
	}

	public function payment()
	{
		$data['id_pesanan_main'] = $this->input->post('id_pesanan_main');
		$data['id_pesanan_pend'] = $this->input->post('id_pesanan_pend');
		$data['pajak']           = $this->input->post('tax_v');
		$data['diskon_suteki']          = $this->input->post('diskon_suteki');
		$data['diskon_fonte']          = $this->input->post('diskon_fonte');
		$data['tax_value']       = $this->input->post('tax_value');
		$data['tax_price']       = $this->input->post('tax_price');
		$data['service_fee_value']       = $this->input->post('service_fee_value');
		$data['service_fee_price']       = $this->input->post('service_fee_price');
		$data['total_order']     = $this->input->post('total_order');
		$data['total_pay']       = $this->input->post('total_pay');
		$data['paysave']         = $this->input->post('paysave');
		$data['action']			= $this->input->post('action');
		$data['status']			= $this->input->post('status');

		$data['paymentmethod'] = $this->m_base->get_data('parameter_coa_ledger', array('stat_aktif' => 1));

		// cek dan perbaikan
		$this->check_and_recovery($data['id_pesanan_main'], $data['id_pesanan_pend']);

		$this->load->view('v_payment', $data, FALSE);
		

	}

	public function proses_pay($value='')
	{
		$id_audit = $this->db->query('select max(id_audit) as id_audit_terakhir from data_audit where stat_audit=1')->row()->id_audit_terakhir;

		$id_main          = $this->input->post('id_pesanan_main');
		$id_pend          = $this->input->post('id_pesanan_pend');
		$diskon_suteki        = $this->input->post('diskon_suteki');
		// echo $diskon_suteki;
		$diskon_fonte        = $this->input->post('diskon_fonte');
		$tax_v            = $this->input->post('tax_v');
		$pajak            = $this->input->post('tax_v')*100;
		$tax_price        = $this->input->post('tax_price');
		$service_fee_value        = $this->input->post('service_fee_value');
		$total_order      = $this->input->post('total_order');
		$total_pay        = $this->input->post('total_pay');
		$cara_bayar       = $this->input->post('option_pay');
		$pay              = str_replace('.', '', $this->input->post('jumlah_uang'));
		$kembali          = $this->input->post('uang_kembali');
		$status          = $this->input->post('status');
		$action          = $this->input->post('action');
		$action2          = $this->input->post('print');
		// echo $total_pay;

		if($action2=='pay') {
			//update join_parent
			$sql_update_joint_parent = "update data_pemesanan set join_parent=$id_main where id_pesanan in ($id_pend)";
			$this->db->query($sql_update_joint_parent);

			//update counter_nota
			$get_max_counter_nota = "SELECT max(counter_nota) as nota_terakhir from data_pemesanan where join_parent is null";
			$nota_terakhir = $this->db->query($get_max_counter_nota)->row()->nota_terakhir;
			if($nota_terakhir==''){
				$nota_terakhir = 0;
			}
			$nota_terakhir++;
			//update counter_nota
			$sql_update_counter_nota = "update data_pemesanan set counter_nota=$nota_terakhir where id_pesanan = $id_main";
			$this->db->query($sql_update_counter_nota);
			$status_pemesanan = 4;
		}else{
			$status_pemesanan = $status;
		}
		// $status_pembayaran = 3;
		$user                 = $this->session->userdata(base_url().'kode_pegawai');

		date_default_timezone_set("Asia/Jakarta"); 
		$dt = new DateTime(); 
		$time= $dt->format('Y-m-d H:i:s');

		//diskon_all
		$diskon_all_suteki = 0;
		$diskon_all_fonte = 0;

		$select_pen = $this->db->query("select id_pesanan, sum(harga) as total_harga, sum(subtotal) as total_tagihan from data_pemesanan_menu where id_pesanan in ($id_pend) GROUP BY id_pesanan");

		$total_pending_all=0;
		foreach ($select_pen->result_array() as $result_pen) {
			$id_pending        = $result_pen['id_pesanan'];

			// get total
			$total_yg_kena_diskon = $this->get_total_pesanan_dis($id_pending, '0');
			$total_per_pending = $result_pen['total_tagihan'];
			$price_diskon_suteki      = $total_yg_kena_diskon['total_suteki']*$diskon_suteki/100;
			$price_diskon_fonte      = $total_yg_kena_diskon['total_fonte']*$diskon_fonte/100;
			$price_service		= $result_pen['total_harga']*$service_fee_value/100;
			$price_jadi        = $total_per_pending-$price_diskon_suteki-$price_diskon_fonte+$price_service;
			
			//diskon_all
			$diskon_all_suteki += $price_diskon_suteki;
			$diskon_all_fonte  += $price_diskon_fonte;

			$total_pending_all = $total_pending_all+$price_jadi;

			$pay_pending = "UPDATE data_pemesanan
							SET 
								discount_promo ='0', 
								nilai_discount_promo_suteki = '0',
								discount_promo_fonte ='0', 
								nilai_discount_promo_fonte = '0',
								service_fee='$service_fee_value', 
								service_fee_price='$price_service',
								total_biaya='$total_per_pending', 
								total_biaya_after_tax='$price_jadi', 
								payment_method='$cara_bayar', 
								pay='$price_jadi',
								kembali='0', 
								status_pemesanan='$status_pemesanan', 
								status_pembayaran='4', 
								submit_oleh='$user', 
								submit_pada='$time',
								id_audit = '$id_audit'
							WHERE id_pesanan='$id_pending' ";
			$this->db->query($pay_pending);
		}

		// get total
		$total_yg_kena_diskon = $this->get_total_pesanan_dis($id_main, '0');
		
		$result_main= $this->db->query("Select id_pesanan, sum(harga) as tot_harga, sum(subtotal) as tot_tagihan from data_pemesanan_menu where id_pesanan='$id_main'")->row_array();

		$total_tagihan_main = $result_main['tot_tagihan'];

		$price_diskon_suteki      = $total_yg_kena_diskon['total_suteki']*($diskon_suteki/100);
		// echo $diskon_suteki;
		$price_diskon_fonte      = $total_yg_kena_diskon['total_fonte']*($diskon_fonte/100);

		$price_service		= $result_main['tot_harga']*$service_fee_value/100;
		$price_jadi_main    = $result_main['tot_tagihan']-$price_diskon_suteki-$price_diskon_fonte+$price_service;
		// echo $price_jadi_main; 

		//diskon_all
		$diskon_all_suteki += $price_diskon_suteki;
		$diskon_all_fonte  += $price_diskon_fonte;
		$uang_pay_main = $pay-$total_pending_all;
		$kembali_main  = $uang_pay_main-$price_jadi_main;
		// echo $price_jadi_main;
		if($status_pemesanan==2){ //print bill
			$pay_main = "UPDATE data_pemesanan
							SET 
								discount_promo ='$diskon_suteki', 
								nilai_discount_promo_suteki = '$diskon_all_suteki',
								discount_promo_fonte ='$diskon_fonte', 
								nilai_discount_promo_fonte = '$diskon_all_fonte',
								tax='$tax_v', 
								tax_price='0', 
								service_fee='$service_fee_value', 
								service_fee_price='$price_service',
								total_biaya='$total_tagihan_main', 
								total_biaya_after_tax='$price_jadi_main', 
								payment_method='$cara_bayar', 
								pay='$uang_pay_main',
								kembali='$kembali_main', 
								status_pemesanan='$status_pemesanan', 
								status_pembayaran='4', 
								submit_oleh='$user', 
								submit_pada='$time',
								id_audit = '$id_audit'
							WHERE id_pesanan='$id_main' ";
			$this->db->query($pay_main);

			redirect('/kasir/c_transaksi/print_bill/'.$id_main.'/'.$id_pend);
		}elseif($status_pemesanan==4){
			if($kembali_main < 0){
				redirect('/kasir/c_kasir/index/44');
			}else{
				$pay_main = "UPDATE data_pemesanan
								SET 
									discount_promo ='$diskon_suteki', 
									nilai_discount_promo_suteki = '$diskon_all_suteki',
									discount_promo_fonte ='$diskon_fonte', 
									nilai_discount_promo_fonte = '$diskon_all_fonte',
									tax='$tax_v', 
									tax_price='0', 
									service_fee='$service_fee_value', 
									service_fee_price='$price_service',
									total_biaya='$total_tagihan_main', 
									total_biaya_after_tax='$price_jadi_main', 
									payment_method='$cara_bayar', 
									pay='$uang_pay_main',
									kembali='$kembali_main', 
									status_pemesanan='$status_pemesanan', 
									status_pembayaran='4', 
									submit_oleh='$user', 
									submit_pada='$time',
									id_audit = '$id_audit'
								WHERE id_pesanan='$id_main' ";
				$this->db->query($pay_main);

				redirect('/kasir/c_transaksi/print_bill/'.$id_main.'/'.$id_pend);
			}
		}
 
		
	}
	public function pre_print_bill(){
		$id_main          = $this->input->post('id_pesanan_main');
		$id_pend          = $this->input->post('id_pesanan_pend');
		
		redirect('/kasir/c_transaksi/print_bill/'.$id_main.'/'.$id_pend);

	}

	public function print_bill_lunas($id_main)
	{
		$sql = "select id_pesanan from data_pemesanan where join_parent = $id_main";
		$data_join = $this->db->query($sql);
		$ar_id_pend = array();
		foreach ($data_join->result() as $d) {
			array_push($ar_id_pend, $d->id_pesanan);
		}
		$str_ar_pend = implode(",", $ar_id_pend);
		$this->print_bill($id_main, $str_ar_pend);
	}

	public function check_and_recovery($id_main, $id_pend)
	{
		$all_id = $id_main;
		if(!empty($id_pend)){
			$all_id=$id_main.','.$id_pend;
		}
		$sql = "select * from data_pemesanan_menu where id_pesanan in ('$all_id') and id_perusahaan is null and subtotal is null";
		$data_pemesanan_menu = $this->db->query($sql);
		foreach ($data_pemesanan_menu->result() as $r) {
			$id_pesanan_menu = $r->id_pesanan_menu;

			$kode_menu = $r->kode_menu;
			$sql = "select id_perusahaan from data_menu where kode_menu = '$kode_menu'";
			$id_perusahaan = $this->db->query($sql)->row()->id_perusahaan;

			$harga = $r->harga;
			$diskon = $r->discount;
			$subtotal = $harga - ($harga*$diskon/100);

			$sql_recovery = "update data_pemesanan_menu set id_perusahaan=$id_perusahaan, subtotal='$subtotal' where id_pesanan_menu=$id_pesanan_menu ";
			$this->db->query($sql_recovery);
		}

	}

	public function print_bill($id_main, $id_pend)
	{
		// get total
		$data['total_yg_kena_diskon'] = $this->get_total_pesanan_dis($id_main, $id_pend);

		$all_id = $id_main;
		if(!empty($id_pend)){
			$all_id=$id_main.','.$id_pend;
		}
		$data['id_main'] = $id_main;
		$query = "SELECT * FROM data_pemesanan where id_pesanan = $id_main";
		$data['data_utama'] = $this->db->query($query);
		
		$query2 = "select count(kode_menu) as jml, nama_menu, subtotal, harga, discount
					from data_pemesanan_menu
					where id_pesanan in ($all_id) group by nama_menu";
		$data['data_pesanan_menu_semua'] = $this->db->query($query2);

		$query3 = "select
					sum(discount_promo) as discount_promo_suteki,
					sum(nilai_discount_promo_suteki) as nilai_discount_promo_suteki,
					sum(discount_promo_fonte) as discount_promo_fonte,
					sum(nilai_discount_promo_fonte) as nilai_discount_promo_fonte,
					tax, 
					sum(tax_price) as tax_price, 
					sum(service_fee_price) as service,
					sum(total_biaya) as total_biaya, 
					sum(total_biaya_after_tax) as total_biaya_after_tax, 
					sum(pay) as pay, 
					sum(kembali) as kembali, 
					payment_method
				from data_pemesanan
				where id_pesanan in ($all_id)";
		$data['data_pesanan_semua'] = $this->db->query($query3);
		$resto = $this->m_base->get_data('constants');
		foreach ($resto->result() as $r) {
			switch ($r->variabel) {
				case 'resto_website':
					$data['resto_website'] = $r->var_value;
				break;
				case 'resto_nama':
					$data['resto_nama'] = $r->var_value;
				break;
				case 'resto_alamat':
					$data['resto_alamat'] = $r->var_value;
				break;
				case 'resto_telp':
					$data['resto_telp'] = $r->var_value;
				break;
			}
		}
		
		// $this->load->view('v_print_bill', $data, FALSE);
		$this->load->view('v_print_bill', $data, FALSE);
	}

	public function print_order($id_pesanan)
	{

		$data['id_pesanan'] = $id_pesanan;
		
		$query = "SELECT * FROM data_pemesanan where id_pesanan = $id_pesanan";
		$data['data_utama'] = $this->db->query($query);

		
		$query2 = "select count(kode_pemesanan) as qty, nama_menu
					from data_pemesanan_menu
					where id_pesanan = $id_pesanan Group By nama_menu" ; 
		$data['detail_pesanan'] = $this->db->query($query2);

		$resto = $this->m_base->get_data('constants');
		foreach ($resto->result() as $r) {
			switch ($r->variabel) {
				case 'resto_website':
					$data['resto_website'] = $r->var_value;
				break;
				case 'resto_nama':
					$data['resto_nama'] = $r->var_value;
				break;
				case 'resto_alamat':
					$data['resto_alamat'] = $r->var_value;
				break;
				case 'resto_telp':
					$data['resto_telp'] = $r->var_value;
				break;
				case 'resto_gambar':
					$data['resto_gambar'] = $r->var_value;
				break;
			}
		}
		
		// $this->load->view('v_print_bill', $data, FALSE);
		$this->load->view('v_print_order', $data, FALSE);
	}

	public function get_list_pesanan($id)
	{
		$query = "SELECT count(kode_menu) as qty, nama_menu, sum(harga) as harga from data_pemesanan_menu where id_pesanan='$id' GROUP BY nama_menu";
		return $this->db->query($query);
	}

	public function proses_pending_bill()
	{
		$id               = $this->input->post('id_pesanan');
		$status_pemesanan = 3;

		$data = array(
					'status_pemesanan'      => $status_pemesanan,
					);
		$update = $this->m_base->update_data('data_pemesanan', $data, array('id_pesanan' => $id));
		if($update['stat']){
			redirect('/kasir/c_kasir/index/3');
		}
	}

	// join
	public function content_join_bill($id)
	{
		$data = array();
		$query = "
				SELECT data_pemesanan.id_pesanan, data_pemesanan.nama_pemesan, data_pemesanan.kode_meja 
				from data_pemesanan 
				WHERE id_pesanan != '$id' and status_pemesanan in(2,3)
				";
		$data['list_pending'] = $this->db->query($query);
		$this->load->view('v_content_join_bill', $data, FALSE);
	}

	public function proses_join($id='')
	{
		$a='5 6';
		// $id = $this->input->post('id');
		$query = "
				SELECT data_pemesanan.id_pesanan, data_pemesanan.nama_pemesan, sum(data_pemesanan_menu.harga) as sumharga, sum(data_pemesanan_menu.subtotal) as total
				from data_pemesanan Inner Join data_pemesanan_menu On data_pemesanan.id_pesanan=data_pemesanan_menu.id_pesanan
				where data_pemesanan.id_pesanan in ($id) 
				Group by id_pesanan
				";
		$data['list_to_join'] = $this->db->query($query);
		$result['hasil'] = $this->load->view('v_list_to_join', $data, true);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	// MODUL AUDIT
	//liat audit
	public function lihat_audit(){
		$data = array();
		$querylihat = "Select id_audit, date_submit, date_modify from data_audit where stat_audit='2'";
		$data['lihat_audit']= $this->db->query($querylihat);
		$data['st']=1;
		$this->load->view('v_lihat_audit', $data, false);
	}

	public function lihat_audit_detail ($id){
		$data = array();
		$query = "select * from data_audit where id_audit='$id'";
		$data['detail_audit'] = $this->db->query($query);
		$data['st']=2;
		$query2 ="Select * from data_audit_detail where id_audit='$id'";
		$data['list_income'] =  $this->db->query($query2); 
		$this->load->view('v_lihat_audit', $data, false);


	}

	public function audit()
	{
		$data = array();
		$query = 'select * from data_audit where stat_audit="1"';
		$data_audit = $this->db->query($query);
		// var_dump($data['data_audit']->num_rows());
		if($data_audit->num_rows()==0){
			$this->load->view('v_audit_open', $data, false);
		}else{
			$data['data_audit'] = $data_audit;
			$query_close = 'select sum(total_biaya_after_tax) as jumlah_transaksi, sum(pay) as pay_diterima, sum(kembali) as pay_kembali from data_pemesanan where status_pemesanan=4';
			$data['data_close'] = $this->db->query($query_close);
			
			$ar_payment = array();
			$paymentmethod    = $this->m_base->get_data('parameter_coa_ledger', array('stat_aktif' => 1));
			$total_payment    = 0;
			foreach ($paymentmethod->result() as $r) {
				$q = $this->db->query('select sum(total_biaya_after_tax) as cash from data_pemesanan where payment_method="'.$r->payment_method.'" and status_pemesanan=4')->row();
				$q2 = $this->db->query('select count(*) as count_cash from data_pemesanan where payment_method="'.$r->payment_method.'" and status_pemesanan=4 and join_parent is null')->row();
				$ar_pay = array(
								'payment_method' => $r->payment_method,
								'sum_total_after_tax' => $q->cash,
								'count_cash' => $q2->count_cash,
					);
				$total_payment += $ar_pay['sum_total_after_tax'];
				array_push($ar_payment, $ar_pay);
			}
			$data['total_payment'] = $total_payment;
			// $data['id_audit'] = $data_audit['id_audit'];
			$data['ar_payment']    = $ar_payment;
			$this->load->view('v_audit_close', $data, false);
		}

	}

	public function save_open()
	{
		$kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
		$saldo_awal = $this->input->post('saldo_awal');
		date_default_timezone_set("Asia/Jakarta"); 
		$dt = new DateTime(); 
		$time= $dt->format('Y-m-d H:i:s');

		$query = "insert into data_audit (date_submit, kode_pegawai, saldo_awal) values ('$time', '$kode_pegawai', '$saldo_awal')";
		if($this->db->query($query)){
			redirect('/kasir/c_kasir/index/4');
		}
	}

	public function export()
	{
		$id_audit = $this->input->get('id_audit');
		$data_audit = $this->m_base->get_data('data_audit', array('id_audit'=>$id_audit))->row();
		date_default_timezone_set("Asia/Jakarta"); 
		$dt = new DateTime(); 
		$time= $dt->format('Y-m-d H:i:s');
		$data['datetime_now'] = $time;
		$data['tgl_open'] = $data_audit->date_submit;
		$query = "
                SELECT
					A.kode_menu,
					D.id_perusahaan,
					D.nama_perusahaan,
					A.nama_menu,
					harga,
					C.total_cost as cost_menu,
					count(A.kode_menu) AS jml_menu,
					sum(harga) AS total,
					(
						count(A.kode_menu) * C.total_cost
					) AS total_cost
				FROM
					data_pemesanan_menu A
				JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
				JOIN v_cost_menu C ON (A.kode_menu = C.kode_menu)
				join parameter_perusahaan D on (A.id_perusahaan=D.id_perusahaan)
				WHERE
					status_pemesanan = 4
				AND (B.id_audit = $id_audit)
				GROUP BY
					kode_menu
				ORDER BY nama_perusahaan ASC
        ";

		$data['cost_menu'] = $this->db->query($query);
	    $this->load->view('v_excel_cost_menu', $data, FALSE);

	}

	public function save_close()
	{
		date_default_timezone_set("Asia/Jakarta"); 
		$dt           = new DateTime(); 
		$time         = $dt->format('Y-m-d H:i:s');
		$id_audit     = $this->input->post('id_audit');
		$saldo_system = $this->input->post('total_kas_sistem');
		$saldo_akhir  = $this->input->post('saldo_akhir');
		$selisih      = $this->input->post('selisih');
		$note         = $this->input->post('note');
		$data_audit = array(
							'date_modify' => $time,
							'saldo_system' => $saldo_system,
							'saldo_akhir' => $saldo_akhir,
							'selisih' => $selisih,
							'catatan' => $note,
							'stat_audit' => 2,
							);

		$arr_method = $this->input->post('method');
		$arr_count = $this->input->post('count');
		$arr_nomin = $this->input->post('nomin');
		for ($i=0; $i < count($arr_method); $i++) { 
			$method = $arr_method[$i];
			$count  = $arr_count[$i];
			$nomin  = $arr_nomin[$i];
			$data_detail = array(
								'id_audit' => $id_audit,
								'payment_method' => $method,
								'jumlah_trans' => $count,
								'total_trans' => $nomin,
							 );
			$insert_detail = $this->m_base->insert_data('data_audit_detail', $data_detail);
		}

		$update_pemesanan = $this->m_base->update_data('data_pemesanan', array('status_pemesanan'=>5), array('status_pemesanan'=>4));
		$update_audit = $this->m_base->update_data('data_audit', $data_audit, array('id_audit'=>$id_audit));
		if($update_audit['stat']){
			$sql = "
					SELECT
						sum(total_biaya_after_tax) AS total_penjualan,
						sum(service_fee_price) AS total_service,
						sum(total_biaya) AS total_biaya,
						sum(nilai_discount_promo_fonte) AS total_diskon_fonte,
						sum(
							nilai_discount_promo_suteki
						) AS total_diskon_suteki
					FROM
						data_pemesanan
					WHERE
						status_pemesanan = 5
					AND id_audit = $id_audit
			";
			$data_diskon_service = $this->db->query($sql)->row();
			$total_service = $data_diskon_service->total_service;
			$total_diskon_fonte = $data_diskon_service->total_diskon_fonte;
			$total_diskon_suteki = $data_diskon_service->total_diskon_suteki;

			$audit = $this->m_base->get_data('data_audit', array('id_audit'=>$id_audit))->row();
			$datetime_open = $audit->date_submit;
			$datetime_close = $audit->date_modify;
			$sql2 = "
					SELECT
						A.id_perusahaan,
						sum(harga) AS total
					FROM
						data_pemesanan_menu A
					JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
					WHERE
						B.status_pemesanan = 5
					AND (
						B.submit_pada BETWEEN '$datetime_open'
						AND '$datetime_close'
					)
					GROUP BY 
						id_perusahaan
			";
			$data_total_penjualan = $this->db->query($sql2);
			$total_penjualan_fonte = 0;
			$total_penjualan_suteki = 0;
			foreach ($data_total_penjualan->result() as $r) {
				if($r->id_perusahaan==100){
					$total_penjualan_fonte = $r->total;
				}elseif($r->id_perusahaan==127){
					$total_penjualan_suteki = $r->total;
				}
			}

			$data_update_audit = array(
									'pendapatan_fonte' => $total_penjualan_fonte, 
									'diskon_fonte' => $total_diskon_fonte, 
									'pendapatan_suteki' => $total_penjualan_suteki, 
									'diskon_suteki' => $total_diskon_suteki, 
									'total_service' => $total_service, 
									);
			$update_audit_fix = $this->m_base->update_data('data_audit', $data_update_audit, array('id_audit'=>$id_audit));
			redirect('/kasir/c_transaksi/lihat_audit_detail/'.$id_audit);
 
		}
	}

	public function report_audit()
	{
		$data = array();
		$query = "SELECT
	                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
	                    sum(saldo_system) AS total_system,
	                    sum(saldo_akhir) AS total_real,
	                    sum(selisih) AS total_selisih
	                FROM
	                    data_audit
	                WHERE
	                    data_audit.stat_audit = 2 
	                GROUP BY date_format(date_submit, '%Y-%m-%d')
	               	ORDER BY date_format(date_submit, '%Y-%m-%d') DESC
	                   ";
		$data['data_report'] = $this->db->query($query);
		// var_dump($data['data_audit']->num_rows());
		$this->load->view('v_report_audit', $data, false);
	}

	public function report_detail()
	{
		$tgl_submit = $this->input->post('tgl_report');
		$data['tgl_submit'] = $tgl_submit;
		$data['pendapatan'] = $this->db->query("
								SELECT
				                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
				                    sum(saldo_system) AS total_system,
				                    sum(saldo_akhir) AS total_real,
				                    sum(selisih) AS total_selisih
				                FROM
				                    data_audit
				                WHERE
				                    date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and data_audit.stat_audit = 2
				                GROUP BY 
				                	date_format(date_submit, '%Y-%m-%d')
							");
		$data_audit = $this->db->query("
							select * from data_audit where date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and stat_audit=2 
						");
		$ar_audit = array();
		foreach ($data_audit->result() as $r) {
			array_push($ar_audit, $r->id_audit);
		}
		$str_ar_audit = implode(",", $ar_audit);
		$data['str_ar_audit'] = $str_ar_audit;
		// echo $str_ar_audit;

		$detail_audit = $this->db->query("select sum(total_trans) as total_trans from data_audit_detail where id_audit in ($str_ar_audit) ");

		$total_transaksi = 0;
		if($detail_audit->row()->total_trans != 0){
			$total_transaksi = $detail_audit->row()->total_trans;
		}
		// $total_transaksi = 0;
		// foreach ($detail_audit->row() as $r) {
		// 	$total_transaksi += $r->total_trans;
		// }
		$data['total_transaksi'] = $total_transaksi;

		//detail
		$data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit asc
                    ")->row();
        $open_audit = $data_audit->date_submit;
        $data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit desc
                    ")->row();
        $close_audit = $data_audit->date_modify;

        $query = "
                    SELECT
                        kode_menu,
                        A.id_perusahaan,
                        C.nama_perusahaan,
                        nama_menu,
                        harga,
                        count(kode_menu) as jml_menu,
                        sum(harga) AS total
                    FROM
                        data_pemesanan_menu A
                    JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
                    JOIN parameter_perusahaan C ON (A.id_perusahaan = C.id_perusahaan)
                    WHERE
                        status_pemesanan = 5
                    AND (
                        B.submit_pada BETWEEN '$open_audit'
                        AND '$close_audit'
                    )
					GROUP BY kode_menu
                    
        ";
        $data['detail_report'] = $this->db->query($query);
		$this->load->view('v_report_detail', $data, FALSE);
	}

	public function print_report($tanggal)
	{
		$tgl_submit = $tanggal;
		$data['tgl_submit'] = $tanggal;
		$data['pendapatan'] = $this->db->query("
								SELECT
				                    id_audit,
				                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
				                    saldo_system AS total_system,
				                    saldo_akhir AS total_real,
				                    selisih AS total_selisih
				                FROM
				                    data_audit
				                WHERE
				                    date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and data_audit.stat_audit = 2
				                GROUP BY 
				                	date_format(date_submit, '%Y-%m-%d')
							");

		$data_audit = $this->db->query("
							select * from data_audit where date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and stat_audit=2 
						");
		$ar_audit = array();
		$total_system = 0;
		$total_real = 0;
		$total_selisih = 0;
		foreach ($data_audit->result() as $r) {
			array_push($ar_audit, $r->id_audit);
			$total_system += $r->saldo_system;
			$total_real += $r->saldo_akhir;
			$total_selisih += $r->selisih;
		}
		$str_ar_audit = implode(",", $ar_audit);
		$data['str_ar_audit'] = $str_ar_audit;

		$detail_audit = $this->db->query("select sum(total_trans) as total_trans from data_audit_detail where id_audit in ($str_ar_audit) ");

		$total_transaksi = 0;
		if($detail_audit->row()->total_trans != 0){
			$total_transaksi = $detail_audit->row()->total_trans;
		}
		
		$data['total_transaksi'] = $total_transaksi;

		//detail
		$data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit asc
                    ")->row();
        $open_audit = $data_audit->date_submit;
        $data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit desc
                    ")->row();
        $close_audit = $data_audit->date_modify;

        $query = "
                    SELECT
                        kode_menu,
                        A.id_perusahaan,
                        C.nama_perusahaan,
                        nama_menu,
                        harga,
                        count(kode_menu) as jml_menu,
                        sum(harga) AS total
                    FROM
                        data_pemesanan_menu A
                    JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
                    JOIN parameter_perusahaan C ON (A.id_perusahaan = C.id_perusahaan)
                    WHERE
                        status_pemesanan = 5
                    AND (
                        B.submit_pada BETWEEN '$open_audit'
                        AND '$close_audit'
                    )
					GROUP BY kode_menu
                    
        ";
        $data['detail_report'] = $this->db->query($query);

        $resto = $this->m_base->get_data('constants');
		foreach ($resto->result() as $r) {
			switch ($r->variabel) {
				case 'resto_website':
					$data['resto_website'] = $r->var_value;
				break;
				case 'resto_nama':
					$data['resto_nama'] = $r->var_value;
				break;
				case 'resto_alamat':
					$data['resto_alamat'] = $r->var_value;
				break;
				case 'resto_telp':
					$data['resto_telp'] = $r->var_value;
				break;
			}
		}

		// $sql_penjualan = "select 
		// 						sum(total_biaya_after_tax) as total_penjualan,
		// 						sum(service_fee_price) as total_service,
		// 						sum(total_biaya) as total_biaya
		// 					from data_pemesanan
		// 					where
		// 						status_pemesanan=5 and date(submit_pada) = '$tgl_submit' ";
		$sql_penjualan = "select 
								sum(total_biaya_after_tax) as total_penjualan,
								sum(service_fee_price) as total_service,
								sum(total_biaya) as total_biaya,
								sum(nilai_discount_promo_suteki) as total_diskon_suteki,
								sum(nilai_discount_promo_fonte) as total_diskon_fonte
							from data_pemesanan
							where
								status_pemesanan=5 and id_audit in ($str_ar_audit) ";
		$data['total_penjualan'] = $this->db->query($sql_penjualan)->row()->total_penjualan;
		$data['total_service'] = $this->db->query($sql_penjualan)->row()->total_service;
		$data['total_biaya'] = $this->db->query($sql_penjualan)->row()->total_biaya;
		$data['total_diskon_suteki'] = $this->db->query($sql_penjualan)->row()->total_diskon_suteki;
		$data['total_diskon_fonte'] = $this->db->query($sql_penjualan)->row()->total_diskon_fonte;
		// $data['total_diskon'] = $data['total_biaya'] - ($data['total_penjualan']-$data['total_service']);

		$this->load->view('v_print_report', $data, FALSE);
	}

	public function get_total_pesanan()
	{
		$id_pesanan_main_dis = $this->input->post('id_pesanan_main_dis');
		$id_pesanan_pend_dis = $this->input->post('id_pesanan_pend_dis');

		$data_main_suteki = $this->db->query("select * from data_pemesanan_menu where id_pesanan = $id_pesanan_main_dis and kode_kategori != 'Minum' and id_perusahaan=127 ");
		$total_main_suteki = 0;
		foreach ($data_main_suteki->result() as $r) {
			$total_main_suteki += $r->harga;
		}
		
		$total_pend_suteki = 0;
		if(!empty($id_pesanan_pend_dis)){
			$data_pend = $this->db->query("select * from data_pemesanan_menu where id_pesanan in ('$id_pesanan_pend_dis') and kode_kategori != 'Minum' and id_perusahaan=127 ");
			foreach ($data_pend->result() as $r) {
				$total_pend_suteki += $r->harga;
			}
		}
		$result['total_suteki'] = $total_main_suteki+$total_pend_suteki;

		$data_main_fonte = $this->db->query("select * from data_pemesanan_menu where id_pesanan = $id_pesanan_main_dis and id_perusahaan=100 ");
		$total_main_fonte = 0;
		foreach ($data_main_fonte->result() as $r) {
			$total_main_fonte += $r->harga;
		}
		
		$total_pend_fonte = 0;
		if(!empty($id_pesanan_pend_dis)){
			$data_pend = $this->db->query("select * from data_pemesanan_menu where id_pesanan in ('$id_pesanan_pend_dis') and id_perusahaan=100 ");
			foreach ($data_pend->result() as $r) {
				$total_pend_fonte += $r->harga;
			}
		}
		$result['total_fonte'] = $total_main_fonte+$total_pend_fonte;

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function get_total_pesanan_dis($id_pesanan_main_dis, $id_pesanan_pend_dis)
	{
		$data_main_suteki = $this->db->query("select * from data_pemesanan_menu where id_pesanan = $id_pesanan_main_dis and kode_kategori != 'Minum' and id_perusahaan=127 ");
		$total_main_suteki = 0;
		foreach ($data_main_suteki->result() as $r) {
			$total_main_suteki += $r->harga;
		}

		$total_pend_suteki = 0;
		if(!empty($id_pesanan_pend_dis)){
			$data_pend_suteki = $this->db->query("select * from data_pemesanan_menu where id_pesanan in ('$id_pesanan_pend_dis') and kode_kategori != 'Minum' and id_perusahaan=127 ");
			foreach ($data_pend_suteki->result() as $r) {
				$total_pend_suteki += $r->harga;
			}
		}
		$total_suteki = $total_main_suteki+$total_pend_suteki;


		$data_main_fonte = $this->db->query("select * from data_pemesanan_menu where id_pesanan = $id_pesanan_main_dis and id_perusahaan=100 ");
		$total_main_fonte = 0;
		foreach ($data_main_fonte->result() as $r) {
			$total_main_fonte += $r->harga;
		}

		$total_pend_fonte = 0;
		if(!empty($id_pesanan_pend_dis)){
			$data_pend_fonte = $this->db->query("select * from data_pemesanan_menu where id_pesanan in ('$id_pesanan_pend_dis') and id_perusahaan=100 ");
			foreach ($data_pend_fonte->result() as $r) {
				$total_pend_fonte += $r->harga;
			}
		}
		$total_fonte = $total_main_fonte+$total_pend_fonte;
		$total = array('total_suteki' => $total_suteki, 'total_fonte' => $total_fonte);
		return $total;
	}

	public function hapus_pending_bill($value='')
	{
		$id               = $this->input->post('id_pesanan');
		$status_pemesanan = 101;

		$data = array(
					'status_pemesanan'      => $status_pemesanan,
					);
		$update = $this->m_base->update_data('data_pemesanan', $data, array('id_pesanan' => $id));
		if($update['stat']){
			redirect('/kasir/c_kasir');
		}
	}

	public function print_report_sementara()
	{
		$tgl_submit = $this->input->post('tgl_submit');
		$data['tgl_submit'] = $tgl_submit;
		$data['pendapatan'] = $this->db->query("
								SELECT
				                    id_audit,
				                    date_format(date_submit, '%Y-%m-%d') AS date_submit,
				                    saldo_system AS total_system,
				                    saldo_akhir AS total_real,
				                    selisih AS total_selisih
				                FROM
				                    data_audit
				                WHERE
				                    date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and data_audit.stat_audit = 1
				                GROUP BY 
				                	date_format(date_submit, '%Y-%m-%d')
							");

		$data_audit = $this->db->query("
							select * from data_audit where date_format(date_submit, '%Y-%m-%d') = '$tgl_submit' and stat_audit=1 
						");
		$ar_audit = array();
		$total_system = 0;
		$total_real = 0;
		$total_selisih = 0;
		foreach ($data_audit->result() as $r) {
			array_push($ar_audit, $r->id_audit);
			$total_system += $r->saldo_system;
			$total_real += $r->saldo_akhir;
			$total_selisih += $r->selisih;
		}
		$str_ar_audit = implode(",", $ar_audit);
		$data['str_ar_audit'] = $str_ar_audit;

		$detail_audit = $this->db->query("select sum(total_trans) as total_trans from data_audit_detail where id_audit in ($str_ar_audit) ");

		$total_transaksi = 0;
		if($detail_audit->row()->total_trans != 0){
			$total_transaksi = $detail_audit->row()->total_trans;
		}
		
		$data['total_transaksi'] = $total_transaksi;

		//detail
		$data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit asc
                    ")->row();
        $open_audit = $data_audit->date_submit;
        $data_audit = $this->db->query("
                        select * from data_audit where id_audit in ($str_ar_audit) order by id_audit desc
                    ")->row();
        $close_audit = $data_audit->date_modify;
        $tgl_open_audit = date('Y-m-d', strtotime($open_audit));

        $query = "
                    SELECT
                        kode_menu,
                        A.id_perusahaan,
                        C.nama_perusahaan,
                        nama_menu,
                        harga,
                        count(kode_menu) as jml_menu,
                        sum(harga) AS total
                    FROM
                        data_pemesanan_menu A
                    JOIN data_pemesanan B ON (A.id_pesanan = B.id_pesanan)
                    JOIN parameter_perusahaan C ON (A.id_perusahaan = C.id_perusahaan)
                    WHERE
                        status_pemesanan = 4
                    AND (
                        date(B.submit_pada) = '$tgl_open_audit'
                    )
					GROUP BY kode_menu
                    
        ";
        $data['detail_report'] = $this->db->query($query);

        $resto = $this->m_base->get_data('constants');
		foreach ($resto->result() as $r) {
			switch ($r->variabel) {
				case 'resto_website':
					$data['resto_website'] = $r->var_value;
				break;
				case 'resto_nama':
					$data['resto_nama'] = $r->var_value;
				break;
				case 'resto_alamat':
					$data['resto_alamat'] = $r->var_value;
				break;
				case 'resto_telp':
					$data['resto_telp'] = $r->var_value;
				break;
			}
		}

		// $sql_penjualan = "select 
		// 						sum(total_biaya_after_tax) as total_penjualan,
		// 						sum(service_fee_price) as total_service,
		// 						sum(total_biaya) as total_biaya
		// 					from data_pemesanan
		// 					where
		// 						status_pemesanan=5 and date(submit_pada) = '$tgl_submit' ";
		$sql_penjualan = "select 
								sum(total_biaya_after_tax) as total_penjualan,
								sum(service_fee_price) as total_service,
								sum(total_biaya) as total_biaya,
								sum(nilai_discount_promo_suteki) as total_diskon_suteki,
								sum(nilai_discount_promo_fonte) as total_diskon_fonte
							from data_pemesanan
							where
								status_pemesanan=4 and id_audit in ($str_ar_audit) ";
		$data['total_penjualan'] = $this->db->query($sql_penjualan)->row()->total_penjualan;
		$data['total_service'] = $this->db->query($sql_penjualan)->row()->total_service;
		$data['total_biaya'] = $this->db->query($sql_penjualan)->row()->total_biaya;
		$data['total_diskon_suteki'] = $this->db->query($sql_penjualan)->row()->total_diskon_suteki;
		$data['total_diskon_fonte'] = $this->db->query($sql_penjualan)->row()->total_diskon_fonte;
		// $data['total_diskon'] = $data['total_biaya'] - ($data['total_penjualan']-$data['total_service']);

		$this->load->view('v_print_report', $data, FALSE);
	}
}

/* End of file C_transaksi.php */
/* Location: ./application/modules/kasir/controllers/C_transaksi.php */