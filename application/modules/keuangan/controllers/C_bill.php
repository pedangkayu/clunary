<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_bill extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'keuangan/c_bill');
		//load model
		$this->load->model('base/m_base');
		// $this->load->model('m_district');
		$this->load->model('m_bill');

		//session menu
		$url = array('url' => 'keuangan/c_bill', 'menu_parent' => 'keuangan');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		$data = array();
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_bill', $data, true);
        echo modules::run('base/c_template/main_view', $data_view);
	}

	public function get()
	{
		$records = $this->m_bill->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function get_sudah()
	{
		$records = $this->m_bill->get_sudah();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function form_paybill()
	{
		$data = array();
		$data['mode'] = 'paybill';
		$this->load->view('v_bill_form', $data, FALSE);
	}

}

/* End of file C_bill.php */
/* Location: ./application/modules/keuangan/controllers/C_bill.php */