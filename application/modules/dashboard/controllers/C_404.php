<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_404 extends MX_Controller {

	public function index()
	{
		$data = array();
		$data['kode_role'] = $this->session->userdata(base_url().'kode_role');
		$this->load->view('v_404', $data, FALSE);
	}

}

/* End of file C_404.php */
/* Location: ./application/modules/dashboard/controllers/C_404.php */