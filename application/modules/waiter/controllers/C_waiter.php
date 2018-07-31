<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_waiter extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'waiter/c_waiter');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_waiter');

		//session menu
		$url = array('url' => 'waiter/c_waiter', 'menu_parent' => 'waiter');
		modules::run('base/c_base/create_session',$url);
	}

	public function order($status_pemesanan)
	{
		$url = array('url' => 'waiter/c_waiter/order', 'menu_parent' => 'waiter');
		modules::run('base/c_base/create_session',$url);
		
		$data = array();
		$kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
		$filter = array(
					'kode_pegawai' => $kode_pegawai,
					'status_pemesanan' => $status_pemesanan,
					);
		$data['kode_pegawai'] = $kode_pegawai;
		$data['status_pemesanan'] = $status_pemesanan;

		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_waiter', $data, true);
        echo modules::run('base/c_template/main_view_waiter', $data_view);
	}

	public function load_order($status_pemesanan)
	{
		$kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
		
		$query0 = "SELECT count(*) as jml_pesanan from data_temp_pemesanan where kode_pegawai='$kode_pegawai' AND status_pemesanan=0";
		$query1 = "SELECT count(*) as jml_pesanan from data_pemesanan where kode_pegawai='$kode_pegawai' AND status_pemesanan=1";
		$query2 = "SELECT count(*) as jml_pesanan from data_pemesanan where kode_pegawai='$kode_pegawai' AND status_pemesanan=2";
		$query3 = "SELECT count(*) as jml_pesanan from data_pemesanan where kode_pegawai='$kode_pegawai' AND status_pemesanan=3";
		$data['jml_pesanan0'] = $this->db->query($query0)->row()->jml_pesanan;
		$data['jml_pesanan1'] = $this->db->query($query1)->row()->jml_pesanan;
		$data['jml_pesanan2'] = $this->db->query($query2)->row()->jml_pesanan;
		$data['jml_pesanan3'] = $this->db->query($query3)->row()->jml_pesanan;
		
		$data['status_pemesanan'] = $status_pemesanan;
		$data['kode_pegawai'] = $kode_pegawai;
		$filter = array(
					'kode_pegawai' => $kode_pegawai,
					'status_pemesanan' => $status_pemesanan,
					);
		if($status_pemesanan==0){
			$query = "SELECT * from data_temp_pemesanan where kode_pegawai='$kode_pegawai' AND status_pemesanan=0 group by kode_pemesanan";
			$data['pesanan'] = $this->db->query($query);
		}else{
			$data['pesanan'] = $this->m_base->get_data('data_pemesanan', $filter, array('nama_kolom'=>'check_in_pada', 'order'=>'desc'));
		}
		$this->load->view('v_contentorder', $data, FALSE);
	}

	public function take_order($id_pesanan='')
	{
		$url = array('url' => 'waiter/c_waiter/take_order', 'menu_parent' => 'waiter');
		modules::run('base/c_base/create_session',$url);
		
		$data = array();
		$kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
		$data['kode_pegawai'] = $kode_pegawai;
		$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array(), array('nama_kolom' => 'order_kategori', 'order' => 'asc'));
		$data['menu'] = $this->m_base->get_data('data_menu', array('flag_aktif' => 1));
		$data['core_mode'] = '';
		$data['id'] = 0;
		if(!empty($id_pesanan)){
			$data['core_mode'] = 'edit_pesanan';
			$data['id'] = $id_pesanan;
		}
		
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_take_order', $data, true);
        echo modules::run('base/c_template/main_view_waiter', $data_view);
	}

	public function form_add_order()
	{
		$data = array();
		$data['mode'] = 'add';
		$data['meja'] = $this->m_base->get_data('data_meja', array('stat_meja' => 1));
		$this->load->view('v_order_form', $data, FALSE);
	}

	public function form_edit_order($id_pesanan)
	{
		$data = array();
		$data['mode'] = 'edit';
		$data['meja'] = $this->m_base->get_data('data_meja', array('stat_meja' => 1));
		$data['pesanan'] = $this->m_base->get_data('data_temp_pemesanan', array('id_pesanan' => $id_pesanan));
		$this->load->view('v_order_form', $data, FALSE);
	}
	
	// public function form_add()
	// {
	// 	$data = array();
	// 	$data['mode'] = 'add';
	// 	$data['meja'] = $this->m_base->get_data('data_meja', array('stat_meja' => 1));
	// 	$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array(), array('nama_kolom' => 'order_kategori', 'order' => 'asc'));
	// 	$data['menu'] = $this->m_base->get_data('data_menu', array('flag_aktif' => 1));
	// 	$this->load->view('v_waiter_form', $data, FALSE);
	// }

	public function get_listorder()
	{
		$records = $this->m_waiter->get_listorder();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function update_total_bayar()
	{
		$id_pesanan = $this->input->post('id_pesanan');
		$pemesanan_menu = $this->m_base->get_data('data_temp_pemesanan_menu', array('id_pesanan' => $id_pesanan));
		$total = 0;
		foreach ($pemesanan_menu->result() as $r) {
			$total = $total + $r->harga;
		}
		$result['total_bayar'] = $total;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_total_bayar_fix()
	{
		$id_pesanan = $this->input->post('id_pesanan');
		$pemesanan_menu = $this->m_base->get_data('data_pemesanan_menu', array('id_pesanan' => $id_pesanan));
		$total = 0;
		foreach ($pemesanan_menu->result() as $r) {
			$total = $total + $r->harga;
		}
		$result['total_bayar'] = $total;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function add_pesanmenu()
	{
		$cek_bahan = $this->m_waiter->cek_sebelum_pesan();
		if($cek_bahan['stat']){
			$kode_pegawai = $this->session->userdata(base_url().'kode_pegawai');
			$datetime_full_sekarang = date('Y-m-d H:i:s');
			$datetime_sekarang = date('ymdHi', strtotime($datetime_full_sekarang));

			$id_pesanan = $this->input->post('id_pesanan');
			$kode_menu  = $this->input->post('kode_menu');
			$jml_menu   = $this->input->post('jml_menu');
			if($id_pesanan==0){
				$kode_pemesanan = $datetime_sekarang.'-'.$kode_pegawai;
				$data_pemesanan = array(
										'kode_pemesanan' => $kode_pemesanan,
										'kode_pegawai' => $kode_pegawai,
										'check_in_pada' => $datetime_full_sekarang,
										);
				$insert_pemesanan = $this->m_base->insert_data('data_temp_pemesanan', $data_pemesanan, true);
				$id_pesanan = $insert_pemesanan['last_id'];
			}

			$pemesanan = $this->m_base->get_data('data_temp_pemesanan', array('id_pesanan' => $id_pesanan))->row();
			$menu      = $this->m_base->get_data('v_menu', array('kode_menu' => $kode_menu))->row();
			$discount = (empty($menu->discount)) ? 0 : $menu->discount;
			for ($i=0; $i < $jml_menu; $i++) { 
				$discount_price = $menu->harga*$menu->discount/100;
				$subtotal = $menu->harga - $discount_price;
				$data_pemesananmenu = array(
											'id_pesanan'     => $id_pesanan,
											'kode_pemesanan' => $pemesanan->kode_pemesanan,
											'kode_pegawai'   => $kode_pegawai,
											'kode_kategori'  => $menu->kode_kategori,
											'nama_kategori'  => $menu->nama_kategori,
											'kode_menu'      => $kode_menu,
											'id_perusahaan'  => $menu->id_perusahaan,
											'nama_menu'      => $menu->nama_menu,
											'harga'          => $menu->harga,
											'discount'       => $discount,
											'discount_price'       => $discount_price,
											'subtotal'       => $subtotal,
											'dibuat_pada'    => date('Y-m-d H:i:s'),
											'status_menu'    => 0,
											);
				$insert_pemesananmenu = $this->m_base->insert_data('data_temp_pemesanan_menu', $data_pemesananmenu);
			}
			$result['stat'] = true;
			$result['id_pesanan'] = $id_pesanan;
		}else{
			$result = $cek_bahan;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function confirm_order($id_pesanan)
	{
		$data['mode'] = 'confirm';
		$data['pesanan'] = $this->m_base->get_data('data_temp_pemesanan', array('id_pesanan' => $id_pesanan));
		$this->load->view('v_confirm_order', $data, FALSE);
	}

	public function order_ke_kasir($id_pesanan)
	{
		$cek_bahan = $this->m_waiter->cek_sebelum_ke_kasir($id_pesanan);
		if($cek_bahan['stat']){
			$pemesanan_temp = $this->m_base->get_data('data_temp_pemesanan', array('id_pesanan' => $id_pesanan))->row();
			$data = array(
						'kode_pemesanan'   => $pemesanan_temp->kode_pemesanan,
						'kode_pegawai'     => $pemesanan_temp->kode_pegawai,
						'check_in_pada'    => $pemesanan_temp->check_in_pada,
						'nama_pemesan'     => $pemesanan_temp->nama_pemesan,
						'kode_meja'        => $pemesanan_temp->kode_meja,
						'submit_oleh'      => $pemesanan_temp->kode_pegawai,
						'note'             => $pemesanan_temp->note,
						'status_pemesanan' => 1,
						);
			$insert_pemesanan = $this->m_base->insert_data('data_pemesanan', $data, true);
			$id_pesanan_fix = $insert_pemesanan['last_id'];
			$pemesanan_menu_temp = $this->m_base->get_data('data_temp_pemesanan_menu', array('id_pesanan' => $id_pesanan));
			foreach ($pemesanan_menu_temp->result() as $r) {
				// $subtotal = $r->harga - ($r->harga*$r->discount/100);
				$data_menu = array(
								'id_pesanan'     => $id_pesanan_fix,
								'kode_pemesanan' => $r->kode_pemesanan,
								'kode_kategori'  => $r->kode_kategori,
								'nama_kategori'  => $r->nama_kategori,
								'kode_menu'      => $r->kode_menu,
								'id_perusahaan'  => $r->id_perusahaan,
								'nama_menu'      => $r->nama_menu,
								'harga'          => $r->harga,
								'discount'       => $r->discount,
								'discount_price' => $r->discount_price,
								'subtotal'       => $r->subtotal,
								'status_menu'    => 1,
					);
				$insert_pemesanan_menu = $this->m_base->insert_data('data_pemesanan_menu', $data_menu);
			}
			$this->m_waiter->update_stok_bahan($id_pesanan_fix);
			$delete_temp_pemesanan = $this->m_base->delete_data('data_temp_pemesanan', array('id_pesanan' => $id_pesanan));
			$delete_temp_pemesanan_menu = $this->m_base->delete_data('data_temp_pemesanan_menu', array('id_pesanan' => $id_pesanan));
			$result['stat'] = true;
		}else{
			$result = $cek_bahan;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_pesanan()
	{
		$id_pesanan   = $this->input->post('id_pesanan');
		$kode_meja    = $this->input->post('kode_meja');
		$nama_pemesan = $this->input->post('nama_pemesan');
		$note         = $this->input->post('note');
		$data = array(
					'kode_meja'    => $kode_meja,
					'nama_pemesan' => $nama_pemesan,
					'note'         => $note,
					);
		$result = $this->m_base->update_data('data_temp_pemesanan', $data, array('id_pesanan' => $id_pesanan));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	// public function form_edit($id_pesanan)
	// {
	// 	$data['mode'] = 'edit';
	// 	$data['meja'] = $this->m_base->get_data('data_meja', array('stat_meja' => 1));
	// 	$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array(), array('nama_kolom' => 'order_kategori', 'order' => 'asc'));
	// 	$data['menu'] = $this->m_base->get_data('data_menu', array('flag_aktif' => 1));
	// 	$data['pesanan'] = $this->m_base->get_data('data_temp_pemesanan', array('id_pesanan' => $id_pesanan));
	// 	$this->load->view('v_waiter_form', $data, FALSE);
	// }

	public function form_view($id_pesanan)
	{
		$data['mode'] = 'view';
		$data['meja'] = $this->m_base->get_data('data_meja', array('stat_meja' => 1));
		$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array(), array('nama_kolom' => 'order_kategori', 'order' => 'asc'));
		$data['menu'] = $this->m_base->get_data('data_menu', array('flag_aktif' => 1));
		$data['pesanan'] = $this->m_base->get_data('data_pemesanan', array('id_pesanan' => $id_pesanan));
		$this->load->view('v_waiter_form', $data, FALSE);
	}

	public function delete_order_permanen()
	{
		$id_pesanan = $this->input->post('id_pesanan');
		$filter = array('id_pesanan' => $id_pesanan);
		$result = $this->m_base->delete_data('data_temp_pemesanan_menu', $filter);
		$result = $this->m_base->delete_data('data_temp_pemesanan', $filter);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete_listorder()
	{
		$id_pesanan = $this->input->post('id_pesanan');
		$kode_menu = $this->input->post('kode_menu');
		$filter = array(
					'id_pesanan' => $id_pesanan,
					'kode_menu' => $kode_menu,
			);
		$result = $this->m_base->delete_data('data_temp_pemesanan_menu', $filter);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function form_edit_listorder()
	{
		$id_pesanan = $this->input->get('id_pesanan');
		$kode_menu = $this->input->get('kode_menu');
		$filter = array(
					'id_pesanan' => $id_pesanan,
					'kode_menu' => $kode_menu,
			);
		$data['listorder'] = $this->m_base->get_data('v_temp_listorder', $filter);
		$this->load->view('v_listorder_form', $data, FALSE);
	}

	public function update_listorder()
	{
		$cek_bahan = $this->m_waiter->cek_sebelum_pesan('update_listorder');
		if($cek_bahan['stat']){
			$id_pesanan = $this->input->post('id_pesanan');
			$kode_menu = $this->input->post('kode_menu');
			$jml_menu = $this->input->post('jml_menu');
			
			// data awal
			$filter = array(
						'id_pesanan' => $id_pesanan,
						'kode_menu' => $kode_menu,
				);
			$listorder = $this->m_base->get_data('data_temp_pemesanan_menu', $filter)->row();
			$delete_temp = $this->m_base->delete_data('data_temp_pemesanan_menu', $filter);
			
			$data = array(
					'id_pesanan' => $id_pesanan,
					'kode_pemesanan' => $listorder->kode_pemesanan,
					'kode_pegawai' => $listorder->kode_pegawai,
					'kode_kategori' => $listorder->kode_kategori,
					'nama_kategori' => $listorder->nama_kategori,
					'kode_menu' => $kode_menu,
					'nama_menu' => $listorder->nama_menu,
					'harga' => $listorder->harga,
					'discount' => $listorder->discount,
					'dibuat_pada' => $listorder->dibuat_pada,
					'status_menu' => 0,
				);
			for ($i=0; $i < $jml_menu; $i++) { 
				$insert_temp = $this->m_base->insert_data('data_temp_pemesanan_menu', $data);
			}
			$result['stat'] = true;
		}else{
			$result = $cek_bahan;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function cari_menu($txt_search)
	{
		$sql = "
				select * from data_menu
				where
					lower(nama_menu) like '%".strtolower($txt_search)."%'
					AND
					flag_aktif=1
		";
		$data['data_menu'] = $this->db->query($sql);
		$this->load->view('v_content_cari', $data, FALSE);
	}

}

/* End of file C_waiter.php */
/* Location: ./application/modules/waiter/controllers/C_waiter.php */