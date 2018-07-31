<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_constants extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_constants');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');

		//session menu
		$url = array('url' => 'master/c_constants', 'menu_parent' => 'mastersystem');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data['constants'] = $this->m_base->get_data('constants');
		$data['coa_ledger'] = $this->db->query("select * from parameter_coa_ledger where stat_aktif=1 and payment_method != 'CASH' ");
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_constants', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function form_edit_resto()
	{
		$data['mode'] = 'edit_resto';
		$data['constants'] = $this->m_base->get_data('constants');
		$this->load->view('v_constants_form.php', $data, FALSE);
	}

	public function form_edit_kantor()
	{
		$data['mode'] = 'edit_kantor';
		$data['constants'] = $this->m_base->get_data('constants');
		$this->load->view('v_constants_form.php', $data, FALSE);
	}

	
	public function update_resto()
	{
		$resto_nama          = $this->input->post('resto_nama');
		$resto_alamat        = $this->input->post('resto_alamat');
		$resto_telp          = $this->input->post('resto_telp');
		$resto_kodepos       = $this->input->post('resto_kodepos');
		$resto_fax           = $this->input->post('resto_fax');
		$resto_website       = $this->input->post('resto_website');
		$resto_email         = $this->input->post('resto_email');
		$tax                 = $this->input->post('tax');
		$resto_service_fee   = $this->input->post('resto_service_fee');
		$all_item_discount   = $this->input->post('all_item_discount');
		$kitchen_pool_time_s = $this->input->post('kitchen_pool_time_s');
		
		$arr_filter = array('resto_nama', 'resto_alamat', 'resto_telp', 'resto_kodepos', 'resto_fax', 'resto_website', 'resto_email', 'tax', 'resto_service_fee', 'all_item_discount', 'kitchen_pool_time_s');
		// delete resto
		$this->db->where_in('variabel', $arr_filter);
		$this->db->delete('constants');
		// insert resto
		$data = array(
					array(
							'variabel'  => 'resto_nama',
							'var_value' => $resto_nama,
						),
					array(
							'variabel'  => 'resto_alamat',
							'var_value' => $resto_alamat,
						),
					array(
							'variabel'  => 'resto_telp',
							'var_value' => $resto_telp,
						),
					array(
							'variabel'  => 'resto_kodepos',
							'var_value' => $resto_kodepos,
						),
					array(
							'variabel'  => 'resto_fax',
							'var_value' => $resto_fax,
						),
					array(
							'variabel'  => 'resto_website',
							'var_value' => $resto_website,
						),
					array(
							'variabel'  => 'resto_email',
							'var_value' => $resto_email,
						),
					array(
							'variabel'  => 'tax',
							'var_value' => $tax,
						),
					array(
							'variabel'  => 'resto_service_fee',
							'var_value' => $resto_service_fee,
						),
					array(
							'variabel'  => 'all_item_discount',
							'var_value' => $all_item_discount,
						),
					array(
							'variabel'  => 'kitchen_pool_time_s',
							'var_value' => $kitchen_pool_time_s,
						),
			);
		$this->db->insert_batch('constants', $data);
		$result['stat'] = true;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_kantor()
	{
		$kantor_nama          = $this->input->post('kantor_nama');
		$kantor_alamat        = $this->input->post('kantor_alamat');
		$kantor_telp          = $this->input->post('kantor_telp');
		$kantor_kodepos       = $this->input->post('kantor_kodepos');
		$kantor_fax           = $this->input->post('kantor_fax');
		$kantor_website       = $this->input->post('kantor_website');
		$kantor_email         = $this->input->post('kantor_email');
		
		$arr_filter = array('kantor_nama', 'kantor_alamat', 'kantor_telp', 'kantor_kodepos', 'kantor_fax', 'kantor_website', 'kantor_email');
		// delete kantor
		$this->db->where_in('variabel', $arr_filter);
		$this->db->delete('constants');
		// insert kantor
		$data = array(
					array(
							'variabel'  => 'kantor_nama',
							'var_value' => $kantor_nama,
						),
					array(
							'variabel'  => 'kantor_alamat',
							'var_value' => $kantor_alamat,
						),
					array(
							'variabel'  => 'kantor_telp',
							'var_value' => $kantor_telp,
						),
					array(
							'variabel'  => 'kantor_kodepos',
							'var_value' => $kantor_kodepos,
						),
					array(
							'variabel'  => 'kantor_fax',
							'var_value' => $kantor_fax,
						),
					array(
							'variabel'  => 'kantor_website',
							'var_value' => $kantor_website,
						),
					array(
							'variabel'  => 'kantor_email',
							'var_value' => $kantor_email,
						),
			);
		$this->db->insert_batch('constants', $data);
		$result['stat'] = true;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function save_upload()
	{
		$jenis = $this->input->post('jenis');
		$file_name = $this->input->post('file_name');
		// delete
		if($jenis=='resto'){
			$this->db->where('variabel', 'resto_gambar');
		}elseif($jenis=='kantor'){
			$this->db->where('variabel', 'kantor_gambar');
		}
		$this->db->delete('constants');

		// insert
		if($jenis=='resto'){
			$data = array('variabel' => 'resto_gambar', 'var_value' => $file_name);
		}elseif($jenis=='kantor'){
			$data = array('variabel' => 'kantor_gambar', 'var_value' => $file_name);
		}
		$this->db->insert('constants', $data);
		$result['stat'] = true;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function form_add_rekening()
	{
		$data['mode'] = 'rekening';
		$data['submode'] = 'add_rekening';
		$this->load->view('v_constants_form.php', $data, FALSE);
	}

	public function insert_rekening()
	{
		$nama_rek          = $this->input->post('nama_rek');
		$no_rek            = $this->input->post('no_rek');
		$atasnama          = $this->input->post('atasnama');
		$payment_method    = $this->input->post('payment_method');
		$datetime_sekarang = date('Y-m-d H:i:s');

		$cek = $this->m_base->get_data('parameter_coa_ledger', array('payment_method' => $payment_method));
		if($cek->num_rows()>0){
			$result['stat'] = false;
			$result['pesan'] = "Kode tersebut sudah ada, silahkan ganti dengan kode yang lain.";
		}else{
			$data = array(
						'nama_rek'       => $nama_rek,
						'no_rek'         => $no_rek,
						'payment_method' => $payment_method,
						'atasnama'       => $atasnama,
						'update_at'      => $datetime_sekarang,
						);
			$result = $this->m_base->insert_data('parameter_coa_ledger', $data);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function form_edit_rekening()
	{
		$id_coa_ledger = $this->input->get('id');
		$data['mode'] = 'rekening';
		$data['submode'] = 'edit_rekening';
		$data['coa_ledger'] = $this->m_base->get_data('parameter_coa_ledger', array('id_coa_ledger' => $id_coa_ledger));
		$this->load->view('v_constants_form.php', $data, FALSE);
	}

	public function update_rekening()
	{
		$id_coa_ledger     = $this->input->post('id_coa_ledger');
		$nama_rek          = $this->input->post('nama_rek');
		$no_rek            = $this->input->post('no_rek');
		$atasnama          = $this->input->post('atasnama');
		$payment_method    = $this->input->post('payment_method');
		$datetime_sekarang = date('Y-m-d H:i:s');

		$awal = $this->m_base->get_data('parameter_coa_ledger', array('id_coa_ledger' => $id_coa_ledger))->row();
		if($payment_method==$awal->payment_method){
			$data = array(
						'nama_rek'       => $nama_rek,
						'no_rek'         => $no_rek,
						'payment_method' => $payment_method,
						'atasnama'       => $atasnama,
						'update_at'      => $datetime_sekarang,
						);
			$result = $this->m_base->update_data('parameter_coa_ledger', $data, array('id_coa_ledger' => $id_coa_ledger));
		}else{
			$cek = $this->m_base->get_data('parameter_coa_ledger', array('payment_method' => $payment_method));
			if($cek->num_rows()>0){
				$result['stat'] = false;
				$result['pesan'] = "Kode tersebut sudah ada, silahkan ganti dengan kode yang lain.";
			}else{
				$data = array(
							'nama_rek'       => $nama_rek,
							'no_rek'         => $no_rek,
							'payment_method' => $payment_method,
							'atasnama'       => $atasnama,
							'update_at'      => $datetime_sekarang,
							);
				$result = $this->m_base->update_data('parameter_coa_ledger', $data, array('id_coa_ledger' => $id_coa_ledger));
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete_rekening()
	{
		$id_coa_ledger =$this->input->post('id_coa_ledger');
		$update = $this->m_base->update_data('parameter_coa_ledger', array('stat_aktif' => 0), array('id_coa_ledger' => $id_coa_ledger));
		$this->output->set_content_type('application/json')->set_output(json_encode($update));
	}

}

/* End of file C_meja.php */
/* Location: ./application/modules/meja/controllers/C_meja.php */