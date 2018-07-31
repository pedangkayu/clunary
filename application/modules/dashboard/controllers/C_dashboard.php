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



class C_dashboard extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//wajib
		modules::run('front_office/c_login/is_logged_in');
		modules::run('base/c_base/cek_akses', 'dashboard/c_dashboard');

		//load model
		$this->load->model('m_dashboard');
		$this->load->model('base/m_base');

		$url = array('url' => 'dashboard/c_dashboard', 'menu_parent' => 'dashboard');
		modules::run('base/c_base/create_session',$url);
	}

	public function index()
	{
		//isi
		$data = array();

		//wajib
		$data_view['stat'] = '';
		$data_view['content_layout'] = $this->load->view('v_dashboard', $data, true);
		
        echo modules::run('base/c_template/main_view', $data_view);
	}
}

/* End of file C_dashboard.php */
/* Location: ./application/modules/dashboard/controllers/C_dashboard.php */