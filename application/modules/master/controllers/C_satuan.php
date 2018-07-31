<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_satuan extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_satuan');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_satuan');

		//session menu
		$url = array('url' => 'master/c_satuan', 'menu_parent' => 'mastermenu');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_satuan', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_satuan->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$this->load->view('v_satuan_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$id_satuan = $this->input->get('id_satuan');
		$data['mode'] = 'edit';
		$data['satuan'] = $this->m_base->get_data('parameter_satuan', array('id_satuan' => $id_satuan));
		$this->load->view('v_satuan_form', $data, FALSE);
	}

	public function insert()
	{
		$kode_satuan = $this->input->post('kode_satuan');
		$satuan      = $this->input->post('satuan');
		
		$cek = $this->m_base->get_data('parameter_satuan', array('kode_satuan' => $kode_satuan));
		if($cek->num_rows()>0){
			$result['stat'] = false;
			$result['pesan'] = 'Maaf, Kode Satuan tersebut sudah ada.';
		}else{
			$data = array(
						'kode_satuan' => $kode_satuan,
						'satuan'      => $satuan,
				);
			$result = $this->m_base->insert_data('parameter_satuan', $data);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id          = $this->input->post('id');
		$kode_satuan = $this->input->post('kode_satuan');
		$satuan      = $this->input->post('satuan');
		$data = array(
					'kode_satuan' => $kode_satuan,
					'satuan'      => $satuan,
					);

		$dt_satuan = $this->m_base->get_data('parameter_satuan', array('id_satuan' => $id))->row();
		if($dt_satuan->kode_satuan==$kode_satuan){
			$result = $this->m_base->update_data('parameter_satuan', $data, array('id_satuan' => $id));
		}else{
			$cek = $this->m_base->get_data('parameter_satuan', array('kode_satuan' => $kode_satuan));
			if($cek->num_rows()>0){
				$result['stat'] = false;
				$result['pesan'] = 'Maaf, Kode Satuan tersebut sudah ada.';
			}else{
				$result = $this->m_base->update_data('parameter_satuan', $data, array('id_satuan' => $id));
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$id_satuan = $this->input->get('id_satuan');
		$result = $this->m_base->update_data('parameter_satuan', array('satuan_aktif' => 0), array('id_satuan' => $id_satuan));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_satuan.php */
/* Location: ./application/modules/satuan/controllers/C_satuan.php */