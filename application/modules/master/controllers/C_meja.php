<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_meja extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_meja');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_meja');

		//session menu
		$url = array('url' => 'master/c_meja', 'menu_parent' => 'mastermeja');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_meja', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_meja->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$data['areaduduk'] = $this->m_base->get_data('data_meja_areaduduk', array('flag_aktif' => 1));
		$this->load->view('v_meja_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$kode_meja = $this->input->get('kode_meja');
		$data['mode'] = 'edit';
		$data['areaduduk'] = $this->m_base->get_data('data_meja_areaduduk', array('flag_aktif' => 1));
		$data['meja'] = $this->m_base->get_data('data_meja', array('kode_meja' => $kode_meja));
		$this->load->view('v_meja_form', $data, FALSE);
	}

	public function insert()
	{
		$kode_meja      = $this->input->post('kode_meja');
		$kode_areaduduk = $this->input->post('kode_areaduduk');
		$kapasitas      = $this->input->post('kapasitas');
		
		$cek = $this->m_base->get_data('data_meja', array('kode_meja' => $kode_meja, 'stat_meja' => 1));
		if($cek->num_rows()>0){
			$result['stat'] = false;
			$result['pesan'] = 'Maaf, Kode Meja tersebut sudah ada.';
		}else{
			$data = array(
						'kode_meja'      => $kode_meja,
						'kode_areaduduk' => $kode_areaduduk,
						'kapasitas'      => $kapasitas,
				);
			$result = $this->m_base->insert_data('data_meja', $data);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id             = $this->input->post('id');
		$kode_meja      = $this->input->post('kode_meja');
		$kode_areaduduk = $this->input->post('kode_areaduduk');
		$kapasitas      = $this->input->post('kapasitas');

		if($id==$kode_meja){
			$data = array(
						'kode_areaduduk' => $kode_areaduduk,
						'kapasitas'      => $kapasitas,
				);
			$result = $this->m_base->update_data('data_meja', $data, array('kode_meja' => $id));
		}else{
			$cek = $this->m_base->get_data('data_meja', array('kode_meja' => $kode_meja));
			if($cek->num_rows()>0){
				$result['stat'] = false;
				$result['pesan'] = 'Maaf, Kode Meja tersebut sudah ada.';
			}else{
				$data = array(
							'kode_meja'      => $kode_meja,
							'kode_areaduduk' => $kode_areaduduk,
							'kapasitas'      => $kapasitas,
					);
				$result = $this->m_base->update_data('data_meja', array('kode_meja' => $id), $data);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$kode_meja = $this->input->get('kode_meja');
		$result = $this->m_base->update_data('data_meja', array('stat_meja' => 0), array('kode_meja' => $kode_meja));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_meja.php */
/* Location: ./application/modules/meja/controllers/C_meja.php */