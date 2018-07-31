<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_areaduduk extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_areaduduk');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_areaduduk');

		//session menu
		$url = array('url' => 'master/c_areaduduk', 'menu_parent' => 'mastermeja');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_areaduduk', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_areaduduk->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$this->load->view('v_areaduduk_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$kode_areaduduk = $this->input->get('kode_areaduduk');
		$data['mode'] = 'edit';
		$data['areaduduk'] = $this->m_base->get_data('data_meja_areaduduk', array('kode_areaduduk' => $kode_areaduduk));
		$this->load->view('v_areaduduk_form', $data, FALSE);
	}

	public function insert()
	{
		$kode_areaduduk = $this->input->post('kode_areaduduk');
		$nama_area      = $this->input->post('nama_area');
		$deskripsi      = $this->input->post('deskripsi');
		$lantai         = $this->input->post('lantai');
		
		$cek = $this->m_base->get_data('data_meja_areaduduk', array('kode_areaduduk' => $kode_areaduduk));
		if($cek->num_rows()>0){
			$result['stat'] = false;
			$result['pesan'] = 'Maaf, Kode Area Duduk tersebut sudah ada.';
		}else{
			$data = array(
						'kode_areaduduk' => $kode_areaduduk,
						'nama_area'      => $nama_area,
						'deskripsi'      => $deskripsi,
						'lantai'         => $lantai,
				);
			$result = $this->m_base->insert_data('data_meja_areaduduk', $data);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id             = $this->input->post('id');
		$kode_areaduduk = $this->input->post('kode_areaduduk');
		$nama_area      = $this->input->post('nama_area');
		$deskripsi      = $this->input->post('deskripsi');
		$lantai         = $this->input->post('lantai');

		if($id==$kode_areaduduk){
			$data = array(
						'nama_area'      => $nama_area,
						'deskripsi'      => $deskripsi,
						'lantai'         => $lantai,
				);
			$result = $this->m_base->update_data('data_meja_areaduduk', $data, array('kode_areaduduk' => $id));
		}else{
			$cek = $this->m_base->get_data('data_meja_areaduduk', array('kode_areaduduk' => $kode_areaduduk));
			if($cek->num_rows()>0){
				$result['stat'] = false;
				$result['pesan'] = 'Maaf, Kode Area Duduk tersebut sudah ada.';
			}else{
				$data = array(
							'kode_areaduduk' => $kode_areaduduk,
							'nama_area'      => $nama_area,
							'deskripsi'      => $deskripsi,
							'lantai'         => $lantai,
					);
				$result = $this->m_base->update_data('data_meja_areaduduk', array('kode_areaduduk' => $id), $data);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$kode_areaduduk = $this->input->get('kode_areaduduk');
		$result = $this->m_base->update_data('data_meja_areaduduk', array('flag_aktif' => 0), array('kode_areaduduk' => $kode_areaduduk));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_areaduduk.php */
/* Location: ./application/modules/areaduduk/controllers/C_areaduduk.php */