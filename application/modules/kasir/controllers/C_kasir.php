<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/***
    * Sistem Manajemen Restoran
    *
    *
    * @package     dashboard
    * @type        Controller
    * @author      Kurniawan (ndoro.awank@gmail.com)
    * @kode        
    * @desc        
***/



class C_kasir extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'kasir/c_kasir');

		//load model
		// $this->load->model('m_kasir');

		$url = array('url' => 'kasir/c_kasir', 'menu_parent' => 'kasir');
		modules::run('base/c_base/create_session',$url);
	}

	public function index($status='')
	{
		//isi
		$data = array();
		$data['status'] = $status;
		// $data['mode'] = 'utama';
		//wajib
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_dashboard_kasir', $data, true);
		
        echo modules::run('base/c_template/main_view_kasir', $data_view);
	}

	public function audit()
	{
		//isi
		$data = array();
		$data['mode'] = 'audit';
		//wajib
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_dashboard_kasir', $data, true);
		
        echo modules::run('base/c_template/main_view_kasir', $data_view);
	}

}

/* End of file C_dashboard.php */
/* Location: ./application/modules/dashboard/controllers/C_dashboard.php */