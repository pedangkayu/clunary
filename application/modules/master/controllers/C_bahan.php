<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_bahan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_bahan');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_bahan');

		//session menu
		$url = array('url' => 'master/c_bahan', 'menu_parent' => 'mastermenu');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_bahan', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_bahan->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$data['param_satuan'] = $this->m_base->get_data('parameter_satuan', array('satuan_aktif' => 1));
		$this->load->view('v_bahan_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$id_bahan = $this->input->get('id_bahan');
		$data['mode'] = 'edit';
		$data['param_satuan'] = $this->m_base->get_data('parameter_satuan', array('satuan_aktif' => 1));
		$data['bahan'] = $this->m_base->get_data('data_bahan', array('id_bahan' => $id_bahan));
		$this->load->view('v_bahan_form', $data, FALSE);
	}

	public function insert()
	{
		$datetime_sekarang = date('Y-m-d H:i:s');
		$nama_bahan          = $this->input->post('nama_bahan');
		$id_coa              = $this->input->post('id_coa');
		$harga_bahan         = $this->input->post('harga_bahan');
		$satuan              = $this->input->post('satuan');
		$minimum_stock_alert = $this->input->post('minimum_stock_alert');
		
		$data = array(
					'nama_bahan'          => $nama_bahan,
					'id_coa'              => $id_coa,
					'harga_bahan'         => $harga_bahan,
					'satuan'              => $satuan,
					'minimum_stock_alert' => $minimum_stock_alert,
					'dibuat_pada'         => $datetime_sekarang,
			);
		$result = $this->m_base->insert_data('data_bahan', $data, true);

		if($result['stat']){
			// insert log_harga_bahan
			$data_log_harga_bahan = array(
										'tgl_update' => $datetime_sekarang,
										'id_bahan' => $result['last_id'],
										'harga' => $harga_bahan,
										'kode_pegawai' => $this->session->userdata(base_url().'kode_pegawai'),
				);
			$insert_log_harga_bahan = $this->m_base->insert_data('log_harga_bahan', $data_log_harga_bahan);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id                  = $this->input->post('id');
		$nama_bahan          = $this->input->post('nama_bahan');
		$id_coa              = $this->input->post('id_coa');
		$harga_bahan         = $this->input->post('harga_bahan');
		$satuan              = $this->input->post('satuan');
		$minimum_stock_alert = $this->input->post('minimum_stock_alert');

		$data_bahan = $this->m_base->get_data('data_bahan', array('id_bahan' => $id))->row();
		$data_log_harga_bahan = array();
		if($data_bahan->harga_bahan != $harga_bahan){
			// insert log_harga_bahan
			$datetime_sekarang = date('Y-m-d H:i:s');
			$data_log_harga_bahan = array(
										'tgl_update' => $datetime_sekarang,
										'id_bahan' => $id,
										'harga' => $harga_bahan,
										'kode_pegawai' => $this->session->userdata(base_url().'kode_pegawai'),
				);
		}

		$data = array(
					'nama_bahan'          => $nama_bahan,
					'id_coa'              => $id_coa,
					'harga_bahan'         => $harga_bahan,
					'satuan'              => $satuan,
					'minimum_stock_alert' => $minimum_stock_alert,
			);
		$result = $this->m_base->update_data('data_bahan', $data, array('id_bahan' => $id));
		if($result['stat']){
			if(!empty($data_log_harga_bahan)){
				$insert_log_harga_bahan = $this->m_base->insert_data('log_harga_bahan', $data_log_harga_bahan);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$id_bahan = $this->input->get('id_bahan');
		$result   = $this->m_base->update_data('data_bahan', array('stat_aktif' => 0), array('id_bahan' => $id_bahan));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_bahan.php */
/* Location: ./application/modules/bahan/controllers/C_bahan.php */