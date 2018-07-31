<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_kategori extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'master/c_kategori');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_kategori');

		//session menu
		$url = array('url' => 'master/c_kategori', 'menu_parent' => 'mastermenu');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_kategori', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_kategori->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_add()
	{
		$data = array();
		$data['mode'] = 'add';
		$this->load->view('v_kategori_form', $data, FALSE);
	}

	public function form_edit()
	{
		$data = array();
		$kode_kategori = $this->input->get('kode_kategori');
		$data['mode'] = 'edit';
		$data['kategori'] = $this->m_base->get_data('data_menu_kategori', array('kode_kategori' => $kode_kategori));
		$this->load->view('v_kategori_form', $data, FALSE);
	}

	public function insert()
	{
		$kode_kategori  = $this->input->post('kode_kategori');
		$nama_kategori  = $this->input->post('nama_kategori');
		$order_kategori = $this->input->post('order_kategori');
		
		$cek = $this->m_base->get_data('data_menu_kategori', array('kode_kategori' => $kode_kategori));
		if($cek->num_rows()>0){
			$result['stat'] = false;
			$result['pesan'] = 'Maaf, Kode Kategori Menu tersebut sudah ada.';
		}else{
			$data = array(
						'kode_kategori'  => $kode_kategori,
						'nama_kategori'  => $nama_kategori,
						'order_kategori' => $order_kategori,
				);
			$result = $this->m_base->insert_data('data_menu_kategori', $data);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update()
	{
		$id             = $this->input->post('id');
		$kode_kategori  = $this->input->post('kode_kategori');
		$nama_kategori  = $this->input->post('nama_kategori');
		$order_kategori = $this->input->post('order_kategori');

		if($id==$kode_kategori){
			$data = array(
						'nama_kategori'      => $nama_kategori,
						'order_kategori'      => $order_kategori,
				);
			$result = $this->m_base->update_data('data_menu_kategori', $data, array('kode_kategori' => $id));
		}else{
			$cek = $this->m_base->get_data('data_menu_kategori', array('kode_kategori' => $kode_kategori));
			if($cek->num_rows()>0){
				$result['stat'] = false;
				$result['pesan'] = 'Maaf, Kode Kategori Menu tersebut sudah ada.';
			}else{
				$data = array(
							'kode_kategori'  => $kode_kategori,
							'nama_kategori'  => $nama_kategori,
							'order_kategori' => $order_kategori,
					);
				$result = $this->m_base->update_data('data_menu_kategori', array('kode_kategori' => $id), $data);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete()
	{
		$kode_kategori = $this->input->get('kode_kategori');
		// $result = $this->m_base->update_data('data_meja_kategori', array('flag_aktif' => 0), array('kode_kategori' => $kode_kategori));
		$result = $this->m_base->delete_data('data_menu_kategori', array('kode_kategori' => $kode_kategori));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file C_kategori.php */
/* Location: ./application/modules/kategori/controllers/C_kategori.php */