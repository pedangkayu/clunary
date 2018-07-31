<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pendingbill extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');

		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_pendingbill');

		//session menu
		$url = array('url' => 'keuangan/c_pendingbill', 'menu_parent' => 'keuangan');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_pendingbill', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_pendingbill->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function delete()
	{
		$status_pemesanan = 100;
		$id_pesanan = $this->input->get('id_pesanan');
		$data = array('status_pemesanan' => $status_pemesanan);
		$result = $this->m_base->update_data('data_pemesanan', $data, array('id_pesanan'=>$id_pesanan));
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}

/* End of file C_pendingbill.php */
/* Location: ./application/modules/keuangan/controllers/C_pendingbill.php */